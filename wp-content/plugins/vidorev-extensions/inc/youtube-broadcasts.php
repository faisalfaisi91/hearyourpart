<?php
if(!function_exists('vidorev_youtube_live_broadcasts')){
	function vidorev_youtube_live_broadcasts(
		$params = 	array(
						'broadcast_title' =>	'', 
						'q' => 					'', 
						'channelid' =>			'', 
						'videocategoryid' =>	'', 
						'maxresults' =>			5, 
						'order' =>				'relevance', 
						'regioncode' =>			'', 
						'pageToken' =>			'', 
						'videosyndicated' =>	'true', 
						'style' =>				'default-3columns', 
						'reload_first' =>		'off', 
						'ajax' =>				false
					)
	){
		
		$api_url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&eventType=live';
		$api_key = trim(vidorev_get_redux_option('google_api_key', ''));
		
		$broadcast_title= (isset($params['broadcast_title'])&&trim($params['broadcast_title'])!='')?trim($params['broadcast_title']):'';
		$query			= (isset($params['q'])&&trim($params['q'])!='')?trim($params['q']):'';
		$channelid 		= (isset($params['channelid'])&&trim($params['channelid'])!='')?trim($params['channelid']):'';
		$videocategoryid= (isset($params['videocategoryid'])&&trim($params['videocategoryid'])!='')?trim($params['videocategoryid']):'';	
		$maxresults 	= (isset($params['maxresults'])&&trim($params['maxresults'])!=''&&is_numeric(trim($params['maxresults'])))?trim($params['maxresults']):5;	
		$order 			= (isset($params['order'])&&trim($params['order'])!='')?trim($params['order']):'relevance';	
		$regioncode 	= (isset($params['regioncode'])&&trim($params['regioncode'])!='')?trim($params['regioncode']):'';
		$pageToken 		= (isset($params['pageToken'])&&trim($params['pageToken'])!='')?trim($params['pageToken']):'';
		$videosyndicated= (isset($params['videosyndicated'])&&trim($params['videosyndicated'])!='')?trim($params['videosyndicated']):'true';
		$style			= (isset($params['style'])&&trim($params['style'])!='')?trim($params['style']):'default-3columns';
		$reload_first	= (isset($params['reload_first'])&&trim($params['reload_first'])!='')?trim($params['reload_first']):'off';
		$ajax			= isset($params['ajax'])?$params['ajax']:false;
		
		$url_array = array();

		$url_array['key'] = $api_key;
		
		if($query!=''){
			$url_array['q'] = $query;
		}
		
		if($channelid!=''){
			$url_array['channelId'] = $channelid;
		}
		
		if($videocategoryid!=''){
			$url_array['videoCategoryId'] = $videocategoryid;
		}
		
		if($maxresults!='' && is_numeric($maxresults)){
			$maxresults = (int)$maxresults;
			if($maxresults > 50){
				$maxresults = 50;
			}
			if($maxresults < 1){
				$maxresults = 5;
			}		
			$url_array['maxResults'] = $maxresults;
		}
		
		if($order!=''){
			$url_array['order'] = $order;
		}
		
		if($regioncode!=''){
			$url_array['regionCode'] = $regioncode;
		}
		
		if($videosyndicated!=''){
			$url_array['videoSyndicated'] = $videosyndicated;
		}
		
		if($pageToken!=''){
			$url_array['pageToken'] = $pageToken;
		}
		
		$request_url = add_query_arg($url_array, $api_url);
				
		$response = wp_remote_get($request_url, array('timeout'=>368));
		
		if(is_wp_error($response)){			
			return '';
		}else {
			$result = json_decode($response['body']);
			if((isset($result->{'error'}) && $result->{'error'}!='') || (isset($result->{'pageInfo'}) && $result->{'pageInfo'}->{'totalResults'}==0)){
				return '';
			}
		}
		
		$video_IDs = array();
		
		if(isset($result->{'items'}) && count($result->{'items'})>0){
			foreach ($result->{'items'} as $value) {
				if(isset($value->{'id'}) && isset($value->{'id'}->{'videoId'})){
					$videoID = ($value->{'id'}->{'videoId'});
					array_push($video_IDs, $videoID);
				}
			}
		}		
		
		if(count($video_IDs)>0){		
			
			$prevTokenPage = (isset($result->{'prevPageToken'})&&$result->{'prevPageToken'}!='')?$result->{'prevPageToken'}:'';
			$nextTokenPage = (isset($result->{'nextPageToken'})&&$result->{'nextPageToken'}!='')?$result->{'nextPageToken'}:'';
			
			$videos_request = 'https://www.googleapis.com/youtube/v3/videos?id='.(implode(',', $video_IDs)).'&part=snippet,contentDetails,statistics,liveStreamingDetails&key='.$api_key;
			$videos_response = wp_remote_get($videos_request, array('timeout'=>368));
			
			if(is_wp_error($videos_response)){			
				return '';
			}else {
				$videos_result = json_decode($videos_response['body']);
				if((isset($videos_result->{'error'}) && $videos_result->{'error'}!='') || (isset($videos_result->{'pageInfo'}) && $videos_result->{'pageInfo'}->{'totalResults'}==0)){
					return '';
				}
			}
			
			if(isset($videos_result->{'items'}) && count($videos_result->{'items'})>0){
				
				ob_start();
				
				$rnd_id = 'ylb_'.rand(1, 99999);
				
				$class_load_first = $reload_first=='on'?'cache-load-fist cache-load-fist-control':'';
				
				if($ajax==false){				
				?>
					<div id="<?php echo esc_attr($rnd_id);?>" class="vidorev-youtube-broadcast youtube-broadcast-control dark-background <?php echo esc_attr($class_load_first);?>">
						<div class="broadcast-player">
							<div class="player-video player-video-control">
								<span class="video-load-icon"></span>
							</div>
							<div class="player-banner">	
							
								<div class="broadcasts-icon broadcasts-min-control">						
									<svg class="broadcasts-icon-svg" height="30" viewBox="0 0 1102 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M248.123077 913.723077C-3.938462 728.615385 7.876923 362.338462 256 189.046154c11.815385 15.753846 23.630769 31.507692 39.384615 51.2-102.4 78.769231-161.476923 181.169231-161.476923 311.138461 0 129.969231 55.138462 232.369231 157.538462 311.138462-15.753846 15.753846-31.507692 35.446154-43.323077 51.2zM874.338462 913.723077c-11.815385-15.753846-23.630769-31.507692-39.384616-51.2 98.461538-82.707692 153.6-185.107692 153.6-315.076923s-59.076923-228.430769-157.538461-311.138462c11.815385-15.753846 23.630769-35.446154 35.446153-51.2 236.307692 165.415385 259.938462 539.569231 7.876924 728.615385z"  /><path d="M334.769231 319.015385c15.753846 15.753846 27.569231 35.446154 39.384615 51.2-126.030769 106.338462-110.276923 283.569231 7.876923 374.153846-11.815385 15.753846-23.630769 31.507692-39.384615 51.2-74.830769-55.138462-118.153846-129.969231-126.030769-220.553846-3.938462-102.4 35.446154-189.046154 118.153846-256zM748.307692 370.215385c11.815385-15.753846 27.569231-31.507692 39.384616-51.2 157.538462 118.153846 145.723077 366.276923-11.815385 472.615384-11.815385-15.753846-23.630769-31.507692-35.446154-51.2 59.076923-47.261538 94.523077-106.338462 94.523077-185.107692 3.938462-70.892308-27.569231-133.907692-86.646154-185.107692z"/><path d="M551.384615 551.384615m-118.153846 0a118.153846 118.153846 0 1 0 236.307693 0 118.153846 118.153846 0 1 0-236.307693 0Z"/></svg>
								</div>
								<div class="broadcasts-text">
									<h2 class="h5 extra-bold h6-mobile"><?php echo $broadcast_title!=''?esc_html($broadcast_title):esc_html__('Youtube Live Broadcasts', 'vidorev-extensions');?></h2>
								</div>
								
							</div>
							
						</div>
						
						<div class="broadcast-toolbar pos-top">
							<a href="javascript:;" class="refresh-broadcasts refresh-broadcasts-control"><i class="fa fa-refresh" aria-hidden="true"></i> <span><?php echo esc_html__('Refresh', 'vidorev-extensions');?></span></a>
							<div class="broadcast-page-prev-next active-item">
								<span class="next-prev-action <?php echo esc_attr($prevTokenPage!=''?'':'disabled-query');?>" data-action="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
								<span class="next-prev-action <?php echo esc_attr($nextTokenPage!=''?'':'disabled-query');?>" data-action="next"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
						</div>
						
						<div class="broadcast-items broadcast-items-control <?php echo esc_attr($style)?>">
							
							<div class="ajax-loading">
								<div class="la-ball-triangle-path">
									<div></div>
									<div></div>
									<div></div>
								</div>
							</div>
							
							<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
				<?php 
				}
				?>		
								<div class="blog-items blog-items-control site__row grid-default">
									<?php		
									foreach ($videos_result->{'items'} as $value) {
										if(isset($value->{'id'})){
											$videoTitle = isset($value->{'snippet'}->{'title'})?$value->{'snippet'}->{'title'}:'';
											$videoChannel = isset($value->{'snippet'}->{'channelId'})?$value->{'snippet'}->{'channelId'}:'';
											$videoChannelTitle = isset($value->{'snippet'}->{'channelTitle'})?$value->{'snippet'}->{'channelTitle'}:'';
											$videoLiveView = isset($value->{'liveStreamingDetails'}->{'concurrentViewers'})?apply_filters('vidorev_number_format', $value->{'liveStreamingDetails'}->{'concurrentViewers'}):0;
											$videothumb = isset($value->{'snippet'}->{'thumbnails'})?vidorev_youtube_image_retina($value->{'snippet'}->{'thumbnails'}):'';
											$videolike = isset($value->{'statistics'}->{'likeCount'})?apply_filters('vidorev_number_format', $value->{'statistics'}->{'likeCount'}):'0';
											
											?>
											<article class="post-item site__col youtube-item-control" data-current-player-id="<?php echo esc_attr($value->{'id'});?>">
												<div class="post-item-wrap">
													
													<?php if($videothumb!=''){?>												
														<div class="blog-pic">
															<div class="blog-pic-wrap youtube-preview-control open-live-video-control" data-video-id="<?php echo esc_attr($value->{'id'});?>">
																<a href="javascript:;" class="blog-img">
																	<?php echo ($reload_first=='off' || $ajax==true)?$videothumb:'';?>
																	<span class="ul-placeholder-bg class-16x9"></span>
																	<span class="video-load-icon"></span>
																	
																	<div class="preview-video preview-video-control">
																		<span class="overlay-video"></span>
																	</div>
																	
																</a>
																<span class="live-icon font-size-12"><?php echo esc_html__('Live', 'vidorev-extensions');?></span>
																<span class="video-icon medium-icon alway-active"></span>
																
															</div>
														</div>	
													<?php }?>	
																		
													<div class="listing-content">											
																
														<h3 class="entry-title h6 post-title"> 
															<a href="javascript:;" title="<?php echo esc_attr($videoTitle);?>" class="open-live-video-control" data-video-id="<?php echo esc_attr($value->{'id'});?>"><?php echo esc_html($videoTitle);?></a> 
														</h3>
														
														<div class="entry-meta post-meta meta-font">
															<div class="post-meta-wrap">
																<div class="comment-count"><i class="fa fa-video-camera" aria-hidden="true"></i><a href="https://www.youtube.com/channel/<?php echo esc_attr($videoChannel);?>" target="_blank"><?php echo esc_html($videoChannelTitle);?></a></div>
															</div>
														</div>
														
														<div class="entry-meta post-meta meta-font">
															<div class="post-meta-wrap">
																<div class="watching-count"><i class="fa fa-circle" aria-hidden="true"></i><span><?php echo esc_html($videoLiveView).' '.esc_html__('Watching', 'vidorev-extensions');?></span></div>
																<div class="like-count"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span class="like-count"><?php echo esc_html($videolike);?></span></div>
															</div>
														</div>
													
													</div>
													
												</div>
											</article>
											<?php
										}
									}
									?>
								</div>
								<input type="hidden" class="prev-page-token-control" value="<?php echo esc_attr($prevTokenPage);?>">
								<input type="hidden" class="next-page-token-control" value="<?php echo esc_attr($nextTokenPage);?>">
								
				<?php if($ajax==false){?>				
							</div>
						</div>
						
						<div class="broadcast-toolbar pos-bottom">
							<a href="javascript:;" class="refresh-broadcasts refresh-broadcasts-control"><i class="fa fa-refresh" aria-hidden="true"></i> <span><?php echo esc_html__('Refresh', 'vidorev-extensions');?></span></a>
							<div class="broadcast-page-prev-next active-item">
								<span class="next-prev-action <?php echo esc_attr($prevTokenPage!=''?'':'disabled-query');?>" data-action="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
								<span class="next-prev-action <?php echo esc_attr($nextTokenPage!=''?'':'disabled-query');?>" data-action="next"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<script>					
						if(typeof(vidorev_jav_plugin_js_object)!=='undefined'){
							vidorev_jav_plugin_js_object.youtube_broadcasts_params['<?php echo esc_attr($rnd_id);?>'] = <?php echo json_encode($params);?>;
						}
						if(typeof(vidorev_builder_control)!=="undefined" && vidorev_builder_control!==null){
							vidorev_builder_control.youtubeBroadcastsTriggerFirstLoad('<?php echo esc_attr($rnd_id);?>');
						}
					</script>
				<?php
				}
				
				$output_string = ob_get_contents();
				ob_end_clean();
				
				return $output_string;
			}
		}else{
			return '';
		}
		
	}
}

