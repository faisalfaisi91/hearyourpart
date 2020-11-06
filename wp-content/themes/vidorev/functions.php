<?php
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/admin.php';
require get_template_directory() . '/inc/to-redux.php';
require get_template_directory() . '/inc/mega-menu/extra-fields.php';
require get_template_directory() . '/inc/mega-menu/walker-menu.php';
require get_template_directory() . '/inc/mobile-menu/walker-menu.php';
require get_template_directory() . '/inc/category-color.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/css/custom-css.php';

if ( ! function_exists( 'vidorev_notification_required_plugins' ) ) :
	function vidorev_notification_required_plugins(){
		if(defined('VIDOREV_EXTENSIONS') && defined('VPE_VER')){
			$latest_version = '2.9.9.9.7.5';
			if( version_compare(VPE_VER, $latest_version, '<') ){
				
				global $pagenow;
				
				if(
					(($pagenow == 'admin.php' || $pagenow == 'edit.php' || $pagenow == 'post-new.php' || $pagenow == 'edit-tags.php')						
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
					))
					||
					($pagenow == 'index.php' && (!isset($_GET['page'])))					
				){
					$html = '<div id="notice-update-vidorev"><h2>
					'.esc_html('"VidoRev Extensions" plugin needs to be updated to its latest version to ensure maximum compatibility with this theme', 'vidorev').'
					</h2><br><a href="'.esc_url(admin_url('themes.php?page=tgmpa-install-plugins&plugin_status=update')).'" class="button button-primary">Update Now!</a></div>';
					
					echo apply_filters('vidorev_notification_required_plugins', $html);
				}
			}
		}
	}
endif;
add_action('admin_footer', 'vidorev_notification_required_plugins');

if ( ! function_exists( 'vidorev_register_required_plugins' ) ) :
	function vidorev_register_required_plugins() {
	
		$plugins = array(
		
			array(
				'name'               => esc_html__( 'VidoRev Extensions', 'vidorev'), 
				'slug'               => 'vidorev-extensions',
				'source'             => get_template_directory() . '/inc/plugins/vidorev-extensions-2.9.9.9.7.5.zip',
				'required'           => true,
				'version'            => '2.9.9.9.7.5',
			),
			
			array(
				  'name'     => esc_html__('Redux Framework', 'vidorev'),
				  'slug'     => 'redux-framework',
				  'required' => true
			),
			
			array(
				  'name'     => esc_html__('Elementor', 'vidorev'),
				  'slug'     => 'elementor',
				  'required' => true
			),
			
			array(
				  'name'     => esc_html__('Post Views Counter', 'vidorev'),
				  'slug'     => 'post-views-counter',
				  'required' => true
			),
			
			array(
				  'name'     => esc_html__('WP PageNavi', 'vidorev'),
				  'slug'     => 'wp-pagenavi',
				  'required' => true
			),
			
			array(
				  'name'     => esc_html__('Clean Login', 'vidorev'),
				  'slug'     => 'clean-login',
				  'required' => true
			),
			
			array(
				  'name'     => esc_html__('Ajax Search Lite', 'vidorev'),
				  'slug'     => 'ajax-search-lite',
				  'required' => true
			),
			
			array(
				  'name'     => esc_html__('Contact Form 7', 'vidorev'),
				  'slug'     => 'contact-form-7',
				  'required' => true
			),
			
			array(
				  'name'     => esc_html__('Paid Memberships Pro', 'vidorev'),
				  'slug'     => 'paid-memberships-pro',
				  'required' => false
			),
			
			array(
				  'name'     => esc_html__('Yet Another Stars Rating', 'vidorev'),
				  'slug'     => 'yet-another-stars-rating',
				  'required' => false
			),
			
			array(
				  'name'     => esc_html__('OnePress Social Locker', 'vidorev'),
				  'slug'     => 'social-locker',
				  'required' => false
			),
			
			array(
				  'name'     => esc_html__('Instagram Feed', 'vidorev'),
				  'slug'     => 'instagram-feed',
				  'required' => false
			),
			
			array(
				  'name'     => esc_html__('MailPoet Newsletters', 'vidorev'),
				  'slug'     => 'mailpoet',
				  'required' => false
			),
			
			array(
				  'name'     => esc_html__('PayPal Donations', 'vidorev'),
				  'slug'     => 'paypal-donations',
				  'required' => false
			),
			
			array(
				  'name'     => esc_html__('Yoast SEO', 'vidorev'),
				  'slug'     => 'wordpress-seo',
				  'required' => false
			),
			
			array(
				  'name'     => esc_html__('BuddyPress', 'vidorev'),
				  'slug'     => 'buddypress',
				  'required' => false
			),

			array(
				'name'               => esc_html__( 'Youzer', 'vidorev'), 
				'slug'               => 'youzer',
				'source'             => get_template_directory() . '/inc/plugins/youzer-2.6.0.zip',
				'required'           => false,
				'version'            => '2.6.0',
			),	
		);
	
		$config = array(
			'id'           => 'vidorev',             
			'default_path' => '',                      
			'menu'         => 'tgmpa-install-plugins', 
			'has_notices'  => true,                   
			'dismissable'  => true,                   
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',			
		);
	
		tgmpa( $plugins, $config );
	}
endif;
add_action( 'tgmpa_register', 'vidorev_register_required_plugins' );

