# 写真まみれ

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Sass](https://img.shields.io/badge/Sass-CC6699?style=for-the-badge&logo=sass&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)

> 奈良を拠点にする写真ブログ向けのオリジナル WordPress テーマ

## 📖 概要

写真投稿をフィルム状の一覧で見せるクラシックテーマ。テーマ名は `style.css` の `Theme Name: 写真まみれ`、テーマバージョンは `1.0`。

WordPress 本体、データベース、アップロード済みの写真はリポジトリに含まない。`composer.json` と `package.json` は無し。

公開ドメインは `header.php` のアクセス解析タグが参照する `https://photo-mamire.jp/`。

## ✨ 主な機能

- トップのフィルム風一覧。2カラム、帯を -15 度回転。1024px 以下は 1 カラム（`css/style.scss`）
- ホイール、矢印キー、縦スワイプを同じ慣性処理に渡す一覧スクロール（`js/script.js`）
- サムネイルのフェードイン（Web Animations API）と、クリック時のライトボックス
- タグの複数選択。`condition=or` は `tag_slug__in`、それ以外は `tag_slug__and`（`functions.php` の `pre_get_posts`）
- 1ページ 24 件（`$POSTPERPAGE`）。件数とページ送りは `footer.php`
- 検索 0 件は条件の再表示と最新 6 件（`template/nosearchcontent.php`）
- 個別ページでアイキャッチ JPEG の EXIF を表示（`single.php` の `exif_read_data()`）
- 横長・縦長で写真レイアウトを分岐（`getimagesize()`）
- 個別ページのコメントは、投稿本文ではなくアイキャッチ添付ファイルの `post_content`
- アイキャッチ未設定時は `images/default_noimage.png`
- 生成サイズは `custom-360x360`（クロップあり）と `custom-2000x2000`（比率維持）。標準の thumbnail / medium / large などは停止（`functions.php`）
- 管理画面の投稿一覧にアイキャッチ列を追加
- 固定ページはプロフィール、お問い合わせ、プライバシーポリシー。404 は案内と最新 6 件
- サイドバーは左下ボタンで開閉。メニューとタグ検索フォーム

## 🛠 技術スタック

依存関係ファイルは無し。下表はソースと `style.css` から確認できたもの。

| 分類                 | 技術                                                                                                               |
| -------------------- | ------------------------------------------------------------------------------------------------------------------ |
| 言語                 | PHP（バージョン宣言なし）、JavaScript（フレームワークなし）、Sass（`css/style.scss`）                              |
| フレームワーク / CMS | WordPress クラシックテーマ（対応バージョンの宣言なし。テーマ Version は 1.0）                                      |
| CSS                  | 読み込みは `css/reset.css`（destyle.css v4.0.1）と `css/style.css`。後者のクエリに `rand()` を付与                 |
| フォント             | Google Fonts の Noto Sans JP、RocknRoll One（`header.php`）                                                        |
| ページ送り           | `footer.php` が `function_exists('wp_pagenavi')` のときだけ `wp_pagenavi()` を呼ぶ。プラグインの宣言ファイルは無し |
| DB                   | 該当なし（テーマ内に接続設定なし）                                                                                 |
| パッケージ管理       | 該当なし                                                                                                           |
| お問い合わせフォーム | 該当なし（`page-contact.php` は案内文のあと `the_content()`。フォームプラグインの指定は無し）                      |

## 🚀 セットアップ

`composer.json` / `package.json` が無いため、パッケージのインストール手順は該当なし。

1. このディレクトリを WordPress の `wp-content/themes/photomamire_wp` に置く
2. 管理画面「外観 → テーマ」で「写真まみれ」を有効化する
3. スタイルの読み込み元は `functions.php`。編集対象は `css/style.scss`、enqueue 先は `css/style.css`
4. TODO: Sass のコンパイルコマンド（ビルド定義ファイルが無い）
5. TODO: 動作確認済みの PHP バージョンと WordPress バージョン
6. 個別ページの EXIF 表示は PHP の `exif_read_data()` を使用。拡張の導入手順はリポジトリに記載なし
7. ページ送りを出すには `wp_pagenavi()` を提供するプラグインが必要。未導入でも一覧自体は表示する（`function_exists` で分岐）
8. ヘッダーのリンク先は `/profile/`、`/privacy/`、`/contact/`。対応テンプレート名は「プロフィール」「プライバシーポリシー」「お問い合わせ」
9. 投稿はアイキャッチとタグを使用。一覧・ライトボックス・個別表示が参照する画像サイズは `custom-2000x2000`。EXIF 用に `full` も参照
10. TODO: フロントを「最新の投稿」にする必要があるかは設定ファイルに記載なし（投稿一覧テンプレートは `home.php`）

## 📁 ディレクトリ構成

```text
photomamire_wp/
├── style.css              テーマ宣言（Theme Name / Version のみ）
├── functions.php          テーマサポート、画像サイズ、タグ検索クエリ、管理画面の列
├── header.php             ヘッダー、サイドバー、タグ検索フォーム
├── footer.php             件数、ページ送り、ライトボックス
├── home.php               トップ一覧（WP_Query）
├── index.php              最終フォールバック
├── single.php             個別ページ（EXIF）
├── search.php             タグ検索結果
├── tag.php                タグアーカイブ
├── page.php               汎用固定ページ
├── page-profile.php       テンプレート名: プロフィール
├── page-contact.php       テンプレート名: お問い合わせ
├── page-privacy.php       テンプレート名: プライバシーポリシー
├── 404.php
├── template/
│   ├── photocontent.php      一覧の写真 1 件
│   ├── nosearchcontent.php   検索 0 件
│   └── 404content.php
├── css/
│   ├── reset.css          destyle.css v4.0.1
│   ├── style.scss         スタイルの編集元
│   └── style.css          読み込んでいる CSS
├── js/
│   └── script.js          慣性スクロール、ライトボックス、サイドバー
├── images/                フィルム地、機材写真、代替画像、メニューアイコン
└── favicon.png
```

## 🔗 デモ

解析タグの読み込み先: [https://photo-mamire.jp/](https://photo-mamire.jp/)

TODO: リポジトリ内にデモ手順やスクリーンショットの配置は無し

## 📝 今後の予定

該当なし

## 📄 ライセンス

テーマ全体の LICENSE ファイルは無し。該当なし。

`css/reset.css` のみ、ファイル先頭で destyle.css v4.0.1 / MIT License と記載。
