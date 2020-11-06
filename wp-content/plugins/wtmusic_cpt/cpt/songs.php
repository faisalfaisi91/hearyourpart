<?php

if ( ! function_exists( 'T20_artist_name_link' ) ) {
	function T20_artist_name_link() {
		$theme = wp_get_theme();
		if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
			global $post;
			$output = '';
			$array = get_post_meta($post->ID,'artist_nameaa',true);
			if ($array !== '') {
				if (is_array($array)) {
					$len = count($array);
					if ($len === 1) {
						$single_artist_id = implode(",", $array);
						$single_artist = get_post( $single_artist_id );
						$output .= '<a class="n_m" href="'.get_post_permalink($single_artist).'">'.( $single_artist->post_title ).'</a>';
					} else {
						$elements = array();
						foreach($array as $selectedOption) {
							$multiple_artist = get_post( $selectedOption );
							$elements[] = '<a class="n_m" href="'.get_post_permalink($multiple_artist).'">'.( $multiple_artist->post_title ).'</a>';
						}
						$output .= implode(', ', $elements);
					}
				} else {
					$single_artist = get_post( $array );
					$output .= '<a class="n_m" href="'.get_post_permalink($single_artist).'">'.( $single_artist->post_title ).'</a>';
				}
			}

			return $output;
		}
	}
}

function song() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$slug = ot_get_option('songs_slug');
		$songs_title = ot_get_option('songs_title');
	} else { 
		$slug = 'songs';
		$songs_title = 'Songs';
	}
	$labels = array(
		'name'			=> _x( $songs_title, 'post type general name' ),
		'singular_name'		=> _x( 'Song', 'post type singular name' ),
		'add_new'		=> _x( 'Add New', 'song' ),
		'add_new_item'		=> __( 'Add New Song' ),
		'edit_item'		=> __( 'Edit Song' ),
		'new_item'		=> __( 'New Song' ),
		'all_items'		=> __( 'All Songs' ),
		'view_item'		=> __( 'View Song' ),
		'search_items'		=> __( 'Search Songs' ),
		'not_found'		=> __( 'No Songs found' ),
		'not_found_in_trash'	=> __( 'No Songs found in the Trash' ), 
		'parent_item_colon'	=> '',
		'menu_name'		=> 'Songs'
	);
	$args = array(
		'labels'			=> $labels,
		'description'		=> 'T20',
		'public'			=> true,
		'menu_position'		=> 10,
		'taxonomies'		=> array('post_tag'),
		'menu_icon'		=> 'dashicons-playlist-audio',
		'supports'		=> array( 'title', 'editor', 'thumbnail', 'custom-fields', 'comments' ),
		'has_archive'		=> true,
		'rewrite'			=> array( 'slug' => $slug )
	);
	register_post_type( 'songs', $args );
	if ( !function_exists( 'is_woocommerce' ) ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'song' );

function songs_cat() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$songs_cat_slug = ot_get_option('songs_cat_slug');
		$songs_cat_title = ot_get_option('songs_cat_title');
	} else { 
		$songs_cat_slug = 'songs/category';
		$songs_cat_title = 'Categories';
	}
	$labels = array(
		'name'			=> _x( $songs_cat_title, 'taxonomy general name' ),
		'singular_name'		=> _x( 'Category', 'taxonomy singular name' ),
		'search_items'		=> __( 'Search Category' ),
		'all_items'		=> __( 'All Categories' ),
		'parent_item'		=> __( 'Parent Category' ),
		'parent_item_colon'	=> __( 'Parent Category:' ),
		'edit_item'		=> __( 'Edit Category' ), 
		'update_item'		=> __( 'Update Category' ),
		'add_new_item'		=> __( 'Add New Category' ),
		'new_item_name'	=> __( 'New Category' ),
		'menu_name'		=> __( 'Categories' ),
	);
	$args = array(
		'hierarchical'		=> true,
		'labels'			=> $labels,
		'show_ui'		=> true,
		'show_admin_column'	=> true,
		'query_var'		=> true,
		'rewrite'			=> array( 'slug' => $songs_cat_slug ),
	);
	register_taxonomy( 'songs_cat', 'songs', $args );
}
add_action( 'init', 'songs_cat', 0 );

