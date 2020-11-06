<?php
if(!function_exists('beeteam368_get_user_role')){
	function beeteam368_get_user_role(){
		if(is_user_logged_in()){
			$current_user 	= wp_get_current_user();
			$user_meta      = get_userdata( $current_user->ID );
			$user_roles 	= $user_meta->roles;
			if ( in_array( 'administrator', $user_roles, true ) ) {
				return true;
			}
		}
		
		return false;
	}
}

if ( ! function_exists( 'vidorev_playlist_metaboxes' ) ) :
	function vidorev_playlist_metaboxes() {
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$prefix = PLAYLIST_PM_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'video_ids_in_playlist',
			'title'         => esc_html__( 'Add Video To Playlist', 'vidorev-extensions'),
			'object_types'  => array( 'vid_playlist' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Videos', 'vidorev-extensions'),
			'id'        	=> $prefix . 'videos',
			'type'      	=> 'custom_attached_posts',			
			'column'  		=> false,
			'options' 		=> array(
				'show_thumbnails' => true,
				'filter_boxes'    => true,
				'query_args'      => array(
					'posts_per_page'	=> 5,
					'post_type'    	 	=> 'post',
					'tax_query' 		=> array(
                                        		array(
													'taxonomy'  => 'post_format',
													'field'    	=> 'slug',
													'terms'     => array('post-format-video'),
													'operator'  => 'IN',
                                        		),
                                    		),

				),
			),
		));
	}
endif;
add_action( 'cmb2_init', 'vidorev_playlist_metaboxes' );

