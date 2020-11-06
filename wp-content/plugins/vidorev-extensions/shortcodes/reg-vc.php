<?php
if(!class_exists('vidorev_reg_vc_shortcodes')) {
	class vidorev_reg_vc_shortcodes{		

		public function reg_vc_shortcodes(){
			if(function_exists('vc_map')){																																		

				vc_map(
					array(
						'name' 				=> 	esc_html__('Slider', 'vidorev-extensions'),
						'base' 				=> 	'slider_sc',
						'category' 			=> 	esc_html__('VIDOREV SHORTCODES', 'vidorev-extensions'),
						'icon'				=> 	VPE_PLUGIN_URL.'assets/back-end/images/ul-layout-shortcode.png',
						'params'			=> 	array(
													
													array(
														'type' 			=> 'dropdown',
														'heading' 		=> esc_html__('Layout', 'vidorev-extensions'),
														'param_name' 	=> 'layout',
														'value' 		=> array(
																				esc_html__('STYLE 1', 'vidorev-extensions') => 'slider-1',
																				esc_html__('STYLE 2', 'vidorev-extensions') => 'slider-2',
																				esc_html__('STYLE 3', 'vidorev-extensions') => 'slider-3',
																				esc_html__('STYLE 4', 'vidorev-extensions') => 'slider-4',
																				esc_html__('STYLE 5', 'vidorev-extensions') => 'slider-5',
																				esc_html__('STYLE 6', 'vidorev-extensions') => 'slider-6',
																				esc_html__('STYLE 7', 'vidorev-extensions') => 'slider-7',
																				esc_html__('STYLE 8', 'vidorev-extensions') => 'slider-8',
																				esc_html__('STYLE 9', 'vidorev-extensions') => 'slider-9',
																				esc_html__('STYLE 10', 'vidorev-extensions') => 'slider-10',
																		   ),																	
													),
													
													array(
														'type' 			=> 'dropdown',
														'heading' 		=> esc_html__('Post Type', 'vidorev-extensions'),
														'param_name' 	=> 'post_type',
														'value' 		=> array(
																				esc_html__('POST ( all posts )', 'vidorev-extensions') => 'post',
																				esc_html__('POST ( without video posts )', 'vidorev-extensions') => 'post-without-video',
																				esc_html__('POST VIDEO', 'vidorev-extensions') => 'post-video',
																				esc_html__('PLAYLIST', 'vidorev-extensions') => 'vid_playlist',
																				esc_html__('CHANNEL', 'vidorev-extensions') => 'vid_channel',																			
																		   ),																	
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Include categories', 'vidorev-extensions'),
														'param_name' 		=> 'category',
														'description' 		=> esc_html__('Enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),																											
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Include tags', 'vidorev-extensions'),
														'param_name' 		=> 'tag',
														'description' 		=> esc_html__('Enter tag id or slug, eg: 19, 368, ...', 'vidorev-extensions'),																											
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Include Posts', 'vidorev-extensions'),
														'param_name' 		=> 'ids',
														'description' 		=> esc_html__('Enter post id, eg: 1136, 2251, ...', 'vidorev-extensions'),																											
													),
													
													array(
														'type' 				=> 'dropdown',
														'heading' 			=> esc_html__('Order By', 'vidorev-extensions'),			
														'param_name' 		=> 'order_by',
														'value' 			=> array(	
																				esc_html__('Date', 'vidorev-extensions') 					=> 'date',																		
																				esc_html__('Order by post ID', 'vidorev-extensions') 		=> 'ID',
																				esc_html__('Author', 'vidorev-extensions') 					=> 'author',
																				esc_html__('Title', 'vidorev-extensions') 					=> 'title',
																				esc_html__('Last modified date', 'vidorev-extensions') 		=> 'modified',
																				esc_html__('Post/page parent ID', 'vidorev-extensions') 	=> 'parent',
																				esc_html__('Number of comments', 'vidorev-extensions') 		=> 'comment_count',
																				esc_html__('Menu order/Page Order', 'vidorev-extensions') 	=> 'menu_order',
																				esc_html__('Random order', 'vidorev-extensions') 			=> 'rand',																				
																				esc_html__('Preserve post ID order', 'vidorev-extensions') 	=> 'post__in',
																				esc_html__('Most viewed', 'vidorev-extensions') 			=> 'view',																				
																				esc_html__('Most liked', 'vidorev-extensions') 				=> 'like',
																				esc_html__('Most Subscribed (only for channels)', 'vidorev-extensions') => 'mostsubscribed',
																				esc_html__('Highest Rated (only for video Posts)', 'vidorev-extensions') => 'highest_rated',																																																						
																			),
														'description' 		=> esc_html__('Select order type.', 'vidorev-extensions'),
													),	
													
													array(
														'type' 				=> 'dropdown',
														'heading' 			=> esc_html__('Sort Order', 'vidorev-extensions'),			
														'param_name' 		=> 'order',
														'value' 			=> array(	
																				esc_html__('Descending', 'vidorev-extensions') 			=> 'DESC',																		
																				esc_html__('Ascending', 'vidorev-extensions') 			=> 'ASC',																																																																											
																			),
														'description' 		=> esc_html__('Select sorting order.', 'vidorev-extensions'),
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Post Count', 'vidorev-extensions'),
														'param_name' 		=> 'post_count',
														'description' 		=> esc_html__('Set max limit for items in grid or enter -1 to display all.', 'vidorev-extensions'),																											
													),
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Categories', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_categories',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Author', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_author',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Published Date', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_date',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Comment Count', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_comment_count',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post View Count', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_view_count',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Like Count', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_like_count',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Dislike Count', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_dislike_count',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Autoplay Speed', 'vidorev-extensions'),
														'param_name' 		=> 'autoplay',
														'description' 		=> esc_html__('Autoplay Speed in milliseconds. If blank, autoplay is off. eg: 5000, 6000...', 'vidorev-extensions'),																											
													),
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Fading Effect', 'vidorev-extensions'),								
														'param_name' 	=> 	'fade',
														'value' 		=> 	array(																	
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																																																							
																			),
													),													
												),
					)
				);
				
				
				vc_map(
					array(
						'name' 				=> 	esc_html__('Block', 'vidorev-extensions'),
						'base' 				=> 	'block_sc',
						'category' 			=> 	esc_html__('VIDOREV SHORTCODES', 'vidorev-extensions'),
						'icon'				=> 	VPE_PLUGIN_URL.'assets/back-end/images/ul-layout-shortcode.png',
						'params'			=> 	array(
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Block Title', 'vidorev-extensions'),
														'param_name' 		=> 'block_title',
														'description' 		=> esc_html__('Enter section title (Note: you can leave it empty).', 'vidorev-extensions'),																											
													),
													
													array(
														'type' 			=> 'dropdown',
														'heading' 		=> esc_html__('Layout', 'vidorev-extensions'),
														'param_name' 	=> 'layout',
														'value' 		=> array(
																				esc_html__('Grid Default - 3 Columns', 'vidorev-extensions') 	=> 'grid-df-3-col',
																				esc_html__('Grid Default - 2 Columns', 'vidorev-extensions') 	=> 'grid-df-2-col',
																				esc_html__('Grid Default - 1 Column', 'vidorev-extensions') 		=> 'grid-df-1-col',
																				
																				esc_html__('List Default', 'vidorev-extensions') 				=> 'list-df',
																				esc_html__('List Special', 'vidorev-extensions') 				=> 'list-sp',
																				
																				esc_html__('Grid Special - 3 Columns', 'vidorev-extensions') 	=> 'grid-sp-3-col',
																				esc_html__('Grid Special - 2 Columns', 'vidorev-extensions') 	=> 'grid-sp-2-col',
																				esc_html__('Grid Special - 1 Column', 'vidorev-extensions') 		=> 'grid-sp-1-col',
																				
																				esc_html__('Grid Modern - 3 Columns', 'vidorev-extensions') 		=> 'grid-md-3-col',
																				esc_html__('Grid Modern - 2 Columns', 'vidorev-extensions') 		=> 'grid-md-2-col',
																				esc_html__('Grid Modern - 1 Column', 'vidorev-extensions') 		=> 'grid-md-1-col',
																				
																				esc_html__('Grid Poster - 6 Columns', 'vidorev-extensions') 		=> 'grid-mv-6-col',
																				esc_html__('Grid Poster - 4 Columns', 'vidorev-extensions') 		=> 'grid-mv-4-col',
																				
																				esc_html__('List Poster', 'vidorev-extensions') 					=> 'list-mv',
																				
																				esc_html__('Block Default - 3 Columns', 'vidorev-extensions') 	=> 'block-df-1',
																				esc_html__('Block Default - 2 Columns', 'vidorev-extensions') 	=> 'block-df-2',
																				esc_html__('Block Default - 1 Columns', 'vidorev-extensions') 	=> 'block-df-3',
																				
																				esc_html__('Block Classic - 3 Columns', 'vidorev-extensions') 	=> 'block-cl-1',
																				esc_html__('Block Classic - 2 Columns', 'vidorev-extensions') 	=> 'block-cl-2',
																				
																				esc_html__('Block Special - Large', 'vidorev-extensions') 		=> 'block-sp-1',
																				esc_html__('Block Special - Medium', 'vidorev-extensions') 		=> 'block-sp-2',
																				esc_html__('Block Special - Small', 'vidorev-extensions') 		=> 'block-sp-3',
																				
																				esc_html__('Grid Small 3 Columns', 'vidorev-extensions') 		=> 'grid-sm-3-col',
																				esc_html__('Grid Small 4 Columns', 'vidorev-extensions') 		=> 'grid-sm-4-col',
																				
																				/*new layout*/																
																		   ),																	
													),
													
													array(
														'type' 			=> 'dropdown',
														'heading' 		=> esc_html__('Post Type', 'vidorev-extensions'),
														'param_name' 	=> 'post_type',
														'value' 		=> array(
																				esc_html__('POST ( all posts )', 'vidorev-extensions') => 'post',
																				esc_html__('POST ( without video posts )', 'vidorev-extensions') => 'post-without-video',
																				esc_html__('POST VIDEO', 'vidorev-extensions') => 'post-video',
																				esc_html__('PLAYLIST', 'vidorev-extensions') => 'vid_playlist',	
																				esc_html__('CHANNEL', 'vidorev-extensions') => 'vid_channel',																			
																		   ),																	
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Filter Items', 'vidorev-extensions'),
														'param_name' 		=> 'filter_items',
														'description' 		=> esc_html__('Enter categories, tags (id or slug) be shown in the filter list.', 'vidorev-extensions'),																											
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Include categories', 'vidorev-extensions'),
														'param_name' 		=> 'category',
														'description' 		=> esc_html__('Enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),																											
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Include tags', 'vidorev-extensions'),
														'param_name' 		=> 'tag',
														'description' 		=> esc_html__('Enter tag id or slug, eg: 19, 368, ...', 'vidorev-extensions'),																											
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Include Posts', 'vidorev-extensions'),
														'param_name' 		=> 'ids',
														'description' 		=> esc_html__('Enter post id, eg: 1136, 2251, ...', 'vidorev-extensions'),																											
													),
													
													array(
														'type' 				=> 'dropdown',
														'heading' 			=> esc_html__('Order By', 'vidorev-extensions'),			
														'param_name' 		=> 'order_by',
														'value' 			=> array(	
																				esc_html__('Date', 'vidorev-extensions') 					=> 'date',																		
																				esc_html__('Order by post ID', 'vidorev-extensions') 		=> 'ID',
																				esc_html__('Author', 'vidorev-extensions') 					=> 'author',
																				esc_html__('Title', 'vidorev-extensions') 					=> 'title',
																				esc_html__('Last modified date', 'vidorev-extensions') 		=> 'modified',
																				esc_html__('Post/page parent ID', 'vidorev-extensions') 	=> 'parent',
																				esc_html__('Number of comments', 'vidorev-extensions') 		=> 'comment_count',
																				esc_html__('Menu order/Page Order', 'vidorev-extensions') 	=> 'menu_order',
																				esc_html__('Random order', 'vidorev-extensions') 			=> 'rand',																				
																				esc_html__('Preserve post ID order', 'vidorev-extensions') 	=> 'post__in',
																				esc_html__('Most viewed', 'vidorev-extensions') 			=> 'view',																				
																				esc_html__('Most liked', 'vidorev-extensions') 				=> 'like',
																				esc_html__('Most Subscribed (only for channels)', 'vidorev-extensions') => 'mostsubscribed',
																				esc_html__('Highest Rated (only for video Posts)', 'vidorev-extensions') => 'highest_rated',																																																							
																			),
														'description' 		=> esc_html__('Select order type.', 'vidorev-extensions'),
													),	
													
													array(
														'type' 				=> 'dropdown',
														'heading' 			=> esc_html__('Sort Order', 'vidorev-extensions'),			
														'param_name' 		=> 'order',
														'value' 			=> array(	
																				esc_html__('Descending', 'vidorev-extensions') 			=> 'DESC',																		
																				esc_html__('Ascending', 'vidorev-extensions') 			=> 'ASC',																																																																											
																			),
														'description' 		=> esc_html__('Select sorting order.', 'vidorev-extensions'),
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Items Per Page', 'vidorev-extensions'),
														'param_name' 		=> 'items_per_page',
														'description' 		=> esc_html__('Number of items to show per page.', 'vidorev-extensions'),																											
													),
													
													array(															
														'type' 				=> 'textfield',
														'heading' 			=> esc_html__('Post Count', 'vidorev-extensions'),
														'param_name' 		=> 'post_count',
														'description' 		=> esc_html__('Set max limit for items in grid or enter -1 to display all.', 'vidorev-extensions'),																											
													),
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Image Ratio', 'vidorev-extensions'),								
														'param_name' 	=> 	'image_ratio',
														'value' 		=> 	array(	
																				esc_html__('Default', 'vidorev-extensions') 			=> '',																		
																				esc_html__('Video - 16:9', 'vidorev-extensions') 	=> '16_9',
																				esc_html__('Blog - 4:3', 'vidorev-extensions') 		=> '4_3',
																				esc_html__('Movie - 2:3', 'vidorev-extensions') 		=> '2_3',																																																							
																			),
													),
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Categories', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_categories',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Excerpt', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_excerpt',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Author', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_author',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Published Date', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_date',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Comment Count', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_comment_count',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post View Count', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_view_count',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Like Count', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_like_count',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),	
													
													array(
														'type' 			=> 	'dropdown',
														'heading' 		=> 	esc_html__('Display Post Dislike Count', 'vidorev-extensions'),								
														'param_name' 	=> 	'display_dislike_count',
														'value' 		=> 	array(	
																				esc_html__('Yes', 'vidorev-extensions') 		=> 'yes',																		
																				esc_html__('No', 'vidorev-extensions') 		=> 'no',																																																							
																			),
													),				
												),
					)
				);				

			}
		}

		
		public function init(){
			$this->reg_vc_shortcodes();
		}
		
		public function __construct() {				
			add_action('init', array($this, 'init'), 9998, 1);
		}
	}
	
	global $vidorev_reg_vc_shortcodes;
	if(!$vidorev_reg_vc_shortcodes){
		$vidorev_reg_vc_shortcodes = new vidorev_reg_vc_shortcodes();
	}
	
	if(!function_exists('vidorev_vc_extends')){
		function vidorev_vc_extends(){
			if(class_exists('WPBakeryShortCode') && class_exists('WPBakeryShortCodesContainer') && class_exists('WPBakeryShortCode')){
				class WPBakeryShortCode_slider_sc extends WPBakeryShortCode{}
			}
		}	
		add_action('init', 'vidorev_vc_extends', 9999, 1);
	}	
}