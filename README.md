# WP-Champloo

WP-ChamplooはWebクリエイター向けに便利な機能をチャンプルーしたプラグインです。

## 機能
WP-Champlooでは以下の機能を提供します。

* ヘッダに出力される以下の項目を削除

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

* 投稿記事内にある画像のa要素に対し、クラス「lightbox」を自動付与
* カスタム投稿タイプ（月別アーカイブ）のリライトルールを追加

## 関数
WP-Champlooでは以下の関数を提供します。

* wp_get_archivesを配列で取得する関数 **get_archives_array**
* ページネーション関数 **get_pagination**
* 文字数を指定して取得する関数 **get_trim_str**
* 指定したカテゴリに所属するのかを調べる関数 **in_parent_category**
* 指定したページに所属するのかを調べる関数 **in_parent_page**
* 投稿が有効期間内にあるのかを調べる関数 **in_expiry_date**

## インストール
ZIPファイルをダウンロード後、解凍し「wp-champloo」フォルダを「wp-content/plugins」ディレクトリにアップロードします。

## 使い方
準備中
http://qiita.com/users/hisa_k