<?php
if(!function_exists('wpcf7_add_form_tag')){
	return;
}

if(!function_exists('vidorev_detech_lang_submit_page')){
	function vidorev_detech_lang_submit_page($page_id){
		$custom_submit_polylang = vidorev_get_redux_option('custom_submit_polylang', '');			
		$lang_check_set = false;
		$lang_check_shc = array();
		$lang_check_pid = 0;
		if($custom_submit_polylang){
			foreach ($custom_submit_polylang as $lang){
				if(isset($lang['url']) && is_numeric(trim($lang['url'])) && $page_id == trim($lang['url'])){
					$lang_check_set = true;
					$lang_check_shc = (isset($lang['description'])&&trim($lang['description'])!='')?explode(',', trim($lang['description'])):array();
					$lang_check_pid = trim($lang['url']);
					return array($lang_check_set, $lang_check_shc, $lang_check_pid);
					break;
				}
			}
		}
		
		return array($lang_check_set, $lang_check_shc, $lang_check_pid);
	}
}

if(!function_exists('vidorev_detech_limit_upload')){
	function vidorev_detech_limit_upload($file_size = '1mb'){
		$allowed_size = 1048576;
		
		$limit_pattern = '/^([1-9][0-9]*)([kKmM]?[bB])?$/';

		if ( preg_match( $limit_pattern, $file_size, $matches ) ) {
			$allowed_size = (int) $matches[1];

			if ( ! empty( $matches[2] ) ) {
				$kbmb = strtolower( $matches[2] );

				if ( 'kb' == $kbmb ) {
					$allowed_size *= 1024;
				} elseif ( 'mb' == $kbmb ) {
					$allowed_size *= 1024 * 1024;
				}
			}
		}
		
		return $allowed_size;
	}
}

if(!function_exists('vidorev_cf7_channel_cats')):
	function vidorev_cf7_channel_cats(){
		 wpcf7_add_form_tag( 'vid_cf7_channel_cats', 'vidorev_cf7_channel_cats_handler' , array( 'name-attr' => true ) );
	}
endif;

if(!function_exists('vidorev_hierarchical_channel_cats_tree')){
	function vidorev_hierarchical_channel_cats_tree( $tag, $i = 0) {		
		$args_query = array(
			'orderby' 		=> 'name',
			'order'   		=> 'ASC',
			'hide_empty'	=> 0,
			'parent'		=> $tag,
		);		
		
		if(!isset($i)){
			$i = 0;
		}
		
		$next = get_terms('vid_channel_cat', $args_query);
		
		$html = '';
		
		if( $next ) :
			$z = $i+1;
			if($i==0){
				$html.='<select data-placeholder="'.esc_attr__('Select a Channel Category', 'vidorev-extensions').'" class="vidorev-select-multiple select-multiple-control" name="vidorev-submit-video-channel-cats[]" multiple="multiple">';
			}		
			foreach( $next as $tag ) :
				$html.='<option value="'.esc_attr($tag->term_id).'">'.str_repeat('&nbsp; &nbsp; &nbsp; ', $i).esc_html($tag->name).'</option>';			
				$html.=vidorev_hierarchical_channel_cats_tree( $tag->term_id, $z);
			endforeach; 
			
			if($i==0){
				$html.='</select>';
			}  
			
			return $html;  
		endif;
	}  
}

if(!function_exists('vidorev_cf7_channel_cats_handler')):
	function vidorev_cf7_channel_cats_handler( $tag ){
		ob_start();
		
		echo vidorev_hierarchical_channel_cats_tree(0);
		
		$output_string = ob_get_contents();
		ob_end_clean();		
		return $output_string;
	}
endif;

add_action( 'wpcf7_init', 'vidorev_cf7_channel_cats' );

if(!function_exists('vidorev_cf7_playlist_cats')):
	function vidorev_cf7_playlist_cats(){
		 wpcf7_add_form_tag( 'vid_cf7_playlist_cats', 'vidorev_cf7_playlist_cats_handler' , array( 'name-attr' => true ) );
	}
endif;

if(!function_exists('vidorev_hierarchical_playlist_cats_tree')){
	function vidorev_hierarchical_playlist_cats_tree( $tag, $i = 0) {		
		$args_query = array(
			'orderby' 		=> 'name',
			'order'   		=> 'ASC',
			'hide_empty'	=> 0,
			'parent'		=> $tag,
		);		
		
		if(!isset($i)){
			$i = 0;
		}
		
		$next = get_terms('vid_playlist_cat', $args_query);
		
		$html = '';
		
		if( $next ) :
			$z = $i+1;
			if($i==0){
				$html.='<select data-placeholder="'.esc_attr__('Select a Playlist Category', 'vidorev-extensions').'" class="vidorev-select-multiple select-multiple-control" name="vidorev-submit-video-playlist-cats[]" multiple="multiple">';
			}		
			foreach( $next as $tag ) :
				$html.='<option value="'.esc_attr($tag->term_id).'">'.str_repeat('&nbsp; &nbsp; &nbsp; ', $i).esc_html($tag->name).'</option>';			
				$html.=vidorev_hierarchical_playlist_cats_tree( $tag->term_id, $z);
			endforeach; 
			
			if($i==0){
				$html.='</select>';
			}  
			
			return $html;  
		endif;
	}  
}

if(!function_exists('vidorev_cf7_playlist_cats_handler')):
	function vidorev_cf7_playlist_cats_handler( $tag ){
		ob_start();
		
		echo vidorev_hierarchical_playlist_cats_tree(0);
		
		$output_string = ob_get_contents();
		ob_end_clean();		
		return $output_string;
	}
endif;

add_action( 'wpcf7_init', 'vidorev_cf7_playlist_cats' );

if(!function_exists('vidorev_cf7_tags')):
	function vidorev_cf7_tags(){
		 wpcf7_add_form_tag( 'vid_cf7_tags', 'vidorev_cf7_tags_handler' , array( 'name-attr' => true ) );
	}
endif;

if(!function_exists('vidorev_hierarchical_tag_tree')){
	function vidorev_hierarchical_tag_tree( $tag, $i = 0) {		
		$args_query = array(
			'orderby' 		=> 'name',
			'order'   		=> 'ASC',
			'hide_empty'	=> 0,
			'parent'		=> $tag,
		);		
		
		if(!isset($i)){
			$i = 0;
		}
		
		$next = get_tags($args_query);
		
		$html = '';
		
		if( $next ) :
			$z = $i+1;
			if($i==0){
				$html.='<select data-placeholder="'.esc_attr__('Select a Tag', 'vidorev-extensions').'" class="vidorev-select-multiple select-multiple-control" name="vidorev-submit-video-tags[]" multiple="multiple">';
			}		
			foreach( $next as $tag ) :
				$html.='<option value="'.esc_attr($tag->name).'">'.str_repeat('&nbsp; &nbsp; &nbsp; ', $i).esc_html($tag->name).'</option>';			
				$html.=vidorev_hierarchical_tag_tree( $tag->term_id, $z);
			endforeach; 
			
			if($i==0){
				$html.='</select>';
			}  
			
			return $html;  
		endif;
	}  
}

if(!function_exists('vidorev_cf7_tags_handler')):
	function vidorev_cf7_tags_handler( $tag ){
		ob_start();
		
		echo vidorev_hierarchical_tag_tree(0);
		
		$output_string = ob_get_contents();
		ob_end_clean();		
		return $output_string;
	}
endif;

add_action( 'wpcf7_init', 'vidorev_cf7_tags' );

if(!function_exists('vidorev_cf7_categories')):
	function vidorev_cf7_categories(){
		 wpcf7_add_form_tag( 'vid_cf7_categories', 'vidorev_cf7_categories_handler' , array( 'name-attr' => true ) );
	}
endif;

if(!function_exists('vidorev_hierarchical_category_tree')){
	function vidorev_hierarchical_category_tree( $cat, $i = 0) {
		$args_query = array(
			'orderby' 		=> 'name',
			'order'   		=> 'ASC',
			'hide_empty'	=> 0,
			'parent'		=> $cat,
		);
		
		$ex_category 	= trim(vidorev_get_option('ex_category', 'user_submit_settings', ''));
		$s_tax_query 	= 'category';
		
		if($ex_category!=''){
			$ex_catArray = array();
			
			$ex_catExs = explode(',', $ex_category);
			
			foreach($ex_catExs as $ex_catEx){	
				if(is_numeric(trim($ex_catEx))){					
					array_push($ex_catArray, trim($ex_catEx));
				}else{
					$slug_ex_cat = get_term_by('slug', trim($ex_catEx), $s_tax_query);					
					if($slug_ex_cat){
						$ex_cat_term_id = $slug_ex_cat->term_id;
						array_push($ex_catArray, $ex_cat_term_id);
					}
				}
			}
			
			if(count($ex_catArray) > 0){
				
				$args_query['exclude'] = $ex_catArray;
				
			}	
		}
		if(!isset($i)){
			$i = 0;
		}
		
		$next = get_categories($args_query);
		
		$html = '';
		
		if( $next ) :
			$z = $i+1;
			if($i==0){
				$html.='<select data-placeholder="'.esc_attr__('Select a Category', 'vidorev-extensions').'" class="vidorev-select-multiple select-multiple-control" name="vidorev-submit-video-categories[]" multiple="multiple">';
			}		
			foreach( $next as $cat ) :
				$html.='<option value="'.esc_attr($cat->term_id).'">'.str_repeat('&nbsp; &nbsp; &nbsp; ', $i).esc_html($cat->name).'</option>';			
				$html.=vidorev_hierarchical_category_tree( $cat->term_id, $z);
			endforeach; 
			
			if($i==0){
				$html.='</select>';
			}  
			
			return $html;  
		endif;
	}  
}

if(!function_exists('vidorev_cf7_categories_handler')):
	function vidorev_cf7_categories_handler( $tag ){
		ob_start();
		
		echo vidorev_hierarchical_category_tree(0);
		
		$output_string = ob_get_contents();
		ob_end_clean();		
		return $output_string;
	}
endif;

add_action( 'wpcf7_init', 'vidorev_cf7_categories' );

if(!function_exists('vidorev_cf7_playlists')):
	function vidorev_cf7_playlists(){
		 wpcf7_add_form_tag( 'vid_cf7_playlists', 'vidorev_cf7_playlists_handler' , array( 'name-attr' => true ) );
	}
endif;

if(!function_exists('vidorev_cf7_playlists_handler')):
	function vidorev_cf7_playlists_handler( $tag ){
		ob_start();
			if(vidorev_get_option('ex_playlist', 'user_submit_settings', 'all') == 'current_user'){
				
				echo '<select data-placeholder="'.esc_attr__('Select a Playlist', 'vidorev-extensions').'" class="vidorev-ajax-select-single select-single-ss-control" name="vidorev-submit-video-playlist"><option value="">'.esc_attr__('Select a Playlist', 'vidorev-extensions').'</option>';
				
				$args_query = array(
					'post_type'				=> 'vid_playlist',
					'posts_per_page' 		=> -1,
					'post_status' 			=> 'publish',
					'ignore_sticky_posts' 	=> 1,
					'nopaging'				=> true,
				);

				if(is_user_logged_in()){				
					$current_user = wp_get_current_user();
					$args_query['author'] = $current_user->ID;
					
					$search_query 	= new WP_Query($args_query);
					if($search_query->have_posts()):
						while($search_query->have_posts()):
							$search_query->the_post();
							echo '<option value="'.esc_attr(get_the_ID()).'">'.esc_html(get_the_title()).'</option>';
						endwhile;
					endif;
					wp_reset_postdata();
					
				}
				
				echo '</select>';
				
			}else{
		?>
				<select data-placeholder="<?php echo esc_attr__('Select a Playlist', 'vidorev-extensions');?>" class="vidorev-ajax-select-single ajax-select-playlist-control" name="vidorev-submit-video-playlist"></select>
		<?php
			}
		$output_string = ob_get_contents();
		ob_end_clean();
		
		return $output_string;
	}
endif;

add_action( 'wpcf7_init', 'vidorev_cf7_playlists' );

/*----*/

if(!function_exists('vidorev_cf7_channels')):
	function vidorev_cf7_channels(){
		 wpcf7_add_form_tag( 'vid_cf7_channels', 'vidorev_cf7_channels_handler' , array( 'name-attr' => true ) );
	}
endif;

if(!function_exists('vidorev_cf7_channels_handler')):
	function vidorev_cf7_channels_handler( $tag ){
		ob_start();
			if(vidorev_get_option('ex_channel', 'user_submit_settings', 'all') == 'current_user'){
				
				echo '<select data-placeholder="'.esc_attr__('Select a Channel', 'vidorev-extensions').'" class="vidorev-ajax-select-single select-single-ss-control" name="vidorev-submit-video-channel"><option value="">'.esc_attr__('Select a Channel', 'vidorev-extensions').'</option>';
				
				$args_query = array(
					'post_type'				=> 'vid_channel',
					'posts_per_page' 		=> -1,
					'post_status' 			=> 'publish',
					'ignore_sticky_posts' 	=> 1,
					'nopaging'				=> true,
				);

				if(is_user_logged_in()){				
					$current_user = wp_get_current_user();
					$args_query['author'] = $current_user->ID;
					
					$search_query 	= new WP_Query($args_query);
					if($search_query->have_posts()):
						while($search_query->have_posts()):
							$search_query->the_post();
							echo '<option value="'.esc_attr(get_the_ID()).'">'.esc_html(get_the_title()).'</option>';
						endwhile;
					endif;
					wp_reset_postdata();
					
				}
				echo '</select>';
			}else{
		?>
				<select data-placeholder="<?php echo esc_attr__('Select a Channel', 'vidorev-extensions');?>" class="vidorev-ajax-select-single ajax-select-channel-control" name="vidorev-submit-video-channel"></select>
		<?php
			}
		$output_string = ob_get_contents();
		ob_end_clean();
		
		return $output_string;
	}
endif;

add_action( 'wpcf7_init', 'vidorev_cf7_channels' );

