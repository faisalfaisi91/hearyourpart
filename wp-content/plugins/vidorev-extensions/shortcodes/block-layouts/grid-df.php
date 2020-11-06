<article <?php post_class('post-item site__col'); ?>>
	<div class="post-item-wrap">
	
		<?php
		$image_ratio_case = vidorev_image_ratio_case('1x');
		do_action('vidorev_thumbnail', apply_filters('vidorev_custom_grid_default_image_size', 'vidorev_thumb_16x9_1x', $layout), 'class-16x9', 1, NULL, $image_ratio_case); 
		?>
		
		<div class="listing-content">
			
			<?php
			if($display_categories=='yes'){
				do_action( 'vidorev_category_element', NULL, 'archive' ); 
			}
			?>
			
			<h3 class="entry-title h3 post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>	
			
			<?php do_action( 'vidorev_posted_on', array($post_metas[0], $post_metas[1]), 'shortcode' ); ?>	
		
			<?php do_action( 'vidorev_excerpt_element' ); ?>
		
			<?php do_action( 'vidorev_posted_on', array('', '', $post_metas[2], $post_metas[3], $post_metas[4], $post_metas[5]), 'shortcode' ); ?>		
		
		</div>
		
	</div>
</article>