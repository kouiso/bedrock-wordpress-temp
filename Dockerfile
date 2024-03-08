FROM php:8.0-apache

# 環境変数を設定して、ComposerとWP-CLIの警告を抑制
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    WP_CLI_ALLOW_ROOT=1

# 必要なパッケージとPHPの拡張をインストール
# libzip-devとdefault-mysql-clientはWordPressとWP-CLIで必要
# zip, pdo, pdo_mysql, mysqliはPHP拡張
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    default-mysql-client \
    && docker-php-ext-install zip pdo pdo_mysql mysqli \
    && rm -rf /var/lib/apt/lists/*  # キャッシュを削除してイメージサイズを減らす

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# WP-CLIのインストール
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# プロジェクトファイルのコピー
COPY . /var/www/html

# Composerを使用して依存関係をインストール
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ディレクトリの所有者をwww-dataに変更
RUN chown -R www-data:www-data /var/www/html

# Apacheの設定ファイルをコピー
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# WordPressのインストールと初期設定を行うスクリプトを追加
COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# エントリーポイントを設定
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]