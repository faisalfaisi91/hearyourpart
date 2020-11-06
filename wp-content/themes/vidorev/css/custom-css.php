<?php
if(!function_exists('vidorev_theme_custom_css')){
	function vidorev_theme_custom_css(){
		$css_snippet = '';
		
		/*retina logo*/	
		$main_logo			= '';
		$main_logo_mobile	= '';
		$sticky_logo		= '';
		
		$main_logo_retina 			= '';
		$sticky_logo_retina 		= '';
		$main_logo_mobile_retina 	= '';	
		
		if(is_single() || is_page()){
			$post_id			= get_the_ID();
			
			$main_logo			= trim(get_post_meta($post_id, 'main_logo', true));
			$main_logo_mobile	= trim(get_post_meta($post_id, 'main_logo_mobile', true));
			$sticky_logo		= trim(get_post_meta($post_id, 'sticky_logo', true));
			
			$main_logo_retina 			= trim(get_post_meta($post_id, 'main_logo_retina', true));
			$sticky_logo_retina 		= trim(get_post_meta($post_id, 'sticky_logo_retina', true));
			$main_logo_mobile_retina 	= trim(get_post_meta($post_id, 'main_logo_mobile_retina', true));
		}
			
		if($main_logo=='') 			$main_logo 					= trim(vidorev_get_redux_option('main_logo', '', 'media_get_src'));
		if($sticky_logo=='') 		$sticky_logo 				= trim(vidorev_get_redux_option('sticky_logo', '', 'media_get_src'));
		if($main_logo_mobile=='') 	$main_logo_mobile 			= trim(vidorev_get_redux_option('main_logo_mobile', '', 'media_get_src'));
		
		if($main_logo_retina=='') 			$main_logo_retina 			= trim(vidorev_get_redux_option('main_logo_retina', '', 'media_get_src'));
		if($sticky_logo_retina=='') 		$sticky_logo_retina 		= trim(vidorev_get_redux_option('sticky_logo_retina', '', 'media_get_src'));
		if($main_logo_mobile_retina=='') 	$main_logo_mobile_retina 	= trim(vidorev_get_redux_option('main_logo_mobile_retina', '', 'media_get_src'));		
		
		if($main_logo!=''){
			if($main_logo_retina!=''){
				$css_snippet.=	'@media only screen and (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi){
									.nav-logo .nav-logo-img img.main-logo{
										opacity:0; visibility:hidden
									}
									.nav-logo .nav-logo-img a.logo-link{
										background:url("'.esc_url($main_logo_retina).'") no-repeat center; background-size:contain
									}									
								}';
			}				
		}else{
			$color_mode = '';
			if(is_page()){
				$page_id = get_the_ID();			
				$color_mode = get_post_meta($page_id, 'color_mode', true);				
			}		
			if($color_mode==''){				
				$color_mode = vidorev_get_redux_option('color_mode', 'white');
			}
			$header_style = vidorev_header_style();
			switch($header_style){
				case 'default':
					$main_logo_sample = get_template_directory_uri().'/img/logo-retina.png';
					break;
				case 'classic':
					if($color_mode == 'dark'){
						$main_logo_sample = get_template_directory_uri().'/img/logo-classic-dark-retina.png';
					}else{
						$main_logo_sample = get_template_directory_uri().'/img/logo-classic-retina.png';
					}					
					break;
				case 'sport':
					$main_logo_sample = get_template_directory_uri().'/img/logo-retina.png';
					break;
				case 'tech':
					$main_logo_sample = get_template_directory_uri().'/img/logo-small-retina.png';
					break;
				case 'blog':
					if($color_mode == 'dark'){
						$main_logo_sample = get_template_directory_uri().'/img/logo-blog-retina-dark.png';
					}else{
						$main_logo_sample = get_template_directory_uri().'/img/logo-blog-retina.png';
					}
					break;
				case 'movie':
					$main_logo_sample = get_template_directory_uri().'/img/logo-small-retina.png';
					break;
				case 'side':
					$main_logo_sample = get_template_directory_uri().'/img/logo-mobile-retina.png';
					break;			
				default:
					$main_logo_sample = get_template_directory_uri().'/img/logo.png-retina';						
			}
			$css_snippet.=	'@media only screen and (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi){
								.nav-logo .nav-logo-img img.main-logo{
									opacity:0; visibility:hidden
								}
								.nav-logo .nav-logo-img a.logo-link{
									background:url("'.esc_url($main_logo_sample).'") no-repeat center; background-size:contain
								}								
							}';
		}
		if($sticky_logo!=''){
			if($sticky_logo_retina!=''){
				$css_snippet.=	'@media only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width:992px), (min-resolution: 192dpi) and (min-width:992px){
									.main-nav.sticky-menu .nav-logo-img img.sticky-logo{
										opacity:0; visibility:hidden
									}
									.main-nav.sticky-menu .nav-logo-img a.logo-link{
										background:url("'.esc_url($sticky_logo_retina).'") no-repeat center; background-size:contain
									}
								}';
			}			
		}else{
			$sticky_logo_sample	= get_template_directory_uri().'/img/logo-sticky-default-retina.png';
			$css_snippet.=	'@media only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width:992px), (min-resolution: 192dpi) and (min-width:992px){
								.main-nav.sticky-menu .nav-logo-img img.sticky-logo{
									opacity:0; visibility:hidden
								}
								.main-nav.sticky-menu .nav-logo-img a.logo-link{
									background:url("'.esc_url($sticky_logo_sample).'") no-repeat center; background-size:contain
								}
							}';
		}		
		if($main_logo_mobile!=''){
			if($main_logo_mobile_retina!=''){
				$css_snippet.=	'@media only screen and (-webkit-min-device-pixel-ratio: 2) and (max-width:991px), (min-resolution: 192dpi) and (max-width:991px){
									.nav-logo .nav-logo-img img.main-logo-mobile{
										opacity:0; visibility:hidden
									}
									.nav-logo .nav-logo-img a.logo-link{
										background:url("'.esc_url($main_logo_mobile_retina).'") no-repeat center; background-size:contain
									}
								}';
			}			
		}else{
			$main_logo_mobile_sample = get_template_directory_uri().'/img/logo-mobile-retina.png';	
			$css_snippet.=	'@media  only screen and (-webkit-min-device-pixel-ratio: 2) and (max-width:991px), (min-resolution: 192dpi) and (max-width:991px){
								.nav-logo .nav-logo-img img.main-logo-mobile{
									opacity:0; visibility:hidden
								}
								.nav-logo .nav-logo-img a.logo-link{
									background:url("'.esc_url($main_logo_mobile_sample).'") no-repeat center; background-size:contain
								}
							}';
		}
		/*retina logo*/
		
		/*single post full width bg*/
		if(is_single() && has_post_thumbnail() && vidorev_single_style() == 'full-width' && get_post_format() == '0'){
			$css_snippet.= '.single-post-style-wrapper.full-width{
								background-image: url("'.esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')).'");
								background-repeat:no-repeat;
								background-size:cover;
								background-position: center top;
							}';
		}
		
		if(is_singular('vid_channel') && defined('CHANNEL_PM_PREFIX')){
						
			$channel_banner = trim(get_post_meta( get_the_ID(), CHANNEL_PM_PREFIX.'banner', true ));			
			if($channel_banner!=''){						
				$css_snippet.= '.single-post-style-wrapper.full-width{
									background-image: url("'.esc_url($channel_banner).'");
									background-repeat:no-repeat;
									background-size:cover;
									background-position: center center;
								}';
			}			
		}
		/*single post full width bg*/
		
		$term_taxonomy_color_custom = get_option( 'term_taxonomy_color_custom', array() );
		
		foreach($term_taxonomy_color_custom as $index => $data){
			
			$term_css = '';
			
			if(isset($data['text'])){
				$term_css.='color:'.esc_attr($data['text']).';';
			}
			
			if(isset($data['background'])){
				$term_css.='background-color:'.esc_attr($data['background']).';';
			}
			
			$css_snippet.='.categories-elm .categories-wrap a[data-cat-id="'.esc_attr($index).'"]{'.$term_css.'}';
			
		}	
		
		$header_bg = vidorev_get_redux_option('header_background', array());
		$header_bg_css = '';
		
		if(is_array($header_bg)){
			
			if(isset($header_bg['background-color']) && $header_bg['background-color']!=''){
				$header_bg_css.='background-color:'.esc_attr($header_bg['background-color']).';';
			}
			
			if(isset($header_bg['background-repeat']) && $header_bg['background-repeat']!=''){
				$header_bg_css.='background-repeat:'.esc_attr($header_bg['background-repeat']).';';
			}
			
			if(isset($header_bg['background-attachment']) && $header_bg['background-attachment']!=''){
				$header_bg_css.='background-attachment:'.esc_attr($header_bg['background-attachment']).';';
			}
			
			if(isset($header_bg['background-position']) && $header_bg['background-position']!=''){
				$header_bg_css.='background-position:'.esc_attr($header_bg['background-position']).';';
			}
			
			if(isset($header_bg['background-size']) && $header_bg['background-size']!=''){
				$header_bg_css.='background-size:'.esc_attr($header_bg['background-size']).';';
			}
			
			if(isset($header_bg['background-image']) && $header_bg['background-image']!=''){
				$header_bg_css.='background-image:url("'.esc_url($header_bg['background-image']).'");';
			}
		}
		
		if($header_bg_css!=''){
			$css_snippet.='#site-header{'.$header_bg_css.'}';
		}
		
		$mobile_menu_bg = vidorev_get_redux_option('mobile_menu_background', array());
		$mobile_menu_bg_css = '';
		
		if(is_array($mobile_menu_bg)){
			
			if(isset($mobile_menu_bg['background-color']) && $mobile_menu_bg['background-color']!=''){
				$mobile_menu_bg_css.='background-color:'.esc_attr($mobile_menu_bg['background-color']).';';
			}
			
			if(isset($mobile_menu_bg['background-repeat']) && $mobile_menu_bg['background-repeat']!=''){
				$mobile_menu_bg_css.='background-repeat:'.esc_attr($mobile_menu_bg['background-repeat']).';';
			}
			
			if(isset($mobile_menu_bg['background-attachment']) && $mobile_menu_bg['background-attachment']!=''){
				$mobile_menu_bg_css.='background-attachment:'.esc_attr($mobile_menu_bg['background-attachment']).';';
			}
			
			if(isset($mobile_menu_bg['background-position']) && $mobile_menu_bg['background-position']!=''){
				$mobile_menu_bg_css.='background-position:'.esc_attr($mobile_menu_bg['background-position']).';';
			}
			
			if(isset($mobile_menu_bg['background-size']) && $mobile_menu_bg['background-size']!=''){
				$mobile_menu_bg_css.='background-size:'.esc_attr($mobile_menu_bg['background-size']).';';
			}
			
			if(isset($mobile_menu_bg['background-image']) && $mobile_menu_bg['background-image']!=''){
				$mobile_menu_bg_css.='background-image:url("'.esc_url($mobile_menu_bg['background-image']).'");';
			}
		}
		
		if($mobile_menu_bg_css!=''){
			$css_snippet.='#vp-mobile-menu{'.$mobile_menu_bg_css.'}';
		}
		
		$theme_bg = vidorev_get_redux_option('theme_background', array());
		$theme_bg_css = '';
		
		if(is_array($theme_bg)){
			
			if(isset($theme_bg['background-color']) && $theme_bg['background-color']!=''){
				$theme_bg_css.='background-color:'.esc_attr($theme_bg['background-color']).';';
			}
			
			if(isset($theme_bg['background-repeat']) && $theme_bg['background-repeat']!=''){
				$theme_bg_css.='background-repeat:'.esc_attr($theme_bg['background-repeat']).';';
			}
			
			if(isset($theme_bg['background-attachment']) && $theme_bg['background-attachment']!=''){
				$theme_bg_css.='background-attachment:'.esc_attr($theme_bg['background-attachment']).';';
			}
			
			if(isset($theme_bg['background-position']) && $theme_bg['background-position']!=''){
				$theme_bg_css.='background-position:'.esc_attr($theme_bg['background-position']).';';
			}
			
			if(isset($theme_bg['background-size']) && $theme_bg['background-size']!=''){
				$theme_bg_css.='background-size:'.esc_attr($theme_bg['background-size']).';';
			}
			
			if(isset($theme_bg['background-image']) && $theme_bg['background-image']!=''){
				$theme_bg_css.='background-image:url("'.esc_url($theme_bg['background-image']).'");';
			}
		}
		
		if($theme_bg_css!=''){
			$css_snippet.='#site-wrap-parent{'.$theme_bg_css.'}';
		}
		
		if(is_page()){
			$post_id = get_the_ID();		
			$page_slider_settings = get_post_meta($post_id, 'page_slider_group', true);
			$display_slider_group = get_post_meta($post_id, 'display_slider_group', true);
			
			$i = 1;
			if(is_array($page_slider_settings) && count($page_slider_settings)>0 && $display_slider_group=='yes'){
				foreach ($page_slider_settings as $slider_item){
					$header_slider_css = '';
					
					if(isset($slider_item['margin_top']) && $slider_item['margin_top']!=''){
						$header_slider_css.='margin-top:'.esc_attr($slider_item['margin_top']).';';
					}
					
					if(isset($slider_item['margin_bottom']) && $slider_item['margin_bottom']!=''){
						$header_slider_css.='margin-bottom:'.esc_attr($slider_item['margin_bottom']).';';
					}
					
					if(isset($slider_item['padding_top']) && $slider_item['padding_top']!=''){
						$header_slider_css.='padding-top:'.esc_attr($slider_item['padding_top']).';';
					}
					
					if(isset($slider_item['padding_bottom']) && $slider_item['padding_bottom']!=''){
						$header_slider_css.='padding-bottom:'.esc_attr($slider_item['padding_bottom']).';';
					}
					
					if(isset($slider_item['padding_left']) && $slider_item['padding_left']!=''){
						$header_slider_css.='padding-left:'.esc_attr($slider_item['padding_left']).';';
					}
					
					if(isset($slider_item['padding_right']) && $slider_item['padding_right']!=''){
						$header_slider_css.='padding-right:'.esc_attr($slider_item['padding_right']).';';
					}
					
					if(isset($slider_item['background_color']) && $slider_item['background_color']!=''){
						$header_slider_css.='background-color:'.esc_attr($slider_item['background_color']).';';
					}
					
					if($header_slider_css!=''){
						$css_snippet.='#header-slider-'.esc_attr($i).'{'.$header_slider_css.'}';
					}
					$i++;
				}
			}
			
		}		
				
		/*theme background & header background*/
		if(is_single() || is_page()){
			$post_id			= get_the_ID();
			
			$page_header_bg = get_post_meta($post_id, 'header_background', true);
			$page_header_bg_css = '';
			
			if(is_array($page_header_bg)){
				
				foreach($page_header_bg as $page_header_bg_item){				
					if(isset($page_header_bg_item['background-color']) && $page_header_bg_item['background-color']!='' && $page_header_bg_item!='#'){
						$page_header_bg_css.='background-color:'.esc_attr($page_header_bg_item['background-color']).';';
					}
					
					if(isset($page_header_bg_item['background-repeat']) && $page_header_bg_item['background-repeat']!=''){
						$page_header_bg_css.='background-repeat:'.esc_attr($page_header_bg_item['background-repeat']).';';
					}
					
					if(isset($page_header_bg_item['background-attachment']) && $page_header_bg_item['background-attachment']!=''){
						$page_header_bg_css.='background-attachment:'.esc_attr($page_header_bg_item['background-attachment']).';';
					}
					
					if(isset($page_header_bg_item['background-position']) && $page_header_bg_item['background-position']!=''){
						$page_header_bg_css.='background-position:'.esc_attr($page_header_bg_item['background-position']).';';
					}
					
					if(isset($page_header_bg_item['background-size']) && $page_header_bg_item['background-size']!=''){
						$page_header_bg_css.='background-size:'.esc_attr($page_header_bg_item['background-size']).';';
					}
					
					if(isset($page_header_bg_item['background-image']) && $page_header_bg_item['background-image']!=''){
						$page_header_bg_css.='background-image:url("'.esc_url($page_header_bg_item['background-image']).'");';
					}
				}
				
			}
			
			if($page_header_bg_css!=''){
				$css_snippet.='#site-header{'.$page_header_bg_css.'}';
			}
			
			$page_theme_bg = get_post_meta($post_id, 'theme_background', true);
			$page_theme_bg_css = '';
			
			if(is_array($page_theme_bg)){
				
				foreach($page_theme_bg as $page_theme_bg_item){				
					if(isset($page_theme_bg_item['background-color']) && $page_theme_bg_item['background-color']!='' && $page_theme_bg_item!='#'){
						$page_theme_bg_css.='background-color:'.esc_attr($page_theme_bg_item['background-color']).';';
					}
					
					if(isset($page_theme_bg_item['background-repeat']) && $page_theme_bg_item['background-repeat']!=''){
						$page_theme_bg_css.='background-repeat:'.esc_attr($page_theme_bg_item['background-repeat']).';';
					}
					
					if(isset($page_theme_bg_item['background-attachment']) && $page_theme_bg_item['background-attachment']!=''){
						$page_theme_bg_css.='background-attachment:'.esc_attr($page_theme_bg_item['background-attachment']).';';
					}
					
					if(isset($page_theme_bg_item['background-position']) && $page_theme_bg_item['background-position']!=''){
						$page_theme_bg_css.='background-position:'.esc_attr($page_theme_bg_item['background-position']).';';
					}
					
					if(isset($page_theme_bg_item['background-size']) && $page_theme_bg_item['background-size']!=''){
						$page_theme_bg_css.='background-size:'.esc_attr($page_theme_bg_item['background-size']).';';
					}
					
					if(isset($page_theme_bg_item['background-image']) && $page_theme_bg_item['background-image']!=''){
						$page_theme_bg_css.='background-image:url("'.esc_url($page_theme_bg_item['background-image']).'");';
					}
				}
			}
			
			if($page_theme_bg_css!=''){
				$css_snippet.='#site-wrap-parent{'.$page_theme_bg_css.'}';
			}			
		}
		/*theme background & header background*/
		
		$css_snippet.= 'header.entry-header.movie-style{
							background-image: url("'.esc_url(get_template_directory_uri()).'/img/film-background.jpg");								
						}';
						
		/*single Actor Director Header Background*/
		if( (is_singular('vid_actor') || is_singular('vid_director')) && defined('MOVIE_PM_PREFIX') ){
						
			$adda_banner = trim(get_post_meta( get_the_ID(), MOVIE_PM_PREFIX.'background_adda', true ));			
			if($adda_banner!=''){						
				$css_snippet.= 'header.entry-header.movie-style{
									background-image: url("'.esc_url($adda_banner).'");									
								}';
			}			
		}		
		/*single Actor Director Header Background*/					
		
		if(function_exists('clean_login_register_show') && function_exists('clean_login_enqueue_style')){
						
			$color_mode = '';
			if(is_page()){
				$page_id = get_the_ID();			
				$color_mode = get_post_meta($page_id, 'color_mode', true);				
			}		
			if($color_mode==''){				
				$color_mode = vidorev_get_redux_option('color_mode', 'white');
			}				
			if ( $color_mode == 'dark' ) {
				$css_snippet.= '.cleanlogin-field-username{background-image:url("'.esc_url(get_template_directory_uri()).'/img/clean-login/log.png");}';
				$css_snippet.= '.cleanlogin-field-password{background-image:url("'.esc_url(get_template_directory_uri()).'/img/clean-login/pwd.png");}';
				$css_snippet.= '.cleanlogin-field-name{background-image:url("'.esc_url(get_template_directory_uri()).'/img/clean-login/name.png");}';
				$css_snippet.= '.cleanlogin-field-surname{background-image:url("'.esc_url(get_template_directory_uri()).'/img/clean-login/surname.png");}';
				$css_snippet.= '.cleanlogin-field-email{background-image:url("'.esc_url(get_template_directory_uri()).'/img/clean-login/mail.png");}';
				$css_snippet.= '.cleanlogin-field-spam{background-image:url("'.esc_url(get_template_directory_uri()).'/img/clean-login/spam.png");}';
			}	
		
		}
		
		/*main color*/		
		$main_skin_color = vidorev_get_redux_option('main_skin_color', '');		
		if(isset($main_skin_color) && $main_skin_color!='' && $main_skin_color!='#'){
			
			$main_skin_color_rgb 	= vidorev_hex2rgb($main_skin_color);
			$main_color_mixing 		= vidorev_get_redux_option('main_color_mixing', 0.1);	
			$main_skin_color_mix 	= vidorev_rgb2hex(vidorev_mix_color(array(0, 0, 0), $main_skin_color_rgb, $main_color_mixing));

			/*color*/
			$css_snippet.= '
			a:focus {
				color: '.esc_attr($main_skin_color).';
			}
			a:hover {
				color: '.esc_attr($main_skin_color).';
			}
			a.main-color-udr{
				color: '.esc_attr($main_skin_color).';
			}			
			.dark-background a:focus {
				color: '.esc_attr($main_skin_color).';
			}
			.dark-background a:hover {
				color: '.esc_attr($main_skin_color).';
			}			
			button.white-style:hover, button.white-style:focus,
			input[type=button].white-style:hover,
			input[type=button].white-style:focus,
			input[type=submit].white-style:hover,
			input[type=submit].white-style:focus,
			input[type="reset"].white-style:hover,
			input[type="reset"].white-style:focus,
			.basic-button-default.white-style:hover,
			.basic-button-default.white-style:focus{
				color: '.esc_attr($main_skin_color).';
			}
			
			.global-single-content .like-dislike-toolbar-footer .ld-t-item-content:hover > span {
				color: '.esc_attr($main_skin_color).';
			}
			.global-single-content .like-dislike-toolbar-footer .ld-t-item-content.active-item > span {
				color: '.esc_attr($main_skin_color).';
			}
			
			.popular-video-footer .popular-video-content .block-left .vid-title-main {
				color: '.esc_attr($main_skin_color).';
			}
			
			.video-toolbar .toolbar-item-content:hover > span {
				color: '.esc_attr($main_skin_color).';
			}
			.video-toolbar .toolbar-item-content.active-item > span {
				color: '.esc_attr($main_skin_color).';
			}
			
			.top-watch-later-listing .remove-item-watch-later:hover {
				color: '.esc_attr($main_skin_color).';
			}
			
			.list-default .post-item.sticky .post-title a:not(:hover),
			.list-blog .post-item.sticky .post-title a:not(:hover){
				color: '.esc_attr($main_skin_color).';
			}
			
			#bbpress-forums ul.bbp-topics li.bbp-body p.bbp-topic-meta a.bbp-author-name,
			#bbpress-forums div.bbp-topic-author a.bbp-author-name,
			#bbpress-forums div.bbp-reply-author a.bbp-author-name,
			#bbpress-forums .bbp-topic-content ul.bbp-topic-revision-log a,
			#bbpress-forums .bbp-reply-content ul.bbp-topic-revision-log a,
			#bbpress-forums .bbp-reply-content ul.bbp-reply-revision-log a,
			#bbpress-forums div.bbp-template-notice p a.bbp-author-name,
			#bbpress-forums div.indicator-hint p a.bbp-author-name,
			.video-player-wrap .vidorev-membership-wrapper .vidorev-membership-content .membership-lock-text span.level-highlight,
			.pmpro_content_message,
			.pmpro_actionlinks a,
			.pmpro_actionlinks a:hover,
			small a,
			small a:hover,
			.dark-background small a,
			.dark-background small a:hover,
			#pmpro_form .pmpro_checkout h3 span.pmpro_checkout-h3-msg a,
			#pmpro_form .pmpro_checkout h3 span.pmpro_checkout-h3-msg a:hover,
			.woocommerce .product.type-product .product_meta > * a,
			body.header-vid-side div.asl_r .results .item span.highlighted,
			.woocommerce-info:before{
				color: '.esc_attr($main_skin_color).';
			}
			
			';
			/*color*/
			
			/*border-color*/
			$css_snippet.= '
			
			blockquote{
				border-left-color:'.esc_attr($main_skin_color).';
				border-right-color:'.esc_attr($main_skin_color).';
			}
			
			.alphabet-filter a.active-item {				
				border-color: '.esc_attr($main_skin_color).';
			}
			
			.dark-background .alphabet-filter a.active-item {				
				border-color: '.esc_attr($main_skin_color).';
			}
			
			.video-load-icon {				
				border-left-color:'.esc_attr($main_skin_color).';				
			}
			
			.dark-background .video-load-icon {				
				border-left-color: '.esc_attr($main_skin_color).';
			}
			
			.list-blog .post-item .bloglisting-read-more:hover,
			.video-player-wrap .vidorev-membership-wrapper .vidorev-membership-content .membership-lock-text span.level-highlight,
			.pmpro_content_message,
			.download-lightbox .download-listing .download-package .package-title{
				border-color: '.esc_attr($main_skin_color).';
			}
			
			.sc-playlist-wrapper{
				border-top-color:'.esc_attr($main_skin_color).';
				border-bottom-color:'.esc_attr($main_skin_color).';
			}
			
			.woocommerce-info{
				border-top-color:'.esc_attr($main_skin_color).';
			}
			
			';
			/*border-color*/
			
			/*background-color*/
				/*plugin*/
				$css_snippet.= '
				.slider-container button[type="button"].slick-arrow:hover,
				.slider-container button[type="button"].slick-arrow:focus {
					background-color: '.esc_attr($main_skin_color).';
					background: linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
					background: -webkit-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
					background: -moz-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				}
				.slider-container .sync-slider-small .sync-item:before {					
					background-color: '.esc_attr($main_skin_color).';
				}
				.sc-blocks-container .ajax-loading .video-load-icon {
					border-right-color: '.esc_attr($main_skin_color).';
					border-bottom-color: '.esc_attr($main_skin_color).';
				}
				.sc-blocks-container .filter-items .nav__dropdown .filter-item:hover {
					background-color: '.esc_attr($main_skin_color).';
				}
				.sc-blocks-container .filter-items .nav__dropdown .filter-item.active-item {
					background-color: '.esc_attr($main_skin_color).';
				}
				';
				/*plugin*/
			$css_snippet.= '
			button:not([aria-controls]):not([aria-live]),
			input[type=button],
			input[type=submit],
			input[type="reset"],
			.basic-button-default,
			.next-content a,
			.prev-content a,
			.pmpro_btn, 
			.pmpro_btn:link, 
			.pmpro_content_message a, 
			.pmpro_content_message a:link,
			.pmpro_checkout .pmpro_btn,
			#nav-below.navigation a,
			.woocommerce #respond input#submit, 
			.woocommerce a.button, 
			.woocommerce button.button, 
			.woocommerce input.button{
				background-color: '.esc_attr($main_skin_color).';
				background: linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				background: -webkit-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				background: -moz-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
			}
			
			button:not([aria-controls]):not([aria-live]):visited,
			input[type=button]:visited,
			input[type=submit]:visited,
			input[type="reset"]:visited,
			.basic-button-default:visited,
			.next-content a:visited,
			.prev-content a:visited,
			.pmpro_btn:visited, 
			.pmpro_btn:link:visited, 
			.pmpro_content_message a:visited, 
			.pmpro_content_message a:link:visited,
			.pmpro_checkout .pmpro_btn:visited,
			#nav-below.navigation a:visited,
			.woocommerce #respond input#submit:visited, 
			.woocommerce a.button:visited, 
			.woocommerce button.button:visited, 
			.woocommerce input.button:visited{
				background-color: '.esc_attr($main_skin_color).';
				background: linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				background: -webkit-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				background: -moz-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
			}
			
			.main-nav{
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.nav-menu > ul > li:hover > a{
				background-color: '.esc_attr($main_skin_color_mix).';
			}
			
			.nav-menu > ul > li.current-menu-ancestor:not(.top-megamenu) > a, .nav-menu > ul > li.current-menu-item:not(.top-megamenu) > a{				
				background-color: '.esc_attr($main_skin_color_mix).';
			}
			
			.nav-menu > ul > li ul li:hover > a {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.nav-menu > ul > li ul li.current-menu-ancestor > a, .nav-menu > ul > li ul li.current-menu-item > a{
				background-color: '.esc_attr($main_skin_color).';
			}
			
			@media (min-width: 992px) {
				.header-sport .top-nav {
					background-color: '.esc_attr($main_skin_color).';
				}
			}
			
			.top-search-box .top-search-box-wrapper .search-terms-textfield {				
				background-color: '.$main_skin_color_mix.';				
			}
			
			.top-search-box .top-search-box-wrapper .search-terms-textfield:-webkit-autofill, 
			.top-search-box .top-search-box-wrapper .search-terms-textfield:-webkit-autofill:hover, 
			.top-search-box .top-search-box-wrapper .search-terms-textfield:-webkit-autofill:focus, 
			.top-search-box .top-search-box-wrapper .search-terms-textfield:focus:-webkit-autofill {
				background-color: '.esc_attr($main_skin_color_mix).' !important;
				-webkit-box-shadow: 0 0 0 50px '.esc_attr($main_skin_color_mix).' inset;
			}
			
			.vp-widget-post-layout.wg-single-slider .slick-dots > * > button:hover {
				background: '.esc_attr($main_skin_color).';
			}
			.vp-widget-post-layout.wg-single-slider .slick-dots > *.slick-active > button {
				background: '.esc_attr($main_skin_color).';
			}
			
			.list-blog .post-item .bloglisting-read-more:hover,
			.list-blog .post-item .bloglisting-read-more:hover:before, 
			.list-blog .post-item .bloglisting-read-more:hover:after{
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.categories-elm .category-item,
			.dark-background .categories-elm .category-item{
				background-color: '.esc_attr($main_skin_color).';	
			}
			
			.widget .widget-title > span:not(.widget-arrow):after{
				background-color: '.esc_attr($main_skin_color).';	
			}
			
			.widget.widget_wysija .widget_wysija_cont .error,
			.widget.widget_wysija .widget_wysija_cont .xdetailed-errors {
				background-color: '.esc_attr($main_skin_color).';				
			}
			
			.post-item-wrap:hover .video-icon {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.blog-pic-wrap:hover .video-icon {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.video-icon.alway-active {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			@keyframes videoiconclick {
				from {
					transform: scale3d(1, 1, 1);
					background-color: '.esc_attr($main_skin_color).';
				}
				50% {
					transform: scale3d(1.1, 1.1, 1.1);
					background-color: rgba(0, 0, 0, 0.5);
				}
				to {
					transform: scale3d(1, 1, 1);
					background-color: '.esc_attr($main_skin_color).';
				}
			}
			@-webkit-keyframes videoiconclick {
				from {
					transform: scale3d(1, 1, 1);
					background-color: '.esc_attr($main_skin_color).';
				}
				50% {
					transform: scale3d(1.1, 1.1, 1.1);
					background-color: rgba(0, 0, 0, 0.5);
				}
				to {
					transform: scale3d(1, 1, 1);
					background-color: '.esc_attr($main_skin_color).';
				}
			}
			
			.watch-later-icon:hover {
				background-color: '.esc_attr($main_skin_color).';
			}
			.watch-later-icon.active-item {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.blog-pagination .wp-pagenavi-wrapper .wp-pagenavi .current,
			.blog-pagination .wp-pagenavi-wrapper .wp-pagenavi a:hover,
			.woocommerce nav.woocommerce-pagination .page-numbers li > *.current, 
			.woocommerce nav.woocommerce-pagination .page-numbers li > *:hover,
			.woocommerce nav.woocommerce-pagination .page-numbers li > *:focus {
				background-color: '.esc_attr($main_skin_color).';
				background: linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				background: -webkit-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				background: -moz-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
			}
			
			.infinite-la-fire {
				color: '.esc_attr($main_skin_color).';				
			}
			
			body.active-alphabet-filter .alphabet-filter-icon {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.alphabet-filter a.active-item {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.dark-background .alphabet-filter a.active-item {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.single-image-gallery .slick-dots > * > button:hover {
				background: '.esc_attr($main_skin_color).';
			}
			.single-image-gallery .slick-dots > *.slick-active > button {
				background: '.esc_attr($main_skin_color).';
			}
			
			.popular-video-footer .popular-video-content .slider-popular-container .slick-arrow:hover {
				background-color: '.esc_attr($main_skin_color).';
				background: linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				background: -webkit-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
				background: -moz-linear-gradient(to left bottom, '.esc_attr($main_skin_color).' 50%, '.esc_attr($main_skin_color_mix).' 50%);
			}
			
			.auto-next-icon.active-item {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.auto-next-icon.big-style.active-item {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.video-player-wrap .autoplay-off-elm:hover .video-icon {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.video-player-wrap .player-muted:after {				
				background-color: '.esc_attr($main_skin_color).';				
			}
			
			.video-lightbox-wrapper .listing-toolbar .toolbar-item.active-item:after {
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.cleanlogin-notification.error, .cleanlogin-notification.success,
			.cleanlogin-notification.error,
			.cleanlogin-notification.success {				
				background: '.esc_attr($main_skin_color).';				
			}
			
			.nav-menu > ul > li.top-megamenu > ul .megamenu-menu > *:first-child .megamenu-item-heading:not(.hidden-item),
			.nav-menu > ul > li.top-megamenu > ul .megamenu-menu .megamenu-item-heading:hover, 
			.nav-menu > ul > li.top-megamenu > ul .megamenu-menu .megamenu-item-heading.active-item{
				background-color: '.esc_attr($main_skin_color).';
			}
			
			#user-submitted-posts #usp_form div#usp-error-message.usp-callout-failure,
			#user-submitted-posts #usp_form div#usp-error-message .usp-error,
			#user-submitted-posts #usp_form ul.parsley-errors-list.filled li.parsley-required{
				background-color: '.esc_attr($main_skin_color).';
			}
			
			
			#bbpress-forums li.bbp-header{
				background: '.esc_attr($main_skin_color).';
			}
			#bbpress-forums div.bbp-breadcrumb ~ span#subscription-toggle .is-subscribed a.subscription-toggle{
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.img-lightbox-icon:hover:after{
				background-color: '.esc_attr($main_skin_color).';
			}
			
			.video-sub-toolbar .toolbar-item-content.view-like-information .like-dislike-bar > span,
			.video-sub-toolbar .item-button:hover,
			.video-sub-toolbar .toolbar-item-content .report-form .report-info.report-no-data, 
			.video-sub-toolbar .toolbar-item-content .report-form .report-info.report-error,
			.director-element.single-element .actor-element-title span:after, 
			.director-element.single-element .director-element-title span:after, 
			.actor-element.single-element .actor-element-title span:after, 
			.actor-element.single-element .director-element-title span:after,
			.series-wrapper .series-item.active-item,
			.single-post-video-full-width-wrapper .series-wrapper .series-item.active-item,
			.video-player-wrap .other-ads-container .skip-ad .skip-text,
			.video-toolbar .toolbar-item-content.free-files-download,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
			.woocommerce div.product .woocommerce-tabs ul.tabs li:hover, 
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.dark-background.woocommerce div.product .woocommerce-tabs ul.tabs li:hover, 
			.dark-background.woocommerce div.product .woocommerce-tabs ul.tabs li.active, 
			.dark-background .woocommerce div.product .woocommerce-tabs ul.tabs li:hover, 
			.dark-background .woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.duration-text .rating-average-dr,
			.slider-container.slider-9 .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
			body.header-vid-side div.asl_r .mCSBap_scrollTools .mCSBap_dragger .mCSBap_dragger_bar,
			.slider-container.slider-9 .os-theme-dark .os-scrollbar > .os-scrollbar-track > .os-scrollbar-handle,
			.slider-container.slider-9 .os-theme-dark .os-scrollbar:hover > .os-scrollbar-track > .os-scrollbar-handle, 
			.slider-container.slider-9 .os-theme-dark .os-scrollbar > .os-scrollbar-track > .os-scrollbar-handle.active{
				background-color: '.esc_attr($main_skin_color).';
			}
			';
			/*background-color*/
		}
		/*main color*/
		
		/*sub color*/		
		$sub_skin_color = vidorev_get_redux_option('sub_skin_color', '');		
		if(isset($sub_skin_color) && $sub_skin_color!='' && $sub_skin_color!='#'){
			/*color*/
			$css_snippet.= '
			.global-single-content .like-dislike-toolbar-footer .ld-t-item-content.active-item-sub > span {
				color: '.esc_attr($sub_skin_color).';
			}
			.video-toolbar .toolbar-item-content.active-item-sub > span {
				color: '.esc_attr($sub_skin_color).';
			}
			';
			/*color*/
			
			/*border-color*/
			$css_snippet.= '
			.global-single-content .like-dislike-toolbar-footer .ld-t-item-content .login-tooltip:after {				
				border-bottom-color: '.esc_attr($sub_skin_color).';				
			}
			.video-toolbar .toolbar-item-content .login-tooltip:after {				
				border-bottom-color: '.esc_attr($sub_skin_color).';				
			}
			.video-lightbox-wrapper .lib-contents .data-lightbox-content .ajax-comment-form.disable-comment .ajax-comment-form-wrapper .login-tooltip:after {				
				border-bottom-color: '.esc_attr($sub_skin_color).';
			}
			.video-sub-toolbar .toolbar-item-content .login-tooltip:after{
				border-bottom-color: '.esc_attr($sub_skin_color).';
			}			
			';
			/*border-color*/
			
			/*background-color*/
			$css_snippet.= '
			.widget.widget_wysija .widget_wysija_cont .updated,
			.widget.widget_wysija .widget_wysija_cont .login .message {
				background-color: '.esc_attr($sub_skin_color).';
			}
			.global-single-content .like-dislike-toolbar-footer .ld-t-item-content .login-tooltip {				
				background-color: '.esc_attr($sub_skin_color).';				
			}
			
			.video-toolbar .toolbar-item-content .login-tooltip {			
				background-color: '.esc_attr($sub_skin_color).';			
			}
			
			.video-lightbox-wrapper .lib-contents .data-lightbox-content .ajax-comment-form.disable-comment .ajax-comment-form-wrapper .login-tooltip {				
				background-color: '.esc_attr($sub_skin_color).';				
			}
			
			.cleanlogin-notification.success {
				background: '.esc_attr($sub_skin_color).';
			}
			
			#user-submitted-posts #usp_form div#usp-success-message{
				background-color: '.esc_attr($sub_skin_color).';
			}			
			.video-sub-toolbar .item-button.active-item,
			.video-sub-toolbar .toolbar-item-content .report-form .report-info.report-success,
			.video-sub-toolbar .item-button.complete-action,
			.video-sub-toolbar .toolbar-item-content .login-tooltip{
				background-color: '.esc_attr($sub_skin_color).';
			}
			';
			/*background-color*/
		}
		/*sub color*/
		
		/*typography*/
		$main_font 	= vidorev_get_redux_option('main_font', array());
		$hea_font 	= vidorev_get_redux_option('hea_font', array());
		$nav_font 	= vidorev_get_redux_option('nav_font', array());
		$meta_font 	= vidorev_get_redux_option('meta_font', array());
		
			/*main*/
			$main_font_css = '';
			$main_font_size_css = '';
			if(isset($main_font['font-family']) && $main_font['font-family']!=''){
				$main_font_css.='font-family:'.esc_attr($main_font['font-family']).';';
			}		
			if(isset($main_font['line-height']) && $main_font['line-height']!=''){
				$main_font_css.='line-height:'.esc_attr($main_font['line-height']).';';
			}
			if(isset($main_font['font-weight']) && $main_font['font-weight']!=''){
				$main_font_css.='font-weight:'.esc_attr($main_font['font-weight']).';';
			}
			if(isset($main_font['font-style']) && $main_font['font-style']!=''){
				$main_font_css.='font-style:'.esc_attr($main_font['font-style']).';';
			}
			if(isset($main_font['text-transform']) && $main_font['text-transform']!=''){
				$main_font_css.='text-transform:'.esc_attr($main_font['text-transform']).';';
			}
			if(isset($main_font['letter-spacing']) && $main_font['letter-spacing']!=''){
				$main_font_css.='letter-spacing:'.esc_attr($main_font['letter-spacing']).';';
			}
			
			if($main_font_css!=''){
				$css_snippet.='	body,.body-typography,
								input:not([type]),input[type="text"],input[type="email"],input[type="url"],input[type="password"],input[type="search"],input[type="number"],input[type="tel"],input[type="range"],
								input[type="date"],input[type="month"],input[type="week"],input[type="time"],input[type="datetime"],input[type="datetime-local"],input[type="color"],textarea,select,
								#pmpro_form .pmpro_checkout h3 span.pmpro_checkout-h3-msg,.video-player-wrap .fluid_video_wrapper,body.header-vid-side div.asl_r .results .item .asl_desc, body.header-vid-side div.asl_s.searchsettings .asl_option_label
								{'.$main_font_css.'}';
				/*youzer*/				
				$css_snippet.='body.buddypress, body.buddypress .logy-form-item .logy-item-content input, body.buddypress .yzb-head-content .yzb-head-meta, body.buddypress .logy-form .logy-form-message p, body.buddypress .uk-panel-msg .uk-msg-content p, body.buddypress .logy-form .logy-form-desc, body.buddypress [data-yztooltip]:after, body.buddypress .yz-items-list-widget, body.buddypress .yz-my-account-widget, body.buddypress .yz-usermeta li span, body.buddypress .yzb-account-menu a, body.buddypress .yzb-author-infos p, body.buddypress .youzer-dialog-desc, body.buddypress .widget.buddypress, body.buddypress .yz-tooltip:after, body.buddypress #sitewide-notice #message, body.buddypress #sitewide-notice strong, body.buddypress .youzer_msg span, body.buddypress textarea, body.buddypress .logy-form-note, body.buddypress select, body.buddypress .youzer-dialog, body.buddypress input, body.buddypress .uk-popup, body.buddypress .logy, body.buddypress .option-content input:not([type=radio]), body.buddypress .option-content input:not([type=radio]):not(.uk-upload-button):not(.wp-color-picker):not(.wp-picker-clear), body.buddypress .option-content textarea, body.buddypress .option-content select, body.buddypress .uk-option-item .option-desc, body.buddypress .yz-account-head span, body.buddypress #yz-directory-search-box form input[type=text], body.buddypress #yz-groups-list .item .item-meta span, body.buddypress #yz-members-list .yz-name, body.buddypress .yz-group-settings-tab textarea, body.buddypress .yz-group-settings-tab .yz-group-field-item input[type=text], body.buddypress .yz-group-manage-members-search #search-members-form #members_search, body.buddypress .yz-tab-comment .yz-comment-excerpt p, body.buddypress .yz-post-plus4imgs .yz-post-imgs-nbr, body.buddypress .yz-tab-comment .yz-comment-title, body.buddypress .yz-form .youzer-form-message p, body.buddypress .yz-infos-content ul li strong, body.buddypress .yz-video-head .yz-video-desc, body.buddypress .yz-quote-content blockquote, body.buddypress .yz-tab-post .yz-post-text p, body.buddypress .yz-link-content p, body.buddypress .yz-infos-content ul li p, body.buddypress .yz-info-msg p strong, body.buddypress .lb-data .lb-caption, body.buddypress .lb-data .lb-number, body.buddypress .yz-profile-login, body.buddypress .youzer_msg span, body.buddypress .yz-info-msg p, body.buddypress .yz-box-404 p, body.buddypress .yz-aboutme-bio, body.buddypress .nice-select, body.buddypress div.item-list-tabs .yz-bar-select, body.buddypress .yz-name .yz-user-status, body.buddypress .yz-user-ratings-details .yz-user-ratings-rate, body.buddypress .yz-user-ratings-details .yz-user-ratings-total, body.buddypress .yz-infos-content .yz-info-data, body.buddypress .yz-infos-content .yz-info-data a, body.buddypress .members.friends #yz-members-list .item .item-meta span, body.buddypress .nice-select .option, body.buddypress .nice-select .current, body.buddypress #whats-new-post-in-box .nice-select .current, body.buddypress .activity-header p, body.buddypress .activity-header .activity-head p a, body.buddypress .activity-header .time-since, body.buddypress .activity-header a.activity-time-since span, body.buddypress .yz-wall-embed .yz-embed-meta, body.buddypress #message p, body.buddypress .yz-wall-options .yz-wall-opts-item label, body.buddypress .yz-wall-custom-form .yz-wall-cf-item input, body.buddypress .yz-wall-custom-form .yz-wall-cf-item textarea, body.buddypress .yz-pinned-post-tag, body.buddypress .widget_bp_core_members_widget #members-list .vcard .item-meta .activity, body.buddypress .widget_bp_groups_widget #groups-list li .item-meta .activity, body.buddypress .myCRED-leaderboard .yz-leaderboard-points, body.buddypress .myCRED-leaderboard .yz-leaderboard-position, body.buddypress #friend-list.item-list .item .item-meta span, body.buddypress .yz-item-content p, body.buddypress .yz-uploader-change-item p, body.buddypress .bp-avatar p, body.buddypress div.bp-avatar-status p.warning, body.buddypress div.bp-cover-image-status p.warning, body.buddypress div.bp-cover-image-status p.warning, body.buddypress div.bp-avatar-status p.warning, body.buddypress .editfield label .bp-required-field-label, body.buddypress .editfield legend .bp-required-field-label, body.buddypress .editfield .field-visibility-settings-notoggle, body.buddypress .editfield .field-visibility-settings-toggle, body.buddypress .editfield input:not([type=radio]):not([type=checkbox]), body.buddypress .yz-items-list-widget .yz-list-item .yz-item-meta .yz-meta-item, body.buddypress .yz-review-item .yz-head-meta .yz-item-date, body.buddypress .yz-review-item .yz-item-content .yz-item-desc, body.buddypress .yz-link-url, body.buddypress .groups.mygroups #yz-groups-list .item .item-meta span, body.buddypress .yz-tab-title-box .yz-tab-title-content span, body.buddypress.mycred-history #buddypress.youzer .mycred-table tbody td, body.buddypress.follows .youzer #yz-members-list .item .item-meta span, body.buddypress.my-friends .youzer #yz-members-list .item .item-meta span, body.buddypress .yz-box-content p, body.buddypress .youzer a, body.buddypress .youzer, .youzer, body.buddypress .youzer p, body.buddypress .yz-project-content .yz-project-text p, body.buddypress .yz-skill-bar-percent, body.buddypress .yz-skillbar-title,
				body.buddypress #group-settings-form .yz-group-field-item input[type=text], 
				body.buddypress #group-settings-form textarea,
				body.buddypress .youzer .group-members-list .item .item-meta,
				body.buddypress.my-groups .youzer #yz-groups-list .item .item-meta span,
				body.buddypress .yz-recent-posts .yz-post-meta ul li,
				.widget-mycred-list .myCRED-leaderboard .yz-leaderboard-position
				{'.$main_font_css.'}';	
				
				$css_snippet.='body.bp-legacy .logy-forgot-password, body.bp-legacy .logy-form .form-title h2, body.bp-legacy .logy-form .logy-form-desc, body.bp-legacy .logy-form .logy-form-message p, body.bp-legacy .logy-form-item .logy-item-content input, body.bp-legacy .logy-form-note, body.bp-legacy .logy-link-button, body.bp-legacy .logy-social-buttons .logy-social-title, body.bp-legacy .logy-social-buttons li a, body.bp-legacy #logy_signup_form label .bp-required-field-label, body.bp-legacy #logy_signup_form legend .bp-required-field-label, body.bp-legacy .logy-form-note.logy-terms-note a, body.buddypress .youzer input[type="text"], body.buddypress #youzer input[type="text"]
				{'.$main_font_css.'}';
				/*youzer*/			
			}
			
			$main_font_scale = vidorev_get_redux_option('main_font_scale', 1);
			if($main_font_scale!=1){
				$font__main_size = round(14 * $main_font_scale);
				$font_size_10 = round($font__main_size * 0.7);
				$font_size_12 = round($font__main_size * 0.86);
				$font_size_18 = round($font__main_size * 1.286);
				$font_size_24 = round($font__main_size * 1.74);
				
				$main_font_size_css.='
				body,.body-typography,
				input:not([type]),input[type="text"],input[type="email"],input[type="url"],input[type="password"],input[type="search"],input[type="number"],input[type="tel"],input[type="range"],
				input[type="date"],input[type="month"],input[type="week"],input[type="time"],input[type="datetime"],input[type="datetime-local"],input[type="color"],textarea,select,
				.cleanlogin-container .cleanlogin-form .cleanlogin-form label,
				.widget.widget_wysija .widget_wysija_cont .error,.widget.widget_wysija .widget_wysija_cont .xdetailed-errors,
				.widget.widget_wysija .widget_wysija_cont .updated,.widget.widget_wysija .widget_wysija_cont .login .message,
				#bbpress-forums .bbp-forum-info .bbp-forum-content,
				#bbpress-forums div.bbp-forum-content, #bbpress-forums div.bbp-topic-content, #bbpress-forums div.bbp-reply-content,
				.woocommerce ul.products li.product .price,
				.pswp__caption__center,
				.woocommerce ul.products li.product .star-rating,
				.woocommerce table.my_account_orders,
				.video-player-wrap .fluid_video_wrapper,
				body.header-vid-side div.asl_r .results .item .asl_desc
				{font-size:'.esc_attr($font__main_size).'px;}
				.widget_tag_cloud .tagcloud{font-size:'.esc_attr($font__main_size).'px !important;}
				
				.font-size-10{
					font-size:'.esc_attr($font_size_10).'px;
				}
				
				.font-size-12,
				#bbpress-forums,
				div.bbp-template-notice p,
				div.bbp-topic-tags,
				.bbp_widget_login .bbp-logged-in .logout-link,
				#pmpro_form .pmpro_checkout h3 span.pmpro_checkout-h3-msg,
				.woocommerce span.onsale,
				body.header-vid-side div.asl_s.searchsettings .asl_option_label,
				.widget.widget_mailpoet_form[id*="mailpoet_form-"] .parsley-errors-list{
					font-size:'.esc_attr($font_size_12).'px;
				}
				
				.font-size-18{
					font-size:'.esc_attr($font_size_18).'px;	
				}
				
				.wp-block-quote.is-large p, .wp-block-quote.is-style-large p{
					font-size:'.esc_attr($font_size_24).'px;
				}
				
				@media(min-width:767px){
					blockquote{
						font-size:'.esc_attr($font_size_18).'px;	
					}
					blockquote cite {
						font-size:'.esc_attr($font__main_size).'px;
					}
					blockquote:before{
						left:'.esc_attr($font__main_size).'px;
					}
				}
				
				@media(max-width:767px){
					.global-single-content .wp-block-quote.is-large p, .global-single-content .wp-block-quote.is-style-large p{font-size:'.esc_attr($font_size_18).'px;	}
				}'
				;
				
				/*youzer*/
				$main_font_size_css.='body.buddypress .logy-form-item .logy-item-content input, body.buddypress .yzb-head-content .yzb-head-meta, body.buddypress .logy-form .logy-form-message p, body.buddypress .uk-panel-msg .uk-msg-content p, body.buddypress .logy-form .logy-form-desc, body.buddypress [data-yztooltip]:after, body.buddypress .yz-items-list-widget, body.buddypress .yz-my-account-widget, body.buddypress .yz-usermeta li span, body.buddypress .yzb-account-menu a, body.buddypress .yzb-author-infos p, body.buddypress .youzer-dialog-desc, body.buddypress .widget.buddypress, body.buddypress .yz-tooltip:after, body.buddypress #sitewide-notice #message, body.buddypress #sitewide-notice strong, body.buddypress .youzer_msg span, body.buddypress textarea, body.buddypress .logy-form-note, body.buddypress select, body.buddypress .youzer-dialog, body.buddypress input, body.buddypress .uk-popup, body.buddypress .logy, body.buddypress .option-content input:not([type=radio]), body.buddypress .option-content input:not([type=radio]):not(.uk-upload-button):not(.wp-color-picker):not(.wp-picker-clear), body.buddypress .option-content textarea, body.buddypress .option-content select, body.buddypress .uk-option-item .option-desc, body.buddypress .yz-account-head span, body.buddypress #yz-directory-search-box form input[type=text], body.buddypress #yz-groups-list .item .item-meta span, body.buddypress #yz-members-list .yz-name, body.buddypress .yz-group-settings-tab textarea, body.buddypress .yz-group-settings-tab .yz-group-field-item input[type=text], body.buddypress .yz-group-manage-members-search #search-members-form #members_search, body.buddypress .yz-tab-comment .yz-comment-excerpt p, body.buddypress .yz-post-plus4imgs .yz-post-imgs-nbr, body.buddypress .yz-tab-comment .yz-comment-title, body.buddypress .yz-form .youzer-form-message p, body.buddypress .yz-infos-content ul li strong, body.buddypress .yz-video-head .yz-video-desc, body.buddypress .yz-quote-content blockquote, body.buddypress .yz-tab-post .yz-post-text p, body.buddypress .yz-link-content p, body.buddypress .yz-infos-content ul li p, body.buddypress .yz-info-msg p strong, body.buddypress .lb-data .lb-caption, body.buddypress .lb-data .lb-number, body.buddypress .yz-profile-login, body.buddypress .youzer_msg span, body.buddypress .yz-info-msg p, body.buddypress .yz-box-404 p, body.buddypress .yz-aboutme-bio, body.buddypress .nice-select, body.buddypress div.item-list-tabs .yz-bar-select, body.buddypress .yz-name .yz-user-status, body.buddypress .yz-user-ratings-details .yz-user-ratings-rate, body.buddypress .yz-user-ratings-details .yz-user-ratings-total, body.buddypress .yz-infos-content .yz-info-data, body.buddypress .yz-infos-content .yz-info-data a, body.buddypress .members.friends #yz-members-list .item .item-meta span, body.buddypress .nice-select .option, body.buddypress .nice-select .current, body.buddypress #whats-new-post-in-box .nice-select .current, body.buddypress .activity-header p, body.buddypress .activity-header .activity-head p a, body.buddypress .activity-header .time-since, body.buddypress .activity-header a.activity-time-since span, body.buddypress .yz-wall-embed .yz-embed-meta, body.buddypress #message p, body.buddypress .yz-wall-options .yz-wall-opts-item label, body.buddypress .yz-wall-custom-form .yz-wall-cf-item input, body.buddypress .yz-wall-custom-form .yz-wall-cf-item textarea, body.buddypress .yz-pinned-post-tag, body.buddypress .widget_bp_core_members_widget #members-list .vcard .item-meta .activity, body.buddypress .widget_bp_groups_widget #groups-list li .item-meta .activity, body.buddypress .myCRED-leaderboard .yz-leaderboard-points, body.buddypress .myCRED-leaderboard .yz-leaderboard-position, body.buddypress #friend-list.item-list .item .item-meta span, body.buddypress .yz-item-content p, body.buddypress .yz-uploader-change-item p, body.buddypress .bp-avatar p, body.buddypress div.bp-avatar-status p.warning, body.buddypress div.bp-cover-image-status p.warning, body.buddypress div.bp-cover-image-status p.warning, body.buddypress div.bp-avatar-status p.warning, body.buddypress .editfield label .bp-required-field-label, body.buddypress .editfield legend .bp-required-field-label, body.buddypress .editfield .field-visibility-settings-notoggle, body.buddypress .editfield .field-visibility-settings-toggle, body.buddypress .editfield input:not([type=radio]):not([type=checkbox]), body.buddypress .yz-items-list-widget .yz-list-item .yz-item-meta .yz-meta-item, body.buddypress .yz-review-item .yz-head-meta .yz-item-date, body.buddypress .yz-review-item .yz-item-content .yz-item-desc, body.buddypress .yz-link-url, body.buddypress .groups.mygroups #yz-groups-list .item .item-meta span, body.buddypress .yz-tab-title-box .yz-tab-title-content span, body.buddypress.mycred-history #buddypress.youzer .mycred-table tbody td, body.buddypress.follows .youzer #yz-members-list .item .item-meta span, body.buddypress.my-friends .youzer #yz-members-list .item .item-meta span, body.buddypress .yz-box-content p, body.buddypress .yz-project-content .yz-project-text p, body.buddypress .yz-skill-bar-percent, body.buddypress .yz-skillbar-title,
				body.buddypress #group-settings-form .yz-group-field-item input[type=text], 
				body.buddypress #group-settings-form textarea,
				body.buddypress .youzer .group-members-list .item .item-meta,
				body.buddypress.my-groups .youzer #yz-groups-list .item .item-meta span,
				.widget-mycred-list .myCRED-leaderboard .yz-leaderboard-position,
				body.buddypress .yz-widget .yz-widget-content p
				{font-size:'.esc_attr($font__main_size).'px;}';
				
				$main_font_size_css.='body.bp-legacy .logy-forgot-password, body.bp-legacy .logy-form .form-title h2, body.bp-legacy .logy-form .logy-form-desc, body.bp-legacy .logy-form .logy-form-message p, body.bp-legacy .logy-form-item .logy-item-content input, body.bp-legacy .logy-form-note, body.bp-legacy .logy-link-button, body.bp-legacy .logy-social-buttons .logy-social-title, body.bp-legacy .logy-social-buttons li a, body.bp-legacy #logy_signup_form label .bp-required-field-label, body.bp-legacy #logy_signup_form legend .bp-required-field-label, body.bp-legacy .logy-form-note.logy-terms-note a, body.bp-legacy #logy_signup_form .field-visibility-settings-notoggle, body.bp-legacy #logy_signup_form .field-visibility-settings-toggle
				{font-size:'.esc_attr($font__main_size).'px;}';
				
				$main_font_size_css.='body.bp-legacy #logy_signup_form label .bp-required-field-label, body.bp-legacy #logy_signup_form legend .bp-required-field-label
				{font-size:'.esc_attr($font_size_10).'px;}';
				
				$main_font_size_css.='body.buddypress [data-yztooltip]:after, body.buddypress .yz-usermeta li span, body.buddypress .yz-tab-post .yz-post-meta ul li, body.buddypress .lb-data .lb-number, body.buddypress .yz-recent-posts .yz-post-meta ul li, body.buddypress .yz-tab-post .yz-post-meta ul li, body.buddypress .yz-name .yz-user-status, body.buddypress .yz-user-ratings-details .yz-user-ratings-rate, body.buddypress .yz-user-ratings-details .yz-user-ratings-total, body.buddypress .members.friends #yz-members-list .item .item-meta span, body.buddypress .activity-header .time-since, body.buddypress .activity-header a.activity-time-since span, body.buddypress .yz-wall-embed .yz-embed-meta, body.buddypress .yz-wall-options .yz-wall-opts-item label, body.buddypress .yz-pinned-post-tag, body.buddypress .widget_bp_core_members_widget #members-list .vcard .item-meta .activity, body.buddypress .widget_bp_groups_widget #groups-list li .item-meta .activity, body.buddypress .myCRED-leaderboard .yz-leaderboard-points, body.buddypress .myCRED-leaderboard .yz-leaderboard-position, body.buddypress #friend-list.item-list .item .item-meta span, body.buddypress .editfield label .bp-required-field-label, body.buddypress .editfield legend .bp-required-field-label, body.buddypress .yz-items-list-widget .yz-list-item .yz-item-meta .yz-meta-item, body.buddypress .yz-review-item .yz-head-meta .yz-item-date, body.buddypress .groups.mygroups #yz-groups-list .item .item-meta span, body.buddypress.follows .youzer #yz-members-list .item .item-meta span, body.buddypress.my-friends .youzer #yz-members-list .item .item-meta span, body.buddypress .yz-box-content p, body.buddypress .yz-project-meta ul li,
				body.buddypress .youzer .group-members-list .item .item-meta,
				body.buddypress.my-groups .youzer #yz-groups-list .item .item-meta span
				{font-size:'.esc_attr($font_size_12).'px;}';
				
				$main_font_size_css.='body.buddypress .yz-quote-content blockquote
				{font-size:'.esc_attr($font_size_18).'px;}';
				/*youzer*/
				
				
			}
			
			if($main_font_size_css!=''){
				$css_snippet.=$main_font_size_css;
			}/*main*/	
			
			/*heading*/
			$hea_font_css = '';
			$hea_font_size_css = '';
			if(isset($hea_font['font-family']) && $hea_font['font-family']!=''){
				$hea_font_css.='font-family:'.esc_attr($hea_font['font-family']).';';
			}
			if(isset($hea_font['line-height']) && $hea_font['line-height']!=''){
				$hea_font_css.='line-height:'.esc_attr($hea_font['line-height']).';';
			}
			if(isset($hea_font['font-weight']) && $hea_font['font-weight']!=''){
				$hea_font_css.='font-weight:'.esc_attr($hea_font['font-weight']).';';
			}
			if(isset($hea_font['font-style']) && $hea_font['font-style']!=''){
				$hea_font_css.='font-style:'.esc_attr($hea_font['font-style']).';';
			}
			if(isset($hea_font['text-transform']) && $hea_font['text-transform']!=''){
				$hea_font_css.='text-transform:'.esc_attr($hea_font['text-transform']).';';
			}
			if(isset($hea_font['letter-spacing']) && $hea_font['letter-spacing']!=''){
				$hea_font_css.='letter-spacing:'.esc_attr($hea_font['letter-spacing']).';';
			}
			
			if($hea_font_css!=''){
				$css_snippet.='	h1,h2,h3,h4,h5,h6,
								.h1,.h2,.h3,.h4,.h5,.h6,.h7,
								button,input[type=button],input[type=submit],input[type="reset"],.basic-button,.next-content a,.prev-content a,
								#bbpress-forums li.bbp-header,
								#bbpress-forums li.bbp-body ul.forum a.bbp-forum-title, #bbpress-forums li.bbp-body ul.topic a.bbp-forum-title,
								#bbpress-forums ul.bbp-topics li.bbp-body li.bbp-topic-title a.bbp-topic-permalink,
								#bbpress-forums fieldset.bbp-form legend,
								#bbpress-forums fieldset.bbp-form label,
								#amazon-native-ad.amazon-native-ad .amzn-native-header .amzn-native-header-text,
								.pmpro_btn, 
								.pmpro_btn:link, 
								.pmpro_content_message a, 
								.pmpro_content_message a:link,
								.pmpro_checkout .pmpro_btn,
								#nav-below.navigation a,
								.woocommerce #respond input#submit, 
								.woocommerce a.button, 
								.woocommerce button.button, 
								.woocommerce input.button,
								.woocommerce ul.cart_list li a, 
								.woocommerce ul.product_list_widget li a,
								.woocommerce #review_form #respond p label,
								.woocommerce div.product .woocommerce-tabs ul.tabs li,
								.woocommerce form .form-row label,
								.woocommerce nav.woocommerce-pagination .page-numbers li > *,
								.global-single-wrapper .yasr_table_multi_set_shortcode tbody tr > td .yasr-multi-set-name-field,
								body.header-vid-side div.asl_r .results .item .asl_content h3, body.header-vid-side div.asl_r .results .item .asl_content h3 a,
								body.header-vid-side div.asl_r p.showmore a
								{'.$hea_font_css.'}';
				/*youzer*/	
				$css_snippet.='	body.buddypress .widget_bp_core_sitewide_messages .bp-site-wide-message button, body.buddypress .youzer-main-content .wp-picker-container .wp-picker-clear, body.buddypress .youzer-main-content .wp-picker-container .wp-color-picker, body.buddypress .widget_bp_core_members_widget .item-options a, body.buddypress .logy-form .logy-form-cover .form-cover-title, body.buddypress .uk-upload-photo .uk-upload-button, body.buddypress .logy-form-item .logy-item-content label, body.buddypress .logy-social-buttons .logy-social-title, body.buddypress .yz-tool-btn .yz-tool-name, body.buddypress .logy-social-buttons li a, body.buddypress .logy-form-actions button, body.buddypress .logy-form .form-title h2, body.buddypress .yz-user-statistics li h3, body.buddypress .logy-forgot-password, body.buddypress .yzb-head-content h2, body.buddypress .yzb-head-content h3, body.buddypress .logy-link-button, body.buddypress #sitewide-notice #message button, body.buddypress .yz-reset-options, body.buddypress .yz-save-options, body.buddypress .uk-msg-head h3, body.buddypress .yz-hdr-v1 .yz-name h2, body.buddypress .yz-hdr-v2 .yz-name h2, body.buddypress .yz-hdr-v3 .yz-name h2, body.buddypress .yz-hdr-v6 .yz-name h2, body.buddypress .yz-hdr-v7 .yz-name h2, body.buddypress .settings-inner-content .options-section-title h2, body.buddypress .settings-sidebar .account-menus ul li a, body.buddypress .yz-cphoto-options .yz-upload-photo, body.buddypress .settings-sidebar .account-menus h2, body.buddypress .yz-account-header ul li a, body.buddypress .action-button, body.buddypress .yz-account-head h2, body.buddypress .yza-item-button, body.buddypress .yz-no-content, body.buddypress #yz-directory-search-box form input[type=submit], body.buddypress #yz-members-list .yzm-user-actions a, body.buddypress #yz-groups-list .item .item-title a, body.buddypress #yz-members-list .yz-fullname, body.buddypress #yz-groups-list .action a, body.buddypress #send-invite-form .submit input, body.buddypress .group-members #search-members-form label input, body.buddypress .group-members #search-members-form #members_search_submit, body.buddypress .yz-recent-posts .yz-post-head .yz-post-title a, body.buddypress .yz-wg-networks.yz-icons-full-width li a, body.buddypress .yz-profile-navmenu .yz-navbar-item a, body.buddypress .yz-project-content .yz-project-title, body.buddypress .yz-tab-comment .yz-comment-fullname, body.buddypress .yz-post-content .yz-post-title a, body.buddypress .yz-video-head .yz-video-title, body.buddypress .yz-tab-post .yz-post-title a, body.buddypress .yz-widget .yz-widget-title, body.buddypress .yz-box-head .yz-box-title, body.buddypress .pagination .page-numbers, body.buddypress .yz-project-type, body.buddypress .yz-quote-owner, body.buddypress .yz-box-404 h2, body.buddypress .yz-post-type, body.buddypress .yz-item-title, body.buddypress .uk-option-item label, body.buddypress .yz-items-list-widget .yz-list-item a.yz-item-name, body.buddypress div.item-list-tabs li a, body.buddypress .yz-pagination .yz-nav-links .page-numbers, body.buddypress .yz-pagination .yz-pagination-pages, body.buddypress .yz-modal .uk-option-item .option-title, body.buddypress .yz-infos-content .yz-info-label, body.buddypress .yzmsg-form-item label, body.buddypress .members.friends #yz-members-list .item .item-title a, body.buddypress #yz-group-buttons .group-button a, body.buddypress .yz-wall-embed .yz-embed-name, body.buddypress .yz-item-tool .yz-tool-name, body.buddypress .activity-meta a, body.buddypress #whats-new-post-in-box label, body.buddypress .youzer-sidebar .widget-content .widget-title, body.buddypress .widget_bp_core_members_widget #members-list .vcard .item-title a, body.buddypress .widget_bp_groups_widget #groups-list li .item-title a, body.buddypress .myCRED-leaderboard .yz-leaderboard-username, body.buddypress .widget_bp_core_members_widget .item-options a, body.buddypress .widget_bp_groups_widget .item-options a, body.buddypress #friend-list.item-list .item .item-title a, body.buddypress #friend-list.item-list .action a, body.buddypress #yz-members-list .yzm-user-actions a, body.buddypress #yz-wall-nav li a, body.buddypress .yz-uploader-change-item h2, body.buddypress .avatar-nav-items li a, body.buddypress #bp-delete-avatar, body.buddypress #bp-delete-cover-image, body.buddypress .editfield fieldset legend, body.buddypress .editfield .field-visibility-settings-notoggle .current-visibility-level, body.buddypress .editfield .field-visibility-settings-toggle .current-visibility-level, body.buddypress .editfield .field-visibility-settings-toggle .visibility-toggle-link, body.buddypress .option-content .yz-upload-photo, body.buddypress .yz-directory-filter .item-list-tabs li label, body.buddypress .yz-directory-filter .item-list-tabs li#members-order-select label, body.buddypress .yz-review-item .yz-head-meta .yz-item-name a, body.buddypress .yz-user-balance-box .yz-box-head, body.buddypress .yz-profile-sidebar .yz-aboutme-description, body.buddypress .yz-aboutme-name, body.buddypress .yz-tab-post .yz-read-more, body.buddypress .yz-wall-embed .yz-embed-action .friendship-button a, body.buddypress .yz-wall-embed .yz-embed-action .group-button a, body.buddypress .yz-wall-embed .yz-embed-action .message-button .yz-send-message, body.buddypress .groups.mygroups #yz-groups-list .item .item-title a, body.buddypress .yz-tab-title-box .yz-tab-title-content h2, body.buddypress.mycred-history #buddypress.youzer .mycred-table tfoot th, body.buddypress.mycred-history #buddypress.youzer .mycred-table thead th, body.buddypress.follows .youzer #yz-members-list .item .item-title a, body.buddypress.my-friends .youzer #yz-members-list .item .item-title a, body.buddypress .yz-user-badges-tab .yz-user-badge-item .yz-user-badge-title, body.buddypress #yz-profile-navmenu .yz-settings-menu a span, body.buddypress .yz-group-navmenu li a, body.buddypress .yz-rating-show-more, body.buddypress .yz-profile-list-widget .yz-more-items a,
				body.buddypress #group-settings-form .radio label, 
				body.buddypress #group-settings-form label, 
				body.buddypress .yz-group-settings-tab .radio label, 
				body.buddypress .yz-group-settings-tab label,
				body.buddypress .youzer .group-members-list .item .item-title a,
				body.buddypress.my-groups .youzer #yz-groups-list .action a,
				body.buddypress.my-groups .youzer #yz-groups-list .item .item-title a,
				body.buddypress .yz-directory-filter #directory-show-search a, 
				body.buddypress .yz-directory-filter .item-list-tabs li a,
				body.buddypress .yz-social-buttons .follow-button a, 
				body.buddypress .yz-social-buttons .friendship-button a, 
				body.buddypress .yz-social-buttons .message-button a,
				body.buddypress .youzer .activity-list li.load-more a, 
				body.buddypress .youzer .activity-list li.load-newest a,
				body.buddypress #group-settings-form .yz-group-submit-form #group-creation-previous, 
				body.buddypress #group-settings-form input[type=submit], 
				body.buddypress #send-invite-form .submit input, 
				body.buddypress .yz-group-settings-tab .yz-group-submit-form #group-creation-previous, 
				body.buddypress .yz-group-settings-tab input[type=submit],
				body.buddypress .yz-group-manage-members-search #members_search_submit,
				body.buddypress .yz-group-settings-tab .yz-group-submit-form input,
				.widget-mycred-list .myCRED-leaderboard .yz-leaderboard-username,
				.elementor-widget-container .myCRED-leaderboard .yz-leaderboard-username,
				body.buddypress .youzer input[type="submit"], 
				body.buddypress #youzer input[type="submit"],
				.yz-media-filter .yz-filter-item .yz-filter-content span
								{'.$hea_font_css.'}';
								
				$css_snippet.='body.bp-legacy .logy-form .form-title h2, body.bp-legacy .logy-form .logy-form-cover .form-cover-title, body.bp-legacy .logy-form-item .logy-item-content label, body.bp-legacy .logy-form-actions button, body.bp-legacy #logy_signup_form fieldset legend, body.bp-legacy #logy_signup_form label, body.bp-legacy #logy_signup_form .logy-section-title span, body.bp-legacy #logy_signup_form .field-visibility-settings-notoggle .current-visibility-level, body.bp-legacy #logy_signup_form .field-visibility-settings-toggle .current-visibility-level, body.bp-legacy #logy_signup_form label .field-visibility-text, body.bp-legacy #logy_signup_form .field-visibility-settings .field-visibility-settings-close, body.bp-legacy #logy_signup_form .field-visibility-settings-notoggle .visibility-toggle-link, body.bp-legacy #logy_signup_form .field-visibility-settings-toggle .visibility-toggle-link
				{'.$hea_font_css.'}';				
				/*youzer*/				
			}
			
			$hea_font_scale = vidorev_get_redux_option('hea_font_scale', 1);	
			
			if($hea_font_scale!=1){
				$font__heading_size = 16 * $hea_font_scale;
				
				$h1_font_size = 	round($font__heading_size * 1.602);
				$h2_font_size = 	round($font__heading_size * 1.424);
				$h3_font_size = 	round($font__heading_size * 1.266);
				$h4_font_size = 	round($font__heading_size * 1.125);
				$h5_font_size = 	round($font__heading_size * 1);
				$h6_font_size = 	round($font__heading_size * 0.889);
				$h7_font_size = 	round($font__heading_size * 0.75);
				$h_font_size_30 = 	round($font__heading_size * 1.9);				
				$h_font_size_36 = 	round($font__heading_size * 2.25);
				$h_font_size_40 = 	round($font__heading_size * 2.5);
				$h_font_size_48 = 	round($font__heading_size * 3);
				
				$hea_font_size_css.='h1,.h1{font-size:'.esc_attr($h1_font_size).'px;}';
				/*youzer*/
				$hea_font_size_css.='body.buddypress .yz-video-head .yz-video-title{font-size:'.esc_attr($h1_font_size).'px;}';
				/*youzer*/
				
				$hea_font_size_css.='h2,.h2{font-size:'.esc_attr($h2_font_size).'px;}';
				/*youzer*/
				$hea_font_size_css.='body.buddypress .yz-hdr-v1 .yz-name h2, body.buddypress .yz-hdr-v2 .yz-name h2, body.buddypress .yz-hdr-v6 .yz-name h2{font-size:'.esc_attr($h2_font_size).'px;}';
				/*youzer*/
				
				$hea_font_size_css.='h3,.h3{font-size:'.esc_attr($h3_font_size).'px;}';				
				/*youzer*/
				$hea_font_size_css.='body.buddypress .yz-hdr-v3 .yz-name h2, body.buddypress .yz-hdr-v7 .yz-name h2, body.buddypress .yz-tab-title-box .yz-tab-title-content h2{font-size:'.esc_attr($h3_font_size).'px;}';
				/*youzer*/
				
				$hea_font_size_css.='h4,.h4,#bbpress-forums li.bbp-body ul.forum a.bbp-forum-title, #bbpress-forums li.bbp-body ul.topic a.bbp-forum-title,#amazon-native-ad.amazon-native-ad .amzn-native-header:before, #amazon-native-ad.amazon-native-ad .amzn-native-header:after,#amazon-native-ad.amazon-native-ad .amzn-native-header .amzn-native-header-text,.woocommerce h2[class$="__title"]:not(.woocommerce-loop-product__title), .woocommerce .woocommerce-MyAccount-content h3{font-size:'.esc_attr($h4_font_size).'px;}';
				/*youzer*/
				$hea_font_size_css.='body.buddypress .yzb-head-content h2, body.buddypress .settings-inner-content .options-section-title h2{font-size:'.esc_attr($h4_font_size).'px;}';
				/*youzer*/
				
				$hea_font_size_css.='h5,.h5,.cleanlogin-container .cleanlogin-form h4,#bbpress-forums ul.bbp-topics li.bbp-body li.bbp-topic-title a.bbp-topic-permalink,#bbpress-forums fieldset.bbp-form legend,.bbp_widget_login .bbp-logged-in h4,.widget_display_topics .widget-item-wrap > ul > li a.bbp-forum-title,.woocommerce div.product .woocommerce-tabs .panel h2,.woocommerce .related.products > h2,.woocommerce ul.products li.product .woocommerce-loop-category__title, .woocommerce ul.products li.product .woocommerce-loop-product__title, .woocommerce ul.products li.product h3,.global-single-content .wp-block-latest-posts a{font-size:'.esc_attr($h5_font_size).'px;}';				
				/*youzer*/
				$hea_font_size_css.='body.buddypress .logy-form .logy-form-cover .form-cover-title,	body.buddypress .logy-form .form-title h2, body.buddypress .yz-widget .yz-widget-title,	body.buddypress .youzer-sidebar .widget-content .widget-title, body.bp-legacy .logy-form .form-cover-title, body.buddypress .yz-project-content .yz-project-title,.widget-mycred-list .myCRED-leaderboard .yz-leaderboard-username,.elementor-widget-container .myCRED-leaderboard .yz-leaderboard-username{font-size:'.esc_attr($h5_font_size).'px;}';
				/*youzer*/
				
				$hea_font_size_css.='h6,.h6,#bbpress-forums li.bbp-header,#bbpress-forums fieldset.bbp-form label,.global-single-wrapper .yasr_table_multi_set_shortcode tbody tr > td .yasr-multi-set-name-field{font-size:'.esc_attr($h6_font_size).'px;}@media(min-width: 768px){body.floating-video:not(.light-off-enabled):not(.disable-floating-video) #site-wrap-parent .video-player-content .auto-next-content .video-next-title,.woocommerce ul.cart_list li a, .woocommerce ul.product_list_widget li a,.woocommerce #review_form #respond p label,.woocommerce div.product .woocommerce-tabs ul.tabs li,.woocommerce form .form-row label,body.header-vid-side div.asl_r .results .item .asl_content h3, body.header-vid-side div.asl_r .results .item .asl_content h3 a, body.header-vid-side div.asl_r p.showmore a{font-size:'.esc_attr($h6_font_size).'px;}}';				
				/*youzer*/
				$hea_font_size_css.='body.buddypress .logy-form-item .logy-item-content label, body.buddypress .logy-social-buttons .logy-social-title, body.buddypress .yz-tool-btn .yz-tool-name, body.buddypress .logy-social-buttons li a, body.buddypress .logy-forgot-password, body.buddypress .yzb-head-content h3, body.buddypress .logy-link-button, body.buddypress .uk-msg-head h3, body.buddypress .settings-sidebar .account-menus ul li a, body.buddypress .settings-sidebar .account-menus h2, body.buddypress .yz-account-header ul li a, body.buddypress .yz-account-head h2, body.buddypress .yz-no-content, body.buddypress #yz-members-list .yzm-user-actions a, body.buddypress #yz-groups-list .item .item-title a, body.buddypress #yz-members-list .yz-fullname, body.buddypress #yz-groups-list .action a, body.buddypress #send-invite-form .submit input, body.buddypress .group-members #search-members-form label input, body.buddypress .yz-recent-posts .yz-post-head .yz-post-title a, body.buddypress .yz-wg-networks.yz-icons-full-width li a, body.buddypress .yz-profile-navmenu .yz-navbar-item a, body.buddypress .yz-tab-comment .yz-comment-fullname, body.buddypress .yz-post-content .yz-post-title a, body.buddypress .yz-tab-post .yz-post-title a, body.buddypress .yz-widget .yz-widget-title, body.buddypress .yz-box-head .yz-box-title, body.buddypress .yz-quote-owner, body.buddypress .yz-item-title, body.buddypress .uk-option-item label, body.buddypress .yz-items-list-widget .yz-list-item a.yz-item-name, body.buddypress .yz-modal .uk-option-item .option-title, body.buddypress .yz-infos-content .yz-info-label, body.buddypress .yzmsg-form-item label, body.buddypress .members.friends #yz-members-list .item .item-title a, body.buddypress #yz-group-buttons .group-button a, body.buddypress .yz-wall-embed .yz-embed-name, body.buddypress .yz-item-tool .yz-tool-name, body.buddypress .activity-meta a, body.buddypress .widget_bp_core_members_widget #members-list .vcard .item-title a, body.buddypress .widget_bp_groups_widget #groups-list li .item-title a, body.buddypress .myCRED-leaderboard .yz-leaderboard-username, body.buddypress #friend-list.item-list .item .item-title a, body.buddypress #friend-list.item-list .action a, body.buddypress #yz-members-list .yzm-user-actions a, body.buddypress .yz-uploader-change-item h2, body.buddypress .avatar-nav-items li a, body.buddypress #bp-delete-avatar, body.buddypress #bp-delete-cover-image, body.buddypress .editfield fieldset legend, body.buddypress .editfield .field-visibility-settings-notoggle .current-visibility-level, body.buddypress .editfield .field-visibility-settings-toggle .current-visibility-level, body.buddypress .option-content .yz-upload-photo, body.buddypress .yz-review-item .yz-head-meta .yz-item-name a, body.buddypress .yz-aboutme-name, body.buddypress .yz-wall-embed .yz-embed-action .friendship-button a, body.buddypress .yz-wall-embed .yz-embed-action .group-button a, body.buddypress .yz-wall-embed .yz-embed-action .message-button .yz-send-message, body.buddypress .groups.mygroups #yz-groups-list .item .item-title a, body.buddypress.mycred-history #buddypress.youzer .mycred-table tfoot th, body.buddypress.mycred-history #buddypress.youzer .mycred-table thead th, body.buddypress.follows .youzer #yz-members-list .item .item-title a, body.buddypress.my-friends .youzer #yz-members-list .item .item-title a, body.buddypress .yz-user-badges-tab .yz-user-badge-item .yz-user-badge-title, body.buddypress .yz-group-navmenu li a, body.buddypress .yz-rating-show-more, body.buddypress .yz-profile-list-widget .yz-more-items a,
				body.buddypress #group-settings-form .radio label, 
				body.buddypress #group-settings-form label, 
				body.buddypress .yz-group-settings-tab .radio label, 
				body.buddypress .yz-group-settings-tab label,
				body.buddypress .youzer .group-members-list .item .item-title a,
				body.buddypress.my-groups .youzer #yz-groups-list .action a,
				body.buddypress.my-groups .youzer #yz-groups-list .item .item-title a,
				body.buddypress .yz-directory-filter #directory-show-search a, 
				.yz-directory-filter .item-list-tabs li a,
				body.buddypress .yz-social-buttons .follow-button a, 
				body.buddypress .yz-social-buttons .friendship-button a, 
				body.buddypress .yz-social-buttons .message-button a,
				body.buddypress .youzer .activity-list li.load-more a, 
				body.buddypress .youzer .activity-list li.load-newest a,
				.yz-media-filter .yz-filter-item .yz-filter-content span
				{font-size:'.esc_attr($h6_font_size).'px;}';
				
				$hea_font_size_css.='body.bp-legacy .logy-form .logy-form-actions button, body.bp-legacy .logy-form .logy-link-button, body.bp-legacy .logy-with-labels .logy-form-item label, body.bp-legacy .logy-form-actions button, body.bp-legacy #logy_signup_form fieldset legend, body.bp-legacy #logy_signup_form label, body.bp-legacy #logy_signup_form .logy-section-title span, body.bp-legacy #logy_signup_form label .field-visibility-text, body.bp-legacy #logy_signup_form .field-visibility-settings .field-visibility-settings-close
				{font-size:'.esc_attr($h6_font_size).'px;}';
				/*youzer*/
				
				$hea_font_size_css.='.h7,
									button,input[type=button],input[type=submit],input[type="reset"],.basic-button,.next-content a,.prev-content a,
									.pmpro_btn, 
									.pmpro_btn:link, 
									.pmpro_content_message a, 
									.pmpro_content_message a:link,
									.pmpro_checkout .pmpro_btn,
									#nav-below.navigation a,
									.woocommerce #respond input#submit, 
									.woocommerce a.button, 
									.woocommerce button.button, 
									.woocommerce input.button,
									.woocommerce nav.woocommerce-pagination .page-numbers li > *
									{font-size:'.esc_attr($h7_font_size).'px;}';									
				/*youzer*/
				$hea_font_size_css.='body.buddypress button, body.buddypress input[type="submit"], body.buddypress #yz-directory-search-box form input[type=submit], body.buddypress .yz-reset-options, body.buddypress .yz-save-options, body.buddypress #send_message_form .submit #send, body.buddypress .item-list-tabs #search-message-form #messages_search_submit, body.buddypress #send-reply #send_reply_button, body.buddypress #bp-browse-button, body.buddypress .widget_bp_core_sitewide_messages .bp-site-wide-message button, body.buddypress .youzer-main-content .wp-picker-container .wp-picker-clear, body.buddypress .youzer-main-content .wp-picker-container .wp-color-picker, body.buddypress .widget_bp_core_members_widget .item-options a, body.buddypress .uk-upload-photo .uk-upload-button, body.buddypress #sitewide-notice #message button, body.buddypress .yz-cphoto-options .yz-upload-photo, body.buddypress #yz-directory-search-box form input[type=submit], body.buddypress .group-members #search-members-form #members_search_submit, body.buddypress .pagination .page-numbers, body.buddypress .yz-project-type, body.buddypress .yz-post-type, body.buddypress .yz-user-statistics li h3, body.buddypress .logy-form-actions button, body.buddypress .action-button, body.buddypress .yza-item-button, body.buddypress .yz-items-list-widget .yz-list-item .yz-item-meta .yz-meta-item, body.buddypress .yz-reset-options, body.buddypress .yz-save-options, body.buddypress div.item-list-tabs li a, body.buddypress .yz-pagination .yz-nav-links .page-numbers, body.buddypress .yz-pagination .yz-pagination-pages, body.buddypress #whats-new-post-in-box label, body.buddypress .widget_bp_core_members_widget .item-options a, body.buddypress .widget_bp_groups_widget .item-options a, body.buddypress #yz-wall-nav li a, body.buddypress .yz-directory-filter .item-list-tabs li label, body.buddypress .yz-directory-filter .item-list-tabs li#members-order-select label, body.buddypress .yz-user-balance-box .yz-box-head, body.buddypress .yz-profile-sidebar .yz-aboutme-description, body.buddypress .yz-tab-post .yz-read-more, body.buddypress #yz-profile-navmenu .yz-settings-menu a span,
				body.buddypress #group-settings-form .yz-group-submit-form #group-creation-previous, 
				body.buddypress #group-settings-form input[type=submit], 
				body.buddypress #send-invite-form .submit input, 
				body.buddypress .yz-group-settings-tab .yz-group-submit-form #group-creation-previous, 
				body.buddypress .yz-group-settings-tab input[type=submit],
				body.buddypress .yz-group-manage-members-search #members_search_submit,
				body.buddypress .yz-group-settings-tab .yz-group-submit-form input
				{font-size:'.esc_attr($h7_font_size).'px;}';
				
				$hea_font_size_css.='body.bp-legacy #logy_signup_form .field-visibility-settings-notoggle .current-visibility-level, body.bp-legacy #logy_signup_form .field-visibility-settings-toggle .current-visibility-level, body.bp-legacy #logy_signup_form .field-visibility-settings-notoggle .visibility-toggle-link, body.bp-legacy #logy_signup_form .field-visibility-settings-toggle .visibility-toggle-link
				{font-size:'.esc_attr($h7_font_size).'px;}';
				/*youzer*/					
				
				$hea_font_size_css.='.h-font-size-30{font-size:'.esc_attr($h_font_size_30).'px;}';
				$hea_font_size_css.='.h-font-size-36{font-size:'.esc_attr($h_font_size_36).'px;}';
				$hea_font_size_css.='.h-font-size-40{font-size:'.esc_attr($h_font_size_40).'px;}';
				$hea_font_size_css.='.h-font-size-48{font-size:'.esc_attr($h_font_size_48).'px;}';
				$hea_font_size_css.='@media(max-width:1199px){.h1-small-desktop{font-size:'.esc_attr($h1_font_size).'px;}}';
				$hea_font_size_css.='@media(max-width:767px){.h1-tablet{font-size:'.esc_attr($h1_font_size).'px;}}';
				$hea_font_size_css.='@media(max-width:767px){.h2-tablet{font-size:'.esc_attr($h2_font_size).'px;}}';
				$hea_font_size_css.='@media(max-width:1199px){.h3-small-desktop{font-size:'.esc_attr($h3_font_size).'px;}}';
				$hea_font_size_css.='@media(max-width:575px){.h5-mobile{font-size:'.esc_attr($h5_font_size).'px;}}';
				$hea_font_size_css.='@media(max-width:1450px){.h5-small-desktop{font-size:'.esc_attr($h5_font_size).'px;}}';
				$hea_font_size_css.='@media(max-width:575px){.h6-mobile{font-size:'.esc_attr($h6_font_size).'px;}}';
			}
			
			if($hea_font_size_css!=''){
				$css_snippet.=$hea_font_size_css;
			}
			/*heading*/		
		
			/*nav*/
			$nav_font_css = '';
			$nav_font_size_css = '';
			if(isset($nav_font['font-family']) && $nav_font['font-family']!=''){
				$nav_font_css.='font-family:'.esc_attr($nav_font['font-family']).';';
			}
			if(isset($nav_font['line-height']) && $nav_font['line-height']!=''){
				$nav_font_css.='line-height:'.esc_attr($nav_font['line-height']).';';
			}
			if(isset($nav_font['font-weight']) && $nav_font['font-weight']!=''){
				$nav_font_css.='font-weight:'.esc_attr($nav_font['font-weight']).';';
			}
			if(isset($nav_font['font-style']) && $nav_font['font-style']!=''){
				$nav_font_css.='font-style:'.esc_attr($nav_font['font-style']).';';
			}
			if(isset($nav_font['text-transform']) && $nav_font['text-transform']!=''){
				$nav_font_css.='text-transform:'.esc_attr($nav_font['text-transform']).';';
			}
			if(isset($nav_font['letter-spacing']) && $nav_font['letter-spacing']!=''){
				$nav_font_css.='letter-spacing:'.esc_attr($nav_font['letter-spacing']).';';
			}
			
			if($nav_font_css!=''){
				$css_snippet.='.navigation-font,div.bbp-breadcrumb,#bbpress-forums div.bbp-breadcrumb > p,#bbpress-forums .bbp-pagination,.widget_nav_menu{'.$nav_font_css.'}';
			}
			
			$nav_font_scale = vidorev_get_redux_option('nav_font_scale', 1);
			if($nav_font_scale!=1){
				$font__navigation_size 		= round(14 * $nav_font_scale);
				$font_navigation_size_12 	= round($font__navigation_size * 0.86);
				$font_navigation_size_16 	= round($font__navigation_size * 1.142);
				
				$nav_font_size_css.='
				body.header-vid-side .side-menu-wrapper .main-side-menu,.widget_nav_menu{font-size:'.esc_attr($font_navigation_size_16).'px;}
				.navigation-font,body.header-vid-side .side-menu-wrapper .main-side-menu > ul > li > ul > li ul{font-size:'.esc_attr($font__navigation_size).'px;}
				.nav-font-size-12,div.bbp-breadcrumb,#bbpress-forums div.bbp-breadcrumb > p,#bbpress-forums .bbp-pagination{font-size:'.esc_attr($font_navigation_size_12).'px;}
				';
			}
			
			if($nav_font_size_css!=''){
				$css_snippet.=$nav_font_size_css;
			}/*nav*/
			
			/*meta*/
			$meta_font_css = '';
			$meta_font_size_css = '';
			if(isset($meta_font['font-family']) && $meta_font['font-family']!=''){
				$meta_font_css.='font-family:'.esc_attr($meta_font['font-family']).';';
			}
			if(isset($meta_font['line-height']) && $meta_font['line-height']!=''){
				$meta_font_css.='line-height:'.esc_attr($meta_font['line-height']).';';
			}
			if(isset($meta_font['font-weight']) && $meta_font['font-weight']!=''){
				$meta_font_css.='font-weight:'.esc_attr($meta_font['font-weight']).';';
			}
			if(isset($meta_font['font-style']) && $meta_font['font-style']!=''){
				$meta_font_css.='font-style:'.esc_attr($meta_font['font-style']).';';
			}
			if(isset($meta_font['text-transform']) && $meta_font['text-transform']!=''){
				$meta_font_css.='text-transform:'.esc_attr($meta_font['text-transform']).';';
			}
			if(isset($meta_font['letter-spacing']) && $meta_font['letter-spacing']!=''){
				$meta_font_css.='letter-spacing:'.esc_attr($meta_font['letter-spacing']).';';
			}
			
			if($meta_font_css!=''){
				$css_snippet.='.meta-font,#bbpress-forums li.bbp-body li.bbp-forum-topic-count, #bbpress-forums ul.bbp-topics li.bbp-body p.bbp-topic-meta, #bbpress-forums li.bbp-body li.bbp-topic-voice-count, #bbpress-forums li.bbp-body li.bbp-forum-reply-count, #bbpress-forums li.bbp-body li.bbp-topic-reply-count, #bbpress-forums li.bbp-body li.bbp-forum-freshness, #bbpress-forums li.bbp-body li.bbp-topic-freshness, #bbpress-forums div.bbp-meta,.widget_display_topics .widget-item-wrap > ul > li,.woocommerce .product.type-product .product_meta,.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta,body.header-vid-side div.asl_r .results .item div.etc,body.header-vid-side div.asl_r .results .item div.etc .asl_author, body.header-vid-side div.asl_r .results .item div.etc .asl_date,.widget-mycred-list .myCRED-leaderboard .yz-leaderboard-points,.elementor-widget-container .myCRED-leaderboard .yz-leaderboard-points{'.$meta_font_css.'}';
			}
			
			$meta_font_scale = vidorev_get_redux_option('meta_font_scale', 1);
			if($meta_font_scale!=1){
				$font__meta_size 		= round(12 * $meta_font_scale);
				$font__meta_size_10 	= round($font__meta_size * 0.83);
				$font__meta_size_14 	= round($font__meta_size * 1.17);
				
				$meta_font_size_css.='
				.meta-font, #bbpress-forums ul.bbp-topics li.bbp-body p.bbp-topic-meta, #bbpress-forums li.bbp-body li.bbp-forum-topic-count, #bbpress-forums li.bbp-body li.bbp-topic-voice-count, #bbpress-forums li.bbp-body li.bbp-forum-reply-count, #bbpress-forums li.bbp-body li.bbp-topic-reply-count, #bbpress-forums li.bbp-body li.bbp-forum-freshness, #bbpress-forums li.bbp-body li.bbp-topic-freshness, #bbpress-forums div.bbp-meta,.widget_display_topics .widget-item-wrap > ul > li,.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta,body.header-vid-side div.asl_r .results .item div.etc,body.header-vid-side div.asl_r .results .item div.etc .asl_author, body.header-vid-side div.asl_r .results .item div.etc .asl_date,.widget-mycred-list .myCRED-leaderboard .yz-leaderboard-points,.elementor-widget-container .myCRED-leaderboard .yz-leaderboard-points{font-size:'.esc_attr($font__meta_size).'px;}
				.m-font-size-10,span.bbp-admin-links a{font-size:'.esc_attr($font__meta_size_10).'px;}
				.woocommerce .product.type-product .product_meta{font-size:'.esc_attr($font__meta_size_14).'px;}
				';
			}
			
			if($meta_font_size_css!=''){
				$css_snippet.=$meta_font_size_css;
			}/*meta*/	
		
		/*typography*/
		
		if(function_exists('is_bbpress') && is_bbpress()){
			$css_snippet.='body.bbpress .global-single-content .entry-header{display:none}';
		}
		
		$theme_css = trim(vidorev_get_redux_option('theme_css', ''));		
		if($theme_css!=''){
			$css_snippet.=$theme_css;
		}
		
		if( is_page() ){
			$page_id = get_the_ID();			
			$page_custom_css = get_post_meta($page_id, 'page_custom_css', true);
			$css_snippet.= 	$page_custom_css;	
		}
		
		if(beeteam368_return_embed()){
			$admin_bar_filter_name = 'show_admin_bar';
			$css_snippet.='html{overflow: hidden !important;}';
			add_filter( $admin_bar_filter_name, '__return_false' );
			remove_action( 'wp_head', '_admin_bar_bump_cb' );
		}
	
		return $css_snippet;
	}
}

add_action('amp_post_template_css', function(){			
	?>
    .amp-site-title{
   		display:none;
    }
    h1.amp-wp-title{
    	font-size:1.8em;
        font-weight:700;
        line-height:1.3;
    }
    .amp-wp-header div{
   		min-height:30px;
        padding:15px 16px;
        text-align:center;
        line-height:1;
    }
    .amp-wp-site-logo{
    	display:inline-block;
        margin-left:auto;
        margin-right:auto;
    }
    .wp-caption .wp-caption-text{
    	text-align:center;
    }
    .amp-wp-comments-link a{
    	border-radius:0;
        border-width:1px;
    }
    .amp-wp-footer{
    	text-align:center;
    }
    .amp-wp-footer h2{
    	margin:0;
    }
    .amp-wp-footer p{
    	margin:0;
    }
    <?php
});