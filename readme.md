##  [Laravel todoアプリケーション]

### 使用した技術
```
＊ Laradock
* PHP 7.2.22
＊ Docker 19.03.8
* docker-compose 1.25.5
* Laravel Framework 6.18.15
```

### 環境構築
#### ・dockerのインストール
```
# dockerのインストール
# $ brew cask install docker
```

#### ・Kitematicのインストール
```
# Kitematicのインストール
$ brew cask install kitematic
```

#### ・Laradockのインストール
```
# ディレクトリの作成
$ cd ~
$ mkdir laravel(適宜の名前で作成)
$ cd laravel
# laradockのインストール
$ git clone https://github.com/laradock/laradock.git
```

#### ・Docker環境の設定
```
$ cd laradock
$ cp env-example .env
```

#### ・Docker環境の構築
```
$　docker-compose up -d nginx mysql workspace phpmyadmin
```

#### ・Docker環境のバージョン
```
$ docker-compose run workspace php -v

$ docker-compose run nginx nginx -v

$ docker-compose run mysql mysql -V
```

#### ・Laravelのバージョン確認
```
$ php artisan -V
```

#### ・Laravelプロジェクトの作成
```
$ docker-compose exec --user=laradock workspace bash

$ composer create-project laravel/laravel sampleapp(適宜設定)

$ exit
```

#### ・Laradockの環境設定ファイルを変更
```
APP_CODE_PATH_HOST=../sampleapp
```

#### ・docker再起動
```
# Laradockの .env を変更した場合、反映させるためにdockerの再起動が必要
$ docker-compose stop
$ docker-compose up -d nginx mysql
```

#### ・Laravel Welcomeページを表示する
```
# デフォルトはポート80
http://localhost へアクセス
```

#### ・Laravel MySQL接続設定
```
# workspaceコンテナに入り、Laravelの .env ファイルを変更
$ docker-compose exec --user=laradock workspace bash

# .env ファイルのデータベース設定項目を下記の設定に書き換え
DB_CONNECTION=mysql
DB_HOST=mysql # 変更
DB_PORT=3306
DB_DATABASE=default # 変更
DB_USERNAME=default # 変更
DB_PASSWORD=secret

$ php artisan migrate
```

#### ・MySQL認証方式の確認
```
# mysqlコンテナにログイン、MySQLにログインして認証方式を表示するSELECT文を実行
$ docker-compose exec mysql bash
$ mysql -uroot -p root

defaultユーザーのpluginが mysql_native_password となっていればok
```

#### ・MySQL5.7にダウングレードする場合
```
# laradock/.env を変更
### MYSQL #################################################

#MYSQL_VERSION=latest
MYSQL_VERSION=5.7

$ docker-compose stop
$ rm -rf ~/.laradock
$ docker-compose up -d --build mysql
$ docker-compose exec mysql bash
# mysql --version
mysql  Ver 14.14 Distrib 5.7.24, for Linux (x86_64) using  EditLine wrapper
```

#### ・nginxのポート番号を変更する
```
# laradock/.env ファイルでポート変更
### NGINX #################################################

#NGINX_HOST_HTTP_PORT=80
NGINX_HOST_HTTP_PORT=8888

$ docker-compose stop
$ docker-compose up -d --build nginx

```

### 機能一覧
```
・タスク作成
・タスク状態管理
・タスク一覧表示
・タスクのフォルダ管理
・フォルダ作成
・パスワード再登録機能
・認証機能
・会員登録
```

### URL一覧
|URL                |メソッド       |処理|
|:--------------------:|:------------------:|:--------------------:|
|/folders/{フォルダID}/tasks	  |GET   |タスク一覧ページを表示する。     |
|/folders/create  |GET  |フォルダ作成ページを表示する。     |
|/folders/create |POST |フォルダ作成処理を実行する。    |
|/folders/{フォルダID}/tasks/create |GET |タスク作成ページを表示する。   |
|/folders/{フォルダID}/tasks/create |POST |タスク作成処理を実行する。    |
|/folders/{フォルダID}/tasks/{タスクID}/edit |GET |タスク編集ページを表示する。   |
|/folders/{フォルダID}/tasks/{タスクID}/edit |POST |タスク編集処理を実行する。   |

### テーブル定義

・フォルダテーブル
|カラム論理名                |カラム物理名       |
|:--------------------:|:------------------:|
|ID  |id     |
|タイトル |title |
|作成日  |created_at  |
|更新日 |updated_at |

・タスクテープル
|カラム論理名                |カラム物理名       |
|:--------------------:|:------------------:|
|ID  |id     |
|フォルダID |folder_id |
|タイトル  |title  |
|状態 |status |
|期限日  |due_date  |
|作成日 |created_at |
|更新日  |updated_at  |

### カラムの型
・フォルダテーブル
|カラム論理名                |カラム物理名       |型|型の意味 |
|:--------------------:|:------------------:|:--------------------:|:--------------------:|
|ID |id | SERIAL | 連番(自動採番) |
|タイトル |title | VARCHAR(20) | 20字まで |
|作成日 | created_at | TIMESTAMP | 日付と時刻 |
|更新日 | updated_at | TIMESTAMP | 日付と時刻 |

・タスクテーブル
|カラム論理名                |カラム物理名       |型|型の意味 |
|:--------------------:|:------------------:|:--------------------:|:--------------------:|
|ID |id | SERIAL | 連番(自動採番) |
|フォルダID |folder_id | INTEGER |  |
|タイトル |title | VARCHAR(20) | 20字まで |
|状態 |status | INTEGER |  |
|期限日 |due_date | DATE |  |
|作成日 | created_at | TIMESTAMP | 日付と時刻 |
|更新日 | updated_at | TIMESTAMP | 日付と時刻 |