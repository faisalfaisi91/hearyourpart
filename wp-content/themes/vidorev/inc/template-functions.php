<?php
if ( ! function_exists( 'vidorev_ajax_verify_nonce' ) ) :
	function vidorev_ajax_verify_nonce($nonce, $login = true){
		$theme_data = wp_get_theme();
		$require_login = $login?'true':var_export(is_user_logged_in(), true);
		if(!wp_verify_nonce(trim($nonce), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).$require_login )){
			return false;
		}
		return true;
	}
endif;

if ( ! function_exists( 'vidorev_main_layout' ) ) :
	function vidorev_main_layout(){
		global $main_layout;
		
		if(isset($main_layout) && $main_layout!=''){
			return $main_layout;
		}
		
		$main_layout ='';
		
		if(is_page() || is_single()){
			$main_layout = get_post_meta(get_the_ID(), 'main_layout', true);
		}
		
		if($main_layout ==''){
			$main_layout = vidorev_get_redux_option('main_layout', 'wide');
		}
	
		return $main_layout;
	}
endif;

if ( ! function_exists( 'vidorev_full_width_mode' ) ) :
	function vidorev_full_width_mode(){
		global $main_layout_full_with;
		
		if(isset($main_layout_full_with) && $main_layout_full_with!=''){
			return $main_layout_full_with;
		}
		
		$main_layout_full_with = '';
		
		if(is_page() || is_single()){
			$main_layout_full_with = get_post_meta(get_the_ID(), 'main_layout_full_with', true);
		}
		
		if($main_layout_full_with ==''){
			$main_layout_full_with = vidorev_get_redux_option('main_layout_full_with', 'off', 'switch');
		}
		
		$main_layout = vidorev_main_layout();
		
		if($main_layout_full_with=='on' && $main_layout=='wide'){
			$main_layout_full_with = 'on';
		}else{
			$main_layout_full_with = 'off';
		}
		
		return $main_layout_full_with;
	}
endif;

if ( ! function_exists( 'vidorev_single_video_style' ) ) :
	function vidorev_single_video_style(){
		global $vidorev_single_video_style;
		
		if(isset($vidorev_single_video_style) && $vidorev_single_video_style!=''){
			return $vidorev_single_video_style;
		}
		
		$vidorev_single_video_style = '';
		
		if(is_single() && get_post_format() == 'video'){
			$vidorev_single_video_style = get_post_meta(get_the_ID(), 'single_video_style', true);
			if($vidorev_single_video_style == ''){
				$vidorev_single_video_style = vidorev_get_redux_option('single_video_style', 'basic');
			}
		}
		
		return $vidorev_single_video_style;
	}
endif;

if ( ! function_exists( 'vidorev_channel_replace_category' ) ) :
	function vidorev_channel_replace_category(){
		global $channel_replace_category;
		
		if(isset($channel_replace_category) && $channel_replace_category!=''){
			return $channel_replace_category;
		}
		
		$channel_replace_category = vidorev_get_option('vid_channel_replate_cat', 'vid_channel_layout_settings', 'off');
		
		return $channel_replace_category;
	}
endif;

if ( ! function_exists( 'vidorev_header_style' ) ) :
	function vidorev_header_style(){
		global $header_style;
		
		if(isset($header_style) && $header_style!=''){
			return $header_style;
		}
		
		$header_style ='';
		
		if(is_page() || is_single()){
			$header_style = get_post_meta(get_the_ID(), 'main_nav_layout', true);
		}
		
		if($header_style ==''){
			$header_style = vidorev_get_redux_option('main_nav_layout', 'default');
		}
	
		return $header_style;
	}
endif;

if ( ! function_exists( 'vidorev_ajax_search' ) ) :
	function vidorev_ajax_search(){
		global $beeteam368_ajax_search;
		
		if(isset($beeteam368_ajax_search) && $beeteam368_ajax_search!=''){
			return $beeteam368_ajax_search;
		}
		
		$beeteam368_ajax_search ='';
		
		if(is_page()){
			$beeteam368_ajax_search = get_post_meta(get_the_ID(), 'ajax_search', true);
		}
		
		if($beeteam368_ajax_search ==''){
			$beeteam368_ajax_search = vidorev_get_redux_option('ajax_search', 'off', 'switch');
		}
		
		if(!class_exists('WD_ASL_Globals')){
			$beeteam368_ajax_search = 'off';
		}
	
		return $beeteam368_ajax_search;
	}
endif;

if ( ! function_exists( 'vidorev_sidebar_control' ) ) :
	function vidorev_sidebar_control(){
		global $sidebarControl;
		
		if(isset($sidebarControl) && $sidebarControl!=''){
			return $sidebarControl;
		}
		
		$sidebarControl ='';
		
		if(is_archive()){
			if(is_post_type_archive('vid_playlist') || is_tax('vid_playlist_cat')){
				$sidebarControl = vidorev_get_option('vid_playlist_listing_sidebar', 'vid_playlist_layout_settings', '');
			}elseif(is_post_type_archive('vid_channel') || is_tax('vid_channel_cat')){
				$sidebarControl = vidorev_get_option('vid_channel_listing_sidebar', 'vid_channel_layout_settings', '');
			}elseif(is_post_type_archive('vid_actor') || is_tax('vid_actor_cat')){
				$sidebarControl = vidorev_get_option('vid_actor_listing_sidebar', 'vid_actor_layout_settings', '');
			}elseif(is_post_type_archive('vid_director') || is_tax('vid_director_cat')){
				$sidebarControl = vidorev_get_option('vid_director_listing_sidebar', 'vid_director_layout_settings', '');
			}elseif(is_post_type_archive('vid_series') || is_tax('vid_series_cat')){
				$sidebarControl = vidorev_get_option('vid_series_listing_sidebar', 'vid_series_layout_settings', '');
			}elseif(is_author()){
				$sidebarControl = vidorev_get_redux_option('author_sidebar', '');
			}elseif(is_category()){
				if(defined('CATEGORY_PM_PREFIX')){				
					$category 		= get_category( get_query_var( 'cat' ) );
					$cat_id 		= $category->cat_ID;				
					$sidebarControl = get_metadata('term', $cat_id, CATEGORY_PM_PREFIX.'cate_sidebar', true);
				}
			}			
			if($sidebarControl == ''){
				$sidebarControl = vidorev_get_redux_option('archive_sidebar', '');
			}
		}elseif(is_tax()){
			if(is_tax('vid_playlist_cat')){
				$sidebarControl = vidorev_get_option('vid_playlist_listing_sidebar', 'vid_playlist_layout_settings', '');
			}elseif(is_tax('vid_channel_cat')){
				$sidebarControl = vidorev_get_option('vid_channel_listing_sidebar', 'vid_channel_layout_settings', '');
			}elseif(is_tax('vid_actor_cat')){
				$sidebarControl = vidorev_get_option('vid_actor_listing_sidebar', 'vid_actor_layout_settings', '');
			}elseif(is_tax('vid_director_cat')){
				$sidebarControl = vidorev_get_option('vid_director_listing_sidebar', 'vid_director_layout_settings', '');
			}elseif(is_tax('vid_series_cat')){
				$sidebarControl = vidorev_get_option('vid_series_listing_sidebar', 'vid_series_layout_settings', '');
			}		
			if($sidebarControl == ''){
				$sidebarControl = vidorev_get_redux_option('archive_sidebar', '');
			}
		}elseif(is_page()){
			$page_id = get_the_ID();
			if(is_page_template('template/archive-playlist.php')){
				$sidebarControl = vidorev_get_option('vid_playlist_listing_sidebar', 'vid_playlist_layout_settings', '');
			}elseif(is_page_template('template/archive-channel.php')){
				$sidebarControl = vidorev_get_option('vid_channel_listing_sidebar', 'vid_channel_layout_settings', '');
			}elseif(is_page_template('template/archive-actor.php')){
				$sidebarControl = vidorev_get_option('vid_actor_listing_sidebar', 'vid_actor_layout_settings', '');
			}elseif(is_page_template('template/archive-director.php')){
				$sidebarControl = vidorev_get_option('vid_director_listing_sidebar', 'vid_director_layout_settings', '');	
			}elseif(is_page_template('template/archive-series.php')){
				$sidebarControl = vidorev_get_option('vid_series_listing_sidebar', 'vid_series_layout_settings', '');	
			}elseif($page_id == vidorev_get_redux_option('watch_page', '')){
				$sidebarControl = vidorev_get_redux_option('watch_sidebar', '');
			}elseif(defined('CHANNEL_PM_PREFIX') && vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')=='yes' && $page_id == vidorev_get_option('vid_channel_subscribed_page', 'vid_channel_subscribe_settings', '')){
				$sidebarControl = vidorev_get_option('vid_channel_subscribed_sidebar', 'vid_channel_subscribe_settings', '');
			}elseif(defined('CHANNEL_PM_PREFIX') && vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')=='yes' && vidorev_get_option('vid_channel_notifications_fnc', 'vid_channel_notifications_settings', 'yes')=='yes' && $page_id == vidorev_get_option('vid_channel_notifications_page', 'vid_channel_notifications_settings', '')){
				$sidebarControl = vidorev_get_option('vid_channel_notifications_sidebar', 'vid_channel_notifications_settings', '');				
			}else{
				$sidebarControl = get_post_meta($page_id, 'theme_sidebar', true);
			}
			
			if($sidebarControl == ''){
				$sidebarControl = vidorev_get_redux_option('single_page_sidebar', '');
			}
		}elseif(is_single()){			
			if(is_singular('vid_playlist')){
				$sidebarControl = vidorev_get_option('vid_single_playlist_sidebar', 'vid_playlist_layout_settings', '');
			}elseif(is_singular('vid_channel')){
				$sidebarControl = vidorev_get_option('vid_single_channel_sidebar', 'vid_channel_layout_settings', '');
			}elseif(is_singular('vid_actor')){
				$sidebarControl = vidorev_get_option('vid_single_actor_sidebar', 'vid_actor_layout_settings', '');
			}elseif(is_singular('vid_director')){
				$sidebarControl = vidorev_get_option('vid_single_director_sidebar', 'vid_director_layout_settings', '');
			}elseif(is_singular('vid_series')){
				$sidebarControl = vidorev_get_option('vid_single_series_sidebar', 'vid_series_layout_settings', '');
			}else{
				$sidebarControl = get_post_meta(get_the_ID(), 'theme_sidebar', true);		
			}
			
			if($sidebarControl == ''){
				$sidebarControl = vidorev_get_redux_option('single_post_sidebar', '');
			}
		}elseif(is_search()){
			$sidebarControl = vidorev_get_redux_option('search_sidebar', '');
		}
		
		if($sidebarControl ==''){
			$sidebarControl = vidorev_get_redux_option('theme_sidebar', 'right');
		}
		
		if(function_exists('is_bbpress') && is_bbpress()){
			$sidebarControl = vidorev_get_redux_option('bbpress_sidebar', 'right');
		}
		
		if(function_exists('is_woocommerce') && is_woocommerce()){
			$sidebarControl = vidorev_get_redux_option('woo_sidebar', 'right');
		}
	
		return $sidebarControl;
	}
