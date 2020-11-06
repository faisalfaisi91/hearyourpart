<?php
if ( !class_exists('vidorev_like_dislike_settings' ) ):
	class vidorev_like_dislike_settings {
	
		private $settings_api;
	
		function __construct() {
			$this->settings_api = new WeDevs_Settings_API;
	
			add_action( 'admin_init', array($this, 'admin_init') );
			add_action( 'admin_menu', array($this, 'admin_menu') );
		}
	
		function admin_init() {
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			$this->settings_api->admin_init();
		}
	
		function admin_menu() {
			add_submenu_page('vidorev-theme-settings', esc_html__( 'Like/Dislike Settings', 'vidorev-extensions'), esc_html__( 'Like/Dislike Settings', 'vidorev-extensions'), 'manage_options', 'vid_like_dislike_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'like_dislike_settings',
					'title' => esc_html__('Like/Dislike Settings', 'vidorev-extensions')
				),				          
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'like_dislike_settings' => array(
					array(
						'name'    => 'lk_enable_sys',
						'label'   => esc_html__( 'Enable Like/Dislike', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Select whether only logged in users can vote or not.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),
							'no'			=> esc_html__('NO', 'vidorev-extensions'),							
						)
					),
					array(
						'name'    => 'lk_login_required',
						'label'   => esc_html__( 'Login Required to Vote', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Select whether only logged in users can vote or not.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),
							'no'			=> esc_html__('NO', 'vidorev-extensions'),							
						)
					),
					array(
						'name'    => 'lk_show_dislike',
						'label'   => esc_html__( 'Show Dislike Option', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Select the option whether to show or hide the dislike option.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),
							'no'			=> esc_html__('NO', 'vidorev-extensions'),							
						)
					),      
				),       
			);
			
			/*$post_types = get_post_types('', 'objects');*/			
			$post_types = json_decode(
				json_encode(
					array(
						array(
							'name' => 'vid_channel',
							'labels' => array(
								'singular_name' => 'Channel'
							),
						),
						array(
							'name' => 'vid_playlist',
							'labels' => array(
								'singular_name' => 'Playlist'
							),
						),
						array(
							'name' => 'vid_series',
							'labels' => array(
								'singular_name' => 'Series'
							),
						),
						array(
							'name' => 'vid_actor',
							'labels' => array(
								'singular_name' => 'Actor'
							),
						),
						array(
							'name' => 'vid_director',
							'labels' => array(
								'singular_name' => 'Director'
							),
						),
					)
				), 
			FALSE);	
			
				
			foreach($post_types as $post_type){				
				
				$pt_name 	= $post_type->{'name'};
				$pt_s_name 	= $post_type->{'labels'}->{'singular_name'};
				
				if($pt_name == 'vid_channel' || $pt_name == 'vid_playlist' || $pt_name == 'vid_series' || $pt_name == 'vid_actor' || $pt_name == 'vid_director'){
					
					$settings_fields['like_dislike_settings'][] = array(
						'name'    => 'lk_for_'.$pt_name,
						'label'   => $pt_s_name,
						'desc'    => esc_html__( 'Show in', 'vidorev-extensions').' '.$pt_s_name,
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes'			=> esc_html__('YES', 'vidorev-extensions'),
							'no'			=> esc_html__('NO', 'vidorev-extensions'),							
						)
					);
				
				}
			}

	
			return $settings_fields;
		}
	
		function plugin_page() {
			echo '<div class="wrap">';
	
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
	
			echo '</div>';
		}	
	}
endif;
new vidorev_like_dislike_settings();

if(!function_exists('vidorev_get_ip')):
	function vidorev_get_ip() {
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		} elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		} elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}
endif;

if(!function_exists('vidorev_already_voted')):
	function vidorev_already_voted($post_id) {
		global $wpdb;

		$ip 			= vidorev_get_ip();
		$current_user 	= wp_get_current_user();
		$user_id 		= (int)$current_user->ID;
		
		if($user_id == 0){
			$has_voted = $wpdb->get_var($wpdb->prepare("SELECT value AS has_voted FROM {$wpdb->prefix}vpe_like_dislike WHERE post_id = %d AND ip = %s AND user_id = %d", $post_id, $ip, 0));
		}else{
			$has_voted = $wpdb->get_var($wpdb->prepare("SELECT value AS has_voted FROM {$wpdb->prefix}vpe_like_dislike WHERE post_id = %d AND user_id = %d", $post_id, $user_id));
		}
		
		return $has_voted;
	}
endif;	

