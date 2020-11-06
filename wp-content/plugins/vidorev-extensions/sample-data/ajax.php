<?php
if(!function_exists('vidorev_sample_data_action')){
	function vidorev_sample_data_action(){
		
		set_time_limit(0);
		
		if(!isset($_POST['version'])){
			return;
		}
		
		$sampleDataFile 	= 'sample-data-full.xml';	
		$themeOptionFile 	= 'theme-options-full.json';
		$front_page_slug 	= 'demo-magazine';		
		$ajax_search_live	= 'a:156:{s:5:"theme";s:10:"simple-red";s:20:"override_search_form";s:1:"0";s:24:"override_woo_search_form";s:1:"0";s:13:"keyword_logic";s:3:"and";s:23:"trigger_on_facet_change";s:1:"1";s:17:"redirect_click_to";s:12:"results_page";s:17:"redirect_enter_to";s:12:"results_page";s:21:"click_action_location";s:4:"same";s:22:"return_action_location";s:4:"same";s:19:"custom_redirect_url";s:11:"?s={phrase}";s:13:"triggerontype";s:1:"1";s:11:"customtypes";s:20:"_decode_WyJwb3N0Il0=";s:13:"searchintitle";s:1:"1";s:15:"searchincontent";s:1:"1";s:15:"searchinexcerpt";s:1:"1";s:20:"search_in_permalinks";s:1:"0";s:13:"search_in_ids";s:1:"0";s:13:"search_all_cf";s:1:"0";s:12:"customfields";s:0:"";s:11:"post_status";s:7:"publish";s:24:"override_default_results";s:1:"0";s:15:"override_method";s:3:"get";s:9:"exactonly";s:1:"0";s:20:"exact_match_location";s:8:"anywhere";s:13:"searchinterms";s:1:"1";s:9:"charcount";s:1:"0";s:10:"maxresults";s:2:"10";s:10:"itemscount";s:1:"4";s:16:"resultitemheight";s:4:"70px";s:15:"orderby_primary";s:14:"relevance DESC";s:17:"orderby_secondary";s:9:"date DESC";s:11:"show_images";s:1:"1";s:18:"image_transparency";i:1;s:14:"image_bg_color";s:7:"#FFFFFF";s:11:"image_width";s:2:"70";s:12:"image_height";s:2:"70";s:19:"image_crop_location";s:1:"c";s:27:"image_crop_location_selects";a:9:{i:0;a:2:{s:6:"option";s:13:"In the center";s:5:"value";s:1:"c";}i:1;a:2:{s:6:"option";s:9:"Align top";s:5:"value";s:1:"t";}i:2;a:2:{s:6:"option";s:15:"Align top right";s:5:"value";s:2:"tr";}i:3;a:2:{s:6:"option";s:14:"Align top left";s:5:"value";s:2:"tl";}i:4;a:2:{s:6:"option";s:12:"Align bottom";s:5:"value";s:1:"b";}i:5;a:2:{s:6:"option";s:18:"Align bottom right";s:5:"value";s:2:"br";}i:6;a:2:{s:6:"option";s:17:"Align bottom left";s:5:"value";s:2:"bl";}i:7;a:2:{s:6:"option";s:10:"Align left";s:5:"value";s:1:"l";}i:8;a:2:{s:6:"option";s:11:"Align right";s:5:"value";s:1:"r";}}s:13:"image_sources";a:7:{i:0;a:2:{s:6:"option";s:14:"Featured image";s:5:"value";s:8:"featured";}i:1;a:2:{s:6:"option";s:12:"Post Content";s:5:"value";s:7:"content";}i:2;a:2:{s:6:"option";s:12:"Post Excerpt";s:5:"value";s:7:"excerpt";}i:3;a:2:{s:6:"option";s:12:"Custom field";s:5:"value";s:6:"custom";}i:4;a:2:{s:6:"option";s:15:"Page Screenshot";s:5:"value";s:10:"screenshot";}i:5;a:2:{s:6:"option";s:13:"Default image";s:5:"value";s:7:"default";}i:6;a:2:{s:6:"option";s:8:"Disabled";s:5:"value";s:8:"disabled";}}s:13:"image_source1";s:8:"featured";s:13:"image_source2";s:7:"content";s:13:"image_source3";s:7:"excerpt";s:13:"image_source4";s:6:"custom";s:13:"image_source5";s:7:"default";s:13:"image_default";s:97:"'.esc_url(plugins_url( 'ajax-search-lite/img/default.jpg' )).'";s:21:"image_source_featured";s:20:"vidorev_thumb_1x1_1x";s:18:"image_custom_field";s:0:"";s:12:"use_timthumb";i:1;s:29:"show_frontend_search_settings";s:1:"1";s:16:"showexactmatches";s:1:"1";s:17:"showsearchinposts";s:1:"1";s:17:"showsearchinpages";s:1:"1";s:17:"showsearchintitle";s:1:"1";s:19:"showsearchincontent";s:1:"1";s:15:"showcustomtypes";s:0:"";s:20:"showsearchincomments";i:1;s:19:"showsearchinexcerpt";i:1;s:19:"showsearchinbpusers";i:0;s:20:"showsearchinbpgroups";i:0;s:20:"showsearchinbpforums";i:0;s:16:"exactmatchestext";s:18:"Exact matches only";s:17:"searchinpoststext";s:15:"Search in posts";s:17:"searchinpagestext";s:15:"Search in pages";s:17:"searchintitletext";s:15:"Search in title";s:19:"searchincontenttext";s:17:"Search in content";s:20:"searchincommentstext";s:18:"Search in comments";s:19:"searchinexcerpttext";s:17:"Search in excerpt";s:19:"searchinbpuserstext";s:15:"Search in users";s:20:"searchinbpgroupstext";s:16:"Search in groups";s:20:"searchinbpforumstext";s:16:"Search in forums";s:22:"showsearchincategories";s:1:"1";s:17:"showuncategorised";s:1:"0";s:20:"exsearchincategories";s:0:"";s:26:"exsearchincategoriesheight";i:200;s:22:"showsearchintaxonomies";i:1;s:9:"showterms";s:0:"";s:23:"showseparatefilterboxes";i:1;s:24:"exsearchintaxonomiestext";s:9:"Filter by";s:24:"exsearchincategoriestext";s:20:"Filter by Categories";s:9:"box_width";s:4:"100%";s:10:"box_margin";s:22:"||0px||0px||0px||0px||";s:8:"box_font";s:7:"poppins";s:11:"override_bg";s:1:"1";s:17:"override_bg_color";s:18:"rgba(184, 0, 0, 1)";s:13:"override_icon";s:1:"1";s:22:"override_icon_bg_color";s:18:"rgba(159, 0, 0, 1)";s:19:"override_icon_color";s:18:"rgb(255, 255, 255)";s:15:"override_border";s:1:"0";s:21:"override_border_style";s:59:"border:1px none rgb(0, 0, 0);border-radius:0px 0px 0px 0px;";s:15:"resultstype_def";a:4:{i:0;a:2:{s:6:"option";s:16:"Vertical Results";s:5:"value";s:8:"vertical";}i:1;a:2:{s:6:"option";s:18:"Horizontal Results";s:5:"value";s:10:"horizontal";}i:2;a:2:{s:6:"option";s:16:"Isotopic Results";s:5:"value";s:8:"isotopic";}i:3;a:2:{s:6:"option";s:22:"Polaroid style Results";s:5:"value";s:8:"polaroid";}}s:11:"resultstype";s:8:"vertical";s:19:"resultsposition_def";a:2:{i:0;a:2:{s:6:"option";s:20:"Hover - over content";s:5:"value";s:5:"hover";}i:1;a:2:{s:6:"option";s:22:"Block - pushes content";s:5:"value";s:5:"block";}}s:15:"resultsposition";s:5:"hover";s:16:"resultsmargintop";s:4:"12px";s:16:"v_res_max_height";s:4:"none";s:17:"defaultsearchtext";s:13:"Search here..";s:15:"showmoreresults";s:1:"1";s:19:"showmoreresultstext";s:15:"More results...";s:19:"results_click_blank";s:1:"1";s:17:"scroll_to_results";s:1:"0";s:19:"resultareaclickable";s:1:"1";s:23:"close_on_document_click";s:1:"1";s:15:"show_close_icon";s:1:"1";s:10:"showauthor";s:1:"1";s:8:"showdate";s:1:"1";s:15:"showdescription";s:1:"1";s:17:"descriptionlength";s:2:"50";s:19:"description_context";s:1:"1";s:13:"noresultstext";s:11:"No results!";s:14:"didyoumeantext";s:13:"Did you mean:";s:12:"kw_highlight";s:1:"0";s:24:"kw_highlight_whole_words";s:1:"1";s:15:"highlight_color";s:16:"rgb(217, 49, 43)";s:18:"highlight_bg_color";s:22:"rgba(238, 238, 238, 1)";s:10:"custom_css";s:0:"";s:12:"autocomplete";s:1:"1";s:14:"kw_suggestions";s:1:"1";s:9:"kw_length";s:2:"60";s:8:"kw_count";s:2:"10";s:14:"kw_google_lang";s:2:"en";s:13:"kw_exceptions";s:0:"";s:12:"shortcode_op";s:6:"remove";s:16:"striptagsexclude";s:0:"";s:12:"runshortcode";i:1;s:14:"stripshortcode";i:0;s:19:"pageswithcategories";i:0;s:10:"titlefield";s:1:"0";s:13:"titlefield_cf";s:0:"";s:16:"descriptionfield";s:1:"0";s:19:"descriptionfield_cf";s:0:"";s:22:"woo_exclude_outofstock";s:1:"0";s:18:"exclude_woo_hidden";s:1:"1";s:17:"excludecategories";s:0:"";s:12:"excludeposts";s:0:"";s:18:"wpml_compatibility";s:1:"1";s:22:"polylang_compatibility";s:1:"1";s:21:"classname-customtypes";s:23:"wpdreamsCustomPostTypes";s:8:"wdcfs_10";s:0:"";s:22:"classname-customfields";s:20:"wpdreamsCustomFields";s:10:"asl_submit";s:1:"1";s:10:"submit_asl";s:13:"Save options!";s:25:"classname-showcustomtypes";s:31:"wpdreamsCustomPostTypesEditable";s:30:"classname-exsearchincategories";s:18:"wpdreamsCategories";s:7:"topleft";s:3:"0px";s:11:"bottomright";s:3:"0px";s:8:"topright";s:3:"0px";s:10:"bottomleft";s:3:"0px";s:12:"_colorpicker";s:12:"rgb(0, 0, 0)";s:27:"classname-excludecategories";s:18:"wpdreamsCategories";s:10:"sett_tabid";s:1:"1";s:21:"selected-customfields";N;s:24:"selected-showcustomtypes";N;s:29:"selected-exsearchincategories";N;s:26:"selected-excludecategories";N;s:7:"wdcfs_9";s:0:"";s:20:"selected-customtypes";a:1:{i:0;s:4:"post";}}';	
						
		if($_POST['version'] == 'full-width'){
			$sampleDataFile 	= 'sample-data-full-width.xml';
			$themeOptionFile 	= 'theme-options-full-width.json';
			$front_page_slug 	= 'home-page-vertical-menu';	
			$ajax_search_live	= 'a:155:{s:5:"theme";s:10:"simple-red";s:20:"override_search_form";s:1:"0";s:24:"override_woo_search_form";s:1:"0";s:13:"keyword_logic";s:3:"and";s:23:"trigger_on_facet_change";s:1:"1";s:17:"redirect_click_to";s:12:"results_page";s:17:"redirect_enter_to";s:12:"results_page";s:21:"click_action_location";s:4:"same";s:22:"return_action_location";s:4:"same";s:19:"custom_redirect_url";s:11:"?s={phrase}";s:13:"triggerontype";s:1:"1";s:11:"customtypes";s:20:"_decode_WyJwb3N0Il0=";s:13:"searchintitle";s:1:"1";s:15:"searchincontent";s:1:"1";s:15:"searchinexcerpt";s:1:"1";s:20:"search_in_permalinks";s:1:"0";s:13:"search_in_ids";s:1:"0";s:13:"search_all_cf";s:1:"0";s:12:"customfields";s:0:"";s:11:"post_status";s:7:"publish";s:24:"override_default_results";s:1:"0";s:15:"override_method";s:3:"get";s:9:"exactonly";s:1:"0";s:20:"exact_match_location";s:8:"anywhere";s:13:"searchinterms";s:1:"1";s:9:"charcount";s:1:"0";s:10:"maxresults";s:2:"10";s:10:"itemscount";s:1:"4";s:16:"resultitemheight";s:4:"70px";s:15:"orderby_primary";s:14:"relevance DESC";s:17:"orderby_secondary";s:9:"date DESC";s:11:"show_images";s:1:"1";s:18:"image_transparency";i:1;s:14:"image_bg_color";s:7:"#FFFFFF";s:11:"image_width";s:2:"70";s:12:"image_height";s:2:"70";s:19:"image_crop_location";s:1:"c";s:27:"image_crop_location_selects";a:9:{i:0;a:2:{s:6:"option";s:13:"In the center";s:5:"value";s:1:"c";}i:1;a:2:{s:6:"option";s:9:"Align top";s:5:"value";s:1:"t";}i:2;a:2:{s:6:"option";s:15:"Align top right";s:5:"value";s:2:"tr";}i:3;a:2:{s:6:"option";s:14:"Align top left";s:5:"value";s:2:"tl";}i:4;a:2:{s:6:"option";s:12:"Align bottom";s:5:"value";s:1:"b";}i:5;a:2:{s:6:"option";s:18:"Align bottom right";s:5:"value";s:2:"br";}i:6;a:2:{s:6:"option";s:17:"Align bottom left";s:5:"value";s:2:"bl";}i:7;a:2:{s:6:"option";s:10:"Align left";s:5:"value";s:1:"l";}i:8;a:2:{s:6:"option";s:11:"Align right";s:5:"value";s:1:"r";}}s:13:"image_sources";a:7:{i:0;a:2:{s:6:"option";s:14:"Featured image";s:5:"value";s:8:"featured";}i:1;a:2:{s:6:"option";s:12:"Post Content";s:5:"value";s:7:"content";}i:2;a:2:{s:6:"option";s:12:"Post Excerpt";s:5:"value";s:7:"excerpt";}i:3;a:2:{s:6:"option";s:12:"Custom field";s:5:"value";s:6:"custom";}i:4;a:2:{s:6:"option";s:15:"Page Screenshot";s:5:"value";s:10:"screenshot";}i:5;a:2:{s:6:"option";s:13:"Default image";s:5:"value";s:7:"default";}i:6;a:2:{s:6:"option";s:8:"Disabled";s:5:"value";s:8:"disabled";}}s:13:"image_source1";s:8:"featured";s:13:"image_source2";s:7:"content";s:13:"image_source3";s:7:"excerpt";s:13:"image_source4";s:6:"custom";s:13:"image_source5";s:7:"default";s:13:"image_default";s:89:"'.esc_url(plugins_url( 'ajax-search-lite/img/default.jpg' )).'";s:21:"image_source_featured";s:20:"vidorev_thumb_1x1_1x";s:18:"image_custom_field";s:0:"";s:12:"use_timthumb";i:1;s:29:"show_frontend_search_settings";s:1:"1";s:16:"showexactmatches";s:1:"1";s:17:"showsearchinposts";s:1:"1";s:17:"showsearchinpages";s:1:"1";s:17:"showsearchintitle";s:1:"1";s:19:"showsearchincontent";s:1:"1";s:15:"showcustomtypes";s:0:"";s:20:"showsearchincomments";i:1;s:19:"showsearchinexcerpt";i:1;s:19:"showsearchinbpusers";i:0;s:20:"showsearchinbpgroups";i:0;s:20:"showsearchinbpforums";i:0;s:16:"exactmatchestext";s:18:"Exact matches only";s:17:"searchinpoststext";s:15:"Search in posts";s:17:"searchinpagestext";s:15:"Search in pages";s:17:"searchintitletext";s:15:"Search in title";s:19:"searchincontenttext";s:17:"Search in content";s:20:"searchincommentstext";s:18:"Search in comments";s:19:"searchinexcerpttext";s:17:"Search in excerpt";s:19:"searchinbpuserstext";s:15:"Search in users";s:20:"searchinbpgroupstext";s:16:"Search in groups";s:20:"searchinbpforumstext";s:16:"Search in forums";s:22:"showsearchincategories";s:1:"1";s:17:"showuncategorised";s:1:"0";s:20:"exsearchincategories";s:0:"";s:26:"exsearchincategoriesheight";i:200;s:22:"showsearchintaxonomies";i:1;s:9:"showterms";s:0:"";s:23:"showseparatefilterboxes";i:1;s:24:"exsearchintaxonomiestext";s:9:"Filter by";s:24:"exsearchincategoriestext";s:20:"Filter by Categories";s:9:"box_width";s:4:"100%";s:10:"box_margin";s:22:"||0px||0px||0px||0px||";s:8:"box_font";s:7:"poppins";s:11:"override_bg";s:1:"1";s:17:"override_bg_color";s:19:"rgba(218, 92, 0, 1)";s:13:"override_icon";s:1:"1";s:22:"override_icon_bg_color";s:19:"rgba(200, 84, 0, 1)";s:19:"override_icon_color";s:18:"rgb(255, 255, 255)";s:15:"override_border";s:1:"0";s:21:"override_border_style";s:59:"border:1px none rgb(0, 0, 0);border-radius:0px 0px 0px 0px;";s:15:"resultstype_def";a:4:{i:0;a:2:{s:6:"option";s:16:"Vertical Results";s:5:"value";s:8:"vertical";}i:1;a:2:{s:6:"option";s:18:"Horizontal Results";s:5:"value";s:10:"horizontal";}i:2;a:2:{s:6:"option";s:16:"Isotopic Results";s:5:"value";s:8:"isotopic";}i:3;a:2:{s:6:"option";s:22:"Polaroid style Results";s:5:"value";s:8:"polaroid";}}s:11:"resultstype";s:8:"vertical";s:19:"resultsposition_def";a:2:{i:0;a:2:{s:6:"option";s:20:"Hover - over content";s:5:"value";s:5:"hover";}i:1;a:2:{s:6:"option";s:22:"Block - pushes content";s:5:"value";s:5:"block";}}s:15:"resultsposition";s:5:"hover";s:16:"resultsmargintop";s:4:"12px";s:16:"v_res_max_height";s:4:"none";s:17:"defaultsearchtext";s:13:"Search here..";s:15:"showmoreresults";s:1:"1";s:19:"showmoreresultstext";s:15:"More results...";s:19:"results_click_blank";s:1:"1";s:17:"scroll_to_results";s:1:"0";s:19:"resultareaclickable";s:1:"1";s:23:"close_on_document_click";s:1:"1";s:15:"show_close_icon";s:1:"1";s:10:"showauthor";s:1:"1";s:8:"showdate";s:1:"1";s:15:"showdescription";s:1:"1";s:17:"descriptionlength";s:2:"50";s:19:"description_context";s:1:"1";s:13:"noresultstext";s:11:"No results!";s:14:"didyoumeantext";s:13:"Did you mean:";s:12:"kw_highlight";s:1:"0";s:24:"kw_highlight_whole_words";s:1:"1";s:15:"highlight_color";s:20:"rgba(217, 49, 43, 1)";s:18:"highlight_bg_color";s:22:"rgba(238, 238, 238, 1)";s:10:"custom_css";s:0:"";s:12:"autocomplete";s:1:"1";s:14:"kw_suggestions";s:1:"1";s:9:"kw_length";s:2:"60";s:8:"kw_count";s:2:"10";s:14:"kw_google_lang";s:2:"en";s:13:"kw_exceptions";s:0:"";s:12:"shortcode_op";s:6:"remove";s:16:"striptagsexclude";s:0:"";s:12:"runshortcode";i:1;s:14:"stripshortcode";i:0;s:19:"pageswithcategories";i:0;s:10:"titlefield";s:1:"0";s:13:"titlefield_cf";s:0:"";s:16:"descriptionfield";s:1:"0";s:19:"descriptionfield_cf";s:0:"";s:22:"woo_exclude_outofstock";s:1:"0";s:18:"exclude_woo_hidden";s:1:"1";s:17:"excludecategories";s:0:"";s:12:"excludeposts";s:0:"";s:18:"wpml_compatibility";s:1:"1";s:22:"polylang_compatibility";s:1:"1";s:21:"classname-customtypes";s:23:"wpdreamsCustomPostTypes";s:8:"wdcfs_10";s:0:"";s:22:"classname-customfields";s:20:"wpdreamsCustomFields";s:10:"asl_submit";s:1:"1";s:10:"submit_asl";s:13:"Save options!";s:25:"classname-showcustomtypes";s:31:"wpdreamsCustomPostTypesEditable";s:30:"classname-exsearchincategories";s:18:"wpdreamsCategories";s:7:"topleft";s:3:"0px";s:11:"bottomright";s:3:"0px";s:8:"topright";s:3:"0px";s:10:"bottomleft";s:3:"0px";s:12:"_colorpicker";s:12:"rgb(0, 0, 0)";s:27:"classname-excludecategories";s:18:"wpdreamsCategories";s:10:"sett_tabid";s:1:"1";s:21:"selected-customfields";N;s:24:"selected-showcustomtypes";N;s:29:"selected-exsearchincategories";N;s:26:"selected-excludecategories";N;s:20:"selected-customtypes";a:1:{i:0;s:4:"post";}}';
		}

		$thumbDemoFiles = 	array(
								'0.jpg' 	=> VPE_PLUGIN_PATH . '/sample-data/data/default-thumb-1.jpg',
								'1.jpg' 	=> VPE_PLUGIN_PATH . '/sample-data/data/default-thumb-2.jpg',
								'2.jpg' 	=> VPE_PLUGIN_PATH . '/sample-data/data/default-thumb-3.jpg',
								'3.jpg' 	=> VPE_PLUGIN_PATH . '/sample-data/data/default-thumb-4.jpg',
								'4.jpg' 	=> VPE_PLUGIN_PATH . '/sample-data/data/default-thumb-5.jpg',
								'5.jpg' 	=> VPE_PLUGIN_PATH . '/sample-data/data/default-thumb-6.jpg',						
							);
		
		if ( !defined('WP_LOAD_IMPORTERS') ) {
			define('WP_LOAD_IMPORTERS', true);
		}
		
		if(	!is_plugin_active( 'clean-login/clean-login.php' )
			|| !is_plugin_active( 'elementor/elementor.php' )
			|| !is_plugin_active( 'post-views-counter/post-views-counter.php' )
			|| !is_plugin_active( 'redux-framework/redux-framework.php' )
			|| !is_plugin_active( 'wp-pagenavi/wp-pagenavi.php' )
			|| !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' )
		){
			echo 'plugin-active-error';
			return;
		}
		
		global $wpdb;
		
		require_once(ABSPATH.'wp-includes/pluggable.php');
		require_once(ABSPATH.'wp-admin/includes/image.php');
		require_once(ABSPATH.'wp-admin/includes/file.php' );
		require_once(ABSPATH.'wp-admin/includes/media.php' );
		
		if(!class_exists('WP_Import')){
			require_once(VPE_PLUGIN_PATH . '/sample-data/wordpress-importer/wordpress-importer.php');
		}
		
		if(!function_exists('wie_import_data')){
			require_once(VPE_PLUGIN_PATH . '/sample-data/widget-import/widgets.php');
			require_once(VPE_PLUGIN_PATH . '/sample-data/widget-import/import.php');
		}
		
		/*settings*/
			$post_views_counter_settings_general = get_option('post_views_counter_settings_general');
			if(is_array($post_views_counter_settings_general)){
				$post_views_counter_settings_general['post_types_count'] 	= array('vid_actor', 'vid_channel', 'vid_director', 'vid_playlist', 'vid_series', 'post');
				$post_views_counter_settings_general['post_views_column'] 	= false;
				update_option('post_views_counter_settings_general', $post_views_counter_settings_general);
			}
			
			$post_views_counter_settings_display = get_option('post_views_counter_settings_display');			
			if(is_array($post_views_counter_settings_display)){
				$post_views_counter_settings_display['post_types_display'] 	= array();
				$post_views_counter_settings_display['page_types_display'] 	= array();
				update_option('post_views_counter_settings_display', $post_views_counter_settings_display);
			}
			
			$vid_playlist_layout_settings = array();
			$vid_playlist_layout_settings['vid_playlist_layout'] 			= 'grid-modern';
			$vid_playlist_layout_settings['vid_playlist_items_per_page'] 	= 10;
			$vid_playlist_layout_settings['vid_playlist_pag_type'] 			= 'loadmore-btn';
			$vid_playlist_layout_settings['vid_playlist_listing_sidebar'] 	= '';
			$vid_playlist_layout_settings['vid_single_playlist_layout'] 	= 'list-default';
			$vid_playlist_layout_settings['vid_single_playlist_sidebar'] 	= '';
			update_option('vid_playlist_layout_settings', $vid_playlist_layout_settings);
			
			$vid_actor_layout_settings = array();
			$vid_actor_layout_settings['vid_actor_layout'] 				= 'movie-grid';
			$vid_actor_layout_settings['vid_actor_items_per_page'] 		= 12;
			$vid_actor_layout_settings['vid_actor_pag_type'] 			= 'infinite-scroll';
			$vid_actor_layout_settings['vid_actor_listing_sidebar'] 	= '';
			$vid_actor_layout_settings['vid_single_actor_layout'] 		= 'movie-list';
			$vid_actor_layout_settings['vid_single_actor_sidebar'] 		= '';
			update_option('vid_actor_layout_settings', $vid_actor_layout_settings);
			
			$vid_director_layout_settings = array();
			$vid_director_layout_settings['vid_director_layout'] 			= 'movie-grid';
			$vid_director_layout_settings['vid_director_items_per_page'] 	= 12;
			$vid_director_layout_settings['vid_director_pag_type'] 			= 'infinite-scroll';
			$vid_director_layout_settings['vid_director_listing_sidebar'] 	= '';
			$vid_director_layout_settings['vid_single_director_layout'] 	= 'movie-list';
			$vid_director_layout_settings['vid_single_director_sidebar'] 	= '';
			update_option('vid_director_layout_settings', $vid_director_layout_settings);
			
			$vid_series_layout_settings = array();
			$vid_series_layout_settings['vid_series_layout'] 			= 'grid-special';
			$vid_series_layout_settings['vid_series_items_per_page'] 	= 12;
			$vid_series_layout_settings['vid_series_pag_type'] 			= 'loadmore-btn';
			$vid_series_layout_settings['vid_series_listing_sidebar'] 	= '';
			$vid_series_layout_settings['vid_single_series_layout'] 	= 'grid-default';
			$vid_series_layout_settings['vid_single_series_sidebar'] 	= '';
			update_option('vid_series_layout_settings', $vid_series_layout_settings);
			
			$vid_channel_layout_settings = array();
			$vid_channel_layout_settings['vid_channel_layout'] 							= 'grid-special';
			$vid_channel_layout_settings['vid_channel_items_per_page'] 					= 12;
			$vid_channel_layout_settings['vid_channel_pag_type'] 						= 'loadmore-btn';
			$vid_channel_layout_settings['vid_channel_listing_sidebar'] 				= '';
			$vid_channel_layout_settings['vid_single_channel_layout'] 					= 'grid-small';
			$vid_channel_layout_settings['vid_single_channel_video_items_per_page'] 	= 36;
			$vid_channel_layout_settings['vid_single_channel_playlist_layout'] 			= 'grid-modern';
			$vid_channel_layout_settings['vid_single_channel_playlist_items_per_page'] 	= 12;
			$vid_channel_layout_settings['vid_single_channel_series_layout'] 			= 'grid-modern';
			$vid_channel_layout_settings['vid_single_channel_series_items_per_page'] 	= 12;
			$vid_channel_layout_settings['vid_single_channel_pag_type'] 				= 'loadmore-btn';			
			$vid_channel_layout_settings['vid_single_channel_sidebar'] 	= '';
			update_option('vid_channel_layout_settings', $vid_channel_layout_settings);
			
			update_option('elementor_disable_color_schemes', 'yes');			
			update_option('elementor_disable_typography_schemes', 'yes');
			
			if(isset($ajax_search_live)){				
				$ajax_search_live = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {      
					return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
				}, $ajax_search_live );
				
				update_option('asl_options', unserialize($ajax_search_live));
			}
			
			if(defined('YASR_VERSION_NUM')){

				$yasr_stored_options_update = array();
				
				$yasr_stored_options_update['visitors_stats'] 				= 'yes';
				$yasr_stored_options_update['allowed_user'] 				= 'logged_only';
				$yasr_stored_options_update['snippet_itemtype'] 			= 'BlogPosting';
				$yasr_stored_options_update['publisher'] 					= 'Organization';
				$yasr_stored_options_update['publisher_name'] 				= 'VidoRev';
				$yasr_stored_options_update['publisher_logo'] 				= '';
				/*
				$yasr_stored_options_update['auto_insert_enabled'] 			= 0;
				$yasr_stored_options_update['show_overall_in_loop'] 		= 'disabled';
				$yasr_stored_options_update['show_visitor_votes_in_loop'] 	= 'disabled';
				$yasr_stored_options_update['text_before_stars'] 			= 0;
				$yasr_stored_options_update['enable_ip'] 					= 'no';
				$yasr_stored_options_update['enable_ajax'] 					= 'no';
				$yasr_stored_options_update['stars_title']					= 'no';
				*/
				
				update_option('yasr_general_options', $yasr_stored_options_update);
			}
					
		/*settings*/
		
		/*Set Widget*/
			$sidebars_widgets = get_option( 'sidebars_widgets' );
			if(isset($sidebars_widgets) && is_array($sidebars_widgets)){				
				if(isset($sidebars_widgets['main-sidebar']) && is_array($sidebars_widgets['main-sidebar']) && count($sidebars_widgets['main-sidebar']) > 0){				
					foreach ($sidebars_widgets['main-sidebar'] as $i => $value) {
						unset($sidebars_widgets['main-sidebar'][$i]);
					}
					update_option('sidebars_widgets', $sidebars_widgets);
				}
				if(isset($sidebars_widgets['footer-sidebar']) && is_array($sidebars_widgets['footer-sidebar']) && count($sidebars_widgets['footer-sidebar']) > 0){
					foreach ($sidebars_widgets['footer-sidebar'] as $i => $value) {
						unset($sidebars_widgets['footer-sidebar'][$i]);
					}
					update_option('sidebars_widgets', $sidebars_widgets);
				}
			}
			
			if(	is_plugin_active( 'mailpoet/mailpoet.php' ) ){
				$success = $wpdb->query(
								$wpdb->prepare(
									"INSERT INTO {$wpdb->prefix}mailpoet_forms SET 
									name = %s, body = %s, settings = %s",
									'FORM DEMO 1', 'a:3:{i:0;a:7:{s:4:"type";s:4:"html";s:4:"name";s:19:"Custom text or HTML";s:2:"id";s:4:"html";s:6:"unique";s:1:"0";s:6:"static";s:1:"0";s:6:"params";a:2:{s:4:"text";s:84:"Subscribe to our newsletter and join [mailpoet_subscribers_count] other subscribers.";s:5:"nl2br";s:1:"0";}s:8:"position";s:1:"1";}i:1;a:7:{s:4:"type";s:4:"text";s:4:"name";s:5:"Email";s:2:"id";s:5:"email";s:6:"unique";s:1:"0";s:6:"static";s:1:"1";s:6:"params";a:3:{s:5:"label";s:5:"Email";s:8:"required";s:4:"true";s:12:"label_within";s:1:"1";}s:8:"position";s:1:"2";}i:2;a:7:{s:4:"type";s:6:"submit";s:4:"name";s:6:"Submit";s:2:"id";s:6:"submit";s:6:"unique";s:1:"0";s:6:"static";s:1:"1";s:6:"params";a:1:{s:5:"label";s:10:"Subscribe!";}s:8:"position";s:1:"3";}}', 'a:5:{s:8:"segments";a:1:{i:0;s:1:"3";}s:10:"on_success";s:7:"message";s:15:"success_message";s:61:"Check your inbox or spam folder to confirm your subscription.";s:12:"success_page";s:4:"5263";s:20:"segments_selected_by";s:5:"admin";}'
								)
							);
				
				if($success){						
					$lastInsertNT_ID = $wpdb->insert_id; 
				}else{
					$lastInsertNT_ID = 0;
				}
			}else{
				$lastInsertNT_ID = 0;
			}
			
			$banner_ads = str_replace( '"', '', json_encode(plugins_url( 'vidorev-extensions/sample-data/data/banner-ads.jpg' )) );
			
			$widgetData = json_decode('{"main-sidebar":{"vidorev_post_extensions-2":{"title":"MOST LIKED VIDEOS","layout":"single-slider","post_type":"post-video","category":"","tag":"","ids":"","order_by":"most-liked-all-time","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-14":{"title":"MOST SUBSCRIPTIONS","layout":"list-default","post_type":"vid_channel","category":"","tag":"","ids":"","order_by":"mostsubscribed","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"mailpoet_form-2":{"title":"NEWSLETTER","form":"'.$lastInsertNT_ID.'","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-3":{"title":"MOST VIEWED VIDEOS","layout":"list-special","post_type":"post-video","category":"","tag":"","ids":"","order_by":"most-viewed-all-time","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-4":{"title":"MOST VIEWED PLAYLITS","layout":"list-small-image","post_type":"vid_playlist","category":"","tag":"","ids":"","order_by":"most-viewed-all-time","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"media_image-2":{"attachment_id":2356,"url":"'.$banner_ads.'","title":"","size":"full","width":300,"height":250,"caption":"","alt":"","link_type":"custom","link_url":"https:\/\/themeforest.net\/item\/vidorev-video-wordpress-theme\/21798615?ref=beeteam368","image_classes":"","link_classes":"","link_rel":"","link_target_blank":false,"image_title":"","extraclassname":"img-ads","widgetcolumn":"widget__col-04"}},"footer-sidebar":{"text-2":{"title":"","text":"<img class=\"alignnone wp-image-3276 size-full\" src=\"'.str_replace( '"', '', json_encode(plugins_url( 'vidorev-extensions/sample-data/data/logo-footer.png' )) ).'\" alt=\"\" width=\"179\" height=\"35\" \/>\r\n\r\nVidoRev is a Responsive WordPress Theme best suitable for <strong>VIDEO, MOVIE, NEWS, MAGAZINE, BLOG<\/strong> or <strong>REVIEW SITES<\/strong>.\r\n\r\n<em>Each and every element has been tested to ensure it adapts to modern smartphones and tablets. <\/em>\r\n\r\nSpectr comes with 06 different headers to choose on, 06 homepage layouts, 07 different blog listing layouts and including single post video, playlist, gallery, quote, audio, Soundcloud ....\r\n\r\n<a class=\"basic-button basic-button-default\" style=\"margin-top: 12px;\" href=\"https:\/\/themeforest.net\/item\/vidorev-video-wordpress-theme\/21798615\">FIND OUT MORE \u00a0 <i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"><\/i><\/a>","filter":true,"visual":true,"extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-5":{"title":"LATEST NEWS","layout":"list-default","post_type":"post-without-video","category":"","tag":"","ids":"","order_by":"latest","post_count":"3","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-6":{"title":"MOST DISCUSSED","layout":"list-default","post_type":"post","category":"","tag":"","ids":"","order_by":"most-commented","post_count":"3","extraclassname":"","widgetcolumn":"widget__col-04"}},"elementor-sidebar-1":{"vidorev_post_extensions-7":{"title":"MOST VIEWED VIDEOS","layout":"list-special","post_type":"post-video","category":"","tag":"","ids":"","order_by":"most-viewed-all-time","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"}},"elementor-sidebar-2":{"mailpoet_form-5":{"title":"NEWSLETTER","form":"'.$lastInsertNT_ID.'","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-8":{"title":"MOST LIKED VIDEOS","layout":"single-slider","post_type":"post-video","category":"","tag":"","ids":"","order_by":"most-liked-all-time","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"media_image-5":{"attachment_id":2357,"url":"'.$banner_ads.'","title":"","size":"full","width":300,"height":250,"caption":"","alt":"","link_type":"custom","link_url":"https:\/\/themeforest.net\/item\/vidorev-video-wordpress-theme\/21798615?ref=beeteam368","image_classes":"","link_classes":"","link_rel":"","link_target_blank":false,"image_title":"","extraclassname":"img-ads","widgetcolumn":"widget__col-04"}},"elementor-sidebar-3":{"mailpoet_form-6":{"title":"NEWSLETTER","form":"'.$lastInsertNT_ID.'","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-9":{"title":"MOST LIKED VIDEOS","layout":"list-default","post_type":"post-video","category":"","tag":"","ids":"","order_by":"most-liked-all-time","post_count":"4","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-10":{"title":"NEW PLAYLISTS","layout":"list-small-image","post_type":"vid_playlist","category":"","tag":"","ids":"","order_by":"latest","post_count":"4","extraclassname":"","widgetcolumn":"widget__col-04"},"media_image-6":{"attachment_id":2356,"url":"'.$banner_ads.'","title":"","size":"full","width":300,"height":250,"caption":"","alt":"","link_type":"custom","link_url":"https:\/\/themeforest.net\/item\/vidorev-video-wordpress-theme\/21798615?ref=beeteam368","image_classes":"","link_classes":"","link_rel":"","link_target_blank":false,"image_title":"","extraclassname":"img-ads","widgetcolumn":"widget__col-04"}},"elementor-sidebar-4":{"vidorev_post_extensions-11":{"title":"MOST VEWED VIDEOS","layout":"list-special","post_type":"post-video","category":"","tag":"","ids":"","order_by":"most-liked-all-time","post_count":"6","extraclassname":"","widgetcolumn":"widget__col-04"}},"vidorev-bbpress-1":{"bbp_topics_widget-2":{"title":"Recent Topics","order_by":"popular","parent_forum":"any","max_shown":3,"show_date":true,"show_user":true,"extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-12":{"title":"POPULAR VIDEOS","layout":"list-special","post_type":"post-video","category":"","tag":"","ids":"","order_by":"popular-view-like","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"bbp_views_widget-2":{"title":"VIEWS LIST","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-13":{"title":"MOST VIEWED PLAYLITS","layout":"single-slider","post_type":"vid_playlist","category":"","tag":"","ids":"","order_by":"most-viewed-all-time","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"media_image-7":{"attachment_id":2357,"url":"'.$banner_ads.'","title":"","size":"full","width":300,"height":250,"caption":"","alt":"","link_type":"custom","link_url":"https:\/\/themeforest.net\/item\/vidorev-video-wordpress-theme\/21798615?ref=beeteam368","image_classes":"","link_classes":"","link_rel":"","link_target_blank":false,"image_title":"","extraclassname":"img-ads","widgetcolumn":"widget__col-04"}},"sidemenu-sidebar":{"vidorev_post_extensions-15":{"title":"MOST SUBSCRIPTIONS","layout":"list-default","post_type":"vid_channel","category":"","tag":"","ids":"","order_by":"mostsubscribed","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"vidorev_post_extensions-16":{"title":"HIGHEST RATED","layout":"list-default","post_type":"post-video","category":"","tag":"","ids":"","order_by":"highest_rated","post_count":"5","extraclassname":"","widgetcolumn":"widget__col-04"},"media_image-8":{"attachment_id":2356,"url":"'.$banner_ads.'","title":"","size":"full","width":300,"height":250,"caption":"","alt":"","link_type":"custom","link_url":"https:\/\/themeforest.net\/item\/vidorev-video-wordpress-theme\/21798615","image_classes":"","link_classes":"","link_rel":"","link_target_blank":true,"image_title":"","extraclassname":"img-ads","widgetcolumn":"widget__col-04"}}}');	
			
			if($lastInsertNT_ID == 0){
				unset( $widgetData->{'main-sidebar'}->{'mailpoet_form-2'} );
				unset( $widgetData->{'elementor-sidebar-2'}->{'mailpoet_form-5'} );
				unset( $widgetData->{'elementor-sidebar-3'}->{'mailpoet_form-6'} );
			}
						
			$wie_import_results = wie_import_data( $widgetData );
		/*Set Widget*/
		
		/*sample content*/
			$files = array(
				VPE_PLUGIN_PATH . '/sample-data/data/'.$sampleDataFile
			);
			
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = false;
			
			foreach($files as $file){
				$wp_import->import( $file );
			}
		/*sample content*/	
		
		/*upload img demo*/
			$images_list = 	$thumbDemoFiles;	
			
			$post_gallery_1_id = 0;
			$post_gallery_1 = get_page_by_path( 'special-3', OBJECT, 'post' );
			if($post_gallery_1){
				$post_gallery_1_id = $post_gallery_1->ID;
			}
			
			$post_gallery_2_id = 0;
			$post_gallery_2 = get_page_by_path( 'basic-3', OBJECT, 'post' );
			if($post_gallery_2){
				$post_gallery_2_id = $post_gallery_2->ID;
			}
										
			$parent_post_id	= $post_gallery_1_id;
			
			if(!is_array($images_list) && empty($images_list)){return;}
			$wp_upload_dir = wp_upload_dir();
			
			$image_list_upload = array();
			global $vidorev_sample_data_feature_img_id;
			
			$iz = 1;
			foreach($images_list as $name => $img_url){
				if(isset($img_url)&&$img_url!='' && isset($name)&&$name!='') {
					
					if($iz > 3){
						$parent_post_id	= $post_gallery_2_id;
					}
					
					if(!file_exists($img_url)) {return;}
									
					$newFilePath = $wp_upload_dir['path'].'/'.rand(0,9999).time().$name;				
					
					copy($img_url, $newFilePath);
					
					$filetype = wp_check_filetype(basename($newFilePath), null);
					
					$attachment = 	array(
										'guid'           => $wp_upload_dir['url'].'/'.basename($newFilePath), 
										'post_mime_type' => $filetype['type'],
										'post_title'     => preg_replace('/\.[^.]+$/', '', basename($newFilePath)),
										'post_content'   => '',
										'post_status'    => 'inherit'
									);	
																
					$attach_id=wp_insert_attachment($attachment, $newFilePath, $parent_post_id);								
					$attach_data=wp_generate_attachment_metadata($attach_id, $newFilePath);
					wp_update_attachment_metadata($attach_id, $attach_data);	
					
					array_push($image_list_upload, $attach_id);					
					
					if($iz == 1){
						$vidorev_sample_data_feature_img_id = $attach_id;
					}
				}
				$iz++;
			}
		/*upload img demo*/
		
		/*Home Page*/			
			$front_page = get_page_by_path( $front_page_slug );
			if($front_page){
				update_option('show_on_front', 'page');
				update_option('page_on_front', $front_page->ID);
			}
		/*Home Page*/
		
		/*Theme Options*/			
			$file_to 			= VPE_PLUGIN_URL . '/sample-data/data/'.$themeOptionFile;
			$file_to_contents 	= wp_remote_get( $file_to, array(
				'timeout'     => 368,				
			));
			
			if( is_wp_error( $file_to_contents ) ) {
				
			}else{
				if(isset($file_to_contents['body']) && class_exists('ReduxFrameworkInstances')){
					
					$to_options_arr		= json_decode(wp_remote_retrieve_body($file_to_contents), true);				
					$to_redux 			= ReduxFrameworkInstances::get_instance('vidorev_theme_options');
					$to_redux->set_options($to_options_arr);
					
				}
			}			
		/*Theme Options*/
		
		/*Set Menu*/
			$menus = get_terms('nav_menu', array('hide_empty' => false));
			if ( is_array($menus) && !empty($menus) ) {
				foreach ($menus as $single_menu) {
					if (is_object( $single_menu ) && isset($single_menu->name, $single_menu->term_id) && trim($single_menu->name) == 'Main Menu'){					
						$locations = get_theme_mod( 'nav_menu_locations' );
						$locations['VidoRev-MainMenu'] = $single_menu->term_id;
						set_theme_mod ( 'nav_menu_locations', $locations );
						break;
					}
				}
			}
		/*Set Menu*/
		
		/*Set View, Like, Feature IMG*/			
			$args_query_update_post_meta = array(
				'post_type'				=> array('vid_actor', 'vid_director', 'vid_playlist', 'vid_channel', 'vid_series', 'post'),
				'posts_per_page' 		=> -1,
				'post_status' 			=> 'publish',
																	
			);
			
			$update_post_meta			= get_posts( $args_query_update_post_meta );
			
			$input_view_count 	= 'vm_view_count';
			$input_like_count 	= 'vm_like_count';
			$where 				= ' WHERE user_id = %d AND post_id = %d AND ip = %s';
			$datetime 			= date( 'Y-m-d H:i:s' );
			
			if( $update_post_meta ) {
				
				$feature_img_id = isset($vidorev_sample_data_feature_img_id)&&is_numeric($vidorev_sample_data_feature_img_id)?$vidorev_sample_data_feature_img_id:0;
				
				foreach ( $update_post_meta as $update_id):
				
					$post_id = $update_id->ID;
					
					if(!has_post_thumbnail($post_id)){
					
						update_post_meta($post_id, '_thumbnail_id', $feature_img_id );
						update_post_meta($post_id, MOVIE_PM_PREFIX.'poster_image_id', $feature_img_id );
						
						$like_count = rand(1,1000);
						update_post_meta($post_id, $input_like_count, $like_count);
						if(function_exists('vidorev_already_voted_fetch')){
							$has_voted = vidorev_already_voted_fetch($post_id, 'like');
							if(is_numeric($has_voted)){
								$success = 	$wpdb->query(
												$wpdb->prepare(
													"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
													value = '".$like_count."',
													date_time = '" . $datetime . "'
													".$where,
													0, $post_id, 'like'
												)
											);
							}else{
								$success = 	$wpdb->query(
												$wpdb->prepare(
													"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
													post_id = %d, value = '".$like_count."',
													date_time = '" . $datetime . "',
													user_id = %d, ip = %s",
													$post_id, 0, 'like'
												)
											);					
							}
						}
						
						$view_count = rand(1,1000);
						$current_view_post = trim(get_post_meta($post_id, $input_view_count, true));				
						if(class_exists('Post_Views_Counter')){					
							$total_view_post	= (float)pvc_get_post_views($post_id);	
							
							if(is_numeric($current_view_post) && ($total_view_post>=(float)$current_view_post)){
								$new_view_post = $total_view_post + (float)$view_count - (float)$current_view_post;
							}else{						
								$new_view_post = $total_view_post + (float)$view_count;
							}			
							
							$success_view = $wpdb->query(
								$wpdb->prepare( "
									INSERT INTO " . $wpdb->prefix . "post_views (id, type, period, count)
									VALUES (%d, %d, %s, %d)
									ON DUPLICATE KEY UPDATE count = %d", $post_id, 4, 'total', $new_view_post, $new_view_post
								)
							);
						}			
						
						update_post_meta($post_id, $input_view_count, $view_count);
						
					}
					
				endforeach;
			}
		/*Set Feature IMG*/	
		
		die;
	}
}

