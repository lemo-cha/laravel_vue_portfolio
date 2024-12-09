## インストール方法
①インストール<br>
git clone https://github.com/lemo-cha/laravel_vue_portfolio.git<br>
②パッケージインストール<br>
composer install<br>
npm install<br>
③ご使用の環境に合わせて.envの調整、データベースの作成をしてください<br>
④起動<br>
php artisan serve<br>
npm run dev<br>
(開発環境)<br>

## 在庫検索・管理アプリ
このアプリは、「実店舗がある卸売業者が管理するアプリ(BtoB/C)」を想定し、作成しました。<br>
管理者（業者）は商品の登録、仕入登録、売上登録、顧客や仕入先の登録などを行います。<br>
ユーザー（顧客）は、商品の検索、在庫検索を行います。<br>

### プロジェクトの目標
・管理者は、商品情報/顧客情報/仕入先情報を管理することができる。<br>
・顧客は、来店しなくても、商品情報を見ることができる。<br>

※まだ未完成のため、以下に実装予定の処理を記載します<br>
・レスポンシブ対応<br>
・全体的なデザイン<br>
・トップページ、dashboardページ<br>
・商品の価格管理<br>
・商品の仕入登録、売上登録<br>
・laravel_permissionを使用したページ閲覧制限<br>
・FLOCSS,scssの訂正<br>
など

## 使用技術
・Laravel<br>
・Vue(Composition API)<br>
・axios<br>
・FLOCSS,scss<br>
・Mysql<br>

## 工夫した点
・Enum型による一貫性の確保<br>
　会社形態の登録にEnum型を採用し、空白の有無の正確性や半角全角の統一性が保たれるようにしました。また、表示形式を「株式会社」「（株）」に簡単に切り替えができるようにしました。<br>
・機器に応じたデータ件数の変更<br>
　商品一覧表示画面で、ユーザーが使用している機器によってpaginationのデータ件数を変更できるようにしました。<br>
・バックエンド主導のデータ整形<br>
　バックエンド側でデータの編集を行いフロントエンドでは表示するだけ、と一貫性を持たせました(一部編集し忘れているかもしれません)<br>

## 動作環境
Laravel v11.22.0<br>
Vue ^3.4.0<br>
php 8.2.21<br>
node v18.20.4<br>
npm 10.7.0<br>
mysql 5.7(8でも動作確認済みです)<br>

## 画像について
このプロジェクトで使用している画像（アプリアイコン・背景画像・ダミーに使用している画像）は、フリー使用が許可されているサイト様からダウンロードさせていただきました。ありがとうございます。二次使用は許可されておりませんので、このプロジェクトを公開しているブラウザ・ファイルからダウンロードして再使用することはご遠慮ください。

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
