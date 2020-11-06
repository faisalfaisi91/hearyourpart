<?php
if(!function_exists('vidorev_page_slider')):
	function vidorev_page_slider(){
		$paged = get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);	
		if(!is_page() || $paged > 1){
			return;
		}
		
		$post_id = get_the_ID();
		
		$display_slider_group = get_post_meta($post_id, 'display_slider_group', true);
		$page_slider_settings = get_post_meta($post_id, 'page_slider_group', true);
		
		if(!is_array($page_slider_settings) || count($page_slider_settings)==0 || $display_slider_group!='yes'){
			return;
		}
		
		$i = 1;
		foreach ($page_slider_settings as $slider_item){
			
			$title = isset($slider_item['title'])?trim($slider_item['title']):'';
			$layout = isset($slider_item['layout'])?trim($slider_item['layout']):'';
			$post_type = isset($slider_item['post_type'])?trim($slider_item['post_type']):'';
			$category = isset($slider_item['category'])?trim($slider_item['category']):'';
			$tag = isset($slider_item['tag'])?trim($slider_item['tag']):'';
			$ex_category = (isset($slider_item['ex_category'])&&trim($slider_item['ex_category'])!='')?trim($slider_item['ex_category']):'';
			$ids = isset($slider_item['ids'])?trim($slider_item['ids']):'';
			$order_by = isset($slider_item['order_by'])?trim($slider_item['order_by']):'';
			$order = isset($slider_item['order'])?trim($slider_item['order']):'';
			$offset = isset($slider_item['offset'])?trim($slider_item['offset']):'';
			$post_count = isset($slider_item['post_count'])?trim($slider_item['post_count']):'';
			$display_categories = isset($slider_item['display_categories'])?trim($slider_item['display_categories']):'';
			$display_author = isset($slider_item['display_author'])?trim($slider_item['display_author']):'';
			$display_date = isset($slider_item['display_date'])?trim($slider_item['display_date']):'';
			$display_comment_count = isset($slider_item['display_comment_count'])?trim($slider_item['display_comment_count']):'';
			$display_view_count = isset($slider_item['display_view_count'])?trim($slider_item['display_view_count']):'';
			$display_like_count = isset($slider_item['display_like_count'])?trim($slider_item['display_like_count']):'';
			$display_dislike_count = isset($slider_item['display_dislike_count'])?trim($slider_item['display_dislike_count']):'';
			$autoplay = isset($slider_item['autoplay'])?trim($slider_item['autoplay']):'';
			$fade = isset($slider_item['fade'])?trim($slider_item['fade']):'';
			
			if($layout!='slider-4' && $layout!='slider-5' && $layout!='slider-9'){
				
				$padding_class = 'slider-col-padding';
				if($layout=='slider-6' || $layout=='slider-8'){
					$padding_class = 'slider-col-padding-m';
				}
				
				echo '<div class="site__container fullwidth-vidorev-ctrl page-slider-header medium-width-slider" id="header-slider-'.$i.'"><div class="site__row"><div class="site__col '.$padding_class.'">';
				
			}else{
				echo '<div class="page-slider-header full-width-slider" id="header-slider-'.$i.'">';
			}
				
				if($title!=''){
					echo '<div class="slider-header-title"><h2 class="h5 extra-bold">'.$title.'</h2></div>';
				}
				
				echo do_shortcode('[slider_sc 
										layout="'.$layout.'"
										post_type="'.$post_type.'"
										category="'.$category.'" 
										tag="'.$tag.'"
										ex_category="'.$ex_category.'" 
										ids="'.$ids.'" 
										order_by="'.$order_by.'" 
										order="'.$order.'" 
										offset="'.$offset.'"
										post_count="'.$post_count.'" 
										display_categories="'.$display_categories.'" 
										display_author="'.$display_author.'" 
										display_date="'.$display_date.'" 
										display_comment_count="'.$display_comment_count.'" 
										display_view_count="'.$display_view_count.'" 
										display_like_count="'.$display_like_count.'" 
										display_dislike_count="'.$display_dislike_count.'" 
										autoplay="'.$autoplay.'" 
										fade="'.$fade.'"
								]');
			if($slider_item['layout']!='slider-4' && $slider_item['layout']!='slider-5' && $slider_item['layout']!='slider-9'){
				echo '</div></div></div>';
			}else{
				echo '</div>';
			}
			
			$i++;					
		}
	}
endif;
add_action( 'vidorev_page_slider', 'vidorev_page_slider', 10 );