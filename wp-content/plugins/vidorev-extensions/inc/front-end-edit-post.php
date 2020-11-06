<?php
if(!function_exists('beeteam368_front_end_edit_post')){
	function beeteam368_front_end_edit_post($post_id){
		if(!is_user_logged_in() || !isset($post_id) || !is_numeric($post_id)){
			return '';
		}
		
		$post_author_id = get_post_field( 'post_author', $post_id );
		
		$current_user 		= wp_get_current_user();
		$user_id 			= $current_user->ID;		
		
		if($post_author_id != $user_id){
			return '';
		}
		
		$post_type = get_post_type($post_id);
		
		switch($post_type){
			case 'post':
				return '<span class="fe_edit-post fe_edit-post-control" data-id="'.esc_attr($post_id).'"><i class="fa fa-pencil-square" aria-hidden="true"></i></span><span class="fe_edit-post fe_delete-post-control" data-id="'.esc_attr($post_id).'"><i class="fa fa-window-close" aria-hidden="true"></i></span>';
				break;
			case 'vid_playlist':
				return '<span class="fe_edit-post fe_edit-post-control" data-id="'.esc_attr($post_id).'"><i class="fa fa-pencil-square" aria-hidden="true"></i></span><span class="fe_edit-post fe_delete-post-control" data-id="'.esc_attr($post_id).'"><i class="fa fa-window-close" aria-hidden="true"></i></span>';
				break;
			case 'vid_channel':
				return '<span class="fe_edit-post fe_edit-post-control" data-id="'.esc_attr($post_id).'"><i class="fa fa-pencil-square" aria-hidden="true"></i></span><span class="fe_edit-post fe_delete-post-control" data-id="'.esc_attr($post_id).'"><i class="fa fa-window-close" aria-hidden="true"></i></span>';
				break;
		}
		
		return '';
	}
}
add_filter('vidorev_front_end_edit_post', 'beeteam368_front_end_edit_post');

