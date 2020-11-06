<?php
if(! defined( 'CMB2_LOADED' )){
	return;
}

if ( ! function_exists( 'vidorev_cmb_post_options' ) ){
	function vidorev_cmb_post_options(){
		if(function_exists('beeteam368_get_user_role')){
			$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
			if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
				return;
			}
		}
		
		/*$feature_image_settings*/
			$feature_image_settings = new_cmb2_box( array(
				'id'            => 'feature_image_settings',
				'title'         => esc_html__( 'Feature Image Settings', 'vidorev-extensions'),
				'object_types'  => array( 'post' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			$feature_image_settings->add_field( array(			
				'id'        	=> 'feature_image_position',
				'name'      	=> esc_html__('Feature Image Position', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select default feature image position for standard posts', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    			=> esc_html__('Default', 'vidorev-extensions'),
					'basic'    		=> esc_html__('Basic', 'vidorev-extensions'),
					'full-width'    => esc_html__('Full Width', 'vidorev-extensions'),
					'special'    	=> esc_html__('Special', 'vidorev-extensions'),						
				),
				'images'        => array(
					''    			=> 'img/to-pic/to-default.jpg',
					'basic'    		=> 'img/to-pic/single-post-standard-basic.jpg',
					'full-width'    => 'img/to-pic/single-post-standard-full-width.jpg',
					'special'    	=> 'img/to-pic/single-post-standard-special.jpg',					
				),	
			));
		/*$feature_image_settings*/
		
		/*$video_player_settings*/
			$video_player_settings = new_cmb2_box( array(
				'id'            => 'video_player_settings',
				'title'         => esc_html__( 'Video Player Settings', 'vidorev-extensions'),
				'object_types'  => array( 'post' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			$video_player_settings->add_field( array(			
				'id'        	=> 'single_video_style',
				'name'      	=> esc_html__('Style', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select single video style', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    			=> esc_html__('Default', 'vidorev-extensions'),
					'basic'    		=> esc_html__('Basic', 'vidorev-extensions'),
					'clean'   		=> esc_html__('Clean', 'vidorev-extensions'),					
				),
				'images'        => array(
					''    			=> 'img/to-pic/to-default.jpg',
					'basic'    		=> 'img/to-pic/video-s-1.png',
					'clean'    		=> 'img/to-pic/video-s-2.png',								
				),	
			));
			$video_player_settings->add_field( array(			
				'id'        	=> 'video_player_position',
				'name'      	=> esc_html__('Video Player Position', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select default video player position for video posts', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    			=> esc_html__('Default', 'vidorev-extensions'),
					'basic'    		=> esc_html__('Basic', 'vidorev-extensions'),
					'full-width'    => esc_html__('Full Width', 'vidorev-extensions'),
					'special'    	=> esc_html__('Special', 'vidorev-extensions'),						
				),
				'images'        => array(
					''    			=> 'img/to-pic/to-default.jpg',
					'basic'    		=> 'img/to-pic/single-video-basic.jpg',
					'full-width'    => 'img/to-pic/single-video-theater.jpg',
					'special'    	=> 'img/to-pic/single-video-special.jpg',					
				),	
			));
			$video_player_settings->add_field( array(
				'id'        	=> 'vm_video_url_btn_choose',
				'name'      	=> esc_html__( 'Choose self-hosted Video', 'vidorev-extensions'),
				'type'      	=> 'file',
				'options' 		=> array( 'url' => false ),
				'query_args' => array(					
					'type' => array(
						'video/x-ms-asf',
						'video/x-ms-wmv',
						'video/x-ms-wmx',
						'video/x-ms-wm',
						'video/avi',
						'video/divx',
						'video/x-flv',
						'video/quicktime',
						'video/mpeg',
						'video/mp4',
						'video/ogg',
						'video/webm',
						'video/x-matroska',
						'video/3gpp',
						'video/3gpp2'
					),
				),
						
			));
			$video_player_settings->add_field( array(			
				'id'        	=> 'vm_video_url',
				'name'      	=> esc_html__( 'Video URL ( url from video sites or embed [ iframe, object, html code ] )', 'vidorev-extensions'),
				'type'      	=> 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),			
				'column'  		=> false,
				'desc'        	=> 	wp_kses(__(
										'Enter url from video sites ( or &#x3C;object&#x3E;, &#x3C;embed&#x3E;, &#x3C;iframe&#x3E; ) like YouTube, Vimeo, Dailymotion, Facebook, Twitch, Google Drive or your file upload (*.mp4).
										<br><br><strong>For example:</strong><br><br>
										<code>https://www.youtube.com/watch?v=q8znjqjdA2I</code><br>
										<code>https://youtu.be/q8znjqjdA2I</code><br><br>
										<code>https://vimeo.com/channels/staffpicks/169993072</code><br>
										<code>https://vimeo.com/199169842</code><br><br>
										<code>http://www.dailymotion.com/video/x5s6bwc</code><br><br>
										<code>https://www.twitch.tv/videos/241287909</code><br>
										<code>https://www.twitch.tv/dotamajor</code><br><br>
										<code>https://www.facebook.com/leagueoflegends/videos/10157218236550556/</code><br><br>
										<code>https://drive.google.com/file/d/1Igz_p03sJHiHu8XAy24FdKJXUtKay3AJ/view?usp=sharing</code><br><br>
										<strong>For self-hosted videos</strong>:<br>
										About Cross-platform and Cross-browser Support<br>
										If you want your video works in all platforms and browsers(HTML5 and Flash), you should provide various video formats for same video, if the video files are ready, enter one url per line. For Example: <br>
										<code>http://yousite.com/sample-video.m4v</code><br>
										<code>http://yousite.com/sample-video.ogv</code><br>
										Recommended Format Solution: mp4 + webmv + m4v + ogv + flv + wmv.', 'vidorev-extensions'), 
										array('br'=>array(), 'code'=>array(), 'strong'=>array())		
									),
			));
			
			$video_player_settings->add_field( array(			
				'id'        	=> 'vm_video_ratio',
				'name'      	=> esc_html__( 'Player Ratio', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Sets the ratio between the width and the height of the player. The default parameter is 16:9. Eg(s): 4:3, 21:9 ...', 'vidorev-extensions'),
				'type'      	=> 'text',	
				'default'		=> '16:9',		
				'column'  		=> false,		
			));
			$video_player_settings->add_field( array(			
				'id'        	=> 'vm_video_ratio_mobile',
				'name'      	=> esc_html__( 'Player Ratio (mobile)', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Sets the ratio between the width and the height of the player. The default parameter is 16:9. Eg(s): 4:3, 21:9 ...', 'vidorev-extensions'),
				'type'      	=> 'text',	
				'default'		=> '16:9',		
				'column'  		=> false,		
			));	
			
			$video_player_settings->add_field( array(			
				'id'        	=> 'video_player_library',
				'name'      	=> esc_html__('Player', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select default player for video file. Select "Default" to use settings in Theme Options > Single Video Settings.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'vp'    		=> esc_html__('VidoRev Javascript Library', 'vidorev-extensions'),
					'fluidplayer' 	=> esc_html__('Fluid Player (with VAST)', 'vidorev-extensions'),
					'jw'    		=> esc_html__('JW Player', 'vidorev-extensions'),
					'videojs'   	=> esc_html__('Videojs HTML5 Player', 'vidorev-extensions'),
					'flow'    		=> esc_html__('FV Flowplayer Video Player', 'vidorev-extensions'),
										
				),	
			));
				$video_player_settings->add_field( array(			
					'id'        	=> 'plyr_player',
					'name'      	=> esc_html__('Custom Player for Youtube & Vimeo', 'vidorev-extensions'),					
					'type'      	=> 'select',			
					'column'  		=> false,
					'default'		=> '',	
					'options'       => array(
						''    		=> esc_html__('Default', 'vidorev-extensions'),
						'on'  		=> esc_html__('ON', 'vidorev-extensions'),
						'off'  		=> esc_html__('OFF', 'vidorev-extensions'),									
					),
					'attributes' => array(
						'data-conditional-id'    => 'video_player_library',
						'data-conditional-value' => 'vp',
					),
				));
			
			$video_player_settings->add_field( array(			
				'id'        	=> 'video_streaming',
				'name'      	=> esc_html__('Streaming (Only works with FluidPlayer)', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Streaming is multimedia that is constantly received by, and presented to, an end-user while being delivered by a provider. Fluid Player supports HLS (.m3u8) streaming. These both work by splitting the content into segments. Segments contain video or audio content, and are selected based on the highest bit rate available. This is to ensure there are as few stalls and re-buffers as possible.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'no',	
				'options'       => array(
					'no'    		=> esc_html__('NO', 'vidorev-extensions'),
					/*'MPEG-DASH'    	=> esc_html__('MPEG-DASH (mpd)', 'vidorev-extensions'),*/
					'HLS'    		=> esc_html__('HLS (m3u8)', 'vidorev-extensions'),							
				),
				'attributes' => array(
					'data-conditional-id'    => 'video_player_library',
					'data-conditional-value' => 'fluidplayer',
				),		
			));
			
			$video_player_settings->add_field( array(			
				'id'        	=> 'vm_video_shortcode',
				'name'      	=> esc_html__( 'Custom Player ( [shortcode] or embed [ iframe, object, html code ] )', 'vidorev-extensions'),
				'type'      	=> 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),			
				'column'  		=> false,
				'desc'        	=> 	wp_kses(__(
										'Please enter your shortcode. This is a priority option, which replaces the default player.<br><br>Example: <code>[GDPlayer gdrive="https://drive.google.com/file/d/1Y-XwehfdImCzpug0HuQ-qDMhs1z8k3ii/view?usp=sharing"]</code>
										<br><br><strong>Note: Some players will not work in lightbox mode. This is a standalone player, so some features will not be available.</strong>', 'vidorev-extensions'), 
										array('br'=>array(), 'code'=>array(), 'strong'=>array())		
									),				
			));
			
			$video_player_settings->add_field( array(			
				'id'        	=> 'vm_video_timelapse',
				'name'      	=> esc_html__( 'TimeLapse', 'vidorev-extensions'),
				'type'      	=> 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),			
				'column'  		=> false,
				'desc'        	=> 	wp_kses(__(
										'You can add shortcodes here, it will be displayed at the bottom of the video. <a href="https://www.youtube.com/watch?v=MFE0DE7I3JM" target="_blank">Video Tutorial</a><br>Shortcode: <code>[vidorev_time_lapse time="" title=""]</code><br>This feature works smoothly with videos from Youtube, Vimeo and self-hosted videos (* .mp4). Enter one shortcode per line. For Example:', 'vidorev-extensions'), 
										array('a'=>array('href'=>array(), 'target'=>array()), 'code'=>array(), 'br'=>array())		
									),				
			));
			
			$group_media_subtitles = $video_player_settings->add_field(array(
				'id'          => 'vm_media_subtitles',
				'type'        => 'group',	
				'description' => esc_html__('Subtitles - [Only work with FluidPlayer] - Subtitles are text derived from either a transcript or screenplay of the dialog or commentary in films, television programs, video games, and the like, usually displayed at the bottom of the screen.', 'vidorev-extensions'),		
				'options'     => array(
					'group_title'   => esc_html__('Subtitles {#}', 'vidorev-extensions'),
					'add_button'	=> esc_html__('Add Subtitles', 'vidorev-extensions'),
					'remove_button' => esc_html__('Remove Subtitles', 'vidorev-extensions'),				
					'closed'		=> true,
				),
				'repeatable'  => true,				
			));	
				$video_player_settings->add_group_field($group_media_subtitles, array(
					'id'   			=> 'label',
					'name' 			=> esc_html__( 'Label', 'vidorev-extensions'),
					'type' 			=> 'text',
					'desc'        	=> esc_html__('A user-readable title of the text track which is used by the browser when listing available text tracks.', 'vidorev-extensions'),
					'repeatable' 	=> false,
				));				
				$video_player_settings->add_group_field($group_media_subtitles, array(
					'id'   			=> 'srclang',
					'name' 			=> esc_html__( 'Srclang', 'vidorev-extensions'),
					'type' 			=> 'text',
					'desc'        	=> esc_html__('Language of the track text data. It must be a valid BCP 47 language tag ( https://r12a.github.io/app-subtags/ ). If the kind attribute is set to subtitles, then srclang must be defined.', 'vidorev-extensions'),
					'repeatable' 	=> false,
				));
				$video_player_settings->add_group_field($group_media_subtitles, array(
					'id'   			=> 'src',
					'name' 			=> esc_html__( 'Src', 'vidorev-extensions'),
					'type' 			=> 'file',
					'desc'        	=> esc_html__('Address of the track (.vtt file). Must be a valid URL. This attribute must be specified and its URL value must have the same origin as the document — unless the <audio> or <video> parent element of the track element has a crossorigin attribute.', 'vidorev-extensions'),
					'repeatable' 	=> false,
				));
			
			$group_media_source = $video_player_settings->add_field(array(
				'id'          => 'vm_media_sources',
				'type'        => 'group',	
				'description' => esc_html__('Media Sources - [Only work with JWPlayer & FluidPlayer] - Sources are inserted into playlist objects and are lists of files. Sources serve a dual purpose, depending on the files used.', 'vidorev-extensions'),		
				'options'     => array(
					'group_title'   => esc_html__('Media Source {#}', 'vidorev-extensions'),
					'add_button'	=> esc_html__('Add Media', 'vidorev-extensions'),
					'remove_button' => esc_html__('Remove Media', 'vidorev-extensions'),				
					'closed'		=> true,
				),
				'repeatable'  => true,				
			));	
				$video_player_settings->add_group_field($group_media_source, array(
					'id'   			=> 'source_label',
					'name' 			=> esc_html__( 'Label', 'vidorev-extensions'),
					'type' 			=> 'text',
					'repeatable' 	=> false,
				));
				$video_player_settings->add_group_field($group_media_source, array(
					'id'   			=> 'source_file',
					'name' 			=> esc_html__( 'File', 'vidorev-extensions'),
					'type' 			=> 'file',
					'repeatable' 	=> false,
				));
			
			$video_player_settings->add_field( array(			
				'id'        	=> 'vid_auto_play',
				'name'      	=> esc_html__('Auto Play', 'vidorev-extensions'),
				'desc'        	=> esc_html__('The videos automatically play for desktop users only, and are shown but require a tap to play for mobile users. Select "Default" to use settings in Theme Options > Single Video Settings.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'on'    	=> esc_html__('ON', 'vidorev-extensions'),
					'off'  		=> esc_html__('OFF', 'vidorev-extensions'),									
				),	
			));
			
			$video_player_settings->add_field( array(			
				'id'        	=> 'vid_preview_mode',
				'name'      	=> esc_html__('Preview', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Enabling this option helps users preview videos when hovering over featured image of video post on lists or archive pages. Note: This feature is only available for self-hosted videos, or video networks supported through API such as: Youtube, Vimeo, Twitch, Facebook, Dailymotion. It does not work with videos displayed with normal embedded mode. If your video needs to be protected or not supported by the API. Please use the Screenshot Preview mode.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    			=> esc_html__('Default', 'vidorev-extensions'),
					'video'    		=> esc_html__('Watch the video of this post', 'vidorev-extensions'),
					'screenshots'   => esc_html__('Screenshot Preview', 'vidorev-extensions'),
					'off'  			=> esc_html__('OFF', 'vidorev-extensions'),									
				),				
			));
				$group_screenshot_preview = $video_player_settings->add_field(array(
					'id'          => 'vm_screenshot_preview',
					'type'        => 'group',	
					'description' => esc_html__('Screenshots Preview', 'vidorev-extensions'),		
					'options'     => array(
						'group_title'   => esc_html__('Screenshot Source {#}', 'vidorev-extensions'),
						'add_button'	=> esc_html__('Add Screenshot', 'vidorev-extensions'),
						'remove_button' => esc_html__('Remove Screenshot', 'vidorev-extensions'),				
						'closed'		=> true,
					),
					'repeatable'  => true,										
				));
					$video_player_settings->add_group_field($group_screenshot_preview, array(
						'id'   			=> 'preview_source_file',
						'name' 			=> esc_html__( 'File', 'vidorev-extensions'),
						'type' 			=> 'file',
						'repeatable' 	=> false,
					));
			
			$video_player_settings->add_field(array(
				'name' 			=> esc_html__( 'Video Tags', 'vidorev-extensions'),
				'desc' 			=> esc_html__( 'Start typing tag name. Eg: 4k, HDR, HD, SD... You need to add these tags before finding them and adding them to the post.', 'vidorev-extensions'),
				'id'			=> 'vid_tags',
				'type' 			=> 'text',
				'column'  		=> false,
				'render_row_cb' => 'beeteam368_custom_field_tags_search',
				'save_field' 	=> true,
			));

			
			if(defined('PLAYLIST_PM_PREFIX') && defined('CHANNEL_PM_PREFIX')){
				$video_player_settings->add_field( array(
					'name' 			=> esc_html__( 'Playlist', 'vidorev-extensions'),
					'desc' 			=> esc_html__( 'Add video to playlist.', 'vidorev-extensions'),
					'id'			=> PLAYLIST_PM_PREFIX.'sync_playlist',
					'type' 			=> 'text',
					'column'  		=> false,
					'render_row_cb' => 'beeteam368_custom_field_playlist_search',
					'save_field' 	=> false,
				));
				
				$video_player_settings->add_field( array(
					'name' 			=> esc_html__( 'Channel', 'vidorev-extensions'),
					'desc' 			=> esc_html__( 'Add video to channel.', 'vidorev-extensions'),
					'id'			=> CHANNEL_PM_PREFIX.'sync_channel',
					'type' 			=> 'text',
					'column'  		=> false,
					'render_row_cb' => 'beeteam368_custom_field_channel_search',
					'save_field' 	=> false,
				));
			}
			
			$video_player_settings->add_field( array(
				'name' 			=> esc_html__( 'Get Post Format', 'vidorev-extensions'),
				'id'			=> 'get_post_format',
				'type' 			=> 'text',
				'column'  		=> false,
				'render_row_cb' => 'beeteam368_get_field_post_format',
				'save_field' 	=> false,
			));
				
				$video_player_settings->add_field( array(			
					'id'        	=> 'multiple_links_structure',
					'name'      	=> esc_html__('Multiple-Links Structure', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Do not change this field. Please contact us before changing it!', 'vidorev-extensions'),
					'type'      	=> 'select',			
					'column'  		=> false,
					'default'		=> 'default',	
					'options'       => array(						
						'default'   => esc_html__('DEFAULT', 'vidorev-extensions'),
						'multi'  	=> esc_html__('Multiple groups', 'vidorev-extensions'),									
					),	
				));				
				$video_player_settings->add_field( array(
					'id'   			=> 'multi_links_title',
					'name' 			=> esc_html__( 'Multi-Links Title', 'vidorev-extensions'),
					'type' 			=> 'text',
					'repeatable' 	=> false,
					'attributes' => array(
						'data-conditional-id'    => 'multiple_links_structure',
						'data-conditional-value' => 'default',
					),	
				));
				$video_player_settings->add_field( array(
					'id'   			=> 'original_video_title',
					'name' 			=> esc_html__( 'Original Video Title', 'vidorev-extensions'),
					'type' 			=> 'text',
					'repeatable' 	=> false,
					'attributes' => array(
						'data-conditional-id'    => 'multiple_links_structure',
						'data-conditional-value' => 'default',
					),	
				));
				$group_multi_links = $video_player_settings->add_field(array(
					'id'          => 'vm_video_multi_links',
					'type'        => 'group',	
					'description' => esc_html__('You can create multiple videos in one post. Videos will be listed as links.', 'vidorev-extensions'),		
					'options'     => array(
						'group_title'   => esc_html__('Multi-Links - [ Video ] {#}', 'vidorev-extensions'),
						'add_button'	=> esc_html__('Add Video', 'vidorev-extensions'),
						'remove_button' => esc_html__('Remove Video', 'vidorev-extensions'),				
						'closed'		=> true,
					),
					'repeatable'  => true,
				));	
					$video_player_settings->add_group_field($group_multi_links, array(
						'id'   			=> 'ml_label',
						'name' 			=> esc_html__( 'Label', 'vidorev-extensions'),
						'type' 			=> 'text',
						'repeatable' 	=> false,
					));
					$video_player_settings->add_group_field($group_multi_links, array(
						'id'   				=> 'ml_url_mm',
						'name' 				=> esc_html__( 'Video URL', 'vidorev-extensions'),
						'description' 		=> wp_kses(__(
													'Enter one url per line. For Example: <br>
													<code>Link 1</code><br>
													<code>http://yousite.com/sample-video-1.mp4</code><br>
													<code>Link 2</code><br>
													<code>http://yousite.com/sample-video-2.mp4</code><br>', 'vidorev-extensions'), 
													array('br'=>array(), 'code'=>array(), 'strong'=>array())		
												),
						'type' 				=> 'textarea_small',
						'repeatable' 		=> false,
						'sanitization_cb' 	=> 'vidorev_sanitization_cmb2_func',
						'attributes' => array(
							'data-conditional-id'    => 'multiple_links_structure',
							'data-conditional-value' => 'multi',
						),
					));
					$video_player_settings->add_group_field($group_multi_links, array(
						'id'   				=> 'ml_url',
						'name' 				=> esc_html__( 'Video URL ( url from video sites or embed [ iframe, object, html code ] )', 'vidorev-extensions'),
						'type' 				=> 'textarea_small',
						'repeatable' 		=> false,
						'sanitization_cb' 	=> 'vidorev_sanitization_cmb2_func',
						'attributes' => array(
							'data-conditional-id'    => 'multiple_links_structure',
							'data-conditional-value' => 'default',
						),
					));
					$video_player_settings->add_group_field($group_multi_links, array(
						'id'   				=> 'ml_shortcode',
						'name' 				=> esc_html__( 'Custom Player ( [shortcode] or embed [ iframe, object, html code ] )', 'vidorev-extensions'),
						'type' 				=> 'textarea_small',
						'repeatable' 		=> false,
						'sanitization_cb' 	=> 'vidorev_sanitization_cmb2_func',
						'attributes' => array(
							'data-conditional-id'    => 'multiple_links_structure',
							'data-conditional-value' => 'default',
						),
					));
			
			$video_player_settings->add_field( array(			
				'id'        	=> 'vm_duration',
				'name'      	=> esc_html__( 'Duration', 'vidorev-extensions'),
				'desc'        	=> esc_html__('The duration of the video, For example ( mm:ss ): 16:59, 20:32 ... Leave blank, the system will automatically fetch data.', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,		
			));			
			$video_player_settings->add_field( array(			
				'id'        	=> 'vid_social_locker',
				'name'      	=> esc_html__('Social/Email/Sign-In Locker', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Wrap content you want to lock via the shortcode (created by Social Locker). You will need to install Social Locker plugin', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'off',	
				'options'       => array(
					'on'    	=> esc_html__('ON', 'vidorev-extensions'),
					'off'  		=> esc_html__('OFF', 'vidorev-extensions'),									
				),	
			));
			
				$video_player_settings->add_field( array(			
					'id'        	=> 'vid_locker_mode',
					'name'      	=> esc_html__('Lock mode', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Please select a mode to protect the video.', 'vidorev-extensions'),
					'type'      	=> 'select',			
					'column'  		=> false,
					'default'		=> 'social',	
					'options'       => array(
						'social'    	=> esc_html__('SOCIAL LOCKER', 'vidorev-extensions'),
						'email'  		=> esc_html__('EMAIL LOCKER', 'vidorev-extensions'),
						'signin'  		=> esc_html__('SIGN-IN LOCKER', 'vidorev-extensions'),									
					),	
				));
				
				$video_player_settings->add_field( array(			
					'id'        	=> 'vid_social_locker_id',
					'name'      	=> esc_html__('[Social Locker] Shortcode ID', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Enter Shortcode ID. Ex: 1342, 5146 ...', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'column'  		=> false,
					'attributes' => array(
						'data-conditional-id'    => 'vid_locker_mode',
						'data-conditional-value' => 'social',
					),
				));
				
				$video_player_settings->add_field( array(			
					'id'        	=> 'vid_social_email_locker_id',
					'name'      	=> esc_html__('[Email Locker] Shortcode ID', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Enter Shortcode ID. Ex: 1342, 5146 ... ( You need to buy this plugin to use: https://codecanyon.net/item/optin-panda-for-wordpress/10224279 )', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'column'  		=> false,
					'attributes' => array(
						'data-conditional-id'    => 'vid_locker_mode',
						'data-conditional-value' => 'email',
					),
				));
				
				$video_player_settings->add_field( array(			
					'id'        	=> 'vid_social_signin_locker_id',
					'name'      	=> esc_html__('[Sign-In Locker] Shortcode ID', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Enter Shortcode ID. Ex: 1342, 5146 ... ( You need to buy this plugin to use: https://codecanyon.net/item/optin-panda-for-wordpress/10224279 )', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'column'  		=> false,
					'attributes' => array(
						'data-conditional-id'    => 'vid_locker_mode',
						'data-conditional-value' => 'signin',
					),
				));
				
			$video_player_settings->add_field( array(			
				'id'        	=> 'vid_membership_action',
				'name'      	=> esc_html__('[Membership] Restrict Content', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Wrap content you want to lock via the Membership. You will need to install Paid Membership Pro plugin', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'content-video',	
				'options'       => array(
					'content-video'    	=> esc_html__('Content & Video', 'vidorev-extensions'),
					'content'  			=> esc_html__('Content Only', 'vidorev-extensions'),
					'trailer'  			=> esc_html__('Trailer Video', 'vidorev-extensions'),									
				),	
			));			
				$video_player_settings->add_field( array(			
					'id'        	=> 'vm_video_trailer_url',
					'name'      	=> esc_html__( 'Video Trailer URL ( url from video sites or embed [ iframe, object, html code ] )', 'vidorev-extensions'),
					'type'      	=> 'textarea_code',
					'options' 		=> array( 'disable_codemirror' => true ),			
					'column'  		=> false,
					'desc'        	=> 	wp_kses(__(
											'Enter url from video sites ( or &#x3C;object&#x3E;, &#x3C;embed&#x3E;, &#x3C;iframe&#x3E; ) like YouTube, Vimeo, Dailymotion, Facebook, Twitch, Google Drive or your file upload (*.mp4).
											<br><br><strong>For example:</strong><br><br>
											<code>https://www.youtube.com/watch?v=q8znjqjdA2I</code><br>
											<code>https://youtu.be/q8znjqjdA2I</code><br><br>
											<code>https://vimeo.com/channels/staffpicks/169993072</code><br>
											<code>https://vimeo.com/199169842</code><br><br>
											<code>http://www.dailymotion.com/video/x5s6bwc</code><br><br>
											<code>https://www.twitch.tv/videos/241287909</code><br>
											<code>https://www.twitch.tv/dotamajor</code><br><br>
											<code>https://www.facebook.com/leagueoflegends/videos/10157218236550556/</code><br><br>
											<code>https://drive.google.com/file/d/1Igz_p03sJHiHu8XAy24FdKJXUtKay3AJ/view?usp=sharing</code><br><br>
											<strong>For self-hosted videos</strong>:<br>
											About Cross-platform and Cross-browser Support<br>
											If you want your video works in all platforms and browsers(HTML5 and Flash), you should provide various video formats for same video, if the video files are ready, enter one url per line. For Example: <br>
											<code>http://yousite.com/sample-video.m4v</code><br>
											<code>http://yousite.com/sample-video.ogv</code><br>
											Recommended Format Solution: mp4 + webmv + m4v + ogv + flv + wmv.', 'vidorev-extensions'), 
											array('br'=>array(), 'code'=>array(), 'strong'=>array())		
										),
					'attributes' 	=> array(
											'data-conditional-id'    => 'vid_membership_action',
											'data-conditional-value' => 'trailer',
										),									
				));	
				
			$video_player_settings->add_field( array(			
				'id'        	=> 'vid_download_type',
				'name'      	=> esc_html__('Download', 'vidorev-extensions'),
				'desc'        	=> esc_html__('If the download is free, please provide a direct link here. If the download is paid, please study the documentation to establish a link with WooCommerce.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'free',	
				'options'       => array(
					'free'    	=> esc_html__('FREE', 'vidorev-extensions'),
					'paid'    	=> esc_html__('PAID', 'vidorev-extensions'),								
				),	
			));
			$video_player_settings->add_field( array(			
				'id'        	=> 'vid_download_target',
				'name'      	=> esc_html__('[Download] Link Target', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'download',	
				'options'       => array(
					'download'    	=> esc_html__('Download File', 'vidorev-extensions'),
					'newtab'    	=> esc_html__('Direct Link - Open Link In New Tab', 'vidorev-extensions'),								
				),	
			));
			$video_player_settings->add_field( array(
				'name'      	=> esc_html__( '[Download] Linked Product', 'vidorev-extensions'),
				'id'        	=> 'vid_woo_product',
				'type'      	=> 'post_search_ajax',
				'desc'			=> esc_html__( 'Start typing Product name', 'vidorev-extensions'),
				'limit'      	=> 1, 		
				'sortable' 	 	=> true,
				'query_args'	=> array(
					'post_type'			=> array( 'product' ),
					'post_status'		=> array( 'publish' ),
					'posts_per_page'	=> -1
				)
			));
			$video_player_settings->add_field( array(			
				'id'        	=> 'vid_download_mode',
				'name'      	=> esc_html__('[Download] Protect Mode', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> 'normal',	
				'options'       => array(
					'normal'    	=> esc_html__('Normal', 'vidorev-extensions'),
					'protect'    	=> esc_html__('Protect', 'vidorev-extensions'),								
				),
				'attributes' 	=> array(
										'data-conditional-id'    => 'vid_download_type',
										'data-conditional-value' => 'paid',
				),	
			));
				$video_player_settings->add_field( array(			
					'id'        	=> 'vid_download_mode_trailer',
					'name'      	=> esc_html__( '[Download] Video Trailer URL ( url from video sites or embed [ iframe, object, html code ] )', 'vidorev-extensions'),
					'type'      	=> 'textarea_code',
					'options' 		=> array( 'disable_codemirror' => true ),			
					'column'  		=> false,
					'desc'        	=> 	wp_kses(__(
											'Enter url from video sites ( or &#x3C;object&#x3E;, &#x3C;embed&#x3E;, &#x3C;iframe&#x3E; ) like YouTube, Vimeo, Dailymotion, Facebook, Twitch, Google Drive or your file upload (*.mp4).
											<br><br><strong>For example:</strong><br><br>
											<code>https://www.youtube.com/watch?v=q8znjqjdA2I</code><br>
											<code>https://youtu.be/q8znjqjdA2I</code><br><br>
											<code>https://vimeo.com/channels/staffpicks/169993072</code><br>
											<code>https://vimeo.com/199169842</code><br><br>
											<code>http://www.dailymotion.com/video/x5s6bwc</code><br><br>
											<code>https://www.twitch.tv/videos/241287909</code><br>
											<code>https://www.twitch.tv/dotamajor</code><br><br>
											<code>https://www.facebook.com/leagueoflegends/videos/10157218236550556/</code><br><br>
											<code>https://drive.google.com/file/d/1Igz_p03sJHiHu8XAy24FdKJXUtKay3AJ/view?usp=sharing</code><br><br>
											<strong>For self-hosted videos</strong>:<br>
											About Cross-platform and Cross-browser Support<br>
											If you want your video works in all platforms and browsers(HTML5 and Flash), you should provide various video formats for same video, if the video files are ready, enter one url per line. For Example: <br>
											<code>http://yousite.com/sample-video.m4v</code><br>
											<code>http://yousite.com/sample-video.ogv</code><br>
											Recommended Format Solution: mp4 + webmv + m4v + ogv + flv + wmv.', 'vidorev-extensions'), 
											array('br'=>array(), 'code'=>array(), 'strong'=>array())		
										),
					'attributes' 	=> array(
											'data-conditional-id'    => 'vid_download_mode',
											'data-conditional-value' => 'protect',
										),									
				));	
				
			$group_media_download = $video_player_settings->add_field(array(
				'id'          => 'vm_media_download',
				'type'        => 'group',	
				'description' => esc_html__('FREE Download files.', 'vidorev-extensions'),		
				'options'     => array(
					'group_title'   => esc_html__('File Download {#}', 'vidorev-extensions'),
					'add_button'	=> esc_html__('Add File', 'vidorev-extensions'),
					'remove_button' => esc_html__('Remove File', 'vidorev-extensions'),				
					'closed'		=> true,
				),
				'repeatable'  => true,
			));	
				$video_player_settings->add_group_field($group_media_download, array(
					'id'   			=> 'source_label',
					'name' 			=> esc_html__( 'Label', 'vidorev-extensions'),
					'type' 			=> 'text',
					'repeatable' 	=> false,
				));
				$video_player_settings->add_group_field($group_media_download, array(
					'id'   			=> 'source_file',
					'name' 			=> esc_html__( 'File', 'vidorev-extensions'),
					'type' 			=> 'file',
					'repeatable' 	=> false,
				));
			
			$yasr_get_multi_set = array( '' => esc_html__('Select an item', 'vidorev-extensions') );
			if(class_exists('YasrMultiSetData') && method_exists('YasrMultiSetData', 'returnMultiSetNames')){
				
				$refl_cl_gt_bee_t = new ReflectionMethod('YasrMultiSetData', 'returnMultiSetNames');					
				if($refl_cl_gt_bee_t->isStatic() && $refl_cl_gt_bee_t->isPublic()){
				
					global $wpdb;
					$multi_set=YasrMultiSetData::returnMultiSetNames();
					$n_multi_set = $wpdb->num_rows;
					
					if ($n_multi_set > 0) {
						foreach ($multi_set as $name) {
							$yasr_get_multi_set[$name->set_id] = $name->set_name;
						}
					}
				}
			}
			
			$yasr_get_multi_set_param =	array(
											'id' 			=> 'user_rating_multi_sets',
											'type'	 		=> 'select',
											'name' 			=> esc_html__('Multiple Set', 'vidorev-extensions'),
											'desc' 			=> esc_html__('Select set for video posts', 'vidorev-extensions'),
											'default' 		=> '',
											'column'  		=> false,
											'options'  		=> $yasr_get_multi_set,
											'attributes' 	=> array(
																'data-conditional-id'    => 'user_rating_mode',
																'data-conditional-value' => 'multi-sets',
															),	
										);
				
			$video_player_settings->add_field( array(			
				'id'        	=> 'user_rating',
				'name'      	=> esc_html__('User Rating', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Turn On/Off user rating. You will need to install Yasr – Yet Another Stars Rating plugin. Select "Default" to use settings in Theme Options > Single Video Settings', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'on'    	=> esc_html__('ON', 'vidorev-extensions'),
					'off'    	=> esc_html__('OFF', 'vidorev-extensions'),							
				),	
			));
				$video_player_settings->add_field( array(			
					'id'        	=> 'user_rating_position',
					'name'      	=> esc_html__('Where?', 'vidorev-extensions'),
					'type'      	=> 'select',			
					'column'  		=> false,
					'default'		=> 'before',	
					'options'       => array(
						'before' 	=> esc_html__('Before the post', 'vidorev-extensions'),
						'after'		=> esc_html__('After the post', 'vidorev-extensions'),								
					),
					'attributes' 	=> array(
											'data-conditional-id'    => 'user_rating',
											'data-conditional-value' => 'on',
										),	
				));
				
				$video_player_settings->add_field( array(			
					'id'        	=> 'user_rating_mode',
					'name'      	=> esc_html__('Rating Mode', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Select default rating mode for video post', 'vidorev-extensions'),
					'type'      	=> 'select',			
					'column'  		=> false,
					'default'		=> 'single',	
					'options'       => array(
						'single' 	=> esc_html__('Single', 'vidorev-extensions'),
						'multi-sets'=> esc_html__('Multiple Set', 'vidorev-extensions'),									
					),
					'attributes' 	=> array(
											'data-conditional-id'    => 'user_rating',
											'data-conditional-value' => 'on',
										),	
				));	
				
				$video_player_settings->add_field(
					$yasr_get_multi_set_param
				);
				
			$video_player_settings->add_field( array(			
				'id'        	=> 'ads_above_single_player',
				'name'      	=> esc_html__( '[AD] Above Video Player', 'vidorev-extensions'),
				'type'      	=> 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),			
				'column'  		=> false,
				'desc'        	=> 	esc_html__('This ad will be displayed above video player on your single post templates', 'vidorev-extensions'),				
			));		
		/*$video_player_settings*/
		
		/*$video_auto_fetch_settings*/
			$video_auto_fetch_settings = new_cmb2_box( array(
				'id'            => 'video_auto_fetch_settings',
				'title'         => esc_html__( 'Video Auto Fetch Settings', 'vidorev-extensions'),
				'object_types'  => array( 'post' ),
				'context'       => 'side',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			$video_auto_fetch_settings->add_field( array(			
				'id'        	=> 'vm_video_fetch',
				'name'      	=> esc_html__('Enable/Disable Auto Fetch Data', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Support: Youtube, Vimeo, Dailymotion, Twitch, Facebook', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'options'       => array(
					'on'    	=> esc_html__('Enable', 'vidorev-extensions'),
					'off'  		=> esc_html__('Disable', 'vidorev-extensions'),					
				),	
			));
		/*$video_auto_fetch_settings*/
		
		/*$video_fake_views_likes*/
			$video_fake_views_likes = new_cmb2_box( array(
				'id'            => 'video_fake_views_likes',
				'title'         => esc_html__( 'Fake Views/Likes', 'vidorev-extensions'),
				'object_types'  => array( 'post', 'vid_playlist', 'vid_channel', 'vid_actor', 'vid_director', 'vid_series' ),
				'context'       => 'side',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			$video_fake_views_likes->add_field( array(			
				'id'        	=> 'vm_fake_views',
				'name'      	=> esc_html__('Views', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,
				'attributes' => array(
					'type' => 'number',					
				),				
			));
			$video_fake_views_likes->add_field( array(			
				'id'        	=> 'vm_fake_likes',
				'name'      	=> esc_html__('Likes', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,	
				'attributes' => array(
					'type' => 'number',					
				),			
			));
			$video_fake_views_likes->add_field( array(			
				'id'        	=> 'vm_fake_dislikes',
				'name'      	=> esc_html__('Dislikes', 'vidorev-extensions'),
				'type'      	=> 'text',			
				'column'  		=> false,
				'attributes' => array(
					'type' => 'number',					
				),				
			));
		/*$video_fake_views_likes*/
		
		/*$gallery_settings*/
			$gallery_settings = new_cmb2_box( array(
				'id'            => 'gallery_settings',
				'title'         => esc_html__( 'Gallery Settings', 'vidorev-extensions'),
				'object_types'  => array( 'post' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			$gallery_settings->add_field( array(			
				'id'        	=> 'gallery_position',
				'name'      	=> esc_html__('Gallery Position', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select default gallery position for gallery posts', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    			=> esc_html__('Default', 'vidorev-extensions'),
					'basic'    		=> esc_html__('Basic', 'vidorev-extensions'),
					'special'    	=> esc_html__('Special', 'vidorev-extensions'),						
				),
				'images'        => array(
					''    			=> 'img/to-pic/to-default.jpg',
					'basic'    		=> 'img/to-pic/single-post-gallery-basic.jpg',
					'special'    	=> 'img/to-pic/single-post-gallery-special.jpg',					
				),	
			));
		/*$gallery_settings*/
		
		/*$quote_settings*/
			$quote_settings = new_cmb2_box( array(
				'id'            => 'quote_settings',
				'title'         => esc_html__( 'Quote Settings', 'vidorev-extensions'),
				'object_types'  => array( 'post' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			$quote_settings->add_field( array(			
				'id'        	=> 'quote_position',
				'name'      	=> esc_html__('Quote Position', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select default quote position for quote posts', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    			=> esc_html__('Default', 'vidorev-extensions'),
					'basic'    		=> esc_html__('Basic', 'vidorev-extensions'),
					'special'    	=> esc_html__('Special', 'vidorev-extensions'),						
				),
				'images'        => array(
					''    			=> 'img/to-pic/to-default.jpg',
					'basic'    		=> 'img/to-pic/single-post-quote-basic.jpg',
					'special'    	=> 'img/to-pic/single-post-quote-special.jpg',					
				),	
			));
		/*$quote_settings*/
		
		/*$post_options*/
			$post_options = new_cmb2_box( array(
				'id'            => 'post_options',
				'title'         => esc_html__( 'Post Options', 'vidorev-extensions'),
				'object_types'  => array( 'post' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true,
				'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
			));
			
			$post_options->add_field( array(			
				'id'        	=> 'main_layout',
				'name'      	=> esc_html__('Layout', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select "Default" to use settings in Theme Options > Styling.', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'wide'    	=> esc_html__('Wide', 'vidorev-extensions'),
					'boxed'    	=> esc_html__('Inbox', 'vidorev-extensions'),						
				),
				'images'        => array(
					''    		=> 'img/to-pic/to-default.jpg',
					'wide'    	=> 'img/to-pic/layout-wide.jpg',
					'boxed'    	=> 'img/to-pic/layout-inbox.jpg',					
				),	
			));
			
			$post_options->add_field( array(			
				'id'        	=> 'main_logo',
				'name'      	=> esc_html__('Logo', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$post_options->add_field( array(			
				'id'        	=> 'main_logo_retina',
				'name'      	=> esc_html__('Logo (Retina)', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$post_options->add_field( array(			
				'id'        	=> 'main_logo_mobile',
				'name'      	=> esc_html__('Main logo on mobile devices', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$post_options->add_field( array(			
				'id'        	=> 'main_logo_mobile_retina',
				'name'      	=> esc_html__('Main logo on mobile devices (Retina)', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$post_options->add_field( array(			
				'id'        	=> 'sticky_logo',
				'name'      	=> esc_html__('Logo for Sticky Menu', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));
			
			$post_options->add_field( array(			
				'id'        	=> 'sticky_logo_retina',
				'name'      	=> esc_html__('Logo for Sticky Menu (Retina)', 'vidorev-extensions'),
				'desc'       	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'file',			
				'column'  		=> false,
				'query_args' 	=> array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),		
			));	
			
			$post_options->add_field( array(			
				'id'        	=> 'main_nav_layout',
				'name'      	=> esc_html__('Main Navigation Layout', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select "Default" to use settings in Theme Options > Header.', 'vidorev-extensions'),
				'type'      	=> 'radio_image',			
				'column'  		=> false,
				'default'		=> '',
				'images_path'   => get_template_directory_uri(),
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'default'   => esc_html__('Default', 'vidorev-extensions'),
					'classic'   => esc_html__('Classic', 'vidorev-extensions'),
					'sport'    	=> esc_html__('Sport', 'vidorev-extensions'),
					'tech'    	=> esc_html__('Tech', 'vidorev-extensions'),
					'blog'    	=> esc_html__('Blog', 'vidorev-extensions'),
					'movie'    	=> esc_html__('Movie', 'vidorev-extensions'),	
					'side'    	=> esc_html__('Side', 'vidorev-extensions'),					
				),
				'images'        => array(
					''    		=> 'img/to-pic/to-default.jpg',
					'default'   => 'img/to-pic/header-1.jpg',
					'classic'   => 'img/to-pic/header-6.jpg',
					'sport'    	=> 'img/to-pic/header-2.jpg',
					'tech'    	=> 'img/to-pic/header-5.jpg',
					'blog'    	=> 'img/to-pic/header-3.jpg',
					'movie'    	=> 'img/to-pic/header-4.jpg',
					'side'    	=> 'img/to-pic/header-7.jpg',							
				),	
			));	
			
			$group_background_header = $post_options->add_field(array(
				'id'          => 'header_background',
				'type'        => 'group',			
				'options'     => array(
					'group_title'   => esc_html__( 'Header Background', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Leave blank to use settings in Theme Options > Header.', 'vidorev-extensions'),
					'closed'		=> true,
				),
				'repeatable'  => false,
			));
				$post_options->add_group_field($group_background_header, array(
					'id'   			=> 'background-color',
					'name' 			=> esc_html__( 'Background Color', 'vidorev-extensions'),
					'type' 			=> 'colorpicker',
					'options' 		=> array(
						'alpha' => true,
					),
					'repeatable' 	=> false,
				));
				$post_options->add_group_field($group_background_header, array(			
					'id'        	=> 'background-image',
					'name'      	=> esc_html__('Background Image', 'vidorev-extensions'),
					'type'      	=> 'file',
					'query_args' 	=> array(
						'type' => array(
							'image/gif',
							'image/jpeg',
							'image/png',
						),
					),
					'repeatable' 	=> false,		
				));	
				$post_options->add_group_field($group_background_header, array(
					'id'   				=> 'background-repeat',
					'name' 				=> esc_html__( 'Background Repeat', 'vidorev-extensions'),			
					'type' 				=> 'select',	
					'show_option_none' 	=> true,	
					'options' 			=> array(
						'no-repeat'		=> esc_html__( 'No Repeat', 'vidorev-extensions'),
						'repeat'		=> esc_html__( 'Repeat All', 'vidorev-extensions'),
						'repeat-x'		=> esc_html__( 'Repeat Horizontally', 'vidorev-extensions'),
						'repeat-y'		=> esc_html__( 'Repeat Vertically', 'vidorev-extensions'),
						'inherit'		=> esc_html__( 'Inherit', 'vidorev-extensions'),					
					),
					'repeatable' 		=> false,
				));				
				$post_options->add_group_field($group_background_header, array(
					'id'   				=> 'background-attachment',
					'name' 				=> esc_html__( 'Background Attachment', 'vidorev-extensions'),			
					'type' 				=> 'select',	
					'show_option_none' 	=> true,
					'options' 			=> array(
						'scroll'		=> esc_html__( 'Scroll', 'vidorev-extensions'),
						'fixed'			=> esc_html__( 'Fixed', 'vidorev-extensions'),
						'inherit'		=> esc_html__( 'Inherit', 'vidorev-extensions'),				
					),
					'repeatable' 		=> false,
				));				
				$post_options->add_group_field($group_background_header, array(
					'id'   				=> 'background-position',
					'name' 				=> esc_html__( 'Background Position', 'vidorev-extensions'),			
					'type' 				=> 'select',
					'show_option_none' 	=> true,
					'options' 			=> array(
						'center center'		=> esc_html__( 'Center Center', 'vidorev-extensions'),
						'left top'			=> esc_html__( 'Left Top', 'vidorev-extensions'),
						'left center'		=> esc_html__( 'Left Center', 'vidorev-extensions'),
						'left bottom'		=> esc_html__( 'Left Bottom', 'vidorev-extensions'),
						'center top'		=> esc_html__( 'Center Top', 'vidorev-extensions'),
						'center bottom'		=> esc_html__( 'Center Bottom', 'vidorev-extensions'),
						'right top'			=> esc_html__( 'Right Top', 'vidorev-extensions'),
						'right center'		=> esc_html__( 'Right Center', 'vidorev-extensions'),
						'right bottom'		=> esc_html__( 'Right Bottom', 'vidorev-extensions'),				
					),
					'repeatable' 		=> false,
				));
				$post_options->add_group_field($group_background_header, array(			
					'id'        	=> 'background-size',
					'name'      	=> esc_html__('Background Size', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'repeatable' 	=> false,
					'attributes'  => array(
						'placeholder' => esc_attr__( 'cover', 'vidorev-extensions'),
					),	
				));
				
			$post_options->add_field( array(			
				'id'        	=> 'theme_sidebar',
				'name'      	=> esc_html__('Sidebar', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select "Default" to use settings in Theme Options > Single Page Settings.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'right'    	=> esc_html__('Right', 'vidorev-extensions'),
					'left'  	=> esc_html__('Left', 'vidorev-extensions'),
					'hidden'  	=> esc_html__('Hidden', 'vidorev-extensions'),					
				),	
			));	
			
			$post_options->add_field( array(			
				'id'        	=> 'single_post_comment_type',
				'name'      	=> esc_html__('Comment Type', 'vidorev-extensions'),
				'desc'        	=> esc_html__('Select "Default" to use settings in Theme Options > Single Post Settings.', 'vidorev-extensions'),
				'type'      	=> 'select',			
				'column'  		=> false,
				'default'		=> '',	
				'options'       => array(
					''    		=> esc_html__('Default', 'vidorev-extensions'),
					'wp'  		=> esc_html__('WordPress Comment', 'vidorev-extensions'),
					'facebook'  => esc_html__('Facebook Comment', 'vidorev-extensions'),				
				),	
			));				
			
				
			$group_background_theme = $post_options->add_field(array(
				'id'          => 'theme_background',
				'type'        => 'group',			
				'options'     => array(
					'group_title'   => esc_html__('Background', 'vidorev-extensions'),
					'desc'        	=> esc_html__('Leave blank to use settings in Theme Options > Styling.', 'vidorev-extensions'),
					'closed'		=> true,
				),
				'repeatable'  => false,
			));
				$post_options->add_group_field($group_background_theme, array(
					'id'   			=> 'background-color',
					'name' 			=> esc_html__( 'Background Color', 'vidorev-extensions'),
					'type' 			=> 'colorpicker',
					'options' 		=> array(
						'alpha' => true,
					),
					'repeatable' 	=> false,
				));
				$post_options->add_group_field($group_background_theme, array(			
					'id'        	=> 'background-image',
					'name'      	=> esc_html__('Background Image', 'vidorev-extensions'),
					'type'      	=> 'file',
					'query_args' 	=> array(
						'type' => array(
							'image/gif',
							'image/jpeg',
							'image/png',
						),
					),
					'repeatable' 	=> false,		
				));	
				$post_options->add_group_field($group_background_theme, array(
					'id'   				=> 'background-repeat',
					'name' 				=> esc_html__( 'Background Repeat', 'vidorev-extensions'),			
					'type' 				=> 'select',	
					'show_option_none' 	=> true,	
					'options' 			=> array(
						'no-repeat'		=> esc_html__( 'No Repeat', 'vidorev-extensions'),
						'repeat'		=> esc_html__( 'Repeat All', 'vidorev-extensions'),
						'repeat-x'		=> esc_html__( 'Repeat Horizontally', 'vidorev-extensions'),
						'repeat-y'		=> esc_html__( 'Repeat Vertically', 'vidorev-extensions'),
						'inherit'		=> esc_html__( 'Inherit', 'vidorev-extensions'),					
					),
					'repeatable' 		=> false,
				));				
				$post_options->add_group_field($group_background_theme, array(
					'id'   				=> 'background-attachment',
					'name' 				=> esc_html__( 'Background Attachment', 'vidorev-extensions'),			
					'type' 				=> 'select',	
					'show_option_none' 	=> true,
					'options' 			=> array(
						'scroll'		=> esc_html__( 'Scroll', 'vidorev-extensions'),
						'fixed'			=> esc_html__( 'Fixed', 'vidorev-extensions'),
						'inherit'		=> esc_html__( 'Inherit', 'vidorev-extensions'),				
					),
					'repeatable' 		=> false,
				));				
				$post_options->add_group_field($group_background_theme, array(
					'id'   				=> 'background-position',
					'name' 				=> esc_html__( 'Background Position', 'vidorev-extensions'),			
					'type' 				=> 'select',
					'show_option_none' 	=> true,
					'options' 			=> array(
						'center center'		=> esc_html__( 'Center Center', 'vidorev-extensions'),
						'left top'			=> esc_html__( 'Left Top', 'vidorev-extensions'),
						'left center'		=> esc_html__( 'Left Center', 'vidorev-extensions'),
						'left bottom'		=> esc_html__( 'Left Bottom', 'vidorev-extensions'),
						'center top'		=> esc_html__( 'Center Top', 'vidorev-extensions'),
						'center bottom'		=> esc_html__( 'Center Bottom', 'vidorev-extensions'),
						'right top'			=> esc_html__( 'Right Top', 'vidorev-extensions'),
						'right center'		=> esc_html__( 'Right Center', 'vidorev-extensions'),
						'right bottom'		=> esc_html__( 'Right Bottom', 'vidorev-extensions'),				
					),
					'repeatable' 		=> false,
				));
				$post_options->add_group_field($group_background_theme, array(			
					'id'        	=> 'background-size',
					'name'      	=> esc_html__('Background Size', 'vidorev-extensions'),
					'type'      	=> 'text',			
					'repeatable' 	=> false,
					'attributes'  => array(
						'placeholder' => esc_attr__( 'cover', 'vidorev-extensions'),
					),	
				));
		/*$page_options*/
	}
}

add_action( 'cmb2_init', 'vidorev_cmb_post_options' );

if(!function_exists('vidorev_sanitization_cmb2_func')){
	function vidorev_sanitization_cmb2_func( $original_value, $args, $cmb2_field ) {
		return $original_value;
	}
}

if ( ! function_exists( 'beeteam368_custom_field_playlist_search' ) ) :
	function beeteam368_custom_field_playlist_search($field_args, $field){
		
		if(!defined('PLAYLIST_PM_PREFIX')){
			return;
		}
		
		$id          = $field->args( 'id' );
		$label       = $field->args( 'name' );
		$name        = $field->args( '_name' );
		$value       = $field->escaped_value();
		$description = $field->args( 'description' );
		$post_id	 = is_numeric($field->object_id)?$field->object_id:'';
		
		$old_playlists 		= get_post_meta($post_id, PLAYLIST_PM_PREFIX.'sync_playlist', true);
		$check_playlists	= array();
	?>
		<div class="custom-column-display">
			<p><label for="<?php echo esc_attr($id);?>"><?php echo esc_html($label);?></label></p>
			<p class="bee_select_2">
				<select id="<?php echo esc_attr($id);?>" data-placeholder="<?php echo esc_attr__('Select a Playlist', 'vidorev-extensions');?>" class="vidorev-admin-ajax admin-ajax-find-playlist-control" name="<?php echo esc_attr($name);?>[]" multiple>
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
																	'value' 	=> serialize( strval($post_id) ),
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
			</p>
			<p class="description"><?php echo wp_kses_post($description); ?></p>
		</div>
	<?php	
	}
endif;

if ( ! function_exists( 'beeteam368_custom_field_channel_search' ) ) :
	function beeteam368_custom_field_channel_search($field_args, $field){
		
		if(!defined('CHANNEL_PM_PREFIX')){
			return;
		}
		
		$id          = $field->args( 'id' );
		$label       = $field->args( 'name' );
		$name        = $field->args( '_name' );
		$value       = $field->escaped_value();
		$description = $field->args( 'description' );
		$post_id	 = is_numeric($field->object_id)?$field->object_id:'';
		
		$old_channels 	= get_post_meta($post_id, CHANNEL_PM_PREFIX.'sync_channel', true);
		$check_channels	= array();
	?>
		<div class="custom-column-display">
			<p><label for="<?php echo esc_attr($id);?>"><?php echo esc_html($label);?></label></p>
			<p class="bee_select_2">
				<select id="<?php echo esc_attr($id);?>" data-placeholder="<?php echo esc_attr__('Select a Channel', 'vidorev-extensions');?>" class="vidorev-admin-ajax admin-ajax-find-channel-control" name="<?php echo esc_attr($name);?>[]" multiple>
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
																	'value' 	=> serialize( strval($post_id) ),
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
			</p>
			<p class="description"><?php echo wp_kses_post($description); ?></p>
		</div>
	<?php	
	}
endif;

if(!function_exists('vidorev_adminAjaxGetAllPlaylists')){
	function vidorev_adminAjaxGetAllPlaylists(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=2)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true) )){
			wp_send_json($json_params);
			return;
			die();
		}
		
		$args_query = array(
			'post_type'				=> 'vid_playlist',
			'posts_per_page' 		=> 18,
			'post_status' 			=> 'any',
			'ignore_sticky_posts' 	=> 1,
			's'						=> $keyword,
			'nopaging'				=> true,
		);
		
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
add_action('wp_ajax_adminAjaxGetAllPlaylists', 'vidorev_adminAjaxGetAllPlaylists');
add_action('wp_ajax_nopriv_adminAjaxGetAllPlaylists', 'vidorev_adminAjaxGetAllPlaylists');

if(!function_exists('vidorev_adminAjaxGetAllChannels')){
	function vidorev_adminAjaxGetAllChannels(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=2)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true) )){
			wp_send_json($json_params);
			return;
			die();
		}
		
		$args_query = array(
			'post_type'				=> 'vid_channel',
			'posts_per_page' 		=> 18,
			'post_status' 			=> 'any',
			'ignore_sticky_posts' 	=> 1,
			's'						=> $keyword,
			'nopaging'				=> true,
		);
		
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
add_action('wp_ajax_adminAjaxGetAllChannels', 'vidorev_adminAjaxGetAllChannels');
add_action('wp_ajax_nopriv_adminAjaxGetAllChannels', 'vidorev_adminAjaxGetAllChannels');

if ( ! function_exists( 'beeteam368_get_field_post_format' ) ) :
	function beeteam368_get_field_post_format($field_args, $field){
		
		$id          = $field->args( 'id' );
		$label       = $field->args( 'name' );
		$name        = $field->args( '_name' );
		$value       = $field->escaped_value();
		$description = $field->args( 'description' );
		$post_id	 = is_numeric($field->object_id)?$field->object_id:'';
	?>
		<div class="custom-column-display get_field_post_format">			
			<input type="hidden" value="<?php echo esc_attr(get_post_format($post_id));?>" name="beeteam368_check_post_format">
		</div>
	<?php	
	}
endif;