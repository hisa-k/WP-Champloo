# WP-Champloo

WP-Champlooは、Webクリエイター向けに便利な機能・関数をチャンプルーしたプラグインです。

## 機能
WP-Champlooでは以下の機能を提供します。

* ヘッダに出力される以下の項目を削除します。

```html
<link rel="alternate" type="application/rss+xml" title="サイト名-フィード" href="http://xxxx.xxx/feed/" />
<link rel="alternate" type="application/rss+xml" title="サイト名-コメントフィード" href="http://xxxx.xxx/comments/feed/" />
<link rel="alternate" type="application/rss+xml" title="サイト名-カテゴリ名カテゴリーのフィード" href="http://xxxx.xxx/category/xxxx/feed/" />
<link rel="alternate" type="application/rss+xml" title="サイト名-タグ名タグのフィード" href="http://xxxx.xxx/tag/xxxx/feed/" />
<link rel="alternate" type="application/rss+xml" title="サイト名-検索結果:記事タイトルフィード" href="http://xxxx.xxx/search/xxxx/feed/rss2/" />
<link rel="alternate" type="application/rss+xml" title="サイト名-記事タイトルのコメントのフィード" href="http://xxxx.xxx/feed/" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://xxxx.xxx/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://xxxx.xxx/wp-includes/wlwmanifest.xml" />
<link rel='prev' title='記事タイトル' href='http://xxxx.xxx/' />
<link rel='next' title='記事タイトル' href='http://xxxx.xxx/' />
<meta name="generator" content="WordPress 3.x.x" />
<link rel='canonical' href='http://xxxx.xxx/' />
<link rel='shortlink' href='http://xxxx.xxx/?p=xx' />
```

* 投稿記事内にある画像のa要素に対し、クラス「lightbox」を自動付与します。

```html
<a href="http://xxxx.xxx/uploads/xxxx.jpg" class="lightbox" title="xxxx"><img width="xxx" height="xxx" src="xxxx.jpg" class="attachment-thumbnail" alt="xxxx" title="xxxx" /></a>
```

* カスタム投稿タイプ（月別アーカイブ）のリライトルールを追加します。

```html
http://xxxx.xxx/2013/post_type/
http://xxxx.xxx/2013/page/2/post_type/
http://xxxx.xxx/2013/04/post_type/
http://xxxx.xxx/2013/04/page/2/post_type/
http://xxxx.xxx/2013/04/10/post_type/
http://xxxx.xxx/2013/04/10/page/2/post_type/
```

## 関数
WP-Champlooでは以下の関数を提供します。

* **[get_archives_array](http://qiita.com/items/b26d0b466c0274fd085a)**（wp_get_archivesを配列で取得する関数）
* **get_post_type_year_link**（カスタム投稿タイプの年別アーカイブページへのURLを取得する関数）
* **get_post_type_month_link**（カスタム投稿タイプの月別アーカイブページへのURLを取得する関数）
* **get_pagination**（ページネーション関数）
* **[get_trim_str](http://qiita.com/items/cb96565068426e261690)**（文字数を指定して取得する関数）
* **[in_parent_category](http://qiita.com/items/b3016d1c71b0f5777482)**（指定したカテゴリに所属するのかを調べる関数）
* **[in_parent_page](http://qiita.com/items/568212c387a36f90ca66)**（指定したページに所属するのかを調べる関数）
* **in_expiry_date**（投稿が有効期間内にあるのかを調べる関数）

## インストール
ZIPファイルをダウンロード後、解凍し「wp-champloo」フォルダを「wp-content/plugins」ディレクトリにアップロードします。

## 動作環境
WordPress 3.5.1

## ライセンス
商用・非商用を問わず無償で利用することが出来ます。但し、当プラグインを利用した事により生じたいかなる不都合、トラブル、損失および損害等については責任を負いませんのでご了承ください。

## 今後の予定
* ロールオーバー・LightBox・スムーススクロール等の基本的な機能を備えたjqueryライブラリの同梱
* メディアアップローダーにアップした写真を自動認識し、ギャラリーを表示する関数の追加