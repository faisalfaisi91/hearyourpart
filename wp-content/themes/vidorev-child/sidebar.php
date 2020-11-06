<?php if(is_active_sidebar( 'vidorev-bbpress-1' ) && function_exists('is_bbpress') && is_bbpress() ){?>
	<aside id="main-sidebar" class="site__col main-sidebar main-sidebar-control vidorev-bbpress-sidebar">
		<div class="sidebar-content sidebar-content-control">
			<div class="sidebar-content-inner sidebar-content-inner-control">
				<?php dynamic_sidebar( 'vidorev-bbpress-1' ); ?>
			</div>
		</div>
	</aside>
<?php
}elseif(is_active_sidebar('woo-sidebar-1') && function_exists('is_woocommerce') && is_woocommerce()){
	$sidebarControl = vidorev_sidebar_control();
	if($sidebarControl!='hidden'){
?>
        <aside id="main-sidebar" class="site__col main-sidebar main-sidebar-control vidorev-woocommerce-sidebar">
            <div class="sidebar-content sidebar-content-control">
                <div class="sidebar-content-inner sidebar-content-inner-control">
                    <?php dynamic_sidebar( 'woo-sidebar-1' ); ?>
                </div>
            </div>
        </aside>
<?php
	}
}elseif(is_active_sidebar( 'main-sidebar' ) ) {
?>
	<aside id="main-sidebar" class="site__col main-sidebar main-sidebar-control">
		<div class="sidebar-content sidebar-content-control">
			<div class="sidebar-content-inner sidebar-content-inner-control">
				<?php dynamic_sidebar( 'main-sidebar' ); ?>
			</div>
		</div>
	</aside>
<?php }?>	