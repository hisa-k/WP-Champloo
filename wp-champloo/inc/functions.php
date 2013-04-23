<?php
/**
* @function get_archives_array
* @param post_type(string) / period(string) / year(Y) / limit(int)
* @return array
*/
if(!function_exists('get_archives_array')){
	function get_archives_array($args = ''){
		global $wpdb, $wp_locale;

		$defaults = array(
			'post_type' => '',
			'period'  => 'monthly',
			'year' => '',
			'limit' => ''
		);
		$args = wp_parse_args($args, $defaults);
		extract($args, EXTR_SKIP);

		if($post_type == ''){
			$post_type = 'post';
		}elseif($post_type == 'any'){
			$post_types = get_post_types(array('public'=>true, '_builtin'=>false, 'show_ui'=>true));
			$post_type_ary = array();
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

				array_push($post_type_ary, $slug);
			}

			$post_type = join("', '", $post_type_ary); 
		}else{
			if(!post_type_exists($post_type)){
				return false;
  			}
		}
		if($period == ''){
			$period = 'monthly';
		}
		if($year != ''){
			$year = intval($year);
			$year = " AND DATE_FORMAT(post_date, '%Y') = ".$year;
		}
		if($limit != ''){
			$limit = absint($limit);
			$limit = ' LIMIT '.$limit;
		}

		$where  = "WHERE post_type IN ('".$post_type."') AND post_status = 'publish'{$year}";
		$join   = "";
		$where  = apply_filters('getarchivesary_where', $where, $args);
		$join   = apply_filters('getarchivesary_join' , $join , $args);

		if($period == 'monthly'){
				$query = "SELECT YEAR(post_date) AS 'year', MONTH(post_date) AS 'month', count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
		}elseif($period == 'yearly'){
			$query = "SELECT YEAR(post_date) AS 'year', count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
		}

		$key = md5($query);
		$cache = wp_cache_get('get_archives_array', 'general');
		if(!isset($cache[$key])){
			$arcresults = $wpdb->get_results($query);
			$cache[$key] = $arcresults;
			wp_cache_set('get_archives_array', $cache, 'general');
		}else{
			$arcresults = $cache[$key];
		}
		if($arcresults){
			$output = (array)$arcresults;
		}

		if(empty($output)){
			return false;
		}

		return $output;
	}
}

/**
* @function get_post_type_year_link
* @param post_type(string) / year(Y)
* @return string
*/
if(!function_exists('get_post_type_year_link')){
	function get_post_type_year_link($post_type, $year = ''){
		global $wp_rewrite;

		$post_type_obj = get_post_type_object($post_type);
		if(!$post_type_obj){
			return false;
		}
		if(!$post_type_obj->has_archive){
			return false;
		}

		if(!$year){
			$year = gmdate('Y', current_time('timestamp'));
		}

		if(get_option('permalink_structure') && is_array($post_type_obj->rewrite)){
			if($post_type_obj->has_archive === true){
				$struct = $year.'/'.$post_type_obj->rewrite['slug'];
			}else{
				$struct = $year.'/'.$post_type_obj->has_archive;
			}

			if($post_type_obj->rewrite['with_front']){
				$struct = $wp_rewrite->front.$struct;
			}else{
				$struct = $wp_rewrite->root.$struct;
			}

			$link = home_url(user_trailingslashit($struct, 'post_type_archive'));
		}else{
			$link = home_url('?year='.$year.'&post_type='.$post_type);
		}

		return apply_filters('post_type_year_link', $link, $post_type);
	}
}

