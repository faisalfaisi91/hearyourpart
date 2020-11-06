<?php do_action('vidorev_below_single_content_ads');?>
<div class="post-footer">
	<?php
	$post_id							= get_the_ID();
	$post_type 							= get_post_type($post_id);
	$post_format 						= get_post_format($post_id);
	$enable_like_dislike 				= vidorev_get_option('lk_enable_sys', 'like_dislike_settings', 'yes');
	$single_post_footer_like_dislike 	= (vidorev_get_redux_option('single_post_footer_like_dislike', 'on', 'switch')=='on' && function_exists('vidorev_display_like_button'))?true:false;
	$single_post_social_share 			= (vidorev_get_redux_option('single_post_social_share', 'off', 'switch')=='on' && function_exists('vidorev_social_sharing'))?true:false;
	$posttags 							= get_the_tags();
	$single_post_tags 					= ($posttags && vidorev_get_redux_option('single_post_tags', 'on', 'switch')=='on')?true:false;
	
	if(($enable_like_dislike=='yes' && $single_post_footer_like_dislike) || $single_post_social_share){
	?>
	<div class="like-dislike-toolbar-footer">
		<?php if($enable_like_dislike=='yes' && $single_post_footer_like_dislike){?>
			<div class="ld-t-footer-wrapper"><?php if(function_exists('vidorev_display_like_button')){echo vidorev_display_like_button($post_id, '2');}if(function_exists('vidorev_display_dislike_button')){echo vidorev_display_dislike_button($post_id, '2');}?></div>
		<?php }
		
		if($single_post_social_share){
		?>
		<div class="ld-t-footer-sharing">
			<?php vidorev_social_sharing($post_id);?>
		</div>
		<?php }?>
	</div>
	<?php
	}
	
	if($single_post_tags){
	?>
		<div class="tags-socialsharing">
			
			<div class="tags-items">
				<span class="tag-title"><i class="fa fa-tags" aria-hidden="true"></i> <span class="h5 extra-bold"><?php echo esc_html__('Tags', 'vidorev');?></span></span>
				<?php
				foreach($posttags as $tag) {
					echo '<a href="'.esc_url(get_tag_link($tag->term_id)).'" title="'.esc_attr($tag->name).'" class="tag-item font-size-12">'.esc_html($tag->name).'</a>'; 
				}		
				?>
			</div>
				
		</div>
	<?php
	}
		
	if(vidorev_get_redux_option('single_post_nav', 'on', 'switch')=='on' && $post_type != 'vid_actor' && $post_type != 'vid_director' && $post_type != 'vid_channel'){		
		
		$previous_post_text = esc_html__('Previous Post', 'vidorev');
		$next_post_text 	= esc_html__('Next Post', 'vidorev');
		
		$default_next_prev = 'default';
		
		switch($post_type){
			case 'post':
				if($post_format == 'video'){
					$previous_post_text = esc_html__('Previous Video', 'vidorev');
					$next_post_text 	= esc_html__('Next Video', 'vidorev');
					
					$default_next_prev = 'video';
				}
				break;
			
			case 'vid_playlist':
				$previous_post_text = esc_html__('Previous Playlist', 'vidorev');
				$next_post_text 	= esc_html__('Next Playlist', 'vidorev');
				break;
				
			case 'vid_channel':
				$previous_post_text = esc_html__('Previous Channel', 'vidorev');
				$next_post_text 	= esc_html__('Next Channel', 'vidorev');
				break;	
				
			case 'vid_series':
				$previous_post_text = esc_html__('Previous Series', 'vidorev');
				$next_post_text 	= esc_html__('Next Series', 'vidorev');
				break;	
		}
		
		if($default_next_prev == 'video'){
			$prevPost = vidorev_get_adjacent_video_by_id( get_the_ID(), true );
			$nextPost = vidorev_get_adjacent_video_by_id( get_the_ID());
			
			if($prevPost > 0){
				$prevPost = (object)array('ID' => $prevPost);
			}else{
				$prevPost = false;
			}
			
			if($nextPost > 0){
				$nextPost = (object)array('ID' => $nextPost);
			}else{
				$nextPost = false;
			}
			
		}else{
			$prevPost = ( is_attachment() ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true ) );
			$nextPost = get_adjacent_post( false, '', false );
		}
		
		if($prevPost || $nextPost){	
		$post_prev_next_thumb_0 = 'vidorev_thumb_1x1_0x';
		if(!defined('VIDOREV_EXTENSIONS')){
			$post_prev_next_thumb_0 = 'thumbnail';
		}	
		?>
		<div class="single-post-nav">
			<div class="single-post-nav-items">
		<?php	
			if($prevPost){
				$prev_post_id = $prevPost->ID;
	?>
				<div class="single-post-nav-item prev-item">
					<div class="item-text navigation-font"><a class="neutral" href="<?php echo esc_url(vidorev_get_post_url($prev_post_id)); ?>" title="<?php echo esc_attr(get_the_title($prev_post_id)); ?>"><?php echo esc_html($previous_post_text);?></a></div>
					<div class="post-listing-item">
						<div class="post-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_prev_next_single_post_image_size', $post_prev_next_thumb_0), apply_filters('vidorev_custom_prev_next_single_post_image_ratio', 'class-1x1'), 3, $prev_post_id); ?></div>
						<div class="post-content">
							<h3 class="h6 post-title"> 
								<a href="<?php echo esc_url(vidorev_get_post_url($prev_post_id)); ?>" title="<?php echo esc_attr(the_title_attribute(array('echo'=>0, 'post'=>$prev_post_id)));?>"><?php echo esc_html(get_the_title($prev_post_id));?></a> 
							</h3>						
						</div>
					</div>	
				</div>		
			<?php
			}
			if($nextPost){
				$next_post_id = $nextPost->ID;
			?>
				<div class="single-post-nav-item next-item">
					<div class="item-text navigation-font"><a class="neutral" href="<?php echo esc_url(vidorev_get_post_url($next_post_id)); ?>" title="<?php echo esc_attr(get_the_title($next_post_id)); ?>"><?php echo esc_html($next_post_text);?></a></div>
					<div class="post-listing-item">	
						<div class="post-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_prev_next_single_post_image_size', $post_prev_next_thumb_0), apply_filters('vidorev_custom_prev_next_single_post_image_ratio', 'class-1x1'), 3, $next_post_id); ?></div>
						<div class="post-content">
							<h3 class="h6 post-title"> 
								<a href="<?php echo esc_url(vidorev_get_post_url($next_post_id)); ?>" title="<?php echo esc_attr(the_title_attribute(array('echo'=>0, 'post'=>$next_post_id)));?>"><?php echo esc_html(get_the_title($next_post_id));?></a> 
							</h3>						
						</div>
					</div>	
				</div>
	<?php
			}
		?>
			</div>
		</div>
		<?php	
		}
	}
	
	if(vidorev_get_redux_option('single_post_author', 'off', 'switch')=='on' && $post_type != 'vid_actor' && $post_type != 'vid_director' && $post_type != 'vid_channel' && (vidorev_single_video_style()=='' || vidorev_single_video_style()=='basic')){
	?>
	<div class="author-box">
		<div class="author-box-body">
			<div class="author-box-avatar">
				<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>" class="author-avatar">
					<?php echo get_avatar( get_the_author_meta('email'), 130 ); ?>
            	</a>
			</div>
			<div class="author-box-content">
				<h4 class="author-name h5 extra-bold"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"><?php the_author_meta( 'display_name' ); ?></a></h4>
				<div class="author-des"><?php the_author_meta('description'); ?></div>
				<?php do_action('vidorev_author_social_follow');?>
			</div>
		</div>
	</div>
	<?php }?>
