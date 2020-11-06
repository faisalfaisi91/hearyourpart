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
					
					<div class="single-page-wrapper global-single-wrapper">
							
						<?php
						while ( have_posts() ) : the_post();
			
							get_template_part( 'template-parts/content', 'page' );
			
							if ( (comments_open() || get_comments_number()!=0 ) && vidorev_get_redux_option('single_page_comment', 'on', 'switch')=='on') :
								comments_template();
							endif;
			
						endwhile;
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