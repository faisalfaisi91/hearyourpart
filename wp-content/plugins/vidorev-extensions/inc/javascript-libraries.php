<?php
if ( !class_exists('vidorev_video_network_library' ) ):
	class vidorev_video_network_library {
	
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
			add_submenu_page('vidorev-theme-settings', esc_html__( 'Libraries Settings', 'vidorev-extensions'), esc_html__( 'Libraries Settings', 'vidorev-extensions'), 'manage_options', 'vid_javascript_libraries_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'javascript_libraries_settings',
					'title' => esc_html__('Libraries Settings', 'vidorev-extensions')
				),				          
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'javascript_libraries_settings' => array(
				
					array(
						'name'    => 'hidden_all_meta_box',
						'label'   => esc_html__( 'Hide all Metabox', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'no',
						'options' => array(
							'no'			=> esc_html__('NO', 'vidorev-extensions'),
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),							
						)
					),
										           
				),       
			);
	
			return $settings_fields;
		}
	
		function plugin_page() {
			echo '<div class="wrap">';
	
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
	
			echo '</div>';
		}	
	}
endif;
new vidorev_video_network_library();