if(!function_exists('vidorev_ajaxGetAllPlaylists')){
	function vidorev_ajaxGetAllPlaylists(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=3)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true) )){
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
		
		if(vidorev_get_option('ex_playlist', 'user_submit_settings', 'all') == 'current_user'){
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
add_action('wp_ajax_ajaxGetAllPlaylists', 'vidorev_ajaxGetAllPlaylists');
add_action('wp_ajax_nopriv_ajaxGetAllPlaylists', 'vidorev_ajaxGetAllPlaylists');

if(!function_exists('vidorev_ajaxGetAllChannels')){
	function vidorev_ajaxGetAllChannels(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=3)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true) )){
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
		
		if(vidorev_get_option('ex_channel', 'user_submit_settings', 'all') == 'current_user'){
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
add_action('wp_ajax_ajaxGetAllChannels', 'vidorev_ajaxGetAllChannels');
add_action('wp_ajax_nopriv_ajaxGetAllChannels', 'vidorev_ajaxGetAllChannels');

if(!function_exists('vidorev_cf7_save_playlist_data')){
	function vidorev_cf7_save_playlist_data( $posted_data ) {
		
		$new_cf7_version = ( defined( 'WPCF7_VERSION' ) && version_compare( WPCF7_VERSION, '5.2', '>=' ) );
		
		if ( $new_cf7_version ) {
			$posted_data['_wpcf7_container_post'] 	= (isset($_POST['_wpcf7_container_post']))?$_POST['_wpcf7_container_post']:0;
			$posted_data['_wpcf7_unit_tag']			= (isset($_POST['_wpcf7_unit_tag']))?$_POST['_wpcf7_unit_tag']:'';
		}
		
		$submit_video_page = vidorev_get_redux_option('submit_video_page', '');
		$get_crr_sbm_page = (isset($posted_data['_wpcf7_container_post']))?$posted_data['_wpcf7_container_post']:0;
		$vidorev_detech_lang_submit_page = vidorev_detech_lang_submit_page($get_crr_sbm_page);
		
		if(isset($posted_data['vidorev-submit-playlist-user-login']) && isset($posted_data['_wpcf7_container_post']) && ($posted_data['_wpcf7_container_post'] == $submit_video_page || $vidorev_detech_lang_submit_page[0])){
			
			$posting_without_login = trim(vidorev_get_option('posting_without_login', 'user_submit_settings', 'no'));
			
			$user_submit_id = 0;
			if(is_user_logged_in()){
				$current_user = wp_get_current_user();
				if($current_user->user_login == $posted_data['vidorev-submit-playlist-user-login']){
					$user_submit_id = $current_user->ID;
				}
			}			
			
			if( $user_submit_id == 0 && $posting_without_login == 'no'){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('Please login before submitting this form!', 'vidorev-extensions'),					
				);
				
				wp_send_json($error);
				return;
				die;
			}			
			
			if($user_submit_id == 0 && $posting_without_login == 'yes'){
				$user_login_name = $posted_data['vidorev-submit-playlist-user-login'];
				if($user_login_name!=''){
					$current_user = get_user_by('login', $user_login_name);
					if($current_user){
						$user_submit_id = $current_user->ID;
					}
				}
			}
			
			/*check permision*/
			$user_meta	= get_userdata($user_submit_id);
			$user_roles	= $user_meta->roles;
			
			global $wp_roles;
			$all_roles 	= implode(', ', array_keys($wp_roles->role_names));
			$roles 		= explode(',', trim(vidorev_get_option('playlist_roles', 'user_submit_settings', $all_roles)));
			$roles_op 	= array();
			
			foreach($roles as $role){
				$role = trim($role);
				if($role!=''){
					$roles_op[] = $role;
				}
			}
			
			$permisions = array();
			$permisions = array_intersect($user_roles, $roles_op);
			
			if(count($permisions) == 0 && $posting_without_login == 'no'){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('You are not allowed to submit this information!', 'vidorev-extensions'),					
				);
				
				wp_send_json($error);
				return;
				die;
			}/*check permision*/
			
			do_action('beeteam368_submit_playlist_before_check_data_FE', $posted_data);
			
			$vidorev_submit_first_name 				= '';
			$vidorev_submit_last_name 				= '';
			$vidorev_submit_user_email 				= '';
			$vidorev_submit_playlist_title 			= '';
			
			if(isset($posted_data['vidorev-submit-first-name']) && trim($posted_data['vidorev-submit-first-name'])!=''){
				$vidorev_submit_first_name = trim($posted_data['vidorev-submit-first-name']);
			}
			
			if(isset($posted_data['vidorev-submit-last-name']) && trim($posted_data['vidorev-submit-last-name'])!=''){
				$vidorev_submit_last_name = trim($posted_data['vidorev-submit-last-name']);
			}
			
			if(isset($posted_data['vidorev-submit-user-email']) && trim($posted_data['vidorev-submit-user-email'])!=''){
				$vidorev_submit_user_email = trim($posted_data['vidorev-submit-user-email']);
			}
			
			if(isset($posted_data['vidorev-submit-playlist-title']) && trim($posted_data['vidorev-submit-playlist-title'])!=''){
				$vidorev_submit_playlist_title = trim($posted_data['vidorev-submit-playlist-title']);
			}
			
			if($vidorev_submit_user_email == '' || $vidorev_submit_playlist_title == ''){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('One or more fields have an error. Please check and try again.', 'vidorev-extensions'),					
				);
				
				if($vidorev_submit_user_email == ''){
					$error['invalidFields'][] = array(
						'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-user-email',
						'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
						'idref'		=> null,
					);
					
					if ( $new_cf7_version ) {
						$error['invalid_fields'][] = array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-user-email',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						);
					}
				}
				
				if($vidorev_submit_playlist_title == ''){
					$error['invalidFields'][] = array(
						'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-playlist-title',
						'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
						'idref'		=> null,
					);
					
					if ( $new_cf7_version ) {
						$error['invalid_fields'][] = array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-playlist-title',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						);
					}
				}
				
				wp_send_json($error);
				return;
				die;
			}
			
			$limit_image_upload_param = trim(vidorev_get_option('limit_ft_upload', 'user_submit_settings', '2mb'));
			$limit_image_upload = vidorev_detech_limit_upload($limit_image_upload_param);			
			if(isset($_FILES['vidorev-submit-playlist-featured-image']) && isset($_FILES['vidorev-submit-playlist-featured-image']['error']) && $_FILES['vidorev-submit-playlist-featured-image']['error'] == 0){
				if($_FILES['vidorev-submit-playlist-featured-image']['size'] > $limit_image_upload){
					$error = array(
						'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
						'status' 			=> 'validation_failed',
						'message' 			=> esc_html__('Uploaded file is too large. You can only upload up to ', 'vidorev-extensions').$limit_image_upload_param,
						'invalidFields' 	=> array(
							array(
								'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-playlist-featured-image',
								'message' 	=> esc_html__('The file is too big.', 'vidorev-extensions'),
								'idref'		=> null,
							)
						),
					);
					
					if ( $new_cf7_version ) {					
						$error['invalid_fields'] = array(
							array(
								'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-playlist-featured-image',
								'message' 	=> esc_html__('The file is too big.', 'vidorev-extensions'),
								'idref'		=> null,
							)
						);
					}
						
					wp_send_json($error);
					return;
					die;
				}
			}
			
			$vidorev_submit_playlist_content 	= '';
			$vidorev_submit_video_channel 		= 0;
			
			if(isset($posted_data['vidorev-submit-playlist-content']) && trim($posted_data['vidorev-submit-playlist-content'])!=''){
				$vidorev_submit_playlist_content = trim($posted_data['vidorev-submit-playlist-content']);
			}
			
			if(isset($posted_data['vidorev-submit-video-channel']) && is_numeric($posted_data['vidorev-submit-video-channel'])){
				$vidorev_submit_video_channel = $posted_data['vidorev-submit-video-channel'];
			}
			
			do_action('beeteam368_submit_playlist_before_check_additional_data_FE', $posted_data);
			
			$postData = array();
			
			$postData['post_type']		= 'vid_playlist';
			
			$postData['post_title'] 	= $vidorev_submit_playlist_title;	
			
			$post_status 				= trim(vidorev_get_option('post_status', 'user_submit_settings', 'pending'));
			$postData['post_status'] 	= $post_status;
			
			$postData['post_content']	= $vidorev_submit_playlist_content;
			
			if($user_submit_id > 0){
				$postData['post_author'] 	= $user_submit_id;
			}
			
			$newPostID = wp_insert_post($postData);
			
			if(!is_wp_error($newPostID) && $newPostID){
				
				if(isset($posted_data['vidorev-submit-video-playlist-cats']) && !empty($posted_data['vidorev-submit-video-playlist-cats']) && is_array($posted_data['vidorev-submit-video-playlist-cats'])){
					$vidorev_submit_video_playlist_cats_u	= array();
					$vidorev_submit_video_playlist_cats 	= $posted_data['vidorev-submit-video-playlist-cats'];	
					foreach($vidorev_submit_video_playlist_cats as $vidorev_submit_video_playlist_cats_it){
						$vidorev_submit_video_playlist_cats_u[] = (int)$vidorev_submit_video_playlist_cats_it;
					}			
					wp_set_object_terms($newPostID, $vidorev_submit_video_playlist_cats_u, 'vid_playlist_cat', true);
				}
				
				if($vidorev_submit_video_channel > 0 && defined('CHANNEL_PM_PREFIX')){
					$playlists_in = get_post_meta($vidorev_submit_video_channel, CHANNEL_PM_PREFIX.'playlists', true);					
					if(is_array($playlists_in)){
						if(($izc = array_search($newPostID, $playlists_in)) === FALSE){
							array_push($playlists_in, $newPostID);
							update_post_meta($vidorev_submit_video_channel, CHANNEL_PM_PREFIX.'playlists', array_map('strval', $playlists_in));
						}
					}else{
						update_post_meta($vidorev_submit_video_channel, CHANNEL_PM_PREFIX.'playlists', array_map('strval', array($newPostID)));
					}
				}
				
				if(isset($_FILES['vidorev-submit-playlist-featured-image']) && isset($_FILES['vidorev-submit-playlist-featured-image']['error']) && $_FILES['vidorev-submit-playlist-featured-image']['error'] == 0){
					if(!function_exists('wp_handle_upload') || !function_exists('wp_generate_attachment_metadata')){
						require_once( ABSPATH . 'wp-admin/includes/admin.php' );
						require_once( ABSPATH . 'wp-admin/includes/image.php' );
						require_once( ABSPATH . 'wp-admin/includes/file.php' );
						require_once( ABSPATH . 'wp-admin/includes/media.php' );
					}
					$upload_overrides 	= array( 'test_form' => false );
					$movefile 			= wp_handle_upload( $_FILES['vidorev-submit-playlist-featured-image'], $upload_overrides );
					
					if ( $movefile && !isset( $movefile['error'] ) ) {
						$attachment = array(
							'post_mime_type' 	=> $movefile['type'],
							'post_parent' 		=> $newPostID,
							'post_title' 		=> sanitize_file_name($_FILES['vidorev-submit-playlist-featured-image']['name']),
							'post_content' 		=> '',
							'post_status' 		=> 'inherit'
						);
						
						$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $newPostID );
						
						if(!function_exists('wp_generate_attachment_metadata')){
							require_once( ABSPATH . 'wp-admin/includes/image.php' );
							require_once( ABSPATH . 'wp-admin/includes/file.php' );
							require_once( ABSPATH . 'wp-admin/includes/media.php' );
						}
						
						$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
						wp_update_attachment_metadata( $attach_id, $attach_data );	
						set_post_thumbnail( $newPostID, $attach_id );
					}
				}
				
				$submit_list = array();
				$submit_list['post_title'] 		= $postData['post_title'];	
				$submit_list['post_status'] 	= 'pending';
				$submit_list['post_type'] 		= 'playlist_user_submit';
				
				$submitID = wp_insert_post($submit_list);
				if(!is_wp_error($submitID) && $submitID){
					update_post_meta($submitID, 'first_name', $vidorev_submit_first_name);
					update_post_meta($submitID, 'last_name', $vidorev_submit_last_name);
					update_post_meta($submitID, 'email', $vidorev_submit_user_email);
					update_post_meta($submitID, 'user_id', $user_submit_id);
					update_post_meta($submitID, 'u_playlist_id', $newPostID);
					
					update_post_meta($newPostID, 'playlist_submit_id', $submitID);
				}
				
				do_action('beeteam368_submit_playlist_after_custom_data_FE', $newPostID);
				
			}
			
		}
		
		return $posted_data;
	}
}

add_filter( 'wpcf7_posted_data', 'vidorev_cf7_save_playlist_data' );

if(!function_exists('vidorev_cf7_save_channel_data')){
	function vidorev_cf7_save_channel_data( $posted_data ) {
		
		$new_cf7_version = ( defined( 'WPCF7_VERSION' ) && version_compare( WPCF7_VERSION, '5.2', '>=' ) );
		
		if ( $new_cf7_version ) {
			$posted_data['_wpcf7_container_post'] 	= (isset($_POST['_wpcf7_container_post']))?$_POST['_wpcf7_container_post']:0;
			$posted_data['_wpcf7_unit_tag']			= (isset($_POST['_wpcf7_unit_tag']))?$_POST['_wpcf7_unit_tag']:'';
		}
		
		$submit_video_page = vidorev_get_redux_option('submit_video_page', '');
		$get_crr_sbm_page = (isset($posted_data['_wpcf7_container_post']))?$posted_data['_wpcf7_container_post']:0;
		$vidorev_detech_lang_submit_page = vidorev_detech_lang_submit_page($get_crr_sbm_page);
		
		if(isset($posted_data['vidorev-submit-channel-user-login']) && isset($posted_data['_wpcf7_container_post']) && ($posted_data['_wpcf7_container_post'] == $submit_video_page || $vidorev_detech_lang_submit_page[0])){
			
			$posting_without_login = trim(vidorev_get_option('posting_without_login', 'user_submit_settings', 'no'));
			
			$user_submit_id = 0;
			if(is_user_logged_in()){
				$current_user = wp_get_current_user();
				if($current_user->user_login == $posted_data['vidorev-submit-channel-user-login']){
					$user_submit_id = $current_user->ID;
				}
			}
			
			if( $user_submit_id == 0 && $posting_without_login == 'no'){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('Please login before submitting this form!', 'vidorev-extensions'),					
				);
				
				wp_send_json($error);
				return;
				die;
			}
			
			if($user_submit_id == 0 && $posting_without_login == 'yes'){
				$user_login_name = $posted_data['vidorev-submit-channel-user-login'];
				if($user_login_name!=''){
					$current_user = get_user_by('login', $user_login_name);
					if($current_user){
						$user_submit_id = $current_user->ID;
					}
				}
			}
			
			/*check permision*/
			$user_meta	= get_userdata($user_submit_id);
			$user_roles	= $user_meta->roles;
			
			global $wp_roles;
			$all_roles 	= implode(', ', array_keys($wp_roles->role_names));		
			$roles 		= explode(',', trim(vidorev_get_option('channel_roles', 'user_submit_settings', $all_roles)));
			$roles_op 	= array();
			
			foreach($roles as $role){
				$role = trim($role);
				if($role!=''){
					$roles_op[] = $role;
				}
			}
			
			$permisions = array();
			$permisions = array_intersect($user_roles, $roles_op);
			
			if(count($permisions) == 0 && $posting_without_login == 'no'){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('You are not allowed to submit this information!', 'vidorev-extensions'),					
				);
				
				wp_send_json($error);
				return;
				die;
			}/*check permision*/
			
			do_action('beeteam368_submit_channel_before_check_data_FE', $posted_data);
			
			$vidorev_submit_first_name 				= '';
			$vidorev_submit_last_name 				= '';
			$vidorev_submit_user_email 				= '';
			$vidorev_submit_channel_title 			= '';
			
			if(isset($posted_data['vidorev-submit-first-name']) && trim($posted_data['vidorev-submit-first-name'])!=''){
				$vidorev_submit_first_name = trim($posted_data['vidorev-submit-first-name']);
			}
			
			if(isset($posted_data['vidorev-submit-last-name']) && trim($posted_data['vidorev-submit-last-name'])!=''){
				$vidorev_submit_last_name = trim($posted_data['vidorev-submit-last-name']);
			}
			
			if(isset($posted_data['vidorev-submit-user-email']) && trim($posted_data['vidorev-submit-user-email'])!=''){
				$vidorev_submit_user_email = trim($posted_data['vidorev-submit-user-email']);
			}
			
			if(isset($posted_data['vidorev-submit-channel-title']) && trim($posted_data['vidorev-submit-channel-title'])!=''){
				$vidorev_submit_channel_title = trim($posted_data['vidorev-submit-channel-title']);
			}
			
			if(/*$vidorev_submit_first_name == '' || $vidorev_submit_last_name == '' ||*/ $vidorev_submit_user_email == '' || $vidorev_submit_channel_title == ''){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('One or more fields have an error. Please check and try again.', 'vidorev-extensions'),					
				);
				
				if($vidorev_submit_user_email == ''){
					$error['invalidFields'][] = array(
						'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-user-email',
						'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
						'idref'		=> null,
					);
					
					if ( $new_cf7_version ) {
						$error['invalid_fields'][] = array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-user-email',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						);
					}
				}
				
				if($vidorev_submit_channel_title == ''){
					$error['invalidFields'][] = array(
						'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-channel-title',
						'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
						'idref'		=> null,
					);
					
					if ( $new_cf7_version ) {
						$error['invalid_fields'][] = array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-channel-title',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						);
					}
				}
				
				wp_send_json($error);
				return;
				die;
			}
			
			/**/
			$channel_file_types = array('featured', 'logo', 'banner');
			
			$limit_image_upload_param = trim(vidorev_get_option('limit_ft_upload', 'user_submit_settings', '2mb'));
			$limit_image_upload = vidorev_detech_limit_upload($limit_image_upload_param);

			$arr_img_upload_err = array();			
			foreach($channel_file_types as $type){
				$file_name = 'vidorev-submit-channel-'.$type.'-image';
				if(isset($_FILES[$file_name]) && isset($_FILES[$file_name]['error']) && $_FILES[$file_name]['error'] == 0){	
					if($_FILES[$file_name]['size'] > $limit_image_upload){
						array_push($arr_img_upload_err, array(
							'into'		=>'span.wpcf7-form-control-wrap.'.$file_name,
							'message' 	=> esc_html__('The file is too big.', 'vidorev-extensions'),
							'idref'		=> null,
						));
					}
										
				}
			}
			
			if(count($arr_img_upload_err) > 0){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('Uploaded file is too large. You can only upload up to ', 'vidorev-extensions').$limit_image_upload_param,
					'invalidFields' 	=> $arr_img_upload_err,
				);
				
				if ( $new_cf7_version ) {
					$error['invalid_fields'] = $arr_img_upload_err;
				}
				
				wp_send_json($error);
				return;
				die;
			}
			/**/
			
			$vidorev_submit_channel_content 	= '';
			
			if(isset($posted_data['vidorev-submit-channel-content']) && trim($posted_data['vidorev-submit-channel-content'])!=''){
				$vidorev_submit_channel_content = trim($posted_data['vidorev-submit-channel-content']);
			}
			
			do_action('beeteam368_submit_channel_before_check_additional_data_FE', $posted_data);
			
			$postData = array();
			
			$postData['post_type']		= 'vid_channel';
			
			$postData['post_title'] 	= $vidorev_submit_channel_title;	
			
			$post_status 				= trim(vidorev_get_option('post_status', 'user_submit_settings', 'pending'));
			$postData['post_status'] 	= $post_status;
			
			$postData['post_content']	= $vidorev_submit_channel_content;
			
			if($user_submit_id > 0){
				$postData['post_author'] 	= $user_submit_id;
			}
			
			$newPostID = wp_insert_post($postData);
			
			if(!is_wp_error($newPostID) && $newPostID){
				
				if(isset($posted_data['vidorev-submit-video-channel-cats']) && !empty($posted_data['vidorev-submit-video-channel-cats']) && is_array($posted_data['vidorev-submit-video-channel-cats'])){
					$vidorev_submit_video_channel_cats_u	= array();
					$vidorev_submit_video_channel_cats 	= $posted_data['vidorev-submit-video-channel-cats'];	
					foreach($vidorev_submit_video_channel_cats as $vidorev_submit_video_channel_cats_it){
						$vidorev_submit_video_channel_cats_u[] = (int)$vidorev_submit_video_channel_cats_it;
					}			
					wp_set_object_terms($newPostID, $vidorev_submit_video_channel_cats_u, 'vid_channel_cat', true);
				}
				
				foreach($channel_file_types as $type){
					
					if(isset($_FILES['vidorev-submit-channel-'.$type.'-image']) && isset($_FILES['vidorev-submit-channel-'.$type.'-image']['error']) && $_FILES['vidorev-submit-channel-'.$type.'-image']['error'] == 0){
						if(!function_exists('wp_handle_upload') || !function_exists('wp_generate_attachment_metadata')){
							require_once( ABSPATH . 'wp-admin/includes/admin.php' );
							require_once( ABSPATH . 'wp-admin/includes/image.php' );
							require_once( ABSPATH . 'wp-admin/includes/file.php' );
							require_once( ABSPATH . 'wp-admin/includes/media.php' );
						}
						$upload_overrides 	= array( 'test_form' => false );
						$movefile 			= wp_handle_upload( $_FILES['vidorev-submit-channel-'.$type.'-image'], $upload_overrides );
						
						if ( $movefile && !isset( $movefile['error'] ) ) {
							$attachment = array(
								'post_mime_type' 	=> $movefile['type'],
								'post_parent' 		=> $newPostID,
								'post_title' 		=> sanitize_file_name($_FILES['vidorev-submit-channel-'.$type.'-image']['name']),
								'post_content' 		=> '',
								'post_status' 		=> 'inherit'
							);
							
							$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $newPostID );
							
							if(!function_exists('wp_generate_attachment_metadata')){
								require_once( ABSPATH . 'wp-admin/includes/image.php' );
								require_once( ABSPATH . 'wp-admin/includes/file.php' );
								require_once( ABSPATH . 'wp-admin/includes/media.php' );
							}
							
							$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
							wp_update_attachment_metadata( $attach_id, $attach_data );
							
							switch($type){
								case 'featured':
									set_post_thumbnail( $newPostID, $attach_id );
									break;
									
								case 'logo':
									update_post_meta($newPostID, CHANNEL_PM_PREFIX.'logo_id', $attach_id);
									update_post_meta($newPostID, CHANNEL_PM_PREFIX.'logo', wp_get_attachment_url($attach_id));
									break;
									
								case 'banner':
									update_post_meta($newPostID, CHANNEL_PM_PREFIX.'banner_id', $attach_id);
									update_post_meta($newPostID, CHANNEL_PM_PREFIX.'banner', wp_get_attachment_url($attach_id));
									break;		
							}	
							
						}
					}
					
				}
				
				$submit_list = array();
				$submit_list['post_title'] 		= $postData['post_title'];	
				$submit_list['post_status'] 	= 'pending';
				$submit_list['post_type'] 		= 'channel_user_submit';
				
				$submitID = wp_insert_post($submit_list);
				if(!is_wp_error($submitID) && $submitID){
					update_post_meta($submitID, 'first_name', $vidorev_submit_first_name);
					update_post_meta($submitID, 'last_name', $vidorev_submit_last_name);
					update_post_meta($submitID, 'email', $vidorev_submit_user_email);
					update_post_meta($submitID, 'user_id', $user_submit_id);
					update_post_meta($submitID, 'u_channel_id', $newPostID);
					
					update_post_meta($newPostID, 'channel_submit_id', $submitID);
				}
				
				do_action('beeteam368_submit_channel_after_custom_data_FE', $newPostID);
				
			}
			
		}
		
		return $posted_data;
	}
}