endif;	

if ( ! function_exists( 'vidorev_instagram_feed_control' ) ) :
	function vidorev_instagram_feed_control(){
		global $instagramFeedControl;
		
		if(isset($instagramFeedControl) && $instagramFeedControl!=''){
			return $instagramFeedControl;
		}
		
		$instagramFeedControl ='';
		
		if(is_page()){
			$page_id = get_the_ID();
			
			$page_instagram = get_post_meta($page_id, 'instagram_feed', true);	
			if($page_instagram!=''){				
				$instagramFeedControl = array($page_instagram, get_post_meta($page_id, 'instagram_feed_position', true));
			}
		}
		
		if($instagramFeedControl == ''){
			$instagramFeedControl = array(vidorev_get_redux_option('instagram_feed', 'off', 'switch'), vidorev_get_redux_option('instagram_feed_position', 'header'));
		}
	
		return $instagramFeedControl;
	}
endif;	


if ( ! function_exists( 'vidorev_category_element_template' ) ) :
	function vidorev_category_element_template(){
		global $category_element_template;
		if(isset($category_element_template)){			
			return $category_element_template;
		}	
		
		$page_id 			= get_the_ID();	
		$category_element_template = get_post_meta($page_id, 'blog_show_categories', true);
		
		return $category_element_template;
	}
endif;

if ( ! function_exists( 'vidorev_excerpt_element_template' ) ) :
	function vidorev_excerpt_element_template(){
		global $excerpt_element_template;
		if(isset($excerpt_element_template)){			
			return $excerpt_element_template;
		}	
		
		$page_id 			= get_the_ID();	
		$excerpt_element_template = get_post_meta($page_id, 'blog_show_excerpt', true);
		
		return $excerpt_element_template;
	}
endif;

if ( ! function_exists( 'vidorev_post_meta_control_template' ) ) :
	function vidorev_post_meta_control_template(){
		global $archiveMetaControl;
		if(isset($archiveMetaControl) && is_array($archiveMetaControl) && count($archiveMetaControl)>0){			
			return $archiveMetaControl;
		}
		
		$archiveMetaControl = array();
		$page_id 			= get_the_ID();
		
		$blog_show_author 			= get_post_meta($page_id, 'blog_show_author', true);
		$blog_show_date 			= get_post_meta($page_id, 'blog_show_date', true);
		$blog_show_comment_count 	= get_post_meta($page_id, 'blog_show_comment_count', true);
		$blog_show_view_count 		= get_post_meta($page_id, 'blog_show_view_count', true);
		$blog_show_like_count 		= get_post_meta($page_id, 'blog_show_like_count', true);
		$blog_show_dislike_count 	= get_post_meta($page_id, 'blog_show_dislike_count', true);
		
		array_push(
			$archiveMetaControl, 
			($blog_show_author=='on'?'author':''),
			($blog_show_date=='on'?'date-time':''),
			($blog_show_comment_count=='on'?'comment-count':''),
			($blog_show_view_count=='on'?'view-count':''),
			($blog_show_like_count=='on'?'like-count':''),
			($blog_show_dislike_count=='on'?'dislike-count':'')
		);
		
		return $archiveMetaControl;
	}
endif;

if ( ! function_exists( 'vidorev_post_meta_control' ) ) :
	function vidorev_post_meta_control($type){
		global $archiveMetaControl;
		global $singleMetaControl;		
		global $postMetaControl;
		
		switch($type){
			case 'archive':
				
				if(isset($archiveMetaControl) && is_array($archiveMetaControl) && count($archiveMetaControl)>0){			
					return $archiveMetaControl;
				}
				
				$archiveMetaControl = array();
				
				$blog_show_author 			= vidorev_get_redux_option('blog_show_author', 'on', 'switch');
				$blog_show_date 			= vidorev_get_redux_option('blog_show_date', 'on', 'switch');
				$blog_show_comment_count 	= vidorev_get_redux_option('blog_show_comment_count', 'on', 'switch');
				$blog_show_view_count 		= vidorev_get_redux_option('blog_show_view_count', 'on', 'switch');
				$blog_show_like_count 		= vidorev_get_redux_option('blog_show_like_count', 'on', 'switch');
				$blog_show_dislike_count 	= vidorev_get_redux_option('blog_show_dislike_count', 'on', 'switch');
				$blog_show_updated_date		= vidorev_get_redux_option('blog_show_updated_date', 'off', 'switch');
				
				array_push(
					$archiveMetaControl, 
					($blog_show_author=='on'?'author':''),
					($blog_show_date=='on'?'date-time':''),
					($blog_show_comment_count=='on'?'comment-count':''),
					($blog_show_view_count=='on'?'view-count':''),
					($blog_show_like_count=='on'?'like-count':''),
					($blog_show_dislike_count=='on'?'dislike-count':''),
					($blog_show_updated_date=='on'?'updated-date':'')
				);
				
				return $archiveMetaControl;
				
				break;
			
			case 'single':
				if(isset($singleMetaControl) && is_array($singleMetaControl) && count($singleMetaControl)>0){			
					return $singleMetaControl;
				}
				
				$singleMetaControl = array();
			
				$post_format = get_post_format();
				
				if($post_format=='video'){
					$single_video_show_author 			= vidorev_get_redux_option('single_video_show_author', 'on', 'switch');
					$single_video_show_date 			= vidorev_get_redux_option('single_video_show_date', 'on', 'switch');
					$single_video_show_comment_count 	= vidorev_get_redux_option('single_video_show_comment_count', 'on', 'switch');
					$single_video_show_view_count 		= vidorev_get_redux_option('single_video_show_view_count', 'on', 'switch');
					$single_video_show_like_count 		= vidorev_get_redux_option('single_video_show_like_count', 'on', 'switch');
					$single_video_show_dislike_count 	= vidorev_get_redux_option('single_video_show_dislike_count', 'on', 'switch');
					$single_video_show_updated_date		= vidorev_get_redux_option('single_video_show_updated_date', 'off', 'switch');
					
					array_push(
						$singleMetaControl, 
						($single_video_show_author=='on'?'author':''),
						($single_video_show_date=='on'?'date-time':''),
						($single_video_show_comment_count=='on'?'comment-count':''),
						($single_video_show_view_count=='on'?'view-count':''),
						($single_video_show_like_count=='on'?'like-count':''),
						($single_video_show_dislike_count=='on'?'dislike-count':''),
						($single_video_show_updated_date=='on'?'updated-date':'')
					);
					
					return $singleMetaControl;
					
				}else{
					$single_post_show_author 			= vidorev_get_redux_option('single_post_show_author', 'on', 'switch');
					$single_post_show_date 				= vidorev_get_redux_option('single_post_show_date', 'on', 'switch');
					$single_post_show_comment_count 	= vidorev_get_redux_option('single_post_show_comment_count', 'on', 'switch');
					$single_post_show_view_count 		= vidorev_get_redux_option('single_post_show_view_count', 'on', 'switch');
					$single_post_show_like_count 		= vidorev_get_redux_option('single_post_show_like_count', 'on', 'switch');
					$single_post_show_dislike_count 	= vidorev_get_redux_option('single_post_show_dislike_count', 'on', 'switch');
					$single_post_show_updated_date		= vidorev_get_redux_option('single_post_show_updated_date', 'off', 'switch');
					
					array_push(
						$singleMetaControl, 
						($single_post_show_author=='on'?'author':''),
						($single_post_show_date=='on'?'date-time':''),
						($single_post_show_comment_count=='on'?'comment-count':''),
						($single_post_show_view_count=='on'?'view-count':''),
						($single_post_show_like_count=='on'?'like-count':''),
						($single_post_show_dislike_count=='on'?'dislike-count':''),
						($single_post_show_updated_date=='on'?'updated-date':'')
					);
					
					return $singleMetaControl;
				}
				break;	
		}
		
		if(isset($postMetaControl) && is_array($postMetaControl) && count($postMetaControl)>0){			
			return $postMetaControl;
		}
		
		$postMetaControl = array();	
		
		if(count($postMetaControl)==0){			
			$postMetaControl = array('author', 'date-time', 'comment-count', 'view-count', 'like-count', 'dislike-count');
		}
		
		return $postMetaControl;
	}
endif;

if ( ! function_exists( 'vidorev_categories_control' ) ) :
	function vidorev_categories_control($type){
		global $archiveCategoriesControl;
		global $singleCategoriesControl;		
		global $postCategoriesControl;
		
		switch($type){
			case 'archive':	
				if(isset($archiveCategoriesControl) && $archiveCategoriesControl!=''){			
					return $archiveCategoriesControl;
				}			
				
				$archiveCategoriesControl = vidorev_get_redux_option('blog_show_categories', 'on', 'switch');
				
				return $archiveCategoriesControl;
				
				break;
			
			case 'single':	
				
				if(isset($singleCategoriesControl) && $singleCategoriesControl!=''){			
					return $singleCategoriesControl;
				}			
			
				$post_format = get_post_format();
				
				if($post_format=='video'){				
					
					$singleCategoriesControl = vidorev_get_redux_option('single_video_show_categories', 'off', 'switch');
					
					return $singleCategoriesControl;
					
				}else{					
					
					$singleCategoriesControl = vidorev_get_redux_option('single_post_show_categories', 'off', 'switch');
					
					return $singleCategoriesControl;
				}
				break;	
		}
		
		if(isset($postCategoriesControl) && $postCategoriesControl!=''){		
			return $postCategoriesControl;
		}
		
		$postCategoriesControl = 'on';
		
		return $postCategoriesControl;
	}
endif;

