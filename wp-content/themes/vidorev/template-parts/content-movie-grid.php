<article id="post-<?php the_ID(); ?>" <?php post_class('post-item site__col'); ?>>
	<div class="post-item-wrap">
	
		<?php 
		$image_ratio_case = vidorev_image_ratio_case('0x');
		do_action('vidorev_thumbnail', apply_filters('vidorev_custom_movie_grid_archive_image_size', 'vidorev_thumb_2x3_0x'), apply_filters('vidorev_custom_movie_grid_archive_image_ratio', 'class-2x3'), 1, NULL, $image_ratio_case, 1);
		?>
		
		<div class="listing-content">
			
			<?php do_action( 'vidorev_category_element', NULL, 'archive' ); ?>
			
			<h3 class="entry-title h5 h6-mobile post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>			
			
			<?php do_action( 'vidorev_posted_on', array('', '', '', 'view-count', 'like-count', ''), 'archive' ); ?>	
		</div>
		
	</div>
</article>