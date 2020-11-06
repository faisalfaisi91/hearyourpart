<?php
if(!class_exists('vidorev_widget_post')):
	class vidorev_widget_post extends WP_Widget {
	
		function __construct() {
			
			parent::__construct( 'vidorev_post_extensions', esc_html__('VidoRev - Post Extensions', 'vidorev-extensions'), array('classname' => 'vidorev-post-extensions') );
		}	
			
		function widget( $args, $instance ) {
			extract($args);
			
			$title 				= isset($instance['title'])?trim($instance['title']):'';
			$layout 			= isset($instance['layout'])?trim($instance['layout']):'list-default';
			$post_type 			= isset($instance['post_type'])?trim($instance['post_type']):'post';
			$link_to			= isset($instance['link_to'])?trim($instance['link_to']):'default';
			$category 			= isset($instance['category'])?trim($instance['category']):'';
			$tag 				= isset($instance['tag'])?trim($instance['tag']):'';
			$ids 				= isset($instance['ids'])?trim($instance['ids']):'';
			$order_by 			= isset($instance['order_by'])?trim($instance['order_by']):'latest';
			$post_count 		= isset($instance['post_count'])?trim($instance['post_count']):5;
			
			$args_query = array(
				'post_type'				=> $post_type,
				'posts_per_page' 		=> $post_count,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,		
			);
			
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
			
			$df_post_metas = array('author', '', '', 'view-count', 'like-count', '');
			
			switch($order_by){
				case 'latest':
					$args_query['order'] = 'DESC';
					$args_query['orderby'] = 'date';
					$df_post_metas = array('author', 'date-time', '', '', '', '');
					break;
					
				case 'most-commented':
					$args_query['order'] = 'DESC';
					$args_query['orderby'] = 'comment_count';	
					$df_post_metas = array('author', '', 'comment-count', '', '', '');
					break;
					
				case 'most-viewed-all-time':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
					}
					$df_post_metas = array('author', '', '', 'view-count', '', '');
					break;
					
				case 'most-viewed-day':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_day'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
					}
					$df_post_metas = array('author', '', '', 'view-count', '', '');
					break;
					
				case 'most-viewed-week':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_week'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
					}
					$df_post_metas = array('author', '', '', 'view-count', '', '');
					break;
					
				case 'most-viewed-month':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_month'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
					}
					$df_post_metas = array('author', '', '', 'view-count', '', '');
					break;
					
				case 'most-viewed-year':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_year'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
					}
					$df_post_metas = array('author', '', '', 'view-count', '', '');
					break;
				
				case 'most-liked-all-time':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
					}
					$df_post_metas = array('author', '', '', '', 'like-count', '');
					break;	
				
				case 'most-liked-day':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_day'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
					}
					$df_post_metas = array('author', '', '', '', 'like-count', '');
					break;	
				
				case 'most-liked-week':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_week'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
					}
					$df_post_metas = array('author', '', '', '', 'like-count', '');
					break;	
				
				case 'most-liked-month':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_month'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
					}
					$df_post_metas = array('author', '', '', '', 'like-count', '');
					break;	
					
				case 'most-liked-year':
					if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_year'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
					}
					$df_post_metas = array('author', '', '', '', 'like-count', '');
					break;
					
				case 'popular-view-like':
					if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter') && class_exists('vidorev_like_dislike_settings')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_view_like'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view_like'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_like_all'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));	
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_like'));
					}
					$df_post_metas = array('author', '', '', 'view-count', 'like-count', '');
					break;
					
				case 'mostsubscribed':
					if(class_exists('vidorev_like_view_sorting') && defined('CHANNEL_PM_PREFIX')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_subscribed'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_subscribed'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_subscribed'));
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));	
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_desc'));
					}
					break;
					
				case 'highest_rated':
					if(class_exists('vidorev_like_view_sorting') && defined('YASR_LOG_TABLE')){
						add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_star_rating'));
						add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_star_rating'));
						add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_star_rating'));						
						add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));	
						add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_desc'));
					}
					break;												
					
			}
			
			$widget_query = new WP_Query($args_query);
			
			if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_day'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_week'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_month'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_year'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_asc'));
			}
			
			if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_day'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_week'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_month'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_year'));
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
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_desc'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_asc'));
			}

			if(class_exists('vidorev_like_view_sorting') && defined('YASR_LOG_TABLE')){
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_star_rating'));
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_star_rating'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_star_rating'));							
				remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));	
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_desc'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_asc'));
			}
			
			$widget_html = '';
			
			if($widget_query->have_posts()):
			
				$widget_html.= $before_widget;
				
				$widget_arrow = '';
				$widget_extra_class = '';
				$widget_sub_bt = '';
				$widget_sub_at = '';
				if($layout=='single-slider'){
					$widget_arrow = '<span class="widget-arrow"><span class="widget-arrow-prev widget-arrow-prev-control"><i class="fa fa-angle-left" aria-hidden="true"></i></span><span class="widget-arrow-next widget-arrow-next-control"><i class="fa fa-angle-right" aria-hidden="true"></i></span></span>';
					$widget_extra_class = 'is-single-slider effect-fade';
					$widget_sub_bt = '<span class="is-arrow-ct">';
					$widget_sub_at = '</span>';
				}
				
				$widget_html.= $before_title . $widget_arrow . $widget_sub_bt . $title . $widget_sub_at . $after_title;
				
				ob_start();
				?>
					<div class="vp-widget-post-layout vp-widget-post-layout-control <?php echo 'wg-'.esc_attr($layout);?>">
						<div class="widget-post-listing widget-post-listing-control <?php echo esc_attr($widget_extra_class);?>">
						<?php
						$widget_thumbnail_0 = 'vidorev_thumb_1x1_0x';
						$widget_thumbnail_1 = 'vidorev_thumb_1x1_1x';
						if(!defined('VIDOREV_EXTENSIONS')){
							$widget_thumbnail_0 = 'thumbnail';
							$widget_thumbnail_1 = 'thumbnail';							
						}
						
						$i = 1;
						while($widget_query->have_posts()):
							$widget_query->the_post();
							
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
							
							switch($layout){
								case 'list-default':
									?>
									<div class="post-listing-item">
										<div class="post-img"><?php do_action('vidorev_thumbnail', $widget_thumbnail_1, 'class-1x1', 5, NULL); ?></div>
										<div class="post-content">
											<h3 class="h6 post-title"> 
												<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
											</h3>
											<?php do_action( 'vidorev_channel_sub_btn', get_the_ID(), ''); ?>
											<?php do_action( 'vidorev_posted_on', apply_filters( 'vidorev_widget_meta_arr', $df_post_metas, get_the_ID() ), 'widget' ); ?>												
										</div>
									</div>
									<?php
									break;
									
								case 'list-small-image':
									?>
									<div class="post-listing-item">
										<div class="post-img"><?php do_action('vidorev_thumbnail', $widget_thumbnail_0, 'class-1x1', 3, NULL); ?></div>
										<div class="post-content">
											<h3 class="h6 post-title"> 
												<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
											</h3>
											<?php do_action( 'vidorev_channel_sub_btn', get_the_ID(), ''); ?>
											<?php do_action( 'vidorev_posted_on', apply_filters( 'vidorev_widget_meta_arr', $df_post_metas, get_the_ID() ), 'widget' ); ?>												
										</div>
									</div>
									<?php
									break;
									
								case 'list-special':
									if($i==1){
									?>
										<div class="post-listing-item top-item">
											<div class="post-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_widget_list_special_image_big_size', 'vidorev_thumb_2point7x1_1x'), apply_filters('vidorev_custom_widget_list_special_image_big_ratio', 'class-2point7x1'), 3, NULL); ?></div>
											<div class="absolute-gradient"></div>										
											<div class="post-content dark-background overlay-background">
												<span class="item-number h1"><?php echo esc_html($i);?></span>											
												<h3 class="h5 post-title"> 
													<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
												</h3>
												<?php do_action( 'vidorev_posted_on', apply_filters( 'vidorev_widget_meta_arr', $df_post_metas, get_the_ID() ), 'widget' ); ?>												
											</div>
										</div>
									<?php
									}else{
									?>
										<div class="post-listing-item">
											<div class="post-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_widget_list_special_image_size', $widget_thumbnail_1), apply_filters('vidorev_custom_widget_list_special_image_ratio', 'class-1x1'), 3, NULL); ?><span class="item-number h3"><?php echo esc_html($i);?></span></div>
											<div class="post-content">
												<h3 class="h6 post-title"> 
													<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
												</h3>
												<?php do_action( 'vidorev_posted_on', apply_filters( 'vidorev_widget_meta_arr', $df_post_metas, get_the_ID() ), 'widget' ); ?>	
											</div>
										</div>
									<?php
									}
									break;
									
								case 'single-slider':
									?>
									<div class="post-listing-item">
										<div class="post-img"><?php $image_ratio_case = vidorev_image_ratio_case('1x');do_action('vidorev_thumbnail', 'vidorev_thumb_16x9_1x', 'class-16x9', 1, NULL, $image_ratio_case);?></div>
										<div class="post-content">
											<h3 class="h4 post-title"> 
												<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
											</h3>
											<?php do_action( 'vidorev_posted_on', apply_filters( 'vidorev_widget_meta_arr', $df_post_metas, get_the_ID() ), 'widget' ); ?>	
											<?php do_action( 'vidorev_excerpt_element' ); ?>
										</div>
									</div>
									<?php
									break;
									
								case 'list-wide':									
									?>
                                    <div class="post-listing-item top-item">
                                        <div class="post-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_widget_list_special_image_big_size', 'vidorev_thumb_2point7x1_1x'), apply_filters('vidorev_custom_widget_list_special_image_big_ratio', 'class-2point7x1'), 3, NULL); ?></div>
                                        <div class="absolute-gradient"></div>										
                                        <div class="post-content dark-background overlay-background">
                                            <span class="item-number h1"><?php echo esc_html($i);?></span>											
                                            <h3 class="h5 post-title"> 
                                                <a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
                                            </h3>
                                            <?php do_action( 'vidorev_posted_on', apply_filters( 'vidorev_widget_meta_arr', $df_post_metas, get_the_ID() ), 'widget' ); ?>												
                                        </div>
                                    </div>
                                
                            <?php
                                	break;
							}
							$i++;
							
							if( isset($post_type_add_param_to_url) && is_array($post_type_add_param_to_url) && ($series_id > 0 || $playlist_id > 0) ){
								$post_type_add_param_to_url = NULL;	
							}
						endwhile;
						?>
						</div>
					</div>	
				<?php	
				$output_string = ob_get_contents();
				ob_end_clean();		
				$widget_html.= $output_string;
				
				$widget_html.= $after_widget;
				
				echo apply_filters( 'vidorev_widget_posts_html', $widget_html );
			endif;
			wp_reset_postdata();
		}
	
		function update( $new_instance, $old_instance ) {
			$instance 					= $old_instance;
			$instance['title'] 			= esc_attr($new_instance['title']);
			$instance['layout'] 		= esc_attr($new_instance['layout']);
			$instance['post_type'] 		= esc_attr($new_instance['post_type']);
			$instance['link_to'] 		= esc_attr($new_instance['link_to']);
			$instance['category'] 		= esc_attr($new_instance['category']);
			$instance['tag'] 			= esc_attr($new_instance['tag']);
			$instance['ids'] 			= esc_attr($new_instance['ids']);
			$instance['order_by'] 		= esc_attr($new_instance['order_by']);
			$instance['post_count'] 	= esc_attr($new_instance['post_count']);
			return $instance;
		}
	
		function form( $instance ) {
			$val = array(
				'title' 				=> esc_html__('Posts', 'vidorev-extensions'),
				'layout' 				=> 'list-default',
				'post_type'				=> 'post',
				'link_to'				=> 'default',
				'category' 				=> '',			
				'tag' 					=> '',
				'ids' 					=> '',
				'order_by'				=> 'latest',
				'post_count' 			=> '5',			
			);
			
			$instance = wp_parse_args((array) $instance, $val);
			
			$title 				= esc_attr(trim($instance['title']));
			$layout 			= esc_attr(trim($instance['layout']));
			$post_type 			= esc_attr(trim($instance['post_type']));
			$link_to			= esc_attr(trim($instance['link_to']));
			$category 			= esc_attr(trim($instance['category']));
			$tag 				= esc_attr(trim($instance['tag']));
			$ids 				= esc_attr(trim($instance['ids']));
			$order_by 			= esc_attr(trim($instance['order_by']));
			$post_count 		= esc_attr(trim($instance['post_count']));
			
			ob_start();
			
			?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title'));?>"><?php echo esc_html__('Title', 'vidorev-extensions');?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title'));?>" name="<?php echo esc_attr($this->get_field_name('title'));?>" value="<?php echo esc_attr($title);?>">
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('layout'));?>"><?php echo esc_html__('Layout', 'vidorev-extensions');?></label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('layout'));?>" name="<?php echo esc_attr($this->get_field_name('layout'));?>">
					<option value="list-default"<?php if($layout=='list-default'){echo ' selected';}?>><?php echo esc_html__('List - Default', 'vidorev-extensions');?></option>
					<option value="list-small-image"<?php if($layout=='list-small-image'){echo ' selected';}?>><?php echo esc_html__('List - Small Image', 'vidorev-extensions');?></option>
					<option value="list-special"<?php if($layout=='list-special'){echo ' selected';}?>><?php echo esc_html__('List - Special', 'vidorev-extensions');?></option>
					<option value="single-slider"<?php if($layout=='single-slider'){echo ' selected';}?>><?php echo esc_html__('Single Slider', 'vidorev-extensions');?></option>
                    <option value="list-wide"<?php if($layout=='list-wide'){echo ' selected';}?>><?php echo esc_html__('List - Wide', 'vidorev-extensions');?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('post_type'));?>"><?php echo esc_html__('Post Type', 'vidorev-extensions');?>:</label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('post_type'));?>" name="<?php echo esc_attr($this->get_field_name('post_type'));?>">
					<option value="post"<?php if($post_type=='post'){echo ' selected';}?>><?php echo esc_html__('Post ( all posts )', 'vidorev-extensions');?></option>
					<option value="post-without-video"<?php if($post_type=='post-without-video'){echo ' selected';}?>><?php echo esc_html__('Post ( without video posts )', 'vidorev-extensions');?></option>
					<option value="post-video"<?php if($post_type=='post-video'){echo ' selected';}?>><?php echo esc_html__('Post - Video', 'vidorev-extensions');?></option>
					<option value="vid_playlist"<?php if($post_type=='vid_playlist'){echo ' selected';}?>><?php echo esc_html__('Playlist', 'vidorev-extensions');?></option>
					<option value="vid_channel"<?php if($post_type=='vid_channel'){echo ' selected';}?>><?php echo esc_html__('Channel', 'vidorev-extensions');?></option>
					<option value="vid_series"<?php if($post_type=='vid_series'){echo ' selected';}?>><?php echo esc_html__('Video Series', 'vidorev-extensions');?></option>				
				</select>
			</p>
            <p>
				<label for="<?php echo esc_attr($this->get_field_id('link_to'));?>"><?php echo esc_html__('Link To', 'vidorev-extensions');?>:</label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('link_to'));?>" name="<?php echo esc_attr($this->get_field_name('link_to'));?>">
                	<option value="default"<?php if($link_to=='default'){echo ' selected';}?>><?php echo esc_html__('Default', 'vidorev-extensions');?></option>
					<option value="playlist"<?php if($link_to=='playlist'){echo ' selected';}?>><?php echo esc_html__('Playlist', 'vidorev-extensions');?></option>
					<option value="series"<?php if($link_to=='series'){echo ' selected';}?>><?php echo esc_html__('Series', 'vidorev-extensions');?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('category'));?>"><?php echo esc_html__('Include categories, enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions');?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('category'));?>" name="<?php echo esc_attr($this->get_field_name('category'));?>" value="<?php echo esc_attr($category);?>">
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('tag'));?>"><?php echo esc_html__('Include tags, enter tag id or slug, eg: 19, 368, ...', 'vidorev-extensions');?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('tag'));?>" name="<?php echo esc_attr($this->get_field_name('tag'));?>" value="<?php echo esc_attr($tag);?>">
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('ids'));?>"><?php echo esc_html__('Include Posts, enter post id, eg: 1136, 2251, ...', 'vidorev-extensions');?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('ids'));?>" name="<?php echo esc_attr($this->get_field_name('ids'));?>" value="<?php echo esc_attr($ids);?>">
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('order_by'));?>"><?php echo esc_html__('Order by', 'vidorev-extensions');?>:</label>
				<select class="widefat" id="<?php echo esc_attr($this->get_field_id('order_by'));?>" name="<?php echo esc_attr($this->get_field_name('order_by'));?>">
					<option value="latest"<?php if($order_by=='latest'){echo ' selected';}?>><?php echo esc_html__('Latest', 'vidorev-extensions');?></option>
					<option value="most-commented"<?php if($order_by=='most-commented'){echo ' selected';}?>><?php echo esc_html__('Most commented', 'vidorev-extensions');?></option>
					<?php if(class_exists('Post_Views_Counter')){?>
						<option value="most-viewed-all-time"<?php if($order_by=='most-viewed-all-time'){echo ' selected';}?>><?php echo esc_html__('Most viewed of all time', 'vidorev-extensions');?></option>
						<option value="most-viewed-day"<?php if($order_by=='most-viewed-day'){echo ' selected';}?>><?php echo esc_html__('Most viewed of the day', 'vidorev-extensions');?></option>
						<option value="most-viewed-week"<?php if($order_by=='most-viewed-week'){echo ' selected';}?>><?php echo esc_html__('Most viewed of the week', 'vidorev-extensions');?></option>
						<option value="most-viewed-month"<?php if($order_by=='most-viewed-month'){echo ' selected';}?>><?php echo esc_html__('Most viewed of the month', 'vidorev-extensions');?></option>
						<option value="most-viewed-year"<?php if($order_by=='most-viewed-year'){echo ' selected';}?>><?php echo esc_html__('Most viewed of the year', 'vidorev-extensions');?></option>
					<?php }?>
					
					<?php if(class_exists('vidorev_like_dislike_settings')){?>
						<option value="most-liked-all-time"<?php if($order_by=='most-liked-all-time'){echo ' selected';}?>><?php echo esc_html__('Most liked of all time', 'vidorev-extensions');?></option>
						<option value="most-liked-day"<?php if($order_by=='most-liked-day'){echo ' selected';}?>><?php echo esc_html__('Most liked - Last one day', 'vidorev-extensions');?></option>
						<option value="most-liked-week"<?php if($order_by=='most-liked-week'){echo ' selected';}?>><?php echo esc_html__('Most liked - Last one week', 'vidorev-extensions');?></option>
						<option value="most-liked-month"<?php if($order_by=='most-liked-month'){echo ' selected';}?>><?php echo esc_html__('Most liked - Last one month', 'vidorev-extensions');?></option>
						<option value="most-liked-year"<?php if($order_by=='most-liked-year'){echo ' selected';}?>><?php echo esc_html__('Most liked - Last one year', 'vidorev-extensions');?></option>					
					<?php }?>
					
					<?php if(class_exists('Post_Views_Counter') && class_exists('vidorev_like_dislike_settings')){?>
						<option value="popular-view-like"<?php if($order_by=='popular-view-like'){echo ' selected';}?>><?php echo esc_html__('Popular Videos (Total Views Count + Like Count)', 'vidorev-extensions');?></option>
					<?php }?>
					
					<?php if(defined('CHANNEL_PM_PREFIX')){?>
						<option value="mostsubscribed"<?php if($order_by=='mostsubscribed'){echo ' selected';}?>><?php echo esc_html__('Most Subscribed (only for channels)', 'vidorev-extensions');?></option>
					<?php }?>
					
					<?php if(defined('YASR_LOG_TABLE')){?>
						<option value="highest_rated"<?php if($order_by=='highest_rated'){echo ' selected';}?>><?php echo esc_html__('Highest Rated (only for video Posts)', 'vidorev-extensions');?></option>
					<?php }?>	
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('post_count'));?>"><?php echo esc_html__('Post Count', 'vidorev-extensions');?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('post_count'));?>" name="<?php echo esc_attr($this->get_field_name('post_count'));?>" value="<?php echo esc_attr($post_count);?>">
			</p>
			<?php
			
			$output_string = ob_get_contents();
			ob_end_clean();
			
			echo apply_filters( 'vidorev_admin_widget_posts_html', $output_string );
		}
	}
endif;