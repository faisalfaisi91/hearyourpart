<?php
if ( ! function_exists( 'vidorev_theme_control_panel' ) ) :
	function vidorev_theme_control_panel() {		
		do_action('vidorev_theme_control_panel');
	}
endif;

if ( ! function_exists( 'vidorev_theme_setup_menu' ) ) :
	function vidorev_theme_setup_menu(){
		add_menu_page(esc_html__('VidoRev Dashboard', 'vidorev-extensions'), esc_html__('VidoRev', 'vidorev-extensions'), 'edit_theme_options', 'vidorev-theme-settings', 'vidorev_theme_control_panel', 'dashicons-format-video', 5);
	}
endif;

if(is_admin()){	
	add_action('admin_menu', 'vidorev_theme_setup_menu');	
}

if ( ! function_exists( 'beeteam368_vrpcccc' ) ) :
	function beeteam368_vrpcccc(){
		global $beeteam368_vidorev_vri_ck;
	?>
    	<div class="wrap">
			<h2><strong><?php echo esc_html__('Purchase Code', 'vidorev-extensions')?></strong></h2>
            <div class="metabox-holder">
            	<div id="beeteam368_purchase_code">
                	<?php if($beeteam368_vidorev_vri_ck == 'img_tu'){?>
                		<strong><?php echo esc_html__('Please, activate the theme to unlock its features. Enter the purchase code you received with the theme into the form below.', 'vidorev-extensions');?></strong>
                    <?php 
						update_option( 'beeteam368_verify_md5_code', '' );				
						update_option( 'beeteam368_verify_purchase_code', '' );
						update_option( 'beeteam368_verify_buyer', '' );
						update_option( 'beeteam368_verify_domain', '' );
					}?>
                    
                    <?php 
					if($beeteam368_vidorev_vri_ck=='pur_cd'){
					?>
                    	<div class="ver-mess ver-mess-control scc">
                        	<?php echo esc_html__( 'Thank you for Verifying your PURCHASE CODE', 'vidorev-extensions');?>
                        </div>
					<?php
					}else{?>
                    	<div class="ver-mess ver-mess-control"></div>
                    <?php }
					$beeteam368_verify_buyer = trim(get_option( 'beeteam368_verify_server', 'primary' ));
					?>
                	<table class="form-table">
                        <tbody>
                        	 <tr>
                                <th scope="row">
                                    <label for="envato_username"><?php echo esc_html__('Server Authenticated', 'vidorev-extensions');?></label>
                                </th>
                                <td>
                                	<select class="regular" id="server" name="server" style="width:35em; max-width:100%;">
                                    	<option value="primary" <?php if($beeteam368_verify_buyer=='primary'){echo 'selected="selected"';}?>><?php echo esc_html__('Primary', 'vidorev-extensions')?></option>
                                        <option value="second-1" <?php if($beeteam368_verify_buyer=='second-1'){echo 'selected="selected"';}?>><?php echo esc_html__('Second 1', 'vidorev-extensions')?></option>
                                        <option value="second-2" <?php if($beeteam368_verify_buyer=='second-2'){echo 'selected="selected"';}?>><?php echo esc_html__('Second 2', 'vidorev-extensions')?></option>
                                    </select>    
                                    <p class="description"><?php echo esc_html__('If you cannot authenticate with the primary server, try with the second server.', 'vidorev-extensions')?></p>                                
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="envato_username"><?php echo esc_html__('Your Envato Account (username)', 'vidorev-extensions');?></label>
                                </th>
                                <td>
                                    <input type="text" class="regular-text" id="envato_username" name="envato_username" value="<?php echo esc_attr(trim(get_option( 'beeteam368_verify_buyer', '' )));?>" placeholder="<?php echo esc_attr__('eg: beeteam368', 'vidorev-extensions')?>" style="width:35em; max-width:100%;">                                   
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="purchase_code"><?php echo esc_html__('Purchase Code', 'vidorev-extensions');?></label>
                                </th>
                                <td>
                                    <input type="text" class="regular-text" id="purchase_code" name="purchase_code" value="<?php echo esc_attr(trim(get_option( 'beeteam368_verify_purchase_code', '' )));?>" placeholder="<?php echo esc_attr__('eg: 11b77b20-19e8-4d9f-9878-299923dcd763', 'vidorev-extensions')?>" style="width:35em; max-width:100%;">                                   
                                </td>
                            </tr>						
                        </tbody>
                    </table>                    
                    <div class="verify-submit">
                        <p class="submit">
                            <input type="button" class="button button-primary button-large verify-submit-control" value="<?php echo esc_html__('Verify', 'vidorev-extensions');?>">
                        </p>							
                    </div>
                    <?php if($beeteam368_vidorev_vri_ck == 'img_tu'){?>
                    	<strong><?php echo esc_html__('Below is just a guide. You need to use your account and your license', 'vidorev-extensions');?></strong>
                    	<br><br>
                        <img src="<?php echo esc_url(VPE_PLUGIN_URL.'assets/front-end/img/purchase-code.jpg');?>" style="border:3px solid #222222;">
                        <br>
                    <?php }?>
                </div>
            </div>
        </div>
        <script>
			;(function($){
				$('.verify-submit-control').on('click', function(){
					var $t = $(this),
						envato_username = $.trim($('#envato_username').val()),
						purchase_code	= $.trim($('#purchase_code').val());
						server			= $.trim($('#server').val());
						
					$t.addClass('btn-loading');	
					$('.ver-mess-control').text('');
						
					if(envato_username == '' || purchase_code == ''){
						alert('<?php echo esc_html__('Please enter a valid purchase code.', 'vidorev-extensions');?>');
						$t.removeClass('btn-loading');
						return;
					}
					
					newParamsRequest = {
						'action':		'beeteam368_verify_purchase_code',
						'code': 		purchase_code,
						'buyer': 		envato_username,
						'server':		server,
					}	
					
					$.ajax({
						url:		'<?php echo esc_url(admin_url('admin-ajax.php'));?>',						
						type: 		'POST',
						data:		newParamsRequest,
						dataType: 	'html',
						cache:		false,
						success: 	function(data){
							if(data==='success'){
								$('.ver-mess-control').text('<?php echo esc_html__( 'Thank you for Verifying your PURCHASE CODE', 'vidorev-extensions')?>').addClass('scc');
							}else{
								$('.ver-mess-control').text(data).removeClass('scc');
							}
							
							$t.removeClass('btn-loading');	
						},
						error:		function(){
							$('.ver-mess-control').text('<?php echo esc_html__( 'An error occurred, please try again later', 'vidorev-extensions')?>').removeClass('scc');
							$t.removeClass('btn-loading');
						},
					});
				});
			}(jQuery));
		</script>
        <style>
			.btn-loading{
				opacity:0.5 !important;
				pointer-events:none !important;
			}
			.ver-mess{
				font-size:20px;
				font-weight:bold;
				color:#F80004;			
			}
			.ver-mess.scc{
				color:#0A9C0D;
			}
			.ver-mess:not(:empty){
				padding-top:25px;
			}
		</style>
    <?php
	}
