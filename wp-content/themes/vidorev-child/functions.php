<?php
if (!function_exists('vidorev_enqueue_parent_styles')) :
	function vidorev_enqueue_parent_styles()
	{
		wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	}
endif;
add_action('wp_enqueue_scripts', 'vidorev_enqueue_parent_styles');

if (!function_exists('vidorev_child_scripts')) :
	function vidorev_child_scripts()
	{

		wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), '1.0.0', true);
	}
endif;
add_action('wp_enqueue_scripts', 'vidorev_child_scripts');

add_filter('body_class', 'is_sidebar_body_class');
function is_sidebar_body_class($classes)
{
	$song_page =  strtolower(get_the_title());
	if ($song_page == 'songs') {
		$classes[] = 'is-sidebar';
	}

	return $classes;
}
