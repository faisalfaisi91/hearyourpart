<?php
require_once VPE_PLUGIN_PATH . '/widgets/widget-post.php';
require_once VPE_PLUGIN_PATH . '/widgets/widget-related-post.php';

if(!function_exists('vidorev_register_widgets')):
	function vidorev_register_widgets() {
		register_widget( 'vidorev_widget_post' );
		register_widget( 'vidorev_widget_related_posts' );
	}
endif;	
add_action( 'widgets_init', 'vidorev_register_widgets' );