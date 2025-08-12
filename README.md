# クイズアプリケーション

## プロジェクト概要
このプロジェクトはLaravelフレームワークを使用して構築されたクイズアプリケーションです。

### 主な機能
- ユーザー向けクイズ機能
  - ジャンル別クイズの選択
  - クイズの実施と採点
- 管理者向け機能
  - クイズ問題の管理（作成・編集・削除）

## 環境要件

- PHP 8.1 以上
- Composer 2.0 以上
- Node.js 16.x 以上
- npm 8.x 以上 または yarn 1.22.x 以上
- MySQL 5.7 以上 または MariaDB 10.3 以上
- Laravel Sail (Docker環境推奨)

## セットアップ手順

### 開発環境の準備
Docker Desktopをインストールし、起動しておいてください。

### Laravel Sailのセットアップ
```bash
# 初回のみ
./vendor/bin/sail up -d

# コンテナ内でコマンドを実行する場合
./vendor/bin/sail shell
```

### 1. リポジトリのクローンと初期設定
```bash
git clone [リポジトリURL]
cd lara-qui-app
```

### 2. 依存関係のインストール
```bash
composer install
npm install
```

### 3. 環境設定ファイルの作成
```bash
cp .env.example .env
php artisan key:generate
```

### 4. データベースの設定
`.env` ファイルを編集して、データベース接続情報を設定してください。

### 5. アプリケーションキーの生成
```bash
php artisan key:generate
```

### 6. データベースマイグレーション
```bash
php artisan migrate
```

### 7. 管理者アカウントの作成
```bash
# 管理者アカウントを作成
php artisan make:filament-user

# または既存のユーザーを管理者に昇格
php artisan make:filament-user --user=1
```

### 8. フロントエンドアセットのビルド
開発環境用:
```bash
npm run dev
```

本番環境用:
```bash
npm run build
```

## 開発サーバーの起動

### Laravel開発サーバー (Sail使用)
```bash
# バックグラウンドで起動
./vendor/bin/sail up -d

# ログを確認
./vendor/bin/sail logs -f
```

### Vite開発サーバー（別ターミナルで実行）
```bash
# コンテナ内で実行
./vendor/bin/sail npm run dev
```

### 管理画面へのアクセス
- 管理画面: `http://localhost/admin/login`
- ユーザー画面: `http://localhost`

## テストの実行
```bash
# ユニットテスト
./vendor/bin/sail test

# 機能テスト
./vendor/bin/sail test --testsuite=Feature

# 特定のテストを実行
./vendor/bin/sail test tests/Feature/QuizTest.php
```

## 管理機能の詳細

### クイズ管理
- カテゴリ別のクイズ作成・編集・削除

## デプロイ

### 本番環境へのデプロイ手順

1. コードを本番サーバーにデプロイ
2. 依存関係をインストール
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   ```
3. 環境設定
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. ストレージリンクの作成
   ```bash
   php artisan storage:link
   ```
5. スケジュール設定（クイズの公開/非公開の自動化など）
   ```bash
   # スケジューラーの設定
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

## ディレクトリ構造

```
app/
├── Console/         # カスタムArtisanコマンド
├── Http/
│   ├── Controllers/ # コントローラー
│   └── Middleware/  # ミドルウェア
├── Models/          # データモデル
├── Policies/        # 認可ポリシー
└── Providers/       # サービスプロバイダー

database/
├── factories/      # テスト用ファクトリ
├── migrations/     # データベースマイグレーション
└── seeders/        # シーダークラス

resources/
├── js/             # JavaScriptファイル
├── css/            # CSSファイル
├── views/          # ビューファイル
│   ├── admin/      # 管理画面用ビュー
│   └── quiz/       # クイズ関連ビュー
└── lang/           # 多言語対応ファイル

routes/
├── web.php        # Webルート
└── console.php    # コンソールコマンド

tests/             # テストファイル
```

## トラブルシューティング

### 管理画面にアクセスできない場合
1. 管理者権限を持ったユーザーでログインしているか確認
2. ルートが正しく設定されているか確認
   ```bash
   php artisan route:list
   ```

### アセットが読み込まれない場合
1. Vite開発サーバーが起動しているか確認
2. キャッシュをクリア
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```


## ライセンス
このプロジェクトは [MIT license](https://opensource.org/licenses/MIT) で公開されています。


## 著者

Ten10sun
---

*このドキュメントはプロジェクトの進捗に伴い更新される場合があります。***