if ( ! function_exists( 'vidorev_body_class_control' ) ) :
	function vidorev_body_class_control( $classes ) {
		
		$extra_class = '';
		
		$color_mode = '';
		if(is_page()){
			$page_id = get_the_ID();			
			$color_mode = get_post_meta($page_id, 'color_mode', true);				
		}
		
		if(function_exists('is_woocommerce') && is_woocommerce()){
			$color_mode = vidorev_get_redux_option('woo_color_mode', '');
		}
				
		if($color_mode==''){				
			$color_mode = vidorev_get_redux_option('color_mode', 'white');
		}				
		if ( $color_mode == 'dark' ) {			
			$color_mode_clss_string = ' dark-background dark-version';	
			
			if(function_exists('bp_current_component') && bp_current_component()){
				$color_mode_clss_string = ' yz-bd-dack-background';
			}		
			
			$extra_class.= $color_mode_clss_string;
		}
		
		$sticky_menu = vidorev_get_redux_option('sticky_menu', 'off', 'switch');
		if ( $sticky_menu == 'on' ) {
			$extra_class.= ' sticky-menu-on';
			
			$sticky_menu_behavior = vidorev_get_redux_option('sticky_menu_behavior', 'scroll_up');
			if ( $sticky_menu_behavior == 'scroll_up' ) {
				$extra_class.= ' sticky-behavior-up';
			}
		}
		
		$sticky_sidebar = vidorev_get_redux_option('sticky_sidebar', 'off', 'switch');
		if ( $sticky_sidebar == 'on' ) {
			$extra_class.= ' sticky-sidebar-on';
		}
		
		$main_layout = vidorev_main_layout();
		if ( $main_layout == 'boxed' ) {
			$extra_class.= ' main-layout-boxed';
		}
		
		$sidebarControl = vidorev_sidebar_control();		
		if( $sidebarControl != 'hidden' ){
			$extra_class.= ' is-sidebar sidebar-'.$sidebarControl;
		}
		
		$float_player = vidorev_get_redux_option('float_player', 'off', 'switch');
		if($float_player == 'off'){
			$extra_class.= ' disable-floating-video';
		}
		
		if(isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!=''){
			$extra_class.= ' active-alphabet-filter';
		}
		
		if(vidorev_get_redux_option('right_to_left', 'off', 'switch') == 'on'){
			$extra_class.= ' rtl';
		}				
		
		$extra_class.= ' header-vid-'.vidorev_header_style();
		
		if(beeteam368_return_embed()){
			$extra_class.= ' embed-player-container';
			if(isset($_GET['preview_mode']) && is_numeric($_GET['preview_mode']) && $_GET['preview_mode'] == 1){
				$extra_class.= ' preview-hide-player-controlbar';
			}
		}
		
		$vidorev_full_width_mode = vidorev_full_width_mode();
		if($vidorev_full_width_mode == 'on'){
			$extra_class.= ' fullwidth-mode-enable';
		}
		
		if(vidorev_single_video_style()=='clean'){
			$extra_class.= ' single-video-clean-style';
		}
		
		if(isset($_COOKIE['vidorevsidemenustatus']) && $_COOKIE['vidorevsidemenustatus'] == 'close'){			
			$extra_class.= ' close-side-menu';			
		}
		
		$extra_class.= ' beeteam368';
		
		if(defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, '3.0.0', '>=') ){
			$optimized_dom_output 			= get_option( 'elementor_optimized_dom_output' );
			$element_wrappers_legacy_mode 	= false;
			if ( $optimized_dom_output ) {
				$element_wrappers_legacy_mode = 'enabled' === $optimized_dom_output;
			}
			
			if($element_wrappers_legacy_mode){
				$extra_class.= ' elementor-three-x-version';
			}
		}		
		
		$classes[] = $extra_class;
		
		return $classes;
	}	
endif;
add_filter( 'body_class', 'vidorev_body_class_control' );

if ( ! function_exists( 'vidorev_archive_style' ) ) :
	function vidorev_archive_style(){
		global $archive_style;
		
		if(isset($archive_style) && $archive_style!=''){
			return $archive_style;
		}
		
		$archive_style ='';
		
		if(is_post_type_archive('vid_playlist') || is_tax('vid_playlist_cat')){
			$archive_style = vidorev_get_option('vid_playlist_layout', 'vid_playlist_layout_settings', '');
			
		}elseif(is_post_type_archive('vid_channel') || is_tax('vid_channel_cat')){
			$archive_style = vidorev_get_option('vid_channel_layout', 'vid_channel_layout_settings', '');
			
		}elseif(is_post_type_archive('vid_actor') || is_tax('vid_actor_cat')){
			$archive_style = vidorev_get_option('vid_actor_layout', 'vid_actor_layout_settings', 'movie-grid');
			
		}elseif(is_post_type_archive('vid_director') || is_tax('vid_director_cat')){
			$archive_style = vidorev_get_option('vid_director_layout', 'vid_director_layout_settings', 'movie-grid');
				
		}elseif(is_post_type_archive('vid_series') || is_tax('vid_series_cat')){
			$archive_style = vidorev_get_option('vid_series_layout', 'vid_series_layout_settings', '');
				
		}elseif(is_singular('vid_playlist')){
			$archive_style = vidorev_get_option('vid_single_playlist_layout', 'vid_playlist_layout_settings', '');
		
		}elseif(is_singular('vid_channel')){
			$archive_style = vidorev_get_option('vid_single_channel_layout', 'vid_channel_layout_settings', '');
			
			if(isset($_GET['channel_tab'])){
				$channel_tab = sanitize_text_field(trim($_GET['channel_tab']));
				switch($channel_tab){
					case 'playlist':
						$archive_style = vidorev_get_option('vid_single_channel_playlist_layout', 'vid_channel_layout_settings', '');
						break;
					case 'series':
						$archive_style = vidorev_get_option('vid_single_channel_series_layout', 'vid_channel_layout_settings', '');
						break;	
				}
			}
		
		}elseif(is_singular('vid_actor')){
			$archive_style = vidorev_get_option('vid_single_actor_layout', 'vid_actor_layout_settings', '');
		
		}elseif(is_singular('vid_director')){
			$archive_style = vidorev_get_option('vid_single_director_layout', 'vid_director_layout_settings', '');
			
		}elseif(is_singular('vid_series')){
			$archive_style = vidorev_get_option('vid_single_series_layout', 'vid_series_layout_settings', '');
		
		}elseif(is_numeric(vidorev_get_redux_option('watch_page', '')) && is_page(vidorev_get_redux_option('watch_page', ''))){
			$archive_style = vidorev_get_redux_option('watch_loop_style', 'list-blog');
			
		}elseif(defined('CHANNEL_PM_PREFIX') && vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')=='yes' && is_numeric(vidorev_get_option('vid_channel_subscribed_page', 'vid_channel_subscribe_settings', '')) && is_page(vidorev_get_option('vid_channel_subscribed_page', 'vid_channel_subscribe_settings', ''))){
			$archive_style = vidorev_get_option('vid_channel_subscribed_layout', 'vid_channel_subscribe_settings', '');
		
		}elseif(defined('CHANNEL_PM_PREFIX') && vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')=='yes' && vidorev_get_option('vid_channel_notifications_fnc', 'vid_channel_notifications_settings', 'yes')=='yes' && is_numeric(vidorev_get_option('vid_channel_notifications_page', 'vid_channel_notifications_settings', '')) && is_page(vidorev_get_option('vid_channel_notifications_page', 'vid_channel_notifications_settings', ''))){
			$archive_style = vidorev_get_option('vid_channel_notifications_layout', 'vid_channel_notifications_settings', '');
			
		}elseif(is_page_template('template/blog-page-template.php')){
			$archive_style =  get_post_meta(get_the_ID(), 'archive_loop_style', true);	
			
		}elseif(is_search()){
			$archive_style = vidorev_get_redux_option('search_loop_style', 'list-blog');
						
		}elseif(is_author()){
			$archive_style = vidorev_get_redux_option('author_loop_style', 'list-blog');
			
		}elseif(is_category()){			
			if(defined('CATEGORY_PM_PREFIX')){				
				$category 		= get_category( get_query_var( 'cat' ) );
				$cat_id 		= $category->cat_ID;				
				$archive_style 	= get_metadata('term', $cat_id, CATEGORY_PM_PREFIX.'category_layout', true);
			}			
			
		}	
		
		if($archive_style == ''){
			$archive_style = vidorev_get_redux_option('archive_loop_style', 'list-blog');
		}
		
		if(isset($_GET['archive_style'])){
			$style_pr = sanitize_text_field(trim($_GET['archive_style']));
			if($style_pr!=''){
				$archive_style = $style_pr;
			}
		}
	
		return $archive_style;
	}
endif;


if ( ! function_exists( 'vidorev_single_style' ) ) :
	function vidorev_single_style(){
		if(!is_single() || post_password_required()){
			return '';
		}
		
		global $single_style;
		
		if(isset($single_style) && $single_style!=''){
			return $single_style;
		}
		
		$single_style ='';
		
		$post_format = get_post_format();
		
		switch($post_format){
			case '0':
				$single_style = get_post_meta(get_the_ID(), 'feature_image_position', true);
				break;
				
			case 'video':
				$single_style = get_post_meta(get_the_ID(), 'video_player_position', true);
				break;
				
			case 'gallery':
				$single_style = get_post_meta(get_the_ID(), 'gallery_position', true);
				break;	
				
			case 'quote':
				$single_style = get_post_meta(get_the_ID(), 'quote_position', true);
				break;
		}

		
		if($single_style == ''){
			switch($post_format){
				case '0':
					$single_style = vidorev_get_redux_option('feature_image_position', 'special');
					break;
					
				case 'video':
					$single_style = vidorev_get_redux_option('video_player_position', 'basic');
					break;				
					
				case 'gallery':
					$single_style = vidorev_get_redux_option('gallery_position', 'basic');
					break;	
					
				case 'quote':
					$single_style = vidorev_get_redux_option('quote_position', 'basic');
					break;
					
				default:
					$single_style = 'basic';
			}
		}
		
		if(beeteam368_return_embed()){
			$single_style = 'full-width';
		}
	
		return $single_style;
	}
endif;

if(!function_exists('vidorev_detech_player_library')){
	function vidorev_detech_player_library($sc_post_id=0){
		
		if(is_numeric($sc_post_id) && $sc_post_id>0){
			$player_library_sc = '';
			$player_library_sc = get_post_meta($sc_post_id, 'video_player_library', true);
			if($player_library_sc == ''){
				$player_library_sc = vidorev_get_redux_option('video_player_library', 'vp');
			}
			return $player_library_sc;
		}
		
		global $player_library;
		
		if(isset($player_library) && $player_library!=''){
			return $player_library;
		}
		
		$player_library = '';
		
		if(is_single() && get_post_type()=='post' && get_post_format()=='video'){
			$player_library 	= get_post_meta(get_the_ID(), 'video_player_library', true);
		}
		
		if($player_library == ''){
			$player_library = vidorev_get_redux_option('video_player_library', 'vp');
		}
		
		return $player_library;
	}	
}

if(!function_exists('vidorev_detech_player_plyr')){
	function vidorev_detech_player_plyr($sc_post_id=0){
		
		if(is_numeric($sc_post_id) && $sc_post_id>0){
			$player_plyr_sc = '';
			$player_plyr_sc = get_post_meta($sc_post_id, 'plyr_player', true);
			if($player_plyr_sc == ''){
				$player_plyr_sc = vidorev_get_redux_option('plyr_player', 'off', 'switch');
			}
			return $player_plyr_sc;
		}
		
		global $player_plyr_library;
		
		if(isset($player_plyr_library) && $player_plyr_library!=''){
			return $player_plyr_library;
		}
		
		$player_plyr_library = '';
		
		if(is_single() && get_post_type()=='post' && get_post_format()=='video'){
			$player_plyr_library 	= get_post_meta(get_the_ID(), 'plyr_player', true);
		}
		
		if($player_plyr_library == ''){
			$player_plyr_library = vidorev_get_redux_option('plyr_player', 'off', 'switch');
		}
		
		return $player_plyr_library;
		
	}	
}

