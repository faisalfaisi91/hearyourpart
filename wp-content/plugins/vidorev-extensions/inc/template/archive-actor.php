<?php
/*Template Name: Archive Actor*/
get_header(); 

$paged 			= get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
$sidebarControl = vidorev_sidebar_control();
$wp_query 		= vidorev_detech_wp_query();	
$wp				= vidorev_detech_wp();
?>

<div id="primary-content-wrap" class="primary-content-wrap">
	<div class="primary-content-control">
		<div class="site__container fullwidth-vidorev-ctrl container-control">
			
			<?php do_action( 'vidorev_nav_breadcrumbs' );?>
			
			<div class="site__row sidebar-direction">							
				<main id="main-content" class="site__col main-content">	
					
					<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
						<?php
						$template_actor_query = array(
							'post_type' 			=> 'vid_actor',
							'posts_per_page' 		=> vidorev_get_option('vid_actor_items_per_page', 'vid_actor_layout_settings', 10),
							'post_status' 			=> 'publish',
							'ignore_sticky_posts' 	=> 1,
							'paged' 				=> $paged,
						);
						
						if(isset($_GET['archive_query']) && trim($_GET['archive_query'])!=''){
							switch(trim($_GET['archive_query'])){
								case 'comment':					
									$template_actor_query['orderby']	= 'comment_count date';
									$template_actor_query['order']		= 'DESC';
									break;
									
								case 'view':
									if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
										add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
										add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
										add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
									}
									break;
									
								case 'like':
									if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
										add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
										add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
										add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));
										add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
										add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
									}
									break;
									
								case 'title':
									$template_actor_query['orderby']		= 'title';
									$template_actor_query['order']		= 'ASC';
									break;			
							}
						}
						
						if(class_exists('vidorev_like_view_sorting') && isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!=''){
							add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_alphabet_temp'));
						}
																						
						$actor_query = new WP_Query($template_actor_query);
						
						if(isset($_GET['archive_query']) && trim($_GET['archive_query'])!=''){
							switch(trim($_GET['archive_query'])){				
									
								case 'view':
									if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
										remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
										remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
										remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
									}
									break;
									
								case 'like':
									if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
										remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
										remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
										remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));	
										remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));				
										remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
									}
									break;
													
							}
						}
						
						if(class_exists('vidorev_like_view_sorting') && isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!=''){
							remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_alphabet_temp'));
						}
						
						$wp_query = $actor_query;
						
						$archive_style = vidorev_archive_style();		
						do_action( 'vidorev_archive_heading', $archive_style );
						do_action( 'vidorev_archive_alphabet_filter', $archive_style );	
											
						if ( have_posts() ) :
						?>
							<script>
								vidorev_jav_js_object['query_vars'] = <?php echo json_encode($wp_query->query_vars);?>;
								<?php 
								if(isset($_GET['archive_query']) && trim($_GET['archive_query'])!=''){
									echo "vidorev_jav_js_object['archive_query'] = '".trim($_GET['archive_query'])."';";
								}
								
								if(isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!=''){
									echo "vidorev_jav_js_object['alphabet_filter'] = '".trim($_GET['alphabet_filter'])."';";
								}
								?>
							</script>
							
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

						wp_reset_postdata();
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