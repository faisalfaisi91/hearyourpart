<?php

function gallerys() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$slug = ot_get_option('gallery_slug');
		$gallery_title = ot_get_option('gallery_title');
	} else { 
		$slug = 'gallery'; 
		$gallery_title = 'Gallery';
	}
	$labels = array(
		'name'			=> _x( $gallery_title, 'post type general name' ),
		'singular_name'		=> _x( 'Gallery', 'post type singular name' ),
		'add_new'		=> _x( 'Add New', 'gallery' ),
		'add_new_item'		=> __( 'Add New Gallery' ),
		'edit_item'		=> __( 'Edit Gallery' ),
		'new_item'		=> __( 'New Gallery' ),
		'all_items'		=> __( 'All Galleries' ),
		'view_item'		=> __( 'View Gallery' ),
		'search_items'		=> __( 'Search Galleries' ),
		'not_found'		=> __( 'No Galleries found' ),
		'not_found_in_trash'	=> __( 'No Galleries found in the Trash' ), 
		'parent_item_colon'	=> '',
		'menu_name'		=> 'gallery'
	);
	$args = array(
		'labels'			=> $labels,
		'description'		=> 'T20',
		'public'			=> true,
		'menu_position'		=> 10,
		'menu_icon'		=> 'dashicons-images-alt',
		'supports'		=> array( 'title', 'editor', 'thumbnail', 'custom-fields', 'comments' ),
		'has_archive'		=> true,
		'rewrite'			=> array( 'slug' => $slug )
	);
	register_post_type( 'gallery', $args );
	if ( !function_exists( 'is_woocommerce' ) ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'gallerys' );

function gallery_cat() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$gallery_cat_slug = ot_get_option('gallery_cat_slug');
		$gallery_cat_title = ot_get_option('gallery_cat_title');
	} else { 
		$gallery_cat_slug = 'gallery/category';
		$gallery_cat_title = 'Categories';
	}
	$labels = array(
		'name'			=> _x( $gallery_cat_title, 'taxonomy general name' ),
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
		'rewrite'			=> array( 'slug' => $gallery_cat_slug ),
	);
	register_taxonomy( 'gallery_cat', 'gallery', $args );
}
add_action( 'init', 'gallery_cat', 0 );

add_filter( 'manage_edit-gallery_columns', 'my_edit_gallery_columns' ) ;
function my_edit_gallery_columns( $columns ) {
	$columns = array(
		'cb' => 'cb-select-all-1',
		'cover' => __( 'Cover', 'T20' ),
		'title' => __( 'Gallery Title', 'T20' ),
		'date' => __( 'Date', 'T20' ),
		'comments' => __( 'CM', 'T20' )
	);

	return $columns;
}
add_action( 'manage_gallery_posts_custom_column', 'my_manage_gallery_columns', 10, 2 );
function my_manage_gallery_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'cover' :
			printf( the_post_thumbnail('thumbnail') );
			break;
		default :
			break;
	}
}