if(!function_exists('vidorev_detech_comment_type')){
	function vidorev_detech_comment_type(){
		global $vidorev_comment_type;
		
		if(isset($vidorev_comment_type) && $vidorev_comment_type!=''){
			return $vidorev_comment_type;
		}
		
		$vidorev_comment_type = '';
		
		if(is_single()){
			$vidorev_comment_type 	= trim(get_post_meta(get_the_ID(), 'single_post_comment_type', true));
		}
		
		if($vidorev_comment_type == ''){
			$vidorev_comment_type = trim(vidorev_get_redux_option('single_post_comment_type', 'wp'));
		}
		
		return $vidorev_comment_type;
	}	
}

if( ! function_exists('vidorev_get_adjacent_video_by_id') ) :
	function vidorev_get_adjacent_video_by_id( $post_id, $prev = false, $single_btn = false ) {
		
		if($single_btn && defined('PLAYLIST_PM_PREFIX') && isset($_GET['playlist']) && is_numeric($_GET['playlist'])){
			$playlist_id = $_GET['playlist'];
			
			$post_query = get_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', true);
			if(is_array($post_query) && count($post_query)>0){
				$post_query = array_values($post_query);
				$izc = array_search($post_id, $post_query);
				if($izc!==FALSE){
					
					if($prev){
						if($izc==0){
							return $post_query[count($post_query) - 1];
						}else{
							return $post_query[$izc - 1];
						}
					}
					
					if($izc==count($post_query) - 1){
						return $post_query[0];
					}else{
						return $post_query[$izc + 1];
					}
					
					return 0;
				}
			}
		
		}elseif($single_btn && isset($_GET['series']) && is_numeric($_GET['series'])){
			$series_id = $_GET['series'];
			
			$post_query = get_post_meta($series_id, 'video_series_group', true);
				if(is_array($post_query) && count($post_query)>0){
					
					$arr_videos_search = array();
					
					foreach($post_query as $group){
						if(isset($group['videos']) && is_array($group['videos']) && count($group['videos'])>0){							
							$arr_videos_search = array_merge($arr_videos_search, $group['videos']);
						}
					}
					
					$izc = array_search($post_id, $arr_videos_search);
					
					if($izc!==FALSE){				
						if($prev){
							if($izc==0){
								return $arr_videos_search[count($arr_videos_search) - 1];
							}else{
								return $arr_videos_search[$izc - 1];
							}
						}
						
						if($izc==count($arr_videos_search) - 1){
							return $arr_videos_search[0];
						}else{
							return $arr_videos_search[$izc + 1];
						}
						return 0;
					}
				}
		}
		
		$post_date = get_the_date('Y/m/d H:i:s', $post_id);
				
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> 1,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__not_in'			=> array($post_id),
			'tax_query' 			=> array(
										array(
											'taxonomy'  => 'post_format',
											'field'    	=> 'slug',
											'terms'     => array('post-format-video'),
											'operator'  => 'IN',
										),
									),	
			'order'					=> 'DESC',
			'orderby'				=> 'date ID',
			'date_query'			=> array(
				array(
					'before' 	=> $post_date,
				),				
			),													
		);
		
		if($prev){
			$args_query['order'] = 'ASC';
			$args_query['date_query'] = array(
				array(
					'after' 	=> $post_date,
				),				
			);
		}
		
		$videos = get_posts( $args_query );
		
		if( $videos ) {
			foreach ( $videos as $video):
				return $video->ID;
				break;
			endforeach;
		}else{
			
			unset($args_query['date_query']);
			
			$videos = get_posts( $args_query );
			if( $videos ) {
				foreach ( $videos as $video):
					return $video->ID;
					break;
				endforeach;
			}
		}
		
		return 0;
	}
endif;

