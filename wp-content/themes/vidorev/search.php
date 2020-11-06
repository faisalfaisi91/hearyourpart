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
					
					<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
						<div class="search-form-page">
							<div class="header-search-page-wrapper">
								<form action="<?php echo esc_url(home_url('/'));?>" method="get">					
									<input class="search-terms-textfield search-terms-textfield-control" type="text" placeholder="<?php esc_attr_e('Search...', 'vidorev');?>" name="s" value="<?php echo esc_attr(get_search_query());?>">		
									<i class="fa fa-search" aria-hidden="true"></i>					
									<input type="submit" value="<?php esc_attr_e('Search', 'vidorev');?>">							
								</form>
							</div>
						</div>
						
						<?php if ( have_posts() ) :	
							$archive_style = vidorev_archive_style();
						?>
							<div class="archive-heading">
								<?php 
								printf( '<h1 class="archive-title h2">'.esc_html__( 'Search Results for: %s', 'vidorev').'</h1>', '<span>' . get_search_query() . '</span>' );														
								do_action( 'vidorev_html_switch_mode', $archive_style );									
								?>																	
							</div>
							
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