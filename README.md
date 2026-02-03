# 環境構築

## Docker ビルド

    git clone git@github.com:Takeshi410/fleamarket.git
    cd fleamarket
    docker-compose up -d --build

    ※ MySQL は OS によって起動しない場合があるので、それぞれの PC に合わせて
    　docker-compose.yml ファイルを編集してください。

## Laravel 環境構築

    docker-compose exec php bash
    composer install
    composer require stripe/stripe-php
    cp .env.example .env

### .envファイルの環境変数を変更

    DBの環境設定
    ・DB_HOST = mysql に変更
    ・DB_DATABASE に MYSQL_DATABASE を登録
    ・DB_USERNAME に MYSQL_USER を登録
    ・DB_PASSWORD に MYSQL_PASSWORD を登録

    MAILの環境設定
    ・"M"AIL_FROM_ADDRESS"に任意のメールアドレスを登録
    ・"MAIL_FROM_NAME"に任意の名前を登録

    決済サービス（Stripe）のAPIキーを設定
    ・STRIPE_KEY を追加
    ・STRIPE_SECRET を追加


### .envファイル設定後、下記コマンドを実行
    php artisan key:generate
    php artisan migrate
    php artisan db:seed

## 開発環境

    商品一覧(トップ画面)：http://localhost
    phpmyadmin：http://localhost:8080/
    mailhog：http://localhost:8025/

## 使用技術（実行環境）

    ・PHP 8.1.34
    ・Laravel 8.83.29
    ・nginx 1.21.1
    ・MySQL 8.0.26
    ・phpmyadmin
    ・mailhog

## ER 図

![](image/ER図.png)
