<?php
if(!function_exists('vidorev_display_main_menu')):
	function vidorev_display_main_menu(){
		if(has_nav_menu('VidoRev-MainMenu')){
			
			wp_nav_menu(array(
				'theme_location'  	=> 'VidoRev-MainMenu',
				'container' 		=> false,
				'items_wrap' 		=> '%3$s',
				'walker' 			=> new vidorev_walkernav(),
			));
			
		}else{
		?>
			<li>
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<?php esc_html_e('Home', 'vidorev'); ?>
				</a>
			</li>
		<?php 
			wp_list_pages('depth=1&number=3&title_li=');
		}
	}
endif;
add_action( 'vidorev_display_main_menu', 'vidorev_display_main_menu', 10 );

if(!function_exists('vidorev_display_top_menu')):
	function vidorev_display_top_menu($pos){
		$top_menu_position = vidorev_get_redux_option('top_menu_position', 'left');
		if(has_nav_menu('VidoRev-TopMenu') && vidorev_get_redux_option('top_menu', 'off', 'switch') == 'on' && $pos == $top_menu_position){			
			$extra_pos = ($top_menu_position == 'left')?'float-left':'float-right';
		?>
			<div class="site__col top-menu <?php echo esc_attr($extra_pos);?> navigation-font nav-font-size-12">
				<div class="top-menu-content">
					<ul>
						<?php	
							wp_nav_menu(array(
								'theme_location'  	=> 'VidoRev-TopMenu',
								'container' 		=> false,
								'items_wrap' 		=> '%3$s',
								'walker' 			=> new vidorev_walkernav_for_mobile(),
							));
						?>
					</ul>
				</div>
			</div>
		<?php
		}
	}
endif;
add_action( 'vidorev_topnav_menu', 'vidorev_display_top_menu', 10, 1 );

if(!function_exists('vidorev_display_mobile_menu')):
	function vidorev_display_mobile_menu(){
	?>
		<div id="vp-mobile-menu" class="dark-background vp-mobile-menu-control">
			<div class="vp-mobile-menu-body">
			
				<div class="button-menu-mobile button-menu-mobile-control">
					<span></span>			
					<span></span>			
					<span></span>			
					<span></span>			
					<span></span>			
				</div>
				
				<div class="mobile-menu-social">
					<?php do_action( 'vidorev_topnav_social_accounts_listing', array('s-grid mobile-style', 'watch-later', 'notifications') );?>
				</div>
			
				<div class="vp-mobile-menu-items vp-mobile-menu-items-control navigation-font">
					<ul>
						<?php	
						if(has_nav_menu('VidoRev-MainMenu')){
							wp_nav_menu(array(
								'theme_location'  	=> 'VidoRev-MainMenu',
								'container' 		=> false,
								'items_wrap' 		=> '%3$s',
								'walker' 			=> new vidorev_walkernav_for_mobile(),
							));
						}else{
						?>
							<li>
								<a href="<?php echo esc_url(home_url('/')); ?>">
									<?php esc_html_e('Home', 'vidorev'); ?>
								</a>
							</li>
						<?php 
							wp_list_pages('depth=1&number=3&title_li=');
						}
						?>
					</ul>
					<?php 
					if(has_nav_menu('VidoRev-TopMenu') && vidorev_get_redux_option('top_menu', 'off', 'switch') == 'on'){	
					?>
						<ul>
							<?php	
								wp_nav_menu(array(
									'theme_location'  	=> 'VidoRev-TopMenu',
									'container' 		=> false,
									'items_wrap' 		=> '%3$s',
									'walker' 			=> new vidorev_walkernav_for_mobile(),
								));
							?>
						</ul>
					<?php 
					}
					if(is_user_logged_in() && function_exists('pmpro_has_membership_access')){
						$pmpro_account_page_id = get_option( 'pmpro_account_page_id' );
						$pmpro_billing_page_id = get_option( 'pmpro_billing_page_id' );
					?>
						<ul class="membership-mobile-menu">
							<li>
								<a href="<?php echo (($pmpro_account_page_id!='' && is_numeric($pmpro_account_page_id) && $pmpro_account_page_id>0)?esc_url(get_permalink($pmpro_account_page_id)):'#')?>" title="<?php echo esc_attr__('Membership Account', 'vidorev')?>" class="h6">
									<?php echo esc_html__('Membership Account', 'vidorev');?>
								</a>
							</li>
							<li>
								<a href="<?php echo (($pmpro_billing_page_id!='' && is_numeric($pmpro_billing_page_id) && $pmpro_billing_page_id>0)?esc_url(get_permalink($pmpro_billing_page_id)):'#')?>" title="<?php echo esc_attr__('Billing Information', 'vidorev')?>" class="h6">
									<?php echo esc_html__('Billing Information', 'vidorev');?>
								</a>
							</li>
						</ul>						
					<?php	
					}
					if(is_user_logged_in() && class_exists( 'WooCommerce' )){
					?>
						<ul class="membership-mobile-menu">
							<li>
								<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php echo esc_attr__('My Account', 'vidorev')?>" class="h6">
									<?php echo esc_html__('My Account', 'vidorev');?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url(wc_get_account_endpoint_url(get_option( 'woocommerce_myaccount_downloads_endpoint', 'downloads' )));?>" title="<?php echo esc_attr__('My Downloads', 'vidorev')?>" class="h6">
									<?php echo esc_html__('My Downloads', 'vidorev');?>
								</a>
							</li>
						</ul>
					<?php	
					}
					
					if(is_user_logged_in() && defined('CHANNEL_PM_PREFIX') && vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')=='yes'){
						$vid_channel_subscribed_page = vidorev_get_option('vid_channel_subscribed_page', 'vid_channel_subscribe_settings', '');
					?>
						<ul class="membership-mobile-menu">
							<li>
								<a href="<?php echo (($vid_channel_subscribed_page!='' && is_numeric($vid_channel_subscribed_page) && $vid_channel_subscribed_page>0)?esc_url(get_permalink($vid_channel_subscribed_page)):'#')?>" title="<?php echo esc_attr__('Subscriptions', 'vidorev')?>" class="h6">
									<i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo esc_html__('Subscriptions', 'vidorev');?>
								</a>
							</li>							
						</ul>
					<?php	
					}
					?>	
					<ul class="membership-submit-video-mobile-menu"><?php do_action('vidorev_topnav_submit_video');?></ul>
				</div>
			</div>
		</div>
		<?php
	}
endif;
add_action( 'vidorev_display_mobile_menu', 'vidorev_display_mobile_menu', 10 );

if(!function_exists('vidorev_main_logo_retina')):
	function vidorev_main_logo_retina(){
		$header_style = vidorev_header_style();	
		
		$color_mode = '';
		if(is_page()){
			$page_id = get_the_ID();			
			$color_mode = get_post_meta($page_id, 'color_mode', true);				
		}		
		if($color_mode==''){				
			$color_mode = vidorev_get_redux_option('color_mode', 'white');
		}
			
		switch($header_style){
			case 'default':
				$main_logo_sample = get_template_directory_uri().'/img/logo.png';
				break;
			case 'classic':
				if($color_mode == 'dark'){
					$main_logo_sample = get_template_directory_uri().'/img/logo-classic-dark.png';
				}else{
					$main_logo_sample = get_template_directory_uri().'/img/logo-classic.png';
				}
				break;
			case 'sport':
				$main_logo_sample = get_template_directory_uri().'/img/logo.png';
				break;
			case 'tech':
				$main_logo_sample = get_template_directory_uri().'/img/logo-small.png';
				break;
			case 'blog':
				if($color_mode == 'dark'){
					$main_logo_sample = get_template_directory_uri().'/img/logo-blog-dark.png';
				}else{
					$main_logo_sample = get_template_directory_uri().'/img/logo-blog.png';
				}				
				break;
			case 'movie':
				$main_logo_sample = get_template_directory_uri().'/img/logo-small.png';
				break;
			case 'side':
				$main_logo_sample = get_template_directory_uri().'/img/logo-mobile.png';
				break;	
			default:
				$main_logo_sample = get_template_directory_uri().'/img/logo.png';						
		}
		
		$main_logo_mobile_sample 	= get_template_directory_uri().'/img/logo-mobile.png';	
		$sticky_logo_sample			= get_template_directory_uri().'/img/logo-sticky-default.png';
		
		$main_logo			= '';
		$main_logo_mobile	= '';
		$sticky_logo		= '';
		
		if(is_single() || is_page()){
			$post_id			= get_the_ID();
			$main_logo			= trim(get_post_meta($post_id, 'main_logo', true));
			$main_logo_mobile	= trim(get_post_meta($post_id, 'main_logo_mobile', true));
			$sticky_logo		= trim(get_post_meta($post_id, 'sticky_logo', true));
		}
		
		if($main_logo=='') $main_logo 				= trim(vidorev_get_redux_option('main_logo', '', 'media_get_src'));
		if($main_logo_mobile=='') $main_logo_mobile	= trim(vidorev_get_redux_option('main_logo_mobile', '', 'media_get_src'));
		if($sticky_logo=='') $sticky_logo 			= trim(vidorev_get_redux_option('sticky_logo', '', 'media_get_src'));
		
		$alt = get_bloginfo('name');
		
		if($main_logo!=''){
		?>
			<img src="<?php echo esc_url($main_logo);?>" alt="<?php echo esc_attr($alt);?>" class="main-logo">
		<?php
		}else{
		?>
			<img src="<?php echo esc_url($main_logo_sample);?>" alt="<?php echo esc_attr($alt);?>" class="main-logo">
		<?php
		}
		
		if($main_logo_mobile!=''){
		?>
			<img src="<?php echo esc_url($main_logo_mobile);?>" alt="<?php echo esc_attr($alt);?>" class="main-logo-mobile">
		<?php
		}else{
		?>
			<img src="<?php echo esc_url($main_logo_mobile_sample);?>" alt="<?php echo esc_attr($alt);?>" class="main-logo-mobile">
		<?php
		}
		
		if($sticky_logo!=''){
		?>
			<img src="<?php echo esc_url($sticky_logo);?>" alt="<?php echo esc_attr($alt);?>" class="sticky-logo">
		<?php	
		}else{
		?>
			<img src="<?php echo esc_url($sticky_logo_sample);?>" alt="<?php echo esc_attr($alt);?>" class="sticky-logo">
		<?php
		}	
		
	}
endif;
add_action( 'vidorev_main_logo_retina', 'vidorev_main_logo_retina', 10 );

if(!function_exists('vidorev_top_header_content_ads')):
	function vidorev_top_header_content_ads(){
		if(vidorev_get_redux_option('ads_in_header', '') !=''){
		?>
			<div class="top-ad-content">
				<div class="top-ad-wrap">	
					<?php echo do_shortcode(vidorev_get_redux_option('ads_in_header', ''));?>
				</div>
			</div>
		<?php	
		}
	}
endif;
add_action( 'vidorev_top_header_content_ads', 'vidorev_top_header_content_ads', 10 );

if(!function_exists('vidorev_top_header_ads_mobile')):
	function vidorev_top_header_ads_mobile(){
		if(vidorev_get_redux_option('ads_in_header_mobile', '') !=''){
		?>
			<div class="top-header-ads-mobile">
				<div class="site__container fullwidth-vidorev-ctrl container-control">
					<div class="site__row auto-width">
						<div class="site__col">
							<div class="top-header-ads-mobile-content">	
								<?php echo do_shortcode(vidorev_get_redux_option('ads_in_header_mobile', ''));?>
							</div>
						</div>
					</div>
				</div>
			</div>					
		<?php	
		}
	}
endif;
add_action( 'vidorev_top_header_ads_mobile', 'vidorev_top_header_ads_mobile', 10 );

if(!function_exists('vidorev_above_footer_content_ads')):
	function vidorev_above_footer_content_ads(){
		if(vidorev_get_redux_option('ads_above_footer', '') !=''){
			?>
			<div class="ads-above-footer">
				<div class="site__container fullwidth-vidorev-ctrl">
					<div class="site__row">
						<div class="site__col">
							<?php echo do_shortcode(vidorev_get_redux_option('ads_above_footer', ''));?>
						</div>
					</div>
				</div>			
			</div>
			<?php
		}
	}
endif;
add_action( 'vidorev_above_footer_content_ads', 'vidorev_above_footer_content_ads', 10 );

if(!function_exists('vidorev_above_single_content_ads')):
	function vidorev_above_single_content_ads(){
		if(vidorev_get_redux_option('ads_above_single', '') !=''){
			if(is_single() && is_singular('vid_channel')){
				return;	
			}
			?>
			<div class="ads-above-single">
				<?php echo do_shortcode(vidorev_get_redux_option('ads_above_single', ''));?>
			</div>
			<?php
		}
	}
endif;
add_action( 'vidorev_above_single_content_ads', 'vidorev_above_single_content_ads', 10 );

if(!function_exists('vidorev_below_single_content_ads')):
	function vidorev_below_single_content_ads(){
		if(vidorev_get_redux_option('ads_below_single', '') !=''){
			?>
			<div class="ads-below-single">
				<?php echo do_shortcode(vidorev_get_redux_option('ads_below_single', ''));?>
			</div>
			<?php
		}
	}
endif;
add_action( 'vidorev_below_single_content_ads', 'vidorev_below_single_content_ads', 10 );

if(!function_exists('vidorev_between_post_content_ads')):
	function vidorev_between_post_content_ads(){
		if(vidorev_get_redux_option('ads_between_post', '') !=''){
			$ads_between_post_offset = vidorev_get_redux_option('ads_between_post_offset', 3);
			
			global $post_ads_index;
			if(isset($post_ads_index) && $post_ads_index!=''){
				$post_ads_index++;
			}else{
				$post_ads_index = 1;
			}
			if($post_ads_index==$ads_between_post_offset){
			?>
				<article class="post-item site__col">
					<div class="ads-between-post">
						<?php echo do_shortcode(vidorev_get_redux_option('ads_between_post', ''));?>
					</div>
				</article>
			<?php
			}
		}
	}
endif;
add_action( 'vidorev_between_post_content_ads', 'vidorev_between_post_content_ads', 10 );

if(!function_exists('vidorev_above_single_player_ads')):
	function vidorev_above_single_player_ads($post_id = 0){
		$ads_above_single_player = '';
		$ads_above_single_player = trim(get_post_meta($post_id, 'ads_above_single_player', true));
		if($ads_above_single_player == ''){
			$ads_above_single_player = vidorev_get_redux_option('ads_above_single_player', '');
		}
		if($ads_above_single_player !='' && !beeteam368_return_embed()){
			?>
			<div class="ads-above-single-player">
				<?php echo apply_filters('vidorev_above_player_ads_source', do_shortcode($ads_above_single_player), $post_id);?>
			</div>
			<?php
		}
	}
endif;
add_action( 'vidorev_above_single_player_ads', 'vidorev_above_single_player_ads', 10 );

if(!function_exists('vidorev_above_channel_ads')):
	function vidorev_above_channel_ads($force = false){
		if((is_post_type_archive('vid_channel') || is_tax('vid_channel_cat') || $force) && vidorev_get_redux_option('ads_above_channel', '') !=''){
			?>
			<div class="ads-above-channel">
				<?php echo do_shortcode(vidorev_get_redux_option('ads_above_channel', ''));?>
			</div>
			<?php
		}
	}
endif;
add_action( 'vidorev_above_channel_ads', 'vidorev_above_channel_ads', 10 );

if(!function_exists('vidorev_top_header_posts_slider')):
	function vidorev_top_header_posts_slider(){
		$latest_news 			= vidorev_get_redux_option('latest_news', 'off', 'switch');		
		$latest_news_title 		= trim(vidorev_get_redux_option('latest_news_title', ''));		
		$latest_news_ic 		= trim(vidorev_get_redux_option('latest_news_ic', ''));
		$latest_news_it 		= trim(vidorev_get_redux_option('latest_news_it', ''));	
		$latest_news_pt 		= trim(vidorev_get_redux_option('latest_news_pt', 'post-without-video'));		
		
		if($latest_news == 'off'){
			return '';
		}		
		
		$category 	= $latest_news_ic!=''?$latest_news_ic:'';
		$tag 		= $latest_news_it!=''?$latest_news_it:'';
		
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> 8,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,		
		);
		
		$args_re = array('relation' => 'OR');
		
		if($latest_news_pt == 'post-video'){			
			$args_re[] = 	array(
								'taxonomy'  => 'post_format',
								'field'    	=> 'slug',
								'terms'     => array('post-format-video'),
								'operator'  => 'IN',
							);
		}elseif($latest_news_pt == 'post-without-video'){			
			$args_re[] = 	array(
								'taxonomy'  => 'post_format',
								'field'    	=> 'slug',
								'terms'     => array('post-format-video'),
								'operator'  => 'NOT IN',
							);
		}
		
		if($category!='' || $tag!=''){
			$catArray = array();
			$tagArray = array();
		
			$catExs = explode(',', $category);
			$tagExs = explode(',', $tag);
			
			foreach($catExs as $catEx){	
				if(is_numeric(trim($catEx))){					
					array_push($catArray, trim($catEx));
				}else{
					$slug_cat = get_term_by('slug', trim($catEx), 'category');					
					if($slug_cat){
						$cat_term_id = $slug_cat->term_id;
						array_push($catArray, $cat_term_id);
					}
				}
			}			
			
			foreach($tagExs as $tagEx){	
				if(is_numeric(trim($tagEx))){					
					array_push($tagArray, trim($tagEx));
				}else{
					$slug_tag = get_term_by('slug', trim($tagEx), 'post_tag');									
					if($slug_tag){
						$tag_term_id = $slug_tag->term_id;	
						array_push($tagArray, $tag_term_id);
					}
				}
			}
			
			if(count($catArray) > 0 || count($tagArray) > 0){
				$taxonomies = array();
				
				$def = array(
					'field' 			=> 'id',
					'operator' 			=> 'IN',
				);
				
				if(count($catArray) > 0){
					array_push($taxonomies, 'category');
					$args_cat_query = wp_parse_args(
						array(
							'taxonomy'	=> 'category',
							'terms'		=> $catArray,
						),
						$def
					);
				}
				
				if(count($tagArray) > 0){
					array_push($taxonomies, 'post_tag');
					$args_tag_query = wp_parse_args(
						array(
							'taxonomy'	=> 'post_tag',
							'terms'		=> $tagArray,
						),
						$def
					);
				}
				
				if(count($taxonomies) > 1){
					$args_re[] = array(
						'relation' => 'OR',
						$args_cat_query,
						$args_tag_query,	
					);
				}else{
					if(count($catArray) > 0 && count($tagArray) == 0){
						$args_re[] = $args_cat_query;
					}elseif(count($catArray) == 0 && count($tagArray) > 0){
						$args_re[] = $args_tag_query;
					}
				}			
				
			}
		}
		
		if(count($args_re)>1){
			if(count($args_re)>2){
				$args_re['relation'] = 'AND';
			}
			$args_query['tax_query'] = $args_re;
		}
		
		$args_query['order'] 	= 'DESC';
		$args_query['orderby'] 	= 'date';
		
		$sc_query = new WP_Query($args_query);
														
		$r_latest_news_title = $latest_news_title!=''?$latest_news_title:esc_html__('Latest news', 'vidorev');
	?>
		<div class="top-video-header">
			<h2 class="top-video-heading h7 extra-bold"><?php echo esc_html($r_latest_news_title);?></h2>
		</div>
		
		<?php if($sc_query->have_posts()):?>
				
			<div class="top-video-listing font-size-12">
				<ul class="fading-slide-control">
					
					<?php 
					$i = 1;
					while($sc_query->have_posts()):
						$sc_query->the_post();
					?>					
						<li <?php if($i==1){?>class="active-item"<?php }?>><a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>" class="neutral"><?php the_title();?></a></li>				
					<?php 
						$i++;
					endwhile;
					?>
				</ul>
			</div>		
		<?php
		endif;
		wp_reset_postdata();
	}
endif;
add_action( 'vidorev_top_header_posts_slider', 'vidorev_top_header_posts_slider', 10 );

