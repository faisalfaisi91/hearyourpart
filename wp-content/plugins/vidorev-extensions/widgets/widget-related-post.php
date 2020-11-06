<?php
if(!class_exists('vidorev_widget_related_posts')):
	class vidorev_widget_related_posts extends WP_Widget {
	
		function __construct() {
			
			parent::__construct( 'vidorev_related_posts', esc_html__('VidoRev - Related Posts', 'vidorev-extensions'), array('classname' => 'vidorev-related-posts-extensions') );
		}	
			
		function widget( $args, $instance ) {
			extract($args);
			
			if(!is_singular('post')){
				return;
			}
			
			$post_id			= get_the_ID();
			
			$title 				= isset($instance['title'])?trim($instance['title']):'';
			$items_page 		= isset($instance['items_page'])?trim($instance['items_page']):3;
			$post_count 		= isset($instance['post_count'])?trim($instance['post_count']):15;
			
			$single_post_related_query = vidorev_get_redux_option('single_post_related_query',  'same-category');
			$single_post_related_order = vidorev_get_redux_option('single_post_related_order',  'latest');	
			
			$post_type = 'post';
			
			switch($single_post_related_query){
				case 'same-category':
					
					$categories = array();
					$post_categories = get_the_category($post_id);				
					if ( ! empty( $post_categories ) && count($post_categories) > 0) {
						foreach( $post_categories as $category ) {						
							array_push($categories, $category->term_id);
						}  
						
						$category__in =  $categories;
					}
								
					break;
					
				case 'same-tag':
					
					$tags = array();
					$post_tags = wp_get_post_tags( $post_id );
					
					if ( ! empty( $post_tags ) && count($post_tags) > 0) {
						foreach( $post_tags as $tag ) {						
							array_push($tags, $tag->term_id);
						}  
						
						$tag__in =  $tags;
					}
					
					break;	
			}	
			
			$sc_params = '';			
			$sc_params.= ' ex_ids="'.$post_id.'"';
				
			if(isset($category__in)){
				$sc_params.= ' category="'.implode(',', $category__in).'"';
			}
			
			if(isset($tag__in)){
				$sc_params.= ' tag="'.implode(',', $tag__in).'"';
			}
			
			$sc_params.=' order="DESC"';
			$sc_params.=' items_per_page="'.$items_page.'"';
			$sc_params.=' post_count="'.$post_count.'"';
			
			switch($single_post_related_order){
				case 'latest':
					$sc_params.=' order_by="date"';
					break;
					
				case 'most-viewed':
					$sc_params.=' order_by="view"';
					break;
					
				case 'most-liked':
					$sc_params.=' order_by="like"';
					break;
					
				case 'random':
					$sc_params.=' order_by="rand"';
					break;			
			}
			
			$widget_html 	= '';			
			$rl_content 	= do_shortcode('[block_sc layout="widget-list-df"'.$sc_params.']');			
			
			if(trim($rl_content)!=''){				
				$widget_html.= $before_widget;
				$widget_html.= $before_title . $title . $after_title;	
				$widget_html.= '<div class="vp-widget-post-layout related-posts-layout">';			
					$widget_html.= $rl_content; 
				$widget_html.= '</div>';
				$widget_html.= $after_widget;
				echo apply_filters( 'vidorev_widget_related_posts_html', $widget_html );
			}
		}
	
		function update( $new_instance, $old_instance ) {
			$instance 					= $old_instance;
			$instance['title'] 			= esc_attr($new_instance['title']);	
			$instance['items_page'] 	= esc_attr($new_instance['items_page']);	
			$instance['post_count'] 	= esc_attr($new_instance['post_count']);
			return $instance;
		}
	
		function form( $instance ) {
			$val = array(
				'title' 				=> esc_html__('Related Posts', 'vidorev-extensions'),
				'items_page' 			=> 3,
				'post_count' 			=> 15,				
			);
			
			$instance = wp_parse_args((array) $instance, $val);
			
			$title 				= esc_attr(trim($instance['title']));
			$items_page 		= esc_attr(trim($instance['items_page']));
			$post_count 		= esc_attr(trim($instance['post_count']));			
			
			ob_start();
			
				?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('title'));?>"><?php echo esc_html__('Title', 'vidorev-extensions');?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title'));?>" name="<?php echo esc_attr($this->get_field_name('title'));?>" value="<?php echo esc_attr($title);?>">
				</p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('items_page'));?>"><?php echo esc_html__('Items Per Page', 'vidorev-extensions');?></label>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('items_page'));?>" name="<?php echo esc_attr($this->get_field_name('items_page'));?>" value="<?php echo esc_attr($items_page);?>">
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('post_count'));?>"><?php echo esc_html__('Post Count', 'vidorev-extensions');?></label>
                    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('post_count'));?>" name="<?php echo esc_attr($this->get_field_name('post_count'));?>" value="<?php echo esc_attr($post_count);?>">
                </p>
				<?php
			
			$output_string = ob_get_contents();
			ob_end_clean();
			
			echo apply_filters( 'vidorev_admin_widget_related_posts_html', $output_string );
		}
	}
endif;