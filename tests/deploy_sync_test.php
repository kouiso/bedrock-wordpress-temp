<?php
/**
 * deploy 同期スクリプトのローカル振る舞い検証。
 *
 * WP 関数をスタブして、WordPress 本体なしで
 * 固定ページの作成・更新・削除とマイグレーション適用を確認する。
 *
 * 実行: php tests/deploy_sync_test.php
 */

error_reporting(E_ALL & ~E_DEPRECATED);

$GLOBALS['__posts']   = array();
$GLOBALS['__meta']    = array();
$GLOBALS['__options'] = array();
$GLOBALS['__next_id'] = 1;
$GLOBALS['__wpdb']    = new class {
    public $prefix = 'wp_';
    public function get_charset_collate() { return ''; }
};

function sanitize_title($t) {
    return strtolower(preg_replace('/[^a-z0-9\-_]+/i', '-', $t));
}
function get_posts($args) {
    $out = array();
    foreach ($GLOBALS['__posts'] as $p) {
        if (isset($args['post_type']) && $p->post_type !== $args['post_type']) { continue; }
        if (isset($args['name']) && $p->post_name !== $args['name']) { continue; }
        if (isset($args['meta_key']) && !isset($GLOBALS['__meta'][$p->ID][$args['meta_key']])) { continue; }
        if (isset($args['post_status']) && 'any' !== $args['post_status']
            && !in_array($p->post_status, (array) $args['post_status'], true)) { continue; }
        $out[] = $p;
    }
    $n = isset($args['posts_per_page']) && $args['posts_per_page'] > 0 ? $args['posts_per_page'] : count($out);
    return array_slice(array_values($out), 0, $n);
}
function get_post_meta($id, $k, $single = true) { return $GLOBALS['__meta'][$id][$k] ?? ''; }
function update_post_meta($id, $k, $v) { $GLOBALS['__meta'][$id][$k] = $v; return true; }
function add_post_meta($id, $k, $v) { return update_post_meta($id, $k, $v); }
function wp_insert_post($arr, $wp_error = false) {
    $id = $GLOBALS['__next_id']++;
    $GLOBALS['__posts'][$id] = (object) array_merge(array(
        'ID'           => $id,
        'post_type'    => 'page',
        'post_status'  => 'publish',
        'post_name'    => '',
        'post_title'   => '',
        'post_content' => '',
    ), $arr);
    return $id;
}
function wp_update_post($arr) {
    $p = $GLOBALS['__posts'][$arr['ID']];
    foreach ($arr as $k => $v) { $p->$k = $v; }
    return $arr['ID'];
}
function wp_trash_post($id) { $GLOBALS['__posts'][$id]->post_status = 'trash'; return true; }
function is_wp_error($x) { return false; }
function get_option($k, $d = false) { return $GLOBALS['__options'][$k] ?? $d; }
function update_option($k, $v) { $GLOBALS['__options'][$k] = $v; return true; }
function dbDelta($sql) { $GLOBALS['__dbdelta'][] = $sql; return true; }

define('DEPLOY_SYNC_NO_RUN', 1);
$repo = dirname(__DIR__);
require $repo . '/bin/sync-pages.php';
require $repo . '/bin/run-migrations.php';

$failures = 0;
function check($label, $cond) {
    global $failures;
    if ($cond) { echo "PASS: {$label}\n"; }
    else { $failures++; echo "FAIL: {$label}\n"; }
}
function page_by_slug($slug) {
    foreach ($GLOBALS['__posts'] as $p) { if ($p->post_name === $slug) { return $p; } }
    return null;
}

// --- テスト用 deploy/ を用意 ---
$tmp = sys_get_temp_dir() . '/deploy-sync-test-' . getmypid();
$deploy = $tmp . '/deploy';
@mkdir($deploy . '/content', 0777, true);
@mkdir($deploy . '/migrations', 0777, true);
file_put_contents($deploy . '/content/a.html', '<p>AAA</p>');
file_put_contents($deploy . '/content/b.html', '<p>BBB</p>');
file_put_contents($deploy . '/pages.json', json_encode(array(
    array('slug' => 'page-a', 'title' => 'ページA', 'content_file' => 'a.html'),
    array('slug' => 'page-b', 'title' => 'ページB', 'content_file' => 'b.html'),
)));

