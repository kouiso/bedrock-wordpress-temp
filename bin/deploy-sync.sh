#!/usr/bin/env bash
# デプロイ後に WP-CLI で「DBマイグレーション適用 → 固定ページ同期」を実行する。
#
# 使い方:
#   bash bin/deploy-sync.sh
#
# 環境変数:
#   WP_PATH       WordPress本体のパス。未指定なら wp-cli.yml の path 設定に従う。
#   WP_ALLOW_ROOT 1 にすると wp に --allow-root を付ける（root 実行のサーバ向け）。
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
# wp-cli.yml を確実に読ませるためリポジトリ直下で実行する
cd "$ROOT"

WP_ARGS=()
if [ -n "${WP_PATH:-}" ]; then
  WP_ARGS+=(--path="$WP_PATH")
fi
if [ "${WP_ALLOW_ROOT:-}" = "1" ]; then
  WP_ARGS+=(--allow-root)
fi

wp "${WP_ARGS[@]}" eval-file "$ROOT/bin/run-migrations.php"
wp "${WP_ARGS[@]}" eval-file "$ROOT/bin/sync-pages.php"