/**
* @function get_post_type_month_link
* @param post_type(string) / year(Y)
* @return string
*/
if(!function_exists('get_post_type_month_link')){
	function get_post_type_month_link($post_type, $year = '', $month = ''){
		global $wp_rewrite;

		$post_type_obj = get_post_type_object($post_type);
		if(!$post_type_obj){
			return false;
		}
		if(!$post_type_obj->has_archive){
			return false;
		}

		if(!$year){
			$year = gmdate('Y', current_time('timestamp'));
		}

		if(!$month){
			$month = gmdate('m', current_time('timestamp'));
		}
		$month = zeroise(intval($month), 2);

		if(get_option('permalink_structure') && is_array($post_type_obj->rewrite)){
			if($post_type_obj->has_archive === true){
				$struct = $year.'/'.$month.'/'.$post_type_obj->rewrite['slug'];
			}else{
				$struct = $year.'/'.$month.'/'.$post_type_obj->has_archive;
			}
	
			if($post_type_obj->rewrite['with_front']){
				$struct = $wp_rewrite->front.$struct;
			}else{
				$struct = $wp_rewrite->root.$struct;
			}
	
			$link = home_url(user_trailingslashit($struct, 'post_type_archive'));
		}else{
			$link = home_url('?year='.$year.'&month='.$month.'&post_type='.$post_type);
		}
	
		return apply_filters('post_type_year_link', $link, $post_type);
	}
}

/**
* @function get_pagination
* @param none
* @return string
*/
if(!function_exists('get_pagination')){
	function get_pagination(){
		global $wp_query, $paged;
	
		$pages = $wp_query->max_num_pages;

		if($pages == ''){
			$pages = 1;
		}
		if($paged == ''){
			$paged = 1;
		}
	
		if($pages >= 2){
			$output = '<ul class="pagination">';
			if($paged > 1){
				$output .= '<li class="prev"><a href="'.get_pagenum_link($paged-1).'">前のページ</a></li>';
			}else{
				$output .= '<li class="prev">前のページ</li>';
			}
	
			for($i=1; $i<=$pages; $i++){
				if($paged == $i){
					$output .= '<li class="current">'.$i.'</li>';
				}else{
					$output .= '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
				}
			}
	
			if($paged < $pages){
				$output .= '<li class="next"><a href="'.get_pagenum_link($paged+1).'">次のページ</a></li>';
			}else{
				$output .= '<li class="next">次のページ</li>';
			}
			$output .= '</ul>';
		}

		return $output;
	}
}

/**
* @function get_trim_str
* @param str(string), len(int), suffix(string), echo(bool)
* @return string
*/
if(!function_exists('get_trim_str')){
	function get_trim_str($args = ''){

		$defaults = array(
			'str' => '',
			'len' => 30,
			'suffix' => '..',
			'echo' => true
		);
		$args = wp_parse_args($args, $defaults);
		extract($args, EXTR_SKIP);

		$str = esc_html($str);
		$len = intval($len);
		$suffix = esc_html($suffix);

		if(mb_strlen($str, 'UTF-8') > $len){
			$output = mb_substr($str, 0, $len, 'UTF-8').$suffix;
		}else{
			$output = $str;
		}

		if($echo){
			echo $output;
		}else{
			return $output;
		}
	}
}

/**
* @function in_parent_category
* @param cats_id(array)
* @return bool
*/
if(!function_exists('in_parent_category')){
	function in_parent_category($cats_id = null){
		global $post;

		foreach((array)$cats_id as $cat_id){
			$parent_cats = get_term_children(intval($cat_id), 'category');
			if($parent_cats && in_category($parent_cats, $post->ID)){
				return true;
			}
		}

		return false;
	}
}

/**
* @function in_parent_page
* @param pages_id(array)
* @return bool
*/
if(!function_exists('in_parent_page')){
	function in_parent_page($pages_id = null){
		if(is_page()){
			global $post;

			$parent_pages = get_post_ancestors($post->ID);

			foreach((array)$pages_id as $page_id){
				if($parent_pages && in_array(intval($page_id), $parent_pages)){
					return true;
				}
			}
		}

		return false;
	}
}

/**
* @function in_expiry_date
* @param post_date(Y/m/d), days(int)
* @return bool
*/
if(!function_exists('in_expiry_date')){
	function in_expiry_date($post_date = null, $days = 6){
		global $post;

		if($post_date == ''){
			$post_date = $post->post_date;
		}

		if(in_array(strtotime($post_date), array(false, -1))){
			return false;
		}

		$limit = current_time('timestamp') - ($days - 1) * 24 * 3600;
		if(mysql2date('Y/m/d', $post_date) >= date('Y/m/d', $limit)){
			return true;
		}

		return false;
	}
}
?>