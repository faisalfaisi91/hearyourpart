<article <?php post_class('post-item site__col'); ?>>
	<div class="post-item-wrap<?php echo esc_attr(apply_filters('vidorev_preview_control_class', '', get_the_ID(), get_post_type(), get_post_format()))?>">
		
		<div class="blog-pic">
			<div class="blog-pic-wrap">
				<?php 
				$image_ratio_case = vidorev_image_ratio_case('1x');
				do_action('vidorev_thumbnail', apply_filters('vidorev_custom_grid_modern_image_size', 'vidorev_thumb_4x3_1x', $layout), 'class-4x3', 2, NULL, $image_ratio_case);
				?>
			</div>
		</div>
		
		<div class="absolute-gradient"></div>
		
		<div class="listing-content dark-background overlay-background">
		
			<?php
			if($display_categories=='yes'){
				do_action( 'vidorev_category_element', NULL, 'archive' ); 
			}
			?>
			
			<h3 class="entry-title h5 h6-mobile post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>			
		
			<?php do_action( 'vidorev_posted_on', array($post_metas[0], $post_metas[1], $post_metas[2], $post_metas[3], $post_metas[4], $post_metas[5]), 'shortcode' ); ?>	
		
		</div>
	
	</div>
</article>