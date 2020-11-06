<?php
if ( !class_exists('vidorev_channel_settings' ) ):
	class vidorev_channel_settings {
	
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
			add_submenu_page('edit.php?post_type=vid_channel', esc_html__( 'Channel Settings', 'vidorev-extensions'), esc_html__( 'Channel Settings', 'vidorev-extensions'), 'manage_options', 'vid_channel_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'vid_channel_settings',
					'title' => esc_html__('General Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'vid_channel_layout_settings',
					'title' => esc_html__('Layout Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'vid_channel_subscribe_settings',
					'title' => esc_html__('Subscribe Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'vid_channel_notifications_settings',
					'title' => esc_html__('Notifications Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'vid_channel_tab_settings',
					'title' => esc_html__('Tab Settings', 'vidorev-extensions')
				),            
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'vid_channel_settings' => array(
					array(
						'name' 		=> 'vid_channel_slug',
						'label' 	=> esc_html__( 'Channel Slug', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Change single Channel slug. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'channel'
					), 
					array(
						'name' 		=> 'vid_channel_category_base',
						'label' 	=> esc_html__( 'Channel Category Base', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Change Channel Category Base. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'channel-category'
					), 
					array(
						'name' 		=> 'vid_channel_image',
						'label' 	=> esc_html__( 'Channel Image', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Upload an image or enter an URL.', 'vidorev-extensions'),
						'type' 		=> 'file',
					),                
				), 
				'vid_channel_layout_settings' => array(					
					array(
						'name'    => 'vid_channel_layout',
						'label'   => esc_html__( 'Channel Listing Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change single Channel Listing Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'grid-default' 	=> esc_html__('Grid - Default', 'vidorev-extensions'),
							'list-default'  => esc_html__('List - Default', 'vidorev-extensions'),
							'grid-special'  => esc_html__('Grid - Special', 'vidorev-extensions'),
							'list-special'  => esc_html__('List - Special', 'vidorev-extensions'),
							'grid-modern'  	=> esc_html__('Grid - Modern', 'vidorev-extensions'),
							'movie-grid' 	=> esc_html__('Grid - Poster', 'vidorev-extensions'),
							'list-blog' 	=> esc_html__('List - Blog Wide', 'vidorev-extensions'),
							'movie-list'  	=> esc_html__('List - Poster', 'vidorev-extensions'),
							'grid-small' 	=> esc_html__('Grid - Small', 'vidorev-extensions'),
							/*new layout*/
						)
					),					
					array(
						'name'              => 'vid_channel_items_per_page',
						'label'             => esc_html__( '[Channel Listing] Items Per Page', 'vidorev-extensions'),
						'desc'              => esc_html__( 'Number of items to show per page. Defaults to: 10', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '10', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 100,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '10',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_channel_pag_type',
						'label'   => esc_html__( '[Channel Listing] Pagination', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Choose type of navigation for channel page. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'wp-default',
						'options' => array(
							'wp-default'		=> esc_html__('WordPress Default', 'vidorev-extensions'),
							'loadmore-btn'		=> esc_html__('Load More Button (Ajax)', 'vidorev-extensions'),
							'infinite-scroll' 	=> esc_html__('Infinite Scroll (Ajax)', 'vidorev-extensions'),
							'pagenavi_plugin'  	=> esc_html__('WP PageNavi (Plugin)', 'vidorev-extensions'),
						)
					),
					array(
						'name'    => 'vid_channel_listing_sidebar',
						'label'   => esc_html__( 'Channel Listing Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Channel Listing Sidebar. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'right'			=> esc_html__('Right', 'vidorev-extensions'),
							'left' 			=> esc_html__('Left', 'vidorev-extensions'),
							'hidden'  		=> esc_html__('Hidden', 'vidorev-extensions'),
						)
					), 
					array(
						'name'    => 'vid_single_channel_layout',
						'label'   => esc_html__( 'Single Channel Video Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Channel Video Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'grid-default' 	=> esc_html__('Grid - Default', 'vidorev-extensions'),
							'list-default'  => esc_html__('List - Default', 'vidorev-extensions'),
							'grid-special'  => esc_html__('Grid - Special', 'vidorev-extensions'),
							'list-special'  => esc_html__('List - Special', 'vidorev-extensions'),
							'grid-modern'  	=> esc_html__('Grid - Modern', 'vidorev-extensions'),
							'movie-grid' 	=> esc_html__('Grid - Poster', 'vidorev-extensions'),
							'list-blog' 	=> esc_html__('List - Blog Wide', 'vidorev-extensions'),
							'movie-list'  	=> esc_html__('List - Poster', 'vidorev-extensions'),
							'grid-small' 	=> esc_html__('Grid - Small', 'vidorev-extensions'),
							/*new layout*/
						)
					),
					array(
						'name'              => 'vid_single_channel_video_items_per_page',
						'label'             => esc_html__( '[Video] Items Per Page', 'vidorev-extensions'),
						'desc'              => esc_html__( 'Number of items to show per page. Defaults to: 10', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '10', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 100,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '10',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_single_channel_playlist_layout',
						'label'   => esc_html__( 'Single Channel Playlist Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Channel Playlist Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'grid-default' 	=> esc_html__('Grid - Default', 'vidorev-extensions'),
							'list-default'  => esc_html__('List - Default', 'vidorev-extensions'),
							'grid-special'  => esc_html__('Grid - Special', 'vidorev-extensions'),
							'list-special'  => esc_html__('List - Special', 'vidorev-extensions'),
							'grid-modern'  	=> esc_html__('Grid - Modern', 'vidorev-extensions'),
							'movie-grid' 	=> esc_html__('Grid - Poster', 'vidorev-extensions'),
							'list-blog' 	=> esc_html__('List - Blog Wide', 'vidorev-extensions'),
							'movie-list'  	=> esc_html__('List - Poster', 'vidorev-extensions'),
							'grid-small' 	=> esc_html__('Grid - Small', 'vidorev-extensions'),
							/*new layout*/
						)
					), 
					array(
						'name'              => 'vid_single_channel_playlist_items_per_page',
						'label'             => esc_html__( '[Playlist] Items Per Page', 'vidorev-extensions'),
						'desc'              => esc_html__( 'Number of items to show per page. Defaults to: 10', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '10', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 100,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '10',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_single_channel_series_layout',
						'label'   => esc_html__( 'Single Channel Series Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Channel Series Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'grid-default' 	=> esc_html__('Grid - Default', 'vidorev-extensions'),
							'list-default'  => esc_html__('List - Default', 'vidorev-extensions'),
							'grid-special'  => esc_html__('Grid - Special', 'vidorev-extensions'),
							'list-special'  => esc_html__('List - Special', 'vidorev-extensions'),
							'grid-modern'  	=> esc_html__('Grid - Modern', 'vidorev-extensions'),
							'movie-grid' 	=> esc_html__('Grid - Poster', 'vidorev-extensions'),
							'list-blog' 	=> esc_html__('List - Blog Wide', 'vidorev-extensions'),
							'movie-list'  	=> esc_html__('List - Poster', 'vidorev-extensions'),
							'grid-small' 	=> esc_html__('Grid - Small', 'vidorev-extensions'),
							/*new layout*/
						)
					), 
					array(
						'name'              => 'vid_single_channel_series_items_per_page',
						'label'             => esc_html__( '[Series] Items Per Page', 'vidorev-extensions'),
						'desc'              => esc_html__( 'Number of items to show per page. Defaults to: 10', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '10', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 100,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '10',
						'sanitize_callback' => 'floatval'
					), 
					array(
						'name'    => 'vid_single_channel_pag_type',
						'label'   => esc_html__( '[Single Channel] Pagination', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Choose type of navigation for channel page.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'loadmore-btn',
						'options' => array(
							'loadmore-btn'		=> esc_html__('Load More Button (Ajax)', 'vidorev-extensions'),					
							'infinite-scroll' 	=> esc_html__('Infinite Scroll (Ajax)', 'vidorev-extensions'),
							'pagenavi_plugin'  	=> esc_html__('WP PageNavi (Plugin)', 'vidorev-extensions'),
						)
					),    
					array(
						'name'    => 'vid_single_channel_sidebar',
						'label'   => esc_html__( 'Single Channel Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Channel Sidebar. Select "Default" to use settings in Theme Options > Single Post Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'right'			=> esc_html__('Right', 'vidorev-extensions'),
							'left' 			=> esc_html__('Left', 'vidorev-extensions'),
							'hidden'  		=> esc_html__('Hidden', 'vidorev-extensions'),
						)
					),
					array(
						'name'    => 'vid_channel_display_cat',
						'label'   => esc_html__( 'Display Channel Categories', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'no',
						'options' => array(
							'no'			=> esc_html__('NO', 'vidorev-extensions'),
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),							
						)
					),
					array(
						'name'    => 'vid_channel_query_items',
						'label'   => esc_html__( 'Query Items', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'default',
						'options' => array(
							'default'		=> esc_html__('Preserve post ID order', 'vidorev-extensions'),
							'new'			=> esc_html__('Newest Items', 'vidorev-extensions'),
							'old'			=> esc_html__('Oldest Items', 'vidorev-extensions'),							
						)
					),
					array(
						'name'    => 'vid_channel_replate_cat',
						'label'   => esc_html__( 'Replace the default category of WordPress', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'off',
						'options' => array(
							'off'		=> esc_html__('OFF', 'vidorev-extensions'),
							'on'		=> esc_html__('ON', 'vidorev-extensions'),													
						)
					),
				),
				'vid_channel_subscribe_settings' => array(
					array(
						'name'    => 'vid_channel_subscribe_fnc',
						'label'   => esc_html__( 'Enable Subscribe Function', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),			
							'no'			=> esc_html__('NO', 'vidorev-extensions'),											
						)
					),
					array(
						'name'    => 'vid_channel_subscribed_sidebar',
						'label'   => esc_html__( 'Subscribed Listing Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Subscribed Listing Sidebar. Select "Default" to use settings in Theme Options > Single Page Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'right'			=> esc_html__('Right', 'vidorev-extensions'),
							'left' 			=> esc_html__('Left', 'vidorev-extensions'),
							'hidden'  		=> esc_html__('Hidden', 'vidorev-extensions'),
						)
					),
					array(
						'name'    => 'vid_channel_subscribed_layout',
						'label'   => esc_html__( 'Subscribed Listing Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Subscribed Listing Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'grid-default' 	=> esc_html__('Grid - Default', 'vidorev-extensions'),
							'list-default'  => esc_html__('List - Default', 'vidorev-extensions'),
							'grid-special'  => esc_html__('Grid - Special', 'vidorev-extensions'),
							'list-special'  => esc_html__('List - Special', 'vidorev-extensions'),
							'grid-modern'  	=> esc_html__('Grid - Modern', 'vidorev-extensions'),
							'movie-grid' 	=> esc_html__('Grid - Poster', 'vidorev-extensions'),
							'list-blog' 	=> esc_html__('List - Blog Wide', 'vidorev-extensions'),
							'movie-list'  	=> esc_html__('List - Poster', 'vidorev-extensions'),
							'grid-small' 	=> esc_html__('Grid - Small', 'vidorev-extensions'),
							/*new layout*/
						)
					),
					array(
						'name'    => 'vid_channel_subscribed_page',
						'label'   => esc_html__( 'Subscribed Page', 'vidorev-extensions'),
						'desc'    => esc_html__( 'This sets the base your "subscribed listing page". This is the page that will display the channel listings you want to see.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => $this->get_pages(),						
					),  
				),
				
				'vid_channel_notifications_settings' => array(
					array(
						'name'    => 'vid_channel_notifications_fnc',
						'label'   => esc_html__( 'Enable Notification Function', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),			
							'no'			=> esc_html__('NO', 'vidorev-extensions'),											
						)
					),
					array(
						'name'    => 'vid_channel_notifications_sidebar',
						'label'   => esc_html__( 'Notification Listing Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Notification Listing Sidebar. Select "Default" to use settings in Theme Options > Single Page Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'right'			=> esc_html__('Right', 'vidorev-extensions'),
							'left' 			=> esc_html__('Left', 'vidorev-extensions'),
							'hidden'  		=> esc_html__('Hidden', 'vidorev-extensions'),
						)
					),
					array(
						'name'    => 'vid_channel_notifications_layout',
						'label'   => esc_html__( 'Notification Listing Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Notification Listing Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'grid-default' 	=> esc_html__('Grid - Default', 'vidorev-extensions'),
							'list-default'  => esc_html__('List - Default', 'vidorev-extensions'),
							'grid-special'  => esc_html__('Grid - Special', 'vidorev-extensions'),
							'list-special'  => esc_html__('List - Special', 'vidorev-extensions'),
							'grid-modern'  	=> esc_html__('Grid - Modern', 'vidorev-extensions'),
							'movie-grid' 	=> esc_html__('Grid - Poster', 'vidorev-extensions'),
							'list-blog' 	=> esc_html__('List - Blog Wide', 'vidorev-extensions'),
							'movie-list'  	=> esc_html__('List - Poster', 'vidorev-extensions'),
							'grid-small' 	=> esc_html__('Grid - Small', 'vidorev-extensions'),
							/*new layout*/
						)
					),
					array(
						'name'    => 'vid_channel_notifications_page',
						'label'   => esc_html__( 'Notification Page', 'vidorev-extensions'),
						'desc'    => esc_html__( 'This sets the base your "Notification listing page". This is the page that will display the channel listings you want to see.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => $this->get_pages(),						
					),  
				),
				
				'vid_channel_tab_settings' => array(
					array(
						'name'    => 'vid_video_tab',
						'label'   => esc_html__( 'Video Tab', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),			
							'no'			=> esc_html__('NO', 'vidorev-extensions'),											
						)
					),
					array(
						'name'              => 'vid_video_tab_order',
						'label'             => esc_html__( 'Video Tab [Order]', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '1', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 5,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '1',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_playlist_tab',
						'label'   => esc_html__( 'Playlist Tab', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),			
							'no'			=> esc_html__('NO', 'vidorev-extensions'),											
						)
					),
					array(
						'name'              => 'vid_playlist_tab_order',
						'label'             => esc_html__( 'Playlist Tab [Order]', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '2', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 5,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '2',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_series_tab',
						'label'   => esc_html__( 'Series Tab', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),			
							'no'			=> esc_html__('NO', 'vidorev-extensions'),											
						)
					),
					array(
						'name'              => 'vid_series_tab_order',
						'label'             => esc_html__( 'Series Tab [Order]', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '3', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 5,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '3',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_about_tab',
						'label'   => esc_html__( 'About Tab', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),			
							'no'			=> esc_html__('NO', 'vidorev-extensions'),											
						)
					),
					array(
						'name'              => 'vid_about_tab_order',
						'label'             => esc_html__( 'About Tab [Order]', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '4', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 5,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '4',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_community_tab',
						'label'   => esc_html__( 'Community Tab', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),			
							'no'			=> esc_html__('NO', 'vidorev-extensions'),											
						)
					),
					array(
						'name'              => 'vid_community_tab_order',
						'label'             => esc_html__( 'Community Tab [Order]', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '5', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 5,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '5',
						'sanitize_callback' => 'floatval'
					),					
				),            
			);
	
			return $settings_fields;
		}
		
		function get_pages() {
			$pages = get_pages();
			$pages_options = array();
			$pages_options[''] = esc_html__('---Please Select a Page', 'vidorev-extensions');
			if ( $pages ) {
				foreach ($pages as $page) {
					$pages_options[$page->ID] = esc_attr($page->post_title);
				}
			}
			return $pages_options;
		}
	
		function plugin_page() {
			echo '<div class="wrap"><h1>'.esc_html__( 'Channel Settings', 'vidorev-extensions').'</h1>';
	
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
	
			echo '</div>';
		}	
	}
endif;
new vidorev_channel_settings();

if ( !function_exists('vidorev_set_posts_per_page_for_channel' ) ):
	function vidorev_set_posts_per_page_for_channel( $query ) {
		if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'vid_channel' ) || is_tax('vid_channel_cat')) ) {
			$query->set( 'posts_per_page', vidorev_get_option('vid_channel_items_per_page', 'vid_channel_layout_settings', 10) );
		}
	}
endif;	
add_action( 'pre_get_posts', 'vidorev_set_posts_per_page_for_channel' );

if ( !function_exists('vidorev_load_videos_in_channel' ) ):
	function vidorev_load_videos_in_channel(){
		
		$post_id = get_the_ID();
		
		if ( get_post_type( $post_id ) != 'vid_channel' ) {
			return;
		}
		
		if(!isset($_GET['channel_tab'])){
			$tab_settings = array();
			
			if(vidorev_get_option('vid_video_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_video_tab_order = vidorev_get_option('vid_video_tab_order', 'vid_channel_tab_settings', 1);
				$vid_video_tab_order = is_numeric($vid_video_tab_order)?$vid_video_tab_order:1;
				if(!isset($tab_settings[$vid_video_tab_order])){
					$tab_settings[$vid_video_tab_order] = 'vid_video_tab';
				}else{
					$tab_settings[$vid_video_tab_order+count($tab_settings)+1] = 'vid_video_tab';
				}
			}
			
			if(vidorev_get_option('vid_playlist_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_playlist_tab_order = vidorev_get_option('vid_playlist_tab_order', 'vid_channel_tab_settings', 2);
				$vid_playlist_tab_order = is_numeric($vid_playlist_tab_order)?$vid_playlist_tab_order:2;				
				if(!isset($tab_settings[$vid_playlist_tab_order])){
					$tab_settings[$vid_playlist_tab_order] = 'vid_playlist_tab';
				}else{
					$tab_settings[$vid_playlist_tab_order+count($tab_settings)+1] = 'vid_playlist_tab';
				}
			}
			
			if(vidorev_get_option('vid_series_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_series_tab_order = vidorev_get_option('vid_series_tab_order', 'vid_channel_tab_settings', 3);
				$vid_series_tab_order = is_numeric($vid_series_tab_order)?$vid_series_tab_order:3;
				if(!isset($tab_settings[$vid_series_tab_order])){
					$tab_settings[$vid_series_tab_order] = 'vid_series_tab';
				}else{
					$tab_settings[$vid_series_tab_order+count($tab_settings)+1] = 'vid_series_tab';
				}
			}
			
			if(vidorev_get_option('vid_about_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_about_tab_order = vidorev_get_option('vid_about_tab_order', 'vid_channel_tab_settings', 4);
				$vid_about_tab_order = is_numeric($vid_about_tab_order)?$vid_about_tab_order:4;
				if(!isset($tab_settings[$vid_about_tab_order])){
					$tab_settings[$vid_about_tab_order] = 'vid_about_tab';
				}else{
					$tab_settings[$vid_about_tab_order+count($tab_settings)+1] = 'vid_about_tab';
				}
			}
			
			if(vidorev_get_option('vid_community_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_community_tab_order = vidorev_get_option('vid_community_tab_order', 'vid_channel_tab_settings', 5);
				$vid_community_tab_order = is_numeric($vid_community_tab_order)?$vid_community_tab_order:5;
				if(!isset($tab_settings[$vid_community_tab_order])){
					$tab_settings[$vid_community_tab_order] = 'vid_community_tab';
				}else{
					$tab_settings[$vid_community_tab_order+count($tab_settings)+1] = 'vid_community_tab';
				}
			}
			
			ksort($tab_settings);
			
			$tab_settings = array_values($tab_settings);
			
			if(isset($tab_settings[0])){
				if($tab_settings[0] == 'vid_video_tab'){
					$_GET['channel_tab'] = 'video';
				}elseif($tab_settings[0] == 'vid_playlist_tab'){
					$_GET['channel_tab'] = 'playlist';
				}elseif($tab_settings[0] == 'vid_series_tab'){
					$_GET['channel_tab'] = 'series';
				}elseif($tab_settings[0] == 'vid_about_tab'){
					$_GET['channel_tab'] = 'about';
				}elseif($tab_settings[0] == 'vid_community_tab'){
					$_GET['channel_tab'] = 'community';
				}
			}
		}
		
		if(isset($_GET['channel_tab'])){
			$channel_tab = trim($_GET['channel_tab']);
			switch($channel_tab){
				case 'video':
					$list_data 				= 'videos';
					$single_post_type 		= 'post-video';
					$single_items_per_page 	= vidorev_get_option('vid_single_channel_video_items_per_page', 'vid_channel_layout_settings', 10);		
					break;
				case 'playlist':
					$list_data 				= 'playlists';
					$single_items_per_page 	= vidorev_get_option('vid_single_channel_playlist_items_per_page', 'vid_channel_layout_settings', 10);
					$single_post_type 		= 'vid_playlist';
					break;
				case 'series':
					$list_data 				= 'series';
					$single_items_per_page 	= vidorev_get_option('vid_single_channel_series_items_per_page', 'vid_channel_layout_settings', 10);
					$single_post_type 		= 'vid_series';
					break;
				case 'about':
				?>
					<div class="entry-content"><?php the_content($post_id);?></div>
				<?php
					get_template_part('template-parts/single-post/content-footer');						
					return;
					break;
				case 'community':
				
					if ( (comments_open() || get_comments_number()) && vidorev_get_redux_option('single_post_comment', 'on', 'switch')=='on' && vidorev_detech_comment_type() == 'wp') :
						comments_template();
					endif;
					
					if ( vidorev_get_redux_option('single_post_comment', 'on', 'switch')=='on' && vidorev_detech_comment_type() == 'facebook') :
						do_action('vidorev_facebook_comment');
					endif;
					
					return;
					break;			
			}
		}
		
		if(!isset($list_data)){
			return;
		}
		
		$post_query = get_post_meta($post_id, CHANNEL_PM_PREFIX.$list_data, true);
		
		if(!is_array($post_query) || count($post_query)<1){
			return;
		}
		
		global $post_type_add_param_to_url;
		$post_type_add_param_to_url = array(
			'channel' => $post_id
		);
		
		global $vidorev_check_single_channel;
		$vidorev_check_single_channel = 'channel';
		
		$paged 	= get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
		
		$args_query = array(
			'posts_per_page' 		=> $single_items_per_page,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($post_query) ? $post_query : array(),
			'orderby'				=> 'post__in',
			'paged' 				=> $paged,		
		);
		
		if($single_post_type == 'post-video'){
			$args_query['post_type'] = 'post';
			$args_query['tax_query'] = array(
											array(
												'taxonomy'  => 'post_format',
												'field'    	=> 'slug',
												'terms'     => array('post-format-video'),
												'operator'  => 'IN',
											),
										);
		}else{
			$args_query['post_type'] = $single_post_type;
		}
		
		$query_items = vidorev_get_option('vid_channel_query_items', 'vid_channel_layout_settings', 'default');
		
		switch($query_items){
			case 'default':
				$args_query['orderby'] = 'post__in';
				break;
				
			case 'new':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'DESC';
				break;
				
			case 'old':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'ASC';
				break;
		}
		
		$channel_query 	= new WP_Query($args_query);
		
		if($channel_query->have_posts()):	
			$archive_style = vidorev_archive_style();
			
			global $wp_query;
			$old_max_num_pages = $wp_query->max_num_pages;				
			$wp_query->max_num_pages = 	$channel_query->max_num_pages;
									
		?>
			<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
				<script>
					vidorev_jav_js_object['query_vars'] = <?php echo json_encode($channel_query->query_vars);?>;
					<?php 
					if(isset($_GET['archive_query']) && trim($_GET['archive_query'])!=''){
						echo "vidorev_jav_js_object['archive_query'] = '".trim($_GET['archive_query'])."';";
					}
					
					if(isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!=''){
						echo "vidorev_jav_js_object['alphabet_filter'] = '".trim($_GET['alphabet_filter'])."';";
					}
					?>
				</script>
				
					<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
						<?php									
							while($channel_query->have_posts()):
								$channel_query->the_post();			
								
								get_template_part( 'template-parts/content', $archive_style );
				
							endwhile;
						?>
					</div>
				
				
				<?php 
				$pag_type = vidorev_get_option('vid_single_channel_pag_type', 'vid_channel_layout_settings', 'loadmore-btn');
				do_action('vidorev_pagination', 'template-parts/content', $archive_style, $pag_type); 
				?>
			</div>	
		<?php
			
			$wp_query->max_num_pages = $old_max_num_pages;
			
		endif;
		$post_type_add_param_to_url = NULL;
		$vidorev_check_single_channel = NULL;
		wp_reset_postdata();
	}
endif;
add_action( 'vidorev_single_custom_listing', 'vidorev_load_videos_in_channel' );

if(!function_exists('vidorev_submit_channel_subscribe')){
	function vidorev_submit_channel_subscribe(){
		$json_params = array();
		
		$theme_data = wp_get_theme();
		if(!wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' )){
			$json_params['error'] = 'yes';
			wp_send_json($json_params);
			return;
			die();
		}
		
		if(!is_user_logged_in() || !isset($_POST['channel_id']) || !is_numeric($_POST['channel_id'])){
			$json_params['error'] = 'yes';
			wp_send_json($json_params);
			return;
			die();
		}
		
		$prefix_channel_sub = 'channel_sub_';
		$channel_data 		= $prefix_channel_sub.$_POST['channel_id'];
		
		$current_user 	= wp_get_current_user();
		$user_id 		= (int)$current_user->ID;		
		$meta_id		= $channel_data.'_'.$user_id;
		
		$current_sub = get_the_author_meta($meta_id, $user_id);
		
		if($current_sub == $channel_data){
			update_user_meta( $user_id, $meta_id, '' );
			$json_params['status_update'] = 0;
		}else{
			update_user_meta( $user_id, $meta_id, $channel_data );
			$json_params['status_update'] = 1;
		}
		
		echo '';
		
		$json_params['success'] 		= 'yes';
		$json_params['meta_id'] 		= $meta_id;
		$json_params['channel_data'] 	= $channel_data;
		
		$subscribed_count = vidorev_count_channel_subscribed($channel_data);
		
		update_post_meta($_POST['channel_id'], 'vidorev_channel_sub_count', $subscribed_count);	
		
		$json_params['subscribed_count'] = apply_filters('vidorev_number_format', $subscribed_count);
		
		wp_send_json($json_params);
		
		die();
	}
}
add_action('wp_ajax_vidorev_submit_channel_subscribe', 'vidorev_submit_channel_subscribe');
add_action('wp_ajax_nopriv_vidorev_submit_channel_subscribe', 'vidorev_submit_channel_subscribe');

if ( !function_exists('vidorev_load_new_videos_in_subscriptions' ) ):
	function vidorev_load_new_videos_in_subscriptions(){
		$post_id = get_the_ID();
		
		if(!defined('CHANNEL_PM_PREFIX') || !is_user_logged_in() || vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')!='yes' || vidorev_get_option('vid_channel_notifications_fnc', 'vid_channel_notifications_settings', 'yes')!='yes' || $post_id != vidorev_get_option('vid_channel_notifications_page', 'vid_channel_notifications_settings', '')){
			if(is_numeric($post_id) && $post_id>0 && !is_user_logged_in() && $post_id == vidorev_get_option('vid_channel_notifications_page', 'vid_channel_notifications_settings', '')){
				echo '<div class="notice-login-sub"><h1 class="h3 h5-mobile">'.esc_html__('Don\'t miss new videos!', 'vidorev-extensions').'<br>'.esc_html__('Sign in to see updates from your favourite channels.', 'vidorev-extensions').'</h1></div>';
				$login_shortcode = trim(vidorev_get_redux_option('login_shortcode', ''));
				if(function_exists( 'clean_login_get_translated_option_page' ) && $login_shortcode==''){
					echo do_shortcode('[clean-login]');
				}elseif($login_shortcode!=''){
					echo do_shortcode($login_shortcode);
				}
			}			
			return;
		}	
		
		$arr_cookies_view_notice_posts = array();
		
		$archive_style = vidorev_archive_style();
		$args_query = vidorev_get_channels_by_user_login(-1, false, 'today');
		if(is_array($args_query) && count($args_query)>0){
			?>
			<h2 class="extra-bold h4 subscriptions-title"><?php echo esc_html__('TODAY', 'vidorev-extensions');?></h2>
			<?php
			$subscriptions_query 	= new WP_Query($args_query);
			if($subscriptions_query->have_posts()):												
			?>						
				<div class="blog-items blog-items-control subscriptions-archive-control site__row <?php echo esc_attr($archive_style);?>">
					<?php
						$i_cookie = 1;									
						while($subscriptions_query->have_posts()):
							$subscriptions_query->the_post();
										
							if($i_cookie==1){
								$arr_cookies_view_notice_posts[] = get_the_ID();
							}
							
							get_template_part( 'template-parts/content', $archive_style );
							
							$i_cookie++;
						endwhile;
					?>
				</div>
			<?php
			else:
				echo esc_html__('There are no videos to show right now', 'vidorev-extensions').'<br><br><br>';	
			endif;
			wp_reset_postdata();
		}
		
		$args_query = vidorev_get_channels_by_user_login(-1, false, 'yesterday');		
		if(is_array($args_query) && count($args_query)>0){
			?>
			<h2 class="extra-bold h4 subscriptions-title"><?php echo esc_html__('YESTERDAY', 'vidorev-extensions');?></h2>
			<?php
			$subscriptions_query 	= new WP_Query($args_query);		
			if($subscriptions_query->have_posts()):									
			?>						
				<div class="blog-items blog-items-control subscriptions-archive-control site__row <?php echo esc_attr($archive_style);?>">
					<?php
						$i_cookie = 1;									
						while($subscriptions_query->have_posts()):
							$subscriptions_query->the_post();
										
							if($i_cookie==1){
								$arr_cookies_view_notice_posts[] = get_the_ID();
							}
							
							get_template_part( 'template-parts/content', $archive_style );
							
							$i_cookie++;
						endwhile;
					?>
				</div>
			<?php	
			else:
				echo esc_html__('There are no videos to show right now', 'vidorev-extensions').'<br><br><br>';	
			endif;
			wp_reset_postdata();
		}
		
		$args_query = vidorev_get_channels_by_user_login(-1, false, 'week');		
		if(is_array($args_query) && count($args_query)>0){
			?>
			<h2 class="extra-bold h4 subscriptions-title"><?php echo esc_html__('THIS WEEK', 'vidorev-extensions');?></h2>
			<?php
			$subscriptions_query 	= new WP_Query($args_query);		
			if($subscriptions_query->have_posts()):									
			?>						
				<div class="blog-items blog-items-control subscriptions-archive-control site__row <?php echo esc_attr($archive_style);?>">
					<?php
						$i_cookie = 1;									
						while($subscriptions_query->have_posts()):
							$subscriptions_query->the_post();			
							
							if($i_cookie==1){
								$arr_cookies_view_notice_posts[] = get_the_ID();
							}
							
							get_template_part( 'template-parts/content', $archive_style );
							
							$i_cookie++;
						endwhile;
					?>
				</div>
			<?php	
			else:
				echo esc_html__('There are no videos to show right now', 'vidorev-extensions').'<br><br><br>';	
			endif;
			wp_reset_postdata();
		}
		
		$args_query = vidorev_get_channels_by_user_login(-1, false, 'month');		
		if(is_array($args_query) && count($args_query)>0){
			?>
			<h2 class="extra-bold h4 subscriptions-title"><?php echo esc_html__('THIS MONTH', 'vidorev-extensions');?></h2>
			<?php
			$subscriptions_query 	= new WP_Query($args_query);		
			if($subscriptions_query->have_posts()):									
			?>						
				<div class="blog-items blog-items-control subscriptions-archive-control site__row <?php echo esc_attr($archive_style);?>">
					<?php
						$i_cookie = 1;									
						while($subscriptions_query->have_posts()):
							$subscriptions_query->the_post();			
							
							if($i_cookie==1){
								$arr_cookies_view_notice_posts[] = get_the_ID();
							}
							
							get_template_part( 'template-parts/content', $archive_style );
							
							$i_cookie++;
						endwhile;
					?>
				</div>
			<?php	
			else:
				echo esc_html__('There are no videos to show right now', 'vidorev-extensions').'<br><br><br>';	
			endif;
			wp_reset_postdata();
		}
		
		$args_query = vidorev_get_channels_by_user_login(12, false, 'older');
		if(is_array($args_query) && count($args_query)>0){
			?>
			<h2 class="extra-bold h4 subscriptions-title"><?php echo esc_html__('OLDER', 'vidorev-extensions');?></h2>
			<?php
			$subscriptions_query 	= new WP_Query($args_query);		
			if($subscriptions_query->have_posts()):
				global $wp_query;
				$old_max_num_pages = $wp_query->max_num_pages;				
				$wp_query->max_num_pages = 	$subscriptions_query->max_num_pages;										
			?>
            	<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">	
					<script>
                        vidorev_jav_js_object['query_vars'] = <?php echo json_encode($subscriptions_query->query_vars);?>;
                        <?php 
                        if(isset($_GET['archive_query']) && trim($_GET['archive_query'])!=''){
                            echo "vidorev_jav_js_object['archive_query'] = '".trim($_GET['archive_query'])."';";
                        }
                        
                        if(isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!=''){
                            echo "vidorev_jav_js_object['alphabet_filter'] = '".trim($_GET['alphabet_filter'])."';";
                        }
                        ?>
                    </script>					
                    <div class="blog-items blog-items-control subscriptions-archive-control site__row <?php echo esc_attr($archive_style);?>">
                        <?php	
							$i_cookie = 1;								
                            while($subscriptions_query->have_posts()):
                                $subscriptions_query->the_post();			
                                
								if($i_cookie==1){
									$arr_cookies_view_notice_posts[] = get_the_ID();
								}
								
                                get_template_part( 'template-parts/content', $archive_style );
                				
								$i_cookie++;
                            endwhile;
                        ?>
                    </div>
                    <?php
                    do_action('vidorev_pagination', 'template-parts/content', $archive_style, 'infinite-scroll');
                    $wp_query->max_num_pages = $old_max_num_pages;
			?>
            	</div>
            <?php		
			else:
				echo esc_html__('There are no videos to show right now', 'vidorev-extensions');	
			endif;
			wp_reset_postdata();
		}
		
		$int_crr_user_id = get_current_user_id();	
		
		if($int_crr_user_id > 0){
			if(isset($arr_cookies_view_notice_posts) && is_array($arr_cookies_view_notice_posts) && count($arr_cookies_view_notice_posts)>0){
				update_user_meta( $int_crr_user_id, 'beeteam368_notification_posts', $arr_cookies_view_notice_posts );
			}else{
				update_user_meta( $int_crr_user_id, 'beeteam368_notification_posts', array(0) );
			}
		}
	}
endif;
add_action( 'vidorev_single_page_custom_listing', 'vidorev_load_new_videos_in_subscriptions' );

/*
if(!function_exists('vidorev_update_post_sync_channels')){
	function vidorev_update_post_sync_channels($channel_id, $post_after, $post_before){
		if(isset($channel_id) && $channel_id>0 && get_post_type($channel_id)=='vid_channel'){			
			$videos_in = get_post_meta($channel_id, CHANNEL_PM_PREFIX.'videos', true);
			print_r($post_before);die;
			if(is_array($videos_in)){
				foreach($videos_in as $video_id){
					$current_channels = get_post_meta($video_id, CHANNEL_PM_PREFIX.'sync_channel', true);
					if(is_array($current_channels) && ($izc = array_search($channel_id, $current_channels)) === FALSE){
						array_push($current_channels, $channel_id);
						update_post_meta($video_id, CHANNEL_PM_PREFIX.'sync_channel', $current_channels);
					}else{
						update_post_meta($video_id, CHANNEL_PM_PREFIX.'sync_channel', array($channel_id));
					}
				}
			}
		}
	}
}
add_action( 'post_updated', 'vidorev_update_post_sync_channels', 10, 3 );
*/