if(!function_exists('vidorev_already_voted_fetch')):
	function vidorev_already_voted_fetch($post_id, $action_ip='like') {
		global $wpdb;
		$has_voted = $wpdb->get_var($wpdb->prepare("SELECT value AS has_voted FROM {$wpdb->prefix}vpe_like_dislike WHERE post_id = %d AND ip = %s AND user_id = %d", $post_id, $action_ip, 0));		
		return $has_voted;
	}
endif;	

if(!function_exists('vidorev_get_like_count')):
	function vidorev_get_like_count($post_id) {
		global $wpdb;
		$like_count = $wpdb->get_var(
							$wpdb->prepare(
								"SELECT SUM(value) FROM {$wpdb->prefix}vpe_like_dislike
								WHERE post_id = %d AND value >= 0",
								$post_id
							)
						);
		
		if (!$like_count) {
			$like_count = 0;
		}

		return apply_filters('vidorev_number_format', $like_count);
	}
endif;

if(!function_exists('vidorev_get_like_count_full')):
	function vidorev_get_like_count_full($post_id) {
		global $wpdb;
		$like_count = $wpdb->get_var(
							$wpdb->prepare(
								"SELECT SUM(value) FROM {$wpdb->prefix}vpe_like_dislike
								WHERE post_id = %d AND value >= 0",
								$post_id
							)
						);
		
		if (!$like_count) {
			$like_count = 0;
		}

		return (int)$like_count;
	}
endif;

if(!function_exists('vidorev_get_dislike_count')):
	function vidorev_get_dislike_count($post_id = 0) {		
		if($post_id == 0){
			$post_id = get_the_ID();
		}
		
		global $wpdb;
		$dislike_count = $wpdb->get_var(
							$wpdb->prepare(
								"SELECT SUM(value) FROM {$wpdb->prefix}vpe_like_dislike
								WHERE post_id = %d AND value <= 0",
								$post_id
							)
						);
		
		if (!$dislike_count) {
			$dislike_count = 0;
		} else {
			$dislike_count = str_replace('-', '', $dislike_count);
		}
		
		return apply_filters('vidorev_number_format', $dislike_count);
	}
endif;

if(!function_exists('vidorev_get_dislike_count_full')):
	function vidorev_get_dislike_count_full($post_id = 0) {		
		if($post_id == 0){
			$post_id = get_the_ID();
		}
		
		global $wpdb;
		$dislike_count = $wpdb->get_var(
							$wpdb->prepare(
								"SELECT SUM(value) FROM {$wpdb->prefix}vpe_like_dislike
								WHERE post_id = %d AND value <= 0",
								$post_id
							)
						);
		
		if (!$dislike_count) {
			$dislike_count = 0;
		} else {
			$dislike_count = str_replace('-', '', $dislike_count);
		}
		
		return (int)$dislike_count;
	}
endif;

if(!function_exists('vidorev_display_like_button')):
	function vidorev_display_like_button($post_id = 0, $style = '1'){
		$enable_like_dislike = vidorev_get_option('lk_enable_sys', 'like_dislike_settings', 'yes');	
		
		if($enable_like_dislike!='yes'){
			return '';
		}
		
		if($post_id == 0){
			$post_id = get_the_ID();
		}
		
		$post_type_enb = vidorev_get_option('lk_for_'.get_post_type($post_id), 'like_dislike_settings', 'yes');		
		if($post_type_enb == 'no'){
			return '';
		}
		
		$has_voted 			= vidorev_already_voted($post_id);
		$login_required 	= vidorev_get_option('lk_login_required', 'like_dislike_settings', 'yes');
		$is_user_logged_in 	= is_user_logged_in();
		
		ob_start();
		switch($style){
			case '1':
				?>
				<div class="site__col toolbar-item">
					<div class="toolbar-item-content like-action-control <?php echo $has_voted==1?'active-item-sub':''?>" data-id=<?php echo esc_attr($post_id);?> data-action="like">
						<span class="like-tooltip like-tooltip-control"><span class="likethis"><?php echo esc_html__( 'I Like This', 'vidorev-extensions');?></span><span class="unlike"><?php echo esc_html__( 'Unlike', 'vidorev-extensions');?></span></span>
						<span class="item-icon font-size-18"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Like', 'vidorev-extensions');?></span>
						<span class="video-load-icon small-icon"></span>
						<?php if ( $login_required=='yes' && !$is_user_logged_in ) {?>
							<span class="login-tooltip login-req"><span><?php echo esc_html__( 'Please Login to Vote', 'vidorev-extensions');?></span></span>
						<?php }?>
					</div>
				</div>
				<?php
				break;
			case '2':
				?>
				<div class="ld-t-item-content like-action-control <?php echo $has_voted==1?'active-item-sub':''?>" data-id=<?php echo esc_attr($post_id);?> data-action="like">
					<span class="like-tooltip like-tooltip-control"><span class="likethis"><?php echo esc_html__( 'I Like This', 'vidorev-extensions');?></span><span class="unlike"><?php echo esc_html__( 'Unlike', 'vidorev-extensions');?></span></span>
					<span class="item-icon font-size-18"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span><span class="item-text like-count" data-id="<?php echo esc_attr($post_id);?>"><?php echo vidorev_get_like_count($post_id);?></span>
					<span class="video-load-icon small-icon"></span>
					<?php if ( $login_required=='yes' && !$is_user_logged_in ) {?>
						<span class="login-tooltip login-req"><span><?php echo esc_html__( 'Please Login to Vote', 'vidorev-extensions');?></span></span>
					<?php }?>
				</div>
				<?php
				break;	
		}		
		$output_string = ob_get_contents();
		ob_end_clean();		
		return $output_string;
	}
