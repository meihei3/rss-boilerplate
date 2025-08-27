# RSS Boilerplate

汎用RSS配信ボイラープレート（PHP 8.4 + Symfony 7.3）

## 📋 プロジェクト概要

任意のJSON APIからRSSフィードを生成する汎用的なボイラープレート。PHP 8.4の最新機能とSymfony 7.3 MicroKernelを使用。

**外部データ処理に特化**: 外部JSON APIの型構造が不確実な環境でも安全に動作するよう設計。

## 🚀 クイックスタート

```bash
# 依存関係インストール
composer install

# RSS生成（デフォルト設定）
composer generate-rss

# カスタムオプション付きRSS生成
php bin/console generate-rss --title="My RSS Feed" --output="custom-feed.xml"
```

## 🛠️ 開発コマンド

```bash
# テスト実行
composer test

# コードスタイルチェック（PSR-12）
composer phpcs

# 静的解析（PHPStan Level 8）
composer phpstan

# カバレッジレポート生成
composer test-coverage

# コードスタイル自動修正
composer phpcbf
```

## 📁 重要なファイル

### 環境設定
- `.env` - 環境変数設定（コンテンツソースURL等）
- `config/services.php` - Symfony DIコンテナ設定

### コア実装
- `src/Service/JsonContentFetcher.php` - JSON APIからコンテンツ取得
- `src/Model/ContentItem.php` - RSSアイテム構造（readonly class）
- `templates/rss.xml.twig` - RSS XML生成テンプレート

### カスタマイズ例
- `examples/` - カスタムContentFetcher実装例

## 🔧 開発時の注意事項

### コード品質
- **PHP 8.4必須**: readonly classes, match expressions等を使用
- **PSR-12準拠**: コードスタイル必須
- **PHPStan Level 8**: 実用的な最高レベル静的解析
  - `level: max`や`level: 10`は外部JSON APIデータとの相性が悪い
  - 外部APIのレスポンス構造を完全に型定義するのは現実的でない
  - `level: 8`が外部データ処理と型安全性のベストバランス
- **PHPUnit**: `$this->assert*()` スタイル推奨

### アーキテクチャ
- **Symfony 7.3 MicroKernel**: 軽量なコンソールアプリケーション
- **readonly classes**: イミュータブルなデータ構造
- **Constructor Property Promotion**: 簡潔なクラス定義
- **Dependency Injection**: Symfonyコンテナでの依存関係管理

### CI/CD
GitHub Actionsで以下を自動実行：
1. コードスタイルチェック
2. 静的解析
3. ユニットテスト
4. カバレッジレポート

## 🔄 カスタマイズ方法

### 1. ContentFetcherの実装
```php
readonly class MyContentFetcher implements ContentFetcherInterface
{
    public function fetchContent(): array
    {
        // カスタムロジックでContentItem[]を返す
    }
}
```

### 2. DIコンテナ設定
```php
// config/services.php
$services->set(ContentFetcherInterface::class, MyContentFetcher::class)
    ->bind('$apiUrl', '%env(MY_API_URL)%');
```

### 3. 環境変数設定
```bash
# .env
CONTENT_SOURCE_URL=https://api.example.com/feed
RSS_TITLE="My Custom RSS Feed"
RSS_DESCRIPTION="Generated RSS feed"
```

## 📝 ライセンス

MIT License - 詳細は [LICENSE](LICENSE) を参照