if(!function_exists('vidorev_front_end_edit_post_control')){
	function vidorev_front_end_edit_post_control(){
		
		$json_params = array();
		
		$theme_data = wp_get_theme();
		if(	!defined('PLAYLIST_PM_PREFIX') || !isset($_POST['post_id']) || !is_numeric($_POST['post_id']) || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' ) || !is_user_logged_in() ){
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$current_user 		= wp_get_current_user();
		$user_id 			= $current_user->ID;		
		$post_id 			= $_POST['post_id'];		
		$post_author 		= get_post_field( 'post_author', $post_id );
		
		if($post_author != $user_id){
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$post_type = get_post_type($post_id);
		
		$post_title = get_post_field( 'post_title', $post_id );
		$post_content = get_post_field( 'post_content', $post_id );
		$vm_video_url = get_post_meta($post_id, 'vm_video_url', true );
		
		$img_ft = '';
		ob_start();
			do_action('vidorev_thumbnail', 'thumbnail', 'class-1x1', 4, $post_id);
		$img_ft = ob_get_contents();
		ob_end_clean();	
		
		if($img_ft!=''){
			$featured_image = '<img src="'.$img_ft.'">';
		}
		
		switch($post_type){
			case 'post':
				$post_format = get_post_format($post_id);
				if($post_format=='video'){
					$json_params['form'] = array(
						array( '', '<input type="hidden" name="vidorev-submit-post-id" value="'.esc_attr($post_id).'" class="wpcf7-hidden">' ),
						array( esc_html__('Post Title *', 'vidorev-extensions'), '<input type="text" name="vidorev-submit-post-title" value="'.esc_attr($post_title).'" size="40" class="wpcf7-text" aria-required="true" aria-invalid="false">', do_shortcode('[single_video_player id="'.$post_id.'" style="vp-small-item"]') ),
						array( esc_html__('Featured Image', 'vidorev-extensions'), '<input type="file" name="vidorev-submit-post-featured-image" size="40" class="wpcf7-file" accept=".gif,.png,.jpg,.jpeg" aria-invalid="false">', $featured_image ),
						array( esc_html__('Post Content', 'vidorev-extensions'), '<textarea name="vidorev-submit-post-content" cols="40" rows="10" class="wpcf7-textarea" aria-invalid="false">'.$post_content.'</textarea>' ),
						array( esc_html__('Video URL (or Embed)', 'vidorev-extensions'), '<textarea name="vidorev-submit-video-url" cols="40" rows="10" class="wpcf7-textarea" aria-invalid="false">'.$vm_video_url.'</textarea>' ),
						array( esc_html__('Video File', 'vidorev-extensions'), '<input type="file" name="vidorev-submit-video-file-mp4" size="40" class="wpcf7-file" accept=".mp4,.flv,.m4v,.webm,.ogv,.wmv" aria-invalid="false">', esc_html__('This is a priority option, which replaces the video url (or embed). Supports: *.mp4, *.flv, *.m4v, *.webm, *.ogv, *.wmv', 'vidorev-extensions') ),
						array( esc_html__('Playlist', 'vidorev-extensions'), beeteam368_front_end_playlist_search($post_id) ),
						array( esc_html__('Channel', 'vidorev-extensions'), beeteam368_front_end_channel_search($post_id) ),			
					);
				}else{
					$json_params['form'] = array(
						array( '', '<input type="hidden" name="vidorev-submit-post-id" value="'.esc_attr($post_id).'" class="wpcf7-hidden">' ),
						array( esc_html__('Post Title *', 'vidorev-extensions'), '<input type="text" name="vidorev-submit-post-title" value="'.esc_attr($post_title).'" size="40" class="wpcf7-text" aria-required="true" aria-invalid="false">' ),
						array( esc_html__('Featured Image', 'vidorev-extensions'), '<input type="file" name="vidorev-submit-post-featured-image" size="40" class="wpcf7-file" accept=".gif,.png,.jpg,.jpeg" aria-invalid="false">', $featured_image ),
						array( esc_html__('Post Content', 'vidorev-extensions'), '<textarea name="vidorev-submit-post-content" cols="40" rows="10" class="wpcf7-textarea" aria-invalid="false">'.$post_content.'</textarea>' ),										
					);
				}
				break;
			case 'vid_playlist':
				$json_params['form'] = array(
					array( '', '<input type="hidden" name="vidorev-submit-post-id" value="'.esc_attr($post_id).'" class="wpcf7-hidden">' ),
					array( esc_html__('Playlist Title *', 'vidorev-extensions'), '<input type="text" name="vidorev-submit-post-title" value="'.esc_attr($post_title).'" size="40" class="wpcf7-text" aria-required="true" aria-invalid="false">' ),
					array( esc_html__('Featured Image', 'vidorev-extensions'), '<input type="file" name="vidorev-submit-post-featured-image" size="40" class="wpcf7-file" accept=".gif,.png,.jpg,.jpeg" aria-invalid="false">', $featured_image ),
					array( esc_html__('Playlist Content', 'vidorev-extensions'), '<textarea name="vidorev-submit-post-content" cols="40" rows="10" class="wpcf7-textarea" aria-invalid="false">'.$post_content.'</textarea>' ),		
					array( esc_html__('Channel', 'vidorev-extensions'), beeteam368_front_end_pl_channel_search($post_id) ),							
				);
				break;
			case 'vid_channel':
				$json_params['form'] = array(
					array( '', '<input type="hidden" name="vidorev-submit-post-id" value="'.esc_attr($post_id).'" class="wpcf7-hidden">' ),
					array( esc_html__('Channel Title *', 'vidorev-extensions'), '<input type="text" name="vidorev-submit-post-title" value="'.esc_attr($post_title).'" size="40" class="wpcf7-text" aria-required="true" aria-invalid="false">' ),
					array( esc_html__('Featured Image', 'vidorev-extensions'), '<input type="file" name="vidorev-submit-post-featured-image" size="40" class="wpcf7-file" accept=".gif,.png,.jpg,.jpeg" aria-invalid="false">', $featured_image ),
					array( esc_html__('Channel Logo', 'vidorev-extensions'), '<input type="file" name="vidorev-submit-channel-logo-image" size="40" class="wpcf7-form-control wpcf7-file" accept=".gif,.png,.jpg,.jpeg" aria-invalid="false">' ),					
					array( esc_html__('Channel Banner', 'vidorev-extensions'), '<input type="file" name="vidorev-submit-channel-banner-image" size="40" class="wpcf7-form-control wpcf7-file" accept=".gif,.png,.jpg,.jpeg" aria-invalid="false">' ),
					array( esc_html__('Channel Content', 'vidorev-extensions'), '<textarea name="vidorev-submit-post-content" cols="40" rows="10" class="wpcf7-textarea" aria-invalid="false">'.$post_content.'</textarea>' ),										
				);
				break;
		}
		
		wp_send_json($json_params);			
		die();
	}
}
add_action( 'wp_ajax_front_end_edit_post_control', 'vidorev_front_end_edit_post_control' );
add_action( 'wp_ajax_nopriv_front_end_edit_post_control', 'vidorev_front_end_edit_post_control' );

if(!function_exists('vidorev_front_end_edit_post_data')){
	function vidorev_front_end_edit_post_data(){
		
		$json_params = array();
		
		$theme_data = wp_get_theme();
		if(	!defined('PLAYLIST_PM_PREFIX') || !isset($_POST['vidorev-submit-post-id']) || !is_numeric($_POST['vidorev-submit-post-id']) || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' ) || !is_user_logged_in() ){
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$current_user 		= wp_get_current_user();
		$user_id 			= $current_user->ID;		
		$post_id 			= $_POST['vidorev-submit-post-id'];		
		$post_author 		= get_post_field( 'post_author', $post_id );
		
		if($post_author != $user_id){
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$post_type = get_post_type($post_id);
		
		$u_post_title 	= (isset($_POST['vidorev-submit-post-title']) && trim($_POST['vidorev-submit-post-title'])!='')?trim($_POST['vidorev-submit-post-title']):'';
		$u_post_content = (isset($_POST['vidorev-submit-post-content']) && trim($_POST['vidorev-submit-post-content'])!='')?trim($_POST['vidorev-submit-post-content']):'';
		
		if($u_post_title == ''){
			$json_params['error'] = '1';
			$json_params['error_content'] = array( 'err_title' => esc_html__('One or more fields have an error. Please check and try again', 'vidorev-extensions'), 'err_class' => array('vidorev-submit-post-title'), 'err_desc' => esc_html__('The field is required.', 'vidorev-extensions') );
			wp_send_json($json_params);			
			die();
			return;
		}
		
		if(isset($_FILES['vidorev-submit-post-featured-image']) && isset($_FILES['vidorev-submit-post-featured-image']['error']) && $_FILES['vidorev-submit-post-featured-image']['error'] == 0){
			if(!function_exists('wp_handle_upload')){
				require_once( ABSPATH . 'wp-admin/includes/admin.php' );
			}
			$upload_overrides 	= array( 'test_form' => false );
			$movefile 			= wp_handle_upload( $_FILES['vidorev-submit-post-featured-image'], $upload_overrides );
			
			if ( $movefile && !isset( $movefile['error'] ) ) {
				$attachment = array(
					'post_mime_type' 	=> $movefile['type'],
					'post_parent' 		=> $post_id,
					'post_title' 		=> sanitize_file_name($_FILES['vidorev-submit-post-featured-image']['name']),
					'post_content' 		=> '',
					'post_status' 		=> 'inherit'
				);
				
				$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $post_id );
				
				if(!function_exists('wp_handle_upload') || !function_exists('wp_generate_attachment_metadata')){
					require_once( ABSPATH . 'wp-admin/includes/image.php' );
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
					require_once( ABSPATH . 'wp-admin/includes/media.php' );
				}
				
				$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
				wp_update_attachment_metadata( $attach_id, $attach_data );	
				set_post_thumbnail( $post_id, $attach_id );
			}
		}
		
		switch($post_type){
			case 'post':
				$post_format = get_post_format($post_id);
				if($post_format=='video'){
					
					$u_video_url = (isset($_POST['vidorev-submit-video-url']) && trim($_POST['vidorev-submit-video-url'])!='')?trim($_POST['vidorev-submit-video-url']):'';
					
					$video_list_files = array('', '-mp4', '-flv', '-m4v', '-webm', '-ogv', '-wmv');
					$html5_video_files = '';					
					foreach($video_list_files as $ex){						
						$file_name = 'vidorev-submit-video-file'.$ex;
						if(isset($_FILES[$file_name]) && isset($_FILES[$file_name]['error']) && $_FILES[$file_name]['error'] == 0){									
							$upload_overrides 	= array( 'test_form' => false );
							$movefile 			= wp_handle_upload( $_FILES[$file_name], $upload_overrides );	
							
							if ( $movefile && !isset( $movefile['error'] ) ) {
								$attachment = array(
									'post_mime_type' 	=> $movefile['type'],
									'post_parent' 		=> $post_id,
									'post_title' 		=> sanitize_file_name($_FILES[$file_name]['name']),
									'post_content' 		=> '',
									'post_status' 		=> 'inherit'
								);
								
								$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $post_id );
								
								$vid_attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
								wp_update_attachment_metadata( $attach_id, $vid_attach_data );
								
								$html5_video_files.=$movefile['url'].'
								';
							}
						}
					}
					
					if($u_video_url == '' && $html5_video_files == ''){
						$json_params['error'] = '1';
						$json_params['error_content'] = array( 'err_title' => esc_html__('One or more fields have an error. Please check and try again', 'vidorev-extensions'), 'err_class' => array('vidorev-submit-video-url', 'vidorev-submit-video-file-mp4'), 'err_desc' => esc_html__('The field is required.', 'vidorev-extensions') );
						wp_send_json($json_params);			
						die();
						return;
					}else{
						if($html5_video_files!=''){
							update_post_meta($post_id, 'vm_video_url', $html5_video_files);
						}else{
							update_post_meta($post_id, 'vm_video_url', $u_video_url);
						}
					}					
				}
				break;
			case 'vid_playlist':
			
				$old_channels = get_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', true);
				if(is_array($old_channels) && count($old_channels)>0){
					foreach($old_channels as $channel_id){
						$channel_videos = get_post_meta($channel_id, CHANNEL_PM_PREFIX.'playlists', true);
						if(is_array($channel_videos) && ($i = array_search($post_id, $channel_videos)) !== FALSE){
							unset($channel_videos[$i]);
							update_post_meta($channel_id, CHANNEL_PM_PREFIX.'playlists', $channel_videos);
						}
					}
				}				
				if(isset($_POST[CHANNEL_PM_PREFIX.'sync_channel'])){
					if( is_array($_POST[CHANNEL_PM_PREFIX.'sync_channel']) ){
						foreach($_POST[CHANNEL_PM_PREFIX.'sync_channel'] as $channel_id){
							$channel_videos = get_post_meta($channel_id, CHANNEL_PM_PREFIX.'playlists', true);
							if(is_array($channel_videos)){						
								if( ($iz = array_search($post_id, $channel_videos)) === FALSE ){
									array_push($channel_videos, $post_id);
									update_post_meta($channel_id, CHANNEL_PM_PREFIX.'playlists', $channel_videos);							
								}
							}else{
								update_post_meta($channel_id, CHANNEL_PM_PREFIX.'playlists', array($post_id));
							}
						}				
					}					
					update_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', $_POST[CHANNEL_PM_PREFIX.'sync_channel']);					
				}
				
				break;
			case 'vid_channel':
			
				$channel_file_types = array('logo', 'banner');				
				foreach($channel_file_types as $type){
					
					if(isset($_FILES['vidorev-submit-channel-'.$type.'-image']) && isset($_FILES['vidorev-submit-channel-'.$type.'-image']['error']) && $_FILES['vidorev-submit-channel-'.$type.'-image']['error'] == 0){
						if(!function_exists('wp_handle_upload')){
							require_once( ABSPATH . 'wp-admin/includes/admin.php' );
						}
						$upload_overrides 	= array( 'test_form' => false );
						$movefile 			= wp_handle_upload( $_FILES['vidorev-submit-channel-'.$type.'-image'], $upload_overrides );
						
						if ( $movefile && !isset( $movefile['error'] ) ) {
							$attachment = array(
								'post_mime_type' 	=> $movefile['type'],
								'post_parent' 		=> $post_id,
								'post_title' 		=> sanitize_file_name($_FILES['vidorev-submit-channel-'.$type.'-image']['name']),
								'post_content' 		=> '',
								'post_status' 		=> 'inherit'
							);
							
							$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $post_id );
							
							if(!function_exists('wp_handle_upload') || !function_exists('wp_generate_attachment_metadata')){
								require_once( ABSPATH . 'wp-admin/includes/image.php' );
								require_once( ABSPATH . 'wp-admin/includes/file.php' );
								require_once( ABSPATH . 'wp-admin/includes/media.php' );
							}
							
							$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
							wp_update_attachment_metadata( $attach_id, $attach_data );
							
							switch($type){							
									
								case 'logo':
									update_post_meta($post_id, CHANNEL_PM_PREFIX.'logo_id', $attach_id);
									update_post_meta($post_id, CHANNEL_PM_PREFIX.'logo', wp_get_attachment_url($attach_id));
									break;
									
								case 'banner':
									update_post_meta($post_id, CHANNEL_PM_PREFIX.'banner_id', $attach_id);
									update_post_meta($post_id, CHANNEL_PM_PREFIX.'banner', wp_get_attachment_url($attach_id));
									break;		
							}	
							
						}
					}
					
				}
				break;
		}
		
		$update_data = array(
			'ID'    		=> $post_id,
			'post_title'   	=> $u_post_title,
			'post_content' 	=> $u_post_content,
		);
		
		$u_check = wp_update_post($update_data);
		
		if (is_wp_error($u_check)) {
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$json_params['success'] = 'done!';
		
		wp_send_json($json_params);			
		die();
	}
}
add_action( 'wp_ajax_front_end_edit_post_data', 'vidorev_front_end_edit_post_data' );
add_action( 'wp_ajax_nopriv_front_end_edit_post_data', 'vidorev_front_end_edit_post_data' );

if ( ! function_exists( 'beeteam368_front_end_playlist_search' ) ) :
	function beeteam368_front_end_playlist_search($post_id){
		
		if(!defined('PLAYLIST_PM_PREFIX')){
			return;
		}
		
		ob_start();
		
			$old_playlists 		= get_post_meta($post_id, PLAYLIST_PM_PREFIX.'sync_playlist', true);
			$check_playlists	= array();
			?>		
			<select data-placeholder="<?php echo esc_attr__('Select a Playlist', 'vidorev-extensions');?>" class="ajax-edit-find-playlist-control" name="<?php echo esc_attr(PLAYLIST_PM_PREFIX.'sync_playlist[]');?>" multiple>
				<?php
				
					if($post_id!=''){							
						$args_query = array(
							'post_type'				=> 'vid_playlist',
							'posts_per_page' 		=> -1,
							'post_status' 			=> 'any',
							'ignore_sticky_posts' 	=> 1,
							'meta_query' 			=> array(
															array(
																'key' 		=> PLAYLIST_PM_PREFIX.'videos',
																'value' 	=> $post_id,
																'compare' 	=> 'LIKE'
															)
							)
						);
						
						$playlist_query = get_posts($args_query);
						
						if($playlist_query):
							foreach ( $playlist_query as $item) :
								if(!is_array($old_playlists) || $old_playlists == ''){
									array_push($check_playlists, $item->ID);
								}
							?>
								<option value="<?php echo esc_attr($item->ID);?>" selected="selected"><?php echo esc_attr(get_the_title($item->ID));?></option>
							<?php
							endforeach;
						endif;
						
						if(count($check_playlists) > 0){
							update_post_meta($post_id, PLAYLIST_PM_PREFIX.'sync_playlist', $check_playlists);
						}
					}
				?>
			</select>
            <input type="hidden" value="postupdate" name="beeteam368_check_playlist_manual">
		<?php
		$select2Content = ob_get_contents();
		ob_end_clean();	
		
		return $select2Content;
	}
endif;

if ( ! function_exists( 'beeteam368_front_end_channel_search' ) ) :
	function beeteam368_front_end_channel_search($post_id){
		
		if(!defined('CHANNEL_PM_PREFIX')){
			return;
		}
		
		ob_start();
		
			$old_channels 	= get_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', true);
			$check_channels	= array();
			?>
			
            <select data-placeholder="<?php echo esc_attr__('Select a Channel', 'vidorev-extensions');?>" class="ajax-edit-find-channel-control" name="<?php echo esc_attr(CHANNEL_PM_PREFIX.'sync_channel[]');?>" multiple>
                <?php
                
                    if($post_id!=''){							
                        $args_query = array(
                            'post_type'				=> 'vid_channel',
                            'posts_per_page' 		=> -1,
                            'post_status' 			=> 'any',
                            'ignore_sticky_posts' 	=> 1,
                            'meta_query' 			=> array(
                                                            array(
                                                                'key' 		=> CHANNEL_PM_PREFIX.'videos',
                                                                'value' 	=> $post_id,
                                                                'compare' 	=> 'LIKE'
                                                            )
                            )
                        );
                        
                        $playlist_query = get_posts($args_query);
                        
                        if($playlist_query):
                            foreach ( $playlist_query as $item) :
                                if(!is_array($old_channels) || $old_channels == ''){
                                    array_push($check_channels, $item->ID);
                                }
                            ?>
                                <option value="<?php echo esc_attr($item->ID);?>" selected="selected"><?php echo esc_attr(get_the_title($item->ID));?></option>
                            <?php
                            endforeach;
                        endif;
                        
                        if(count($check_channels) > 0){
                            update_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', $check_channels);
                        }							
                    }
                ?>
            </select>
            <input type="hidden" value="postupdate" name="beeteam368_check_channel_manual">
		<?php
		$select2Content = ob_get_contents();
		ob_end_clean();	
		
		return $select2Content;	
	}
endif;

if(!function_exists('vidorev_ajaxEditGetAllPlaylists')){
	function vidorev_ajaxEditGetAllPlaylists(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=3)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' )){
			wp_send_json($json_params);
			return;
			die();
		}
		
		$args_query = array(
			'post_type'				=> 'vid_playlist',
			'posts_per_page' 		=> 18,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			's'						=> $keyword,
			'nopaging'				=> true,
		);
		
		$user_submit_id = 0;
		if(is_user_logged_in()){				
			$current_user = wp_get_current_user();				
			$user_submit_id = $current_user->ID;
			$args_query['author'] = $user_submit_id;
		}else{
			wp_send_json($json_params);
			return;
			die();
		}

		
		$search_query 	= new WP_Query($args_query);
		if($search_query->have_posts()):
			while($search_query->have_posts()):
				$search_query->the_post();
				array_push($json_params['results'], array('id'=>get_the_ID(), 'text'=>esc_html(get_the_title())));
			endwhile;	
		endif;
		wp_reset_postdata();				
		
		wp_send_json($json_params);
		return;
		die();
	}
}
add_action('wp_ajax_ajaxEditGetAllPlaylists', 'vidorev_ajaxEditGetAllPlaylists');
add_action('wp_ajax_nopriv_ajaxEditGetAllPlaylists', 'vidorev_ajaxEditGetAllPlaylists');

