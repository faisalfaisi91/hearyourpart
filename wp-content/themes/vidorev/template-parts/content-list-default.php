<article id="post-<?php the_ID(); ?>" <?php post_class('post-item site__col'); ?>>
	<?php 
	$is_sticky = is_sticky();
		
	if($is_sticky){
	?>
		<div class="sticky-container">
			<div class="sticky-row">
				<div class="sticky-col sticky-line">
					<span></span>
				</div>
				<div class="sticky-col sticky-text">
					<span class="font-size-12"><?php esc_html_e('Sticky post', 'vidorev');?></span>
				</div>
				<div class="sticky-col sticky-line">
					<span></span>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<div class="post-item-wrap">
	
		<?php 
		$image_ratio_case = vidorev_image_ratio_case('1x');
		do_action('vidorev_thumbnail', apply_filters('vidorev_custom_list_default_archive_image_size', 'vidorev_thumb_16x9_1x'), apply_filters('vidorev_custom_list_default_archive_image_ratio', 'class-16x9'), 1, NULL, $image_ratio_case);
		?>
		
		<div class="listing-content">
			
			<?php do_action( 'vidorev_category_element', NULL, 'archive' ); ?>
			
			<h3 class="entry-title h3 post-title"> 
				<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
			</h3>
			
			<?php 
			if(!defined('VIDOREV_EXTENSIONS')){
				do_action( 'vidorev_posted_on', array('author', 'date-time', 'comment-count'), 'archive' ); 
			}else{
				do_action( 'vidorev_posted_on', array('author', 'date-time'), 'archive' ); 
			}
			?>	
		
			<?php do_action( 'vidorev_excerpt_element' ); ?>
		
			<?php 
			if(defined('VIDOREV_EXTENSIONS')){			
				do_action( 'vidorev_posted_on', array('', '', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'archive' ); 
			}
			?>		
		
		</div>
		
	</div>
	<?php 
	if($is_sticky){
	?>
		<div class="sticky-container">
			<div class="sticky-row">
				<div class="sticky-col sticky-line">
					<span></span>
				</div>
				<div class="sticky-col sticky-text">
					<span><i class="fa fa-bolt" aria-hidden="true"></i></span>
				</div>
				<div class="sticky-col sticky-line">
					<span></span>
				</div>
			</div>
		</div>
	<?php
	}
	?>
</article>