<?php
if(!class_exists('vidorev_TemplateLoaded')):
	class vidorev_TemplateLoaded {
	
		private static $instance;
		protected $templates;
	
		public static function get_instance() {
	
			if ( null == self::$instance ) {
				self::$instance = new vidorev_TemplateLoaded();
			} 
	
			return self::$instance;
	
		} 
	
		private function __construct() {
	
			$this->templates = array();
	
			if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
	
				add_filter(
					'page_attributes_dropdown_pages_args',
					array( $this, 'register_project_templates' )
				);
	
			} else {
	
				add_filter(
					'theme_page_templates', array( $this, 'add_new_template' )
				);
	
			}
	
			add_filter(
				'wp_insert_post_data', 
				array( $this, 'register_project_templates' ) 
			);
	
			add_filter(
				'template_include', 
				array( $this, 'view_project_template') 
			);
	
			$this->templates = array(
				'template/archive-playlist.php' => esc_html__('Archive Playlist', 'vidorev-extensions'),
				'template/archive-channel.php' => esc_html__('Archive Channel', 'vidorev-extensions'),
				'template/archive-actor.php' => esc_html__('Archive Actor', 'vidorev-extensions'),
				'template/archive-director.php' => esc_html__('Archive Director', 'vidorev-extensions'),
				'template/archive-series.php' => esc_html__('Archive Series', 'vidorev-extensions'),
				'template/blog-page-template.php' => esc_html__('Blog Page Template', 'vidorev-extensions'),
			);
				
		} 
	
		public function add_new_template( $posts_templates ) {
			$posts_templates = array_merge( $posts_templates, $this->templates );
			return $posts_templates;
		}
	
		public function register_project_templates( $atts ) {
	
			$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
	
			$templates = wp_get_theme()->get_page_templates();
			if ( empty( $templates ) ) {
				$templates = array();
			} 
	
			wp_cache_delete( $cache_key , 'themes');
	
			$templates = array_merge( $templates, $this->templates );
	
			wp_cache_add( $cache_key, $templates, 'themes', 1800 );
	
			return $atts;
	
		} 
	
		public function view_project_template( $template ) {
	
			if ( is_search() ) {
				return $template;
			}
	
			global $post;
	
			if ( ! $post ) {
				return $template;
			}
	
			if ( ! isset( $this->templates[get_post_meta( 
				$post->ID, '_wp_page_template', true 
			)] ) ) {
				return $template;
			} 
	
			$file = plugin_dir_path( __FILE__ ). get_post_meta( 
				$post->ID, '_wp_page_template', true
			);
	
			if ( file_exists( $file ) ) {
				return $file;
			} else {
				echo $file;
			}
	
			return $template;
	
		}
	
	}
endif;	
add_action( 'plugins_loaded', array( 'vidorev_TemplateLoaded', 'get_instance' ) );

if(!function_exists('beeteam368_vidorev_extensions_vrf')){
	function beeteam368_vidorev_extensions_vrf(){
		
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

if(is_admin()){
	add_action('admin_init', 'beeteam368_vidorev_extensions_vrf');
}