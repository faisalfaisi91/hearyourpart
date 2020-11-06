<article class="post-item">
	<div class="post-item-wrap<?php echo esc_attr(apply_filters('vidorev_preview_control_class', '', get_the_ID(), get_post_type(), get_post_format()))?>">
		
		<div class="blog-pic">
			<div class="blog-pic-wrap">
				<?php 
				do_action('vidorev_thumbnail', 'vidorev_thumb_4x3_2x', 'class-4x3', 2, NULL, NULL);							
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
			<h3 class="entry-title h2 h5-mobile h5-small-desktop post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>	
			<?php
			do_action( 'vidorev_posted_on', $post_metas, 'shortcode' );
			
			?>				
		</div>
	
	</div>
</article>