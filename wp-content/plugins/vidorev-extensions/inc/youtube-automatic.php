<?php
if ( !class_exists('vidorev_youtube_automatic_settings' ) ):
	class vidorev_youtube_automatic_settings {
	
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
			add_submenu_page('edit.php?post_type=youtube_automatic', esc_html__( 'Cron-Job Server', 'vidorev-extensions'), esc_html__( 'Cron-Job Server', 'vidorev-extensions'), 'manage_options', 'youtube_automatic_settings', array($this, 'plugin_page') );
		}
	
		function get_settings_sections() {
			$sections = array(
				array(
					'id' 	=> 'youtube_automatic_settings',
					'title' => esc_html__('Cron-Job Server - Youtube Automatic Settings', 'vidorev-extensions')
				),				      
			);
			
			return $sections;
		}

		function get_settings_fields() {
			$settings_fields = array(
				'youtube_automatic_settings' => array(	
					array(
						'name'    => 'enable_auto',
						'label'   => esc_html__( 'Enable Youtube Automatic', 'vidorev-extensions'),						
						'type'    => 'select',
						'default' => 'yes',
						'options' => array(
							'yes' 	=> esc_html__('Turn ON', 'vidorev-extensions'),
							'no'  	=> esc_html__('Turn OFF', 'vidorev-extensions'),
						)
					),			           
				),
				          
			);
	
			return $settings_fields;
		}
	
		function plugin_page() {
			echo '<div class="wrap"><h1>'.esc_html__( 'Youtube Automatic Settings', 'vidorev-extensions').'</h1>';
	
				$this->settings_api->show_navigation();
				$this->settings_api->show_forms();
			
			ob_start();
			?>
				<div>
					<h2>CURL command code (1):</h2>
					<code style="padding:10px; font-size:16px;">curl <?php echo esc_url(VPE_PLUGIN_URL.'cron-job/youtube-automatic.php');?></code><br><br>
					<hr>
					
					<h2>How to get to the Cron Job Page in cPanel (2):</h2>
						1/ Login to cPanel.<br><br>
	
						2/ Scroll down until you find the Advanced section.<br><br>
	
						3/ Click on Cron jobs. This will bring you to the Cron Jobs page.
					<hr>
					
					<h2>Set up a New Cron job (3):</h2>
					Specify when the cron job will run. The order is:<br><br>

					<strong>[minute] [hour] [day] [month] [weekday] [command]</strong><br><br>
					<img src="<?php echo esc_url(VPE_PLUGIN_URL.'cron-job/cpanel-cron-job.jpg');?>">
				</div>
			<?php
			$output_string = ob_get_contents();
			ob_end_clean();
			
			echo $output_string.'</div>';
		}	
	}
endif;
new vidorev_youtube_automatic_settings();