add_filter( 'wpcf7_posted_data', 'vidorev_cf7_save_channel_data' );


if(!function_exists('vidorev_ftp_mksubdirs')){
	function vidorev_ftp_mksubdirs($ftpcon, $ftpbasedir, $ftpath){
		@ftp_chdir($ftpcon, $ftpbasedir);
		$parts = explode('/', $ftpath);
		foreach($parts as $part){
			if(!@ftp_chdir($ftpcon, $part)){
				ftp_mkdir($ftpcon, $part);
				ftp_chdir($ftpcon, $part);
				/*ftp_chmod($ftpcon, 0777, $part);*/
			}
		}
	}
}

if(!function_exists('vidorev_readVideoChunk')){
	function vidorev_readVideoChunk ($handle, $chunkSize){
		$byteCount 	= 0;
		$giantChunk = "";
		while (!feof($handle)) {
			$chunk = fread($handle, 8192);
			$byteCount += strlen($chunk);
			$giantChunk .= $chunk;
			if ($byteCount >= $chunkSize){
				return $giantChunk;
			}
		}
		return $giantChunk;
	}
}

if(!function_exists('vidorev_cf7_save_posted_data')){
	function vidorev_cf7_save_posted_data( $posted_data ) {
		
		$new_cf7_version = ( defined( 'WPCF7_VERSION' ) && version_compare( WPCF7_VERSION, '5.2', '>=' ) );
		
		if ( $new_cf7_version ) {
			$posted_data['_wpcf7_container_post'] 	= (isset($_POST['_wpcf7_container_post']))?$_POST['_wpcf7_container_post']:0;
			$posted_data['_wpcf7_unit_tag']			= (isset($_POST['_wpcf7_unit_tag']))?$_POST['_wpcf7_unit_tag']:'';
		}
		
		$submit_video_page = vidorev_get_redux_option('submit_video_page', '');
		$get_crr_sbm_page = (isset($posted_data['_wpcf7_container_post']))?$posted_data['_wpcf7_container_post']:0;
		$vidorev_detech_lang_submit_page = vidorev_detech_lang_submit_page($get_crr_sbm_page);
		
		if(isset($posted_data['vidorev-submit-user-login']) && isset($posted_data['_wpcf7_container_post']) && ($posted_data['_wpcf7_container_post'] == $submit_video_page || $vidorev_detech_lang_submit_page[0])){
			
			$posting_without_login = trim(vidorev_get_option('posting_without_login', 'user_submit_settings', 'no'));
			
			$user_submit_id = 0;
			if(is_user_logged_in()){
				$current_user = wp_get_current_user();
				if($current_user->user_login == $posted_data['vidorev-submit-user-login']){
					$user_submit_id = $current_user->ID;
				}
			}
			
			if( $user_submit_id == 0 && $posting_without_login == 'no'){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('Please login before submitting this form!', 'vidorev-extensions'),					
				);
				
				wp_send_json($error);
				return;
				die;
			}
			
			if($user_submit_id == 0 && $posting_without_login == 'yes'){
				$user_login_name = $posted_data['vidorev-submit-user-login'];
				if($user_login_name!=''){
					$current_user = get_user_by('login', $user_login_name);
					if($current_user){
						$user_submit_id = $current_user->ID;
					}
				}
			}
			
			/*check permision*/
			$user_meta	= get_userdata($user_submit_id);
			$user_roles	= $user_meta->roles;
			
			global $wp_roles;
			$all_roles = implode(', ', array_keys($wp_roles->role_names));
			
			$roles 		= explode(',', trim(vidorev_get_option('roles', 'user_submit_settings', $all_roles)));
			$roles_op 	= array();
			
			foreach($roles as $role){
				$role = trim($role);
				if($role!=''){
					$roles_op[] = $role;
				}
			}
			
			$permisions = array();
			$permisions = array_intersect($user_roles, $roles_op);
			
			if(count($permisions) == 0 && $posting_without_login == 'no'){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('You are not allowed to submit this information!', 'vidorev-extensions'),					
				);
				
				wp_send_json($error);
				return;
				die;
			}/*check permision*/
			
			do_action('beeteam368_submit_post_before_check_data_FE', $posted_data);
			
			$vidorev_submit_first_name 				= '';
			$vidorev_submit_last_name 				= '';
			$vidorev_submit_user_email 				= '';
			$vidorev_submit_video_title 			= '';
			$vidorev_submit_video_url 				= '';			
			$vidorev_submit_video_content 			= '';
			
			$vidorev_submit_video_featured_image 	= '';
			$vidorev_submit_video_file_mp4 			= '';
			$vidorev_submit_video_file_flv 			= '';
			$vidorev_submit_video_file_m4v 			= '';
			$vidorev_submit_video_file_webm 		= '';
			$vidorev_submit_video_file_ogv 			= '';
			$vidorev_submit_video_file_wmv 			= '';
			
			$vidorev_submit_video_tags 				= '';
			$vidorev_submit_video_categories		= array();
			$vidorev_submit_video_playlist			= 0;
			$vidorev_submit_video_channel 			= 0;
			
			if(isset($posted_data['vidorev-submit-first-name']) && trim($posted_data['vidorev-submit-first-name'])!=''){
				$vidorev_submit_first_name = trim($posted_data['vidorev-submit-first-name']);
			}
			
			if(isset($posted_data['vidorev-submit-last-name']) && trim($posted_data['vidorev-submit-last-name'])!=''){
				$vidorev_submit_last_name = trim($posted_data['vidorev-submit-last-name']);
			}
			
			if(isset($posted_data['vidorev-submit-user-email']) && trim($posted_data['vidorev-submit-user-email'])!=''){
				$vidorev_submit_user_email = trim($posted_data['vidorev-submit-user-email']);
			}
			
			if(isset($posted_data['vidorev-submit-video-title']) && trim($posted_data['vidorev-submit-video-title'])!=''){
				$vidorev_submit_video_title = trim($posted_data['vidorev-submit-video-title']);
			}
			
			if(/*$vidorev_submit_first_name == '' || $vidorev_submit_last_name == '' ||*/ $vidorev_submit_user_email == '' || $vidorev_submit_video_title == ''){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('One or more fields have an error. Please check and try again.', 'vidorev-extensions'),					
				);
				
				if($vidorev_submit_user_email == ''){
					$error['invalidFields'][] = array(
						'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-user-email',
						'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
						'idref'		=> null,
					);
					
					if ( $new_cf7_version ) {
						$error['invalid_fields'][] = array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-user-email',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						);
					}
				}
				
				if($vidorev_submit_video_title == ''){
					$error['invalidFields'][] = array(
						'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-title',
						'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
						'idref'		=> null,
					);
					
					if ( $new_cf7_version ) {
						$error['invalid_fields'][] = array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-title',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						);
					}
				}
				
				wp_send_json($error);
				return;
				die;
			}
			
			if(isset($posted_data['vidorev-submit-video-content']) && trim($posted_data['vidorev-submit-video-content'])!=''){
				$vidorev_submit_video_content = trim($posted_data['vidorev-submit-video-content']);
			}
			
			if(isset($posted_data['vidorev-submit-video-tags']) && !empty($posted_data['vidorev-submit-video-tags'])){
				if(is_array($posted_data['vidorev-submit-video-tags'])){
					$vidorev_submit_video_tags = trim(implode(',', $posted_data['vidorev-submit-video-tags']));
				}elseif(trim($posted_data['vidorev-submit-video-tags'])!=''){
					$vidorev_submit_video_tags = trim($posted_data['vidorev-submit-video-tags']);
				}				
			}
			
			if(isset($posted_data['vidorev-submit-video-categories']) && is_array($posted_data['vidorev-submit-video-categories'])){
				$vidorev_submit_video_categories = $posted_data['vidorev-submit-video-categories'];
			}
			
			if(isset($posted_data['vidorev-submit-video-playlist']) && is_numeric($posted_data['vidorev-submit-video-playlist'])){
				$vidorev_submit_video_playlist = $posted_data['vidorev-submit-video-playlist'];
			}
			
			if(isset($posted_data['vidorev-submit-video-channel']) && is_numeric($posted_data['vidorev-submit-video-channel'])){
				$vidorev_submit_video_channel = $posted_data['vidorev-submit-video-channel'];
			}
			
			if(isset($posted_data['vidorev-submit-video-url']) && trim($posted_data['vidorev-submit-video-url'])!=''){
				$vidorev_submit_video_url = trim($posted_data['vidorev-submit-video-url']);
			}
			
			$video_list_files = array('', '-mp4', '-flv', '-m4v', '-webm', '-ogv', '-wmv');
			
			$limit_param	= trim(vidorev_get_option('limit_vid_upload', 'user_submit_settings', '10mb'));
			if ( defined( 'PMPRO_VERSION' ) && isset($current_user->membership_level) && isset($current_user->membership_level->ID) && is_numeric($current_user->membership_level->ID)) {
				$new_limit_param	= trim(vidorev_get_option('limit_vid_upload_membership_'.$current_user->membership_level->ID, 'user_submit_settings', ''));
				if($new_limit_param!=''){
					$limit_param = $new_limit_param;
				}
			}
			$limit_upload 	= vidorev_detech_limit_upload($limit_param);
			
			$i_err = 0;
			
			/*Custom Upload DND*/
				$dd_upload = false; /*find $dd_upload*/
				if(isset($posted_data['vidorev-submit-video-file-pb-check']) && trim($posted_data['vidorev-submit-video-file-pb-check']) == '1'){					
					$dd_upload = true;	
					
					$dd_files_arr = array();
					if(isset($posted_data['vidorev-submit-video-file-pb']) && is_array($posted_data['vidorev-submit-video-file-pb']) && count($posted_data['vidorev-submit-video-file-pb'])>0){
						$dd_files_arr = $posted_data['vidorev-submit-video-file-pb'];
					}					
					
					$dd_list_files = array();
					foreach($dd_files_arr as $dd_file){
						if( file_exists( $dd_file ) ) {
							$i_err++;
							array_push($dd_list_files, $dd_file);
						}
					}
					
					if($vidorev_submit_video_url == '' && $i_err == 0){
						$error = array(
							'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
							'status' 			=> 'validation_failed',
							'message' 			=> esc_html__('You need to enter a Video URL or upload a video file. Please check and try again.', 'vidorev-extensions'),
							'invalidFields' 	=> array(
								array(
									'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-url',
									'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
									'idref'		=> null,
								),
								array(
									'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-pb',
									'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
									'idref'		=> null,
								),								
							),
						);
						
						if ( $new_cf7_version ) {
							$error['invalid_fields'] = array(
								array(
									'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-url',
									'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
									'idref'		=> null,
								),
								array(
									'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-pb',
									'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
									'idref'		=> null,
								),								
							);
						}
						
						wp_send_json($error);
						return;
						die;
					}
							
				}
			/*Custom Upload DND*/			
			
			$arr_vid_upload_err = array();			
			foreach($video_list_files as $ex){
				$file_name = 'vidorev-submit-video-file'.$ex;
				if(isset($_FILES[$file_name]) && isset($_FILES[$file_name]['error']) && $_FILES[$file_name]['error'] == 0){									
					$i_err++;
					
					if($_FILES[$file_name]['size'] > $limit_upload && !$dd_upload){
						array_push($arr_vid_upload_err, array(
							'into'		=>'span.wpcf7-form-control-wrap.'.$file_name,
							'message' 	=> esc_html__('The file is too big.', 'vidorev-extensions'),
							'idref'		=> null,
						));
					}
										
				}
			}
			
			if($vidorev_submit_video_url == '' && $i_err == 0 && !$dd_upload){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('You need to enter a Video URL or upload a video file. Please check and try again.', 'vidorev-extensions'),
					'invalidFields' 	=> array(
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-url',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-mp4',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-flv',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-m4v',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-webm',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-ogv',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-wmv',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
					),
				);
				
				if ( $new_cf7_version ) {
					$error['invalid_fields'] = array(
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-url',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-mp4',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-flv',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-m4v',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-webm',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-ogv',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
						array(
							'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-file-wmv',
							'message' 	=> esc_html__('The field is required.', 'vidorev-extensions'),
							'idref'		=> null,
						),
					);
				}
				
				wp_send_json($error);
				return;
				die;
			}
			
			if(count($arr_vid_upload_err) > 0){
				$error = array(
					'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
					'status' 			=> 'validation_failed',
					'message' 			=> esc_html__('Uploaded file is too large. You can only upload up to ', 'vidorev-extensions').$limit_param,
					'invalidFields' 	=> $arr_vid_upload_err,
				);
				
				if ( $new_cf7_version ) {
					$error['invalid_fields'] = $arr_vid_upload_err;
				}
				
				wp_send_json($error);
				return;
				die;
			}
			
			do_action('beeteam368_submit_post_before_check_additional_data_FE', $posted_data);
			
			$storage = trim(vidorev_get_option('storage', 'user_submit_settings', 'self_hosted'));			
			if($i_err > 0 && $storage != 'self_hosted'){
				
				switch($storage){
					case 'as_ftp':
					
						$storage_ftp_server_ip		= trim(vidorev_get_option('storage_ftp_server_ip', 'user_submit_settings', ''));
						$storage_ftp_server_port	= trim(vidorev_get_option('storage_ftp_server_port', 'user_submit_settings', ''));
						$storage_ftp_username		= trim(vidorev_get_option('storage_ftp_username', 'user_submit_settings', ''));
						$storage_ftp_password		= trim(vidorev_get_option('storage_ftp_password', 'user_submit_settings', ''));
						
						$conn_id 		= ftp_connect($storage_ftp_server_ip, $storage_ftp_server_port, 368);
						$login_result 	= ftp_login($conn_id, $storage_ftp_username, $storage_ftp_password);
						ftp_pasv($conn_id, true);
						
						if ((!$conn_id) || (!$login_result)) {
							ftp_close($conn_id);
							$error = array(
								'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
								'status' 			=> 'validation_failed',
								'message' 			=> esc_html__('FTP connection has failed!', 'vidorev-extensions'),
							);
							wp_send_json($error);
							return;
							die;
						}
						
						break;
						
					case 'google_drive':
												
						if(!class_exists('Google_Client')){
							$error = array(
								'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
								'status' 			=> 'validation_failed',
								'message' 			=> esc_html__('Please install plugin "VidoRev Google APIs Client Library for PHP"', 'vidorev-extensions'),
							);
							wp_send_json($error);
							return;
							die;
						}else{
							
							$storage_gd_service_account_id = trim(vidorev_get_option('storage_gd_service_account_id', 'user_submit_settings', ''));
							if($storage_gd_service_account_id=='' || !is_numeric($storage_gd_service_account_id)){
								$error = array(
									'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
									'status' 			=> 'validation_failed',
									'message' 			=> esc_html__('Please declare your JSON file for Authentication', 'vidorev-extensions'),
								);
								wp_send_json($error);
								return;
								die;
							}
							
							$fullAuth_path = get_attached_file( $storage_gd_service_account_id );
							
							if(!$fullAuth_path){
								$error = array(
									'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
									'status' 			=> 'validation_failed',
									'message' 			=> esc_html__('Please declare your JSON file for Authentication', 'vidorev-extensions'),
								);
								wp_send_json($error);
								return;
								die;
							}
							
							putenv('GOOGLE_APPLICATION_CREDENTIALS='.$fullAuth_path);
							
							try {	
													
								$gda_client = new Google_Client();
								$gda_client->useApplicationDefaultCredentials();
								$gda_client->addScope(Google_Service_Drive::DRIVE);	
								
								$gda_service 	= new Google_Service_Drive($gda_client);
								
								$gda_optParams = array(
									'pageSize' => 1,
									'fields' 	=> 'nextPageToken, files(id)'
								);
								
								$gda_check_result = $gda_service->files->listFiles($gda_optParams);
								
							}catch (Exception $e) {
								$error = array(
									'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
									'status' 			=> 'validation_failed',
									'message' 			=> esc_html($e->getMessage()),
								);
								wp_send_json($error);
								return;
								die;
							}
							
						}
							
						break;	
				}
				
			}
			
			$limit_image_upload_param = trim(vidorev_get_option('limit_ft_upload', 'user_submit_settings', '2mb'));
			$limit_image_upload = vidorev_detech_limit_upload($limit_image_upload_param);			
			if(isset($_FILES['vidorev-submit-video-featured-image']) && isset($_FILES['vidorev-submit-video-featured-image']['error']) && $_FILES['vidorev-submit-video-featured-image']['error'] == 0){
				if($_FILES['vidorev-submit-video-featured-image']['size'] > $limit_image_upload){
					$error = array(
						'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
						'status' 			=> 'validation_failed',
						'message' 			=> esc_html__('Uploaded file is too large. You can only upload up to ', 'vidorev-extensions').$limit_image_upload_param,
						'invalidFields' 	=> array(
							array(
								'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-featured-image',
								'message' 	=> esc_html__('The file is too big.', 'vidorev-extensions'),
								'idref'		=> null,
							)
						),
					);
					
					if ( $new_cf7_version ) {
						$error['invalid_fields'] = array(
							array(
								'into'		=>'span.wpcf7-form-control-wrap.vidorev-submit-video-featured-image',
								'message' 	=> esc_html__('The file is too big.', 'vidorev-extensions'),
								'idref'		=> null,
							)
						);
					}
					
					wp_send_json($error);
					return;
					die;
				}
			}
			
			$postData = array();
			
			$postData['post_title'] 	= $vidorev_submit_video_title;	
			
			$post_status 				= trim(vidorev_get_option('post_status', 'user_submit_settings', 'pending'));
			$postData['post_status'] 	= $post_status;
			
			$postData['post_content']	= $vidorev_submit_video_content;
			$postData['post_category'] 	= $vidorev_submit_video_categories;
			
			if($user_submit_id > 0){
				$postData['post_author'] 	= $user_submit_id;
			}
			
			$newPostID = wp_insert_post($postData);
			
			if(!is_wp_error($newPostID) && $newPostID){
				
				do_action('beeteam368_submit_post_before_custom_data_FE', $newPostID);
				
				set_post_format($newPostID, 'video' );
				
				if($vidorev_submit_video_tags!=''){
					$tag_array = explode(',', $vidorev_submit_video_tags);
					wp_set_object_terms($newPostID, $tag_array, 'post_tag', true);
				}
				
				if($vidorev_submit_video_playlist > 0 && defined('PLAYLIST_PM_PREFIX')){
					$videos_in = get_post_meta($vidorev_submit_video_playlist, PLAYLIST_PM_PREFIX.'videos', true);					
					if(is_array($videos_in)){
						if(($izp = array_search($newPostID, $videos_in)) === FALSE){
							array_push($videos_in, $newPostID);
							update_post_meta($vidorev_submit_video_playlist, PLAYLIST_PM_PREFIX.'videos', array_map('strval', $videos_in));
						}
					}else{
						update_post_meta($vidorev_submit_video_playlist, PLAYLIST_PM_PREFIX.'videos', array_map('strval', array($newPostID)));
					}
					
					update_post_meta($newPostID, PLAYLIST_PM_PREFIX.'sync_playlist', array($vidorev_submit_video_playlist));
				}
				
				if($vidorev_submit_video_channel > 0 && defined('CHANNEL_PM_PREFIX')){
					$videos_in = get_post_meta($vidorev_submit_video_channel, CHANNEL_PM_PREFIX.'videos', true);					
					if(is_array($videos_in)){
						if(($izc = array_search($newPostID, $videos_in)) === FALSE){
							array_push($videos_in, $newPostID);
							update_post_meta($vidorev_submit_video_channel, CHANNEL_PM_PREFIX.'videos', array_map('strval', $videos_in));
						}
					}else{
						update_post_meta($vidorev_submit_video_channel, CHANNEL_PM_PREFIX.'videos', array_map('strval', array($newPostID)));
					}
					
					update_post_meta($newPostID, CHANNEL_PM_PREFIX.'sync_channel', array($vidorev_submit_video_channel));
				}
				
				if(isset($_FILES['vidorev-submit-video-featured-image']) && isset($_FILES['vidorev-submit-video-featured-image']['error']) && $_FILES['vidorev-submit-video-featured-image']['error'] == 0){
					if(!function_exists('wp_handle_upload') || !function_exists('wp_generate_attachment_metadata')){
						require_once( ABSPATH . 'wp-admin/includes/admin.php' );
						require_once( ABSPATH . 'wp-admin/includes/image.php' );
						require_once( ABSPATH . 'wp-admin/includes/file.php' );
						require_once( ABSPATH . 'wp-admin/includes/media.php' );
					}
					$upload_overrides 	= array( 'test_form' => false );
					$movefile 			= wp_handle_upload( $_FILES['vidorev-submit-video-featured-image'], $upload_overrides );
					
					if ( $movefile && !isset( $movefile['error'] ) ) {
						$attachment = array(
							'post_mime_type' 	=> $movefile['type'],
							'post_parent' 		=> $newPostID,
							'post_title' 		=> sanitize_file_name($_FILES['vidorev-submit-video-featured-image']['name']),
							'post_content' 		=> '',
							'post_status' 		=> 'inherit'
						);
						
						$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $newPostID );
						
						if(!function_exists('wp_generate_attachment_metadata')){
							require_once( ABSPATH . 'wp-admin/includes/image.php' );
							require_once( ABSPATH . 'wp-admin/includes/file.php' );
							require_once( ABSPATH . 'wp-admin/includes/media.php' );
						}
						
						$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
						wp_update_attachment_metadata( $attach_id, $attach_data );	
						set_post_thumbnail( $newPostID, $attach_id );
					}
				}
				
				if($i_err > 0){					
					
					$html5_video_files = '';
					$count_files	   = 0;
					
					switch($storage){
						case 'self_hosted':
							if(!function_exists('wp_handle_upload') || !function_exists('wp_generate_attachment_metadata')){
								require_once( ABSPATH . 'wp-admin/includes/admin.php' );
								require_once( ABSPATH . 'wp-admin/includes/image.php' );
								require_once( ABSPATH . 'wp-admin/includes/file.php' );
								require_once( ABSPATH . 'wp-admin/includes/media.php' );
							}
							
							if($dd_upload){
								
								$wp_upload_dir = wp_upload_dir();
								
								foreach($dd_list_files as $dd_move_file){
									if(file_exists($dd_move_file)){
										$dd_base_name 		= wp_basename($dd_move_file);
										$dd_new_file_name	= wp_unique_filename($wp_upload_dir['path'], $dd_base_name);
										$dd_new_file_path 	= path_join($wp_upload_dir['path'], $dd_new_file_name);
										
										copy($dd_move_file, $dd_new_file_path);
										
										$filetype = wp_check_filetype($dd_new_file_name, null);
										
										$attachment = 	array(
											'guid'           => trailingslashit($wp_upload_dir['url']).$dd_new_file_name, 
											'post_mime_type' => $filetype['type'],
											'post_title'     => sanitize_file_name($dd_new_file_name),
											'post_content'   => '',
											'post_status'    => 'inherit'
										);
										
										$attach_id 			= wp_insert_attachment($attachment, $dd_new_file_path, $newPostID);								
										$vid_attach_data	= wp_generate_attachment_metadata($attach_id, $dd_new_file_path);
										wp_update_attachment_metadata($attach_id, $vid_attach_data);
										
										if( file_exists( $dd_move_file ) ){
											wp_delete_file( $dd_move_file );											
										}
										
										$html5_video_files.= trailingslashit($wp_upload_dir['url']).$dd_new_file_name.PHP_EOL;
										$count_files++;
									}
								}
								
							}else{
								
								foreach($video_list_files as $ex){						
									$file_name = 'vidorev-submit-video-file'.$ex;
									if(isset($_FILES[$file_name]) && isset($_FILES[$file_name]['error']) && $_FILES[$file_name]['error'] == 0){									
										$upload_overrides 	= array( 'test_form' => false );
										$movefile 			= wp_handle_upload( $_FILES[$file_name], $upload_overrides );	
										
										if ( $movefile && !isset( $movefile['error'] ) ) {
											$attachment = array(
												'post_mime_type' 	=> $movefile['type'],
												'post_parent' 		=> $newPostID,
												'post_title' 		=> sanitize_file_name($_FILES[$file_name]['name']),
												'post_content' 		=> '',
												'post_status' 		=> 'inherit'
											);
											
											$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $newPostID );
											
											$vid_attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
											wp_update_attachment_metadata( $attach_id, $vid_attach_data );
											
											$html5_video_files.=$movefile['url'].PHP_EOL;
											$count_files++;
										}
									}
								}
								
							}
							break;
							
						case 'as_ftp':
							if($dd_upload){
								
								foreach($dd_list_files as $dd_move_file){
									if(file_exists($dd_move_file)){
										if($user_submit_id > 0){
											$new_dir = '/'.date('Y-m-d').'/'.$user_submit_id.'-'.$current_user->user_login.'/';
										}else{
											$new_dir = '/'.date('Y-m-d').'/'.$user_submit_id.'-anonymous/'.rand().'/';
										}
										
										vidorev_ftp_mksubdirs($conn_id, '', $new_dir);
										
										$dd_base_name 		= wp_basename($dd_move_file);
										$destination_file 	= trailingslashit($new_dir).time().'-'.$dd_base_name;
										
										$upload 			= ftp_put($conn_id, $destination_file, $dd_move_file, FTP_BINARY);
										
										if ($upload) {
											
											if( file_exists( $dd_move_file ) ){
												wp_delete_file( $dd_move_file );											
											}
											
											$html5_video_files.='[/*ftp$/]'.$destination_file.PHP_EOL;
											$count_files++;
										}else{										
											if( file_exists( $dd_move_file ) ){
												wp_delete_file( $dd_move_file );											
											}
										}
									}
								}
								
							}else{		
																			
								foreach($video_list_files as $ex){
									$file_name = 'vidorev-submit-video-file'.$ex;
									if(isset($_FILES[$file_name]) && isset($_FILES[$file_name]['error']) && $_FILES[$file_name]['error'] == 0){
										
										if($user_submit_id > 0){
											$new_dir = '/'.date('Y-m-d').'/'.$user_submit_id.'-'.$current_user->user_login.'/';
										}else{
											$new_dir = '/'.date('Y-m-d').'/'.$user_submit_id.'-anonymous/'.rand().'/';
										}
										
										vidorev_ftp_mksubdirs($conn_id, '', $new_dir);
										
										$path_parts 		= pathinfo($_FILES[$file_name]['name']);
										$extension 			= $path_parts['extension'];
										$destination_file 	= $new_dir.time().'.'.$extension;
										
										$source_file		= $_FILES[$file_name]['tmp_name'];
										
										$upload 			= ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);
										
										if ($upload) {
											$html5_video_files.='[/*ftp$/]'.$destination_file.PHP_EOL;
											$count_files++;
										}else{										
											/*$error = array(
												'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
												'status' 			=> 'validation_failed',
												'message' 			=> esc_html__($source_file, 'vidorev-extensions'),
											);
											wp_send_json($error);
											return;*/
										}
	
									}
								}
								
							}
														
							ftp_close($conn_id);
							
							break;
							
						case 'google_drive':
							$iz_upload = 0;
							$gda_upload_file 	= array();							
							foreach($video_list_files as $ex){
								$file_name 			= 'vidorev-submit-video-file'.$ex;								
								if(isset($_FILES[$file_name]) && isset($_FILES[$file_name]['error']) && $_FILES[$file_name]['error'] == 0){
									
									$path_parts 		= pathinfo($_FILES[$file_name]['name']);
									$extension 			= $path_parts['extension'];
									if($user_submit_id > 0){
										$new_file_name 	= $user_submit_id.'-'.$current_user->user_login.'-'.time().'.'.$extension;	
									}else{
										$new_file_name 	= $user_submit_id.'-anonymous-'.rand().'-'.time().'.'.$extension;	
									}
									$source_file		= $_FILES[$file_name]['tmp_name'];
									
									$finfo 				= finfo_open(FILEINFO_MIME_TYPE);
									$mime 				= finfo_file($finfo, $source_file);
									
									$upload_dir 		= wp_upload_dir();
									
									if ( ! file_exists( $upload_dir.'/vidorev-ext' ) ) {
										wp_mkdir_p( $upload_dir.'/vidorev-ext' );
									}
									
									$dir_new_source		= $upload_dir.'/vidorev-ext/'.$new_file_name;
									
									move_uploaded_file($source_file, $dir_new_source);
									
									if (!file_exists($dir_new_source)) {
										$fh = fopen($dir_new_source, 'w');
										fseek($fh, 1024*1024*20);
										fwrite($fh, "!", 1);
										fclose($fh);
									}
									
									$gda_upload_file[$iz_upload] = new Google_Service_Drive_DriveFile();
									$gda_upload_file[$iz_upload]->setName($vidorev_submit_video_title);
									$gda_upload_file[$iz_upload]->setDescription($newPostID);
									
									$chunkSizeBytes = 1 * 1024 * 1024;
									
									$gda_client->setDefer(true);
									
									try{									
										
										$gda_createdFile = $gda_service->files->create($gda_upload_file[$iz_upload]);
										
										$gda_media = new Google_Http_MediaFileUpload(
											$gda_client,
											$gda_createdFile,
											$mime,
											null,
											true,
											$chunkSizeBytes
										);
										
										$gda_media->setFileSize(filesize($dir_new_source));
										
										$gda_status = false;
										$gda_handle = fopen($dir_new_source, "rb");
										while (!$gda_status && !feof($gda_handle)) {										
											$gda_chunk 	= vidorev_readVideoChunk($gda_handle, $chunkSizeBytes);
											$gda_status = $gda_media->nextChunk($gda_chunk);
										}
										
										$gda_result = false;
										if ($gda_status != false) {
											$gda_result = $gda_status;
										}
										
										fclose($gda_handle);
										
										wp_delete_file($dir_new_source);
										
									}catch (Exception $e) {
										wp_delete_file($dir_new_source);
										$error = array(
											'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
											'status' 			=> 'validation_failed',
											'message' 			=> esc_html($e->getMessage()),
										);
										wp_send_json($error);
										return;
									}
									
									wp_delete_file($dir_new_source);									
									$gda_client->setDefer(false);									
									
									if(isset($gda_result) && $gda_result!=false && isset($gda_result->{'id'})){
										$gda_fileId = $gda_result->{'id'};
										
										$storage_gd_domain = trim(vidorev_get_option('storage_gd_domain', 'user_submit_settings', ''));
										
										if($storage_gd_domain!=''){
											$gda_permission = new Google_Service_Drive_Permission(array(
												'type' 		=> 'domain',
												'role' 		=> 'reader',
												'domain' 	=> $storage_gd_domain,
											));
										}else{
											$gda_permission = new Google_Service_Drive_Permission(array(
												'type' 		=> 'anyone',
												'role' 		=> 'reader',
											));
										}
										
										try{
											$gda_service->permissions->create($gda_fileId, $gda_permission, array('fields' => 'id'));
										}catch (Exception $e) {
											$error = array(
												'into' 				=> '#'.$posted_data['_wpcf7_unit_tag'],
												'status' 			=> 'validation_failed',
												'message' 			=> esc_html($e->getMessage()),
											);
											wp_send_json($error);
											return;
										}
									}									
									
									if (isset($gda_fileId)) {
										$html5_video_files.='https://drive.google.com/file/d/'.$gda_fileId.'/view
										';
										$count_files++;
									}else{										
									
									}									
								
								}
								$iz_upload++;
							}
								
							break;
					}
					
					if($html5_video_files!=''){
						if($storage=='as_ftp'){
							$storage_ftp_domain			= trim(vidorev_get_option('storage_ftp_domain', 'user_submit_settings', ''));
							$storage_ftp_sub_domain		= trim(vidorev_get_option('storage_ftp_sub_domain', 'user_submit_settings', ''));
							$storage_ftp_protocol		= trim(vidorev_get_option('storage_ftp_protocol', 'user_submit_settings', ''));
							if($storage_ftp_domain!=''){
								if($storage_ftp_sub_domain!=''){
									$replace_ftp = $storage_ftp_protocol.$storage_ftp_sub_domain.'.'.$storage_ftp_domain;
								}else{
									$replace_ftp = $storage_ftp_protocol.$storage_ftp_domain;
								}
								$html5_video_files=str_replace('[/*ftp$/]', $replace_ftp, $html5_video_files);
							}
						}						
						update_post_meta($newPostID, 'vm_video_url', $html5_video_files);
						if($count_files==1 && ($storage == 'self_hosted' || $storage == 'as_ftp')){
							update_post_meta($newPostID, 'video_player_library', 'fluidplayer');
						}
					}
				
				}else{
					update_post_meta($newPostID, 'vm_video_url', $vidorev_submit_video_url);					
					$new_post = array(
						'ID' => $newPostID,
					);								
					wp_update_post( $new_post );
				}
				
				$submit_list = array();
				$submit_list['post_title'] 		= $postData['post_title'];	
				$submit_list['post_status'] 	= 'pending';
				$submit_list['post_type'] 		= 'video_user_submit';
				
				$submitID = wp_insert_post($submit_list);
				if(!is_wp_error($submitID) && $submitID){
					update_post_meta($submitID, 'first_name', $vidorev_submit_first_name);
					update_post_meta($submitID, 'last_name', $vidorev_submit_last_name);
					update_post_meta($submitID, 'email', $vidorev_submit_user_email);
					update_post_meta($submitID, 'user_id', $user_submit_id);
					update_post_meta($submitID, 'video_id', $newPostID);
					
					update_post_meta($newPostID, 'vidorev_submit_id', $submitID);
				}
				
				do_action('beeteam368_submit_post_after_custom_data_FE', $newPostID);
				
			}
		}
		
		return $posted_data;	
	}
}

