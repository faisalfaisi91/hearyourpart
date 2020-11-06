<?php
if(!function_exists('vidorev_get_option')):
	function vidorev_get_option( $option, $section, $default = '' ) {
	
		$options = get_option( $section );
	
		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}
	
		return $default;
	}
endif;

if(!function_exists('vidorev_get_redux_option')):
	function vidorev_get_redux_option( $id, $default_value = '', $type = NULL ){ //type string, switch ...
		
		global $vidorev_theme_options;
		
		if(isset($vidorev_theme_options) && is_array($vidorev_theme_options) && isset($vidorev_theme_options[$id]) && $vidorev_theme_options[$id]!=''){
			
			switch($type){
				case 'switch':					
					if($vidorev_theme_options[$id]==1){
						return 'on';
					}else{
						return 'off';
					}
					break;
					
				case 'media_get_src':
					if(is_array($vidorev_theme_options[$id]) && isset($vidorev_theme_options[$id]['url']) && $vidorev_theme_options[$id]['url']!=''){
						return trim($vidorev_theme_options[$id]['url']);
					}else{
						return $default_value;
					}
					break;
					
				case 'media_get_id':
					if(is_array($vidorev_theme_options[$id]) && isset($vidorev_theme_options[$id]['id']) && $vidorev_theme_options[$id]['id']!=''){
						return trim($vidorev_theme_options[$id]['id']);
					}else{
						return $default_value;
					}
					break;			
			}
			
			return $vidorev_theme_options[$id];
				
		}
		
		return $default_value;
	}
endif;

if ( ! class_exists( 'Redux' ) ) {
	return;
}

load_theme_textdomain( 'vidorev', get_template_directory() . '/languages' );

$opt_name 		= 'vidorev_theme_options';
$opt_name 		= apply_filters( 'vidorev_theme_options/opt_name', $opt_name );
$theme 			= wp_get_theme();
$page_parent 	= 'themes.php';
if(defined('VPE_VER') && defined('VPE_PLUGIN_URL')){
	$page_parent 	= 'vidorev-theme-settings';
}

$args = array(
	'opt_name'             => $opt_name,
	'display_name'         => $theme->get( 'Name' ),
	'display_version'      => $theme->get( 'Version' ),
	'menu_type'            => 'submenu',
	'allow_sub_menu'       => true,
	'menu_title'           => esc_html__( 'Theme Options', 'vidorev'),
	'page_title'           => esc_html__( 'Theme Options', 'vidorev'),
	'google_api_key'       => '',
	'google_update_weekly' => false,
	'async_typography'     => true,
	'admin_bar'            => true,
	'admin_bar_icon'       => 'dashicons-portfolio',
	'admin_bar_priority'   => 50,
	'global_variable'      => 'vidorev_theme_options',
	'dev_mode'             => false,
	'update_notice'        => false,
	'customizer'           => true,
	'page_priority'        => null,
	'page_parent'          => $page_parent,
	'page_permissions'     => 'manage_options',
	'menu_icon'            => '',
	'last_tab'             => '',
	'page_icon'            => 'icon-themes',
	'page_slug'            => 'edit_theme_options',
	'save_defaults'        => true,
	'default_show'         => false,
	'default_mark'         => '',
	'show_import_export'   => true,
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	'output_tag'           => true,

	'database'             => '',
	'use_cdn'              => true,
);

if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
	if ( ! empty( $args['global_variable'] ) ) {
		$v = $args['global_variable'];
	} else {
		$v = str_replace( '-', '_', $args['opt_name'] );
	}
	
	$args['intro_text'] = 	sprintf( wp_kses(
								__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'vidorev'),
								array(
									'p'			=> array(),	
									'strong'	=> array(),																
								)
							), $v );
} else {
	$args['intro_text'] = 	wp_kses(
								__('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'vidorev'),
								array(
									'p'			=> array(),															
								)
							);
}

$args['footer_text'] = 		wp_kses(
								__('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'vidorev'),
								array(
									'p'			=> array(),															
								)
							);

Redux::setArgs( $opt_name, $args );

$yasr_get_multi_set = array( '' => esc_html__('Select an item', 'vidorev') );

if(class_exists('YasrMultiSetData') && method_exists('YasrMultiSetData', 'returnMultiSetNames')){
	
	$refl_cl_gt_bee = new ReflectionMethod('YasrMultiSetData', 'returnMultiSetNames');					
	if($refl_cl_gt_bee->isStatic() && $refl_cl_gt_bee->isPublic()){
	
		global $wpdb;
		$multi_set=YasrMultiSetData::returnMultiSetNames();
		$n_multi_set = $wpdb->num_rows;
		
		if ($n_multi_set > 0) {
			foreach ($multi_set as $name) {
				$yasr_get_multi_set[$name->set_id] = $name->set_name;
			}
		}
	
	}
}

$yasr_get_multi_set_param =	array(
								'id' 			=> 'user_rating_multi_sets',
								'type'	 		=> 'select',
								'title' 		=> esc_html__('Multiple Set', 'vidorev'),
								'desc' 			=> esc_html__('Select set for video posts', 'vidorev'),
								'default' 		=> '',
								'options'  		=> $yasr_get_multi_set,
								'required' 		=> array(
													array( 'user_rating_mode', '=', 'multi-sets' ),									
												),
							);

/*global*/
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Global Settings', 'vidorev'),
		'id'    	=> 'global',
		'icon'  	=> 'el el-globe-alt',
		'fields'	=>	array(
			array(
				'id' 		=> 'right_to_left',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('RTL Mode', 'vidorev'),
				'desc' 		=> esc_html__( 'Enable/Disable Right-to-Left language', 'vidorev'),
				'default' 	=> false,
			),
			array(
				'id' 		=> 'lazyload',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Lazyload Images', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Lazyload Images', 'vidorev'),
				'default' 	=> false,
			),
				array(
					'id' 		=> 'normal_img_effect',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fade-in Image on Scrolling', 'vidorev'),
					'desc' 		=> esc_html__('Display the matched images by fading them to opaque.', 'vidorev'),
					'default' 	=> false,
					'required' 	=> array( 'lazyload', '=', '0' ),
				),
			array(
				'id' 		=> 'number_format',
				'type'	 	=> 'select',
				'title' 	=> esc_html__('Number Format', 'vidorev'),
				'desc' 		=> esc_html__('Converts a number into a short version, eg: 1000 -> 1k', 'vidorev'),
				'default' 	=> 'short',
				'options'  	=> array(
					'short' 	=> esc_html__('Shorten long numbers to K/M/B/T', 'vidorev'),
					'full'	 	=> esc_html__('Number Format Default', 'vidorev'),					
				),
			),
			array(
				'id' 		=> 'datetime_format',
				'type'	 	=> 'select',
				'title' 	=> esc_html__('DateTime Format', 'vidorev'),
				'default' 	=> 'default',
				'options'  	=> array(
					'default' 	=> esc_html__('Default', 'vidorev'),
					'ago'	 	=> esc_html__('Time Ago', 'vidorev'),					
				),
			),
			array(
				'id' 		=> 'scroll_to_top_button',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Scroll Back To Top Button', 'vidorev'),
				'desc' 		=> esc_html__( 'Enable/Disable Scroll Back To Top Button.', 'vidorev'),
				'default' 	=> false,
			),			
		)
	));
/*global*/	