if(!function_exists('vidorev_ajaxEditGetAllChannels')){
	function vidorev_ajaxEditGetAllChannels(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=3)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' )){
			wp_send_json($json_params);
			return;
			die();
		}
		
		$args_query = array(
			'post_type'				=> 'vid_channel',
			'posts_per_page' 		=> 18,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			's'						=> $keyword,
			'nopaging'				=> true,
		);

		$user_submit_id = 0;
		if(is_user_logged_in()){				
			$current_user = wp_get_current_user();				
			$user_submit_id = $current_user->ID;
			$args_query['author'] = $user_submit_id;
		}else{
			wp_send_json($json_params);
			return;
			die();
		}
		
		$search_query 	= new WP_Query($args_query);
		if($search_query->have_posts()):
			while($search_query->have_posts()):
				$search_query->the_post();
				array_push($json_params['results'], array('id'=>get_the_ID(), 'text'=>esc_html(get_the_title())));
			endwhile;	
		endif;
		wp_reset_postdata();				
		
		wp_send_json($json_params);
		return;
		die();
	}
}
add_action('wp_ajax_ajaxEditGetAllChannels', 'vidorev_ajaxEditGetAllChannels');
add_action('wp_ajax_nopriv_ajaxEditGetAllChannels', 'vidorev_ajaxEditGetAllChannels');


