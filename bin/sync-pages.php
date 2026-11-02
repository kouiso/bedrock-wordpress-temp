<?php
/**
 * 固定ページを deploy/pages.json の定義に同期する WP-CLI スクリプト。
 *
 * 使い方:
 *   wp eval-file bin/sync-pages.php [--allow-root]
 *
 * 挙動:
 *   - 定義にある固定ページを slug で特定して作成・更新する
 *   - このスクリプトが作ったページ（_code_managed_page メタ付き）で
 *     定義から消えたものはゴミ箱へ移す
 *   - 管理画面で手動作成したページは対象外（メタが無いので消えない）
 */

if (!function_exists('deploy_sync_load_definitions')) {
    /**
     * deploy/pages.json を読んで正規化した定義配列を返す。
     */
    function deploy_sync_load_definitions($deploy_dir) {
        $path = $deploy_dir . '/pages.json';
        if (!is_readable($path)) {
            return array('ok' => false, 'error' => 'pages.json が読めない: ' . $path);
        }
        $raw = json_decode(file_get_contents($path), true);
        if (!is_array($raw)) {
            return array('ok' => false, 'error' => 'pages.json が JSON として不正: ' . $path);
        }
        $defs = array();
        foreach ($raw as $i => $d) {
            if (empty($d['slug']) || empty($d['title'])) {
                return array('ok' => false, 'error' => "pages.json の {$i} 件目に slug か title が無い");
            }
            $content = '';
            if (!empty($d['content_file'])) {
                $cpath = $deploy_dir . '/content/' . $d['content_file'];
                if (!is_readable($cpath)) {
                    return array('ok' => false, 'error' => '本文ファイルが読めない: ' . $cpath);
                }
                $content = (string) file_get_contents($cpath);
            }
            $defs[] = array(
                'slug'     => sanitize_title($d['slug']),
                'title'    => (string) $d['title'],
                'status'   => isset($d['status']) && '' !== $d['status'] ? (string) $d['status'] : 'publish',
                'template' => isset($d['template']) ? (string) $d['template'] : '',
                'content'  => $content,
            );
        }
        return array('ok' => true, 'defs' => $defs);
    }

    /**
     * slug で既存の固定ページを探す。
     */
    function deploy_sync_find_page($slug) {
        $posts = get_posts(array(
            'name'           => $slug,
            'post_type'      => 'page',
            'post_status'    => 'any',
            'posts_per_page' => 1,
        ));
        return empty($posts) ? null : $posts[0];
    }

    /**
     * 同期本体。返り値: array('ok' => bool, 'log' => array, 'error' => string?)
     */
    function deploy_sync_pages($deploy_dir) {
        $log    = array();
        $loaded = deploy_sync_load_definitions($deploy_dir);
        if (!$loaded['ok']) {
            return array('ok' => false, 'log' => $log, 'error' => $loaded['error']);
        }
        $defs          = $loaded['defs'];
        $defined_slugs = array();
        $created       = 0;
        $updated       = 0;
        $adopted       = 0;
        $skipped       = 0;
        $trashed       = 0;

        foreach ($defs as $d) {
            $defined_slugs[] = $d['slug'];
            $hash            = sha1($d['slug'] . '|' . $d['title'] . '|' . $d['status'] . '|' . $d['template'] . '|' . $d['content']);
            $post            = deploy_sync_find_page($d['slug']);
            if ($post) {
                $managed  = get_post_meta($post->ID, '_code_managed_page', true);
                $old_hash = get_post_meta($post->ID, '_code_managed_hash', true);
                if ('1' === $managed && $old_hash === $hash) {
                    $skipped++;
                    continue;
                }
                wp_update_post(array(
                    'ID'           => $post->ID,
                    'post_title'   => $d['title'],
                    'post_content' => $d['content'],
                    'post_status'  => $d['status'],
                ));
                if ('' !== $d['template']) {
                    update_post_meta($post->ID, '_wp_page_template', $d['template']);
                }
                update_post_meta($post->ID, '_code_managed_page', '1');
                update_post_meta($post->ID, '_code_managed_hash', $hash);
                if ('1' === $managed) {
                    $updated++;
                    $log[] = "updated: {$d['slug']}";
                } else {
                    $adopted++;
                    $log[] = "adopted: {$d['slug']}（既存の同名ページを管理下に移行）";
                }
            } else {
                $id = wp_insert_post(array(
                    'post_type'    => 'page',
                    'post_name'    => $d['slug'],
                    'post_title'   => $d['title'],
                    'post_content' => $d['content'],
                    'post_status'  => $d['status'],
                ), true);
                if (is_wp_error($id)) {
                    return array('ok' => false, 'log' => $log, 'error' => "{$d['slug']} の作成に失敗: " . $id->get_error_message());
                }
                if ('' !== $d['template']) {
                    update_post_meta($id, '_wp_page_template', $d['template']);
                }
                update_post_meta($id, '_code_managed_page', '1');
                update_post_meta($id, '_code_managed_hash', $hash);
                $created++;
                $log[] = "created: {$d['slug']}";
            }
        }

        // 定義から消えた管理下ページをゴミ箱へ移す。
        // 手動作成ページは _code_managed_page を持たないので対象外になる。
        $managed_pages = get_posts(array(
            'post_type'      => 'page',
            'post_status'    => 'any',
            'meta_key'       => '_code_managed_page',
            'posts_per_page' => -1,
        ));
        foreach ($managed_pages as $p) {
            if (!in_array($p->post_name, $defined_slugs, true)) {
                wp_trash_post($p->ID);
                $trashed++;
                $log[] = "trashed: {$p->post_name}";
            }
        }

        $log[] = "sync-pages: created={$created} updated={$updated} adopted={$adopted} unchanged={$skipped} trashed={$trashed}";
        return array('ok' => true, 'log' => $log);
    }
}

if (!defined('DEPLOY_SYNC_NO_RUN')) {
    $deploy_dir = dirname(__DIR__) . '/deploy';
    $report     = deploy_sync_pages($deploy_dir);
    foreach ($report['log'] as $line) {
        echo $line . "\n";
    }
    if (!$report['ok']) {
        fwrite(STDERR, $report['error'] . "\n");
        exit(1);
    }
}