/*style settings*/
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Styling', 'vidorev'),
		'id'    	=> 'style_settings',
		'icon'  	=> 'el el-screen',
		'fields'	=>	array(
			array(
				'id' 		=> 'color_mode',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Color Mode', 'vidorev'),
				'desc' 		=> esc_html__('Select Color Mode', 'vidorev'),
				'default' 	=> 'white',
				'options'  	=> array(
					'white' 	=> array(
						'alt'   => esc_html__('Light', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/light-version.jpg'
					),
					'dark'	 	=> array(
						'alt'   => esc_html__('Dark', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/dark-version.jpg'
					),
				),
			),
				array(
					'id' 			=> 'woo_color_mode',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('WooCommerce Color Mode', 'vidorev'),
					'desc' 			=> esc_html__('Select Color Mode For WooCommerce', 'vidorev'),
					'default' 		=> '',
					'placeholder'	=> esc_html__('Default', 'vidorev'),
					'options'  		=> array(
						'' 			=> esc_html__('Default', 'vidorev'),
						'white'	 	=> esc_html__('Light', 'vidorev'),
						'dark'	 	=> esc_html__('Dark', 'vidorev'),
					),
				),
			array(
				'id' 		=> 'main_layout',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Theme Layout', 'vidorev'),
				'desc' 		=> esc_html__('Select Theme Layout', 'vidorev'),
				'default' 	=> 'wide',
				'options'  	=> array(
					'wide' 	=> array(
						'alt'   => esc_html__('Wide', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/layout-wide.jpg'
					),
					'boxed'	 	=> array(
						'alt'   => esc_html__('Inbox', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/layout-inbox.jpg'
					),
				),
			),
				array(
					'id' 		=> 'main_layout_full_with',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Full-Width Mode', 'vidorev'),
					'default' 	=> false,
					'required' 	=> array( 'main_layout', '=', 'wide' ),
				),
			array(
				'id' 		=> 'sticky_sidebar',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Sticky Sidebar', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Sticky Sidebar', 'vidorev'),
				'default' 	=> false,
			),
			array(
				'id' 		=> 'nav_breadcrumbs',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Breadcrumbs', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Breadcrumbs', 'vidorev'),
				'default' 	=> true,
			),
			array(
				'id' 		=> 'theme_sidebar',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Sidebar', 'vidorev'),
				'desc' 		=> esc_html__('Select sidebar appearance', 'vidorev'),
				'default' 	=> 'right',
				'options'  	=> array(
					'right' 	=> array(
						'alt'   => esc_html__('Right', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/2cr.png'
					),
					'left'	 	=> array(
						'alt'   => esc_html__('Left', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
					),
					'hidden'	=> array(
						'alt'   => esc_html__('Hidden', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/1col.png'
					),
				),
			),			
			array(
				'id' 		=> 'woo_sidebar',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('WooCommerce Sidebar', 'vidorev'),
				'desc' 		=> esc_html__('Select sidebar appearance', 'vidorev'),
				'default' 	=> 'right',
				'options'  	=> array(
					'right' 	=> array(
						'alt'   => esc_html__('Right', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/2cr.png'
					),
					'left'	 	=> array(
						'alt'   => esc_html__('Left', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
					),
					'hidden'	=> array(
						'alt'   => esc_html__('Hidden', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/1col.png'
					),
				),
			),			
			array(
				'id' 		=> 'bbpress_sidebar',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('BBPress Sidebar', 'vidorev'),
				'desc' 		=> esc_html__('Select sidebar appearance', 'vidorev'),
				'default' 	=> 'right',
				'options'  	=> array(
					'right' 	=> array(
						'alt'   => esc_html__('Right', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/2cr.png'
					),
					'left'	 	=> array(
						'alt'   => esc_html__('Left', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
					),
					'hidden'	=> array(
						'alt'   => esc_html__('Hidden', 'vidorev'), 
            			'img'   => ReduxFramework::$_url.'assets/img/1col.png'
					),
				),
			),
			
			array(
				'id' 			=> 'scrollbar_library',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Scrollbar Library', 'vidorev'),
				'desc' 			=> esc_html__('Select library for placements using Custom Scroll Bar. Please update the VidoRev Extensions plugin to version 2.9.9.9.7.4 or higher to use this feature!', 'vidorev'),
				'default' 		=> '',
				'placeholder'	=> esc_html__('Default', 'vidorev'),
				'options'  		=> array(
					'' 			=> esc_html__('Default', 'vidorev'),
					'malihu'	=> esc_html__('Malihu Scrollbars', 'vidorev'),
					'overlay'	=> esc_html__('Overlay Scrollbars', 'vidorev'),
				),
			),
			
			array(
				'id' 		=> 'theme_background',
				'type'	 	=> 'background',
				'title' 	=> esc_html__('Background', 'vidorev'),
			),
			array(
				'id' 		=> 'theme_css',
				'type'	 	=> 'ace_editor',
				'title' 	=> esc_html__('Custom CSS', 'vidorev'),
				'mode'		=> 'css',
			),
		)
	));
/*style settings*/	
	
/*header_settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Header', 'vidorev'),
		'id'    	=> 'header_settings',
		'icon'  	=> 'el el-cog-alt',
		'fields'	=>	array(
			array(
				'id' 			=> 'main_logo',
				'type'	 		=> 'media',				
				'title' 		=> esc_html__('Logo', 'vidorev'),
				'desc' 			=> esc_html__('Upload your logo image', 'vidorev'),
				'placeholder'	=> esc_html__('No image selected', 'vidorev'),
				'readonly'		=> false,
				'url'			=> true,
			),
			array(
				'id' 			=> 'main_logo_retina',
				'type'	 		=> 'media',				
				'title' 		=> esc_html__('Logo (Retina)', 'vidorev'),
				'desc' 			=> esc_html__('Retina logo should be two time bigger than the custom logo. Retina Logo is optional, use this setting if you want to strictly support retina devices', 'vidorev'),
				'placeholder'	=> esc_html__('No image selected', 'vidorev'),
				'readonly'		=> false,
				'url'			=> true,
			),
			array(
				'id' 			=> 'main_logo_mobile',
				'type'	 		=> 'media',				
				'title' 		=> esc_html__('Main logo on mobile devices', 'vidorev'),
				'desc' 			=> esc_html__('Upload your logo image for mobile devices', 'vidorev'),
				'placeholder'	=> esc_html__('No image selected', 'vidorev'),
				'readonly'		=> false,
				'url'			=> true,
			),
			array(
				'id' 			=> 'main_logo_mobile_retina',
				'type'	 		=> 'media',				
				'title' 		=> esc_html__('Main logo on mobile devices (Retina)', 'vidorev'),
				'placeholder'	=> esc_html__('No image selected', 'vidorev'),
				'readonly'		=> false,
				'url'			=> true,
			),
			array(
				'id' 			=> 'sticky_logo',
				'type'	 		=> 'media',				
				'title' 		=> esc_html__('Logo for Sticky Menu', 'vidorev'),
				'desc' 			=> esc_html__('Upload your logo image for sticky menu', 'vidorev'),
				'placeholder'	=> esc_html__('No image selected', 'vidorev'),
				'readonly'		=> false,
				'url'			=> true,
			),
			array(
				'id' 			=> 'sticky_logo_retina',
				'type'	 		=> 'media',				
				'title' 		=> esc_html__('Logo for Sticky Menu (Retina)', 'vidorev'),
				'placeholder'	=> esc_html__('No image selected', 'vidorev'),
				'readonly'		=> false,
				'url'			=> true,
			),
			array(
				'id' 		=> 'main_nav_layout',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Main Navigation Layout', 'vidorev'),
				'desc' 		=> esc_html__('Select Navigation Layout', 'vidorev'),
				'default' 	=> 'default',
				'options'  	=> array(
					'default' 	=> array(
						'alt'   => esc_html__('Default', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/header-1.jpg'
					),
					'classic'	 	=> array(
						'alt'   => esc_html__('Classic', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/header-6.jpg'
					),
					'sport'	 	=> array(
						'alt'   => esc_html__('Sport', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/header-2.jpg'
					),
					'tech'	 	=> array(
						'alt'   => esc_html__('Tech', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/header-5.jpg'
					),
					'blog'	 	=> array(
						'alt'   => esc_html__('Blog', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/header-3.jpg'
					),
					'movie'	 	=> array(
						'alt'   => esc_html__('Movie', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/header-4.jpg'
					),
					'side'	 	=> array(
						'alt'   => esc_html__('Side', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/header-7.jpg'
					),
				),
			),
				array(
					'id' 		=> 'ajax_search',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Ajax Search', 'vidorev'),
					'desc'      => esc_html__('Enable/Disable Ajax Search. You will need to install Ajax Search Lite plugin', 'vidorev'),				
					'default' 	=> false,
					'required' 	=> array( 'main_nav_layout', '=', 'side' ),
				),
			array(
				'id' 		=> 'mega_menu',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Mega Menu', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Mega Menu', 'vidorev'),
				'default' 	=> false,
			),
				array(
					'id' 		=> 'mega_menu_pag',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Mega Menu Pagination', 'vidorev'),
					'desc' 		=> esc_html__('Enable/Disable Mega Menu Pagination', 'vidorev'),
					'default' 	=> false,					
					'required' => array( 'mega_menu', '=', '1' ),
				),
			array(
				'id' 		=> 'sticky_menu',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Sticky Menu', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Sticky Menu', 'vidorev'),
				'default' 	=> false,
			),			
				array(
					'id' 		=> 'sticky_menu_behavior',
					'type'	 	=> 'select',
					'title' 	=> esc_html__('Select Sticky Menu Behavior', 'vidorev'),
					'default' 	=> 'scroll_up',
					'options'  	=> array(
						'scroll_up' 	=> esc_html__('Only appears when page is Scrolled Up', 'vidorev'),
						'scroll_down'	=> esc_html__('Always Sticky', 'vidorev'),					
					),
					'required' => array( 'sticky_menu', '=', '1' ),
				),
			array(
				'id' 		=> 'latest_news',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Latest News', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Latest News. Get latest posts without video.', 'vidorev'),
				'default' 	=> false,
			),
				array(
					'id' 		=> 'latest_news_title',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Latest News] Title', 'vidorev'),
					'desc' 		=> esc_html__('Enter Title for Latest News section', 'vidorev'),
					'required' 	=> array( 'latest_news', '=', '1' ),
				),
				array(
					'id' 		=> 'latest_news_ic',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Latest News] Include Categories', 'vidorev'),
					'desc' 		=> esc_html__('Include categories, enter category id or slug, eg: 245, 126, ...', 'vidorev'),
					'required' 	=> array( 'latest_news', '=', '1' ),
				),
				array(
					'id' 		=> 'latest_news_it',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Latest News] Include Tags', 'vidorev'),
					'desc' 		=> esc_html__('Include tags, enter tag id or slug, eg: 19, 368, ...', 'vidorev'),
					'required' 	=> array( 'latest_news', '=', '1' ),
				),
				array(
					'id' 		=> 'latest_news_pt',
					'type'	 	=> 'select',
					'title' 	=> esc_html__('[Latest News] Post Type', 'vidorev'),
					'default' 	=> 'post-without-video',
					'options'  	=> array(
						'post-without-video' 	=> esc_html__('Post ( without video posts )', 'vidorev'),
						'post' 					=> esc_html__('Post ( all posts )', 'vidorev'),
						'post-video'			=> esc_html__('Post - Video', 'vidorev'),					
					),
					'required' => array( 'latest_news', '=', '1' ),
				),
			array(
				'id' 		=> 'login_user_btn',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Login/User Icon', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Login/User Icon', 'vidorev'),
				'default' 	=> true,
			),
				array(
					'id' 			=> 'login_page',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Login Page', 'vidorev'),
					'desc' 			=> esc_html__('Update this field if you use another login plugin', 'vidorev'),
					'data'			=> 'page',
					'required' 		=> array( 'login_user_btn', '=', '1' ),	
				),	
				array(
					'id' 			=> 'lost_password_page',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Lost Password Page', 'vidorev'),
					'desc' 			=> esc_html__('Update this field if you use another login plugin', 'vidorev'),
					'data'			=> 'page',
					'required' 		=> array( 'login_user_btn', '=', '1' ),	
				),
				array(
					'id' 			=> 'register_page',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Register Page', 'vidorev'),
					'desc' 			=> esc_html__('Update this field if you use another login plugin', 'vidorev'),
					'data'			=> 'page',
					'required' 		=> array( 'login_user_btn', '=', '1' ),	
				),
				array(
					'id' 			=> 'profile_page',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Profile Page', 'vidorev'),
					'desc' 			=> esc_html__('Update this field if you use another login plugin', 'vidorev'),
					'data'			=> 'page',
					'required' 		=> array( 'login_user_btn', '=', '1' ),	
				),
				array(
					'id' 		=> 'login_shortcode',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Login Shortcode', 'vidorev'),
					'desc' 		=> esc_html__('Use for locations that require login.', 'vidorev'),
					'required' 	=> array( 'login_user_btn', '=', '1' ),
				),		
			array(
				'id' 		=> 'submit_video',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Submit Video', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable User Submit Video', 'vidorev'),
				'default' 	=> false,
			),
				array(
					'id' 		=> 'submit_video_text',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Submit Video] Text', 'vidorev'),
					'desc' 		=> esc_html__('Enter text for submit video button', 'vidorev'),
					'required' 	=> array( 'submit_video', '=', '1' ),
				),
				array(
					'id' 			=> 'submit_video_page',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('[Submit Video] Page', 'vidorev'),
					'desc' 			=> esc_html__('This sets the base your "submit video page". You will need to install Contact Form 7 plugin', 'vidorev'),
					'data'			=> 'page',
					'required' 		=> array( 'submit_video', '=', '1' ),	
				),	
				array(
					'id' 		=> 'submit_video_shortcode',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Submit Video] Video Submit Shortcode', 'vidorev'),
					'desc' 		=> esc_html__('Enter shortcode for submit video form', 'vidorev'),
					'required' 	=> array( 'submit_video', '=', '1' ),
				),
				array(
					'id' 		=> 'submit_channel_shortcode',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Submit Video] Channel Submit Shortcode', 'vidorev'),
					'desc' 		=> esc_html__('Enter shortcode for submit channel form', 'vidorev'),
					'required' 	=> array( 'submit_video', '=', '1' ),
				),
				array(
					'id' 		=> 'submit_playlist_shortcode',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Submit Video] Playlist Submit Shortcode', 'vidorev'),
					'desc' 		=> esc_html__('Enter shortcode for submit playlist form', 'vidorev'),
					'required' 	=> array( 'submit_video', '=', '1' ),
				),
				array(
					'id' 		=> 'custom_submit_polylang',
					'type'	 	=> 'slides',
					'title' 	=> esc_html__('[Submit Video] For Polylang.', 'vidorev'),
					'desc' 		=> esc_html__('Additional video posting pages for other languages.', 'vidorev'),
					'required' 	=> array( 'submit_video', '=', '1' ),
					'show' 		=> array(
								'title' 		=> true,
								'description' 	=> true,
								'url' 			=> true,						
					),
					'placeholder' => array(
						'title'           => esc_html__('Language', 'vidorev'),
						'description'     => esc_html__('Shortcodes separated by commas. Order: [shortcode for submit video form], [shortcode for submit channel form], [shortcode for submit playlist form]. Eg: [contact-form-7 id="5200" title="Submit Video"], [contact-form-7 id="4380" title="Submit Channel"], [contact-form-7 id="4379" title="Submit Playlist"]. You create additional video submission forms via CF7.', 'vidorev'),
						'url'			  => esc_html__('Page ID: Enter the ID of the page generated by Polylang. Eg: 1104, 2067', 'vidorev')
					),
				),
				
			array(
				'id' 		=> 'top_menu',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Top Menu', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Top Menu.', 'vidorev'),
				'default' 	=> false,
			),
				array(
					'id' 			=> 'top_menu_position',
					'type'	 		=> 'select',
					'default' 		=> 'left',
					'title' 		=> esc_html__('[Top Menu] Position', 'vidorev'),
					'options'  	=> array(
						'left' 		=> esc_html__('LEFT', 'vidorev'),
						'right' 	=> esc_html__('RIGHT', 'vidorev'),
						'b-right' 	=> esc_html__('Before Social', 'vidorev'),								
					),
					'required' 		=> array( 'top_menu', '=', '1' ),	
				),	
			array(
				'id' 		=> 'header_background',
				'type'	 	=> 'background',
				'title' 	=> esc_html__('Header Background', 'vidorev'),
			),
			array(
				'id' 		=> 'mobile_menu_background',
				'type'	 	=> 'background',
				'title' 	=> esc_html__('Mobile Menu Background', 'vidorev'),
			),	
		)
	));
/*header_settings*/	
	
/*footer_settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Footer', 'vidorev'),
		'id'    	=> 'footer_settings',
		'icon'  	=> 'el el-cog-alt',
		'fields'	=>	array(
			array(
				'id' 		=> 'popular_videos',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Popular Videos', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Popular Videos. You will need to install Post Views Counter plugin.', 'vidorev'),
				'default' 	=> false,
			),
				array(
					'id' 		=> 'popular_videos_title_1',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Popular Videos] Title 1', 'vidorev'),
					'desc' 		=> esc_html__('Enter Title for Popular Videos section', 'vidorev'),
					'required' 	=> array( 'popular_videos', '=', '1' ),
				),
				array(
					'id' 		=> 'popular_videos_title_2',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Popular Videos] Title 2', 'vidorev'),
					'desc' 		=> esc_html__('Enter Title for Popular Videos section', 'vidorev'),
					'required' 	=> array( 'popular_videos', '=', '1' ),
				),
				array(
					'id' 		=> 'popular_videos_ic',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Popular Videos] Include Categories', 'vidorev'),
					'desc' 		=> esc_html__('Include categories, enter category id or slug, eg: 245, 126, ...', 'vidorev'),
					'required' 	=> array( 'popular_videos', '=', '1' ),
				),
				array(
					'id' 		=> 'popular_videos_it',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('[Popular Videos] Include Tags', 'vidorev'),
					'desc' 		=> esc_html__('Include tags, enter tag id or slug, eg: 19, 368, ...', 'vidorev'),
					'required' 	=> array( 'popular_videos', '=', '1' ),
				),
			array(
				'id' 		=> 'instagram_feed',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Instagram Feed', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Instagram Feed. You will need to install Instagram Feed plugin', 'vidorev'),
				'default' 	=> false,
			),	
				array(
					'id' 		=> 'instagram_feed_position',
					'type'	 	=> 'select',
					'title' 	=> esc_html__('Instagram Feed Display Position', 'vidorev'),
					'default' 	=> 'header',
					'options'  	=> array(
						'header' 	=> esc_html__('HEADER', 'vidorev'),
						'footer'	=> esc_html__('FOOTER', 'vidorev'),					
					),
					'required' => array( 'instagram_feed', '=', '1' ),
				),
			array(
				'id' 		=> 'footer_copyright',
				'type'	 	=> 'editor',
				'title' 	=> esc_html__('Fotter Copyright Text', 'vidorev'),
			),	
		)
	));
/*footer_settings*/	
	
/*color_typography*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Color & Typography', 'vidorev'),
		'id'    	=> 'color_typography',
		'icon'  	=> 'el el-css',
		'fields'	=>	array(
			array(
				'id' 			=> 'main_skin_color',
				'type'	 		=> 'color',
				'title' 		=> esc_html__('Main Skin Color', 'vidorev'),
				'desc' 			=> esc_html__('Choose main skin color', 'vidorev'),
				'transparent' 	=> false
			),			
			array(
				'id' 			=> 'main_color_mixing',
				'type'	 		=> 'slider',
				'title' 		=> esc_html__('Main Color Mixing (with black)', 'vidorev'),
				'desc' 			=> esc_html__('Default: 0.10', 'vidorev'),
				'min'			=> 0,
				'max'			=> 1,
				'step'			=> 0.01,
				'default'		=> 0.1,
				'resolution'	=> 0.01,
			),
			array(
				'id' 			=> 'sub_skin_color',
				'type'	 		=> 'color',
				'title' 		=> esc_html__('Sub Skin Color', 'vidorev'),
				'desc' 			=> esc_html__('Choose sub skin color', 'vidorev'),
				'transparent' 	=> false
			),
			
			array(
				'id' 			=> 'main-font-section',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('Main Font', 'vidorev'),
				'indent' => true 
			),		
			
				array(
					'id' 				=> 'main_font',
					'type'	 			=> 'typography',
					'units'				=> 'em',
					'title' 			=> esc_html__('Main Font Settings', 'vidorev'),
					'text-align'		=> false,
					'text-transform'	=> true,
					'color'				=> false,
					'letter-spacing'	=> true,
					'font-size'			=> false,
				),
				array(
					'id' 			=> 'main_font_scale',
					'type'	 		=> 'slider',
					'title' 		=> esc_html__('Main Font Scale', 'vidorev'),
					'desc' 			=> esc_html__('Default: 1.00', 'vidorev'),
					'min'			=> 0.5,
					'max'			=> 3,
					'step'			=> 0.01,
					'default'		=> 1,
					'resolution'	=> 0.01,
				),
			
			array(
				'id' 			=> 'heading-font-section',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('Heading Font', 'vidorev'),
				'indent' => true 
			),
				array(
					'id' 				=> 'hea_font',
					'type'	 			=> 'typography',
					'units'				=> 'em',
					'title' 			=> esc_html__('Heading Font Settings', 'vidorev'),
					'text-align'		=> false,
					'text-transform'	=> true,
					'color'				=> false,
					'letter-spacing'	=> true,
					'font-size'			=> false,
				),	
				array(
					'id' 			=> 'hea_font_scale',
					'type'	 		=> 'slider',
					'title' 		=> esc_html__('Heading Font Scale', 'vidorev'),
					'desc' 			=> esc_html__('Default: 1.00', 'vidorev'),
					'min'			=> 0.5,
					'max'			=> 3,
					'step'			=> 0.01,
					'default'		=> 1,
					'resolution'	=> 0.01,
				),
				
			array(
				'id' 			=> 'nav-font-section',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('Navigation Font', 'vidorev'),
				'indent' => true 
			),	
				array(
					'id' 				=> 'nav_font',
					'type'	 			=> 'typography',
					'units'				=> 'em',
					'title' 			=> esc_html__('Navigation Font Settings', 'vidorev'),
					'text-align'		=> false,
					'text-transform'	=> true,
					'color'				=> false,
					'letter-spacing'	=> true,
					'font-size'			=> false,
				),
				array(
					'id' 			=> 'nav_font_scale',
					'type'	 		=> 'slider',
					'title' 		=> esc_html__('Navigation Font Scale', 'vidorev'),
					'desc' 			=> esc_html__('Default: 1.00', 'vidorev'),
					'min'			=> 0.5,
					'max'			=> 3,
					'step'			=> 0.01,
					'default'		=> 1,
					'resolution'	=> 0.01,
				),
				
			array(
				'id' 			=> 'meta-font-section',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('Meta Font', 'vidorev'),
				'indent' => true 
			),		
				array(
					'id' 				=> 'meta_font',
					'type'	 			=> 'typography',
					'units'				=> 'em',
					'title' 			=> esc_html__('Meta Font Settings', 'vidorev'),
					'text-align'		=> false,
					'text-transform'	=> true,
					'color'				=> false,
					'letter-spacing'	=> true,
					'font-size'			=> false,
				),
				array(
					'id' 			=> 'meta_font_scale',
					'type'	 		=> 'slider',
					'title' 		=> esc_html__('Meta Font Scale', 'vidorev'),
					'desc' 			=> esc_html__('Default: 1.00', 'vidorev'),
					'min'			=> 0.5,
					'max'			=> 3,
					'step'			=> 0.01,
					'default'		=> 1,
					'resolution'	=> 0.01,
				),
		)
	));
/*color_typography*/	
	
/*Blog Settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Blog Settings', 'vidorev'),
		'id'    	=> 'blog_settings',
		'icon'  	=> 'el el-view-mode',
		'fields'	=>	array(
			array(
				'id' 			=> 'archive_sidebar',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Sidebar', 'vidorev'),
				'desc' 			=> esc_html__('Select "Default" to use settings in Theme Options > Styling', 'vidorev'),
				'default' 		=> '',
				'placeholder'	=> esc_html__('Default', 'vidorev'),
				'options'  		=> array(
					'' 			=> esc_html__('Default', 'vidorev'),
					'right'	 	=> esc_html__('Right', 'vidorev'),
					'left'	 	=> esc_html__('Left', 'vidorev'),
					'hidden'	=> esc_html__('Hidden', 'vidorev'),
				),
			),
			array(
				'id' 		=> 'archive_loop_style',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Archive Loop Style', 'vidorev'),
				'desc' 		=> esc_html__('Select Archive Loop Style', 'vidorev'),
				'default' 	=> 'list-blog',
				'options'  	=> array(
					'grid-default'	=> array(
						'alt'   => esc_html__('Grid - Default', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/grid-default.jpg'
					),
					'list-default'	=> array(
						'alt'   => esc_html__('List - Default', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/list-default.jpg'
					),
					'grid-special'	=> array(
						'alt'   => esc_html__('Grid - Special', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/grid-special.jpg'
					),
					'list-special'	=> array(
						'alt'   => esc_html__('List - Special', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/list-special.jpg'
					),
					'grid-modern'	=> array(
						'alt'   => esc_html__('Grid - Modern', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/grid-modern.jpg'
					),
					'movie-grid'	=> array(
						'alt'   => esc_html__('Grid - Poster', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/grid-poster.jpg'
					),
					'list-blog'	=> array(
						'alt'   => esc_html__('List - Blog Wide', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/list-blog.jpg'
					),
					'movie-list'	=> array(
						'alt'   => esc_html__('List - Poster', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/list-poster.jpg'
					),
					'grid-small'	=> array(
						'alt'   => esc_html__('Grid - Small', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/grid-small.jpg'
					),
					/*new layout*/
				),				
			),
			array(
				'id' 		=> 'blog_alphabet_filter',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Alphabet Filter', 'vidorev'),				
				'default' 	=> true,
			),
				array(
					'id' 		=> 'blog_alphabet_filter_list',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Local Alphabet', 'vidorev'),
					'desc' 		=> esc_html__('Enter your country\'s alphabet here. The letters are separated by commas. Example: A,B,C,D,E... If blank, the English alphabet is the default.', 'vidorev'),					
					'required' 	=> array( 'blog_alphabet_filter', '=', '1' ),
				),
			array(
				'id' 			=> 'blog_image_ratio',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Image Ratio', 'vidorev'),
				'desc' 			=> esc_html__('This option will change the ratio of the image for the archive pages on your theme.', 'vidorev'),
				'default' 		=> '',
				'placeholder'	=> esc_html__('Default', 'vidorev'),
				'options'  		=> array(
					'' 			=> esc_html__('Default', 'vidorev'),
					'16_9'	 	=> esc_html__('Video - 16:9', 'vidorev'),
					'4_3'	 	=> esc_html__('Blog - 4:3', 'vidorev'),
					'2_3'		=> esc_html__('Movie - 2:3', 'vidorev'),
				),
			),
			array(
				'id' 			=> 'caterory_desc_post',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Location of Category Description', 'vidorev'),
				'default' 		=> 'top',
				'options'  		=> array(
					'top' 		=> esc_html__('TOP', 'vidorev'),
					'bottom'	=> esc_html__('BOTTOM', 'vidorev'),
				),
			),
			array(
				'id' 		=> 'blog_image_lightbox',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Lightbox Icon', 'vidorev'),				
				'default' 	=> false,
			),
			array(
				'id' 		=> 'blog_show_categories',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Categories', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'blog_show_excerpt',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Excerpt', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'blog_show_author',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Author', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'blog_show_date',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Published Date', 'vidorev'),				
				'default' 	=> true,
			),
				array(
					'id' 		=> 'blog_show_updated_date',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Last Updated Date', 'vidorev'),				
					'default' 	=> false,
					'required' 	=> array( 'blog_show_date', '=', '1' ),
				),
			array(
				'id' 		=> 'blog_show_comment_count',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Comment Count', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'blog_show_view_count',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post View Count', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'blog_show_like_count',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Like Count', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'blog_show_dislike_count',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Dislike Count', 'vidorev'),				
				'default' 	=> true,
			),			
			array(
				'id' 			=> 'blog_pag_type',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Pagination', 'vidorev'),
				'desc' 			=> esc_html__('Choose type of navigation for blog and any listing page. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev'),
				'default' 		=> 'wp-default',
				'options'  		=> array(
					'wp-default' 		=> esc_html__('WordPress Default', 'vidorev'),
					'loadmore-btn'	 	=> esc_html__('Load More Button (Ajax)', 'vidorev'),
					'infinite-scroll'	=> esc_html__('Infinite Scroll (Ajax)', 'vidorev'),
					'pagenavi_plugin'	=> esc_html__('WP PageNavi (Plugin)', 'vidorev'),
				),
			),
		)
	));
/*Blog Settings*/	
	
/*Single Page Settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Single Page Settings', 'vidorev'),
		'id'    	=> 'single_page_settings',
		'icon'  	=> 'el el-cog-alt',
		'fields'	=>	array(
			array(
				'id' 			=> 'single_page_sidebar',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Sidebar', 'vidorev'),
				'desc' 			=> esc_html__('Select "Default" to use settings in Theme Options > Styling', 'vidorev'),
				'default' 		=> '',
				'placeholder'	=> esc_html__('Default', 'vidorev'),
				'options'  		=> array(
					'' 			=> esc_html__('Default', 'vidorev'),
					'right'	 	=> esc_html__('Right', 'vidorev'),
					'left'	 	=> esc_html__('Left', 'vidorev'),
					'hidden'	=> esc_html__('Hidden', 'vidorev'),
				),
			),
			array(
				'id' 		=> 'single_page_comment',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Page Comments', 'vidorev'),
				'desc' 		=> esc_html__('Enable/Disable Page Comments', 'vidorev'),			
				'default' 	=> true,
			),
		)
	));
/*Single Page Settings*/

/*Single Post Settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Single Post Settings', 'vidorev'),
		'id'    	=> 'single_post_settings',
		'icon'  	=> 'el el-cog-alt',
		'fields'	=>	array(
			array(
				'id' 		=> 'feature_image_position',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Feature Image Position', 'vidorev'),
				'desc' 		=> esc_html__('Select default feature image position for standard posts', 'vidorev'),
				'default' 	=> 'special',
				'options'  	=> array(
					'basic'		=> array(
						'alt'   => esc_html__('Basic', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-post-standard-basic.jpg'
					),
					'full-width'=> array(
						'alt'   => esc_html__('Full Width', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-post-standard-full-width.jpg'
					),
					'special'	=> array(
						'alt'   => esc_html__('Special', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-post-standard-special.jpg'
					),					
				),				
			),
			array(
				'id' 		=> 'gallery_position',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Gallery Position', 'vidorev'),
				'desc' 		=> esc_html__('Select default gallery position for gallery posts', 'vidorev'),
				'default' 	=> 'basic',
				'options'  	=> array(
					'basic'		=> array(
						'alt'   => esc_html__('Basic', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-post-gallery-basic.jpg'
					),					
					'special'	=> array(
						'alt'   => esc_html__('Special', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-post-gallery-special.jpg'
					),					
				),				
			),
			array(
				'id' 		=> 'quote_position',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Quote Position', 'vidorev'),
				'desc' 		=> esc_html__('Select default quote position for quote posts', 'vidorev'),
				'default' 	=> 'basic',
				'options'  	=> array(
					'basic'		=> array(
						'alt'   => esc_html__('Basic', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-post-quote-basic.jpg'
					),					
					'special'	=> array(
						'alt'   => esc_html__('Special', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-post-quote-special.jpg'
					),					
				),				
			),
			array(
				'id' 			=> 'single_post_sidebar',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Sidebar', 'vidorev'),
				'desc' 			=> esc_html__('Select "Default" to use settings in Theme Options > Styling', 'vidorev'),
				'default' 		=> '',
				'placeholder'	=> esc_html__('Default', 'vidorev'),
				'options'  		=> array(
					'' 			=> esc_html__('Default', 'vidorev'),
					'right'	 	=> esc_html__('Right', 'vidorev'),
					'left'	 	=> esc_html__('Left', 'vidorev'),
					'hidden'	=> esc_html__('Hidden', 'vidorev'),
				),
			),
			array(
				'id' 		=> 'single_post_show_categories',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Categories', 'vidorev'),				
				'default' 	=> false,
			),
			array(
				'id' 		=> 'single_post_show_author',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Author', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'single_post_show_date',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Published Date', 'vidorev'),				
				'default' 	=> true,
			),
				array(
					'id' 		=> 'single_post_show_updated_date',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Last Updated Date', 'vidorev'),				
					'default' 	=> false,
					'required' 	=> array( 'single_post_show_date', '=', '1' ),
				),
			array(
				'id' 		=> 'single_post_show_comment_count',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Comment Count', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'single_post_show_view_count',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post View Count', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'single_post_show_like_count',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Like Count', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'single_post_show_dislike_count',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Dislike Count', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'single_post_footer_like_dislike',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Like/Dislike Button ( At the bottom of the post )', 'vidorev'),
				'desc'      => esc_html__('Show/Hide Like/Dislike Button', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'single_post_tags',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Tags', 'vidorev'),
				'desc'      => esc_html__('Show/Hide Post Tags', 'vidorev'),			
				'default' 	=> true,
			),
			array(
				'id' 		=> 'single_post_social_share',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Social Sharing Buttons', 'vidorev'),
				'desc'      => esc_html__('Show/Hide Social Sharing Buttons', 'vidorev'),				
				'default' 	=> false,
			),
			array(
				'id' 		=> 'single_post_nav',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Post Navigation', 'vidorev'),
				'desc'      => esc_html__('Show/hide Post Navigation (Prev & Next post)', 'vidorev'),				
				'default' 	=> true,
			),
			array(
				'id' 		=> 'single_post_author',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Author Info Box', 'vidorev'),
				'desc'      => esc_html__('Show/hide Author section in Single Post', 'vidorev'),				
				'default' 	=> false,
			),
			array(
				'id' 		=> 'single_post_related',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Related Posts', 'vidorev'),	
				'desc'      => esc_html__('Show/hide Related Posts section', 'vidorev'),			
				'default' 	=> false,
			),
				array(
					'id' 		=> 'single_post_related_title',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Related Post Header Title', 'vidorev'),
					'desc' 		=> esc_html__('Enter Title for Related Posts section', 'vidorev'),
					'required' 	=> array( 'single_post_related', '=', '1' ),
					'default'	=> esc_html__('Related posts', 'vidorev'),
				),
				array(
					'id' 			=> 'single_post_related_query',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Related Posts - Query', 'vidorev'),					
					'default' 		=> 'same-category',
					'options'  		=> array(
						'same-category' 	=> esc_html__('Querying posts from same Categories', 'vidorev'),
						'same-tag'	 		=> esc_html__('Querying posts from same Tags', 'vidorev'),
					),
					'required' 	=> array( 'single_post_related', '=', '1' ),
				),
				array(
					'id' 		=> 'single_post_related_format',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Related Posts - Query With Post Format', 'vidorev'),
					'desc' 		=> esc_html__('When inside a video post it will only retrieve the video post', 'vidorev'),
					'default' 	=> false,
				),
				array(
					'id' 			=> 'single_post_related_order',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Related Posts - Order By', 'vidorev'),					
					'default' 		=> 'latest',
					'options'  		=> array(
						'latest' 		=> esc_html__('Latest', 'vidorev'),
						'most-viewed'	=> esc_html__('Most Viewed', 'vidorev'),
						'most-liked'	=> esc_html__('Most Liked', 'vidorev'),
						'random'	 	=> esc_html__('Random', 'vidorev'),
					),
					'required' 	=> array( 'single_post_related', '=', '1' ),
				),
				array(
					'id' 		=> 'single_post_related_count',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Related Post - Count', 'vidorev'),
					'desc' 		=> esc_html__('Number of related posts', 'vidorev'),
					'required' 	=> array( 'single_post_related', '=', '1' ),
					'default'	=> 6,
				),
			array(
				'id' 		=> 'single_post_comment',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Post Comments', 'vidorev'),
				'desc'      => esc_html__('Enable/Disable Post Comments', 'vidorev'),				
				'default' 	=> true,
			),
				array(
					'id' 			=> 'single_post_comment_type',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Comment Type', 'vidorev'),					
					'default' 		=> 'wp',
					'options'  		=> array(
						'wp' 			=> esc_html__('WordPress Comment', 'vidorev'),
						'facebook'		=> esc_html__('Facebook Comment', 'vidorev'),						
					),
					'required' 	=> array( 'single_post_comment', '=', '1' ),
				),
		)
	));
/*Single Post Settings*/	

/*lightbox_settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Video Lightbox Settings', 'vidorev'),
		'id'    	=> 'lightbox_settings',
		'icon'  	=> 'el el-video-alt',
		'fields'	=>	array(
			array(
				'id' 		=> 'video_lightbox',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Display Video Lightbox Icon', 'vidorev'),
				'desc'      => esc_html__('Enable/Disable Video Lightbox', 'vidorev'),				
				'default' 	=> true,
			),
				array(
					'id' 		=> 'video_title',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Video Title', 'vidorev'),
					'desc'      => esc_html__('Enable/Disable Video Title', 'vidorev'),				
					'default' 	=> false,
				),				
				array(
					'id' 			=> 'video_lightbox_gallery',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Action', 'vidorev'),					
					'default' 		=> 'gallery',
					'options'  		=> array(
						'gallery' 		=> esc_html__('Gallery', 'vidorev'),
						'hyperlink'		=> esc_html__('HyperLink', 'vidorev'),						
					),
					'required' 	=> array( 'video_lightbox', '=', '1' ),
				),
				array(
					'id' 		=> 'video_lightbox_suggested',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Suggested Posts', 'vidorev'),
					'desc'      => esc_html__('Enable/Disable Suggested Posts on Lightbox', 'vidorev'),				
					'default' 	=> true,
					'required' 	=> array( 'video_lightbox', '=', '1' ),
				),
					array(
						'id' 			=> 'video_lightbox_suggested_layout',
						'type'	 		=> 'select',
						'title' 		=> esc_html__('Suggested Post Layout', 'vidorev'),					
						'default' 		=> 'default',
						'options'  		=> array(
							'default' 		=> esc_html__('Default', 'vidorev'),
							'special'		=> esc_html__('Special', 'vidorev'),						
						),
						'required' 	=> array(
											array( 'video_lightbox', '=', '1' ),
											array( 'video_lightbox_suggested', '=', '1' ),
										),
					),
					array(
						'id' 			=> 'video_lightbox_suggested_query',
						'type'	 		=> 'select',
						'title' 		=> esc_html__('Suggested Posts - Query', 'vidorev'),					
						'default' 		=> 'same-category',
						'options'  		=> array(
							'same-category' 	=> esc_html__('Querying posts from same Categories', 'vidorev'),
							'same-tag'	 		=> esc_html__('Querying posts from same Tags', 'vidorev'),
							'same-playlist'	 	=> esc_html__('Querying posts from same Playlist', 'vidorev'),
							'same-series'	 	=> esc_html__('Querying posts from same Series', 'vidorev'),
						),
						'required' 		=> array(
											array( 'video_lightbox', '=', '1' ),
											array( 'video_lightbox_suggested', '=', '1' ),
										),
					),
					array(
						'id' 			=> 'video_lightbox_suggested_order',
						'type'	 		=> 'select',
						'title' 		=> esc_html__('Suggested Posts - Order By', 'vidorev'),					
						'default' 		=> 'latest',
						'options'  		=> array(
							'latest' 		=> esc_html__('Newest Items', 'vidorev'),
							'oldest' 		=> esc_html__('Oldest Items', 'vidorev'),
							'most-viewed'	=> esc_html__('Most Viewed', 'vidorev'),
							'most-liked'	=> esc_html__('Most Liked', 'vidorev'),
							'random'	 	=> esc_html__('Random', 'vidorev'),
							'preserve_pid'	=> esc_html__('Preserve post ID order ( for the same Playlist and Series )', 'vidorev'),
							'title-desc' 	=> esc_html__('Title - Descending', 'vidorev'),
							'title-asc' 	=> esc_html__('Title - Ascending', 'vidorev'),
						),
						'required' 		=> array(
											array( 'video_lightbox', '=', '1' ),
											array( 'video_lightbox_suggested', '=', '1' ),
										),
					),
					array(
						'id' 		=> 'video_lightbox_suggested_count',
						'type'	 	=> 'text',
						'title' 	=> esc_html__('Suggested Posts - Count', 'vidorev'),
						'desc' 		=> esc_html__('Number of suggested posts', 'vidorev'),
						'required' 		=> array(
											array( 'video_lightbox', '=', '1' ),
											array( 'video_lightbox_suggested', '=', '1' ),
										),
						'default'	=> 15,
					),
					
					array(
						'id' 		=> 'video_lightbox_suggested_count',
						'type'	 	=> 'text',
						'title' 	=> esc_html__('Suggested Posts - Count', 'vidorev'),
						'desc' 		=> esc_html__('Number of suggested posts', 'vidorev'),
						'required' 		=> array(
											array( 'video_lightbox', '=', '1' ),
											array( 'video_lightbox_suggested', '=', '1' ),
										),
						'default'	=> 15,
					),
					array(
						'id' 			=> 'video_lightbox_link_action',
						'type'	 		=> 'select',
						'title' 		=> esc_html__('Interactive', 'vidorev'),					
						'default' 		=> 'lightbox',
						'options'  		=> array(
							'lightbox' 		=> esc_html__('Open in Lightbox', 'vidorev'),
							'post'			=> esc_html__('Go To Post', 'vidorev'),
						),
						'required' 		=> array(
											array( 'video_lightbox', '=', '1' ),
											array( 'video_lightbox_suggested', '=', '1' ),
										),
					),
					
				array(
					'id' 		=> 'video_lightbox_comments',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Comments', 'vidorev'),
					'desc'      => esc_html__('Enable/Disable Comments on Lightbox', 'vidorev'),				
					'default' 	=> true,
					'required' 	=> array( 'video_lightbox', '=', '1' ),
				),
		)
	));
/*lightbox_settings*/	

/*Single Video Settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Single Video Settings', 'vidorev'),
		'id'    	=> 'single_video_settings',
		'icon'  	=> 'el el-facetime-video',
		'fields'	=>	array(
			array(
				'id' 		=> 'single_video_style',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Style', 'vidorev'),
				'desc' 		=> esc_html__('Select single video style', 'vidorev'),
				'default' 	=> 'basic',
				'options'  	=> array(
					'basic'	=> array(
						'alt'   => esc_html__('Basic', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/video-s-1.png'
					),
					'clean'=> array(
						'alt'   => esc_html__('Clean', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/video-s-2.png'
					),									
				),				
			),
			array(
				'id' 		=> 'video_player_position',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Video Player Position', 'vidorev'),
				'desc' 		=> esc_html__('Select default video player position for video posts', 'vidorev'),
				'default' 	=> 'basic',
				'options'  	=> array(
					'basic'		=> array(
						'alt'   => esc_html__('Basic', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-video-basic.jpg'
					),
					'full-width'=> array(
						'alt'   => esc_html__('Full Width', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-video-theater.jpg'
					),
					'special'	=> array(
						'alt'   => esc_html__('Special', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/single-video-special.jpg'
					),					
				),				
			),
			array(
				'id' 			=> 'video_ps_link_action',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Automatically apply elements', 'vidorev'),
				'default' 		=> 'no',
				'options'  		=> array(
					'no' 			=> esc_html__('NO', 'vidorev'),
					'playlist' 		=> esc_html__('Display Playlist', 'vidorev'),
					'series'	 	=> esc_html__('Display Series', 'vidorev'),
					'both'			=> esc_html__('Display Playlist & Series', 'vidorev'),					
				),
			),
			array(
				'id' 			=> 'video_series_style',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Video Series Style', 'vidorev'),
				'default' 		=> 'inline',
				'options'  		=> array(
					'inline' 		=> esc_html__('Inline', 'vidorev'),
					'dd' 			=> esc_html__('Dropdown', 'vidorev'),
					'grid' 			=> esc_html__('Grid', 'vidorev'),							
				),
			),
			array(
				'id' 		=> 'vid_auto_play',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Auto Play', 'vidorev'),
				'desc'      => esc_html__('The videos automatically play for desktop users only, and are shown but require a tap to play for mobile users', 'vidorev'),				
				'default' 	=> false,
			),
			array(
				'id' 		=> 'vid_auto_play_mute',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Muted autoplay', 'vidorev'),
				'desc'      => esc_html__('Autoplay policy has changed on desktop browsers. You may need to use this option for the autoplay feature to work.', 'vidorev'),				
				'default' 	=> false,
			),
			array(
				'id' 		=> 'vid_preview_mode',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Preview', 'vidorev'),
				'desc'      => esc_html__('Enabling this option helps users preview videos when hovering over featured image of video post on lists or archive pages. Note: This feature is only available for self-hosted videos, or video networks supported through API such as: Youtube, Vimeo, Twitch, Facebook, Dailymotion. It does not work with videos displayed with normal embedded mode.', 'vidorev'),				
				'default' 	=> false,
			),
			array(
				'id' 		=> 'float_player',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Minimize + Float Player on Scroll', 'vidorev'),				
				'default' 	=> false,
			),
			array(
				'id' 			=> 'video_player_library',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Player', 'vidorev'),
				'desc' 			=> esc_html__('Select default player for video file', 'vidorev'),
				'default' 		=> 'vp',
				'options'  		=> array(
					'vp' 			=> esc_html__('VidoRev Javascript Library', 'vidorev'),
					'fluidplayer' 	=> esc_html__('Fluid Player (with VAST)', 'vidorev'),
					'jw'	 		=> esc_html__('JW Player', 'vidorev'),
					'videojs'		=> esc_html__('Videojs HTML5 Player', 'vidorev'),
					'flow'			=> esc_html__('FV Flowplayer Video Player', 'vidorev'),
				),
			),
				array(
					'id' 		=> 'plyr_player',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('[Player] PLYR for Youtube & Vimeo', 'vidorev'),				
					'default' 	=> false,
					'required' 	=> array(
										array( 'video_player_library', '=', 'vp' ),									
									),
				),
			array(
				'id' 		=> 'identify_player',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('[Player] Automatically identify MP4 and M3U8 files', 'vidorev'),				
				'default' 	=> false,
				'desc' 		=> esc_html__('This is an auxiliary feature for two player libraries: FluidPlayer and VidoRev Javascript Library. It will automatically identify the links and select the appropriate player without having to manually select from the post editing section.', 'vidorev'),
			),
				
			array(
				'id' 			=> 'jwplayer_cloud_library',
				'type'	 		=> 'media',
				'preview'		=> false,
				'library_filter'=> array('js'),			
				'title' 		=> esc_html__('[JWPLAYER] Cloud Player Library Url', 'vidorev'),
				'desc' 			=> esc_html__('You can use a cloud or a self hosted library', 'vidorev'),
				'placeholder'	=> esc_html__('No library selected', 'vidorev'),
				'readonly'		=> false,
				'url'			=> true,
			),
			array(
				'id' 		=> 'jwplayer_licence_key',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[JWPLAYER] Licence Key', 'vidorev'),
				'desc' 		=> esc_html__('Self hosted player? Please, add your JW Player license key', 'vidorev'),
			),			
			array(
				'id' 		=> 'google_api_key',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[Youtube] Google API Key', 'vidorev'),
				'desc' 		=> esc_html__('Fill your Google API key to fetch data from Youtube', 'vidorev'),
			),
			array(
				'id' 		=> 'vimeo_client_identifier',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[Vimeo] Client Identifier', 'vidorev'),
				'desc' 		=> esc_html__('Optional: Only required for accessing private VIMEO videos', 'vidorev'),
			),
			array(
				'id' 		=> 'vimeo_client_secrets',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[Vimeo] Client Secrets', 'vidorev'),
				'desc' 		=> esc_html__('Optional: Only required for accessing private VIMEO videos', 'vidorev'),
			),
			array(
				'id' 		=> 'vimeo_personal_access_tokens',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[Vimeo] Personal Access Tokens', 'vidorev'),
				'desc' 		=> esc_html__('Optional: Only required for accessing private VIMEO videos', 'vidorev'),
			),
			array(
				'id' 		=> 'twitch_client_id',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[Twitch] Client ID', 'vidorev'),
				'desc' 		=> esc_html__('Fill your Twitch Client ID to fetch data from Twitch', 'vidorev'),
			),
			array(
				'id' 		=> 'twitch_client_secret',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[Twitch] Client Secret', 'vidorev'),
				'desc' 		=> esc_html__('Fill your Twitch Client Secret to fetch data from Twitch', 'vidorev'),
			),
			array(
				'id' 		=> 'facebook_app_id',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[Facebook] App ID', 'vidorev'),
				'desc' 		=> esc_html__('Fill your Facebook App ID to fetch data from Facebook', 'vidorev'),
			),
			array(
				'id' 		=> 'facebook_app_secret',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('[Facebook] App Secret', 'vidorev'),
				'desc' 		=> esc_html__('Fill your Facebook App Secret to fetch data from Facebook', 'vidorev'),
			),
			array(
				'id' 		=> 'imdb_user',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('IMDb User ID', 'vidorev'),
				'desc' 		=> esc_html__('Fill your IMDb ID to fetch data from IMDb ratings plugin', 'vidorev'),
			),
			array(
					'id' 		=> 'sv_show_more_btn',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Show More Button', 'vidorev'),			
					'default' 	=> false,
				),
			array(
				'id' 			=> 'single_video_fetch_data_start',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('Fetching Data', 'vidorev'),
				'indent' 		=> true 
			),
				array(
					'id' 		=> 'fetch_video_title',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video Title', 'vidorev'),			
					'default' 	=> true,
				),
				array(
					'id' 		=> 'fetch_video_description',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video Description', 'vidorev'),			
					'default' 	=> true,
				),
				array(
					'id' 		=> 'fetch_video_tags',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video Tags', 'vidorev'),		
					'default' 	=> false,
				),
				array(
					'id' 		=> 'fetch_video_duration',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video Duration', 'vidorev'),			
					'default' 	=> true,
				),
				array(
					'id' 		=> 'fetch_video_view_count',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video View Count', 'vidorev'),				
					'default' 	=> true,
				),
				array(
					'id' 		=> 'fetch_video_like_count',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video Like Count', 'vidorev'),		
					'default' 	=> true,
				),
				array(
					'id' 		=> 'fetch_video_dislike_count',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video Dislike Count', 'vidorev'),			
					'default' 	=> true,
				),
				array(
					'id' 		=> 'fetch_video_comment_count',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video Comment Count', 'vidorev'),
					'default' 	=> true,
				),
				array(
					'id' 		=> 'fetch_video_thumbnail',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetch Video Thumbnail', 'vidorev'),			
					'default' 	=> true,
				),
				array(
					'id' 		=> 'fetch_video_when_accessing',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Fetching data when accessing video posts', 'vidorev'),			
					'default' 	=> false,
				),
			array(
				'id'     => 'single_video_fetch_data_end',
				'type'   => 'section',
				'indent' => false,
			),	
			
			array(
				'id' 			=> 'single_video_elements_section_start',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('Elements', 'vidorev'),
				'indent' 		=> true 
			),
			
				array(
					'id' 		=> 'single_video_show_categories',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Post Categories', 'vidorev'),			
					'default' 	=> false,
				),
				array(
					'id' 		=> 'single_video_show_author',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Post Author', 'vidorev'),				
					'default' 	=> true,
				),
				array(
					'id' 		=> 'single_video_show_date',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Post Published Date', 'vidorev'),			
					'default' 	=> true,
				),
					array(
						'id' 		=> 'single_video_show_updated_date',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Display Last Updated Date', 'vidorev'),				
						'default' 	=> false,
						'required' 	=> array( 'single_video_show_date', '=', '1' ),
					),
				array(
					'id' 		=> 'single_video_show_comment_count',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Post Comment Count', 'vidorev'),			
					'default' 	=> true,
				),
				array(
					'id' 		=> 'single_video_show_view_count',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Post View Count', 'vidorev'),			
					'default' 	=> true,
				),
				array(
					'id' 		=> 'single_video_show_like_count',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Post Like Count', 'vidorev'),				
					'default' 	=> true,
				),
				array(
					'id' 		=> 'single_video_show_dislike_count',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Display Post Dislike Count', 'vidorev'),				
					'default' 	=> true,
				),
			array(
				'id'     => 'single_video_elements_section_end',
				'type'   => 'section',
				'indent' => false,
			),	
			
			array(
				'id' 			=> 'single_video_main_toolbar_section_start',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('Main-Toolbar', 'vidorev'),
				'indent' 		=> true 
			),	
				array(
					'id' 		=> 'single_video_main_toolbar',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Main-toolbar', 'vidorev'),				
					'default' 	=> true,
				),
					array(
						'id' 		=> 'single_video_main_toolbar_tol',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Turn Off Light', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_main_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_main_toolbar_like',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Like Button', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_main_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_main_toolbar_dislike',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Dislike Button', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_main_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_main_toolbar_watch_later',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Watch Later Button', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_main_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_main_toolbar_share',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Share Button', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_main_toolbar', '=', '1' ),									
									),
					),
						array(
							'id' 		=> 'single_video_main_toolbar_share_iframe',
							'type'	 	=> 'switch',
							'title' 	=> esc_html__('Iframe Video', 'vidorev'),				
							'default' 	=> true,
							'required' 	=> array(
											array( 'single_video_main_toolbar_share', '=', '1' ),									
										),
						),
					array(
						'id' 		=> 'single_video_main_toolbar_auto_next',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Auto Next', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_main_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_main_toolbar_comment_count',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Comments Count / Files Download', 'vidorev'),
						'desc'      => esc_html__('If the video allows downloading the file, the download button will replace the comment button.', 'vidorev'),			
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_main_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_main_toolbar_theater_mode',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Theater Mode', 'vidorev'),	
						'default' 	=> false,
						'required' 	=> array(
										array( 'single_video_main_toolbar', '=', '1' ),									
									),
					),
			array(
				'id'     => 'single_video_main_toolbar_section_end',
				'type'   => 'section',
				'indent' => false,
			),
			
			array(
				'id' 			=> 'single_video_sub_toolbar_section_start',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('Sub-Toolbar', 'vidorev'),
				'indent' 		=> true 
			),
				array(
					'id' 		=> 'single_video_sub_toolbar',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Sub-toolbar', 'vidorev'),				
					'default' 	=> false,
				),
					array(
						'id' 		=> 'single_video_sub_toolbar_like_dislike_view_block',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Like/DisLike/View Block', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_sub_toolbar_facebook_block',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Facebook Like/Share', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_sub_toolbar_report_button',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Report Button', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_sub_toolbar_repeat_button',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Repeat Button', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_sub_toolbar_lightbox_button',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Lightbox Button', 'vidorev'),				
						'default' 	=> true,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),	
					array(
						'id' 		=> 'single_video_sub_toolbar_donation_button',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Donate Button', 'vidorev'),
						'desc'		=> esc_html__('You will need to install PayPal Donations plugin.', 'vidorev'),				
						'default' 	=> false,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
					
					array(
						'id' 		=> 'single_video_sub_toolbar_prev_video',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Prev Button', 'vidorev'),			
						'default' 	=> false,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),					
					array(
						'id' 		=> 'single_video_sub_toolbar_next_video',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Next Button', 'vidorev'),			
						'default' 	=> false,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_sub_toolbar_more_videos',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('More Videos Button', 'vidorev'),			
						'default' 	=> false,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_sub_toolbar_channel_subscribe',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Subscribe Button', 'vidorev'),			
						'default' 	=> false,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
					array(
						'id' 		=> 'single_video_sub_toolbar_add_playlist',
						'type'	 	=> 'switch',
						'title' 	=> esc_html__('Add Playlist Button', 'vidorev'),			
						'default' 	=> false,
						'required' 	=> array(
										array( 'single_video_sub_toolbar', '=', '1' ),									
									),
					),
			array(
				'id'     => 'single_video_sub_toolbar_section_end',
				'type'   => 'section',
				'indent' => false,
			),			
			
			
			array(
				'id' 			=> 'single_video_rating_section_start',
				'type'	 		=> 'section',
				'title' 		=> esc_html__('User Rating', 'vidorev'),
				'indent' 		=> true 
			),
				array(
					'id' 		=> 'user_rating',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('User Rating', 'vidorev'),
					'desc'		=> esc_html__('Turn On/Off user rating. You will need to install Yasr – Yet Another Stars Rating plugin', 'vidorev'),			
					'default' 	=> false,
				),
					array(
						'id' 			=> 'user_rating_position',
						'type'	 		=> 'select',
						'title' 		=> esc_html__('Where?', 'vidorev'),
						'default' 		=> 'before',
						'options'  		=> array(
							'before' 	=> esc_html__('Before the post', 'vidorev'),
							'after'		=> esc_html__('After the post', 'vidorev'),							
						),
						'required' 		=> array(
											array( 'user_rating', '=', '1' ),									
										),
					),
					array(
						'id' 			=> 'user_rating_mode',
						'type'	 		=> 'select',
						'title' 		=> esc_html__('Rating Mode', 'vidorev'),
						'desc' 			=> esc_html__('Select default rating mode for video posts', 'vidorev'),
						'default' 		=> 'single',
						'options'  		=> array(
							'single' 	=> esc_html__('Single', 'vidorev'),
							'multi-sets'=> esc_html__('Multiple Set', 'vidorev'),							
						),
						'required' 		=> array(
											array( 'user_rating', '=', '1' ),									
										),
					),
						$yasr_get_multi_set_param,
			array(
				'id'     => 'single_video_rating_section_end',
				'type'   => 'section',
				'indent' => false,
			),							
		)
	));
/*Single Video Settings*/	

/*watch_settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Watch Later Settings', 'vidorev'),
		'id'    	=> 'watch_settings',
		'icon'  	=> 'el el-time',
		'fields'	=>	array(
			array(
				'id' 		=> 'watch_enable',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Watch Later', 'vidorev'),
				'desc'      => esc_html__('Enable/Disable Watch Later Function', 'vidorev'),				
				'default' 	=> false,
			),
				array(
					'id' 			=> 'watch_sidebar',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Watch Later Listing Sidebar', 'vidorev'),
					'desc' 			=> esc_html__('Select "Default" to use settings in Theme Options > Single Page Settings', 'vidorev'),
					'default' 		=> '',
					'placeholder'	=> esc_html__('Default', 'vidorev'),
					'options'  		=> array(
						'' 			=> esc_html__('Default', 'vidorev'),
						'right'	 	=> esc_html__('Right', 'vidorev'),
						'left'	 	=> esc_html__('Left', 'vidorev'),
						'hidden'	=> esc_html__('Hidden', 'vidorev'),
					),
					'required' 	=> array( 'watch_enable', '=', '1' ),
				),
				array(
					'id' 		=> 'watch_loop_style',
					'type'	 	=> 'image_select',
					'title' 	=> esc_html__('Watch Later Loop Style', 'vidorev'),
					'desc' 		=> esc_html__('Select Watch Later Loop Style', 'vidorev'),
					'default' 	=> 'list-blog',
					'options'  	=> array(
						'grid-default'	=> array(
							'alt'   => esc_html__('Grid - Default', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/grid-default.jpg'
						),
						'list-default'	=> array(
							'alt'   => esc_html__('List - Default', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/list-default.jpg'
						),
						'grid-special'	=> array(
							'alt'   => esc_html__('Grid - Special', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/grid-special.jpg'
						),
						'list-special'	=> array(
							'alt'   => esc_html__('List - Special', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/list-special.jpg'
						),
						'grid-modern'	=> array(
							'alt'   => esc_html__('Grid - Modern', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/grid-modern.jpg'
						),
						'movie-grid'	=> array(
							'alt'   => esc_html__('Grid - Poster', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/grid-poster.jpg'
						),
						'list-blog'	=> array(
							'alt'   => esc_html__('List - Blog Wide', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/list-blog.jpg'
						),
						'movie-list'	=> array(
							'alt'   => esc_html__('List - Poster', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/list-poster.jpg'
						),
						'grid-small'	=> array(
							'alt'   => esc_html__('Grid - Small', 'vidorev'), 
							'img'   => get_template_directory_uri() . '/img/to-pic/grid-small.jpg'
						),
						/*new layout*/
					),
					'required' 	=> array( 'watch_enable', '=', '1' ),				
				),
				array(
					'id' 			=> 'watch_page',
					'type'	 		=> 'select',
					'title' 		=> esc_html__('Watch Later Page', 'vidorev'),
					'desc' 			=> esc_html__('This sets the base your "watch later page". This is the page that will display the video listings you want to view later.', 'vidorev'),
					'data'			=> 'page',
					'required' 		=> array( 'watch_enable', '=', '1' ),	
				),
		)
	));
