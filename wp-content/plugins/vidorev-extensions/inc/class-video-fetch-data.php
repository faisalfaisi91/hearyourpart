<?php
/**
*Automatic Data ( fetching data from video automatically )
*Supports: Youtube, Vimeo, Dailymotion, Twitch, Facebook
*Author: BeeTeam368
*Author URI: http://themeforest.net/user/beeteam368
*Version: 2.9.9.9.7.5
*License: Themeforest Licence
*License URI: http://themeforest.net/licenses
**/

if(!class_exists('vidorev_video_fetch_data')){
	class vidorev_video_fetch_data{
		
		private static function timeout(){
			return 368;
		}	
		
		private static function get_video_id_from_url($url = '', $regexes = array()){
			if($url == '' || !is_array($regexes)){
				return '';
			}
			
			foreach($regexes as $regex) {
				if(preg_match($regex, $url, $matches)) {
					return $matches[1];
				}
			}
			return '';
		}
		
		public static function getYoutubeID($url = ''){ //Youtube
			$regexes = array(
				'#(?:https?:)?//www\.youtube(?:\-nocookie)?\.com/(?:v|e|embed)/([A-Za-z0-9\-_]+)#', // Comprehensive search for both iFrame and old school embeds
				'#(?:https?(?:a|vh?)?://)?(?:www\.)?youtube(?:\-nocookie)?\.com/watch\?.*v=([A-Za-z0-9\-_]+)#', // Any YouTube URL. After http(s) support a or v for Youtube Lyte and v or vh for Smart Youtube plugin
				'#(?:https?(?:a|vh?)?://)?youtu\.be/([A-Za-z0-9\-_]+)#', // Any shortened youtu.be URL. After http(s) a or v for Youtube Lyte and v or vh for Smart Youtube plugin
				'#<div class="lyte" id="([A-Za-z0-9\-_]+)"#', // YouTube Lyte
				'#data-youtube-id="([A-Za-z0-9\-_]+)"#' // LazyYT.js
			);
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getYoutubePlaylistID($url = ''){ //Youtube Playlist
		
			$list 	= '';
			$string = parse_url($url); 
			if(isset($string['query'])){
				parse_str($string['query'], $q);
				$list 	= isset($q['list'])?$q['list']:'';
			}
			
			return $list;
		}
		
		public static function getVimeoID($url = ''){ //Vimeo
			$regexes = array(
				'#<object[^>]+>.+?http://vimeo\.com/moogaloop.swf\?clip_id=([A-Za-z0-9\-_]+)&.+?</object>#s', // Standard Vimeo embed code
				'#(?:https?:)?//player\.vimeo\.com/video/([0-9]+)#', // Vimeo iframe player
				'#\[vimeo id=([A-Za-z0-9\-_]+)]#', // JR_embed shortcode
				'#\[vimeo clip_id="([A-Za-z0-9\-_]+)"[^>]*]#', // Another shortcode
				'#\[vimeo video_id="([A-Za-z0-9\-_]+)"[^>]*]#', // Yet another shortcode
				'#(?:https?://)?(?:www\.)?vimeo\.com/([0-9]+)#', // Vimeo URL
				'#(?:https?://)?(?:www\.)?vimeo\.com/channels/(?:[A-Za-z0-9]+)/([0-9]+)#' // Channel URL
			);
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getDailymotionID($url = ''){ //Dailymotion
			$regexes = array(
				'#<object[^>]+>.+?http://www\.dailymotion\.com/swf/video/([A-Za-z0-9]+).+?</object>#s', // Dailymotion flash
				'#//www\.dailymotion\.com/embed/video/([A-Za-z0-9]+)#', // Dailymotion iframe
				'#(?:https?://)?(?:www\.)?dailymotion\.com/video/([A-Za-z0-9]+)#' // Dailymotion URL
			);
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getFacebookID($url = ''){ //Facebook
			$regexes = array(
				'~/videos/(?:t\.\d+/)?(\d+)~i',
				'#(?://|\%2F\%2F)(?:www\.)?facebook\.com(?:/|\%2F)(?:[a-zA-Z0-9]+)(?:/|\%2F)videos(?:/|\%2F)([0-9]+)#', // URL Embed
				'#http://www\.facebook\.com/v/([0-9]+)#', // Flash Embed
				'#https?://www\.facebook\.com/video/embed\?video_id=([0-9]+)#', // iFrame Embed
				'#https?://www\.facebook\.com/video\.php\?v=([0-9]+)#'
			);
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getTwitchID($url = ''){ //Twitch
			$regexes = array(
				'#(?:www\.)?twitch\.tv/(?:[A-Za-z0-9_]+)/v/([0-9]+)#', // Video URL
				'#(?:www\.)?twitch\.tv/(?:[A-Za-z0-9_]+)/c/([0-9]+)#', // Video URL
				'#(?:www\.)?twitch\.tv/(?:[A-Za-z0-9_]+)/([0-9]+)#', // Video URL
				'#(?:www\.)?twitch\.tv/(?:[A-Za-z0-9_]+)/video/([0-9]+)#', // Video URL
				'#<object[^>]+>.+?http://www\.twitch\.tv/widgets/archive_embed_player\.swf.+?chapter_id=([0-9]+).+?</object>#s', // Flash embed
				'#<object[^>]+>.+?http://www\.twitch\.tv/swflibs/TwitchPlayer\.swf.+?videoId=c([0-9]+).+?</object>#s', // Newer Flash embed
				'#(?:www\.)?twitch\.tv/([A-Za-z0-9_]+)#', // Video Channel URL
			);
			$return_id = self::get_video_id_from_url($url, $regexes);
			
			if($return_id!='' && !is_numeric($return_id)){
				return 'channel...?><[~|~]'.$return_id;
			}
			
			if($return_id==''){
				$split_url = explode('/', trim($url));
				if(count($split_url)>0){
					$count = count($split_url)-1;
					return 'channel...?><[~|~]'.$split_url[$count];
				}
				return '';
			}
			return $return_id;
		}
		
		public static function getDriveID($url = ''){
			$regexes = array(
				'#(?:https?://)?(?:www\.)?drive\.google\.com/file/d/([A-Za-z0-9\-_]+)#', //Video URL				
			);
			
			return self::get_video_id_from_url($url, $regexes);
		}
		
		public static function getVideoNetwork($url = ''){
			
			if($url == ''){
				return '';
			}
			
			$videoNetwork = '';
			
			if(strpos($url, 'youtube.com') || strpos($url, 'youtu.be')){
				$videoNetwork='youtube';
			}elseif(strpos($url, 'vimeo.com')){
				$videoNetwork='vimeo';
			}elseif(strpos($url, 'dailymotion.com') || strpos($url, 'dai.ly')){
				$videoNetwork='dailymotion';
			}elseif(strpos($url, 'facebook.com')){
				$videoNetwork='facebook';
			}elseif(strpos($url, 'twitch.tv')){
				$videoNetwork='twitch';
			}elseif(strpos($url, 'drive.google.com')){
				$videoNetwork='drive';	
			}elseif(preg_match('/<iframe/', $url) || preg_match('/<object/', $url) || preg_match('/<script/', $url)){
				$videoNetwork='embeded-code';
			}else{
				$videoNetwork='self-hosted';
			}
						
			return $videoNetwork;
		}
		
		public static function getVideoID($url = ''){
			
			if($url == ''){
				return '';
			}
			
			$videoID = '';
			$videoNetwork = self::getVideoNetwork($url);
			
			switch ($videoNetwork){
				case 'youtube':
					$videoID = self::getYoutubeID($url);
					break;
				case 'vimeo':
					$videoID = self::getVimeoID($url);
					break;
				case 'dailymotion':
					$videoID = self::getDailymotionID($url);
					break;
				case 'facebook':
					$videoID = self::getFacebookID($url);
					break;
				case 'twitch':
					$videoID = self::getTwitchID($url);
					break;
				case 'drive':					
					$videoID = self::getDriveID($url);
					break;					
			}
			
			return $videoID;
		}
		
		public static function covtime($youtube_time) {
			preg_match_all('/(\d+)/',$youtube_time,$parts);

			if (count($parts[0]) == 1) {
				array_unshift($parts[0], "0", "0");
			} elseif (count($parts[0]) == 2) {
				array_unshift($parts[0], "0");
			}
		
			$sec_init = $parts[0][2];
			$seconds = $sec_init%60;
			$seconds_overflow = floor($sec_init/60);
		
			$min_init = $parts[0][1] + $seconds_overflow;
			$minutes = ($min_init)%60;
			$minutes_overflow = floor(($min_init)/60);
		
			$hours = $parts[0][0] + $minutes_overflow;
			
			$minutes=(strlen($minutes)==1?('0'.$minutes):$minutes);
			$seconds=(strlen($seconds)==1?('0'.$seconds):$seconds);
			
			if($hours != 0){
				$hours=(strlen($hours)==1?('0'.$hours):$hours);
				return $hours.':'.$minutes.':'.$seconds;
			}else{				
				return $minutes.':'.$seconds;
			}
		}
		
		private static function construct_filename( $post_id ) {
			$filename = get_the_title( $post_id );
			$filename = sanitize_title( $filename, $post_id );
			$filename = urldecode( $filename );
			$filename = preg_replace( '/[^a-zA-Z0-9\-]/', '', $filename );
			$filename = substr( $filename, 0, 32 );
			$filename = trim( $filename, '-' );
			if ( $filename == '' ) $filename = (string) $post_id;
			return $filename;
		}
		
		private static function update_img($id = 0, $img_url = '', $img_name = ''){
			if($id == 0 || $img_url == ''){
				return;
			}
			
			$error 		= '';
			$post_id 	= $id;			
			$image_url  = $img_url;			
			
			$args = array(
				'timeout'     => self::timeout(),				
			); 
			$response = wp_remote_get( $image_url, $args );
			
			if( is_wp_error( $response ) ) {
				$error = new WP_Error( 'thumbnail_retrieval', sprintf( esc_html__( 'Error retrieving a thumbnail from the URL %1$s using wp_remote_get(). If opening that URL in your web browser returns anything else than an error page, the problem may be related to your web server and might be something your host administrator can solve.', 'vidorev-extensions'), $image_url ) . esc_html__( 'Error Details:', 'vidorev-extensions') . ' ' . $response->get_error_message() );
			} else {
				$image_contents = $response['body'];
				$image_type = wp_remote_retrieve_header( $response, 'content-type' );
			}
	
			if ( $error != '' ) {
				return $error;
			} else {
	
				if ( $image_type == 'image/jpeg' ) {
					$image_extension = '.jpg';
				} elseif ( $image_type == 'image/png' ) {
					$image_extension = '.png';
				} elseif ( $image_type == 'image/gif' ) {
					$image_extension = '.gif';
				} else {
					return new WP_Error( 'thumbnail_upload', esc_html__( 'Unsupported MIME type:', 'vidorev-extensions') . ' ' . $image_type );
				}
	
				$new_filename = self::construct_filename( $post_id ) . $image_extension;
				
				$upload = wp_upload_bits( $new_filename, null, $image_contents );
	
				if ( $upload['error'] ) {
					$error = new WP_Error( 'thumbnail_upload', esc_html__( 'Error uploading image data:', 'vidorev-extensions') . ' ' . $upload['error'] );
					return $error;
				} else {
		
					$wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );
	
					$upload = apply_filters( 'wp_handle_upload', array(
						'file' => $upload['file'],
						'url'  => $upload['url'],
						'type' => $wp_filetype['type']
					), 'sideload' );
	
					$attachment = array(
						'post_mime_type'	=> $upload['type'],
						'post_title'		=> get_the_title( $post_id ),
						'post_content'		=> '',
						'post_status'		=> 'inherit'
					);
					
					$attach_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );
					require_once( ABSPATH . 'wp-admin/includes/image.php' );
					$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
					wp_update_attachment_metadata( $attach_id, $attach_data );	
					set_post_thumbnail( $post_id, $attach_id );
	
				}
	
			}
	
			return $attach_id;
		}
		
		private static function fetch_youtube($id = ''){
			if($id == ''){
				return '';
			}
			$google_api_key = trim(vidorev_get_redux_option('google_api_key', ''));
			if(isset($_POST['auto_fetch_extensions_api_key']) && $_POST['auto_fetch_extensions_api_key']!=''){
				$google_api_key= trim($_POST['auto_fetch_extensions_api_key']);
			}
			$args = array(
				'timeout'     => self::timeout(),				
			);
			$response = wp_remote_get('https://www.googleapis.com/youtube/v3/videos?id='.$id.'&key='.$google_api_key.'&part=snippet,contentDetails,statistics', $args);
			if(is_wp_error($response)){
				global $beeteam36_youtube_fetch_err;
				$beeteam36_youtube_fetch_err = 'yes';
				return '';
			}else {
				$result = json_decode($response['body']);
				if((isset($result->{'error'}) && $result->{'error'}!='') || (isset($result->{'pageInfo'}) && $result->{'pageInfo'}->{'totalResults'}==0)){
					global $beeteam36_youtube_fetch_err;
					$beeteam36_youtube_fetch_err = 'yes';
					return '';
				}
			}
						
			$params = array('vd_post_title' => '', 'vd_post_description' => '', 'vd_post_duration' => '', 'vd_post_tags' => '', 'vd_post_viewcount' => '', 'vd_post_likecount' => '', 'vd_post_dislikecount' => '', 'vd_post_commentcount' => '', 'vd_post_img' => '');
			
			$params['vd_post_title'] 		= $result->{'items'}[0]->{'snippet'}->{'title'};
			$params['vd_post_description'] 	= $result->{'items'}[0]->{'snippet'}->{'description'};
			$params['vd_post_duration'] 	= self::covtime($result->{'items'}[0]->{'contentDetails'}->{'duration'});
			
			if(isset($result->{'items'}[0]->{'snippet'}->{'tags'})){
				$vd_post_tags = implode(',', $result->{'items'}[0]->{'snippet'}->{'tags'});
			}else{
				$vd_post_tags = array();
			}
			$params['vd_post_tags'] 		= $vd_post_tags;
			
			$params['vd_post_viewcount'] 	= $result->{'items'}[0]->{'statistics'}->{'viewCount'};
			$params['vd_post_likecount'] 	= $result->{'items'}[0]->{'statistics'}->{'likeCount'};
			$params['vd_post_dislikecount'] = $result->{'items'}[0]->{'statistics'}->{'dislikeCount'};
			
			if(isset($result->{'items'}[0]->{'statistics'}->{'commentCount'})){
				$vd_post_commentcount = $result->{'items'}[0]->{'statistics'}->{'commentCount'};
			}else{
				$vd_post_commentcount = 0;
			}
			$params['vd_post_commentcount'] = $vd_post_commentcount;
						
			if(isset($result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'maxres'})){
				$params['vd_post_img']	= $result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'maxres'}->{'url'};
			}else if(isset($result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'standard'})){
				$params['vd_post_img']	= $result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'standard'}->{'url'};
			}else if(isset($result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'high'})){
				$params['vd_post_img']	= $result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'high'}->{'url'};
			}else if(isset($result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'medium'})){
				$params['vd_post_img']	= $result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'medium'}->{'url'};
			}else if(isset($result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'default'})){
				$params['vd_post_img']	= $result->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'default'}->{'url'};
			}else{
				$params['vd_post_img'] = '';
			}
			
			return $params;
		} 
		
		private static function get_full_vimeo_img($url = ''){
			if($url!=''){
				$url_explode = explode('_', $url);
				if(is_array($url_explode) && count($url_explode) == 2){
					$url_extension = explode('.', $url_explode[1]); 
					if(is_array($url_extension) && count($url_extension) == 2){
						$full_img_url = $url_explode[0].'.'.$url_extension[1];
						
						$check_img_exists = wp_remote_get( $full_img_url, array('timeout' => self::timeout()) );
			
						if( is_wp_error( $check_img_exists ) ) {
							return '';
						} else {
							return $full_img_url;
						}
					}
				}
			}
			
			return '';		
		}
		
		private static function fetch_vimeo($id = ''){
			if($id == ''){
				return '';
			}
			$args = array(
				'timeout'     => self::timeout(),				
			);
			
			$client_id = vidorev_get_redux_option('vimeo_client_identifier', '');						
			$client_secret = vidorev_get_redux_option('vimeo_client_secrets', '');
			$access_token = vidorev_get_redux_option('vimeo_personal_access_tokens', '');			
						
			$config = array('client_id'=>$client_id, 'client_secret'=>$client_secret, 'access_token'=>$access_token);
			
			$response = wp_remote_get('http://vimeo.com/api/v2/video/'.$id.'.json', $args);
			if(is_wp_error($response)){
				return '';
			}else {
				$result = json_decode($response['body']);
			}
			
			$params = array('vd_post_title' => '', 'vd_post_description' => '', 'vd_post_duration' => '', 'vd_post_tags' => '', 'vd_post_viewcount' => '', 'vd_post_likecount' => '', 'vd_post_dislikecount' => '', 'vd_post_commentcount' => '', 'vd_post_img' => '');
			
			if($result=='1' || !is_array($result) || is_wp_error($result[0]->{'duration'}) || (isset($result[0]->{'error'}) && $result[0]->{'error'}!='')){
				if(isset($config['client_id']) && isset($config['client_secret']) && isset($config['access_token']) && $config['client_id']!='' && $config['client_secret']!='' && $config['access_token']!='' && defined('VPE_VER') && defined('VPE_PLUGIN_URL')){
					$lib = new \Vimeo\Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
					//get data vimeo video
					$me = $lib->request('/me/videos/'.$id);					
					if(is_wp_error($me)){
						return '';
					}else {
						$result = $me["body"];
						
						if(isset($result['error']) && $result['error']!=''){
							return '';
						}
						
						$tags = array();
						foreach($result['tags'] as $tag){
							array_push($tags, trim($tag['name']));
						}
												
						$params['vd_post_title'] 		= $result['name'];
						$params['vd_post_description'] 	= $result['description'];
						$params['vd_post_duration'] 	= gmdate("H:i:s", $result['duration']);
						$params['vd_post_tags'] 		= implode(',', $tags);
						$params['vd_post_viewcount'] 	= $result['stats']['plays'];
						$params['vd_post_likecount'] 	= $result['metadata']['connections']['likes']['total'];
						$params['vd_post_commentcount']	= $result['metadata']['connections']['comments']['total'];
						
						if( isset($result['pictures']['sizes'][6]) ){
							$params['vd_post_img']	= $result['pictures']['sizes'][6]['link'];							
						}elseif( isset($result['pictures']['sizes'][5]) ){
							$params['vd_post_img']	= $result['pictures']['sizes'][5]['link'];
						}else if( isset($result['pictures']['sizes'][4]) ){
							$params['vd_post_img']	= $result['pictures']['sizes'][4]['link'];
						}else if( isset($result['pictures']['sizes'][3]) ){
							$params['vd_post_img']	= $result['pictures']['sizes'][3]['link'];
						}else if( isset($result['pictures']['sizes'][2]) ){
							$params['vd_post_img']	= $result['pictures']['sizes'][2]['link'];
						}else if( isset($result['pictures']['sizes'][1]) ){
							$params['vd_post_img']	= $result['pictures']['sizes'][1]['link'];
						}else if( isset($result['pictures']['sizes'][0]) ){
							$params['vd_post_img']	= $result['pictures']['sizes'][0]['link'];
						}else{
							$params['vd_post_img'] = '';
						}
						
						/*$full_img = self::get_full_vimeo_img($params['vd_post_img']);
						if($full_img!=''){
							$params['vd_post_img'] = $full_img;
						}*/
						
						return $params;
					}
				}else{
					return '';
				}
			}
			
			$params['vd_post_title'] 		= $result[0]->{'title'};
			$params['vd_post_description'] 	= $result[0]->{'description'};
			$params['vd_post_duration'] 	= gmdate("H:i:s", $result[0]->{'duration'});
			$params['vd_post_tags'] 		= $result[0]->{'tags'};
			$params['vd_post_viewcount'] 	= $result[0]->{'stats_number_of_plays'};
			$params['vd_post_likecount'] 	= $result[0]->{'stats_number_of_likes'};
			$params['vd_post_commentcount']	= $result[0]->{'stats_number_of_comments'};
			$params['vd_post_img']			= $result[0]->{'thumbnail_large'};
			
			if(isset($result[0]->{'thumbnail_large'})){
				$params['vd_post_img']	= $result[0]->{'thumbnail_large'};
			}else if(isset($result[0]->{'thumbnail_medium'})){
				$params['vd_post_img']	= $result[0]->{'thumbnail_medium'};
			}else if(isset($result[0]->{'thumbnail_small'})){
				$params['vd_post_img']	= $result[0]->{'thumbnail_small'};
			}else{
				$params['vd_post_img'] = '';
			}	
			
			$full_img = self::get_full_vimeo_img($params['vd_post_img']);
			if($full_img!=''){
				$params['vd_post_img'] = $full_img;
			}
			
			return $params;
		} 
		
		private static function fetch_dailymotion($id = ''){
			if($id == ''){
				return '';
			}
			$args = array(
				'timeout'     => self::timeout(),				
			); 
			$response = wp_remote_get('https://api.dailymotion.com/video/'.$id.'?fields=title,description,duration,views_total,tags,comments_total,thumbnail_url,thumbnail_1080_url,thumbnail_720_url,thumbnail_480_url,thumbnail_360_url,thumbnail_240_url,thumbnail_180_url,thumbnail_120_url,thumbnail_60_url', $args);
			if(is_wp_error($response)){				
				return '';
			}else {
				$result = json_decode($response['body']);
				if(isset($result->{'error'}) && $result->{'error'}!=''){
					return '';
				}				
			}
						
			$params = array('vd_post_title' => '', 'vd_post_description' => '', 'vd_post_duration' => '', 'vd_post_tags' => '', 'vd_post_viewcount' => '', 'vd_post_likecount' => '', 'vd_post_dislikecount' => '', 'vd_post_commentcount' => '', 'vd_post_img' => '');
			
			$params['vd_post_title'] 		= $result->{'title'};
			$params['vd_post_description'] 	= $result->{'description'};
			$params['vd_post_duration'] 	= gmdate("H:i:s", $result->{'duration'});
			$params['vd_post_tags'] 		= implode(',', $result->{'tags'});
			$params['vd_post_viewcount'] 	= $result->{'views_total'};
			$params['vd_post_commentcount'] = $result->{'comments_total'};
			
			if( isset($result->{'thumbnail_1080_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_1080_url'};
				
			}else if( isset($result->{'thumbnail_720_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_720_url'};
				
			}else if( isset($result->{'thumbnail_480_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_480_url'};
				
			}else if( isset($result->{'thumbnail_360_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_360_url'};
				
			}else if( isset($result->{'thumbnail_240_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_240_url'};
				
			}else if( isset($result->{'thumbnail_180_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_180_url'};
				
			}else if( isset($result->{'thumbnail_120_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_120_url'};
				
			}else if( isset($result->{'thumbnail_60_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_60_url'};
				
			}else if( isset($result->{'thumbnail_url'}) ){
				$params['vd_post_img']	= $result->{'thumbnail_url'};
				
			}else{
				$params['vd_post_img'] = '';
			}
			
			return $params;
		}
		
		private static function fetch_twitch($id = ''){
			if($id == ''){
				return '';
			}
			
			$elements = explode('channel...?><[~|~]', $id);
			$twitch_client_id = vidorev_get_redux_option('twitch_client_id', '');
			$params = array('vd_post_title' => '', 'vd_post_description' => '', 'vd_post_duration' => '', 'vd_post_tags' => '', 'vd_post_viewcount' => '', 'vd_post_likecount' => '', 'vd_post_dislikecount' => '', 'vd_post_commentcount' => '', 'vd_post_img' => '');	
			
			if(count($elements)==1){
				$args = array(
					'timeout'     => self::timeout(),
					'headers'     => array('Client-ID' => $twitch_client_id),
				); 
				
				$response = wp_remote_get('https://api.twitch.tv/helix/videos?id='.$id, $args);
				
				if(is_wp_error($response)){
					return '';
				}else {
					$result = json_decode($response['body']);
					if(isset($result->{'error'}) && $result->{'error'}!=''){
						return '';
					}
				}
				
				if(!isset($result->{'data'}) || !is_array($result->{'data'}) || count($result->{'data'})<1){
					return '';
				}
				
				$twitch_data = $result->{'data'}[0];
				
				$params['vd_post_title'] 		= $twitch_data->{'title'};
				$params['vd_post_description'] 	= $twitch_data->{'description'};
				$params['vd_post_duration'] 	= self::convertTimeTwitch($twitch_data->{'duration'});
				$params['vd_post_viewcount'] 	= $twitch_data->{'view_count'};
				
				if( isset($twitch_data->{'thumbnail_url'}) ){
					$params['vd_post_img']	= str_replace('%{width}x%{height}', '1920x1080', $twitch_data->{'thumbnail_url'});
				}else{
					$params['vd_post_img']	= '';
				}
				
				return $params;	
				
			}else{				
				$channel_id = $elements[1];
				
				$args = array(
					'timeout'     => self::timeout(),
					'headers'     => array('Client-ID' => $twitch_client_id),
				); 
				$response = wp_remote_get('https://api.twitch.tv/helix/streams?user_login='.$channel_id, $args);
				
				if(is_wp_error($response)){
					return '';
				}else {
					$result = json_decode($response['body']);
					if(isset($result->{'error'}) && $result->{'error'}!=''){
						return '';
					}
				}
				
				if(!isset($result->{'data'}) || !is_array($result->{'data'}) || count($result->{'data'})<1){
					return '';
				}
				
				$twitch_data = $result->{'data'}[0];
				
				$params['vd_post_title'] 		= $twitch_data->{'title'};
				$params['vd_post_viewcount'] 	= $twitch_data->{'viewer_count'};
				
				if( isset($twitch_data->{'thumbnail_url'}) ){
					$params['vd_post_img']	= str_replace('{width}x{height}', '1920x1080', $twitch_data->{'thumbnail_url'});
				}else{
					$params['vd_post_img']	= '';
				}
								
				return $params;
			}
			return '';
		}
		
		private static function fetch_facebook($id = ''){
			if($id == ''){
				return '';
			}
			
			$args = array(
				'timeout'     => self::timeout(),
			); 
			
			$facebook_app_id = vidorev_get_redux_option('facebook_app_id', '');
			$facebook_app_secret = vidorev_get_redux_option('facebook_app_secret', '');
			
			$request_topken = wp_remote_get('https://graph.facebook.com/oauth/access_token?client_id='.$facebook_app_id.'&client_secret='.$facebook_app_secret.'&grant_type=client_credentials', $args);			
			if(is_wp_error($request_topken)){
				return '';
			}else{
				$topken = json_decode($request_topken['body']);
				if(isset($topken->{'error'}) && $topken->{'error'}!=''){					
					return '';
				}
			}			
			
			$response = wp_remote_get('https://graph.facebook.com/v3.2/'.$id.'?access_token='.$topken->{'access_token'}.'&fields=title,description,length,format,comments.limit(1).summary(true),likes.limit(1).summary(true)', $args);
			
			if(is_wp_error($response)){
				return '';
			}else {
				$result = json_decode($response['body']);
				if(isset($result->{'error'}) && $result->{'error'}!=''){
					return '';
				}
			}		
			
			$params = array('vd_post_title' => '', 'vd_post_description' => '', 'vd_post_duration' => '', 'vd_post_tags' => '', 'vd_post_viewcount' => '', 'vd_post_likecount' => '', 'vd_post_dislikecount' => '', 'vd_post_commentcount' => '', 'vd_post_img' => '');
			
			$params['vd_post_title'] 		= isset($result->{'title'})?$result->{'title'}:'';
			$params['vd_post_description'] 	= isset($result->{'description'})?$result->{'description'}:'';
			$params['vd_post_duration'] 	= isset($result->{'length'})?gmdate("H:i:s", $result->{'length'}):'';
			$params['vd_post_likecount'] 	= isset($result->{'likes'})?$result->{'likes'}->{'summary'}->{'total_count'}:0;
			$params['vd_post_commentcount']	= isset($result->{'comments'})?$result->{'comments'}->{'summary'}->{'total_count'}:0;
			
			/*
			if( isset($result->{'thumbnails'}) ){
				$params['vd_post_img']	= $result->{'thumbnails'}->{'data'}[0]->{'uri'};
			}else{
				$params['vd_post_img']	= '';
			}
			*/			
			
			if( isset($result->{'format'}) ){
				$f_thumb = $result->{'format'};
				$params['vd_post_img']	= $f_thumb[count($f_thumb)-1]->{'picture'};
			}else{
				$params['vd_post_img']	= '';
			}
			
			return $params;		
		}
		
		private static function fetch_drive($id = ''){
			if($id == ''){
				return '';
			}
			
			$args = array(
				'timeout'     => self::timeout(),
			); 
			
			$google_api_key = trim(vidorev_get_redux_option('google_api_key', ''));
			$response 		= wp_remote_get('https://www.googleapis.com/drive/v2/files/'.$id.'?key='.$google_api_key, $args);
			
			if(is_wp_error($response)){
				return '';
			}else {
				$result = json_decode($response['body']);
				if(isset($result->{'error'}) || !isset($result->{'videoMediaMetadata'})){
					return '';
				}
			}
			
			
			
			$params = array('vd_post_title' => '', 'vd_post_description' => '', 'vd_post_duration' => '', 'vd_post_tags' => '', 'vd_post_viewcount' => '', 'vd_post_likecount' => '', 'vd_post_dislikecount' => '', 'vd_post_commentcount' => '', 'vd_post_img' => '');
			
			$params['vd_post_title'] 		= isset($result->{'title'})?$result->{'title'}:'';
			$params['vd_post_duration'] 	= isset($result->{'videoMediaMetadata'}->{'durationMillis'})?date("H:i:s", (((int)$result->{'videoMediaMetadata'}->{'durationMillis'})/1000)):'';
			$params['vd_post_img'] 			= isset($result->{'thumbnailLink'})?str_replace('=s220', '=s2560', $result->{'thumbnailLink'}):'';
			
			return $params;		
		}
		
		private static function getData($url = ''){
			if($url == ''){
				return '';
			}
			
			$id = self::getVideoID($url);
			$network = self::getVideoNetwork($url);
			
			switch($network){
				case 'youtube': 	
					return self::fetch_youtube($id);
					break;
				case 'vimeo': 		
					return self::fetch_vimeo($id);
					break;
				case 'dailymotion': 
					return self::fetch_dailymotion($id);	
					break;			
				case 'twitch': 		
					return self::fetch_twitch($id);
					break;
				case 'facebook': 		
					return self::fetch_facebook($id);
					break;
				case 'drive': 		
					return self::fetch_drive($id);
					break;		
				default: 			
					return '';
			}
		}
		
		private static function convertTimeTwitch($time = ''){
			if($time==''){
				return '';
			}
			
			$time = str_replace(array('h', 'm', 's'), array(':', ':', ''), $time);
			$time = explode(':', $time);
			
			$hours = 0; $mins = 0; $secs = 0;			
			if(count($time) == 3){
				$hours = (strlen($time[0])==1?('0'.$time[0]):$time[0]); 
				$mins = (strlen($time[1])==1?('0'.$time[1]):$time[1]); 
				$secs = (strlen($time[2])==1?('0'.$time[2]):$time[2]); 
				return $hours.':'.$mins.':'.$secs;
			}
			if(count($time) == 2){
				$mins = (strlen($time[0])==1?('0'.$time[0]):$time[0]); 
				$secs = (strlen($time[1])==1?('0'.$time[1]):$time[1]); 
				return $mins.':'.$secs;
			}			
			if(count($time) == 1){
				$mins = '00'; 
				$secs = (strlen($time[0])==1?('0'.$time[0]):$time[0]); 
				return $mins.':'.$secs;
			}
			
			return '';
		}
		
		private static function convertTime($time = ''){
			if($time==''){
				return '';
			}
			
			$time = explode(':', $time);
			
			if(count($time)<2){
				return '';
			}
			
			$hours = 0; $mins = 0; $secs = 0;			
			if(count($time) == 3){
				$hours = $time[0]; 
				$mins = $time[1]; 
				$secs = $time[2];
				if(!is_numeric($hours) || !is_numeric($mins) || !is_numeric($secs)){
					return '';
				}
			}
			if(count($time) == 2) {
				$mins = $time[0]; 
				$secs = $time[1];
				if(!is_numeric($mins) || !is_numeric($secs)){
					return '';
				}
			}
			
			return $hours * 3600 + $mins * 60 + $secs;
		}
		
		public static function savePost($post_id, $post, $update){
			
			$is_df_request = true;
			if(is_object($post_id)){
				$post_id = $post_id->ID;
				$is_df_request = false;
			}
			
			global $wpdb;
			
			$input_url 				= 'vm_video_url';
			$input_duration 		= 'vm_duration';
			$input_duration_ts 		= 'vm_duration_ts';
			$input_view_count 		= 'vm_view_count';
			$input_like_count 		= 'vm_like_count';
			$input_dislike_count 	= 'vm_dislike_count';			
			$input_comment_count 	= 'vm_comment_count';
			$checkbox_autoFetch 	= 'vm_video_fetch';
			
			do_action('beeteam368_create_thumbnails_for_video_admin_upload', $post_id);
			
			if(isset($_POST['vid_m_vid_tmdb_movie']) && is_array($_POST['vid_m_vid_tmdb_movie'])){
				$arr_movie_data = array();
				$tmdb_api_key 	= apply_filters('beeteam368_tmdb_movie_api_key', '6f2a688b4bd7ca287e759544a0198ecd');
				$tmdb_language 	= apply_filters('beeteam368_tmdb_movie_language', 'en-US');
				
				foreach($_POST['vid_m_vid_tmdb_movie'] as $movie_item){
					if(is_numeric($movie_item)){
						$response_movie 	= wp_remote_get('https://api.themoviedb.org/3/movie/'.$movie_item.'?api_key='.$tmdb_api_key.'&language='.$tmdb_language.'&append_to_response=trailers', array('timeout' => self::timeout()) );
						$response_credits 	= wp_remote_get('https://api.themoviedb.org/3/movie/'.$movie_item.'/credits?api_key='.$tmdb_api_key.'&language='.$tmdb_language, array('timeout' => self::timeout()) );
						
						if($tmdb_language!='en-US'){
							$response_movie_en_us = wp_remote_get('https://api.themoviedb.org/3/movie/'.$movie_item.'?api_key='.$tmdb_api_key.'&language=en-US&append_to_response=trailers', array('timeout' => self::timeout()) );
						}
						
						if(!is_wp_error($response_movie) && !is_wp_error($response_credits)){
							
							$response_movie_body 	= json_decode($response_movie['body']);
							$response_credits_body 	= json_decode($response_credits['body']);
							
							if(isset($response_movie_en_us)){
								$response_movie_body_en_us = json_decode($response_movie_en_us['body']);
								$arr_movie_data[] = array('movie_details'=> $response_movie_body, 'movie_credits'=> $response_credits_body, 'movie_details_en_us'=> $response_movie_body_en_us);
							}else{
								$arr_movie_data[] = array('movie_details'=> $response_movie_body, 'movie_credits'=> $response_credits_body);
							}	
							
							$use_data_tmdb = $response_movie_body;
							if(isset($response_movie_body_en_us)){
								$use_data_tmdb_en_us = $response_movie_body_en_us;
							}							
							
							if(!isset($_POST['vid_m_imdb_ratings']) || trim($_POST['vid_m_imdb_ratings'])==''){
								if(isset($use_data_tmdb->{'imdb_id'}) && $use_data_tmdb->{'imdb_id'}!=''){								
									$_POST['vid_m_imdb_ratings'] = $use_data_tmdb->{'imdb_id'};
								}
							}
							
							if(!isset($_POST['vid_m_vid_tmdb_thumb']) || trim($_POST['vid_m_vid_tmdb_thumb'])=='poster_sizes' || trim($_POST['vid_m_vid_tmdb_thumb'])=='backdrop_sizes'){
								
								$tmdb_original_title = isset($use_data_tmdb->{'original_title'})&&$use_data_tmdb->{'original_title'}!=''?$use_data_tmdb->{'original_title'}:'';
								
								/*
									"backdrop_sizes": [
									  "w300",
									  "w780",
									  "w1280",
									  "original"
									],
									"logo_sizes": [
									  "w45",
									  "w92",
									  "w154",
									  "w185",
									  "w300",
									  "w500",
									  "original"
									],
									"poster_sizes": [
									  "w92",
									  "w154",
									  "w185",
									  "w342",
									  "w500",
									  "w780",
									  "original"
									],
									"profile_sizes": [
									  "w45",
									  "w185",
									  "h632",
									  "original"
									],
									"still_sizes": [
									  "w92",
									  "w185",
									  "w300",
									  "original"
									]
								*/
								
								switch(trim($_POST['vid_m_vid_tmdb_thumb'])){
									case 'poster_sizes':
										if(isset($use_data_tmdb->{'poster_path'}) && $use_data_tmdb->{'poster_path'}!=''){
											$tmdb_thumb_imp = 'https://image.tmdb.org/t/p/w780'.$use_data_tmdb->{'poster_path'};
										}elseif(isset($use_data_tmdb_en_us) && isset($use_data_tmdb_en_us->{'poster_path'}) && $use_data_tmdb_en_us->{'poster_path'}!=''){
											$tmdb_thumb_imp = 'https://image.tmdb.org/t/p/w780'.$use_data_tmdb_en_us->{'poster_path'};
										}
										break;
										
									case 'backdrop_sizes':
										if(isset($use_data_tmdb->{'backdrop_path'}) && $use_data_tmdb->{'backdrop_path'}!=''){
											$tmdb_thumb_imp = 'https://image.tmdb.org/t/p/w1280'.$use_data_tmdb->{'backdrop_path'};
										}elseif(isset($use_data_tmdb_en_us) && isset($use_data_tmdb_en_us->{'backdrop_path'}) && $use_data_tmdb_en_us->{'backdrop_path'}!=''){
											$tmdb_thumb_imp = 'https://image.tmdb.org/t/p/w1280'.$use_data_tmdb_en_us->{'backdrop_path'};
										}
										break;	
								}
								
								if(isset($tmdb_thumb_imp) && $tmdb_thumb_imp!=''){
									if(!has_post_thumbnail( $post_id )){
										self::update_img($post_id, $tmdb_thumb_imp, $tmdb_original_title );
									}
								}
								
							}
						}
					}
				}
				
				update_post_meta($post_id, 'beeteam368_tmdb_data', $arr_movie_data);
			}else{
				update_post_meta($post_id, 'beeteam368_tmdb_data', '');
			}
			
			if(isset($_POST['vid_m_vid_tmdb_tv_shows']) && is_array($_POST['vid_m_vid_tmdb_tv_shows'])){
				$arr_tv_data 	= array();
				$tmdb_api_key 	= apply_filters('beeteam368_tmdb_movie_api_key', '6f2a688b4bd7ca287e759544a0198ecd');
				$tmdb_language 	= apply_filters('beeteam368_tmdb_movie_language', 'en-US');
				
				foreach($_POST['vid_m_vid_tmdb_tv_shows'] as $tv_item){
					if(is_numeric($tv_item)){
						$response_tvshows 			= wp_remote_get('https://api.themoviedb.org/3/tv/'.$tv_item.'?api_key='.$tmdb_api_key.'&language='.$tmdb_language.'&append_to_response=trailers', array('timeout' => self::timeout()) );
						$response_tvshows_credits 	= wp_remote_get('https://api.themoviedb.org/3/tv/'.$tv_item.'/credits?api_key='.$tmdb_api_key.'&language='.$tmdb_language, array('timeout' => self::timeout()) );
						
						if(!is_wp_error($response_tvshows) && !is_wp_error($response_tvshows_credits)){
							
							$response_tvshows_body 			= json_decode($response_tvshows['body']);
							$response_tvshows_credits_body 	= json_decode($response_tvshows_credits['body']);
							
							$arr_tv_data[] = array('tv_details'=> $response_tvshows_body, 'tv_credits'=> $response_tvshows_credits_body);
							
							if(!isset($_POST['vid_m_vid_tmdb_thumb']) || trim($_POST['vid_m_vid_tmdb_thumb'])=='poster_sizes_tv' || trim($_POST['vid_m_vid_tmdb_thumb'])=='backdrop_sizes_tv'){
								$tmdb_tv_name = isset($response_tvshows_body->{'name'})&&$response_tvshows_body->{'name'}!=''?$response_tvshows_body->{'name'}:'';
								
								switch(trim($_POST['vid_m_vid_tmdb_thumb'])){
									case 'poster_sizes_tv':
										
										if(isset($response_tvshows_body->{'poster_path'}) && $response_tvshows_body->{'poster_path'}!=''){
											$tmdb_thumb_imp_tv = 'https://image.tmdb.org/t/p/w780'.$response_tvshows_body->{'poster_path'};
										}
										
										break;
										
									case 'backdrop_sizes_tv':
										
										if(isset($response_tvshows_body->{'backdrop_path'}) && $response_tvshows_body->{'backdrop_path'}!=''){
											$tmdb_thumb_imp_tv = 'https://image.tmdb.org/t/p/w1280'.$response_tvshows_body->{'backdrop_path'};
										}
										
										break;	
								}
								
								if(isset($tmdb_thumb_imp_tv) && $tmdb_thumb_imp_tv!=''){
									if(!has_post_thumbnail( $post_id )){
										self::update_img($post_id, $tmdb_thumb_imp_tv, $tmdb_tv_name );
									}
								}
							}
						}
					}
				}
				
				update_post_meta($post_id, 'beeteam368_tmdb_tv_data', $arr_tv_data);
				
			}else{
				update_post_meta($post_id, 'beeteam368_tmdb_tv_data', '');
			}
			
			if(isset($_POST['vid_m_imdb_ratings'])){				
				$imdb_user 		= trim(vidorev_get_redux_option('imdb_user', ''));
				$imdb_ratings 	= trim($_POST['vid_m_imdb_ratings']);
				
				if($imdb_user!='' && $imdb_ratings!=''){
					$response = wp_remote_get('http://p.media-imdb.com/static-content/documents/v1/title/'.$imdb_ratings.'/ratings%3Fjsonp=imdb.rating.run:imdb.api.title.ratings/data.json?u='.$imdb_user, array('timeout' => self::timeout()) );
					if(!is_wp_error($response)){
						$str_find_r = ['imdb.rating.run(', ')'];
						$str_repl_r = ['', ''];
						$result = json_decode(str_replace($str_find_r, $str_repl_r, trim($response['body'])));
						$resource = array('id'=>'', 'rating'=>'');
						if(isset($result->{'resource'})){
							if(isset($result->{'resource'}->{'id'})){
								$resource['id'] = $result->{'resource'}->{'id'};
							}
							if(isset($result->{'resource'}->{'rating'})){
								$resource['rating'] = $result->{'resource'}->{'rating'};
							}
						}
						update_post_meta($post_id, 'beeteam368_imdb_data', json_encode($resource));
					}
				}
			}
			
			if(defined('YOUTUBE_LIVE_VIDEO_PREFIX') && isset($_POST['vid_lv_channel_id'])){
				
				$live_channel_vid_url = trim($_POST['vid_lv_channel_id']);
				$live_channel_vid_api = isset($_POST['vid_lv_sub_api_key'])?trim($_POST['vid_lv_sub_api_key']):'';
				if($live_channel_vid_api==''){
					$live_channel_vid_api = trim(vidorev_get_redux_option('google_api_key', ''));
				}
				
				if(strpos($live_channel_vid_url, '/user/')){

					$idString 	= substr($live_channel_vid_url, strrpos($live_channel_vid_url,'/user/') + 6);										
					if($idString != '' && $live_channel_vid_api!=''){
						$id_explode = explode('/', $idString);
						
						$response_lv = wp_remote_get('https://www.googleapis.com/youtube/v3/channels?key='.$live_channel_vid_api.'&forUsername='.$id_explode[0].'&part=snippet&maxResults=1', array('timeout'=>368));
												
						if(!is_wp_error($response_lv)){														
							$result_lv = json_decode($response_lv['body']);
							if((isset($result_lv->{'error'}) && $result_lv->{'error'}!='') || (isset($result_lv->{'pageInfo'}) && $result_lv->{'pageInfo'}->{'totalResults'}==0)){	
								/*error no data*/
							}else{
								if( isset($result_lv->{'items'}) && count($result_lv->{'items'})>0 && isset($result_lv->{'items'}[0]) && isset($result_lv->{'items'}[0]->{'id'}) ){
									update_post_meta($post_id, YOUTUBE_LIVE_VIDEO_PREFIX.'det_channel_id', $result_lv->{'items'}[0]->{'id'});
								}
							}
						}
						
					}
					
				}elseif(strpos($live_channel_vid_url, '/channel/')){					
					$idString 	= substr($live_channel_vid_url, strrpos($live_channel_vid_url,'/channel/') + 9);										
					if($idString != ''){						
						$id_explode = explode('/', $idString);						
						update_post_meta($post_id, YOUTUBE_LIVE_VIDEO_PREFIX.'det_channel_id', $id_explode[0]);
					}
					
				}
			}
			
			if(isset($_POST['vm_fake_views']) || isset($_POST['vm_fake_likes']) || isset($_POST['vm_fake_dislikes'])){
				$where 		= ' WHERE user_id = %d AND post_id = %d AND ip = %s';
				$datetime 	= date( 'Y-m-d H:i:s' );
							
				if(isset($_POST['vm_fake_likes']) && trim($_POST['vm_fake_likes'])!='' && is_numeric($_POST['vm_fake_likes'])){
					update_post_meta($post_id, $input_like_count, trim($_POST['vm_fake_likes']));
					if(function_exists('vidorev_already_voted_fetch')){
						$has_voted = vidorev_already_voted_fetch($post_id, 'like');
						if(is_numeric($has_voted)){
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
												value = '".trim($_POST['vm_fake_likes'])."',
												date_time = '" . $datetime . "'
												".$where,
												0, $post_id, 'like'
											)
										);
						}else{
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
												post_id = %d, value = '".trim($_POST['vm_fake_likes'])."',
												date_time = '" . $datetime . "',
												user_id = %d, ip = %s",
												$post_id, 0, 'like'
											)
										);					
						}
					}
				}
							
				if(isset($_POST['vm_fake_dislikes']) && trim($_POST['vm_fake_dislikes'])!='' && is_numeric($_POST['vm_fake_dislikes'])){
					update_post_meta($post_id, $input_dislike_count, trim($_POST['vm_fake_dislikes']));
					if(function_exists('vidorev_already_voted_fetch')){
						$has_voted = vidorev_already_voted_fetch($post_id, 'dislike');
						if(is_numeric($has_voted)){
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
												value = '-".trim($_POST['vm_fake_dislikes'])."',
												date_time = '" . $datetime . "'
												".$where,
												0, $post_id, 'dislike'
											)
										);
						}else{
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
												post_id = %d, value = '-".trim($_POST['vm_fake_dislikes'])."',
												date_time = '" . $datetime . "',
												user_id = %d, ip = %s",
												$post_id, '0', 'dislike'
											)
										);					
						}
					}
				}
				
				if(isset($_POST['vm_fake_views']) && trim($_POST['vm_fake_views'])!='' && is_numeric($_POST['vm_fake_views'])){
					
					if(class_exists('Post_Views_Counter')){	
						$_POST['post_views'] = trim($_POST['vm_fake_views']);					
						$success_view = $wpdb->query(
							$wpdb->prepare( "
								INSERT INTO " . $wpdb->prefix . "post_views (id, type, period, count)
								VALUES (%d, %d, %s, %d)
								ON DUPLICATE KEY UPDATE count = %d", $post_id, 4, 'total', trim($_POST['vm_fake_views']), trim($_POST['vm_fake_views'])
							)
						);
					}			
					
					update_post_meta($post_id, $input_view_count, trim($_POST['vm_fake_views']));
				}
			}
			
			$v_post_type = get_post_type($post_id);
			
			if($v_post_type=='vid_channel' && !metadata_exists( 'post', $post_id, 'vidorev_channel_sub_count' )){				
				update_post_meta($post_id, 'vidorev_channel_sub_count', 0);
			}
			
			if(defined('CHANNEL_PM_PREFIX') && $v_post_type=='vid_channel' && isset($_POST[CHANNEL_PM_PREFIX.'videos'])){				
				$videos_in = $_POST[CHANNEL_PM_PREFIX.'videos'];
				if($videos_in!=''){
					$videos_in = explode(',', $videos_in);
				}else{
					$videos_in = array();
				}
				if(is_array($videos_in)){
					foreach($videos_in as $video_id){
						$current_channels = get_post_meta($video_id, CHANNEL_PM_PREFIX.'sync_channel', true);
						if(is_array($current_channels) && ($izc = array_search($post_id, $current_channels)) === FALSE){
							array_push($current_channels, $post_id);
							update_post_meta($video_id, CHANNEL_PM_PREFIX.'sync_channel', $current_channels);
						}else{
							update_post_meta($video_id, CHANNEL_PM_PREFIX.'sync_channel', array($post_id));
						}
					}
				}
			}
			
			if($v_post_type!='post' || wp_is_post_revision($post_id) || get_post_format($post_id)!='video'){
				
				if($v_post_type == 'vid_playlist' || $v_post_type == 'vid_channel'){
					switch($v_post_type){
						case 'vid_playlist':
							$vidorev_submit_id = get_post_meta($post_id, 'playlist_submit_id', true);	
							break;
							
						case 'vid_channel':
							$vidorev_submit_id = get_post_meta($post_id, 'channel_submit_id', true);
							break;
					}
					
					if(isset($vidorev_submit_id) && $vidorev_submit_id!='' && is_numeric($vidorev_submit_id)){
						wp_update_post(array(
							'ID'    		=>  $vidorev_submit_id,
							'post_status'   =>  get_post_status( $post_id )
						));
					}
				}
				
				return;
			}
			
			$vidorev_submit_id = get_post_meta($post_id, 'vidorev_submit_id', true);
			if($vidorev_submit_id!='' && is_numeric($vidorev_submit_id)){
				wp_update_post(array(
					'ID'    		=>  $vidorev_submit_id,
					'post_status'   =>  get_post_status( $post_id )
				));
			}
			
			if(defined('PLAYLIST_PM_PREFIX') && isset($_POST[PLAYLIST_PM_PREFIX.'sync_playlist'])){
								
				$old_playlists = get_post_meta($post_id, PLAYLIST_PM_PREFIX.'sync_playlist', true);
				if(is_array($old_playlists) && count($old_playlists)>0){
					foreach($old_playlists as $playlist_id){
						$playlist_videos = get_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', true);
						if(is_array($playlist_videos) && ($i = array_search($post_id, $playlist_videos)) !== FALSE){
							unset($playlist_videos[$i]);
							update_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', array_map('strval', $playlist_videos));
						}
					}
				}
				
				if( is_array($_POST[PLAYLIST_PM_PREFIX.'sync_playlist']) ){
					foreach($_POST[PLAYLIST_PM_PREFIX.'sync_playlist'] as $playlist_id){
						$playlist_videos = get_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', true);
						if(is_array($playlist_videos)){						
							if( ($iz = array_search($post_id, $playlist_videos)) === FALSE ){
								array_push($playlist_videos, $post_id);
								update_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', array_map('strval', $playlist_videos));							
							}
						}else{
							update_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', array_map('strval', array($post_id)));
						}
					}
				}
				
				update_post_meta($post_id, PLAYLIST_PM_PREFIX.'sync_playlist', $_POST[PLAYLIST_PM_PREFIX.'sync_playlist']);
				
			}else{
				if(defined('PLAYLIST_PM_PREFIX') && isset($_POST['beeteam368_check_playlist_manual']) && $_POST['beeteam368_check_playlist_manual'] == 'postupdate'){
					$old_playlists = get_post_meta($post_id, PLAYLIST_PM_PREFIX.'sync_playlist', true);
					if(is_array($old_playlists) && count($old_playlists)>0){
						foreach($old_playlists as $playlist_id){
							$playlist_videos = get_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', true);
							if(is_array($playlist_videos) && ($i = array_search($post_id, $playlist_videos)) !== FALSE){
								unset($playlist_videos[$i]);
								update_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', array_map('strval', $playlist_videos));
							}
						}
					}
					
					update_post_meta($post_id, PLAYLIST_PM_PREFIX.'sync_playlist', '');
				}
			}
			
			if(defined('CHANNEL_PM_PREFIX') && isset($_POST[CHANNEL_PM_PREFIX.'sync_channel'])){
				
				$old_channels = get_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', true);
				if(is_array($old_channels) && count($old_channels)>0){
					foreach($old_channels as $channel_id){
						$channel_videos = get_post_meta($channel_id, CHANNEL_PM_PREFIX.'videos', true);
						if(is_array($channel_videos) && ($i = array_search($post_id, $channel_videos)) !== FALSE){
							unset($channel_videos[$i]);
							update_post_meta($channel_id, CHANNEL_PM_PREFIX.'videos', array_map('strval', $channel_videos));
						}
					}
				}
				
				if( is_array($_POST[CHANNEL_PM_PREFIX.'sync_channel']) ){
					foreach($_POST[CHANNEL_PM_PREFIX.'sync_channel'] as $channel_id){
						$channel_videos = get_post_meta($channel_id, CHANNEL_PM_PREFIX.'videos', true);
						if(is_array($channel_videos)){						
							if( ($iz = array_search($post_id, $channel_videos)) === FALSE ){
								array_push($channel_videos, $post_id);
								update_post_meta($channel_id, CHANNEL_PM_PREFIX.'videos', array_map('strval', $channel_videos));							
							}
						}else{
							update_post_meta($channel_id, CHANNEL_PM_PREFIX.'videos', array_map('strval', array($post_id)));
						}
					}				
				}
				
				update_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', $_POST[CHANNEL_PM_PREFIX.'sync_channel']);
				
			}else{
				if(defined('CHANNEL_PM_PREFIX') && isset($_POST['beeteam368_check_channel_manual']) && $_POST['beeteam368_check_channel_manual'] == 'postupdate'){
					$old_channels = get_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', true);
					if(is_array($old_channels) && count($old_channels)>0){
						foreach($old_channels as $channel_id){
							$channel_videos = get_post_meta($channel_id, CHANNEL_PM_PREFIX.'videos', true);
							if(is_array($channel_videos) && ($i = array_search($post_id, $channel_videos)) !== FALSE){
								unset($channel_videos[$i]);
								update_post_meta($channel_id, CHANNEL_PM_PREFIX.'videos', array_map('strval', $channel_videos));
							}
						}
					}
					
					update_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', '');
				}
			}
			
			/*auto fetch radio*/
			if(isset($_POST[$checkbox_autoFetch])){
				$auto_fetch_data = trim($_POST[$checkbox_autoFetch]);
			}else{
				if(!$is_df_request){					
					add_action('rest_after_insert_post', array(__CLASS__, 'savePost'), 2, 2);
					return;
				}else{
					if(isset($_POST['vidorev-submit-post-id']) || isset($_POST['vidorev-submit-user-login'])){
						$auto_fetch_data = trim(vidorev_get_option('auto_fetch_nt', 'user_submit_settings', 'on'));
					}elseif(isset($_POST['auto_fetch_extensions'])){
						$auto_fetch_data = $_POST['auto_fetch_extensions'];
					}else{
						return;
					}
				}				
			}					
			
			if(!isset($auto_fetch_data) || $auto_fetch_data != 'on'){ 				
				return;				
			}/*auto fetch radio*/
			
			/*video url*/
			if(isset($_POST[$input_url])){
				$video_url = trim($_POST[$input_url]);				
			}
			
			if(!isset($video_url) || $video_url==''){
				$video_url = trim(get_post_meta($post_id, $input_url, true));
			}
			
			if(!isset($video_url) || $video_url==''){ 				
				return;
			}/*video url*/
			
			$fetch_data = self::getData($video_url);
			if(!isset($fetch_data) || !is_array($fetch_data) || $fetch_data==''){
				return;
			}
			
			$post_data = array('ID' => $post_id);
			
			$fetch_title 		= vidorev_get_redux_option('fetch_video_title', 'on', 'switch');					
			$fetch_description 	= vidorev_get_redux_option('fetch_video_description', 'on', 'switch');			
			$fetch_tags 		= vidorev_get_redux_option('fetch_video_tags', 'off', 'switch');			
			$fetch_duration 	= vidorev_get_redux_option('fetch_video_duration', 'on', 'switch');			
			$fetch_view 		= vidorev_get_redux_option('fetch_video_view_count', 'on', 'switch');			
			$fetch_like 		= vidorev_get_redux_option('fetch_video_like_count', 'on', 'switch');			
			$fetch_dislike 		= vidorev_get_redux_option('fetch_video_dislike_count', 'on', 'switch');			
			$fetch_comment 		= vidorev_get_redux_option('fetch_video_comment_count', 'on', 'switch');
			$fetch_thumbnail	= vidorev_get_redux_option('fetch_video_thumbnail', 'on', 'switch');			
						
			if($fetch_title=='on'){
				$post_data['post_title'] =  $fetch_data['vd_post_title'];
				$post_data['post_name'] =  $fetch_data['vd_post_title'];
			}
			
			if($fetch_description=='on'){
				$post_data['post_content'] =  $fetch_data['vd_post_description'];
			}
			
			if($fetch_tags=='on'){
				$tag_array = explode(',', $fetch_data['vd_post_tags']);
				wp_set_object_terms($post_id, $tag_array, 'post_tag', true);
			}
			
			if($fetch_duration=='on'){
				if(!isset($_POST[$input_duration]) || trim($_POST[$input_duration])==''){
					$_POST[$input_duration] = $fetch_data['vd_post_duration'];
					update_post_meta($post_id, $input_duration, $fetch_data['vd_post_duration']);					
					update_post_meta($post_id, $input_duration_ts, self::convertTime($fetch_data['vd_post_duration']));					
				}else{
					$current_post_duration = trim(get_post_meta($post_id, $input_duration, true));
					if($current_post_duration == ''){
						update_post_meta($post_id, $input_duration, $fetch_data['vd_post_duration']);
					}
					update_post_meta($post_id, $input_duration_ts, self::convertTime(trim($_POST[$input_duration])));					
				}
			}
			
			if($fetch_view=='on'){
				
				$current_view_post = trim(get_post_meta($post_id, $input_view_count, true));
				
				if(class_exists('Post_Views_Counter')){					
					$total_view_post	= (float)pvc_get_post_views($post_id);	
					
					if(is_numeric($current_view_post) && ($total_view_post>=(float)$current_view_post)){
						$new_view_post = $total_view_post + (float)$fetch_data['vd_post_viewcount'] - (float)$current_view_post;
					}else{						
						$new_view_post = $total_view_post + (float)$fetch_data['vd_post_viewcount'];
					}
					
					$_POST['post_views'] = $new_view_post;					
					
					$success_view = $wpdb->query(
						$wpdb->prepare( "
							INSERT INTO " . $wpdb->prefix . "post_views (id, type, period, count)
							VALUES (%d, %d, %s, %d)
							ON DUPLICATE KEY UPDATE count = %d", $post_id, 4, 'total', $new_view_post, $new_view_post
						)
					);
				}			
				
				update_post_meta($post_id, $input_view_count, $fetch_data['vd_post_viewcount']);
			}
			
			$where 		= ' WHERE user_id = %d AND post_id = %d AND ip = %s';
			$datetime 	= date( 'Y-m-d H:i:s' );
			
			$original_ip_add = function_exists('vidorev_get_ip')?vidorev_get_ip():rand();
			$fake_ip_add = implode(':', str_split(md5(rand().$original_ip_add), 4));
						
			if($fetch_like=='on'){
				update_post_meta($post_id, $input_like_count, $fetch_data['vd_post_likecount']);
				if(function_exists('vidorev_already_voted_fetch')){
					
					$current_likes = vidorev_get_like_count_full($post_id);

					if(is_numeric($fetch_data['vd_post_likecount']) && (int)$fetch_data['vd_post_likecount']>$current_likes){
						$new_likes_number = (int)$fetch_data['vd_post_likecount'] - $current_likes;
					}
					
					$has_voted = vidorev_already_voted_fetch($post_id, 'l'.$fake_ip_add);
					
					if(isset($new_likes_number)){
					
						if(is_numeric($has_voted)){
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
												value = '".$new_likes_number."',
												date_time = '" . $datetime . "'
												".$where,
												0, $post_id, 'l'.$fake_ip_add
											)
										);
						}else{
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
												post_id = %d, value = '".$new_likes_number."',
												date_time = '" . $datetime . "',
												user_id = %d, ip = %s",
												$post_id, 0, 'l'.$fake_ip_add
											)
										);					
						}
					
					}
				}
			}
						
			if($fetch_dislike=='on'){
				update_post_meta($post_id, $input_dislike_count, $fetch_data['vd_post_dislikecount']);
				if(function_exists('vidorev_already_voted_fetch')){
					
					$current_dislikes = vidorev_get_dislike_count_full($post_id);
					
					if(is_numeric($fetch_data['vd_post_dislikecount']) && (int)$fetch_data['vd_post_dislikecount']>$current_dislikes){
						$new_dislikes_number = (int)$fetch_data['vd_post_dislikecount'] - $current_dislikes;
					}
					
					$has_voted = vidorev_already_voted_fetch($post_id, 'd'.$fake_ip_add);
					
					if(isset($new_dislikes_number)){
					
						if(is_numeric($has_voted)){
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
												value = '-".$new_dislikes_number."',
												date_time = '" . $datetime . "'
												".$where,
												0, $post_id, 'd'.$fake_ip_add
											)
										);
						}else{
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
												post_id = %d, value = '-".$new_dislikes_number."',
												date_time = '" . $datetime . "',
												user_id = %d, ip = %s",
												$post_id, '0', 'd'.$fake_ip_add
											)
										);					
						}
						
					}
				}
			}
						
			if($fetch_comment=='on'){
				update_post_meta($post_id, $input_comment_count, $fetch_data['vd_post_commentcount']);
			}	
			
			if(!has_post_thumbnail( $post_id ) && $fetch_thumbnail=='on'){
				self::update_img($post_id, $fetch_data['vd_post_img'], $fetch_data['vd_post_title']);
			}
			
			do_action('beeteam368_create_thumbnails_for_video_admin_upload_after', $post_id);
			
			if(!$is_df_request){
				remove_action('rest_after_insert_post', array(__CLASS__, 'savePost'), 2, 2);
			}else{
				remove_action('save_post', array(__CLASS__, 'savePost'), 1, 3);
				wp_update_post($post_data);
				add_action('save_post', array(__CLASS__, 'savePost'), 1, 3);
			}			
		}
		
		public static function autoGetDataFromClient(){
			
			if(!is_single()){
				return;
			}
			
			$post_id = get_the_ID();
			
			if(get_post_type($post_id)!='post' || wp_is_post_revision($post_id) || get_post_format($post_id)!='video'){				
				return;
			}
			
			global $wpdb;
			
			$input_url 				= 'vm_video_url';
			$input_view_count 		= 'vm_view_count';
			$input_like_count 		= 'vm_like_count';
			$input_dislike_count 	= 'vm_dislike_count';
			$checkbox_autoFetch 	= 'vm_video_fetch';
			
			/*auto fetch radio*/			
			$auto_fetch_data = trim(get_post_meta($post_id, $checkbox_autoFetch, true));
			if($auto_fetch_data == '') $auto_fetch_data = 'on';
			if(!isset($auto_fetch_data) || $auto_fetch_data != 'on'){
				return;				
			}/*auto fetch radio*/

				
			$imdb_user 		= trim(vidorev_get_redux_option('imdb_user', ''));
			$imdb_ratings 	= trim(get_post_meta($post_id, 'vid_m_imdb_ratings', true));
			
			if($imdb_user!='' && $imdb_ratings!=''){
				$response = wp_remote_get('http://p.media-imdb.com/static-content/documents/v1/title/'.$imdb_ratings.'/ratings%3Fjsonp=imdb.rating.run:imdb.api.title.ratings/data.json?u='.$imdb_user, array('timeout' => self::timeout()) );
				if(!is_wp_error($response)){					
					$str_find_r = ['imdb.rating.run(', ')'];
					$str_repl_r = ['', ''];
					$result = json_decode(str_replace($str_find_r, $str_repl_r, trim($response['body'])));
					$resource = array('id'=>'', 'rating'=>'');
					if(isset($result->{'resource'})){
						if(isset($result->{'resource'}->{'id'})){
							$resource['id'] = $result->{'resource'}->{'id'};
						}
						if(isset($result->{'resource'}->{'rating'})){
							$resource['rating'] = $result->{'resource'}->{'rating'};
						}
					}
					update_post_meta($post_id, 'beeteam368_imdb_data', json_encode($resource));
				}
			}
			
			$fetch_video_when_accessing = vidorev_get_redux_option('fetch_video_when_accessing', 'off', 'switch');
			if($fetch_video_when_accessing=='off'){
				return;
			}	
			
			/*video url*/
			$video_url = trim(get_post_meta($post_id, $input_url, true));
			if(!isset($video_url) || $video_url==''){ 				
				return;
			}/*video url*/
			
			$fetch_data = self::getData($video_url);
			if(!isset($fetch_data) || !is_array($fetch_data) || $fetch_data==''){
				return;
			}	
						
			$fetch_view 		= vidorev_get_redux_option('fetch_video_view_count', 'on', 'switch');			
			$fetch_like 		= vidorev_get_redux_option('fetch_video_like_count', 'on', 'switch');			
			$fetch_dislike 		= vidorev_get_redux_option('fetch_video_dislike_count', 'on', 'switch');	
			
			$where 		= ' WHERE user_id = %d AND post_id = %d AND ip = %s';
			$datetime 	= date( 'Y-m-d H:i:s' );
			
			$original_ip_add = function_exists('vidorev_get_ip')?vidorev_get_ip():rand();
			$fake_ip_add = implode(':', str_split(md5(rand().$original_ip_add), 4));
						
			if($fetch_like=='on'){
				update_post_meta($post_id, $input_like_count, $fetch_data['vd_post_likecount']);
				if(function_exists('vidorev_already_voted_fetch')){
					
					$current_likes = vidorev_get_like_count_full($post_id);
					
					if(is_numeric($fetch_data['vd_post_likecount']) && (int)$fetch_data['vd_post_likecount']>$current_likes){
						$new_likes_number = (int)$fetch_data['vd_post_likecount'] - $current_likes;
					}
					
					$has_voted = vidorev_already_voted_fetch($post_id, 'l'.$fake_ip_add);
					
					if(isset($new_likes_number)){
						
						if(is_numeric($has_voted)){
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
												value = '".$new_likes_number."',
												date_time = '" . $datetime . "'
												".$where,
												0, $post_id, 'l'.$fake_ip_add
											)
										);
						}else{
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
												post_id = %d, value = '".$new_likes_number."',
												date_time = '" . $datetime . "',
												user_id = %d, ip = %s",
												$post_id, 0, 'l'.$fake_ip_add
											)
										);					
						}
						
					}
				}
			}
						
			if($fetch_dislike=='on'){
				update_post_meta($post_id, $input_dislike_count, $fetch_data['vd_post_dislikecount']);
				if(function_exists('vidorev_already_voted_fetch')){
					
					$current_dislikes = vidorev_get_dislike_count_full($post_id);
					
					if(is_numeric($fetch_data['vd_post_dislikecount']) && (int)$fetch_data['vd_post_dislikecount']>$current_dislikes){
						$new_dislikes_number = (int)$fetch_data['vd_post_dislikecount'] - $current_dislikes;
					}					
					
					$has_voted = vidorev_already_voted_fetch($post_id, 'd'.$fake_ip_add);
					
					if(isset($new_dislikes_number)){
					
						if(is_numeric($has_voted)){
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
												value = '-".$new_dislikes_number."',
												date_time = '" . $datetime . "'
												".$where,
												0, $post_id, 'd'.$fake_ip_add
											)
										);
						}else{
							$success = 	$wpdb->query(
											$wpdb->prepare(
												"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
												post_id = %d, value = '-".$new_dislikes_number."',
												date_time = '" . $datetime . "',
												user_id = %d, ip = %s",
												$post_id, '0', 'd'.$fake_ip_add
											)
										);					
						}
						
					}
				}
			}
			
			if($fetch_view=='on'){
				
				$current_view_post = trim(get_post_meta($post_id, $input_view_count, true));
				
				if(class_exists('Post_Views_Counter')){					
					$total_view_post	= (float)pvc_get_post_views($post_id);	
					
					if(is_numeric($current_view_post) && ($total_view_post>=(float)$current_view_post)){
						$new_view_post = $total_view_post + (float)$fetch_data['vd_post_viewcount'] - (float)$current_view_post;
					}else{						
						$new_view_post = $total_view_post + (float)$fetch_data['vd_post_viewcount'];
					}			
					
					$success_view = $wpdb->query(
						$wpdb->prepare( "
							INSERT INTO " . $wpdb->prefix . "post_views (id, type, period, count)
							VALUES (%d, %d, %s, %d)
							ON DUPLICATE KEY UPDATE count = %d", $post_id, 4, 'total', $new_view_post, $new_view_post
						)
					);
				}			
				
				update_post_meta($post_id, $input_view_count, $fetch_data['vd_post_viewcount']);
			}
			
		}
		
		public static function autoGetDataFromTRDPARTY($meta_id, $post_id, $meta_key, $meta_value){	
		
			if ( (function_exists('wp_automatic_admin_scripts') || function_exists('yvtwp_load_plugin') || defined('WPVR_ID') || class_exists( 'Video_Blogster_Engine' )) && 'vm_sync_import_playlist' == $meta_key && defined('PLAYLIST_PM_PREFIX')) {
								
				$vm_sync_import_playlist = trim(get_post_meta($post_id, 'vm_sync_import_playlist', true));				
				if($vm_sync_import_playlist!=''){
					$vm_sync_import_playlist_arr = explode(',', $vm_sync_import_playlist);
					$arr_sync_update_meta_playlist = array();
					foreach($vm_sync_import_playlist_arr as $playlist_item){
						$playlist_item = trim($playlist_item);
						if(is_numeric($playlist_item) && $playlist_item > 0){
							array_push($arr_sync_update_meta_playlist, $playlist_item);
							
							$videos_in = get_post_meta($playlist_item, PLAYLIST_PM_PREFIX.'videos', true);					
							if(is_array($videos_in)){
								if(($izp = array_search($post_id, $videos_in)) === FALSE){
									array_push($videos_in, $post_id);
									update_post_meta($playlist_item, PLAYLIST_PM_PREFIX.'videos', array_map('strval', $videos_in));
								}
							}else{
								update_post_meta($playlist_item, PLAYLIST_PM_PREFIX.'videos', array_map('strval', array($post_id)));
							}
														
						}
					}
					
					if(count($arr_sync_update_meta_playlist)>0){
						update_post_meta($post_id, PLAYLIST_PM_PREFIX.'sync_playlist', $arr_sync_update_meta_playlist);
					}
				}
				
			}
			
			if ( (function_exists('wp_automatic_admin_scripts') || function_exists('yvtwp_load_plugin') || defined('WPVR_ID') || class_exists( 'Video_Blogster_Engine' )) && 'vm_sync_import_channel' == $meta_key && defined('CHANNEL_PM_PREFIX')) {
				
				$vm_sync_import_channel = trim(get_post_meta($post_id, 'vm_sync_import_channel', true));
				if($vm_sync_import_channel!=''){
					$vm_sync_import_channel_arr = explode(',', $vm_sync_import_channel);
					$arr_sync_update_meta_channel = array();
					foreach($vm_sync_import_channel_arr as $channel_item){
						$channel_item = trim($channel_item);						
						if(is_numeric($channel_item) && $channel_item > 0){
							array_push($arr_sync_update_meta_channel, $channel_item);
							
							$videos_in = get_post_meta($channel_item, CHANNEL_PM_PREFIX.'videos', true);					
							if(is_array($videos_in)){
								if(($izc = array_search($post_id, $videos_in)) === FALSE){
									array_push($videos_in, $post_id);
									update_post_meta($channel_item, CHANNEL_PM_PREFIX.'videos', array_map('strval', $videos_in));
								}
							}else{
								update_post_meta($channel_item, CHANNEL_PM_PREFIX.'videos', array_map('strval', array($post_id)));
							}
						}
					}
					
					if(count($arr_sync_update_meta_channel)>0){
						update_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', $arr_sync_update_meta_channel);
					}
				}
				
			}		

			if ( (function_exists('wp_automatic_admin_scripts') || function_exists('yvtwp_load_plugin') || defined('WPVR_ID') || class_exists( 'Video_Blogster_Engine' )) && 'vm_video_url' == $meta_key) {	
			
				global $wpdb;
				
				$input_url 				= 'vm_video_url';
				$input_view_count 		= 'vm_view_count';
				$input_like_count 		= 'vm_like_count';
				$input_dislike_count 	= 'vm_dislike_count';
				$checkbox_autoFetch 	= 'vm_video_fetch';							
				
				$video_url = trim(get_post_meta($post_id, $input_url, true));
				if(!isset($video_url) || $video_url==''){									
					return;
				}
				
				$fetch_data = self::getData($video_url);
				if(!isset($fetch_data) || !is_array($fetch_data) || $fetch_data==''){
					return;
				}
							
				$fetch_view 		= vidorev_get_redux_option('fetch_video_view_count', 'on', 'switch');			
				$fetch_like 		= vidorev_get_redux_option('fetch_video_like_count', 'on', 'switch');			
				$fetch_dislike 		= vidorev_get_redux_option('fetch_video_dislike_count', 'on', 'switch');	
				
				$where 		= ' WHERE user_id = %d AND post_id = %d AND ip = %s';
				$datetime 	= date( 'Y-m-d H:i:s' );
				
				$original_ip_add = function_exists('vidorev_get_ip')?vidorev_get_ip():rand();
				$fake_ip_add = implode(':', str_split(md5(rand().$original_ip_add), 4));			
				
							
				if($fetch_like=='on'){
					update_post_meta($post_id, $input_like_count, $fetch_data['vd_post_likecount']);
					if(function_exists('vidorev_already_voted_fetch')){
						
						$current_likes = vidorev_get_like_count_full($post_id);
						
						if(is_numeric($fetch_data['vd_post_likecount']) && (int)$fetch_data['vd_post_likecount']>$current_likes){
							$new_likes_number = (int)$fetch_data['vd_post_likecount'] - $current_likes;
						}
						
						$has_voted = vidorev_already_voted_fetch($post_id, 'l'.$fake_ip_add);
						
						if(isset($new_likes_number)){
							
							if(is_numeric($has_voted)){
								$success = 	$wpdb->query(
												$wpdb->prepare(
													"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
													value = '".$new_likes_number."',
													date_time = '" . $datetime . "'
													".$where,
													0, $post_id, 'l'.$fake_ip_add
												)
											);
							}else{
								$success = 	$wpdb->query(
												$wpdb->prepare(
													"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
													post_id = %d, value = '".$new_likes_number."',
													date_time = '" . $datetime . "',
													user_id = %d, ip = %s",
													$post_id, 0, 'l'.$fake_ip_add
												)
											);					
							}
							
						}
					}
				}
							
				if($fetch_dislike=='on'){
					update_post_meta($post_id, $input_dislike_count, $fetch_data['vd_post_dislikecount']);
					if(function_exists('vidorev_already_voted_fetch')){
						
						$current_dislikes = vidorev_get_dislike_count_full($post_id);
						
						if(is_numeric($fetch_data['vd_post_dislikecount']) && (int)$fetch_data['vd_post_dislikecount']>$current_dislikes){
							$new_dislikes_number = (int)$fetch_data['vd_post_dislikecount'] - $current_dislikes;
						}					
						
						$has_voted = vidorev_already_voted_fetch($post_id, 'd'.$fake_ip_add);
						
						if(isset($new_dislikes_number)){
						
							if(is_numeric($has_voted)){
								$success = 	$wpdb->query(
												$wpdb->prepare(
													"UPDATE {$wpdb->prefix}vpe_like_dislike SET 
													value = '-".$new_dislikes_number."',
													date_time = '" . $datetime . "'
													".$where,
													0, $post_id, 'd'.$fake_ip_add
												)
											);
							}else{
								$success = 	$wpdb->query(
												$wpdb->prepare(
													"INSERT INTO {$wpdb->prefix}vpe_like_dislike SET 
													post_id = %d, value = '-".$new_dislikes_number."',
													date_time = '" . $datetime . "',
													user_id = %d, ip = %s",
													$post_id, '0', 'd'.$fake_ip_add
												)
											);					
							}
							
						}
					}
				}
				
				if($fetch_view=='on'){
					
					$current_view_post = trim(get_post_meta($post_id, $input_view_count, true));
					
					if(class_exists('Post_Views_Counter')){					
						$total_view_post	= (float)pvc_get_post_views($post_id);	
						
						if(is_numeric($current_view_post) && ($total_view_post>=(float)$current_view_post)){
							$new_view_post = $total_view_post + (float)$fetch_data['vd_post_viewcount'] - (float)$current_view_post;
						}else{						
							$new_view_post = $total_view_post + (float)$fetch_data['vd_post_viewcount'];
						}			
						
						$success_view = $wpdb->query(
							$wpdb->prepare( "
								INSERT INTO " . $wpdb->prefix . "post_views (id, type, period, count)
								VALUES (%d, %d, %s, %d)
								ON DUPLICATE KEY UPDATE count = %d", $post_id, 4, 'total', $new_view_post, $new_view_post
							)
						);
					}			
					
					update_post_meta($post_id, $input_view_count, $fetch_data['vd_post_viewcount']);					
				}

			}
			
		}		
		
		public static function vidorev_wpvr_tfvrv_add_theme_meta( $dataFillers_meta, $post_meta, $post_id ) {
			global $wpvr_options;
			
			/*No video ID found, it means not an imported video*/
			if ( ! isset( $post_meta['wpvr_video_id'] ) || ! isset( $post_meta['wpvr_video_views'] ) ) {
				return $dataFillers_meta;
			}
			
			if(isset($post_meta['wpvr_video_service_url']) && isset($post_meta['wpvr_video_service_url'][0])){
				update_post_meta($post_id, 'vm_video_url', str_replace( 'http://', 'https://', $post_meta['wpvr_video_service_url'][0] ));
			}
			
			if(isset($post_meta['wpvr_video_duration']) && isset($post_meta['wpvr_video_duration'][0])){
				update_post_meta($post_id, 'vm_duration', gmdate("H:i:s", wpvr_get_duration_string( $post_meta['wpvr_video_duration'][0], true )));
			}
			
			return $dataFillers_meta;
		}
		
		public static function init(){
			add_action('save_post', array(__CLASS__, 'savePost'), 1, 3);			
			add_action('wp', array(__CLASS__, 'autoGetDataFromClient'), 20, 1);
			add_action('added_post_meta', array(__CLASS__, 'autoGetDataFromTRDPARTY'), 10, 4);
			add_action('updated_post_meta', array(__CLASS__, 'autoGetDataFromTRDPARTY'), 10, 4);
			add_filter('wpvr_extend_dataFillers_built_meta', array(__CLASS__, 'vidorev_wpvr_tfvrv_add_theme_meta'), 100, 3);
		}
	}
	
	vidorev_video_fetch_data::init();
}