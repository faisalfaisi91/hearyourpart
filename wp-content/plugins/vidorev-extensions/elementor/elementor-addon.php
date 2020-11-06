<?php
if(!class_exists('vidorev_Addon_Elementor')){
	
	class vidorev_Addon_Elementor {
		public function __construct() {
			add_action( 'elementor/init', array( $this, 'addons' ) );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets') );
		}
		
		public function widgets() {
			 require_once( VPE_PLUGIN_PATH. 'elementor/widgets/slider.php' );
			 require_once( VPE_PLUGIN_PATH. 'elementor/widgets/block.php' );
			 require_once( VPE_PLUGIN_PATH. 'elementor/widgets/youtube-broadcasts.php' );
			 require_once( VPE_PLUGIN_PATH. 'elementor/widgets/categories.php' );
			 require_once( VPE_PLUGIN_PATH. 'elementor/widgets/playlist.php' );
			 require_once( VPE_PLUGIN_PATH. 'elementor/widgets/video.php' );
			 require_once( VPE_PLUGIN_PATH. 'elementor/widgets/youtube-live-video.php' );
		}
		
		public function addons() {
			Elementor\Plugin::instance()->elements_manager->add_category(
				'vidorev-addon-elements',
				array(
					'title' => esc_html__( 'VidoRev Elements', 'vidorev-extensions'),
				),
				1
			);
		}	
	}
	
}
new vidorev_Addon_Elementor();

/*ext*/
	if(!function_exists('beeteam368_create_elm_sc_video')){
		function beeteam368_create_elm_sc_video($sc_post_id = 0, $ext_id_sc = ''){
			if($sc_post_id == 0 || $ext_id_sc == ''){
				return '';
			}
			echo '<script>var vidorev_json_id_'.esc_attr($ext_id_sc).' = '.vidorev_get_player_params($sc_post_id).';if(typeof(window.get_vidorev_build_fnc)!=="undefined" && window.get_vidorev_build_fnc!==null){window.get_vidorev_build_fnc.create_single_video_player("player-api-control'.esc_attr($ext_id_sc).'", vidorev_json_id_'.esc_attr($ext_id_sc).');}else{jQuery("body").on("get_vidorev_build_fnc", function(e){window.get_vidorev_build_fnc.create_single_video_player("player-api-control'.esc_attr($ext_id_sc).'", vidorev_json_id_'.esc_attr($ext_id_sc).');});}</script>';
		}
	}
/*ext*/