<?php
if(!class_exists('vidorev_slider_shortcodes')){
	class vidorev_slider_shortcodes {
	
		static function init(){
			add_shortcode('slider_sc', array(__CLASS__, 'handle_shortcode'));
		}	

		static function handle_shortcode($params, $contents=''){
			
			extract(
				shortcode_atts(
					array(						
						'layout'				=> '',
						'post_type'				=> '',
						'category'				=> '',
						'tag'					=> '',
						'ex_category'			=> '',
						'ids'					=> '',
						'ex_ids'				=> '',
						'order_by'				=> '',
						'order'					=> '',
						'offset'				=> '',
						'post_count'			=> '',
						'display_categories'	=> '',
						'display_author'		=> '',	
						'display_date'			=> '',	
						'display_comment_count'	=> '',	
						'display_view_count'	=> '',	
						'display_like_count'	=> '',	
						'display_dislike_count'	=> '',
						'autoplay'				=> '',
						'fade'					=> ''
					), 
					$params
				)				
			);		
			
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
			
			$html_json_params = wp_json_encode($slider_params);
			
			$offset 			= (isset($params['offset'])&&trim($params['offset'])!=''&&is_numeric(trim($params['offset'])))?trim($params['offset']):0;
			$post_count 		= (isset($params['post_count'])&&trim($params['post_count'])!=''&&is_numeric(trim($params['post_count'])))?trim($params['post_count']):$default_post_count;	
			
			$display_categories			= (isset($params['display_categories'])&&trim($params['display_categories'])!='')?trim($params['display_categories']):'yes';
			$display_author 			= (isset($params['display_author'])&&trim($params['display_author'])!='')?trim($params['display_author']):'yes';
			$display_date 				= (isset($params['display_date'])&&trim($params['display_date'])!='')?trim($params['display_date']):'yes';
			$display_comment_count 		= (isset($params['display_comment_count'])&&trim($params['display_comment_count'])!='')?trim($params['display_comment_count']):'yes';
			$display_view_count 		= (isset($params['display_view_count'])&&trim($params['display_view_count'])!='')?trim($params['display_view_count']):'yes';
			$display_like_count 		= (isset($params['display_like_count'])&&trim($params['display_like_count'])!='')?trim($params['display_like_count']):'yes';
			$display_dislike_count 		= (isset($params['display_dislike_count'])&&trim($params['display_dislike_count'])!='')?trim($params['display_dislike_count']):'yes';
			
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
			
			$sc_query = new WP_Query($args_query);
			
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
					<div class="slider-container <?php echo esc_attr($layout);?>">
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
			
			return $output_string;
		}
	}	
}
vidorev_slider_shortcodes::init();