if(!function_exists('vidorev_sample_data_ajax')){
	function vidorev_sample_data_ajax(){
		if(is_admin() && isset($_POST['addsample']) && $_POST['addsample']=='yes'){
			add_action('wp_ajax_vidorev_setupsampledata', 'vidorev_sample_data_action');
			add_action('wp_ajax_nopriv_vidorev_setupsampledata', 'vidorev_sample_data_action');	
		}	
	}
}

add_action('admin_init', 'vidorev_sample_data_ajax');

if(!function_exists('vidorev_changemetricld')){
	function vidorev_changemetricld(){
		
		global $wpdb;
				
		$args_query_update_post_meta = array(
			'post_type'				=> array('vid_actor', 'vid_director', 'vid_playlist', 'vid_channel', 'vid_series', 'post'),
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'publish',
																
		);
		
		$update_post_meta			= get_posts( $args_query_update_post_meta );

		$input_like_count 		= 'vm_like_count';
		$input_dislike_count	= 'vm_dislike_count';
		$where 					= ' WHERE user_id = %d AND post_id = %d AND ip = %s';
		$datetime 				= date( 'Y-m-d H:i:s' );
		
		if( $update_post_meta ) {
			
			foreach ( $update_post_meta as $update_id):
			
				$post_id = $update_id->ID;
				
				$like_count = apply_filters('vidorev_fake_bulk_like_count', rand(600,16666));
				$dislike_count = apply_filters('vidorev_fake_bulk_dislike_count', rand(1,199));
				
				update_post_meta($post_id, $input_like_count, $like_count);
				update_post_meta($post_id, $input_dislike_count, $dislike_count);
				if(function_exists('vidorev_already_voted_fetch')){
					$has_voted = vidorev_already_voted_fetch($post_id, 'like');
					if(is_numeric($has_voted)){
						$success = 	$wpdb->query(
										$wpdb->prepare(
											"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
											value = '".$like_count."',
											date_time = '" . $datetime . "'
											".$where,
											0, $post_id, 'like'
										)
									);
					}else{
						$success = 	$wpdb->query(
										$wpdb->prepare(
											"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
											post_id = %d, value = '".$like_count."',
											date_time = '" . $datetime . "',
											user_id = %d, ip = %s",
											$post_id, 0, 'like'
										)
									);					
					}
					
					$has_voted = vidorev_already_voted_fetch($post_id, 'dislike');
					if(is_numeric($has_voted)){
						$success = 	$wpdb->query(
										$wpdb->prepare(
											"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
											value = '-".$dislike_count."',
											date_time = '" . $datetime . "'
											".$where,
											0, $post_id, 'dislike'
										)
									);
					}else{
						$success = 	$wpdb->query(
										$wpdb->prepare(
											"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
											post_id = %d, value = '-".$dislike_count."',
											date_time = '" . $datetime . "',
											user_id = %d, ip = %s",
											$post_id, '0', 'dislike'
										)
									);					
					}
				}
				
				do_action('vidorev_fake_bulk_custom_values', $post_id);
				
			endforeach;
		}
	}
}