if ( ! function_exists( 'beeteam368_front_end_pl_channel_search' ) ) :
	function beeteam368_front_end_pl_channel_search($post_id){
		
		if(!defined('CHANNEL_PM_PREFIX')){
			return;
		}
		
		ob_start();
		
			$old_channels 	= get_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', true);
			$check_channels	= array();
			?>
			
            <select data-placeholder="<?php echo esc_attr__('Select a Channel', 'vidorev-extensions');?>" class="ajax-edit-find-channel-control" name="<?php echo esc_attr(CHANNEL_PM_PREFIX.'sync_channel[]');?>" multiple>
                <?php
                
                    if($post_id!=''){							
                        $args_query = array(
                            'post_type'				=> 'vid_channel',
                            'posts_per_page' 		=> -1,
                            'post_status' 			=> 'any',
                            'ignore_sticky_posts' 	=> 1,
                            'meta_query' 			=> array(
                                                            array(
                                                                'key' 		=> CHANNEL_PM_PREFIX.'playlists',
                                                                'value' 	=> $post_id,
                                                                'compare' 	=> 'LIKE'
                                                            )
                            )
                        );
                        
                        $playlist_query = get_posts($args_query);
                        
                        if($playlist_query):
                            foreach ( $playlist_query as $item) :
                                if(!is_array($old_channels) || $old_channels == ''){
                                    array_push($check_channels, $item->ID);
                                }
                            ?>
                                <option value="<?php echo esc_attr($item->ID);?>" selected="selected"><?php echo esc_attr(get_the_title($item->ID));?></option>
                            <?php
                            endforeach;
                        endif;
                        
                        if(count($check_channels) > 0){
                            update_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', $check_channels);
                        }							
                    }
                ?>
            </select>
		<?php
		$select2Content = ob_get_contents();
		ob_end_clean();	
		
		return $select2Content;	
	}
endif;

if(!function_exists('vidorev_front_end_delete_post_data')){
	function vidorev_front_end_delete_post_data(){
		
		$json_params = array();
		
		$theme_data = wp_get_theme();
		if(	!isset($_POST['post_id']) || !is_numeric($_POST['post_id']) || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' ) || !is_user_logged_in() ){
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$current_user 		= wp_get_current_user();
		$user_id 			= $current_user->ID;		
		$post_id 			= $_POST['post_id'];		
		$post_author 		= get_post_field( 'post_author', $post_id );
		
		if($post_author != $user_id){
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$d_check = wp_delete_post( $post_id, true);
		
		if (is_wp_error($d_check)) {
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$json_params['success'] = 'done!';
		$json_params['red_url'] = esc_url( get_author_posts_url( get_the_author_meta( 'ID', $user_id ) ) );
		
		wp_send_json($json_params);			
		die();
	}
}
add_action( 'wp_ajax_front_end_delete_post_data', 'vidorev_front_end_delete_post_data' );
add_action( 'wp_ajax_nopriv_front_end_delete_post_data', 'vidorev_front_end_delete_post_data' );