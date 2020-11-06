<?php
if ( ! function_exists( 'vidorev_plugin_scripts' ) ) :
	function vidorev_plugin_scripts() {		
		$google_ima_library 		= trim(vidorev_get_option('google_ima_library', 'javascript_libraries_settings', 'yes'));
		$google_adsense_library 	= trim(vidorev_get_option('google_adsense_library', 'javascript_libraries_settings', 'yes'));		
		$fluidplayer 				= trim(vidorev_get_option(FLUIDPLAYER_PM_PREFIX.'fluidplayer', FLUIDPLAYER_PM_PREFIX.'fluidplayer_settings_page', 'yes'));
		$fluidplayer_version		= trim(vidorev_get_option(FLUIDPLAYER_PM_PREFIX.'fluidplayer_version', FLUIDPLAYER_PM_PREFIX.'fluidplayer_settings_page', 'v2'));
		
		$define_js_object = array();
		
		wp_enqueue_style( 'priority-navigation', VPE_PLUGIN_URL . 'assets/front-end/priority-navigation/priority-nav-core.css', array(), VPE_VER);
		wp_enqueue_style( 'select2', VPE_PLUGIN_URL . 'assets/front-end/select2/select2.min.css', array(), VPE_VER);
		wp_enqueue_style( 'vidorev-plugin-css', VPE_PLUGIN_URL . 'assets/front-end/main.css', array(), VPE_VER);
		
		wp_enqueue_style( 'wp-mediaelement' );
		if($fluidplayer == 'yes' && $fluidplayer_version == 'v2'){
			wp_enqueue_style( 'fluidplayer', VPE_PLUGIN_URL . 'assets/front-end/fluidplayer/fluidplayer.min.css', array(), VPE_VER);
		}

		wp_enqueue_style( 'plyrplayer', VPE_PLUGIN_URL . 'assets/front-end/plyr/plyr.css', array(), VPE_VER);
		
		$define_js_object['youtube_library_url'] 		= 'https://www.youtube.com/iframe_api';		
		$define_js_object['vimeo_library_url'] 			= 'https://player.vimeo.com/api/player.js';
		$define_js_object['dailymotion_library_url'] 	= 'https://api.dmcdn.net/all.js';
		
		$vid_facebook_sdk_app_id = trim(vidorev_get_option('vid_facebook_sdk_app_id', 'vid_facebook_sdk_settings', ''));
		$query_fb_app = '';
		if($vid_facebook_sdk_app_id!=''){
			$query_fb_app = '&appId='.esc_attr($vid_facebook_sdk_app_id).'&autoLogAppEvents=1';
		}
		$vid_facebook_sdk_language = trim(vidorev_get_option('vid_facebook_sdk_language', 'vid_facebook_sdk_settings', 'en_US'));
		$define_js_object['facebook_library_url'] 		= 'https://connect.facebook.net/'.$vid_facebook_sdk_language.'/sdk.js?ver=6.0#xfbml=1&version=v6.0'.$query_fb_app;
		
		$define_js_object['twitch_library_url'] 		= 'https://player.twitch.tv/js/embed/v1.js';
		$define_js_object['google_ima_library_url'] 	= 'https://imasdk.googleapis.com/js/sdkloader/ima3.js';
		$define_js_object['google_adsense_library_url'] = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
		
		$jwplayer_cloud_library = vidorev_get_redux_option('jwplayer_cloud_library', '', 'media_get_src');
		$define_js_object['jwplayer_library_url'] 		= $jwplayer_cloud_library;
		
		wp_enqueue_script( 'beeteam368_obj_wes', VPE_PLUGIN_URL . 'assets/front-end/btwes.js', array( 'jquery' ), '1.0.0', false  );
		wp_enqueue_script( 'priority-navigation', VPE_PLUGIN_URL . 'assets/front-end/priority-navigation/priority-nav.min.js', array( 'jquery' ), VPE_VER, true  );
		wp_enqueue_script( 'select2', VPE_PLUGIN_URL . 'assets/front-end/select2/select2.full.min.js', array( 'jquery' ), VPE_VER, true  );
		wp_enqueue_script( 'vidorev-plugin-javascript', VPE_PLUGIN_URL . 'assets/front-end/main.js', array( 'jquery' ), VPE_VER, true  );
		
		$define_js_object['mediaelement_library_url'] = VPE_PLUGIN_URL . 'assets/front-end/mediaelement/mediaelement.all.js';
		if($fluidplayer == 'yes' && $fluidplayer_version == 'v2'){
			$define_js_object['fluidplayer_library_url'] = VPE_PLUGIN_URL . 'assets/front-end/fluidplayer/fluidplayer.min.js';
		}
		
		if($fluidplayer == 'yes' && $fluidplayer_version == 'v3'){
			$define_js_object['fluidplayer_library_url'] = 'https://cdn.fluidplayer.com/3.0.4/fluidplayer.min.js';
		}

		$define_js_object['plyr_library_url'] = VPE_PLUGIN_URL . 'assets/front-end/plyr/plyr.min.js';
		
		$define_js_object['imdb_logo_url'] = esc_url(VPE_PLUGIN_URL.'assets/front-end/img/IMDB_Logo');
		
		$define_js_object['youtube_rel'] 			= trim(vidorev_get_option('rel', 'youtube_player_settings', 'no'));
		$define_js_object['youtube_modestbranding'] = trim(vidorev_get_option('modestbranding', 'youtube_player_settings', 'yes'));
		$define_js_object['youtube_showinfo'] 		= trim(vidorev_get_option('showinfo', 'youtube_player_settings', 'yes'));
		
		$define_js_object['youtube_broadcasts_params'] 	= array();
		
		if($fluidplayer == 'yes'){
			$define_js_object['hls_library_url'] = esc_url(VPE_PLUGIN_URL . 'assets/front-end/fluidplayer/hls.min.js');
			$define_js_object['mpd_library_url'] = esc_url(VPE_PLUGIN_URL . 'assets/front-end/fluidplayer/dash.mediaplayer.min.js');
		}
		
		wp_localize_script( 'beeteam368_obj_wes', 'vidorev_jav_plugin_js_object', $define_js_object );

		$define_video_ads_object = get_option( VIDEOADS_PM_PREFIX.'videoads_settings_page', false );
		if(!is_array($define_video_ads_object)){
			$define_video_ads_object = array();
		}			
		if(isset($define_video_ads_object['vid_ads_m_group_html']) && isset($define_video_ads_object['vid_ads_m_group_html'][0]) && isset($define_video_ads_object['vid_ads_m_group_html'][0]['vid_ads_m_html_source'])){
			$global_ads_html_source = $define_video_ads_object['vid_ads_m_group_html'][0]['vid_ads_m_html_source'];
			$define_video_ads_object['vid_ads_m_group_html'][0]['vid_ads_m_html_source'] =  apply_filters('vidorev_global_ads_html_source', $global_ads_html_source);
		}
		
		if(isset($define_video_ads_object['vid_ads_m_hide_ads_membership']) && is_array($define_video_ads_object['vid_ads_m_hide_ads_membership']) && count($define_video_ads_object['vid_ads_m_hide_ads_membership'])>0 && defined( 'PMPRO_VERSION' ) && is_user_logged_in()){						
			$current_user_mb_ad_st 		= wp_get_current_user();						
			$user_membership_hide_ad_id	= 0;
			
			if ( isset($current_user_mb_ad_st->membership_level) && isset($current_user_mb_ad_st->membership_level->ID) && is_numeric($current_user_mb_ad_st->membership_level->ID)) {
				$user_membership_hide_ad_id = $current_user_mb_ad_st->membership_level->ID;
				if(array_search('free', $define_video_ads_object['vid_ads_m_hide_ads_membership']) !== FALSE || array_search('hide_ads_membership_'.$user_membership_hide_ad_id, $define_video_ads_object['vid_ads_m_hide_ads_membership']) !== FALSE){
					$define_video_ads_object['vid_ads_m_hide_ads_membership_result'] = 'hide';
				}
			}
		}
		
		if(	isset($define_video_ads_object['vid_ads_m_hide_ads_membership_wc_mb']) 
			&& is_array($define_video_ads_object['vid_ads_m_hide_ads_membership_wc_mb']) 
			&& count($define_video_ads_object['vid_ads_m_hide_ads_membership_wc_mb'])>0 
			&& class_exists( 'WooCommerce' ) && function_exists('wc_memberships') && is_user_logged_in()
		){	
			$current_user_WC_mb_ad_st 		= wp_get_current_user();
			foreach($define_video_ads_object['vid_ads_m_hide_ads_membership_wc_mb'] as $wc_mb_plan_id){
				if(!is_numeric($wc_mb_plan_id) && $wc_mb_plan_id == 'free'){
					$define_video_ads_object['vid_ads_m_hide_ads_membership_result'] = 'hide';
					break;
				}
				
				if(wc_memberships_is_user_active_member($current_user_WC_mb_ad_st->ID, $wc_mb_plan_id)){
					$define_video_ads_object['vid_ads_m_hide_ads_membership_result'] = 'hide';
					break;
				}
			}
		}
		
		wp_localize_script( 'beeteam368_obj_wes', 'vidorev_jav_plugin_video_ads_object', $define_video_ads_object );
		
		if($fluidplayer == 'yes'){
			$define_fluidplayer_object = get_option( FLUIDPLAYER_PM_PREFIX.'fluidplayer_settings_page', false );
			if(!is_array($define_fluidplayer_object)){
				$define_fluidplayer_object = array();
			}
			wp_localize_script( 'beeteam368_obj_wes', 'vidorev_jav_plugin_fluidplayer_object', $define_fluidplayer_object );
		}
		
		if(is_single() && get_post_type()=='post' && get_post_format()=='video'){
			$post_id = get_the_ID();
			
			$define_video_ads_object_post = array();
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'video_ads'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'video_ads', true));
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'video_ads_type'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'video_ads_type', true));
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_google_ima'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_google_ima', true);
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_image'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_image', true);
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html5_video'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_html5_video', true);
			
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_html', true);
			if(isset($define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html']) && isset($define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html'][0]) && isset($define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html'][0][VIDEOADS_PM_PREFIX.'html_source'])){
				$single_ads_html_source = $define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html'][0][VIDEOADS_PM_PREFIX.'html_source'];
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_html'][0][VIDEOADS_PM_PREFIX.'html_source'] =  apply_filters('vidorev_single_ads_html_source', $single_ads_html_source, $post_id);
			}
			
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'group_dynamic'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'group_dynamic', true);
			
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'time_to_show_ads'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'time_to_show_ads', true));
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'time_skip_ads'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'time_skip_ads', true));
			$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'time_to_hide_ads'] = trim(get_post_meta($post_id, VIDEOADS_PM_PREFIX.'time_to_hide_ads', true));
			
			if($fluidplayer == 'yes'){
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vpaid_mode'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vpaid_mode', true);				
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vast_preroll'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vast_preroll', true);
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vast_postroll'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vast_postroll', true);
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vast_pauseroll'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vast_pauseroll', true);
				$define_video_ads_object_post[VIDEOADS_PM_PREFIX.'vast_midroll'] = get_post_meta($post_id, VIDEOADS_PM_PREFIX.'vast_midroll', true);
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
			
			wp_localize_script( 'beeteam368_obj_wes', 'vidorev_jav_plugin_video_ads_object_post', $define_video_ads_object_post );
		}
	}
