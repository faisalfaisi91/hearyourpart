<?php
if ( ! function_exists( 'vidorev_category_metaboxes' ) ) :
	function vidorev_category_metaboxes() {
		$prefix = CATEGORY_PM_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'custom_layout_for_category',
			'title'         => esc_html__( 'Custom Layout for Category', 'vidorev-extensions'),
			'object_types'  => array( 'term' ),
			'taxonomies'    => array( 'category' ),
		));
		
		$cmb->add_field( array(
				'name'             		=> esc_html__( 'Category Layout', 'vidorev-extensions'),
				'desc'             		=> esc_html__( 'Change Category Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
				'id'               		=> $prefix . 'category_layout',
				'type'             		=> 'select',
				'default'				=> '',
				'show_option_none'	 	=> false,
				'options'         		=> array(
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
				),
		));
		
		$cmb->add_field( array(
				'name'             		=> esc_html__( 'Image Ratio', 'vidorev-extensions'),
				'desc'             		=> esc_html__( 'Change Image Ratio. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
				'id'               		=> $prefix . 'image_ratio',
				'type'             		=> 'select',
				'default'				=> '',
				'show_option_none'	 	=> false,
				'options'         		=> array(
					''		=> esc_html__('Default', 'vidorev-extensions'),
					'16_9' 	=> esc_html__('Video - 16:9', 'vidorev-extensions'),
					'4_3'  	=> esc_html__('Blog - 4:3', 'vidorev-extensions'),
					'2_3'  	=> esc_html__('Movie - 2:3', 'vidorev-extensions'),					
				),
		));
		
		$cmb->add_field( array(
				'name'             		=> esc_html__( 'Sidebar', 'vidorev-extensions'),
				'desc'             		=> esc_html__( 'Change Category Sidebar. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
				'id'               		=> $prefix . 'cate_sidebar',
				'type'             		=> 'select',
				'default'				=> '',
				'show_option_none'	 	=> false,
				'options'         		=> array(
					''				=> esc_html__('Default', 'vidorev-extensions'),
					'right'			=> esc_html__('Right', 'vidorev-extensions'),
					'left' 			=> esc_html__('Left', 'vidorev-extensions'),
					'hidden'  		=> esc_html__('Hidden', 'vidorev-extensions'),				
				),
		));
		
		$cmb->add_field( array(
			'name' => esc_html__( 'Category Text Color', 'vidorev-extensions'),			
			'id'   => $prefix . 'text_color',
			'type' => 'colorpicker',
			'options' => array(
				'alpha' => true, 
			),
		));
		
		$cmb->add_field( array(
			'name' => esc_html__( 'Category Background Color', 'vidorev-extensions'),			
			'id'   => $prefix . 'background_color',
			'type' => 'colorpicker',
			'options' => array(
				'alpha' => true, 
			),
		));
		
		$cmb->add_field( array(
			'name' => esc_html__( 'Category Image', 'vidorev-extensions'),			
			'id'   => $prefix . 'image',
			'type' => 'file',
		));
	}
endif;
add_action( 'cmb2_admin_init', 'vidorev_category_metaboxes' );