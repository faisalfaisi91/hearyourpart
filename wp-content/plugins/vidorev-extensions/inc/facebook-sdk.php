<?php
if ( !class_exists('vidorev_facebook_sdk_settings' ) ):
	class vidorev_facebook_sdk_settings {
	
		private $settings_api;
	
		function __construct() {
			$this->settings_api = new WeDevs_Settings_API;
	
			add_action( 'admin_init', array($this, 'admin_init') );
			add_action( 'admin_menu', array($this, 'admin_menu') );
		}
	
		function admin_init() {
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			$this->settings_api->admin_init();
		}
	
		function admin_menu() {
			add_submenu_page('vidorev-theme-settings', esc_html__( 'Facebook SDK', 'vidorev-extensions'), esc_html__( 'Facebook SDK', 'vidorev-extensions'), 'manage_options', 'vid_facebook_sdk_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'vid_facebook_sdk_settings',
					'title' => esc_html__('General Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'vid_facebook_comments_settings',
					'title' => esc_html__('Comment Settings', 'vidorev-extensions')
				),				        
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'vid_facebook_sdk_settings' => array(
					array(
						'name' 		=> 'vid_facebook_sdk_app_id',
						'label' 	=> esc_html__( 'Facebook App ID', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'You need to declare your application code to be able to moderate comments: https://developers.facebook.com/tools/comments/', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> '',
					),
					array(
						'name' 		=> 'vid_facebook_sdk_language',
						'label' 	=> esc_html__( 'Language', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'For example, you can replace en_US with your locale, such as fr_FR for French (France).', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'en_US',
					),						                
				),     
				
				'vid_facebook_comments_settings' => array(					
					array(
						'name' 		=> 'vid_facebook_comments_numposts',
						'label' 	=> esc_html__( 'Num Posts', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'The number of comments to show by default. The minimum value is 1.', 'vidorev-extensions'),
						'type' 		=> 'number',
						'min'       => 1,
                   		'max'       => 100,
						'step'      => '1',
						'default' 	=> 10
					), 
					
					array(
						'name'    => 'vid_facebook_comments_order_by',
						'label'   => esc_html__( 'Order by', 'vidorev-extensions'),
						'desc'    => esc_html__( 'The order to use when displaying comments. Can be "TOP", "OLDEST", or "NEWEST". ', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'social',
						'options' => array(
							'social'		=> esc_html__('TOP', 'vidorev-extensions'),
							'reverse_time' 	=> esc_html__('OLDEST', 'vidorev-extensions'),
							'time'  		=> esc_html__('NEWEST', 'vidorev-extensions'),							
						)
					),	                
				),     
			);
	
			return $settings_fields;
		}
	
		function plugin_page() {
			echo '<div class="wrap"><h1>'.esc_html__( 'Facebook SDK Settings', 'vidorev-extensions').'</h1>';
	
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
	
			echo '</div>';
		}	
	}
endif;
new vidorev_facebook_sdk_settings();

if(!function_exists('vidorev_facebook_sdk_meta_tags')){
	function vidorev_facebook_sdk_meta_tags(){
		$vid_facebook_sdk_app_id = trim(vidorev_get_option('vid_facebook_sdk_app_id', 'vid_facebook_sdk_settings', ''));
		if($vid_facebook_sdk_app_id != ''){
		?>
			<meta property="fb:app_id" content="<?php echo esc_attr($vid_facebook_sdk_app_id);?>" />
		<?php
		}
	}
}
add_action('vidorev_meta_tags', 'vidorev_facebook_sdk_meta_tags');