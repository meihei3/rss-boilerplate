# RSS Boilerplate

汎用RSS配信ボイラープレート（PHP 8.4 + Symfony 7.3）

## 📋 プロジェクト概要

### 目的
Square Release Notes RSSをベースに、**汎用的なRSSボイラープレート**を作成。任意のJSON APIからRSSフィードを生成できる再利用可能な基盤を提供。

### 解決する問題
- JSON APIからRSS配信への変換作業の自動化
- 外部APIの構造変更に対する堅牢性
- 開発者ごとの実装差異の解消

### ターゲット
- JSON APIを持つサービスでRSS配信を追加したい開発者
- 外部データソースからコンテンツ配信を行いたいプロジェクト
- RSS生成の実装パターンを学びたい開発者

### 技術スタック
PHP 8.4 + Symfony 7.3 MicroKernel + 外部データ処理特化設計

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

---

## 🤖 Claude Code開発ガイド

### 開発時の基本方針
1. **外部データ処理を最優先**: 型安全性よりも堅牢性を重視
2. **既存パターンの踏襲**: 新機能は既存の`ContentFetcher`パターンに従う
3. **テスト必須**: 機能追加時は必ずユニットテストを作成
4. **ドキュメント更新**: README.md、例外的にCLAUDE.mdを同期更新

### 推奨アプローチ
✅ **DO**
- `readonly class`での新しいモデル作成
- `JsonContentFetcher`を参考にした新しいFetcher実装
- PHPStan Level 8でのエラーゼロ維持
- コミット前の`composer test && composer phpstan && composer phpcs`実行

❌ **DON'T** 
- PHPStan Level 9以上の設定変更
- 外部APIの完全型定義（現実的でない）
- readonly classの変更（イミュータビリティ破壊）
- テストなしでの機能追加

### ファイル編集の優先順位
1. **Core Logic**: `src/Service/`, `src/Model/`
2. **Command**: `src/Command/GenerateRssCommand.php`
3. **Config**: `config/services.php`, `.env`
4. **Templates**: `templates/rss.xml.twig`
5. **Tests**: `tests/Unit/`

### 新機能追加手順
```bash
# 1. ブランチ作成
git checkout -b feature/new-fetcher

# 2. ContentFetcher実装
# src/Service/NewContentFetcher.php を作成

# 3. テスト作成
# tests/Unit/Service/NewContentFetcherTest.php を作成

# 4. DI設定
# config/services.php で新しいFetcherを登録

# 5. 品質チェック
composer test && composer phpstan && composer phpcs

# 6. コミット・PR
git add . && git commit -m "feat: NewContentFetcherの追加"
git push -u origin HEAD && gh pr create --assignee @me
```

### よくある課題とトラブルシューティング

#### 外部API接続エラー
- `JsonContentFetcher`のエラーハンドリングを参考
- 適切なデフォルト値の設定
- ログ出力の追加

#### 型エラー（PHPStan）
- `array<string, mixed>`でのPHPDoc型注釈
- キャスト`(string)`よりもnull合体演算子`??`を優先
- Level 8で通らない場合は設計を見直し

#### テスト失敗
- 外部API依存を避けたモックの使用
- `ContentItem`のイミュータブル特性を活用
- `$this->assert*()`スタイルの徹底

---

## 🔧 開発ルール

### ブランチ作成ルール
- **機能開発**: `feature/{{ticket-id}}`
- **バグ修正**: `hotfix/{{ticket-id}}`

### ブランチ管理
- `main`ブランチで作業していた場合、コミット前に適切なブランチを作成
- 必ず`git status`と`git --no-pager diff`で状況確認
- **タスク完了よりもコミットの粒度を重視**
- diffがあればタスク未完了でもコミットすること

### コミットメッセージルール

#### プレフィックス（type:）
- `feat`: 新機能追加・削除
- `fix`: バグ修正
- `refactor`: コード再構築（動作変更なし）
- `perf`: パフォーマンス改善
- `style`: フォーマット関連
- `test`: テスト関連
- `docs`: ドキュメント関連
- `build`: ビルド関連（CI、依存関係等）
- `chore`: その他雑務

#### メッセージ形式
- **言語**: 日本語で記述
- **1行目**: なぜこの変更をしたのかを記載
- **3行目以降**: 詳細な実施内容（体言止め、`- `でリスト形式）

```bash
feat: RSS生成機能の改善

- JsonContentFetcherのエラーハンドリング強化
- テストケースの追加
- PHPDocの型注釈改善
```

### Pull Request作成
```bash
# プッシュ
git push -u origin HEAD

# PR作成（日本語、自分をアサイン）
gh pr create --assignee @me --title "feat: RSS生成機能の改善"
```

---

## ⚠️ プロジェクト固有の制約・要件

### 外部API依存の注意点
- **データ構造の不確実性**: 外部APIのレスポンス形式は予告なく変更される可能性
- **ネットワークエラー**: タイムアウト、接続失敗への対応が必須
- **認証・レート制限**: APIキー、リクエスト制限への配慮

### パフォーマンス要件
- **メモリ使用量**: 大量データ処理でのメモリリーク防止
- **実行時間**: RSS生成処理は10秒以内での完了を目標
- **キャッシュ戦略**: 頻繁なAPI呼び出し回避（将来的な実装候補）

### セキュリティ考慮事項
- **入力値検証**: 外部APIデータの適切なサニタイゼーション
- **XSS対策**: RSS出力でのHTML特殊文字エスケープ
- **ログ管理**: APIキー等の機密情報の出力回避

### 運用・保守性
- **設定の外部化**: `.env`ファイルでの環境別設定管理
- **エラー追跡**: 適切なログ出力とエラーメッセージ
- **バージョン管理**: Dependabotによる依存関係自動更新

---

## 🆘 FAQ・よくある質問

### Q: 新しいContentFetcherを追加したい
A: `examples/`の実装例を参考に、`ContentFetcherInterface`を実装し、`config/services.php`で登録してください。

### Q: RSS出力形式をカスタマイズしたい  
A: `templates/rss.xml.twig`を編集してください。RSS 2.0仕様に準拠している限り自由にカスタマイズ可能です。

### Q: PHPStanエラーが解決できない
A: Level 8で通らない場合、外部データの型定義アプローチを見直してください。完全型定義より堅牢なエラーハンドリングを優先します。

### Q: テストでモックが必要
A: `JsonContentFetcher`の`HttpClientInterface`モックパターンを参考にしてください。外部API依存は必ずモック化してください。

### Q: GitHub Actionsが失敗する
A: ローカルで`composer test && composer phpstan && composer phpcs`が全て成功することを確認してからプッシュしてください。