add_filter( 'wpcf7_posted_data', 'vidorev_cf7_save_posted_data' );

if(!function_exists('vidorev_video_user_submit_column_ID')){
	function vidorev_video_user_submit_column_ID( $columns ) {
		$date = $columns['date'];
		unset($columns['date']);
		$columns['first_name'] = esc_html__('First Name', 'vidorev-extensions');
		$columns['last_name'] = esc_html__('Last Name', 'vidorev-extensions');
		$columns['email'] = esc_html__('Email', 'vidorev-extensions');
		$columns['edit_view_data'] = esc_html__('Check Post', 'vidorev-extensions');
		$columns['user_submit'] = esc_html__('User Submit', 'vidorev-extensions');
		$columns['date'] = $date;
		return $columns;
	}
}
add_filter('manage_edit-video_user_submit_columns', 'vidorev_video_user_submit_column_ID');
add_filter('manage_edit-playlist_user_submit_columns', 'vidorev_video_user_submit_column_ID');
add_filter('manage_edit-channel_user_submit_columns', 'vidorev_video_user_submit_column_ID');

if(!function_exists('vidorev_video_user_submit_column_ID_value')){
	function vidorev_video_user_submit_column_ID_value( $colname, $cptid ) {
		
		$post_type  = get_post_type($cptid);		
		$post_id	= $cptid;
		switch($post_type){
			case 'video_user_submit':
				$post_id = get_post_meta($cptid, 'video_id', true);
				break;
				
			case 'playlist_user_submit':
				$post_id = get_post_meta($cptid, 'u_playlist_id', true);
				break;
				
			case 'channel_user_submit':
				$post_id = get_post_meta($cptid, 'u_channel_id', true);
				break;		
		}
		
		if ( $colname == 'first_name' ){
			echo get_post_meta($cptid, 'first_name', true);
		
		}elseif($colname == 'last_name' ){
			echo get_post_meta($cptid, 'last_name', true);
			
		}elseif($colname == 'email' ){
			echo get_post_meta($cptid, 'email', true);
			
		}elseif($colname == 'edit_view_data' ){
			
			$post_status = get_post_status( $post_id );
			if($post_status == 'publish'){
				$html_status = '<span class="small-publish-status">'.esc_html__('PUBLISH', 'vidorev-extensions').'</span>';
			}else{
				$html_status = '<span class="big-publish-status">'.esc_html__('PENDING', 'vidorev-extensions').'</span>';
			}
			
			echo 	wp_kses(
						__('Status: '.$html_status.' | <a href="'.esc_url(get_edit_post_link($post_id)).'" target="_blank">'.esc_html__('Edit Post', 'vidorev-extensions').'</a> | <a href="'.esc_url(get_permalink($post_id)).'" target="_blank">'.esc_html__('View Post', 'vidorev-extensions').'</a>', 'vidorev-extensions'
						),
						array(
							'a'=>array('href' => array(), 'target' => array()),
							'span'=>array('class' => array()),
						)
					);
			
		}elseif($colname == 'user_submit'){
			
			$user_obj = get_user_by('id', get_post_meta($cptid, 'user_id', true));
			if($user_obj){
			
				echo 	wp_kses(
							__('User Name: <strong>'.$user_obj->user_login.'</strong> | <a href="'.esc_url(get_edit_user_link($user_obj->ID)).'" target="_blank">'.esc_html__('View User', 'vidorev-extensions').'</a>', 'vidorev-extensions'
							),
							array(
								'a'=>array('href' => array(), 'target' => array()),
								'strong'=>array(),
							)
						);
			}else{
				
				echo esc_html__('Unknown', 'vidorev-extensions');
				
			}
			
		}
	}
}
add_action('manage_video_user_submit_posts_custom_column', 'vidorev_video_user_submit_column_ID_value', 10, 2);
add_action('manage_playlist_user_submit_posts_custom_column', 'vidorev_video_user_submit_column_ID_value', 10, 2);
add_action('manage_channel_user_submit_posts_custom_column', 'vidorev_video_user_submit_column_ID_value', 10, 2);

