<?php
if ( !class_exists('vidorev_series_settings' ) ):
	class vidorev_series_settings {
	
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
			add_submenu_page('edit.php?post_type=vid_series', esc_html__( 'Series Settings', 'vidorev-extensions'), esc_html__( 'Series Settings', 'vidorev-extensions'), 'manage_options', 'vid_series_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'vid_series_settings',
					'title' => esc_html__('General Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'vid_series_layout_settings',
					'title' => esc_html__('Layout Settings', 'vidorev-extensions')
				),            
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'vid_series_settings' => array(
					array(
						'name' 		=> 'vid_series_slug',
						'label' 	=> esc_html__( 'Series Slug', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Change single Series slug. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'series'
					), 
					array(
						'name' 		=> 'vid_series_category_base',
						'label' 	=> esc_html__( 'Series Category Base', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Change Series Category Base. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'series-category'
					), 
					array(
						'name' 		=> 'vid_series_image',
						'label' 	=> esc_html__( 'Series Image', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Upload an image or enter an URL.', 'vidorev-extensions'),
						'type' 		=> 'file',
					),                
				), 
				'vid_series_layout_settings' => array(					
					array(
						'name'    => 'vid_series_layout',
						'label'   => esc_html__( 'Series Listing Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change single Series Listing Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
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
						'name'              => 'vid_series_items_per_page',
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
						'name'    => 'vid_series_pag_type',
						'label'   => esc_html__( 'Pagination', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Choose type of navigation for series page. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev-extensions'),
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
						'name'    => 'vid_series_link_action',
						'label'   => esc_html__( '[Series Listing] - Link', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => '',
						'options' => array(
							''				=> esc_html__('Default', 'vidorev-extensions'),
							'vid_post'		=> esc_html__('Go to the video post', 'vidorev-extensions'),							
						)
					),
					array(
						'name'    => 'vid_series_listing_sidebar',
						'label'   => esc_html__( 'Series Listing Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Series Listing Sidebar. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
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
						'name'    => 'vid_single_series_layout',
						'label'   => esc_html__( 'Single Series Video Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Series Video Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
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
						'name'    => 'vid_single_series_sidebar',
						'label'   => esc_html__( 'Single Series Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Series Sidebar. Select "Default" to use settings in Theme Options > Single Post Settings.', 'vidorev-extensions'),
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
						'name'    => 'vid_series_display_cat',
						'label'   => esc_html__( 'Display Series Categories', 'vidorev-extensions'),						
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
			echo '<div class="wrap"><h1>'.esc_html__( 'Series Settings', 'vidorev-extensions').'</h1>';
	
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
	
			echo '</div>';
		}	
	}
endif;
new vidorev_series_settings();

if ( !function_exists('vidorev_set_posts_per_page_for_series' ) ):
	function vidorev_set_posts_per_page_for_series( $query ) {
		if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'vid_series' ) || is_tax('vid_series_cat')) ) {
			$query->set( 'posts_per_page', vidorev_get_option('vid_series_items_per_page', 'vid_series_layout_settings', 10) );
		}
	}
endif;	
add_action( 'pre_get_posts', 'vidorev_set_posts_per_page_for_series' );

if ( !function_exists('vidorev_load_videos_in_series' ) ):
	function vidorev_load_videos_in_series(){
		$post_id = get_the_ID();
		
		if ( get_post_type( $post_id ) != 'vid_series' ) {
			return;
		}
		
		$post_query = get_post_meta($post_id, 'video_series_group', true);
		
		if(!is_array($post_query) || count($post_query)<1){
			return;
		}
		
		global $post_type_add_param_to_url;
		$post_type_add_param_to_url = array(
			'series' => $post_id
		);
		
		foreach($post_query as $group){
			if(isset($group['videos']) && is_array($group['videos']) && count($group['videos'])>0){
				$videos 	= isset($group['videos'])?$group['videos']:array();
				$group_name = isset($group['group_name'])?trim($group['group_name']):'';
			
				$args_query = array(
					'post_type'				=> 'post',
					'posts_per_page' 		=> -1,
					'post_status' 			=> 'publish',
					'ignore_sticky_posts' 	=> 1,
					'post__in'				=> is_array($videos) ? $videos : array(),
					'orderby'				=> 'post__in',
					'tax_query' 			=> array(
													array(
														'taxonomy'  => 'post_format',
														'field'    	=> 'slug',
														'terms'     => array('post-format-video'),
														'operator'  => 'IN',
													),
												),
				);
				
				$series_query = new WP_Query($args_query);
				if($series_query->have_posts()):	
					$archive_style = vidorev_archive_style();
			?>
					<div class="archive-heading series-heading series-heading-control">
						
						<?php if($group_name!=''){
							$all_key_query = array_keys($videos);
						?>
							<a href="<?php echo esc_url(add_query_arg(array('series' => $post_id), get_permalink($videos[$all_key_query[0]])));?>" class="basic-button basic-button-default">
								<i class="fa fa-play-circle" aria-hidden="true"></i> &nbsp; <span><?php echo esc_html($group_name)?></span> &nbsp; <i class="fa fa-play" aria-hidden="true"></i>
							</a>											
						<?php 
						}
						do_action( 'vidorev_html_switch_mode', $archive_style );
						?>	
																		
					</div>
					
					<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
						<?php									
							while($series_query->have_posts()):
								$series_query->the_post();			
								
								get_template_part( 'template-parts/content', $archive_style );
				
							endwhile;
						?>
					</div>
			<?php	
				endif;
				wp_reset_postdata();
			}
		}
		
		$post_type_add_param_to_url = NULL;
		
	}
endif;
add_action( 'vidorev_single_custom_listing', 'vidorev_load_videos_in_series' );

if ( !function_exists('vidorev_single_post_display_series' ) ):
	function vidorev_single_post_display_series($post_id = 0){
		if($post_id == 0){
			$post_id = get_the_ID();			
		}
		
		$video_ps_link_action = vidorev_get_redux_option('video_ps_link_action', 'no');		
		if($video_ps_link_action == 'series' || $video_ps_link_action == 'both'){
			$at_series_id = beeteam368_get_series_by_post_id($post_id);
			if($at_series_id > 0){
				$_GET['series'] = $at_series_id;
			}
		}
		
		if(isset($_GET['series'])){
			$series = trim($_GET['series']);		
			if(is_numeric($series)){
				$post_query = get_post_meta($series, 'video_series_group', true);
				if(!is_array($post_query) || count($post_query)<1){
					return;
				}
			}else{
				return;
			}
		}else{
			return;
		}
		
		global $post_type_add_param_to_url;
		$post_type_add_param_to_url = array(
			'series' => $series
		);
		
		if(isset($_GET['video_index']) && is_numeric($_GET['video_index'])){
			$post_type_add_param_to_url = array(
				'series' 		=> $series,
				'video_index' 	=> $_GET['video_index']
			);
		}
		
		ob_start();
		$i = 1;
		foreach($post_query as $group){
			if(isset($group['videos']) && is_array($group['videos']) && count($group['videos'])>0){
				$videos 		= isset($group['videos'])?$group['videos']:array();
				$group_name 	= isset($group['group_name'])?trim($group['group_name']):'';
				$item_name 		= isset($group['item_name'])?trim($group['item_name']):'';
				
				$args_query = array(
					'post_type'				=> 'post',
					'posts_per_page' 		=> -1,
					'post_status' 			=> 'publish',
					'ignore_sticky_posts' 	=> 1,
					'post__in'				=> is_array($videos) ? $videos : array(),
					'orderby'				=> 'post__in',
					'tax_query' 			=> array(
													array(
														'taxonomy'  => 'post_format',
														'field'    	=> 'slug',
														'terms'     => array('post-format-video'),
														'operator'  => 'IN',
													),
												),
				);
				
				$series_query = new WP_Query($args_query);
				if($series_query->have_posts()):
				
				$video_series_style = get_post_meta($series, 'video_series_style', true);
				if($video_series_style == ''){
					$video_series_style = vidorev_get_redux_option('video_series_style', 'inline');	
				}
		?>
				<div class="series-items <?php echo esc_attr('ss_'.$video_series_style)?>" data-index="<?php echo esc_attr($i);?>">
					<div class="series-items-wrap" data-index="<?php echo esc_attr($i);?>">
						<div class="series-name"><h5 class="extra-bold"><?php echo esc_html($group_name);?></h5></div>
						<div class="series-listing">
							<?php 
							$z = 1;
							
							if($video_series_style == 'inline'){
							
								while($series_query->have_posts()):
									$series_query->the_post();
							?>
									<a href="<?php echo esc_url(vidorev_get_post_url());?>" class="series-item <?php if($post_id == get_the_ID()){echo 'active-item';}?>" title="<?php the_title_attribute(); ?>">
										<i class="fa fa-play-circle" aria-hidden="true"></i><span><?php echo esc_html($item_name);?></span><span><?php echo esc_html($z);?></span>
									</a>
							<?php
									$z++;
								endwhile;
							}elseif($video_series_style == 'dd'){
							?>
                            	<div class="series-dropdown series-dropdown-control">
                                <?php
									$active_series 		= '';
									
									$active_series_df 	= '<span class="series-item series-df-item-control">
																<i class="fa fa-list-alt" aria-hidden="true"></i><span>'.esc_html('All Videos in', 'vidorev-extensions').'</span>'.$group_name.'<span></span>
															</span>';
									$all_series 		= '';						
									while($series_query->have_posts()):
										$series_query->the_post();
										if($post_id == get_the_ID()){
											$active_series= '<span class="series-item active-item series-df-item-control">
																<i class="fa fa-play-circle" aria-hidden="true"></i><span>'.esc_html($item_name).'</span><span>'.esc_html($z).'</span>
															</span>';
										}else{
											$all_series.= 	'<a href="'.esc_url(vidorev_get_post_url()).'" class="series-item" title="'.esc_attr(the_title_attribute(array('echo'=>false))).'">
																<i class="fa fa-play-circle" aria-hidden="true"></i><span>'.esc_html($item_name).'</span><span>'.esc_html($z).'</span>
															</a>';
										}
								?>
                                <?php
										$z++;
									endwhile;
									
									echo $active_series!=''?$active_series:$active_series_df;
								?>	
                                	<div class="series-dropdown-content">
                                    	<?php echo $all_series;?>
                                    </div>
                                </div>
                            <?php	
							}elseif($video_series_style == 'grid'){
							?>
                            	<div class="grid-style-series grid-style-series-control">
                                    <div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
                                        <div class="blog-items blog-items-control site__row grid-small">
                                            <?php
                                            while($series_query->have_posts()):
                                                $series_query->the_post();
                                                $item_class = 'post-item site__col';
												$item_id	= '';
                                                if(get_the_ID() == $post_id){
                                                    $item_class = 'post-item site__col current-playing';
													$item_id	= ' id="current-playing-series"';
                                                }
                                                ?><article <?php post_class($item_class); echo $item_id;?>>
                                                    <div class="post-item-wrap">				
                                                        <?php 
                                                        $image_ratio_case = vidorev_image_ratio_case('1x');
                                                        do_action('vidorev_thumbnail', 'vidorev_thumb_16x9_0x', 'class-16x9', 1, NULL, $image_ratio_case); 
                                                        ?>
                                                        
                                                        <div class="listing-content">
                                                            
                                                            <h3 class="entry-title h6 post-title"> 
                                                                <a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
                                                            </h3>	
                                                            
                                                            <?php do_action( 'vidorev_posted_on', array('author', 'date-time'), 'archive' ); ?>	
                                                            <?php do_action( 'vidorev_posted_on', array('', '', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'archive' ); ?>		
                                                        
                                                        </div>
                                                        
                                                    </div>
                                                </article><?php
                                            endwhile;	
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php	
							}
							?>
						</div>
					</div>	
				</div>
		<?php
				endif;
				wp_reset_postdata();
			}
			$i++;
		}
		
		$output_string = ob_get_contents();
		ob_end_clean();
		
		if(trim($output_string)!=''){
			echo '<div class="series-wrapper">'.$output_string.'</div>';
		}
			
		$post_type_add_param_to_url = NULL;		
	}
endif;
add_action( 'vidorev_video_series_element', 'vidorev_single_post_display_series', 10 ,1 );

if ( !function_exists('vidorev_get_link_series_all' ) ):
	function vidorev_get_link_series_all($post_id, $series_first_video){
		
		$series_all_link = '';
		if(!is_array($series_first_video) || count($series_first_video)<1){
			return $series_all_link;
		}
		
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> 1,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($series_first_video) ? $series_first_video : array(),
			'orderby'				=> 'post__in',
			'tax_query' 			=> array(
											array(
												'taxonomy'  => 'post_format',
												'field'    	=> 'slug',
												'terms'     => array('post-format-video'),
												'operator'  => 'IN',
											),
										),
			'orderby'				=> 	'post__in',					
		);
		
		$series_query = get_posts($args_query);		
		if($series_query):
			foreach ( $series_query as $item) :								
				$series_all_link = add_query_arg(array('series' => $post_id), get_permalink($item->ID));
				break;
			endforeach;
		endif;
		
		return $series_all_link;
	}
endif;

if ( !function_exists('vidorev_get_link_series_all_title' ) ):
	function vidorev_get_link_series_all_title(){
		
		if(vidorev_get_option('vid_series_link_action', 'vid_series_layout_settings', '') == 'vid_post'){
			
			add_filter('vidorev_is_params_url_return', function($url, $post_id){
				
				if($post_id == NULL){
					$post_id = get_the_ID();
				}
				
				if(get_post_type($post_id)=='vid_series'){
					$series_group = get_post_meta($post_id, 'video_series_group', true);
					if(is_array($series_group) && isset($series_group[0]) && isset($series_group[0]['videos']) && is_array($series_group[0]['videos'])){
						return vidorev_get_link_series_all($post_id, $series_group[0]['videos']);
					}
				}
				return $url;
			}, 10, 2);
			
			add_filter('vidorev_no_params_url_return', function($url, $post_id){
				
				if($post_id == NULL){
					$post_id = get_the_ID();
				}
				
				if(get_post_type($post_id)=='vid_series'){
					$series_group = get_post_meta($post_id, 'video_series_group', true);
					if(is_array($series_group) && isset($series_group[0]) && isset($series_group[0]['videos']) && is_array($series_group[0]['videos'])){
						return vidorev_get_link_series_all($post_id, $series_group[0]['videos']);
					}
				}
				return $url;
			}, 10, 2);
		}
		
	}
endif;
add_action('init', 'vidorev_get_link_series_all_title');