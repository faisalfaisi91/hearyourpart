<div class="nav-wrap nav-wrap-control">
	<div class="main-nav main-nav-control">
		<div class="site__container-fluid container-control">
			<div class="site__row auto-width">
				
				<div class="site__col float-left nav-side-menu">
					<?php do_action( 'vidorev_button_nav_side_menu' );?>
				</div>
				
				<div class="site__col nav-logo">
					<div class="nav-logo-img">
						<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name'));?>" class="logo-link">
							<?php do_action( 'vidorev_main_logo_retina' );?>
						</a>
					</div>
				</div>
				
				<!--<div class="site__col float-left top-search-box">-->
					<?php 
				// 	if(vidorev_ajax_search() == 'on'){
				// 		echo do_shortcode('[wpdreams_ajaxsearchlite]');
				// 	}else{
						//do_action( 'vidorev_top_search_box' );
				// 	}
					?>
				<!--</div>-->
				
				<!--<div class="site__col float-right top-submit-video">-->
					<?php //do_action( 'vidorev_topnav_submit_video', array('white-style') );?>	
				<!--</div>-->
				
				<div class="site__col float-left nav-mobile-menu">
					<?php do_action( 'vidorev_button_nav_mobile_menu' );?>
				</div>
				
				<div class="site__col float-right top-search-box-mobile">
					<?php do_action( 'vidorev_search_mobile_menu' );?>
				</div>	
                
                <div class="site__col float-right top-login-box-mobile">
					<?php do_action( 'vidorev_login_mobile_menu' );?>
				</div>
			
			</div>
		</div>
	</div>
</div>