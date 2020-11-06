<?php
if ( ! function_exists( 'vidorev_register_post_types' ) ) :
	function vidorev_register_post_types() {
		
		$permalinks_p 			= vidorev_get_option('vid_playlist_slug', 'vid_playlist_settings', 'playlist');
		$playlist_permalink 	= (!isset($permalinks_p) || empty($permalinks_p) || $permalinks_p=='')?esc_html_x('playlist', 'slug', 'vidorev-extensions'):$permalinks_p;
		register_post_type('vid_playlist',
			apply_filters('vidorev_register_post_type_video_playlist',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Playlists', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Playlist', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Video Playlists', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Playlist', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Playlist', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Playlist', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Playlist', 'vidorev-extensions'),
							'view'                  => esc_html__('View Playlist', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Playlist', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Playlists', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Playlists found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Playlists found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Playlist', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Playlist Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set playlist image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove playlist image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as playlist image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into playlist', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this playlist', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter playlists', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Playlists navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Playlists list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new playlists to your site.', 'vidorev-extensions'),
					'public'              => true,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false,
					'rewrite'             => $playlist_permalink?array('slug' => untrailingslashit($playlist_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-playlist-video',
					'menu_position'		  => 6,
				)
			)
		);
		
		$tax_playlist 		= vidorev_get_option('vid_playlist_category_base', 'vid_playlist_settings', 'playlist-category');
		$tax_playlist_slug 	= (!isset($tax_playlist) || empty($tax_playlist) || $tax_playlist=='')?esc_html_x('playlist-category', 'slug', 'vidorev-extensions'):$tax_playlist;
		register_taxonomy(
			'vid_playlist_cat',
			apply_filters( 'vidorev_register_taxonomy_objects_playlist_cat', array( 'vid_playlist' ) ),
			apply_filters(
				'vidorev_register_taxonomy_args_playlist_cat', array(
					'hierarchical'          => true,
					'label'                 => esc_html__( 'Categories', 'vidorev-extensions' ),
					'labels'                => array(
						'name'              => esc_html__( 'Playlist categories', 'vidorev-extensions' ),
						'singular_name'     => esc_html__( 'Category', 'vidorev-extensions' ),
						'menu_name'         => esc_html_x( 'Categories', 'Admin menu name', 'vidorev-extensions' ),
						'search_items'      => esc_html__( 'Search categories', 'vidorev-extensions' ),
						'all_items'         => esc_html__( 'All categories', 'vidorev-extensions' ),
						'parent_item'       => esc_html__( 'Parent category', 'vidorev-extensions' ),
						'parent_item_colon' => esc_html__( 'Parent category:', 'vidorev-extensions' ),
						'edit_item'         => esc_html__( 'Edit category', 'vidorev-extensions' ),
						'update_item'       => esc_html__( 'Update category', 'vidorev-extensions' ),
						'add_new_item'      => esc_html__( 'Add new category', 'vidorev-extensions' ),
						'new_item_name'     => esc_html__( 'New category name', 'vidorev-extensions' ),
						'not_found'         => esc_html__( 'No categories found', 'vidorev-extensions' ),
					),
					'show_ui'               => true,
					'query_var'             => true,
					'show_admin_column' 	=> true,					
					'rewrite'          		=> array(
						'slug'         => untrailingslashit($tax_playlist_slug),
						'with_front'   => false,
						'hierarchical' => true,
					),
				)
			)
		);
		
		$permalinks_vc 			= vidorev_get_option('vid_channel_slug', 'vid_channel_settings', 'channel');
		$channel_permalink 		= (!isset($permalinks_vc) || empty($permalinks_vc) || $permalinks_vc=='')?esc_html_x('channel', 'slug', 'vidorev-extensions'):$permalinks_vc;
		register_post_type('vid_channel',
			apply_filters('vidorev_register_post_type_video_channel',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Channels', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Channel', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Video Channels', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Channel', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Channel', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Channel', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Channel', 'vidorev-extensions'),
							'view'                  => esc_html__('View Channel', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Channel', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Channels', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Channels found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Channels found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Channel', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Channel Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set channel image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove channel image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as channel image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into channel', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this channel', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter channels', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Channels navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Channels list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new channels to your site.', 'vidorev-extensions'),
					'public'              => true,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false,
					'rewrite'             => $channel_permalink?array('slug' => untrailingslashit($channel_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', /*'custom-fields'*/),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-welcome-view-site',
					'menu_position'		  => 6,
				)
			)
		);
		
		$tax_channel 		= vidorev_get_option('vid_channel_category_base', 'vid_channel_settings', 'channel-category');
		$tax_channel_slug 	= (!isset($tax_channel) || empty($tax_channel) || $tax_channel=='')?esc_html_x('channel-category', 'slug', 'vidorev-extensions'):$tax_channel;
		register_taxonomy(
			'vid_channel_cat',
			apply_filters( 'vidorev_register_taxonomy_objects_channel_cat', array( 'vid_channel' ) ),
			apply_filters(
				'vidorev_register_taxonomy_args_channel_cat', array(
					'hierarchical'          => true,
					'label'                 => esc_html__( 'Categories', 'vidorev-extensions' ),
					'labels'                => array(
						'name'              => esc_html__( 'Channel categories', 'vidorev-extensions' ),
						'singular_name'     => esc_html__( 'Category', 'vidorev-extensions' ),
						'menu_name'         => esc_html_x( 'Categories', 'Admin menu name', 'vidorev-extensions' ),
						'search_items'      => esc_html__( 'Search categories', 'vidorev-extensions' ),
						'all_items'         => esc_html__( 'All categories', 'vidorev-extensions' ),
						'parent_item'       => esc_html__( 'Parent category', 'vidorev-extensions' ),
						'parent_item_colon' => esc_html__( 'Parent category:', 'vidorev-extensions' ),
						'edit_item'         => esc_html__( 'Edit category', 'vidorev-extensions' ),
						'update_item'       => esc_html__( 'Update category', 'vidorev-extensions' ),
						'add_new_item'      => esc_html__( 'Add new category', 'vidorev-extensions' ),
						'new_item_name'     => esc_html__( 'New category name', 'vidorev-extensions' ),
						'not_found'         => esc_html__( 'No categories found', 'vidorev-extensions' ),
					),
					'show_ui'               => true,
					'query_var'             => true,
					'show_admin_column' 	=> true,					
					'rewrite'          		=> array(
						'slug'         => untrailingslashit($tax_channel_slug),
						'with_front'   => false,
						'hierarchical' => true,
					),
				)
			)
		);
		
		$permalinks_a 		= vidorev_get_option('vid_actor_slug', 'vid_actor_settings', 'actor');
		$actor_permalink 	= (!isset($permalinks_a) || empty($permalinks_a) || $permalinks_a=='')?esc_html_x('actor', 'slug', 'vidorev-extensions'):$permalinks_a;
		register_post_type('vid_actor',
			apply_filters('vidorev_register_post_type_video_actor',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Actors', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Actor', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Video Actors', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Actor', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Actor', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Actor', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Actor', 'vidorev-extensions'),
							'view'                  => esc_html__('View Actor', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Actor', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Actors', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Actors found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Actors found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Actor', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Actor Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set actor image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove actor image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as actor image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into actor', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this actor', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter actors', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Actors navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Actors list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new actors to your site.', 'vidorev-extensions'),
					'public'              => true,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false,
					'rewrite'             => $actor_permalink?array('slug' => untrailingslashit($actor_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-universal-access-alt',
					'menu_position'		  => 6,
				)
			)
		);
		
		$tax_actor 			= vidorev_get_option('vid_actor_category_base', 'vid_actor_settings', 'actor-category');
		$tax_actor_slug 	= (!isset($tax_actor) || empty($tax_actor) || $tax_actor=='')?esc_html_x('actor-category', 'slug', 'vidorev-extensions'):$tax_actor;
		register_taxonomy(
			'vid_actor_cat',
			apply_filters( 'vidorev_register_taxonomy_objects_actor_cat', array( 'vid_actor' ) ),
			apply_filters(
				'vidorev_register_taxonomy_args_actor_cat', array(
					'hierarchical'          => true,
					'label'                 => esc_html__( 'Categories', 'vidorev-extensions' ),
					'labels'                => array(
						'name'              => esc_html__( 'Actor categories', 'vidorev-extensions' ),
						'singular_name'     => esc_html__( 'Category', 'vidorev-extensions' ),
						'menu_name'         => esc_html_x( 'Categories', 'Admin menu name', 'vidorev-extensions' ),
						'search_items'      => esc_html__( 'Search categories', 'vidorev-extensions' ),
						'all_items'         => esc_html__( 'All categories', 'vidorev-extensions' ),
						'parent_item'       => esc_html__( 'Parent category', 'vidorev-extensions' ),
						'parent_item_colon' => esc_html__( 'Parent category:', 'vidorev-extensions' ),
						'edit_item'         => esc_html__( 'Edit category', 'vidorev-extensions' ),
						'update_item'       => esc_html__( 'Update category', 'vidorev-extensions' ),
						'add_new_item'      => esc_html__( 'Add new category', 'vidorev-extensions' ),
						'new_item_name'     => esc_html__( 'New category name', 'vidorev-extensions' ),
						'not_found'         => esc_html__( 'No categories found', 'vidorev-extensions' ),
					),
					'show_ui'               => true,
					'query_var'             => true,
					'show_admin_column' 	=> true,					
					'rewrite'          		=> array(
						'slug'         => untrailingslashit($tax_actor_slug),
						'with_front'   => false,
						'hierarchical' => true,
					),
				)
			)
		);
		
		$permalinks_d 			= vidorev_get_option('vid_director_slug', 'vid_director_settings', 'director');
		$director_permalink 	= (!isset($permalinks_d) || empty($permalinks_d) || $permalinks_d=='')?esc_html_x('director', 'slug', 'vidorev-extensions'):$permalinks_d;
		register_post_type('vid_director',
			apply_filters('vidorev_register_post_type_video_director',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Directors', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Director', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Video Directors', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Director', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Director', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Director', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Director', 'vidorev-extensions'),
							'view'                  => esc_html__('View Director', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Director', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Directors', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Directors found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Directors found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Director', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Director Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set director image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove director image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as director image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into director', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this director', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter directors', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Directors navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Directors list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new directors to your site.', 'vidorev-extensions'),
					'public'              => true,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false,
					'rewrite'             => $director_permalink?array('slug' => untrailingslashit($director_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-businessman',
					'menu_position'		  => 6,
				)
			)
		);
		
		$tax_director 		= vidorev_get_option('vid_director_category_base', 'vid_director_settings', 'director-category');
		$tax_director_slug 	= (!isset($tax_director) || empty($tax_director) || $tax_director=='')?esc_html_x('director-category', 'slug', 'vidorev-extensions'):$tax_director;
		register_taxonomy(
			'vid_director_cat',
			apply_filters( 'vidorev_register_taxonomy_objects_director_cat', array( 'vid_director' ) ),
			apply_filters(
				'vidorev_register_taxonomy_args_director_cat', array(
					'hierarchical'          => true,
					'label'                 => esc_html__( 'Categories', 'vidorev-extensions' ),
					'labels'                => array(
						'name'              => esc_html__( 'Director categories', 'vidorev-extensions' ),
						'singular_name'     => esc_html__( 'Category', 'vidorev-extensions' ),
						'menu_name'         => esc_html_x( 'Categories', 'Admin menu name', 'vidorev-extensions' ),
						'search_items'      => esc_html__( 'Search categories', 'vidorev-extensions' ),
						'all_items'         => esc_html__( 'All categories', 'vidorev-extensions' ),
						'parent_item'       => esc_html__( 'Parent category', 'vidorev-extensions' ),
						'parent_item_colon' => esc_html__( 'Parent category:', 'vidorev-extensions' ),
						'edit_item'         => esc_html__( 'Edit category', 'vidorev-extensions' ),
						'update_item'       => esc_html__( 'Update category', 'vidorev-extensions' ),
						'add_new_item'      => esc_html__( 'Add new category', 'vidorev-extensions' ),
						'new_item_name'     => esc_html__( 'New category name', 'vidorev-extensions' ),
						'not_found'         => esc_html__( 'No categories found', 'vidorev-extensions' ),
					),
					'show_ui'               => true,
					'query_var'             => true,
					'show_admin_column' 	=> true,					
					'rewrite'          		=> array(
						'slug'         => untrailingslashit($tax_director_slug),
						'with_front'   => false,
						'hierarchical' => true,
					),
				)
			)
		);
		
		$permalinks_s 			= vidorev_get_option('vid_series_slug', 'vid_series_settings', 'series');
		$series_permalink 	= (!isset($permalinks_s) || empty($permalinks_s) || $permalinks_s=='')?esc_html_x('series', 'slug', 'vidorev-extensions'):$permalinks_s;
		register_post_type('vid_series',
			apply_filters('vidorev_register_post_type_video_series',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Series', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Series', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Video Series', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Series', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Series', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Series', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Series', 'vidorev-extensions'),
							'view'                  => esc_html__('View Series', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Series', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Series', 'vidorev-extensions'),
							'not_found'             => esc_html__('No series found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No series found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Series', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Series Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set Series image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove Series image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as series image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into series', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this series', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter series', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Series navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Series list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new series to your site.', 'vidorev-extensions'),
					'public'              => true,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false,
					'rewrite'             => $series_permalink?array('slug' => untrailingslashit($series_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-video-alt',
					'menu_position'		  => 6,
				)
			)
		);
		
		$tax_series 		= vidorev_get_option('vid_series_category_base', 'vid_series_settings', 'series-category');
		$tax_series_slug 	= (!isset($tax_series) || empty($tax_series) || $tax_series=='')?esc_html_x('series-category', 'slug', 'vidorev-extensions'):$tax_series;
		register_taxonomy(
			'vid_series_cat',
			apply_filters( 'vidorev_register_taxonomy_objects_series_cat', array( 'vid_series' ) ),
			apply_filters(
				'vidorev_register_taxonomy_args_series_cat', array(
					'hierarchical'          => true,
					'label'                 => esc_html__( 'Categories', 'vidorev-extensions' ),
					'labels'                => array(
						'name'              => esc_html__( 'series categories', 'vidorev-extensions' ),
						'singular_name'     => esc_html__( 'Category', 'vidorev-extensions' ),
						'menu_name'         => esc_html_x( 'Categories', 'Admin menu name', 'vidorev-extensions' ),
						'search_items'      => esc_html__( 'Search categories', 'vidorev-extensions' ),
						'all_items'         => esc_html__( 'All categories', 'vidorev-extensions' ),
						'parent_item'       => esc_html__( 'Parent category', 'vidorev-extensions' ),
						'parent_item_colon' => esc_html__( 'Parent category:', 'vidorev-extensions' ),
						'edit_item'         => esc_html__( 'Edit category', 'vidorev-extensions' ),
						'update_item'       => esc_html__( 'Update category', 'vidorev-extensions' ),
						'add_new_item'      => esc_html__( 'Add new category', 'vidorev-extensions' ),
						'new_item_name'     => esc_html__( 'New category name', 'vidorev-extensions' ),
						'not_found'         => esc_html__( 'No categories found', 'vidorev-extensions' ),
					),
					'show_ui'               => true,
					'query_var'             => true,
					'show_admin_column' 	=> true,					
					'rewrite'          		=> array(
						'slug'         => untrailingslashit($tax_series_slug),
						'with_front'   => false,
						'hierarchical' => true,
					),
				)
			)
		);
		
		$yls_permalink 	= esc_html_x('youtube_broadcast', 'slug', 'vidorev-extensions');
		register_post_type('youtube_broadcast',
			apply_filters('vidorev_register_post_type_youtube_broadcast',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Broadcasts', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Broadcast', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Youtube Live Broadcasts', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Broadcast', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Broadcast', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Broadcast', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Broadcast', 'vidorev-extensions'),
							'view'                  => esc_html__('View Broadcast', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Broadcast', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Broadcasts', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Broadcasts found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Broadcasts found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Broadcast', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Broadcast Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set broadcast image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove broadcast image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as broadcast image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into broadcast', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this broadcast', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter broadcasts', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Broadcasts navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Broadcasts list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new broadcasts to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $yls_permalink?array('slug' => untrailingslashit($yls_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-video-alt3',
					'menu_position'		  => 6,
				)
			)
		);
		
		$ylv_permalink 	= esc_html_x('youtube_live_video', 'slug', 'vidorev-extensions');
		register_post_type('youtube_live_video',
			apply_filters('vidorev_register_post_type_youtube_live_video',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Channels', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Channel', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Youtube Live Video', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Channel', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Channel', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Channel', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Channel', 'vidorev-extensions'),
							'view'                  => esc_html__('View Channel', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Channel', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Channels', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Channels found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Channels found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Channel', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Channel Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set Channel image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove Channel image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as Channel image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into Channel', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this Channel', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter Channels', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Channels navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Channels list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new channels to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $ylv_permalink?array('slug' => untrailingslashit($ylv_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title', 'thumbnail'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-video-alt3',
					'menu_position'		  => 6,
				)
			)
		);
		
		$ama_ass_permalink 	= esc_html_x('amazon_associates', 'slug', 'vidorev-extensions');
		register_post_type('amazon_associates',
			apply_filters('vidorev_register_post_type_amazon_associates',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Amazon Associates', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Amazon Associates', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Amazon Associates', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Affiliate', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Affiliate', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Affiliate', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Affiliate', 'vidorev-extensions'),
							'view'                  => esc_html__('View Affiliate', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Affiliate', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Affiliates', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Affiliates found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Affiliates found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Affiliate', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Affiliate Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set affiliate image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove affiliate image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as affiliate image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into affiliate', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this affiliate', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter Affiliates', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Affiliates navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Affiliates list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new Affiliates to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $ama_ass_permalink?array('slug' => untrailingslashit($ama_ass_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-networking',
					'menu_position'		  => 6,
				)
			)
		);
		
		$vr_permalink 	= esc_html_x('video_report_check', 'slug', 'vidorev-extensions');
		register_post_type('video_report_check',
			apply_filters('vidorev_register_post_type_video_report_check',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Video Reports', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Video Report', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Video Reports', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Report', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Report', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Report', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Report', 'vidorev-extensions'),
							'view'                  => esc_html__('View Report', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Report', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Reports', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Reports found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Reports found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Report', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Report Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set report image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove report image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as report image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into report', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this report', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter reports', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Reports navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Reports list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new reports to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $vr_permalink?array('slug' => untrailingslashit($vr_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-info',
					'menu_position'		  => 6,
					'capabilities'		  => array(
						'create_posts' => 'do_not_allow',
					),
				)
			)
		);
		
		$usp_permalink 	= esc_html_x('video_user_submit', 'slug', 'vidorev-extensions');
		register_post_type('video_user_submit',
			apply_filters('vidorev_register_post_type_video_user_submit',
				array(
					'labels'              => array(
							'name'                  => esc_html__('User-Submitted', 'vidorev-extensions'),
							'singular_name'         => esc_html__('User-Submitted', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('User Submit', 'Admin Menu Name', 'vidorev-extensions'),
							'all_items'				=> esc_html__('Videos Awaiting Review', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add User-Submitted', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New User-Submitted', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit User-Submitted', 'vidorev-extensions'),
							'new_item'              => esc_html__('New User-Submitted', 'vidorev-extensions'),
							'view'                  => esc_html__('View User-Submitted', 'vidorev-extensions'),
							'view_item'             => esc_html__('View User-Submitted', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search User-Submitted', 'vidorev-extensions'),
							'not_found'             => esc_html__('No User-Submitted found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No User-Submitted found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent User-Submitted', 'vidorev-extensions'),
							'featured_image'        => esc_html__('User-Submitted Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set User-Submitted image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove User-Submitted image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as User-Submitted image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into User-Submitted', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this User-Submitted', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter User-Submitted', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('User-Submitted navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('User-Submitted list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new User-Submitted to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $usp_permalink?array('slug' => untrailingslashit($usp_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-welcome-add-page',
					'menu_position'		  => 6,
					'capabilities'		  => array(
						'create_posts' 		=> 'do_not_allow',
						'publish_posts'    	=> 'do_not_allow',
					),
				)
			)
		);
		
		$uspp_permalink 	= esc_html_x('playlist_user_submit', 'slug', 'vidorev-extensions');
		register_post_type('playlist_user_submit',
			apply_filters('vidorev_register_post_type_playlist_user_submit',
				array(
					'labels'              => array(
							'name'                  => esc_html__('User-Submitted', 'vidorev-extensions'),
							'singular_name'         => esc_html__('User-Submitted', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('User Submit', 'Admin Menu Name', 'vidorev-extensions'),
							'all_items'				=> esc_html__('Playlists Awaiting Review', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add User-Submitted', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New User-Submitted', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit User-Submitted', 'vidorev-extensions'),
							'new_item'              => esc_html__('New User-Submitted', 'vidorev-extensions'),
							'view'                  => esc_html__('View User-Submitted', 'vidorev-extensions'),
							'view_item'             => esc_html__('View User-Submitted', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search User-Submitted', 'vidorev-extensions'),
							'not_found'             => esc_html__('No User-Submitted found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No User-Submitted found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent User-Submitted', 'vidorev-extensions'),
							'featured_image'        => esc_html__('User-Submitted Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set User-Submitted image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove User-Submitted image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as User-Submitted image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into User-Submitted', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this User-Submitted', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter User-Submitted', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('User-Submitted navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('User-Submitted list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new User-Submitted to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $uspp_permalink?array('slug' => untrailingslashit($uspp_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-welcome-add-page',
					'show_in_menu'		  => 'edit.php?post_type=video_user_submit',
					'menu_position'		  => 2,
					'capabilities'		  => array(
						'create_posts' 		=> 'do_not_allow',
						'publish_posts'    	=> 'do_not_allow',
					),
				)
			)
		);
		
		$uspc_permalink 	= esc_html_x('channel_user_submit', 'slug', 'vidorev-extensions');
		register_post_type('channel_user_submit',
			apply_filters('vidorev_register_post_type_channel_user_submit',
				array(
					'labels'              => array(
							'name'                  => esc_html__('User-Submitted', 'vidorev-extensions'),
							'singular_name'         => esc_html__('User-Submitted', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('User Submit', 'Admin Menu Name', 'vidorev-extensions'),
							'all_items'				=> esc_html__('Channels Awaiting Review', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add User-Submitted', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New User-Submitted', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit User-Submitted', 'vidorev-extensions'),
							'new_item'              => esc_html__('New User-Submitted', 'vidorev-extensions'),
							'view'                  => esc_html__('View User-Submitted', 'vidorev-extensions'),
							'view_item'             => esc_html__('View User-Submitted', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search User-Submitted', 'vidorev-extensions'),
							'not_found'             => esc_html__('No User-Submitted found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No User-Submitted found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent User-Submitted', 'vidorev-extensions'),
							'featured_image'        => esc_html__('User-Submitted Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set User-Submitted image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove User-Submitted image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as User-Submitted image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into User-Submitted', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this User-Submitted', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter User-Submitted', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('User-Submitted navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('User-Submitted list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new User-Submitted to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $uspc_permalink?array('slug' => untrailingslashit($uspc_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-welcome-add-page',
					'show_in_menu'		  => 'edit.php?post_type=video_user_submit',
					'menu_position'		  => 3,
					'capabilities'		  => array(
						'create_posts' 		=> 'do_not_allow',
						'publish_posts'    	=> 'do_not_allow',
					),
				)
			)
		);
		
		
		$ya_ass_permalink 	= esc_html_x('youtube_automatic', 'slug', 'vidorev-extensions');
		register_post_type('youtube_automatic',
			apply_filters('vidorev_register_post_type_youtube_automatic',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Youtube Automatic', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Youtube Automatic', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Youtube Automatic', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Source', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Source', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Source', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Source', 'vidorev-extensions'),
							'view'                  => esc_html__('View Source', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Source', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search Sources', 'vidorev-extensions'),
							'not_found'             => esc_html__('No Sources found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No Sources found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Source', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Source Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set Source image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove Source image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as Source image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into Source', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this Source', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Filter Sources', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Sources navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Sources list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new Source ( Youtube Import ) to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $ya_ass_permalink?array('slug' => untrailingslashit($ya_ass_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'menu_icon'			  => 'dashicons-video-alt3',
					'menu_position'		  => 6,
				)
			)
		);
		
	}
endif;
add_action('init', 'vidorev_register_post_types', 5);
 
if(!function_exists('beeteam368_add_role_caps')){
	function beeteam368_add_role_caps() {
		
		add_role( 'video_manager', esc_html__('Video Manager', 'vidorev-extensions'), array( 'read' => true ) );	
			
		$roles = array('administrator', 'video_manager');	
		foreach($roles as $the_role) { 
		
			$role = get_role($the_role);
						
			$role->add_cap( 'read' );
						
			$role->add_cap( 'edit_beeteam368_manager' );
			$role->add_cap( 'read_beeteam368_manager' );
			$role->add_cap( 'delete_beeteam368_manager' );
			$role->add_cap( 'edit_beeteam368_managers' );
			$role->add_cap( 'edit_others_beeteam368_managers' );
			$role->add_cap( 'publish_beeteam368_managers' );
			$role->add_cap( 'read_private_beeteam368_managers' );
			$role->add_cap( 'delete_beeteam368_managers' );
			$role->add_cap( 'delete_private_beeteam368_managers' );
			$role->add_cap( 'delete_published_beeteam368_managers' );
			$role->add_cap( 'delete_others_beeteam368_managers' );
			$role->add_cap( 'edit_private_beeteam368_managers' );
			$role->add_cap( 'edit_published_beeteam368_managers' );			
			
			$role->add_cap( 'manage_beeteam368_manager_terms' );
			$role->add_cap( 'edit_beeteam368_manager_terms' );
			$role->add_cap( 'delete_beeteam368_manager_terms' );
			$role->add_cap( 'assign_beeteam368_manager_terms' );
		
		}
	}
}
add_action('admin_init', 'beeteam368_add_role_caps', 999);