if( ! function_exists('vidorev_get_player_params') ) :
	function vidorev_get_player_params($sc_post_id = 0) {
		
		if($sc_post_id > 0){
			$_POST['post_id'] = sanitize_text_field($sc_post_id);
		}
		
		if($sc_post_id == 0){
			$security = sanitize_text_field($_POST['security']);
			if(!vidorev_ajax_verify_nonce($security, false)){
				return;
				die();
			}
		}
		
		if(!isset($_POST['post_id'])){
			echo '';
			return;
		}	
				
		$post_id = sanitize_text_field(trim($_POST['post_id']));
		if(get_post_type($post_id)!='post' || wp_is_post_revision($post_id) || get_post_format($post_id)!='video'){
			echo '';
			return;
		}
		
		$vm_video_url = apply_filters( 'vidorev_single_video_url', trim(get_post_meta($post_id, 'vm_video_url', true)), $post_id );
		$vm_video_shortcode = apply_filters( 'vidorev_single_video_shortcode', trim(get_post_meta($post_id, 'vm_video_shortcode', true)), $post_id );
		
		if($vm_video_url=='' && $vm_video_shortcode==''){
			echo '';
			return;
		}
		
		$json_params = array();
		
		$json_params['single_video_network'] 				= vidorev_detech_video_data::getVideoNetwork($vm_video_url);	
		$json_params['single_video_source'] 				= vidorev_detech_video_data::getVideoID($vm_video_url);
		$json_params['single_video_youtube_playlist_id'] 	= vidorev_detech_video_data::getYoutubePlaylistID($vm_video_url);
		$json_params['single_video_url'] 					= $vm_video_url;
		$json_params['single_video_streaming'] 				= apply_filters( 'vidorev_single_video_streaming', trim(get_post_meta($post_id, 'video_streaming', true)), $post_id, $vm_video_url );
		
		$vm_video_ratio = trim(get_post_meta($post_id, 'vm_video_ratio', true));
		if($vm_video_ratio==''){
			$vm_video_ratio = '16:9';
		}			
		$json_params['vm_video_ratio'] = $vm_video_ratio;
		
		$vm_video_ratio_mobile = trim(get_post_meta($post_id, 'vm_video_ratio_mobile', true));
		if($vm_video_ratio_mobile==''){
			$vm_video_ratio_mobile = '16:9';
		}			
		$json_params['vm_video_ratio_mobile'] = $vm_video_ratio_mobile;
		
		$trdPartyPlayer 						= '';
		
		$img_background_cover = '';
		if(has_post_thumbnail($post_id) && $imgsource = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_16x9_3x')){
			$img_background_cover = $imgsource[0];
		}
		$json_params['poster_background'] = esc_url($img_background_cover);
		
		switch($json_params['single_video_network']){
			case 'embeded-code':
				$trdPartyPlayer = $vm_video_url;
				$json_params['single_video_embed'] 	= $trdPartyPlayer;
				break;
			
			case 'self-hosted':
				$poster = '';
				
				if($img_background_cover!=''){
					$poster = 'poster="'.$img_background_cover.'"';
				}
								
				$videos_format = array();
				$get_videos_html_format = explode(PHP_EOL, $vm_video_url);
				foreach($get_videos_html_format as $video_format){	
					if(trim($video_format) != ''){					
						$filetype = wp_check_filetype(trim($video_format));
						if(isset($filetype['ext'])&&( strtolower($filetype['ext']) == 'mp4' || strtolower($filetype['ext']) == 'm4v' || strtolower($filetype['ext']) == 'webm' || strtolower($filetype['ext']) == 'ogv' || strtolower($filetype['ext']) == 'wmv' || strtolower($filetype['ext']) == 'flv') ){
							$videos_format[strtolower($filetype['ext'])] = trim($video_format);
						}
					}
				}
				
				if(count($videos_format)>1){
					$shc_string = '';
					foreach($videos_format as $key => $value){
						$shc_string.= $key.'="'.esc_url($value).'" ';
					}					
					$trdPartyPlayer = do_shortcode('[video '.$shc_string.' '.$poster.']');
				}else{
					$trdPartyPlayer = do_shortcode('[video src="'.esc_url($vm_video_url).'" '.$poster.']');
					
					if(strpos($vm_video_url, '<video') === false){
						$trdPartyPlayer = '<div class="wp-video"><video src="'.esc_url($vm_video_url).'" class="wp-video-shortcode" preload="metadata" controls></video></div>';
					}
				}
				$json_params['single_video_wp_shortcode'] 	= $trdPartyPlayer;
				break;
				
			case 'drive':
				$poster = '';				
				
				if($img_background_cover!=''){
					$poster = 'poster="'.esc_url($img_background_cover).'"';
				}
				
				$google_api_key = trim(vidorev_get_redux_option('google_api_key', ''));
				$drive_file_id	= vidorev_detech_video_data::getVideoID($vm_video_url);
				$response 		= wp_remote_get('https://www.googleapis.com/drive/v2/files/'.$drive_file_id.'?key='.$google_api_key, array(	'timeout' => 368));
				
				$videos_format = '';
				
				if(is_wp_error($response)){
					$videos_format = '';
				}else {
					$result = json_decode($response['body']);
					if(isset($result->{'error'}) || !isset($result->{'videoMediaMetadata'})){
						$videos_format = '';
					}
				}
				
				$videos_format = isset($result->{'mimeType'})?$result->{'mimeType'}:'';
				$videos_size   = (isset($result->{'fileSize'})&&is_numeric($result->{'fileSize'}))?(int)$result->{'fileSize'}:0;
				$max_drive_size = apply_filters('vidorev_max_drive_size', 35000000);
				
				if($videos_format!='' && $videos_size < $max_drive_size){
					if(strpos($videos_format, 'mp4')){
						$trdPartyPlayer = do_shortcode('[video mp4="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.mp4" '.$poster.']');
					}elseif(strpos($videos_format, 'm4v')){
						$trdPartyPlayer = do_shortcode('[video m4v="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.m4v" '.$poster.']');
					}elseif(strpos($videos_format, 'webm')){
						$trdPartyPlayer = do_shortcode('[video webm="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.webm" '.$poster.']');						
					}elseif(strpos($videos_format, 'ogv')){
						$trdPartyPlayer = do_shortcode('[video ogv="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.ogv" '.$poster.']');
					}elseif(strpos($videos_format, 'wmv')){
						$trdPartyPlayer = do_shortcode('[video wmv="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.wmv" '.$poster.']');
					}elseif(strpos($videos_format, 'flv')){
						$trdPartyPlayer = do_shortcode('[video flv="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.flv" '.$poster.']');
					}else{
						$json_params['single_video_network'] 	= 'embeded-code';						
						$trdPartyPlayer 						= '<iframe src="https://drive.google.com/file/d/'.$drive_file_id.'/preview" width="640" height="480" frameborder="0" allowfullscreen="1" allow="autoplay; encrypted-media" wmode="Opaque"></iframe>';
						$json_params['single_video_embed'] 		= $trdPartyPlayer;
					}
				}else{
					$json_params['single_video_network'] 	= 'embeded-code';	
					$trdPartyPlayer 						= '<iframe src="https://drive.google.com/file/d/'.$drive_file_id.'/preview" width="640" height="480" frameborder="0" allowfullscreen="1" allow="autoplay; encrypted-media" wmode="Opaque"></iframe>';
					$json_params['single_video_embed'] 		= $trdPartyPlayer;
				}		
				
				$json_params['single_video_wp_shortcode'] 	= $trdPartyPlayer;			
				break;
		}
		
		if($vm_video_shortcode!=''){
			ob_start();
				echo do_shortcode($vm_video_shortcode);
				$vidorev_custom_player = ob_get_contents();
			ob_end_clean();
			if(isset($vidorev_custom_player) && $vidorev_custom_player!=''){
				$json_params['single_video_network'] 	= 'embeded-code';
				$json_params['single_video_embed']		= $vidorev_custom_player;
			}
		}
		
		/*video ads*/
		if(defined('VIDEOADS_PM_PREFIX')){
			$define_video_ads_object_post = array();
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'video_ads'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'video_ads', true));
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'video_ads_type'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'video_ads_type', true));
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_google_ima'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_google_ima', true);
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_image'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_image', true);
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html5_video'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_html5_video', true);
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_html', true);
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_dynamic'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_dynamic', true);
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'time_to_show_ads'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'time_to_show_ads', true));
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'time_skip_ads'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'time_skip_ads', true));
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'time_to_hide_ads'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'time_to_hide_ads', true));
			
			$fluidplayer = trim(vidorev_get_option(FLUIDPLAYER_PM_PREFIX.'fluidplayer', FLUIDPLAYER_PM_PREFIX.'fluidplayer_settings_page', 'yes'));
			if($fluidplayer == 'yes'){
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vpaid_mode'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vpaid_mode', true);
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vast_preroll'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vast_preroll', true);
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vast_postroll'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vast_postroll', true);
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vast_pauseroll'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vast_pauseroll', true);
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vast_midroll'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vast_midroll', true);
			}			
			
			$define_video_ads_object = get_option( VIDEOADS_PM_PREFIX.'videoads_settings_page', false );
			if(!is_array($define_video_ads_object)){
				$define_video_ads_object = array();
			}
			
			if($define_video_ads_object_post[VIDEOADS_PM_PREFIX.'video_ads_type'] == '' && isset($define_video_ads_object[VIDEOADS_PM_PREFIX.'video_ads_type'])){
				$define_video_ads_object_post = $define_video_ads_object;
			}
			
			if($define_video_ads_object_post[VIDEOADS_PM_PREFIX.'video_ads']=='' && isset($define_video_ads_object[VIDEOADS_PM_PREFIX.'video_ads'])){
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'video_ads'] = trim($define_video_ads_object[VIDEOADS_PM_PREFIX.'video_ads']);
			}
			
			$ads_author_id = get_post_field ('post_author', $post_id);
			if(is_numeric($ads_author_id)){
				$ads_author_arr = get_user_meta($ads_author_id, 'beeteam368_user_ads_settings', true );
				if(is_array($ads_author_arr) && isset($ads_author_arr['vid_ads_m_video_ads']) && $ads_author_arr['vid_ads_m_video_ads']=='yes'){
					if(isset($ads_author_arr['vid_ads_m_video_ads_type']) && $ads_author_arr['vid_ads_m_video_ads_type']!=''){
						
						$current_user 		= get_user_by('ID', $ads_author_id);						
						$user_submit_id 	= $ads_author_id;
						$user_membership_id = 0;
						
						if($current_user && function_exists('pmpro_getMembershipLevelForUser')){
							$current_user->membership_level = pmpro_getMembershipLevelForUser($ads_author_id);
						}
						
						if ( defined( 'PMPRO_VERSION' ) && isset($current_user->membership_level) && isset($current_user->membership_level->ID) && is_numeric($current_user->membership_level->ID)) {
							$user_membership_id = $current_user->membership_level->ID;
						}
						
						switch($ads_author_arr['vid_ads_m_video_ads_type']){							
							case 'google_ima':
								$ads_google_ima 		= vidorev_get_option('google_ima', 'user_ads_settings', array('free'=>'free'));
								$ads_google_ima_status 	= 'free';
								if(is_array($ads_google_ima)){
									if(array_search('free', $ads_google_ima) !== FALSE){
										$ads_google_ima_status = 'free';
									}else{
										if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_google_ima) !== FALSE){
											$ads_google_ima_status = 'enable_by_membership';
										}else{
											$ads_google_ima_status = 'disable_by_membership';
										}
									}
								}else{
									$ads_google_ima_status = 'disable';
								}
								
								if($ads_google_ima_status == 'free' || $ads_google_ima_status == 'enable_by_membership'){
									$define_video_ads_object_post = $ads_author_arr;
								}
								
								break;
								
							case 'image':
								$ads_image 			= vidorev_get_option('image', 'user_ads_settings', array('free'=>'free'));
								$ads_image_status = 'free';
								if(is_array($ads_image)){
									if(array_search('free', $ads_image) !== FALSE){
										$ads_image_status = 'free';
									}else{
										if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_image) !== FALSE){
											$ads_image_status = 'enable_by_membership';
										}else{
											$ads_image_status = 'disable_by_membership';
										}
									}
								}else{
									$ads_image_status = 'disable';
								}
								
								if($ads_image_status == 'free' || $ads_image_status == 'enable_by_membership'){
									$define_video_ads_object_post = $ads_author_arr;
								}
								
								break;
								
							case 'html5_video':
								$ads_html5_video 	= vidorev_get_option('html5_video', 'user_ads_settings', array('free'=>'free'));
								$ads_html5_video_status = 'free';
								if(is_array($ads_html5_video)){
									if(array_search('free', $ads_html5_video) !== FALSE){
										$ads_html5_video_status = 'free';
									}else{
										if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_html5_video) !== FALSE){
											$ads_html5_video_status = 'enable_by_membership';
										}else{
											$ads_html5_video_status = 'disable_by_membership';
										}
									}
								}else{
									$ads_html5_video_status = 'disable';
								}
								
								if($ads_html5_video_status == 'free' || $ads_html5_video_status == 'enable_by_membership'){
									$define_video_ads_object_post = $ads_author_arr;
								}
								
								break;
								
							case 'html':
								$ads_google_adsense = vidorev_get_option('google_adsense', 'user_ads_settings', array('free'=>'free'));
								$ads_google_adsense_status = 'free';
								if(is_array($ads_google_adsense)){
									if(array_search('free', $ads_google_adsense) !== FALSE){
										$ads_google_adsense_status = 'free';
									}else{
										if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_google_adsense) !== FALSE){
											$ads_google_adsense_status = 'enable_by_membership';
										}else{
											$ads_google_adsense_status = 'disable_by_membership';
										}
									}
								}else{
									$ads_google_adsense_status = 'disable';
								}
								
								if($ads_google_adsense_status == 'free' || $ads_google_adsense_status == 'enable_by_membership'){
									$define_video_ads_object_post = $ads_author_arr;

								}
								
								break;
								
							case 'vast':
								$ads_vast 			= vidorev_get_option('vast', 'user_ads_settings', array('free'=>'free'));
								$ads_vast_status = 'free';
								if(is_array($ads_vast)){
									if(array_search('free', $ads_vast) !== FALSE){
										$ads_vast_status = 'free';
									}else{
										if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_vast) !== FALSE){
											$ads_vast_status = 'enable_by_membership';
										}else{
											$ads_vast_status = 'disable_by_membership';
										}
									}
								}else{
									$ads_vast_status = 'disable';
								}
								
								if($ads_vast_status == 'free' || $ads_vast_status == 'enable_by_membership'){
									$define_video_ads_object_post = $ads_author_arr;
								}
								
								break;				
						}
					}
				}
			}
			
			$json_params['vidorev_jav_plugin_video_ads_object_post'] = $define_video_ads_object_post;
		}
		/*video ads*/
		
		/*player library*/
			$tpl_player_library = get_post_meta($post_id, 'video_player_library', true);
			if($tpl_player_library == ''){
				$tpl_player_library = vidorev_get_redux_option('video_player_library', 'vp');
			}
			
			$json_params['player_library'] = apply_filters( 'vidorev_single_player_library', $tpl_player_library, $post_id, $vm_video_url );
			
			$json_params['plyr_player'] = get_post_meta($post_id, 'plyr_player', true);
			if($json_params['plyr_player'] == ''){
				$json_params['plyr_player'] = vidorev_get_redux_option('plyr_player', 'off', 'switch');
			}
		/*player library*/
		
		/*media sources*/
		$vm_media_sources = get_post_meta($post_id, 'vm_media_sources', true);			
		if(is_array($vm_media_sources)){
			$json_params['single_media_sources'] = get_post_meta($post_id, 'vm_media_sources', true);
		}
		/*media sources*/
		
		/*subtitles*/
		$vm_media_subtitles = get_post_meta($post_id, 'vm_media_subtitles', true);			
		if(is_array($vm_media_subtitles)){
			$json_params['single_media_subtitles'] = get_post_meta($post_id, 'vm_media_subtitles', true);
		}
		/*subtitles*/
		
		/*membership*/
		$json_params['membership'] = videorev_membership_locker('', $post_id);
		/*membership*/
		
		/*prime video*/
		$json_params['prime_video'] = videorev_prime_locker('', $post_id);
		/*prime video*/
		
		/*woo membership*/
		$json_params['woo_membership'] = beeteam368_woo_membership_locker('', $post_id);
		/*woo membership*/
		
		/*myCred sell*/
		$json_params['mycred_sell'] = vidorev_mycred_locker('', $post_id);
		/*myCred sell*/
		
		/*video title*/
		if(vidorev_get_redux_option('video_title', 'off', 'switch') == 'on'){
			$json_params['video_title'] = '<h4 class="h6-mobile post-title"><a href="'.esc_url(vidorev_get_post_url($post_id)).'">'.get_the_title($post_id).'</a><i class="fa fa-window-close close-title close-title-control" aria-hidden="true"></i></h4>';
		}
		/*video title*/
		
		/*suggested post*/
		if(vidorev_get_redux_option('video_lightbox_suggested', 'on', 'switch')=='on' && $sc_post_id == 0){
			$json_params['single_video_suggested'] = '';
			$video_lightbox_suggested_query = vidorev_get_redux_option('video_lightbox_suggested_query',  'same-category');
			$video_lightbox_suggested_order = vidorev_get_redux_option('video_lightbox_suggested_order',  'latest');
			$video_lightbox_suggested_count = vidorev_get_redux_option('video_lightbox_suggested_count',  '15');
			
			$next_video_id = 0;
			
			switch($video_lightbox_suggested_query){
				case 'same-playlist':
					if(defined('PLAYLIST_PM_PREFIX')){
						$playlist_id = beeteam368_get_playlist_by_post_id($post_id);
						$lightbox_arr_sp_qr = array(0);	
						if($playlist_id > 0){
							$lightbox_arr_query_sgu = get_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', true);
							if(is_array($lightbox_arr_query_sgu) && count($lightbox_arr_query_sgu)>0){
								$lightbox_arr_sp_qr = $lightbox_arr_query_sgu;
							}	
						}
					}
					break;
					
				case 'same-series':
					if(defined('VIDOREV_EXTENSIONS')){
						$series_id = beeteam368_get_series_by_post_id($post_id);
						$lightbox_arr_sp_qr = array(0);						
						if($series_id > 0){					
							$lightbox_arr_query_sgu = get_post_meta($series_id, 'video_series_group', true);
							if(is_array($lightbox_arr_query_sgu) && count($lightbox_arr_query_sgu)>0){						
								$lightbox_arr_sp_qr = array();								
								foreach($lightbox_arr_query_sgu as $group){
									if(isset($group['videos']) && is_array($group['videos']) && count($group['videos'])>0){							
										$lightbox_arr_sp_qr = array_merge($lightbox_arr_sp_qr, $group['videos']);										
									}
								}
							}
						}
						
					}
					break;
					
				case 'same-category':
					$next_video_id = vidorev_get_adjacent_video_by_id($post_id);
					break;
					
				case 'same-tag':
					$next_video_id = vidorev_get_adjacent_video_by_id($post_id);
					break;
				
				default:
					$next_video_id = vidorev_get_adjacent_video_by_id($post_id);				
			}
			
			$postNotIn = array($post_id);
			
			$nextVideoHTML = '';
			if($next_video_id > 0){
				$postNotIn = array($post_id, $next_video_id);
				ob_start();
				?>
				<div class="suggested-post-listing next-video-popup next-video-popup-action">
					<div class="video-listing-item">
						<div class="video-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_lightbox_image_big_size', 'vidorev_thumb_2point7x1_1x'), apply_filters('vidorev_custom_lightbox_image_big_ratio', 'class-2point7x1'), 3, $next_video_id);?></div>
						<div class="absolute-gradient"></div>
						<div class="video-content overlay-background">
							<span class="video-icon small-icon alway-active video-popup-control" data-id="<?php echo esc_attr($next_video_id);?>"></span>
							<div class="up-next-text font-size-12"><?php echo esc_html__('Up next', 'vidorev')?></div>
							<h3 class="h6 post-title"> 
								<a class="video-popup-control check-url-control" data-id="<?php echo esc_attr($next_video_id);?>" href="<?php echo esc_url(vidorev_get_post_url($next_video_id)); ?>" title="<?php echo esc_attr(get_the_title($next_video_id));?>"><?php echo get_the_title($next_video_id);?></a> 
							</h3>								
						</div>
					</div>
				</div>
				<?php
				$nextVideoHTML = ob_get_contents();
				ob_end_clean();
			}
			
			$suggested_query = array(
				'post_type'             => 'post',
				'post_status'           => 'publish',
				'posts_per_page'        => $video_lightbox_suggested_count,
				'ignore_sticky_posts'   => 1,
				'tax_query'				=> array(
					'relation' => 'AND',
					array(
						'taxonomy' 	=> 'post_format',
						'field' 	=> 'slug',
						'terms' 	=> array('post-format-video'),
						'operator' 	=> 'IN',
					)
				),
			);
			
			if(isset($lightbox_arr_sp_qr) && is_array($lightbox_arr_sp_qr) && count($lightbox_arr_sp_qr)>0){
				$suggested_query['post__in'] = $lightbox_arr_sp_qr;
			}else{
				$suggested_query['post__not_in'] = $postNotIn;
			}
			
			switch($video_lightbox_suggested_order){
				case 'latest':
					$suggested_query['order'] 		= 'DESC';
					$suggested_query['orderby'] 	= 'date';
					break;
					
				case 'oldest':
					$suggested_query['order'] 		= 'ASC';
					$suggested_query['orderby'] 	= 'date';
					break;
					
				case 'preserve_pid':
					$suggested_query['orderby'] 	= 'post__in';
					break;		
					
				case 'most-viewed':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						vidorev_like_view_sorting::vidorev_add_ttt_2();
					}
					break;
					
				case 'most-liked':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						vidorev_like_view_sorting::vidorev_add_ttt_3();
					}
					break;
					
				case 'random':
					$suggested_query['orderby'] 	= 'rand';
					break;	
					
				case 'title-desc':
					$suggested_query['order'] 		= 'DESC';
					$suggested_query['orderby'] 	= 'title';
					break;
					
				case 'title-asc':
					$suggested_query['order'] 		= 'ASC';
					$suggested_query['orderby'] 	= 'title';
					break;			
			}
			
			switch($video_lightbox_suggested_query){
				case 'same-category':
					
					$categories = array();
					$post_categories = get_the_category($post_id);				
					if ( ! empty( $post_categories ) && count($post_categories) > 0) {
						foreach( $post_categories as $category ) {						
							array_push($categories, $category->term_id);
						}  
						
						$suggested_query['category__in'] =  $categories;
					}
								
					break;
					
				case 'same-tag':
					
					$tags = array();
					$post_tags = wp_get_post_tags( $post_id );
					
					if ( ! empty( $post_tags ) && count($post_tags) > 0) {
						foreach( $post_tags as $tag ) {						
							array_push($tags, $tag->term_id);
						}  
						
						$suggested_query['tag__in'] =  $tags;
					}
					
					break;	
			}
			
			$suggested_query_action = new WP_Query($suggested_query);
			
			switch($video_lightbox_suggested_order){
				case 'most-viewed':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						vidorev_like_view_sorting::vidorev_remove_ttt_2();
					}
					break;
					
				case 'most-liked':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						vidorev_like_view_sorting::vidorev_remove_ttt_3();
					}
					break;			
			}
			
			if($suggested_query_action->have_posts()):
				
				$tt_suggested_pst = $suggested_query_action->found_posts;
				
				ob_start();
				$video_lightbox_link_action = trim(vidorev_get_redux_option('video_lightbox_link_action', 'lightbox'));
				$extra_lightbox_link = 'video-popup-control';
				if($video_lightbox_link_action == 'post'){
					$extra_lightbox_link = '';
				}
				$video_lightbox_suggested_layout = trim(vidorev_get_redux_option('video_lightbox_suggested_layout', 'default'));
				?>						
				<div class="suggested-post-listing <?php echo esc_attr($video_lightbox_suggested_layout=='special'?'next-video-popup suggested-posts':'');?>">
					<?php
					$n_v_w 		= 0;
					$n_v_w_c 	= 0;
					while($suggested_query_action->have_posts()):
						$suggested_query_action->the_post();
						
						if($n_v_w==1){
							$n_v_w = 0;
							$sub_next_video_id = get_the_ID();
						}
						
						if($post_id == get_the_ID()){
							$n_v_w = 1;
						}else{
							$n_v_w = 0;
						}
						
						if($n_v_w_c == 0){
							$sub_first_video_id = get_the_ID();
						}
						
						$n_v_w_c++;
						
						if($n_v_w_c == $tt_suggested_pst && !isset($sub_next_video_id) && isset($sub_first_video_id)){
							$sub_next_video_id = $sub_first_video_id;
							$no_more_videos_next = true;
						}
						
						if($video_lightbox_suggested_layout=='default'){	
						?>
                            <div class="post-listing-item<?php echo esc_attr($post_id==get_the_ID()?' crr-video-scc':'');?><?php echo esc_attr((isset($sub_next_video_id)&&$sub_next_video_id==get_the_ID())?' next-video-scc':'');?>">
                                <div class="post-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_lightbox_image_size', 'vidorev_thumb_1x1_1x'), apply_filters('vidorev_custom_lightbox_image_ratio', 'class-1x1'), 6, NULL); ?></div>
                                <div class="post-content">
                                    <h3 class="h6 post-title">
                                        <a href="<?php echo esc_url(vidorev_get_post_url(get_the_ID())); ?>" class="<?php echo esc_attr($extra_lightbox_link);?>" data-id="<?php echo esc_attr(get_the_ID());?>"><?php the_title();?></a> 
                                    </h3>
                                    <?php do_action( 'vidorev_posted_on', array('author', '', '', 'view-count', 'like-count', ''), 'widget' ); ?>	
                                </div>
                            </div>
						<?php
						}elseif($video_lightbox_suggested_layout=='special'){
						?>
                        	<div class="video-listing-item<?php echo esc_attr($post_id==get_the_ID()?' crr-video-scc':'');?><?php echo esc_attr((isset($sub_next_video_id)&&$sub_next_video_id==get_the_ID())?' next-video-scc':'');?>">
                                <div class="video-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_lightbox_image_big_size', 'vidorev_thumb_2point7x1_1x'), apply_filters('vidorev_custom_lightbox_image_big_ratio', 'class-2point7x1'), 3, NULL);?></div>
                                <div class="absolute-gradient"></div>
                                <div class="video-content overlay-background">
                                    <span class="video-icon small-icon alway-active video-popup-control" data-id="<?php echo esc_attr(get_the_ID());?>"></span>
                                    <div class="up-next-text font-size-12"><?php do_action( 'vidorev_posted_on', array('', '', '', 'view-count', 'like-count', ''), 'widget' ); ?></div>
                                    <h3 class="h6 post-title"> 
                                        <a href="<?php echo esc_url(vidorev_get_post_url(get_the_ID())); ?>" class="<?php echo esc_attr($extra_lightbox_link);?>" data-id="<?php echo esc_attr(get_the_ID());?>"><?php the_title();?></a>
                                    </h3>								
                                </div>
                            </div>
                        <?php	
						}
					endwhile;
					?>
				</div>
				<?php
				$output_string = ob_get_contents();
				ob_end_clean();	
				
				if(isset($sub_next_video_id) && $sub_next_video_id > 0 && $nextVideoHTML == ''){
					ob_start();
					?>
					<div class="suggested-post-listing next-video-popup next-video-popup-action<?php echo esc_attr(isset($no_more_videos_next)&&$no_more_videos_next?' hide-first-video':'')?>">
						<div class="video-listing-item">
							<div class="video-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_lightbox_image_big_size', 'vidorev_thumb_2point7x1_1x'), apply_filters('vidorev_custom_lightbox_image_big_ratio', 'class-2point7x1'), 3, $sub_next_video_id);?></div>
							<div class="absolute-gradient"></div>
							<div class="video-content overlay-background">
								<span class="video-icon small-icon alway-active video-popup-control" data-id="<?php echo esc_attr($sub_next_video_id);?>"></span>
								<div class="up-next-text font-size-12"><?php echo esc_html__('Up next', 'vidorev')?></div>
								<h3 class="h6 post-title"> 
									<a class="video-popup-control check-url-control" data-id="<?php echo esc_attr($sub_next_video_id);?>" href="<?php echo esc_url(vidorev_get_post_url($sub_next_video_id)); ?>" title="<?php echo esc_attr(get_the_title($sub_next_video_id));?>"><?php echo get_the_title($sub_next_video_id);?></a> 
								</h3>								
							</div>
						</div>
					</div>
					<?php
					$nextVideoHTML = ob_get_contents();
					ob_end_clean();
				}
				
				$json_params['single_video_suggested'] = $nextVideoHTML.$output_string;
			else:
				ob_start();
				?>
				<div class="no-suggested-post"><?php esc_html_e('No suggested videos!', 'vidorev');?></div>
				<?php
				$output_string = ob_get_contents();
				ob_end_clean();	
				$json_params['single_video_suggested'] = $nextVideoHTML.$output_string;
			endif;
			
			wp_reset_postdata();
		}
		/*suggested post*/
		
		if($sc_post_id > 0){
			return json_encode($json_params);
		}else{
			if(is_user_logged_in()){
				do_action('beeteam368_video_fne', get_current_user_id(), $post_id);
			}
			wp_send_json($json_params);
		}
	
		die();
	}
