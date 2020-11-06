<?php

function artist() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$slug = ot_get_option('artists_slug'); 
		$artists_title = ot_get_option('artists_title'); 
	} else { 
		$slug = 'artists';
		$artists_title = 'Artists';
	}
	$labels = array(
		'name'			=> _x( $artists_title, 'post type general name' ),
		'singular_name'		=> _x( 'Artist', 'post type singular name' ),
		'add_new'		=> _x( 'Add New', 'artist' ),
		'add_new_item'		=> __( 'Add New Artist' ),
		'edit_item'		=> __( 'Edit Artist' ),
		'new_item'		=> __( 'New Artist' ),
		'all_items'		=> __( 'All Artists' ),
		'view_item'		=> __( 'View Artist' ),
		'search_items'		=> __( 'Search Artists' ),
		'not_found'		=> __( 'No Artists found' ),
		'not_found_in_trash'	=> __( 'No Artists found in the Trash' ), 
		'parent_item_colon'	=> '',
		'menu_name'		=> 'Artists'
	);
	$args = array(
		'labels'			=> $labels,
		'description'		=> 'T20',
		'public'			=> true,
		'menu_position'		=> 10,
		'menu_icon'		=> 'dashicons-groups',
		'supports'		=> array( 'title', 'editor', 'thumbnail', 'custom-fields', 'comments' ),
		'has_archive'		=> true,
		'rewrite'			=> array( 'slug' => $slug )
	);
	register_post_type( 'artists', $args );
	if ( !function_exists( 'is_woocommerce' ) ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'artist' );

function artists_alpha() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$artists_tax_slug = ot_get_option('artists_tax_slug'); 
		$artists_tax_title = ot_get_option('artists_tax_title'); 
	} else { 
		$artists_tax_slug = 'artists/browse';
		$artists_tax_title = 'Alphabet';
	}
	$labels = array(
		'name'			=> _x( $artists_tax_title, 'taxonomy general name' ),
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
		'rewrite'			=> array( 'slug' => $artists_tax_slug ),
	);
	register_taxonomy( 'artist', 'artists', $args );
}
add_action( 'init', 'artists_alpha', 0 );


add_filter( 'manage_edit-artists_columns', 'my_edit_artists_columns' ) ;
function my_edit_artists_columns( $columns ) {
	$columns = array(
		'cb' => 'cb-select-all-1',
		'cover' => __( 'Cover', 'T20' ),
		'title' => __( 'Name', 'T20' ),
		'taxonomy-artist' => __( 'Under', 'T20' ),
		'date' => __( 'Date', 'T20' )
	);

	return $columns;
}
add_action( 'manage_artists_posts_custom_column', 'my_manage_artists_columns', 10, 2 );
function my_manage_artists_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'cover' :
			printf( the_post_thumbnail('thumbnail') );
			break;
		default :
			break;
	}
}
