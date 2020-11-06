<article class="post-item">
	<div class="post-item-wrap">
	
		<?php
		$image_ratio_case = vidorev_image_ratio_case('1x'); 
		do_action('vidorev_thumbnail', 'vidorev_thumb_16x9_1x', 'class-16x9', 1, NULL, $image_ratio_case); 
		?>
		
		<div class="listing-content">
			
			<?php 
			if($display_categories=='yes'){	
				do_action( 'vidorev_category_element', NULL, 'archive' ); 
			}
			?>
			
			<h3 class="entry-title h5 post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>
		
			<?php do_action( 'vidorev_posted_on', $post_metas, 'shortcode' ); ?>		
		
		</div>
		
	</div>
</article>