endif;
add_action( 'wp_ajax_get_player_params', 'vidorev_get_player_params' );
add_action( 'wp_ajax_nopriv_get_player_params', 'vidorev_get_player_params' );

if( ! function_exists('vidorev_get_post_data_for_lightbox') ) :
	function vidorev_get_post_data_for_lightbox() {
		$security = sanitize_text_field($_POST['security']);
		if(!isset($_POST['post_id']) || !vidorev_ajax_verify_nonce($security, false)){
			echo '';
			return;
		}
		
		$json_params = array();		
		$json_params['post_url'] = esc_url(vidorev_get_post_url(sanitize_text_field(trim($_POST['post_id']))));	
		
		wp_send_json($json_params);
		die;
	}
endif;
add_action( 'wp_ajax_get_post_data_for_lightbox', 'vidorev_get_post_data_for_lightbox' );
add_action( 'wp_ajax_nopriv_get_post_data_for_lightbox', 'vidorev_get_post_data_for_lightbox' );

if( ! function_exists('vidorev_get_player_comments') ) :
	function vidorev_get_player_comments() {
		
		$security = sanitize_text_field($_POST['security']);
		if(!vidorev_ajax_verify_nonce($security, false)){
			return;
			die();
		}
		
		if(vidorev_get_redux_option('video_lightbox_comments', 'on', 'switch')=='off' || !isset($_POST['post_id'])){
			echo '';
			return;
		}	
				
		$post_id = sanitize_text_field(trim($_POST['post_id']));
		if(get_post_type($post_id)!='post' || wp_is_post_revision($post_id) || get_post_format($post_id)!='video'){
			echo '';
			return;
		}
		
		$stop_query = apply_filters('beeteam368_stop_comment_lightbox', false, $post_id);
		
		do_action('beeteam368_custom_comment_lightbox', $post_id);
		
		if($stop_query){
			die();
		}
		
		$query_date = '';
		if(isset($_POST['query_date'])){
			$query_date = sanitize_text_field(trim($_POST['query_date']));
		}
		
		ob_start();
			
			$args = array(				
				'post_id' 	=> $post_id,	
				'number' 	=> 20,
				'orderby' 	=> 'comment_date',
				'order' 	=> 'DESC',
				'status'	=> 'approve',			
			);
			
			if($query_date!=''){
				$args['date_query'] = array(
					'after' => $query_date,
				);
				$args['number'] = NULL;
			}
			
			$comments = get_comments( $args );	
			if(is_array($comments) && count($comments)>0){
				if($query_date==''){
				?>
					<div class="comment-wrapper comment-wrapper-control">
				<?php
				}
					foreach($comments as $comment){
						$comment_id 			= $comment->comment_ID ;
						$comment_author 		= $comment->comment_author;
						$comment_author_email 	= $comment->comment_author_email;
						$comment_date 			= get_comment_date( 'M j, Y \a\t g:i a', $comment_id );
						$comment_content  		= $comment->comment_content;
					?>
						<div class="comment-item" id="comment-id-<?php echo esc_attr($comment_id);?>" data-date="<?php echo esc_attr($comment->comment_date);?>">
							<div class="comment-avatar">
								<?php echo get_avatar( $comment_author_email, 40 );?>
							</div>
							<div class="comment-body">
								<div class="comment-header">
									<span class="c-author h6"><?php echo esc_html($comment_author);?></span>
									<span class="c-date meta-font"><?php echo esc_html($comment_date);?></span>															
								</div>
								<div class="comment-footer">
									<span class="c-content"><?php echo esc_html($comment_content);?></span>		
								</div>
							</div>							
						</div>
					<?php
					}
				if($query_date==''){	
				?>
					</div>
				<?php
				}
			}else{
				if($query_date==''){
			?>
					<div class="no-suggested-post"><?php esc_html_e('No comments found!', 'vidorev');?></div>
			<?php
				}
			}
		
		$output_string = ob_get_contents();
		ob_end_clean();	
		
		echo apply_filters( 'vidorev_live_comments_html', $output_string );
	
		die();
	}
