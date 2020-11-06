<article id="post-<?php the_ID(); ?>" <?php post_class('post-item site__col'); ?>>
	<div class="post-item-wrap">
	
		<?php 
		$image_ratio_case = vidorev_image_ratio_case('1x');
		do_action('vidorev_thumbnail', apply_filters('vidorev_custom_grid_content_default_archive_image_size', 'vidorev_thumb_16x9_1x'), apply_filters('vidorev_custom_grid_content_default_archive_image_ratio', 'class-16x9'), 1, NULL, $image_ratio_case);
		?>
		
		<div class="listing-content">
			
			<?php do_action( 'vidorev_category_element', NULL, 'archive' ); ?>
			
			<h3 class="entry-title h3 post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>
			
			<?php do_action( 'vidorev_posted_on', array('author', 'date-time'), 'archive' ); ?>	
		
			<?php do_action( 'vidorev_excerpt_element' ); ?>
		
			<?php do_action( 'vidorev_posted_on', array('', '', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'archive' ); ?>		
		
		</div>
		
	</div>
</article>