if(!class_exists('vidorev_block_shortcodes')){
	class vidorev_block_shortcodes {
				
		static function init(){
			add_shortcode('block_sc', array(__CLASS__, 'handle_shortcode'));
			
			add_action('wp_ajax_blockajaxaction', array(__CLASS__, 'ajax'));
			add_action('wp_ajax_nopriv_blockajaxaction', array(__CLASS__, 'ajax'));
		}
		
		static function shortcode_html($params){
			
			$block_title		= trim($params['block_title']);
			$layout 			= trim($params['layout']);
			$post_type 			= trim($params['post_type']);
			$filter_items		= trim($params['filter_items']);
			$category 			= trim($params['category']);
			$tag 				= trim($params['tag']);
			$ex_category 		= trim($params['ex_category']);
			$ids 				= trim($params['ids']);
			$ex_ids 			= trim($params['ex_ids']);
			$order_by 			= trim($params['order_by']);
			$order 				= trim($params['order']);
			$offset 			= trim($params['offset']);
			$items_per_page		= trim($params['items_per_page']);		
			$post_count 		= trim($params['post_count']);
			$image_ratio 		= trim($params['image_ratio']);
			$display_categories	= trim($params['display_categories']);
			$display_excerpt	= trim($params['display_excerpt']);
			$post_metas			= $params['post_metas'];
			$link_to			= trim($params['link_to']);
			$sub_class			= trim($params['sub_class']);
			$rnd_id				= trim($params['rnd_id']);
			$data_ajax			= trim($params['data_ajax']);
			
			if(isset($params['filter'])){
				$filter = trim($params['filter']);
				if($filter!='' && is_numeric($filter) && (float)$filter > 0){
					if(isset($params['tax'])){
						$tax = trim($params['tax']);
						if($tax!=''){
							switch($tax){
								case 'category':
									$category = $filter;
									break;
									
								case 'post_tag':
									$tag = $filter;
									break;	
							}
						}
					}
				}
			}
			
			$args_query = array(
				'post_type'				=> $post_type,
				'posts_per_page' 		=> $items_per_page,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,		
			);
			
			if($offset > 0){
				$args_query['offset'] = $offset;
			}
			
			if(isset($params['paged'])){
				$paged = trim($params['paged']);
				if($paged!='' && is_numeric($paged) && $paged > 1){
					$args_query['paged'] = $paged;
				}
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
					
					if(count($ex_catArray) > 0){						
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
			
			$sc_query = new WP_Query($args_query);
			
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
			
				global $theme_image_ratio;
				if(isset($theme_image_ratio)){
					$old_theme_image_ratio = $theme_image_ratio;
				}
				$theme_image_ratio = $image_ratio;	
				
				global $excerpt_element_template;
				if(isset($excerpt_element_template)){
					$old_excerpt_element_template = $excerpt_element_template;
				}
				$excerpt_element_template = $display_excerpt;
				
				$sidebarControl = vidorev_sidebar_control();
				
				$options_vs_query = '';
				$options_vs_query .='<script>';
				$options_vs_query .=	'if(typeof(vidorev_layouts_query_params)==="undefined"){var vidorev_layouts_query_params=[]};vidorev_layouts_query_params["'.$rnd_id.'"]='.json_encode($params).';';					
				$options_vs_query .='</script>';
				
				$dataItem 	= '0';
				$dataPaged 	= '1';
				$dataEnd	= 'no';	
				
				if(isset($filter) && isset($tax) && $filter!='' && is_numeric($filter) && (float)$filter > 0 && $tax!=''){
					$dataItem 	= $filter;					
				}
				
				if(isset($paged) && $paged!='' && is_numeric($paged) && (float)$paged > 1){
					$dataPaged 	= $paged;	
				}
				
				/*page calculator*/
				$total_posts 		= $post_count;
				$totalCountPosts 	= ($sc_query->found_posts);
				if(is_numeric($total_posts) && $total_posts!=-1) {
					if($totalCountPosts > (float)($total_posts)) {
						$totalCountPosts = $total_posts;
					}else{
						$totalCountPosts = ($sc_query->found_posts);
					};
				};
				
				$allItems			= (float)$totalCountPosts;							
				$allItemsPerPage	= (float)$items_per_page;
				
				if($allItemsPerPage > (float)($total_posts) && $total_posts!=-1){
					$allItemsPerPage = (float)($total_posts);
				}
				
				if($allItemsPerPage > $allItems){
					$allItemsPerPage = $allItems;
				}
				
				$paged_calculator	= 1;
				$percentItems		= 0;
				
				if($allItems > $allItemsPerPage) {
					$percentItems = ($allItems % $allItemsPerPage);		
					if($percentItems!=0){
						$paged_calculator=(($allItems-$percentItems) / $allItemsPerPage) + 1;
					}else{
						$paged_calculator=($allItems / $allItemsPerPage);
					}
				}
				/*page calculator*/
				
				if($paged_calculator==$dataPaged){
					$dataEnd	= 'yes';	
				}
							
				ob_start();								
					$lightbox_video_enb = vidorev_get_redux_option('video_lightbox', 'on', 'switch');
					
					$loop_layout = apply_filters('beeteam368_elementor_block_loop_layouts', array(
						'grid-df-fw-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-df.php',
						'grid-df-3-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-df.php',
						'grid-df-2-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-df.php',
						'grid-df-1-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-df.php',
						'list-df' 			=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/list-df.php',
						'list-sp' 			=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/list-sp.php',
						'grid-sp-fw-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sp.php',
						'grid-sp-3-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sp.php',
						'grid-sp-2-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sp.php',
						'grid-sp-1-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sp.php',
						'grid-md-fw-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-md.php',
						'grid-md-3-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-md.php',
						'grid-md-2-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-md.php',
						'grid-md-1-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-md.php',
						'grid-mv-fw-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/movie-grid.php',
						'grid-mv-6-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/movie-grid.php',
						'grid-mv-4-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/movie-grid.php',
						'list-mv' 			=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/movie-list.php',
						'block-df-1' 		=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-df.php',
						'block-df-2' 		=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-df.php',
						'block-df-3' 		=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-df.php',
						'block-cl-1' 		=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-cl.php',
						'block-cl-2'		=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-cl.php',
						'block-sp-1'		=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-sp.php',
						'block-sp-2' 		=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-sp.php',
						'block-sp-3' 		=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-sp.php',
						'grid-sm-fw-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sm.php',
						'grid-sm-4-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sm.php',
						'grid-sm-3-col' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sm.php',
						'widget-list-df' 	=> VPE_PLUGIN_PATH . 'shortcodes/block-layouts/widget-list-df.php',
					));
					
					if($data_ajax=='no'){
						add_action('wp_footer', function() use ($options_vs_query){
							echo $options_vs_query;
						});
				?>
						<div class="sc-blocks-container sc-blocks-container-control <?php echo esc_attr(apply_filters('beeteam368_elementor_block_layout_class', $layout));?> fw-c-fix-cls" data-id="<?php echo esc_attr($rnd_id)?>">
						
							<?php if($block_title!='' || $filter_items!=''){?>
								<div class="filter-container filter-container-control">
									<div class="filter-wrapper">
										<?php if($block_title!=''){?>
											<div class="block-title block-title-control"><h2 class="extra-bold h5"><?php echo esc_html($block_title);?></h2></div>
										<?php }?>
										
										<?php if($filter_items!=''){?>
											<div class="filter-items filter-items-control navigation-font nav-font-size-12">
												<div class="filter-items-wrapper filter-items-wrapper-control">
													<?php 
													$filter_item_html = '';
													$filter_item_html.='<span class="filter-item filter-action-control active-item" data-taxonomy="all" data-id="0">'.esc_html__('All', 'vidorev-extensions').'</span>';
													
													$terms = explode(',', $filter_items);
													foreach($terms as $term){
															
														if(is_numeric(trim($term))){					
															$term_cat = get_term_by('id', trim($term), $s_tax_query);
															$term_tag = get_term_by('id', trim($term), 'post_tag');												
														}else{
															$term_cat = get_term_by('slug', trim($term), $s_tax_query);
															$term_tag = get_term_by('slug', trim($term), 'post_tag');												
														}
														
														if(!is_wp_error($term_cat) && !empty($term_cat)){
															$filter_item_html.='<span class="filter-item filter-action-control" data-taxonomy="category" data-id="'.esc_attr($term_cat->term_id).'">'.esc_html($term_cat->name).'</span>';	
														}
														
														if(!is_wp_error($term_tag) && !empty($term_tag)){
															$filter_item_html.='<span class="filter-item filter-action-control" data-taxonomy="post_tag" data-id="'.esc_attr($term_tag->term_id).'">'.esc_html($term_tag->name).'</span>';		
														}
													}
													echo $filter_item_html;
													?>
												</div>
											</div>
										<?php }?>
									</div>
								</div>
							
							<?php }?>
							
							<div class="block-filter block-filter-control">
								<div class="ajax-loading">
									<div class="la-ball-triangle-path">
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>								

					<?php 
					}						
					?>	
						
								<div class="blog-wrapper global-blog-wrapper blog-wrapper-control active-item current-paged" data-item="<?php echo esc_attr($dataItem);?>" data-paged="<?php echo esc_attr($dataPaged);?>" data-end="<?php echo esc_attr($dataEnd);?>">
									<div class="blog-items blog-items-control site__row <?php echo esc_attr($sub_class);?>">
										<?php
										$i = 1;
										$z = 1;
										while($sc_query->have_posts()):
											$sc_query->the_post();
											
											$playlist_id 	= 0;
											$series_id 		= 0;
											
											switch($link_to){
												case 'playlist';
													$playlist_id 	= beeteam368_get_playlist_by_post_id(get_the_ID());	
													if($playlist_id > 0){
														global $post_type_add_param_to_url;
														$post_type_add_param_to_url = array(
															'playlist' => $playlist_id
														);
													}								
													break;
													
												case 'series';
													$series_id = beeteam368_get_series_by_post_id(get_the_ID());
													if($series_id > 0){
														global $post_type_add_param_to_url;
														$post_type_add_param_to_url = array(
															'series' => $series_id
														);
													}
													break;
											}
											
											if(isset($loop_layout[$layout])){
												include($loop_layout[$layout]);
											}else{
												include($loop_layout['grid-df-3-col']);
											}
											
											/*switch($layout){
												case 'grid-df-fw-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-df.php');								
													break;
													
												case 'grid-df-3-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-df.php');								
													break;
													
												case 'grid-df-2-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-df.php');								
													break;
													
												case 'grid-df-1-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-df.php');							
													break;
													
												case 'list-df':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/list-df.php');								
													break;
													
												case 'list-sp':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/list-sp.php');								
													break;		
												
												case 'grid-sp-fw-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sp.php');								
													break;
													
												case 'grid-sp-3-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sp.php');								
													break;
													
												case 'grid-sp-2-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sp.php');								
													break;
													
												case 'grid-sp-1-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sp.php');							
													break;
													
												case 'grid-md-fw-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-md.php');								
													break;	
													
												case 'grid-md-3-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-md.php');								
													break;
													
												case 'grid-md-2-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-md.php');								
													break;
													
												case 'grid-md-1-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-md.php');							
													break;
												
												case 'grid-mv-fw-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/movie-grid.php');								
													break;
													
												case 'grid-mv-6-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/movie-grid.php');								
													break;
													
												case 'grid-mv-4-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/movie-grid.php');							
													break;	
													
												case 'list-mv':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/movie-list.php');							
													break;
													
												case 'block-df-1':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-df.php');							
													break;
													
												case 'block-df-2':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-df.php');							
													break;	
													
												case 'block-df-3':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-df.php');							
													break;	
													
												case 'block-cl-1':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-cl.php');							
													break;
													
												case 'block-cl-2':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-cl.php');							
													break;	
													
												case 'block-sp-1':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-sp.php');							
													break;
													
												case 'block-sp-2':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-sp.php');							
													break;	
													
												case 'block-sp-3':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/block-sp.php');							
													break;
												
												case 'grid-sm-fw-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sm.php');							
													break;
													
												case 'grid-sm-4-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sm.php');							
													break;	
													
												case 'grid-sm-3-col':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/grid-sm.php');							
													break;
													
												case 'widget-list-df':
													include(VPE_PLUGIN_PATH . 'shortcodes/block-layouts/widget-list-df.php');							
													break;			
													
												//new layout		
																		
											}*/
											
											if($dataPaged==$paged_calculator && $i==$percentItems){
												break;
											}
											
											$i++;
											$z++;
											
											if( isset($post_type_add_param_to_url) && is_array($post_type_add_param_to_url) && ($series_id > 0 || $playlist_id > 0) ){
												$post_type_add_param_to_url = NULL;	
											}
											
										endwhile;	
										?>	
									</div>	
								</div>
							
					<?php if($data_ajax=='no'){?>	
							</div>	
							<div class="bl-page-prev-next bl-page-prev-next-control <?php if($paged_calculator > 1 && $offset < 1){echo esc_attr('active-item');} ?>">
								<span class="next-prev-action disabled-query" data-action="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
								<span class="next-prev-action" data-action="next"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>					
						</div>
					<?php }?>
				<?php				
				$output_string = ob_get_contents();
				ob_end_clean();
				
				if(isset($old_theme_image_ratio)){
					$theme_image_ratio = $old_theme_image_ratio;
				}else{
					unset($theme_image_ratio);
				}
				
				if(isset($old_excerpt_element_template)){
					$excerpt_element_template = $old_excerpt_element_template;
				}else{
					unset($excerpt_element_template);
				}
			endif;
			
			wp_reset_postdata();			
			return $output_string;	
		}
		
		static function ajax(){
			$params	= $_POST['params'];
			
			if(isset($params)){							
				echo self::shortcode_html($params);
			}else{
				echo '';
			}
			exit;
		}	

		static function handle_shortcode($params, $contents=''){
			
			extract(
				shortcode_atts(
					array(	
						'block_title'			=> '',					
						'layout'				=> '',
						'post_type'				=> '',
						'filter_items'			=> '',
						'category'				=> '',
						'ex_category'			=> '',
						'tag'					=> '',
						'ids'					=> '',
						'ex_ids'				=> '',
						'order_by'				=> '',
						'order'					=> '',
						'offset'				=> '',
						'items_per_page'		=> '',
						'post_count'			=> '',
						'image_ratio'			=> '',
						'display_categories'	=> '',
						'display_excerpt'		=> '',
						'display_author'		=> '',	
						'display_date'			=> '',	
						'display_comment_count'	=> '',	
						'display_view_count'	=> '',	
						'display_like_count'	=> '',	
						'display_dislike_count'	=> '',
						'link_to'				=> '',
						'overwirte_rnd'			=> '',					
					), 
					$params
				)				
			);

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
					
				case 'widget-list-df':
					$default_items_per_page = apply_filters( 'vidorev_widget_related_posts_itemsperpage', 3 );
					$default_post_count		= apply_filters( 'vidorev_widget_related_posts_postcount', 15 );
					$sub_class				= 'widget-list-df';								
					break;		
					
				/*new layout*/			
										
			}
			
			$offset 			= (isset($params['offset'])&&trim($params['offset'])!=''&&is_numeric(trim($params['offset'])))?trim($params['offset']):0;
			$items_per_page		= (isset($params['items_per_page'])&&trim($params['items_per_page'])!=''&&is_numeric(trim($params['items_per_page'])))?trim($params['items_per_page']):$default_items_per_page;		
			$post_count 		= (isset($params['post_count'])&&trim($params['post_count'])!=''&&is_numeric(trim($params['post_count'])))?trim($params['post_count']):$default_post_count;	
			
			$image_ratio 		= (isset($params['image_ratio'])&&trim($params['image_ratio'])!='')?trim($params['image_ratio']):'';	
			
			$display_categories			= (isset($params['display_categories'])&&trim($params['display_categories'])!='')?trim($params['display_categories']):'yes';
			$display_excerpt			= (isset($params['display_excerpt'])&&trim($params['display_excerpt'])!='')?trim($params['display_excerpt']):'yes';
			
			$display_author 			= (isset($params['display_author'])&&trim($params['display_author'])!='')?trim($params['display_author']):'yes';
			$display_date 				= (isset($params['display_date'])&&trim($params['display_date'])!='')?trim($params['display_date']):'yes';
			$display_comment_count 		= (isset($params['display_comment_count'])&&trim($params['display_comment_count'])!='')?trim($params['display_comment_count']):'yes';
			$display_view_count 		= (isset($params['display_view_count'])&&trim($params['display_view_count'])!='')?trim($params['display_view_count']):'yes';
			$display_like_count 		= (isset($params['display_like_count'])&&trim($params['display_like_count'])!='')?trim($params['display_like_count']):'yes';
			$display_dislike_count 		= (isset($params['display_dislike_count'])&&trim($params['display_dislike_count'])!='')?trim($params['display_dislike_count']):'yes';
			
			$post_metas					= 	array(
												$display_author=='yes'?'author':'', 
												$display_date=='yes'?'date-time':'', 
												$display_comment_count=='yes'?'comment-count':'', 
												$display_view_count=='yes'?'view-count':'', 
												$display_like_count=='yes'?'like-count':'', 
												$display_dislike_count=='yes'?'dislike-count':''
											);
											
			$link_to 		= (isset($params['link_to'])&&trim($params['link_to'])!='')?trim($params['link_to']):'default';								
			
			$rnd_id 		= 'vp_'.rand(1, 99999);
			$overwirte_rnd 	= (isset($params['overwirte_rnd'])&&trim($params['overwirte_rnd'])!='')?trim($params['overwirte_rnd']):'';	
			if($overwirte_rnd!=''){
				$rnd_id = $overwirte_rnd;
			}						
											
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
			
			return self::shortcode_html($sc_params);
		}
	}	
}
vidorev_block_shortcodes::init();

if(!class_exists('vidorev_single_player_shortcodes')){
	class vidorev_single_player_shortcodes {
	
		static function init(){
			add_shortcode('single_video_player', array(__CLASS__, 'handle_shortcode'));
		}	

		static function handle_shortcode($params, $contents=''){
			
			extract(
				shortcode_atts(
					array(						
						'id'				=> '',
						'style'				=> '',						
					), 
					$params
				)				
			);
			
			$id 	= (isset($params['id'])&&trim($params['id'])!=''&&is_numeric(trim($params['id'])))?trim($params['id']):0;
			$style	= (isset($params['style'])&&trim($params['style'])!='')?trim($params['style']):'vp-small-item';
			
			if($id==0){
				return '';
			}
			
			ob_start();	
			
				do_action( 'vidorev_single_video_player', 'toolbar', $style.' sc-video-elm-widget', $id);
				
			$output_string = ob_get_contents();
			ob_end_clean();
			return $output_string;	
			
		}
	}	
}
vidorev_single_player_shortcodes::init();

if(!class_exists('vidorev_single_playlist_shortcodes')){
	class vidorev_single_playlist_shortcodes {
	
		static function init(){
			add_shortcode('single_video_playlist', array(__CLASS__, 'handle_shortcode'));
		}	

		static function handle_shortcode($params, $contents=''){
			
			extract(
				shortcode_atts(
					array(						
						'id'				=> '',
						'style'				=> '',						
					), 
					$params
				)				
			);
			
			$id 	= (isset($params['id'])&&trim($params['id'])!=''&&is_numeric(trim($params['id'])))?trim($params['id']):0;
			$style	= (isset($params['style'])&&trim($params['style'])!='')?trim($params['style']):'pe-small-item';
			
			if($id==0){
				return '';
			}
			
			ob_start();	
			
				echo '<div class="site__container fullwidth-vidorev-ctrl sc-playlist-wrapper dark-background '.esc_attr($style).'">';
					do_action( 'vidorev_single_post_convert_playlist', $id, $style);
				echo '</div>';
				
			$output_string = ob_get_contents();
			ob_end_clean();
			return $output_string;	
			
		}
	}	
}
vidorev_single_playlist_shortcodes::init();

if(!class_exists('vidorev_single_time_lapses_shortcodes')){
	class vidorev_single_time_lapses_shortcodes {
	
		static function init(){
			add_shortcode('vidorev_time_lapse', array(__CLASS__, 'handle_shortcode'));
			add_action('vidorev_video_player_timelapse', array(__CLASS__, 'handle_elements'));
		}	

		static function handle_shortcode($params, $contents=''){
			
			extract(
				shortcode_atts(
					array(						
						'title'				=> '',
						'time'				=> '',						
					), 
					$params
				)				
			);
			
			$title 	= (isset($params['title'])&&trim($params['title'])!='')?trim($params['title']):'';
			$style	= (isset($params['time'])&&trim($params['time'])!='')?trim($params['time']):'';
			
			if($time==''){
				return '';
			}
			
			ob_start();	
			
				echo '<a href="#" class="h6 time_lapses time_lapses_control" data-time="'.esc_attr($time).'">'.esc_html($title).' <span class="tl-time meta-font"> '.esc_html($time).' </span></a>';					
				
			$output_string = ob_get_contents();
			ob_end_clean();
			return $output_string;	
			
		}
		static function handle_elements($post_id){
			$timelapse_sc = trim(get_post_meta($post_id, 'vm_video_timelapse', true));
			if($timelapse_sc!=''){
				echo '<div class="player-timelapse">'.do_shortcode($timelapse_sc).'</div>';
			}
		}
	}	
}
vidorev_single_time_lapses_shortcodes::init();