/*watch_settings*/	
	
/*Social Accounts*/	
	do_action('vidorev_social_accounts_otps', $opt_name);	
/*Social Accounts*/	
	
/*Social Sharing*/
	do_action('vidorev_social_sharing_otps', $opt_name);
/*Social Sharing*/	

/*author_settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Author Settings', 'vidorev'),
		'id'    	=> 'author_settings',
		'icon'  	=> 'el el-adult',
		'fields'	=>	array(
			array(
				'id' 			=> 'author_sidebar',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Sidebar', 'vidorev'),
				'desc' 			=> esc_html__('Select "Default" to use settings in Theme Options > Styling', 'vidorev'),
				'default' 		=> '',
				'placeholder'	=> esc_html__('Default', 'vidorev'),
				'options'  		=> array(
					'' 			=> esc_html__('Default', 'vidorev'),
					'right'	 	=> esc_html__('Right', 'vidorev'),
					'left'	 	=> esc_html__('Left', 'vidorev'),
					'hidden'	=> esc_html__('Hidden', 'vidorev'),
				),				
			),
			array(
				'id' 		=> 'author_loop_style',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Author Loop Style', 'vidorev'),
				'desc' 		=> esc_html__('Select Author Loop Style', 'vidorev'),
				'default' 	=> 'list-blog',
				'options'  	=> array(
					'grid-default'	=> array(
						'alt'   => esc_html__('Grid - Default', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/grid-default.jpg'
					),
					'list-default'	=> array(
						'alt'   => esc_html__('List - Default', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/list-default.jpg'
					),
					'grid-special'	=> array(
						'alt'   => esc_html__('Grid - Special', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/grid-special.jpg'
					),
					'list-special'	=> array(
						'alt'   => esc_html__('List - Special', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/list-special.jpg'
					),
					'grid-modern'	=> array(
						'alt'   => esc_html__('Grid - Modern', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/grid-modern.jpg'
					),
					'movie-grid'	=> array(
						'alt'   => esc_html__('Grid - Poster', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/grid-poster.jpg'
					),
					'list-blog'	=> array(
						'alt'   => esc_html__('List - Blog Wide', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/list-blog.jpg'
					),
					'movie-list'	=> array(
						'alt'   => esc_html__('List - Poster', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/list-poster.jpg'
					),
					'grid-small'	=> array(
						'alt'   => esc_html__('Grid - Small', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/grid-small.jpg'
					),
					/*new layout*/
				),		
			),	
			array(
				'id' 			=> 'author_pag_type',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Pagination', 'vidorev'),
				'desc' 			=> esc_html__('Choose type of navigation for search page. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev'),
				'default' 		=> 'wp-default',
				'options'  		=> array(
					'wp-default' 		=> esc_html__('WordPress Default', 'vidorev'),
					'loadmore-btn'	 	=> esc_html__('Load More Button (Ajax)', 'vidorev'),
					'infinite-scroll'	=> esc_html__('Infinite Scroll (Ajax)', 'vidorev'),
					'pagenavi_plugin'	=> esc_html__('WP PageNavi (Plugin)', 'vidorev'),
				),
			),
			array(
				'id' 		=> 'author_slug',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('Author Slug', 'vidorev'),
				'desc' 		=> esc_html__('Change Author slug. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev'),
			),
		)
	));
