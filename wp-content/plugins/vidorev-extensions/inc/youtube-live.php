<?php
if(!function_exists('vidorev_youtube_live_video')){
	function vidorev_youtube_live_video(
		$params = 	array(
						'id'				=> 0,
						'channel_name' 		=> '', 
						'live_video_title' 	=> '', 
						'channel_id' 		=> '', 
						'auto_refresh' 		=> 'on', 
						'fallback_options' 	=> 'recent_video',
						'public_api_key'	=> '',
						'lang'				=> 'en-US',
						'timezone'			=> 'America/New_York',
						'display_info'		=> 'on',
						'player'			=> 'plyr',
						'autoplay'			=> 'on',
					)
	){
		$id 				= (isset($params['id'])&&trim($params['id'])!=''&&is_numeric(trim($params['id'])))?trim($params['id']):0;
		$channel_name		= (isset($params['channel_name'])&&trim($params['channel_name'])!='')?trim($params['channel_name']):'';
		$live_video_title	= (isset($params['live_video_title'])&&trim($params['live_video_title'])!='')?trim($params['live_video_title']):'';
		$channel_id			= (isset($params['channel_id'])&&trim($params['channel_id'])!='')?trim($params['channel_id']):'';		
		$auto_refresh		= (isset($params['auto_refresh'])&&trim($params['auto_refresh'])!='')?trim($params['auto_refresh']):'on';
		$fallback_options	= (isset($params['fallback_options'])&&trim($params['fallback_options'])!='')?trim($params['fallback_options']):'recent_video';
		$public_api_key		= (isset($params['public_api_key'])&&trim($params['public_api_key'])!='')?trim($params['public_api_key']):'';
		$lang				= (isset($params['lang'])&&trim($params['lang'])!='')?trim($params['lang']):'en-US';
		$timezone			= (isset($params['timezone'])&&trim($params['timezone'])!='')?trim($params['timezone']):'America/New_York';
		$display_info		= (isset($params['display_info'])&&trim($params['display_info'])!='')?trim($params['display_info']):'on';
		$player				= (isset($params['player'])&&trim($params['player'])!='')?trim($params['player']):'plyr';
		$autoplay			= (isset($params['autoplay'])&&trim($params['autoplay'])!='')?trim($params['autoplay']):'on';
		
		$api_url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video';
		$api_key = $public_api_key;
		
		
		if($api_key=='' || $channel_id==''){
			return '';
		}
		
		$url_array = array();
		$url_array['key'] = $api_key;
		$url_array['channelId'] = $channel_id;
		
		$request_basic = add_query_arg($url_array, $api_url);
		
		$request_live_url 		= add_query_arg(array('eventType'=>'live', 'order'=>'date'), $request_basic);
		$request_upcoming_url 	= add_query_arg(array('eventType'=>'upcoming', 'order'=>'date'), $request_basic);
		$request_completed_url 	= add_query_arg(array('eventType'=>'completed', 'order'=>'date'), $request_basic);
		$request_recent_url 	= add_query_arg(array('order'=>'date','maxResults'=>1), $request_basic);		
		
		$array_live = array(
			'live_url'			=> $request_live_url,
			'upcoming_url'		=> $request_upcoming_url,
			'completed_url'		=> $request_completed_url,
			'recent_url'		=> $request_recent_url,
			'channel_name'		=> $channel_name,
			'live_video_title'	=> $live_video_title,
			'auto_refresh'		=> $auto_refresh,
			'fallback_options'	=> $fallback_options,
			'public_api_key'	=> $public_api_key,
			'lang'				=> $lang,
			'timezone'			=> $timezone,
			'display_info'		=> $display_info,
			'player'			=> $player,
			'autoplay'			=> $autoplay,
		);
		
		$json_live 	= json_encode($array_live);
		$rnd_id 	= 'yvl_'.(rand(1, 99999)+$id);
		
		ob_start();
		?>
       		<div id="<?php echo esc_attr($rnd_id); ?>" class="yvl-wrapper yvl-wrapper-control status-check">
            	
                <?php if($display_info=='on' && $live_video_title!=''){?>            
                    <div class="live-header live-header-control">
                        <div class="live-icon">
                            <svg class="broadcasts-icon-svg" height="25" viewBox="0 0 1102 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M248.123077 913.723077C-3.938462 728.615385 7.876923 362.338462 256 189.046154c11.815385 15.753846 23.630769 31.507692 39.384615 51.2-102.4 78.769231-161.476923 181.169231-161.476923 311.138461 0 129.969231 55.138462 232.369231 157.538462 311.138462-15.753846 15.753846-31.507692 35.446154-43.323077 51.2zM874.338462 913.723077c-11.815385-15.753846-23.630769-31.507692-39.384616-51.2 98.461538-82.707692 153.6-185.107692 153.6-315.076923s-59.076923-228.430769-157.538461-311.138462c11.815385-15.753846 23.630769-35.446154 35.446153-51.2 236.307692 165.415385 259.938462 539.569231 7.876924 728.615385z"></path><path d="M334.769231 319.015385c15.753846 15.753846 27.569231 35.446154 39.384615 51.2-126.030769 106.338462-110.276923 283.569231 7.876923 374.153846-11.815385 15.753846-23.630769 31.507692-39.384615 51.2-74.830769-55.138462-118.153846-129.969231-126.030769-220.553846-3.938462-102.4 35.446154-189.046154 118.153846-256zM748.307692 370.215385c11.815385-15.753846 27.569231-31.507692 39.384616-51.2 157.538462 118.153846 145.723077 366.276923-11.815385 472.615384-11.815385-15.753846-23.630769-31.507692-35.446154-51.2 59.076923-47.261538 94.523077-106.338462 94.523077-185.107692 3.938462-70.892308-27.569231-133.907692-86.646154-185.107692z"></path><path d="M551.384615 551.384615m-118.153846 0a118.153846 118.153846 0 1 0 236.307693 0 118.153846 118.153846 0 1 0-236.307693 0Z">
                                </path>
                            </svg>
                        </div><h2 class="extra-bold h5"><?php echo esc_html($live_video_title); ?></h2>
                    </div>
                <?php }
				if($display_info=='on'){
				?>                
                    <div class="live-bar live-bar-control"> 
                     
                        <span class="live-bar-btn live-bar-btn-ctrl live-video font-size-12 meta-font" data-action="live"><i class="fa fa-circle" aria-hidden="true"></i> <span><?php echo esc_html__('LIVE', 'vidorev-extensions');?></span></span><span class="live-bar-btn live-bar-btn-ctrl offline-video font-size-12 meta-font" data-action="live"><?php echo esc_html__('OFFLINE [ RECHECK ]', 'vidorev-extensions');?></span><span class="live-bar-btn live-bar-btn-ctrl recent-video font-size-12 meta-font" data-action="recent"><?php echo esc_html__('Recent Video', 'vidorev-extensions');?></span><span class="live-bar-btn live-bar-btn-ctrl completed-live-video font-size-12 meta-font" data-action="completed"><?php echo esc_html__('Last Completed Live Video', 'vidorev-extensions');?></span><span class="live-bar-btn live-bar-btn-ctrl scheduled-live-video font-size-12 meta-font" data-action="scheduled"><?php echo esc_html__('Scheduled Live Video', 'vidorev-extensions');?></span>
                        
                        <span class="live-seperate"></span>
                        
                        <?php if($auto_refresh=='on'){?>           
                        	<span class="reload-time font-size-12 meta-font"><span class="reload-time-text"><?php echo esc_html__('Check Back in:', 'vidorev-extensions');?></span> <span class="reload-time-control">. . .</span></span>
                        <?php }?>
                    </div>
                <?php }?>
                
				<div class="live-player live-player-control">
					<?php do_action('vidorev_thumbnail', 'vidorev_thumb_16x9_2x', 'class-16x9', 3, $id, vidorev_image_ratio_case('2x')); ?>
                    
                    <div class="absolute-content checking-data checking-data-control dark-background"><div class="video-loading medium-icon"><span class="video-load-icon"></span></div> <span><i class="fa fa-tasks" aria-hidden="true"></i> &nbsp; <?php echo esc_html__('Checking Data . . .', 'vidorev-extensions');?></span></div>
                    
                    <div class="absolute-content checking-offline dark-background"><span><?php echo esc_html__('OFFLINE', 'vidorev-extensions');?></span></div>
                    
                    <div class="absolute-content checking-scheduled dark-background font-size-12 meta-font"><span><?php echo esc_html__('SCHEDULED FOR: ', 'vidorev-extensions');?></span><span class="scheduled-time-control"></span></div>
					
            	</div> 
                       
			</div>
			<script>if(typeof(beeteam368_vid_live_json)==='undefined'){var beeteam368_vid_live_json=[];};beeteam368_vid_live_json['<?php echo $rnd_id;?>']=<?php echo $json_live;?>;if(typeof(vidorev_builder_control)!=="undefined" && vidorev_builder_control!==null){vidorev_builder_control.youtube_live_video('<?php echo $rnd_id;?>');}</script>
        <?php		
		$output_string = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('beeteam368_live_video_html_json', $output_string, $array_live);
	}
}

