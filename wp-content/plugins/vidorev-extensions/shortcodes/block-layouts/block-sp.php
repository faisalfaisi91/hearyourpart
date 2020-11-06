<?php 
if($i==1){	
?>
	<div class="block-big-items">
		<article <?php post_class('post-item site__col'); ?>>
			<div class="post-item-wrap<?php echo esc_attr(apply_filters('vidorev_preview_control_class', '', get_the_ID(), get_post_type(), get_post_format()))?>">
				
				<div class="blog-pic">
					<div class="blog-pic-wrap">
						<?php 
						$title_class = 'h2 h5-mobile';
						if($layout=='block-sp-3'){
							$image_ratio_case = vidorev_image_ratio_case('1x');
							do_action('vidorev_thumbnail', apply_filters('vidorev_custom_block_special_sp3_image_size', 'vidorev_thumb_4x3_1x', $layout), apply_filters('vidorev_custom_block_special_sp3_image_ratio', 'class-4x3', $layout), 2, NULL, apply_filters('vidorev_custom_block_special_sp3_image_ratio_case', $image_ratio_case, $layout));
							$title_class = 'h5 h6-mobile';
						}elseif($layout=='block-sp-2'){
							$image_ratio_case = vidorev_image_ratio_case('2x');
							do_action('vidorev_thumbnail', apply_filters('vidorev_custom_block_special_sp2_image_size', 'vidorev_thumb_4x3_2x', $layout), apply_filters('vidorev_custom_block_special_sp2_image_ratio', 'class-4x3', $layout), 2, NULL, apply_filters('vidorev_custom_block_special_sp2_image_ratio_case', $image_ratio_case, $layout));
						}else{
							$image_ratio_case = vidorev_image_ratio_case('3x');
							do_action('vidorev_thumbnail', apply_filters('vidorev_custom_block_special_sp1_image_size', 'vidorev_thumb_4x3_3x', $layout), apply_filters('vidorev_custom_block_special_sp1_image_ratio', 'class-4x3', $layout), 2, NULL, apply_filters('vidorev_custom_block_special_sp1_image_ratio_case', $image_ratio_case, $layout));
						}
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
					
					<h3 class="entry-title post-title <?php echo esc_attr($title_class);?>"> 
						<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
					</h3>			
				
					<?php do_action( 'vidorev_posted_on', array($post_metas[0], $post_metas[1], $post_metas[2], $post_metas[3], $post_metas[4], $post_metas[5]), 'shortcode' ); ?>	
				
				</div>
			
			</div>
		</article>
	</div>
<?php 
}else{
	if($i==2){
	?>
        <div class="block-small-items">
    <?php
	}
?>
			<article class="post-item">
				<div class="post-item-wrap">
				
					<div class="post-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_block_special_image_size', 'vidorev_thumb_1x1_1x', $layout), apply_filters('vidorev_custom_block_special_image_ratio', 'class-1x1', $layout), 5, NULL); ?></div>
					
					<div class="post-content">
						
						<h3 class="entry-title h6 post-title"> 
							<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
						</h3>
					
						<?php do_action( 'vidorev_posted_on', array($post_metas[0], $post_metas[1], '', '', '', ''), 'shortcode' ); ?>
					
					</div>
					
				</div>
			</article>

<?php
	if($i==$allItemsPerPage || ($dataPaged==$paged_calculator && $i==$percentItems)){
	?>        	
        </div>
    <?php
	}
}
?>