endif;
add_action( 'wp_ajax_get_player_comments', 'vidorev_get_player_comments' );
add_action( 'wp_ajax_nopriv_get_player_comments', 'vidorev_get_player_comments' );

if( ! function_exists('vidorev_added_player_comments') ) :
	function vidorev_added_player_comments() {
		
		$security = sanitize_text_field($_POST['security']);
		if(!vidorev_ajax_verify_nonce($security, true)){
			return;
			die();
		}
		
		if(vidorev_get_redux_option('video_lightbox_comments', 'on', 'switch')=='off' || !isset($_POST['post_id']) || !isset($_POST['comment']) || !is_user_logged_in()){
			echo '';
			return;
		}	
				
		$post_id = sanitize_text_field(trim($_POST['post_id']));
		if(get_post_type($post_id)!='post' || wp_is_post_revision($post_id) || get_post_format($post_id)!='video'){
			echo '';
			return;
		}
		
		$json_params = array();
		
		$current_user = wp_get_current_user();
		
		$display_name 	= $current_user->display_name;
		$user_email 	= $current_user->user_email;
		$user_id 		= $current_user->ID;
		
		$query_date 	= date('Y-m-d H:i:s', time() - 30);
		
		$args = array(
			'number' 		=> 5,
			'orderby' 		=> 'comment_date',
			'order' 		=> 'DESC',
			'status'		=> 'all',
			'user_id'		=> $user_id,
			'date_query'	=> array('after' => $query_date),		
		);
		$comments = get_comments( $args );
		
		if((is_array($comments) && count($comments)>=5) || (isset($_COOKIE['checkcmposttime']) && $_COOKIE['checkcmposttime']=='1')){
			if(!isset($_COOKIE['checkcmposttime'])){
				setcookie('checkcmposttime', '1', time()+300, '/');
			}
			$json_params['result'] 	= '0';
			$json_params['msg'] 	= esc_html__('You are doing that too fast. Please wait 05 minutes before trying again.', 'vidorev');
			wp_send_json($json_params);
			return;
		}
		
		$commentdata = array();
		
		$commentdata['comment_author'] 			= $display_name;
		$commentdata['comment_author_email'] 	= $user_email;
		$commentdata['user_id'] 				= $user_id;
		$commentdata['comment_post_ID'] 		= $post_id;
		$commentdata['comment_content'] 		= sanitize_textarea_field(trim($_POST['comment']));
		
		
		$insert_comment = wp_insert_comment( $commentdata );
		
		if($insert_comment==false){
			$json_params['result'] = '1';
		}else{
			$json_params['result'] = '2';
		}
		
		wp_send_json($json_params);
			
		die();
	}
endif;
add_action( 'wp_ajax_add_live_comment', 'vidorev_added_player_comments' );
add_action( 'wp_ajax_nopriv_add_live_comment', 'vidorev_added_player_comments' );

if ( ! function_exists( 'vidorev_remove_blockquotes' ) ) :
	function vidorev_remove_blockquotes( $content ) {
		$content = preg_replace('~<blockquote>([\s\S]+?)</blockquote>~', '', $content);
		return $content;		
	}	
endif;

if ( ! function_exists( 'vidorev_custom_CSS' ) ) :
	function vidorev_custom_CSS() {
		wp_add_inline_style('vidorev-style', vidorev_theme_custom_css());
		if(vidorev_get_redux_option('right_to_left', 'off', 'switch') == 'on'){
			wp_enqueue_style( 'right_to_left', get_template_directory_uri() . '/rtl.css');
		}				
	}	
endif;
add_action( 'wp_enqueue_scripts', 'vidorev_custom_CSS', 100 );

if ( ! function_exists( 'vidorev_pingback_header' ) ) :
	function vidorev_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
	add_action( 'wp_head', 'vidorev_pingback_header' );
endif;

if ( ! function_exists( 'vidorev_mix_color' ) ) :
	function vidorev_mix_color($color_1 = array(0, 0, 0), $color_2 = array(0, 0, 0), $weight = 0.5){
		$f = function($x) use ($weight) { return $weight * $x; };
		$g = function($x) use ($weight) { return (1 - $weight) * $x; };
		$h = function($x, $y) { return round($x + $y); };
		return array_map($h, array_map($f, $color_1), array_map($g, $color_2));
	}
endif;

if ( ! function_exists( 'vidorev_hex2rgb' ) ) :
	function vidorev_hex2rgb($hex = "#000000"){
		$f = function($x) { return hexdec($x); };
		return array_map($f, str_split(str_replace("#", "", $hex), 2));
	}
endif;

if ( ! function_exists( 'vidorev_rgb2hex' ) ) :
	function vidorev_rgb2hex($rgb = array(0, 0, 0)){
		$f = function($x) { return str_pad(dechex($x), 2, "0", STR_PAD_LEFT); };
		return "#" . implode("", array_map($f, $rgb));
	}
endif;


if(!function_exists('vidorev_woocommerce_header_add_to_cart_fragment')){
	function vidorev_woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		?>
			<span class="cart-total-items"><?php echo WC()->cart->get_cart_contents_count(); ?></span>	
		<?php
		$fragments['span.cart-total-items'] = ob_get_clean();
		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'vidorev_woocommerce_header_add_to_cart_fragment' );

if(!function_exists('beeteam368_get_channel_by_post_id')){
	function beeteam368_get_channel_by_post_id($post_id){
		
		if($post_id == NULL || !defined('CHANNEL_PM_PREFIX')){
			return 0;
		}
		
		$post_author = get_post_field( 'post_author', $post_id );
		
		$args_query = array(
							'post_type'				=> 'vid_channel',
							'posts_per_page' 		=> -1,
							'post_status' 			=> 'publish',
							'ignore_sticky_posts' 	=> 1,
							'author'				=> $post_author,
							'meta_query' 			=> array(
															array(
																'key' 		=> CHANNEL_PM_PREFIX.'videos',
																'value' 	=> serialize( strval( $post_id ) ),
																'compare' 	=> 'LIKE'
															)
							)
						);
		$channel_query = get_posts($args_query);
		
		if($channel_query):
			foreach ( $channel_query as $item) :
				return $item->ID;
				break;
			endforeach;
			return 0;
		else:
			return 0;	
		endif;	
					
	}
}

