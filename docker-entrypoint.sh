#!/bin/bash

# WordPressのインストール
wp core download --path=/var/www/html/web/wp --locale=ja --allow-root

# wp-config.phpの作成
wp config create --dbname=wordpress --dbuser=wordpress --dbpass=wordpress --dbhost=db:3306 --path=/var/www/html/web/wp --allow-root

# WordPressデータベースのインストール
wp core install --url="http://localhost:8000" --title="サイトのタイトル" --admin_user="admin" --admin_password="password" --admin_email="info@example.com" --path=/var/www/html/web/wp --allow-root

# その他の初期設定コマンド...

# Apacheを前景で実行
exec apache2-foreground