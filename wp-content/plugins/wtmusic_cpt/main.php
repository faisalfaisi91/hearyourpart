<?php
/*
	Plugin Name: T20 - WTmusic
	Plugin URI: kreativewebteam.com/
	Description: The required plugin for wtmusic music theme.
	Version: 2.1
	Author: Kreative Web Team
	Author URI: kreativewebteam.com/
	License: GPLv2
*/

define( 'WTMUSIC_DIR', dirname( __FILE__ ) );
define( 'WTMUSIC_URL', plugins_url( '',__FILE__ ) );

/* T20 - CTP */
	include_once WTMUSIC_DIR . '/cpt/artists.php'; 
	include_once WTMUSIC_DIR . '/cpt/songs.php'; 
	include_once WTMUSIC_DIR . '/cpt/videos.php'; 
	include_once WTMUSIC_DIR . '/cpt/gallery.php'; 
	include_once WTMUSIC_DIR . '/cpt/events.php'; 

/* T20 - Shortcodes */
	require_once( WTMUSIC_DIR . '/includes/scripts.php' ); 
	require_once( WTMUSIC_DIR . '/includes/shortcode-functions.php'); 
	require_once( WTMUSIC_DIR . '/includes/mce/symple_shortcodes_tinymce.php'); 

$theme = wp_get_theme();
if ( 'wtmusic' === $theme->name || 'WTMUSIC Child' === $theme->name ) { 

	if ( !class_exists('AjaxyLiveSearch') ) {
		/* T20 - Ajax Search */
		require_once( WTMUSIC_DIR . '/ajaxy.php'); 
	}

	if ( ! function_exists( 'uf_init' ) ) {
		/* T20 - User Profile */
		require_once( WTMUSIC_DIR . '/user-frontend/user-frontend.php');
	}

	if ( ! function_exists( 'ldc_like_counter_p' ) ) {
		/* T20 - Like */
		require_once( WTMUSIC_DIR . '/ldclite-appearance.php');
		require_once( WTMUSIC_DIR . '/ldclite-function.php');

		register_activation_hook(__FILE__,'like_dislike_counter_install');
		add_action('admin_init', 'ldclite_plugin_redirect');
		function ldclite_plugin_activate() {
		    add_option('ldclite_plugin_do_activation_redirect', true);
		}
		function ldclite_plugin_redirect() {
		    if (get_option('ldclite_plugin_do_activation_redirect', false)) {
		        delete_option('ldclite_plugin_do_activation_redirect');
		        wp_redirect('plugins.php');
		    }
		}
		function like_dislike_counter_install() {
			add_option('ldclite_options', ldc_lite_defaultOptions());
			global $wpdb;
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$table_name = $wpdb->prefix."like_dislike_counters";     
			if($wpdb->get_var("show tables like '$table_name'") != $table_name){
				$sql= "CREATE TABLE ".$table_name."(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,post_id VARCHAR( 200 ) NOT NULL,ul_key VARCHAR( 30 ) NOT NULL,ul_value VARCHAR( 30 ) NOT NULL);"; 
				dbDelta($sql);
			}
			ldclite_plugin_activate();
		}

		function ldc_lite_defaultOptions(){
			$default = array(
				'ldc_deactivate'  => 0,
				'ldc_like_text' => 'Likes',
				'ldc_dislike_text' => 'Dislikes'
		    );
			return $default;
		}

		function wp_dislike_like_footer_script() {
			if(!is_admin()){ ?>
				<script type="text/javascript">
					var isProcessing = false; 
					function alter_ul_post_values(obj,post_id,ul_type){
					
						if (isProcessing)    
						return;  
						isProcessing = true;   
						
						jQuery(obj).find("span").html("...");
					    	jQuery.ajax({
					   		type: "POST",
					   		url: "<?php echo plugins_url( 'ajax_counter.php' , __FILE__ );?>",
					   		data: "post_id="+post_id+"&up_type="+ul_type,
					   		success: function(msg){
					     			jQuery(obj).find("span").html(msg);
								isProcessing = false; 
					   		}
					 	});
					}
				</script>
			<?php }
		}
		add_action('wp_footer', 'wp_dislike_like_footer_script');
	}

	/* T20 - Demo */
	require_once( WTMUSIC_DIR . '/demo/index.php' );
}