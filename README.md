# Rese-re  
## 概要  
ユーザーは飲食店の予約やお気に入り登録、レビューなどをすることができ、お店側は店舗の作成、店舗情報の更新やqrコードによる予約確認などができるアプリ。

![アプリトップ画像](https://github.com/YutaTomatsu/Rese-re/blob/main/Readme%E7%94%A8%E7%94%BB%E5%83%8F/%E3%82%A2%E3%83%97%E3%83%AA%E3%83%88%E3%83%83%E3%83%97%E7%94%BB%E5%83%8F.png?raw=true)

## 作成した目的  

飲食店予約アプリを作成するため。

## アプリケーションURL

13.230.68.76

## 機能一覧

会員登録機能  
ログイン機能  
ログアウト機能  
パスワードリセット機能  
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

### 前提条件

- PHP 7.4 以上がインストールされていること  
- Composerがインストールされていること  
- MySQLデータベースがセットアップされていること  
- AWSのセットアップが完了していること  

### インストール手順  

#### 1, Dockerのインストール（既にインストール済みの場合は飛ばして下さい）

以下のリンクからDockerをダウンロードします。

[https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)

ダウンロードが完了したら、エクスプローラのダウンロードフォルダにインストーラが保存されているので、ダブルクリックしインストールします。  
インストールが完了したらpcを再起動し、以下のコマンドでバージョン情報が返ってくるか確認して下さい。

docker -v

以下のようにバージョン情報が返ってきたらインストール完了です。

Docker version 20.10.22, build 3a2c30b

#### 2,リポジトリのクローン  

git clone https://github.com/YutaTomatsu/Rese-re.git

#### 3,プロジェクトのディレクトリに移動してビルド  

cd Rese-re  
docker-compose up -d --build  
code .

#### 4,コンテナに移動し必要な依存関係のインストール  

docker-compose exec php bash（以降コンテナに移動するときはプロジェクトディレクトリからこのコマンドを実行して下さい） composer install

#### 5,環境設定ファイルの作成  

cp .env.example .env

#### 6,.envファイルを編集して、データベース接続情報を設定  

DB_CONNECTION=mysql  
DB_HOST=mysql  
DB_PORT=3306  
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass

#### 7,アプリケーションキーの生成

php artisan key:generate

#### 8,データベースのマイグレーション実行  

php artisan migrate

#### 9,アプリケーションの起動

php artisan serve

アプリケーションが正常に起動すると、[http://localhost:10000](http://localhost:10000) でアクセスできます。  
またデータベースは[http://localhost:8080](http://localhost:8080) からアクセスすることができます。

### 10, ダミーデータの作成

php artisan db:seed

これにより、ダミーのショップやユーザーアカウント、管理者アカウント、店舗代表者アカウントなどが作成されます。  

※ダミーアカウントを利用する場合は以下のアカウントからそれぞれの権限にログインすることができます。

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

#### 1,.envの編集

以下の例を参考に、自身の環境に合わせて.envを作成して下さい。

（例）

APP_NAME=Rese　※Reseに変更  
APP_ENV=local  
APP_KEY=（php artisan key:generateで作成されたキー）  
APP_DEBUG=true  
APP_URL=http://localhost

LOG_CHANNEL=stack  
LOG_DEPRECATIONS_CHANNEL=null  
LOG_LEVEL=debug

DB_CONNECTION=mysql  
DB_HOST=mysql  
DB_PORT=3306  
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass

BROADCAST_DRIVER=log  
CACHE_DRIVER=file  
FILESYSTEM_DRIVER=local  
QUEUE_CONNECTION=database ※databaseに変更  
SESSION_DRIVER=database  
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1  
REDIS_PASSWORD=null  
REDIS_PORT=6379

MAIL_DRIVER=smtp  
MAIL_HOST=smtp.gmail.com  
MAIL_PORT=587  
MAIL_USERNAME=example@gmail.com(認証に利用するメールアドレス）  
MAIL_PASSWORD=****************(２段階認証プロセスのアプリパスワードを入力）  
MAIL_ENCRYPTION=tls MAIL_FROM_ADDRSS=example@gmail.com(認証に利用するメールアドレス）  
MAIL_FROM_NAME="Rese"

＊例ではgmailを用いて認証していますが自身環境に合わせて変更して下さい

AWS_ACCESS_KEY_ID=*********************  
AWS_SECRET_ACCESS_KEY=*********************  
AWS_DEFAULT_REGION=us-east-1  
AWS_BUCKET=rese-bucket  
AWS_USE_PATH_STYLE_ENDPOINT=false

※用意したs３の情報を入力

PUSHER_APP_ID=  
PUSHER_APP_KEY=  
PUSHER_APP_SECRET=  
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"  
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

STRIPE_PUBLIC_KEY=*************************************  
STRIPE_SECRET_KEY=*************************************

※STRIPEの記述はデフォルトでは存在しないため、新たに書き足して下さい ※パブリックキーとシークレットキーは決済機能を提供するサービスであるstripeでアカウントを作成し、テストモードのパブリックキーとシークレットきーを貼り付けて下さい。

#### ２,マルチログインの設定

laravelのルートディレクトリ/vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.phpのstore functionを以下のように修正します。

use Laravel\Fortify\Http\Requests\LoginRequest;　※use宣言を追加

    public function store(LoginRequest $request)
 
    { return $this->loginPipeline($request)->then(function ($request) { $user = $request->user();

    if ($user->hasVerifiedEmail()) {
        $role = $user->admin ? $user->admin->role : 'user';

        if ($role == 'admin') {
            return redirect()->route('admin');
        } elseif ($role == 'owner') {
            return redirect()->route('owner');
        } else {
            return redirect()->route('dashboard');
        }
    } else {
        return redirect()->route('verification.notice');
    }
    });
 
    }

これにより、adminsテーブルに保存されているroleと紐付けられているuser_idによってログインしたユーザーのロールを識別し、ロールに対応したアクセス先にアクセスされるようになります。

また、laravelのルートディレクトリ/vendor/laravel/fortify/src/Http/Controllers/VerifyEmailController.phpの__invoke　functionを以下のように修正します。

　　　use Illuminate\Auth\Events\Verified;　※use宣言を追加

    public function __invoke(VerifyEmailRequest $request)
    {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    if ($request->user()->markEmailAsVerified()) {
        event(new Verified($request->user()));
    }

    // Check the user's role and redirect accordingly
    $role = $request->user()->admin ? $request->user()->admin->role : 'user';

    if ($role == 'owner') {
        return redirect()->route('owner');
    } else {
        return redirect()->route('dashboard');
    }
}
 
これにより、メール認証時にロールに対応したアクセス先にアクセスされるようになります。

#### 3,queueとscheduleの実行

以下のコマンドを実行してqueueとscheduleを起動します。 queueを実行することで管理者のメール一斉送信を非同期化し、scheduleを実行することでユーザーの予約に対するリマインダーメール機能を起動します。

php artisan queue:work  
php artisan schedule:work

以上の工程を実行することで、ローカルの環境構築が完了します。