</div>
<?php
if(vidorev_get_redux_option('single_post_related', 'off', 'switch')=='on' && $post_type != 'vid_actor' && $post_type != 'vid_director' && $post_type != 'vid_playlist' && $post_type != 'vid_channel' && $post_type != 'vid_series'){

	$single_post_related_title = vidorev_get_redux_option('single_post_related_title',  esc_html__('Related posts', 'vidorev'));
	if($post_format == 'video'){
		$single_post_related_title = apply_filters( 'vidorev_single_related_title', esc_html__('Related videos', 'vidorev') );
	}
	
	$single_post_related_query = vidorev_get_redux_option('single_post_related_query',  'same-category');
	$single_post_related_format = vidorev_get_redux_option('single_post_related_format', 'off', 'switch');
	$single_post_related_order = vidorev_get_redux_option('single_post_related_order',  'latest');
	$single_post_related_count = vidorev_get_redux_option('single_post_related_count',  '6');

	if(!$post_type){
		$post_type = 'post';
	}
	
	$related_query = array(
		'post_type'             => $post_type,
		'post_status'           => 'publish',
		'posts_per_page'        => $single_post_related_count,			
		'post__not_in'          => array($post_id),
		'ignore_sticky_posts'   => 1,
	);
	
	switch($single_post_related_order){
		case 'latest':
			$related_query['order'] 	= 'DESC';
			$related_query['orderby'] 	= 'date';
			break;
			
		case 'most-viewed':
			if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
				vidorev_like_view_sorting::vidorev_add_ttt_9();
			}
			break;
			
		case 'most-liked':
			if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
				vidorev_like_view_sorting::vidorev_add_ttt_10();
			}
			break;
			
		case 'random':
			$related_query['orderby'] 	= 'rand';
			break;			
	}
	
	switch($single_post_related_query){
		case 'same-category':
			
			$categories = array();
			$post_categories = get_the_category($post_id);				
			if ( ! empty( $post_categories ) && count($post_categories) > 0) {
				foreach( $post_categories as $category ) {						
					array_push($categories, $category->term_id);
				}  
				
				$related_query['category__in'] =  $categories;
			}
						
			break;
			
		case 'same-tag':
			
			$tags = array();
			$post_tags = wp_get_post_tags( $post_id );
			
			if ( ! empty( $post_tags ) && count($post_tags) > 0) {
				foreach( $post_tags as $tag ) {						
					array_push($tags, $tag->term_id);
				}  
				
				$related_query['tag__in'] =  $tags;
			}
			
			break;	
	}
	
	if($single_post_related_format == 'on'){
		$related_query['tax_query'] = array(
			array(
			'taxonomy'  => 'post_format',
			'field'    	=> 'slug',
			'terms'     => array('post-format-video'),
			'operator'  => 'IN',
		));
	}
	
	$related_query_action = new WP_Query($related_query);
	
	switch($single_post_related_order){
		case 'most-viewed':
			if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
				vidorev_like_view_sorting::vidorev_remove_ttt_9();
			}
			break;
			
		case 'most-liked':
			if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
				vidorev_like_view_sorting::vidorev_remove_ttt_10();
			}
			break;			
	}
	
	if($related_query_action->have_posts()):
		?>
		<div class="single-related-posts">
			<h3 class="related-header h5 extra-bold"><?php echo esc_html(($single_post_related_title!=''?$single_post_related_title:__('RELATED POSTS', 'vidorev')));?></h3>
			<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
				<div class="blog-items blog-items-control site__row grid-default">
		<?php	
		while($related_query_action->have_posts()):
			$related_query_action->the_post();			
			
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('post-item site__col'); ?>>
				<div class="post-item-wrap">
				
					<?php 
					$image_ratio_case = vidorev_image_ratio_case('1x');
					do_action('vidorev_thumbnail', apply_filters('vidorev_custom_single_related_posts_image_size', 'vidorev_thumb_16x9_0x'), apply_filters('vidorev_custom_single_related_posts_image_ratio', 'class-16x9'), 1, NULL, $image_ratio_case); 
					?>
					
					<div class="listing-content">
						
						<h3 class="entry-title h6 post-title"> 
							<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
						</h3>	
						
						<?php do_action( 'vidorev_posted_on', array('author', 'date-time'), 'archive' ); ?>	
						<?php do_action( 'vidorev_posted_on', array('', '', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'archive' ); ?>		
					
					</div>
					
				</div>
			</article>
			<?php

		endwhile;
		?>
				</div>
			</div>
		</div>
		<?php
	endif;
	
	wp_reset_postdata();
}
?>