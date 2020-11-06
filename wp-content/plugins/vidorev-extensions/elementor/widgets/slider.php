<?php
namespace Elementor;

if(!class_exists('vidorev_Slider_Widget')){

	class vidorev_Slider_Widget extends Widget_Base {
	
		public function get_name() {
			return 'vidorev_slider_addon';
		}
	
		public function get_title() {
			return esc_html__( 'Slider', 'vidorev-extensions');
		}
	
		public function get_icon() {
			return 'fa fa-sliders';
		}
		
		public function get_categories() {
			return [ 'vidorev-addon-elements' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'vidorev_slider_addon_global_settings',
				[
					'label' 		=> esc_html__( 'Slider', 'vidorev-extensions')
				]
			);
			
			$this->add_control(
				'layout',
				[
					'label'			=> esc_html__( 'Layout', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> 'slider-1',
					'options'		=> apply_filters('beeteam368_elementor_slider_style_layouts', [
						'slider-1' => esc_html__('STYLE 1', 'vidorev-extensions'),
						'slider-2' => esc_html__('STYLE 2', 'vidorev-extensions'),
						'slider-3' => esc_html__('STYLE 3', 'vidorev-extensions'),
						'slider-4' => esc_html__('STYLE 4', 'vidorev-extensions'),
						'slider-5' => esc_html__('STYLE 5', 'vidorev-extensions'),
						'slider-6' => esc_html__('STYLE 6', 'vidorev-extensions'),
						'slider-7' => esc_html__('STYLE 7', 'vidorev-extensions'),
						'slider-8' => esc_html__('STYLE 8', 'vidorev-extensions'),
						'slider-9' => esc_html__('STYLE 9', 'vidorev-extensions'),
						'slider-10' => esc_html__('STYLE 10', 'vidorev-extensions'),
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
					'description' 	=> esc_html__('Number of post to displace or pass over.', 'vidorev-extensions'),	
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
				'autoplay',
				[
					'label'			=> esc_html__('Autoplay Speed', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Autoplay Speed in milliseconds. If blank, autoplay is off. eg: 5000, 6000...', 'vidorev-extensions'),		
				]
			);
			
			$this->add_control(
				'fade',
				[
					'label'			=> esc_html__('Fading Effect', 'vidorev-extensions'),	
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> '',
					'label_on' 		=> esc_html__('Yes', 'vidorev-extensions'),
					'label_off' 	=> esc_html__('No', 'vidorev-extensions'),
					'return_value' 	=> 'yes',
				]
			);
			
		}
		
		protected function render() {
			$params = $this->get_settings();
			
			$layout 			= (isset($params['layout'])&&trim($params['layout'])!='')?trim($params['layout']):'slider-1';
			$post_type 			= (isset($params['post_type'])&&trim($params['post_type'])!='')?trim($params['post_type']):'post';
			$category 			= (isset($params['category'])&&trim($params['category'])!='')?trim($params['category']):'';
			$tag 				= (isset($params['tag'])&&trim($params['tag'])!='')?trim($params['tag']):'';
			$ex_category 		= (isset($params['ex_category'])&&trim($params['ex_category'])!='')?trim($params['ex_category']):'';
			$ids 				= (isset($params['ids'])&&trim($params['ids'])!='')?trim($params['ids']):'';
			$ex_ids 			= (isset($params['ex_ids'])&&trim($params['ex_ids'])!='')?trim($params['ex_ids']):'';
			$order_by 			= (isset($params['order_by'])&&trim($params['order_by'])!='')?trim($params['order_by']):'date';
			$order 				= (isset($params['order'])&&trim($params['order'])!='')?trim($params['order']):'DESC';
			$autoplay 			= (isset($params['autoplay'])&&trim($params['autoplay'])!=''&&is_numeric(trim($params['autoplay'])))?trim($params['autoplay']):0;	
			$fade 				= (isset($params['fade'])&&trim($params['fade'])!='')?trim($params['fade']):'no';
			
			$slider_params 		= array();
			$default_post_count	= 12;
			switch($layout){
				case 'slider-1':
					$default_post_count	= 12;
					$slider_params['layout'] 	= 'slider-1';
					$slider_params['arrows'] 	= true;
					$slider_params['dots'] 		= false;					
					break;
					
				case 'slider-2':
					$default_post_count	= 15;
					$slider_params['layout'] 	= 'slider-2';
					$slider_params['arrows'] 	= true;
					$slider_params['dots'] 		= false;
					break;
					
				case 'slider-3':
					$default_post_count	= 3;
					$slider_params['layout'] 	= 'slider-3';
					$slider_params['arrows'] 	= true;
					$slider_params['dots'] 		= true;
					break;
					
				case 'slider-4':
					$default_post_count	= 6;
					$slider_params['layout'] 	= 'slider-4';
					$slider_params['arrows'] 	= false;
					$slider_params['dots'] 		= false;
					break;	
					
				case 'slider-5':
					$default_post_count	= 8;
					$slider_params['layout'] 	= 'slider-5';
					$slider_params['arrows'] 	= true;
					$slider_params['dots'] 		= false;
					break;
					
				case 'slider-6':
					$default_post_count	= 12;
					$slider_params['layout'] 	= 'slider-6';
					$slider_params['arrows'] 	= false;
					$slider_params['dots'] 		= true;
					break;
					
				case 'slider-7':
					$default_post_count	= 12;
					$slider_params['layout'] 	= 'slider-7';
					$slider_params['arrows'] 	= true;
					$slider_params['dots'] 		= false;
					break;
					
				case 'slider-8':
					$default_post_count	= 6;
					$slider_params['layout'] 	= 'slider-8';
					$slider_params['arrows'] 	= true;
					$slider_params['dots'] 		= false;					
					break;
					
				case 'slider-9':
					$default_post_count	= 20;
					$slider_params['layout'] 	= 'slider-9';
					$slider_params['arrows'] 	= false;
					$slider_params['dots'] 		= false;
					break;
				
				case 'slider-10':
					$default_post_count	= 6;
					$slider_params['layout'] 	= 'slider-10';
					$slider_params['arrows'] 	= true;
					$slider_params['dots'] 		= false;					
					break;									
			}
			
			$slider_params['autoplay'] 	= $autoplay;
			$slider_params['fade'] 		= $fade;
			
			$slider_params['rnd_class'] = 'slider'.rand(1, 99999);
			
			$slider_params 		= apply_filters('beeteam368_elementor_slider_params', $slider_params, $layout);
			$default_post_count = apply_filters('beeteam368_elementor_slider_post_count', $default_post_count, $layout);
			
			$html_json_params = wp_json_encode($slider_params);
			
			$offset 			= (isset($params['offset'])&&trim($params['offset'])!=''&&is_numeric(trim($params['offset'])))?trim($params['offset']):0;	
			$post_count 		= (isset($params['post_count'])&&trim($params['post_count'])!=''&&is_numeric(trim($params['post_count'])))?trim($params['post_count']):$default_post_count;	
			
			$display_categories			= (isset($params['display_categories'])&&trim($params['display_categories'])!='')?trim($params['display_categories']):'no';
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
											
											
			$args_query = array(
				'post_type'				=> $post_type,
				'posts_per_page' 		=> $post_count,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,		
			);
			
			if($offset > 0){
				$args_query['offset'] = $offset;
			}
			
			$args_re = array('relation' => 'OR');
			
			if($post_type == 'post-video'){
				$args_query['post_type'] = 'post';
				
				$args_re[] = 	array(
									'taxonomy'  => 'post_format',
									'field'    	=> 'slug',
									'terms'     => array('post-format-video'),
									'operator'  => 'IN',
								);
			}elseif($post_type == 'post-without-video'){
				$args_query['post_type'] = 'post';
				
				$args_re[] = 	array(
									'taxonomy'  => 'post_format',
									'field'    	=> 'slug',
									'terms'     => array('post-format-video'),
									'operator'  => 'NOT IN',
								);
			}	
			
			if($ids!=''){
				$idsArray = array();
				$idsExs = explode(',', $ids);
				foreach($idsExs as $idsEx){	
					if(is_numeric(trim($idsEx))){					
						array_push($idsArray, trim($idsEx));
					}
				}
				
				if(count($idsArray)>0){
					$args_query['post__in'] = $idsArray;
				}
			}
			
			if($ex_ids!=''){
				$ex_idsArray = array();
				$ex_idsExs = explode(',', $ex_ids);
				foreach($ex_idsExs as $ex_idsEx){	
					if(is_numeric(trim($ex_idsEx))){					
						array_push($ex_idsArray, trim($ex_idsEx));
					}
				}
				
				if(count($ex_idsArray)>0){
					$args_query['post__not_in'] = $ex_idsArray;
				}
			}
			
			$s_tax_query = 'category';
			
			switch($post_type){
				case 'vid_playlist':
					$s_tax_query = 'vid_playlist_cat';
					break;
				case 'vid_channel':
					$s_tax_query = 'vid_channel_cat';
					break;	
				case 'vid_series':
					$s_tax_query = 'vid_series_cat';
					break;
			}
			
			if($ex_category!=''){
				$ex_catArray = array();
				
				$ex_catExs = explode(',', $ex_category);
				
				foreach($ex_catExs as $ex_catEx){	
					if(is_numeric(trim($ex_catEx))){					
						array_push($ex_catArray, trim($ex_catEx));
					}else{
						$slug_ex_cat = get_term_by('slug', trim($ex_catEx), $s_tax_query);					
						if($slug_ex_cat){
							$ex_cat_term_id = $slug_ex_cat->term_id;
							array_push($ex_catArray, $ex_cat_term_id);
						}
					}
				}
				
				if(count($ex_catArray) > 0){
					
					$ex_def = array(
						'field' 			=> 'id',
						'operator' 			=> 'NOT IN',
					);					
											
					$args_ex_cat_query = wp_parse_args(
						array(
							'taxonomy'	=> $s_tax_query,
							'terms'		=> $ex_catArray,
						),
						$ex_def
					);
					
					$args_re[] = $args_ex_cat_query;
					
				}	
			}
			
			if($category!='' || $tag!=''){
				$catArray = array();
				$tagArray = array();
			
				$catExs = explode(',', $category);
				$tagExs = explode(',', $tag);
				
				foreach($catExs as $catEx){	
					if(is_numeric(trim($catEx))){					
						array_push($catArray, trim($catEx));
					}else{
						$slug_cat = get_term_by('slug', trim($catEx), $s_tax_query);					
						if($slug_cat){
							$cat_term_id = $slug_cat->term_id;
							array_push($catArray, $cat_term_id);
						}
					}
				}			
				
				foreach($tagExs as $tagEx){	
					if(is_numeric(trim($tagEx))){					
						array_push($tagArray, trim($tagEx));
					}else{
						$slug_tag = get_term_by('slug', trim($tagEx), 'post_tag');									
						if($slug_tag){
							$tag_term_id = $slug_tag->term_id;	
							array_push($tagArray, $tag_term_id);
						}
					}
				}
				
				if(count($catArray) > 0 || count($tagArray) > 0){
					$taxonomies = array();
					
					$def = array(
						'field' 			=> 'id',
						'operator' 			=> 'IN',
					);
					
					if(count($catArray) > 0){
						array_push($taxonomies, $s_tax_query);
						$args_cat_query = wp_parse_args(
							array(
								'taxonomy'	=> $s_tax_query,
								'terms'		=> $catArray,
							),
							$def
						);
					}
					
					if(count($tagArray) > 0){
						array_push($taxonomies, 'post_tag');
						$args_tag_query = wp_parse_args(
							array(
								'taxonomy'	=> 'post_tag',
								'terms'		=> $tagArray,
							),
							$def
						);
					}
					
					if(count($taxonomies) > 1){
						$args_re[] = array(
							'relation' => 'OR',
							$args_cat_query,
							$args_tag_query,	
						);
					}else{
						if(count($catArray) > 0 && count($tagArray) == 0){
							$args_re[] = $args_cat_query;
						}elseif(count($catArray) == 0 && count($tagArray) > 0){
							$args_re[] = $args_tag_query;
						}
					}			
					
				}
			}
			
			if(count($args_re)>1){
				if(count($args_re)>2){
					$args_re['relation'] = 'AND';
				}
				$args_query['tax_query'] = $args_re;
			}
			
			switch($order_by){
				case 'date':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'date';
					break;
					
				case 'ID':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'ID';
					break;	
					
				case 'author':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'author';
					break;	
					
				case 'title':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'title';
					break;	
					
				case 'modified':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'modified';
					break;	
					
				case 'parent':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'parent';
					break;	
					
				case 'comment_count':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'comment_count';
					break;						
					
				case 'menu_order':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'menu_order';	
					break;	
					
				case 'post__in':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'post__in';
					break;
					
				case 'rand':
					$args_query['order'] = $order;
					$args_query['orderby'] = 'rand';	
					break;					
					
				case 'view':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
						
						if($order=='ASC'){
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_asc'));
						}else{
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
						}						
					}
					break;
				
				case 'like':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
						
						if($order=='ASC'){
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like_asc'));
						}else{
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
						}						
					}
					break;	
					
				case 'popular':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_view_like'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view_like'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_like_all'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));							
						if($order=='ASC'){
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_like_asc'));
						}else{
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_like'));
						}
					}
					break;
					
				case 'mostsubscribed':
					if(class_exists('vidorev_like_view_sorting') && defined('CHANNEL_PM_PREFIX')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_subscribed'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_subscribed'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_subscribed'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
						if($order=='ASC'){
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_asc'));
						}else{
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_desc'));
						}
					}
					break;
					
				case 'highest_rated':
					if(class_exists('vidorev_like_view_sorting') && defined('YASR_LOG_TABLE')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_star_rating'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_star_rating'));	
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_star_rating'));					
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
						if($order=='ASC'){
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_asc'));
						}else{
							add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_desc'));
						}
					}
					break;						
					
			}
			
			$sc_query = new \WP_Query($args_query);
			
			if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_asc'));
			}
			
			if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));
				remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like_asc'));
			}
			
			if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter') && class_exists('vidorev_like_dislike_settings')){
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_view_like'));
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view_like'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_like_all'));
				remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_like'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_like_asc'));
			}
			
			if(class_exists('vidorev_like_view_sorting') && defined('CHANNEL_PM_PREFIX')){
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_subscribed'));
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_subscribed'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_subscribed'));
				remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_asc'));	
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_desc'));
			}
			
			if(class_exists('vidorev_like_view_sorting') && defined('YASR_LOG_TABLE')){
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_star_rating'));
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_star_rating'));	
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_star_rating'));					
				remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));	
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_desc'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_asc'));
			}
			
			$output_string = '';
			
			if($sc_query->have_posts()):
				ob_start();
					$small_sync = '';					
					$lightbox_video_enb = vidorev_get_redux_option('video_lightbox', 'on', 'switch');
					$loop_layout = apply_filters('beeteam368_elementor_slider_loop_layouts', array(
						'slider-1' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-1.php',
						'slider-2' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-2.php',
						'slider-3' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-3.php',
						'slider-4' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-4.php',
						'slider-5' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-5.php',
						'slider-6' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-6.php',
						'slider-7' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-7.php',
						'slider-8' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-8.php',
						'slider-9' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-9.php',
						'slider-10' => VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-10.php',
					));
				?>
					<div class="slider-container <?php echo esc_attr(apply_filters('beeteam368_elementor_slider_layout_class', $layout));?>">
						<div class="slider-track">
							<div class="slider-list is-shortcode-slider" data-params='<?php echo $html_json_params;?>'>
								<?php								
								
								$totalCountPosts = 	($sc_query->found_posts);
								
								if(is_numeric($post_count) && $post_count!=-1) {
									if($totalCountPosts > (int)($post_count)) {
										$totalCountPosts = $post_count;
									}else{
										$totalCountPosts = ($sc_query->found_posts);
									};
								};
								
								$i = 1;
								$z = 1;
								while($sc_query->have_posts()):
									$sc_query->the_post();
									
									if(isset($loop_layout[$layout])){
										include($loop_layout[$layout]);
									}else{
										include($loop_layout['slider-1']);
									}
									
									/*switch($layout){
										case 'slider-1':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-1.php');
											break;
											
										case 'slider-2':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-2.php');
											break;
											
										case 'slider-3':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-3.php');
											break;
											
										case 'slider-4':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-4.php');
											break;	
											
										case 'slider-5':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-5.php');
											break;
											
										case 'slider-6':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-6.php');
											break;
											
										case 'slider-7':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-7.php');
											break;
											
										case 'slider-8':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-8.php');
											break;
										
										case 'slider-9':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-9.php');
											break;
										
										case 'slider-10':
											include(VPE_PLUGIN_PATH . 'shortcodes/slider-layouts/slider-10.php');
											break;									
									}*/
									
									$i++;
									$z++;
								endwhile;	
								?>
								
							</div>
							
							<?php if($layout == 'slider-4'){?>
								<div class="site__container fullwidth-vidorev-ctrl dark-background sync-wrapper <?php echo esc_attr($slider_params['rnd_class']);?>">
									<div class="site__row">
										<div class="site__col">
											<div class="sync-slider-small sync-slider-small-control">
												<?php echo $small_sync;?>
											</div>
										</div>
									</div>
								</div>	
							<?php }?>
						</div>						
					</div>
				<?php				
				$output_string = ob_get_contents();
				ob_end_clean();
			endif;
			
			wp_reset_postdata();
			
			echo $output_string.'<script>if(typeof(vidorev_builder_control)!=="undefined" && vidorev_builder_control!==null){vidorev_builder_control.shortcode_slider();}</script>';
		}
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new vidorev_Slider_Widget() );