<?php
if(!class_exists('vidorev_youzer_shortcodes')){
	class vidorev_youzer_shortcodes {
		
		static function init(){
			add_shortcode('youzer_video_posts', array(__CLASS__, 'handle_shortcode_video'));
			add_shortcode('youzer_video_playlists', array(__CLASS__, 'handle_shortcode_playlist'));	
			add_shortcode('youzer_video_channels', array(__CLASS__, 'handle_shortcode_channel'));			
		}
		
		static function handle_shortcode_video($params, $contents=''){
			extract(
				shortcode_atts(
					array(						
						'layout'				=> '',						
					), 
					$params
				)				
			);
			
			$layout = (isset($params['layout'])&&trim($params['layout'])!='')?trim($params['layout']):'grid-small';	
			
			if(!function_exists('bp_displayed_user_id')){
				echo '';
				return;
			}
			
			
			$args_query = array(
				'post_type'				=> 'post',
				'posts_per_page' 		=> 30,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,	
				'author'				=> bp_displayed_user_id(),		
				'orderby'				=> 'date',
				'order'					=> 'desc',
				'tax_query' 			=> array(
												array(
													'taxonomy'  => 'post_format',
													'field'    	=> 'slug',
													'terms'     => array('post-format-video'),
													'operator'  => 'IN',
												),
											)		
			);	
			
			$videos_query 	= new WP_Query($args_query);				
			
			if($videos_query->have_posts()):
				$archive_style	= $layout;
				global $wp_query;
				$old_max_num_pages 			= $wp_query->max_num_pages;				
				$wp_query->max_num_pages 	= $videos_query->max_num_pages;
				
			?>	
				<div class="blog-wrapper bd-wrapper-videos global-blog-wrapper blog-wrapper-control">
					<script>vidorev_jav_js_object['query_vars'] = <?php echo json_encode($videos_query->query_vars);?>;</script>
					<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
						<?php									
							while($videos_query->have_posts()):
								$videos_query->the_post();			
								
								get_template_part( 'template-parts/content', $archive_style );
				
							endwhile;
						?>
					</div>
					<?php do_action('vidorev_pagination', 'template-parts/content', $archive_style, 'loadmore-btn');?>
				</div>
			<?php
				$wp_query->max_num_pages = $old_max_num_pages;	
			endif;
			wp_reset_postdata();
		}
		
		static function handle_shortcode_playlist($params, $contents=''){
			extract(
				shortcode_atts(
					array(						
						'layout'				=> '',						
					), 
					$params
				)				
			);
			
			$layout = (isset($params['layout'])&&trim($params['layout'])!='')?trim($params['layout']):'grid-modern';	
			
			if(!function_exists('bp_displayed_user_id')){
				echo '';
				return;
			}
			
			
			$args_query = array(
				'post_type'				=> 'vid_playlist',
				'posts_per_page' 		=> 30,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,	
				'author'				=> bp_displayed_user_id(),		
				'orderby'				=> 'date',
				'order'					=> 'desc',						
			);	
			
			$videos_query 	= new WP_Query($args_query);				
			
			if($videos_query->have_posts()):
				$archive_style	= $layout;
				global $wp_query;
				$old_max_num_pages 			= $wp_query->max_num_pages;				
				$wp_query->max_num_pages 	= $videos_query->max_num_pages;
				
			?>	
				<div class="blog-wrapper bd-wrapper-playlists global-blog-wrapper blog-wrapper-control">
					<script>vidorev_jav_js_object['query_vars'] = <?php echo json_encode($videos_query->query_vars);?>;</script>
					<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
						<?php									
							while($videos_query->have_posts()):
								$videos_query->the_post();			
								
								get_template_part( 'template-parts/content', $archive_style );
				
							endwhile;
						?>
					</div>
					<?php do_action('vidorev_pagination', 'template-parts/content', $archive_style, 'loadmore-btn');?>
				</div>
			<?php
				$wp_query->max_num_pages = $old_max_num_pages;	
			endif;
			wp_reset_postdata();
		}
		
		static function handle_shortcode_channel($params, $contents=''){
			extract(
				shortcode_atts(
					array(						
						'layout'				=> '',						
					), 
					$params
				)				
			);
			
			$layout = (isset($params['layout'])&&trim($params['layout'])!='')?trim($params['layout']):'grid-modern';	
			
			if(!function_exists('bp_displayed_user_id')){
				echo '';
				return;
			}
			
			
			$args_query = array(
				'post_type'				=> 'vid_channel',
				'posts_per_page' 		=> 30,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,	
				'author'				=> bp_displayed_user_id(),		
				'orderby'				=> 'date',
				'order'					=> 'desc',					
			);	
			
			$videos_query 	= new WP_Query($args_query);				
			
			if($videos_query->have_posts()):
				$archive_style	= $layout;
				global $wp_query;
				$old_max_num_pages 			= $wp_query->max_num_pages;				
				$wp_query->max_num_pages 	= $videos_query->max_num_pages;
				
			?>	
				<div class="blog-wrapper bd-wrapper-channels global-blog-wrapper blog-wrapper-control">
					<script>vidorev_jav_js_object['query_vars'] = <?php echo json_encode($videos_query->query_vars);?>;</script>
					<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
						<?php									
							while($videos_query->have_posts()):
								$videos_query->the_post();			
								
								get_template_part( 'template-parts/content', $archive_style );
				
							endwhile;
						?>
					</div>
					<?php do_action('vidorev_pagination', 'template-parts/content', $archive_style, 'loadmore-btn');?>
				</div>
			<?php
				$wp_query->max_num_pages = $old_max_num_pages;	
			endif;
			wp_reset_postdata();
		}		
	}
}