if ( !class_exists('beeteam368_youtube_automatic_action' ) ):
	class beeteam368_youtube_automatic_action {		
		
		private $prefix = YOUTUBE_AUTOMATIC_PREFIX;
		
		private function api_key($task_api_id = 0){
			$single_api_key = trim(get_post_meta($task_api_id, $this->prefix.'sub_api_key', true));
			if($single_api_key!=''){
				return $single_api_key;
			} 
			return trim(vidorev_get_redux_option('google_api_key', ''));
		}
		
		private function user_url($id, $task_api_id = 0){
			return 'https://www.googleapis.com/youtube/v3/channels?key='.$this->api_key($task_api_id).'&forUsername='.$id.'&part=snippet,contentDetails,brandingSettings,statistics&maxResults=1';
		}
		
		private function channel_url($id, $task_api_id = 0){
			return 'https://www.googleapis.com/youtube/v3/channels?key='.$this->api_key($task_api_id).'&id='.$id.'&part=snippet,contentDetails,brandingSettings,statistics&maxResults=1';
		}
		
		private function custom_channel_url($id, $task_api_id = 0){
			return 'https://www.googleapis.com/youtube/v3/search?key='.$this->api_key($task_api_id).'&part=id&type=channel&q='.$id;
		}
		
		private function search_url_date($id, $publishedAfter, $publishedBefore, $pageToken, $task_api_id = 0){
			if($publishedAfter!='' || $publishedBefore!=''){
				
				$pt_string = '';	
						
				if($pageToken!=''){
					$pt_string='&pageToken='.$pageToken;
				}
				
				$date_published = '';
				
				if($publishedAfter!=''){
					$date_published.='&publishedAfter='.$publishedAfter;
				}
				
				if($publishedBefore!=''){
					$date_published.='&publishedBefore='.$publishedBefore;
				}
				
				return 'https://www.googleapis.com/youtube/v3/search?key='.$this->api_key($task_api_id).'&channelId='.$id.$date_published.'&part=snippet&type=video&order=date&maxResults=50'.$pt_string;
			}
		}
		
		private function playlist_url($id, $pageToken, $task_api_id = 0){
			
			$pt_string = '';
			
			if($pageToken!=''){
				$pt_string='&pageToken='.$pageToken;
			}
						
			return 'https://www.googleapis.com/youtube/v3/playlistItems?key='.$this->api_key($task_api_id).'&playlistId='.$id.'&part=contentDetails&maxResults=50'.$pt_string;
		}
		
		private function auto_detech($url){
			$detech_source = array();
			
			if(strpos($url, '/user/')){
				
				$detech_source['type'] 	= 'user';
				
				$idString 	= substr($url, strrpos($url,'/user/') + 6);
									
				if($idString != ''){
					$id_explode = explode('/', $idString);
					$detech_source['id'] = $id_explode[0];
				}else{
					$detech_source['id'] = '';
				}
				
			}elseif(strpos($url, '/channel/')){
				
				$detech_source['type'] 	= 'channel';
				
				$idString 	= substr($url, strrpos($url,'/channel/') + 9);
									
				if($idString != ''){
					$id_explode = explode('/', $idString);
					$detech_source['id'] = $id_explode[0];
				}else{
					$detech_source['id'] = '';
				}
				
			}elseif(strpos($url, 'list=')){
				
				$detech_source['type'] 	= 'playlist';
				
				$url = parse_url($url);
				
				if(isset($url['query'])){
					parse_str($url['query'], $q);
					if(isset($q['list']) && trim($q['list']) !=''){
						$detech_source['id'] = trim($q['list']);
					}else{
						$detech_source['id'] = '';
					}		
				}else{
					$detech_source['id'] = '';
				}	
							
			}elseif(strpos($url, '/c/')){
				$detech_source['type'] 	= 'customchannel';
				
				$idString 	= substr($url, strrpos($url,'/c/') + 3);
									
				if($idString != ''){
					$id_explode = explode('/', $idString);
					$detech_source['id'] = $id_explode[0];
				}else{
					$detech_source['id'] = '';
				}
				
			}else{
				$detech_source['type'] 	= '';
				$detech_source['id'] 	= '';
			}

			return $detech_source;
		}
		
		public function auto_detech_playlist_id($detech_source, $publishedAfter = '', $publishedBefore = '', $task_api_id = 0){
			
			if(is_array($detech_source) && count($detech_source) == 2 && $detech_source['type'] != '' && $detech_source['id']!=''){
				switch($detech_source['type']){
					case 'user':
					
						$request_url 	= $this->user_url($detech_source['id'], $task_api_id);	
						$response 		= wp_remote_get($request_url, array('timeout'=>368));
						
						if(is_wp_error($response)){														
							return '';
						}else {
							$result = json_decode($response['body']);
							if((isset($result->{'error'}) && $result->{'error'}!='') || (isset($result->{'pageInfo'}) && isset($result->{'pageInfo'}->{'totalResults'}) && $result->{'pageInfo'}->{'totalResults'}==0)){	
								return '';
							}
						}
						
						if(	isset($result->{'items'}) && count($result->{'items'})>0 && isset($result->{'items'}[0]) && isset($result->{'items'}[0]->{'id'}) ){
							
							if($publishedAfter!='' || $publishedBefore!=''){
								return array($result->{'items'}[0]->{'id'}, $publishedAfter, $publishedBefore);
							}
							
							$request_url 	= $this->channel_url($result->{'items'}[0]->{'id'}, $task_api_id);		
							$response 		= wp_remote_get($request_url, array('timeout'=>368));
							
							if(is_wp_error($response)){												
								return '';
							}else {
								$result = json_decode($response['body']);
								if((isset($result->{'error'}) && $result->{'error'}!='') || (isset($result->{'pageInfo'}) && isset($result->{'pageInfo'}->{'totalResults'}) && $result->{'pageInfo'}->{'totalResults'}==0)){												
									return '';
								}
							}
							
							if(	isset($result->{'items'}) && count($result->{'items'})>0 && 
								isset($result->{'items'}[0]) && isset($result->{'items'}[0]->{'contentDetails'}) && isset($result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}) && isset($result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}->{'uploads'})
							){								
								return $result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}->{'uploads'};
							}
							
						}
						
						return '';
						
						break;
						
					case 'channel':
					
						if($publishedAfter!='' || $publishedBefore!=''){
							return array($detech_source['id'], $publishedAfter, $publishedBefore);
						}
						
						$request_url 	= $this->channel_url($detech_source['id'], $task_api_id);		
						$response 		= wp_remote_get($request_url, array('timeout'=>368));
						
						if(is_wp_error($response)){												
							return '';
						}else {
							$result = json_decode($response['body']);
							if((isset($result->{'error'}) && $result->{'error'}!='') || (isset($result->{'pageInfo'}) && isset($result->{'pageInfo'}->{'totalResults'}) && $result->{'pageInfo'}->{'totalResults'}==0)){												
								return '';
							}
						}
						
						if(	isset($result->{'items'}) && count($result->{'items'})>0 && 
							isset($result->{'items'}[0]) && isset($result->{'items'}[0]->{'contentDetails'}) && isset($result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}) && isset($result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}->{'uploads'})
						){
							return $result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}->{'uploads'};
						}
						
						return '';
					
						break;
						
					case 'customchannel':
						
						$request_url 	= $this->custom_channel_url($detech_source['id'], $task_api_id);	
						$response 		= wp_remote_get($request_url, array('timeout'=>368));
						
						if(is_wp_error($response)){														
							return '';
						}else {
							$result = json_decode($response['body']);
							if((isset($result->{'error'}) && $result->{'error'}!='') || (isset($result->{'pageInfo'}) && isset($result->{'pageInfo'}->{'totalResults'}) && $result->{'pageInfo'}->{'totalResults'}==0)){	
								return '';
							}
						}
						
						if(	isset($result->{'items'}) && count($result->{'items'})>0 && isset($result->{'items'}[0]) && isset($result->{'items'}[0]->{'id'}) && isset($result->{'items'}[0]->{'id'}->{'channelId'}) ){							
														
							$request_url 	= $this->channel_url($result->{'items'}[0]->{'id'}->{'channelId'}, $task_api_id);		
							$response 		= wp_remote_get($request_url, array('timeout'=>368));
							
							if(is_wp_error($response)){												
								return '';
							}else {
								$result = json_decode($response['body']);
								if((isset($result->{'error'}) && $result->{'error'}!='') || (isset($result->{'pageInfo'}) && isset($result->{'pageInfo'}->{'totalResults'}) && $result->{'pageInfo'}->{'totalResults'}==0)){												
									return '';
								}
							}
							
							if(	isset($result->{'items'}) && count($result->{'items'})>0 && 
								isset($result->{'items'}[0]) && isset($result->{'items'}[0]->{'contentDetails'}) && isset($result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}) && isset($result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}->{'uploads'})
							){								
								return $result->{'items'}[0]->{'contentDetails'}->{'relatedPlaylists'}->{'uploads'};
							}
							
						}
						
						return '';
						
						break;	
						
					case 'playlist':		
						return $detech_source['id'];
				}
			}
			
			return '';
		}
		
		private function beeteam368_youtube_get_upload_videos($playlist_upload, $pageToken, $prev_page_videos, $task_api_id = 0){
			
			if(is_array($playlist_upload) && count($playlist_upload)==3){
				$request_url = $this->search_url_date($playlist_upload[0], $playlist_upload[1], $playlist_upload[2], $pageToken, $task_api_id);
			}else{
				$request_url = $this->playlist_url($playlist_upload, $pageToken, $task_api_id);
			}
			
			$response = wp_remote_get($request_url, array('timeout'=>368));
			
			if(is_wp_error($response)){				
				return array();
			}else {
				$result = json_decode($response['body']);								
				if((isset($result->{'error'}) && $result->{'error'}!='') || (isset($result->{'pageInfo'}) && isset($result->{'pageInfo'}->{'totalResults'}) && $result->{'pageInfo'}->{'totalResults'}==0)){							
					return array();
				}
			}
			
			$videos = array();		
			if(isset($result->{'items'}) && count($result->{'items'})>0){				
				foreach ($result->{'items'} as $value) {
					if(isset($value->{'contentDetails'}) && isset($value->{'contentDetails'}->{'videoId'}) && isset($value->{'contentDetails'}->{'videoPublishedAt'})){
						$videoID 			= $value->{'contentDetails'}->{'videoId'};
						$videoPublishedAt 	= $value->{'contentDetails'}->{'videoPublishedAt'};
						array_push( $videos, array('videoID' => $videoID, $videoID => $videoPublishedAt) );
					}elseif(isset($value->{'id'}) && isset($value->{'id'}->{'videoId'}) && isset($value->{'snippet'}) && isset($value->{'snippet'}->{'publishedAt'})){
						$videoID 			= $value->{'id'}->{'videoId'};
						$videoPublishedAt 	= $value->{'snippet'}->{'publishedAt'};
						array_push( $videos, array('videoID' => $videoID, $videoID => $videoPublishedAt) );
					}
				}
			}
			
			if(isset($prev_page_videos) && count($prev_page_videos) > 0){
				$videos = array_merge( $videos, $prev_page_videos );
			}

			$nextTokenPage = (isset($result->{'nextPageToken'})&&$result->{'nextPageToken'}!='')?$result->{'nextPageToken'}:'';
			
			if($nextTokenPage!=''){
				$videos = $this->beeteam368_youtube_get_upload_videos($playlist_upload, $nextTokenPage, $videos, $task_api_id);				
				return $videos;
			}else{
				return $videos;
			}
		}
		
		private function update_processing($auto_id, $value){
			update_post_meta($auto_id, $this->prefix.'processing', $value);
		}
		
		private function get_update_time($auto_id){
			
			$update_time = 200 * 60;
			
			$update_every 		= get_post_meta($auto_id, $this->prefix.'update_every', true);
			$update_unit  		= get_post_meta($auto_id, $this->prefix.'update_unit', true);
						
			switch($update_unit){
				case 'minutes':
					$update_time = (int)$update_every * 60;
					break;
					
				case 'hours':
					$update_time = (int)$update_every * 3600;
					break;
					
				case 'days':
					$update_time = (int)$update_every * 86400;
					break;			
			}
			
			return $update_time;
		}
		
		private function check_video_exists($videoID){
			$video_exists = get_posts( array(
				'posts_per_page' 	=> 1,
				'meta_key' 			=> 'beeteam368_youtube_automactic_id',
				'meta_value' 		=> $videoID,
			));
			
			if(is_array($video_exists) && count($video_exists)>0){
				foreach ( $video_exists as $video_exists_id ) {
					return $video_exists_id->ID;
					break;
				}
			}
			
			return 0;
		}
		
		private function update_data($auto_id, $videoID, $new_post_id, $ext_datas){	
			
			$video_exists_id = $this->check_video_exists($videoID);
			
			if($video_exists_id > 0){
				wp_delete_post( $new_post_id, true);
				$new_post_id = $video_exists_id;
				
				if(isset($ext_datas['director']) && is_array($ext_datas['director'])){
					
					$all_directors = get_post_meta($new_post_id, MOVIE_PM_PREFIX.'director', true);
					
					if(is_array($all_directors)){					
						foreach($ext_datas['director'] as $director){
	
							if(($izd = array_search($director, $all_directors)) === FALSE){
								array_push($all_directors, $director);					
							}							
						}						
						update_post_meta($new_post_id, MOVIE_PM_PREFIX.'director', $all_directors);				
					}else{
						update_post_meta($new_post_id, MOVIE_PM_PREFIX.'director', $ext_datas['director']);
					}
				}
				
				if(isset($ext_datas['actor']) && is_array($ext_datas['actor'])){
					$all_actors = get_post_meta($new_post_id, MOVIE_PM_PREFIX.'actor', true);
					
					if(is_array($all_actors)){					
						foreach($ext_datas['actor'] as $actor){
	
							if(($iza = array_search($actor, $all_actors)) === FALSE){
								array_push($all_actors, $actor);					
							}							
						}						
						update_post_meta($new_post_id, MOVIE_PM_PREFIX.'actor', $all_actors);				
					}else{
						update_post_meta($new_post_id, MOVIE_PM_PREFIX.'actor', $ext_datas['actor']);
					}
				}
				
				if(isset($ext_datas['categories']) && is_array($ext_datas['categories'])){
					wp_set_post_categories( $new_post_id, $ext_datas['categories'], true );
				}
				
			}else{
				$video_url 		= 'https://www.youtube.com/watch?v='.$videoID;			
				set_post_format($new_post_id, 'video' );			
				update_post_meta($new_post_id, 'vm_video_url', $video_url);
				update_post_meta($new_post_id, 'beeteam368_youtube_automactic_id', $videoID);
				
				$_POST['auto_fetch_extensions'] = 'on';
				$_POST['auto_fetch_extensions_api_key'] = $ext_datas['api_key'];
				
				$new_post = array(
					'ID' 			=> $new_post_id,
				);	
											
				wp_update_post( $new_post );
				
				if(isset($ext_datas['director']) && is_array($ext_datas['director'])){
					update_post_meta($new_post_id, MOVIE_PM_PREFIX.'director', $ext_datas['director']);
				}
				
				if(isset($ext_datas['actor']) && is_array($ext_datas['actor'])){
					update_post_meta($new_post_id, MOVIE_PM_PREFIX.'actor', $ext_datas['actor']);
				}
			}
			
			global $beeteam36_youtube_fetch_err;
			if(isset($beeteam36_youtube_fetch_err) && $beeteam36_youtube_fetch_err=='yes'){
				wp_delete_post( $new_post_id, true);
				return;
			}
			
			if(isset($ext_datas['playlists']) && is_array($ext_datas['playlists'])){
				
				update_post_meta($new_post_id, PLAYLIST_PM_PREFIX.'sync_playlist', $ext_datas['playlists']);
				
				foreach($ext_datas['playlists'] as $playlist){
					$videos_in = get_post_meta($playlist, PLAYLIST_PM_PREFIX.'videos', true);
					if(is_array($videos_in)){
						if(($izp = array_search($new_post_id, $videos_in)) === FALSE){
							array_push($videos_in, $new_post_id);
							update_post_meta($playlist, PLAYLIST_PM_PREFIX.'videos', array_map('strval', $videos_in));
						}
					}else{
						update_post_meta($playlist, PLAYLIST_PM_PREFIX.'videos', array_map('strval', array($new_post_id)));
					}
				}
			}
			
			if(isset($ext_datas['channels']) && is_array($ext_datas['channels'])){
				
				update_post_meta($new_post_id, CHANNEL_PM_PREFIX.'sync_channel', $ext_datas['channels']);
				
				foreach($ext_datas['channels'] as $channel){
					$videos_in = get_post_meta($channel, CHANNEL_PM_PREFIX.'videos', true);
					if(is_array($videos_in)){
						if(($izc = array_search($new_post_id, $videos_in)) === FALSE){
							array_push($videos_in, $new_post_id);
							update_post_meta($channel, CHANNEL_PM_PREFIX.'videos', array_map('strval', $videos_in));
						}
					}else{
						update_post_meta($channel, CHANNEL_PM_PREFIX.'videos', array_map('strval', array($new_post_id)));
					}
				}
			}
			
			global $wpdb;
			$success = 	$wpdb->query(
							$wpdb->prepare(
								"UPDATE {$wpdb->prefix}posts SET post_status = %s where ID = %d",
								$ext_datas['status'], $new_post_id
							)
						);
			
			$old_import = get_post_meta($auto_id, $this->prefix.'old_import', true);
			if(!is_array($old_import) || count($old_import) == 0){
				$old_import = array();
			}
			array_push($old_import, $videoID);
			
			update_post_meta($auto_id, $this->prefix.'old_import', $old_import);
			
			if(isset($ext_datas['update_time']) && is_numeric($ext_datas['update_time'])){
				update_post_meta($auto_id, $this->prefix.'timestamp_update', (time()+$ext_datas['update_time']) );
			}	
		}
		
		private function beeteam368_youtube_automatic_import($auto_id){
		
			if(!isset($auto_id) || !is_numeric($auto_id)){
				return;
			}
			
			$renew_posts  		= get_post_meta($auto_id, $this->prefix.'renew_posts', true); //yes, no	
			if($renew_posts == 'yes'){
				return;
			}			
			
			$youtube_source 	= trim(get_post_meta($auto_id, $this->prefix.'youtube_source', true));
			$processing  		= get_post_meta($auto_id, $this->prefix.'processing', true); //yes, no			
			$timestamp_update  	= get_post_meta($auto_id, $this->prefix.'timestamp_update', true);
			
			$publishedAfter		= trim(get_post_meta($auto_id, $this->prefix.'published_after', true));
			$check_date_after 	= ($publishedAfter!=''&&(bool)strtotime($publishedAfter));
			if($check_date_after){				
				$publishedAfter = $publishedAfter.'T00:00:00Z';
			}else{
				$publishedAfter = '';
			}
			
			$publishedBefore	= trim(get_post_meta($auto_id, $this->prefix.'published_before', true));
			$check_date_before 	= ($publishedBefore!=''&&(bool)strtotime($publishedBefore));
			if($check_date_before){				
				$publishedBefore = $publishedBefore.'T00:00:00Z';
			}else{
				$publishedBefore = '';
			}
			
			$url_array = array();
			
			if($youtube_source == '' || $processing == 'yes' || ($timestamp_update != '' && is_numeric($timestamp_update) && time() < $timestamp_update) ){
				if($timestamp_update != '' && is_numeric($timestamp_update) && $timestamp_update + 86400 < time()){
					$this->update_processing($auto_id, 'no');
				}				
				return;			
			}
			
			$this->update_processing($auto_id, 'yes');
			
			$playlist_upload = $this->auto_detech_playlist_id($this->auto_detech($youtube_source), $publishedAfter, $publishedBefore, $auto_id);
			
			if($playlist_upload!=''){
				
				$fetch_videos 	= $this->beeteam368_youtube_get_upload_videos($playlist_upload, '', array(), $auto_id);
				if(!is_array($fetch_videos) || count($fetch_videos) == 0){
					$this->update_processing($auto_id, 'no');
					return;
				}
				
				$videos	= wp_list_pluck( $fetch_videos, 'videoID' );
				
				if(is_array($videos) && count($videos) > 0){
					
					$old_import = get_post_meta($auto_id, $this->prefix.'old_import', true);
					
					if(!is_array($old_import) || count($old_import) == 0){
						$old_import= array();
					}
					
					$new_import_videos = array_diff($videos, $old_import);
					
					if(!is_array($new_import_videos) || count($new_import_videos) == 0){
						$this->update_processing($auto_id, 'no');
						return;
					}
					
					$import_post_date	= get_post_meta($auto_id, $this->prefix.'import_post_date', true);
					$status 			= get_post_meta($auto_id, $this->prefix.'status', true);
					$categories 		= get_the_terms( $auto_id, 'category');
					$cat_insert			= array();
					
					if(!is_wp_error($categories) && isset($categories) && is_array($categories)){
						foreach($categories as $category){
							if(isset($category->term_id) && is_numeric($category->term_id)){
								array_push($cat_insert, $category->term_id);
							}
						}
					}
					
					$author				= get_post_meta($auto_id, $this->prefix.'author', true);
					
					$ext_datas		= array(
						'playlists'			=> get_post_meta($auto_id, $this->prefix.'playlists', true),
						'channels'			=> get_post_meta($auto_id, $this->prefix.'channels', true),
						'director'			=> get_post_meta($auto_id, $this->prefix.'director', true),
						'actor'				=> get_post_meta($auto_id, $this->prefix.'actor', true),
						'import_post_date'	=> get_post_meta($auto_id, $this->prefix.'import_post_date', true),
						'update_time'		=> $this->get_update_time($auto_id),
						'status'			=> $status,
						'categories'		=> $cat_insert,
						'api_key'			=> $this->api_key($auto_id),
					);
					
					foreach($new_import_videos as $video){
						global $beeteam36_youtube_fetch_err;
						if(get_post_meta($auto_id, $this->prefix.'processing', true) == 'no' || get_post_meta($auto_id, $this->prefix.'renew_posts', true) == 'yes' || (isset($beeteam36_youtube_fetch_err) && $beeteam36_youtube_fetch_err=='yes')){
							if(isset($beeteam36_youtube_fetch_err) && $beeteam36_youtube_fetch_err=='yes'){
								$this->update_processing($auto_id, 'no');
								update_post_meta($auto_id, $this->prefix.'timestamp_update', (time()+86400));
								$beeteam36_youtube_fetch_err = '';
							}
							break;
						}else{								
							$postData 		= array();
							
							$postData['post_title'] 	= esc_html__('[ID: '.$video.'] Youtube Automatic', 'vidorev-extensions');
							$postData['post_name'] 		= esc_html($video);
							
							$postData['post_status'] 	= 'private';	
							
							if($author!='' && is_numeric($author)){
								$postData['post_author']= $author;
							}
							
							if(count($cat_insert)>0){
								$postData['post_category']= $cat_insert;
							}
							
							if($import_post_date == 'yes'){									
								if (($i = array_search($video, array_column($fetch_videos, 'videoID'))) !== FALSE && isset($fetch_videos[$i][$video])) {
									$postData['post_date'] = $fetch_videos[$i][$video];
								}
							}
							
							$newPostID = wp_insert_post($postData);
							
							if(!is_wp_error($newPostID) && $newPostID){
								
								$post_import = get_post_meta($auto_id, $this->prefix.'post_import', true);
								if(!is_array($post_import) || count($post_import) == 0){
									$post_import = array();
								}
								array_push($post_import, $newPostID);								
								update_post_meta($auto_id, $this->prefix.'post_import', $post_import);
								
								$this->update_data($auto_id, $video, $newPostID, $ext_datas);
							}							
						}
					}
					
					$this->update_processing($auto_id, 'no');
					
				}else{
					$this->update_processing($auto_id, 'no');
				}
				
			}else{
				$this->update_processing($auto_id, 'no');					
				return;
			}
			
		}
		
		public function beeteam368_youtube_automatic_cron_job(){
			
			if(vidorev_get_option('enable_auto', 'youtube_automatic_settings', 'yes') != 'yes'){
				return;
			}
			
			$args_query = array(
				'post_type'				=> 'youtube_automatic',
				'posts_per_page' 		=> -1,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,
				'meta_query' 			=> array(
												'relation' => 'AND',											
												array(
													'key' 		=> $this->prefix.'processing',
													'type'		=> 'CHAR',
													'value' 	=> 'yes',
													'compare' 	=> '!='
												)
											),
				'fields'          		=> 'ids',													
			);
			
			$at_query = get_posts($args_query);
			
			if(!is_wp_error($at_query) && is_array($at_query) && count($at_query) > 0){	
				print_r($at_query);						
				foreach($at_query as $auto_id){
					$this->beeteam368_youtube_automatic_import($auto_id);
				}
				echo esc_html__( time().' - DONE!!!', 'vidorev-extensions');
			}else{
				echo esc_html__( time().' - No Thing???', 'vidorev-extensions');
			}
		}
		
		public function save_auto($auto_id, $auto, $update){
			
			$post_type = get_post_type($auto_id);
			
			if($post_type != 'youtube_automatic' ){				
				return;
			}
			
			$processing = get_post_meta($auto_id, $this->prefix.'processing', true);
			$timestamp_update = get_post_meta($auto_id, $this->prefix.'timestamp_update', true);
			
			if($processing == ''){				
				update_post_meta($auto_id, $this->prefix.'processing', 'no');
			}
			
			if($timestamp_update == ''){
				update_post_meta($auto_id, $this->prefix.'timestamp_update', time());
				
			}elseif($timestamp_update !='' && is_numeric($timestamp_update)){								
				update_post_meta( $auto_id, $this->prefix.'timestamp_update', (time()+$this->get_update_time($auto_id)) );
			}
						
			$auto_data = array('ID' => $auto_id);	
					
			remove_action('save_post', array( $this, 'save_auto' ), 10, 3);
			wp_update_post($auto_data);
			add_action('save_post', array( $this, 'save_auto' ), 10, 3);
		}
		
		public function beeteam368_youtube_automatic_column_ID( $columns ) {
			$date = $columns['date'];
			unset($columns['date']);
			$columns['next_execution'] 	= esc_html__('Next Execution', 'vidorev-extensions');
			$columns['reset'] 			= esc_html__('Reset', 'vidorev-extensions');
			$columns['delete_posts'] 	= esc_html__('Delete Posts', 'vidorev-extensions');
			return $columns;
		}
		
		public function beeteam368_youtube_automatic_column_ID_value( $colname, $cptid ) {
			
			$renew_posts = get_post_meta($cptid, $this->prefix.'renew_posts', true);
			$processing  = get_post_meta($cptid, $this->prefix.'processing', true);				
			
			if ( $colname == 'next_execution' ){
				$youtube_source 	= trim(get_post_meta($cptid, $this->prefix.'youtube_source', true));				
				if($renew_posts == 'yes' || $processing == 'yes'){					
					if($renew_posts == 'yes'){
						echo '<div id="ya-execution-'.esc_attr($cptid).'">'.esc_html__('Disable', 'vidorev-extensions').'</div>';
					}elseif($processing == 'yes'){
						echo '<div id="ya-execution-'.esc_attr($cptid).'">'.esc_html__('Processing...', 'vidorev-extensions').'</div>';
					}
				}else{
					echo 	'<div id="ya-execution-'.esc_attr($cptid).'">
								<a href="javascript:;" data-id="'.esc_attr($cptid).'" class="youtube_automatic_execution button button-primary">'.esc_html__('Execute Now', 'vidorev-extensions').'</a>
								 &nbsp; 
								 <code class="youtube-execution-time">'.date_default_timezone_get().': '.gmdate('F jS, Y g:i:s a', get_post_meta($cptid, $this->prefix.'timestamp_update', true)).'</code>
							</div>		
							';
				}				
			}elseif($colname == 'reset' ){
				if($renew_posts == 'yes'){
					echo esc_html__('Disable', 'vidorev-extensions');
				}else{
					echo '<a href="javascript:;" data-id="'.esc_attr($cptid).'" class="youtube_automatic_reset button button-primary">'.esc_html__('Reset Time', 'vidorev-extensions').'</a>';
				}
			}elseif($colname == 'delete_posts' ){
								
				if($renew_posts == 'yes' || $processing == 'yes'){
					
					if($renew_posts == 'yes'){
						echo '<div id="delete-action-'.esc_attr($cptid).'">'.esc_html__('Processing...', 'vidorev-extensions').'</div>';
					}elseif($processing == 'yes'){
						echo '<div id="delete-action-'.esc_attr($cptid).'">'.esc_html__('Disable', 'vidorev-extensions').'</div>';
					}
										
				}else{
					echo '<div id="delete-action-'.esc_attr($cptid).'">';
						echo '<a href="javascript:;" data-id="'.esc_attr($cptid).'" class="youtube_automatic_delete_posts button button-primary">'.esc_html__('Delete Posts', 'vidorev-extensions').'</a>';
					
						$post_import = get_post_meta($cptid, $this->prefix.'post_import', true);
						if(is_array($post_import)){
							echo ' &nbsp; <code class="youtube-execution-time" data-post-number="'.$cptid.'">'.count($post_import).'</code> ';
						}else{
							echo ' &nbsp; <code class="youtube-execution-time" data-post-number="'.$cptid.'">0</code> ';
						}
						
						echo esc_html__('Posts', 'vidorev-extensions');
					echo '</div>';	
				}
			}
		}
		
		public function beeteam368_youtube_automatic_reset(){
			$json_params = array();
			
			if(!is_admin() || !isset($_POST['auto_id'])){
				$json_params['error'] = 'yes';
				wp_send_json($json_params);
				return;
				die();
			}
			
			$auto_id = $_POST['auto_id'];
			
			$new_time_update = time()+$this->get_update_time($auto_id); 
			
			update_post_meta( $auto_id, $this->prefix.'timestamp_update', $new_time_update );
			update_post_meta( $auto_id, $this->prefix.'processing', 'no' );
			
			$json_params['success'] = 	'<div id="ya-execution-'.esc_attr($auto_id).'">
											<a href="javascript:;" data-id="'.esc_attr($auto_id).'" class="youtube_automatic_execution button button-primary">'.esc_html__('Execute Now', 'vidorev-extensions').'</a>
											 &nbsp; 
											 <code class="youtube-execution-time">'.date_default_timezone_get().': '.gmdate('F jS, Y g:i:s a', $new_time_update).'</code>
										</div>		
										';
				
			$post_import = get_post_meta($auto_id, $this->prefix.'post_import', true);
			if(is_array($post_import)){
				$posts_count = ' &nbsp; <code class="youtube-execution-time" data-post-number="'.$auto_id.'">'.count($post_import).'</code> ';
			}else{
				$posts_count = ' &nbsp; <code class="youtube-execution-time" data-post-number="'.$auto_id.'">0</code> ';
			}
									
			$json_params['btn_delete'] = 	'<a href="javascript:;" data-id="'.esc_attr($auto_id).'" class="youtube_automatic_delete_posts button button-primary">'.esc_html__('Delete Posts', 'vidorev-extensions').'</a>'.$posts_count. esc_html__('Posts', 'vidorev-extensions');							
								
			wp_send_json($json_params);
			die();							
		}
		
		public function beeteam368_youtube_automatic_execution(){
			$json_params = array();
			
			if(!is_admin() || !isset($_POST['auto_id'])){
				$json_params['error'] = 'yes';
				wp_send_json($json_params);
				return;
				die();
			}
			
			$auto_id = $_POST['auto_id'];							
				
			update_post_meta( $auto_id, $this->prefix.'timestamp_update', time() );
			$this->beeteam368_youtube_automatic_import($auto_id);	
			
			$timestamp_update 		= get_post_meta($auto_id, $this->prefix.'timestamp_update', true);
			$json_params['success'] = '<div id="ya-execution-'.esc_attr($auto_id).'">
											<a href="javascript:;" data-id="'.esc_attr($auto_id).'" class="youtube_automatic_execution button button-primary">'.esc_html__('Execute Now', 'vidorev-extensions').'</a>
											 &nbsp; 
											 <code class="youtube-execution-time">'.date_default_timezone_get().': '.gmdate('F jS, Y g:i:s a', $timestamp_update).'</code>
										</div>		
										';
										
			$post_import = get_post_meta($auto_id, $this->prefix.'post_import', true);							
			$json_params['posts_count'] = (is_array($post_import))?count($post_import):0;
										
			wp_send_json($json_params);
			die();							
		}
		
		public function beeteam368_youtube_automatic_delete_posts(){
			$json_params = array();
			
			if(!is_admin() || !isset($_POST['auto_id'])){
				$json_params['error'] = 'yes';
				wp_send_json($json_params);
				return;
				die();
			}
			
			$auto_id = $_POST['auto_id'];			
			
			$renew_posts = get_post_meta($auto_id, $this->prefix.'renew_posts', true);
			
			if($renew_posts == 'yes'){
				$json_params['error'] = 'yes';
				wp_send_json($json_params);
				return;
				die();
			}
			
			$post_import 	= get_post_meta($auto_id, $this->prefix.'post_import', true);
			
			$old_import 	= get_post_meta($auto_id, $this->prefix.'old_import', true);
			if(!is_array($old_import) || count($old_import) == 0){
				$old_import = array();
			}
			
			if(is_array($post_import) && count($post_import) > 0){
				
				update_post_meta($auto_id, $this->prefix.'renew_posts', 'yes');
				
				foreach($post_import as $post_id){
					
					$beeteam368_youtube_automactic_id = get_post_meta($post_id, 'beeteam368_youtube_automactic_id', true);	
									
					wp_delete_post( $post_id, true);
					
					if (($key = array_search($post_id, $post_import)) !== false) {
						unset($post_import[$key]);
						update_post_meta($auto_id, $this->prefix.'post_import', $post_import);
					}
					
					if (($key = array_search($beeteam368_youtube_automactic_id, $old_import)) !== false) {
						unset($old_import[$key]);
						update_post_meta($auto_id, $this->prefix.'old_import', $old_import);
					}
				}
				
				update_post_meta($auto_id, $this->prefix.'renew_posts', 'no');				
			
			}
			
			update_post_meta($auto_id, $this->prefix.'post_import', array());				
			update_post_meta($auto_id, $this->prefix.'old_import', array());
			
			$json_params['success'] 	= 'ok';
			wp_send_json($json_params);
			die();
			
		}
		
		public function beeteam368_ya_wp_cron_activation(){
			if ( !wp_next_scheduled( 'beeteam368_youtube_automatic_wp_cron' ) ){
				wp_schedule_event( time(), 'twicedaily', 'beeteam368_youtube_automatic_wp_cron' );
			}
		}
		
		public function beeteam368_youtube_automatic_wp_cron(){
			$this->beeteam368_youtube_automatic_cron_job();
		}
		
		public function init(){
			add_action('save_post', array( $this, 'save_auto' ), 10, 3);	
			add_filter('manage_edit-youtube_automatic_columns', array( $this, 'beeteam368_youtube_automatic_column_ID' ));	
			add_action('manage_youtube_automatic_posts_custom_column',  array( $this, 'beeteam368_youtube_automatic_column_ID_value' ), 10, 2);
			
			add_action('wp_ajax_beeteam368_youtube_automatic_reset',  array( $this, 'beeteam368_youtube_automatic_reset') );
			add_action('wp_ajax_nopriv_beeteam368_youtube_automatic_reset',  array( $this, 'beeteam368_youtube_automatic_reset') );
			
			add_action('wp_ajax_beeteam368_youtube_automatic_execution',  array( $this, 'beeteam368_youtube_automatic_execution') );
			add_action('wp_ajax_nopriv_beeteam368_youtube_automatic_execution',  array( $this, 'beeteam368_youtube_automatic_execution') );
			
			add_action('wp_ajax_beeteam368_youtube_automatic_delete_posts',  array( $this, 'beeteam368_youtube_automatic_delete_posts') );
			add_action('wp_ajax_nopriv_beeteam368_youtube_automatic_delete_posts',  array( $this, 'beeteam368_youtube_automatic_delete_posts') );
			
			add_action('init', array( $this, 'beeteam368_ya_wp_cron_activation') );
			add_action('beeteam368_youtube_automatic_wp_cron', array( $this, 'beeteam368_youtube_automatic_wp_cron') );
		}
	}
	
	$beeteam368_youtube_automatic_hook = new beeteam368_youtube_automatic_action();
	$beeteam368_youtube_automatic_hook->init();

endif;