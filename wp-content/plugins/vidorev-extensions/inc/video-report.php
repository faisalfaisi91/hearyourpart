<?php
if(!function_exists('vidorev_submit_video_report')){
	function vidorev_submit_video_report(){
		
		$json_params = array();
		
		if(!is_user_logged_in() || !isset($_POST['post_id']) || !isset($_POST['reasons']) || !isset($_POST['security']) || !is_numeric($_POST['post_id']) || trim($_POST['security']) == '' || trim($_POST['reasons']) == ''){
			$json_params['error'] = 'yes';
			wp_send_json($json_params);
			return;
			die();
		}
		
		$theme_data = wp_get_theme();
		if(!wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' )){
			$json_params['error'] = 'yes';
			wp_send_json($json_params);
			return;
			die();
		}
		
		$current_user 	= wp_get_current_user();
		$user_id 		= (int)$current_user->ID;		
		$meta_id		= $_POST['post_id'].'|'.$user_id;
		
		$exists = new WP_Query(array(
			'post_type'   	=> 'video_report_check',
			'post_status' 	=> 'any',
			'posts_per_page'=> 1,			
			'meta_query'  	=> array(
				array(
					'key'     => 'post_report_id',
					'value'   => $meta_id,
					'compare' => '=',
				),
			),
		));

		if($exists->have_posts()){			
			wp_reset_postdata();			
			$json_params['error'] = 'yes';
			wp_send_json($json_params);			
			return;
			die();
		}
		
		wp_reset_postdata();
		
		$postData = array();											
		$postData['post_title'] 	= esc_html__('Report', 'vidorev-extensions').': '.get_the_title($_POST['post_id']);	
		$postData['post_status'] 	= 'publish';
		$postData['post_type'] 		= 'video_report_check';
		
		$newPostID = wp_insert_post($postData);
		
		if(!is_wp_error($newPostID) && $newPostID){			
			update_post_meta($newPostID, 'post_report_id', $meta_id);
			update_post_meta($newPostID, 'post_report_seasons', trim($_POST['reasons']));	
		}else{
			$json_params['error'] = 'yes';
			wp_send_json($json_params);
			return;
			die();
		}
		
		$json_params['success'] = 'yes';
		wp_send_json($json_params);
		
		die();
	}
}
add_action('wp_ajax_vidorev_submit_video_report', 'vidorev_submit_video_report');
add_action('wp_ajax_nopriv_vidorev_submit_video_report', 'vidorev_submit_video_report');	

if(!function_exists('vidorev_video_report_column_ID')){
	function vidorev_video_report_column_ID( $columns ) {
		$date = $columns['date'];
		unset($columns['date']);
		$columns['reasons'] = esc_html__('Reasons', 'vidorev-extensions');
		$columns['edit_view_data'] = esc_html__('Action', 'vidorev-extensions');
		$columns['user_report'] = esc_html__('User Report', 'vidorev-extensions');
		$columns['date'] = $date;
		return $columns;
	}
}
add_filter('manage_edit-video_report_check_columns', 'vidorev_video_report_column_ID');

if(!function_exists('vidorev_video_report_column_ID_value')){
	function vidorev_video_report_column_ID_value( $colname, $cptid ) {
		
		$explode_id = explode('|', get_post_meta($cptid, 'post_report_id', true));
		
		if ( $colname == 'reasons' ){
			echo '<code class="reasons-texxt">'.get_post_meta($cptid, 'post_report_seasons', true).'</code>';
		}elseif($colname == 'edit_view_data' ){
			if(is_array($explode_id) && count($explode_id) == 2){
				echo 	wp_kses(
							__('<a href="'.esc_url(get_edit_post_link($explode_id[0])).'" target="_blank">Edit Post</a> | <a href="'.esc_url(get_permalink($explode_id[0])).'" target="_blank">View Post</a>', 'vidorev-extensions'
							),
							array(
								'a'=>array('href' => array(), 'target' => array()),
							)
						);
			}
		}elseif($colname == 'user_report'){
			if(is_array($explode_id) && count($explode_id) == 2){
				$user_obj = get_user_by('id', $explode_id[1]);
				echo 	wp_kses(
							__('User Name: <strong>'.$user_obj->user_login.'</strong> | <a href="'.esc_url(get_edit_user_link($user_obj->ID)).'" target="_blank">View User</a>', 'vidorev-extensions'
							),
							array(
								'a'=>array('href' => array(), 'target' => array()),
								'strong'=>array(),
							)
						);
			}
		}
	}
}
add_action('manage_video_report_check_posts_custom_column', 'vidorev_video_report_column_ID_value', 10, 2);