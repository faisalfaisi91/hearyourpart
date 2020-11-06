<?php
namespace Elementor;

if(!class_exists('vidorev_Block_Widget')){
	
	class vidorev_Block_Widget extends Widget_Base {
	
		public function get_name() {
			return 'vidorev_block_addon';
		}
	
		public function get_title() {
			return esc_html__( 'Block', 'vidorev-extensions');
		}
	
		public function get_icon() {
			return 'fa fa-newspaper-o';
		}
		
		public function get_categories() {
			return [ 'vidorev-addon-elements' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'vidorev_block_addon_global_settings',
				[
					'label' 		=> esc_html__( 'Block', 'vidorev-extensions')
				]
			);
			
			$this->add_control(
				'block_title',
				[
					'label'			=> esc_html__( 'Block Title', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Enter section title (Note: you can leave it empty).', 'vidorev-extensions'),		
				]
			);
			
			$this->add_control(
				'layout',
				[
					'label'			=> esc_html__( 'Layout', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> 'grid-df-3-col',
					'options'		=> apply_filters('beeteam368_elementor_block_style_layouts', [
						'grid-df-fw-col' 	=> esc_html__('Grid Default - Full Width', 'vidorev-extensions'),
						'grid-df-3-col' 	=> esc_html__('Grid Default - 3 Columns', 'vidorev-extensions'),
						'grid-df-2-col' 	=> esc_html__('Grid Default - 2 Columns', 'vidorev-extensions'),
						'grid-df-1-col' 	=> esc_html__('Grid Default - 1 Column', 'vidorev-extensions'),
						
						'list-df' 			=> esc_html__('List Default', 'vidorev-extensions'),
						'list-sp' 			=> esc_html__('List Special', 'vidorev-extensions'),
						
						'grid-sp-fw-col' 	=> esc_html__('Grid Special - Full Width', 'vidorev-extensions'),
						'grid-sp-3-col' 	=> esc_html__('Grid Special - 3 Columns', 'vidorev-extensions'),
						'grid-sp-2-col' 	=> esc_html__('Grid Special - 2 Columns', 'vidorev-extensions'),
						'grid-sp-1-col' 	=> esc_html__('Grid Special - 1 Column', 'vidorev-extensions'),
						
						'grid-md-fw-col' 	=> esc_html__('Grid Modern - Full Width', 'vidorev-extensions'),
						'grid-md-3-col' 	=> esc_html__('Grid Modern - 3 Columns', 'vidorev-extensions'),
						'grid-md-2-col' 	=> esc_html__('Grid Modern - 2 Columns', 'vidorev-extensions'),
						'grid-md-1-col' 	=> esc_html__('Grid Modern - 1 Column', 'vidorev-extensions'),
						
						'grid-mv-fw-col' 	=> esc_html__('Grid Poster - Full Width', 'vidorev-extensions'),
						'grid-mv-6-col' 	=> esc_html__('Grid Poster - 6 Columns', 'vidorev-extensions'),
						'grid-mv-4-col' 	=> esc_html__('Grid Poster - 4 Columns', 'vidorev-extensions'),
						
						'list-mv' 			=> esc_html__('List Poster', 'vidorev-extensions'),
						
						'block-df-1' 		=> esc_html__('Block Default - 3 Columns', 'vidorev-extensions'),
						'block-df-2' 		=> esc_html__('Block Default - 2 Columns', 'vidorev-extensions'),
						'block-df-3' 		=> esc_html__('Block Default - 1 Columns', 'vidorev-extensions'),
						
						'block-cl-1' 		=> esc_html__('Block Classic - 3 Columns', 'vidorev-extensions'),
						'block-cl-2' 		=> esc_html__('Block Classic - 2 Columns', 'vidorev-extensions'),
						
						'block-sp-1' 		=> esc_html__('Block Special - Large', 'vidorev-extensions'),
						'block-sp-2' 		=> esc_html__('Block Special - Medium', 'vidorev-extensions'),
						'block-sp-3' 		=> esc_html__('Block Special - Small', 'vidorev-extensions'),
						
						'grid-sm-fw-col' 	=> esc_html__('Grid Small - Full Width', 'vidorev-extensions'),
						'grid-sm-4-col' 	=> esc_html__('Grid Small - 4 Columns', 'vidorev-extensions'),
						'grid-sm-3-col' 	=> esc_html__('Grid Small - 3 Columns', 'vidorev-extensions'),						
						
						/*new layout*/
					]),
				]
			);
			
			$this->add_control(
				'post_type',
				[
					'label'			=> esc_html__( 'Post Type', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> 'post',
					'options'		=> [
						'post' 					=> esc_html__('POST ( all posts )', 'vidorev-extensions'),
						'post-without-video' 	=> esc_html__('POST ( without video posts )', 'vidorev-extensions'),
						'post-video' 			=> esc_html__('POST VIDEO', 'vidorev-extensions'),
						'vid_playlist' 			=> esc_html__('PLAYLIST', 'vidorev-extensions'),
						'vid_channel' 			=> esc_html__('CHANNEL', 'vidorev-extensions'),
						'vid_series' 			=> esc_html__('SERIES', 'vidorev-extensions'),					
					]
				]
			);
			
			$this->add_control(
				'filter_items',
				[
					'label'			=> esc_html__( 'Filter Items', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Enter categories, tags (id or slug) be shown in the filter list.', 'vidorev-extensions'),		
				]
			);
			
			$this->add_control(
				'category',
				[
					'label'			=> esc_html__( 'Include categories', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),		
				]
			);
			
			$this->add_control(
				'tag',
				[
					'label'			=> esc_html__( 'Include tags', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Enter tag id or slug, eg: 19, 368, ...', 'vidorev-extensions'),		
				]
			);
			
			$this->add_control(
				'ex_category',
				[
					'label'			=> esc_html__( 'Exclude categories', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),		
				]
			);
			
			$this->add_control(
				'ids',
				[
					'label'			=> esc_html__( 'Include Posts', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Enter post id, eg: 1136, 2251, ...', 'vidorev-extensions'),		
				]
			);	
			
			$this->add_control(
				'order_by',
				[
					'label'			=> esc_html__( 'Order By', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'description' 	=> esc_html__('Select order type.', 'vidorev-extensions'),
					'default'		=> 'date',
					'options'		=> [
						'date' 			=> esc_html__('Date', 'vidorev-extensions'),																		
						'ID' 			=> esc_html__('Order by post ID', 'vidorev-extensions'),
						'author' 		=> esc_html__('Author', 'vidorev-extensions'),
						'title' 		=> esc_html__('Title', 'vidorev-extensions'),
						'modified' 		=> esc_html__('Last modified date', 'vidorev-extensions'),
						'parent' 		=> esc_html__('Post/page parent ID', 'vidorev-extensions'),
						'comment_count' => esc_html__('Number of comments', 'vidorev-extensions'),
						'menu_order' 	=> esc_html__('Menu order/Page Order', 'vidorev-extensions'),
						'rand' 			=> esc_html__('Random order', 'vidorev-extensions'),																				
						'post__in' 		=> esc_html__('Preserve post ID order', 'vidorev-extensions'),
						'view' 			=> esc_html__('Most viewed', 'vidorev-extensions'),																				
						'like'			=> esc_html__('Most liked', 'vidorev-extensions'),
						'popular'		=> esc_html__('Popular (Total Views Count + Like Count)', 'vidorev-extensions'),
						'mostsubscribed'=> esc_html__('Most Subscribed (only for channels)', 'vidorev-extensions'),
						'highest_rated'	=> esc_html__('Highest Rated (only for video Posts)', 'vidorev-extensions'),					
					]
				]
			);	
			
			$this->add_control(
				'order',
				[
					'label'			=> esc_html__( 'Sort Order', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'description' 	=> esc_html__('Select sorting order.', 'vidorev-extensions'),
					'default'		=> 'DESC',
					'options'		=> [
						'DESC' 			=> esc_html__('Descending', 'vidorev-extensions'),																		
						'ASC' 			=> esc_html__('Ascending', 'vidorev-extensions'),									
					]
				]
			);
			
			$this->add_control(
				'offset',
				[
					'label'			=> esc_html__('Offset', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Number of post to displace or pass over. Warning: Setting the offset parameter overrides/ignores the paged parameter and breaks pagination. Therefore, the Pagination button will be hidden when you use this parameter.', 'vidorev-extensions'),	
				]
			);
			
			$this->add_control(
				'items_per_page',
				[
					'label'			=> esc_html__('Items Per Page', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Number of items to show per page.', 'vidorev-extensions'),	
				]
			);		
			
			$this->add_control(
				'post_count',
				[
					'label'			=> esc_html__('Post Count', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Set max limit for items in grid or enter -1 to display all.', 'vidorev-extensions'),	
				]
			);	
			
			$this->add_control(
				'image_ratio',
				[
					'label'			=> esc_html__('Image Ratio', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> [
						 '' 		=> esc_html__('Default', 'vidorev-extensions'),																		
						 '16_9' 	=> esc_html__('Video - 16:9', 'vidorev-extensions'),
						 '4_3' 		=> esc_html__('Blog - 4:3', 'vidorev-extensions'),
						 '2_3' 		=> esc_html__('Movie - 2:3', 'vidorev-extensions'),								
					]
				]
			);
			
			$this->add_control(
				'display_categories',
				[
					'label'			=> esc_html__('Display Post Categories', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',					
				]
			);
			
			$this->add_control(
				'display_excerpt',
				[
					'label'			=> esc_html__('Display Excerpt', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',
				]
			);
			
			$this->add_control(
				'display_author',
				[
					'label'			=> esc_html__('Display Post Author', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',
				]
			);
			
			$this->add_control(
				'display_date',
				[
					'label'			=> esc_html__('Display Post Published Date', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',
				]
			);
			
			$this->add_control(
				'display_comment_count',
				[
					'label'			=> esc_html__('Display Post Comment Count', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',
				]
			);
			
			$this->add_control(
				'display_view_count',
				[
					'label'			=> esc_html__('Display Post View Count', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',
				]
			);
			
			$this->add_control(
				'display_like_count',
				[
					'label'			=> esc_html__('Display Post Like Count', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',
				]
			);
			
			$this->add_control(
				'display_dislike_count',
				[
					'label'			=> esc_html__('Display Post Dislike Count', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',
				]
			);
			
			$this->add_control(
				'link_to',
				[
					'label'			=> esc_html__( 'Link To', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> 'default',
					'options'		=> [
						'default' 		=> esc_html__('Default', 'vidorev-extensions'),
						'playlist' 		=> esc_html__('Playlist', 'vidorev-extensions'),
						'series' 		=> esc_html__('Series', 'vidorev-extensions'),							
					]
				]
			);
			
		}
		
		protected function render() {
			$params = $this->get_settings();
			
			$block_title 		= (isset($params['block_title'])&&trim($params['block_title'])!='')?trim($params['block_title']):'';
			$layout 			= (isset($params['layout'])&&trim($params['layout'])!='')?trim($params['layout']):'grid-df-3-col';
			$post_type 			= (isset($params['post_type'])&&trim($params['post_type'])!='')?trim($params['post_type']):'post';
			$filter_items		= (isset($params['filter_items'])&&trim($params['filter_items'])!='')?trim($params['filter_items']):'';
			$category 			= (isset($params['category'])&&trim($params['category'])!='')?trim($params['category']):'';
			$tag 				= (isset($params['tag'])&&trim($params['tag'])!='')?trim($params['tag']):'';
			$ex_category 		= (isset($params['ex_category'])&&trim($params['ex_category'])!='')?trim($params['ex_category']):'';
			$ids 				= (isset($params['ids'])&&trim($params['ids'])!='')?trim($params['ids']):'';
			$ex_ids 			= (isset($params['ex_ids'])&&trim($params['ex_ids'])!='')?trim($params['ex_ids']):'';
			$order_by 			= (isset($params['order_by'])&&trim($params['order_by'])!='')?trim($params['order_by']):'date';
			$order 				= (isset($params['order'])&&trim($params['order'])!='')?trim($params['order']):'DESC';
			
			$default_items_per_page = 6;
			$default_post_count		= 12;
			$sub_class				= '';
			
			switch($layout){
				case 'grid-df-fw-col':
					$default_items_per_page = 8;
					$default_post_count		= 16;
					$sub_class				= 'grid-default';								
					break;
				
				case 'grid-df-3-col':
					$default_items_per_page = 6;
					$default_post_count		= 12;
					$sub_class				= 'grid-default';								
					break;
					
				case 'grid-df-2-col':
					$default_items_per_page = 4;
					$default_post_count		= 8;
					$sub_class				= 'grid-default';								
					break;
					
				case 'grid-df-1-col':
					$default_items_per_page = 2;
					$default_post_count		= 4;
					$sub_class				= 'grid-default';								
					break;
					
				case 'list-df':
					$default_items_per_page = 3;
					$default_post_count		= 6;
					$sub_class				= 'list-default';								
					break;
					
				case 'list-sp':
					$default_items_per_page = 3;
					$default_post_count		= 6;
					$sub_class				= 'list-special';								
					break;		
				
				case 'grid-sp-fw-col':
					$default_items_per_page = 8;
					$default_post_count		= 16;
					$sub_class				= 'grid-special';								
					break;
					
				case 'grid-sp-3-col':
					$default_items_per_page = 6;
					$default_post_count		= 12;
					$sub_class				= 'grid-special';								
					break;
					
				case 'grid-sp-2-col':
					$default_items_per_page = 4;
					$default_post_count		= 8;
					$sub_class				= 'grid-special';								
					break;
					
				case 'grid-sp-1-col':
					$default_items_per_page = 2;
					$default_post_count		= 4;
					$sub_class				= 'grid-special';								
					break;	
				
				case 'grid-md-fw-col':
					$default_items_per_page = 8;
					$default_post_count		= 16;
					$sub_class				= 'grid-modern';								
					break;
					
				case 'grid-md-3-col':
					$default_items_per_page = 6;
					$default_post_count		= 12;
					$sub_class				= 'grid-modern';								
					break;
					
				case 'grid-md-2-col':
					$default_items_per_page = 4;
					$default_post_count		= 8;
					$sub_class				= 'grid-modern';								
					break;
					
				case 'grid-md-1-col':
					$default_items_per_page = 2;
					$default_post_count		= 4;
					$sub_class				= 'grid-modern';								
					break;		
				
				case 'grid-mv-fw-col':
					$default_items_per_page = 16;
					$default_post_count		= 32;
					$sub_class				= 'movie-grid';								
					break;
					
				case 'grid-mv-6-col':
					$default_items_per_page = 6;
					$default_post_count		= 12;
					$sub_class				= 'movie-grid';								
					break;
					
				case 'grid-mv-4-col':
					$default_items_per_page = 4;
					$default_post_count		= 8;
					$sub_class				= 'movie-grid';								
					break;
					
				case 'list-mv':
					$default_items_per_page = 3;
					$default_post_count		= 6;
					$sub_class				= 'movie-list';								
					break;
					
				case 'block-df-1':
					$default_items_per_page = 9;
					$default_post_count		= 18;	
					$sub_class				= 'grid-default';						
					break;	
					
				case 'block-df-2':
					$default_items_per_page = 6;
					$default_post_count		= 12;
					$sub_class				= 'grid-default';							
					break;
					
				case 'block-df-3':
					$default_items_per_page = 3;
					$default_post_count		= 6;
					$sub_class				= 'grid-default';							
					break;		
					
				case 'block-cl-1':
					$default_items_per_page = 9;
					$default_post_count		= 18;
					$sub_class				= 'grid-default';							
					break;	
					
				case 'block-cl-2':
					$default_items_per_page = 5;
					$default_post_count		= 10;	
					$sub_class				= 'grid-default';						
					break;		
					
				case 'block-sp-1':
					$default_items_per_page = 7;
					$default_post_count		= 14;							
					break;	
					
				case 'block-sp-2':
					$default_items_per_page = 5;
					$default_post_count		= 10;							
					break;
					
				case 'block-sp-3':
					$default_items_per_page = 3;
					$default_post_count		= 6;							
					break;
				
				case 'grid-sm-fw-col':
					$default_items_per_page = 12;
					$default_post_count		= 24;
					$sub_class				= 'grid-small';								
					break;	
				
				case 'grid-sm-4-col':
					$default_items_per_page = 4;
					$default_post_count		= 8;
					$sub_class				= 'grid-small';								
					break;	
					
				case 'grid-sm-3-col':
					$default_items_per_page = 3;
					$default_post_count		= 6;
					$sub_class				= 'grid-small';							
					break;
					
				/*new layout*/				
										
			}
			
			$default_items_per_page = apply_filters('beeteam368_elementor_block_items_per_page', $default_items_per_page, $layout);
			$default_post_count		= apply_filters('beeteam368_elementor_block_post_count', $default_post_count, $layout);
			$sub_class				= apply_filters('beeteam368_elementor_block_sub_class', $sub_class, $layout);
			
			$offset 			= (isset($params['offset'])&&trim($params['offset'])!=''&&is_numeric(trim($params['offset'])))?trim($params['offset']):0;	
			$items_per_page		= (isset($params['items_per_page'])&&trim($params['items_per_page'])!=''&&is_numeric(trim($params['items_per_page'])))?trim($params['items_per_page']):$default_items_per_page;		
			$post_count 		= (isset($params['post_count'])&&trim($params['post_count'])!=''&&is_numeric(trim($params['post_count'])))?trim($params['post_count']):$default_post_count;	
			
			$image_ratio 		= (isset($params['image_ratio'])&&trim($params['image_ratio'])!='')?trim($params['image_ratio']):'';
			
			$display_categories			= (isset($params['display_categories'])&&trim($params['display_categories'])!='')?trim($params['display_categories']):'no';
			$display_excerpt			= (isset($params['display_excerpt'])&&trim($params['display_excerpt'])!='')?trim($params['display_excerpt']):'no';			
			$display_author 			= (isset($params['display_author'])&&trim($params['display_author'])!='')?trim($params['display_author']):'no';
			$display_date 				= (isset($params['display_date'])&&trim($params['display_date'])!='')?trim($params['display_date']):'no';
			$display_comment_count 		= (isset($params['display_comment_count'])&&trim($params['display_comment_count'])!='')?trim($params['display_comment_count']):'no';
			$display_view_count 		= (isset($params['display_view_count'])&&trim($params['display_view_count'])!='')?trim($params['display_view_count']):'no';
			$display_like_count 		= (isset($params['display_like_count'])&&trim($params['display_like_count'])!='')?trim($params['display_like_count']):'no';
			$display_dislike_count 		= (isset($params['display_dislike_count'])&&trim($params['display_dislike_count'])!='')?trim($params['display_dislike_count']):'no';
			
			$post_metas					= 	array(
												$display_author=='yes'?'author':'', 
												$display_date=='yes'?'date-time':'', 
												$display_comment_count=='yes'?'comment-count':'', 
												$display_view_count=='yes'?'view-count':'', 
												$display_like_count=='yes'?'like-count':'', 
												$display_dislike_count=='yes'?'dislike-count':''
											);
											
			$link_to					= (isset($params['link_to'])&&trim($params['link_to'])!='')?trim($params['link_to']):'default';								
			
			$rnd_id = 'vp_'.rand(1, 99999);								
											
			$sc_params = array(
				'block_title'			=> $block_title,						
				'layout'				=> $layout,
				'post_type'				=> $post_type,
				'filter_items'			=> $filter_items,
				'category'				=> $category,
				'tag'					=> $tag,
				'ex_category'			=> $ex_category,
				'ids'					=> $ids,
				'ex_ids'				=> $ex_ids,
				'order_by'				=> $order_by,
				'order'					=> $order,
				'offset'				=> $offset,
				'items_per_page'		=> $items_per_page,
				'post_count'			=> $post_count,
				'image_ratio'			=> $image_ratio,
				'display_categories'	=> $display_categories,
				'display_excerpt'		=> $display_excerpt=='yes'?'on':'off',
				'post_metas'			=> $post_metas,
				'link_to'				=> $link_to,	
				'sub_class'				=> $sub_class,
				'rnd_id'				=> $rnd_id,
				'data_ajax'				=> 'no',
			);	
			
			echo \vidorev_block_shortcodes::shortcode_html($sc_params).'<script>if(typeof(vidorev_builder_control)!=="undefined" && vidorev_builder_control!==null){vidorev_builder_control.filter_tab_responsive();}</script>';
		}
	}
	
}

Plugin::instance()->widgets_manager->register_widget_type( new vidorev_Block_Widget() );