// --- 1. 初回実行: 2件作成 ---
$r = deploy_sync_pages($deploy);
check('初回実行 ok', $r['ok']);
check('2件作成される', count($GLOBALS['__posts']) === 2);
check('_code_managed_page が付く', get_post_meta(1, '_code_managed_page') === '1' && get_post_meta(2, '_code_managed_page') === '1');
check('本文が入る', $GLOBALS['__posts'][1]->post_content === '<p>AAA</p>');

// --- 2. 再実行: 変更なしでスキップ ---
$r = deploy_sync_pages($deploy);
check('2回目 ok', $r['ok']);
check('再実行で重複作成しない', count($GLOBALS['__posts']) === 2);
check('再実行で unchanged=2', strpos(implode("\n", $r['log']), 'unchanged=2') !== false);

// --- 3. タイトル変更を検出して更新 ---
$defs = json_decode(file_get_contents($deploy . '/pages.json'), true);
$defs[0]['title'] = 'ページA（改）';
file_put_contents($deploy . '/pages.json', json_encode($defs));
$r = deploy_sync_pages($deploy);
check('タイトル変更で更新される', $GLOBALS['__posts'][1]->post_title === 'ページA（改）');

// --- 4. 定義から消すとゴミ箱へ ---
file_put_contents($deploy . '/pages.json', json_encode(array($defs[0])));
$r = deploy_sync_pages($deploy);
check('定義から消えた管理下ページは trash になる', $GLOBALS['__posts'][2]->post_status === 'trash');
check('定義にある方は残る', $GLOBALS['__posts'][1]->post_status === 'publish');

// --- 5. 手動作成ページは消えない ---
wp_insert_post(array('post_type' => 'page', 'post_name' => 'manual-page', 'post_title' => '手動ページ'));
$r = deploy_sync_pages($deploy);
check('手動作成ページは削除対象外', page_by_slug('manual-page')->post_status === 'publish');

// --- 6. 同名 slug の手動ページは管理下に取り込む ---
$defs[] = array('slug' => 'manual-page', 'title' => '管理ページ（取込）');
file_put_contents($deploy . '/pages.json', json_encode($defs));
$r = deploy_sync_pages($deploy);
check('同名の手動ページは adopted になる', strpos(implode("\n", $r['log']), 'adopted: manual-page') !== false);
check('adopted 後にメタが付く', get_post_meta(page_by_slug('manual-page')->ID, '_code_managed_page') === '1');

// --- 7. マイグレーション: 未適用分だけ実行・記録 ---
file_put_contents($deploy . '/migrations/0001_one.php', "<?php update_option('m1_done', 1); return true;\n");
file_put_contents($deploy . '/migrations/0002_two.php', "<?php update_option('m2_done', 1); return true;\n");
file_put_contents($deploy . '/migrations/notrun.txt.php.example', "<?php return true;\n");
$r = deploy_run_migrations($deploy);
check('migration 2件適用', get_option('m1_done') === 1 && get_option('m2_done') === 1);
check('適用済みが記録される', get_option('code_migrations_applied') === array('0001_one.php', '0002_two.php'));
$r = deploy_run_migrations($deploy);
check('再実行で 0 applied', strpos(implode("\n", $r['log']), '0 applied') !== false);

// --- 8. 失敗したマイグレーションで停止し、記録しない ---
file_put_contents($deploy . '/migrations/0003_bad.php', "<?php throw new Exception('boom');\n");
$r = deploy_run_migrations($deploy);
check('失敗時 ok=false', !$r['ok']);
check('失敗分は記録されない', !in_array('0003_bad.php', get_option('code_migrations_applied'), true));

// --- 9. pages.json が壊れている時はエラー ---
file_put_contents($deploy . '/pages.json', '{broken');
$r = deploy_sync_pages($deploy);
check('不正な pages.json で ok=false', !$r['ok']);

// --- 後始末 ---
exec('rm -rf ' . escapeshellarg($tmp));

echo "\n" . ($failures === 0 ? 'ALL TESTS PASSED' : "{$failures} FAILED") . "\n";
exit($failures === 0 ? 0 : 1);