if(!function_exists('vidorev_youtube_live_video_shortcode')){
	function vidorev_youtube_live_video_shortcode($params){
		extract(
			shortcode_atts(
				array(						
					'id'				=> '',
					'channel_name' 		=> '', 
					'live_video_title' 	=> '', 
					'channel_id' 		=> '', 
					'auto_refresh' 		=> '', 
					'fallback_options' 	=> '',
					'public_api_key'	=> '',
					'lang'				=> '',
					'timezone'			=> '',
					'display_info'		=> '',
					'player'			=> '',
					'autoplay'			=> '',		
				), 
				$params
			)				
		);
		
		
		$id 				= (isset($params['id'])&&trim($params['id'])!=''&&is_numeric(trim($params['id'])))?trim($params['id']):0;
		$channel_name		= (isset($params['channel_name'])&&trim($params['channel_name'])!='')?trim($params['channel_name']):'';
		$live_video_title	= (isset($params['live_video_title'])&&trim($params['live_video_title'])!='')?trim($params['live_video_title']):'';
		$channel_id			= (isset($params['channel_id'])&&trim($params['channel_id'])!='')?trim($params['channel_id']):'';		
		$auto_refresh		= (isset($params['auto_refresh'])&&trim($params['auto_refresh'])!='')?trim($params['auto_refresh']):'on';
		$fallback_options	= (isset($params['fallback_options'])&&trim($params['fallback_options'])!='')?trim($params['fallback_options']):'recent_video';
		$public_api_key		= (isset($params['public_api_key'])&&trim($params['public_api_key'])!='')?trim($params['public_api_key']):'';
		$lang				= (isset($params['lang'])&&trim($params['lang'])!='')?trim($params['lang']):'en-US';
		$timezone			= (isset($params['timezone'])&&trim($params['timezone'])!='')?trim($params['timezone']):'America/New_York';
		$display_info		= (isset($params['display_info'])&&trim($params['display_info'])!='')?trim($params['display_info']):'on';
		$player				= (isset($params['player'])&&trim($params['player'])!='')?trim($params['player']):'plyr';
		$autoplay			= (isset($params['autoplay'])&&trim($params['autoplay'])!='')?trim($params['autoplay']):'on';
		
		if($id!='' && is_numeric($id)){
			
			$post_exists = new WP_Query(array(
				'post_type' 	=> 'youtube_live_video',
				'p' 			=> $id,
				'post_status' 	=> 'publish',
			));
			
			if( $post_exists->have_posts() ){
				
				$prefix = YOUTUBE_LIVE_VIDEO_PREFIX;
				
				$channel_name		= trim(get_post_meta($id, $prefix . 'channel_name', true));
				$live_video_title 	= trim(get_post_meta($id, $prefix . 'live_video_title', true));			
				$channel_id 		= trim(get_post_meta($id, $prefix . 'det_channel_id', true));
				$auto_refresh		= trim(get_post_meta($id, $prefix . 'auto_refresh', true));	
				$fallback_options 	= trim(get_post_meta($id, $prefix . 'fallback_options', true));	
				
				$public_api_key		= trim(get_post_meta($id, $prefix . 'sub_api_key_public', true));				
				if($public_api_key==''){
					$public_api_key	= trim(vidorev_get_redux_option('google_api_key', ''));
				}
				
				$lang				= trim(get_post_meta($id, $prefix . 'lang', true));
				$timezone			= trim(get_post_meta($id, $prefix . 'timezone', true));				
				$display_info		= trim(get_post_meta($id, $prefix . 'display_info', true));
				$player				= trim(get_post_meta($id, $prefix . 'player', true));				
				$autoplay			= trim(get_post_meta($id, $prefix . 'autoplay', true));			
				
				$channel_name		= $channel_name!=''?$channel_name:'';
				$live_video_title	= $live_video_title!=''?$live_video_title:'';
				$channel_id 		= $channel_id!=''?$channel_id:'';
				$auto_refresh		= $auto_refresh!=''?$auto_refresh:'on';	
				$fallback_options	= $fallback_options!=''?$fallback_options:'recent_video';
				$public_api_key		= $public_api_key!=''?$public_api_key:'';
				$lang				= $lang!=''?$lang:'en-US';
				$timezone			= $timezone!=''?$timezone:'America/New_York';				
				$display_info		= $display_info!=''?$display_info:'on';
				$player				= $player!=''?$player:'plyr';
				$autoplay			= $autoplay!=''?$autoplay:'on';
				
			}
			
			wp_reset_postdata();
		}
		
		$params_request = array('id'=>$id, 'channel_name'=>$channel_name, 'live_video_title'=>$live_video_title, 'channel_id'=>$channel_id, 'auto_refresh'=>$auto_refresh, 'fallback_options'=>$fallback_options, 'public_api_key'=>$public_api_key, 'lang'=>$lang, 'timezone'=>$timezone, 'display_info'=>$display_info, 'player'=>$player, 'autoplay'=>$autoplay);
		
		return vidorev_youtube_live_video($params_request);			
	}	
}

add_action('init', function(){
	add_shortcode('youtube_live_video', 'vidorev_youtube_live_video_shortcode');
});

if(!function_exists('vidorev_youtube_live_video_column_ID')){
	function vidorev_youtube_live_video_column_ID( $columns ) {
		$date = $columns['date'];
		unset($columns['date']);
		$columns['Shortcode_ID'] = esc_html__('SHORTCODE', 'vidorev-extensions');
		$columns['date'] = $date;
		return $columns;
	}
}
add_filter('manage_edit-youtube_live_video_columns', 'vidorev_youtube_live_video_column_ID');

if(!function_exists('vidorev_youtube_live_video_column_ID_value')){
	function vidorev_youtube_live_video_column_ID_value( $colname, $cptid ) {
		 if ( $colname == 'Shortcode_ID'){
			  echo '<code class="shortcode-texxt">[youtube_live_video id="'.$cptid.'"]</code>';
		 }
	}
}
add_action('manage_youtube_live_video_posts_custom_column', 'vidorev_youtube_live_video_column_ID_value', 10, 2);