if(!function_exists('beeteam368_get_series_by_post_id')){

	function beeteam368_get_series_by_post_id($post_id){
		if($post_id == NULL || !defined('VIDOREV_EXTENSIONS')){
			return 0;
		}
		
		$args_query = array(
							'post_type'				=> 'vid_series',
							'posts_per_page' 		=> -1,
							'post_status' 			=> 'publish',
							'ignore_sticky_posts' 	=> 1,
							'meta_query' 			=> array(
															array(
																'key' 		=> 'video_series_group',
																'value' 	=> serialize( strval( $post_id ) ),
																'compare' 	=> 'LIKE'
															)
							)
						);
		$series_query = get_posts($args_query);
		
		if($series_query):
			foreach ( $series_query as $item) :
				return $item->ID;
				break;
			endforeach;
			return 0;
		else:
			return 0;	
		endif;	
	}
}

if(!function_exists('beeteam368_get_playlist_by_post_id')){
	function beeteam368_get_playlist_by_post_id($post_id){
		if($post_id == NULL || !defined('PLAYLIST_PM_PREFIX')){
			return 0;
		}
		
		$args_query = array(
							'post_type'				=> 'vid_playlist',
							'posts_per_page' 		=> -1,
							'post_status' 			=> 'publish',
							'ignore_sticky_posts' 	=> 1,
							'meta_query' 			=> array(
															array(
																'key' 		=> PLAYLIST_PM_PREFIX.'videos',
																'value' 	=> serialize( strval( $post_id ) ),
																'compare' 	=> 'LIKE'
															)
							)
						);
		$playlist_query = get_posts($args_query);
		
		if($playlist_query):
			foreach ( $playlist_query as $item) :
				return $item->ID;
				break;
			endforeach;
			return 0;
		else:
			return 0;	
		endif;	
	}
}

if(!function_exists('beeteam368_return_embed')){
	function beeteam368_return_embed(){
		if(isset($_GET['video_embed']) && is_numeric($_GET['video_embed']) && is_single(sanitize_text_field($_GET['video_embed'])) && get_post_format(sanitize_text_field($_GET['video_embed']))=='video'){
			return true;
		}else{
			return false;
		}		
	}
}

if(!class_exists('vidorev_detech_video_data')){ /*vidorev_video_fetch_data - 19 - 183*/
	class vidorev_detech_video_data{
		private static function get_video_id_from_url($url = '', $regexes = array()){
			if($url == '' || !is_array($regexes)){
				return '';
			}
			
			foreach($regexes as $regex) {
				if(preg_match($regex, $url, $matches)) {
					return $matches[1];
				}
			}
			return '';
		}
		
		public static function getYoutubeID($url = ''){ //Youtube
			$regexes = array(
				'#(?:https?:)?//www\.youtube(?:\-nocookie)?\.com/(?:v|e|embed)/([A-Za-z0-9\-_]+)#', // Comprehensive search for both iFrame and old school embeds
				'#(?:https?(?:a|vh?)?://)?(?:www\.)?youtube(?:\-nocookie)?\.com/watch\?.*v=([A-Za-z0-9\-_]+)#', // Any YouTube URL. After http(s) support a or v for Youtube Lyte and v or vh for Smart Youtube plugin
				'#(?:https?(?:a|vh?)?://)?youtu\.be/([A-Za-z0-9\-_]+)#', // Any shortened youtu.be URL. After http(s) a or v for Youtube Lyte and v or vh for Smart Youtube plugin
				'#<div class="lyte" id="([A-Za-z0-9\-_]+)"#', // YouTube Lyte
				'#data-youtube-id="([A-Za-z0-9\-_]+)"#' // LazyYT.js
			);
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getYoutubePlaylistID($url = ''){ //Youtube Playlist
		
			$list 	= '';
			$string = parse_url($url); 
			if(isset($string['query'])){
				parse_str($string['query'], $q);
				$list 	= isset($q['list'])?$q['list']:'';
			}
			
			return $list;
		}
		
		public static function getVimeoID($url = ''){ //Vimeo
			$regexes = array(
				'#<object[^>]+>.+?http://vimeo\.com/moogaloop.swf\?clip_id=([A-Za-z0-9\-_]+)&.+?</object>#s', // Standard Vimeo embed code
				'#(?:https?:)?//player\.vimeo\.com/video/([0-9]+)#', // Vimeo iframe player
				'#\[vimeo id=([A-Za-z0-9\-_]+)]#', // JR_embed shortcode
				'#\[vimeo clip_id="([A-Za-z0-9\-_]+)"[^>]*]#', // Another shortcode
				'#\[vimeo video_id="([A-Za-z0-9\-_]+)"[^>]*]#', // Yet another shortcode
				'#(?:https?://)?(?:www\.)?vimeo\.com/([0-9]+)#', // Vimeo URL
				'#(?:https?://)?(?:www\.)?vimeo\.com/channels/(?:[A-Za-z0-9]+)/([0-9]+)#' // Channel URL
			);
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getDailymotionID($url = ''){ //Dailymotion
			$regexes = array(
				'#<object[^>]+>.+?http://www\.dailymotion\.com/swf/video/([A-Za-z0-9]+).+?</object>#s', // Dailymotion flash
				'#//www\.dailymotion\.com/embed/video/([A-Za-z0-9]+)#', // Dailymotion iframe
				'#(?:https?://)?(?:www\.)?dailymotion\.com/video/([A-Za-z0-9]+)#' // Dailymotion URL
			);
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getFacebookID($url = ''){ //Facebook
			$regexes = array(
				'~/videos/(?:t\.\d+/)?(\d+)~i',
				'#(?://|\%2F\%2F)(?:www\.)?facebook\.com(?:/|\%2F)(?:[a-zA-Z0-9]+)(?:/|\%2F)videos(?:/|\%2F)([0-9]+)#', // URL Embed
				'#http://www\.facebook\.com/v/([0-9]+)#', // Flash Embed
				'#https?://www\.facebook\.com/video/embed\?video_id=([0-9]+)#', // iFrame Embed
				'#https?://www\.facebook\.com/video\.php\?v=([0-9]+)#'
			);
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getTwitchID($url = ''){ //Twitch
			$regexes = array(
				'#(?:www\.)?twitch\.tv/(?:[A-Za-z0-9_]+)/v/([0-9]+)#', // Video URL
				'#(?:www\.)?twitch\.tv/(?:[A-Za-z0-9_]+)/c/([0-9]+)#', // Video URL
				'#(?:www\.)?twitch\.tv/(?:[A-Za-z0-9_]+)/([0-9]+)#', // Video URL
				'#(?:www\.)?twitch\.tv/(?:[A-Za-z0-9_]+)/video/([0-9]+)#', // Video URL
				'#<object[^>]+>.+?http://www\.twitch\.tv/widgets/archive_embed_player\.swf.+?chapter_id=([0-9]+).+?</object>#s', // Flash embed
				'#<object[^>]+>.+?http://www\.twitch\.tv/swflibs/TwitchPlayer\.swf.+?videoId=c([0-9]+).+?</object>#s', // Newer Flash embed
				'#(?:www\.)?twitch\.tv/([A-Za-z0-9_]+)#', // Video Channel URL
			);
			$return_id = self::get_video_id_from_url($url, $regexes);
			
			if($return_id!='' && !is_numeric($return_id)){
				return 'channel...?><[~|~]'.$return_id;
			}
			
			if($return_id==''){
				$split_url = explode('/', trim($url));
				if(count($split_url)>0){
					$count = count($split_url)-1;
					return 'channel...?><[~|~]'.$split_url[$count];
				}
				return '';
			}
			return $return_id;
		}
		
		public static function getDriveID($url = ''){
			$regexes = array(
				'#(?:https?://)?(?:www\.)?drive\.google\.com/file/d/([A-Za-z0-9\-_]+)#', //Video URL				
			);
			
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getVideoNetwork($url = ''){
			
			if($url == ''){
				return '';
			}
			
			$videoNetwork = '';
			
			if(strpos($url, 'youtube.com') || strpos($url, 'youtu.be')){
				$videoNetwork='youtube';
			}elseif(strpos($url, 'vimeo.com')){
				$videoNetwork='vimeo';
			}elseif(strpos($url, 'dailymotion.com') || strpos($url, 'dai.ly')){
				$videoNetwork='dailymotion';
			}elseif(strpos($url, 'facebook.com')){
				$videoNetwork='facebook';
			}elseif(strpos($url, 'twitch.tv')){
				$videoNetwork='twitch';
			}elseif(strpos($url, 'drive.google.com')){
				$videoNetwork='drive';	
			}elseif(preg_match('/<iframe/', $url) || preg_match('/<object/', $url) || preg_match('/<script/', $url)){
				$videoNetwork='embeded-code';
			}else{
				$videoNetwork='self-hosted';
			}
						
			return $videoNetwork;
		}
		
		public static function getVideoID($url = ''){
			
			if($url == ''){
				return '';
			}
			
			$videoID = '';
			$videoNetwork = self::getVideoNetwork($url);
			
			switch ($videoNetwork){
				case 'youtube':
					$videoID = self::getYoutubeID($url);
					break;
				case 'vimeo':
					$videoID = self::getVimeoID($url);
					break;
				case 'dailymotion':
					$videoID = self::getDailymotionID($url);
					break;
				case 'facebook':
					$videoID = self::getFacebookID($url);
					break;
				case 'twitch':
					$videoID = self::getTwitchID($url);
					break;
				case 'drive':					
					$videoID = self::getDriveID($url);
					break;					
			}
			
			return $videoID;
		}
	}
}

if(!function_exists('vidorev_get_option_login_page')){
	function vidorev_get_option_login_page($otp, $default = ''){
		
		$login_page 		= trim(vidorev_get_redux_option('login_page', ''));
		$lost_password_page = trim(vidorev_get_redux_option('lost_password_page', ''));
		$register_page 		= trim(vidorev_get_redux_option('register_page', ''));
		$profile_page 		= trim(vidorev_get_redux_option('profile_page', ''));
		$clean_login_plugin	= function_exists( 'clean_login_get_translated_option_page' );
		
		switch($otp){
			case 'cl_login_url':
				if($clean_login_plugin && !is_numeric($login_page)){
					return clean_login_get_translated_option_page( 'cl_login_url','');
				}elseif(is_numeric($login_page)){
					return get_permalink($login_page);
				}
				break;
				
			case 'cl_restore_url':
				if($clean_login_plugin && !is_numeric($lost_password_page)){
					return clean_login_get_translated_option_page( 'cl_restore_url','');
				}elseif(is_numeric($lost_password_page)){
					return get_permalink($lost_password_page);
				}
				break;
				
			case 'cl_register_url':
				if($clean_login_plugin && !is_numeric($register_page)){
					return clean_login_get_translated_option_page( 'cl_register_url','');
				}elseif(is_numeric($register_page)){
					return get_permalink($register_page);
				}
				break;
				
			case 'cl_edit_url':
				if($clean_login_plugin && !is_numeric($profile_page)){
					return clean_login_get_translated_option_page( 'cl_edit_url','');
				}elseif(is_numeric($profile_page)){
					return get_permalink($profile_page);
				}
				break;			
		}
		
		return $default;
	}
}