endif;

if(!function_exists('vidorev_get_last_date')):
	function vidorev_get_last_date($voting_period) {
		$hour = $day = $month = $year = 0;
		
		 switch($voting_period) {
			  case "1":
				   $day = 1;
				   break;
			  case "2":
				   $day = 2;
				   break;
			  case "3":
				   $day = 3;
				   break;
			  case "7":
				   $day = 7;
				   break;
			  case "14":
				   $day = 14;
				   break;
			  case "21":
				   $day = 21;
				   break;
			  case "1m":
				   $month = 1;
				   break;
			  case "2m":
				   $month = 2;
				   break;
			  case "3m":
				   $month = 3;
				   break;
			  case "6m":
				   $month = 6;
				   break;
			  case "1y":
				   $year = 1;
				break;
		 }
		 
		 $last_strtotime = strtotime(date('Y-m-d H:i:s'));
		 $last_strtotime = mktime(date('H', $last_strtotime), date('i', $last_strtotime), date('s', $last_strtotime),
						date('m', $last_strtotime) - $month, date('d', $last_strtotime) - $day, date('Y', $last_strtotime) - $year);
		 
		 $last_voting_date = date('Y-m-d H:i:s', $last_strtotime);
		 
		 return $last_voting_date;
	}
endif;

if(!function_exists('vidorev_display_dislike_button')):
	function vidorev_display_dislike_button($post_id = 0, $style = '1'){
		$enable_like_dislike = vidorev_get_option('lk_enable_sys', 'like_dislike_settings', 'yes');	
		
		if($enable_like_dislike!='yes'){
			return '';
		}		
		
		$show_dislike = vidorev_get_option('lk_show_dislike', 'like_dislike_settings', 'yes');	
		
		if($show_dislike!='yes'){
			return '';
		}
			
		if($post_id == 0){
			$post_id = get_the_ID();
		}
		
		$post_type_enb = vidorev_get_option('lk_for_'.get_post_type($post_id), 'like_dislike_settings', 'yes');		
		if($post_type_enb == 'no'){
			return '';
		}
		
		$has_voted 			= vidorev_already_voted($post_id);
		$login_required 	= vidorev_get_option('lk_login_required', 'like_dislike_settings', 'yes');
		$is_user_logged_in 	= is_user_logged_in();
		
		ob_start();
		switch($style){
			case '1':
				?>
				<div class="site__col toolbar-item">
					<div class="toolbar-item-content like-action-control <?php echo $has_voted==-1?'active-item-sub':''?>" data-id=<?php echo esc_attr($post_id);?>  data-action="dislike">
						<span class="dislike-tooltip dislike-tooltip-control"><span class="dislikethis"><?php echo esc_html__( 'I Dislike This', 'vidorev-extensions');?></span><span class="undislike"><?php echo esc_html__( 'Un-Dislike', 'vidorev-extensions');?></span></span>
						<span class="item-icon font-size-18"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Dislike', 'vidorev-extensions');?></span>
						<span class="video-load-icon small-icon"></span>
						<?php if ( $login_required=='yes' && !$is_user_logged_in ) {?>
							<span class="login-tooltip login-req"><span><?php echo esc_html__( 'Please Login to Vote', 'vidorev-extensions');?></span></span>
						<?php }?>
					</div>
				</div>
				<?php
				break;
				
			case '2':
				?>
				<div class="ld-t-item-content like-action-control <?php echo $has_voted==-1?'active-item-sub':''?>" data-id=<?php echo esc_attr($post_id);?>  data-action="dislike">
					<span class="dislike-tooltip dislike-tooltip-control"><span class="dislikethis"><?php echo esc_html__( 'I Dislike This', 'vidorev-extensions');?></span><span class="undislike"><?php echo esc_html__( 'Un-Dislike', 'vidorev-extensions');?></span></span>
					<span class="item-icon font-size-18"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></span><span class="item-text dislike-count" data-id="<?php echo esc_attr($post_id);?>"><?php echo vidorev_get_dislike_count($post_id);?></span>
					<span class="video-load-icon small-icon"></span>
					<?php if ( $login_required=='yes' && !$is_user_logged_in ) {?>
						<span class="login-tooltip login-req"><span><?php echo esc_html__( 'Please Login to Vote', 'vidorev-extensions');?></span></span>
					<?php }?>
				</div>
				<?php
				break;	
		}
		$output_string = ob_get_contents();
		ob_end_clean();		
		return $output_string;
	}