endif;	

if ( ! function_exists( 'beeteam368_vrpcccc_menu' ) ) :
	function beeteam368_vrpcccc_menu(){
		add_submenu_page('vidorev-theme-settings', esc_html__( 'Verify Purchase Code', 'vidorev-extensions'), esc_html__( 'Verify Purchase Code', 'vidorev-extensions'), 'manage_options', 'beeteam368_vrpcccc', 'beeteam368_vrpcccc' );
	}
endif;

if(is_admin()){	
	add_action('admin_menu', 'beeteam368_vrpcccc_menu');	
}

if(!function_exists('beeteam368_verify_purchase_code')){
	function beeteam368_verify_purchase_code($code = '', $buyer = ''){
		
		$return = true;
		
		if(isset($_POST['action']) && $_POST['action'] == 'beeteam368_verify_purchase_code'){
			$return = false;
		}
		
		if(isset($_POST['server']) && trim($_POST['server'])!=''){
			update_option( 'beeteam368_verify_server', trim($_POST['server']) );
		}
		
		if(isset($_POST['code'])){
			$code = $_POST['code'];
		}
		
		if(isset($_POST['buyer'])){
			$buyer = $_POST['buyer'];
		}
		
		$server = 'https://beeteam368.net/beeteam368.php';
		
		switch(trim(get_option( 'beeteam368_verify_server', 'primary' ))){
			case 'second-1':
				$server = 'http://exthemes.net/beeteam368-addon-domain/beeteam368.php';
				break;
			case 'second-2':
				$server = 'http://wp.beeteam368.com/beeteam368.php';
				break;	
			default:	
				$server = 'https://beeteam368.net/beeteam368.php';
		}
		
		$response = wp_remote_post( $server, array(						
			'method' 	=> 'POST',
			'timeout' 	=> 368,	
			'body' 		=> array(
				'code' 		=> trim($code),
				'buyer' 	=> trim($buyer),
				'item_id' 	=> beeteam368_tf_item_id,
				'domain'	=> beeteam368_tf_item_domain,
			),
		));
		
		if(is_wp_error($response)){
			if($return){
				return esc_html__( 'An error occurred, please try again later', 'vidorev-extensions');
			}else{
				echo esc_html__( 'An error occurred, please try again later', 'vidorev-extensions');
				wp_die();
			}
		}else {
			$result = json_decode($response['body']);
			if(is_array($result) && count($result) === 5 && $result[0] === 'success'){				
				update_option( 'beeteam368_verify_md5_code', $result[1] );				
				update_option( 'beeteam368_verify_purchase_code', $result[2] );
				update_option( 'beeteam368_verify_buyer', $result[3] );
				update_option( 'beeteam368_verify_domain', $result[4] );
				
				if($return){
					return 'success';
				}else{
					echo 'success';
					wp_die();
				}
			}else{
				update_option( 'beeteam368_verify_md5_code', '' );				
				update_option( 'beeteam368_verify_purchase_code', '' );
				update_option( 'beeteam368_verify_buyer', '' );
				update_option( 'beeteam368_verify_domain', '' );
				
				if(is_array($result) && count($result) === 2 && $result[0] === 'error'){					
					if($return){
						return $result[1];
					}else{
						echo $result[1];
						wp_die();
					}
				}
				
				if($return){
					return esc_html__( 'An error occurred, please try again later', 'vidorev-extensions');
				}else{
					echo esc_html__( 'An error occurred, please try again later', 'vidorev-extensions');
					wp_die();
				}
			}
		}
		
		wp_die();
	}
}

