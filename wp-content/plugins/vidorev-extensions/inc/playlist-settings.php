<?php
if ( !class_exists('vidorev_playlist_settings' ) ):
	class vidorev_playlist_settings {
	
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
			add_submenu_page('edit.php?post_type=vid_playlist', esc_html__( 'Playlist Settings', 'vidorev-extensions'), esc_html__( 'Playlist Settings', 'vidorev-extensions'), 'manage_options', 'vid_playlist_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'vid_playlist_settings',
					'title' => esc_html__('General Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'vid_playlist_layout_settings',
					'title' => esc_html__('Layout Settings', 'vidorev-extensions')
				),            
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'vid_playlist_settings' => array(
					array(
						'name' 		=> 'vid_playlist_slug',
						'label' 	=> esc_html__( 'Playlist Slug', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Change single Playlist slug. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'playlist'
					), 
					array(
						'name' 		=> 'vid_playlist_category_base',
						'label' 	=> esc_html__( 'Playlist Category Base', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Change Playlist Category Base. Remember to save the permalink settings again in Settings > Permalinks', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> 'playlist-category'
					), 
					array(
						'name' 		=> 'vid_playlist_image',
						'label' 	=> esc_html__( 'Playlist Image', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Upload an image or enter an URL.', 'vidorev-extensions'),
						'type' 		=> 'file',
					),                
				), 
				'vid_playlist_layout_settings' => array(					
					array(
						'name'    => 'vid_playlist_layout',
						'label'   => esc_html__( 'Playlist Listing Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change single Playlist Listing Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
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
						'name'              => 'vid_playlist_items_per_page',
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
						'name'    => 'vid_playlist_pag_type',
						'label'   => esc_html__( 'Pagination', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Choose type of navigation for playlist page. For WP PageNavi, you will need to install WP PageNavi plugin', 'vidorev-extensions'),
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
						'name'    => 'vid_playlist_listing_sidebar',
						'label'   => esc_html__( 'Playlist Listing Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Playlist Listing Sidebar. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
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
						'name'    => 'vid_single_playlist_layout',
						'label'   => esc_html__( 'Single Playlist Video Layout', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Playlist Video Layout. Select "Default" to use settings in Theme Options > Blog Settings.', 'vidorev-extensions'),
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
						'name'              => 'vid_single_playlist_video_items_per_page',
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
						'name'    => 'vid_single_playlist_pag_type',
						'label'   => esc_html__( '[Single Playlist] Pagination', 'vidorev-extensions'),
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
						'name'    => 'vid_single_playlist_sidebar',
						'label'   => esc_html__( 'Single Playlist Sidebar', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Change Single Playlist Sidebar. Select "Default" to use settings in Theme Options > Single Post Settings.', 'vidorev-extensions'),
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
						'name'    => 'vid_playlist_display_cat',
						'label'   => esc_html__( 'Display Playlist Categories', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'no',
						'options' => array(
							'no'			=> esc_html__('NO', 'vidorev-extensions'),
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),							
						)
					),    
					array(
						'name'    => 'vid_playlist_hyperlink_action',
						'label'   => esc_html__( 'Open playlist', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'default',
						'options' => array(
							'default'		=> esc_html__('Default', 'vidorev-extensions'),
							'only-title'	=> esc_html__('Only open through the post title', 'vidorev-extensions'),							
						)
					),
					array(
						'name'    => 'vid_playlist_query_items',
						'label'   => esc_html__( 'Query Items', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'default',
						'options' => array(
							'default'		=> esc_html__('Preserve post ID order', 'vidorev-extensions'),
							'new'			=> esc_html__('Newest Items', 'vidorev-extensions'),
							'old'			=> esc_html__('Oldest Items', 'vidorev-extensions'),							
						)
					), 
					array(
						'name' 		=> 'vid_playlist_items_per_page_single_post',
						'label' 	=> esc_html__( 'The maximum limit', 'vidorev-extensions'),
						'desc' 		=> esc_html__( 'Set max limit for items in Single Post Video or enter -1 to display all. Default: -1', 'vidorev-extensions'),
						'type' 		=> 'text',
						'default' 	=> '-1'
					),               
				),            
			);
	
			return $settings_fields;
		}
	
		function plugin_page() {
			echo '<div class="wrap"><h1>'.esc_html__( 'Playlist Settings', 'vidorev-extensions').'</h1>';
	
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
	
			echo '</div>';
		}	
	}
endif;
new vidorev_playlist_settings();

if ( !function_exists('vidorev_set_posts_per_page_for_playlist' ) ):
	function vidorev_set_posts_per_page_for_playlist( $query ) {
		if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'vid_playlist' ) || is_tax('vid_playlist_cat')) ) {
			$query->set( 'posts_per_page', vidorev_get_option('vid_playlist_items_per_page', 'vid_playlist_layout_settings', 10) );
		}
	}
endif;	
add_action( 'pre_get_posts', 'vidorev_set_posts_per_page_for_playlist' );

if ( !function_exists('vidorev_load_videos_in_playlist' ) ):
	function vidorev_load_videos_in_playlist(){
		$post_id = get_the_ID();
		
		if ( get_post_type( $post_id ) != 'vid_playlist' ) {
			return;
		}
		
		$post_query = get_post_meta($post_id, PLAYLIST_PM_PREFIX.'videos', true);
		
		if(!is_array($post_query) || count($post_query)<1){
			return;
		}
		
		global $post_type_add_param_to_url;
		$post_type_add_param_to_url = array(
			'playlist' => $post_id
		);
		
		global $vidorev_check_single_playlist;
		$vidorev_check_single_playlist = 'playlist';
		
		$single_items_per_page 	= vidorev_get_option('vid_single_playlist_video_items_per_page', 'vid_playlist_layout_settings', 20);
		$paged 					= get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
		
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> $single_items_per_page,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($post_query) ? $post_query : array(),
			'orderby'				=> 'post__in',
			'tax_query' 			=> array(
											array(
												'taxonomy'  => 'post_format',
												'field'    	=> 'slug',
												'terms'     => array('post-format-video'),
												'operator'  => 'IN',
											),
										),
			'paged' 				=> $paged,							
		);
		
		$query_items = vidorev_get_option('vid_playlist_query_items', 'vid_playlist_layout_settings', 'default');
		
		switch($query_items){
			case 'default':
				$args_query['orderby'] = 'post__in';
				break;
				
			case 'new':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'DESC';
				break;
				
			case 'old':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'ASC';
				break;
		}
		
		$playlist_query = new WP_Query($args_query);

		if($playlist_query->have_posts()):	
			$archive_style = vidorev_archive_style();
			
			global $wp_query;
			$old_max_num_pages 			= $wp_query->max_num_pages;				
			$wp_query->max_num_pages 	= $playlist_query->max_num_pages;
			
			$all_key_query = array_keys($post_query);
			
			$playlist_get_query_arr = isset($playlist_query->posts)?$playlist_query->posts:array();
		
			if(count($playlist_get_query_arr)>0){
				$first_post_query = (isset($playlist_get_query_arr[0])&&isset($playlist_get_query_arr[0]->ID)&&is_numeric($playlist_get_query_arr[0]->ID))?$playlist_get_query_arr[0]->ID:0;	
			}
			
			$top_post_query_fn = $post_query[$all_key_query[0]];
			
			if(isset($first_post_query) && $first_post_query > 0){
				$top_post_query_fn = $first_post_query;
			}
										
		?>			
			<div class="archive-heading playlist-heading">
			
				<a href="<?php echo esc_url(add_query_arg(array('playlist' => $post_id), get_permalink($top_post_query_fn)));?>" class="basic-button basic-button-default"><span><?php echo esc_html__('PLAY ALL VIDEOS', 'vidorev-extensions')?></span> &nbsp; <i class="fa fa-play" aria-hidden="true"></i></a>
				
				<?php do_action( 'vidorev_html_switch_mode', $archive_style );?>	
																	
			</div>
            
            <div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
			
            	<script>
					vidorev_jav_js_object['query_vars'] = <?php echo json_encode($playlist_query->query_vars);?>;
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
                        while($playlist_query->have_posts()):
                            $playlist_query->the_post();			
                            
                            get_template_part( 'template-parts/content', $archive_style );
            
                        endwhile;
                    ?>
                </div>
                
                <?php 
                $pag_type = vidorev_get_option('vid_single_playlist_pag_type', 'vid_playlist_layout_settings', 'loadmore-btn');
                do_action('vidorev_pagination', 'template-parts/content', $archive_style, $pag_type); 
                ?>
            
            </div>
		<?php
			
			$wp_query->max_num_pages = $old_max_num_pages;
			
		endif;
		$post_type_add_param_to_url = NULL;
		$vidorev_check_single_playlist = NULL;
		wp_reset_postdata();
	}
endif;
add_action( 'vidorev_single_custom_listing', 'vidorev_load_videos_in_playlist' );

if(!function_exists('vidorev_single__first_post_playlist')){
	function vidorev_single__first_post_playlist($playlist_id, $pagenum){
		
		$fist_post_return = 0;
		
		$post_query = get_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', true);
		if(!is_array($post_query) || count($post_query)<1){
			return $fist_post_return;
		}
		
		$df_posts_per_page = -1;		
		$vid_playlist_items_per_page_single_post = trim(vidorev_get_option('vid_playlist_items_per_page_single_post', 'vid_playlist_layout_settings', -1));		
		$df_posts_per_page = (is_numeric($vid_playlist_items_per_page_single_post)&&$vid_playlist_items_per_page_single_post>0)?intval($vid_playlist_items_per_page_single_post):-1;
		
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> $df_posts_per_page,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($post_query) ? $post_query : array(),
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
		
		if($df_posts_per_page>0){
			$args_query['paged'] = $pagenum;
		}
		
		$query_items = vidorev_get_option('vid_playlist_query_items', 'vid_playlist_layout_settings', 'default');
		
		switch($query_items){
			case 'default':
				$args_query['orderby'] = 'post__in';
				break;
				
			case 'new':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'DESC';
				break;
				
			case 'old':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'ASC';
				break;
		}
		
		$playlist_query = new WP_Query($args_query);			
		if($playlist_query->have_posts()):
			$playlist_query->the_post();
			$fist_post_return = get_the_ID();
		endif;		
		wp_reset_postdata();
		
		return $fist_post_return;
	}	
}

if ( !function_exists('vidorev_single_post_convert_playlist' ) ):
	function vidorev_single_post_convert_playlist($playlist_id = 0, $style = ''){		
		
		if($playlist_id > 0){
			$_GET['playlist'] = $playlist_id;
		}
		
		$video_ps_link_action = vidorev_get_redux_option('video_ps_link_action', 'no');		
		if($playlist_id == 0 && ($video_ps_link_action == 'playlist' || $video_ps_link_action == 'both') ){
			$at_playlist_id = beeteam368_get_playlist_by_post_id(get_the_ID());	
			if($at_playlist_id > 0){
				$_GET['playlist'] = $at_playlist_id;
			}
		}
		
		if(isset($_GET['playlist'])){
			$playlist = trim($_GET['playlist']);		
			if(is_numeric($playlist)){
				$post_query = get_post_meta($playlist, PLAYLIST_PM_PREFIX.'videos', true);
				if(!is_array($post_query) || count($post_query)<1){
					return;
				}
			}else{
				return;
			}
		}else{
			return;
		}	
		
		$current_post_id = get_the_ID();
		
		global $post_type_add_param_to_url;
		$post_type_add_param_to_url = array(
			'playlist' => $playlist
		);
		
		$df_posts_per_page = -1;		
		$vid_playlist_items_per_page_single_post = trim(vidorev_get_option('vid_playlist_items_per_page_single_post', 'vid_playlist_layout_settings', -1));		
		$df_posts_per_page = (is_numeric($vid_playlist_items_per_page_single_post)&&$vid_playlist_items_per_page_single_post>0)?intval($vid_playlist_items_per_page_single_post):-1;
		$paged = get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
		
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> $df_posts_per_page,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($post_query) ? $post_query : array(),
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
		
		if($df_posts_per_page>0){
			$args_query['paged'] = $paged;
		}
		
		$query_items = vidorev_get_option('vid_playlist_query_items', 'vid_playlist_layout_settings', 'default');
		
		switch($query_items){
			case 'default':
				$args_query['orderby'] = 'post__in';
				break;
				
			case 'new':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'DESC';
				break;
				
			case 'old':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'ASC';
				break;
		}
		
		$playlist_query = new WP_Query($args_query);
		?>
		<div class="site__row playlist-frame playlist-frame-control">
			<div class="site__col player-in-playlist">
				<?php
				if($playlist_id > 0){
					$all_key_query = array_keys($post_query);
					
					if($playlist_query->have_posts()):
						$playlist_get_query_arr = isset($playlist_query->posts)?$playlist_query->posts:array();
			
						if(count($playlist_get_query_arr)>0){
							$first_post_query = (isset($playlist_get_query_arr[0])&&isset($playlist_get_query_arr[0]->ID)&&is_numeric($playlist_get_query_arr[0]->ID))?$playlist_get_query_arr[0]->ID:0;	
						}
					endif;
					
					$top_post_query_fn = $post_query[$all_key_query[0]];
					
					if(isset($first_post_query) && $first_post_query > 0){
						$top_post_query_fn = $first_post_query;
					}
					
					do_action( 'vidorev_single_video_player', 'toolbar', 'vp-small-item sc-video-elm-widget', $top_post_query_fn);
				}else{
					do_action( 'vidorev_single_video_player', 'toolbar', 'vp-small-item');
				}
				?>
			</div>
			<div class="site__col playlist-videos">
				<div class="video-listing video-playlist-listing-control">
					<div class="video-listing-header">
						<h5 class="header-title extra-bold" title="<?php echo esc_attr(get_the_title($playlist));?>"><?php echo esc_html(get_the_title($playlist));?></h5>
						<div class="header-total-videos font-size-12">
							<a href="<?php echo esc_url(get_permalink($playlist))?>" class="neutral" title="<?php echo esc_attr__('View Playlist', 'vidorev-extensions')?>">
								<?php echo count($post_query).' '.esc_html__('Videos', 'vidorev-extensions');?> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
							</a>
						</div>						
					</div>
					<?php
					if($playlist_query->have_posts()):
						
						$top_pl_page = '';
						
						if($df_posts_per_page>0){
							global $wp_query;
							$old_max_num_pages 			= $wp_query->max_num_pages;				
							$wp_query->max_num_pages 	= $playlist_query->max_num_pages;
							
							ob_start();
								do_action('vidorev_pagination', 'template-parts/content', '', 'pagenavi_plugin');
							$output_string = ob_get_contents();
							ob_end_clean();
							$top_pl_page = $output_string;
						}
						
						$current_video_elm = '';
						$video_listing_elm = '';
						?>
						<div class="video-listing-body">
						<?php
						$i = 0;
						while($playlist_query->have_posts()):
							$playlist_query->the_post();
							
							if($i == 0 && $playlist_id > 0){
								$current_post_id = get_the_ID();
							}
							
							if($current_post_id == get_the_ID()){
								ob_start();
								?>
								<div class="video-listing-item video-listing-item-control current-item" data-index="<?php echo esc_attr($i);?>">
									<div class="video-img"><?php if($style=='pe-small-item'){do_action('vidorev_thumbnail', 'vidorev_thumb_2point7x1_3x', 'class-2point7x1', 3, NULL);}else{do_action('vidorev_thumbnail', 'vidorev_thumb_2point7x1_1x', 'class-2point7x1', 3, NULL);}?></div>
									<div class="absolute-gradient"></div>
									<div class="video-content">
										<span class="video-icon small-icon alway-active"></span>
                                        <?php if($style=='pe-small-item'){?>
                                        	<h3 class="h3 h6-mobile post-title"> 
                                                <a class="check-url-control" href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
                                            </h3>
                                        <?php }else{?>
                                            <h3 class="h6 post-title"> 
                                                <a class="check-url-control" href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
                                            </h3>
                                        <?php }?>
										<?php do_action( 'vidorev_posted_on', array('author', '', '', 'view-count', 'like-count', ''), 'archive' ); ?>	
									</div>
								</div>
								<?php
								$output_string = ob_get_contents();
								ob_end_clean();
								$current_video_elm = $output_string;
							}else{
								ob_start();								
							?>
								<div class="video-listing-item video-listing-item-control" data-index="<?php echo esc_attr($i);?>">
									<div class="video-img"><?php do_action('vidorev_thumbnail', 'vidorev_thumb_1x1_1x', 'class-1x1', 3, NULL);?></div>
									<div class="video-content">
										<h3 class="h6 post-title"> 
											<a class="check-url-control" href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
										</h3>
										<?php do_action( 'vidorev_posted_on', array('author', '', '', 'view-count', 'like-count', ''), 'archive' ); ?>	
									</div>
								</div>
							<?php
								$output_string = ob_get_contents();
								ob_end_clean();
								$video_listing_elm.=$output_string;
							}
							$i++;
						endwhile;
						
						if($current_video_elm == ''){
							ob_start();
							?>
							<div class="video-listing-item video-listing-item-control current-item" data-index="<?php echo esc_attr($df_posts_per_page+1);?>">
								<div class="video-img"><?php if($style=='pe-small-item'){do_action('vidorev_thumbnail', 'vidorev_thumb_2point7x1_3x', 'class-2point7x1', 3, $current_post_id);}else{do_action('vidorev_thumbnail', 'vidorev_thumb_2point7x1_1x', 'class-2point7x1', 3, $current_post_id);}?></div>
								<div class="absolute-gradient"></div>
								<div class="video-content">
									<span class="video-icon small-icon alway-active"></span>
									<?php if($style=='pe-small-item'){?>
										<h3 class="h3 h6-mobile post-title"> 
											<a class="check-url-control" href="<?php echo esc_url(vidorev_get_post_url($current_post_id)); ?>" title="<?php echo esc_attr(get_the_title($current_post_id));?>"><?php echo esc_html(get_the_title($current_post_id));?></a> 
										</h3>
									<?php }else{?>
										<h3 class="h6 post-title"> 
											<a class="check-url-control" href="<?php echo esc_url(vidorev_get_post_url($current_post_id)); ?>" title="<?php echo esc_attr(get_the_title($current_post_id));?>"><?php echo esc_html(get_the_title($current_post_id));?></a> 
										</h3>
									<?php }?>
								</div>
							</div>
							<?php
							$output_string = ob_get_contents();
							ob_end_clean();
							$current_video_elm = $output_string;
						}
												
						echo $current_video_elm.$top_pl_page.$video_listing_elm;						
						?>
						</div>
						<?php
						if($df_posts_per_page>0){
							do_action('vidorev_pagination', 'template-parts/content', '', 'pagenavi_plugin');
							$wp_query->max_num_pages = $old_max_num_pages;
						}
					endif;					
					?>
				</div>
				
				<div class="bottom-gradient">
					<div class="absolute-gradient"></div>
				</div>
			</div>
		</div>
		<?php
		wp_reset_postdata();
		$post_type_add_param_to_url = NULL;
	}
endif;
add_action( 'vidorev_single_post_convert_playlist', 'vidorev_single_post_convert_playlist', 10, 2 );

if ( !function_exists('vidorev_get_link_playlist_all' ) ):
	function vidorev_get_link_playlist_all($post_id){
		
		$playlist_all_link = '';
		
		$post_query = get_post_meta($post_id, PLAYLIST_PM_PREFIX.'videos', true);
		
		if(!is_array($post_query) || count($post_query)<1){
			return $playlist_all_link;
		}
		
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> 1,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($post_query) ? $post_query : array(),
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
		
		$query_items = vidorev_get_option('vid_playlist_query_items', 'vid_playlist_layout_settings', 'default');
		
		switch($query_items){
			case 'default':
				$args_query['orderby'] = 'post__in';
				break;
				
			case 'new':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'DESC';
				break;
				
			case 'old':
				$args_query['orderby'] 	= 'date';
				$args_query['order'] 	= 'ASC';
				break;
		}
		
		$playlist_query = get_posts($args_query);		
		if($playlist_query):
			foreach ( $playlist_query as $item) :								
				$playlist_all_link = add_query_arg(array('playlist' => $post_id), get_permalink($item->ID));
				break;
			endforeach;
		endif;
		
		return $playlist_all_link;
	}
endif;

if(!function_exists('beeteam368_custom_page_for_post_playlist')){
	function beeteam368_custom_page_for_post_playlist($result, $pagenum){
		
		if(is_single() && get_post_type()=='post' && get_post_format()=='video' && isset($_GET['playlist']) && is_numeric($_GET['playlist'])){
			
			$fist_post_return = vidorev_single__first_post_playlist($_GET['playlist'], $pagenum);			
			if($fist_post_return>0){
				global $wp_rewrite;
				if ( ! $wp_rewrite->using_permalinks() ) {
					return add_query_arg(array('playlist' => $_GET['playlist'], 'paged' => $pagenum), get_permalink($fist_post_return));
				}else{
					return add_query_arg(array('playlist' => $_GET['playlist']), trailingslashit(get_permalink($fist_post_return)).user_trailingslashit( $wp_rewrite->pagination_base . '/' . $pagenum, 'paged' ));
				}
			}
		
		}
		
		return $result;
	}
}

add_filter('get_pagenum_link', 'beeteam368_custom_page_for_post_playlist', 10, 2);

if(!function_exists('beeteam368_custom_canonical_redirect')){
	function beeteam368_custom_canonical_redirect($redirect_url){
		$paged = get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
		if($paged > 1 && (is_singular('vid_playlist') || is_singular('vid_channel') || is_singular('vid_actor') || is_singular('vid_director') || ( is_single() && get_post_type()=='post' && get_post_format()=='video' && isset($_GET['playlist']) && is_numeric($_GET['playlist']) ) )){
			$redirect_url = false;
		}
		return $redirect_url;
	}
}

add_filter( 'redirect_canonical', 'beeteam368_custom_canonical_redirect', 5, 1);