endif;

if(!function_exists('vidorev_ajax_voted')):
	function vidorev_ajax_voted(){
		global $wpdb;
		
		$post_id 		= (int)$_REQUEST['post_id'];
		$task_action 	= $_REQUEST['task_action'];
		
		$json_params = array();
		
		$can_vote = false;
		
		$login_required 	= vidorev_get_option('lk_login_required', 'like_dislike_settings', 'yes');
		$is_user_logged_in 	= is_user_logged_in();
		
		if ( $login_required=='yes' && !$is_user_logged_in ) {
			$json_params['error'] 	= 1;
			$json_params['msg'] 	= esc_html__('Please login to vote.', 'vidorev-extensions');
			wp_send_json($json_params);			
		}else{
			$can_vote = true;
		}
		
		if($can_vote){
			$has_voted 		= vidorev_already_voted($post_id);
			$ip 			= vidorev_get_ip();
			$current_user 	= wp_get_current_user();
			$user_id 		= (int)$current_user->ID;
			$datetime 		= date( 'Y-m-d H:i:s' );
			
			if(is_numeric($has_voted)){
				
				if($user_id == 0){
					$where = ' WHERE user_id = %d AND post_id = %d AND ip = %s';
				}else{
					$where = ' WHERE user_id = %d AND post_id = %d';
				}
				
				if($task_action=='like'){
					$value = 1;
					if($has_voted==1){
						$value = 0;
					}
					
					$success = 	$wpdb->query(
									$wpdb->prepare(
										"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
										value = ".$value.",
										date_time = '" . $datetime . "'
										".$where,
										$user_id, $post_id, $ip
									)
								);
					if($value == 0){
						do_action('beeteam368_unlike_fne', $user_id, $post_id);
					}else{			
						do_action('beeteam368_like_fne', $user_id, $post_id);	
					}
				}elseif($task_action=='dislike'){
					$value = -1;
					if($has_voted==-1){
						$value = 0;
					}
					$success = 	$wpdb->query(
									$wpdb->prepare(
										"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
										value = ".$value.",
										date_time = '" . $datetime . "'
										".$where,
										$user_id, $post_id, $ip
									)
								);
								
					if($value == 0){
						do_action('beeteam368_undislike_fne', $user_id, $post_id);
					}else{			
						do_action('beeteam368_dislike_fne', $user_id, $post_id);
					}			
				}
				
			}else{
				if($task_action=='like'){
					$success = 	$wpdb->query(
									$wpdb->prepare(
										"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
										post_id = %d, value = '1',
										date_time = '" . $datetime . "',
										user_id = %d, ip = %s",
										$post_id, $user_id, $ip
									)
								);
					
					do_action('beeteam368_like_fne', $user_id, $post_id);
								
				}elseif($task_action=='dislike'){
					$success = 	$wpdb->query(
									$wpdb->prepare(
										"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
										post_id = %d, value = '-1',
										date_time = '" . $datetime . "',
										user_id = %d, ip = %s",
										$post_id, $user_id, $ip
									)
								);
					do_action('beeteam368_dislike_fne', $user_id, $post_id);			
				}
			}
			
			if($success){
				$json_params['error'] 			= 0;
				$json_params['msg'] 			= esc_html__('Thanks for your vote.', 'vidorev-extensions');
				$json_params['like_count'] 		= vidorev_get_like_count($post_id);
				$json_params['dislike_count'] 	= vidorev_get_dislike_count($post_id);
				$json_params['like_count_full'] = vidorev_get_like_count_full($post_id);
				$json_params['dislike_count_full'] 	= vidorev_get_dislike_count_full($post_id);
				$json_params['has_voted']		= vidorev_already_voted($post_id);
			}else{
				$json_params['error'] = 1;
				$json_params['msg'] 	= esc_html__('Could not process your vote.', 'vidorev-extensions');
			}
			
			wp_send_json($json_params);
		}
	
		die();
	}
endif;
add_action( 'wp_ajax_like_action_query', 'vidorev_ajax_voted' );
add_action( 'wp_ajax_nopriv_like_action_query', 'vidorev_ajax_voted' );