endif;	
add_action( 'wp_enqueue_scripts', 'vidorev_plugin_scripts' );

add_action('amp_post_template_head', function(){
	if(is_single() && get_post_type()=='post' && get_post_format()=='video'){
		echo '<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>';
	}
}, 99);

if(!function_exists('vidorev_plugin_scripts_check')){
	function vidorev_plugin_scripts_check(){
		if(function_exists('is_buddypress') && !is_buddypress()){
			wp_enqueue_script( 'select2', VPE_PLUGIN_URL . 'assets/front-end/select2/select2.full.min.js', array( 'jquery' ), VPE_VER, true  );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'vidorev_plugin_scripts_check', 1000 );

if(!function_exists('vidorev_visible_image_opacity_plugin')){
	function vidorev_visible_image_opacity_plugin(){
		$lazyload 			= vidorev_get_redux_option('lazyload', 'off', 'switch');
		if($lazyload != 'on'){
	?>
			<script>
				if(typeof(window.vidorev_visible_image_opacity) === 'undefined'){	
	
					window.vidorev_visible_image_opacity = function (){
						var elements = document.querySelectorAll('img.ul-normal-effect:not(.img-effect-setup)');
						
						if(elements.length === 0){
							return;
						}
												
						for (var i = 0; i < elements.length; i++){
							
							var el 			= elements[i];
							
							var doc 		= document.documentElement;			
							var scrollTop	= ((window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0));
							
							var rect 		= el.getBoundingClientRect();
							var elemTop 	= rect.top + scrollTop;	
							
							var wHeight		= (window.innerHeight || doc.clientHeight || document.body.clientHeight);
							var isVisible 	= (elemTop <= scrollTop + wHeight);
				
							if(isVisible){
								el.classList.add('img-effect-setup');
								if(el.complete){
									el.classList.add('img-loaded');
								}else{
									el.addEventListener('load', function(){
										this.classList.add('img-loaded');
									});				
								}
							}
											
						}

					}
					
					var docElem = document.documentElement;
					
					window.addEventListener('scroll', window.vidorev_visible_image_opacity, true);
					window.addEventListener('resize', window.vidorev_visible_image_opacity, true);
					
					if(window.MutationObserver){
						new MutationObserver( window.vidorev_visible_image_opacity ).observe( docElem, {childList: true, subtree: true, attributes: true} );
					} else {
						docElem['addEventListener']('DOMNodeInserted', window.vidorev_visible_image_opacity, true);
						docElem['addEventListener']('DOMAttrModified', window.vidorev_visible_image_opacity, true);
						setInterval(window.vidorev_visible_image_opacity, 999);
					}
					
					window.addEventListener('hashchange', window.vidorev_visible_image_opacity, true);
					
					['focus', 'mouseover', 'click', 'load', 'transitionend', 'animationend', 'webkitAnimationEnd'].forEach(function(name){
						document['addEventListener'](name, window.vidorev_visible_image_opacity, true);
					});
					
					document['addEventListener']('DOMContentLoaded', window.vidorev_visible_image_opacity);
					
					window.vidorev_visible_image_opacity();
					
				}
			</script>
	<?php
		}
	}
}
add_action('wp_footer', 'vidorev_visible_image_opacity_plugin');

if( ! function_exists('vidorev_plugin_image_sizes') ) :
	function vidorev_plugin_image_sizes(){		
		add_image_size('vidorev_thumb_1x1_0x', 60, 60, true);		
		add_image_size('vidorev_thumb_1x1_1x', 100, 100, true);	
		add_image_size('vidorev_thumb_1x1_2x', 200, 200, true);
		add_image_size('vidorev_thumb_1x1_3x', 268, 268, true);
		
		add_image_size('vidorev_thumb_2point7x1_1x', 346, 130, true);	
		add_image_size('vidorev_thumb_2point7x1_2x', 568, 213, true);	
		add_image_size('vidorev_thumb_2point7x1_3x', 1136, 426, true);
		add_image_size('vidorev_thumb_4x3_0point5x', 282, 212, true);
		add_image_size('vidorev_thumb_4x3_1point5x', 568, 426, true);
		
		add_image_size('vidorev_thumb_2x3_0point3x', 60, 90, true);		
	}	
endif;
add_action('after_setup_theme', 'vidorev_plugin_image_sizes');

if( ! function_exists('vidorev_convert_special_text') ) :
	function vidorev_convert_special_text($text) {
	
		$t = $text;
		
		$specChars = array(
			'!' => '%21',    '"' => '%22',
			'#' => '%23',    '$' => '%24',    '%' => '%25',
			'&' => '%26',    '\'' => '%27',   '(' => '%28',
			')' => '%29',    '*' => '%2A',    '+' => '%2B',
			',' => '%2C',    '-' => '%2D',    '.' => '%2E',
			'/' => '%2F',    ':' => '%3A',    ';' => '%3B',
			'<' => '%3C',    '=' => '%3D',    '>' => '%3E',
			'?' => '%3F',    '@' => '%40',    '[' => '%5B',
			'\\' => '%5C',   ']' => '%5D',    '^' => '%5E',
			'_' => '%5F',    '`' => '%60',    '{' => '%7B',
			'|' => '%7C',    '}' => '%7D',    '~' => '%7E',
			',' => '%E2%80%9A',  ' ' => '%20'
		);
	
		foreach ($specChars as $k => $v) {
			$t = str_replace($k, $v, $t);
		}
		
		return $t;
	}
endif;