if(!function_exists('vidorev_get_pending_items')){
	function vidorev_get_pending_items( $post_type ) {
		global $wpdb;
		/*fake prepare*/
		$pending_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type IN( 'video_user_submit', 'playlist_user_submit', 'channel_user_submit' %s ) AND post_status = 'pending'", $post_type ) );
		/*fake prepare*/
		return (int) $pending_count;
	}
}

if(!function_exists('vidorev_notification_bubble_in_submit_menu')){
	function vidorev_notification_bubble_in_submit_menu() {
		global $menu;
		$pending_items = vidorev_get_pending_items( ''/*fake prepare*/ );
		
		foreach ( $menu as $key => $value ){
			if ( $menu[$key][2] == 'edit.php?post_type=video_user_submit' ){
				$menu[$key][0] .= $pending_items ? " <span class='update-plugins count-1' title='title'><span class='update-count'>$pending_items</span></span>" : '';
				return;
			}
		}
	}
}
add_action('admin_menu', 'vidorev_notification_bubble_in_submit_menu');

if ( !class_exists('vidorev_user_submit_settings' ) ):
	class vidorev_user_submit_settings {
	
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
			add_submenu_page('edit.php?post_type=video_user_submit', esc_html__( 'User Submit Settings', 'vidorev-extensions'), esc_html__( 'User Submit Settings', 'vidorev-extensions'), 'manage_options', 'vid_user_submit_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'user_submit_settings',
					'title' => esc_html__('User Submit Settings', 'vidorev-extensions')
				),
				array(
					'id' 	=> 'user_ads_settings',
					'title' => esc_html__('User Ads Settings', 'vidorev-extensions')
				),						          
			);
			
			return $sections;
		}

		function get_settings_fields() {
			
			global $wp_roles;
			$all_roles = implode(', ', array_keys($wp_roles->role_names));
						
			$settings_fields = array(
				'user_submit_settings' => array(
					array(
						'name'      	=> 'posting_without_login',			
						'label'   		=> esc_html__( 'Posting Without Login', 'vidorev-extensions'),
						'desc'    		=> esc_html__( 'When you enable this feature. Some features will not work: [Video] Roles, [Playlist] Roles, [Channel] Roles. We do not recommend activating this mode. You may have trouble managing the website\'s data.', 'vidorev-extensions'),
						'type'      	=> 'select',
						'default'		=> 'no',	
						'options'       => array(
							'no' 		=> esc_html__('Disable', 'vidorev-extensions'),
							'yes' 		=> esc_html__('Enable', 'vidorev-extensions'),
						),			
					),
					array(
						'name'    => 'ex_category',
						'label'   => esc_html__( 'Exclude Categories', 'vidorev-extensions'),
						'desc'    => esc_html__( 'You can restrict users to add posts to the categories listed above. Enter category id or slug, eg: 245, 126, ...', 'vidorev-extensions'),
						'type'    => 'text',
						'default' => '',						
					),
					array(
						'name'      	=> 'post_status',			
						'label'   		=> esc_html__( 'Post Status', 'vidorev-extensions'),
						'type'      	=> 'select',
						'default'		=> 'pending',	
						'options'       => array(
							'pending' 	=> esc_html__('Pending', 'vidorev-extensions'),
							'publish' 	=> esc_html__('Published', 'vidorev-extensions'),
							'draft' 	=> esc_html__('Draft', 'vidorev-extensions'),							
							'private' 	=> esc_html__('Private', 'vidorev-extensions'),												
						),			
					),
					array(
						'name'    => 'ex_channel',
						'label'   => esc_html__( 'Add to Channel', 'vidorev-extensions'),
						'desc'    => esc_html__( 'You can restrict users to add posts to the channels.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'all',
						'options' => array(
							'all'					=> esc_html__('Display All', 'vidorev-extensions'),
							'current_user'			=> esc_html__('Display channels create by current user/author login', 'vidorev-extensions'),							
						)
					),
					array(
						'name'    => 'ex_playlist',
						'label'   => esc_html__( 'Add to Playlist', 'vidorev-extensions'),
						'desc'    => esc_html__( 'You can restrict users to add posts to the playlists.', 'vidorev-extensions'),
						'type'    => 'select',
						'default' => 'all',
						'options' => array(
							'all'					=> esc_html__('Display All', 'vidorev-extensions'),
							'current_user'			=> esc_html__('Display playlists create by current user/author login', 'vidorev-extensions'),						
						)
					), 
					array(
						'name'    => 'roles',
						'label'   => esc_html__( '[Video] Roles', 'vidorev-extensions'),
						'desc'    => esc_html__( 'Permissions can upload videos. Separated by commas. Ex: '.$all_roles, 'vidorev-extensions'),
						'type'    => 'text',
						'default' => $all_roles,
					),
						array(
							'name'    => 'show_tab_submit_video',
							'label'   => esc_html__( 'Submit Video Tab', 'vidorev-extensions'),
							'type'    => 'select',
							'default' => 'show',
							'options' => array(
								'show'			=> esc_html__('SHOW', 'vidorev-extensions'),
								'hide'			=> esc_html__('HIDE', 'vidorev-extensions'),
								'role'			=> esc_html__('Depends on the role', 'vidorev-extensions'),						
							)
						), 
					array(
						'name'    => 'playlist_roles',
						'label'   => esc_html__( '[Playlist] Roles', 'vidorev-customize'),
						'desc'    => esc_html__( 'Permissions can upload playlists. Separated by commas. Ex: '.$all_roles, 'vidorev-customize'),
						'type'    => 'text',
						'default' => $all_roles,
					),
						array(
							'name'    => 'show_tab_submit_playlist',
							'label'   => esc_html__( 'Submit Playlist Tab', 'vidorev-extensions'),
							'type'    => 'select',
							'default' => 'show',
							'options' => array(
								'show'			=> esc_html__('SHOW', 'vidorev-extensions'),
								'hide'			=> esc_html__('HIDE', 'vidorev-extensions'),
								'role'			=> esc_html__('Depends on the role', 'vidorev-extensions'),						
							)
						), 
					array(
						'name'    => 'channel_roles',
						'label'   => esc_html__( '[Channel] Roles', 'vidorev-customize'),
						'desc'    => esc_html__( 'Permissions can upload channels. Separated by commas. Ex: '.$all_roles, 'vidorev-customize'),
						'type'    => 'text',
						'default' => $all_roles,
					),
						array(
							'name'    => 'show_tab_submit_channel',
							'label'   => esc_html__( 'Submit Channel Tab', 'vidorev-extensions'),
							'type'    => 'select',
							'default' => 'show',
							'options' => array(
								'show'			=> esc_html__('SHOW', 'vidorev-extensions'),
								'hide'			=> esc_html__('HIDE', 'vidorev-extensions'),
								'role'			=> esc_html__('Depends on the role', 'vidorev-extensions'),						
							)
						), 
					array(
						'name'      	=> 'auto_fetch_nt',			
						'label'   		=> esc_html__( 'Auto Fetch Data', 'vidorev-extensions'),
						'type'      	=> 'select',
						'desc'    		=> esc_html__( 'Only for video networks: Youtube, Vimeo, Dailymotion, Twitch', 'vidorev-extensions'),
						'default'		=> 'on',	
						'options'       => array(
							'on' 		=> esc_html__('Enable', 'vidorev-extensions'),
							'off' 		=> esc_html__('Disable', 'vidorev-extensions'),											
						),			
					), 
					
					array(
						'name'      	=> 'storage',			
						'label'   		=> esc_html__( 'Storage', 'vidorev-extensions'),
						'type'      	=> 'select',
						'default'		=> 'self_hosted',	
						'options'       => array(
							'self_hosted' 		=> esc_html__('Self-Hosted', 'vidorev-extensions'),
							'as_ftp' 			=> esc_html__('On Another Server (via FTP)', 'vidorev-extensions'),		
							'google_drive' 		=> esc_html__('Google Drive', 'vidorev-extensions'),											
						),			
					), 
					
						array(
							'name'    => 'storage_ftp_server_ip',
							'label'   => esc_html__( '[Storage - FTP] Server IP', 'vidorev-extensions'),
							'desc'    => esc_html__( 'Ex: 127.0.0.1', 'vidorev-extensions'),
							'type'    => 'text',
						), 
						array(
							'name'    => 'storage_ftp_server_port',
							'label'   => esc_html__( '[Storage - FTP] Server Port', 'vidorev-extensions'),
							'desc'    => esc_html__( 'Ex: 21, 22..', 'vidorev-extensions'),
							'type'    => 'text',
						), 
						array(
							'name'    => 'storage_ftp_username',
							'label'   => esc_html__( '[Storage - FTP] Username', 'vidorev-extensions'),
							'type'    => 'text',
						),  
						array(
							'name'    => 'storage_ftp_password',
							'label'   => esc_html__( '[Storage - FTP] Password', 'vidorev-extensions'),
							'type'    => 'password',
						),						
						array(
							'name'    => 'storage_ftp_domain',
							'label'   => esc_html__( '[Storage - FTP] Domain Name', 'vidorev-extensions'),
							'desc'    => esc_html__( 'Eg: beeteam368.com, envato.com, beeteam368.com/your-folder, ...', 'vidorev-extensions'),
							'type'    => 'text',
						), 
						array(
							'name'    => 'storage_ftp_sub_domain',
							'label'   => esc_html__( '[Storage - FTP] Subdomain (Zone Name)', 'vidorev-extensions'),
							'desc'    => esc_html__( 'Eg: beeteam368, admin...', 'vidorev-extensions'),
							'type'    => 'text',
						), 
						array(
							'name'      	=> 'storage_ftp_protocol',			
							'label'   		=> esc_html__( '[Storage - FTP] Protocol', 'vidorev-extensions'),
							'type'      	=> 'select',
							'default'		=> 'http://',	
							'options'       => array(
								'http://' 			=> esc_html__('http://', 'vidorev-extensions'),
								'https://' 			=> esc_html__('https://', 'vidorev-extensions'),
							),			
						),
						
						array(
							'name'      	=> 'storage_gd_service_account',			
							'label'   		=> esc_html__( '[Storage - Google Drive] Service Account Key', 'vidorev-extensions'),
							'type'      	=> 'file',
							'desc'    		=> esc_html__( 'Upload your JSON file for Authentication', 'vidorev-extensions'),								
						),
						
						/*array(
							'name'      	=> 'storage_gd_domain',			
							'label'   		=> esc_html__( '[Storage - Google Drive] Domain', 'vidorev-extensions'),
							'type'      	=> 'text',
							'desc'    => esc_html__( 'Enter your domain name to secure the video. Eg: beeteam368.com, demo.beeteam368.com ...', 'vidorev-extensions'),
							
						),*/						  
					
					array(
						'name'    => 'limit_ft_upload',
						'label'   => esc_html__( 'FREE - [Featured Image] Limit the max file size acceptable', 'vidorev-extensions'),
						'desc'    => esc_html__( 'You can use kb (kilo byte) or mb (mega byte) suffix optionally. Default: 2mb', 'vidorev-extensions'),
						'type'    => 'text',
						'default' => '2mb',
					),   
					
					array(
						'name'    => 'limit_vid_upload',
						'label'   => esc_html__( 'FREE - [Video] Limit the max file size acceptable', 'vidorev-extensions'),
						'desc'    => esc_html__( 'You can use kb (kilo byte) or mb (mega byte) suffix optionally. Default: 10mb', 'vidorev-extensions'),
						'type'    => 'text',
						'default' => '10mb',
					),                
				),				    
			);
			
			$ads_level_options = array(
				'free' 		=> esc_html__('FREE - Everyone Can Use', 'vidorev-extensions'),	
			);
			
			if ( defined( 'PMPRO_VERSION' ) ) {
				global $wpdb;
				$sqlQuery 	= "SELECT * FROM $wpdb->pmpro_membership_levels WHERE 1 = 1 ORDER BY id ASC";
				$levels 	= $wpdb->get_results($sqlQuery, OBJECT);
				foreach($levels as $level){
					$settings_fields['user_submit_settings'][] = array(
						'name'    => 'limit_vid_upload_membership_'.$level->id,
						'label'   => $level->name.esc_html__( ' - Membership - [Video] Limit the max file size acceptable', 'vidorev-extensions'),
						'desc'    => esc_html__( 'You can use kb (kilo byte) or mb (mega byte) suffix optionally. Default: _blank = disable - You can create upload packages from the Paid Membership Pro plugin.', 'vidorev-extensions'),
						'type'    => 'text',
					);
						
					$ads_level_options['limit_user_ads_membership_'.$level->id] = $level->name.esc_html__( ' - Membership', 'vidorev-extensions');				
				}
			}
			
			$settings_fields['user_ads_settings'] = array(
				array(
					'name'      	=> 'ads_enable',			
					'label'   		=> esc_html__( 'Enable ads for members', 'vidorev-extensions'),
					'type'      	=> 'select',
					'default'		=> 'on',					
					'options'       => array(
						'on' 		=> esc_html__('Turn ON', 'vidorev-extensions'),
						'off' 		=> esc_html__('Turn OFF', 'vidorev-extensions'),	
					),			
				),
				array(
					'name'      	=> 'google_ima',			
					'label'   		=> esc_html__( 'Google IMA', 'vidorev-extensions'),
					'type'      	=> 'multicheck',
					'default'		=> array( 'free' => 'free' ),
					'desc'    		=> esc_html__( 'Interactive Media Ads', 'vidorev-extensions'),	
					'options'       => $ads_level_options,			
				),
				array(
					'name'      	=> 'image',			
					'label'   		=> esc_html__( 'Image', 'vidorev-extensions'),
					'type'      	=> 'multicheck',
					'default'		=> array( 'free' => 'free' ),
					'options'       => $ads_level_options,				
				),
				array(
					'name'      	=> 'html5_video',			
					'label'   		=> esc_html__( 'HTML5 Video', 'vidorev-extensions'),
					'type'      	=> 'multicheck',
					'default'		=> array( 'free' => 'free' ),
					'options'       => $ads_level_options,				
				),
				array(
					'name'      	=> 'google_adsense',			
					'label'   		=> esc_html__( 'Google Adsense', 'vidorev-extensions'),
					'type'      	=> 'multicheck',
					'default'		=> array( 'free' => 'free' ),
					'options'       => $ads_level_options,				
				),
				array(
					'name'      	=> 'vast',			
					'label'   		=> esc_html__( 'VAST', 'vidorev-extensions'),
					'type'      	=> 'multicheck',
					'default'		=> array( 'free' => 'free' ),
					'desc'   		=> esc_html__( 'Only work with Self-hosted video (*.mp4, *.m3u8, *.webm)', 'vidorev-extensions'),	
					'options'       => $ads_level_options,				
				), 
			);
	
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
new vidorev_user_submit_settings();

if(!function_exists('beeteam368_cf7_submit_full')){
	function beeteam368_cf7_submit_full(){
		$page_id = get_the_ID();
		
		$submit_video_page = vidorev_get_redux_option('submit_video_page', '');
		$vidorev_detech_lang_submit_page = vidorev_detech_lang_submit_page($page_id);
		
		if($submit_video_page == $page_id || $vidorev_detech_lang_submit_page[0]){
			global $wp;
			$current_url = home_url( $wp->request );
			
			$ac_tab_video 		= '';
			$ac_tab_playlist 	= 'black-style';
			$ac_tab_channel 	= 'black-style';
			$ac_tab_ads			= 'black-style';
			
			$submit_video_shortcode		= vidorev_get_redux_option('submit_video_shortcode', '');
			$submit_channel_shortcode	= vidorev_get_redux_option('submit_channel_shortcode', '');
			$submit_playlist_shortcode	= vidorev_get_redux_option('submit_playlist_shortcode', '');
			
			if($page_id == $vidorev_detech_lang_submit_page[2]){
				$submit_video_shortcode = (isset($vidorev_detech_lang_submit_page[1][0])&&trim($vidorev_detech_lang_submit_page[1][0])!='')?$vidorev_detech_lang_submit_page[1][0]:$submit_video_shortcode;
				$submit_channel_shortcode = (isset($vidorev_detech_lang_submit_page[1][1])&&trim($vidorev_detech_lang_submit_page[1][1])!='')?$vidorev_detech_lang_submit_page[1][1]:$submit_channel_shortcode;
				$submit_playlist_shortcode = (isset($vidorev_detech_lang_submit_page[1][2])&&trim($vidorev_detech_lang_submit_page[1][2])!='')?$vidorev_detech_lang_submit_page[1][2]:$submit_playlist_shortcode;
			}
			
			$submit_tab = '';
			
			if(isset($_GET['submit_tab'])){
				$submit_tab = trim($_GET['submit_tab']);				
			}
			
			switch($submit_tab){
				case 'video':
					$ac_tab_video 		= '';
					$ac_tab_playlist 	= 'black-style';
					$ac_tab_channel 	= 'black-style';
					$ac_tab_ads			= 'black-style';
					break;
					
				case 'channel':
					$ac_tab_video 		= 'black-style';
					$ac_tab_playlist 	= 'black-style';
					$ac_tab_channel 	= '';
					$ac_tab_ads			= 'black-style';
					break;
					
				case 'playlist':
					$ac_tab_video 		= 'black-style';
					$ac_tab_playlist 	= '';
					$ac_tab_channel 	= 'black-style';
					$ac_tab_ads			= 'black-style';
					break;
				case 'ads_settings':
					$ac_tab_video 		= 'black-style';
					$ac_tab_playlist 	= 'black-style';
					$ac_tab_channel 	= 'black-style';
					$ac_tab_ads			= '';
					break;			
				default:
					$ac_tab_video 		= '';
					$ac_tab_playlist 	= 'black-style';
					$ac_tab_channel 	= 'black-style';
					$ac_tab_ads			= 'black-style';
			}
			
			$video_role 	= true;
			$playlist_role 	= true;
			$channel_role 	= true;
			$ads_role 		= true;
				
			$user_submit_id = 0;
			if(is_user_logged_in()){
				$current_user = wp_get_current_user();					
				$user_submit_id = $current_user->ID;					
			}
			
			if( $user_submit_id == 0 ){
				$user_roles	= array();
			}else{
				$user_meta	= get_userdata($user_submit_id);
				$user_roles	= $user_meta->roles;
			}
			
			/*check permision*/	
			global $wp_roles;
			$all_roles = implode(', ', array_keys($wp_roles->role_names));
			
				/*video role*/				
				$show_tab_submit_video = trim(vidorev_get_option('show_tab_submit_video', 'user_submit_settings', 'show'));
				
				switch($show_tab_submit_video){
					case 'hide':
						$video_role = false;
						break;
						
					case 'role':
						$roles 		= explode(',', trim(vidorev_get_option('roles', 'user_submit_settings', $all_roles)));
						$roles_op 	= array();
						
						foreach($roles as $role){
							$role = trim($role);
							if($role!=''){
								$roles_op[] = $role;
							}
						}
						
						$permisions = array();
						$permisions = array_intersect($user_roles, $roles_op);
						
						if(count($permisions) == 0 ){
							$video_role = false;
						}
						break;	
				}
				/*video role*/
		
				/*playlist role*/				
				$show_tab_submit_playlist = trim(vidorev_get_option('show_tab_submit_playlist', 'user_submit_settings', 'show'));
				
				switch($show_tab_submit_playlist){
					case 'hide':
						$playlist_role = false;
						break;
						
					case 'role':
						$roles 	= explode(',', trim(vidorev_get_option('playlist_roles', 'user_submit_settings', $all_roles)));				
						$roles_op 	= array();
						
						foreach($roles as $role){
							$role = trim($role);
							if($role!=''){
								$roles_op[] = $role;
							}
						}
						
						$permisions = array();
						$permisions = array_intersect($user_roles, $roles_op);
						
						if(count($permisions) == 0 ){
							$playlist_role 	= false;
						}
						break;	
				}				
				/*playlist role*/
		
				/*channel role*/				
				$show_tab_submit_channel = trim(vidorev_get_option('show_tab_submit_channel', 'user_submit_settings', 'show'));
				
				switch($show_tab_submit_channel){
					case 'hide':
						$channel_role = false;
						break;
						
					case 'role':
						$roles 	= explode(',', trim(vidorev_get_option('channel_roles', 'user_submit_settings', $all_roles)));				
						$roles_op 	= array();
						
						foreach($roles as $role){
							$role = trim($role);
							if($role!=''){
								$roles_op[] = $role;
							}
						}
						
						$permisions = array();
						$permisions = array_intersect($user_roles, $roles_op);
						
						if(count($permisions) == 0 ){
							$channel_role 	= false;
						}
						break;	
				}
				
				/*channel role*/
				
			/*check permision*/
			
			
			/*Ads Role*/
			$roles = trim(vidorev_get_option('ads_enable', 'user_ads_settings', 'on'));
			if($roles == 'on'){
				$ads_role = true;
			}else{
				$ads_role = false;
			}/*Ads Role*/
			
			if(!$video_role && !$playlist_role && !$channel_role && !$ads_role){
				return '';
			}
		?>
			<div class="form-front-end-submit">
				<div class="listing-types">
					<div class="listing-types-content">
                    	<?php if($video_role){?>                	
                            <a href="<?php echo esc_url($current_url);?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_video);?>">
                                <i class="fa fa-play-circle" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Video', 'vidorev-extensions');?>
                            </a>
                        <?php }?>
                        
                        <?php if($playlist_role){?>
                            <a href="<?php echo esc_url(add_query_arg(array('submit_tab' => 'playlist'), $current_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_playlist);?>">
                                <i class="fa fa-bars" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Playlist', 'vidorev-extensions');?>
                            </a>
                        <?php }?> 
                        
                        <?php if($channel_role){?>
                            <a href="<?php echo esc_url(add_query_arg(array('submit_tab' => 'channel'), $current_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_channel);?>">
                                <i class="fa fa-film" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Channel', 'vidorev-extensions');?>
                            </a>
                        <?php }?>
                        
                        <?php if($ads_role){?>
                            <a href="<?php echo esc_url(add_query_arg(array('submit_tab' => 'ads_settings'), $current_url));?>" class="basic-button basic-button-default<?php echo ' '.esc_attr($ac_tab_ads);?>">
                                <i class="fa fa-film" aria-hidden="true"></i>&nbsp;&nbsp;<?php esc_html_e('Ads Settings', 'vidorev-extensions');?>
                            </a>
                        <?php }?>						
					</div>
				</div>
				
				<div class="form-submit">
                	<?php
                    if ( defined( 'PMPRO_VERSION' ) ) {
						global $wpdb;
						$sqlQuery 	= "SELECT * FROM $wpdb->pmpro_membership_levels WHERE 1 = 1 ORDER BY id ASC";
						$levels 	= $wpdb->get_results($sqlQuery, OBJECT);
						
						$levels_html = array();
						
						if(is_user_logged_in()){
							$current_user = wp_get_current_user();
							if ( isset($current_user->membership_level) && isset($current_user->membership_level->ID) && is_numeric($current_user->membership_level->ID)) {
								$current_user_level = $current_user->membership_level->ID;
							}								
						}
						
						foreach($levels as $level){
							$level_size = trim(vidorev_get_option('limit_vid_upload_membership_'.$level->id, 'user_submit_settings', ''));
							if($level_size!=''){
								array_push($levels_html, '<li><strong>'.$level->name.': '.$level_size.'</strong></li>');
								if(isset($current_user_level) && $current_user_level == $level->id){
									$current_user_level_info = array($level->name, $level_size);
								}
							}
						}
											
						$register_url = wp_registration_url();
						if(function_exists('pmpro_getOption')){
							$levels_page_id = pmpro_getOption("levels_page_id");
							if(is_numeric($levels_page_id)){
								$register_url = get_permalink($levels_page_id);
							}
						}
					}
					if(isset($levels_html) && count($levels_html)>0 && $ac_tab_ads!=''){
					?>
                        <div class="upload-park">
                            <strong><?php echo esc_html__('The maximum file size limit for uploads varies depending on your LEVEL.', 'vidorev-extensions');?></strong><br><br>
                            <ul>
                            	<?php echo implode('', $levels_html);?>                                
                            </ul><br>
                           	<?php 
							$sr_search 	= array('!!level!!', '!!level_size!!');
							$sr_replace = array('<span class="level-highlight">'.esc_html__('FREE', 'vidorev-extensions').'</span>', '<span class="size-highlight">'.trim(vidorev_get_option('limit_vid_upload', 'user_submit_settings', '10mb')).'</span>');							
						   	$current_level_text = esc_html__(' Your level is: !!level!! - !!level_size!!. Upgrade to a Higher Level Plan', 'vidorev-extensions');
							if(isset($current_user_level_info)){
								$sr_replace = array('<span class="level-highlight">'.$current_user_level_info[0].'</span>', '<span class="size-highlight">'.$current_user_level_info[1].'</span>');
							}
							echo str_replace($sr_search, $sr_replace, $current_level_text);
						   	?>
                           	[ <a href="<?php echo esc_url($register_url);?>" target="_blank"><strong><?php echo esc_html__('REGISTER', 'vidorev-extensions')?></strong></a> ]
                        </div>
					<?php
					}
					switch($submit_tab){
						case 'video':
							if($video_role){
								echo do_shortcode($submit_video_shortcode);
							}
							break;
							
						case 'channel':
							if($channel_role){
								echo do_shortcode($submit_channel_shortcode);
							}
							break;
							
						case 'playlist':
							if($playlist_role){
								echo do_shortcode($submit_playlist_shortcode);
							}
							break;
						case 'ads_settings':
							if($ads_role){
								do_action('beeteam368_user_ads_settings_frontend');
							}
							break;
						default:
							echo do_shortcode($submit_video_shortcode);			
					}
					?>
				</div>
			</div>
		<?php	
		}
	}
}

add_action('vidorev_single_page_custom_listing', 'beeteam368_cf7_submit_full');

if(!function_exists('vidorev_update_user_ads_settings')){
	function vidorev_update_user_ads_settings(){
		$json_params 			= array();
		$json_params['results'] = array('', '');
		
		$ads = isset($_POST['ads'])?$_POST['ads']:'';
		
		$theme_data = wp_get_theme();
		if($ads=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' )){
			$json_params['results'] = array('error', esc_html__('You do not have permission to perform this function.', 'vidorev-extensions'));
			wp_send_json($json_params);
			return;
			die();
		}
		
		$current_user = wp_get_current_user();						
		$user_submit_id = $current_user->ID;
		
		update_user_meta( $user_submit_id, 'beeteam368_user_ads_settings', $ads );		
		
		$json_params['results'] = array('ok', esc_html__('Update Successful!!!', 'vidorev-extensions'));		
				
		wp_send_json($json_params);
		
		return;
		die();
	}
}
add_action('wp_ajax_vidorev_update_user_ads_settings', 'vidorev_update_user_ads_settings');
add_action('wp_ajax_nopriv_vidorev_update_user_ads_settings', 'vidorev_update_user_ads_settings');

if(!function_exists('beeteam368_user_ads_settings_frontend')){
	function beeteam368_user_ads_settings_frontend(){
		$user_submit_id 	= 0;
		$user_membership_id = 0;
		
		$lock_text 		= wp_kses(__('This feature is for !!levels!! members only [ <a href="!!register_url!!" target="_blank"><strong>REGISTER</strong></a> ]', 'vidorev-extensions'), array('a'=>array('href'=>array(), 'target'=>array()), 'strong'=>array()));	
		$sr_search 		= array('!!levels!!', '!!register_url!!');
		$register_url 	= wp_registration_url();
		if(function_exists('pmpro_getOption')){
			$levels_page_id = pmpro_getOption("levels_page_id");
			if(is_numeric($levels_page_id)){
				$register_url = get_permalink($levels_page_id);
			}
		}	
		
		if(is_user_logged_in()){
			
			$current_user = wp_get_current_user();						
			$user_submit_id = $current_user->ID;
			
			if ( defined( 'PMPRO_VERSION' ) && isset($current_user->membership_level) && isset($current_user->membership_level->ID) && is_numeric($current_user->membership_level->ID)) {
				$user_membership_id = $current_user->membership_level->ID;
			}
			
		}
		
		/*delete_user_meta( $user_submit_id, 'beeteam368_user_ads_settings');*/
		
		$ads_google_ima 	= vidorev_get_option('google_ima', 'user_ads_settings', array('free'=>'free'));
		$ads_image 			= vidorev_get_option('image', 'user_ads_settings', array('free'=>'free'));
		$ads_html5_video 	= vidorev_get_option('html5_video', 'user_ads_settings', array('free'=>'free'));
		$ads_google_adsense = vidorev_get_option('google_adsense', 'user_ads_settings', array('free'=>'free'));
		$ads_vast 			= vidorev_get_option('vast', 'user_ads_settings', array('free'=>'free'));
		
		$ads_google_ima_status = 'free';
		if(is_array($ads_google_ima)){
			if(array_search('free', $ads_google_ima) !== FALSE){
				$ads_google_ima_status = 'free';
			}else{
				if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_google_ima) !== FALSE){
					$ads_google_ima_status = 'enable_by_membership';
				}else{
					$ads_google_ima_status = 'disable_by_membership';
				}
			}
		}else{
			$ads_google_ima_status = 'disable';
		}
		
		$ads_image_status = 'free';
		if(is_array($ads_image)){
			if(array_search('free', $ads_image) !== FALSE){
				$ads_image_status = 'free';
			}else{
				if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_image) !== FALSE){
					$ads_image_status = 'enable_by_membership';
				}else{
					$ads_image_status = 'disable_by_membership';
				}
			}
		}else{
			$ads_image_status = 'disable';
		}
		
		$ads_html5_video_status = 'free';
		if(is_array($ads_html5_video)){
			if(array_search('free', $ads_html5_video) !== FALSE){
				$ads_html5_video_status = 'free';
			}else{
				if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_html5_video) !== FALSE){
					$ads_html5_video_status = 'enable_by_membership';
				}else{
					$ads_html5_video_status = 'disable_by_membership';
				}
			}
		}else{
			$ads_html5_video_status = 'disable';
		}
		
		$ads_google_adsense_status = 'free';
		if(is_array($ads_google_adsense)){
			if(array_search('free', $ads_google_adsense) !== FALSE){
				$ads_google_adsense_status = 'free';
			}else{
				if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_google_adsense) !== FALSE){
					$ads_google_adsense_status = 'enable_by_membership';
				}else{
					$ads_google_adsense_status = 'disable_by_membership';
				}
			}
		}else{
			$ads_google_adsense_status = 'disable';
		}
		
		$ads_vast_status = 'free';
		if(is_array($ads_vast)){
			if(array_search('free', $ads_vast) !== FALSE){
				$ads_vast_status = 'free';
			}else{
				if(array_search('limit_user_ads_membership_'.$user_membership_id, $ads_vast) !== FALSE){
					$ads_vast_status = 'enable_by_membership';
				}else{
					$ads_vast_status = 'disable_by_membership';
				}
			}
		}else{
			$ads_vast_status = 'disable';
		}
		
		$all_levels_arr = array();
		if ( defined( 'PMPRO_VERSION' ) ) {
			global $wpdb;		
			$sqlQuery 	= "SELECT * FROM $wpdb->pmpro_membership_levels WHERE 1 = 1 ORDER BY id ASC";
			$levels 	= $wpdb->get_results($sqlQuery, OBJECT);
			
			if($levels){
				foreach($levels as $level){
					$all_levels_arr[] = array(
						'limit_user_ads_membership_'.$level->id => $level->name
					);				
				}
			}
		}
		
		$ads_values = array(
			'vid_ads_m_video_ads' 			=> 'no',
			'vid_ads_m_video_ads_type' 		=> '',
			'vid_ads_m_group_google_ima' 	=> array(
				array(
					'vid_ads_m_ima_source'			=> array(''),
					'vid_ads_m_ima_source_tablet'	=> array(''),
					'vid_ads_m_ima_source_mobile'	=> array(''),
				)
			),
			'vid_ads_m_group_image' 		=> array(
				array(
					'vid_ads_m_image_source'	=> '',
					'vid_ads_m_image_link'		=> '',
					'image_time_show_ad'		=> 0,
					'image_time_skip_ad'		=> 5,
					'image_time_hide_ad'		=> 10,
				)
			),
			'vid_ads_m_group_html5_video' 	=> array(
				array(
					'vid_ads_m_video_source'	=> array('0'=>''),
					'vid_ads_m_video_link'		=> '',
					'video_time_show_ad'		=> 0,
					'video_time_skip_ad'		=> 5,
				)
			),
			'vid_ads_m_group_html' 			=> array(
				array(
					'vid_ads_m_html_source'		=> array(''),
					'adsense_client_id'			=> '',
					'adsense_slot_id'			=> '',
					'adsense_time_show_ad'		=> 0,
					'adsense_time_skip_ad'		=> 5,
					'adsense_time_hide_ad'		=> 10,					
				)
			),
			'vid_ads_m_vast_preroll' 		=> array(
				array(
					'vid_ads_m_vast_tag_pre'		=> '',					
				)
			),
			'vid_ads_m_vast_postroll' 		=> array(
				array(
					'vid_ads_m_vast_tag_post'		=> '',					
				)
			),
			'vid_ads_m_vast_pauseroll' 		=> array(
				array(
					'vid_ads_m_vast_tag_pause'		=> '',					
				)
			),
			'vid_ads_m_vast_midroll' 		=> array(
				array(
					'vid_ads_m_vast_tag_mid'		=> '',
					'vid_ads_m_vast_timer_seconds' 	=> 10,					
				)
			),
			
		);	
			
		$ads_params = get_user_meta( $user_submit_id, 'beeteam368_user_ads_settings', true ); 		
		if(is_array($ads_params)){
			$ads_fn_values = array_merge($ads_values, $ads_params);
		}else{
			$ads_fn_values = $ads_values;
		}
	?>
    	<div class="user-settings-ads">
        	<fieldset class="user-ads-primary">
            	<legend class="h6 extra-bold"><?php echo esc_html__('Primary Advertising', 'vidorev-extensions')?></legend>
                <div class="frontend-ads-settings-row">                    
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="radio" value="disable" name="ads_types" id="ads_types_disable" <?php if($ads_fn_values['vid_ads_m_video_ads']=='no'){ echo 'checked'; }?>>
                            <label for="ads_types_disable">
								<?php echo esc_html__('Disable', 'vidorev-extensions');?>
                            </label><br>
                            
                        	<input type="radio" value="google_ima" name="ads_types" id="ads_types_google_ima" <?php if($ads_fn_values['vid_ads_m_video_ads_type']=='google_ima'){ echo 'checked'; }?>>
                            <label for="ads_types_google_ima">
								<?php echo esc_html__('Google IMA', 'vidorev-extensions'); if($ads_google_ima_status == 'disable' || $ads_google_ima_status == 'disable_by_membership'){echo ' <span class="dis-notice">- '.esc_html__('disabled', 'vidorev-extensions').'</span>';}?>
                            </label><br>
                            
                            <input type="radio" value="image" name="ads_types" id="ads_types_image" <?php if($ads_fn_values['vid_ads_m_video_ads_type']=='image'){ echo 'checked'; }?>>
                            <label for="ads_types_image">
								<?php echo esc_html__('Image', 'vidorev-extensions'); if($ads_image_status == 'disable' || $ads_image_status == 'disable_by_membership'){echo ' <span class="dis-notice">- '.esc_html__('disabled', 'vidorev-extensions').'</span>';}?>
                            </label><br>
                            
                            <input type="radio" value="html5_video" name="ads_types" id="ads_types_html5_video" <?php if($ads_fn_values['vid_ads_m_video_ads_type']=='html5_video'){ echo 'checked'; }?>>
                            <label for="ads_types_html5_video">
								<?php echo esc_html__('HTML5 Video', 'vidorev-extensions'); if($ads_html5_video_status == 'disable' || $ads_html5_video_status == 'disable_by_membership'){echo ' <span class="dis-notice">- '.esc_html__('disabled', 'vidorev-extensions').'</span>';}?>
                            </label><br>
                            
                            <input type="radio" value="google_adsense" name="ads_types" id="ads_types_google_adsense" <?php if($ads_fn_values['vid_ads_m_video_ads_type']=='html'){ echo 'checked'; }?>>
                            <label for="ads_types_google_adsense">
								<?php echo esc_html__('Google Adsense', 'vidorev-extensions'); if($ads_google_adsense_status == 'disable' || $ads_google_adsense_status == 'disable_by_membership'){echo ' <span class="dis-notice">- '.esc_html__('disabled', 'vidorev-extensions').'</span>';}?>
                            </label><br>
                            
                            <input type="radio" value="vast" name="ads_types" id="ads_types_vast" <?php if($ads_fn_values['vid_ads_m_video_ads_type']=='vast'){ echo 'checked'; }?>>
                            <label for="ads_types_vast">
								<?php echo esc_html__('VAST', 'vidorev-extensions'); if($ads_vast_status == 'disable' || $ads_vast_status == 'disable_by_membership'){echo ' <span class="dis-notice">- '.esc_html__('disabled', 'vidorev-extensions').'</span>';}?>
                            </label>
                        </span>
                    </p>
                </div>
            </fieldset>
        	<fieldset class="user-ads-google-ima">
                <legend class="h6 extra-bold"><?php echo esc_html__('Google IMA - Interactive Media Ads', 'vidorev-extensions')?></legend>                
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Ad Tag URL - for desktop', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="ima_source_desktop" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_google_ima'][0]['vid_ads_m_ima_source'][0]);?>" size="40" autocomplete="off">
                        </span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Ad Tag URL - for tablet', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="ima_source_tablet"  value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_google_ima'][0]['vid_ads_m_ima_source_tablet'][0]);?>" size="40" autocomplete="off">
                        </span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Ad Tag URL - for mobile', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="ima_source_mobile"  value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_google_ima'][0]['vid_ads_m_ima_source_mobile'][0]);?>" size="40" autocomplete="off">
                        </span>
                    </p>
                </div>
                <?php 
				if($ads_google_ima_status == 'disable' || $ads_google_ima_status == 'disable_by_membership'){
				?>	
                	<div class="disable-ads">
                    	<div class="disable-ads-content dark-background">
							<?php
                            if($ads_google_ima_status == 'disable'){
                            ?>
                            	<?php echo esc_html__('This feature has been disabled by your Administrator!', 'vidorev-extensions')?>
                            <?php 
                            }elseif($ads_google_ima_status == 'disable_by_membership' && defined( 'PMPRO_VERSION' )){
								$post_membership_levels_names = array();	
								foreach($all_levels_arr as $lvl_item_key=>$lvl_item_val){
									if(is_array($lvl_item_val)){
										foreach($lvl_item_val as $key=>$value){
											if(array_search($key, $ads_google_ima) !== FALSE){
												$post_membership_levels_names[] = $value;
											}											
										}
									}
								}														
								$sr_replace = array('<span class="level-highlight">'.pmpro_implodeToEnglish($post_membership_levels_names, esc_html__('or', 'vidorev-extensions')).'</span>', esc_url($register_url));
								echo str_replace($sr_search, $sr_replace, $lock_text);
							?>
                            <?php 	
                            }
                            ?>
                        </div>
                    </div>
                <?php
				}
				?>
            </fieldset>
            <fieldset class="user-ads-image">
                <legend class="h6 extra-bold"><?php echo esc_html__('Image', 'vidorev-extensions')?></legend>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Image Source', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="image_source" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_image'][0]['vid_ads_m_image_source']);?>" size="40" autocomplete="off">
                        </span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Link Target', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="image_link_target" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_image'][0]['vid_ads_m_image_link']);?>" size="40" autocomplete="off">
                        </span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Ad shows up after [seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="image_time_show_ad" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_image'][0]['image_time_show_ad']);?>" size="40" autocomplete="off">
                        </span>                       
						<span class="desc-param"><?php echo esc_html__('Example: 0, 40, 150, 368. If blank, defaults to: 0', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Skip Ad - Clickable After [seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="image_time_skip_ad" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_image'][0]['image_time_skip_ad']);?>" size="40" autocomplete="off">
                        </span>                       
						<span class="desc-param"><?php echo esc_html__('If blank, defaults to: 5', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Hide Ad After [seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="image_time_hide_ad" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_image'][0]['image_time_hide_ad']);?>" size="40" autocomplete="off">
                        </span>                       
						<span class="desc-param"><?php echo esc_html__('If blank, defaults to: 10', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <?php 
				if($ads_image_status == 'disable' || $ads_image_status == 'disable_by_membership'){
				?>	
                	<div class="disable-ads">
                    	<div class="disable-ads-content dark-background">
							<?php
                            if($ads_image_status == 'disable'){
                            ?>
                            	<?php echo esc_html__('This feature has been disabled by your Administrator!', 'vidorev-extensions')?>
                            <?php 
                            }elseif($ads_image_status == 'disable_by_membership' && defined( 'PMPRO_VERSION' )){	
								$post_membership_levels_names = array();	
								foreach($all_levels_arr as $lvl_item_key=>$lvl_item_val){
									if(is_array($lvl_item_val)){
										foreach($lvl_item_val as $key=>$value){
											if(array_search($key, $ads_image) !== FALSE){
												$post_membership_levels_names[] = $value;
											}											
										}
									}
								}																
								$sr_replace = array('<span class="level-highlight">'.pmpro_implodeToEnglish($post_membership_levels_names, esc_html__('or', 'vidorev-extensions')).'</span>', esc_url($register_url));
								echo str_replace($sr_search, $sr_replace, $lock_text);
							?>
                            <?php 	
                            }
                            ?>
                        </div>
                    </div>
                <?php
				}
				?>
            </fieldset>
            <fieldset class="user-ads-html5-video">
                <legend class="h6 extra-bold"><?php echo esc_html__('HTML5 Video', 'vidorev-extensions')?></legend>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Video Source', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="video_source" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html5_video'][0]['vid_ads_m_video_source'][0]);?>" size="40" autocomplete="off">
                        </span>
                        <span class="desc-param"><?php echo esc_html__('Recommended Format Solution: mp4 + webm + ogg.', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Link Target', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="video_link_target" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html5_video'][0]['vid_ads_m_video_link']);?>" size="40" autocomplete="off">
                        </span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Ad shows up after [seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="video_time_show_ad" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html5_video'][0]['video_time_show_ad']);?>" size="40" autocomplete="off">
                        </span>                       
						<span class="desc-param"><?php echo esc_html__('Example: 0, 40, 150, 368. If blank, defaults to: 0', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Skip Ad - Clickable After [seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="video_time_skip_ad" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html5_video'][0]['video_time_skip_ad']);?>" size="40" autocomplete="off">
                        </span>                       
						<span class="desc-param"><?php echo esc_html__('If blank, defaults to: 5', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <?php 
				if($ads_html5_video_status == 'disable' || $ads_html5_video_status == 'disable_by_membership'){
				?>	
                	<div class="disable-ads">
                    	<div class="disable-ads-content dark-background">
							<?php
                            if($ads_html5_video_status == 'disable'){
                            ?>
                            	<?php echo esc_html__('This feature has been disabled by your Administrator!', 'vidorev-extensions')?>
                            <?php 
                            }elseif($ads_html5_video_status == 'disable_by_membership' && defined( 'PMPRO_VERSION' )){	
								$post_membership_levels_names = array();	
								foreach($all_levels_arr as $lvl_item_key=>$lvl_item_val){
									if(is_array($lvl_item_val)){
										foreach($lvl_item_val as $key=>$value){
											if(array_search($key, $ads_html5_video ) !== FALSE){
												$post_membership_levels_names[] = $value;
											}											
										}
									}
								}									
								$sr_replace = array('<span class="level-highlight">'.pmpro_implodeToEnglish($post_membership_levels_names, esc_html__('or', 'vidorev-extensions')).'</span>', esc_url($register_url));
								echo str_replace($sr_search, $sr_replace, $lock_text);
							?>
                            <?php 	
                            }
                            ?>
                        </div>
                    </div>
                <?php
				}
				?>                
            </fieldset>
            <fieldset class="user-ads-google-adsense">
                <legend class="h6 extra-bold"><?php echo esc_html__('Google Adsense', 'vidorev-extensions')?></legend>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Ad Client ID', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="adsense_client_id" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html'][0]['adsense_client_id']);?>" size="40" autocomplete="off">
                        </span> 
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Ad Slot ID', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="adsense_slot_id" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html'][0]['adsense_slot_id']);?>" size="40" autocomplete="off">
                        </span>
                        <span class="desc-param"><?php echo esc_html__('Please choose responsive ad units.', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Ad shows up after [seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="adsense_time_show_ad" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html'][0]['adsense_time_show_ad']);?>" size="40" autocomplete="off">
                        </span>                       
						<span class="desc-param"><?php echo esc_html__('Example: 0,40,150,368. If blank, defaults to: 0', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Skip Ad - Clickable After [seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="adsense_time_skip_ad" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html'][0]['adsense_time_skip_ad']);?>" size="40" autocomplete="off">
                        </span>                       
						<span class="desc-param"><?php echo esc_html__('If blank, defaults to: 5', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('Hide Ad After [seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span>
                        	<input type="text" name="adsense_time_hide_ad" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_group_html'][0]['adsense_time_hide_ad']);?>" size="40" autocomplete="off">
                        </span>                       
						<span class="desc-param"><?php echo esc_html__('If blank, defaults to: 10', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <?php 
				if($ads_google_adsense_status == 'disable' || $ads_google_adsense_status == 'disable_by_membership'){
				?>	
                	<div class="disable-ads">
                    	<div class="disable-ads-content dark-background">
							<?php
                            if($ads_google_adsense_status == 'disable'){
                            ?>
                            	<?php echo esc_html__('This feature has been disabled by your Administrator!', 'vidorev-extensions')?>
                            <?php 
                            }elseif($ads_google_adsense_status == 'disable_by_membership' && defined( 'PMPRO_VERSION' )){	
								$post_membership_levels_names = array();	
								foreach($all_levels_arr as $lvl_item_key=>$lvl_item_val){
									if(is_array($lvl_item_val)){
										foreach($lvl_item_val as $key=>$value){
											if(array_search($key, $ads_google_adsense  ) !== FALSE){
												$post_membership_levels_names[] = $value;
											}											
										}
									}
								}							
								$sr_replace = array('<span class="level-highlight">'.pmpro_implodeToEnglish($post_membership_levels_names, esc_html__('or', 'vidorev-extensions')).'</span>', esc_url($register_url));
								echo str_replace($sr_search, $sr_replace, $lock_text);
							?>
                            <?php 	
                            }
                            ?>
                        </div>
                    </div>
                <?php
				}
				?>
            </fieldset>
            <fieldset class="user-ads-vast">
                <legend class="h6 extra-bold"><?php echo esc_html__('VAST - Only work with Self-hosted video [*.mp4, *.m3u8, *.webm...]', 'vidorev-extensions')?></legend>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('VAST preRoll', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="vast_preroll" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_vast_preroll'][0]['vid_ads_m_vast_tag_pre']);?>" size="40" autocomplete="off">
                        </span>
                        <span class="desc-param"><?php echo esc_html__('The url of the VAST XML. Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('VAST postRoll', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="vast_postroll" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_vast_postroll'][0]['vid_ads_m_vast_tag_post']);?>" size="40" autocomplete="off">
                        </span>
                        <span class="desc-param"><?php echo esc_html__('The url of the VAST XML.', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('VAST pauseRoll', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="vast_pauseroll" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_vast_pauseroll'][0]['vid_ads_m_vast_tag_pause']);?>" size="40" autocomplete="off">
                        </span>
                        <span class="desc-param"><?php echo esc_html__('The url of the VAST XML.', 'vidorev-extensions')?></span>
                    </p>
                </div>
                <div class="frontend-ads-settings-row">
                    <h3 class="h6"><?php echo esc_html__('VAST midRoll [The number of seconds until the ad starts is 10 seconds]', 'vidorev-extensions')?></h3>
                    <p>
                        <span class="wpcf7-form-control-wrap">
                        	<input type="text" name="vast_midroll" value="<?php echo esc_attr($ads_fn_values['vid_ads_m_vast_midroll'][0]['vid_ads_m_vast_tag_mid']);?>" size="40" autocomplete="off">
                        </span>
                        <span class="desc-param"><?php echo esc_html__('The url of the VAST XML.', 'vidorev-extensions')?></span>
                    </p>
                </div> 
                <?php 
				if($ads_vast_status == 'disable' || $ads_vast_status == 'disable_by_membership'){
				?>	
                	<div class="disable-ads">
                    	<div class="disable-ads-content dark-background">
							<?php
                            if($ads_vast_status == 'disable'){
                            ?>
                            	<?php echo esc_html__('This feature has been disabled by your Administrator!', 'vidorev-extensions')?>
                            <?php 
                            }elseif($ads_vast_status == 'disable_by_membership' && defined( 'PMPRO_VERSION' )){	
								$post_membership_levels_names = array();	
								foreach($all_levels_arr as $lvl_item_key=>$lvl_item_val){
									if(is_array($lvl_item_val)){
										foreach($lvl_item_val as $key=>$value){
											if(array_search($key, $ads_vast ) !== FALSE){
												$post_membership_levels_names[] = $value;
											}											
										}
									}
								}		
								$sr_replace = array('<span class="level-highlight">'.pmpro_implodeToEnglish($post_membership_levels_names, esc_html__('or', 'vidorev-extensions')).'</span>', esc_url($register_url));
								echo str_replace($sr_search, $sr_replace, $lock_text);
							?>
                            <?php 	
                            }
                            ?>
                        </div>
                    </div>
                <?php
				}
				?>                
            </fieldset>
            <div class="frontend-ads-settings-row button-submit">
            	<div class="notice-submit ads-notice-submit-control h5"></div>
				<input type="button" id="ads_settings_update" value="<?php echo esc_attr__('Save Changes', 'vidorev-extensions')?>">
			</div>
        </div>
    <?php	
	}
}

add_action('beeteam368_user_ads_settings_frontend', 'beeteam368_user_ads_settings_frontend');

/*add_filter('wpcf7_subscribers_only_notice', function($notice){
	return do_shortcode('[clean-login]');
});*/

if(!function_exists('vidorev_add_json_to_upload_mimes')){
	function vidorev_add_json_to_upload_mimes( $upload_mimes ) {
		$upload_mimes['json'] 	= 'text/plain';
		return $upload_mimes; 
	} 
}
add_filter( 'upload_mimes', 'vidorev_add_json_to_upload_mimes', 10, 1 );

if ( ! function_exists( 'vidorev_google_dirve_files' ) ) :
	function vidorev_google_dirve_files(){
		
		if(isset($_POST['action'])){		
			$theme_data = wp_get_theme();
			if(!wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' )){
				return '';
			}
		}
		
		$html_content = '';
		
		if(!class_exists('Google_Client')){
			$html_content .=  esc_html__('Please install plugin "VidoRev Google APIs Client Library for PHP"', 'vidorev-extensions');			
		}else{
			
			$storage_gd_service_account_id = trim(vidorev_get_option('storage_gd_service_account_id', 'user_submit_settings', ''));
			if($storage_gd_service_account_id=='' || !is_numeric($storage_gd_service_account_id)){								
				$html_content .=  esc_html__('Please declare your JSON file for Authentication', 'vidorev-extensions');			
			}else{
				
				$fullAuth_path = get_attached_file( $storage_gd_service_account_id );			
				if(!$fullAuth_path){
					$html_content .=  esc_html__('Please declare your JSON file for Authentication', 'vidorev-extensions');
				}else{
					putenv('GOOGLE_APPLICATION_CREDENTIALS='.$fullAuth_path);
				
					try {	
											
						$gda_client = new Google_Client();
						$gda_client->useApplicationDefaultCredentials();
						$gda_client->addScope(Google_Service_Drive::DRIVE);	
						
						$gda_service 	= new Google_Service_Drive($gda_client);
						
						if(isset($_POST['deleteFiles']) && is_array($_POST['deleteFiles'])!=''){							
							$params = array();
							
							foreach($_POST['deleteFiles'] as $itemId){
								$gda_service->files->delete($itemId);
							}	
							
							$params['success'] = 'ok';
							
							wp_send_json($params);
							return;		
							die();
						}elseif(isset($_POST['deleteFiles']) && !is_array($_POST['deleteFiles'])!=''){
							$params = array();
							$params['error'] = esc_html__('Invalid data', 'vidorev-extensions');
							wp_send_json($params);
							return;		
							die();
						}
						
						$gda_optParams = array(
							'pageSize' 	=> 50,
							'fields' 	=> 'nextPageToken, files(id,name,mimeType,webViewLink,description,size,permissionIds)'
						);
						
						if(isset($_POST['pageToken']) && trim($_POST['pageToken'])!=''){
							$gda_optParams['pageToken'] = trim($_POST['pageToken']);
						}
						
						if(isset($_POST['q']) && trim($_POST['q'])!=''){
							$gda_optParams['q'] = "name contains '".trim($_POST['q'])."'";
						}
						
						$gda_check_result = $gda_service->files->listFiles($gda_optParams);
						
					}catch (Exception $e) {
						$html_content .=  esc_html($e->getMessage());				
					}
				}
			}

		}
		
	?>
    <?php if(!isset($_POST['pageToken']) && !isset($_POST['q'])){?>
    	<style>
			.load-status{
				opacity:0.5 !important;
				pointer-events:none !important;
			}		
		</style>
    	<div class="wrap">
        	<h2><strong><?php echo esc_html__('Google Drive Files', 'vidorev-extensions')?></strong></h2>
            <div class="metabox-holder">
            	<p class="search-box">
                    <input type="search" class="ftut_control search-keyword-control" value="">
                    <input type="button" class="ftut_control button search-button-control" value="<?php echo esc_html__('Search Files', 'vidorev-extensions')?>">
                    <input type="button" class="ftut_control button clear_search-control load-status" value="<?php echo esc_html__('Clear', 'vidorev-extensions')?>">
                </p><br><br>            	
                <table class="wp-list-table widefat striped">
                    <thead>
                        <tr>
                            <td class="check-column">
                                <input id="cb-select-all-1" class="ftut_control" type="checkbox">
                            </td>                        
                            <th class="column-title"><?php echo esc_html__('Title', 'vidorev-extensions');?></th>
                            <th class="column-post"><?php echo esc_html__('View Post', 'vidorev-extensions');?></th>
                            <th class="column-mimetype"><?php echo esc_html__('mimeType', 'vidorev-extensions');?></th>
                            <th class="column-size"><?php echo esc_html__('Size', 'vidorev-extensions');?></th>
                            <th class="column-permission"><?php echo esc_html__('Permission Ids', 'vidorev-extensions');?></th>
                        </tr>
                    </thead>
                    
                    <tbody id="the-list">
                        <?php
		}
						if(isset($gda_check_result) && isset($gda_check_result->files) && count($gda_check_result)>0){
							foreach($gda_check_result->files as $item){
							?>
                            	<tr id="<?php echo esc_attr($item->id)?>">
                                	<th class="check-column">
                                    	<input id="cb-select-<?php echo esc_attr($item->id)?>" class="ftut_control" type="checkbox" name="googledrivefile[]" value="<?php echo esc_attr($item->id)?>">
                                    </th>
                                    <td class="column-title">
                                    	<a href="<?php echo esc_url($item->webViewLink)?>" class="row-title" target="_blank"><?php echo esc_html($item->name)?></a>
                                    </td>
                                    <td class="column-post"> 
                                    	<?php 
										$post_contains_video = esc_url(get_edit_post_link($item->description));
										if($post_contains_video){
										?>                                   
                                    		<a href="<?php echo esc_url(get_edit_post_link($item->description))?>" class="row-title" target="_blank"><?php esc_html_e('Post contains Video', 'vidorev-extensions');?></a>
                                        <?php
										}else{
											esc_html_e('NULL', 'vidorev-extensions');
										}
										?>
                                    </td>
                                    <td class="column-mimetype">
                                    	<?php echo esc_html($item->mimeType)?>
                                    </td>
                                    <td class="column-size">
                                    	<?php echo esc_html(size_format($item->size, 2))?>
                                    </td>
                                    <td class="column-permission">
                                    	<?php if(isset($item->permissionIds) && count($item->permissionIds)>1){
											echo esc_html($item->permissionIds[0]);
										}?>                                    	
                                    </td>
                                </tr>
                            <?php	
							}
						}else{
						?>
                        	<tr>
								<td colspan="6" style="text-align:center;">
									<?php esc_html_e('No Files found', 'vidorev-extensions');?>                                   	
                                </td>
                            </tr>
                        <?php
						}
						?>
                        <script>
							if(typeof(beeteam368_admin_gd_nextPageToken)!=='undefined'){
                   				beeteam368_admin_gd_nextPageToken = '<?php echo $gda_check_result->nextPageToken;?>';
							}else{
								var beeteam368_admin_gd_nextPageToken = '<?php echo $gda_check_result->nextPageToken;?>';
							}
                   		</script>
	<?php if(!isset($_POST['pageToken']) && !isset($_POST['q'])){?>                        
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <td class="check-column">
                                <input id="cb-select-all-2" class="ftut_control" type="checkbox">
                            </td>                        
                            <th class="column-title"><?php echo esc_html__('Title', 'vidorev-extensions');?></th>
                            <th class="column-post"><?php echo esc_html__('View Post', 'vidorev-extensions');?></th>
                            <th class="column-mimetype"><?php echo esc_html__('mimeType', 'vidorev-extensions');?></th>
                            <th class="column-size"><?php echo esc_html__('Size', 'vidorev-extensions');?></th>
                            <th class="column-size"><?php echo esc_html__('Permission Ids', 'vidorev-extensions');?></th>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <div style="text-align:center;">
                <?php if(isset($gda_check_result->nextPageToken)){?>                
                	<input type="button" class="ftut_control button button-primary button-large load-google-drive-files-control" value="<?php echo esc_html__('Load More', 'vidorev-extensions');?>">
                <?php }?>
                <input type="button" class="ftut_control button button-primary button-large delete-google-drive-files-control" value="<?php echo esc_html__('Delete Files', 'vidorev-extensions');?>"> 
                </div> 
            </div>
        </div>
    <?php
		}
	}
endif;

add_action('wp_ajax_ajaxGetAllGoogleFiles', 'vidorev_google_dirve_files');
add_action('wp_ajax_nopriv_ajaxGetAllGoogleFiles', 'vidorev_google_dirve_files');

if ( ! function_exists( 'vidorev_google_dirve_files_menu' ) ) :
	function vidorev_google_dirve_files_menu(){
		add_submenu_page('edit.php?post_type=video_user_submit', esc_html__( 'Google Drive Files', 'vidorev-extensions'), esc_html__( 'Google Drive Files', 'vidorev-extensions'), 'manage_options', 'vidorev_google_dirve_files', 'vidorev_google_dirve_files' );
	}
endif;

if ( ! function_exists( 'vidorev_custom_notice_cf7' ) ) :
	function vidorev_custom_notice_cf7($notice, $abc){
		if(is_page()){
			$page_id = get_the_ID();			
			$submit_video_page = vidorev_get_redux_option('submit_video_page', '');
			$vidorev_detech_lang_submit_page = vidorev_detech_lang_submit_page($page_id);
						
			if($submit_video_page == $page_id || $vidorev_detech_lang_submit_page[0]){
				$login_shortcode = trim(vidorev_get_redux_option('login_shortcode', ''));
				if(function_exists( 'clean_login_get_translated_option_page' ) && $login_shortcode==''){
					return do_shortcode('[clean-login]');
				}elseif($login_shortcode!=''){
					return do_shortcode($login_shortcode);
				}
			}
		}
		return $notice;
	}
endif;
add_filter('wpcf7_subscribers_only_notice', 'vidorev_custom_notice_cf7', 10, 2);

if ( ! function_exists( 'vidorev_intercept_all_status_changes' ) ) :
	function vidorev_intercept_all_status_changes( $new_status, $old_status, $post ) {
		if ( $new_status == 'publish' && $old_status !='publish' && 
			( 
					( $post->post_type == 'post' && is_numeric(get_post_meta($post->ID, 'vidorev_submit_id', true)) && get_post_format($post->ID) == 'video' )
				|| 	( $post->post_type == 'vid_playlist' && is_numeric(get_post_meta($post->ID, 'playlist_submit_id', true)) ) 
				|| 	( $post->post_type == 'vid_channel' && is_numeric(get_post_meta($post->ID, 'channel_submit_id', true)) )
			) 
		) {
			$submit_id = 0;
			
			switch($post->post_type){
				case 'post':
					$submit_id = get_post_meta($post->ID, 'vidorev_submit_id', true);
					break;
				
				case 'vid_playlist':
					$submit_id = get_post_meta($post->ID, 'playlist_submit_id', true);
					break;	
					
				case 'vid_channel':
					$submit_id = get_post_meta($post->ID, 'channel_submit_id', true);
					break;		
			}
			
			$to 		= apply_filters( 'vidorev_to_send_mail_publish', get_post_meta($submit_id, 'email', true), $submit_id, $post->ID );
			$subject 	= apply_filters( 'vidorev_subject_send_mail_publish', '['.get_bloginfo('name').'] Your post has been approved', $submit_id, $post->ID );
			$body 		= apply_filters( 'vidorev_body_send_mail_publish', 'Congratulations! Your post has been approved. You can view your item here: <br><br> <strong>'.esc_html(get_the_title($submit_id)).'</strong>[ <a href="'.esc_url(get_permalink($post->ID)).'" target="_blank">'.esc_html(get_permalink($post->ID)).'</a> ] <br><br> Thank you very much!<br>Best Regards.', $submit_id, $post->ID );
			$headers 	= apply_filters( 'vidorev_headers_send_mail_publish', array('Content-Type: text/html; charset=UTF-8', 'From: '.get_bloginfo('name').' <'.get_bloginfo('admin_email').'>', 'Reply-To: '.get_bloginfo('name').' <'.get_bloginfo('admin_email').'>'), $submit_id, $post->ID );
			 
			$send_mail = wp_mail( $to, $subject, $body, $headers );
			update_post_meta($post->ID, 'vidorev_send_mail_publish', $send_mail);
		}
	}  
endif;
add_action( 'transition_post_status', 'vidorev_intercept_all_status_changes', 10, 3 );

if(is_admin()){	
	add_action('admin_menu', 'vidorev_google_dirve_files_menu');	
}

/*custom Hook DND*/
	/*field cf7*/
	if ( ! function_exists( 'vidorev_custom_dnd_cf7_upload_form_tag_handler' ) ) :
		function vidorev_custom_dnd_cf7_upload_form_tag_handler( $tag ) {
			if ( empty( $tag->name ) ) {
				return '';
			}
			$validation_error = wpcf7_get_validation_error( $tag->name );
	
			$class = wpcf7_form_controls_class( 'drag-n-drop-file d-none' );
	
			if ( $validation_error ) {
				$class .= ' wpcf7-not-valid';
			}
	
			$atts = array();
		
			$atts['size'] = $tag->get_size_option( '40' );
			$atts['class'] = $tag->get_class_option( $class );
			$atts['id'] = $tag->get_id_option();
			$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
	
			if ( $tag->is_required() ) {
				$atts['aria-required'] = 'true';
			}
	
			$atts['aria-invalid'] = $validation_error ? 'true' : 'false';
	
			$atts['type'] = 'file';
			$atts['multiple'] = 'multiple';
			$atts['data-name'] = $tag->name;
			$atts['data-type'] = $tag->get_option( 'filetypes','', true);
			
			if($atts['data-name'] == 'vidorev-submit-video-file-pb'){			
				if(is_user_logged_in()){
					$current_user = wp_get_current_user();
				}
				$limit_param	= trim(vidorev_get_option('limit_vid_upload', 'user_submit_settings', '10mb'));
				if ( defined( 'PMPRO_VERSION' ) && isset($current_user) && isset($current_user->membership_level) && isset($current_user->membership_level->ID) && is_numeric($current_user->membership_level->ID)) {
					$new_limit_param	= trim(vidorev_get_option('limit_vid_upload_membership_'.$current_user->membership_level->ID, 'user_submit_settings', ''));
					if($new_limit_param!=''){
						$limit_param = $new_limit_param;
					}
				}
				$limit_upload 	= vidorev_detech_limit_upload($limit_param);
				$atts['data-limit'] = $limit_upload;
				
			}else{
				$atts['data-limit'] = $tag->get_option( 'limit','', true);
			}
			
			$atts['data-max'] = $tag->get_option( 'max-file','', true);
	
			$atts = wpcf7_format_atts( $atts );
	
			return sprintf('<span class="wpcf7-form-control-wrap %1$s"><input %2$s />%3$s</span>',	sanitize_html_class( $tag->name ), $atts, $validation_error );
		}
	endif;
	
	if ( ! function_exists( 'vidorev_custom_dnd_cf7_upload_add_form_tag_file' ) ) :
		function vidorev_custom_dnd_cf7_upload_add_form_tag_file() {
			wpcf7_add_form_tag(	array( 'mfile ', 'mfile*'), 'vidorev_custom_dnd_cf7_upload_form_tag_handler', array( 'name-attr' => true ) );
		}
	endif;
	
	remove_action( 'wpcf7_init', 'dnd_cf7_upload_add_form_tag_file' );
	add_action( 'wpcf7_init', 'vidorev_custom_dnd_cf7_upload_add_form_tag_file' );/*field cf7*/
	
	/*change field data submit file dir*/
	if ( ! function_exists( 'vidorev_custom_dnd_wpcf7_posted_data' ) ) :
		function vidorev_custom_dnd_wpcf7_posted_data( $posted_data ){
			
			if ( !defined( 'dnd_upload_cf7' ) ) {
				return $posted_data;
			}
			
			$submission = WPCF7_Submission::get_instance();

			if ( ! $posted_data ) {
				$posted_data = $submission->get_posted_data();
			}

			$forms_tags = $submission->get_contact_form();
			$uploads_dir = dnd_get_upload_dir();
	
			if( $forms = $forms_tags->scan_form_tags() ) {
				foreach( $forms as $field ) {
					$field_name = $field->name;
					if( $field->basetype == 'mfile' && $field_name!='vidorev-submit-video-file-pb' && isset( $posted_data[$field_name] ) && ! empty( $posted_data[$field_name] ) ) {
						foreach( $posted_data[$field_name] as $key => $file ) {
							$posted_data[$field_name][$key] = trailingslashit( $uploads_dir['upload_url'] ) . wp_basename( $file );
						}
					}elseif( $field->basetype == 'mfile' && $field_name=='vidorev-submit-video-file-pb' && isset( $posted_data[$field_name] ) && ! empty( $posted_data[$field_name] ) ){
						foreach( $posted_data[$field_name] as $key => $file ) {
							$posted_data[$field_name][$key] = trailingslashit( $uploads_dir['upload_dir'] ) . wp_basename( $file );
						}
					}
				}
			}
	
			return $posted_data;
		}
	endif;
	
	remove_filter( 'wpcf7_posted_data', 'dnd_wpcf7_posted_data', 10, 1 );
	add_filter( 'wpcf7_posted_data', 'vidorev_custom_dnd_wpcf7_posted_data', 5, 1 );/*change field data submit file dir*/
	
	/*attach file send mail*/
	if ( ! function_exists( 'vidorev_custom_dnd_cf7_mail_components' ) ) :
		function vidorev_custom_dnd_cf7_mail_components( $components, $form ) {
			
			if ( !defined( 'dnd_upload_cf7' ) ) {
				return $components;
			}
			
			global $_mail;

			$uploads_dir = dnd_get_upload_dir();
	
			$submission = WPCF7_Submission::get_instance();
	
			$fields = $form->scan_form_tags();
	
			if( get_option('drag_n_drop_mail_attachment') == 'yes' ) {
				return $components;
			}
	
			$mail = array('mail','mail_2');
			$props_mail = array();
	
			foreach( $mail as $single_mail ) {
				$props_mail[] = $form->prop( $single_mail );
			}
	
			$mail = $props_mail[ $_mail ];
			if( $mail['active'] && $mail['attachments'] ) {
	
				foreach( $fields as $field ) {
	
					if( $field->basetype == 'mfile' && $field->name != 'vidorev-submit-video-file-pb') {
	
						if( isset( $_POST[ $field->name ] ) && count( $_POST[ $field->name ] ) > 0 ) {
	
							if ( false !== strpos( $mail['attachments'], "[{$field->name}]" ) ) {
	
								foreach( $_POST[ $field->name ] as $_file ) {
	
									$new_file_name = trailingslashit( $uploads_dir['upload_dir'] ) . wp_basename( $_file );
	
									if ( $submission && file_exists( $new_file_name )  ) {
										$components['attachments'][] = $new_file_name;
									}
								}
	
							}
						}
					}
				}
	
			}
	
			$_mail = $_mail + 1;
	
			return $components;
		}
	endif;
	
	remove_action( 'wpcf7_mail_components', 'dnd_cf7_mail_components', 50, 2 );
	add_action( 'wpcf7_mail_components', 'vidorev_custom_dnd_cf7_mail_components', 50, 2 );/*attach file send mail*/	
/*custom Hook DND*/