if(!function_exists('vidorev_youtube_image_retina')){
	function vidorev_youtube_image_retina($imgs){
		if(is_object($imgs)){
			$srcset = array();
			foreach ($imgs as $value) {
				array_push($srcset, $value->{'url'}.' '.$value->{'width'}.'w');
			}
			
			$lazyload			= vidorev_get_redux_option('lazyload', 'off', 'switch');
			$normal_img_effect 	= vidorev_get_redux_option('normal_img_effect', 'off', 'switch');
			$placeholder 		= '';
			$classLazy 			= '';
			
			if($lazyload=='on'){
				$classLazy = 'ul-lazysizes-effect ul-lazysizes-load';				
				$placeholder 	= get_template_directory_uri().'/img/placeholder.png';
			}elseif($lazyload != 'on' && $normal_img_effect == 'on'){				
				$classLazy 		= 'ul-normal-effect';
			}else{
				$classLazy 		= 'ul-normal-classic';
			}
			
			$image_url = $imgs->{'medium'}->{'url'};
			
			$image_srcset 			= implode(',', $srcset);
			$image_sizes 			= '(max-width: 320px) 100vw, 320px';				
			$html_image_url 		= $image_url!=''?($lazyload=='on'?' src="'.esc_url($placeholder).'" data-src="'.esc_url($image_url).'"':' src="'.esc_url($image_url).'"'):'';
			$html_image_responsive 	= ($image_srcset!=''&&$image_sizes!='')?($lazyload=='on'?' data-srcset="'.esc_attr($image_srcset).'" data-sizes="'.esc_attr($image_sizes).'"':' srcset="'.esc_attr($image_srcset).'" sizes="'.esc_attr($image_sizes).'"'):'';		
			
			return $html_image_url!=''?'<img class="blog-picture '.esc_attr($classLazy).'"'.$html_image_url.$html_image_responsive.' alt="'.esc_attr__('Live Image', 'vidorev-extensions').'"/>':'';
		}
		return '';
	}
}