add_filter( 'manage_edit-songs_columns', 'my_edit_songs_columns' ) ;
function my_edit_songs_columns( $columns ) {
	$columns = array(
		'cb' => 'cb-select-all-1',
		'cover' => __( 'Cover', 'T20' ),
		'title' => __( 'Title', 'T20' ),
		'artist' => __( 'Artist', 'T20' ),
		'date' => __( 'Release', 'T20' ),
		'plays' => __( 'Plays', 'T20' ),
		'like' => __( 'Likes', 'T20' ),
		'dislike' => __( 'Dislikes', 'T20' ),
		'download' => __( 'Downloads', 'T20' ),
		'comments' => __( 'CM', 'T20' )
	);

	return $columns;
}

add_action( 'manage_songs_posts_custom_column', 'my_manage_songs_columns', 10, 2 );
function my_manage_songs_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'plays' :
			$plays = get_post_meta( $post_id, 'ozy_post_plays_count', true );
			if ( empty( $plays ) )
				echo '0';
			else
				printf( '%s', $plays );
			break;
		case 'like' :
			$like = get_post_meta( $post_id, 'like', true );
			if ( empty( $like ) )
				echo '0';
			else
				printf( '%s', $like );
			break;
		case 'dislike' :
			$dislike = get_post_meta( $post_id, 'dislike', true );
			if ( empty( $dislike ) )
				echo '0';
			else
				printf( '%s', $dislike );
			break;
		case 'download' :
			$download = get_post_meta( $post_id, 'download_count', true );
			if ( empty( $download ) )
				echo '0';
			else
				printf( '%s', $download );
			break;
		case 'artist' :
			printf( T20_artist_name_link() );
			break;
		case 'cover' :
			printf( the_post_thumbnail('thumbnail') );
			break;
		default :
			break;
	}
}

add_action('admin_head', 're_admin_head');
function re_admin_head() {
	echo '<style type="text/css">';
	echo 'th#artist, th#plays, th#like, th#dislike, th#taxonomy-artist { width: 12% } th#cover { width: 42px } .cover img, .riv_post_thumbs img { border-radius: 100%;width: 40px;height: 40px }';
	echo '.dashicons-format-audio:before, .menu-icon-artists .dashicons-admin-users:before, .dashicons-video-alt3:before, .dashicons-format-gallery:before, .dashicons-calendar:before {color: #2ea2cc !important }';
	echo '.wp-has-current-submenu .dashicons-format-audio:before, .wp-has-current-submenu .dashicons-admin-users:before, .wp-has-current-submenu .dashicons-video-alt3:before, .wp-has-current-submenu .dashicons-format-gallery:before, .wp-has-current-submenu .dashicons-calendar:before {color: #fff !important }';
	echo '</style>';
}

add_filter( 'manage_edit-songs_sortable_columns', 'my_songs_sortable_columns' );
function my_songs_sortable_columns( $columns ) {
	$columns['artist'] = 'artist';
	$columns['plays'] = 'plays';
	$columns['like'] = 'like';
	$columns['dislike'] = 'dislike';
	$columns['download'] = 'download';
	return $columns;
}

add_action( 'load-edit.php', 'my_edit_songs_load' );
function my_edit_songs_load() {
	add_filter( 'request', 'my_sort_songs' );
}
function my_sort_songs( $vars ) {
	if ( isset( $vars['post_type'] ) && 'songs' == $vars['post_type'] ) {
		if ( isset( $vars['orderby'] ) && 'artist' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'artist_nameaa',
					'orderby' => 'meta_value'
				)
			);
		}
		if ( isset( $vars['orderby'] ) && 'like' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'like',
					'orderby' => 'meta_value_num'
				)
			);
		}
		if ( isset( $vars['orderby'] ) && 'dislike' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'dislike',
					'orderby' => 'meta_value_num'
				)
			);
		}
		if ( isset( $vars['orderby'] ) && 'download' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'download_count',
					'orderby' => 'meta_value_num'
				)
			);
		}
		if ( isset( $vars['orderby'] ) && 'plays' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'ozy_post_plays_count',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}
	return $vars;
}