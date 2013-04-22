<?php
/*
Plugin Name: WP Champloo
Plugin URI: http://github.com/hisa-k/WP-Champloo
Description: Webクリエイター向けに便利な機能をチャンプルーしました
Author: hisa-k
Version: 0.1
Author URI: http://hm-blog.jugem.jp/
*/

include('inc/functions.php');

class Wp_Champloo{

	/**
	* @function construct
	*/
	public function __construct(){
		$this->remove_actions();
		add_filter('the_content', array($this, 'set_class_lightbox'));
		add_action('wp_loaded', array(&$this,'set_rewrite_rule'), 99);
	}

	/**
	* @function remove_actions
	* @desc ヘッダに出力される項目を削除する
	* @return void
	*/
	public function remove_actions(){
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		remove_action('wp_head', 'rel_canonical');
	}

	/**
	* @function set_class_lightbox
	* @desc 投稿記事内にある画像のa要素に対し、クラス「lightbox」を自動付与する
	* @return string
	*/
	public function set_class_lightbox($content){
		global $post;

		$pattern = "/(<a(?![^>]*?rel=['\"]lightbox.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)['\"][^\>]*)>/i";
		$replacement = '$1 class="lightbox">';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}

	/**
	* @function set_rewrite_rule
	* @desc カスタム投稿タイプ（月別アーカイブ）のリライトルールを追加する
	* @return void
	*/
	public function set_rewrite_rule(){
		$post_types = get_post_types(array('public'=>true, '_builtin'=>false, 'show_ui'=>true));

		foreach($post_types as $post_type){
			$post_type_obj = get_post_type_object($post_type);
			if(!$post_type_obj){
				continue;
			}

			if($post_type_obj->has_archive === true){
				$slug = $post_type_obj->rewrite['slug'];
			}else{
				$slug = $post_type_obj->has_archive;
			}

			//year
			add_rewrite_rule('([0-9]{4})/'.$slug.'/?$', 'index.php?year=$matches[1]&post_type='.$post_type, 'top');
			add_rewrite_rule('([0-9]{4})/page/?([0-9]{1,})/'.$slug.'/?$', 'index.php?year=$matches[1]&paged=$matches[2]&post_type='.$post_type, 'top');
			//month
			add_rewrite_rule('([0-9]{4})/([0-9]{1,2})/'.$slug.'/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&post_type='.$post_type, 'top');
			add_rewrite_rule('([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/'.$slug.'/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]&post_type='.$post_type, 'top');
			//day
			add_rewrite_rule('([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/'.$slug.'/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&post_type='.$post_type, 'top');
			add_rewrite_rule('([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/'.$slug.'/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]&post_type='.$post_type, 'top');
		}
	}
}

$wp_champloo = new Wp_Champloo();
?>