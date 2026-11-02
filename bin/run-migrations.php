<?php
/**
 * deploy/migrations/*.php をファイル名順に1回ずつ適用する WP-CLI スクリプト。
 *
 * 使い方:
 *   wp eval-file bin/run-migrations.php [--allow-root]
 *
 * 挙動:
 *   - deploy/migrations/ 直下の `NNNN_名前.php` をファイル名昇順で実行
 *   - 適用済みファイル名は option `code_migrations_applied` に記録して再実行しない
 *   - 1件でも失敗したらそこで停止する（以降のマイグレーションは適用しない）
 */

if (!function_exists('deploy_run_migrations')) {
    /**
     * マイグレーション適用本体。返り値: array('ok' => bool, 'log' => array, 'error' => string?)
     */
    function deploy_run_migrations($deploy_dir) {
        $log     = array();
        $dir     = $deploy_dir . '/migrations';
        $applied = get_option('code_migrations_applied', array());
        if (!is_array($applied)) {
            $applied = array();
        }

        $files = glob($dir . '/*.php') ?: array();
        $files = array_values(array_filter($files, function ($f) {
            return preg_match('/^\d+_.+\.php$/', basename($f));
        }));
        usort($files, function ($a, $b) {
            return strcmp(basename($a), basename($b));
        });

        $ran = 0;
        foreach ($files as $file) {
            $name = basename($file);
            if (in_array($name, $applied, true)) {
                continue;
            }
            try {
                $result = include $file;
            } catch (Throwable $e) {
                return array('ok' => false, 'log' => $log, 'error' => "{$name} の適用に失敗: " . $e->getMessage());
            }
            if (false === $result) {
                return array('ok' => false, 'log' => $log, 'error' => "{$name} が false を返した");
            }
            $applied[] = $name;
            update_option('code_migrations_applied', $applied);
            $log[] = "applied: {$name}";
            $ran++;
        }

        $total = count($applied);
        $log[] = "migrations: {$ran} applied / {$total} recorded";
        return array('ok' => true, 'log' => $log);
    }
}

if (!defined('DEPLOY_SYNC_NO_RUN')) {
    $deploy_dir = dirname(__DIR__) . '/deploy';
    $report     = deploy_run_migrations($deploy_dir);
    foreach ($report['log'] as $line) {
        echo $line . "\n";
    }
    if (!$report['ok']) {
        fwrite(STDERR, $report['error'] . "\n");
        exit(1);
    }
}