if(!function_exists('vidorev_social_accounts_listing')):
	function vidorev_social_accounts_listing($arg){	
		?>
		<ul class="social-block <?php echo esc_attr($arg[0]);?>">
			<?php
			
			do_action('vidorev_social_accounts_elements');
			
			if(isset($arg[1]) && $arg[1]=='watch-later' && vidorev_get_redux_option('watch_enable', 'off', 'switch')=='on'){				
				$watch_page = vidorev_get_redux_option('watch_page', '');
				global $watch_later_cookie;
				if(!isset($watch_later_cookie) || !is_array($watch_later_cookie)){
					$watch_later_cookie = array();
				}
				$r_watch_page = ($watch_page!='' && is_numeric($watch_page))?get_permalink($watch_page):'#';
			?>
				<li class="watch-later-elm">
					<a href="<?php echo esc_url($r_watch_page);?>" title="<?php echo esc_attr__('Watch later', 'vidorev')?>" class="top-watch-dropdown">
						<span class="icon">
							<i class="fa fa-clock-o" aria-hidden="true"></i>
							<span class="<?php echo ((count($watch_later_cookie)>0)!=''?'hasVideos ':'')?>hasVideos-control"></span>
						</span>						
					</a>
					
					<?php do_action('vidorev_dropdown_watch_later');?>
					
				</li>
			<?php
			}
			
			if(	defined('CHANNEL_PM_PREFIX') 
				&& ((isset($arg[1]) && $arg[1]=='notifications') || (isset($arg[2]) && $arg[2]=='notifications') || (isset($arg[3]) && $arg[3]=='notifications')) 
				&& vidorev_get_option('vid_channel_notifications_fnc', 'vid_channel_notifications_settings', 'yes')=='yes'
				&& vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')=='yes'
			){
				
				$vid_channel_notifications_page 	= vidorev_get_option('vid_channel_notifications_page', 'vid_channel_notifications_settings', '');				
				$r_vid_channel_notifications_page 	= ($vid_channel_notifications_page!='' && is_numeric($vid_channel_notifications_page))?get_permalink($vid_channel_notifications_page):'#';				
				$new_posts 							= vidorev_get_channels_by_user_login(5, true);				
				
				$checkviewnoticeposts = false;
				$int_crr_user_id = get_current_user_id();
				
				if($int_crr_user_id > 0){
					$arr_get_notice_posts = get_user_meta( $int_crr_user_id, 'beeteam368_notification_posts', true );
					if(is_array($arr_get_notice_posts) && isset($new_posts[0]) && isset($new_posts[0]->ID)){
						if(($izc88 = array_search($new_posts[0]->ID, $arr_get_notice_posts)) !== FALSE){
							$checkviewnoticeposts = true;
						}
					}
				}				
			?>
            	<li class="watch-later-elm">
					<a href="<?php echo esc_url($r_vid_channel_notifications_page);?>" title="<?php echo esc_attr__('Notifications', 'vidorev')?>" class="top-watch-dropdown">
						<span class="icon">
							<i class="fa fa-bell" aria-hidden="true"></i>	
                            <span class="<?php echo ((count($new_posts)>0!=''&&!$checkviewnoticeposts)?'hasVideos ':'')?>"></span>						
						</span>						
					</a>
					
					<?php do_action('vidorev_dropdown_notifications', $new_posts);?>
					
				</li>
            <?php	
			}
			
			if(class_exists( 'WooCommerce' )){				
				$cart_url = wc_get_cart_url();
			?>
				<li class="woo-cart-elm">
					<a href="<?php echo esc_url($cart_url);?>" title="<?php echo esc_attr__('View your shopping cart', 'vidorev')?>" class="top-woo-cart">
						<span class="icon cart-number-ajax-control">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>	
							<span class="cart-total-items"><?php echo WC()->cart->get_cart_contents_count(); ?></span>						
						</span>												
					</a>					
				</li>
			<?php
			}			
			
			if(vidorev_get_redux_option('login_user_btn', 'on', 'switch')=='on'){
				$login_url 		= vidorev_get_option_login_page( 'cl_login_url');
				$register_url 	= vidorev_get_option_login_page( 'cl_register_url');
				$edit_url 		= vidorev_get_option_login_page( 'cl_edit_url');
				
				if(is_user_logged_in()){
					$current_user = wp_get_current_user();				 
					
				?>
					<li class="login-elm">
						<?php if(class_exists('BuddyPress') && class_exists('Youzer')){?>
							<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID', $current_user->ID ) )); ?>" title="<?php echo esc_attr__('Hi!', 'vidorev').' '.esc_attr($current_user->display_name);?>" class="top-login is-user-logged-in">
								<span class="icon top-watch-dropdown">	
									<i class="fa fa-user-plus" aria-hidden="true"></i>
								</span>
							</a>
						<?php }else{?>
							<a href="<?php echo esc_url($edit_url);?>" title="<?php echo esc_attr__('Hi!', 'vidorev').' '.esc_attr($current_user->display_name);?>" class="top-login is-user-logged-in">
								<span class="icon top-watch-dropdown">	
									<i class="fa fa-user-plus" aria-hidden="true"></i>
								</span>
							</a>
						<?php }?>
						
						<ul class="top-login-info top-login-info-control dark-background">
							<li class="top-login-content">
								<div>
									<?php echo wp_kses_post(get_avatar( get_the_author_meta('email', $current_user->ID ), 50 )); ?>
									<?php echo esc_html__('Hi!', 'vidorev').' '.esc_html($current_user->display_name);?><br>
									
									<?php if(class_exists('BuddyPress') && class_exists('Youzer')){?>
										<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID', $current_user->ID ) )); ?>" title="<?php echo esc_attr__('My Profile', 'vidorev')?>" class="h6"><?php echo esc_html__('My Profile', 'vidorev');?></a>
										&nbsp;|&nbsp;
									<?php }else{?>
										<a href="<?php echo esc_url($edit_url);?>" title="<?php echo esc_attr__('Edit my profile', 'vidorev')?>" class="h6"><?php echo esc_html__('Edit my profile', 'vidorev');?></a>
										&nbsp;|&nbsp;
										<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID', $current_user->ID ) )); ?>" title="<?php echo esc_attr__('My Posts', 'vidorev')?>" class="h6"><?php echo esc_html__('My Posts', 'vidorev');?></a>
										&nbsp;|&nbsp;
									<?php }?>
									
										<a href="<?php echo esc_url(wp_logout_url(home_url()));?>" title="<?php echo esc_attr__('Logout', 'vidorev')?>" class="h6"><?php echo esc_html__('Logout', 'vidorev');?></a>
									<?php 
									if(function_exists('pmpro_has_membership_access')){
										$pmpro_account_page_id = get_option( 'pmpro_account_page_id' );
										$pmpro_billing_page_id = get_option( 'pmpro_billing_page_id' );
									?>
										<br>
										<a href="<?php echo (($pmpro_account_page_id!='' && is_numeric($pmpro_account_page_id) && $pmpro_account_page_id>0)?esc_url(get_permalink($pmpro_account_page_id)):'#')?>" title="<?php echo esc_attr__('Membership Account', 'vidorev')?>" class="h6">
											<?php echo esc_html__('Membership Account', 'vidorev');?>
										</a>
										&nbsp;|&nbsp;
										<a href="<?php echo (($pmpro_billing_page_id!='' && is_numeric($pmpro_billing_page_id) && $pmpro_billing_page_id>0)?esc_url(get_permalink($pmpro_billing_page_id)):'#')?>" title="<?php echo esc_attr__('Billing Information', 'vidorev')?>" class="h6">
											<?php echo esc_html__('Billing Information', 'vidorev');?>
										</a>
									<?php	
									}
									
									if(class_exists( 'WooCommerce' )){
									?>
										<br>
										<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php echo esc_attr__('My Account', 'vidorev')?>" class="h6">
											<?php echo esc_html__('My Account', 'vidorev');?>
										</a>
										&nbsp;|&nbsp;
										<a href="<?php echo esc_url(wc_get_account_endpoint_url(get_option( 'woocommerce_myaccount_downloads_endpoint', 'downloads' )));?>" title="<?php echo esc_attr__('My Downloads', 'vidorev')?>" class="h6">
											<?php echo esc_html__('My Downloads', 'vidorev');?>
										</a>
									<?php	
									}
									if(defined('CHANNEL_PM_PREFIX') && vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')=='yes'){
										$vid_channel_subscribed_page = vidorev_get_option('vid_channel_subscribed_page', 'vid_channel_subscribe_settings', '');
										?>
										
										<br>
										<hr class="line-light">									
										<a href="<?php echo (($vid_channel_subscribed_page!='' && is_numeric($vid_channel_subscribed_page) && $vid_channel_subscribed_page>0)?esc_url(get_permalink($vid_channel_subscribed_page)):'#')?>" title="<?php echo esc_attr__('Subscriptions', 'vidorev')?>" class="h6">
											<i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo esc_html__('Subscriptions', 'vidorev');?>
										</a>
									<?php }?>	
								</div>
							</li>							
						</ul>
					</li>
				<?php
				}else{
			?>
					<li class="login-elm">
						<a href="<?php echo esc_url($login_url);?>" title="<?php echo esc_attr__('Login', 'vidorev')?>" class="top-login">
							<span class="icon top-watch-dropdown">	
								<i class="fa fa-user" aria-hidden="true"></i>
							</span>
						</a>
						
						<ul class="top-login-info top-login-info-control dark-background">
							<li class="top-login-content">
								<div>
									<i class="fa fa-user-circle" aria-hidden="true"></i><br>
									<?php echo esc_html__('You are not logged in!', 'vidorev');?><br>
									<a href="<?php echo esc_url($login_url);?>" title="<?php echo esc_attr__('Login', 'vidorev')?>" class="h6"><?php echo esc_html__('Login', 'vidorev');?></a>
									&nbsp;|&nbsp;
									<a href="<?php echo esc_url($register_url);?>" title="<?php echo esc_attr__('Create new account', 'vidorev')?>" class="h6"><?php echo esc_html__('Create new account', 'vidorev');?></a>					
								</div>
							</li>							
						</ul>
					</li>
			<?php
				}
			}
			
			if((isset($arg[1]) && $arg[1]=='search') || (isset($arg[2]) && $arg[2]=='search') || (isset($arg[3]) && $arg[3]=='search')){
			?>
				<li class="top-search-elm top-search-elm-control">
					<a href="#" title="<?php echo esc_attr__('Search', 'vidorev')?>" class="top-search-dropdown top-search-dropdown-control">
						<span class="icon">
							<i class="fa fa-search" aria-hidden="true"></i>
						</span>						
					</a>
					<ul class="dark-background">
						<li class="top-search-box-dropdown">
							<form action="<?php echo esc_url(home_url('/'));?>" method="get">					
								<input class="search-terms-textfield search-terms-textfield-control" autocomplete="off" type="text" placeholder="<?php echo esc_attr__('Type and hit enter ...', 'vidorev');?>" name="s" value="<?php echo esc_attr(get_search_query());?>">
								<input type="submit" value="<?php echo esc_attr_e('Search', 'vidorev');?>">							
							</form>
						</li>
					</ul>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
	}
endif;
add_action( 'vidorev_topnav_social_accounts_listing', 'vidorev_social_accounts_listing', 10 );

if(!function_exists('vidorev_topnav_submit_video')):
	function vidorev_topnav_submit_video($params){
		$submit_video		= vidorev_get_redux_option('submit_video', 'off', 'switch');
		$submit_video_text 	= trim(vidorev_get_redux_option('submit_video_text', ''));
		$submit_video_page 	= vidorev_get_redux_option('submit_video_page', '');
		
		if(function_exists('pll_get_post')){
			$submit_video_page_crr_lang = pll_get_post($submit_video_page);
			
			if(is_numeric($submit_video_page_crr_lang) && $submit_video_page_crr_lang>0){
				$submit_video_page = $submit_video_page_crr_lang;
			}
		}
		
		if($submit_video == 'on'){
			$r_submit_video_page = ($submit_video_page!='' && is_numeric($submit_video_page))?get_permalink($submit_video_page):'#';
			$r_submit_video_text = $submit_video_text!=''?$submit_video_text:esc_html__('Submit video', 'vidorev');
	?>
			<a href="<?php echo esc_url($r_submit_video_page);?>" class="basic-button basic-button-default user-submit-video <?php echo isset($params[0])?esc_attr($params[0]):''?>" target="<?php echo apply_filters('vidorev_submit_video_target', '_blank');?>">
				<?php echo esc_html($r_submit_video_text);?>
			</a>
	<?php
		}
	}
endif;
add_action( 'vidorev_topnav_submit_video', 'vidorev_topnav_submit_video', 10, 1 );

if(!function_exists('vidorev_button_nav_mobile_menu')):
	function vidorev_button_nav_mobile_menu(){
	?>
		<div class="button-wrap">
			<div class="button-menu-mobile button-menu-mobile-control">
				<span></span>			
				<span></span>			
				<span></span>			
				<span></span>			
				<span></span>			
			</div>
		</div>
	<?php
	}
endif;
add_action( 'vidorev_button_nav_mobile_menu', 'vidorev_button_nav_mobile_menu', 10 );

if(!function_exists('vidorev_button_nav_side_menu')):
	function vidorev_button_nav_side_menu(){
	?>
		<div class="button-wrap">
			<div class="button-menu-mobile button-menu-side-control">
				<span></span>			
				<span></span>			
				<span></span>			
				<span></span>			
				<span></span>			
			</div>
		</div>
	<?php
	}
endif;
add_action( 'vidorev_button_nav_side_menu', 'vidorev_button_nav_side_menu', 10 );

if(!function_exists('vidorev_login_mobile_menu')):
	function vidorev_login_mobile_menu(){
		if(vidorev_get_redux_option('login_user_btn', 'on', 'switch')=='on'){
			$login_url 		= vidorev_get_option_login_page( 'cl_login_url');
			$register_url 	= vidorev_get_option_login_page( 'cl_register_url');
			$edit_url 		= vidorev_get_option_login_page( 'cl_edit_url');
	?>
            <ul>
                <li class="top-login-mobile-elm top-login-mobile-elm-control">
                    <a href="#" title="<?php echo esc_attr__('Search', 'vidorev')?>" class="top-login-mobile-dropdown top-login-mobile-dropdown-control">
                        <span class="icon">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                        </span>						
                    </a>
                                    
                    <ul class="top-login-info top-login-info-control dark-background">
                        <?php
                        if(is_user_logged_in()){
                            $current_user = wp_get_current_user();
                        ?>
                            <li class="top-login-content">
                                <div>
                                    <?php echo wp_kses_post(get_avatar( get_the_author_meta('email', $current_user->ID ), 50 )); ?>
                                    <?php echo esc_html__('Hi!', 'vidorev').' '.esc_html($current_user->display_name);?><br>
                                    
                                    <?php if(class_exists('BuddyPress') && class_exists('Youzer')){?>
                                        <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID', $current_user->ID ) )); ?>" title="<?php echo esc_attr__('My Profile', 'vidorev')?>" class="h6"><?php echo esc_html__('My Profile', 'vidorev');?></a>
                                        &nbsp;|&nbsp;
                                    <?php }else{?>
                                        <a href="<?php echo esc_url($edit_url);?>" title="<?php echo esc_attr__('Edit my profile', 'vidorev')?>" class="h6"><?php echo esc_html__('Edit my profile', 'vidorev');?></a>
                                        &nbsp;|&nbsp;
                                        <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID', $current_user->ID ) )); ?>" title="<?php echo esc_attr__('My Posts', 'vidorev')?>" class="h6"><?php echo esc_html__('My Posts', 'vidorev');?></a>
                                        &nbsp;|&nbsp;
                                    <?php }?>
                                    
                                        <a href="<?php echo esc_url(wp_logout_url(home_url()));?>" title="<?php echo esc_attr__('Logout', 'vidorev')?>" class="h6"><?php echo esc_html__('Logout', 'vidorev');?></a>
                                    
                                </div>
                            </li>
                        <?php
                        }else{
                        ?>                        
                            <li class="top-login-content">
                                <div>
                                    <i class="fa fa-user-circle" aria-hidden="true"></i><br>
                                    <?php echo esc_html__('You are not logged in!', 'vidorev');?><br>
                                    <a href="<?php echo esc_url($login_url);?>" title="<?php echo esc_attr__('Login', 'vidorev')?>" class="h6"><?php echo esc_html__('Login', 'vidorev');?></a>
                                    &nbsp;|&nbsp;
                                    <a href="<?php echo esc_url($register_url);?>" title="<?php echo esc_attr__('Create new account', 'vidorev')?>" class="h6"><?php echo esc_html__('Create new account', 'vidorev');?></a>					
                                </div>
                            </li>
                        <?php	
                        }
                        ?>							
                    </ul>
                </li>
            </ul>
            <?php	
		}
	}
endif;
add_action( 'vidorev_login_mobile_menu', 'vidorev_login_mobile_menu', 10 );

if(!function_exists('vidorev_search_mobile_menu')):
	function vidorev_search_mobile_menu(){
	?>
		<ul>
			<li class="top-search-elm top-search-elm-control">
				<a href="#" title="<?php echo esc_attr__('Search', 'vidorev')?>" class="top-search-dropdown top-search-dropdown-control">
					<span class="icon">
						<i class="fa fa-search" aria-hidden="true"></i>
					</span>						
				</a>
				<ul class="dark-background">
					<li class="top-search-box-dropdown">
						<form action="<?php echo esc_url(home_url('/'));?>" method="get">					
							<input class="search-terms-textfield search-terms-textfield-control" autocomplete="off" type="text" placeholder="<?php echo esc_attr__('Type and hit enter ...', 'vidorev');?>" name="s" value="<?php echo esc_attr(get_search_query());?>">
							<input type="submit" value="<?php echo esc_attr_e('Search', 'vidorev');?>">							
						</form>
					</li>
				</ul>
			</li>
		</ul>
	<?php
	}
endif;
add_action( 'vidorev_search_mobile_menu', 'vidorev_search_mobile_menu', 10 );

if(!function_exists('vidorev_top_search_box')):
	function vidorev_top_search_box(){
	?>
		<div class="top-search-box-wrapper">
			<form action="<?php echo esc_url(home_url('/'));?>" method="get">					
				<input class="search-terms-textfield search-terms-textfield-control" autocomplete="off" type="text" placeholder="<?php echo esc_attr__('Search...', 'vidorev');?>" name="s" value="<?php echo esc_attr(get_search_query());?>">		
				<i class="fa fa-search" aria-hidden="true"></i>					
				<input type="submit" value="<?php echo esc_attr_e('Search', 'vidorev');?>">							
			</form>
		</div>
	<?php
	}
endif;
add_action( 'vidorev_top_search_box', 'vidorev_top_search_box', 10 );

if(!function_exists('vidorev_nav_breadcrumbs')):
	function vidorev_nav_breadcrumbs($args){
		
		if(is_page_template('page-templates/front-page-template.php') || is_page_template('template/blog-page-template.php') || (function_exists('is_bbpress') && is_bbpress())){
			return;
		}
		
		if(vidorev_get_redux_option('nav_breadcrumbs', 'on', 'switch')=='off'){
			echo '<div class="site__row nav-breadcrumbs-elm breadcrumbs-turn-off"><div class="site__col"><div class="nav-breadcrumbs navigation-font nav-font-size-12"></div></div></div>';
			return;
		}
		
		$output_string = '';
		
		ob_start();
		
		$text['home']     = esc_html__('Home', 'vidorev');
		$text['category'] = esc_html__('Archive by Category "%s"', 'vidorev');
		$text['search']   = esc_html__('Search Results for "%s" Query', 'vidorev');
		$text['tag']      = esc_html__('Posts Tagged "%s"', 'vidorev');
		$text['author']   = esc_html__('Articles Posted by %s', 'vidorev');
		$text['404']      = esc_html__('Error 404', 'vidorev');
	
		$show_current   = 1;
		$show_on_home   = 1;
		$show_home_link = 1;
		$show_title     = 1;
		$delimiter      = ' <i class="fa fa-angle-right icon-arrow"></i> ';
		$before         = '<span class="current">';
		$after          = '</span>';
	
		global $post;
		
		$home_link    = home_url('/');
		$link_before  = '<span>';
		$link_after   = '</span>';
		$link_attr    = 'class="neutral"';
		$link         = $link_before . '<a ' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
		
		$post == is_singular() ? get_queried_object() : false;
			
		if( $post ){
			$parent_id    = $parent_id_2 = $post->post_parent;
		} else {
			$parent_id    = $parent_id_2 = 0;
		}
		
		$frontpage_id = get_option('page_on_front');
	
		if (is_home() || is_front_page()) {
	
			if ($show_on_home == 1) {
				echo '<div class="site__row nav-breadcrumbs-elm"><div class="site__col"><div class="nav-breadcrumbs navigation-font nav-font-size-12"><div class="nav-breadcrumbs-wrap"><a class="neutral" href="' . esc_url($home_link) . '">' . esc_html($text['home']) . '</a></div></div></div></div>';
			}
	
		} else {
	
			echo '<div class="site__row nav-breadcrumbs-elm"><div class="site__col"><div class="nav-breadcrumbs navigation-font nav-font-size-12"><div class="nav-breadcrumbs-wrap">';
			
			if ($show_home_link == 1) {
				echo wp_kses_post('<a '.$link_attr.' href="' . $home_link . '">' . $text['home'] . '</a>');
				if ($frontpage_id == 0 || $parent_id != $frontpage_id) {
					echo wp_kses_post($delimiter);
				}
			}
	
			if ( is_category() ) {
				$this_cat = get_category(get_query_var('cat'), false);
				if ($this_cat->parent != 0) {
					$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
					if ($show_current == 0) {
						$cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					}
					$cats = str_replace('<a', $link_before . '<a ' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) {
						$cats = preg_replace('/ title="(.*?)"/', '', $cats);
					}
					echo wp_kses_post($cats);
				}
				if ($show_current == 1) {
					echo wp_kses_post($before . sprintf($text['category'], single_cat_title('', false)) . $after);
				}
	
			} elseif ( is_search() ) {
				echo wp_kses_post($before . sprintf($text['search'], get_search_query()) . $after);
	
			} elseif ( is_day() ) {
				echo wp_kses_post(sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter);
				echo wp_kses_post(sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter);
				echo wp_kses_post($before . get_the_time('d') . $after);
	
			} elseif ( is_month() ) {
				echo wp_kses_post(sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter);
				echo wp_kses_post($before . get_the_time('F') . $after);
	
			} elseif ( is_year() ) {
				echo wp_kses_post($before . get_the_time('Y') . $after);
	
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ($show_current == 1) {
						echo wp_kses_post($delimiter . $before . get_the_title() . $after);
					}
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $link_before . '<a ' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) {
						$cats = preg_replace('/ title="(.*?)"/', '', $cats);
					}
					echo wp_kses_post($cats);
					if ($show_current == 1) {
						echo wp_kses_post($before . get_the_title() . $after);
					}
				}
	
			} elseif ( is_attachment() ) {
				$parent = get_post($parent_id);
				$cat = get_the_category($parent->ID);
				if( isset($cat[0]) ){ 
					$cat = $cat[0];
				}
				if ($cat) {
					$cats = get_category_parents($cat, TRUE, $delimiter);
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) {
						$cats = preg_replace('/ title="(.*?)"/', '', $cats);
					}
					echo wp_kses_post($cats);
				}
				printf($link, get_permalink($parent), $parent->post_title);
				if ($show_current == 1) {
					echo wp_kses_post($delimiter . $before . get_the_title() . $after);
				}
	
			} elseif ( is_page() && !$parent_id ) {
				if ($show_current == 1) {
					echo wp_kses_post($before . get_the_title() . $after);
				}
	
			} elseif ( is_page() && $parent_id ) {
				if ($parent_id != $frontpage_id) {
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						if ($parent_id != $frontpage_id) {
							$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ($i = 0; $i < count($breadcrumbs); $i++) {
						echo wp_kses_post($breadcrumbs[$i]);
						if ($i != count($breadcrumbs)-1) {
							echo wp_kses_post($delimiter);
						}
					}
				}
				if ($show_current == 1) {
					if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) {
						echo wp_kses_post($delimiter);
					}
					echo wp_kses_post($before . get_the_title() . $after);
				}
	
			} elseif ( is_tag() ) {
				echo wp_kses_post($before . sprintf($text['tag'], single_tag_title('', false)) . $after);
	
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo wp_kses_post($before . sprintf($text['author'], $userdata->display_name) . $after);
	
			} elseif ( is_404() ) {
				echo wp_kses_post($before . $text['404'] . $after);
	
			} elseif ( has_post_format() && !is_singular() ) {
				echo get_post_format_string( get_post_format() );
				
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				if(is_archive()){
					echo wp_kses_post($before . get_the_archive_title() . $after);
				}else{
					$post_type = get_post_type_object(get_post_type());
					echo wp_kses_post($before . $post_type->labels->singular_name . $after);
				}				
	
			}
	
			if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || (is_single() && get_post_type() == 'post' && get_post_format() == 'video') || (is_single() && ( is_singular('vid_playlist') || is_singular('vid_channel') || is_singular('vid_actor') || is_singular('vid_director') )) ) echo ' (';
				echo esc_html__('Page', 'vidorev') . ' ' . get_query_var('paged');
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || (is_single() && get_post_type() == 'post' && get_post_format() == 'video') || (is_single() && ( is_singular('vid_playlist') || is_singular('vid_channel') || is_singular('vid_actor') || is_singular('vid_director') )) ) echo ')';
			}
	
			echo '</div></div></div></div>';
	
		}
		
		$output_string = ob_get_contents();
		ob_end_clean();
		
		$return = false;
		
		if(isset($args) && isset($args[0]) && $args[0]=true) {
			$return = true;
		}
		
		if(!$return){
			echo wp_kses_post($output_string);
			return;
		}else{
			return wp_kses_post($output_string);
		}
	}
endif;
add_action( 'vidorev_nav_breadcrumbs', 'vidorev_nav_breadcrumbs', 10 );

if( ! function_exists( 'vidorev_html_switch_mode' ) ):
	function vidorev_html_switch_mode($archive_style) {
		if($archive_style=='grid-default' || $archive_style=='list-default'){
	?>
		<div class="archive-switch-mode switch-mode-control">
			<div class="switch-icon grid-icon switch-control <?php if($archive_style=='grid-default'){echo 'active-item';} ?>">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div class="switch-icon list-icon switch-control <?php if($archive_style=='list-default'){echo 'active-item';} ?>">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	<?php
		}
	}
endif;
add_action( 'vidorev_html_switch_mode', 'vidorev_html_switch_mode', 10 );


if ( ! function_exists( 'vidorev_posted_on' ) ) :
	
	function vidorev_posted_on($args, $type = NULL) {
		
		if(!isset($args)) return;
		
		global $post;
		$author_id = $post->post_author;
		$post_id = $post->ID;
		
		$before = '<div class="entry-meta post-meta meta-font"><div class="post-meta-wrap">';
		$after = '</div></div>';
		
		$posted_on = '';
		
		$postMetaControl = vidorev_post_meta_control($type);
		
		$show_updated_time = '';
		$show_updated_time_text = '';
		if(isset($postMetaControl[6]) && $postMetaControl[6] === 'updated-date'){
			$show_updated_time = ' published';
			$show_updated_time_text = esc_html__('- LUD: ', 'vidorev');
		}
		
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <span class="updated%5$s">%6$s</span><time class="updated%5$s" datetime="%3$s">%4$s</time>';
		}
		
		if(vidorev_get_redux_option('datetime_format', 'default') == 'ago'){
			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( human_time_diff(get_the_time('U'), current_time('timestamp')) ).' '.esc_html__('ago', 'vidorev'),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( human_time_diff(get_the_modified_time('U'), current_time('timestamp')) ).' '.esc_html__('ago', 'vidorev'),
				$show_updated_time,
				$show_updated_time_text
			);
		}else{
			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() ),
				$show_updated_time,
				$show_updated_time_text
			);
		}
		
		if(isset($args[6]) && $args[6] === 'custom-meta-widget'){
			$post_meta_custom_block = '';
			$posted_on .= apply_filters('vidorev_custom_post_meta_for_widget', $post_meta_custom_block, $post_id);
		}
		
		if(isset($args[0]) && $args[0] === 'author' && $postMetaControl[0] === 'author' && is_numeric($author_id) && $author_id>0){
			$verify_user_html = '';
			if(function_exists('yz_is_account_verification_enabled') && yz_is_account_verification_enabled()){
				$is_account_verified = get_user_meta( $author_id, 'yz_account_verified', true );
				if($is_account_verified == 'on'){
					$verify_user_html = ' <span class="vd-user-verify fa fa-check-circle" aria-hidden="true"></span>';
					
				}
			}
			$posted_on .= '<div class="author vcard"><i class="fa fa-user-circle" aria-hidden="true"></i><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . $verify_user_html.'</a></div>';
		}
		
		if(isset($args[1]) && $args[1] === 'date-time' && $postMetaControl[1] === 'date-time'){
			$posted_on .= '<div class="date-time"><i class="fa fa-calendar" aria-hidden="true"></i><span>' . $time_string . '</span></div>';
		}
				
		if(isset($args[2]) && $args[2] === 'comment-count' && $postMetaControl[2] === 'comment-count'){
			$posted_on .= '<div class="comment-count"><i class="fa fa-comment" aria-hidden="true"></i><span>' . esc_html(apply_filters('vidorev_number_format', get_comments_number($post_id))) . '</span></div>';
		}
		
		if(isset($args[3]) && $args[3] === 'view-count' && $postMetaControl[3] === 'view-count' && function_exists('pvc_get_post_views')){
			$posted_on .= '<div class="view-count"><i class="fa fa-eye" aria-hidden="true"></i><span>' . esc_html(apply_filters('vidorev_number_format', pvc_get_post_views($post_id))) . '</span></div>';
		}
		
		$enable_like_dislike 	= vidorev_get_option('lk_enable_sys', 'like_dislike_settings', 'yes');
		$show_dislike 			= vidorev_get_option('lk_show_dislike', 'like_dislike_settings', 'yes');		
		
		if(function_exists('vidorev_get_like_count') && $enable_like_dislike=='yes' && isset($args[4]) && $args[4] === 'like-count' && $postMetaControl[4] === 'like-count'){
			$posted_on .= '<div class="like-count"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span class="like-count" data-id="'.esc_attr($post_id).'">'. esc_html(vidorev_get_like_count($post_id)) .'</span></div>';
		}
		
		if(function_exists('vidorev_get_dislike_count') && $enable_like_dislike=='yes' && $show_dislike=='yes' && isset($args[5]) && $args[5] === 'dislike-count' && $postMetaControl[5] === 'dislike-count'){
			$posted_on .= '<div class="dislike-count"><i class="fa fa-thumbs-down" aria-hidden="true"></i><span class="dislike-count" data-id="'.esc_attr($post_id).'">'. esc_html(vidorev_get_dislike_count($post_id)) .'</span></div>';
		}
		
		if($posted_on!=''){
			$posted_on_html = $before.$posted_on.$after;
			echo apply_filters( 'vidorev_posted_on_html', $posted_on_html );
		}

	}
