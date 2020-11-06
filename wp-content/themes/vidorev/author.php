<?php
get_header(); 
$sidebarControl = vidorev_sidebar_control();
?>

<div id="primary-content-wrap" class="primary-content-wrap">
	<div class="primary-content-control">
		<div class="site__container fullwidth-vidorev-ctrl container-control">
			
			<?php 
			do_action( 'vidorev_nav_breadcrumbs' );
			
			$u_id 		= isset($wp_query->query_vars['author']) ? $wp_query->query_vars['author']:NULL;
			$u_data 	= get_user_by('id', $u_id);	
			?>
			
			<div class="site__row sidebar-direction">							
				<main id="main-content" class="site__col main-content">	
					
					<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
						<div class="author-box">
							<div class="author-box-body">
								<div class="author-box-avatar">
									<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID', $u_id ) )); ?>" class="author-avatar">
										<?php echo get_avatar( get_the_author_meta('email', $u_id ), 130 ); ?>
									</a>
								</div>
								<div class="author-box-content">
									<h1 class="author-name h3 extra-bold"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID', $u_id ) )); ?>"><?php the_author_meta( 'display_name', $u_id ); ?></a></h4>
									<div class="author-des"><?php the_author_meta('description', $u_id); ?></div>
                                    <?php do_action('vidorev_single_author_social_follow', $u_id);?>
								</div>
							</div>
						</div>
						
						<?php						
						$u_dn 			= $u_data->display_name;	
						$u_url 			= get_author_posts_url($u_id);
						
						$active_default 	= '';
						$active_videos		= 'black-style';
						$active_news		= 'black-style';
						$active_playlists 	= 'black-style';
						$active_channels	= 'black-style';
						$active_series		= 'black-style';
						
						
						if(isset($_GET['author_type']) && $_GET['author_type']=='video'){
							$active_default		= 'black-style';
							$active_videos		= '';
							$active_news 		= 'black-style';
							$active_playlists 	= 'black-style';
							$active_channels	= 'black-style';
							$active_series		= 'black-style';
						}elseif(isset($_GET['author_type']) && $_GET['author_type']=='news'){
							$active_default		= 'black-style';
							$active_videos		= 'black-style';
							$active_news 		= '';
							$active_playlists 	= 'black-style';
							$active_channels	= 'black-style';
							$active_series		= 'black-style';
						}elseif(isset($_GET['author_type']) && $_GET['author_type']=='playlist'){
							$active_default		= 'black-style';
							$active_videos		= 'black-style';
							$active_news 		= 'black-style';
							$active_playlists 	= '';
							$active_channels	= 'black-style';
							$active_series		= 'black-style';
						}elseif(isset($_GET['author_type']) && $_GET['author_type']=='channel'){
							$active_default		= 'black-style';
							$active_videos		= 'black-style';
							$active_news 		= 'black-style';
							$active_playlists 	= 'black-style';
							$active_channels	= '';
							$active_series		= 'black-style';
						}elseif(isset($_GET['author_type']) && $_GET['author_type']=='series'){
							$active_default		= 'black-style';
							$active_videos		= 'black-style';
							$active_news 		= 'black-style';
							$active_playlists 	= 'black-style';
							$active_channels	= 'black-style';
							$active_series		= '';
						}
						?>
						<div class="listing-types">
							<div class="listing-types-content">
								<a href="<?php echo esc_url($u_url);?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($active_default);?>">
									<?php esc_html_e('View all', 'vidorev'); echo ' ('.apply_filters('vidorev_number_format', count_user_posts( $u_id , array('post', 'vid_playlist', 'vid_channel', 'vid_series'), true)).')';?>
								</a>
								<a href="<?php echo esc_url(add_query_arg('author_type', 'channel', $u_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($active_channels);?>">
									<?php esc_html_e('Channels', 'vidorev'); echo ' ('.apply_filters('vidorev_number_format', count_user_posts( $u_id , 'vid_channel' , true)).')';?>
								</a>
								<a href="<?php echo esc_url(add_query_arg('author_type', 'video', $u_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($active_videos);?>">
									<?php esc_html_e('Videos', 'vidorev'); echo ' ('.vidorev_get_post_count_by_author($u_id).')';?>
								</a>
								<a href="<?php echo esc_url(add_query_arg('author_type', 'playlist', $u_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($active_playlists);?>">
									<?php esc_html_e('Playlists', 'vidorev'); echo ' ('.apply_filters('vidorev_number_format', count_user_posts( $u_id , 'vid_playlist' , true)).')';?>
								</a>
								<a href="<?php echo esc_url(add_query_arg('author_type', 'series', $u_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($active_series);?>">
									<?php esc_html_e('Series', 'vidorev'); echo ' ('.apply_filters('vidorev_number_format', count_user_posts( $u_id , 'vid_series' , true)).')';?>
								</a>
								<!--<a href="<?php echo esc_url(add_query_arg('author_type', 'news', $u_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($active_news);?>">
									<?php esc_html_e('News', 'vidorev'); echo ' ('.vidorev_get_post_count_by_author($u_id, false).')';?>
								</a>-->								
							</div>
						</div>
						<?php if ( have_posts() ) :	
							$archive_style	= vidorev_archive_style();
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