/*author_settings*/	

/*search_settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Search Settings', 'vidorev'),
		'id'    	=> 'search_settings',
		'icon'  	=> 'el el-search-alt',
		'fields'	=>	array(
			array(
				'id' 			=> 'search_sidebar',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Sidebar', 'vidorev'),
				'desc' 			=> esc_html__('Select "Default" to use settings in Theme Options > Styling', 'vidorev'),
				'default' 		=> '',
				'placeholder'	=> esc_html__('Default', 'vidorev'),
				'options'  		=> array(
					'' 			=> esc_html__('Default', 'vidorev'),
					'right'	 	=> esc_html__('Right', 'vidorev'),
					'left'	 	=> esc_html__('Left', 'vidorev'),
					'hidden'	=> esc_html__('Hidden', 'vidorev'),
				),				
			),
			array(
				'id' 		=> 'search_loop_style',
				'type'	 	=> 'image_select',
				'title' 	=> esc_html__('Search Loop Style', 'vidorev'),
				'desc' 		=> esc_html__('Select Search Loop Style', 'vidorev'),
				'default' 	=> 'list-blog',
				'options'  	=> array(
					'grid-default'	=> array(
						'alt'   => esc_html__('Grid - Default', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/grid-default.jpg'
					),
					'list-default'	=> array(
						'alt'   => esc_html__('List - Default', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/list-default.jpg'
					),
					'grid-special'	=> array(
						'alt'   => esc_html__('Grid - Special', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/grid-special.jpg'
					),
					'list-special'	=> array(
						'alt'   => esc_html__('List - Special', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/list-special.jpg'
					),
					'grid-modern'	=> array(
						'alt'   => esc_html__('Grid - Modern', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/grid-modern.jpg'
					),
					'movie-grid'	=> array(
						'alt'   => esc_html__('Grid - Poster', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/grid-poster.jpg'
					),
					'list-blog'	=> array(
						'alt'   => esc_html__('List - Blog Wide', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/list-blog.jpg'
					),
					'movie-list'	=> array(
						'alt'   => esc_html__('List - Poster', 'vidorev'), 
						'img'   => get_template_directory_uri() . '/img/to-pic/list-poster.jpg'
					),
					'grid-small'	=> array(
						'alt'   => esc_html__('Grid - Small', 'vidorev'), 
            			'img'   => get_template_directory_uri() . '/img/to-pic/grid-small.jpg'
					),
					/*new layout*/
				),		
			),			
			array(
				'id' 			=> 'search_pag_type',
				'type'	 		=> 'select',
				'title' 		=> esc_html__('Pagination', 'vidorev'),
				'desc' 			=> esc_html__('Choose type of navigation for search page. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev'),
				'default' 		=> 'wp-default',
				'options'  		=> array(
					'wp-default' 		=> esc_html__('WordPress Default', 'vidorev'),
					'loadmore-btn'	 	=> esc_html__('Load More Button (Ajax)', 'vidorev'),
					'infinite-scroll'	=> esc_html__('Infinite Scroll (Ajax)', 'vidorev'),
					'pagenavi_plugin'	=> esc_html__('WP PageNavi (Plugin)', 'vidorev'),
				),
			),
			array(
				'id' 		=> 'search_remove_pages',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Exclude Pages from Search Results', 'vidorev'),		
				'default' 	=> true,
			),
			array(
				'id' 		=> 'search_video_posts',
				'type'	 	=> 'switch',
				'title' 	=> esc_html__('Search Video Posts Only', 'vidorev'),				
				'default' 	=> false,
			),
		)
	));
