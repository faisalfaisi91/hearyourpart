<?php

function event() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$slug = ot_get_option('events_slug');
		$events_title = ot_get_option('events_title'); 
	} else { 
		$slug = 'events';
		$events_title = 'Events'; 
	}
	$labels = array(
		'name'			=> _x( $events_title, 'post type general name' ),
		'singular_name'		=> _x( 'Event', 'post type singular name' ),
		'add_new'		=> _x( 'Add New', 'event' ),
		'add_new_item'		=> __( 'Add New Event' ),
		'edit_item'		=> __( 'Edit Event' ),
		'new_item'		=> __( 'New Event' ),
		'all_items'		=> __( 'All Events' ),
		'view_item'		=> __( 'View Event' ),
		'search_items'		=> __( 'Search Events' ),
		'not_found'		=> __( 'No Events found' ),
		'not_found_in_trash'	=> __( 'No Events found in the Trash' ), 
		'parent_item_colon'	=> '',
		'menu_name'		=> 'events'
	);
	$args = array(
		'labels'			=> $labels,
		'description'		=> 'T20',
		'public'			=> true,
		'menu_position'		=> 10,
		'menu_icon'		=> 'dashicons-megaphone',
		'supports'		=> array( 'title', 'editor', 'thumbnail', 'custom-fields', 'comments' ),
		'has_archive'		=> true,
		'rewrite'			=> array( 'slug' => $slug )
	);
	register_post_type( 'events', $args );
	if ( !function_exists( 'is_woocommerce' ) ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'event' );

function event_cat() {
	$theme = wp_get_theme();
	if ( 'wtmusic' === $theme->name || 'wtmusic Child' === $theme->name ) { 
		$event_cat_slug = ot_get_option('event_cat_slug');
		$event_cat_title = ot_get_option('event_cat_title');
	} else { 
		$event_cat_slug = 'events/category';
		$event_cat_title = 'Categories';
	}
	$labels = array(
		'name'			=> _x( $event_cat_title, 'taxonomy general name' ),
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
		'rewrite'			=> array( 'slug' => $event_cat_slug ),
	);
	register_taxonomy( 'event_cat', 'events', $args );
}
add_action( 'init', 'event_cat', 0 );

add_filter( 'manage_edit-events_columns', 'my_edit_events_columns' ) ;
function my_edit_events_columns( $columns ) {
	$columns = array(
		'cb' => 'cb-select-all-1',
		'cover' => __( 'Cover', 'T20' ),
		'title' => __( 'Title', 'T20' ),
		'edate' => __( 'Event Date', 'T20' ),
		'venue' => __( 'Venue', 'T20' ),
		'status' => __( 'Button', 'T20' ),
		'artist' => __( 'Artist', 'T20' ),
		'comments' => __( 'CM', 'T20' )
	);

	return $columns;
}

add_action( 'manage_events_posts_custom_column', 'my_manage_events_columns', 10, 2 );
function my_manage_events_columns( $column, $post_id ) {
	global $post;
	global $T20_artist_name;
	switch( $column ) {
		case 'edate' :
			$edate = date("j F, Y - H:i", strtotime(get_post_meta($post->ID,'date_event',true)));
			if ( empty( $edate ) )
				echo 'Unknown';
			else
				printf( '%s', $edate );
			break;
		case 'venue' :
			$venue = get_post_meta( $post_id, 'venue_event', true );
			if ( empty( $venue ) )
				echo 'Unknown';
			else
				printf( '%s', $venue );
			break;
		case 'status' :
			$status = get_post_meta( $post_id, 'buy_event', true );
			if ( empty( $status ) )
				echo 'Unknown';
			else
				printf( '%s', $status );
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

add_filter( 'manage_edit-events_sortable_columns', 'my_events_sortable_columns' );
function my_events_sortable_columns( $columns ) {
	$columns['edate'] = 'edate';
	return $columns;
}

add_action( 'load-edit.php', 'my_edit_events_load' );
function my_edit_events_load() {
	add_filter( 'request', 'my_sort_events' );
}
function my_sort_events( $vars ) {
	if ( isset( $vars['post_type'] ) && 'events' == $vars['post_type'] ) {
		if ( isset( $vars['orderby'] ) && 'date_event' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'date_event',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}
	return $vars;
}