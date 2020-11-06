<?php
if(! defined( 'CMB2_LOADED' )){
	return;
}

if ( ! function_exists( 'vidorev_cmb_page_options' ) ) :
	function vidorev_cmb_page_options() {
		/*$blog_page_settings*/
			$blog_page_settings = new_cmb2_box( array(
				'id'            => 'blog_page_settings',
				'title'         => esc_html__( 'Blog Page Settings', 'vidorev-extensions'),
				'object_types'  => array( 'page' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_page_title',
				'name'      	=> esc_html__( 'Blog Page Title', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,		
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_page_heading',
				'name'      	=> esc_html__('Page Heading', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'off',	
				'options'       => array(
					'off'    		=> esc_html__('Showing only on page 1', 'vidorev-extensions'),
					'on'    		=> esc_html__('Shown on all pages', 'vidorev-extensions'),						
				),	
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_page_advance_search',
				'name'      	=> esc_html__('Advance Search', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'off',	
				'options'       => array(
					'off'    		=> esc_html__('Disable', 'vidorev-extensions'),
					'on'    		=> esc_html__('Enable', 'vidorev-extensions'),						
				),	
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_page_ic',
				'name'      	=> esc_html__('Include Categories', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Include categories, enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,
				'attributes' => array(
					'data-conditional-id'    => 'blog_page_advance_search',
					'data-conditional-value' => 'off',
				),					
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_page_it',
				'name'      	=> esc_html__('Include Tags', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Include tags, enter tag id or slug, eg: 245, 126, ...', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,
				'attributes' => array(
					'data-conditional-id'    => 'blog_page_advance_search',
					'data-conditional-value' => 'off',
				),				
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_page_ec',
				'name'      	=> esc_html__('Exclude categories', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Exclude categories, enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,
				'attributes' => array(
					'data-conditional-id'    => 'blog_page_advance_search',
					'data-conditional-value' => 'off',
				),				
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_page_ip',
				'name'      	=> esc_html__('Include Posts', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Enter post id, eg: 1136, 2251, ...', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,
				'attributes' => array(
					'data-conditional-id'    => 'blog_page_advance_search',
					'data-conditional-value' => 'off',
				),				
			));
			
			$blog_page_settings->add_field( array(
				'name'      	=> esc_html__( 'Advance Search ID', 'vidorev-extensions'),
				'id'        	=> 'blog_page_advance_search_id',
				'type'      	=> 'post_search_ajax',
				'desc'			=> esc_html__( 'Start typing ...', 'vidorev-extensions'),
				'limit'      	=> 1, 		
				'sortable' 	 	=> true,
				'query_args'	=> array(
					'post_type'			=> array( 'filter_tags' ),
					'post_status'		=> array( 'publish' ),
					'posts_per_page'	=> -1
				),
				'attributes' => array(
					'data-conditional-id'    => 'blog_page_advance_search',
					'data-conditional-value' => 'on',
				),
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'archive_loop_style',
				'name'      	=> esc_html__('Loop Style', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select Loop Style', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> 'list-blog',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					'grid-default'    	=> esc_html__('Grid - Default', 'vidorev-extensions'),
					'list-default'    	=> esc_html__('List - Default', 'vidorev-extensions'),
					'grid-special'    	=> esc_html__('Grid - Special', 'vidorev-extensions'),
					'list-special'    	=> esc_html__('List - Special', 'vidorev-extensions'),
					'grid-modern'    	=> esc_html__('Grid - Modern', 'vidorev-extensions'),
					'movie-grid'    	=> esc_html__('Grid - Poster', 'vidorev-extensions'),
					'list-blog'			=> esc_html__('List - Blog Wide', 'vidorev-extensions'),
					'movie-list'    	=> esc_html__('List - Poster', 'vidorev-extensions'),
					'grid-small'    	=> esc_html__('Grid - Small', 'vidorev-extensions'),
					/*new layout*/				
				),
				'images'        => array(
					'grid-default'    	=> 'img/to-pic/grid-default.jpg',
					'list-default'    	=> 'img/to-pic/list-default.jpg',
					'grid-special'    	=> 'img/to-pic/grid-special.jpg',
					'list-special'    	=> 'img/to-pic/list-special.jpg',
					'grid-modern'    	=> 'img/to-pic/grid-modern.jpg',
					'movie-grid'    	=> 'img/to-pic/grid-poster.jpg',
					'list-blog'    		=> 'img/to-pic/list-blog.jpg',
					'movie-list'    	=> 'img/to-pic/list-poster.jpg',
					'grid-small'    	=> 'img/to-pic/grid-small.jpg',
					/*new layout*/
				),	
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_image_ratio',
				'name'      	=> esc_html__('Image Ratio', 'vidorev-extensions'),
				'desc'        	=> esc_html__('This option will change the ratio of the image for this blog page.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'16_9'    	=> esc_html__('Video - 16:9', 'vidorev-extensions'),
					'4_3'    	=> esc_html__('Blog - 4:3', 'vidorev-extensions'),
					'2_3'    	=> esc_html__('Movie - 2:3', 'vidorev-extensions'),						
				),	
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_show_categories',
				'name'      	=> esc_html__('Display Post Categories', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'on',	
				'options'       => array(
					'on'    	=> esc_html__('YES', 'vidorev-extensions'),
					'off'    	=> esc_html__('NO', 'vidorev-extensions'),							
				),	
			));
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_show_excerpt',
				'name'      	=> esc_html__('Display Post Excerpt', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'on',	
				'options'       => array(
					'on'    	=> esc_html__('YES', 'vidorev-extensions'),
					'off'    	=> esc_html__('NO', 'vidorev-extensions'),							
				),	
			));
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_show_author',
				'name'      	=> esc_html__('Display Post Author', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'on',	
				'options'       => array(
					'on'    	=> esc_html__('YES', 'vidorev-extensions'),
					'off'    	=> esc_html__('NO', 'vidorev-extensions'),							
				),	
			));
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_show_date',
				'name'      	=> esc_html__('Display Post Published Date', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'on',	
				'options'       => array(
					'on'    	=> esc_html__('YES', 'vidorev-extensions'),
					'off'    	=> esc_html__('NO', 'vidorev-extensions'),							
				),	
			));
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_show_comment_count',
				'name'      	=> esc_html__('Display Post Comment Count', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'on',	
				'options'       => array(
					'on'    	=> esc_html__('YES', 'vidorev-extensions'),
					'off'    	=> esc_html__('NO', 'vidorev-extensions'),							
				),	
			));
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_show_view_count',
				'name'      	=> esc_html__('Display Post View Count', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'on',	
				'options'       => array(
					'on'    	=> esc_html__('YES', 'vidorev-extensions'),
					'off'    	=> esc_html__('NO', 'vidorev-extensions'),							
				),	
			));
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_show_like_count',
				'name'      	=> esc_html__('Display Post Like Count', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'on',	
				'options'       => array(
					'on'    	=> esc_html__('YES', 'vidorev-extensions'),
					'off'    	=> esc_html__('NO', 'vidorev-extensions'),							
				),	
			));
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_show_dislike_count',
				'name'      	=> esc_html__('Display Post Dislike Count', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'on',	
				'options'       => array(
					'on'    	=> esc_html__('YES', 'vidorev-extensions'),
					'off'    	=> esc_html__('NO', 'vidorev-extensions'),							
				),	
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_items_per_page',
				'name'      	=> esc_html__('Items Per Page', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Number of items to show per page. Defaults to: 10', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,	
				'default'		=> '10',		
			));
			
			$blog_page_settings->add_field( array(			
				'id'        	=> 'blog_pag_type',
				'name'      	=> esc_html__('Pagination', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Choose type of navigation for blog. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'wp-default',	
				'options'       => array(
					'wp-default'    	=> esc_html__('WordPress Default', 'vidorev-extensions'),
					'loadmore-btn'    	=> esc_html__('Load More Button (Ajax)', 'vidorev-extensions'),
					'infinite-scroll'   => esc_html__('Infinite Scroll (Ajax)', 'vidorev-extensions'),
					'pagenavi_plugin'   => esc_html__('WP PageNavi (Plugin)', 'vidorev-extensions'),						
				),	
			));
		/*$blog_page_settings*/	
		
		/*$page_options*/
			$page_options = new_cmb2_box( array(
				'id'            => 'page_options',
				'title'         => esc_html__( 'Page Options', 'vidorev-extensions'),
				'object_types'  => array( 'page' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			
			$page_options->add_field( array(
				'name' 			=> esc_html__( 'Get Page Template', 'vidorev-extensions'),
				'id'			=> 'get_page_template',
				'type' 			=> 'text',
				'column'  		=> false,
				'render_row_cb' => 'beeteam368_get_field_page_template',
				'save_field' 	=> false,
			));
			
			$page_options->add_field( array(			
				'id'        	=> 'color_mode',
				'name'      	=> esc_html__('Color Mode', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select Color Mode. Select "Default" to use settings in Theme Options > Styling.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'white'    	=> esc_html__('Light Version', 'vidorev-extensions'),
					'dark'  	=> esc_html__('Dark Version', 'vidorev-extensions'),					
				),	
			));
			
			$page_options->add_field( array(			
				'id'        	=> 'main_layout',
				'name'      	=> esc_html__('Layout', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select "Default" to use settings in Theme Options > Styling.', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'wide'    	=> esc_html__('Wide', 'vidorev-extensions'),
					'boxed'    	=> esc_html__('Inbox', 'vidorev-extensions'),						
				),
				'images'        => array(
					''    		=> 'img/to-pic/to-default.jpg',
					'wide'    	=> 'img/to-pic/layout-wide.jpg',
					'boxed'    	=> 'img/to-pic/layout-inbox.jpg',					
				),	
			));
				$page_options->add_field( array(			
					'id'        	=> 'main_layout_full_with',
					'name'      	=> esc_html__('Full-Width Mode', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Select "Default" to use settings in Theme Options > Styling.', 'vidorev-extensions'),
					'type'      	=> 'select',			
					'column'  		=> false,
					'default'		=> '',
					'options'       => array(
						''    		=> esc_html__('Default', 'vidorev-extensions'),
						'on'    	=> esc_html__('Enable', 'vidorev-extensions'),
						'off'  		=> esc_html__('Disable', 'vidorev-extensions'),					
					),	
					'attributes' => array(
						'data-conditional-id'    => 'main_layout',
						'data-conditional-value' => 'wide',
					),		
				));
			
			$page_options->add_field( array(			
				'id'        	=> 'main_logo',
				'name'      	=> esc_html__('Logo', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$page_options->add_field( array(			
				'id'        	=> 'main_logo_retina',
				'name'      	=> esc_html__('Logo (Retina)', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$page_options->add_field( array(			
				'id'        	=> 'main_logo_mobile',
				'name'      	=> esc_html__('Main logo on mobile devices', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$page_options->add_field( array(			
				'id'        	=> 'main_logo_mobile_retina',
				'name'      	=> esc_html__('Main logo on mobile devices (Retina)', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$page_options->add_field( array(			
				'id'        	=> 'sticky_logo',
				'name'      	=> esc_html__('Logo for Sticky Menu', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$page_options->add_field( array(			
				'id'        	=> 'sticky_logo_retina',
				'name'      	=> esc_html__('Logo for Sticky Menu (Retina)', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));	
			
			$page_options->add_field( array(			
				'id'        	=> 'main_nav_layout',
				'name'      	=> esc_html__('Main Navigation Layout', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select "Default" to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'default'   => esc_html__('Default', 'vidorev-extensions'),
					'classic'   => esc_html__('Classic', 'vidorev-extensions'),
					'sport'    	=> esc_html__('Sport', 'vidorev-extensions'),
					'tech'    	=> esc_html__('Tech', 'vidorev-extensions'),
					'blog'    	=> esc_html__('Blog', 'vidorev-extensions'),
					'movie'    	=> esc_html__('Movie', 'vidorev-extensions'),
					'side'    	=> esc_html__('Side', 'vidorev-extensions'),						
				),
				'images'        => array(
					''    		=> 'img/to-pic/to-default.jpg',
					'default'   => 'img/to-pic/header-1.jpg',
					'classic'   => 'img/to-pic/header-6.jpg',
					'sport'    	=> 'img/to-pic/header-2.jpg',
					'tech'    	=> 'img/to-pic/header-5.jpg',
					'blog'    	=> 'img/to-pic/header-3.jpg',
					'movie'    	=> 'img/to-pic/header-4.jpg',
					'side'    	=> 'img/to-pic/header-7.jpg',						
				),	
			));
				$page_options->add_field( array(			
					'id'        	=> 'ajax_search',
					'name'      	=> esc_html__('Ajax Search', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Enable/Disable Ajax Search ( You will need to install Ajax Search Lite plugin ). Select "Default" to use settings in Theme Options > Header.', 'vidorev-extensions'),
					'type'      	=> 'select',			
					'column'  		=> false,
					'default'		=> '',	
					'options'       => array(
						''    		=> esc_html__('Default', 'vidorev-extensions'),
						'on'    	=> esc_html__('ON', 'vidorev-extensions'),
						'off'    	=> esc_html__('OFF', 'vidorev-extensions'),							
					),
					'attributes' => array(
						'data-conditional-id'    => 'main_nav_layout',
						'data-conditional-value' => 'side',
					),	
				));
			
			$group_background_header = $page_options->add_field(array(
				'id'          => 'header_background',
				'type'        => 'group',			
				'options'     => array(
					'group_title'   => esc_html__( 'Header Background', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
					'closed'		=> true,
				),
				'repeatable'  => false,
			));
				$page_options->add_group_field($group_background_header, array(
					'id'   			=> 'background-color',
					'name' 			=> esc_html__( 'Background Color', 'vidorev-extensions'),
					'type' 			=> 'colorpicker',
					'options' 		=> array(
						'alpha' => true,
					),
					'repeatable' 	=> false,
				));
				$page_options->add_group_field($group_background_header, array(			
					'id'        	=> 'background-image',
					'name'      	=> esc_html__('Background Image', 'vidorev-extensions'),
					'type'      	=> 'file',
					'query_args' 	=> array(
						'type' => array(
							'image/gif',
							'image/jpeg',
							'image/png',
						),
					),
					'repeatable' 	=> false,		
				));	
				$page_options->add_group_field($group_background_header, array(
					'id'   				=> 'background-repeat',
					'name' 				=> esc_html__( 'Background Repeat', 'vidorev-extensions'),			
					'type' 				=> 'select',	
					'show_option_none' 	=> true,	
					'options' 			=> array(
						'no-repeat'		=> esc_html__( 'No Repeat', 'vidorev-extensions'),
						'repeat'		=> esc_html__( 'Repeat All', 'vidorev-extensions'),
						'repeat-x'		=> esc_html__( 'Repeat Horizontally', 'vidorev-extensions'),
						'repeat-y'		=> esc_html__( 'Repeat Vertically', 'vidorev-extensions'),
						'inherit'		=> esc_html__( 'Inherit', 'vidorev-extensions'),					
					),
					'repeatable' 		=> false,
				));				
				$page_options->add_group_field($group_background_header, array(
					'id'   				=> 'background-attachment',
					'name' 				=> esc_html__( 'Background Attachment', 'vidorev-extensions'),			
					'type' 				=> 'select',	
					'show_option_none' 	=> true,
					'options' 			=> array(
						'scroll'		=> esc_html__( 'Scroll', 'vidorev-extensions'),
						'fixed'			=> esc_html__( 'Fixed', 'vidorev-extensions'),
						'inherit'		=> esc_html__( 'Inherit', 'vidorev-extensions'),				
					),
					'repeatable' 		=> false,
				));				
				$page_options->add_group_field($group_background_header, array(
					'id'   				=> 'background-position',
					'name' 				=> esc_html__( 'Background Position', 'vidorev-extensions'),			
					'type' 				=> 'select',
					'show_option_none' 	=> true,
					'options' 			=> array(
						'center center'		=> esc_html__( 'Center Center', 'vidorev-extensions'),
						'left top'			=> esc_html__( 'Left Top', 'vidorev-extensions'),
						'left center'		=> esc_html__( 'Left Center', 'vidorev-extensions'),
						'left bottom'		=> esc_html__( 'Left Bottom', 'vidorev-extensions'),
						'center top'		=> esc_html__( 'Center Top', 'vidorev-extensions'),
						'center bottom'		=> esc_html__( 'Center Bottom', 'vidorev-extensions'),
						'right top'			=> esc_html__( 'Right Top', 'vidorev-extensions'),
						'right center'		=> esc_html__( 'Right Center', 'vidorev-extensions'),
						'right bottom'		=> esc_html__( 'Right Bottom', 'vidorev-extensions'),				
					),
					'repeatable' 		=> false,
				));
				$page_options->add_group_field($group_background_header, array(			
					'id'        	=> 'background-size',
					'name'      	=> esc_html__('Background Size', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'repeatable' 	=> false,
					'attributes'  => array(
						'placeholder' => esc_attr__( 'cover', 'vidorev-extensions'),
					),	
				));
				
			$page_options->add_field( array(			
				'id'        	=> 'theme_sidebar',
				'name'      	=> esc_html__('Sidebar', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select "Default" to use settings in Theme Options > Single Page Settings.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'right'    	=> esc_html__('Right', 'vidorev-extensions'),
					'left'  	=> esc_html__('Left', 'vidorev-extensions'),
					'hidden'  	=> esc_html__('Hidden', 'vidorev-extensions'),					
				),	
			));
			
			$page_options->add_field( array(			
				'id'        	=> 'instagram_feed',
				'name'      	=> esc_html__('Instagram Feed', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Enable/Disable Instagram Feed. Select "Default" to use settings in Theme Options > Footer.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'on'    	=> esc_html__('ON', 'vidorev-extensions'),
					'off'    	=> esc_html__('OFF', 'vidorev-extensions'),							
				),	
			));
				$page_options->add_field( array(			
					'id'        	=> 'instagram_feed_position',
					'name'      	=> esc_html__('Instagram Feed Display Position', 'vidorev-extensions'),
					'type'      	=> 'select',			
					'column'  		=> false,
					'options'       => array(
						'header'    => esc_html__('HEADER', 'vidorev-extensions'),
						'footer'    => esc_html__('FOOTER', 'vidorev-extensions'),					
					),
					'attributes' => array(
						'data-conditional-id'    => 'instagram_feed',
						'data-conditional-value' => 'on',
					),	
				));
				
			$page_options->add_field( array(			
				'id'        	=> 'popular_videos',
				'name'      	=> esc_html__('Popular Videos', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Enable/Disable Popular Videos. Select "Default" to use settings in Theme Options > Footer', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'on'    	=> esc_html__('ON', 'vidorev-extensions'),
					'off'    	=> esc_html__('OFF', 'vidorev-extensions'),							
				),	
			));
				$page_options->add_field( array(			
					'id'        	=> 'popular_videos_title_1',
					'name'      	=> esc_html__('[Popular Videos] Title 1', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Enter Title for Popular Videos section', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'column'  		=> false,
					'attributes' => array(
						'data-conditional-id'    => 'popular_videos',
						'data-conditional-value' => 'on',
					),		
				));
				$page_options->add_field( array(			
					'id'        	=> 'popular_videos_title_2',
					'name'      	=> esc_html__('[Popular Videos] Title 2', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Enter Title for Popular Videos section', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'column'  		=> false,
					'attributes' => array(
						'data-conditional-id'    => 'popular_videos',
						'data-conditional-value' => 'on',
					),		
				));
				$page_options->add_field( array(			
					'id'        	=> 'popular_videos_ic',
					'name'      	=> esc_html__('[Popular Videos] Include Categories', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Include categories, enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'column'  		=> false,
					'attributes' => array(
						'data-conditional-id'    => 'popular_videos',
						'data-conditional-value' => 'on',
					),		
				));
				$page_options->add_field( array(			
					'id'        	=> 'popular_videos_it',
					'name'      	=> esc_html__('[Popular Videos] Include Tags', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Include tags, enter tag id or slug, eg: 19, 368, ...', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'column'  		=> false,
					'attributes' => array(
						'data-conditional-id'    => 'popular_videos',
						'data-conditional-value' => 'on',
					),		
				));
				
			$group_background_theme = $page_options->add_field(array(
				'id'          => 'theme_background',
				'type'        => 'group',			
				'options'     => array(
					'group_title'   => esc_html__('Background', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Leave blank to use settings in Theme Options > Styling.', 'vidorev-extensions'),
					'closed'		=> true,
				),
				'repeatable'  => false,
			));
				$page_options->add_group_field($group_background_theme, array(
					'id'   			=> 'background-color',
					'name' 			=> esc_html__( 'Background Color', 'vidorev-extensions'),
					'type' 			=> 'colorpicker',
					'options' 		=> array(
						'alpha' => true,
					),
					'repeatable' 	=> false,
				));
				$page_options->add_group_field($group_background_theme, array(			
					'id'        	=> 'background-image',
					'name'      	=> esc_html__('Background Image', 'vidorev-extensions'),
					'type'      	=> 'file',
					'query_args' 	=> array(
						'type' => array(
							'image/gif',
							'image/jpeg',
							'image/png',
						),
					),
					'repeatable' 	=> false,		
				));	
				$page_options->add_group_field($group_background_theme, array(
					'id'   				=> 'background-repeat',
					'name' 				=> esc_html__( 'Background Repeat', 'vidorev-extensions'),			
					'type' 				=> 'select',	
					'show_option_none' 	=> true,	
					'options' 			=> array(
						'no-repeat'		=> esc_html__( 'No Repeat', 'vidorev-extensions'),
						'repeat'		=> esc_html__( 'Repeat All', 'vidorev-extensions'),
						'repeat-x'		=> esc_html__( 'Repeat Horizontally', 'vidorev-extensions'),
						'repeat-y'		=> esc_html__( 'Repeat Vertically', 'vidorev-extensions'),
						'inherit'		=> esc_html__( 'Inherit', 'vidorev-extensions'),					
					),
					'repeatable' 		=> false,
				));				
				$page_options->add_group_field($group_background_theme, array(
					'id'   				=> 'background-attachment',
					'name' 				=> esc_html__( 'Background Attachment', 'vidorev-extensions'),			
					'type' 				=> 'select',	
					'show_option_none' 	=> true,
					'options' 			=> array(
						'scroll'		=> esc_html__( 'Scroll', 'vidorev-extensions'),
						'fixed'			=> esc_html__( 'Fixed', 'vidorev-extensions'),
						'inherit'		=> esc_html__( 'Inherit', 'vidorev-extensions'),				
					),
					'repeatable' 		=> false,
				));				
				$page_options->add_group_field($group_background_theme, array(
					'id'   				=> 'background-position',
					'name' 				=> esc_html__( 'Background Position', 'vidorev-extensions'),			
					'type' 				=> 'select',
					'show_option_none' 	=> true,
					'options' 			=> array(
						'center center'		=> esc_html__( 'Center Center', 'vidorev-extensions'),
						'left top'			=> esc_html__( 'Left Top', 'vidorev-extensions'),
						'left center'		=> esc_html__( 'Left Center', 'vidorev-extensions'),
						'left bottom'		=> esc_html__( 'Left Bottom', 'vidorev-extensions'),
						'center top'		=> esc_html__( 'Center Top', 'vidorev-extensions'),
						'center bottom'		=> esc_html__( 'Center Bottom', 'vidorev-extensions'),
						'right top'			=> esc_html__( 'Right Top', 'vidorev-extensions'),
						'right center'		=> esc_html__( 'Right Center', 'vidorev-extensions'),
						'right bottom'		=> esc_html__( 'Right Bottom', 'vidorev-extensions'),				
					),
					'repeatable' 		=> false,
				));
				$page_options->add_group_field($group_background_theme, array(			
					'id'        	=> 'background-size',
					'name'      	=> esc_html__('Background Size', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'repeatable' 	=> false,
					'attributes'  => array(
						'placeholder' => esc_attr__( 'cover', 'vidorev-extensions'),
					),	
				));
			
			$page_options->add_field( array(			
				'id'        	=> 'page_custom_css',
				'name'      	=> esc_html__('Custom CSS', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Enter custom CSS code for this page.', 'vidorev-extensions'),
				'type'      	=> 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),			
				'column'  		=> false,
			));	
		/*$page_options*/
	}
endif;
add_action( 'cmb2_init', 'vidorev_cmb_page_options' );

if ( ! function_exists( 'beeteam368_get_field_page_template' ) ) :
	function beeteam368_get_field_page_template($field_args, $field){
		
		$id          = $field->args( 'id' );
		$label       = $field->args( 'name' );
		$name        = $field->args( '_name' );
		$value       = $field->escaped_value();
		$description = $field->args( 'description' );
		$post_id	 = is_numeric($field->object_id)?$field->object_id:'';
	?>
		<div class="custom-column-display get_field_post_format">			
			<input type="hidden" value="<?php echo esc_attr(get_page_template_slug($post_id));?>" name="beeteam368_check_page_template">
		</div>
	<?php	
	}
endif;