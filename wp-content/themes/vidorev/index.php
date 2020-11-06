<?php
get_header(); 
$sidebarControl = vidorev_sidebar_control();
?>

<div id="primary-content-wrap" class="primary-content-wrap">
	<div class="primary-content-control">
		<div class="site__container fullwidth-vidorev-ctrl container-control">
		
			<div class="site__row sidebar-direction">							
				<main id="main-content" class="site__col main-content">	
					
					<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
						<?php if ( have_posts() ) :	
							$archive_style = vidorev_archive_style();
						?>
							
							<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
								<?php									
									while ( have_posts() ) : the_post();			
										
										get_template_part( 'template-parts/content', $archive_style );
						
									endwhile;
								?>
							</div>
							
							
							<?php do_action('vidorev_pagination', 'template-parts/content', $archive_style); ?>
							
						<?php else :				
							get_template_part( 'template-parts/content', 'none' );				
						endif; 
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