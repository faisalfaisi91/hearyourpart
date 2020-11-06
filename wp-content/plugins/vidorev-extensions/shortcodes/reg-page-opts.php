<?php
if ( ! function_exists( 'vidorev_page_slider_settings' ) ){
	function vidorev_page_slider_settings(){
		$cmb = new_cmb2_box( array(
			'id'            => 'page_slider_settings',
			'title'         => esc_html__( 'Header Slider Settings', 'vidorev-extensions'),
			'object_types'  => array( 'page' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field(array(
			'id'   			=> 'display_slider_group',
			'name' 			=> esc_html__( 'Display Slider', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),				
			),
		));
		
		$group = $cmb->add_field(array(
			'id'          => 'page_slider_group',
			'type'        => 'group',			
			'options'     => array(
				'group_title'   => esc_html__( 'Page Slider {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add More Slider', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Slider', 'vidorev-extensions'),
				'sortable'      => true,
				'closed'		=> true,
			),
			'repeatable'  => true,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'title',
			'name' 			=> esc_html__( 'Title', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'layout',
			'name' 			=> esc_html__( 'Layout', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'slider-1'		=> esc_html__( 'SLIDER 1', 'vidorev-extensions'),
				'slider-2'		=> esc_html__( 'SLIDER 2', 'vidorev-extensions'),
				'slider-3'		=> esc_html__( 'SLIDER 3', 'vidorev-extensions'),
				'slider-4'		=> esc_html__( 'SLIDER 4', 'vidorev-extensions'),
				'slider-5'		=> esc_html__( 'SLIDER 5', 'vidorev-extensions'),
				'slider-6'		=> esc_html__( 'SLIDER 6', 'vidorev-extensions'),
				'slider-7'		=> esc_html__( 'SLIDER 7', 'vidorev-extensions'),
				'slider-8'		=> esc_html__( 'SLIDER 8', 'vidorev-extensions'),
				'slider-9'		=> esc_html__( 'SLIDER 9', 'vidorev-extensions'),
				'slider-10'		=> esc_html__( 'SLIDER 10', 'vidorev-extensions'),
			),
			'repeatable' 		=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'post_type',
			'name' 			=> esc_html__( 'Post Type', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'post'					=> esc_html__( 'POST ( all posts )', 'vidorev-extensions'),
				'post-without-video'	=> esc_html__( 'POST ( without video posts )', 'vidorev-extensions'),
				'post-video'			=> esc_html__( 'POST VIDEO', 'vidorev-extensions'),
				'vid_playlist'			=> esc_html__( 'PLAYLIST', 'vidorev-extensions'),
				'vid_channel'			=> esc_html__( 'CHANNEL', 'vidorev-extensions'),
				'vid_series'			=> esc_html__( 'SERIES', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'category',
			'name' 			=> esc_html__( 'Include categories', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'tag',
			'name' 			=> esc_html__( 'Include tags', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Enter tag id or slug, eg: 19, 368, ...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'ex_category',
			'name' 			=> esc_html__( 'Exclude categories', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'ids',
			'name' 			=> esc_html__( 'Include Posts', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Enter post id, eg: 1136, 2251, ...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'order_by',
			'name' 			=> esc_html__( 'Order By', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'date'					=> esc_html__( 'Date', 'vidorev-extensions'),
				'ID'					=> esc_html__( 'Order by post ID', 'vidorev-extensions'),
				'author'				=> esc_html__( 'Author', 'vidorev-extensions'),
				'title'					=> esc_html__( 'Title', 'vidorev-extensions'),
				'modified'				=> esc_html__( 'Last modified date', 'vidorev-extensions'),
				'parent'				=> esc_html__( 'Post/page parent ID', 'vidorev-extensions'),
				'comment_count'			=> esc_html__( 'Number of comments', 'vidorev-extensions'),
				'menu_order'			=> esc_html__( 'Menu order/Page Order', 'vidorev-extensions'),
				'rand'					=> esc_html__( 'Random order', 'vidorev-extensions'),
				'post__in'				=> esc_html__( 'Preserve post ID order', 'vidorev-extensions'),
				'view'					=> esc_html__( 'Most viewed', 'vidorev-extensions'),
				'like'					=> esc_html__( 'Most liked', 'vidorev-extensions'),
				'mostsubscribed'		=> esc_html__( 'Most Subscribed (only for channels)', 'vidorev-extensions'),
				'highest_rated'			=> esc_html__( 'Highest Rated (only for video Posts)', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'order',
			'name' 			=> esc_html__( 'Sort Order', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'DESC'					=> esc_html__( 'Descending', 'vidorev-extensions'),
				'ASC'					=> esc_html__( 'Ascending', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'offset',
			'name' 			=> esc_html__( 'Offset', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Number of post to displace or pass over.', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'post_count',
			'name' 			=> esc_html__( 'Post Count', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Set max limit for items in slider or enter -1 to display all.', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'display_categories',
			'name' 			=> esc_html__( 'Display Post Categories', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'display_author',
			'name' 			=> esc_html__( 'Display Post Author', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'display_date',
			'name' 			=> esc_html__( 'Display Post Published Date', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'display_comment_count',
			'name' 			=> esc_html__( 'Display Post Comment Count', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'display_view_count',
			'name' 			=> esc_html__( 'Display Post View Count', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'display_like_count',
			'name' 			=> esc_html__( 'Display Post Like Count', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'display_dislike_count',
			'name' 			=> esc_html__( 'Display Post Dislike Count', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'autoplay',
			'name' 			=> esc_html__( 'Autoplay Speed', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Autoplay Speed in milliseconds. If blank, autoplay is off. eg: 5000, 6000...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'fade',
			'name' 			=> esc_html__( 'Fading Effect', 'vidorev-extensions'),			
			'type' 			=> 'select',		
			'options' 		=> array(
				'no'					=> esc_html__( 'No', 'vidorev-extensions'),
				'yes'					=> esc_html__( 'Yes', 'vidorev-extensions'),				
			),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'margin_top',
			'name' 			=> esc_html__( 'Margin Top', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Example: 30px, 40px, 3em...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'margin_bottom',
			'name' 			=> esc_html__( 'Margin Bottom', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Example: 30px, 40px, 3em...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'padding_top',
			'name' 			=> esc_html__( 'Padding Top', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Example: 30px, 40px, 3em...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'padding_bottom',
			'name' 			=> esc_html__( 'Padding Bottom', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Example: 30px, 40px, 3em...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'padding_left',
			'name' 			=> esc_html__( 'Padding Left', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Example: 30px, 40px, 3em...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'padding_right',
			'name' 			=> esc_html__( 'Padding Right', 'vidorev-extensions'),			
			'desc'			=> esc_html__( 'Example: 30px, 40px, 3em...', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'background_color',
			'name' 			=> esc_html__( 'Background Color', 'vidorev-extensions'),
			'type' 			=> 'colorpicker',
			'options' 		=> array(
				'alpha' => true,
			),
			'repeatable' 	=> false,
		));
		
	}	
}
add_action( 'cmb2_init', 'vidorev_page_slider_settings' );