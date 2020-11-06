<article class="post-item">
	<div class="post-item-wrap">
	
		<div class="post-img"><?php do_action('vidorev_thumbnail', 'vidorev_thumb_1x1_1x', 'class-1x1', 5, NULL); ?></div>
		
		<div class="post-content">
			
			<h3 class="entry-title h6 post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>
		
			<?php do_action( 'vidorev_posted_on', $post_metas, 'shortcode' ); ?>		
		
		</div>
		
	</div>
</article>