if ( ! function_exists( 'vidorev_setup' ) ) :
	function vidorev_setup() {

		load_theme_textdomain( 'vidorev', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );
		
		add_theme_support( 'post-formats', array( 'video', 'audio', 'gallery', 'quote' ) );

		add_theme_support( 'post-thumbnails' );
		
		add_theme_support( 'custom-header', array() );

		register_nav_menus( array(
			'VidoRev-MainMenu' => esc_html__( 'Main Menu', 'vidorev'),
			'VidoRev-TopMenu' => esc_html__( 'Top Menu', 'vidorev'),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'custom-background', apply_filters( 'vidorev_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		
		add_theme_support(
			'woocommerce', 
			apply_filters( 'vidorev_woocommerce_args', array(
					'single_image_width'    => 416,
					'thumbnail_image_width' => 324,
					'product_grid'          => array(
						'default_rows'    => 3,
						'min_rows'        => 2,
						'max_rows'        => 10,
						'default_columns' => 3,
						'min_columns'     => 3,
						'max_columns'     => 4,
					)
				)
			)
		);
		
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}	
endif;
add_action( 'after_setup_theme', 'vidorev_setup' );

if ( ! function_exists( 'vidorev_content_width' ) ) :
	function vidorev_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'vidorev_content_width', 640 );
	}
endif;
add_action( 'after_setup_theme', 'vidorev_content_width', 0 );

if ( ! function_exists( 'vidorev_in_widget_form' ) ) :
	function vidorev_in_widget_form($t, $return, $instance){	
		$instance = wp_parse_args( (array) $instance, array( 'extraclassname' => '', 'widgetcolumn' => 'bt-col-12') );			
		
		if(!isset($instance['extraclassname'])){
			$instance['extraclassname'] = '';
		}
		if(!isset($instance['widgetcolumn'])){
			$instance['widgetcolumn'] = 'bt-col-12';
		}
		
		?>			
			<p>
				<label for="<?php echo esc_attr($t->get_field_id('extraclassname'));?>">
					<?php echo esc_html__( 'Extra Class Name', 'vidorev')?> 
					<input class="widefat" id="<?php echo esc_attr($t->get_field_id('extraclassname'));?>" name="<?php echo esc_attr($t->get_field_name('extraclassname'));?>" type="text" value="<?php echo esc_attr($instance['extraclassname']);?>">
				</label>
			</p>
			<p class="vp-custom-column-widget">
				<label for="<?php echo esc_attr($t->get_field_id('widgetcolumn'));?>"><?php echo esc_html__( 'Widget Column', 'vidorev')?></label>
				<select name="<?php echo esc_attr($t->get_field_name('widgetcolumn'));?>" id="<?php echo esc_attr($t->get_field_id('widgetcolumn'));?>" class="widefat">
					<option <?php selected($instance['widgetcolumn'], 'widget__col-04');?> value="widget__col-04"><?php echo esc_html__( '04/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-12');?> value="widget__col-12"><?php echo esc_html__( '12/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-11');?> value="widget__col-11"><?php echo esc_html__( '11/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-10');?> value="widget__col-10"><?php echo esc_html__( '10/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-09');?> value="widget__col-09"><?php echo esc_html__( '09/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-08');?> value="widget__col-08"><?php echo esc_html__( '08/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-07');?> value="widget__col-07"><?php echo esc_html__( '07/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-06');?> value="widget__col-06"><?php echo esc_html__( '06/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-05');?> value="widget__col-05"><?php echo esc_html__( '05/12', 'vidorev');?></option>					
					<option <?php selected($instance['widgetcolumn'], 'widget__col-03');?> value="widget__col-03"><?php echo esc_html__( '03/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-02');?> value="widget__col-02"><?php echo esc_html__( '02/12', 'vidorev');?></option>
					<option <?php selected($instance['widgetcolumn'], 'widget__col-01');?> value="widget__col-01"><?php echo esc_html__( '01/12', 'vidorev');?></option>
				</select>
			</p>
		<?php
		return array($t, $return, $instance);
	}
	
	add_action('in_widget_form', 'vidorev_in_widget_form', 5, 3);
endif;

if ( ! function_exists( 'vidorev_in_widget_form_update' ) ) :
	function vidorev_in_widget_form_update($instance, $new_instance, $old_instance){
		$instance['extraclassname'] = strip_tags($new_instance['extraclassname']);
		$instance['widgetcolumn'] = strip_tags($new_instance['widgetcolumn']);
		return $instance;
	}
	add_filter('widget_update_callback', 'vidorev_in_widget_form_update', 5, 3);
endif;

if ( ! function_exists( 'vidorev_dynamic_sidebar_params' ) ) :
	function vidorev_dynamic_sidebar_params($params){
		global $wp_registered_widgets;
		$widget_id = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[$widget_id];
		$widget_opt = get_option($widget_obj['callback'][0]->option_name);
		$widget_num = $widget_obj['params'][0]['number'];
		
		$class = '';
				
		if(isset($widget_opt[$widget_num]['extraclassname'])){
			$class.=' '.$widget_opt[$widget_num]['extraclassname'];
		}
		
		if(isset($widget_opt[$widget_num]['widgetcolumn'])){
			$class.=' '.$widget_opt[$widget_num]['widgetcolumn'];
		}
		
		if($class!=''){
			$params[0] = array_replace($params[0], array('before_widget' => str_replace('r-widget-control', 'r-widget-control'.esc_attr($class), $params[0]['before_widget'])));
		}
		return $params;
	}
	add_filter('dynamic_sidebar_params', 'vidorev_dynamic_sidebar_params');
endif;

if ( ! function_exists( 'vidorev_widgets_init' ) ) :
	function vidorev_widgets_init() {
		register_sidebar(array(
			'name'          => esc_html__( 'Main Sidebar', 'vidorev'),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));
		register_sidebar(array(
			'name'          => esc_html__( 'Footer Sidebar', 'vidorev'),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));
		
		register_sidebar(array(
			'name'          => esc_html__( 'Elementor Sidebar 01', 'vidorev'),
			'id'            => 'elementor-sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));		
		register_sidebar(array(
			'name'          => esc_html__( 'Elementor Sidebar 02', 'vidorev'),
			'id'            => 'elementor-sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));		
		register_sidebar(array(
			'name'          => esc_html__( 'Elementor Sidebar 03', 'vidorev'),
			'id'            => 'elementor-sidebar-3',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));		
		register_sidebar(array(
			'name'          => esc_html__( 'Elementor Sidebar 04', 'vidorev'),
			'id'            => 'elementor-sidebar-4',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));		
		register_sidebar(array(
			'name'          => esc_html__( 'Elementor Sidebar 05', 'vidorev'),
			'id'            => 'elementor-sidebar-5',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));		
		register_sidebar(array(
			'name'          => esc_html__( 'Elementor Sidebar 06', 'vidorev'),
			'id'            => 'elementor-sidebar-6',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));
		
		register_sidebar(array(
			'name'          => esc_html__( 'bbPress Sidebar', 'vidorev'),
			'id'            => 'vidorev-bbpress-1',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));
		
		register_sidebar(array(
			'name'          => esc_html__( 'Woocommerce Sidebar', 'vidorev'),
			'id'            => 'woo-sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));
		
		register_sidebar(array(
			'name'          => esc_html__( 'Side Menu - Sidebar', 'vidorev'),
			'id'            => 'sidemenu-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));
		
		register_sidebar(array(
			'name'          => esc_html__( 'Advance Search - Sidebar', 'vidorev'),
			'id'            => 'advancesearch-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'vidorev'),
			'before_widget' => '<div id="%1$s" class="widget r-widget-control %2$s"><div class="widget-item-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2 class="widget-title h5 extra-bold"><span class="title-wrap">',
			'after_title'   => '</span></h2>',
		));
	}
endif;
add_action( 'widgets_init', 'vidorev_widgets_init' );

if( ! function_exists('vidorev_fontawesome') ) :
	function vidorev_fontawesome(){		
		wp_register_style(
			'font-awesome-5-all',
			get_template_directory_uri() . '/css/font-awesome/css/all.min.css',
			array(),
			'5.13.0'
		);
		wp_register_style(
			'font-awesome-4-shim',
			get_template_directory_uri() . '/css/font-awesome/css/v4-shims.min.css',
			array('font-awesome-5-all'),
			'5.13.0'
		);		
	}
endif;
add_action( 'wp_enqueue_scripts', 'vidorev_fontawesome', 1 );

if ( ! function_exists( 'vidorev_scripts' ) ) :
	function vidorev_scripts() {
		
		wp_deregister_style('yz-opensans');
		wp_deregister_style('yz-roboto');
		wp_deregister_style('yz-lato');
		
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css', array(), '4.7.0');
		if ( ! wp_script_is( 'font-awesome-pro' ) ) {
			wp_enqueue_style( 'font-awesome-5-all');
		}
		wp_enqueue_style( 'font-awesome-4-shim');
		
		wp_dequeue_style( 'sb-font-awesome' );
		wp_dequeue_style( 'yz-icons' );
		
		wp_register_style( 'yz-opensans', '');
		wp_register_style( 'yz-roboto', '');
		wp_register_style( 'yz-lato', '');
		
		$scrollbar_library = 'malihu';
		switch(vidorev_get_redux_option('scrollbar_library', '')){
			case 'malihu';
				$scrollbar_library = 'malihu';
				break;
			case 'overlay';
				$scrollbar_library = 'overlay';
				break;
		}
		
		wp_enqueue_style( 'jquery-slick', get_template_directory_uri() . '/css/slick/slick.css', array(), '1.9.0');
		if($scrollbar_library=='malihu'){
			wp_enqueue_style( 'jquery-malihu-scroll', get_template_directory_uri() . '/css/malihu/jquery.mCustomScrollbar.min.css', array(), '3.1.5');
		}
		if($scrollbar_library=='overlay'){
			wp_enqueue_style( 'jquery-overlay-scrollbars', get_template_directory_uri() . '/css/overlay-scrollbars/OverlayScrollbars.min.css', array(), '1.13.0');
		}
		wp_enqueue_style( 'vidorev-extend-ie', get_template_directory_uri() . '/css/extend-ie/extend-ie.css', array(), '1.0.0');
		
		if(class_exists('bbPress')){
			wp_enqueue_style( 'vidorev-bbpress', get_template_directory_uri() . '/css/vidorev-bbpress.css', array(), '1.0.0');	
		}
		
		wp_enqueue_style( 'vidorev-style', get_stylesheet_uri() );
	
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		
		$main_font 	= vidorev_get_redux_option('main_font', array());
		$hea_font 	= vidorev_get_redux_option('hea_font', array());
		$nav_font 	= vidorev_get_redux_option('nav_font', array());
		$meta_font 	= vidorev_get_redux_option('meta_font', array());
				
		$font_arr = array('Poppins:400,500,700');
		$subs_arr = array();	

		if(isset($main_font['google']) && $main_font['google']=='true' && isset($main_font['font-family']) && $main_font['font-family']!=''){
			
			$main_font_string = $main_font['font-family'];
			
			if(isset($main_font['font-weight']) && $main_font['font-weight']!=''){
				$main_font_string .= ':'.$main_font['font-weight'];
			}
			if(isset($main_font['font-style']) && $main_font['font-style']=='italic'){
				$main_font_string .= 'i';
			}
			
			array_push($font_arr, $main_font_string);
			
			if(isset($main_font['subsets']) && $main_font['subsets']!=''){
				array_push($subs_arr, $main_font['subsets']);
			}
		}
		
		if(isset($hea_font['google']) && $hea_font['google']=='true' && isset($hea_font['font-family']) && $hea_font['font-family']!=''){
			$hea_font_string = $hea_font['font-family'];
			
			if(isset($hea_font['font-weight']) && $hea_font['font-weight']!=''){
				$hea_font_string .= ':'.$hea_font['font-weight'];
			}
			if(isset($hea_font['font-style']) && $hea_font['font-style']=='italic'){
				$hea_font_string .= 'i';
			}
			
			array_push($font_arr, $hea_font_string);
			
			if(isset($hea_font['subsets']) && $hea_font['subsets']!=''){
				array_push($subs_arr, $hea_font['subsets']);
			}
		}
		
		if(isset($nav_font['google']) && $nav_font['google']=='true' && isset($nav_font['font-family']) && $nav_font['font-family']!=''){
			$nav_font_string = $nav_font['font-family'];
			
			if(isset($nav_font['font-weight']) && $nav_font['font-weight']!=''){
				$nav_font_string .= ':'.$nav_font['font-weight'];
			}
			if(isset($nav_font['font-style']) && $nav_font['font-style']=='italic'){
				$nav_font_string .= 'i';
			}
			
			array_push($font_arr, $nav_font_string);
			
			if(isset($nav_font['subsets']) && $nav_font['subsets']!=''){
				array_push($subs_arr, $nav_font['subsets']);
			}
		}
		
		if(isset($meta_font['google']) && $meta_font['google']=='true' && isset($meta_font['font-family']) && $meta_font['font-family']!=''){
			$meta_font_string = $meta_font['font-family'];
			
			if(isset($meta_font['font-weight']) && $meta_font['font-weight']!=''){
				$meta_font_string .= ':'.$meta_font['font-weight'];
			}
			if(isset($meta_font['font-style']) && $meta_font['font-style']=='italic'){
				$meta_font_string .= 'i';
			}
			
			array_push($font_arr, $meta_font_string);
			
			if(isset($meta_font['subsets']) && $meta_font['subsets']!=''){
				array_push($subs_arr, $meta_font['subsets']);
			}
		}
		
		$font_string = '';
		if(count($font_arr)>0){
			$font_string = urlencode(implode('|', $font_arr));
		}
		
		$subs_string = '';
		if(count($subs_arr)>0){
			$subs_string = '&amp;subset='.urlencode(implode(',', $subs_arr));
		}
		
		if($font_string!=''){
			wp_enqueue_style( 'vidorev-google-font', '//fonts.googleapis.com/css?family='.$font_string.$subs_string, array(), '1.0.0' );
		}
		
		wp_enqueue_script( 'beeteam368_obj_wes', get_template_directory_uri() . '/js/btwes.js', array( 'jquery' ), '1.0.0', false  );		
		
		$lazyload			= vidorev_get_redux_option('lazyload', 'off', 'switch');
		if($lazyload == 'on'){
			wp_enqueue_script( 'lazysizes', get_template_directory_uri() . '/js/lazysizes.min.js', array( 'jquery' ), '5.0.0', false  );	
		}else{
			wp_enqueue_script( 'vidorev-img-scroll-effect', get_template_directory_uri() . '/js/img-effect.js', array(), '1.0.0', true  );
		}
		
		wp_enqueue_script( 'scrolldir', get_template_directory_uri() . '/js/scrolldir.js', array( 'jquery' ), '1.2.22', true  );		
		wp_enqueue_script( 'jquery-slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.9.0', true  );
		wp_enqueue_script( 'jquery-mousewheel', get_template_directory_uri() . '/js/jquery-mousewheel.js', array( 'jquery' ), '3.13.3', true  );
		if($scrollbar_library=='malihu'){
			wp_enqueue_script( 'jquery-malihu-scroll', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.concat.min.js', array( 'jquery' ), '3.1.5', true  );
		}
		if($scrollbar_library=='overlay'){
			wp_enqueue_script( 'jquery-overlay-scrollbars', get_template_directory_uri() . '/js/jquery.overlayScrollbars.min.js', array( 'jquery' ), '1.13.0', true  );
		}
		wp_enqueue_script( 'resize-sensor', get_template_directory_uri() . '/js/resize-sensor.js', array( 'jquery' ), '1.0.0', true  );
		wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.js', array( 'jquery' ), '1.7.0', true  );
		wp_enqueue_script( 'screenfull', get_template_directory_uri() . '/js/screenfull.min.js', array( 'jquery' ), '3.3.2', true  );
		wp_enqueue_script( 'js-cookie', get_template_directory_uri() . '/js/js.cookie.min.js', array( 'jquery' ), '2.1.4', true  );
		
		wp_enqueue_script( 'vidorev-javascript', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '2.9.9.9.7.5', true  );
		
		global $wp_query, $wp;
		$define_js_object = array();
		$define_js_object['admin_ajax'] 		= esc_url(admin_url( 'admin-ajax.php' ));		
		$define_js_object['query_vars'] 		= $wp_query->query_vars;
		
		$define_js_object['video_auto_play'] 			= esc_html(vidorev_get_redux_option('vid_auto_play', 'off', 'switch'));
		$define_js_object['vid_auto_play_mute'] 		= esc_html(vidorev_get_redux_option('vid_auto_play_mute', 'off', 'switch'));
		$define_js_object['number_format'] 				= esc_html(vidorev_get_redux_option('number_format', 'short'));
		$define_js_object['single_post_comment_type'] 	= esc_html(trim(vidorev_get_redux_option('single_post_comment_type', 'wp')));
		$define_js_object['origin_url'] 				= esc_url(home_url());		
		if(isset($_GET['vidorev_amp'])){
			$define_js_object['origin_url'] 			= esc_url(trim(get_option( 'vidorev_amp_url_settings', '' )));
			$define_js_object['amp_active'] 			= 'ok';
		}
		
		$define_js_object['is_user_logged_in'] 			= is_user_logged_in();
		
		$define_js_object['video_lightbox_suggested'] 	= esc_html(vidorev_get_redux_option('video_lightbox_suggested', 'on', 'switch'));
		$define_js_object['video_lightbox_comments'] 	= esc_html(vidorev_get_redux_option('video_lightbox_comments', 'on', 'switch'));
		
		$define_js_object['translate_close'] 			= esc_html__('Close', 'vidorev');
		$define_js_object['translate_suggested'] 		= esc_html__('Suggested', 'vidorev');
		$define_js_object['translate_comments'] 		= apply_filters('beeteam368_comment_lightbox_title', esc_html__('Live comments', 'vidorev'));
		$define_js_object['translate_auto_next'] 		= esc_html__('Auto next', 'vidorev');
		$define_js_object['translate_loading'] 			= esc_html__('Loading', 'vidorev');
		$define_js_object['translate_public_comment']	= esc_html__('Add a public comment', 'vidorev');
		$define_js_object['translate_post_comment'] 	= esc_html__('Post comment', 'vidorev');
		$define_js_object['translate_reset'] 			= esc_html__('Reset', 'vidorev');
		$define_js_object['translate_login_comment'] 	= esc_html__('Please login to post a comment', 'vidorev');
		$define_js_object['translate_text_load_ad'] 	= esc_html__('Loading advertisement...', 'vidorev');
		$define_js_object['translate_skip_ad'] 			= esc_html__('Skip Ad', 'vidorev');
		$define_js_object['translate_skip_ad_in'] 		= esc_html__('Skip ad in', 'vidorev');
		$define_js_object['translate_up_next'] 			= esc_html__('Up next', 'vidorev');
		$define_js_object['translate_cancel'] 			= esc_html__('cancel', 'vidorev');
		$define_js_object['translate_reported'] 		= esc_html__('Reported', 'vidorev');
		$define_js_object['translate_confirm_delete'] 	= esc_html__('Are you sure you want to delete this item?', 'vidorev');
		$define_js_object['translate_delete_success'] 	= esc_html__('The post has been deleted.', 'vidorev');
		$define_js_object['translate_loading_preview'] 	= esc_html__('Loading Preview', 'vidorev');
		$define_js_object['translate_loading_preview'] 	= esc_html__('Loading Preview', 'vidorev');
		$define_js_object['translate_currently_offline']= wp_kses(__('Currently Offline', 'vidorev'), array('br'=>array()));
		$define_js_object['translate_live_or_ended'] 	= esc_html__('Live Streaming or Ended', 'vidorev');
		
		if(is_archive() && isset($_GET['archive_query']) && trim($_GET['archive_query'])!=''){
			$define_js_object['archive_query'] 	= esc_html(trim($_GET['archive_query']));
		}
		
		if(is_archive() && isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!=''){
			$define_js_object['alphabet_filter'] 	= esc_html(trim($_GET['alphabet_filter']));
		}
		
		global $theme_image_ratio;		
		if(isset($theme_image_ratio)){
			$define_js_object['theme_image_ratio'] 	= esc_html($theme_image_ratio);
		}
		
		if(is_single() && get_post_type()=='post' && get_post_format()=='video'){
			$post_id = get_the_ID();
			$vm_video_url = apply_filters( 'vidorev_single_video_url', trim(get_post_meta($post_id, 'vm_video_url', true)), $post_id );
			$vm_video_shortcode = apply_filters( 'vidorev_single_video_shortcode', trim(get_post_meta($post_id, 'vm_video_shortcode', true)), $post_id );
			
			if(isset($_GET['video_index']) && is_numeric($_GET['video_index'])){
				$vm_video_multi_links = get_post_meta($post_id, 'vm_video_multi_links', true);
				
				$multiple_links_structure = get_post_meta($post_id, 'multiple_links_structure', true);				
				if($multiple_links_structure=='multi' && is_array($vm_video_multi_links)){
					$new_arr_video_multi_links = array();
					
					$ivurl=0;
					foreach($vm_video_multi_links as $videolinks_group){
						if( is_array($videolinks_group) && isset($videolinks_group['ml_url_mm']) && trim($videolinks_group['ml_url_mm'])!=''){
							$exp_videolinks_group = explode(PHP_EOL, $videolinks_group['ml_url_mm']);
							foreach($exp_videolinks_group as $video_item){
								if(strpos($video_item, 'http://')!==false || strpos($video_item, 'https://')!== false || strpos($video_item, 'http')!==false){
									$new_arr_video_multi_links[$ivurl]['ml_url'] = $video_item;
									$ivurl++;
								}
							}
						}
					}
					
					if(count($new_arr_video_multi_links) > 0){
						$vm_video_multi_links = $new_arr_video_multi_links;
					}
				}
				
				$video_ml_index = ((int)sanitize_text_field(trim($_GET['video_index']))) - 1;
							
				if( 	$video_ml_index > -1 && is_array($vm_video_multi_links) && isset($vm_video_multi_links[$video_ml_index])
						&& ( (isset($vm_video_multi_links[$video_ml_index]['ml_url']) && trim($vm_video_multi_links[$video_ml_index]['ml_url'])!='') || (isset($vm_video_multi_links[$video_ml_index]['ml_shortcode']) && trim($vm_video_multi_links[$video_ml_index]['ml_shortcode'])!='' )) 
				){				
					$vm_video_url 		= apply_filters( 'vidorev_single_video_url', isset($vm_video_multi_links[$video_ml_index]['ml_url'])?trim($vm_video_multi_links[$video_ml_index]['ml_url']):'', $post_id );
					$vm_video_shortcode = apply_filters( 'vidorev_single_video_shortcode', isset($vm_video_multi_links[$video_ml_index]['ml_shortcode'])?trim($vm_video_multi_links[$video_ml_index]['ml_shortcode']):'', $post_id );
				}
			}
			
			$define_js_object['single_video_network'] 				= esc_html(vidorev_detech_video_data::getVideoNetwork($vm_video_url));	
			if($vm_video_shortcode!=''){
				$define_js_object['single_video_network'] = 'embeded-code';
			}
			$define_js_object['single_video_source'] 				= esc_html(vidorev_detech_video_data::getVideoID($vm_video_url));
			$define_js_object['single_video_youtube_playlist_id'] 	= esc_html(vidorev_detech_video_data::getYoutubePlaylistID($vm_video_url));
			$define_js_object['single_video_url'] 					= esc_url($vm_video_url);
			$define_js_object['player_library'] 					= apply_filters( 'vidorev_single_player_library', esc_html(vidorev_detech_player_library()), $post_id, $vm_video_url );
			$define_js_object['plyr_player'] 						= esc_html(vidorev_detech_player_plyr());
			$define_js_object['single_video_streaming'] 			= apply_filters( 'vidorev_single_video_streaming', trim(get_post_meta($post_id, 'video_streaming', true)), $post_id, $vm_video_url );
			
			$vm_video_ratio = trim(get_post_meta($post_id, 'vm_video_ratio', true));
			if($vm_video_ratio==''){
				$vm_video_ratio = '16:9';
			}			
			$define_js_object['vm_video_ratio'] = $vm_video_ratio;
			
			$vm_video_ratio_mobile = trim(get_post_meta($post_id, 'vm_video_ratio_mobile', true));
			if($vm_video_ratio_mobile==''){
				$vm_video_ratio_mobile = '16:9';
			}			
			$define_js_object['vm_video_ratio_mobile'] = $vm_video_ratio_mobile;
			
			$vid_auto_play = trim(get_post_meta($post_id, 'vid_auto_play', true));
			if($vid_auto_play!=''){
				$define_js_object['video_auto_play'] = esc_attr($vid_auto_play);
			}
			
			if(beeteam368_return_embed()){
				$define_js_object['video_auto_play'] = 'off';
				if(isset($_GET['preview_mode']) && is_numeric($_GET['preview_mode']) && $_GET['preview_mode'] == 1){
					$define_js_object['video_preview_mode'] = 'on';
				}
			}
			
			$vm_media_sources = get_post_meta($post_id, 'vm_media_sources', true);			
			if(is_array($vm_media_sources)){
				$define_js_object['single_media_sources'] 				= $vm_media_sources;
			}
			
			$vm_media_subtitles = get_post_meta($post_id, 'vm_media_subtitles', true);
			if(is_array($vm_media_subtitles)){
				$define_js_object['single_media_subtitles'] 			= $vm_media_subtitles;
			}
			
			$vid_social_locker = trim(get_post_meta($post_id, 'vid_social_locker', true));
			if($vid_social_locker == 'on' && (function_exists('onp_sl_init_bizpanda') || function_exists('onp_op_init_bizpanda'))){
				$define_js_object['video_auto_play'] = 'off';
			}
			
			if(defined('VIDOREV_EXTENSIONS')){
				$define_js_object['single_video_network_library_setup'] = 'yes';
			}
		}
		
		if(vidorev_get_redux_option('jwplayer_licence_key', '')!=''){
			$define_js_object['jwplayer_licence_key'] = esc_html(vidorev_get_redux_option('jwplayer_licence_key', ''));
		}
		
		$theme_data = wp_get_theme();
		$define_js_object['security'] = esc_attr(wp_create_nonce('BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true)));
		
		$define_js_object['login_url'] = vidorev_get_option_login_page('cl_login_url');
		
		$define_js_object['scrollbar_library'] = esc_attr($scrollbar_library);
		
		if(defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, '3.0.0', '>=') ){
			$optimized_dom_output 			= get_option( 'elementor_optimized_dom_output' );
			$element_wrappers_legacy_mode 	= false;
			if ( $optimized_dom_output ) {
				$element_wrappers_legacy_mode = 'enabled' === $optimized_dom_output;
			}
			
			if($element_wrappers_legacy_mode){
				$define_js_object['elementor_version'] = 'ver-3x';
			}
		}			
				
		wp_localize_script( 'beeteam368_obj_wes', 'vidorev_jav_js_object', $define_js_object );
		wp_localize_script( 'beeteam368_obj_wes', 'vidorev_jav_js_preview', array() );
	}
endif;	
add_action( 'wp_enqueue_scripts', 'vidorev_scripts' );

if( ! function_exists('vidorev_image_sizes') ) :
	function vidorev_image_sizes(){
		add_image_size('vidorev_thumb_16x9_0x', 236, 133, true);		
		add_image_size('vidorev_thumb_16x9_1x', 360, 203, true);		
		add_image_size('vidorev_thumb_16x9_2x', 750, 422, true);	
		add_image_size('vidorev_thumb_16x9_3x', 1500, 844, true);
		
		add_image_size('vidorev_thumb_4x3_1x', 360, 270, true);	
		add_image_size('vidorev_thumb_4x3_2x', 720, 540, true);
		add_image_size('vidorev_thumb_4x3_3x', 1200, 900, true);	
		
		add_image_size('vidorev_thumb_2x3_0x', 165, 248, true);
		add_image_size('vidorev_thumb_2x3_1x', 360, 540, true);	
		add_image_size('vidorev_thumb_2x3_2x', 600, 900, true);		
	}	
endif;
add_action('after_setup_theme', 'vidorev_image_sizes');

if( ! function_exists('vidorev_image_ratio_case') ) :
	function vidorev_image_ratio_case($ratio = '1x'){
		if($ratio == '0x'){
			return array(
				'16_9' 	=> 	array('size' => 'vidorev_thumb_16x9_0x', 'ratio' => 'class-16x9'), 
				'4_3'	=>	array('size' => 'vidorev_thumb_4x3_1x', 'ratio' => 'class-4x3'), 
				'2_3'	=>	array('size' => 'vidorev_thumb_2x3_0x', 'ratio' => 'class-2x3')
			);
		}elseif($ratio == '1x'){
			return array(
				'16_9' 	=> 	array('size' => 'vidorev_thumb_16x9_1x', 'ratio' => 'class-16x9'), 
				'4_3'	=>	array('size' => 'vidorev_thumb_4x3_1x', 'ratio' => 'class-4x3'), 
				'2_3'	=>	array('size' => 'vidorev_thumb_2x3_1x', 'ratio' => 'class-2x3')
			);
		}elseif($ratio == '2x'){
			return array(
				'16_9'	=>	array('size' => 'vidorev_thumb_16x9_2x', 'ratio' => 'class-16x9'), 
				'4_3'	=>	array('size' => 'vidorev_thumb_4x3_2x', 'ratio' => 'class-4x3'), 
				'2_3'	=>	array('size' => 'vidorev_thumb_2x3_2x', 'ratio' => 'class-2x3')
			);
		}elseif($ratio == '3x'){
			return array(
				'16_9'	=>	array('size' => 'vidorev_thumb_16x9_3x', 'ratio' => 'class-16x9'), 
				'4_3'	=>	array('size' => 'vidorev_thumb_4x3_3x', 'ratio' => 'class-4x3'), 
				'2_3'	=>	array('size' => 'vidorev_thumb_2x3_2x', 'ratio' => 'class-2x3')
			);
		}
	}
endif;

if( ! function_exists('vidorev_blog_ajax_load_post') ) :
	function vidorev_blog_ajax_load_post() {			
		
		$security = sanitize_text_field($_POST['security']);
		if(!vidorev_ajax_verify_nonce($security, false)){
			return;
			die();
		}
		
		$query_vars 	= sanitize_text_field(json_encode($_POST['query_vars']));		
		$query_vars		= json_decode($query_vars, true);
		
		if(defined('MOVIE_PM_PREFIX') && isset($query_vars['meta_query']) && is_array($query_vars['meta_query']) && count($query_vars['meta_query'])==1){
			
			$handle_meta_query = $query_vars['meta_query'];
			
			foreach ($handle_meta_query as $key => $value) {
				if(is_array($value) && ( ($i_ou = array_search(MOVIE_PM_PREFIX.'actor', $value)) !== FALSE || ($i_ot = array_search(MOVIE_PM_PREFIX.'director', $value)) !== FALSE )){
					if(isset($value['compare']) &&  $value['compare'] == 'LIKE' && isset($value['value']) && $value['value']!=''){
						/*echo str_replace('\\', '', $value['value']);*/
						$new_value_meta 				= $value;
						$new_value_meta['value'] 		= str_replace('\\', '', $value['value']);
						$query_vars['meta_query'][$key] = $new_value_meta;
					}
				}
			}
			
		}
		
		foreach($query_vars as $key=>$value){
			if(is_numeric($value)) $query_vars[$key] = intval($value);
			if($value == 'false') $query_vars[$key] = false;
			if($value == 'true') $query_vars[$key] = true;
		}
		
		$blog_page 		= intval(sanitize_text_field($_POST['blog_page'])) + 1;
		if($blog_page==0){
			$blog_page = 1;
		}
		
		$template 		= trim(sanitize_text_field($_POST['template']));
		$style			= trim(sanitize_text_field($_POST['style']));
		
		global $theme_image_ratio;
		if(!isset($theme_image_ratio)){
			$theme_image_ratio = trim(sanitize_text_field($_POST['theme_image_ratio']));
		}
		
		$posts_per_page = intval(isset($query_vars['posts_per_page']) ? $query_vars['posts_per_page'] : intval(sanitize_text_field(get_option('posts_per_page'))));
		$query_offset = ($blog_page - 1) * $posts_per_page;
		
		$query_vars['post_status']		= 'publish';
		$query_vars['posts_per_page']	= $posts_per_page;
		$query_vars['offset']			= $query_offset;
		
		unset($query_vars['paged']);
		unset($query_vars['p']);
		unset($query_vars['page']);
		unset($query_vars['pagename']);
		
		$is_archive_query 	= isset($_POST['archive_query']) && trim($_POST['archive_query'])!='';
		$is_alphabet_filter	= isset($_POST['alphabet_filter']) && trim($_POST['alphabet_filter'])!='';
		$ajax_archive_query	= $is_archive_query?sanitize_text_field(trim($_POST['archive_query'])):'';
		
		if($is_archive_query){
			switch($ajax_archive_query){
				case 'comment':					
					$query_vars['orderby']		= 'comment_count date';
					$query_vars['order']		= 'DESC';
					break;
					
				case 'view':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						vidorev_like_view_sorting::vidorev_add_ttt_4();
					}
					break;
					
				case 'like':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						vidorev_like_view_sorting::vidorev_add_ttt_5();
					}
					break;
					
				case 'title':
					$query_vars['orderby']		= 'title';
					$query_vars['order']		= 'ASC';
					break;
					
				case 'mostsubscribed':
					if(class_exists('vidorev_like_view_sorting') && defined('CHANNEL_PM_PREFIX')){
						vidorev_like_view_sorting::vidorev_add_ttt_6();
					}
					break;	
					
				case 'highest_rated':
					if(class_exists('vidorev_like_view_sorting') && defined('YASR_LOG_TABLE')){
						vidorev_like_view_sorting::vidorev_add_ttt_7();
					}
					break;		
								
			}
		}
		
		if(class_exists('vidorev_like_view_sorting') && $is_alphabet_filter){
			vidorev_like_view_sorting::vidorev_add_ttt_8();
		}
		
		$posts = new WP_Query( $query_vars );
		
		if($is_archive_query){
			switch($ajax_archive_query){				
					
				case 'view':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						vidorev_like_view_sorting::vidorev_remove_ttt_4();
					}
					break;
					
				case 'like':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						vidorev_like_view_sorting::vidorev_remove_ttt_5();
					}
					break;
					
				case 'mostsubscribed':	
					if(class_exists('vidorev_like_view_sorting') && defined('CHANNEL_PM_PREFIX')){
						vidorev_like_view_sorting::vidorev_remove_ttt_6();
					}
					break;	
					
				case 'highest_rated':
					if(class_exists('vidorev_like_view_sorting') && defined('YASR_LOG_TABLE')){
						vidorev_like_view_sorting::vidorev_remove_ttt_7();
					}
					break;	
									
			}
		}
		
		if($is_alphabet_filter && class_exists('vidorev_like_view_sorting')){
			vidorev_like_view_sorting::vidorev_remove_ttt_8();
		}
		
		if( ! $posts->have_posts() ) { 
		
			echo '<div class="blog-last-page-control"></div>';
			
		}else {
			
			$totalPosts			= ($posts->found_posts);			
			$percentItems = ($totalPosts % $posts_per_page);		
			if($percentItems!=0){
				$paged_calculator=(($totalPosts-$percentItems) / $posts_per_page) + 1;
			}else{
				$paged_calculator=($totalPosts / $posts_per_page);
			}
			
			while ( $posts->have_posts() ) { 
				$posts->the_post();
				get_template_part( $template, $style );				
			}
			
			if($paged_calculator==$blog_page){
				echo '<div class="blog-last-page-control"></div>';
			}
		}
     
		wp_reset_postdata();
	
		die();
	}
endif;
add_action( 'wp_ajax_blog_ajax_load_post', 'vidorev_blog_ajax_load_post' );
add_action( 'wp_ajax_nopriv_blog_ajax_load_post', 'vidorev_blog_ajax_load_post' );

if(!function_exists('vidorev_remove_pages_in_search_results')){
	function vidorev_remove_pages_in_search_results(){
		if(vidorev_get_redux_option('search_remove_pages', 'on', 'switch') == 'on'){
			global $wp_post_types;
			$wp_post_types['page']->exclude_from_search = true;
		}
	}
}
add_action('init', 'vidorev_remove_pages_in_search_results');

if(!function_exists('vidorev_search_advance')){
	function vidorev_search_advance($query){
		$text = get_search_query();
		if($text != ''){
			if($query->is_main_query()){
				$tax_query = $query->get('tax_query');
				if(!isset($tax_query) || $tax_query == ''){
					$tax_query = array();
				}
				
				if(vidorev_get_redux_option('search_video_posts', 'off', 'switch') == 'on'){					
					array_push($tax_query, array(
						'taxonomy' 	=> 'post_format',
						'field' 	=> 'slug',
						'terms' 	=> array('post-format-video'),
						'operator' 	=> 'IN',
					));
					
					$query->set('tax_query', $tax_query);
				}
			}
		}
		
		return $query;
	}
}
if(!is_admin()){
   add_filter('pre_get_posts', 'vidorev_search_advance');
}

if(!function_exists('vidorev_detech_wp_query')){
	function vidorev_detech_wp_query(){
		global $wp_query;
		return $wp_query;
	}	
}
if(!function_exists('vidorev_detech_wp')){
	function vidorev_detech_wp(){
		global $wp;
		return $wp;
	}	
}
if(!function_exists('vidorev_detech_post_type_url')){
	function vidorev_detech_post_type_url(){
		global $post_type_add_param_to_url;
		return $post_type_add_param_to_url;
	}	
}
if(!function_exists('vidorev_detech_cookie_watch_later')){
	function vidorev_detech_cookie_watch_later(){
		global $watch_later_cookie;
		if(isset($_COOKIE['vpwatchlatervideos'])){
			$watch_later_cookie = array_filter(explode(',', trim($_COOKIE['vpwatchlatervideos'])));
		}else{
			$watch_later_cookie = array();
		}
	}	
}
add_action( 'init', 'vidorev_detech_cookie_watch_later', 1 );

if(!function_exists('vidorev_detech_image_ratio')){
	function vidorev_detech_image_ratio(){
		global $theme_image_ratio;
		
		$theme_image_ratio = '';
		
		if(defined('CATEGORY_PM_PREFIX') && is_category()){					
			$category 		= get_category( get_query_var( 'cat' ) );
			$cat_id 		= $category->cat_ID;				
			$theme_image_ratio 	= get_metadata('term', $cat_id, CATEGORY_PM_PREFIX.'image_ratio', true);			
		}elseif(is_page_template('template/blog-page-template.php')){
			$theme_image_ratio 	= get_post_meta(get_the_ID(), 'blog_image_ratio', true);
		}
		
		if($theme_image_ratio == ''){
			$theme_image_ratio = vidorev_get_redux_option('blog_image_ratio', '');
		}
	}	
}
add_action( 'wp', 'vidorev_detech_image_ratio', 1 );

if(!function_exists('vidorev_get_post_url')){
	function vidorev_get_post_url($post_id = NULL){
		$post_type_add_param_to_url = vidorev_detech_post_type_url();		
		if(isset($post_type_add_param_to_url) && !empty($post_type_add_param_to_url) && is_array($post_type_add_param_to_url) && count($post_type_add_param_to_url)>0){			
			$vidorev_is_params_url_return = add_query_arg(
				$post_type_add_param_to_url, 
				($post_id==NULL?get_permalink():get_permalink($post_id))
			);			
			return apply_filters('vidorev_is_params_url_return', $vidorev_is_params_url_return, $post_id);
		}else{			
			$vidorev_no_params_url_return = ($post_id==NULL?get_permalink():get_permalink($post_id));			
			return apply_filters('vidorev_no_params_url_return', $vidorev_no_params_url_return, $post_id);
		}
	}	
}

if(!function_exists('vidorev_number_format')){
	function vidorev_number_format($n = 0, $precision = 1, $format_type = 'short'){
		$new_number = 0;
		
		$format_type = vidorev_get_redux_option('number_format', 'short');
				
		if(isset($n) && is_numeric($n) && $n > 0){
			switch($format_type){
				case 'full':
					$new_number = number_format_i18n($n);
					break;
				case 'short':
					if ($n < 900) {						
						$n_format = number_format($n, $precision);
						$suffix = '';
					} else if ($n < 900000) {						
						$n_format = number_format($n / 1000, $precision);
						$suffix = 'K';
					} else if ($n < 900000000) {						
						$n_format = number_format($n / 1000000, $precision);
						$suffix = 'M';
					} else if ($n < 900000000000) {						
						$n_format = number_format($n / 1000000000, $precision);
						$suffix = 'B';
					} else {						
						$n_format = number_format($n / 1000000000000, $precision);
						$suffix = 'T';
					}
				  
					if ( $precision > 0 ) {
						$dotzero = '.' . str_repeat( '0', $precision );
						$n_format = str_replace( $dotzero, '', $n_format );
					}
					
					return $n_format . $suffix;
					break;	
			}
		}	
		return $new_number;
	}
}
add_filter('vidorev_number_format', 'vidorev_number_format', 10, 3);

if(!function_exists('vidorev_author_advance_query')){
	function vidorev_author_advance_query($query){
		if($query->is_main_query() && $query->is_author()){
			if(isset($_GET['author_type']) && $_GET['author_type']=='video'){
				
				$tax_query = $query->get('tax_query');
				if(!isset($tax_query) || $tax_query == ''){
					$tax_query = array();
				}				
								
				array_push($tax_query, array(
					'taxonomy' 	=> 'post_format',
					'field' 	=> 'slug',
					'terms' 	=> array('post-format-video'),
					'operator' 	=> 'IN',
				));
				
				$query->set('tax_query', $tax_query);
				
			}elseif(isset($_GET['author_type']) && $_GET['author_type']=='news'){
				
				$tax_query = $query->get('tax_query');
				if(!isset($tax_query) || $tax_query == ''){
					$tax_query = array();
				}				
								
				array_push($tax_query, array(
					'taxonomy' 	=> 'post_format',
					'field' 	=> 'slug',
					'terms' 	=> array('post-format-video'),
					'operator' 	=> 'NOT IN',
				));
				
				$query->set('tax_query', $tax_query);
				
			}elseif(isset($_GET['author_type']) && $_GET['author_type']=='playlist'){
				$query->query_vars['post_type'] = 'vid_playlist';
			}elseif(isset($_GET['author_type']) && $_GET['author_type']=='channel'){
				$query->query_vars['post_type'] = 'vid_channel';
			}elseif(isset($_GET['author_type']) && $_GET['author_type']=='series'){
				$query->query_vars['post_type'] = 'vid_series';
			}else{
				$query->query_vars['post_type'] = array('post', 'vid_playlist', 'vid_channel', 'vid_series');
			}
		}
	}
}
if(!is_admin()){
   add_filter('pre_get_posts', 'vidorev_author_advance_query');
}

if(!function_exists('vidorev_archive_advance_sorting')){
	function vidorev_archive_advance_sorting($query){
		
		if(isset($_GET['archive_query']) && trim($_GET['archive_query'])!='' && $query->is_main_query() && $query->is_archive()){
			$swi_archive_query = sanitize_text_field(trim($_GET['archive_query']));
			switch($swi_archive_query){
				case 'comment':
					$query->set('orderby', 'comment_count date');
					$query->set('order', 'DESC');
					break;
					
				case 'view':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view_sorting'), 10, 2);
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all_sorting'), 10, 2);
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_sorting'), 10, 2);
					}
					break;
					
				case 'like':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like_sorting'), 10, 2);
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like_sorting'), 10, 2);
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all_sorting'), 10, 2);
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby_sorting'), 10, 2);
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like_sorting'), 10, 2);
					}
					break;
					
				case 'title':
					$query->set('orderby', 'title');
					$query->set('order', 'ASC');
					break;
					
				case 'mostsubscribed':
					if(class_exists('vidorev_like_view_sorting') && defined('CHANNEL_PM_PREFIX')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_subscribed_sorting'), 10, 2);
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_subscribed_sorting'), 10, 2);
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_subscribed_sorting'), 10, 2);
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby_sorting'), 10, 2);						
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_sorting'), 10, 2);						
					}
					break;
					
				case 'highest_rated':
					if(class_exists('vidorev_like_view_sorting') && defined('YASR_LOG_TABLE')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_star_rating_sorting'), 10, 2);
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_star_rating_sorting'), 10, 2);
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_star_rating_sorting'), 10, 2);						
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby_sorting'), 10, 2);						
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_sorting'), 10, 2);						
					}
					break;					
			}
		}
		
		if(isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!='' && class_exists('vidorev_like_view_sorting') && $query->is_main_query() && $query->is_archive()){
			add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_alphabet'), 10, 2);
		}		
	}
}
if(!is_admin()){
   add_filter('pre_get_posts', 'vidorev_archive_advance_sorting');
}

if(!function_exists('vidorev_get_video_post_count_by_author')){
	function vidorev_get_post_count_by_author($user_id = 1, $video = true){
		$args_query = array(
						'post_type' 		=> 'post',
						'author'    		=> $user_id,
						'post_staus'		=> 'publish',
						'posts_per_page' 	=> 1,
					);
		
		$args_re 	= array('relation' => 'AND');
		
		$operator = 'IN';
		if(!$video){
			$operator = 'NOT IN';
		}
		$args_re[] 	= array(
						'taxonomy'  => 'post_format',
						'field'    	=> 'slug',
						'terms'     => array('post-format-video'),
						'operator'  => $operator,
					);
					
		$args_query['tax_query'] = $args_re;			
	
		$query = new WP_Query($args_query);
	
		$count = $query->found_posts;
		
		wp_reset_postdata();
		
		return apply_filters('vidorev_number_format', $count);
	}
}

if(!function_exists('vidorev_remove_number_user_edit_post_title')){
	function vidorev_remove_number_user_edit_post_title(){		
		if(!defined('VIDOREV_EXTENSIONS')){
			add_filter('vidorev_front_end_edit_post', function($post_id){
				return '';
			});
		}
	}
}
add_action('init', 'vidorev_remove_number_user_edit_post_title');

if(!function_exists('vidorev_snippet_author_base')){
	function vidorev_snippet_author_base() {
		global $wp_rewrite;
		$author_slug = 'author';
		$new_slug = vidorev_get_redux_option('author_slug', '');
		if($new_slug!=''){
			$author_slug = sanitize_title($new_slug);
		}
		$wp_rewrite->author_base = $author_slug;
	}
}
add_action('init', 'vidorev_snippet_author_base');

if(!function_exists('vidorev_get_nopaging_url')){
	function vidorev_get_nopaging_url() {
		global $wp;
		$current_url = home_url( $wp->request );
		$position = strpos( $current_url , '/page' );
		$nopaging_url = ( $position ) ? substr( $current_url, 0, $position ) : $current_url;
		return add_query_arg( $wp->query_string, '', trailingslashit( $nopaging_url ));
	}
}

if(!function_exists('vidorev_user_submit_video')){
	function vidorev_user_submit_video($newPost) {
		if(isset($newPost) && is_array($newPost) && isset($newPost['id']) && is_numeric($newPost['id'])){
			$tag 			= 'post-format-video';
			$taxonomy 		= 'post_format';
			wp_set_post_terms( $newPost['id'], $tag, $taxonomy );
			
			$new_post = array(
				'ID' => $newPost['id'],
			);
			
			wp_update_post( $new_post );
		}
	}
}
add_action('usp_insert_after', 'vidorev_user_submit_video', 10, 1);

if(!function_exists('videorev_social_locker')){
	function videorev_social_locker($player_content, $post_id){
		$vid_social_locker 		= trim(get_post_meta($post_id, 'vid_social_locker', true));
		$vid_locker_mode		= trim(get_post_meta($post_id, 'vid_locker_mode', true));
		if($vid_locker_mode == ''){
			$vid_locker_mode = 'social';
		}
		$player_content 		= trim($player_content);		
		
		if($vid_social_locker == 'on' && (function_exists('onp_sl_init_bizpanda')||function_exists('onp_op_init_bizpanda')) && $vid_locker_mode=='social'){
			$vid_social_locker_id = trim(get_post_meta($post_id, 'vid_social_locker_id', true));
			if($vid_social_locker_id!='' && is_numeric($vid_social_locker_id)){
				return do_shortcode('[sociallocker id="'.esc_attr($vid_social_locker_id).'"]'.$player_content.'[/sociallocker]');
			}else{
				return do_shortcode('[sociallocker]'.$player_content.'[/sociallocker]');
			}			
		}elseif($vid_social_locker == 'on' && function_exists('onp_op_init_bizpanda') && $vid_locker_mode=='email'){
			$vid_social_email_locker_id = trim(get_post_meta($post_id, 'vid_social_email_locker_id', true));
			if($vid_social_email_locker_id!='' && is_numeric($vid_social_email_locker_id)){
				return do_shortcode('[emaillocker id="'.esc_attr($vid_social_email_locker_id).'"]'.$player_content.'[/emaillocker]');
			}else{
				return do_shortcode('[emaillocker]'.$player_content.'[/emaillocker]');
			}
		}elseif($vid_social_locker == 'on' && function_exists('onp_op_init_bizpanda') && $vid_locker_mode=='signin'){
			$vid_social_signin_locker_id = trim(get_post_meta($post_id, 'vid_social_signin_locker_id', true));
			if($vid_social_signin_locker_id!='' && is_numeric($vid_social_signin_locker_id)){
				return do_shortcode('[signinlocker id="'.esc_attr($vid_social_signin_locker_id).'"]'.$player_content.'[/signinlocker]');
			}else{
				return do_shortcode('[signinlocker]'.$player_content.'[/signinlocker]');
			}	
		}else{
			return $player_content;
		}
	}
}
add_filter('vidorev_single_player_html', 'videorev_social_locker', 10, 2);

if(!function_exists('videorev_membership_locker')){
	function videorev_membership_locker($player_content, $post_id){
		
		$vid_membership_action = trim(get_post_meta($post_id, 'vid_membership_action', true));
		
		if(function_exists('pmpro_has_membership_access') && ($vid_membership_action == 'content-video' || $vid_membership_action == 'trailer')){
			$hasaccess = pmpro_has_membership_access($post_id, NULL, true);
			if(is_array($hasaccess)){
				$post_membership_levels_ids 	= $hasaccess[1];
				$post_membership_levels_names	= $hasaccess[2];
				$hasaccess 						= $hasaccess[0];
			}
			
			if($hasaccess){
				return $player_content;
			}elseif($vid_membership_action == 'content-video'){
				ob_start();
					if(has_post_thumbnail($post_id) && $imgsource = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_16x9_3x')){
						$img_background_cover = $imgsource[0];
					}
					
					$lock_text = esc_html__('This content is for !!levels!! members only.', 'vidorev');
					
					if(!isset($post_membership_levels_ids) || empty($post_membership_levels_ids)){
						$post_membership_levels_ids = array();
					}
			
					if(!isset($post_membership_levels_names) || empty($post_membership_levels_names)){
						$post_membership_levels_names = array();
					}
					
					$sr_search 	= array('!!levels!!');
					$sr_replace = array('<span class="level-highlight">'.pmpro_implodeToEnglish($post_membership_levels_names, esc_html__('or', 'vidorev')).'</span>');
					
					$register_url = wp_registration_url();
					if(function_exists('pmpro_getOption')){
						$levels_page_id = pmpro_getOption("levels_page_id");
						if(is_numeric($levels_page_id)){
							$register_url = get_permalink($levels_page_id);
						}
					}
				?>
					<div class="vidorev-membership-wrapper">
						<?php if(isset($img_background_cover)){?>
							<img src="<?php echo esc_url($img_background_cover)?>" alt="<?php echo esc_attr__('Video Image', 'vidorev');?>" class="membership-placeholder">
						<?php }?>
						
						<div class="vidorev-membership-content">
							<h3 class="h4 h6-mobile membership-lock-text"><?php echo str_replace($sr_search, $sr_replace, $lock_text);?></h3>
							<a class="basic-button basic-button-default" target="_blank" href="<?php echo esc_url(apply_filters('vidorev_replace_pmp_levels_page_url', $register_url, $post_id));?>"><?php echo esc_html__('Register', 'vidorev');?></a>
						</div>
					</div>
				<?php
				$output_string = ob_get_contents();
				ob_end_clean();
				return $output_string;
			}elseif($vid_membership_action == 'trailer'){

				$lock_text = wp_kses(__('Trailer: This video is for !!levels!! members only [ <a href="!!register_url!!" target="_blank"><strong>REGISTER</strong></a> ].', 'vidorev'), array('a'=>array('href'=>array(), 'target'=>array()), 'strong'=>array()));			
				if(!isset($post_membership_levels_ids) || empty($post_membership_levels_ids)){
					$post_membership_levels_ids = array();
				}
		
				if(!isset($post_membership_levels_names) || empty($post_membership_levels_names)){
					$post_membership_levels_names = array();
				}
				
				$register_url = wp_registration_url();
				if(function_exists('pmpro_getOption')){
					$levels_page_id = pmpro_getOption("levels_page_id");
					if(is_numeric($levels_page_id)){
						$register_url = get_permalink($levels_page_id);
					}
				}
				
				$sr_search 	= array('!!levels!!', '!!register_url!!');
				$sr_replace = array('<span class="level-highlight">'.pmpro_implodeToEnglish($post_membership_levels_names, esc_html__('or', 'vidorev')).'</span>', esc_url($register_url));
				
				return $player_content.'<div class="trailer-notice">'.str_replace($sr_search, $sr_replace, $lock_text).'</div>';
			}
		}
		
		return $player_content;
	}
}
add_filter('vidorev_single_player_html', 'videorev_membership_locker', 20, 2);

if(!function_exists('videorev_prime_locker')){
	function videorev_prime_locker($player_content, $post_id){
		
		if(!class_exists( 'WooCommerce' ) || trim(get_post_meta($post_id, 'vid_download_type', true)) != 'paid' || trim(get_post_meta($post_id, 'vid_download_mode', true)) != 'protect'){
			return $player_content;
		}
		
		$vid_woo_product 			= get_post_meta($post_id, 'vid_woo_product', true);
		$vid_woo_product 			= (int)$vid_woo_product;
		
		if($vid_woo_product == '' || $vid_woo_product == 0){
			return $player_content;
		}
		
		$woo_product_download 		= function_exists('wc_get_product')?wc_get_product($vid_woo_product):get_product($vid_woo_product);		
		
		if(!isset($woo_product_download) || empty($woo_product_download)){
			return $player_content;
		}	
		
		$current_user = wp_get_current_user();	
					
		if($current_user->exists() && $woo_product_download->is_virtual() && wc_customer_bought_product( $current_user->user_email, $current_user->ID, $vid_woo_product )){
			return $player_content;
		}else{
			ob_start();
				if(has_post_thumbnail($post_id) && $imgsource = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_16x9_3x')){
					$img_background_cover = $imgsource[0];
				}
				
				$price = '';
				if(isset($woo_product_download) && !empty($woo_product_download)){
					$price = $woo_product_download->get_price_html();
				}
				
				$vid_download_mode_trailer = trim(get_post_meta($post_id, 'vid_download_mode_trailer', true));				
		?>
                <div class="vidorev-membership-wrapper prime-video prime-video-control">
                    <?php if(isset($img_background_cover)){?>
                        <img src="<?php echo esc_url($img_background_cover)?>" alt="<?php echo esc_attr__('Video Image', 'vidorev');?>" class="membership-placeholder">
                    <?php }?>
                    
                    <div class="vidorev-membership-content">
                        <h3 class="h4 h6-mobile membership-lock-text"><?php echo esc_html__('Want to see the full video?', 'vidorev');?></h3>
                        <?php if($vid_download_mode_trailer!=''){?>
                        	<a class="basic-button basic-button-default" href="<?php echo esc_url(add_query_arg(array('watch_trailer' => '1'), get_permalink($post_id)));?>"><?php echo esc_html__('Watch Trailer', 'vidorev')?></a>
                        <?php }?>
                        <a class="basic-button basic-button-default prime-price" target="_blank" href="<?php echo esc_url(get_permalink($vid_woo_product));?>"><?php echo esc_html__('Buy Now:', 'vidorev').' '.apply_filters('vidorev_woo_download_price', $price);?></a>                        
                    </div>
                </div>		    
        <?php
			$output_string = ob_get_contents();
			ob_end_clean();
			
			if(isset($_GET['watch_trailer']) && $_GET['watch_trailer'] == 1){
				return $player_content;
			}else{
				return $output_string;
			}			
		}
		
		return $player_content;
	}
}
add_filter('vidorev_single_player_html', 'videorev_prime_locker', 20, 2);

if(!function_exists('beeteam368_woo_membership_locker')){
	function beeteam368_woo_membership_locker($player_content, $post_id){
		
		if(!class_exists( 'WooCommerce' ) || !function_exists('wc_memberships') || !wc_memberships_is_post_content_restricted( $post_id )){
			return $player_content;
		}
		
		$is_user_logged_in 		= is_user_logged_in();		
		$vid_membership_action 	= trim(get_post_meta($post_id, 'vid_membership_action', true));
		
		if ( $is_user_logged_in && current_user_can( 'wc_memberships_view_restricted_post_content', $post_id ) && current_user_can( 'wc_memberships_view_delayed_post_content', $post_id ) ) {
						
			return $player_content;
			
		} else {
			/*access-restricted*/			
			if($vid_membership_action == 'content-video' || $vid_membership_action == 'trailer'){				
				ob_start();
					if(has_post_thumbnail($post_id) && $imgsource = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_16x9_3x')){
						$img_background_cover = $imgsource[0];
					}				
					$vid_woo_membership_locker_trailer = trim(get_post_meta($post_id, 'vm_video_trailer_url', true));
					
					$message_code 	= 'restricted';
					
					/*access-delayed*/
					if ( $is_user_logged_in && current_user_can( 'wc_memberships_view_restricted_post_content', $post_id ) && !current_user_can( 'wc_memberships_view_delayed_post_content', $post_id ) ) {
						$message_code 	= 'delayed';
					}
					
					$wm_get_post 	= get_post($post_id);
					
					$args = array(
						'post'         		=> $wm_get_post,
						'message_type' 		=> $message_code,
						'use_excerpt'		=> false
					);
					
					/*access-delayed*/
					if ( $message_code == 'delayed' ) {
						$args['access_time'] = wc_memberships()->get_capabilities_instance()->get_user_access_start_time_for_post( get_current_user_id(), $post_id );
					}
					
					$message_code = \WC_Memberships_User_Messages::get_message_code_shorthand_by_post_type( $wm_get_post, $args );
					$content      = \WC_Memberships_User_Messages::get_message_html( $message_code, $args );
					
				?>
				
					<div class="vidorev-membership-wrapper prime-video prime-video-control">
						<?php if(isset($img_background_cover)){?>
							<img src="<?php echo esc_url($img_background_cover)?>" alt="<?php echo esc_attr__('Video Image', 'vidorev');?>" class="membership-placeholder">
						<?php }?>
						
						<div class="vidorev-membership-content">
							<?php echo apply_filters( 'vidorev_woo_mb_custom_messages', $content, $post_id );?>
							<?php if($vid_woo_membership_locker_trailer!=''){?>
								<a class="basic-button basic-button-default" href="<?php echo esc_url(add_query_arg(array('watch_trailer' => '1'), get_permalink($post_id)));?>"><?php echo esc_html__('Watch Trailer', 'vidorev')?></a>
							<?php }?>							      
						</div>
					</div>	
				
				<?php
				
				$output_string = ob_get_contents();
				ob_end_clean();
				
				if(isset($_GET['watch_trailer']) && $_GET['watch_trailer'] == 1){
					return $player_content.'<div class="trailer-notice woo-mem">'.$content.'</div>';
				}else{
					return $output_string;
				}
			
			}else{
				return $player_content;
			}
		}
		
		return $player_content;
	}
}
add_filter('vidorev_single_player_html', 'beeteam368_woo_membership_locker', 20, 2);

if(!function_exists('vidorev_mycred_locker')){
	function vidorev_mycred_locker($player_content, $post_id){
		
		$old_player_content 	= $player_content;
		$vid_myCred_action 		= trim(get_post_meta($post_id, 'vid_membership_action', true));
		
		if(defined( 'myCRED_SELL' ) && defined( 'myCRED_VERSION' ) && ( $vid_myCred_action == 'content-video' || $vid_myCred_action == 'trailer' ) ){
			
			$vid_myCred_locker_trailer = trim(get_post_meta($post_id, 'vm_video_trailer_url', true));
			if($vid_myCred_locker_trailer!=''){
				$myCred_watch_later_btn = '<br><br><a class="basic-button basic-button-default" href="'.esc_url(add_query_arg(array('watch_trailer' => '1'), get_permalink($post_id))).'">'.esc_html__('Watch Trailer', 'vidorev').'</a>';
			}else{
				$myCred_watch_later_btn = '';
			}
			
			$watch_trailer_query = (isset($_GET['watch_trailer']) && $_GET['watch_trailer'] == 1 && $vid_myCred_action == 'trailer');
			
			if($watch_trailer_query){
				$myCred_watch_later_btn = '';
			}
			
			global $mycred_partial_content_sale, $mycred_modules;
			
			$post     = mycred_get_post( $post_id );
			$user_id  = get_current_user_id();
			$is_admin = mycred_is_admin( $user_id );
			$is_owner = ( (int) $post->post_author === $user_id ) ? true : false;
			
			$mycred_partial_content_sale = true;
			
			if(has_post_thumbnail($post_id) && $imgsource = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_16x9_3x')){
				$img_background_cover = $imgsource[0];
			}	
			
			if( mycred_post_is_for_sale( $post )){
			
				if ( is_user_logged_in() ) {
					
					if ( ! $is_admin && ! $is_owner ) {
		
						if ( ! mycred_user_paid_for_content( $user_id, $post_id ) ) {
		
							$payment_options = mycred_sell_content_payment_buttons( $user_id, $post_id );
								
							if ( $payment_options !== false ) {	
								$player_content = $mycred_modules['solo']['content']->sell_content['templates']['members'];
								
								if($watch_trailer_query){
									$player_content = str_replace( '%buy_button%', '<br><br>'.$payment_options, $player_content );
								}else{
									if($myCred_watch_later_btn==''){
										$player_content = str_replace( '%buy_button%', '<br><br>'.$payment_options, $player_content );
									}else{
										$player_content = str_replace( '%buy_button%', $payment_options, $player_content );
									}
								}
								
								$player_content = mycred_sell_content_template( $player_content, $post, 'mycred-sell-partial-content', 'mycred-sell-unpaid' );
									
							}else {	
								$player_content = $mycred_modules['solo']['content']->sell_content['templates']['cantafford'];
								$player_content = mycred_sell_content_template( $player_content, $post, 'mycred-sell-partial-content', 'mycred-sell-insufficient' );	
							}
							
							ob_start();
								$player_content = str_replace( '<span class="myCred-watch-trailer-btn">%watch_trailer_button%</span>', $myCred_watch_later_btn, $player_content );
							?>
                            	<div class="vidorev-membership-wrapper dark-background">
									<?php if(isset($img_background_cover)){?>
                                        <img src="<?php echo esc_url($img_background_cover)?>" alt="<?php echo esc_attr__('Video Image', 'vidorev');?>" class="membership-placeholder">
                                    <?php }?>
                                    
                                    <div class="vidorev-membership-content">
                                    	<?php echo apply_filters( 'vidorev_myCred_mb_custom_contents', $player_content, $post_id );?>
                                    </div>
                                </div>
                            <?php	
							$output_string = ob_get_contents();
							ob_end_clean();		
							
							if($watch_trailer_query){
								return $old_player_content.'<div class="trailer-notice mycred_elm">'.$player_content.'</div>';
							}else{
								return $output_string;
							}
										
						}
		
					}
		
				}else {
					
					$player_content = $mycred_modules['solo']['content']->sell_content['templates']['visitors'];
					$player_content = mycred_sell_content_template( $player_content, $post, 'mycred-sell-partial-content', 'mycred-sell-visitor' );
					$player_content = str_replace( '<span class="myCred-watch-trailer-btn">%watch_trailer_button%</span>', $myCred_watch_later_btn, $player_content );
					ob_start();							
					?>
						<div class="vidorev-membership-wrapper dark-background">
							<?php if(isset($img_background_cover)){?>
								<img src="<?php echo esc_url($img_background_cover)?>" alt="<?php echo esc_attr__('Video Image', 'vidorev');?>" class="membership-placeholder">
							<?php }?>
							
							<div class="vidorev-membership-content">
								<?php echo apply_filters( 'vidorev_myCred_mb_custom_contents', $player_content, $post_id );?>
							</div>
						</div>	
					
					<?php	
					$output_string = ob_get_contents();
					ob_end_clean();		
					
					if($watch_trailer_query){
						return $old_player_content.'<div class="trailer-notice mycred_elm">'.$player_content.'</div>';
					}else{
						return $output_string;
					}
				}
			}
			
		}
		
		return $player_content;
	}
}
add_filter('vidorev_single_player_html', 'vidorev_mycred_locker', 20, 2);

if(!function_exists('videorev_membership_video_url')){
	function videorev_membership_video_url($url, $post_id){
		if(function_exists('pmpro_has_membership_access') && trim(get_post_meta($post_id, 'vid_membership_action', true)) == 'trailer'){
			$hasaccess = pmpro_has_membership_access($post_id, NULL, true);
			if(is_array($hasaccess)){
				$post_membership_levels_ids 	= $hasaccess[1];
				$post_membership_levels_names	= $hasaccess[2];
				$hasaccess 						= $hasaccess[0];
			}
			
			if($hasaccess){
				return $url;
			}else{
				return trim(get_post_meta($post_id, 'vm_video_trailer_url', true));
			}
		}
		return $url;
	}
}
add_filter('vidorev_single_video_url', 'videorev_membership_video_url', 5, 2);

if(!function_exists('videorev_prime_video_url')){
	function videorev_prime_video_url($url, $post_id){
		if(class_exists( 'WooCommerce' ) && trim(get_post_meta($post_id, 'vid_download_type', true)) == 'paid' && trim(get_post_meta($post_id, 'vid_download_mode', true)) == 'protect'){
			
			$vid_woo_product 		= get_post_meta($post_id, 'vid_woo_product', true);
			$vid_woo_product 		= (int)$vid_woo_product;
			
			if($vid_woo_product == '' || $vid_woo_product == 0){
				return $url;
			}
			
			$woo_product_download 	= function_exists('wc_get_product')?wc_get_product($vid_woo_product):get_product($vid_woo_product);
			$current_user 			= wp_get_current_user();
						
			if($current_user->exists() && isset($woo_product_download) && !empty($woo_product_download) && $woo_product_download->is_virtual() && wc_customer_bought_product( $current_user->user_email, $current_user->ID, $vid_woo_product )){
				return $url;
			}else{
				$vid_download_mode_trailer = trim(get_post_meta($post_id, 'vid_download_mode_trailer', true));
				if($vid_download_mode_trailer == ''){
					$vid_download_mode_trailer = 'https://';
				}
				return $vid_download_mode_trailer;
			}
		}
		return $url;
	}
}
add_filter('vidorev_single_video_url', 'videorev_prime_video_url', 5, 2);

if(!function_exists('beeteam368_woo_membership_video_url')){
	function beeteam368_woo_membership_video_url($url, $post_id){
		
		if(class_exists( 'WooCommerce' ) && function_exists('wc_memberships') && wc_memberships_is_post_content_restricted( $post_id ) && trim(get_post_meta($post_id, 'vid_membership_action', true)) == 'trailer'){
			$is_user_logged_in = is_user_logged_in();
			
			if ( $is_user_logged_in && current_user_can( 'wc_memberships_view_restricted_post_content', $post_id ) && current_user_can( 'wc_memberships_view_delayed_post_content', $post_id )) {
				
				return $url;
				
			} else {
				/*access-restricted*/
				return trim(get_post_meta($post_id, 'vm_video_trailer_url', true));
			}
					
		}

		return $url;
	}
}
add_filter('vidorev_single_video_url', 'beeteam368_woo_membership_video_url', 5, 2);

if(!function_exists('vidorev_mycred_video_url')){
	function vidorev_mycred_video_url($url, $post_id){
		
		if(defined( 'myCRED_SELL' ) && defined( 'myCRED_VERSION' ) && trim(get_post_meta($post_id, 'vid_membership_action', true)) == 'trailer'){

			global $mycred_partial_content_sale, $mycred_modules;
			
			$post     = mycred_get_post( $post_id );
			$user_id  = get_current_user_id();
			$is_admin = mycred_is_admin( $user_id );
			$is_owner = ( (int) $post->post_author === $user_id ) ? true : false;
			
			$mycred_partial_content_sale = true;
			
			if( mycred_post_is_for_sale( $post )){
			
				if ( is_user_logged_in() ) {
					
					if ( ! $is_admin && ! $is_owner ) {
		
						if ( ! mycred_user_paid_for_content( $user_id, $post_id ) ) {
		
							$payment_options = mycred_sell_content_payment_buttons( $user_id, $post_id );
								
							if ( $payment_options !== false ) {	
							
								/*access-restricted*/
								return trim(get_post_meta($post_id, 'vm_video_trailer_url', true));
								
							}else {	
							
								/*access-restricted*/
								return trim(get_post_meta($post_id, 'vm_video_trailer_url', true));
								
							}
								
						}
		
					}
		
				}else {
					
					/*access-restricted*/
					return trim(get_post_meta($post_id, 'vm_video_trailer_url', true));
					
				}
			}
			
		}
		
		return $url;
	}
}
add_filter('vidorev_single_video_url', 'vidorev_mycred_video_url', 5, 2);

if(!function_exists('videorev_membership_video_shortcode')){
	function videorev_membership_video_shortcode($shortcode, $post_id){
		if(function_exists('pmpro_has_membership_access') && trim(get_post_meta($post_id, 'vid_membership_action', true)) == 'trailer'){
			$hasaccess = pmpro_has_membership_access($post_id, NULL, true);
			if(is_array($hasaccess)){
				$post_membership_levels_ids 	= $hasaccess[1];
				$post_membership_levels_names	= $hasaccess[2];
				$hasaccess 						= $hasaccess[0];
			}
			
			if($hasaccess){
				return $shortcode;
			}else{
				return '';
			}
		}
		return $shortcode;
	}
}
add_filter('vidorev_single_video_shortcode', 'videorev_membership_video_shortcode', 5, 2);

if(!function_exists('videorev_prime_video_shortcode')){
	function videorev_prime_video_shortcode($shortcode, $post_id){
		if(class_exists( 'WooCommerce' ) && trim(get_post_meta($post_id, 'vid_download_type', true)) == 'paid' && trim(get_post_meta($post_id, 'vid_download_mode', true)) == 'protect'){
			
			$vid_woo_product 		= get_post_meta($post_id, 'vid_woo_product', true);
			$vid_woo_product 		= (int)$vid_woo_product;
			
			if($vid_woo_product == '' || $vid_woo_product == 0){
				return $shortcode;
			}
			
			$woo_product_download 	= function_exists('wc_get_product')?wc_get_product($vid_woo_product):get_product($vid_woo_product);
			$current_user 			= wp_get_current_user();
						
			if($current_user->exists() && isset($woo_product_download) && !empty($woo_product_download) && $woo_product_download->is_virtual() && wc_customer_bought_product( $current_user->user_email, $current_user->ID, $vid_woo_product )){
				return $shortcode;
			}else{
				return '';
			}
		}
		return $shortcode;
	}
}
add_filter('vidorev_single_video_shortcode', 'videorev_prime_video_shortcode', 5, 2);

if(!function_exists('beeteam368_woo_membership_video_shortcode')){
	function beeteam368_woo_membership_video_shortcode($shortcode, $post_id){
				
		if(class_exists( 'WooCommerce' ) && function_exists('wc_memberships') && wc_memberships_is_post_content_restricted( $post_id ) && trim(get_post_meta($post_id, 'vid_membership_action', true)) == 'trailer'){
			$is_user_logged_in = is_user_logged_in();
			
			if ( $is_user_logged_in && current_user_can( 'wc_memberships_view_restricted_post_content', $post_id ) && current_user_can( 'wc_memberships_view_delayed_post_content', $post_id )) {				
					return $shortcode;
			} else {
				/*access-restricted*/
				return '';
			}
					
		}
		
		return $shortcode;
	}
}
add_filter('vidorev_single_video_shortcode', 'beeteam368_woo_membership_video_shortcode', 5, 2);


if(!function_exists('vidorev_mycred_video_shortcode')){
	function vidorev_mycred_video_shortcode($shortcode, $post_id){
		
		if(defined( 'myCRED_SELL' ) && defined( 'myCRED_VERSION' )  && trim(get_post_meta($post_id, 'vid_membership_action', true)) == 'trailer'){

			global $mycred_partial_content_sale, $mycred_modules;
			
			$post     = mycred_get_post( $post_id );
			$user_id  = get_current_user_id();
			$is_admin = mycred_is_admin( $user_id );
			$is_owner = ( (int) $post->post_author === $user_id ) ? true : false;
			
			$mycred_partial_content_sale = true;
			
			if( mycred_post_is_for_sale( $post )){
			
				if ( is_user_logged_in() ) {
					
					if ( ! $is_admin && ! $is_owner ) {
		
						if ( ! mycred_user_paid_for_content( $user_id, $post_id ) ) {
		
							$payment_options = mycred_sell_content_payment_buttons( $user_id, $post_id );
								
							if ( $payment_options !== false ) {	
							
								/*access-restricted*/
								return '';
								
							}else {	
							
								/*access-restricted*/
								return '';
								
							}
								
						}
		
					}
		
				}else {
					
					/*access-restricted*/
					return '';
					
				}
			}
			
		}
		
		return $shortcode;
	}
}
add_filter('vidorev_single_video_shortcode', 'vidorev_mycred_video_shortcode', 5, 2);


if(!function_exists('beeteam368_identify_player')){
	function beeteam368_identify_player($player_library, $post_id, $vm_video_url){
		
		if(vidorev_get_redux_option('identify_player', 'off', 'switch')=='on' && ($player_library == 'vp' || $player_library == 'fluidplayer')){
			$vidNetwork = vidorev_detech_video_data::getVideoNetwork($vm_video_url);
			if($vidNetwork=='self-hosted'){
				$path      = parse_url($vm_video_url, PHP_URL_PATH);
				$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
				
				if(($extension == 'm3u8' || $extension == 'mp4' || $extension == 'webm' || $extension == 'm4v' || $extension == 'ogv' || $extension == 'mov' || $extension == 'wmv' || $extension == 'avi' || $extension == 'mpg' || $extension == '3gp' || $extension == '3g2') && $player_library!='fluidplayer'){
					$player_library = 'fluidplayer';
					return $player_library;
				}
				
			}else{
				if($player_library!='vp'){
					$player_library = 'vp';
					return $player_library;
				}
			}
		}
		
		return $player_library;	
	}
}
add_filter('vidorev_single_player_library', 'beeteam368_identify_player', 6, 3);

if(!function_exists('beeteam368_identify_player_streaming')){
	function beeteam368_identify_player_streaming($streaming, $post_id, $vm_video_url){
		if(vidorev_get_redux_option('identify_player', 'off', 'switch')=='on'){
			$vidNetwork = vidorev_detech_video_data::getVideoNetwork($vm_video_url);
			if($vidNetwork=='self-hosted'){
				$path      = parse_url($vm_video_url, PHP_URL_PATH);
				$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
				
				if($extension == 'm3u8' && $streaming!='HLS'){
					$streaming = 'HLS';
					return $streaming;
				}elseif( ($extension == 'mp4' || $extension == 'webm' || $extension == 'm4v' || $extension == 'ogv' || $extension == 'mov' || $extension == 'wmv' || $extension == 'avi' || $extension == 'mpg' || $extension == '3gp' || $extension == '3g2' ) && $streaming!='no'){
					$streaming = 'no';
					return $streaming;
				}
			}
		}
		
		return $streaming;	
	}
}
add_filter('vidorev_single_video_streaming', 'beeteam368_identify_player_streaming', 6, 3);

if(!function_exists('vidorev_add_svg_to_upload_mimes')){
	function vidorev_add_svg_to_upload_mimes( $upload_mimes ) { 
		$upload_mimes['svg'] = 'image/svg+xml'; 
		$upload_mimes['svgz'] = 'image/svg+xml'; 
		return $upload_mimes; 
	} 
}
add_filter( 'upload_mimes', 'vidorev_add_svg_to_upload_mimes', 10, 1 );

if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if ( ! function_exists( 'vidorev_replace_excerpt' ) ) {
	function vidorev_replace_excerpt( $content ) {
		if(defined( 'myCRED_SELL' ) && defined( 'myCRED_VERSION' )){
			return str_replace('%watch_trailer_button%', '', $content );
		}		
		return $content;
	}
}
add_filter('get_the_excerpt', 'vidorev_replace_excerpt');