endif;
add_action( 'vidorev_posted_on', 'vidorev_posted_on', 10, 2 );

if( ! function_exists( 'vidorev_thumbnail' ) ):
	function vidorev_thumbnail($size = 'thumbnail', $ratio='class-16x9', $wrapper = 1, $post_id = NULL, $ratio_case = NULL, $imdb_elms = 0){
		
		if($post_id==NULL){		
			$post_id = get_the_ID();
		}
		
		$post_type = get_post_type($post_id);
		
		if($post_type=='attachment'){
			$attachment_id = $post_id;
		}else{
			if(!has_post_thumbnail($post_id)){
				return '';
			}
			$attachment_id = get_post_thumbnail_id($post_id);				
		}
		
		global $theme_image_ratio;
		if(isset($theme_image_ratio) && $theme_image_ratio!='' && is_array($ratio_case)){
			switch($theme_image_ratio){
				case '16_9':
					if(isset($ratio_case['16_9'])){
						$size 	= $ratio_case['16_9']['size'];
						$ratio	= $ratio_case['16_9']['ratio'];
					}
					break;
					
				case '4_3':
					if(isset($ratio_case['4_3'])){
						$size 	= $ratio_case['4_3']['size'];
						$ratio	= $ratio_case['4_3']['ratio'];
					}
					break;
					
				case '2_3':
					if(isset($ratio_case['2_3'])){
						$size 	= $ratio_case['2_3']['size'];
						$ratio	= $ratio_case['2_3']['ratio'];
					}
					break;		
			}
		}
		
		
		if(defined('MOVIE_PM_PREFIX')){
			if($ratio == 'class-2x3'){
				$poster_img_id = get_post_meta( $post_id, MOVIE_PM_PREFIX.'poster_image_id', true );
				if(is_numeric($poster_img_id)){
					$attachment_id = $poster_img_id;
				}
			}
			
			$gif_img_id = get_post_meta( $post_id, MOVIE_PM_PREFIX.'gif_image_id', true );
			if(is_numeric($gif_img_id)){
				$attachment_id = $gif_img_id;
				$size = 'full';
			}
		}
		
		$picture_meta 	= wp_get_attachment_image_src($attachment_id, $size);
		if(!$picture_meta){
			return '';
		}
		
		$image_url 		= $picture_meta[0];
		
		$playlist_counting = '';
		if($post_type == 'vid_playlist' && defined('PLAYLIST_PM_PREFIX')){
			$playlist_videos = get_post_meta($post_id, PLAYLIST_PM_PREFIX.'videos', true);
			if(is_array($playlist_videos)){
				$playlist_counting.= '<span class="playlist-count font-size-12 meta-font"><i class="fa fa-play-circle" aria-hidden="true"></i><span>'.esc_attr(apply_filters('vidorev_number_format', count($playlist_videos))).' '.esc_html__('Videos', 'vidorev').'</span></span>';
			}
			$playlist_counting.= '<span class="playlist-count is-viewall font-size-12 meta-font"><i class="fa fa-play" aria-hidden="true"></i><span>'.esc_html__('Play All', 'vidorev').'</span></span>';
			if(function_exists('vidorev_get_link_playlist_all')){
				$playlist_all_link = trim(vidorev_get_link_playlist_all($post_id));
			}
		}elseif($post_type == 'vid_series' && class_exists('vidorev_series_settings')){
			$series_group = get_post_meta($post_id, 'video_series_group', true);
			$series_videos = 0;
			if(is_array($series_group)){
				foreach($series_group as $item_series){
					if(isset($item_series['videos']) && is_array($item_series['videos'])){
						$series_videos = $series_videos + count($item_series['videos']);
					}
				}
				$playlist_counting = '<span class="playlist-count font-size-12 meta-font"><i class="fa fa-play-circle" aria-hidden="true"></i><span>'.esc_attr(apply_filters('vidorev_number_format', $series_videos)).' '.esc_html__('Videos', 'vidorev').'</span></span>';
			}
		}elseif($post_type == 'vid_channel' && defined('CHANNEL_PM_PREFIX')){
			ob_start();
				do_action('vidorev_channel_sub_btn', $post_id, 'absolute-sub-btn');
			$playlist_counting = ob_get_contents();
			ob_end_clean();
		}
		
		global $post_type_add_param_to_url;
		global $vidorev_check_single_playlist;	
				
		if(isset($post_type_add_param_to_url) && ( ($post_type == 'vid_playlist' && defined('PLAYLIST_PM_PREFIX')) || (isset($_GET['playlist']) && is_numeric($_GET['playlist'])) || (isset($vidorev_check_single_playlist) && $vidorev_check_single_playlist=='playlist') ) ){	
			$old_post_type_add_param_to_url = $post_type_add_param_to_url;			
			if(vidorev_get_option('vid_playlist_hyperlink_action', 'vid_playlist_layout_settings', 'default') == 'only-title'){
				$post_type_add_param_to_url = NULL;
			}
		}
		
		$format_icon = '';
		$post_format = get_post_format($post_id);
		
		$before_img 	= '';
		$after_img 		= '';
				
		$before_img 	= 	'<div class="blog-pic">
								<div class="blog-pic-wrap'.esc_attr(apply_filters('vidorev_preview_control_class', '', $post_id, $post_type, $post_format)).'">';
									
		$before_url		=			'<a data-post-id="'.esc_attr($post_id).'" href="'.esc_url(vidorev_get_post_url($post_id)).'" title="'.esc_attr(the_title_attribute(array('echo'=>0, 'post'=>$post_id))).'" class="blog-img">';
		
		if(isset($playlist_all_link) && $playlist_all_link!=''){
			$before_url	=			'<a data-post-id="'.esc_attr($post_id).'" href="'.esc_url($playlist_all_link).'" title="'.esc_attr(the_title_attribute(array('echo'=>0, 'post'=>$post_id))).'" class="blog-img">';
		}
		
		$after_url		=			'</a>';
		
		$button_control	=			'';
		$duration_html	=			'';
		
		$after_img		= 	'	</div>
							</div>';
		
		$img			='';
		
		$post_image_lightbox = '';
		$blog_image_lightbox = vidorev_get_redux_option('blog_image_lightbox', 'off', 'switch');
		if($blog_image_lightbox == 'on' && $post_type == 'post' && ($post_format=='gallery' || $post_format=='0')){
			$picture_lightbox 	= wp_get_attachment_image_src($attachment_id, 'full');
			if($picture_lightbox){
				$post_image_lightbox = '<span class="img-lightbox-icon img-lightbox-icon-control" data-id="'.esc_attr($post_id).'" data-url="'.esc_url($picture_lightbox[0]).'"></span>';
			}
		}
		
		$preview_video = '';
		
		switch($post_format){
			case 'gallery':
				$format_icon='<span class="blog-post-format-icon"><i class="fa fa-picture-o"></i></span>';
				break;						
			case 'video':
				$watch_later_button = '';
				if(vidorev_get_redux_option('watch_enable', 'off', 'switch')=='on'){
					$small_picture = wp_get_attachment_image_src($attachment_id, 'thumbnail');
					$small_picture_url = $small_picture[0];
					
					$watch_later_active_class = '';
					
					global $watch_later_cookie;
					if(!isset($watch_later_cookie) || !is_array($watch_later_cookie)){
						$watch_later_cookie = array();
					}				
					
					if(array_search($post_id, $watch_later_cookie)!==false){
						$watch_later_active_class = 'active-item ';
					}
					
					$watch_later_button = '<span 
												class="'.esc_attr($watch_later_active_class).'watch-later-icon watch-later-control" 
												data-id="'.esc_attr($post_id).'" 
												data-img-src="'.esc_url($small_picture_url).'" 
												data-hyperlink="'.esc_url(get_permalink($post_id)).'" 
												data-title="'.esc_attr(get_the_title($post_id)).'"
											>
												<i class="fa fa-clock-o" aria-hidden="true"></i><span class="watch-text font-size-12">'.esc_html__('Watch Later', 'vidorev').'</span><span class="watch-remove-text font-size-12">'.esc_html__('Added', 'vidorev').'</span>
											</span>';
				}
				
				$format_icon		= '<span class="blog-post-format-icon"><i class="fa fa-play-circle-o"></i></span>';
				
				global $lightbox_video_ot;
				if(isset($lightbox_video_ot) && $lightbox_video_ot!=''){
					$lightbox_video_enb = $lightbox_video_ot;
				}else{
					$lightbox_video_enb = vidorev_get_redux_option('video_lightbox', 'on', 'switch');
					$lightbox_video_ot = $lightbox_video_enb;
				}
				$video_icon_html	= '';
				
				if($lightbox_video_enb=='on' && function_exists( 'vidorev_plugin_scripts' )){
					$video_lightbox_gallery = trim(vidorev_get_redux_option('video_lightbox_gallery', 'gallery'));
					if($video_lightbox_gallery == 'gallery'){
						$video_icon_html 	= '<span class="video-icon video-popup-control" data-id="'.esc_attr($post_id).'"></span>';
					}else{
						$video_icon_html 	= '<a class="video-icon" data-post-id="'.esc_attr($post_id).'" href="'.esc_url(vidorev_get_post_url($post_id)).'" title="'.esc_attr(the_title_attribute(array('echo'=>0, 'post'=>$post_id))).'">'.esc_html__('icon', 'vidorev').'</a>';
					}
				}	
				
				$vidorev_rating_average = vidorev_rating_average($post_id);					
				if($vidorev_rating_average!=''){
					$vidorev_rating_average = '<span class="rating-average-dr">'.$vidorev_rating_average.' <i class="fa fa-star" aria-hidden="true"></i></span>';
				}		
				
				$duration_html 		= '<span class="duration-text font-size-12 meta-font">'.esc_html(get_post_meta($post_id, 'vm_duration', true)).$vidorev_rating_average.'</span>';
				
				$output_imdb = '';
				if($imdb_elms == 1){
					ob_start();					
						do_action ( 'vidorev_IMDb_ratings_html' );					
					$output_imdb = ob_get_contents();
					ob_end_clean();	
				}
				
				$video_tags	= '';
				$meta_vid_tags = get_post_meta($post_id, 'vid_tags', true);
				if(is_array($meta_vid_tags) && count($meta_vid_tags)>0){
					$tag_items = get_tags(array('hide_empty'=>false, 'include' => $meta_vid_tags));
					if($tag_items){						
						$tags_html = array();						
						foreach ( $tag_items as $tag_details ) :
							array_push($tags_html, '<a href="'.esc_url(get_term_link($tag_details->term_id)).'" title="'.esc_attr($tag_details->name).'" class="category-item m-font-size-10">' . esc_html($tag_details->name) . '</a>');							
						endforeach;							
						$video_tags = '<div class="categories-elm tags-absolute meta-font"><div class="categories-wrap">'.join( '', $tags_html ).'</div></div>';			
					}
				}
				
				$button_control		= $video_tags.$video_icon_html.$output_imdb.$watch_later_button.$duration_html;				
				
				$preview_video 		= apply_filters('vidorev_preview_action_control', '', $post_id, $post_type, $post_format, $size, $ratio, $wrapper, $ratio_case, $imdb_elms);
				
				break;
			case 'audio':
				$format_icon='<span class="blog-post-format-icon"><i class="fa fa-volume-up"></i></span>';
				break;
			case 'quote':
				$format_icon='<span class="blog-post-format-icon"><i class="fa fa-quote-right"></i></span>';
				break;
		}
		
		if(function_exists('wp_get_attachment_image_srcset')){
			
			$lazyload			= vidorev_get_redux_option('lazyload', 'off', 'switch');
			$normal_img_effect 	= vidorev_get_redux_option('normal_img_effect', 'off', 'switch');
			$placeholder 		= '';
			$placeholder_bg		= '';
			$classLazy 			= '';
			
			if($wrapper==7){
				$lazyload = 'off';
				$normal_img_effect = 'off';
			}
			
			if($lazyload=='on'){
				$classLazy = 'ul-lazysizes-effect ul-lazysizes-load';					
				$placeholder 	= get_template_directory_uri().'/img/placeholder.png';
				$placeholder_bg = '<span class="ul-placeholder-bg '.esc_attr($ratio).'"></span>';	
			}elseif($lazyload != 'on' && $normal_img_effect == 'on'){				
				$classLazy 		= 'ul-normal-effect';
				$placeholder_bg = '<span class="ul-placeholder-bg '.esc_attr($ratio).'"></span>';	
			}else{
				$classLazy 		= 'ul-normal-classic';
				$placeholder_bg = '<span class="ul-placeholder-bg '.esc_attr($ratio).'"></span>';	
			}
			
			if($wrapper==7){
				$placeholder_bg = '';				
			}
			
			$image_srcset 			= wp_get_attachment_image_srcset($attachment_id, $size);
			$image_sizes 			= wp_get_attachment_image_sizes($attachment_id, $size);				
			$html_image_url 		= $image_url!=''?($lazyload=='on'?' src="'.esc_url($placeholder).'" data-src="'.esc_url($image_url).'"':' src="'.esc_url($image_url).'"'):'';
			
			$html_image_responsive 	= ($image_srcset!=''&&$image_sizes!='')?($lazyload=='on'?' data-srcset="'.esc_attr($image_srcset).'" data-sizes="'.esc_attr($image_sizes).'"':' srcset="'.esc_attr($image_srcset).'" sizes="'.esc_attr($image_sizes).'"'):'';							
			$print_html_image 		= $html_image_url!=''?'<img class="blog-picture '.esc_attr($classLazy).'"'.$html_image_url.$html_image_responsive.' alt="'.esc_attr(get_the_title($attachment_id)).'"/>'.$placeholder_bg:'';	
			
			$img = $print_html_image;
		} else {
			$img = wp_get_attachment_image($attachment_id, $size);
		}
		
		if(isset($old_post_type_add_param_to_url)){
			$post_type_add_param_to_url = $old_post_type_add_param_to_url;
		}
		
		switch($wrapper){
			case 1:
				$img_html = $before_img.$before_url.$img.$preview_video.$after_url.$button_control.$playlist_counting.$post_image_lightbox.$after_img;
				echo apply_filters( 'vidorev_featured_image_html_one', $img_html );
				break;
				
			case 2:
				$img_html = $before_url.$img.$preview_video.$after_url.$button_control.$playlist_counting.$post_image_lightbox;
				echo apply_filters( 'vidorev_featured_image_html_two', $img_html );
				break;
				
			case 3:
				$img_html = $before_url.$img.$after_url;
				echo apply_filters( 'vidorev_featured_image_html_three', $img_html );
				break;
				
			case 4:				
				$img_html = esc_url($image_url);
				echo apply_filters( 'vidorev_featured_image_html_four', $img_html );
				break;
			
			case 5:				
				$img_html = $before_url.$img.$after_url.$duration_html;
				echo apply_filters( 'vidorev_featured_image_html_five', $img_html );
				break;	
				
			case 6:
				$img_html = '<a href="#" class="video-popup-control" data-id="'.esc_attr($post_id).'">'.$img.'</a>'.$duration_html;				
				echo apply_filters( 'vidorev_featured_image_html_six', $img_html );
				break;
				
			case 7:
				$img_html = $img;				
				echo apply_filters( 'vidorev_featured_image_html_seven', $img_html );
				break;		
				
			default:
				$img_html = $before_img.$before_url.$img.$preview_video.$after_url.$button_control.$playlist_counting.$post_image_lightbox.$after_img;
				echo apply_filters( 'vidorev_featured_image_html_eight', $img_html );				
		}
	}
endif;
add_action( 'vidorev_thumbnail', 'vidorev_thumbnail', 10, 6 );

if( ! function_exists( 'vidorev_no_thumbnail' ) ):
	function vidorev_no_thumbnail($ratio='class-16x9', $post_id = NULL){
		global $theme_image_ratio;
		if(isset($theme_image_ratio) && $theme_image_ratio!=''){
			return '';
		}
		
		if($post_id==NULL){		
			$post_id = get_the_ID();
		}

		if(!has_post_thumbnail($post_id)){
			echo 	'<div class="blog-pic">
						<div class="blog-pic-wrap">
							<a data-post-id="'.esc_attr($post_id).'" href="'.esc_url(vidorev_get_post_url($post_id)).'" title="'.esc_attr(the_title_attribute(array('echo'=>0, 'post'=>$post_id))).'" class="blog-img">
								<img class="blog-picture" src="'.esc_url(get_template_directory_uri().'/img/no-image-'.$ratio.'.png').'" alt="'.esc_attr(get_the_title($post_id)).'"/>
							</a>
						</div>
					</div>';
		}				
	}
endif;
add_action( 'vidorev_no_thumbnail', 'vidorev_no_thumbnail', 10, 2 );

if ( ! function_exists( 'vidorev_facebook_comment' ) ) :
	function vidorev_facebook_comment(){
		$vid_facebook_comments_numposts = trim(vidorev_get_option('vid_facebook_comments_numposts', 'vid_facebook_comments_settings', 10));
		$vid_facebook_comments_order_by = trim(vidorev_get_option('vid_facebook_comments_order_by', 'vid_facebook_comments_settings', 'social'));		
		
		$comment_colorscheme = 'light';				
		$color_mode = vidorev_get_redux_option('color_mode', 'white');					
		if ( $color_mode == 'dark' ) {
			$comment_colorscheme = 'dark';
		}
	?>
		<div class="facebook-comment" id="vidorev_facebook_comment">
			<div id="fb-root"></div>
			<div class="fb-comments" data-href="<?php echo esc_url(vidorev_get_post_url()); ?>" data-width="auto" data-numposts="<?php echo esc_attr($vid_facebook_comments_numposts)?>" data-order-by="<?php echo esc_attr($vid_facebook_comments_order_by)?>" data-colorscheme="<?php echo esc_attr($comment_colorscheme);?>"></div>
		</div>
	<?php	
	}
endif;
add_action( 'vidorev_facebook_comment', 'vidorev_facebook_comment', 10, 1 );

if ( ! function_exists( 'vidorev_category_element' ) ) :
	function vidorev_category_element($post_id = NULL, $type = NULL){
		
		if($post_id==NULL){		
			$post_id = get_the_ID();
		}
		
		$post_type = get_post_type($post_id);
		
		if($post_type == 'vid_playlist' || $post_type == 'vid_channel' || $post_type == 'vid_actor' || $post_type == 'vid_director' || $post_type == 'vid_series'){			
			
			if(vidorev_get_option($post_type.'_display_cat', $post_type.'_layout_settings', 'no') == 'no'){
				return;
			}
			
			$taxs = array();		
			
			$terms = get_the_terms( $post_id, $post_type.'_cat' );
			
			if ( $terms && !is_wp_error( $terms ) ){				
				foreach ( $terms as $term ) {
					array_push($taxs, '<a data-tax-id="tax_'.esc_attr($term->term_id).'" href="'.esc_url(get_term_link($term->term_id)).'" title="'.esc_attr($term->name).'" class="category-item m-font-size-10">' . esc_html($term->name) . '</a>');
				}
				
				$cats_elm = '<div class="categories-elm meta-font custom-tax"><div class="categories-wrap">'.join( '', $taxs ).'</div></div>';
				echo apply_filters( 'vidorev_taxonomy_html', $cats_elm );
			}
			
			return;
		
		}
		
		global $category_element_template;
		
		if(vidorev_categories_control($type)!='on' || (isset($category_element_template) && $category_element_template=='off')){
			return '';
		}
		
		$cats_html = '';
		$cats_elm = '';	
		
		if(vidorev_channel_replace_category() == 'on' && $post_type=='post' && get_post_format($post_id)=='video' /*&& (is_page() || is_category())*/ ){
			$channel_id	= beeteam368_get_channel_by_post_id($post_id);
			
			if($channel_id > 0){				
				$channel_title = get_the_title($channel_id);				
				$cats_elm = '<div class="categories-elm meta-font"><div class="categories-wrap"><a data-cat-id="cat_0" href="'.esc_url(get_permalink($channel_id)).'" title="'.esc_attr($channel_title).'" class="category-item m-font-size-10">'.esc_html($channel_title).'</a></div></div>';
				echo apply_filters( 'vidorev_taxonomy_html', $cats_elm );
				return '';
			}
		}
			
		$categories = get_the_category($post_id);
		if($categories){
			foreach( $categories as $category ) {
				$cat_id 	= $category->term_id;
				$cat_name 	= $category->name;
				$cats_html	.= '<a data-cat-id="cat_'.esc_attr($cat_id).'" href="'.esc_url(get_category_link($cat_id)).'" title="'.esc_attr($cat_name).'" class="category-item m-font-size-10">'.esc_html($cat_name).'</a>';
			}
			
			if($cats_html!=''){
				$cats_elm = '<div class="categories-elm meta-font"><div class="categories-wrap">'.$cats_html.'</div></div>';
			}
			
			echo apply_filters( 'vidorev_taxonomy_html', $cats_elm );
		}
		
	}
endif;
add_action( 'vidorev_category_element', 'vidorev_category_element', 10, 2 );

if ( ! function_exists( 'vidorev_excerpt_element' ) ) :
	function vidorev_excerpt_element($post_id = NULL){
		
		global $excerpt_element_template;
		
		if(vidorev_get_redux_option('blog_show_excerpt', 'on', 'switch')!='on' || (isset($excerpt_element_template) && $excerpt_element_template=='off')){
			return;
		}
		
		if($post_id==NULL){		
			$post_id = get_the_ID();
		}
		
		$excerpt_length = apply_filters( 'vidorev_excerpt_length', 132 );
				
		$excerpt = trim(strip_shortcodes(strip_tags(get_the_excerpt($post_id))));
		
		if($excerpt!='' && strlen($excerpt) > $excerpt_length ){
			$limit_excerpt = mb_substr($excerpt, 0, $excerpt_length, 'UTF-8');
			$limit_excerpt = trim(preg_replace('/\s+/', ' ', $limit_excerpt));
			
			echo '<div class="entry-content post-excerpt">'.$limit_excerpt.'...</div>';
			return ;
		}
		
		if($excerpt!=''){
			echo '<div class="entry-content post-excerpt">'.$excerpt.'</div>';
		}		
	}
endif;
add_action( 'vidorev_excerpt_element', 'vidorev_excerpt_element', 10, 1 );

