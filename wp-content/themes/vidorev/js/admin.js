/*
VidoRev Admin Library
Author: BeeTeam368
Author URI: http://themeforest.net/user/beeteam368
Version: 2.9.9.9.7.5
License: Themeforest Licence
License URI: http://themeforest.net/licenses
*/

;(function(factory) {
    if(typeof define === 'function' && define.amd){
        define(['jquery'], factory);
    }else if (typeof exports !== 'undefined'){
        module.exports = factory(require('jquery'));
    }else{
        factory(jQuery);
    }
}(function($){
	'use strict';
	
	var prefix = 'vidorev_theme_admin';		
	var vidorev_theme_admin = window.vidorev_theme_admin || {};
	
  	vidorev_theme_admin = (function(){
		function vidorev_theme_admin(el, options){
			var _ = this;
			
			_.defaults = {
									
			}
			
			if(typeof(options)==='object'){
				_.options = $.extend({}, _.defaults, options);
			}else{
				_.options = _.defaults;
			}
			
			_.$el = $(el);
			_.init();
		}	
			
		return vidorev_theme_admin;
	}());	
		
	/*init function [Core]*/
	vidorev_theme_admin.prototype.init = function(){
		var _ = this;
		
		_.switch_control_post_format();
		_.switch_control_page_template();
		_.video_ads_settings();
		_.video_download_settings();
		_.youtube_automatic_reset();
		_.youtube_automatic_execution();
		_.youtube_automatic_delete_posts();
		_.cmb_box_select2();
		_.google_drive_list_files();
		_.selfHostedVideoUpdate();
		
		/*init*/		
		_.$el.trigger(prefix+'init', []);/*init*/
	}/*init function [Core]*/
	
	vidorev_theme_admin.prototype.post_format_action = function(val){
		var _ = this;
		
		switch(val){
			case '0':
				$('#feature_image_settings').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#video_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_movie_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#audio_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#gallery_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#quote_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_auto_fetch_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#vid_ads_m_videoads_settings_post').addClass('post-meta-group-hide').removeClass('post-meta-group-show');				
				break;
				
			case 'video':
				$('#feature_image_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_player_settings').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#video_movie_settings').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#audio_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#gallery_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#quote_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_auto_fetch_settings').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#vid_ads_m_videoads_settings_post').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				break;
				
			case 'audio':
				$('#feature_image_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_movie_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#gallery_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#quote_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_auto_fetch_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#vid_ads_m_videoads_settings_post').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;
				
			case 'gallery':
				$('#feature_image_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_movie_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#audio_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#gallery_settings').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#quote_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_auto_fetch_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#vid_ads_m_videoads_settings_post').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;
				
			case 'quote':
				$('#feature_image_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_movie_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#audio_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#gallery_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#quote_settings').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#video_auto_fetch_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#vid_ads_m_videoads_settings_post').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;
				
			default:
				$('#feature_image_settings').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#video_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_movie_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#audio_player_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#gallery_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#quote_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#video_auto_fetch_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#vid_ads_m_videoads_settings_post').addClass('post-meta-group-hide').removeClass('post-meta-group-show');			
		}
	}
	
	vidorev_theme_admin.prototype.page_template_action = function(val){
		var _ = this;
		
		switch(val){
			case 'template/archive-playlist.php':
				$('#page_options .inside #setting_theme_sidebar').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('#blog_page_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;
				
			case 'page-templates/front-page-template.php':
				$('#page_options .inside #setting_theme_sidebar').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#blog_page_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;
				
			case 'template/blog-page-template.php':
				$('#page_options .inside #setting_theme_sidebar').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#blog_page_settings').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				break;	
				
			default:
				$('#page_options .inside #setting_theme_sidebar').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('#blog_page_settings').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
		}
	}
	
	vidorev_theme_admin.prototype.video_ads_settings_action = function(val){
		var _ = this;
		
		switch(val){
			case 'google_ima':
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-google-ima').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-image').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html5-video').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-dynamic').addClass('post-meta-group-hide').removeClass('post-meta-group-show');				
				$('.cmb2-id-vid-ads-m-time-to-show-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-skip-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-to-hide-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				
				$('.cmb-row.cmb2-id-vid-ads-m-vpaid-mode').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-configuration').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-preroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-postroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-pauseroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-midroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;
				
			case 'image':
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-google-ima').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-image').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html5-video').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-dynamic').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-to-show-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb2-id-vid-ads-m-time-skip-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb2-id-vid-ads-m-time-to-hide-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				
				$('.cmb-row.cmb2-id-vid-ads-m-vpaid-mode').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-configuration').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-preroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-postroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-pauseroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-midroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;
				
			case 'html5_video':
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-google-ima').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-image').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html5-video').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-dynamic').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-to-show-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb2-id-vid-ads-m-time-skip-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb2-id-vid-ads-m-time-to-hide-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				
				$('.cmb-row.cmb2-id-vid-ads-m-vpaid-mode').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-configuration').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-preroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-postroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-pauseroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-midroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;		
				
			case 'html':
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-google-ima').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-image').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html5-video').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-dynamic').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-to-show-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb2-id-vid-ads-m-time-skip-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb2-id-vid-ads-m-time-to-hide-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				
				$('.cmb-row.cmb2-id-vid-ads-m-vpaid-mode').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-configuration').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-preroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-postroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-pauseroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-midroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;
				
			case 'vast':				
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-google-ima').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-image').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html5-video').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-dynamic').addClass('post-meta-group-hide').removeClass('post-meta-group-show');		
				$('.cmb2-id-vid-ads-m-time-to-show-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-skip-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-to-hide-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				
				$('.cmb-row.cmb2-id-vid-ads-m-vpaid-mode').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-configuration').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-preroll').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-postroll').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-pauseroll').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-midroll').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				break;
				
			case 'dynamic_ad':
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-google-ima').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-image').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html5-video').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-dynamic').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb2-id-vid-ads-m-time-to-show-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				$('.cmb2-id-vid-ads-m-time-skip-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-to-hide-ads').addClass('post-meta-group-show').removeClass('post-meta-group-hide');				
				
				$('.cmb-row.cmb2-id-vid-ads-m-vpaid-mode').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-configuration').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-preroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-postroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-pauseroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-midroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				break;			
				
			default:				
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-google-ima').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-image').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html5-video').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-html').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-group-dynamic').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-to-show-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-skip-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-ads-m-time-to-hide-ads').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				
				$('.cmb-row.cmb2-id-vid-ads-m-vpaid-mode').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-configuration').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-preroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-postroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-pauseroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb-type-group.cmb2-id-vid-ads-m-vast-midroll').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
		}
	}
	
	vidorev_theme_admin.prototype.switch_control_post_format = function(){
		var _ = this,
			$post_formats_select = $('#post-formats-select'),
			$post_formats_value = $post_formats_select.find('input.post-format[name="post_format"]'),
			$post_formats_value_checked = $post_formats_select.find('input.post-format[name="post_format"]:checked');
		
		_.post_format_action($post_formats_value_checked.val());
		
		if($post_formats_select.length > 0 && $post_formats_value.length > 0){			
			$post_formats_value.off('.postFormatsValueChange').on('change.postFormatsValueChange', function(e){				
				var $t = $(this);				
				_.post_format_action($t.val());
			})
		}
		
		var $wp5_post_format_value = $('input[name="beeteam368_check_post_format"]');
		_.post_format_action($wp5_post_format_value.val());
		_.$el.off('.postFormatsValueChange5').on('click.postFormatsValueChange5, change.postFormatsValueChange5', '.editor-post-format select[id^="post-format-selector-"]', function(e){
			var $t = $(this);				
			_.post_format_action($t.val());
		});
	}
	
	vidorev_theme_admin.prototype.switch_control_page_template = function(){
		var _ = this,
			$page_template_select = $('#page_template'),
			$page_template_value = $page_template_select.val();
		
		_.page_template_action($page_template_value);
		
		if($page_template_select.length > 0){			
			$page_template_select.off('.pageTemplateValueChange').on('change.pageTemplateValueChange', function(e){				
				var $t = $(this);				
				_.page_template_action($t.val());
			})
		}
		
		var $wp5_page_template_value = $('input[name="beeteam368_check_page_template"]');
		_.page_template_action($wp5_page_template_value.val());
		_.$el.off('.pageTemplateValueChange5').on('click.pageTemplateValueChange5', '.editor-page-attributes__template select[id^="inspector-select-control-"]', function(e){
			var $t = $(this);				
			_.page_template_action($t.val());
		});
	}
	
	vidorev_theme_admin.prototype.video_ads_settings = function(){
		var _ = this,
			$video_ads_select = $('#vid_ads_m_video_ads_type'),
			$video_ads_value = $video_ads_select.val();
		
		_.video_ads_settings_action($video_ads_value);
		
		if($video_ads_select.length > 0){			
			$video_ads_select.off('.videoAdsValueChange').on('change.videoAdsValueChange', function(e){				
				var $t = $(this);				
				_.video_ads_settings_action($t.val());
			})
		}
	}
	
	vidorev_theme_admin.prototype.video_download_settings_action = function(val){
		var _ = this;
		
		switch(val){
			case 'free':
				$('.cmb-type-group.cmb2-id-vm-media-download').addClass('post-meta-group-show').removeClass('post-meta-group-hide');	
				$('.cmb2-id-vid-woo-product').addClass('post-meta-group-hide').removeClass('post-meta-group-show');		
				break;
				
			case 'paid':
				$('.cmb-type-group.cmb2-id-vm-media-download').addClass('post-meta-group-hide').removeClass('post-meta-group-show');
				$('.cmb2-id-vid-woo-product').addClass('post-meta-group-show').removeClass('post-meta-group-hide');
				break;
		}
	}
	
	vidorev_theme_admin.prototype.video_download_settings = function(){
		var _ = this,
			$video_download_select 	= $('#vid_download_type'),
			$video_download_value 	= $video_download_select.val();
		
		_.video_download_settings_action($video_download_value);
		
		if($video_download_select.length > 0){			
			$video_download_select.off('.videoDownloadValueChange').on('change.videoDownloadValueChange', function(e){				
				var $t = $(this);				
				_.video_download_settings_action($t.val());
			})
		}
	}
	
	vidorev_theme_admin.prototype.youtube_automatic_reset = function(){
		var _ = this;
		_.$el.off('.youtubeAutomaticReset').on('click.youtubeAutomaticReset', '.youtube_automatic_reset', function(e){
			
			if (!confirm(beeteam368_jav_js_object.text_confirm)) {
               return false;
            }
			
			var $t = $(this);
			var id = $t.attr('data-id');
			
			if(typeof(id)==='undefined'){
				return false;
			}
			
			$t.addClass('action-disable');
			$('#ya-execution-'+(id)).addClass('action-disable');
			$('#delete-action-'+(id)).addClass('action-disable');
			
			var paramsRequest = {			
				'action':		'beeteam368_youtube_automatic_reset',
				'auto_id':		id,
			};
			
			$.ajax({
				url:		beeteam368_jav_js_object.admin_ajax,						
				type: 		'POST',
				data:		paramsRequest,
				dataType: 	'json',
				cache:		false,
				success: 	function(data){
					
					if(typeof(data)==='object' && typeof(data['success']) !== 'undefined'){
						$('#ya-execution-'+(id)).html(data['success']);
						$('#delete-action-'+(id)).html(data['btn_delete']);
					}
					
					$t.removeClass('action-disable');
					$('#ya-execution-'+(id)).removeClass('action-disable');	
					$('#delete-action-'+(id)).removeClass('action-disable');	
					
				},
				error:		function(){
					
					$t.removeClass('action-disable');
					$('#ya-execution-'+(id)).removeClass('action-disable');
					$('#delete-action-'+(id)).removeClass('action-disable');
					
				},
			});
		});
	}
	
	vidorev_theme_admin.prototype.youtube_automatic_execution = function(){
		var _ = this;
		_.$el.off('.youtubeAutomaticExecution').on('click.youtubeAutomaticExecution', '.youtube_automatic_execution', function(e){
			
			if (!confirm(beeteam368_jav_js_object.text_confirm)) {
               return false;
            }
			
			var $t = $(this);
			var id = $t.attr('data-id');
			
			if(typeof(id)==='undefined'){
				return false;
			}			
			
			$t.text(beeteam368_jav_js_object.text_processing);
			$('.youtube_automatic_reset[data-id="'+(id)+'"]').addClass('action-disable');
			$('#ya-execution-'+(id)).addClass('action-disable');
			$('#delete-action-'+(id)).addClass('action-disable');
			
			var paramsRequest = {			
				'action':		'beeteam368_youtube_automatic_execution',
				'auto_id':		id,
			};
			
			$.ajax({
				url:		beeteam368_jav_js_object.admin_ajax,						
				type: 		'POST',
				data:		paramsRequest,
				dataType: 	'json',
				cache:		false,
				success: 	function(data){
					
					if(typeof(data)==='object' && typeof(data['success']) !== 'undefined'){
						$('#ya-execution-'+(id)).html(data['success']);
						$('[data-post-number="'+(id)+'"]').html(data['posts_count']);
					}
					
					$('.youtube_automatic_reset[data-id="'+(id)+'"]').removeClass('action-disable');
					$('#ya-execution-'+(id)).removeClass('action-disable');
					$('#delete-action-'+(id)).removeClass('action-disable');		
					
				},
				error:		function(){
					
					$('.youtube_automatic_reset[data-id="'+(id)+'"]').removeClass('action-disable');
					$('#ya-execution-'+(id)).removeClass('action-disable');
					$('#delete-action-'+(id)).removeClass('action-disable');
					
				},
			});
		});
	}
	
	vidorev_theme_admin.prototype.youtube_automatic_delete_posts = function(){
		var _ = this;
		_.$el.off('.youtubeAutomaticDeletePosts').on('click.youtubeAutomaticDeletePosts', '.youtube_automatic_delete_posts', function(e){
			
			if (!confirm(beeteam368_jav_js_object.text_confirm)) {
               return false;
            }
			
			var $t = $(this);
			var id = $t.attr('data-id');
			
			if(typeof(id)==='undefined'){
				return false;
			}			

			$('.youtube_automatic_reset[data-id="'+(id)+'"]').addClass('action-disable');
			$('#ya-execution-'+(id)).addClass('action-disable');
			$('#delete-action-'+(id)).addClass('action-disable');
			
			var paramsRequest = {			
				'action':		'beeteam368_youtube_automatic_delete_posts',
				'auto_id':		id,
			};
			
			$.ajax({
				url:		beeteam368_jav_js_object.admin_ajax,						
				type: 		'POST',
				data:		paramsRequest,
				dataType: 	'json',
				cache:		false,
				success: 	function(data){
					
					if(typeof(data)==='object' && typeof(data['success']) !== 'undefined'){
						$('[data-post-number="'+(id)+'"]').html(0);
					}else{
						location.reload();
					}
					
					$('.youtube_automatic_reset[data-id="'+(id)+'"]').removeClass('action-disable');
					$('#ya-execution-'+(id)).removeClass('action-disable');
					$('#delete-action-'+(id)).removeClass('action-disable');		
					
				},
				error:		function(){
					
					$('.youtube_automatic_reset[data-id="'+(id)+'"]').removeClass('action-disable');
					$('#ya-execution-'+(id)).removeClass('action-disable');
					$('#delete-action-'+(id)).removeClass('action-disable');
					
				},
			});
		});
	}
	
	vidorev_theme_admin.prototype.cmb_box_select2 = function(){
		var _ = this;
		
		var dir = 'ltr';	
			
		if($('body').css('direction')=='rtl'){
			dir = 'rtl';
		}
		
		if(typeof($.fn.select2)==='undefined'){
			return;
		}
		
		$('.admin-ajax-find-playlist-control').select2({
			ajax: 	{
						url: 		beeteam368_jav_js_object.admin_ajax,
						data: 		function (params) {
										var queryParameters = {
										 'action': 	'adminAjaxGetAllPlaylists',
										  'keyword': 	params.term,
										  'security': 	beeteam368_jav_js_object.security,
										}									
										return queryParameters;
						},
						delay: 		250,
						dataType: 	'json',
						type: 		'POST',
						cache:		true,
					},
			minimumInputLength: 2,
			allowClear:true,
			dir:dir,
			width: 'resolve'
		});
		
		$('.admin-ajax-find-channel-control').select2({
			ajax: 	{
						url: 		beeteam368_jav_js_object.admin_ajax,
						data: 		function (params) {
										var queryParameters = {
										 'action': 	'adminAjaxGetAllChannels',
										  'keyword': 	params.term,
										  'security': 	beeteam368_jav_js_object.security,
										}									
										return queryParameters;
						},
						delay: 		250,
						dataType: 	'json',
						type: 		'POST',
						cache:		true,
					},
			minimumInputLength: 2,
			allowClear:true,
			dir:dir,
			width: 'resolve'
		});
		
		$('.admin-ajax-find-tags-control').select2({
			ajax: 	{
						url: 		beeteam368_jav_js_object.admin_ajax,
						data: 		function (params) {
										var queryParameters = {
										 'action': 	'adminAjaxGetAllTags',
										  'keyword': 	params.term,
										  'security': 	beeteam368_jav_js_object.security,
										}									
										return queryParameters;
						},
						delay: 		250,
						dataType: 	'json',
						type: 		'POST',
						cache:		true,
					},
			minimumInputLength: 2,
			allowClear:true,
			dir:dir,
			width: 'resolve'
		});
		$('body.post-type-filter_tags ul.select2-selection__rendered').sortable({
		  containment: 'parent',
		});	
		
		$('.admin-ajax-find-tmdb-movie-control').select2({
			ajax: 	{
						url: 		beeteam368_jav_js_object.admin_ajax,
						data: 		function (params) {
										var queryParameters = {
										 'action': 	'adminAjaxGetAllTMDBMovies',
										  'keyword': 	params.term,
										  'security': 	beeteam368_jav_js_object.security,
										}									
										return queryParameters;
						},
						delay: 		250,
						dataType: 	'json',
						type: 		'POST',
						cache:		true,
					},
			minimumInputLength: 2,
			allowClear:true,
			dir:dir,
			width: 'resolve'
		});
		$('#cmb2-metabox-video_movie_settings .custom-filter-tmdb-movie-display-control ul.select2-selection__rendered').sortable({
		  containment: 'parent',
		});	
		
		$('.admin-ajax-find-tmdb-tv-shows-control').select2({
			ajax: 	{
						url: 		beeteam368_jav_js_object.admin_ajax,
						data: 		function (params) {
										var queryParameters = {
										 'action': 	'adminAjaxGetAllTMDBTVShows',
										  'keyword': 	params.term,
										  'security': 	beeteam368_jav_js_object.security,
										}									
										return queryParameters;
						},
						delay: 		250,
						dataType: 	'json',
						type: 		'POST',
						cache:		true,
					},
			minimumInputLength: 2,
			allowClear:true,
			dir:dir,
			width: 'resolve'
		});
		$('#cmb2-metabox-video_movie_settings .custom-filter-tmdb-tv-shows-display-control ul.select2-selection__rendered').sortable({
		  containment: 'parent',
		});	
		
	}
	
	vidorev_theme_admin.prototype.google_drive_list_files = function(){
		var _ = this;
		
		_.$el.off('.loadGoogleDriveFiles').on('click.loadGoogleDriveFiles', '.load-google-drive-files-control', function(e){
						
			var $t = $(this);			
			$('.ftut_control').addClass('load-status');
			
			if(typeof(beeteam368_admin_gd_nextPageToken)==='undefined' || beeteam368_admin_gd_nextPageToken===''){
				$('.ftut_control').removeClass('load-status');
				$t.addClass('load-status');
				return false;
			}	
			
			var pageToken = beeteam368_admin_gd_nextPageToken;		
			
			var paramsRequest = {			
				'action':		'ajaxGetAllGoogleFiles',
				'pageToken':	pageToken,
				'q':			$('.search-keyword-control').val(),
				'security': 	beeteam368_jav_js_object.security,
			};
			
			$.ajax({
				url:		beeteam368_jav_js_object.admin_ajax,						
				type: 		'POST',
				data:		paramsRequest,
				dataType: 	'html',
				cache:		false,
				success: 	function(data){
					
					$('#the-list').append(data);
					$('.ftut_control').removeClass('load-status');
					
					if($('.search-keyword-control').val()!='' && $('.search-keyword-control').hasClass('has-key')){
					
						$('.clear_search-control').removeClass('load-status');
						$('.search-keyword-control,.search-button-control').addClass('load-status');
					
					}
					
					$('#cb-select-all-1, #cb-select-all-2').prop('checked', false);
					
				},
				error:		function(){
					$('.ftut_control').removeClass('load-status');
				},
			});
		});
		
		_.$el.off('.searchGoogleDriveFiles').on('click.searchGoogleDriveFiles', '.search-button-control', function(e){
						
			var $t = $(this);			
			$('.ftut_control').addClass('load-status');
			
			if($('.search-keyword-control').length === 0 || $('.search-keyword-control').val()===''){
				$('.ftut_control').removeClass('load-status');
				return false;
			}	
			
			var q = $('.search-keyword-control').val();		
			
			var paramsRequest = {			
				'action':		'ajaxGetAllGoogleFiles',				
				'q':			q,
				'security': 	beeteam368_jav_js_object.security,
			};
			
			$.ajax({
				url:		beeteam368_jav_js_object.admin_ajax,						
				type: 		'POST',
				data:		paramsRequest,
				dataType: 	'html',
				cache:		false,
				success: 	function(data){
					
					$('#the-list').html(data);
					$('.ftut_control').removeClass('load-status');
					if(typeof(beeteam368_admin_gd_nextPageToken)!=='undefined' && beeteam368_admin_gd_nextPageToken==''){
						$('.load-google-drive-files-control').addClass('load-status');
					}else if(typeof(beeteam368_admin_gd_nextPageToken)!=='undefined' && beeteam368_admin_gd_nextPageToken!=''){
						$('.load-google-drive-files-control').removeClass('load-status');
					}
					
					$t.addClass('load-status');
					$('.clear_search-control').removeClass('load-status');
					$('.search-keyword-control').addClass('load-status has-key');
					$('#cb-select-all-1, #cb-select-all-2, input[name="googledrivefile[]"]').prop('checked', false);
					
				},
				error:		function(){
					$('.ftut_control').removeClass('load-status');
				},
			});
		});
		
		_.$el.off('.clearGoogleDriveFiles').on('click.clearGoogleDriveFiles', '.clear_search-control', function(e){
			
			var $t = $(this);	
			$('.ftut_control').addClass('load-status');		
			
			var paramsRequest = {			
				'action':		'ajaxGetAllGoogleFiles',				
				'q':			'',
				'security': 	beeteam368_jav_js_object.security,
			};
			
			$.ajax({
				url:		beeteam368_jav_js_object.admin_ajax,						
				type: 		'POST',
				data:		paramsRequest,
				dataType: 	'html',
				cache:		false,
				success: 	function(data){
					
					$('#the-list').html(data);
					$('.ftut_control').removeClass('load-status');
					if(typeof(beeteam368_admin_gd_nextPageToken)!=='undefined' && beeteam368_admin_gd_nextPageToken==''){
						$('.load-google-drive-files-control').addClass('load-status');
					}else if(typeof(beeteam368_admin_gd_nextPageToken)!=='undefined' && beeteam368_admin_gd_nextPageToken!=''){
						$('.load-google-drive-files-control').removeClass('load-status');
					}
					
					$t.removeClass('load-status');
					$('.clear_search-control').addClass('load-status');
					$('.search-keyword-control').removeClass('load-status has-key').val('');
					$('#cb-select-all-1, #cb-select-all-2, input[name="googledrivefile[]"]').prop('checked', false);
					
				},
				error:		function(){
					$('.ftut_control').removeClass('load-status');
				},
			});
		});
		
		_.$el.off('.deleteGoogleDriveFiles').on('click.deleteGoogleDriveFiles', '.delete-google-drive-files-control', function(e){
			
			var $t = $(this);
			
			$('.ftut_control').addClass('load-status');
			
			var fileVal = [];
			fileVal = $('input[name="googledrivefile[]"]:checked').map(function(_, el) {
				return $(el).val();
			}).get();
			
			if(fileVal.length === 0){
				alert('Please select at least one item before delete');
				$('.ftut_control').removeClass('load-status');
				if($('.search-keyword-control').val()!='' && $('.search-keyword-control').hasClass('has-key')){					
					$('.clear_search-control').removeClass('load-status');
					$('.search-keyword-control,.search-button-control').addClass('load-status');				
				}
				return false;
			}
			
			if (!confirm('Are you sure you want to delete these files?')) {
				$('.ftut_control').removeClass('load-status');
				if($('.search-keyword-control').val()!='' && $('.search-keyword-control').hasClass('has-key')){					
					$('.clear_search-control').removeClass('load-status');
					$('.search-keyword-control,.search-button-control').addClass('load-status');				
				}
               return false;
            }
			
			var paramsRequest = {			
				'action':		'ajaxGetAllGoogleFiles',				
				'deleteFiles':	fileVal,
				'security': 	beeteam368_jav_js_object.security,
			}
			
			$.ajax({
				url:		beeteam368_jav_js_object.admin_ajax,						
				type: 		'POST',
				data:		paramsRequest,
				dataType: 	'json',
				cache:		false,
				success: 	function(data){
					if(typeof(data)==='object' && typeof(data.error)==='undefined'){
						console.log('Done!!!');
						location.reload(true);						
					}else{
						$('.ftut_control').removeClass('load-status');
						if($('.search-keyword-control').val()!='' && $('.search-keyword-control').hasClass('has-key')){					
							$('.clear_search-control').removeClass('load-status');
							$('.search-keyword-control,.search-button-control').addClass('load-status');				
						}
					}
					
				},
				error:		function(){
					$('.ftut_control').removeClass('load-status');
				},
			});
		});
	}
	
	vidorev_theme_admin.prototype.selfHostedVideoUpdate = function(){
		var _ = this;	
		$( document ).on( 'cmb_media_modal_select', function ( e, selection, media ) {
			if(typeof(media.field)!=='undefined' && media.field == 'vm_video_url_btn_choose'){
				$('#vm_video_url').val($('#vm_video_url_btn_choose').val());
				$('.cmb2-remove-file-button[rel="vm_video_url_btn_choose"]').after(' / <a href="#" class="vidorev-remove-self-hosted-video-button">Remove All</a>');
				
				$('.vidorev-remove-self-hosted-video-button').off('.removeAllLinkSelfHostedVideo').on('click.removeAllLinkSelfHostedVideo', function(){
					$('#vm_video_url').val('');
					$('.cmb2-remove-file-button[rel="vm_video_url_btn_choose"]').trigger('click');
					return false;
				});
			}
		});
	}
		
	/*destroy [Core]*/
	vidorev_theme_admin.prototype.destroy = function(){
		var _ = this;		
	}/*destroy [Core]*/
	
	/*jquery [Core]*/
	$.fn.J_vidorev_theme_admin = function(){
		var _ 		= this,
			opt 	= arguments[0],
			args 	= Array.prototype.slice.call(arguments, 1),
			l 		= _.length,
			i,
			ret;
		for(i = 0; i < l; i++) {
			if(typeof opt == 'object' || typeof opt == 'undefined'){
				_[i].J_vidorev_theme_admin = new vidorev_theme_admin(_[i], opt);
			}else{
				ret = _[i].J_vidorev_theme_admin[opt].apply(_[i].J_vidorev_theme_admin, args);
			}
			if (typeof ret != 'undefined'){				
				return ret;
			}
		}
		return _;
	}/*jquery [Core]*/
	
	/*ready [Core]*/
	$(document).ready(function(){
		var $b = $( 'body' ),
			options = { };
			
		$b.on(prefix+'init', function(){
			console.log('VidoRev admin: library is installed, version 2.9.9.9.7.5');
		});
			
		$b.J_vidorev_theme_admin( options );		
	});/*ready [Core]*/
			
}));