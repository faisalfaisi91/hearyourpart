<?php
/*
Plugin Name: VidoRev Extensions
Plugin URI: https://beeteam368.net/vidorev/
Description: Video Ads, Playlist, Actor, Director, Like Dislike
Author: BeeTeam368
Author URI: http://themeforest.net/user/beeteam368
Version: 2.9.9.9.7.5
License: Themeforest Licence
License URI: http://themeforest.net/licenses
*/

if ( ! defined( 'ABSPATH' )) {
    return;
}

if(!defined('VIDOREV_EXTENSIONS')){
	define('VIDOREV_EXTENSIONS', 'setup');
}

if(!defined('VPE_VER')){
	define('VPE_VER', '2.9.9.9.7.5');
}

if(!defined('VPE_PLUGIN_URL')){
    define('VPE_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if(!defined('VPE_PLUGIN_PATH')){
    define('VPE_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

if(!defined('PLAYLIST_PM_PREFIX')){
    define('PLAYLIST_PM_PREFIX', 'vid_p_');
}

if(!defined('CHANNEL_PM_PREFIX')){
    define('CHANNEL_PM_PREFIX', 'vid_c_');
}

if(!defined('YOUTUBE_BROADCASTS_PREFIX')){
    define('YOUTUBE_BROADCASTS_PREFIX', 'vid_yb_');
}
if(!defined('YOUTUBE_LIVE_VIDEO_PREFIX')){
    define('YOUTUBE_LIVE_VIDEO_PREFIX', 'vid_lv_');
}
if(!defined('YOUTUBE_AUTOMATIC_PREFIX')){
    define('YOUTUBE_AUTOMATIC_PREFIX', 'vid_ya_');
}

if(!defined('MOVIE_PM_PREFIX')){
    define('MOVIE_PM_PREFIX', 'vid_m_');
}

if(!defined('VIDEOADS_PM_PREFIX')){
    define('VIDEOADS_PM_PREFIX', 'vid_ads_m_');
}

if(!defined('FLUIDPLAYER_PM_PREFIX')){
    define('FLUIDPLAYER_PM_PREFIX', 'vid_fluid_m_');
}

if(!defined('CATEGORY_PM_PREFIX')){
    define('CATEGORY_PM_PREFIX', 'vid_cat_');
}

if(!defined('beeteam368_tf_item_id')){
    define('beeteam368_tf_item_id', 21798615);
}

if(!defined('beeteam368_tf_item_domain')){
    define('beeteam368_tf_item_domain', trim($_SERVER['SERVER_NAME']));
}


require VPE_PLUGIN_PATH . '/inc/like-view-ex.php';
if(!vidorev_extensions_action::detect_source()){
	return;
}
if(!class_exists('Vimeo')){
	require VPE_PLUGIN_PATH . '/inc/vimeo/autoload.php'; 
}
require VPE_PLUGIN_PATH . '/inc/custom-menu-to.php'; 
require VPE_PLUGIN_PATH . '/inc/register-post-type.php';

require VPE_PLUGIN_PATH . '/inc/cmb2/init.php'; 
require VPE_PLUGIN_PATH . '/inc/cmb2-attached-posts/cmb2-attached-posts-field.php'; 
require VPE_PLUGIN_PATH . '/inc/cmb2-field-post-search-ajax/cmb-field-post-search-ajax.php'; 
require VPE_PLUGIN_PATH . '/inc/cmb2-conditionals/cmb2-conditionals.php'; 
require VPE_PLUGIN_PATH . '/inc/cmb2-radio-image/cmb2-radio-image.php'; 
require VPE_PLUGIN_PATH . '/inc/cmb2-field-slider/cmb2_field_slider.php'; 
if(!class_exists('WeDevs_Settings_API')){
	require VPE_PLUGIN_PATH . '/inc/plugin-settings/src/class.settings-api.php'; 
	require VPE_PLUGIN_PATH . '/inc/plugin-settings/get-option.php'; 
}
require VPE_PLUGIN_PATH . '/inc/post-meta.php';
require VPE_PLUGIN_PATH . '/inc/category-meta.php'; 
require VPE_PLUGIN_PATH . '/inc/playlist-settings.php';
require VPE_PLUGIN_PATH . '/inc/channel-settings.php';  
require VPE_PLUGIN_PATH . '/inc/actor-settings.php'; 
require VPE_PLUGIN_PATH . '/inc/director-settings.php'; 
require VPE_PLUGIN_PATH . '/inc/series-settings.php';
require VPE_PLUGIN_PATH . '/inc/multi_links.php'; 
require VPE_PLUGIN_PATH . '/inc/imdb-ratings.php'; 
require VPE_PLUGIN_PATH . '/inc/template-loaded.php';
require VPE_PLUGIN_PATH . '/inc/video-ads.php';
require VPE_PLUGIN_PATH . '/inc/facebook-sdk.php';
require VPE_PLUGIN_PATH . '/inc/transfer-videos.php';
require VPE_PLUGIN_PATH . '/inc/youtube-import.php';
require VPE_PLUGIN_PATH . '/inc/youtube-player-settings.php';
require VPE_PLUGIN_PATH . '/inc/youtube-broadcasts.php';
require VPE_PLUGIN_PATH . '/inc/youtube-live.php';
require VPE_PLUGIN_PATH . '/inc/player-sub-toolbar.php';
require VPE_PLUGIN_PATH . '/inc/video-report.php';
require VPE_PLUGIN_PATH . '/inc/amazon.php';
require VPE_PLUGIN_PATH . '/inc/javascript-libraries.php';
require VPE_PLUGIN_PATH . '/inc/cf7-addons.php';
require VPE_PLUGIN_PATH . '/youzer-addons/video-shortcode.php';
require VPE_PLUGIN_PATH . '/inc/youtube-automatic.php';
require VPE_PLUGIN_PATH . '/inc/fluidplayer.php';
require VPE_PLUGIN_PATH . '/inc/schema-markups.php';

require VPE_PLUGIN_PATH . '/shortcodes/reg-classic.php';
require VPE_PLUGIN_PATH . '/shortcodes/reg-shc.php';
require VPE_PLUGIN_PATH . '/shortcodes/reg-vc.php';
require VPE_PLUGIN_PATH . '/elementor/elementor-addon.php';
require VPE_PLUGIN_PATH . '/shortcodes/reg-page-opts.php';
require VPE_PLUGIN_PATH . '/shortcodes/reg-hook.php';
require VPE_PLUGIN_PATH . '/sample-data/hook.php';
require VPE_PLUGIN_PATH . '/sample-data/ajax.php';
require VPE_PLUGIN_PATH . '/inc/front-end-edit-post.php';
require VPE_PLUGIN_PATH . '/widgets/widgets.php';
require VPE_PLUGIN_PATH . '/inc/cmb-meta-box/page-options.php';
require VPE_PLUGIN_PATH . '/inc/cmb-meta-box/post-options.php';
require VPE_PLUGIN_PATH . '/inc/user-options.php';
require VPE_PLUGIN_PATH . '/inc/social.php';
require VPE_PLUGIN_PATH . '/inc/class-video-fetch-data.php';
require VPE_PLUGIN_PATH . '/inc/filter-tags.php';

require VPE_PLUGIN_PATH . '/inc/mycred/like.php';
require VPE_PLUGIN_PATH . '/inc/mycred/dislike.php';
require VPE_PLUGIN_PATH . '/inc/mycred/video.php';
require VPE_PLUGIN_PATH . '/inc/preview.php';
require VPE_PLUGIN_PATH . '/inc/tmdb.php';

if(!function_exists('vidorev_setup_like_dislike')):
	function vidorev_setup_like_dislike() {
		global $wpdb;
		$vpe_like_dislike_table_name = $wpdb->prefix . 'vpe_like_dislike';
		if ($wpdb->get_var("show tables like '$vpe_like_dislike_table_name'") != $vpe_like_dislike_table_name) {		
			$sql = "CREATE TABLE " . $vpe_like_dislike_table_name . " (
				`id` bigint(11) NOT NULL AUTO_INCREMENT,
				`post_id` int(11) NOT NULL,
				`value` int(2) NOT NULL,
				`date_time` datetime NOT NULL,
				`ip` varchar(40) NOT NULL,
				`user_id` int(11) NOT NULL DEFAULT '0',
				PRIMARY KEY (`id`)
			)";
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}
endif;
register_activation_hook(__FILE__, 'vidorev_setup_like_dislike'); 
require VPE_PLUGIN_PATH . '/inc/like-dislike.php';

require VPE_PLUGIN_PATH . '/inc/assets.php';
if(!function_exists('vidorev_load_plugin_textdomain')){
	function vidorev_load_plugin_textdomain() {
		load_plugin_textdomain('vidorev-extensions', false, basename(VPE_PLUGIN_PATH).'/languages');
	}
}
add_action( 'plugins_loaded', 'vidorev_load_plugin_textdomain' );