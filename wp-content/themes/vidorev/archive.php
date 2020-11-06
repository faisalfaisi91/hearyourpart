<?php
get_header(); 
$sidebarControl = vidorev_sidebar_control();
?>

<div id="primary-content-wrap" class="primary-content-wrap">
	<div class="primary-content-control">
		<div class="site__container fullwidth-vidorev-ctrl container-control">
			
			<?php do_action( 'vidorev_nav_breadcrumbs' );?>
			
			<div class="site__row sidebar-direction">							
				<main id="main-content" class="site__col main-content">	
					
                    <?php do_action( 'vidorev_above_channel_ads' );?>
                    
					<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
						<?php
						$archive_style = vidorev_archive_style();	
						do_action( 'vidorev_archive_heading', $archive_style );
						do_action( 'vidorev_archive_alphabet_filter', $archive_style );
						$category_description = trim(category_description());
						if($category_description!='' && vidorev_get_redux_option('caterory_desc_post', 'top') == 'top'){
						?>
							<div class="archive-cat-desc top-lc">
								<?php echo wp_kses_post($category_description);?>
							</div>
						<?php
						}
						if ( have_posts() ) :								
						?>
							<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
								<?php									
									while ( have_posts() ) : the_post();			
										if($archive_style!='movie-grid'){			
											do_action('vidorev_between_post_content_ads');
										}
										get_template_part( 'template-parts/content', $archive_style );
						
									endwhile;
								?>
							</div>
							
							<?php do_action('vidorev_pagination', 'template-parts/content', $archive_style); ?>
							
						<?php else :				
							get_template_part( 'template-parts/content', 'none' );				
						endif;
						if($category_description!='' && vidorev_get_redux_option('caterory_desc_post', 'top') == 'bottom'){
						?>
                        	<div class="archive-cat-desc bottom-lc">
								<?php echo wp_kses_post($category_description);?>
							</div>
                        <?php 
						}
						?>
					</div>
		
				</main>
				
				<?php								
				if($sidebarControl!='hidden'){
					get_sidebar();
				}
				?>
				
			</div>
			
		</div>
	</div>
</div>

<?php
get_footer();