if(!function_exists('vidorev_youtube_live_broadcasts_shortcode')){
	function vidorev_youtube_live_broadcasts_shortcode($params){
		extract(
			shortcode_atts(
				array(						
					'id'					=> '',
					'broadcast_title'		=> '',
					'q'						=> '',
					'channelid'				=> '',
					'videocategoryid'		=> '',
					'maxresults'			=> '',
					'order'					=> '',
					'regioncode'			=> '',	
					'videosyndicated'		=> '',
					'reload_first'			=> '',
					'style'					=> '',			
				), 
				$params
			)				
		);
		
		
		$id 			= (isset($params['id'])&&trim($params['id'])!=''&&is_numeric(trim($params['id'])))?trim($params['id']):'';
		$broadcast_title= (isset($params['broadcast_title'])&&trim($params['broadcast_title'])!='')?trim($params['broadcast_title']):'';	
		$query 			= (isset($params['q'])&&trim($params['q'])!='')?trim($params['q']):'';	
		$channelid 		= (isset($params['channelid'])&&trim($params['channelid'])!='')?trim($params['channelid']):'';	
		$videocategoryid= (isset($params['videocategoryid'])&&trim($params['videocategoryid'])!='')?trim($params['videocategoryid']):'';
		$maxresults 	= (isset($params['maxresults'])&&trim($params['maxresults'])!=''&&is_numeric(trim($params['maxresults'])))?trim($params['maxresults']):5;	
		$order 			= (isset($params['order'])&&trim($params['order'])!='')?trim($params['order']):'relevance';	
		$regioncode 	= (isset($params['regioncode'])&&trim($params['regioncode'])!='')?trim($params['regioncode']):'';
		$videosyndicated= (isset($params['videosyndicated'])&&trim($params['videosyndicated'])!='')?trim($params['videosyndicated']):'true';
		$reload_first	= (isset($params['reload_first'])&&trim($params['reload_first'])!='')?trim($params['reload_first']):'off';
		$style 			= (isset($params['style'])&&trim($params['style'])!='')?trim($params['style']):'default-3columns';
		
		if($id!='' && is_numeric($id)){
			
			$post_exists = new WP_Query(array(
				'post_type' 	=> 'youtube_broadcast',
				'p' 			=> $id,
				'post_status' 	=> 'publish',
			));
			
			if( $post_exists->have_posts() ){
				
				$prefix = YOUTUBE_BROADCASTS_PREFIX;
				
				$broadcast_title= trim(get_post_meta($id, $prefix . 'broadcast_title', true));
				$query 			= trim(get_post_meta($id, $prefix . 'q', true));			
				$channelid 		= trim(get_post_meta($id, $prefix . 'channelid', true));
				$videocategoryid= trim(get_post_meta($id, $prefix . 'videocategoryid', true));	
				$maxresults 	= trim(get_post_meta($id, $prefix . 'maxresults', true));
				$order 			= trim(get_post_meta($id, $prefix . 'order', true));
				$regioncode 	= trim(get_post_meta($id, $prefix . 'regioncode', true));
				$videosyndicated= trim(get_post_meta($id, $prefix . 'videosyndicated', true));
				$reload_first	= trim(get_post_meta($id, $prefix . 'reload_first', true));
				$style 			= trim(get_post_meta($id, $prefix . 'style', true));
				
				$broadcast_title= $broadcast_title!=''?$broadcast_title:'';
				$query			= $query!=''?$query:'';
				$channelid 		= $channelid!=''?$channelid:'';
				$videocategoryid= $videocategoryid!=''?$videocategoryid:'';	
				$maxresults 	= ($maxresults!=''&&is_numeric($maxresults))?$maxresults:5;	
				$order 			= $order!=''?$order:'relevance';	
				$regioncode 	= $regioncode!=''?$regioncode:'';
				$videosyndicated= $videosyndicated!=''?$videosyndicated:'true';
				$reload_first	= $reload_first!=''?$reload_first:'off';
				$style 			= $style!=''?$style:'default-3columns';
			}
			
			wp_reset_postdata();
		}
		
		$params_request = array('broadcast_title'=>$broadcast_title, 'q'=>$query, 'channelid'=>$channelid, 'videocategoryid'=>$videocategoryid, 'maxresults'=>$maxresults, 'order'=>$order, 'regioncode'=>$regioncode, 'videosyndicated'=>$videosyndicated, 'reload_first'=>$reload_first, 'style'=>$style);
		
		return vidorev_youtube_live_broadcasts($params_request);			
	}	
}

