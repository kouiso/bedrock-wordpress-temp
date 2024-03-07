FROM php:8.0-apache

# Composerをrootユーザーで実行するための設定
ENV COMPOSER_ALLOW_SUPERUSER=1

# 必要なパッケージとPHPの拡張をインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql mysqli

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# プロジェクトファイルのコピー
COPY . /var/www/html

# Composerを使用して依存関係をインストール
RUN composer install

# ディレクトリの所有者をwww-dataに変更
RUN chown -R www-data:www-data /var/www/html

# Apacheの設定ファイルをコピー
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf