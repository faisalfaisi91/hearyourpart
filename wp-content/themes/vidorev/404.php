<?php
get_header();
?>
<div id="primary-content-wrap" class="primary-content-wrap">
	<div class="primary-content-control">
		
		<div class="site__container fullwidth-vidorev-ctrl container-control">
			<div class="site__row sidebar-direction">							
				<main id="main-content" class="site__col main-content">	
					
					<div class="page-404-wrapper">
						<div class="img-404">
							<?php
							$img_404 = trim(vidorev_get_redux_option('img_404', '', 'media_get_src'));
							if($img_404 != ''){ 
								$img = $img_404;
							}else{ 
								$img = get_template_directory_uri().'/img/404.png';
							}
							?>
							<img src="<?php echo esc_url($img);?>" alt="<?php echo esc_attr__('404', 'vidorev');?>">
						</div>
						<div class="content-404">
							<h1>
								<?php
								$content_404 = trim(vidorev_get_redux_option('content_404', ''));
								if($content_404 != ''){ 
									echo esc_html($content_404);
								}else{ 
									echo esc_html__('Ooops... Error', 'vidorev');
								}
								?>
							</h1>
						</div>
						<div class="button-404">
							<a href="<?php echo esc_url(home_url('/'));?>" class="basic-button basic-button-default">
								<?php
								$button_404 = trim(vidorev_get_redux_option('button_404', ''));
								if($button_404 != ''){ 
									echo esc_html($button_404);
								}else{ 
									echo esc_html__('Back to homepage', 'vidorev');
								}
								?>								
							</a>
						</div>
					</div>
					
				</main>
			</div>		
		</div>
	</div>
</div>		

<?php
get_footer();