if ( ! function_exists( 'vidorev_pagination' ) ) :
function vidorev_pagination($template = 'template-parts/content', $style = 'list-blog', $overwrite = NULL) {
	
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	
	echo '<div class="blog-pagination blog-pagination-control">';
	
		$pag_type = vidorev_get_redux_option('blog_pag_type', 'wp-default');
	
		if(is_search()){
			$pag_type = vidorev_get_redux_option('search_pag_type', 'wp-default');
		}elseif(is_post_type_archive('vid_playlist') || is_tax('vid_playlist_cat')){
			$pag_type = vidorev_get_option('vid_playlist_pag_type', 'vid_playlist_layout_settings', 'wp-default');
		}elseif(is_post_type_archive('vid_channel') || is_tax('vid_channel_cat')){
			$pag_type = vidorev_get_option('vid_channel_pag_type', 'vid_channel_layout_settings', 'wp-default');
		}elseif(is_post_type_archive('vid_actor') || is_tax('vid_actor_cat')){
			$pag_type = vidorev_get_option('vid_actor_pag_type', 'vid_actor_layout_settings', 'wp-default');
		}elseif(is_post_type_archive('vid_director') || is_tax('vid_director_cat')){
			$pag_type = vidorev_get_option('vid_director_pag_type', 'vid_director_layout_settings', 'wp-default');
		}elseif(is_post_type_archive('vid_series') || is_tax('vid_series_cat')){
			$pag_type = vidorev_get_option('vid_series_pag_type', 'vid_series_layout_settings', 'wp-default');
		}elseif(is_author()){
			$pag_type = vidorev_get_redux_option('author_pag_type', 'wp-default');			
		}
		
		if(isset($overwrite) && $overwrite!=NULL && $overwrite !=''){
			$pag_type = $overwrite;
		}	
		
		$pag_type = apply_filters('vidorev_pagination_type', $pag_type);
	
		switch($pag_type){
			case 'wp-default':	
				vidorev_pagination_default();			
				break;
				
			case 'loadmore-btn':
				vidorev_pagination_loadmore_btn($template, $style);		
				break;	
				
			case 'pagenavi_plugin':
				if( ! function_exists( 'wp_pagenavi' ) ) {						
					vidorev_pagination_default(); 
				} else {
					echo '<div class="wp-pagenavi-wrapper h6">';
						wp_pagenavi();
					echo '</div>';
				}
				break;
			case 'infinite-scroll':
				vidorev_pagination_infinite_scroll($template, $style);
				break;
			
			default:
				vidorev_pagination_default();
				break;
		}

	echo '</div>';
}
endif;
add_action( 'vidorev_pagination', 'vidorev_pagination', 10, 3 );