if ( ! function_exists( 'vidorev_actor_director_metaboxes' ) ) :
	function vidorev_actor_director_metaboxes() {
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$prefix = MOVIE_PM_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'actor_director_biography',
			'title'         => esc_html__( 'Biography', 'vidorev-extensions'),
			'object_types'  => array( 'vid_actor', 'vid_director' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Biographical', 'vidorev-extensions'),
			'id'        	=> $prefix . 'biography',
			'type'      	=> 'wysiwyg',			
			'column'  		=> false,
			'options' => array(
				'textarea_rows' => 10,
			),			
		));
		
		$cmb_adda = new_cmb2_box( array(
			'id'            => 'actor_director_banner',
			'title'         => esc_html__( 'Header Background', 'vidorev-extensions'),
			'object_types'  => array( 'vid_actor', 'vid_director' ),
			'context'       => 'side',
			'priority'      => 'low',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb_adda->add_field( array(
			'name'      	=> esc_html__( 'Image', 'vidorev-extensions'),
			'id'        	=> $prefix . 'background_adda',
			'type'      	=> 'file',
			'show_names'    => true,			
			'options' 		=> array(
				'url' => false,				
			),
			'preview_size' => 'medium'
		));
	}
endif;
add_action( 'cmb2_init', 'vidorev_actor_director_metaboxes' );

if ( ! function_exists( 'vidorev_channel_metaboxes' ) ) :
	function vidorev_channel_metaboxes() {
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
				
		$prefix = CHANNEL_PM_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'video_ids_in_channel',
			'title'         => esc_html__( 'Add Video To Channel', 'vidorev-extensions'),
			'object_types'  => array( 'vid_channel' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Videos', 'vidorev-extensions'),
			'id'        	=> $prefix . 'videos',
			'type'      	=> 'custom_attached_posts',			
			'column'  		=> false,
			'options' 		=> array(
				'show_thumbnails' => true,
				'filter_boxes'    => true,
				'query_args'      => array(
					'posts_per_page'	=> 5,
					'post_type'    	 	=> 'post',
					'tax_query' 		=> array(
                                        		array(
													'taxonomy'  => 'post_format',
													'field'    	=> 'slug',
													'terms'     => array('post-format-video'),
													'operator'  => 'IN',
                                        		),
                                    		),

				),
			),
		));
		
		$cmb_p = new_cmb2_box( array(
			'id'            => 'playlist_ids_in_channel',
			'title'         => esc_html__( 'Add Playlist To Channel', 'vidorev-extensions'),
			'object_types'  => array( 'vid_channel' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb_p->add_field( array(
			'name'      	=> esc_html__( 'Playlists', 'vidorev-extensions'),
			'id'        	=> $prefix . 'playlists',
			'type'      	=> 'custom_attached_posts',			
			'column'  		=> false,
			'options' 		=> array(
				'show_thumbnails' => true,
				'filter_boxes'    => true,
				'query_args'      => array(
					'posts_per_page'	=> 5,
					'post_type'    	 	=> 'vid_playlist',
				),
			),
		));
		
		$cmb_s = new_cmb2_box( array(
			'id'            => 'series_ids_in_channel',
			'title'         => esc_html__( 'Add Series To Channel', 'vidorev-extensions'),
			'object_types'  => array( 'vid_channel' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb_s->add_field( array(
			'name'      	=> esc_html__( 'Series', 'vidorev-extensions'),
			'id'        	=> $prefix . 'series',
			'type'      	=> 'custom_attached_posts',			
			'column'  		=> false,
			'options' 		=> array(
				'show_thumbnails' => true,
				'filter_boxes'    => true,
				'query_args'      => array(
					'posts_per_page'	=> 5,
					'post_type'    	 	=> 'vid_series',
				),
			),
		));
		
		$cmb_ava = new_cmb2_box( array(
			'id'            => 'channel_images',
			'title'         => esc_html__( 'Images', 'vidorev-extensions'),
			'object_types'  => array( 'vid_channel' ),
			'context'       => 'side',
			'priority'      => 'low',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb_ava->add_field( array(
			'name'      	=> esc_html__( 'Channel Logo', 'vidorev-extensions'),
			'id'        	=> $prefix . 'logo',
			'type'      	=> 'file',
			'show_names'    => true,			
			'options' 		=> array(
				'url' => false,				
			),
			'preview_size' => 'medium'
		));
		
		$cmb_ava->add_field( array(
			'name'      	=> esc_html__( 'Channel Header Banner', 'vidorev-extensions'),
			'id'        	=> $prefix . 'banner',
			'type'      	=> 'file',
			'show_names'    => true,			
			'options' 		=> array(
				'url' => false,				
			),
			'preview_size' => 'medium'
		));
	}
endif;
add_action( 'cmb2_init', 'vidorev_channel_metaboxes' );

if ( ! function_exists( 'vidorev_movie_metaboxes' ) ) :
	function vidorev_movie_metaboxes() {
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$prefix = MOVIE_PM_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'poster_feature_image',
			'title'         => esc_html__( 'Poster Image', 'vidorev-extensions'),
			'object_types'  => array( 'post' ),
			'context'       => 'side',
			'priority'      => 'low',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Poster Image', 'vidorev-extensions'),
			'id'        	=> $prefix . 'poster_image',
			'type'      	=> 'file',
			'show_names'    => false,
			'desc'			=> esc_html__( 'If you are using the image ratio is "2: 3" (movie), you can replace the basic image of WordPress with this option.', 'vidorev-extensions'),
			'options' 		=> array(
				'url' => false,
				
			),
			'preview_size' => 'medium'
		));
		
		$cmb_gif = new_cmb2_box( array(
			'id'            => 'gif_feature_image',
			'title'         => esc_html__( 'Gif Image', 'vidorev-extensions'),
			'object_types'  => array( 'post' ),
			'context'       => 'side',
			'priority'      => 'low',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb_gif->add_field( array(
			'name'      	=> esc_html__( 'Gif Image', 'vidorev-extensions'),
			'id'        	=> $prefix . 'gif_image',
			'type'      	=> 'file',
			'show_names'    => false,
			'desc'			=> esc_html__( 'If you are using the gif image, you can replace the basic image of WordPress with this option.', 'vidorev-extensions'),
			'options' 		=> array(
				'url' => false,
				
			),
			'preview_size' => 'medium'
		));
		
		$cmb_movie = new_cmb2_box( array(
			'id'            => 'video_movie_settings',
			'title'         => esc_html__( 'Movie Settings', 'vidorev-extensions'),
			'object_types'  => array( 'post' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb_movie->add_field( array(
			'name'      	=> esc_html__( 'Director', 'vidorev-extensions'),
			'id'        	=> $prefix . 'director',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing director name', 'vidorev-extensions'),
			'limit'      	=> 50, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'vid_director' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb_movie->add_field( array(
			'name'      	=> esc_html__( 'Actor (Starts)', 'vidorev-extensions'),
			'id'        	=> $prefix . 'actor',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing Actor name', 'vidorev-extensions'),
			'limit'      	=> 50, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'vid_actor' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb_movie->add_field( array(
			'name' 			=> esc_html__( 'IMDb Movie ID ( IMDb Plugins )', 'vidorev-extensions'),
			'desc' 			=> esc_html__( 'Please refer to the manual for this item in the documentation.', 'vidorev-extensions'),
			'id'			=> $prefix . 'imdb_ratings',
			'type' 			=> 'text'
		));
		
		$cmb_movie->add_field( array(
			'name'      	=> esc_html__( 'Amazon Associates', 'vidorev-extensions'),
			'id'        	=> $prefix . 'amazon_associates',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing Amazon Associates name', 'vidorev-extensions'),
			'limit'      	=> 1, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'amazon_associates' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb_movie->add_field(array(
			'name' 			=> esc_html__( 'TMDB Movie Block', 'vidorev-extensions'),
			'desc' 			=> esc_html__( 'Start typing movie name. Eg: fast & furious, 127 hours...', 'vidorev-extensions'),
			'id'			=> $prefix .'vid_tmdb_movie',
			'type' 			=> 'text',
			'column'  		=> false,
			'render_row_cb' => 'beeteam368_custom_field_tmdb_search',
			'save_field' 	=> true,
		));
		
		$cmb_movie->add_field(array(
			'name' 			=> esc_html__( 'TMDB TV-Shows Block', 'vidorev-extensions'),
			'desc' 			=> esc_html__( 'Start typing TV-Shows name. Eg: The Good Doctor, The Flash...', 'vidorev-extensions'),
			'id'			=> $prefix .'vid_tmdb_tv_shows',
			'type' 			=> 'text',
			'column'  		=> false,
			'render_row_cb' => 'beeteam368_custom_field_tmdb_search_tv_shows',
			'save_field' 	=> true,
		));
		
		$cmb_movie->add_field( array(
			'name'      	=> esc_html__( 'TMDB - Automatically generate the Post Thumbnail', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'vid_tmdb_thumb',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'backdrop_sizes',	
			'options'       => array(
				'backdrop_sizes' 	=> esc_html__('YES - Movie Backdrop', 'vidorev-extensions'),
				'poster_sizes' 		=> esc_html__('YES - Movie Poster', 'vidorev-extensions'),
				'backdrop_sizes_tv' => esc_html__('YES - TV-Shows Backdrop', 'vidorev-extensions'),
				'poster_sizes_tv' 	=> esc_html__('YES - TV-Shows Poster', 'vidorev-extensions'),				
				'no' 				=> esc_html__('NO', 'vidorev-extensions'),
			),			
		));
	}
endif;
add_action( 'cmb2_init', 'vidorev_movie_metaboxes' );

if ( ! function_exists( 'vidorev_youtube_broadcasts_metaboxes' ) ) :
	function vidorev_youtube_broadcasts_metaboxes() {
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$prefix = YOUTUBE_BROADCASTS_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'vid_youtube_broadcasts_settings',
			'title'         => esc_html__( 'Youtube Live BroadCasts Settings', 'vidorev-extensions'),
			'object_types'  => array( 'youtube_broadcast' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Broadcast Title', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'broadcast_title',
			'type'      	=> 'text',			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Query', 'vidorev-extensions'),
			'desc'			=> wp_kses(
								__('The <strong>Query</strong> parameter specifies the query term to search for.
								<br>Your request can also use the Boolean NOT (-) and OR (|) operators to exclude videos or to find videos that are associated with one of several search terms. For example, to search for videos matching either "boating" or "sailing", set the <strong>Query</strong> parameter value to <strong>boating|sailing</strong>. Similarly, to search for videos matching either "boating" or "sailing" but not "fishing", set the <strong>Query</strong> parameter value to <strong>boating|sailing -fishing</strong>. Note that the pipe character must be URL-escaped when it is sent in your API request. The URL-escaped value for the pipe character is <strong>%7C</strong>.', 
								'vidorev-extensions'
								),
								array(
									'br'=>array(), 
									'strong'=>array()
								)
							),
			'id'        	=> $prefix . 'q',
			'type'      	=> 'text',			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Channel ID', 'vidorev-extensions'),
			'desc'			=> wp_kses(
								__('The channelId parameter indicates that the API response should only contain resources created by the channel.
								<br><strong>Note</strong>: Search results are constrained to a maximum of 500 videos if your request specifies a value for the channelId parameter and sets the type parameter value to video.', 
								'vidorev-extensions'
								),
								array(
									'br'=>array(), 
									'strong'=>array()
								)
							),
			'id'        	=> $prefix . 'channelid',
			'type'      	=> 'text',			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Video Category ID', 'vidorev-extensions'),
			'desc'			=> wp_kses(
								__('The <strong>Video Category Id</strong> parameter filters video search results based on their <a href="https://developers.google.com/youtube/v3/docs/videoCategories/list" target="_blank">category</a>.', 'vidorev-extensions'),
								array(
									'br'=>array(), 
									'strong'=>array(),
									'a'=>array('href'=>array(), 'target'=>array())
								)
							),
			'id'        	=> $prefix . 'videocategoryid',
			'type'      	=> 'text',			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Max Results', 'vidorev-extensions'),
			'desc'			=> wp_kses(
								__('The maxResults parameter specifies the maximum number of items that should be returned in the result set. Acceptable values are <strong>0</strong> to <strong>50</strong>, inclusive. The default value is <strong>5</strong>.', 'vidorev-extensions'),
								array(
									'br'=>array(), 
									'strong'=>array()
								)
							),
			'id'        	=> $prefix . 'maxresults',
			'type'      	=> 'text',			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Order', 'vidorev-extensions'),
			'desc'			=> wp_kses(
								__('The order parameter specifies the method that will be used to order resources in the API response. The default value is <strong>relevance</strong>.<br><br>
									Acceptable values are:<br>
									<strong>Date</strong> – Resources are sorted in reverse chronological order based on the date they were created.<br>
									<strong>Rating</strong> – Resources are sorted from highest to lowest rating.<br>
									<strong>Relevance</strong> – Resources are sorted based on their relevance to the search query. This is the default value for this parameter.<br>
									<strong>Title</strong> – Resources are sorted alphabetically by title.<br>
									<strong>VideoCount</strong> – Channels are sorted in descending order of their number of uploaded videos.<br>
									<strong>ViewCount</strong> – Resources are sorted from highest to lowest number of views. For live broadcasts, videos are sorted by number of concurrent viewers while the broadcasts are ongoing.', 
									'vidorev-extensions'),
								array(
									'br'=>array(), 
									'strong'=>array()
								)
							),
			'id'        	=> $prefix . 'order',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'relevance',	
			'options'       => array(
				'relevance' 	=> esc_html__('Relevance', 'vidorev-extensions'),
				'date'    		=> esc_html__('Date', 'vidorev-extensions'),
				'rating'   		=> esc_html__('Rating', 'vidorev-extensions'),
				'title'   		=> esc_html__('Title', 'vidorev-extensions'),
				'videoCount'    => esc_html__('Video Count', 'vidorev-extensions'),
				'viewCount'    	=> esc_html__('View Count', 'vidorev-extensions'),
									
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Region Code', 'vidorev-extensions'),
			'desc'			=> wp_kses(
								__('The <strong>regionCode</strong> parameter instructs the API to return search results for videos that can be viewed in the specified country. The parameter value is an 
								<a href="https://www.iso.org/iso-3166-country-codes.html" target="_blank">ISO 3166-1 alpha-2</a> country code.', 'vidorev-extensions'),
								array(
									'br'=>array(), 
									'strong'=>array(),
									'a'=>array('href'=>array(), 'target'=>array())
								)
							),
			'id'        	=> $prefix . 'regioncode',
			'type'      	=> 'text',			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Video Syndicated', 'vidorev-extensions'),	
			'desc'			=> wp_kses(
								__('The <strong>Video Syndicated</strong> parameter lets you to restrict a search to only videos that can be played outside youtube.com.', 'vidorev-extensions'),
								array(
									'br'=>array(), 
									'strong'=>array(),
									'a'=>array('href'=>array(), 'target'=>array())
								)
							),		
			'id'        	=> $prefix . 'videosyndicated',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'true',	
			'options'       => array(
				'true' 		=> esc_html__('Only retrieve syndicated videos', 'vidorev-extensions'),
				'any' 		=> esc_html__('Return all videos, syndicated or not', 'vidorev-extensions'),													
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Style', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'style',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'default-3columns',	
			'options'       => array(
				'default-3columns' 	=> esc_html__('Default - 03 Columns', 'vidorev-extensions'),
				'default-4columns' 	=> esc_html__('Default - 04 Columns', 'vidorev-extensions'),
				'default-fw-st' 	=> esc_html__('Default - Full Width', 'vidorev-extensions'),													
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Automatic refresh after first load', 'vidorev-extensions'),	
			'desc'			=> esc_html__('Only enable this feature when your website uses caches.', 'vidorev-extensions'),		
			'id'        	=> $prefix . 'reload_first',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'off',	
			'options'       => array(
				'off' 		=> esc_html__('TURN OFF', 'vidorev-extensions'),
				'on' 		=> esc_html__('TURN ON', 'vidorev-extensions'),													
			),			
		));
	}
endif;
add_action( 'cmb2_init', 'vidorev_youtube_broadcasts_metaboxes' );

if ( ! function_exists( 'vidorev_video_report_info_display_callback' ) ) :
	function vidorev_video_report_info_display_callback( $post ) {
		$post_id 	= $post->ID;
		$explode_id = explode('|', get_post_meta($post_id, 'post_report_id', true));
		
		ob_start();
		?>
			<div class="cmb2-wrap form-table">
				<div class="cmb2-metabox cmb-field-list">
				
					<div class="cmb-row">
						<div class="cmb-th">
							<label><?php esc_html_e('Reasons', 'vidorev-extensions')?></label>
						</div>
						<div class="cmb-td">
							<code><?php echo esc_html(get_post_meta($post_id, 'post_report_seasons', true));?></code>	
						</div>
					</div>	
					<?php if(is_array($explode_id) && count($explode_id) == 2 && is_numeric($explode_id[0]) && is_numeric($explode_id[1])){?>
					
						<div class="cmb-row">
							<div class="cmb-th">
								<label><?php esc_html_e('Action', 'vidorev-extensions')?></label>
							</div>
							<div class="cmb-td">
								<?php
								echo 	wp_kses(
									__('<a href="'.esc_url(get_edit_post_link($explode_id[0])).'" target="_blank">Edit Post</a> | <a href="'.esc_url(get_permalink($explode_id[0])).'" target="_blank">View Post</a>', 'vidorev-extensions'
									),
									array(
										'a'=>array('href' => array(), 'target' => array()),
									)
								); 
								?>	
							</div>
						</div>	
					
						<div class="cmb-row">
							<div class="cmb-th">
								<label><?php esc_html_e('User Report', 'vidorev-extensions')?></label>
							</div>
							<div class="cmb-td">
								<?php
								$user_obj = get_user_by('id', $explode_id[1]); 
								if($user_obj){
									echo 	wp_kses(
										__('User Name: <strong>'.$user_obj->user_login.'</strong> | <a href="'.esc_url(get_edit_user_link($user_obj->ID)).'" target="_blank">View User</a>', 'vidorev-extensions'
										),
										array(
											'a'=>array('href' => array(), 'target' => array()),
											'strong'=>array(),
										)
									);
								}
								?>
							</div>
						</div>	
					<?php }?>					
					
				</div>
			</div>
		<?php
		$output_string = ob_get_contents();
		ob_end_clean();		
		echo $output_string;
	}
endif;	

if ( ! function_exists( 'vidorev_video_report_info_display' ) ) :
	function vidorev_video_report_info_display() {
		add_meta_box( 'video_report_information', esc_html__( 'Video reporting information', 'vidorev-extensions' ), 'vidorev_video_report_info_display_callback', 'video_report_check', 'normal', 'high' );
	}
endif;
add_action( 'add_meta_boxes', 'vidorev_video_report_info_display' );

if ( ! function_exists( 'vidorev_video_series_settings' ) ){
	function vidorev_video_series_settings(){
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$prefix = MOVIE_PM_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'video_series_settings',
			'title'         => esc_html__( 'Video Series Settings', 'vidorev-extensions'),
			'object_types'  => array( 'vid_series' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Style', 'vidorev-extensions'),			
			'id'        	=> 'video_series_style',
			'type'      	=> 'select',			
			'column'  		=> false,
			'desc'        	=> esc_html__('Select default style for this series. Select "Default" to use settings in Theme Options > Single Video Settings.', 'vidorev-extensions'),
			'default'		=> '',	
			'options'       => array(
				'' 				=> esc_html__('Default', 'vidorev-extensions'),
				'inline' 		=> esc_html__('Inline', 'vidorev-extensions'),
				'dd' 			=> esc_html__('Dropdown', 'vidorev-extensions'),
				'grid' 			=> esc_html__('Grid', 'vidorev-extensions'),													
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Director', 'vidorev-extensions'),
			'id'        	=> $prefix . 'director',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing director name', 'vidorev-extensions'),
			'limit'      	=> 50, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'vid_director' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Actor (Starts)', 'vidorev-extensions'),
			'id'        	=> $prefix . 'actor',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing Actor name', 'vidorev-extensions'),
			'limit'      	=> 50, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'vid_actor' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb->add_field( array(
			'name' 			=> esc_html__( 'IMDb Movie ID ( IMDb Plugins )', 'vidorev-extensions'),
			'desc' 			=> esc_html__( 'Please refer to the manual for this item in the documentation.', 'vidorev-extensions'),
			'id'			=> $prefix . 'imdb_ratings',
			'type' 			=> 'text'
		));
		
		$cmb->add_field(array(
			'name' 			=> esc_html__( 'TMDB TV-Shows Block', 'vidorev-extensions'),
			'desc' 			=> esc_html__( 'Start typing TV-Shows name. Eg: The Good Doctor, The Flash...', 'vidorev-extensions'),
			'id'			=> $prefix .'vid_tmdb_tv_shows',
			'type' 			=> 'text',
			'column'  		=> false,
			'render_row_cb' => 'beeteam368_custom_field_tmdb_search_tv_shows',
			'save_field' 	=> true,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'TMDB - Automatically generate the Post Thumbnail', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'vid_tmdb_thumb',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'backdrop_sizes',	
			'options'       => array(
				'backdrop_sizes_tv' => esc_html__('YES - TV-Shows Backdrop', 'vidorev-extensions'),
				'poster_sizes_tv' 	=> esc_html__('YES - TV-Shows Poster', 'vidorev-extensions'),				
				'no' 				=> esc_html__('NO', 'vidorev-extensions'),
			),			
		));
		
		$group = $cmb->add_field(array(
			'id'          => 'video_series_group',
			'type'        => 'group',			
			'options'     => array(
				'group_title'   => esc_html__( 'Video Series {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add More Series', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Series', 'vidorev-extensions'),
				'sortable'      => false,
				'closed'		=> false,
			),
			'repeatable'  => true,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'group_name',
			'name' 			=> esc_html__( 'Group Name', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'item_name',
			'name' 			=> esc_html__( 'Item Name', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'name'      	=> esc_html__( 'Videos', 'vidorev-extensions'),
			'id'        	=> 'videos',
			'type'      	=> 'custom_attached_posts',			
			'column'  		=> false,
			'options' 		=> array(
				'show_thumbnails' => true,
				'filter_boxes'    => true,
				'query_args'      => array(
					'posts_per_page'	=> 10,
					'post_type'    	 	=> 'post',
					'tax_query' 		=> array(
                                        		array(
													'taxonomy'  => 'post_format',
													'field'    	=> 'slug',
													'terms'     => array('post-format-video'),
													'operator'  => 'IN',
                                        		),
                                    		),

				),
			),
		));
	}
}
add_action( 'cmb2_init', 'vidorev_video_series_settings' );

if ( ! function_exists( 'vidorev_amazon_associates_settings' ) ){
	function vidorev_amazon_associates_settings(){
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$cmb = new_cmb2_box( array(
			'id'            => 'amazon_associates_settings',
			'title'         => esc_html__( 'Amazon Associates', 'vidorev-extensions'),
			'object_types'  => array( 'amazon_associates' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(			
			'id'        	=> 'amazon_associates',
			'name'      	=> esc_html__( 'Amazon Product Links [ HTML Code - iframe ]', 'vidorev-extensions'),
			'type'      	=> 'textarea_code',
			'options' 		=> array( 'disable_codemirror' => true ),			
			'column'  		=> false,
			'desc'        	=> 	wp_kses(__(
									'Enter HTML Code For Product Link.
									<br><br><strong>For example:</strong><br><br>
									<code>&#x3C;iframe style=&#x22;width:120px;height:240px;&#x22; marginwidth=&#x22;0&#x22; marginheight=&#x22;0&#x22; scrolling=&#x22;no&#x22; frameborder=&#x22;0&#x22; 
src=&#x22;//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&#x26;OneJS=1&#x26;Operation=GetAdHtml&#x26;MarketPlace=US&#x26;source=ac&#x26;ref=qf_sp_asin_til&#x26;ad_type=product_link&#x26;tracking_id=beeteam368-20&#x26;marketplace=amazon&#x26;region=US&#x26;placement=B0018OFN1S&#x26;asins=B0018OFN1S&#x26;linkId=f8b40122557ffe24d239ffc5553a3325&#x26;show_border=false&#x26;link_opens_in_new_window=true&#x26;price_color=333333&#x26;title_color=bf0000&#x26;bg_color=ffffff&#x22;&#x3E;
&#x3C;/iframe&#x3E;</code>', 'vidorev-extensions'), 
									array('br'=>array(), 'code'=>array(), 'strong'=>array())		
								),				
		));	
			
		$cmb->add_field( array(			
			'id'        	=> 'amazon_native_ad',
			'name'      	=> esc_html__( 'Amazon Native Shopping Ads [ Javascript Code ]', 'vidorev-extensions'),
			'type'      	=> 'textarea_code',
			'options' 		=> array( 'disable_codemirror' => true ),			
			'column'  		=> false,
			'desc'        	=> 	wp_kses(__(
									'Curate specific products from Amazon that you would like to recommend and place the ad unit into your webpage.
									<br><br><strong>For example:</strong><br><br>
									<code>&#x3C;script type=&#x22;text/javascript&#x22;&#x3E;
amzn_assoc_placement = &#x22;adunit0&#x22;;
amzn_assoc_tracking_id = &#x22;beeteam368-20&#x22;;
amzn_assoc_ad_mode = &#x22;search&#x22;;
amzn_assoc_ad_type = &#x22;smart&#x22;;
amzn_assoc_marketplace = &#x22;amazon&#x22;;
amzn_assoc_region = &#x22;US&#x22;;
amzn_assoc_default_search_phrase = &#x22;fast&#x22;;
amzn_assoc_default_category = &#x22;All&#x22;;
amzn_assoc_linkid = &#x22;6126e1d8dc0ef4f4f895d4437637ef7a&#x22;;
amzn_assoc_search_bar = &#x22;true&#x22;;
amzn_assoc_search_bar_position = &#x22;top&#x22;;
amzn_assoc_title = &#x22;Shop Related Products&#x22;;
&#x3C;/script&#x3E;
&#x3C;script src=&#x22;//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US&#x22;&#x3E;&#x3C;/script&#x3E;</code>', 'vidorev-extensions'), 
									array('br'=>array(), 'code'=>array(), 'strong'=>array())		
								),				
		));	
	}
}
add_action( 'cmb2_init', 'vidorev_amazon_associates_settings' );

if ( ! function_exists( 'vidorev_video_user_submit_info_display_callback' ) ) :
	function vidorev_video_user_submit_info_display_callback( $post ) {
		$post_type  = $post->post_type;
		$post_id 	= $post->ID;
		$submit_id	= $post_id;
		switch($post_type){
			case 'video_user_submit':
				$submit_id = get_post_meta($post_id, 'video_id', true);
				break;
				
			case 'playlist_user_submit':
				$submit_id = get_post_meta($post_id, 'u_playlist_id', true);
				break;
				
			case 'channel_user_submit':
				$submit_id = get_post_meta($post_id, 'u_channel_id', true);
				break;		
		}
		
		ob_start();
		?>
			<div class="cmb2-wrap form-table">
				<div class="cmb2-metabox cmb-field-list">
				
					<div class="cmb-row">
						<div class="cmb-th">
							<label><?php esc_html_e('First Name', 'vidorev-extensions')?></label>
						</div>
						<div class="cmb-td">
							<?php echo get_post_meta($post_id, 'first_name', true);?>
						</div>
					</div>
					
					<div class="cmb-row">
						<div class="cmb-th">
							<label><?php esc_html_e('Last Name', 'vidorev-extensions')?></label>
						</div>
						<div class="cmb-td">
							<?php echo get_post_meta($post_id, 'last_name', true);?>
						</div>
					</div>
					
					<div class="cmb-row">
						<div class="cmb-th">
							<label><?php esc_html_e('Email', 'vidorev-extensions')?></label>
						</div>
						<div class="cmb-td">
							<?php echo get_post_meta($post_id, 'email', true);?>
						</div>
					</div>
					
					<div class="cmb-row">
						<div class="cmb-th">
							<label><?php esc_html_e('Check Post', 'vidorev-extensions')?></label>
						</div>
						<div class="cmb-td">
							<?php
							$post_status = get_post_status( $submit_id );
							if($post_status == 'publish'){
								$html_status = '<span class="small-publish-status">'.esc_html__('PUBLISH', 'vidorev-extensions').'</span>';
							}else{
								$html_status = '<span class="big-publish-status">'.esc_html__('PENDING', 'vidorev-extensions').'</span>';
							}
							
							echo 	wp_kses(
										__('Status: '.$html_status.' | <a href="'.esc_url(get_edit_post_link($submit_id)).'" target="_blank">'.esc_html__('Edit Post', 'vidorev-extensions').'</a> | <a href="'.esc_url(get_permalink($submit_id)).'" target="_blank">'.esc_html__('View Post', 'vidorev-extensions').'</a>', 'vidorev-extensions'
										),
										array(
											'a'=>array('href' => array(), 'target' => array()),
											'span'=>array('class' => array()),
										)
									);
							?>
						</div>
					</div>
					
					<div class="cmb-row">
						<div class="cmb-th">
							<label><?php esc_html_e('User Submit', 'vidorev-extensions')?></label>
						</div>
						<div class="cmb-td">
							<?php
							$user_obj = get_user_by('id', get_post_meta($post_id, 'user_id', true));
							if($user_obj){
							
								echo 	wp_kses(
											__('User Name: <strong>'.$user_obj->user_login.'</strong> | <a href="'.esc_url(get_edit_user_link($user_obj->ID)).'" target="_blank">'.esc_html__('View User', 'vidorev-extensions').'</a>', 'vidorev-extensions'
											),
											array(
												'a'=>array('href' => array(), 'target' => array()),
												'strong'=>array(),
											)
										);
							}else{
								
								echo esc_html__('Unknown', 'vidorev-extensions');
								
							}
							?>
						</div>
					</div>
					
				</div>
			</div>
		<?php
		$output_string = ob_get_contents();
		ob_end_clean();		
		echo $output_string;
	}
endif;	

if ( ! function_exists( 'vidorev_video_user_submit_info_display' ) ) :
	function vidorev_video_user_submit_info_display() {
		add_meta_box( 'video_user_submit_information', esc_html__( 'Information', 'vidorev-extensions' ), 'vidorev_video_user_submit_info_display_callback', 'video_user_submit', 'normal', 'high' );
		add_meta_box( 'playlist_user_submit_information', esc_html__( 'Information', 'vidorev-extensions' ), 'vidorev_video_user_submit_info_display_callback', 'playlist_user_submit', 'normal', 'high' );
		add_meta_box( 'channel_user_submit_information', esc_html__( 'Information', 'vidorev-extensions' ), 'vidorev_video_user_submit_info_display_callback', 'channel_user_submit', 'normal', 'high' );
	}
endif;
add_action( 'add_meta_boxes', 'vidorev_video_user_submit_info_display' );

if ( ! function_exists( 'beeteam368_youtube_automatic' ) ) :
	function beeteam368_youtube_automatic() {
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$prefix = YOUTUBE_AUTOMATIC_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'vid_youtube_automatic_settings',
			'title'         => esc_html__( 'Youtube Automatic Settings', 'vidorev-extensions'),
			'object_types'  => array( 'youtube_automatic' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Youtube Source', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'youtube_source',
			'type'      	=> 'text',	
			'desc'			=> wp_kses(
											__('Paste your channel or playlist url to here.
											<br><br><strong>For Example:</strong>											
											<br>https://www.youtube.com/user/Battlefield
											<br>https://www.youtube.com/channel/UCoDcFZ5KZ0KwBC_omalJuiA
											<br>https://www.youtube.com/playlist?list=PLZeek85Kuka2o8JkicDxLOh47frrPi10X', 
											'vidorev-extensions'
											),
											array(
												'br'=>array(), 
												'strong'=>array(),
												's'=>array()
											)
								),		
			'column'  		=> false,			
		));
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Update Every', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'update_every',
			'type'          => 'own_slider',			
			'column'  		=> false,
			'min'         	=> '1',
			'max'         	=> '1440',
			'step'        	=> '1',
			'default'     	=> '200',
			'value_label' 	=> '',		
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Update Unit', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'update_unit',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'minutes',	
			'options'       => array(
				'minutes'		=> esc_html__('Minutes', 'vidorev-extensions'),
				'hours'			=> esc_html__('Hours', 'vidorev-extensions'),
				'days' 			=> esc_html__('Days', 'vidorev-extensions'),									
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Categories', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'categories',
			'taxonomy'     	=> 'category',
			'type'          => 'taxonomy_multicheck_hierarchical',			
			'column'  		=> false,
			'text'           => array(
				'no_terms_text' => esc_html__( 'Sorry, no terms could be found', 'vidorev-extensions')
			),			
		));
		
				
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Published After', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'published_after',
			'type'          => 'text_date',			
			'column'  		=> false,
			'date_format'	=> 'Y-m-d',	
			'desc'			=> esc_html__( 'Only work with Channels. The Published After parameter indicates that the API response should only contain resources created at or after the specified time. Eg: 2019-01-01', 'vidorev-extensions'),
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'published Before', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'published_before',
			'type'          => 'text_date',			
			'column'  		=> false,
			'date_format'	=> 'Y-m-d',	
			'desc'			=> esc_html__( 'Only work with Channels. The published Before parameter indicates that the API response should only contain resources created before or at the specified time. Eg: 2019-12-31', 'vidorev-extensions'),
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Playlists', 'vidorev-extensions'),
			'id'        	=> $prefix . 'playlists',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing playlist name', 'vidorev-extensions'),
			'limit'      	=> 50, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'vid_playlist' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Channels', 'vidorev-extensions'),
			'id'        	=> $prefix . 'channels',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing channel name', 'vidorev-extensions'),
			'limit'      	=> 50, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'vid_channel' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Director', 'vidorev-extensions'),
			'id'        	=> $prefix . 'director',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing director name', 'vidorev-extensions'),
			'limit'      	=> 50, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'vid_director' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Actor (Starts)', 'vidorev-extensions'),
			'id'        	=> $prefix . 'actor',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing Actor name', 'vidorev-extensions'),
			'limit'      	=> 50, 		
			'sortable' 	 	=> true,
			'query_args'	=> array(
				'post_type'			=> array( 'vid_actor' ),
				'post_status'		=> array( 'publish' ),
				'posts_per_page'	=> -1
			)
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Author', 'vidorev-extensions'),
			'id'        	=> $prefix . 'author',
			'type'      	=> 'post_search_ajax',
			'desc'			=> esc_html__( 'Start typing author name', 'vidorev-extensions'),
			'limit'      	=> 1, 		
			'sortable' 	 	=> false,
			'object_type'	=> 'user',			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Fetch Video Published Date', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'import_post_date',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'yes',	
			'options'       => array(
				'yes' 		=> esc_html__('YES', 'vidorev-extensions'),
				'no' 		=> esc_html__('NO', 'vidorev-extensions'),											
			),			
		));
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Post Status', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'status',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'publish',	
			'options'       => array(
				'publish' 	=> esc_html__('Published', 'vidorev-extensions'),
				'draft' 	=> esc_html__('Draft', 'vidorev-extensions'),
				'pending' 	=> esc_html__('Pending', 'vidorev-extensions'),
				'private' 	=> esc_html__('Private', 'vidorev-extensions'),												
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'API Key for this task', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'sub_api_key',
			'type'          => 'text',			
			'column'  		=> false,
			'desc'			=> esc_html__( 'Use in case your main API is overloaded', 'vidorev-extensions'),
		));
		
	}
endif;
add_action( 'cmb2_init', 'beeteam368_youtube_automatic' );

if(!function_exists('vidorev_general_settings_register_fields')){
	function vidorev_general_settings_register_fields(){
		register_setting('general', 'vidorev_amp_url_settings', 'esc_attr');
		add_settings_field('vidorev_amp_url_settings', '<label for="vidorev_amp_url_settings">'.esc_html__('AMP IFRAME (URL)' , 'vidorev-extensions' ).'</label>' , 'vidorev_general_settings_fields_html', 'general');
	}
}

if(!function_exists('vidorev_general_settings_fields_html')){
	function vidorev_general_settings_fields_html(){
		$value = trim(get_option( 'vidorev_amp_url_settings', '' ));
		echo '<input type="url" class="regular-text code" id="vidorev_amp_url_settings" name="vidorev_amp_url_settings" value="' . esc_attr($value) . '">';
	}
}

add_action('admin_init', 'vidorev_general_settings_register_fields', 1);

if ( ! function_exists( 'vidorev_youtube_live_video_metaboxes' ) ) :
	function vidorev_youtube_live_video_metaboxes() {
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$prefix = YOUTUBE_LIVE_VIDEO_PREFIX;
		
		$cmb = new_cmb2_box( array(
			'id'            => 'vid_youtube_live_video_settings',
			'title'         => esc_html__( 'Youtube Live Vieo Settings', 'vidorev-extensions'),
			'object_types'  => array( 'youtube_live_video' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Channel Name', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'channel_name',
			'type'      	=> 'text',
			'desc'			=> wp_kses(
								__('Displays the current YouTube live video from a specified channel via the shortcode or Elementor Widget.<br>
								Your YouTube livestream must be set to "Public" or it will not work. This is a security feature of YouTube\'s API and unfortunately there\'s no way to work around it.<br>
								In addition, your live stream must be set to allow embedding on third-party sites. If that feature is unavailable, you may need to enable monetization for your account. See YouTube documentation for more information or help with allowing embedding.
								', 'vidorev-extensions'),
								array(
									'br'=>array(), 
									'strong'=>array()
								)
							),			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Title', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'live_video_title',
			'type'      	=> 'text',			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Channel URL', 'vidorev-extensions'),
			'desc'			=> wp_kses(
								__(	'Paste your channel url to here. 
									<br><br><strong>For Example:</strong>
									<br>https://www.youtube.com/user/cattrumpetmusic
									<br>https://www.youtube.com/channel/UCByBXiL8TC7atFvIuNC95Hg', 
								'vidorev-extensions'),
								array(
									'br'=>array(), 
									'strong'=>array()
								)
							),
			'id'        	=> $prefix . 'channel_id',
			'type'      	=> 'text',			
			'column'  		=> false,			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Auto Refresh', 'vidorev-extensions'),	
			'desc'			=> esc_html__('You can also enable auto-refresh to automatically check for a live video every 10 minutes (warning: Will consume your API resources. Make sure your quota is big enough to use it).', 'vidorev-extensions'),		
			'id'        	=> $prefix . 'auto_refresh',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'on',	
			'options'       => array(
				'on' 		=> esc_html__('TURN ON', 'vidorev-extensions'),		
				'off' 		=> esc_html__('TURN OFF', 'vidorev-extensions'),															
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Display Information', 'vidorev-extensions'),	
			'id'        	=> $prefix . 'display_info',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'on',	
			'options'       => array(
				'on' 		=> esc_html__('TURN ON', 'vidorev-extensions'),		
				'off' 		=> esc_html__('TURN OFF', 'vidorev-extensions'),															
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Player', 'vidorev-extensions'),				
			'id'        	=> $prefix . 'player',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'plyr',	
			'options'       => array(
				'plyr' 		=> esc_html__('PLYR', 'vidorev-extensions'),		
				'youtube' 	=> esc_html__('Youtube', 'vidorev-extensions'),															
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Autoplay (for desktop)', 'vidorev-extensions'),	
			'id'        	=> $prefix . 'autoplay',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'on',	
			'options'       => array(
				'on' 		=> esc_html__('TURN ON', 'vidorev-extensions'),		
				'off' 		=> esc_html__('TURN OFF', 'vidorev-extensions'),															
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Fallback options', 'vidorev-extensions'),	
			'desc'			=> esc_html__('If no live video is available when a page is loaded, several fallback options are available', 'vidorev-extensions'),		
			'id'        	=> $prefix . 'fallback_options',
			'type'      	=> 'select',			
			'column'  		=> false,
			'default'		=> 'recent_video',	
			'options'       => array(
				'recent_video' 			=> esc_html__('Show Recent Video From Channel', 'vidorev-extensions'),						
				'scheduled_live_video' 	=> esc_html__('Show Scheduled Live Videos', 'vidorev-extensions'),
				'completed_live_video' 	=> esc_html__('Show Last Completed Live Video', 'vidorev-extensions'),				
				/*'custom_html' 			=> esc_html__('Show a Custom HTML Message', 'vidorev-extensions'),*/														
			),			
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Language Code', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'lang',
			'type'          => 'text',
			'default'		=> 'en-US',				
			'column'  		=> false,
			'desc'			=> esc_html__( 'Include a fallback language, default: en-US [ Get your code here: http://www.lingoes.net/en/translator/langcode.htm ]', 'vidorev-extensions'),
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'timeZone', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'timezone',
			'type'          => 'text',
			'default'		=> 'America/New_York',				
			'column'  		=> false,
			'desc'			=> esc_html__( 'Include a fallback language, default: America/New_York [ Get your code here: https://www.zeitverschiebung.net/en/ ]', 'vidorev-extensions'),
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Youtube Data API Key Private', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'sub_api_key',
			'type'          => 'text',			
			'column'  		=> false,
			'desc'			=> esc_html__( 'Use in case your main API is overloaded', 'vidorev-extensions'),
		));
		
		$cmb->add_field( array(
			'name'      	=> esc_html__( 'Youtube Data API Key Public', 'vidorev-extensions'),			
			'id'        	=> $prefix . 'sub_api_key_public',
			'type'          => 'text',			
			'column'  		=> false,
			'desc'			=> esc_html__( 'Use in case your main API is overloaded [Restriction = Domain]', 'vidorev-extensions'),
		));
		
		/*
		$cmb->add_field( array(			
			'id'        	=> $prefix . 'custom_html',
			'name'      	=> esc_html__('ustom HTML Message', 'vidorev-extensions'),					
			'type'      	=> 'textarea_code',							
			'column'  		=> false,			
			'attributes' => array(
				'data-conditional-id'    => $prefix . 'fallback_options',
				'data-conditional-value' => 'custom_html',
			),			
		));
		*/
		
	}
endif;
add_action( 'cmb2_init', 'vidorev_youtube_live_video_metaboxes' );