if(!function_exists('beeteam368_verify_purchase_code_ajax')){
	function beeteam368_verify_purchase_code_ajax(){
		if(is_admin() && isset($_POST['code']) && $_POST['code']!='' && isset($_POST['buyer']) && $_POST['buyer']!=''){
			add_action('wp_ajax_beeteam368_verify_purchase_code', 'beeteam368_verify_purchase_code');
			add_action('wp_ajax_nopriv_beeteam368_verify_purchase_code', 'beeteam368_verify_purchase_code');	
		}	
	}
}
add_action('admin_init', 'beeteam368_verify_purchase_code_ajax');

if(!function_exists('beeteam368_vidorev_extensions_vrf_cron')){
	function beeteam368_vidorev_extensions_vrf_cron(){
		$code			= trim(get_option( 'beeteam368_verify_purchase_code', '' ));
		$buyer			= trim(get_option( 'beeteam368_verify_buyer', '' ));
		beeteam368_verify_purchase_code($code, $buyer);
	}
}
if(!function_exists('beeteam368_vidorev_extensions_vrf_cron_activation')){
	function beeteam368_vidorev_extensions_vrf_cron_activation(){
		if ( !wp_next_scheduled( 'beeteam368_vidorev_extensions_vrf_cron' ) ){
			wp_schedule_event( time(), 'twicedaily', 'beeteam368_vidorev_extensions_vrf_cron' );
		}
	}
}
add_action('init', 'beeteam368_vidorev_extensions_vrf_cron_activation');
add_action('beeteam368_vidorev_extensions_vrf_cron', 'beeteam368_vidorev_extensions_vrf_cron' );