vidorev_youzer_shortcodes::init();

/*fix Youzer*/
if(!function_exists('vidorev_fix_youzer_bbPress')){
	function vidorev_fix_youzer_bbPress(){
		if(function_exists('yz_is_bbpress_active') && !yz_is_bbpress_active()){
			remove_filter('youzer_template', 'yz_bbp_youzer_template');
			remove_action('bp_init', 'yz_bbp_overload_templates');
			remove_action('wp_enqueue_scripts', 'yz_bbpress_scripts');
			remove_filter('yz_group_class', 'yz_group_create_forum_step_class');
			remove_action('yz_forum_sidebar', 'yz_get_forum_sidebar');
			remove_filter('bbp_no_breadcrumb', '__return_false', 20);
		}
	}
}

add_action('init', 'vidorev_fix_youzer_bbPress', 1);
/*fix Youzer*/

if(!function_exists('vidorev_fix_yz_add_image_attributes_lazy_loading') && !function_exists('vidorev_fix_yz_add_lazyloading_to_avatars')){
		
	function vidorev_fix_yz_add_image_attributes_lazy_loading( $img, $img_url ) {
		return "class='ul-lazysizes-load' data-src='$img_url'";
	}
	
	
	function vidorev_fix_yz_add_lazyloading_to_avatars( $html) {

		$html = str_replace( 'src="', 'data-src="', $html );
		$html = str_replace( 'class="', 'class="ul-lazysizes-load ', $html );
	
		return $html;
	}
	
}

add_action('init', function(){

	if(function_exists('yz_option') && yz_option( 'yz_lazy_load', 'on' ) == 'on' && vidorev_get_redux_option('lazyload', 'off', 'switch')=='on'){	
		remove_filter( 'yz_get_image_attributes', 'yz_add_image_attributes_lazy_loading', 10, 2 );
		remove_filter( 'bp_core_fetch_avatar', 'yz_add_lazyloading_to_avatars' );
		remove_filter( 'mycred_the_badge', 'yz_add_lazyloading_to_avatars' );
		
		add_filter( 'yz_get_image_attributes', 'vidorev_fix_yz_add_image_attributes_lazy_loading', 20, 2 );
		add_filter( 'bp_core_fetch_avatar', 'vidorev_fix_yz_add_lazyloading_to_avatars', 20, 1 );
		add_filter( 'mycred_the_badge', 'vidorev_fix_yz_add_lazyloading_to_avatars', 20, 1 );
	}
	
}, 20, 1);