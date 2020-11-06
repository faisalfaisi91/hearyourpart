<article <?php post_class('post-item site__col'); ?>>
	<div class="post-item-wrap">
	
		<?php 
		$image_ratio_case = vidorev_image_ratio_case('0x');
		do_action('vidorev_thumbnail', 'vidorev_thumb_2x3_0x', 'class-2x3', 1, NULL, $image_ratio_case);
		?>
		
		<div class="listing-content">
			
			<?php
			if($display_categories=='yes'){
				do_action( 'vidorev_category_element', NULL, 'archive' ); 
			}
			?>
			
			<h3 class="entry-title h3 h6-mobile post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>
			
			<?php do_action( 'vidorev_posted_on', array($post_metas[0], $post_metas[1], $post_metas[2], $post_metas[3], $post_metas[4], $post_metas[5]), 'shortcode' ); ?>		
		
			<?php do_action( 'vidorev_excerpt_element' ); ?>
			
			<?php do_action ( 'vidorev_director_html', 3 );?>
			<?php do_action ( 'vidorev_actor_html', 3 );?>
			
			<?php do_action ( 'vidorev_IMDb_ratings_html' );?>
		
		</div>
		
	</div>
</article>