/*search_settings*/	

/*pagenotfound_settings*/	
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( '404 Page Not Found', 'vidorev'),
		'id'    	=> 'pagenotfound_settings',
		'icon'  	=> 'el el-error-alt',
		'fields'	=>	array(
			array(
				'id' 			=> 'img_404',
				'type'	 		=> 'media',				
				'title' 		=> esc_html__('404 Image', 'vidorev'),
				'desc' 			=> esc_html__('Upload your image for 404 Page', 'vidorev'),
				'placeholder'	=> esc_html__('No image selected', 'vidorev'),
				'readonly'		=> false,
				'url'			=> true,
			),
			array(
				'id' 		=> 'content_404',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('404 Content', 'vidorev'),
				'desc' 		=> esc_html__('Content of Page Not Found', 'vidorev'),
			),
			array(
				'id' 		=> 'button_404',
				'type'	 	=> 'text',
				'title' 	=> esc_html__('Back Button Text', 'vidorev'),
				'desc' 		=> esc_html__('Text for "Back to homepage" button', 'vidorev'),
			),
		)
	));
/*pagenotfound_settings*/

/*Ads*/
	Redux::setSection( $opt_name, array(
		'title' 	=> esc_html__( 'Ads', 'vidorev'),
		'id'    	=> 'ads_settings',
		'icon'  	=> 'el el-icon-usd',
		'fields'	=>	array(
			array(
                'id' 			=> 'ads_in_header',
                'type' 			=> 'editor',
                'title' 		=> esc_html__( 'Header Ad Slot', 'vidorev'),
                'subtitle' 		=> esc_html__( 'This ad will be displayed in website header.', 'vidorev'),
                'desc' 			=> esc_html__( 'Note: If you want to paste HTML or js code, use "text" mode in editor. Suggested size of an ad banner is 728x90', 'vidorev'),
                'args'   		=> array(
                    'textarea_rows'    	=> 5,
                    'default_editor' 	=> 'html'
                )
            ),
			array(
                'id' 			=> 'ads_in_header_mobile',
                'type' 			=> 'editor',
                'title' 		=> esc_html__( '[Mobile] Header Ad Slot', 'vidorev'),
                'subtitle' 		=> esc_html__( 'This ad will be displayed in website header on Mobile Devices.', 'vidorev'),
                'desc' 			=> esc_html__( 'Note: If you want to paste HTML or js code, use "text" mode in editor.', 'vidorev'),
                'args'   		=> array(
                    'textarea_rows'    	=> 5,
                    'default_editor' 	=> 'html'
                )
            ),
			array(
                'id' 			=> 'ads_above_footer',
                'type' 			=> 'editor',
                'title' 		=> esc_html__( 'Above Footer', 'vidorev'),
                'subtitle' 		=> esc_html__( 'This ad will be displayed between your footer and website content', 'vidorev'),
                'desc' 			=> esc_html__( 'Note: If you want to paste HTML or JavaScript code, use "text" mode in editor', 'vidorev'),
                'args'   		=> array(
                    'textarea_rows'    	=> 5,
                    'default_editor' 	=> 'html'
                )
            ),
			array(
                'id' 			=> 'ads_above_single',
                'type' 			=> 'editor',
                'title' 		=> esc_html__( 'Above Single Post Content', 'vidorev'),
                'subtitle' 		=> esc_html__( 'This ad will be displayed above post content on your single post templates', 'vidorev'),
                'desc' 			=> esc_html__( 'Note: If you want to paste HTML or JavaScript code, use "text" mode in editor', 'vidorev'),
                'args'   		=> array(
                    'textarea_rows'    	=> 5,
                    'default_editor' 	=> 'html'
                )
            ),
			array(
                'id' 			=> 'ads_below_single',
                'type' 			=> 'editor',
                'title' 		=> esc_html__( 'Below Single Post Content', 'vidorev'),
                'subtitle' 		=> esc_html__( 'This ad will be displayed below post content on your single post templates', 'vidorev'),
                'desc' 			=> esc_html__( 'Note: If you want to paste HTML or JavaScript code, use "text" mode in editor', 'vidorev'),
                'args'   		=> array(
                    'textarea_rows'    	=> 5,
                    'default_editor' 	=> 'html'
                )
            ),
			array(
                'id' 			=> 'ads_between_post',
                'type' 			=> 'editor',
                'title' 		=> esc_html__( 'Between Posts', 'vidorev'),
                'subtitle' 		=> esc_html__( 'This ad will be displayed between posts on archive templates such as category archives, tag archives etc...', 'vidorev'),
                'desc' 			=> esc_html__( 'You will probably not see ads in some unsupported layouts. Note: If you want to paste HTML or JavaScript code, use "text" mode in editor.', 'vidorev'),
                'args'   		=> array(
                    'textarea_rows'    	=> 5,
                    'default_editor' 	=> 'html'
                )
            ),
			array(
                'id' 			=> 'ads_between_post_offset',
                'type' 			=> 'text',
                'title' 		=> esc_html__( 'Ad Between Posts Offset', 'vidorev'),
                'subtitle' 		=> esc_html__( 'Ads appear position, Ex: 1, 3, 5...', 'vidorev'),
                'validate' 		=> 'numeric',
				'default'		=> 3,
            ),
			array(
                'id' 			=> 'ads_above_single_player',
                'type' 			=> 'editor',
                'title' 		=> esc_html__( 'Above Video Player', 'vidorev'),
                'subtitle' 		=> esc_html__( 'This ad will be displayed above video player on your single post templates', 'vidorev'),
                'desc' 			=> esc_html__( 'Note: If you want to paste HTML or JavaScript code, use "text" mode in editor', 'vidorev'),
                'args'   		=> array(
                    'textarea_rows'    	=> 5,
                    'default_editor' 	=> 'html'
                )
            ),			
			array(
                'id' 			=> 'ads_above_channel',
                'type' 			=> 'editor',
                'title' 		=> esc_html__( 'Above Channel', 'vidorev'),
                'subtitle' 		=> esc_html__( 'This ad will be displayed above content on your Single Channel/Channel Listing', 'vidorev'),
                'desc' 			=> esc_html__( 'Note: If you want to paste HTML or JavaScript code, use "text" mode in editor', 'vidorev'),
                'args'   		=> array(
                    'textarea_rows'    	=> 5,
                    'default_editor' 	=> 'html'
                )
            ),
		)
	));
/*Ads*/