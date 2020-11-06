<?php
	$extra_class = '';	
	$color_mode = '';
	
	if(is_page()){	
		$color_mode = get_post_meta(get_the_ID(), 'color_mode', true);				
	}	
	if(function_exists('is_woocommerce') && is_woocommerce()){
		$color_mode = vidorev_get_redux_option('woo_color_mode', '');
	}			
	if($color_mode==''){				
		$color_mode = vidorev_get_redux_option('color_mode', 'white');
	}
	$color_mode_clss_string = '';				
	if ( $color_mode == 'dark' ) {			
		$color_mode_clss_string = ' dark-background dark-version';
	}
?>
<div class="side-menu-wrapper side-menu-wrapper-control<?php echo esc_attr($color_mode_clss_string);?>">
				
	<div class="left-side-menu dark-background">
		<?php do_action( 'vidorev_topnav_social_accounts_listing', array('s-grid', 'watch-later', 'notifications') );?>
	</div>
	
	<div class="side-menu-children side-menu-children-control">
		<div class="main-side-menu navigation-font">
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
		</div>
		
		<div class="sidemenu-sidebar">
			<?php dynamic_sidebar( 'sidemenu-sidebar' ); ?>
		</div>
	</div>
</div>