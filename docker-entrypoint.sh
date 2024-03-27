#!/bin/bash

# 依存関係のインストール
composer install --no-interaction --prefer-dist --optimize-autoloader --working-dir=/var/www/html

# WordPressのインストール
if [ ! -f "/var/www/html/web/wp/wp-config.php" ]; then
    wp core download --path=/var/www/html/web/wp --locale=ja --allow-root

    # wp-config.phpの作成
    wp config create --dbname=wordpress --dbuser=wordpress --dbpass=wordpress --dbhost=db:3306 --path=/var/www/html/web/wp --allow-root

    # WordPressデータベースのインストール
    wp core install --url="http://localhost:8000" --title="サイトのタイトル" --admin_user="admin" --admin_password="password" --admin_email="info@example.com" --path=/var/www/html/web/wp --allow-root
else
    echo "wp-config.php already exists."
fi

# その他の初期設定コマンド...

# Apacheを前景で実行
exec apache2-foreground