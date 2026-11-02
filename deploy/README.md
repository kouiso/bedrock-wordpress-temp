# デプロイ同期（DBマイグレーション＋固定ページ）

`deploy/pages.json` を正として、デプロイ後に WP-CLI で DB の状態をコードに揃える。

## 固定ページの同期

- `deploy/pages.json` の各項目は `slug` `title` `status` `template` `content_file`（`content/` 以下の本文ファイル）を持つ。
- 実行: `bash bin/deploy-sync.sh`（内部で `wp eval-file` を2本実行する）。
- この仕組みが作ったページには `_code_managed_page` メタが付く。定義から消えた管理下のページはゴミ箱へ移る。
- 管理画面で手動作成したページはメタを持たないので消えない。同じ slug の手動ページが先にある場合は管理下に取り込んで二重作成を防ぐ。

## DBマイグレーション

- `deploy/migrations/NNNN_名前.php` をファイル名昇順で未適用分だけ実行する。適用済みは option `code_migrations_applied` に記録する。失敗したらそこで停止。
- ひな形は `deploy/migrations/0001_example.php.example` をコピーして使う。

## GitHub Actions

- `.github/workflows/deploy.yml` は `vars.WP_DEPLOY_ENABLED` が `true` の時だけ走る。
- 必要 secrets: `WP_DEPLOY_SSH_HOST` `WP_DEPLOY_SSH_USER` `WP_DEPLOY_SSH_KEY` `WP_DEPLOY_SSH_PORT` `WP_DEPLOY_PATH`
- サーバ側の WP-CLI 実行方法を変えたい時は vars `WP_SYNC_CMD` にコマンドを書く。例（Docker 内で実行）: `docker compose exec -T wordpress bash /var/www/html/bin/deploy-sync.sh`

## ローカル検証

- `php tests/deploy_sync_test.php` — WP 関数スタブで作成・更新・削除・マイグレーション適用の振る舞いを確認できる。
