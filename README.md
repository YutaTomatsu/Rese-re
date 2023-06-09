# Rese-re  
## 概要  
ユーザーは飲食店の予約やお気に入り登録、レビューなどをすることができ、お店側は店舗の作成、店舗情報の更新やqrコードによる予約確認などができるアプリ。

![アプリトップ画像](https://github.com/YutaTomatsu/Rese-re/blob/main/Readme%E7%94%A8%E7%94%BB%E5%83%8F/%E3%82%A2%E3%83%97%E3%83%AA%E3%83%88%E3%83%83%E3%83%97%E7%94%BB%E5%83%8F.png?raw=true)

## 作成した目的  

飲食店予約アプリを作成するため。

## アプリケーションURL

3.113.25.4

## 機能一覧

会員登録機能  
ログイン機能  
ログアウト機能  
飲食店のお気に入り追加機能  
飲食店のお気に入り削除機能  
飲食店の予約機能  
飲食店の予約削除機能  
飲食店の予約編集機能  
エリアで検索する機能  
ジャンルで検索する機能  
店名で検索する機能  
予約変更機能  
評価機能  
認証やフォーム送信時のバリデーション機能  
レスポンシブデザイン機能  
マルチログイン機能  
メール認証機能  
管理者によるユーザーへのメール一斉送信機能  
管理者による店舗代表者作成機能  
店舗代表者による店舗作成機能  
店舗代表者の店舗情報編集機能  
予約当時のリマインダーメール送信機能  
QRコードによる予約確認機能  
決済機能

## 使用技術 

Laravel 8.83.27

## テーブル設計

![](https://github.com/YutaTomatsu/Rese-re/blob/main/Readme%E7%94%A8%E7%94%BB%E5%83%8F/%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB/%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB%EF%BC%91.png?raw=true)

![](https://github.com/YutaTomatsu/Rese-re/blob/main/Readme%E7%94%A8%E7%94%BB%E5%83%8F/%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB/%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB2.png)

![](https://github.com/YutaTomatsu/Rese-re/blob/main/Readme%E7%94%A8%E7%94%BB%E5%83%8F/%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB/%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB%EF%BC%93.png)

![](https://github.com/YutaTomatsu/Rese-re/blob/main/Readme%E7%94%A8%E7%94%BB%E5%83%8F/%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB/%E3%83%86%E3%83%BC%E3%83%96%E3%83%AB%EF%BC%94.png)

## ER図

![ER図](https://github.com/YutaTomatsu/Rese-re/blob/main/Readme%E7%94%A8%E7%94%BB%E5%83%8F/ER%E5%9B%B3.png)

## 環境構築

### Reseプロジェクトの環境構築

このドキュメントでは、Reseプロジェクトのローカル環境をセットアップする方法を説明します。

### インストール手順  

#### 1, Dockerのインストール（既にインストール済みの場合は飛ばして下さい）

以下のリンクから自身の環境に合ったDockerをダウンロードします。

[https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)

インストールが完了したらpcを再起動し、以下のコマンドでバージョン情報が返ってくるか確認して下さい。

docker -v

例えば以下のような形でバージョン情報が返ってきたらインストール完了です。

Docker version 20.10.22, build 3a2c30b

#### 2,リポジトリのクローン  

Reseプロジェクトを作成したいディレクトリに移動し、以下のコマンドを実行してgitからアプリをcloneします。

git clone https://github.com/YutaTomatsu/Rese-re.git

#### 3,プロジェクトのディレクトリに移動してビルド  

以下のコマンドを実行してReseプロジェクト内に移動します。

cd Rese-re  

デスクトップからdockerを起動した後に以下のコマンドを実行してdocker内にコンテナをbuildします。

docker-compose up -d --build  

dockerのコンテナ内にRese-reというコンテナが作成されていたら成功です。

#### 4,コンテナに移動し必要な依存関係のインストール  

Reseプロジェクトのコンテナ内に移動し、composer installを実行します。  

docker-compose exec php bash（以降コンテナに移動するときはプロジェクトディレクトリからこのコマンドを実行して下さい）  
composer install

#### 5,データベースのマイグレーション実行  

以下のコマンドを実行してデータベース内にテーブルを作成します。

php artisan migrate

#### 6,アプリケーションの起動

php artisan serve

アプリケーションが正常に起動すると、[http://localhost:10000](http://localhost:10000) からアプリのホーム画面にアクセスできるようになります。  
また、データベースは[http://localhost:8080](http://localhost:8080) からアクセスすることができます。

※アプリが重くなっているため、ローカル環境でページを移動する際にお使いの環境によってはサーバーエラーが発生する場合があります。
その場合、ページを再読み込みする、もしくはアクションを再度実行していただくことで解決できます。

### 7, ダミーデータの作成

必要に応じて、以下のコマンドを実行してあらかじめ作成されたダミーのデータを作成することができます。

php artisan db:seed

これにより、ダミーのショップやユーザーアカウント、管理者アカウント、店舗代表者アカウントなどが作成されます。  

#### -（ダミーで作成されるアカウント）-

また、ダミーアカウントを利用する場合は以下のアカウントからそれぞれの権限にログインすることができます。

・ユーザーアカウント

name:ユーザー  
email:user@example.com  
password:12345678  

・管理者アカウント

name:管理者  
email:admin@example.com  
password:12345678  

・店舗代表者アカウント

name:店舗代表者  
email:owner@example.com  
password:12345678  

次に、アプリケーション内の設定をしていきます。

#### 1,queueの実行

以下のコマンドを実行してqueueとscheduleを起動します。 

php artisan queue:work  

queueを実行することで管理者のメール一斉送信を非同期化することができます。

### 2,scheduleの実行

scheduleを実行することでユーザーの予約に対するリマインダーメール機能を起動することができます。

php artisan schedule:work

また、デフォルトでは予約当日の午前9時にメールが送信されるようになっていますが、  
app/Console/Kernel.phpのschedule fuction内の->dailyAt('09:00');という記述を変更することで送信日時を変更することができます。

#### 3,環境切り替え

コンテナ内で以下のコマンドを実行することで、本番環境のデータベースをmigrateし、ダミーデータを作成することができます。

php artisan config:clear

php artisan migrate --seed --env=production (本番環境のmigrateとダミーデータの作成を同時に実行）

これにより、ローカル環境から本番環境で利用しているデータベースにアクセスが可能になります。

以上の工程を実行することで、ローカルの環境構築が完了します。
