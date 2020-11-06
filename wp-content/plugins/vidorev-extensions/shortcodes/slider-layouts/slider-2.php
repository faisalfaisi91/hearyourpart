<?php 
if($z == 6){
	$z=1;
}
if($i == 1){	
?>
	<div class="slide-item">
		<div class="slide-body">
<?php
}
	if($z == 1){
		ob_start();		
	?>
		<div class="large-items-col">
	<?php
	}
	
	if($z == 2){
	?>
		<div class="small-items-col">
	<?php	
	}
	
	if($z == 4){
	?>
		<div class="small-items-col">
	<?php	
	}
?>
			<article class="post-item">
				<div class="post-item-wrap<?php echo esc_attr(apply_filters('vidorev_preview_control_class', '', get_the_ID(), get_post_type(), get_post_format()))?>">
					
					<div class="blog-pic">
						<div class="blog-pic-wrap">
							<?php 
							if($z == 1){
								do_action('vidorev_thumbnail', 'vidorev_thumb_4x3_1point5x', 'class-4x3', 2, NULL, NULL);
							}else{
								do_action('vidorev_thumbnail', 'vidorev_thumb_4x3_0point5x', 'class-4x3', 2, NULL, NULL);
							}
							?>
						</div>
					</div>
					
					<div class="absolute-gradient"></div>
					
					<div class="listing-content dark-background overlay-background">
						<?php
						if($z == 1){
							if($display_categories=='yes'){
								do_action( 'vidorev_category_element', NULL, 'archive' );
							}
							?>
							<h3 class="entry-title h2 h5-mobile post-title"> 
								<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
							</h3>	
							<?php
							do_action( 'vidorev_posted_on', $post_metas, 'shortcode' );
						}else{
						?>
							<h3 class="entry-title h5 post-title"> 
								<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
							</h3>	
						<?php
						}
						?>				
					</div>
				
				</div>
			</article>


<?php 
	if($z == 1 || ($i == $totalCountPosts && $z <= 1)){
	?>
		</div>
	<?php
		$output_string = ob_get_contents();
		ob_end_clean();
		
		if($i == $totalCountPosts && $z <= 1){
			echo $output_string;
		}
	}
	
	if($z == 3 || ($i == $totalCountPosts && $z <= 3 && $z > 1)){
	?>
		</div>
	<?php
		echo $output_string;
	}
	
	if($z == 5 || ($i == $totalCountPosts && $z >= 4)){		
	?>
		</div>
	<?php
	}
if($i % 5 == 0 && $i < $totalCountPosts){	
?>
		</div>	
	</div>
	<div class="slide-item">
		<div class="slide-body">
<?php 
}

if($i == $totalCountPosts){
?>
		</div>
	</div>
<?php 
}
?>