<div class="top-content">
	<div class="site__container fullwidth-vidorev-ctrl fullwidth-special-hd container-control">
		<div class="site__row auto-width">
			
			<div class="site__col float-left nav-logo">
				<div class="nav-logo-img">
					<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name'));?>" class="logo-link">
						<?php do_action( 'vidorev_main_logo_retina' );?>
					</a>
				</div>
			</div>			
			
			<div class="site__col float-right top-ad">				
				<?php do_action( 'vidorev_top_header_content_ads' );?>					
			</div>
		</div>
	</div>
</div>

<?php do_action( 'vidorev_top_header_ads_mobile' );?>	

<div class="nav-sp-wrapper">
	
	<?php do_action('vidorev_new_videos_today');?>
	
	<div class="nav-wrap nav-wrap-control">
		<div class="main-nav main-nav-control">
			<div class="site__container fullwidth-vidorev-ctrl fullwidth-special-hd container-control">
				<div class="site__row auto-width">
					
					<div class="site__col float-left nav-logo">
						<div class="nav-logo-img">
							<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name'));?>" class="logo-link">
								<?php do_action( 'vidorev_main_logo_retina' );?>
							</a>
						</div>
					</div>
					
					<div class="site__col float-left nav-menu nav-menu-control navigation-font">
						<ul>
							<?php do_action( 'vidorev_display_main_menu' );?>
						</ul>
					</div>
					
					<div class="site__col float-left nav-mobile-menu">
						<?php do_action( 'vidorev_button_nav_mobile_menu' );?>
					</div>
					
					<div class="site__col float-right top-search-box-mobile">
						<?php do_action( 'vidorev_search_mobile_menu' );?>
					</div>
                    
                    <div class="site__col float-right top-login-box-mobile">
						<?php do_action( 'vidorev_login_mobile_menu' );?>
					</div>	
					
					<div class="site__col float-right top-search-box">
						<?php do_action( 'vidorev_top_search_box' );?>
					</div>
				
				</div>
			</div>
		</div>
	</div>
	
	<div class="top-nav top-nav-control dark-background">
		<div class="site__container fullwidth-vidorev-ctrl fullwidth-special-hd container-control">
			<div class="site__row auto-width">						
				
				<?php do_action( 'vidorev_topnav_menu', 'left' );?>
				
				<div class="site__col float-left top-videos">
					<div class="top-video-content">
						<div class="top-video-wrap dinginess-background">
							<?php do_action( 'vidorev_top_header_posts_slider' );?>
						</div>
					</div>								
				</div>
				
				<?php do_action( 'vidorev_topnav_menu', 'right' );?>
	
				<div class="site__col float-right top-social">
					<div class="top-social-content">
						<?php do_action( 'vidorev_topnav_social_accounts_listing', array('s-grid nav-style', 'watch-later', 'notifications') );?>
						<?php do_action( 'vidorev_topnav_submit_video', array('transparent-style') );?>
					</div>
				</div>
				
				<?php do_action( 'vidorev_topnav_menu', 'b-right' );?>
				
			</div>
		</div>		
	</div>
	
</div>	