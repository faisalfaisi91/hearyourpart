<?php

function video() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$slug = ot_get_option('videos_slug');
		$videos_title = ot_get_option('videos_title'); 
	} else { 
		$slug = 'videos_tutorials';
		$videos_title = 'Videos';
	}
    $slug = 'videos_tutorials';
	$labels = array(
		'name'			=> _x( $videos_title, 'post type general name' ),
		'singular_name'		=> _x( 'Video', 'post type singular name' ),
		'add_new'		=> _x( 'Add New', 'video' ),
		'add_new_item'		=> __( 'Add New Video' ),
		'edit_item'		=> __( 'Edit Video' ),
		'new_item'		=> __( 'New Video' ),
		'all_items'		=> __( 'All Videos' ),
		'view_item'		=> __( 'View Video' ),
		'search_items'		=> __( 'Search Videos' ),
		'not_found'		=> __( 'No Videos found' ),
		'not_found_in_trash'	=> __( 'No Videos found in the Trash' ), 
		'parent_item_colon'	=> '',
		'menu_name'		=> 'videos'
	);
	$args = array(
		'labels'			=> $labels,
		'description'		=> 'T20',
		'public'			=> true,
		'menu_position'		=> 10,
		'taxonomies'		=> array('post_tag'),
		'menu_icon'		=> 'dashicons-video-alt2',
		'supports'		=> array( 'title', 'editor', 'thumbnail', 'custom-fields', 'comments' ),
		'has_archive'		=> true,
		'rewrite'			=> array( 'slug' => $slug )
	);
	register_post_type( 'videos', $args );
	if ( !function_exists( 'is_woocommerce' ) ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'video' );

function videos_cat() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$videos_cat_slug = ot_get_option('videos_cat_slug');
		$videos_cat_title = ot_get_option('videos_cat_title');
	} else { 
		$videos_cat_slug = 'videos/category';
		$videos_cat_title = 'Categories';
	}
	$labels = array(
		'name'			=> _x( $videos_cat_title, 'taxonomy general name' ),
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
		'rewrite'			=> array( 'slug' => $videos_cat_slug ),
	);
	register_taxonomy( 'videos_cat', 'videos', $args );
}
add_action( 'init', 'videos_cat', 0 );

function videos_alpha() {
    $theme = wp_get_theme();
    if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) {
        $videos_cat_slug = ot_get_option('videos_cat_slug');
        $videos_cat_title = ot_get_option('videos_cat_title');
    } else {
        $videos_cat_slug = 'videos_tutorials/browse';
        $videos_cat_title = 'Categories';
    }
    $videos_cat_slug = 'videos_tutorials/browse';
    $videos_cat_title = 'Alphabet';
    $labels = array(
        'name'			=> _x( $videos_cat_title, 'taxonomy general name' ),
        'singular_name'		=> _x( 'Alphabet', 'taxonomy singular name' ),
        'search_items'		=> __( 'Search Alphabet' ),
        'all_items'		=> __( 'All Alphabet' ),
        'parent_item'		=> __( 'Parent Alphabet' ),
        'parent_item_colon'	=> __( 'Parent Alphabet:' ),
        'edit_item'		=> __( 'Edit Alphabet' ),
        'update_item'		=> __( 'Update Alphabet' ),
        'add_new_item'		=> __( 'Add New Alphabet' ),
        'new_item_name'	=> __( 'New Alphabet' ),
        'menu_name'		=> __( 'Alphabet' ),
    );
    $args = array(
        'hierarchical'		=> true,
        'labels'			=> $labels,
        'show_ui'		=> true,
        'show_admin_column'	=> true,
        'query_var'		=> true,
        'rewrite'			=> array( 'slug' => $videos_cat_slug ),
    );
    register_taxonomy( 'videos_alpha', 'videos', $args );
}
add_action( 'init', 'videos_alpha', 0 );


add_filter( 'manage_edit-videos_columns', 'my_edit_videos_columns' ) ;
function my_edit_videos_columns( $columns ) {
	$columns = array(
		'cb' => 'cb-select-all-1',
		'cover' => __( 'Cover', 'T20' ),
		'title' => __( 'Title', 'T20' ),
		'artist' => __( 'Artist', 'T20' ),
		'date' => __( 'Date', 'T20' ),
		'comments' => __( 'CM', 'T20' )
	);

	return $columns;
}
add_action( 'manage_videos_posts_custom_column', 'my_manage_videos_columns', 10, 2 );
function my_manage_videos_columns( $column, $post_id ) {
	global $post;
	global $T20_artist_name;
	switch( $column ) {
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