if ( ! function_exists( 'vidorev_pagination_default' ) ) :
	function vidorev_pagination_default(){
		
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		
		?>
		
		<nav class="pagination-default">
	
			<?php if ( get_next_posts_link() ) : ?>
			<div class="prev-content"><?php next_posts_link( '<span class="prev-icon">&larr;</span>'.esc_html__( ' Previous', 'vidorev') ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="next-content"><?php previous_posts_link( esc_html__( 'Next ', 'vidorev').'<span class="next-icon">&rarr;</span>' ); ?></div>
			<?php endif; ?>
	
		</nav>

		<?php
	}
endif;

if ( ! function_exists( 'vidorev_pagination_loadmore_btn' ) ) :
	function vidorev_pagination_loadmore_btn($template = 'template-parts/content', $style = 'list-blog'){
		
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		
		?>
		
		<nav class="pagination-loadmore">
	
			<a href="#" class="basic-button basic-button-default loadmore-btn-style loadmore-btn-control" title="<?php echo esc_attr__( 'Load more', 'vidorev'); ?>" data-template="<?php echo esc_attr($template); ?>" data-style="<?php echo esc_attr($style); ?>">
				<span class="loadmore-text">
					<?php echo esc_html__( 'Load more', 'vidorev'); ?>
				</span>
				<span class="loadmore-loading">
					<span class="loadmore-indicator"> 
						<svg>
							<polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
							<polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
						</svg>
					</span>
				</span>
			</a>			
	
		</nav>

		<?php
	}
endif;

if ( ! function_exists( 'vidorev_pagination_infinite_scroll' ) ) :
	function vidorev_pagination_infinite_scroll($template = 'template-parts/content', $style = 'list-blog'){
		
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		
		?>
		
		<nav class="pagination-infinite">
	
			<div class="infinite-scroll-style infinite-scroll-control" data-template="<?php echo esc_attr($template); ?>" data-style="<?php echo esc_attr($style); ?>">
				<div class="infinite-la-fire">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>			
	
		</nav>

		<?php
	}
endif;

if ( ! function_exists( 'vidorev_single_post_breadcrumbs' ) ) :
	function vidorev_single_post_breadcrumbs( $position = 'basic'){
		
		$post_format = get_post_format();
		$single_style = vidorev_single_style();
		$post_type = get_post_type();
		
		if($post_type == 'vid_actor' || $post_type == 'vid_director' || $post_type == 'vid_playlist' || $post_type == 'vid_channel' || $post_type == 'vid_series'){
			if($post_type == 'vid_channel' && $position!='full-width'){
				return '';
			}
			do_action( 'vidorev_nav_breadcrumbs' );
		}else{
			if( 
				($position == 'basic' && ($single_style == 'full-width' || $single_style == 'special'))  
			){
				echo '';
				return;
			}
			do_action( 'vidorev_nav_breadcrumbs' );
		}		
	}
endif;
add_action( 'vidorev_single_post_breadcrumbs', 'vidorev_single_post_breadcrumbs', 10, 1 );

if ( ! function_exists( 'vidorev_single_post_title' ) ) :
	function vidorev_single_post_title( $position = 'basic', $extra_class = '' ){
		
		$post_format = get_post_format();
		$single_style = vidorev_single_style();
		$post_type = get_post_type();
		
		if($post_type == 'vid_actor' || $post_type == 'vid_director'){?>
			<header class="entry-header dark-background movie-style">
				<div class="pp-wrapper">
				
					<div class="pp-image"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_single_actor_director_image_size', 'vidorev_thumb_2x3_0x'), apply_filters('vidorev_custom_single_actor_director_image_ratio', 'class-2x3'), 1, NULL, NULL);?></div>
					
					<div class="pp-content-wrapper">
					
						<div class="entry-meta post-meta meta-font">
							<div class="post-meta-wrap">
								<div>
									<span><?php if($post_type == 'vid_actor'){ echo apply_filters('vidorev_actor_heading_title', esc_html__('Actor', 'vidorev')); }elseif($post_type == 'vid_director'){ echo apply_filters('vidorev_director_heading_title', esc_html__('Director', 'vidorev')); }?></span>
								</div>
							</div>
						</div>
							
						<?php the_title( '<h1 class="entry-title extra-bold h6-mobile '.$extra_class.'">', '</h1>' ); ?>			
						<?php do_action( 'vidorev_posted_on', array('', '', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'single' ); ?>		
						
						<div class="entry-meta post-meta meta-font">
							<div class="post-meta-wrap">
								<div>
									<i class="fa fa-file-video-o" aria-hidden="true"></i><a class="scroll-elm-control" href="#sec_FILMOGRAPHY" title="<?php esc_attr_e('Filmography', 'vidorev');?>"><?php if($post_type == 'vid_actor'){ echo apply_filters('vidorev_actor_filmography_head_title', esc_html__('Filmography', 'vidorev')); }elseif($post_type == 'vid_director'){ echo apply_filters('vidorev_director_filmography_head_title', esc_html__('Filmography', 'vidorev')); }?></a>
								</div>
							</div>
						</div>
										
					</div>
				</div>
			</header>	
		<?php 
		}elseif($post_type == 'vid_playlist'){
		?>
			<header class="entry-header">		
				<?php do_action( 'vidorev_category_element', NULL, 'single' );?>
				<?php the_title( '<h1 class="entry-title extra-bold '.esc_attr($extra_class).'">', apply_filters('vidorev_front_end_edit_post', get_the_ID()).'</h1>' ); ?>			
				<?php do_action( 'vidorev_posted_on', array('author', 'date-time', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'single' ); ?>
			</header>
		<?php
		}elseif($post_type == 'vid_series'){
		?>
			<header class="entry-header">	
				<div class="header-single-with-image">	
					<div class="header-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_single_series_image_size', 'thumbnail'), apply_filters('vidorev_custom_single_series_image_ratio', 'class-1x1'), 3, NULL); ?></div>
					<div class="header-content">
						<?php do_action( 'vidorev_category_element', NULL, 'single' );?>
						<?php do_action( 'vidorev_IMDb_ratings_html' );?>		
						<?php the_title( '<h1 class="entry-title extra-bold '.esc_attr($extra_class).'">', '</h1>' ); ?>			
						<?php do_action( 'vidorev_posted_on', array('author', 'date-time', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'single' ); ?>	
					</div>	
				</div>
				<?php do_action( 'vidorev_director_single_html', -1 );?>
				<?php do_action( 'vidorev_actor_single_html', -1 );?>
                <?php do_action( 'vidorev_tmdb_tv_single_block_html');?>
			</header>	
		<?php	
		}elseif($post_type == 'vid_channel'){
			global $wp;
			$current_url 	= home_url( $wp->request );			
			$pos_paged 		= strpos($current_url , '/page/');
			
			if($pos_paged!==FALSE){
				$current_url 	= trailingslashit(substr($current_url, 0, $pos_paged));
			}
			
			$tab_settings = array();
			
			if(vidorev_get_option('vid_video_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_video_tab_order = vidorev_get_option('vid_video_tab_order', 'vid_channel_tab_settings', 1);
				$vid_video_tab_order = is_numeric($vid_video_tab_order)?$vid_video_tab_order:1;
				if(!isset($tab_settings[$vid_video_tab_order])){
					$tab_settings[$vid_video_tab_order] = 'vid_video_tab';
				}else{
					$tab_settings[$vid_video_tab_order+count($tab_settings)+1] = 'vid_video_tab';
				}
			}
			
			if(vidorev_get_option('vid_playlist_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_playlist_tab_order = vidorev_get_option('vid_playlist_tab_order', 'vid_channel_tab_settings', 2);
				$vid_playlist_tab_order = is_numeric($vid_playlist_tab_order)?$vid_playlist_tab_order:2;				
				if(!isset($tab_settings[$vid_playlist_tab_order])){
					$tab_settings[$vid_playlist_tab_order] = 'vid_playlist_tab';
				}else{
					$tab_settings[$vid_playlist_tab_order+count($tab_settings)+1] = 'vid_playlist_tab';
				}
			}
			
			if(vidorev_get_option('vid_series_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_series_tab_order = vidorev_get_option('vid_series_tab_order', 'vid_channel_tab_settings', 3);
				$vid_series_tab_order = is_numeric($vid_series_tab_order)?$vid_series_tab_order:3;
				if(!isset($tab_settings[$vid_series_tab_order])){
					$tab_settings[$vid_series_tab_order] = 'vid_series_tab';
				}else{
					$tab_settings[$vid_series_tab_order+count($tab_settings)+1] = 'vid_series_tab';
				}
			}
			
			if(vidorev_get_option('vid_about_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_about_tab_order = vidorev_get_option('vid_about_tab_order', 'vid_channel_tab_settings', 4);
				$vid_about_tab_order = is_numeric($vid_about_tab_order)?$vid_about_tab_order:4;
				if(!isset($tab_settings[$vid_about_tab_order])){
					$tab_settings[$vid_about_tab_order] = 'vid_about_tab';
				}else{
					$tab_settings[$vid_about_tab_order+count($tab_settings)+1] = 'vid_about_tab';
				}
			}
			
			if(vidorev_get_option('vid_community_tab', 'vid_channel_tab_settings', 'yes') == 'yes'){
				$vid_community_tab_order = vidorev_get_option('vid_community_tab_order', 'vid_channel_tab_settings', 5);
				$vid_community_tab_order = is_numeric($vid_community_tab_order)?$vid_community_tab_order:5;
				if(!isset($tab_settings[$vid_community_tab_order])){
					$tab_settings[$vid_community_tab_order] = 'vid_community_tab';
				}else{
					$tab_settings[$vid_community_tab_order+count($tab_settings)+1] = 'vid_community_tab';
				}
			}
			
			ksort($tab_settings);
			
			$tab_settings = array_values($tab_settings);
			
			$ac_tab_video 		= '';
			$ac_tab_playlist 	= 'black-style';
			$ac_tab_series 		= 'black-style';
			$ac_tab_about 		= 'black-style';
			$ac_tab_community 	= 'black-style';
			
			if(isset($tab_settings[0])){
				if($tab_settings[0] == 'vid_video_tab'){
					$ac_tab_video 		= '';
					$ac_tab_playlist 	= 'black-style';
					$ac_tab_series 		= 'black-style';
					$ac_tab_about 		= 'black-style';
					$ac_tab_community 	= 'black-style';
				}elseif($tab_settings[0] == 'vid_playlist_tab'){
					$ac_tab_video 		= 'black-style';
					$ac_tab_playlist 	= '';
					$ac_tab_series 		= 'black-style';
					$ac_tab_about 		= 'black-style';
					$ac_tab_community 	= 'black-style';
				}elseif($tab_settings[0] == 'vid_series_tab'){
					$ac_tab_video 		= 'black-style';
					$ac_tab_playlist 	= 'black-style';
					$ac_tab_series 		= '';
					$ac_tab_about 		= 'black-style';
					$ac_tab_community 	= 'black-style';
				}elseif($tab_settings[0] == 'vid_about_tab'){
					$ac_tab_video 		= 'black-style';
					$ac_tab_playlist 	= 'black-style';
					$ac_tab_series 		= 'black-style';
					$ac_tab_about 		= '';
					$ac_tab_community 	= 'black-style';
				}elseif($tab_settings[0] == 'vid_community_tab'){
					$ac_tab_video 		= 'black-style';
					$ac_tab_playlist 	= 'black-style';
					$ac_tab_series 		= 'black-style';
					$ac_tab_about 		= 'black-style';
					$ac_tab_community 	= '';
				}
			}
			
			if(isset($_GET['channel_tab'])){
				$channel_tab = sanitize_text_field(trim($_GET['channel_tab']));
				switch($channel_tab){
					case 'video':
						$ac_tab_video 		= '';
						$ac_tab_playlist 	= 'black-style';
						$ac_tab_series 		= 'black-style';
						$ac_tab_about 		= 'black-style';
						$ac_tab_community 	= 'black-style';
						break;
						
					case 'playlist':
						$ac_tab_video 		= 'black-style';
						$ac_tab_playlist 	= '';
						$ac_tab_series 		= 'black-style';
						$ac_tab_about 		= 'black-style';
						$ac_tab_community 	= 'black-style';
						break;
						
					case 'series':
						$ac_tab_video 		= 'black-style';
						$ac_tab_playlist 	= 'black-style';
						$ac_tab_series 		= '';
						$ac_tab_about 		= 'black-style';
						$ac_tab_community 	= 'black-style';
						break;
						
					case 'about':
						$ac_tab_video 		= 'black-style';
						$ac_tab_playlist 	= 'black-style';
						$ac_tab_series 		= 'black-style';
						$ac_tab_about 		= '';
						$ac_tab_community 	= 'black-style';
						break;
						
					case 'community':
						$ac_tab_video 		= 'black-style';
						$ac_tab_playlist 	= 'black-style';
						$ac_tab_series 		= 'black-style';
						$ac_tab_about 		= 'black-style';
						$ac_tab_community 	= '';
						break;			
				}
			}
		?>
			<header class="entry-header channel-header">								
				<div class="header-single-with-image">
					<?php 
					if(defined('CHANNEL_PM_PREFIX')){
						$channel_logo = get_post_meta( get_the_ID(), CHANNEL_PM_PREFIX.'logo_id', true );
						if(is_numeric($channel_logo)){
							$channel_logo_meta = wp_get_attachment_image_src($channel_logo, 'vidorev_thumb_1x1_2x');
							if($channel_logo_meta){
							?>
								<div class="header-img"><img src="<?php echo esc_url($channel_logo_meta[0])?>" alt="<?php esc_attr_e('Channel Logo', 'vidorev');?>"></div>
							<?php	
							}							
						}
					}
					?>
					<div class="header-content">
						<?php do_action( 'vidorev_category_element', NULL, 'single' );?>
						<?php the_title( '<h1 class="entry-title extra-bold '.esc_attr($extra_class).'">', apply_filters('vidorev_front_end_edit_post', get_the_ID()).'</h1>' ); ?>			
						<?php do_action( 'vidorev_posted_on', array('author', 'date-time', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'single' ); ?>
						<?php do_action( 'vidorev_channel_sub_btn', get_the_ID(), ''); ?>
					</div>	
				</div>				
			</header>
			
            <?php do_action( 'vidorev_above_channel_ads', true );?>
            
            <?php if(count($tab_settings) > 1){?>            
                <div class="listing-types">
                    <div class="listing-types-content">
                    	<?php 
						foreach($tab_settings as $value){
							switch($value){
								case 'vid_video_tab':
									?>
                                    <a href="<?php echo esc_url(add_query_arg(array('channel_tab' => 'video'), $current_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_video);?>">
                                        <i class="fa fa-play-circle" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Videos', 'vidorev');?>
                                    </a>
                                    <?php
									break;
								
								case 'vid_playlist_tab':
									?>
                                    <a href="<?php echo esc_url(add_query_arg(array('channel_tab' => 'playlist'), $current_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_playlist);?>">
                                        <i class="fa fa-bars" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Playlists', 'vidorev');?>
                                    </a>
                                    <?php
									break;
									
								case 'vid_series_tab':
									?>
                                    <a href="<?php echo esc_url(add_query_arg(array('channel_tab' => 'series'), $current_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_series);?>">
                                        <i class="fa fa-film" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Series', 'vidorev');?>
                                    </a>
                                    <?php
									break;
									
								case 'vid_about_tab':
									?>
                                    <a href="<?php echo esc_url(add_query_arg(array('channel_tab' => 'about'), $current_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_about);?>">
                                        <i class="fa fa-id-card" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('About', 'vidorev');?>
                                    </a>
                                    <?php
									break;
									
								case 'vid_community_tab':
									?>
                                    <a href="<?php echo esc_url(add_query_arg(array('channel_tab' => 'community'), $current_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_community);?>">
                                        <i class="fa fa-comment" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Community', 'vidorev');?>
                                    </a>
                                    <?php
									break;					
							}
						}
						?>                    					
                    </div>
                </div>
		<?php	
			}
		}else{
			if(
				($position == 'basic' && ($single_style == 'special' || $single_style == 'full-width') && $post_format == '0') ||
				($position == 'basic' && $single_style == 'special' && $post_format != '0')		
			){
				
				if($single_style == 'special'){
					do_action( 'vidorev_special_author_box');
					do_action( 'vidorev_amazon_ads_html');
					do_action( 'vidorev_director_single_html', -1 );
					do_action( 'vidorev_actor_single_html', -1 );
					do_action( 'vidorev_tmdb_single_block_html');
					do_action( 'vidorev_tmdb_tv_single_block_html');
				}
				return;
			}
		?>
			<header class="entry-header">		
				<?php do_action( 'vidorev_category_element', NULL, 'single' );?>	
				<?php do_action( 'vidorev_IMDb_ratings_html' );?>	
				<?php the_title( '<h1 class="entry-title extra-bold '.esc_attr($extra_class).'">', apply_filters('vidorev_front_end_edit_post', get_the_ID()).'</h1>' ); ?>			
				<?php do_action( 'vidorev_posted_on', array('author', 'date-time', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'single' ); ?>	
				
				<?php if($single_style != 'special'){
					do_action( 'vidorev_special_author_box');
					do_action( 'vidorev_amazon_ads_html');
					do_action( 'vidorev_director_single_html', -1 );
					do_action( 'vidorev_actor_single_html', -1 );
					do_action( 'vidorev_tmdb_single_block_html');
					do_action( 'vidorev_tmdb_tv_single_block_html');
				}?>
			</header>

		<?php 
		}
	}
endif;
add_action( 'vidorev_single_post_title', 'vidorev_single_post_title', 10, 2 );

if ( ! function_exists( 'vidorev_count_channel_subscribed' ) ) :
	function vidorev_count_channel_subscribed( $channel_data ) {
			
		global $wpdb;		
		$count = 	$wpdb->get_var( 
						$wpdb->prepare(
							"SELECT COUNT(*) FROM $wpdb->usermeta WHERE meta_value = %s;", $channel_data
						)
					);		
		return $count;
	}
endif;

if ( ! function_exists( 'vidorev_channel_sub_btn' ) ) :
	function vidorev_channel_sub_btn($channel_id, $extra_class){
		if(!defined('CHANNEL_PM_PREFIX') || vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')!='yes' || !isset($channel_id) || $channel_id == 0 || get_post_type($channel_id) != 'vid_channel'){
			return;
		}
		
		$class_subscribe 	= '';
		$prefix_channel_sub = 'channel_sub_';
		$channel_data 		= $prefix_channel_sub.$channel_id;
		$dataLogin			= 'none';
		
		if(is_user_logged_in()){			
			$current_user 		= wp_get_current_user();
			$user_id 			= (int)$current_user->ID;		
			$meta_id			= $channel_data.'_'.$user_id;
			$current_sub 		= get_the_author_meta($meta_id, $user_id);
			$dataLogin			= 'true';
			
			if($current_sub == $channel_data){
				$class_subscribe = 'channel-subscribed';
			}
		}
		
		$subscribed_count = vidorev_count_channel_subscribed($channel_data);
		if($subscribed_count == 0){
			$subscribed_count = '';
		}
		
		$r_subscribed_count = $subscribed_count == 0?'':apply_filters('vidorev_number_format', $subscribed_count);
	?>
		<a href="javascript:;" data-login="<?php echo esc_attr($dataLogin)?>" class="basic-button basic-button-default channel-subscribe subscribe-control <?php echo esc_attr($class_subscribe);?> <?php echo isset($extra_class)?esc_attr($extra_class):''?>" data-channel-id="<?php echo esc_attr($channel_id);?>">
			<span class="subscribe"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Subscribe', 'vidorev');?></span>
			<span class="subscribed"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Subscribed', 'vidorev');?></span>
			<span class="loadmore-loading">
				<span class="loadmore-indicator"> 
					<svg>
						<polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
						<polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
					</svg>
				</span>
			</span>
			<span class="subscribed-count subscribed-count-control"><?php echo esc_html($r_subscribed_count);?></span>
		</a>	
	<?php	
	}
endif;
add_action( 'vidorev_channel_sub_btn', 'vidorev_channel_sub_btn', 10, 2 );

if ( ! function_exists( 'vidorev_single_channel_element_format' ) ) :
	function vidorev_single_channel_element_format($style){
		if(!is_singular('vid_channel') || $style == 'basic' || $style == 'special'){
			return;
		}
	?>
		<div class="single-post-style-wrapper full-width dark-background overlay-background">
			<div class="absolute-gradient"></div>	
			<div class="full-width-breadcrumbs">
				<div class="site__container fullwidth-vidorev-ctrl">
					<?php do_action( 'vidorev_single_post_breadcrumbs', 'full-width' );?>
				</div>
			</div>				
			<div class="single-post-basic-content">
				<div class="site__container fullwidth-vidorev-ctrl">
					<div class="site__row">
						<div class="site__col">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php	
	}
endif;
add_action( 'vidorev_single_element_format', 'vidorev_single_channel_element_format', 10, 1 );	

if ( ! function_exists( 'vidorev_single_video_player' ) ) :
	function vidorev_single_video_player( $toolbar = 'toolbar', $style = 'full-text', $sc_post_id = 0 ){
		$post_id = get_the_ID();
		
		if(is_user_logged_in()){
			do_action('beeteam368_video_fne', get_current_user_id(), $post_id);
		}
		
		$ext_id_sc = '';
		if($sc_post_id>0){
			$post_id = $sc_post_id;
			$ext_id_sc = '_sc_'.$post_id.rand(1, 99999);
		}
		$vm_video_url = apply_filters( 'vidorev_single_video_url', trim(get_post_meta($post_id, 'vm_video_url', true)), $post_id );
		$vm_video_shortcode = apply_filters( 'vidorev_single_video_shortcode', trim(get_post_meta($post_id, 'vm_video_shortcode', true)), $post_id );
		
		if(isset($_GET['video_index']) && is_numeric($_GET['video_index'])){
			$vm_video_multi_links = get_post_meta($post_id, 'vm_video_multi_links', true);
			
			$multiple_links_structure = get_post_meta($post_id, 'multiple_links_structure', true);				
			if($multiple_links_structure=='multi' && is_array($vm_video_multi_links)){
				$new_arr_video_multi_links = array();

				$ivurl=0;
				foreach($vm_video_multi_links as $videolinks_group){
					if( is_array($videolinks_group) && isset($videolinks_group['ml_url_mm']) && trim($videolinks_group['ml_url_mm'])!=''){
						$exp_videolinks_group = explode(PHP_EOL, $videolinks_group['ml_url_mm']);
						foreach($exp_videolinks_group as $video_item){
							if(strpos($video_item, 'http://')!==false || strpos($video_item, 'https://')!== false || strpos($video_item, 'http')!==false){
								$new_arr_video_multi_links[$ivurl]['ml_url'] = $video_item;
								$ivurl++;
							}
						}
					}
				}
				
				if(count($new_arr_video_multi_links) > 0){
					$vm_video_multi_links = $new_arr_video_multi_links;
				}
			}
			
			$video_ml_index = ((int)sanitize_text_field(trim($_GET['video_index']))) - 1;
						
			if( 	$video_ml_index > -1 && is_array($vm_video_multi_links) && isset($vm_video_multi_links[$video_ml_index])
					&& ( (isset($vm_video_multi_links[$video_ml_index]['ml_url']) && trim($vm_video_multi_links[$video_ml_index]['ml_url'])!='') || (isset($vm_video_multi_links[$video_ml_index]['ml_shortcode']) && trim($vm_video_multi_links[$video_ml_index]['ml_shortcode'])!='' )) 
			){				
				$vm_video_url 		= isset($vm_video_multi_links[$video_ml_index]['ml_url'])?trim($vm_video_multi_links[$video_ml_index]['ml_url']):'';
				$vm_video_shortcode = isset($vm_video_multi_links[$video_ml_index]['ml_shortcode'])?trim($vm_video_multi_links[$video_ml_index]['ml_shortcode']):'';
			}
		}
		
		if($vm_video_url=='' && $vm_video_shortcode==''){
			echo '';
			return;
		}
		$vm_video_network 	= vidorev_detech_video_data::getVideoNetwork($vm_video_url);		
		$trdPartyPlayer = '';
		
		$img_background_cover = '';		
		
		if(has_post_thumbnail($post_id) && $imgsource = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_16x9_3x')){
			$img_background_cover = $imgsource[0];
		}
		
		switch($vm_video_network){
			case 'embeded-code':
				$trdPartyPlayer = $vm_video_url;
				break;
			
			case 'self-hosted':
				$poster = '';				
				
				if($img_background_cover!=''){
					$poster = 'poster="'.esc_url($img_background_cover).'"';
				}
				
				$videos_format = array();
				$get_videos_html_format = explode(PHP_EOL, $vm_video_url);
				foreach($get_videos_html_format as $video_format){	
					if(trim($video_format) != ''){					
						$filetype = wp_check_filetype(trim($video_format));
						if(isset($filetype['ext'])&&( strtolower($filetype['ext']) == 'mp4' || strtolower($filetype['ext']) == 'm4v' || strtolower($filetype['ext']) == 'webm' || strtolower($filetype['ext']) == 'ogv' || strtolower($filetype['ext']) == 'wmv' || strtolower($filetype['ext']) == 'flv') ){
							$videos_format[strtolower($filetype['ext'])] = trim($video_format);
						}
					}
				}
				
				if(count($videos_format)>1){
					$shc_string = '';
					foreach($videos_format as $key => $value){
						$shc_string.= $key.'="'.esc_url($value).'" ';
					}					
					$trdPartyPlayer = do_shortcode('[video '.$shc_string.' '.$poster.']');
				}else{
					$trdPartyPlayer = do_shortcode('[video src="'.esc_url($vm_video_url).'" '.$poster.']');
					
					if(strpos($vm_video_url, '<video') === false){
						$trdPartyPlayer = '<div class="wp-video"><video src="'.esc_url($vm_video_url).'" class="wp-video-shortcode" preload="metadata" controls></video></div>';
					}
				}
				
				break;
				
			case 'drive':
				$poster = '';				
				
				if($img_background_cover!=''){
					$poster = 'poster="'.esc_url($img_background_cover).'"';
				}
				
				$google_api_key = trim(vidorev_get_redux_option('google_api_key', ''));
				$drive_file_id	= vidorev_detech_video_data::getVideoID($vm_video_url);
				$response 		= wp_remote_get('https://www.googleapis.com/drive/v2/files/'.$drive_file_id.'?key='.$google_api_key, array(	'timeout' => 368));
				
				$videos_format = '';
				
				if(is_wp_error($response)){
					$videos_format = '';
				}else {
					$result = json_decode($response['body']);
					if(isset($result->{'error'}) || !isset($result->{'videoMediaMetadata'})){
						$videos_format = '';
					}
				}
				
				$videos_format = isset($result->{'mimeType'})?$result->{'mimeType'}:'';
				$videos_size   = (isset($result->{'fileSize'})&&is_numeric($result->{'fileSize'}))?(int)$result->{'fileSize'}:0;
				$max_drive_size = apply_filters('vidorev_max_drive_size', 35000000);
				
				if($videos_format!='' && $videos_size < $max_drive_size){
					if(strpos($videos_format, 'mp4')){
						$trdPartyPlayer = do_shortcode('[video mp4="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.mp4" '.$poster.']');
					}elseif(strpos($videos_format, 'm4v')){
						$trdPartyPlayer = do_shortcode('[video m4v="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.m4v" '.$poster.']');
					}elseif(strpos($videos_format, 'webm')){
						$trdPartyPlayer = do_shortcode('[video webm="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.webm" '.$poster.']');						
					}elseif(strpos($videos_format, 'ogv')){
						$trdPartyPlayer = do_shortcode('[video ogv="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.ogv" '.$poster.']');
					}elseif(strpos($videos_format, 'wmv')){
						$trdPartyPlayer = do_shortcode('[video wmv="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.wmv" '.$poster.']');
					}elseif(strpos($videos_format, 'flv')){
						$trdPartyPlayer = do_shortcode('[video flv="https://drive.google.com/uc?id='.$drive_file_id.'&export=download&extension=file.flv" '.$poster.']');
					}else{
						$vm_video_network 	= 'embeded-code';
						$trdPartyPlayer	 	= '<iframe src="https://drive.google.com/file/d/'.$drive_file_id.'/preview" width="640" height="480" frameborder="0" allowfullscreen="1" allow="autoplay; encrypted-media" wmode="Opaque"></iframe>';
					}
				}else{
					$vm_video_network 	= 'embeded-code';
					$trdPartyPlayer	 	= '<iframe src="https://drive.google.com/file/d/'.$drive_file_id.'/preview" width="640" height="480" frameborder="0" allowfullscreen="1" allow="autoplay; encrypted-media" wmode="Opaque"></iframe>';
				}	
							
				break;	
		}
		
		if($vm_video_shortcode!=''){
			ob_start();
				echo do_shortcode($vm_video_shortcode);
				$vidorev_custom_player = ob_get_contents();
			ob_end_clean();	
			if(isset($vidorev_custom_player) && $vidorev_custom_player!=''){
				$vm_video_network 	= 'embeded-code';
				$trdPartyPlayer	 	= $vidorev_custom_player;
			}
		}
		
		$trdPartyPlayer = str_replace('class="wp-video-shortcode"', 'class="vidorev-video-shortcode"', $trdPartyPlayer);
		?>
		<div class="single-player-video-wrapper <?php echo esc_attr($style);?>">
        	<?php if($ext_id_sc=='' && !beeteam368_return_embed()){do_action('vidorev_above_single_player_ads', $post_id);}?>
			<?php do_action('vidorev_amazon_product_link', $post_id);?>
			<div class="light-off light-off-control"></div>
			<div id="video-player-wrap-control<?php echo esc_attr($ext_id_sc);?>" class="video-player-wrap">
				
				<div class="video-player-ratio"></div>
				
				<?php 
				$player_content = '';
				ob_start();
					/*$player_library = vidorev_detech_player_library($sc_post_id);*/					
					$player_library = apply_filters( 'vidorev_single_player_library', esc_html(vidorev_detech_player_library($sc_post_id)), $post_id, $vm_video_url );
				?>
				
					<div class="video-player-content video-player-control">
						<div class="float-video-title"><h6><?php echo esc_html(get_the_title($post_id));?></h6></div>
						<a href="#" title="<?php echo esc_attr__('Close', 'vidorev');?>" class="close-floating-video close-floating-video-control"><i class="fa fa-times" aria-hidden="true"></i></a>
						<a href="#" title="<?php echo esc_attr__('Scroll Up', 'vidorev');?>" class="scroll-up-floating-video scroll-up-floating-video-control"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></a>					
						<div class="player-3rdparty player-3rdparty-control <?php if($player_library=='videojs' || $player_library=='flow') echo esc_attr('player-loaded');?>">
							<div id="player-api-control<?php echo esc_attr($ext_id_sc);?>" class="player-api">
								<?php 
								if($player_library!='vp' && $vm_video_network!='embeded-code'){
									switch($player_library){
										
										case 'videojs':
											if(shortcode_exists( 'videojs_video' )){												
												$vid_auto_play = vidorev_get_redux_option('vid_auto_play', 'off', 'switch')=='on'?'true':'false';
												$single_vid_auto_play = trim(get_post_meta($post_id, 'vid_auto_play', true));
												if($single_vid_auto_play!=''){
													$vid_auto_play = $single_vid_auto_play=='on'?'true':'false';
												}
												echo do_shortcode('[videojs_video url="'.esc_url($vm_video_url).'" poster="'.esc_url($img_background_cover).'" autoplay="'.esc_attr($vid_auto_play).'"]');
											}else{
												echo wp_kses(
														__('<div class="require-plugin-player">You need to have installed <a href="https://wordpress.org/plugins/videojs-html5-player/" target="_blank">Videojs HTML5 Player</a> for used this feature.</div>', 'vidorev'),
														array(
															'a'=>array('href'=>array(), 'target'=>array()),	
															'div'=>array('class'=>array()),																
														)
													);
											}
											break;
											
										case 'flow':
											if(shortcode_exists( 'fvplayer' )){
												echo do_shortcode('[fvplayer src="'.$vm_video_url.'" splash="'.$img_background_cover.'"]');
											}else{
												echo wp_kses(
														__('<div class="require-plugin-player">You need to have installed <a href="https://wordpress.org/plugins/fv-wordpress-flowplayer/" target="_blank">FV Flowplayer Video Player</a> for used this feature.</div>', 'vidorev'),
														array(
															'a'=>array('href'=>array(), 'target'=>array()),	
															'div'=>array('class'=>array()),																
														)
													);
											}
											break;
									}
								}else{	
									echo apply_filters( 'vidorev_trdPartyPlayer_posts_html', $trdPartyPlayer );
								}
								?>
							</div>
							
							<div class="player-muted player-muted-control"><i class="fa fa-volume-off" aria-hidden="true"></i></div>
							
							<div class="text-load-ads text-load-ads-control">
								<?php echo esc_html__('Loading advertisement...', 'vidorev');?>
							</div>
							
							<div class="autoplay-off-elm autoplay-off-elm-control video-play-control" data-id="<?php echo esc_attr($post_id);?>" data-background-url="<?php echo esc_url($img_background_cover);?>">
								<span class="video-icon big-icon video-play-control" data-id="<?php echo esc_attr($post_id);?>"></span>
								<img class="poster-preload" src="<?php echo esc_url($img_background_cover);?>" alt="<?php echo esc_attr__('Preload Image', 'vidorev');?>">
							</div>
							
							<div class="player-muted ads-mute-elm ads-muted-control"><i class="fa fa-volume-off" aria-hidden="true"></i></div>
							
							<?php 
							$nextVideoTitle = esc_html__('Video title', 'vidorev');
							$nextVideoURL 	= '';
							$nextVideo 		= vidorev_get_adjacent_video_by_id( $post_id, false, true );	
							if($nextVideo > 0){
								
								if(isset($_GET['series']) && is_numeric($_GET['series'])){
									global $post_type_add_param_to_url;
									$post_type_add_param_to_url = array(
										'series' => $_GET['series']
									);
									
									if(isset($_GET['video_index']) && is_numeric($_GET['video_index'])){
										$post_type_add_param_to_url = array(
											'series' 		=> $_GET['series'],
											'video_index' 	=> $_GET['video_index']
										);
									}
								}
								
								$nextVideoTitle = get_the_title($nextVideo);
								$nextVideoURL 	= vidorev_get_post_url($nextVideo);
								
								if(isset($_GET['series']) && is_numeric($_GET['series'])){
									$post_type_add_param_to_url = NULL;	
								}
													
							}				
							?>
							<div class="auto-next-elm auto-next-elm-control dark-background" data-background-url="<?php echo esc_url($img_background_cover);?>" data-next-url="<?php echo esc_url($nextVideoURL);?>">
								<div class="auto-next-content">
									<div class="up-next-text font-size-12"><?php echo esc_html__('Up next', 'vidorev');?></div>
									<h3 class="h6-mobile video-next-title video-next-title-control"><?php echo esc_html($nextVideoTitle);?></h3>
									
									<div class="loader-timer-wrapper loader-timer-control">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" class="loader-timer">
											<circle class="progress-timer" fill="none" stroke-linecap="round" cx="20" cy="20" r="15.915494309" />
										</svg>
										<i class="fa fa-fast-forward" aria-hidden="true"></i>
									</div>
									
									<a href="#" class="basic-button basic-button-default cancel-btn cancel-btn-control"><?php echo esc_html__('Cancel', 'vidorev');?></a>
								</div>
							</div>
						</div>	
						<div class="video-loading video-loading-control">
							<span class="video-load-icon"></span>
						</div>				
					</div>
				
				<?php 
				$player_content = ob_get_contents();
				ob_end_clean();	
				echo apply_filters( 'vidorev_single_player_html', $player_content, $post_id );
				
				if($ext_id_sc!='' && function_exists('beeteam368_create_elm_sc_video')){				
					beeteam368_create_elm_sc_video($post_id, $ext_id_sc);
				}
				?>
				
			</div>
			
			<?php if(vidorev_get_redux_option('single_video_main_toolbar', 'on', 'switch')=='on' && !beeteam368_return_embed()){?>
			
				<div class="video-toolbar dark-background video-toolbar-control">
					<div class="tb-left">
						<div class="site__row">
							<?php if(vidorev_get_redux_option('single_video_main_toolbar_tol', 'on', 'switch')=='on'){?>
								<div class="site__col toolbar-item">
									<div class="toolbar-item-content turn-off-light turn-off-light-control">
										<span class="item-icon font-size-18"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Turn Off Light', 'vidorev');?></span>
									</div>	
								</div>
							<?php
							}
							if(function_exists('vidorev_display_like_button') && vidorev_get_redux_option('single_video_main_toolbar_like', 'on', 'switch')=='on'){
								echo vidorev_display_like_button($post_id, '1');
							}
							if(function_exists('vidorev_display_dislike_button') && vidorev_get_redux_option('single_video_main_toolbar_dislike', 'on', 'switch')=='on'){
								echo vidorev_display_dislike_button($post_id, '1');
							}
							
							if(vidorev_get_redux_option('watch_enable', 'off', 'switch')=='on' && vidorev_get_redux_option('single_video_main_toolbar_watch_later', 'on', 'switch')=='on'){
								$attachment_id = get_post_thumbnail_id($post_id);
								$small_picture = wp_get_attachment_image_src($attachment_id, 'thumbnail');
								if($small_picture){
									$small_picture_url = $small_picture[0];
								}else{
									$small_picture_url = '';
								}								
								
								$watch_later_active_class = '';
								
								global $watch_later_cookie;
								if(!isset($watch_later_cookie) || !is_array($watch_later_cookie)){
									$watch_later_cookie = array();
								}				
								
								if(array_search($post_id, $watch_later_cookie)!==false){
									$watch_later_active_class = 'active-item ';
								}
								?>															
									<div class="site__col toolbar-item">
										<div class="toolbar-item-content watch-later-control <?php echo esc_attr($watch_later_active_class);?>" 
											data-id="<?php echo esc_attr($post_id);?>" 
											data-img-src="<?php echo esc_url($small_picture_url);?>"
											data-hyperlink="<?php echo esc_url(get_permalink($post_id));?>" 
											data-title="<?php echo esc_attr(get_the_title($post_id));?>"
										>
											<span class="item-icon font-size-18"><i class="fa fa-clock-o" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Watch Later', 'vidorev');?></span>
										</div>
									</div>
								<?php						
							}
							
							if(vidorev_get_redux_option('single_video_main_toolbar_share', 'on', 'switch')=='on' && defined('VIDOREV_EXTENSIONS')){						
							?>						
								<div class="site__col toolbar-item">
									<div class="toolbar-item-content share-control">
										<span class="item-icon font-size-18"><i class="fa fa-share-alt" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Share', 'vidorev');?></span>
									</div>
								</div>	
							<?php }?>					
						</div>	
					</div>
					
					<div class="tb-right">
						<div class="site__row">
							<?php if(vidorev_get_redux_option('single_video_main_toolbar_auto_next', 'on', 'switch')=='on' && defined('VIDOREV_EXTENSIONS')){?>						
								<div class="site__col toolbar-item">
									<div class="toolbar-item-content auto-next-control">
										<span class="item-text"><?php echo esc_html__( 'Auto Next', 'vidorev');?></span><span class="item-icon font-size-18"><i class="auto-next-icon auto-next-icon-control"></i></span>
									</div>
								</div>
							<?php 
							}
							
							if(vidorev_get_redux_option('single_video_main_toolbar_theater_mode', 'off', 'switch')=='on' && $ext_id_sc=='' && defined('VIDOREV_EXTENSIONS')){
							?>
                            	<div class="site__col toolbar-item">
                                    <div class="toolbar-item-content theater-mode-control">
                                        <span class="item-text"><?php echo esc_html__('Theater', 'vidorev');?></span><span class="item-icon font-size-18"><i class="fa fa-television" aria-hidden="true"></i></span>
                                    </div>
                                </div>	
                            <?php	
							}
							
							if(vidorev_get_redux_option('single_video_main_toolbar_comment_count', 'on', 'switch')=='on' && $ext_id_sc==''){
								$vid_download_type 		= get_post_meta($post_id, 'vid_download_type', true);
								$vid_download_target 	= get_post_meta($post_id, 'vid_download_target', true);		
								$vid_woo_product 		= get_post_meta($post_id, 'vid_woo_product', true);
								$vm_media_download 		= get_post_meta($post_id, 'vm_media_download', true);
								$vid_download_mode 		= get_post_meta($post_id, 'vid_download_mode', true);
								if($vid_download_mode == ''){
									$vid_download_mode = 'normal';
								} 
								
								$link_action = 'download';
								if($vid_download_target == 'newtab'){
									$link_action = 'target="_blank"';
								}

								$new_html_files		= '';
								
								if($vid_download_type =='free' && isset($vm_media_download) && is_array($vm_media_download) && count($vm_media_download) > 0){
									$default_file_name = esc_html__('Download File', 'vidorev');
									
									$i_dl = 1;
									foreach($vm_media_download as $download_file){
										if(isset($download_file['source_label']) && trim($download_file['source_label'])!=''){
											$new_file_name = trim($download_file['source_label']);
										}else{
											$new_file_name = $default_file_name.' '.$i_dl;
										}
										
										if(isset($download_file['source_file_id']) && is_numeric($download_file['source_file_id'])){											
											$new_html_files.='<div class="download-item"><div class="download-item-name">'.esc_html($new_file_name).'</div><div class="download-item-btn"><a class="basic-button basic-button-default" href="'.esc_url(wp_get_attachment_url( $download_file['source_file_id'] )).'" '.$link_action.'>'.esc_html__('Download', 'vidorev').'</a></div></div>';
										}else{
											if(isset($download_file['source_file']) && trim($download_file['source_file'])!=''){
												$new_html_files.='<div class="download-item"><div class="download-item-name">'.esc_html($new_file_name).'</div><div class="download-item-btn"><a class="basic-button basic-button-default" href="'.esc_url( $download_file['source_file'] ).'" '.$link_action.'>'.esc_html__('Download', 'vidorev').'</a></div></div>';
											}
										}
										
										$i_dl++;
									}
								}
								
								if($vid_download_type =='paid' && isset($vid_woo_product) && is_numeric($vid_woo_product) && class_exists( 'WooCommerce' )){
									$vid_woo_product = (int)$vid_woo_product;
									$woo_product_download = function_exists('wc_get_product')?wc_get_product($vid_woo_product):get_product($vid_woo_product);									
									
								}
								
								if($vid_download_type =='free' && $new_html_files != ''){
								?>
									<div class="site__col toolbar-item">
										<div class="toolbar-item-content free-files-download download-files-control">
											<span class="item-text"><?php echo esc_html__('Free Download', 'vidorev');?></span><span class="item-icon font-size-18"><i class="fa fa-download" aria-hidden="true"></i></span>
										</div>										
									</div>	
								<?php									
								}elseif($vid_download_type =='paid' && isset($woo_product_download) && !empty($woo_product_download) && $woo_product_download->is_downloadable() && $vid_download_mode == 'normal'){
									
									$price 			= $woo_product_download->get_price_html();									
									$current_user 	= wp_get_current_user();	
									
									if($current_user->exists()){
										
										$available_downloads 	= wc_get_customer_available_downloads( $current_user->ID );
																				
										if(!empty($available_downloads) && is_array($available_downloads) && count($available_downloads) > 0){
											$default_file_name = esc_html__('Download File', 'vidorev');
											
											$i_dl = 1;
											foreach($available_downloads as $download_item){
												if($vid_woo_product == $download_item['product_id']){
													if(isset($download_item['download_name']) && trim($download_item['download_name'])!=''){
														$new_file_name = trim($download_item['download_name']);
													}else{
														$new_file_name = $default_file_name.' '.$i_dl;
													}
													if($vid_download_target == 'newtab'){
														$file_url = '';
														if(isset($download_item['file']['file']) && isset($download_item['file'])){
															$file_url = $download_item['file']['file'];															
														}
														$new_html_files.='<div class="download-item"><div class="download-item-name">'.esc_html($new_file_name).'</div><div class="download-item-btn"><a class="basic-button basic-button-default" href="'.esc_url($file_url).'" '.$link_action.'>'.esc_html__('Download', 'vidorev').'</a></div></div>';
													}else{
														$new_html_files.='<div class="download-item"><div class="download-item-name">'.esc_html($new_file_name).'</div><div class="download-item-btn"><a class="basic-button basic-button-default" href="'.esc_url($download_item['download_url']).'" '.$link_action.'>'.esc_html__('Download', 'vidorev').'</a></div></div>';
													}
													
													$i_dl++;
												}
											}
										}										
									}																											
									if($new_html_files != ''){
										$new_html_files = '<div class="download-package"><span class="package-heading">'.esc_html__('Download Package', 'vidorev').'</span> &nbsp; <a href="'.esc_url(get_permalink($vid_woo_product)).'" target="_blank" class="package-title h6">'.esc_html(get_the_title( $vid_woo_product )).'</a></div>'.$new_html_files;											
									?>
										<div class="site__col toolbar-item">
											<a target="_blank" href="<?php echo esc_url(wc_get_account_endpoint_url(get_option( 'woocommerce_myaccount_downloads_endpoint', 'downloads' )));?>" class="toolbar-item-content premium-ready-files-download download-files-control woo-download-price">
												<span class="item-text"><?php echo esc_html__('Download', 'vidorev');?></span><span class="item-icon font-size-18"><i class="fa fa-download" aria-hidden="true"></i></span>
											</a>																				
										</div>
									<?php }else{?>
										<div class="site__col toolbar-item">
											<a target="_blank" href="<?php echo esc_url(get_permalink($vid_woo_product));?>" class="toolbar-item-content premium-files-download woo-download-price">
												<span class="item-text"><?php echo apply_filters('vidorev_woo_download_price', $price);?></span><span class="item-icon font-size-18"><i class="fa fa-cloud-download" aria-hidden="true"></i></span>
											</a>																					
										</div>
									<?php
									}
								}elseif($vid_download_type =='paid' && isset($woo_product_download) && !empty($woo_product_download) && $woo_product_download->is_virtual() && $vid_download_mode == 'protect'){
									
									$price 			= $woo_product_download->get_price_html();									
									$current_user 	= wp_get_current_user();
									if($current_user->exists() && wc_customer_bought_product( $current_user->user_email, $current_user->ID, $vid_woo_product )){
									?>
                                    	<div class="site__col toolbar-item">
											<a target="_blank" href="<?php echo esc_url(wc_get_account_endpoint_url(get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' )));?>" class="toolbar-item-content premium-ready-files-download woo-download-price">
												<span class="item-text"><?php echo esc_html__('PURCHASED', 'vidorev');?></span><span class="item-icon font-size-18"><i class="fa fa-eye" aria-hidden="true"></i></span>
											</a>																				
										</div>
                                    <?php	
									}else{
									?>
                                    	<div class="site__col toolbar-item">
											<a target="_blank" href="<?php echo esc_url(get_permalink($vid_woo_product));?>" class="toolbar-item-content premium-files-download woo-download-price">
												<span class="item-text"><?php echo esc_html__('BUY', 'vidorev').' '.apply_filters('vidorev_woo_download_price', $price);?></span><span class="item-icon font-size-18"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
											</a>																					
										</div>
                                    <?php	
									}
									
								}else{
									$dd_comment_count = get_comments_number($post_id);
									
									$comment_nav_elm = '#comments';									
									if(vidorev_detech_comment_type() == 'facebook'){
										$comment_nav_elm = '#vidorev_facebook_comment';
										
										$url_request			= get_permalink($post_id);										
										$facebook_api_url 		= 'https://graph.facebook.com/?ids='.$url_request;									
										$request_topken 		= wp_remote_get($facebook_api_url, array('timeout' => 368));
										
										if(is_wp_error($request_topken)){
											
										}else{
											$topken = json_decode($request_topken['body']);
											if(isset($topken->{'error'}) && $topken->{'error'}!=''){					
												
											}else{
												foreach($topken as $key => $values){
													if(isset($values->{'share'}) && isset($values->{'share'}->{'comment_count'})){
														$dd_comment_count = $values->{'share'}->{'comment_count'};
													}
													break;
												}
											}
										}		
										
									}elseif(vidorev_detech_comment_type() == 'wp' && class_exists('Disqus_Api_Service')){
										$comment_nav_elm = '#disqus_thread';
									}
								?>
									<div class="site__col toolbar-item">
										<div class="toolbar-item-content comment-video-control scroll-elm-control" data-href="<?php echo esc_attr($comment_nav_elm);?>">
											<?php 
											$comment_count = get_comments_number($post_id);
											if($comment_count==1){
												$comment_text = apply_filters('vidorev_number_format', $dd_comment_count).' '.esc_html__( 'Comment', 'vidorev');
											}else{
												$comment_text = apply_filters('vidorev_number_format', $dd_comment_count).' '.esc_html__( 'Comments', 'vidorev');
											}
											?>
											<span class="item-text"><?php echo esc_html($comment_text);?></span><span class="item-icon font-size-18"><i class="fa fa-comment" aria-hidden="true"></i></span>
										</div>
									</div>
							<?php 
								}
							}
							?>	
						</div>	
					</div>				
				</div>
				
				<?php 
				if(isset($new_html_files) && $new_html_files!=''){
				?>
					<div class="download-lightbox dark-background">						
						<div class="download-listing">
							<div class="download-close download-files-control">
								<i class="fa fa-times" aria-hidden="true"></i>
							</div>
							<?php echo apply_filters('vidorev_download_files_listing', $new_html_files);?>
						</div>
					</div>
				<?php	
				}				
				if(vidorev_get_redux_option('single_video_main_toolbar_share', 'on', 'switch')=='on' && function_exists('vidorev_social_sharing')){
				?>
					<div class="social-share-toolbar social-share-toolbar-control">
						<div class="social-share-toolbar-content">
							<?php 
							vidorev_social_sharing($post_id);
							if(vidorev_get_redux_option('single_video_main_toolbar_share_iframe', 'on', 'switch')=='on'){
							?>
                            <input type="text" onClick="this.select()" class="share-iframe-embed" readonly value="<?php echo htmlentities('<iframe width="560" height="315" src="'.esc_url(add_query_arg(array('video_embed' => $post_id), get_permalink($post_id))).'" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');?>">
                            <?php
							}
							?>
						</div>
					</div>				
			<?php 
				}
			}
			do_action('vidorev_video_player_timelapse', $post_id);
			do_action('vidorev_video_player_sub_toolbar', $post_id, $ext_id_sc);
			if($ext_id_sc=='' && !beeteam368_return_embed()){
				do_action('vidorev_video_player_more_videos', $post_id);
			}
			do_action('vidorev_video_series_element', $post_id);
			do_action('vidorev_video_multi_links_element', $post_id);
			if(vidorev_single_video_style()=='clean'){
			?>
            
				<div class="show-hide-toolbar show-hide-toolbar-control"><span></span><span></span><span></span></div>
            
			<?php
			}
			if($ext_id_sc=='' && !beeteam368_return_embed()){
				do_action('vidorev_above_single_content_ads');
			}
			?>
		</div>
		<?php
	}
endif;
add_action( 'vidorev_single_video_player', 'vidorev_single_video_player', 10, 3 );

if ( ! function_exists( 'vidorev_single_element_format' ) ) :
	function vidorev_single_element_format( $style ){
		
		$post_format = get_post_format();
		$post_type = get_post_type();
		$single_style = vidorev_single_style();
		
		$playlist = false;
		if(isset($_GET['playlist']) && trim($_GET['playlist'])!='' && $post_format=='video'){					
			if(is_numeric(trim($_GET['playlist']))){
				$playlist = true;
				$single_style = 'full-width';
			}
		}
		
		$video_ps_link_action = vidorev_get_redux_option('video_ps_link_action', 'no');		
		if($post_format=='video' && ($video_ps_link_action == 'playlist' || $video_ps_link_action == 'both') ){
			$at_playlist_id = beeteam368_get_playlist_by_post_id(get_the_ID());	
			if($at_playlist_id > 0){
				$playlist = true;
				$single_style = 'full-width';
			}
		}
		
		if($style != $single_style || $post_type == 'vid_playlist' || $post_type == 'vid_channel' || $post_type == 'vid_actor' || $post_type == 'vid_director' || $post_type == 'vid_series'){
			echo '';
			return;
		}
		
		$before_html 	= '';
		$after_html 	= '';
		
		switch($single_style){
			case 'basic':
				$before_html 	= '<div class="single-post-style-wrapper"><div class="single-post-basic-content">';
				$after_html 	= '</div></div>';
				break;
			
			case 'special':
				$before_html 	= '<div class="site__row"><div class="single-post-style-wrapper"><div class="single-post-basic-content">';
				$after_html 	= '</div></div></div>';
				break;
			
			case 'full-width':
				$before_html 	= '<div class="single-post-style-wrapper full-width dark-background overlay-background"><div class="absolute-gradient"></div><div class="single-post-basic-content"><div class="site__container fullwidth-vidorev-ctrl"><div class="site__row"><div class="site__col">';
				$after_html 	= '</div></div></div></div></div>';
				break;				
		}
		
		switch($post_format){
			case '0':
							
				switch($single_style){
					case 'basic':
						if(!has_post_thumbnail()){
							echo '';
							return;
						}
						?>
						<div class="single-post-style-wrapper">
							<div class="single-post-basic-content">
								<div class="single-feature-image">
									<?php the_post_thumbnail('full');?>
								</div>
							</div>
						</div>						
						<?php
						break;
					
					case 'special':
						?>
						
						<div class="single-post-style-wrapper special">
							<?php do_action( 'vidorev_single_post_breadcrumbs', 'special' );?>
							
							<div class="single-post-basic-content site__row">
								<div class="site__col">
									<?php 
									do_action( 'vidorev_single_post_title', 'special', 'h-font-size-30 h1-tablet');
									
									if(has_post_thumbnail()){
									?>									
									
										<div class="single-feature-image">
											<?php the_post_thumbnail('full');?>
										</div>
									
									<?php }else{
									?>
									
										<div class="basic-special-line"></div>
										
									<?php
									}
									?>	
								</div>
							</div>
						</div>
								
						<?php
						break;
					
					case 'full-width':
						?>
						<div class="single-post-style-wrapper full-width dark-background overlay-background">
							<div class="absolute-gradient"></div>
							<div class="full-width-breadcrumbs">
								<div class="site__container fullwidth-vidorev-ctrl">
									<?php do_action( 'vidorev_single_post_breadcrumbs', 'full-width' );?>
								</div>
							</div>	
							<div class="single-post-basic-content">
								<div class="site__container fullwidth-vidorev-ctrl">
									<div class="site__row">
										<div class="site__col">
											<?php do_action( 'vidorev_single_post_title', 'full-width', 'h-font-size-40');?>
										</div>
									</div>
								</div>
							</div>
						</div>				
						<?php
						break;				
				}
				
				break;
				
			case 'video':
				
				$prevVideo = vidorev_get_adjacent_video_by_id( get_the_ID(), true, true );
				$nextVideo = vidorev_get_adjacent_video_by_id( get_the_ID(), false, true);
			
				switch($single_style){
					case 'basic':						
						?>
						<div class="single-post-style-wrapper">
							<div class="single-post-basic-content">
								<div class="single-feature-image">
									<?php do_action( 'vidorev_single_video_player', 'toolbar', 'vp-small-item');?>
								</div>
							</div>
						</div>	
						<?php
						break;
					
					case 'special':						
						?>
						<div class="single-post-style-wrapper special">
							<?php do_action( 'vidorev_single_post_breadcrumbs', 'special' );?>
							
							<div class="single-post-basic-content site__row">
								<div class="site__col">
									<?php 
									do_action( 'vidorev_single_post_title', 'special', 'h-font-size-30 h1-tablet');
									do_action( 'vidorev_single_video_player', 'toolbar', 'default');
									?>								
								</div>
							</div>
						</div>
						<?php
						break;
					
					case 'full-width':
						?>
						<div class="single-post-video-full-width-wrapper dark-background overlay-background<?php echo esc_attr($playlist?' is_vid_playlist_layout':'')?>">
                        	<?php if(!beeteam368_return_embed()){?>
                                <div class="full-width-breadcrumbs">
                                    <div class="site__container fullwidth-vidorev-ctrl">
                                        <?php do_action( 'vidorev_single_post_breadcrumbs', 'full-width' );?>
                                    </div>
                                </div>	
                            <?php } ?>
							<div class="single-post-video-player-content">
								<?php
								if(!$playlist && !beeteam368_return_embed()){ 
									
									if(isset($_GET['series']) && is_numeric($_GET['series'])){
										global $post_type_add_param_to_url;
										$post_type_add_param_to_url = array(
											'series' => $_GET['series']
										);
										
										if(isset($_GET['video_index']) && is_numeric($_GET['video_index'])){
											$post_type_add_param_to_url = array(
												'series' 		=> $_GET['series'],
												'video_index' 	=> $_GET['video_index']
											);
										}
									}
																			
									if($prevVideo > 0){
										$prev_post_id = $prevVideo;
									?>
										<div class="player-prev-video">
											<a href="<?php echo esc_url(vidorev_get_post_url($prev_post_id)); ?>" title="<?php echo esc_attr(get_the_title($prev_post_id)); ?>">
												<span class="nav-btn navigation-font nav-font-size-12"><i class="fa fa-angle-left" aria-hidden="true"></i><span class="text-btn"><?php echo esc_html__('Previous Video', 'vidorev');?></span></span>
												<span class="nav-text h6">												
													<?php if(has_post_thumbnail($prev_post_id)){?>
														<span class="nav-text-pic"><img src="<?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_prev_next_video_ply_image_size', 'vidorev_thumb_1x1_0x'), apply_filters('vidorev_custom_prev_next_video_ply_image_ratio', 'class-1x1'), 4, $prev_post_id); ?>" alt="<?php echo esc_attr(get_the_title($prev_post_id)); ?>"></span>
													<?php }?>
													<span class="nav-text-content"><?php echo esc_html(get_the_title($prev_post_id));?></span>
												</span>
											</a>										
										</div>
									<?php
									}
									
									if($nextVideo > 0){
										$next_post_id = $nextVideo;
									?>
										<div class="player-next-video">
											<a href="<?php echo esc_url(vidorev_get_post_url($next_post_id)); ?>" title="<?php echo esc_attr(get_the_title($next_post_id)); ?>">
												<span class="nav-btn navigation-font nav-font-size-12"><span class="text-btn"><?php echo esc_html__('Next Video', 'vidorev');?></span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
												<span class="nav-text h6">
													<?php if(has_post_thumbnail($next_post_id)){?>
														<span class="nav-text-pic"><img src="<?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_prev_next_video_ply_image_size', 'vidorev_thumb_1x1_0x'), apply_filters('vidorev_custom_prev_next_video_ply_image_ratio', 'class-1x1'), 4, $next_post_id); ?>" alt="<?php echo esc_attr(get_the_title($next_post_id)); ?>"></span>
													<?php }?>
													<span class="nav-text-content"><?php echo esc_html(get_the_title($next_post_id));?></span>
												</span>
											</a>		
										</div>
									<?php
									}
									
									if(isset($_GET['series']) && is_numeric($_GET['series'])){
										$post_type_add_param_to_url = NULL;	
									}	
								}
								?>
								
								<div class="site__container fullwidth-vidorev-ctrl">
									<div class="site__row">
										<div class="site__col">											
											<?php 
											if($playlist && !beeteam368_return_embed()){
												do_action( 'vidorev_single_post_convert_playlist');
											}else{
												do_action( 'vidorev_single_video_player', 'toolbar', 'default');
											}											
											?>
										</div>
									</div>
								</div>
							</div>
						</div>	
						<?php
						break;				
				}
				
				break;
				
			case 'gallery':
				
				$html = '';
				
				$imgs = get_children( array( 
					'post_parent' => get_the_ID(), 
					'post_type' => 'attachment', 
					'post_mime_type' => 'image', 
					'numberposts' => 333,
				) );
				
				if( count($imgs) > 0 ){
					$html .= '<div class="single-image-gallery is-single-slider">';
					foreach($imgs as $attachment_id => $attachment){
						$image = wp_get_attachment_image_src( $attachment_id ,'full');
						$html .= '<div><img src="'.esc_url($image[0]).'" alt="'.esc_attr($attachment->post_title).'" class="img-gallery-silder"></div>';
					}
					$html .= '</div>';
				}				
				
				switch($single_style){
					case 'basic':
						if($html == ''){
							echo '';
							return;
						}
						?>
						<div class="single-post-style-wrapper">
							<div class="single-post-basic-content">								
								<?php echo apply_filters( 'vidorev_single_gallery_basic_html', $html );?>
							</div>
						</div>	
						<?php
						break;
					
					case 'special':
						?>
						
						<div class="single-post-style-wrapper special">
							<?php do_action( 'vidorev_single_post_breadcrumbs', 'special' );?>
							
							<div class="single-post-basic-content site__row">
								<div class="site__col">
									<?php 
									do_action( 'vidorev_single_post_title', 'special', 'h-font-size-30 h1-tablet');
									echo apply_filters( 'vidorev_single_gallery_special_html', $html );
									?>									
								</div>
							</div>
						</div>
								
						<?php
						break;								
				}
			
				break;	
				
			case 'quote':
				
				global $post;
				preg_match('#<blockquote.*?>(.*?)</blockquote>#si', $post->post_content, $quote);
								
				$html = '';
				
				if(isset($quote[1])){
					add_filter( 'the_content', 'vidorev_remove_blockquotes' );
					$html .= '<div class="single-post-quote">';
						$html .= '<blockquote><p>'.$quote[1].'</p></blockquote>';					
					$html .= '</div>';
				}
				
				if(has_post_thumbnail()){
					$html .= '<div class="single-feature-image">';
						$html .= get_the_post_thumbnail();					
					$html .= '</div>';
				}
				
				switch($single_style){
					case 'basic':
						if($html == ''){
							echo '';
							return;
						}
						?>
						<div class="single-post-style-wrapper">
							<div class="single-post-basic-content">								
								<?php 
									echo apply_filters( 'vidorev_single_quote_basic_html', $html );
								?>
							</div>
						</div>
						<?php
						break;
					
					case 'special':						
						?>
						
						<div class="single-post-style-wrapper special">
							<?php do_action( 'vidorev_single_post_breadcrumbs', 'special' );?>
							
							<div class="single-post-basic-content site__row">
								<div class="site__col">
									<?php 
									do_action( 'vidorev_single_post_title', 'special', 'h-font-size-30 h1-tablet');
									echo apply_filters( 'vidorev_single_quote_special_html', $html );
									?>									
								</div>
							</div>
						</div>
						
						<?php
						break;								
				}
				
				break;	
				
			default:		
		}	
	}
endif;	
add_action( 'vidorev_single_element_format', 'vidorev_single_element_format', 10, 1 );

if(!function_exists('vidorev_custom_comment_form')):
	function vidorev_custom_comment_form($fields){
		
		$commenter 		= wp_get_current_commenter();
		$user 			= wp_get_current_user();
		$user_identity 	= $user->exists()?$user->display_name:'';
		
		$req 			= get_option('require_name_email');
		$aria_req 		= ($req ? ' required aria-required="true"':'');
		
		$fields['author'] 	= '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="'.esc_attr__('Your Name', 'vidorev').($req?' *':'').'" value="'.esc_attr($commenter['comment_author']).'"'.$aria_req.'></p>';
		$fields['email'] 	= '<p class="comment-form-email"><input id="email" placeholder="'.esc_attr__('Your Email', 'vidorev').($req?' *':'').'" name="email" type="email" value="'.esc_attr($commenter['comment_author_email']).'"'.$aria_req.'></p>';
		$fields['url'] 		= '<p class="comment-form-url"><input id="url" placeholder="' . esc_attr__('Your Website', 'vidorev').'" name="url" type="text" value="'.esc_attr($commenter['comment_author_url']).'"></p>';
		
		return $fields;
	}
endif;
add_filter('comment_form_default_fields', 'vidorev_custom_comment_form');


if(!function_exists('vidorev_custom_archive_title')){
	function vidorev_custom_archive_title($title){
		if ( is_category() ) {
			$title = sprintf( esc_html__( '%s', 'vidorev'), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( esc_html__( 'Tag: %s', 'vidorev'), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( esc_html__( 'Author: %s', 'vidorev'), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Year: %s', 'vidorev'), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'vidorev') ) );
		} elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Month: %s', 'vidorev'), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'vidorev') ) );
		} elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Day: %s', 'vidorev'), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'vidorev') ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = esc_html_x( 'Asides', 'post format archive title', 'vidorev');
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = esc_html_x( 'Galleries', 'post format archive title', 'vidorev');
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = esc_html_x( 'Images', 'post format archive title', 'vidorev');
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = esc_html_x( 'Videos', 'post format archive title', 'vidorev');
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = esc_html_x( 'Quotes', 'post format archive title', 'vidorev');
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = esc_html_x( 'Links', 'post format archive title', 'vidorev');
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = esc_html_x( 'Statuses', 'post format archive title', 'vidorev');
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = esc_html_x( 'Audio', 'post format archive title', 'vidorev');
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = esc_html_x( 'Chats', 'post format archive title', 'vidorev');
			}
		} elseif ( is_post_type_archive() ) {
			if(is_post_type_archive('vid_playlist') || is_post_type_archive('vid_channel') || is_post_type_archive('vid_actor') || is_post_type_archive('vid_director') || is_post_type_archive('vid_series')){
				$title = sprintf( esc_html__( '%s', 'vidorev'), post_type_archive_title( '', false ) );
			}else{
				$title = sprintf( esc_html__( 'Archives: %s', 'vidorev'), post_type_archive_title( '', false ) );
			}			
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			if($tax->name == 'vid_playlist_cat' || $tax->name == 'vid_channel_cat' || $tax->name == 'vid_actor_cat' || $tax->name == 'vid_director_cat' || $tax->name == 'vid_series_cat'){
				$title = sprintf( esc_html__( '%1$s', 'vidorev'), single_term_title( '', false ) );
			}else{
				$title = sprintf( esc_html__( '%1$s: %2$s', 'vidorev'), $tax->labels->singular_name, single_term_title( '', false ) );
			}
		} else {
			$title = esc_html__( 'Archives', 'vidorev');
		}

		return apply_filters( 'vidorev_custom_archive_title', $title );
	}
}
add_filter('get_the_archive_title', 'vidorev_custom_archive_title');

if(!function_exists('vidorev_archive_heading')){
	function vidorev_archive_heading($archive_style){		
	?>
		<div class="archive-heading">
			<div class="archive-content">
				<?php 
				if(is_category() && defined('CATEGORY_PM_PREFIX')){
					$category 		= get_category( get_query_var( 'cat' ) );
					$cat_id 		= $category->cat_ID;				
					$archive_img 	= get_metadata('term', $cat_id, CATEGORY_PM_PREFIX.'image', true);
					if($archive_img!=''){					
				?>
						<div class="archive-img">							
							<img alt="<?php echo esc_attr__('Category image', 'vidorev')?>" src="<?php echo esc_url($archive_img);?>">
						</div>
				<?php 
					}else{
					?>
					<div class="archive-img-lev" data-id="<?php echo esc_attr($cat_id);?>"></div>
					<?php
					}
				}elseif(is_post_type_archive('vid_playlist') && vidorev_get_option('vid_playlist_image', 'vid_playlist_settings', '')!=''){
				?>
					<div class="archive-img">							
						<img alt="<?php echo esc_attr__('Playlist image', 'vidorev')?>" src="<?php echo esc_url(vidorev_get_option('vid_playlist_image', 'vid_playlist_settings', ''));?>">
					</div>
				<?php
				}elseif(is_post_type_archive('vid_channel') && vidorev_get_option('vid_channel_image', 'vid_channel_settings', '')!=''){
				?>
					<div class="archive-img">							
						<img alt="<?php echo esc_attr__('Channel image', 'vidorev')?>" src="<?php echo esc_url(vidorev_get_option('vid_channel_image', 'vid_channel_settings', ''));?>">
					</div>
				<?php
				}elseif(is_post_type_archive('vid_actor') && vidorev_get_option('vid_actor_image', 'vid_actor_settings', '')!=''){
				?>
					<div class="archive-img">							
						<img alt="<?php echo esc_attr__('Actor image', 'vidorev')?>" src="<?php echo esc_url(vidorev_get_option('vid_actor_image', 'vid_actor_settings', ''));?>">
					</div>
				<?php
				}elseif(is_post_type_archive('vid_director') && vidorev_get_option('vid_director_image', 'vid_director_settings', '')!=''){
				?>
					<div class="archive-img">							
						<img alt="<?php echo esc_attr__('Director image', 'vidorev')?>" src="<?php echo esc_url(vidorev_get_option('vid_director_image', 'vid_director_settings', ''));?>">
					</div>
				<?php
				}elseif(is_post_type_archive('vid_series') && vidorev_get_option('vid_series_image', 'vid_series_settings', '')!=''){
				?>
					<div class="archive-img">							
						<img alt="<?php echo esc_attr__('Series image', 'vidorev')?>" src="<?php echo esc_url(vidorev_get_option('vid_series_image', 'vid_series_settings', ''));?>">
					</div>
				<?php
				}else{
				?>
					<div class="archive-img-lev"></div>
				<?php
				}
				?>
				<div class="archive-text">
					<h1 class="archive-title h2 extra-bold"><?php echo esc_html(get_the_archive_title());?></h1>
					<div class="entry-meta post-meta meta-font">
						<div class="post-meta-wrap">
							<div class="archive-found-post">
								<i class="fa fa-rss" aria-hidden="true"></i>
								<span><?php echo esc_html(apply_filters('vidorev_number_format', $GLOBALS['wp_query']->found_posts));?> <?php echo esc_html__('Posts', 'vidorev');?></span>
							</div>
						</div>
					</div>
					<div class="category-sort font-size-12">
						<ul class="sort-block sort-block-control">
							<li class="sort-block-list">
							
								<span class="default-item" data-sort="latest">
									<span><?php esc_html_e('Sort by', 'vidorev');?>:</span> 
									<span>
										<?php 
											$default_query_string = esc_html__('Latest', 'vidorev');;
											if(isset($_GET['archive_query']) && trim($_GET['archive_query'])!=''){
												$swi_archive_query = sanitize_text_field(trim($_GET['archive_query']));
												switch($swi_archive_query){
													case 'latest':
														$default_query_string = esc_html__('Latest', 'vidorev');
														break;
													
													case 'comment':
														$default_query_string =  esc_html__('Most commented', 'vidorev');
														break;
														
													case 'view':
														$default_query_string = esc_html__('Most viewed', 'vidorev');
														break;
														
													case 'like':
														$default_query_string = esc_html__('Most liked', 'vidorev');
														break;
														
													case 'title':
														$default_query_string = esc_html__('Title', 'vidorev');
														break;	
														
													case 'mostsubscribed':
														$default_query_string = esc_html__('Most Subscribed', 'vidorev');
														break;	
														
													case 'highest_rated':
														$default_query_string = esc_html__('Highest Rated', 'vidorev');
														break;						
												}
											}
											echo esc_html($default_query_string);
										?>
									</span>
									&nbsp; 
									<i class="fa fa-angle-double-down" aria-hidden="true"></i>
								</span>
								
								<?php 
								$archive_url = add_query_arg( array('paged' => '1'), vidorev_get_nopaging_url());
								$current_alp = (isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!='')?sanitize_text_field(trim($_GET['alphabet_filter'])):'';
								?>
								
								<ul class="sort-items">
									<li class="sort-item"><a href="<?php echo esc_url(add_query_arg(array('archive_query' => 'latest', 'alphabet_filter' => $current_alp), $archive_url));?>" title="<?php esc_attr_e('Latest', 'vidorev');?>"><?php esc_html_e('Latest', 'vidorev');?></a></li>									
									<li class="sort-item"><a href="<?php echo esc_url(add_query_arg(array('archive_query' => 'comment', 'alphabet_filter' => $current_alp), $archive_url));?>" title="<?php esc_attr_e('Most commented', 'vidorev');?>"><?php esc_html_e('Most commented', 'vidorev');?></a></li>
									<?php if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){?>
										<li class="sort-item"><a href="<?php echo esc_url(add_query_arg(array('archive_query' => 'view', 'alphabet_filter' => $current_alp), $archive_url));?>" title="<?php esc_attr_e('Most viewed', 'vidorev');?>"><?php esc_html_e('Most viewed', 'vidorev');?></a></li>
									<?php }?>
									
									<?php if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){?>
										<li class="sort-item"><a href="<?php echo esc_url(add_query_arg(array('archive_query' => 'like', 'alphabet_filter' => $current_alp), $archive_url));?>" title="<?php esc_attr_e('Most liked', 'vidorev');?>"><?php esc_html_e('Most liked', 'vidorev');?></a></li>
									<?php }?>
									
									<li class="sort-item"><a href="<?php echo esc_url(add_query_arg(array('archive_query' => 'title', 'alphabet_filter' => $current_alp), $archive_url));?>" title="<?php esc_attr_e('Title', 'vidorev');?>"><?php esc_html_e('Title', 'vidorev');?></a></li>
									
									<?php if(defined('CHANNEL_PM_PREFIX') && ( is_post_type_archive('vid_channel') || is_tax('vid_channel_cat') )){?>
										<li class="sort-item"><a href="<?php echo esc_url(add_query_arg(array('archive_query' => 'mostsubscribed', 'alphabet_filter' => $current_alp), $archive_url));?>" title="<?php esc_attr_e('Most Subscribed', 'vidorev');?>"><?php esc_html_e('Most Subscribed', 'vidorev');?></a></li>
									<?php }?>
									
									<?php if(defined('YASR_LOG_TABLE') && ( is_home() || is_category() )){?>
										<li class="sort-item"><a href="<?php echo esc_url(add_query_arg(array('archive_query' => 'highest_rated', 'alphabet_filter' => $current_alp), $archive_url));?>" title="<?php esc_attr_e('Highest Rated', 'vidorev');?>"><?php esc_html_e('Highest Rated', 'vidorev');?></a></li>
									<?php }?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php																						
			do_action( 'vidorev_html_switch_mode', $archive_style );	
			
			if(vidorev_get_redux_option('blog_alphabet_filter', 'on', 'switch')=='on' && class_exists('vidorev_like_view_sorting')){							
			?>
				<div class="alphabet-filter-icon alphabet-filter-control">
					<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
				</div>
			<?php 
			}
			?>																
		</div>
	<?php
	}
}
add_action( 'vidorev_archive_heading', 'vidorev_archive_heading', 10, 1 );

if(!function_exists('vidorev_archive_alphabet_filter')){
	function vidorev_archive_alphabet_filter(){
		if(vidorev_get_redux_option('blog_alphabet_filter', 'on', 'switch')=='off' || !class_exists('vidorev_like_view_sorting')){
			return;
		}
		
		$letters = trim(vidorev_get_redux_option('blog_alphabet_filter_list', ''));
		
		if($letters == ''){		
			$alphas = range('A', 'Z');
		}else{
			$alphas = explode(',', $letters);
			if( !is_array($alphas) || count($alphas) == 0 ){
				$alphas = range('A', 'Z');
			}
		}
		
		$archive_url = add_query_arg( array('paged' => '1'), vidorev_get_nopaging_url());
		$current_alp = (isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!='')?sanitize_text_field(trim($_GET['alphabet_filter'])):'';
		$current_sor = (isset($_GET['archive_query']) && trim($_GET['archive_query'])!='')?sanitize_text_field(trim($_GET['archive_query'])):'';
		?>
		<div class="alphabet-filter">			
			<div class="alphabet-filter-wrap">
				<a href="<?php echo esc_url(add_query_arg(array('alphabet_filter' => '', 'archive_query' => $current_sor), $archive_url));?>" class="<?php if('' == $current_alp){echo esc_attr('active-item');}?>"><?php echo esc_html__('ALL', 'vidorev')?></a>
			<?php
				foreach($alphas as $alpha){
					$alpha = trim($alpha);
				?>
					<a href="<?php echo esc_url(add_query_arg(array('alphabet_filter' => $alpha, 'archive_query' => $current_sor), $archive_url));?>" class="<?php if($alpha == $current_alp){echo esc_attr('active-item');}?>"><?php echo esc_html($alpha)?></a>
				<?php	
				}
			?>
			</div>
		</div>
		<?php
	}
}
add_action( 'vidorev_archive_alphabet_filter', 'vidorev_archive_alphabet_filter', 10, 1 );

if ( !function_exists('vidorev_load_videos_in_watch_later' ) ):
	function vidorev_load_videos_in_watch_later(){
		$post_id = get_the_ID();
		
		if($post_id != vidorev_get_redux_option('watch_page', '')){			
			return;
		}
		
		global $watch_later_cookie;
		if(!isset($watch_later_cookie) || !is_array($watch_later_cookie)){
			$watch_later_cookie = array();
		}
		
		$post_query = $watch_later_cookie;
		
		if(!is_array($post_query) || count($post_query)<1){
			get_template_part( 'template-parts/content', 'none' );
			return;
		}
				
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($post_query) ? $post_query : array(),
			'tax_query' 			=> array(
											array(
												'taxonomy'  => 'post_format',
												'field'    	=> 'slug',
												'terms'     => array('post-format-video'),
												'operator'  => 'IN',
											),
										),
		);
		
		$watch_query = new WP_Query($args_query);
		
		if($watch_query->have_posts()):	
			$archive_style = vidorev_archive_style();									
		?>			
			<div class="archive-heading watch-later-heading"><?php do_action( 'vidorev_html_switch_mode', $archive_style );?></div>
			
			<div class="blog-items blog-items-control watch-later-archive-control site__row <?php echo esc_attr($archive_style);?>">
				<?php									
					while($watch_query->have_posts()):
						$watch_query->the_post();			
						
						get_template_part( 'template-parts/content', $archive_style );
		
					endwhile;
				?>
			</div>
		<?php else :				
			get_template_part( 'template-parts/content', 'none' );				
		endif;
		wp_reset_postdata();
	}
endif;
add_action( 'vidorev_single_page_custom_listing', 'vidorev_load_videos_in_watch_later' );

if ( !function_exists('vidorev_get_channels_by_user_login' ) ):
	function vidorev_get_channels_by_user_login($count_q, $short = true, $date = NULL){
		
		if(!defined('CHANNEL_PM_PREFIX') || !is_user_logged_in() || vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')!='yes' || vidorev_get_option('vid_channel_notifications_fnc', 'vid_channel_notifications_settings', 'yes')!='yes'){			
			return array();
		}
		
		$current_user 	= wp_get_current_user();
		$user_id 		= (int)$current_user->ID;
		
		$channel_query 	= array();
		
		global $wpdb;
		
		$subscriptions = $wpdb->get_results(
			$wpdb->prepare( 
				"SELECT {$wpdb->prefix}usermeta.meta_value
				FROM {$wpdb->prefix}usermeta
				WHERE 1=1 
				AND ({$wpdb->prefix}usermeta.meta_key LIKE %s)
				AND ({$wpdb->prefix}usermeta.meta_key LIKE %s)
				AND ({$wpdb->prefix}usermeta.meta_value LIKE %s) 
				AND ({$wpdb->prefix}usermeta.user_id = %d)
				", 
				'channel_sub_%', '%_'.$user_id, 'channel_sub_%', $user_id
			),
			OBJECT
		);
		
		if($subscriptions){
			foreach($subscriptions as $key => $row){
				$row_channel_id = str_replace('channel_sub_', '', $row->{'meta_value'});
				if(is_numeric($row_channel_id)){
					array_push($channel_query, $row_channel_id);
				}
			};
		}
		
		if(!is_array($channel_query) || count($channel_query)<1){			
			return array();
		}
		
		$meta_query = array('relation' => 'OR');
		
		foreach($channel_query as $channel_item){
			$meta_query[] = array(
								'key' 		=> CHANNEL_PM_PREFIX.'sync_channel',
								'value' 	=> $channel_item,
								'compare' 	=> 'LIKE'
							);
		}
		
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> $count_q,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'tax_query' 			=> array(
											array(
												'taxonomy'  => 'post_format',
												'field'    	=> 'slug',
												'terms'     => array('post-format-video'),
												'operator'  => 'IN',
											),
										),
			'meta_query' 			=> $meta_query,
			'order'					=> 'DESC',
			'orderby' 				=> 'date',						
		);
		
		if($short){		
			$post_new_in_channels = get_posts($args_query);	
			if($post_new_in_channels){				
				return $post_new_in_channels;
			}else{
				return array();
			}
		}else{
			switch($date){
				case 'today':
					$args_query['date_query'] = array(
						array(
							'year'		=> date('Y'),
							'month'		=> date('m'),
							'day'		=> date('d'),
						),										
					);
					
					return $args_query;
					break;
					
				case 'yesterday':
					$args_query['date_query'] = array(
						array(							
							'year'	=> date('Y', strtotime('-1 days')),
							'month'	=> date('m', strtotime('-1 days')),
							'day'	=> date('d', strtotime('-1 days')),
						),					
					);
					
					return $args_query;
					break;
					
				case 'week':
					$args_query['date_query'] = array(
						array(							
							'after'     => date('Y-m-d', strtotime('previous week Sunday')),
           					'before'    => date('Y-m-d', strtotime('next week Monday'))
						),					
					);
					
					return $args_query;
					break;
					
				case 'month':
					$args_query['date_query'] = array(
						array(							
							'year'	=> date('Y'),
							'month'	=> date('m'),
						),					
					);
					
					return $args_query;
					break;		
					
				case 'older':
					$args_query['date_query'] = array(
						array(							
							'before' => array(
								'year'	=> date('Y', strtotime('first day of this month')),
								'month'	=> date('m', strtotime('first day of this month')),
								'day'	=> date('d', strtotime('first day of this month')),
							),
						),					
					);
					
					return $args_query;
					break;				
			}
			
			return array();
		}
	}	
endif;

if ( !function_exists('vidorev_load_channels_in_subscriptions' ) ):
	function vidorev_load_channels_in_subscriptions(){
		$post_id = get_the_ID();
		
		if(!defined('CHANNEL_PM_PREFIX') || !is_user_logged_in() || vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')!='yes' || !is_page() || $post_id != vidorev_get_option('vid_channel_subscribed_page', 'vid_channel_subscribe_settings', '')){			
			return;
		}
		
		$current_user 	= wp_get_current_user();
		$user_id 		= (int)$current_user->ID;
		
		$channel_query = array();
		
		global $wpdb;
		
		$subscriptions = $wpdb->get_results(
			$wpdb->prepare( 
				"SELECT {$wpdb->prefix}usermeta.meta_value
				FROM {$wpdb->prefix}usermeta
				WHERE 1=1 
				AND ({$wpdb->prefix}usermeta.meta_key LIKE %s)
				AND ({$wpdb->prefix}usermeta.meta_key LIKE %s)
				AND ({$wpdb->prefix}usermeta.meta_value LIKE %s) 
				AND ({$wpdb->prefix}usermeta.user_id = %d)
				", 
				'channel_sub_%', '%_'.$user_id, 'channel_sub_%', $user_id
			),
			OBJECT
		);
		
		if($subscriptions){
			foreach($subscriptions as $key => $row){
				$row_channel_id = str_replace('channel_sub_', '', $row->{'meta_value'});
				if(is_numeric($row_channel_id)){
					array_push($channel_query, $row_channel_id);
				}
			};
		}		
		
		if(!is_array($channel_query) || count($channel_query)<1){
			get_template_part( 'template-parts/content', 'none' );
			return;
		}
				
		$args_query = array(
			'post_type'				=> 'vid_channel',
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($channel_query) ? $channel_query : array(),
		);
		
		$subscriptions_query = new WP_Query($args_query);
		
		if($subscriptions_query->have_posts()):	
			$archive_style = vidorev_archive_style();									
		?>						
			<div class="blog-items blog-items-control subscriptions-archive-control site__row <?php echo esc_attr($archive_style);?>">
				<?php									
					while($subscriptions_query->have_posts()):
						$subscriptions_query->the_post();			
						
						get_template_part( 'template-parts/content', $archive_style );
		
					endwhile;
				?>
			</div>
		<?php else :				
			get_template_part( 'template-parts/content', 'none' );				
		endif;
		wp_reset_postdata();
	}
endif;
add_action( 'vidorev_single_page_custom_listing', 'vidorev_load_channels_in_subscriptions' );

if ( !function_exists('vidorev_dropdown_watch_later' ) ):
	function vidorev_dropdown_watch_later(){
				
		global $watch_later_cookie;
		if(!isset($watch_later_cookie) || !is_array($watch_later_cookie)){
			$watch_later_cookie = array();
		}
		
		$post_query = $watch_later_cookie;
		
		if(!is_array($post_query) || count($post_query)<1){
			?>
			<ul class="top-watch-later-listing top-watch-later-listing-control dark-background">
				<li class="top-watch-later-items top-watch-later-control no-video"></li>
				<li class="watch-no-video">
					<div>
						<i class="fa fa-file-video-o" aria-hidden="true"></i><br>
						<?php echo esc_html__('No videos yet!', 'vidorev');?><br>
						<?php echo esc_html__('Click on "Watch later" to put videos here', 'vidorev');?><br>						
					</div>
				</li>
				<li class="view-all-hyperlink view-all-hyperlink-control">
					<?php 
					$watch_page = vidorev_get_redux_option('watch_page', '');
					$r_watch_page = ($watch_page!='' && is_numeric($watch_page))?get_permalink($watch_page):'#';
					?>
					<a href="<?php echo esc_url($r_watch_page);?>" title="<?php echo esc_attr__('View All Videos', 'vidorev')?>" class="basic-button basic-button-default">
						<span><?php echo esc_html__('View all videos', 'vidorev');?></span> &nbsp; <i class="fa fa-play" aria-hidden="true"></i>
					</a>
				</li>
			</ul>
			<?php
			return;
		}
				
		$args_query = array(
			'post_type'				=> 'post',
			'posts_per_page' 		=> -1,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'post__in'				=> is_array($post_query) ? $post_query : array(),
			'tax_query' 			=> array(
											array(
												'taxonomy'  => 'post_format',
												'field'    	=> 'slug',
												'terms'     => array('post-format-video'),
												'operator'  => 'IN',
											),
										),
		);
		
		$watch_query = new WP_Query($args_query);
		?>	
		<ul class="top-watch-later-listing top-watch-later-listing-control dark-background">
			<li class="top-watch-later-items top-watch-later-control">
			<?php 
			if($watch_query->have_posts()):	
				while($watch_query->have_posts()):
					$watch_query->the_post();					
					$post_id = get_the_ID();
					?>						
					<div class="video-listing-item video-listing-item-control" id="post-<?php echo esc_attr($post_id)?>-wl">
						<div class="video-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_top_watch_later_image_size', 'vidorev_thumb_1x1_0x'), apply_filters('vidorev_custom_top_watch_later_image_ratio', 'class-1x1'), 3, NULL); ?></div>
						<div class="video-content">
							<h3 class="h6 post-title"> 
								<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
							</h3>							
						</div>
						<div class="remove-item-watch-later remove-item-watch-later-control" data-id="<?php echo esc_attr($post_id)?>"><i class="fa fa-times" aria-hidden="true"></i></div>
					</div>						
					<?php
				endwhile;
			endif;
			?>	
			</li>
			<li class="watch-no-video watch-no-video-control">
				<div>
					<i class="fa fa-file-video-o" aria-hidden="true"></i><br>
					<?php echo esc_html__('No videos yet!', 'vidorev');?><br>
					<?php echo esc_html__('Click on "Watch later" to put videos here', 'vidorev');?><br>	
				</div>
			</li>
			<li class="view-all-hyperlink view-all-hyperlink-control">
				<?php 
				$watch_page = vidorev_get_redux_option('watch_page', ''); 
				$r_watch_page = ($watch_page!='' && is_numeric($watch_page))?get_permalink($watch_page):'#';
				?>
				<a href="<?php echo esc_url($r_watch_page);?>" title="<?php echo esc_attr__('View All Videos', 'vidorev')?>" class="basic-button basic-button-default">
					<span><?php echo esc_html__('View all videos', 'vidorev');?></span> &nbsp; <i class="fa fa-play" aria-hidden="true"></i>
				</a>
			</li>
		</ul>
		<?php
		wp_reset_postdata();
	}
endif;
add_action('vidorev_dropdown_watch_later', 'vidorev_dropdown_watch_later');

if ( !function_exists('vidorev_dropdown_notifications' ) ):
	function vidorev_dropdown_notifications($new_posts){	
		
		if(!is_array($new_posts) || count($new_posts)<1){
			?>
			<ul class="top-watch-later-listing dark-background">
				<li class="top-watch-later-items no-video"></li>
				<li class="watch-no-video">
					<div>
						<i class="fa fa-file-video-o" aria-hidden="true"></i><br>					
						<?php 
						if(is_user_logged_in()){
						?>
                        	<?php echo esc_html__('No videos yet!', 'vidorev');?><br>
							<?php echo esc_html__('Please subscribe your favorite channels to receive notifications', 'vidorev');?><br><br>
                            <a href="<?php echo esc_url(get_post_type_archive_link( 'vid_channel' ));?>" title="<?php echo esc_attr__('Channels', 'vidorev')?>" class="basic-button basic-button-default">
                                <span><?php echo esc_html__('View All Channels', 'vidorev');?></span> &nbsp; <i class="fa fa-play" aria-hidden="true"></i>
                            </a>
                        <?php
						}else{
						?>
                        	<?php echo esc_html__("Don't miss new videos", 'vidorev');?><br>
							<?php echo esc_html__('Sign in to see updates from your favourite channels', 'vidorev');?><br><br>
                            <?php 
							if(vidorev_get_redux_option('login_user_btn', 'on', 'switch')=='on'){
								$login_url = vidorev_get_option_login_page('cl_login_url');
							?>
                                <a href="<?php echo esc_url($login_url);?>" title="<?php echo esc_attr__('Login', 'vidorev')?>" class="basic-button basic-button-default">
                                    <span><?php echo esc_html__('Sign In', 'vidorev');?></span> &nbsp; <i class="fa fa-user-o" aria-hidden="true"></i>
                                </a>
                            <?php
							}
							?>
                        <?php
						}						
						?><br>						
					</div>
				</li>				
			</ul>
			<?php
			return;
		}
		?>	
		<ul class="top-watch-later-listing dark-background">
			<li class="top-watch-later-items">
			<?php 
				foreach ( $new_posts as $item) :
					?>						
					<div class="video-listing-item">
						<div class="video-img"><?php do_action('vidorev_thumbnail', apply_filters('vidorev_custom_top_notification_image_size', 'vidorev_thumb_1x1_0x'), apply_filters('vidorev_custom_top_notification_image_ratio', 'class-1x1'), 3, $item->ID); ?></div>
						<div class="video-content">
							<h3 class="h6 post-title"> 
								<a href="<?php echo esc_url(vidorev_get_post_url($item->ID)); ?>" title="<?php the_title_attribute(array('post'=>$item->ID)); ?>"><?php echo esc_html(get_the_title($item->ID));?></a> 
							</h3>							
						</div>
					</div>						
					<?php
				endforeach;
			?>	
			</li>			
			<li class="view-all-hyperlink view-all-hyperlink-control">
				<?php 
				$vid_channel_notifications_page = vidorev_get_option('vid_channel_notifications_page', 'vid_channel_notifications_settings', '');				
				$r_vid_channel_notifications_page = ($vid_channel_notifications_page!='' && is_numeric($vid_channel_notifications_page))?get_permalink($vid_channel_notifications_page):'#';
				?>
				<a href="<?php echo esc_url($r_vid_channel_notifications_page);?>" title="<?php echo esc_attr__('View New Videos', 'vidorev')?>" class="basic-button basic-button-default">
					<span><?php echo esc_html__('View New Videos', 'vidorev');?></span> &nbsp; <i class="fa fa-play" aria-hidden="true"></i>
				</a>
			</li>
		</ul>
		<?php
	}
endif;
add_action('vidorev_dropdown_notifications', 'vidorev_dropdown_notifications');

if ( ! function_exists( 'vidorev_instagram_feed' ) ) :
	function vidorev_instagram_feed($position = 'header'){
		$instagram = vidorev_instagram_feed_control();
		if(!is_array($instagram) || !function_exists('sb_instagram_feed_init') || $instagram[0] !='on' || count($instagram) != 2 || $position != $instagram[1]){
			return '';
		}
		
		?>
			<div class="instagram-feed-wrapper <?php echo 'pos-'.esc_attr($position);?>">
				<?php echo do_shortcode('[instagram-feed num=8 cols=8 showheader=false showbutton=false imagepadding=0 followtext="'.esc_html__('@ Follow me', 'vidorev').'" imageres=medium]');?>
			</div>
		<?php
	}
endif;	

add_action( 'vidorev_instagram_feed', 'vidorev_instagram_feed', 10, 1 );

if ( !function_exists( 'vidorev_popular_videos_footer' ) ):
	function vidorev_popular_videos_footer() {
		
		if(function_exists('is_buddypress') && is_buddypress()){
			return '';
		}
		
		$popular_videos 			= '';
		
		$popular_videos_title_1 	= '';
		$popular_videos_title_2 	= '';
		
		$popular_videos_ic 			= '';
		$popular_videos_it 			= '';
		
		if(is_page()){
			$page_id = get_the_ID();
			$popular_videos = get_post_meta($page_id, 'popular_videos', true);
			
			if($popular_videos == 'on'){
				$popular_videos_title_1 = get_post_meta($page_id, 'popular_videos_title_1', true);
				$popular_videos_title_2 = get_post_meta($page_id, 'popular_videos_title_2', true);
				
				$popular_videos_ic = get_post_meta($page_id, 'popular_videos_ic', true);
				$popular_videos_it = get_post_meta($page_id, 'popular_videos_it', true);
			}
		}
		
		if($popular_videos == ''){
			$popular_videos = vidorev_get_redux_option('popular_videos', 'off', 'switch');
			
			if($popular_videos == 'on'){
				$popular_videos_title_1 = trim(vidorev_get_redux_option('popular_videos_title_1', ''));
				$popular_videos_title_2 = trim(vidorev_get_redux_option('popular_videos_title_2', ''));
				
				$popular_videos_ic = trim(vidorev_get_redux_option('popular_videos_ic', ''));
				$popular_videos_it = trim(vidorev_get_redux_option('popular_videos_it', ''));
			}
		}
		
		if($popular_videos == 'off' || !class_exists('vidorev_like_view_sorting') || !class_exists('vidorev_like_dislike_settings') || !class_exists('Post_Views_Counter')){
			return '';
		}		
		
		$category 	= $popular_videos_ic!=''?$popular_videos_ic:'';
		$tag 		= $popular_videos_it!=''?$popular_videos_it:'';
		?>
		
		<div class="popular-video-footer">
			<div class="site__container fullwidth-vidorev-ctrl">
				<div class="site__row">
					<div class="site__col">
						<div class="popular-video-content">
							<div class="site__row">
								<div class="site__col block-left">
									<div class="block-left-content">
										<?php 
										if($popular_videos_title_1!=''){
										?>
											<h2 class="h-font-size-36 h2-tablet extra-bold vid-title-main"><?php echo esc_html($popular_videos_title_1);?></h2>
										<?php 
										}
										if($popular_videos_title_2!=''){
										?>
										<h2 class="h-font-size-48 h1-tablet"><?php echo esc_html($popular_videos_title_2);?></h2>
										<?php
										}
										?>
									</div>
								</div>
								<div class="site__col block-right">
									<?php
									$args_query = array(
										'post_type'				=> 'post',
										'posts_per_page' 		=> 8,
										'post_status' 			=> 'publish',
										'ignore_sticky_posts' 	=> 1,		
									);
									
									$args_re = array('relation' => 'OR');
									
									$args_re[] = 	array(
										'taxonomy'  => 'post_format',
										'field'    	=> 'slug',
										'terms'     => array('post-format-video'),
										'operator'  => 'IN',
									);
									
									if($category!='' || $tag!=''){
										$catArray = array();
										$tagArray = array();
									
										$catExs = explode(',', $category);
										$tagExs = explode(',', $tag);
										
										foreach($catExs as $catEx){	
											if(is_numeric(trim($catEx))){					
												array_push($catArray, trim($catEx));
											}else{
												$slug_cat = get_term_by('slug', trim($catEx), 'category');					
												if($slug_cat){
													$cat_term_id = $slug_cat->term_id;
													array_push($catArray, $cat_term_id);
												}
											}
										}			
										
										foreach($tagExs as $tagEx){	
											if(is_numeric(trim($tagEx))){					
												array_push($tagArray, trim($tagEx));
											}else{
												$slug_tag = get_term_by('slug', trim($tagEx), 'post_tag');									
												if($slug_tag){
													$tag_term_id = $slug_tag->term_id;	
													array_push($tagArray, $tag_term_id);
												}
											}
										}
										
										if(count($catArray) > 0 || count($tagArray) > 0){
											$taxonomies = array();
											
											$def = array(
												'field' 			=> 'id',
												'operator' 			=> 'IN',
											);
											
											if(count($catArray) > 0){
												array_push($taxonomies, 'category');
												$args_cat_query = wp_parse_args(
													array(
														'taxonomy'	=> 'category',
														'terms'		=> $catArray,
													),
													$def
												);
											}
											
											if(count($tagArray) > 0){
												array_push($taxonomies, 'post_tag');
												$args_tag_query = wp_parse_args(
													array(
														'taxonomy'	=> 'post_tag',
														'terms'		=> $tagArray,
													),
													$def
												);
											}
											
											if(count($taxonomies) > 1){
												$args_re[] = array(
													'relation' => 'OR',
													$args_cat_query,
													$args_tag_query,	
												);
											}else{
												if(count($catArray) > 0 && count($tagArray) == 0){
													$args_re[] = $args_cat_query;
												}elseif(count($catArray) == 0 && count($tagArray) > 0){
													$args_re[] = $args_tag_query;
												}
											}			
											
										}
									}
									
									if(count($args_re)>1){
										if(count($args_re)>2){
											$args_re['relation'] = 'AND';
										}
										$args_query['tax_query'] = $args_re;
									}																			
									
									vidorev_like_view_sorting::	vidorev_add_ttt_1();										
									
									$sc_query = new WP_Query($args_query);												
									
									vidorev_like_view_sorting::	vidorev_remove_ttt_1();										
																			
									if($sc_query->have_posts()):											
									?>
										<div class="slider-popular-container">
											<div class="slider-popular-track">
												<div class="slider-popular-list slider-popular-control">
													<?php 
													while($sc_query->have_posts()):
														$sc_query->the_post();
													?>
														<article class="post-item">
															<div class="post-item-wrap">
															
																<?php
																$image_ratio_case = vidorev_image_ratio_case('1x'); 
																do_action('vidorev_thumbnail', apply_filters('vidorev_custom_footer_popular_item_image_size', 'vidorev_thumb_16x9_1x'), apply_filters('vidorev_custom_footer_popular_item_image_ratio', 'class-16x9'), 1, NULL, $image_ratio_case); 
																?>
																
																<div class="listing-content">
																	
																	<?php do_action( 'vidorev_category_element', NULL, 'archive' );?>
																	
																	<h3 class="entry-title h4 h5-mobile post-title"> 
																		<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
																	</h3>
																
																	<?php do_action( 'vidorev_posted_on', array('author', '', '', 'view-count', 'like-count', ''), 'widget' ); ?>		
																
																</div>
																
															</div>
														</article>
													<?php endwhile;?>
												</div>
											</div>
										</div>		
									<?php											
									endif;			
									wp_reset_postdata();
									?>										
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>	
		</div>
		<?php
	}
endif;
add_action( 'vidorev_popular_videos_footer', 'vidorev_popular_videos_footer' );

if ( !function_exists('vidorev_new_videos_today' ) ):
	function vidorev_new_videos_today(){
		global $wpdb;
		
		$post_format = get_term_by('slug', 'post-format-video', 'post_format');
		
		if(!$post_format){
			return '';
		}		
		
		$numposts = 0;		
		$yesterday = date('Y-m-d', strtotime('-1 day')).' 23:59:59';
				
		$numposts = $wpdb->get_var(
			$wpdb->prepare( 
				"SELECT COUNT({$wpdb->prefix}posts.ID)
				FROM {$wpdb->prefix}posts 
				LEFT JOIN {$wpdb->prefix}term_relationships ON ({$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id) 
				WHERE 1=1 
				AND ( {$wpdb->prefix}term_relationships.term_taxonomy_id IN ( %d ) ) 
				AND ({$wpdb->prefix}posts.post_status='publish') 
				AND ({$wpdb->prefix}posts.post_type='post') 
				AND ({$wpdb->prefix}posts.post_date > %s)", 
				($post_format->term_id), $yesterday
			) 
		);

	?>
		<div class="number-of-new-posts dark-background">
			<div class="h1 number-of-posts"><?php echo is_numeric($numposts)?esc_html($numposts):0;?></div>
			<div class="font-size-10 text-one"><?php esc_html_e('New Videos', 'vidorev'); ?></div>
			<div class="font-size-12 text-two"><?php esc_html_e('Today', 'vidorev');?></div>		
		</div>
	<?php	
	}
endif;	
add_action( 'vidorev_new_videos_today', 'vidorev_new_videos_today' );

if ( !function_exists('vidorev_oembed_wrapper' ) ):
	function vidorev_oembed_wrapper( $cache, $url, $attr, $post_ID ) {
		$classes = array();
	
		$classes_all = array(
			'whatever-embed-responsive',
		);
		
		$add_wrapper = false;
	
		if ( false !== strpos( $url, 'vimeo.com' ) || false !== strpos( $url, 'youtube.com' ) || false !== strpos( $url, 'dailymotion.com') || false !== strpos( $url, 'wordpress.tv') ) {
			$classes[] = 'video-ratio-16-9';
			$add_wrapper = true;
		}
		
		if ( false !== strpos( $url, 'twitter.com' ) ) {
			$classes[] = 'twitter-ratio';
			$add_wrapper = true;
		}
	
		$classes = array_merge( $classes, $classes_all );
	
		if($add_wrapper){
			return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $cache . '</div>';
		}else{
			return $cache;
		}
	}
endif;

add_filter( 'embed_oembed_html', 'vidorev_oembed_wrapper', 99, 4 );

if ( !function_exists('vidorev_woocommerce_breadcrumb' ) ):
	function vidorev_woocommerce_breadcrumb($args = array()){
		$args = wp_parse_args( $args, apply_filters( 'vidorev_woocommerce_breadcrumb_custom', array(
			'delimiter'   => '<i class="fa fa-angle-right icon-arrow"></i>',
			'wrap_before' => '<div class="site__row nav-breadcrumbs-elm nav-woocommerce-breadcrumbs"><div class="site__col"><div class="nav-breadcrumbs navigation-font nav-font-size-12"><div class="nav-breadcrumbs-wrap">',
			'wrap_after'  => '</div></div></div></div>',
			'before'      => '',
			'after'       => '',
			'home'        => esc_html_x( 'Home', 'breadcrumb', 'vidorev' ),
		) ) );
		do_action('vidorev_woocommerce_breadcrumb_content', $args);
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );		
	}
endif;
add_action( 'vidorev_woocommerce_breadcrumb', 'vidorev_woocommerce_breadcrumb', 20, 1);
add_action( 'vidorev_woocommerce_breadcrumb_content', 'woocommerce_breadcrumb', 20, 1);

if ( !function_exists('vidorev_woocommerce_premium_download_query_args' ) ):
	function vidorev_woocommerce_premium_download_query_args($product_id){
		return $args_query = array(
					'post_type'				=> 'post',
					'posts_per_page' 		=> -1,
					'post_status' 			=> 'publish',
					'ignore_sticky_posts' 	=> 1,
					'tax_query' 			=> array(
													array(
														'taxonomy'  => 'post_format',
														'field'    	=> 'slug',
														'terms'     => array('post-format-video'),
														'operator'  => 'IN',
													),
											),
					'meta_query'			=> array(
													'relation' => 'AND',
													array(
														'key'     => 'vid_woo_product',
														'type'	  => 'NUMERIC',
														'compare' => '=',
														'value'   => $product_id,
													),
											),						
					'order'					=> 'DESC',
					'orderby'				=> 'date ID',									
				);
	}
endif;

if ( !function_exists('vidorev_woocommerce_tab_download' ) ):
	function vidorev_woocommerce_tab_download($tabs){
		global $product;
		if($product->is_downloadable()){
			$product_id = $product->get_id();
			$video_download = new WP_Query(vidorev_woocommerce_premium_download_query_args($product_id));
			if($video_download->have_posts()):
				global $vidorev_woo_premium_downloads;
				if(!isset($vidorev_woo_premium_downloads) || !is_array($vidorev_woo_premium_downloads)){
					$vidorev_woo_premium_downloads = array();
				}
				
				$current_user 	= wp_get_current_user();
				if($current_user->exists()){					
					$available_downloads 	= wc_get_customer_available_downloads( $current_user->ID );															
					if(!empty($available_downloads) && is_array($available_downloads) && count($available_downloads) > 0){
						foreach($available_downloads as $download_item){
							if($product_id == $download_item['product_id']){								
								$has_buy='<div class="already-purchased-package">'.esc_html__('You\'ve already purchased this download package. Thanks!', 'vidorev').'</div>';
								break;
							}
						}
					}										
				}	
				
				$archive_style = 'list-default'/*vidorev_archive_style()*/;				
				ob_start();
				?>
					<div class="vidorev-woo-premium-download">
						
						<?php if(isset($has_buy) && $has_buy!=''){
							echo apply_filters('vidorev_hasbuy_download_content', $has_buy);
						}?>
						
						<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
							<?php									
								while($video_download->have_posts()):
									$video_download->the_post();		
									
									get_template_part( 'template-parts/content', $archive_style );
					
								endwhile;
							?>
						</div>
					</div>
				<?php
				$output_string = ob_get_contents();
				ob_end_clean();
				
				$vidorev_woo_premium_downloads[$product_id] = $output_string;
			
				$tabs['downloads'] = array(
					'title'    => esc_html__( 'Downloads', 'vidorev' ),
					'priority' => 5,
					'callback' => 'vidorev_woocommerce_premium_download',
				);
			endif;
			wp_reset_postdata();
		}
		
		return $tabs;
	}
endif;
add_filter( 'woocommerce_product_tabs', 'vidorev_woocommerce_tab_download' );

if ( !function_exists('vidorev_woocommerce_premium_download' ) ):
	function vidorev_woocommerce_premium_download(){
		global $product, $vidorev_woo_premium_downloads;
		$product_id = $product->get_id();		
		if($product->is_downloadable() && isset($vidorev_woo_premium_downloads) && isset($vidorev_woo_premium_downloads[$product_id]) && $vidorev_woo_premium_downloads[$product_id]!=''){
			echo apply_filters('vidorev_return_download_product_struc', $vidorev_woo_premium_downloads[$product_id]);
		}
	}
endif;

if ( !function_exists('vidorev_woocommerce_tab_prime_videos' ) ):
	function vidorev_woocommerce_tab_prime_videos($tabs){
		global $product;
		if($product->is_virtual() && !$product->is_downloadable()){
			$product_id = $product->get_id();
			$video_prime = new WP_Query(vidorev_woocommerce_premium_download_query_args($product_id));
			if($video_prime->have_posts()):
				global $vidorev_woo_prime_videos;
				if(!isset($vidorev_woo_prime_videos) || !is_array($vidorev_woo_prime_videos)){
					$vidorev_woo_prime_videos = array();
				}
				
				$current_user 	= wp_get_current_user();
				if($current_user->exists() && wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product_id )){					
					$has_buy='<div class="already-purchased-package">'.esc_html__('You\'ve already purchased this product. Thanks!', 'vidorev').'</div>';									
				}
				
				$archive_style = 'list-default';				
				ob_start();
				?>
					<div class="vidorev-woo-premium-download">
						
						<?php if(isset($has_buy) && $has_buy!=''){
							echo apply_filters('vidorev_hasbuy_prime_video_content', $has_buy);
						}?>
						
						<div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
							<?php									
								while($video_prime->have_posts()):
									$video_prime->the_post();		
									
									get_template_part( 'template-parts/content', $archive_style );
					
								endwhile;
							?>
						</div>
					</div>
				<?php
				$output_string = ob_get_contents();
				ob_end_clean();
				
				$vidorev_woo_prime_videos[$product_id] = $output_string;
			
				$tabs['videos'] = array(
					'title'    => esc_html__( 'Premium Videos', 'vidorev' ),
					'priority' => 5,
					'callback' => 'vidorev_woocommerce_prime_videos',
				);
			endif;
			wp_reset_postdata();
		}
		
		return $tabs;
	}
endif;
add_filter( 'woocommerce_product_tabs', 'vidorev_woocommerce_tab_prime_videos' );

if ( !function_exists('vidorev_woocommerce_prime_videos' ) ):
	function vidorev_woocommerce_prime_videos(){
		global $product, $vidorev_woo_prime_videos;
		$product_id = $product->get_id();		
		if($product->is_virtual() && !$product->is_downloadable() && isset($vidorev_woo_prime_videos) && isset($vidorev_woo_prime_videos[$product_id]) && $vidorev_woo_prime_videos[$product_id]!=''){
			echo apply_filters('vidorev_return_prime_video_product_struc', $vidorev_woo_prime_videos[$product_id]);
		}
	}
endif;

if ( !function_exists('vidorev_rating_system' ) ):
	function vidorev_rating_system($content){
		$post_id 				= get_the_ID();
		
		$user_rating 			= trim(get_post_meta($post_id, 'user_rating', true));		
		
		if($user_rating==''){
			$user_rating 			= vidorev_get_redux_option('user_rating', 'off', 'switch');
			$user_rating_position 	= vidorev_get_redux_option('user_rating_position', 'before');		
			$user_rating_mode 		= vidorev_get_redux_option('user_rating_mode', 'single');
			$user_rating_multi_sets = vidorev_get_redux_option('user_rating_multi_sets', '');
		}else{
			if($user_rating=='on'){
				$user_rating_position 	= trim(get_post_meta($post_id, 'user_rating_position', true));		
				$user_rating_mode 		= trim(get_post_meta($post_id, 'user_rating_mode', true));
				$user_rating_multi_sets = trim(get_post_meta($post_id, 'user_rating_multi_sets', true));
			}else{
				return $content;
			}
		}
		
		$visitor_votes_code		= '';
		
		if($user_rating=='off' || !defined( 'YASR_VERSION_NUM') || get_post_type()!='post' || get_post_format()!='video'){
			return $content;
		}else{
			if($user_rating_mode=='multi-sets'){
				if(!is_numeric($user_rating_multi_sets)){
					return $content;
				}else{
					$visitor_votes_code = '[yasr_visitor_multiset setid="'.$user_rating_multi_sets.'"]';
				}
			}else{
				$visitor_votes_code = '[yasr_visitor_votes size="large"]';
			}
			
			if($user_rating_position=='before'){
				return $visitor_votes_code.$content;
			}else{
				return $content.$visitor_votes_code;
			}
		}			
		
	}
endif;
if (!is_admin()) {
	add_filter( 'the_content', 'vidorev_rating_system' );
}

if ( !function_exists('vidorev_rating_average' ) ):
	function vidorev_rating_average($post_id, $rt_nbov = false){
		if(!isset($post_id)){
			$post_id = get_the_ID();
		}
		
		$user_rating = trim(get_post_meta($post_id, 'user_rating', true));
		
		if($user_rating==''){
			$user_rating 			= vidorev_get_redux_option('user_rating', 'off', 'switch');
			$user_rating_mode 		= vidorev_get_redux_option('user_rating_mode', 'single');
			$user_rating_multi_sets = vidorev_get_redux_option('user_rating_multi_sets', '');
		}else{
			if($user_rating=='on'){				
				$user_rating_mode 		= trim(get_post_meta($post_id, 'user_rating_mode', true));
				$user_rating_multi_sets = trim(get_post_meta($post_id, 'user_rating_multi_sets', true));
			}else{
				return '';
			}
		}
		
		if($user_rating=='off' || !class_exists('YasrDatabaseRatings') || get_post_type($post_id)!='post' || get_post_format($post_id)!='video'){
			return '';
		}else{
			if($user_rating_mode=='multi-sets'){
				if(!is_numeric($user_rating_multi_sets) || !class_exists('YasrMultiSetData')){
					return '';
				}else{
					
					if(!method_exists('YasrMultiSetData', 'returnMultiSetAverage')){
						return '';
					}
					
					$refl = new ReflectionMethod('YasrMultiSetData', 'returnMultiSetAverage');
					
					if(!$refl->isStatic() || !$refl->isPublic()){
						return '';
					}
					
					$multiset_average = YasrMultiSetData::returnMultiSetAverage($post_id, $user_rating_multi_sets, true);
					
					if(is_numeric($multiset_average) && $multiset_average > 0){
						if($rt_nbov){
							
							if(!method_exists('YasrMultiSetData', 'returnVisitorMultiSetContent')){
								return '';
							}
							
							$refl = new ReflectionMethod('YasrMultiSetData', 'returnVisitorMultiSetContent');
					
							if(!$refl->isStatic() || !$refl->isPublic()){
								return '';
							}
							
							$multiset_content = YasrMultiSetData::returnVisitorMultiSetContent($post_id, $user_rating_multi_sets);
							if (!is_array($multiset_content)) {
								return 0;
							}else{
								$multiset_rows_number = 0;
								foreach ($multiset_content as $set_content) {
									$multiset_rows_number = $multiset_rows_number+$set_content['number_of_votes'];
								}
								return $multiset_rows_number;
							}
						}
						
						return $multiset_average;
					}else{
						return '';
					}
					
					return $multiset_average;
				}
			}else{
				
				if(!method_exists('YasrDatabaseRatings', 'getVisitorVotes')){
					return '';
				}
				
				$refl = new ReflectionMethod('YasrDatabaseRatings', 'getVisitorVotes');
					
				if(!$refl->isStatic() || !$refl->isPublic()){
					return '';
				}
				
				$votes			= YasrDatabaseRatings::getVisitorVotes($post_id);
				$medium_rating	= 0;
				 
				if (!$votes || !is_array($votes) || !isset($votes['number_of_votes']) || !isset($votes['sum_votes'])) {
					$votes			= 0;
					$votes_number	= 0;
					return '';
				}else {					
					$medium_rating = ($votes['sum_votes']>0 && $votes['number_of_votes']>0)?($votes['sum_votes']/$votes['number_of_votes']):0;					
					if($rt_nbov){
						return $votes['number_of_votes'];
					}					
				}
				
				$medium_rating = round($medium_rating, 1);
				
				if($medium_rating > 0){
					return $medium_rating;
				}else{
					return '';
				}
			}
		}
	}
endif;

if(!function_exists('vidorev_special_author_box')){
	function vidorev_special_author_box(){
		if(vidorev_single_video_style()!='clean' || vidorev_get_redux_option('single_post_author', 'off', 'switch')=='off'){
			return;
		}
		
		$channel_id = beeteam368_get_channel_by_post_id(get_the_ID());
	?>
    	<div class="author-box special-style">
            <div class="author-box-body">
            	<?php if($channel_id>0){
					$subscribed_count = vidorev_count_channel_subscribed('channel_sub_'.$channel_id);
					if($subscribed_count == 1){
						$subscribed_text = esc_html__('Subscriber', 'vidorev');
					}else{
						$subscribed_text = esc_html__('Subscribers', 'vidorev');
					}		
				?>
                	<div class="author-box-avatar">
                        <a href="<?php echo esc_url(get_permalink( $channel_id )); ?>" class="author-avatar">                        	
                            <?php 
							$image_ratio_case = vidorev_image_ratio_case('1x');
							do_action('vidorev_thumbnail', apply_filters('vidorev_custom_special_channel_box_image_size', 'vidorev_thumb_1x1_0x'), apply_filters('vidorev_custom_special_channel_box_image_ratio', 'class-1x1'), 7, $channel_id, $image_ratio_case); 
							?>
                        </a>
                    </div>
                    <div class="author-box-content">
                        <h4 class="author-name h5 extra-bold"><a href="<?php echo esc_url(get_permalink( $channel_id )); ?>"><?php echo esc_html(get_the_title( $channel_id )); ?></a></h4> 
                        <div class="entry-meta post-meta meta-font">
                            <div class="post-meta-wrap">   
                            	<div class="subscribers"><i class="fa fa-users" aria-hidden="true"></i><span><?php echo esc_html($subscribed_count);?></span> <span><?php echo esc_html($subscribed_text);?></span></div>
                            </div>
                        </div>                                                    
                    </div>
                <?php	
				}else{?>
                    <div class="author-box-avatar">
                        <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>" class="author-avatar">
                            <?php echo get_avatar( get_the_author_meta('email'), 130 ); ?>
                        </a>
                    </div>
                    <div class="author-box-content">
                        <h4 class="author-name h5 extra-bold"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"><?php the_author_meta( 'display_name' ); ?></a></h4>
                        <?php do_action('vidorev_author_social_follow');?>                                  
                    </div>
                <?php }?>
                <div class="author-subscribe">
					<?php do_action( 'vidorev_channel_sub_btn', beeteam368_get_channel_by_post_id(get_the_ID()), ''); ?>
                </div> 
            </div>
        </div>
	<?php	
	}
}

add_action( 'vidorev_special_author_box', 'vidorev_special_author_box' );

if(!function_exists('vidorev_special_channel_box')){
	function vidorev_special_channel_box(){
		if(vidorev_single_video_style()=='clean' && vidorev_get_redux_option('single_post_author', 'off', 'switch')=='on'){
			return;
		}
		
		$channel_id = beeteam368_get_channel_by_post_id(get_the_ID());
		
		if($channel_id>0){
			$subscribed_count = vidorev_count_channel_subscribed('channel_sub_'.$channel_id);
			if($subscribed_count == 1){
				$subscribed_text = esc_html__('Subscriber', 'vidorev');
			}else{
				$subscribed_text = esc_html__('Subscribers', 'vidorev');
			}
	?>
            <div class="author-box special-style">
                <div class="author-box-body">
                    <div class="author-box-avatar">
                        <a href="<?php echo esc_url(get_permalink( $channel_id )); ?>" class="author-avatar">                        	
                            <?php 
							$image_ratio_case = vidorev_image_ratio_case('1x');
							do_action('vidorev_thumbnail', apply_filters('vidorev_custom_special_channel_box_image_size', 'vidorev_thumb_1x1_0x'), apply_filters('vidorev_custom_special_channel_box_image_ratio', 'class-1x1'), 7, $channel_id, $image_ratio_case); 
							?>
                        </a>
                    </div>
                    <div class="author-box-content">
                        <h4 class="author-name h5 extra-bold"><a href="<?php echo esc_url(get_permalink( $channel_id )); ?>"><?php echo esc_html(get_the_title( $channel_id )); ?></a></h4>
                        <div class="entry-meta post-meta meta-font">
                            <div class="post-meta-wrap">   
                            	<div class="subscribers"><i class="fa fa-users" aria-hidden="true"></i><span><?php echo esc_html($subscribed_count);?></span> <span><?php echo esc_html($subscribed_text);?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="author-subscribe">
                        <?php do_action( 'vidorev_channel_sub_btn', $channel_id, ''); ?>   
                    </div> 
                </div>
            </div>
	<?php	
		}
	}
}

add_action( 'vidorev_special_author_box', 'vidorev_special_channel_box' );