if(!function_exists('vidorev_changemetricld_ajax')){
	function vidorev_changemetricld_ajax(){
		if(is_admin() && isset($_POST['change']) && $_POST['change']=='yes'){
			add_action('wp_ajax_vidorev_changemetricld', 'vidorev_changemetricld');
			add_action('wp_ajax_nopriv_vidorev_changemetricld', 'vidorev_changemetricld');	
		}	
	}
}
add_action('admin_init', 'vidorev_changemetricld_ajax');

if(!function_exists('vidorev_upgrade_channels_playlists')){
	function vidorev_upgrade_channels_playlists(){
		
		$args_query_update_post_meta_playlist = array(
			'post_type'				=> array('vid_playlist'),
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'any',
			'fields' 				=> 'ids'					
		);
		
		$update_post_meta_playlist = get_posts( $args_query_update_post_meta_playlist );

		if( $update_post_meta_playlist ) {
			
			foreach ( $update_post_meta_playlist as $update_id_playlist):
				
				$old_playlist_videos = get_post_meta($update_id_playlist, PLAYLIST_PM_PREFIX.'videos', true);				
				if(is_array($old_playlist_videos) && count($old_playlist_videos)>0){
					update_post_meta($update_id_playlist, PLAYLIST_PM_PREFIX.'videos', array_map('strval', $old_playlist_videos));
				}
				
			endforeach;
			
		}
		
		/**/
		
		$args_query_update_post_meta_channel = array(
			'post_type'				=> array('vid_channel'),
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'any',
			'fields' 				=> 'ids'
																
		);
		
		$update_post_meta_channel = get_posts( $args_query_update_post_meta_channel );

		if( $update_post_meta_channel ) {
			
			foreach ( $update_post_meta_channel as $update_id_channel):
				
				$old_channel_videos = get_post_meta($update_id_channel, CHANNEL_PM_PREFIX.'videos', true);				
				if(is_array($old_channel_videos) && count($old_playlist_videos)>0){
					update_post_meta($update_id_channel, CHANNEL_PM_PREFIX.'videos', array_map('strval', $old_channel_videos));
				}
				
				$old_channel_playlists = get_post_meta($update_id_channel, CHANNEL_PM_PREFIX.'playlists', true);				
				if(is_array($old_channel_playlists) && count($old_channel_playlists)>0){
					update_post_meta($update_id_channel, CHANNEL_PM_PREFIX.'playlists', array_map('strval', $old_channel_playlists));
				}
				
			endforeach;
			
		}
		
		die;
	}
}

if(!function_exists('vidorev_upgrade_channels_playlists_ajax')){
	function vidorev_upgrade_channels_playlists_ajax(){
		if(is_admin() && isset($_POST['upgrade']) && $_POST['upgrade']=='yes'){
			add_action('wp_ajax_vidorev_upgrade_channels_playlists', 'vidorev_upgrade_channels_playlists');
			add_action('wp_ajax_nopriv_vidorev_upgrade_channels_playlists', 'vidorev_upgrade_channels_playlists');	
		}	
	}
}
add_action('admin_init', 'vidorev_upgrade_channels_playlists_ajax');