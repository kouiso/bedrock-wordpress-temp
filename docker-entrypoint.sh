#!/bin/bash

# .env ファイルから環境変数を読み込む
set -a
source /var/www/html/.env
set +a

# 依存関係のインストール
composer install --no-interaction --prefer-dist --optimize-autoloader --working-dir=/var/www/html


# WordPressのインストール
wp core install \
    --url="${WP_SITEURL}" \
    --title="${WP_SITETITLE}" \
    --admin_user="${WP_ADMIN_USERNAME}" \
    --admin_password="${WP_ADMIN_PASSWORD}" \
    --admin_email="${WP_ADMIN_EMAIL}" \
    --path="/var/www/html/web/wp" \
    --allow-root

# 検索エンジンがサイトをインデックスしないように設定
wp option update blog_public 0 --path="/var/www/html/web/wp" --allow-root

# Apacheを前景で実行
exec apache2-foreground
