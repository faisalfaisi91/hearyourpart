<?php
if ( !class_exists('vidorev_youtube_player_settings' ) ):
	class vidorev_youtube_player_settings {
	
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
			add_submenu_page('vidorev-theme-settings', esc_html__( 'Youtube Player Settings', 'vidorev-extensions'), esc_html__( 'Youtube Player Settings', 'vidorev-extensions'), 'manage_options', 'vidorev_youtube_player_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'youtube_player_settings',
					'title' => esc_html__('Youtube Player Settings', 'vidorev-extensions')
				),				          
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'youtube_player_settings' => array(
					array(
						'name'    => 'rel',
						'label'   => esc_html__( 'Related Videos', 'vidorev-extensions'),
						'desc'    => esc_html__( 'This parameter indicates whether the player should show related videos when playback of the initial video ends. Supported values are NO and YES. The default value is NO.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'no',
						'options' => array(
							'no'			=> esc_html__('NO', 'vidorev-extensions'),
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),										
						)
					),
					array(
						'name'    => 'modestbranding',
						'label'   => esc_html__( 'Modest Branding', 'vidorev-extensions'),
						'desc'    => esc_html__( 'This parameter lets you use a YouTube player that does not show a YouTube logo. Set the parameter value to YES to prevent the YouTube logo from displaying in the control bar. Note that a small YouTube text label will still display in the upper-right corner of a paused video when the user\'s mouse pointer hovers over the player. The default value is YES.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),	
							'no'			=> esc_html__('NO', 'vidorev-extensions'),																
						)
					),	
					array(
						'name'    => 'showinfo',
						'label'   => esc_html__( 'Show Info', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Setting the parameter\'s value to NO causes the player to not display information like the video title and uploader before the video starts playing. If the player is loading a playlist, and you explicitly set the parameter value to 1, then, upon loading, the player will also display thumbnail images for the videos in the playlist. The default value is YES.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),	
							'no'			=> esc_html__('NO', 'vidorev-extensions'),																
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
new vidorev_youtube_player_settings();