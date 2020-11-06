<?php
if ( ! function_exists( 'vidorev_scripts_admin' ) ) :
	function vidorev_scripts_admin() {
		wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin.css', array(), '2.9.9.9.7.5');	
		
		wp_enqueue_media();
		wp_enqueue_script('jquery');
		
		if(defined('VPE_VER') && defined('VPE_PLUGIN_URL')){
			wp_enqueue_style( 'select2', VPE_PLUGIN_URL . 'assets/front-end/select2/select2.min.css', array(), VPE_VER);
			wp_enqueue_script( 'select2', VPE_PLUGIN_URL . 'assets/front-end/select2/select2.full.min.js', array( 'jquery' ), VPE_VER, true  );
		}
		
		$define_js_object = array();
		$define_js_object['admin_ajax'] 		= esc_url(admin_url( 'admin-ajax.php' ));
		$define_js_object['text_processing'] 	= esc_html__('Processing', 'vidorev');
		$define_js_object['text_confirm'] 		= esc_html__('Are you sure?', 'vidorev');
		
		$theme_data = wp_get_theme();
		$define_js_object['security'] 			= esc_attr(wp_create_nonce('BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true)));
		
		wp_enqueue_script( 'beeteam368_obj_wes', get_template_directory_uri() . '/js/btwes.js', array( 'jquery' ), '1.0.0', false  );
		wp_enqueue_script( 'admin_javascript', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ), '2.9.9.9.7.5', true  );	
		
		wp_localize_script( 'beeteam368_obj_wes', 'beeteam368_jav_js_object', $define_js_object );	
	}
endif;	

if ( ! function_exists( 'vidorev_custom_css_admin_header' ) ) :
	function vidorev_custom_css_admin_header() {
		echo 
		'<style type="text/css">
			#redux-header .display_header span{
				display:inline-block;
				padding-left:10px;
			}
			#redux-header .display_header h2 {
				background-image: url("'.get_template_directory_uri().'/img/logo.png");
				background-repeat: no-repeat;
    			background-position: left center;
    			background-size: cover;
				width:153px;
				height:30px;
				font-size:0;
				vertical-align:top;
			} 
		</style>';
		
		if(vidorev_get_redux_option('fetch_video_view_count', 'on', 'switch')=='on'){
			echo 	
			'<style type="text/css">
				.misc-pub-section#post-views{
				display:none !important;
			}</style>';
		}
	}
endif;

if ( ! function_exists( 'vidorev_admin_setup' ) ) :
	function vidorev_admin_setup(){
		add_editor_style('editor-style.css');
	}	
endif;

if(!function_exists('beeteam368_vidorev_extensions_vrf')){
	function beeteam368_vidorev_extensions_vrf(){
		if(defined('beeteam368_tf_item_id')){
			$current_domain = beeteam368_tf_item_domain;
			$domain			= trim(get_option( 'beeteam368_verify_domain', '' ));
			$code			= trim(get_option( 'beeteam368_verify_md5_code', '' ));
			
			if($domain == '' || $code == '' || $domain != $current_domain){
				global $pagenow;
				if($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == 'beeteam368_vrpcccc'){
					global $beeteam368_vidorev_vri_ck;
					$beeteam368_vidorev_vri_ck = 'img_tu';
				}else{
					
					if(
						($pagenow == 'admin.php' || $pagenow == 'edit.php' || $pagenow == 'post-new.php' || $pagenow == 'edit-tags.php')						
						&&
						( 	(isset($_GET['page']) && (
								$_GET['page'] == 'vidorev-theme-settings' || 
								$_GET['page'] == 'vid_facebook_sdk_settings' || 
								$_GET['page'] == 'vidorev_transfer_videos' || 
								$_GET['page'] == 'vidorev_youtube_importer_videos' || 
								$_GET['page'] == 'vidorev_youtube_player_settings' || 
								$_GET['page'] == 'vid_javascript_libraries_settings' || 
								$_GET['page'] == 'vid_like_dislike_settings' || 
								$_GET['page'] == 'edit_theme_options' || 
								$_GET['page'] == 'vid_ads_m_videoads_settings_page' || 
								$_GET['page'] == 'vid_fluid_m_fluidplayer_settings_page' || 
								$_GET['page'] == 'vid_playlist_settings' || 
								$_GET['page'] == 'vid_channel_settings' || 
								$_GET['page'] == 'vid_actor_settings' || 
								$_GET['page'] == 'vid_director_settings' || 
								$_GET['page'] == 'vid_series_settings' || 
								$_GET['page'] == 'vid_user_submit_settings' || 
								$_GET['page'] == 'vidorev_google_dirve_files' || 
								$_GET['page'] == 'youtube_automatic_settings'
							)) || 
							(isset($_GET['post_type']) && (
								$_GET['post_type'] == 'vid_playlist' ||
								$_GET['post_type'] == 'vid_channel' ||
								$_GET['post_type'] == 'vid_actor' ||
								$_GET['post_type'] == 'vid_director' ||
								$_GET['post_type'] == 'vid_series' ||
								$_GET['post_type'] == 'youtube_broadcast' ||
								$_GET['post_type'] == 'amazon_associates' ||
								$_GET['post_type'] == 'video_report_check' ||
								$_GET['post_type'] == 'video_user_submit' ||
								$_GET['post_type'] == 'playlist_user_submit' ||
								$_GET['post_type'] == 'channel_user_submit' ||
								$_GET['post_type'] == 'youtube_automatic'
							)) || 
							(isset($_GET['taxonomy']) && (
								$_GET['taxonomy'] == 'vid_playlist_cat' ||
								$_GET['taxonomy'] == 'vid_channel_cat' ||
								$_GET['taxonomy'] == 'vid_actor_cat' ||
								$_GET['taxonomy'] == 'vid_director_cat' ||
								$_GET['taxonomy'] == 'vid_series_cat'
							)) 
						)						
					){
						wp_redirect( admin_url('/admin.php?page=beeteam368_vrpcccc') ); 
						exit;
					}
				}
			}else{
				global $beeteam368_vidorev_vri_ck;
				$beeteam368_vidorev_vri_ck = 'pur_cd';
			}
		}
	}
}

if(is_admin()){
	add_action('admin_enqueue_scripts', 'vidorev_scripts_admin');
	add_action('admin_head', 'vidorev_custom_css_admin_header');
	add_action('admin_init', 'vidorev_admin_setup');
	add_action('admin_init', 'beeteam368_vidorev_extensions_vrf');
}