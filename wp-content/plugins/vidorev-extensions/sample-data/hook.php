<?php
if(!function_exists('vidorev_theme_control_panel_data')){
	function vidorev_theme_control_panel_data(){
		$ready_all_plugin = true;
		if(	!is_plugin_active( 'clean-login/clean-login.php' )
			|| !is_plugin_active( 'elementor/elementor.php' )
			|| !is_plugin_active( 'post-views-counter/post-views-counter.php' )
			|| !is_plugin_active( 'redux-framework/redux-framework.php' )
			|| !is_plugin_active( 'wp-pagenavi/wp-pagenavi.php' )			
			|| !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' )
		){
			$ready_all_plugin = false;
		}
		
		$ready_all_plugin_fake = true;
		if(	!is_plugin_active( 'post-views-counter/post-views-counter.php' )
			|| !is_plugin_active( 'redux-framework/redux-framework.php' )
		){
			$ready_all_plugin_fake = false;
		}
		?>
		<div class="wrap">
			<h2><strong><?php echo esc_html__("VIDOREV DASHBOARD", 'vidorev-extensions')?></strong></h2>    
			
			<div id="link-to-newpageconfig">
                <div class="tc-information">
                    <div><strong><?php echo esc_html__('Congratulation! Sample data has been successfully imported.', 'vidorev-extensions')?></strong></div>
                </div>
                <div class="tb-infor-error"><?php echo esc_html__('Processing failed, please try again!', 'vidorev-extensions')?></div>
            </div>
			
			<div class="vidorev-dashboard-wrapper">
				<div class="dashboard-row">
					<div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("THEME OPTIONS", 'vidorev-extensions');?></h3>
							<div class="sub-title"></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/themeoptions.png';?>">
							<a href="<?php echo admin_url('admin.php?page=edit_theme_options');?>" class="button button-primary button-large"><?php echo esc_attr__("MANAGE", 'vidorev-extensions')?></a>
						</div>
					</div>
					<div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("LIKE/DISLIKE SETTINGS", 'vidorev-extensions');?></h3>
							<div class="sub-title"></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/like.png';?>">
							<a href="<?php echo admin_url('admin.php?page=vid_like_dislike_settings');?>" class="button button-primary button-large"><?php echo esc_attr__("MANAGE", 'vidorev-extensions')?></a>
						</div>
					</div>
					<div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("VIDEO ADVERTISING", 'vidorev-extensions');?></h3>
							<div class="sub-title"><?php echo esc_html__("VIDEO ADVERTISING MANAGER", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/video-ads.png';?>">
							<a href="<?php echo admin_url('admin.php?page=vid_ads_m_videoads_settings_page');?>" class="button button-primary button-large"><?php echo esc_attr__("MANAGE", 'vidorev-extensions')?></a>
						</div>
					</div>
					<div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("VIDEO PLAYLISTS", 'vidorev-extensions');?></h3>
							<div class="sub-title"><?php echo esc_html__("VIDEO PLAYLIST MANAGER", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/playlist.png';?>">
							<a href="<?php echo admin_url('edit.php?post_type=vid_playlist');?>" class="button button-primary button-large"><?php echo esc_attr__("MANAGE", 'vidorev-extensions')?></a>
						</div>
					</div>
					<div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("VIDEO ACTORS", 'vidorev-extensions');?></h3>
							<div class="sub-title"></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/actor-icon.png';?>">
							<a href="<?php echo admin_url('edit.php?post_type=vid_actor');?>" class="button button-primary button-large"><?php echo esc_attr__("MANAGE", 'vidorev-extensions')?></a>
						</div>
					</div>
					<div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("VIDEO DIRECTORS", 'vidorev-extensions');?></h3>
							<div class="sub-title"></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/director.png';?>">
							<a href="<?php echo admin_url('edit.php?post_type=vid_director');?>" class="button button-primary button-large"><?php echo esc_attr__("MANAGE", 'vidorev-extensions')?></a>
						</div>
					</div>
					<div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("DOCUMENTATION", 'vidorev-extensions');?></h3>
							<div class="sub-title"><?php echo esc_html__("VIEWING ONLINE DOCUMENTATION", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/document.png';?>">
							<a href="https://beeteam368.net/vidorev-doc" class="button button-primary button-large" target="_blank"><?php echo esc_attr__("VIEW", 'vidorev-extensions')?></a>
						</div>
					</div>
                    <!--
					<div class="dashboard-col">
						<div class="col-content">
							<h3><?php echo esc_html__("IMPORT SAMPLE DATA", 'vidorev-extensions')?></h3>
							<div class="sub-title"><?php echo esc_html__("LIGHT VERSION ( MINIMAL )", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/light-version.jpg';?>">
							<input type="button" class="button button-primary button-large import-data-control <?php echo !$ready_all_plugin?'disable-button':'';?>" data-version="light" value="<?php echo esc_attr__("IMPORT", 'vidorev-extensions')?>">
							<?php if(!$ready_all_plugin){?>
								<div class="install-plugin-required"><?php echo esc_html__('You can install sample data after installing all required plugins. Go to "Appearance" -> "Install Plugins" to install and activate recommended plugins.', 'vidorev-extensions')?></div>
							<?php }?>
						</div>
					</div>
					<div class="dashboard-col">
						<div class="col-content">
							<h3><?php echo esc_html__("IMPORT SAMPLE DATA", 'vidorev-extensions')?></h3>
							<div class="sub-title"><?php echo esc_html__("DARK VERSION ( MINIMAL )", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/dark-version.jpg';?>">
							<input type="button" class="button button-primary button-large import-data-control <?php echo !$ready_all_plugin?'disable-button':'';?>" data-version="dark" value="<?php echo esc_attr__("IMPORT", 'vidorev-extensions')?>">
							<?php if(!$ready_all_plugin){?>
								<div class="install-plugin-required"><?php echo esc_html__('You can install sample data after installing all required plugins. Go to "Appearance" -> "Install Plugins" to install and activate recommended plugins.', 'vidorev-extensions')?></div>
							<?php }?>
						</div>
					</div>
                    -->
					<div class="dashboard-col">
						<div class="col-content">
							<h3><?php echo esc_html__("IMPORT SAMPLE DATA", 'vidorev-extensions')?></h3>
							<div class="sub-title"><?php echo esc_html__("MAIN DEMO", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/header-1.jpg';?>">
							<input type="button" class="button button-primary button-large import-data-control <?php echo !$ready_all_plugin?'disable-button':'';?>" data-version="full" value="<?php echo esc_attr__("IMPORT", 'vidorev-extensions')?>">
							<?php if(!$ready_all_plugin){?>
								<div class="install-plugin-required"><?php echo esc_html__('You can install sample data after installing all required plugins. Go to "Appearance" -> "Install Plugins" to install and activate recommended plugins.', 'vidorev-extensions')?></div>
							<?php }?>
						</div>
					</div>
                    <div class="dashboard-col">
						<div class="col-content">
							<h3><?php echo esc_html__("IMPORT SAMPLE DATA", 'vidorev-extensions')?></h3>
							<div class="sub-title"><?php echo esc_html__("FULL-WIDTH DEMO", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/header-7.jpg';?>">
							<input type="button" class="button button-primary button-large import-data-control <?php echo !$ready_all_plugin?'disable-button':'';?>" data-version="full-width" value="<?php echo esc_attr__("IMPORT", 'vidorev-extensions')?>">
							<?php if(!$ready_all_plugin){?>
								<div class="install-plugin-required"><?php echo esc_html__('You can install sample data after installing all required plugins. Go to "Appearance" -> "Install Plugins" to install and activate recommended plugins.', 'vidorev-extensions')?></div>
							<?php }?>
						</div>
					</div>
                    <div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("METRIC CHANGES", 'vidorev-extensions')?></h3>
							<div class="sub-title"><?php echo esc_html__("LIKES/DISLIKES - Random", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/like.png';?>">
							<input type="button" class="button button-primary button-large change-likes-dislikes-control <?php echo !$ready_all_plugin_fake?'disable-button':'';?>" data-version="full-width" value="<?php echo esc_attr__("CHANGE", 'vidorev-extensions')?>">
							<?php if(!$ready_all_plugin_fake){?>
								<div class="install-plugin-required"><?php echo esc_html__('You can only use this feature after installing all required plugins. Go to "Appearance" -> "Install Plugins" to install and activate recommended plugins.', 'vidorev-extensions')?></div>
							<?php }?>
						</div>
					</div>                    
                    
                    <div class="dashboard-col documentation">
						<div class="col-content">
							<h3><?php echo esc_html__("UPGRADES CHANNELS/PLAYLISTS ", 'vidorev-extensions')?></h3>
							<div class="sub-title"><?php echo esc_html__("Converts data type from integer to string", 'vidorev-extensions')?></div>
							<img src="<?php echo get_template_directory_uri() . '/img/to-pic/icon-convert-2.jpg';?>">
							<input type="button" class="button button-primary button-large upgrade-channels-playlists-control" data-version="full-width" value="<?php echo esc_attr__("UPGRADE", 'vidorev-extensions')?>">
						</div>
					</div>
                                        
				</div>
			</div>	
            
            <div id="link-to-newpageconfig">
                <div class="tc-information">
                    <div><strong><?php echo esc_html__('Congratulation! Sample data has been successfully imported.', 'vidorev-extensions')?></strong></div>
                </div>
                <div class="tb-infor-error"><?php echo esc_html__('Processing failed, please try again!', 'vidorev-extensions')?></div>
            </div>
            		
		</div>
		<div id="loading-import-sample-data">
			<div>
				<div class="cssload-wrap">
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
					<div class="cssload-circle"></div>
				</div>
				<?php echo esc_html__('Processing ( in about 10 minutes or so ). Please wait a few minutes and do not close the browser...', 'vidorev-extensions');?>
				
			</div>
		</div>		
		<script>
			;(function($){
				$(document).ready(function(){					
					$('.import-data-control').on('click', function(){
						var $t 				= $(this),
							version 		= $t.attr('data-version'),
							text_confirm	= '<?php echo esc_html__("Import LIGHT version?", 'vidorev-extensions');?>';
						
						if(version == 'full-width'){
							text_confirm	= '<?php echo esc_html__("Import FULL-WIDTH version?", 'vidorev-extensions');?>';
						}else if(version == 'full'){
							text_confirm	= '<?php echo esc_html__("Import MAIN version?", 'vidorev-extensions');?>';
						}
						
						if(confirm(text_confirm)){
							$('#loading-import-sample-data').addClass('active-sample');
							
							window.onbeforeunload = function(){ 
								return false;
							}
							
							var newParamsRequest = {'addsample':'yes', action:'vidorev_setupsampledata', 'version': version};
							$t.addClass('disable-button');
							$('.tc-information, .tb-infor-error').removeClass('active-infor');
							$.ajax({
								url:		'<?php echo admin_url('admin-ajax.php');?>',						
								type: 		'POST',
								data:		newParamsRequest,
								dataType: 	'html',
								cache:		false,
								success: 	function(data){
									
									$('.tc-information').addClass('active-infor').find('strong').text('<?php echo esc_html__("Congratulation! Sample data has been successfully imported!!!", 'vidorev-extensions');?>');
									$('#loading-import-sample-data').removeClass('active-sample');	
									
									window.onbeforeunload = null;
								},
								error:		function(){
									
									$t.removeClass('disable-button');
									$('.tb-infor-error').addClass('active-infor');	
									$('#loading-import-sample-data').removeClass('active-sample');
									
									window.onbeforeunload = null;
									
								},
							});	
							
							return false;
						}else{
							return false;
						}
					});
					
					$('.change-likes-dislikes-control').on('click', function(){
						var $t 				= $(this),
							text_confirm	= '<?php echo esc_html__("Do you want to continue?", 'vidorev-extensions');?>';
						
						if(confirm(text_confirm)){
							$('#loading-import-sample-data').addClass('active-sample');
							
							window.onbeforeunload = function(){ 
								return false;
							}
							
							var newParamsRequest = {action:'vidorev_changemetricld', 'change':'yes'};
							$t.addClass('disable-button');
							$('.tc-information, .tb-infor-error').removeClass('active-infor');
							$.ajax({
								url:		'<?php echo admin_url('admin-ajax.php');?>',						
								type: 		'POST',
								data:		newParamsRequest,
								dataType: 	'html',
								cache:		false,
								success: 	function(data){
									
									$('.tc-information').addClass('active-infor').find('strong').text('<?php echo esc_html__("The data have been updated!!!", 'vidorev-extensions');?>');
									$('#loading-import-sample-data').removeClass('active-sample');	
									$t.removeClass('disable-button');
									
									window.onbeforeunload = null;
								},
								error:		function(){
									
									$t.removeClass('disable-button');
									$('.tb-infor-error').addClass('active-infor');	
									$('#loading-import-sample-data').removeClass('active-sample');
									
									window.onbeforeunload = null;
									
								},
							});	
							
							return false;
						}else{
							return false;
						}
					});
										
					$('.upgrade-channels-playlists-control').on('click', function(){
						var $t 				= $(this),
							text_confirm	= '<?php echo esc_html__("Do you want to continue?", 'vidorev-extensions');?>';
						
						if(confirm(text_confirm)){
							$('#loading-import-sample-data').addClass('active-sample');
							
							window.onbeforeunload = function(){ 
								return false;
							}
							
							var newParamsRequest = {action:'vidorev_upgrade_channels_playlists', 'upgrade':'yes'};
							$t.addClass('disable-button');
							$('.tc-information, .tb-infor-error').removeClass('active-infor');
							$.ajax({
								url:		'<?php echo admin_url('admin-ajax.php');?>',						
								type: 		'POST',
								data:		newParamsRequest,
								dataType: 	'html',
								cache:		false,
								success: 	function(data){									
									$('.tc-information').addClass('active-infor').find('strong').text('<?php echo esc_html__("Older data used on versions lower than 2.9.9.9.6.3 has been updated!!!", 'vidorev-extensions');?>');
									$('#loading-import-sample-data').removeClass('active-sample');	
									$t.removeClass('disable-button');
									
									window.onbeforeunload = null;
								},
								error:		function(){
									
									$t.removeClass('disable-button');
									$('.tb-infor-error').addClass('active-infor');	
									$('#loading-import-sample-data').removeClass('active-sample');
									
									window.onbeforeunload = null;
									
								},
							});	
							
							return false;
						}else{
							return false;
						}
					});
				});
			}(jQuery));
		</script>
		<style>
			.cssload-wrap {
				position: absolute;
				margin: 0 auto 0;
				left: 50%;
				margin-left: -218px;
				transform: rotateX(75deg);
			}
			.cssload-circle {
				position: absolute;
				float: left;
				border: 1px solid white;
				animation: bounce 1.73s infinite ease-in-out alternate;
					-o-animation: bounce 1.73s infinite ease-in-out alternate;
					-ms-animation: bounce 1.73s infinite ease-in-out alternate;
					-webkit-animation: bounce 1.73s infinite ease-in-out alternate;
					-moz-animation: bounce 1.73s infinite ease-in-out alternate;
				border-radius: 100%;
				background: transparent;
				top: -73px;
				left: -73px;
			}
			.cssload-circle:nth-child(1) {
				margin: 0 288px;
				width: 10px;
				height: 10px;
				animation-delay: 115ms;
					-o-animation-delay: 115ms;
					-ms-animation-delay: 115ms;
					-webkit-animation-delay: 115ms;
					-moz-animation-delay: 115ms;
				z-index: -1;
				border: 1px solid rgba(255,43,0,0.7);
			}
			.cssload-circle:nth-child(2) {
				margin: 0 283px;
				width: 19px;
				height: 19px;
				animation-delay: 230ms;
					-o-animation-delay: 230ms;
					-ms-animation-delay: 230ms;
					-webkit-animation-delay: 230ms;
					-moz-animation-delay: 230ms;
				z-index: -2;
				border: 1px solid rgba(255,85,0,0.7);
			}
			.cssload-circle:nth-child(3) {
				margin: 0 278px;
				width: 29px;
				height: 29px;
				animation-delay: 345ms;
					-o-animation-delay: 345ms;
					-ms-animation-delay: 345ms;
					-webkit-animation-delay: 345ms;
					-moz-animation-delay: 345ms;
				z-index: -3;
				border: 1px solid rgba(255,128,0,0.7);
			}
			.cssload-circle:nth-child(4) {
				margin: 0 273px;
				width: 39px;
				height: 39px;
				animation-delay: 460ms;
					-o-animation-delay: 460ms;
					-ms-animation-delay: 460ms;
					-webkit-animation-delay: 460ms;
					-moz-animation-delay: 460ms;
				z-index: -4;
				border: 1px solid rgba(255,170,0,0.7);
			}
			.cssload-circle:nth-child(5) {
				margin: 0 268px;
				width: 49px;
				height: 49px;
				animation-delay: 575ms;
					-o-animation-delay: 575ms;
					-ms-animation-delay: 575ms;
					-webkit-animation-delay: 575ms;
					-moz-animation-delay: 575ms;
				z-index: -5;
				border: 1px solid rgba(255,213,0,0.7);
			}
			.cssload-circle:nth-child(6) {
				margin: 0 263px;
				width: 58px;
				height: 58px;
				animation-delay: 690ms;
					-o-animation-delay: 690ms;
					-ms-animation-delay: 690ms;
					-webkit-animation-delay: 690ms;
					-moz-animation-delay: 690ms;
				z-index: -6;
				border: 1px solid rgba(255,255,0,0.7);
			}
			.cssload-circle:nth-child(7) {
				margin: 0 258px;
				width: 68px;
				height: 68px;
				animation-delay: 805ms;
					-o-animation-delay: 805ms;
					-ms-animation-delay: 805ms;
					-webkit-animation-delay: 805ms;
					-moz-animation-delay: 805ms;
				z-index: -7;
				border: 1px solid rgba(212,255,0,0.7);
			}
			.cssload-circle:nth-child(8) {
				margin: 0 253px;
				width: 78px;
				height: 78px;
				animation-delay: 920ms;
					-o-animation-delay: 920ms;
					-ms-animation-delay: 920ms;
					-webkit-animation-delay: 920ms;
					-moz-animation-delay: 920ms;
				z-index: -8;
				border: 1px solid rgba(170,255,0,0.7);
			}
			.cssload-circle:nth-child(9) {
				margin: 0 249px;
				width: 88px;
				height: 88px;
				animation-delay: 1035ms;
					-o-animation-delay: 1035ms;
					-ms-animation-delay: 1035ms;
					-webkit-animation-delay: 1035ms;
					-moz-animation-delay: 1035ms;
				z-index: -9;
				border: 1px solid rgba(128,255,0,0.7);
			}
			.cssload-circle:nth-child(10) {
				margin: 0 244px;
				width: 97px;
				height: 97px;
				animation-delay: 1150ms;
					-o-animation-delay: 1150ms;
					-ms-animation-delay: 1150ms;
					-webkit-animation-delay: 1150ms;
					-moz-animation-delay: 1150ms;
				z-index: -10;
				border: 1px solid rgba(85,255,0,0.7);
			}
			.cssload-circle:nth-child(11) {
				margin: 0 239px;
				width: 107px;
				height: 107px;
				animation-delay: 1265ms;
					-o-animation-delay: 1265ms;
					-ms-animation-delay: 1265ms;
					-webkit-animation-delay: 1265ms;
					-moz-animation-delay: 1265ms;
				z-index: -11;
				border: 1px solid rgba(43,255,0,0.7);
			}
			.cssload-circle:nth-child(12) {
				margin: 0 234px;
				width: 117px;
				height: 117px;
				animation-delay: 1380ms;
					-o-animation-delay: 1380ms;
					-ms-animation-delay: 1380ms;
					-webkit-animation-delay: 1380ms;
					-moz-animation-delay: 1380ms;
				z-index: -12;
				border: 1px solid rgba(0,255,0,0.7);
			}
			.cssload-circle:nth-child(13) {
				margin: 0 229px;
				width: 127px;
				height: 127px;
				animation-delay: 1495ms;
					-o-animation-delay: 1495ms;
					-ms-animation-delay: 1495ms;
					-webkit-animation-delay: 1495ms;
					-moz-animation-delay: 1495ms;
				z-index: -13;
				border: 1px solid rgba(0,255,43,0.7);
			}
			.cssload-circle:nth-child(14) {
				margin: 0 224px;
				width: 136px;
				height: 136px;
				animation-delay: 1610ms;
					-o-animation-delay: 1610ms;
					-ms-animation-delay: 1610ms;
					-webkit-animation-delay: 1610ms;
					-moz-animation-delay: 1610ms;
				z-index: -14;
				border: 1px solid rgba(0,255,85,0.7);
			}
			.cssload-circle:nth-child(15) {
				margin: 0 219px;
				width: 146px;
				height: 146px;
				animation-delay: 1725ms;
					-o-animation-delay: 1725ms;
					-ms-animation-delay: 1725ms;
					-webkit-animation-delay: 1725ms;
					-moz-animation-delay: 1725ms;
				z-index: -15;
				border: 1px solid rgba(0,255,128,0.7);
			}
			.cssload-circle:nth-child(16) {
				margin: 0 214px;
				width: 156px;
				height: 156px;
				animation-delay: 1840ms;
					-o-animation-delay: 1840ms;
					-ms-animation-delay: 1840ms;
					-webkit-animation-delay: 1840ms;
					-moz-animation-delay: 1840ms;
				z-index: -16;
				border: 1px solid rgba(0,255,170,0.7);
			}
			.cssload-circle:nth-child(17) {
				margin: 0 210px;
				width: 166px;
				height: 166px;
				animation-delay: 1955ms;
					-o-animation-delay: 1955ms;
					-ms-animation-delay: 1955ms;
					-webkit-animation-delay: 1955ms;
					-moz-animation-delay: 1955ms;
				z-index: -17;
				border: 1px solid rgba(0, 255, 213, 0.7);
			}
			.cssload-circle:nth-child(18) {
				margin: 0 205px;
				width: 175px;
				height: 175px;
				animation-delay: 2070ms;
					-o-animation-delay: 2070ms;
					-ms-animation-delay: 2070ms;
					-webkit-animation-delay: 2070ms;
					-moz-animation-delay: 2070ms;
				z-index: -18;
				border: 1px solid rgba(0, 255, 255, 0.7);
			}
			.cssload-circle:nth-child(19) {
				margin: 0 200px;
				width: 185px;
				height: 185px;
				animation-delay: 2185ms;
					-o-animation-delay: 2185ms;
					-ms-animation-delay: 2185ms;
					-webkit-animation-delay: 2185ms;
					-moz-animation-delay: 2185ms;
				z-index: -19;
				border: 1px solid rgba(0, 212, 255, 0.7);
			}
			.cssload-circle:nth-child(20) {
				margin: 0 195px;
				width: 195px;
				height: 195px;
				animation-delay: 2300ms;
					-o-animation-delay: 2300ms;
					-ms-animation-delay: 2300ms;
					-webkit-animation-delay: 2300ms;
					-moz-animation-delay: 2300ms;
				z-index: -20;
				border: 1px solid rgba(0, 170, 255, 0.7);
			}
			.cssload-circle:nth-child(21) {
				margin: 0 190px;
				width: 205px;
				height: 205px;
				animation-delay: 2415ms;
					-o-animation-delay: 2415ms;
					-ms-animation-delay: 2415ms;
					-webkit-animation-delay: 2415ms;
					-moz-animation-delay: 2415ms;
				z-index: -21;
				border: 1px solid rgba(0, 127, 255, 0.7);
			}
			.cssload-circle:nth-child(22) {
				margin: 0 185px;
				width: 214px;
				height: 214px;
				animation-delay: 2530ms;
					-o-animation-delay: 2530ms;
					-ms-animation-delay: 2530ms;
					-webkit-animation-delay: 2530ms;
					-moz-animation-delay: 2530ms;
				z-index: -22;
				border: 1px solid rgba(0, 85, 255, 0.7);
			}
			.cssload-circle:nth-child(23) {
				margin: 0 180px;
				width: 224px;
				height: 224px;
				animation-delay: 2645ms;
					-o-animation-delay: 2645ms;
					-ms-animation-delay: 2645ms;
					-webkit-animation-delay: 2645ms;
					-moz-animation-delay: 2645ms;
				z-index: -23;
				border: 1px solid rgba(0, 43, 255, 0.7);
			}
			.cssload-circle:nth-child(24) {
				margin: 0 175px;
				width: 234px;
				height: 234px;
				animation-delay: 2760ms;
					-o-animation-delay: 2760ms;
					-ms-animation-delay: 2760ms;
					-webkit-animation-delay: 2760ms;
					-moz-animation-delay: 2760ms;
				z-index: -24;
				border: 1px solid rgba(0, 0, 255, 0.7);
			}
			.cssload-circle:nth-child(25) {
				margin: 0 171px;
				width: 244px;
				height: 244px;
				animation-delay: 2875ms;
					-o-animation-delay: 2875ms;
					-ms-animation-delay: 2875ms;
					-webkit-animation-delay: 2875ms;
					-moz-animation-delay: 2875ms;
				z-index: -25;
				border: 1px solid rgba(42, 0, 255, 0.7);
			}
			.cssload-circle:nth-child(26) {
				margin: 0 166px;
				width: 253px;
				height: 253px;
				animation-delay: 2990ms;
					-o-animation-delay: 2990ms;
					-ms-animation-delay: 2990ms;
					-webkit-animation-delay: 2990ms;
					-moz-animation-delay: 2990ms;
				z-index: -26;
				border: 1px solid rgba(85, 0, 255, 0.7);
			}
			.cssload-circle:nth-child(27) {
				margin: 0 161px;
				width: 263px;
				height: 263px;
				animation-delay: 3105ms;
					-o-animation-delay: 3105ms;
					-ms-animation-delay: 3105ms;
					-webkit-animation-delay: 3105ms;
					-moz-animation-delay: 3105ms;
				z-index: -27;
				border: 1px solid rgba(127, 0, 255, 0.7);
			}
			.cssload-circle:nth-child(28) {
				margin: 0 156px;
				width: 273px;
				height: 273px;
				animation-delay: 3220ms;
					-o-animation-delay: 3220ms;
					-ms-animation-delay: 3220ms;
					-webkit-animation-delay: 3220ms;
					-moz-animation-delay: 3220ms;
				z-index: -28;
				border: 1px solid rgba(170, 0, 255, 0.7);
			}
			.cssload-circle:nth-child(29) {
				margin: 0 151px;
				width: 283px;
				height: 283px;
				animation-delay: 3335ms;
					-o-animation-delay: 3335ms;
					-ms-animation-delay: 3335ms;
					-webkit-animation-delay: 3335ms;
					-moz-animation-delay: 3335ms;
				z-index: -29;
				border: 1px solid rgba(212, 0, 255, 0.7);
			}
			.cssload-circle:nth-child(30) {
				margin: 0 146px;
				width: 292px;
				height: 292px;
				animation-delay: 3450ms;
					-o-animation-delay: 3450ms;
					-ms-animation-delay: 3450ms;
					-webkit-animation-delay: 3450ms;
					-moz-animation-delay: 3450ms;
				z-index: -30;
				border: 1px solid rgba(255, 0, 255, 0.7);
			}
			
			
			@keyframes bounce {
				0% {
					transform: translateY(0px);
				}
				100% {
					transform: translateY(97px);
				}
			}
			
			@-o-keyframes bounce {
				0% {
					-o-transform: translateY(0px);
				}
				100% {
					-o-transform: translateY(97px);
				}
			}
			
			@-ms-keyframes bounce {
				0% {
					-ms-transform: translateY(0px);
				}
				100% {
					-ms-transform: translateY(97px);
				}
			}
			
			@-webkit-keyframes bounce {
				0% {
					-webkit-transform: translateY(0px);
				}
				100% {
					-webkit-transform: translateY(97px);
				}
			}
			
			@-moz-keyframes bounce {
				0% {
					-moz-transform: translateY(0px);
				}
				100% {
					-moz-transform: translateY(97px);
				}
			}
		</style>
		<?php
	}
}
add_action('vidorev_theme_control_panel', 'vidorev_theme_control_panel_data');