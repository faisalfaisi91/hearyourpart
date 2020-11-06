<?php
if ( !class_exists('vidorev_director_settings' ) ):
	class vidorev_director_settings {
	
		private $settings_api;
	
		function __construct() {
			$this->settings_api = new WeDevs_Settings_API;
	
			add_action( 'admin_init', array($this, 'admin_init') );
			add_action( 'admin_menu', array($this, 'admin_menu') );
		}
	
		function admin_init() {
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			$this->settings_api->admin_init();
		}
	
		function admin_menu() {
			add_submenu_page('edit.php?post_type=vid_director', esc_html__( 'Director Settings', 'vidorev-extensions'), esc_html__( 'Director Settings', 'vidorev-extensions'), 'manage_options', 'vid_director_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'vid_director_settings',
					'title' => esc_html__('General Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'vid_director_layout_settings',
					'title' => esc_html__('Layout Settings', 'vidorev-extensions')
				),            
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'vid_director_settings' => array(
					array(
						'name' 		=> 'vid_director_slug',
						'label' 	=> esc_html__( 'Director Slug', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Change single Director slug. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'director'
					),
					array(
						'name' 		=> 'vid_director_category_base',
						'label' 	=> esc_html__( 'Director Category Base', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Change Director Category Base. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'director-category'
					), 
					array(
						'name' 		=> 'vid_director_image',
						'label' 	=> esc_html__( 'Director Image', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Upload an image or enter an URL.', 'vidorev-extensions'),
						'type' 		=> 'file',
					),                
				), 
				'vid_director_layout_settings' => array(					
					array(
						'name'    => 'vid_director_layout',
						'label'   => esc_html__( 'Director Listing Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change single Director Listing Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'grid',
						'options' => array(							
							'movie-grid' 	=> esc_html__('Grid', 'vidorev-extensions'),
							'movie-list'  => esc_html__('List', 'vidorev-extensions'),							
						)
					),					
					array(
						'name'              => 'vid_director_items_per_page',
						'label'             => esc_html__( 'Items Per Page', 'vidorev-extensions'),
						'desc'              => esc_html__( 'Number of items to show per page. Defaults to: 10', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '10', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 100,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '10',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_director_pag_type',
						'label'   => esc_html__( 'Pagination', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Choose type of navigation for director listing. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'wp-default',
						'options' => array(
							'wp-default'		=> esc_html__('WordPress Default', 'vidorev-extensions'),
							'loadmore-btn'		=> esc_html__('Load More Button (Ajax)', 'vidorev-extensions'),
							'infinite-scroll' 	=> esc_html__('Infinite Scroll (Ajax)', 'vidorev-extensions'),
							'pagenavi_plugin'  	=> esc_html__('WP PageNavi (Plugin)', 'vidorev-extensions'),
						)
					),
					array(
						'name'    => 'vid_director_listing_sidebar',
						'label'   => esc_html__( 'Director Listing Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Director Listing Sidebar. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'right'			=> esc_html__('Right', 'vidorev-extensions'),
							'left' 			=> esc_html__('Left', 'vidorev-extensions'),
							'hidden'  		=> esc_html__('Hidden', 'vidorev-extensions'),
						)
					), 
					array(
						'name'    => 'vid_single_director_layout',
						'label'   => esc_html__( 'Single Director Video Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Director Video Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'grid-default' 	=> esc_html__('Grid - Default', 'vidorev-extensions'),
							'list-default'  => esc_html__('List - Default', 'vidorev-extensions'),
							'grid-special'  => esc_html__('Grid - Special', 'vidorev-extensions'),
							'list-special'  => esc_html__('List - Special', 'vidorev-extensions'),
							'grid-modern'  	=> esc_html__('Grid - Modern', 'vidorev-extensions'),
							'movie-grid' 	=> esc_html__('Grid - Poster', 'vidorev-extensions'),
							'list-blog' 	=> esc_html__('List - Blog Wide', 'vidorev-extensions'),
							'movie-list'  	=> esc_html__('List - Poster', 'vidorev-extensions'),
							'grid-small' 	=> esc_html__('Grid - Small', 'vidorev-extensions'),
							/*new layout*/
						)
					),
					array(
						'name'              => 'vid_single_director_video_items_per_page',
						'label'             => esc_html__( '[Video] Items Per Page', 'vidorev-extensions'),
						'desc'              => esc_html__( 'Number of items to show per page. Defaults to: 20', 'vidorev-extensions'),
						'placeholder'       => esc_html__( '20', 'vidorev-extensions'),
						'min'               => 1,
						'max'               => 100,
						'step'              => '1',
						'type'              => 'number',
						'default'           => '20',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'    => 'vid_single_director_pag_type',
						'label'   => esc_html__( '[Single Director] Pagination', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Choose type of navigation for playlist page. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'loadmore-btn',
						'options' => array(
							'loadmore-btn'		=> esc_html__('Load More Button (Ajax)', 'vidorev-extensions'),					
							'infinite-scroll' 	=> esc_html__('Infinite Scroll (Ajax)', 'vidorev-extensions'),
							'pagenavi_plugin'  	=> esc_html__('WP PageNavi (Plugin)', 'vidorev-extensions'),
						)
					),      
					array(
						'name'    => 'vid_single_director_sidebar',
						'label'   => esc_html__( 'Single Director Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Director Sidebar. Select "Default" to use settings in Theme Options > Single Post Settings.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'right'			=> esc_html__('Right', 'vidorev-extensions'),
							'left' 			=> esc_html__('Left', 'vidorev-extensions'),
							'hidden'  		=> esc_html__('Hidden', 'vidorev-extensions'),
						)
					),
					array(
						'name'    => 'vid_director_display_cat',
						'label'   => esc_html__( 'Display Director Categories', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'no',
						'options' => array(
							'no'			=> esc_html__('NO', 'vidorev-extensions'),
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),							
						)
					),                   
				),            
			);
	
			return $settings_fields;
		}
	
		function plugin_page() {
			echo '<div class="wrap"><h1>'.esc_html__( 'Director Settings', 'vidorev-extensions').'</h1>';
	
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
	
			echo '</div>';
		}	
	}
endif;
new vidorev_director_settings();

if ( !function_exists('vidorev_set_posts_per_page_for_director' ) ):
	function vidorev_set_posts_per_page_for_director( $query ) {
		if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'vid_director' ) || is_tax('vid_director_cat')) ) {
			$query->set( 'posts_per_page', vidorev_get_option('vid_director_items_per_page', 'vid_director_layout_settings', 10) );
		}
	}
endif;	
add_action( 'pre_get_posts', 'vidorev_set_posts_per_page_for_director' );

if ( !function_exists('vidorev_director_html' ) ):
	function vidorev_director_html( $post_count = -1 ){
		$post_id 		= get_the_ID();
		$director		= get_post_meta($post_id, MOVIE_PM_PREFIX.'director', true);
		
		if(is_array($director) && count($director)>0){
			$args_query = array(
				'post_type'				=> 'vid_director',
				'posts_per_page' 		=> $post_count,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,
				'post__in'				=> is_array($director) ? $director : array(),
				'orderby'				=> 'post__in',
			);
			
			$director_query = get_posts($args_query);
			if($director_query):
				?>
				<div class="director-element">
					<span class="director-element-title h6"><i class="fa fa-universal-access" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_director_listing_title', esc_html__('Directors', 'vidorev-extensions'));?>:</span>  &nbsp; </span>
					<?php
					$i = 1;
					foreach ( $director_query as $item) :						
						if($i>1){
							$comma = '<span class="comma">&nbsp;.&nbsp;</span>';
						}else{
							$comma = '';
						}					
						echo $comma.'<a class="main-color-udr" href="'.esc_url(get_permalink($item->ID)).'" title="'.esc_attr(get_the_title($item->ID)).'">'.get_the_title($item->ID).'</a>';	
						$i++;				
					endforeach;
					?>
				</div>
				<?php	
			endif;
		}
	}
endif;
add_action('vidorev_director_html', 'vidorev_director_html', 10, 1);

if ( !function_exists('vidorev_director_single_html' ) ):
	function vidorev_director_single_html( $post_count = -1 ){
		$post_id 		= get_the_ID();
		$director		= get_post_meta($post_id, MOVIE_PM_PREFIX.'director', true);
		
		if(is_array($director) && count($director)>0){
			$args_query = array(
				'post_type'				=> 'vid_director',
				'posts_per_page' 		=> $post_count,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,
				'post__in'				=> is_array($director) ? $director : array(),
				'orderby'				=> 'post__in',
			);
			
			$director_query = get_posts($args_query);
			if($director_query):
				?>
				<div class="director-element single-element">
					<h3 class="director-element-title extra-bold h4"><i class="fa fa-universal-access" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_director_single_title', esc_html__('Directors', 'vidorev-extensions'));?></h3>
					
					<div class="site__row">
						<?php							
						foreach ( $director_query as $item) :
							$biography 		= trim(get_post_meta($item->ID, MOVIE_PM_PREFIX.'biography', true));
							$ex_class_bio 	= '';
							if($biography!=''){
								$ex_class_bio = 'full-bio';
							}
						?>	
							<div class="site__col <?php echo esc_attr($ex_class_bio);?>">
								<div class="ac-di-content">
									<div class="post-img"><?php do_action('vidorev_thumbnail', 'vidorev_thumb_2x3_0point3x', 'class-2x3', 3, $item->ID); ?></div>
									<div class="post-content">
										<h6 class="post-title"><a class="main-color-udr" href="<?php echo esc_url(get_permalink($item->ID));?>" title="<?php echo esc_attr(get_the_title($item->ID));?>"><?php echo get_the_title($item->ID);?></a></h6>
										<div class="entry-meta post-meta meta-font">
											<div class="post-meta-wrap">
												<div class="like-count"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span class="like-count" data-id="<?php echo esc_attr($item->ID)?>"><?php echo esc_html(vidorev_get_like_count($item->ID))?></span></div>
												<div class="dislike-count"><i class="fa fa-thumbs-down" aria-hidden="true"></i><span class="dislike-count" data-id="<?php echo esc_attr($item->ID)?>"><?php echo esc_html(vidorev_get_dislike_count($item->ID))?></span></div>
											</div>
										</div>
										<div class="entry-meta post-meta meta-font">
											<div class="post-meta-wrap">												
												<div class="dislike-count"><i class="fa fa-file-video-o" aria-hidden="true"></i><span><?php echo esc_html(apply_filters('vidorev_number_format', vidorev_count_videos_in_director($item->ID))).' '.apply_filters('vidorev_director_single_format_title', esc_html__('videos', 'vidorev-extensions'))?></span></div>
											</div>
										</div>
									</div>									
								</div>
                                <?php if($biography!=''){?>
                                	<div class="ac-di-bio">
                                    	<h5 class="bio-heading extra-bold"><?php echo esc_html__('Biographical', 'vidorev-extensions');?></h5>
                                    	<?php echo beeteam368_get_wysiwyg_output(MOVIE_PM_PREFIX.'biography', $item->ID);?>
                                    </div>
                                <?php }?>
							</div>				
						<?php				
						endforeach;
						?>
					</div>
					
				</div>				
				<?php	
			endif;
		}
	}
endif;
add_action('vidorev_director_single_html', 'vidorev_director_single_html', 10, 1);

if(!function_exists('vidorev_count_videos_in_director' )):
	function vidorev_count_videos_in_director($post_id){
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> 1,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'tax_query' 			=> array(
											array(
												'taxonomy'  => 'post_format',
												'field'    	=> 'slug',
												'terms'     => array('post-format-video'),
												'operator'  => 'IN',
											),
										),
			'meta_query' 			=> array(
											array(
												'key' 		=> MOVIE_PM_PREFIX.'director',
												'value' 	=> serialize( strval( $post_id )),
												'compare' 	=> 'LIKE'
											)
			)							
		);
		
		$director_query = new WP_Query($args_query);
		if($director_query->have_posts()):
			wp_reset_postdata();
			return $director_query->found_posts;
		else:
			wp_reset_postdata();
			return 0;	
		endif;
		wp_reset_postdata();		
	}
endif;

if ( !function_exists('vidorev_load_videos_in_director' ) ):
	function vidorev_load_videos_in_director(){
		$post_id = get_the_ID();
		
		if ( get_post_type( $post_id ) != 'vid_director' ) {
			return;
		}
		
		$single_items_per_page 	= vidorev_get_option('vid_single_director_video_items_per_page', 'vid_director_layout_settings', 20);
		$paged 					= get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
		
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> $single_items_per_page,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'tax_query' 			=> array(
											array(
												'taxonomy'  => 'post_format',
												'field'    	=> 'slug',
												'terms'     => array('post-format-video'),
												'operator'  => 'IN',
											),
										),
			'meta_query' 			=> array(
											array(
												'key' 		=> MOVIE_PM_PREFIX.'director',
												'value' 	=> serialize( strval( $post_id )),
												'compare' 	=> 'LIKE'
											)
			),
			'paged' 				=> $paged,							
		);
		
		$director_query = new WP_Query($args_query);
		
		if($director_query->have_posts()):	
			$archive_style = vidorev_archive_style();	
			
			global $wp_query;
			$old_max_num_pages 			= $wp_query->max_num_pages;				
			$wp_query->max_num_pages 	= $director_query->max_num_pages;
											
		?>			
			<div class="archive-heading">
				<h2 class="h5 extra-bold" id="sec_FILMOGRAPHY"><?php echo apply_filters('vidorev_director_filmography_title', esc_html__('FILMOGRAPHY', 'vidorev-extensions'));?></h2>													
			</div>
			
            <div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
            	
                <script>
					vidorev_jav_js_object['query_vars'] = <?php echo json_encode($director_query->query_vars);?>;
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
                        while($director_query->have_posts()):
                            $director_query->the_post();			
                            
                            get_template_part( 'template-parts/content', $archive_style );
            
                        endwhile;
                    ?>
                </div>
                
                <?php 
                $pag_type = vidorev_get_option('vid_single_director_pag_type', 'vid_director_layout_settings', 'loadmore-btn');
                do_action('vidorev_pagination', 'template-parts/content', $archive_style, $pag_type); 
                ?>
                
			</div>                
		<?php
			
			$wp_query->max_num_pages = $old_max_num_pages;
						
		endif;
		wp_reset_postdata();
	}
endif;
add_action( 'vidorev_single_custom_listing', 'vidorev_load_videos_in_director' );