add_action('init', function(){
	add_shortcode('youtube_live_broadcasts', 'vidorev_youtube_live_broadcasts_shortcode');
});

if(!function_exists('vidorev_request_pagetoken_youtube_broadcasts')){
	function vidorev_request_pagetoken_youtube_broadcasts(){
		$params	= $_POST['params'];
		
		if(isset($params)){						
			echo vidorev_youtube_live_broadcasts($params);
		}else{
			echo '';
		}
		exit;
	}
}
add_action('wp_ajax_vidorev_request_pagetoken_youtube_broadcasts', 'vidorev_request_pagetoken_youtube_broadcasts');
add_action('wp_ajax_nopriv_vidorev_request_pagetoken_youtube_broadcasts', 'vidorev_request_pagetoken_youtube_broadcasts');	

if(!function_exists('vidorev_youtube_broadcasts_column_ID')){
	function vidorev_youtube_broadcasts_column_ID( $columns ) {
		$date = $columns['date'];
		unset($columns['date']);
		$columns['Shortcode_ID'] = esc_html__('SHORTCODE', 'vidorev-extensions');
		$columns['date'] = $date;
		return $columns;
	}
}
add_filter('manage_edit-youtube_broadcast_columns', 'vidorev_youtube_broadcasts_column_ID');

if(!function_exists('vidorev_youtube_broadcasts_column_ID_value')){
	function vidorev_youtube_broadcasts_column_ID_value( $colname, $cptid ) {
		 if ( $colname == 'Shortcode_ID'){
			  echo '<code class="shortcode-texxt">[youtube_live_broadcasts id="'.$cptid.'"]</code>';
		 }
	}
}
add_action('manage_youtube_broadcast_posts_custom_column', 'vidorev_youtube_broadcasts_column_ID_value', 10, 2);