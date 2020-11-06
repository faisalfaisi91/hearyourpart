<?php
if ( ! function_exists( 'vidorev_register_video_ads_settings' ) ) :
	function vidorev_register_video_ads_settings() {
		
		$prefix = VIDEOADS_PM_PREFIX;

		$main_options = new_cmb2_box( array(
			'id'           			=> $prefix.'videoads_settings_page',
			'title'        			=> esc_html__( 'Video Advertising', 'vidorev-extensions'),
			'object_types' 			=> array( 'options-page' ),	
			'option_key'      		=> $prefix.'videoads_settings_page',			
			'parent_slug'     		=> 'vidorev-theme-settings',
		));

		$main_options->add_field( array(
			'name'    => esc_html__( 'Enable Video Advertising', 'vidorev-extensions'),
			'id'      => $prefix.'video_ads',
			'type'    => 'select',
			'default' => 'no',
			'options' => array(
				'no'	 => esc_html__( 'NO', 'vidorev-extensions'),
				'yes'   => esc_html__( 'YES', 'vidorev-extensions'),
			),
		));
		
		$main_options->add_field( array(
			'name'    => esc_html__( 'Video Ad Type And Format', 'vidorev-extensions'),
			'id'      => $prefix.'video_ads_type',
			'type'    => 'select',
			'default' => 'google_ima',
			'options' => array(
				'google_ima'	=> esc_html__( 'Google IMA (Interactive Media Ads)', 'vidorev-extensions'),
				'image'   		=> esc_html__( 'Image', 'vidorev-extensions'),
				'html5_video'	=> esc_html__( 'HTML5 Video', 'vidorev-extensions'),
				'html'   		=> esc_html__( 'HTML', 'vidorev-extensions'),
				'vast'   		=> esc_html__( 'VAST ( Only work with Fluid Player )', 'vidorev-extensions'),
				'dynamic_ad'   	=> esc_html__( 'Dynamic', 'vidorev-extensions'),
			),
		));
		
		/*Google IMA*/
		$group_google_ima = $main_options->add_field(array(
			'id'          => $prefix.'group_google_ima',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] Google IMA', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));		
		$main_options->add_group_field( $group_google_ima, array(
			'name' => esc_html__( 'Ad Tag URL (for desktop)', 'vidorev-extensions'),
			'id'   => $prefix.'ima_source',
			'type' => 'text_url',
			'repeatable' => true,
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
		));
		$main_options->add_group_field( $group_google_ima, array(
			'name' => esc_html__( 'Ad Tag URL (for tablet)', 'vidorev-extensions'),
			'id'   => $prefix.'ima_source_tablet',
			'type' => 'text_url',
			'repeatable' => true,
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
		));
		$main_options->add_group_field( $group_google_ima, array(
			'name' => esc_html__( 'Ad Tag URL (for mobile)', 'vidorev-extensions'),
			'id'   => $prefix.'ima_source_mobile',
			'type' => 'text_url',
			'repeatable' => true,
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
		));/*Google IMA*/	
		
		/*IMAGE*/
		$group_image = $main_options->add_field(array(
			'id'          => $prefix.'group_image',
			'type'        => 'group',
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
			'repeatable'  => true,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] Image Ads Group {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));		
		$main_options->add_group_field( $group_image, array(
			'name' => esc_html__( 'Image Source', 'vidorev-extensions'),
			'id'   => $prefix.'image_source',
			'type' => 'file',
			'repeatable' => false,
		));	
		$main_options->add_group_field( $group_image, array(
			'name' => esc_html__( 'Link Target', 'vidorev-extensions'),
			'id'   => $prefix.'image_link',
			'type' => 'text',
			'description' => esc_html__( 'Enter URL if you want this image to have a link.', 'vidorev-extensions'),
			'repeatable' => false,
		));/*IMAGE*/
		
		/*HTML5 Video*/
		$group_video = $main_options->add_field(array(
			'id'          => $prefix.'group_html5_video',
			'type'        => 'group',
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
			'repeatable'  => true,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] HTML5 Video Ads Group {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));		
		$main_options->add_group_field( $group_video, array(
			'name' => esc_html__( 'Video Source', 'vidorev-extensions'),
			'desc' => wp_kses(__('
						If you want your video works in all platforms and browsers, you should provide various video formats for same video, if the video files are ready, put them on the list. <br>
						Recommended Format Solution: mp4 + webm + ogg.', 'vidorev-extensions'), 
						array('br'=>array(), 'code'=>array(), 'strong'=>array())		
					  ),
			'id'   => $prefix.'video_source',
			'type' => 'file_list',
			'repeatable' => false,
		));	
		$main_options->add_group_field( $group_video, array(
			'name' => esc_html__( 'Link Target', 'vidorev-extensions'),
			'id'   => $prefix.'video_link',
			'type' => 'text',
			'description' => esc_html__( 'Enter URL if you want this video to have a link.', 'vidorev-extensions'),
			'repeatable' => false,
		));/*HTML5 Video*/	
		
		/*HTML*/
		$group_html = $main_options->add_field(array(
			'id'          => $prefix.'group_html',
			'type'        => 'group',			
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] HTML', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));
		$main_options->add_group_field( $group_html, array(
			'name' => esc_html__( 'Ads Source', 'vidorev-extensions'),
			'id'   => $prefix.'html_source',
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below - You will have to use CSS to customize this content. Make sure you can handle it.', 'vidorev-extensions'),
			'type' => 'textarea_code',
			'options' 		=> array( 'disable_codemirror' => true ),
			'repeatable' => true,
		));/*HTML*/
		
		/*VAST*/
		$main_options->add_field( array(
			'name'    => esc_html__( 'VPAID Mode', 'vidorev-extensions'),
			'id'      => $prefix.'vpaid_mode',
			'type'    => 'select',
			'default' => '',
			'options' => array(
				'no'	 => esc_html__( 'NO', 'vidorev-extensions'),
				'yes'  	 => esc_html__( 'YES', 'vidorev-extensions'),
			),
			'description' => esc_html__( 'To enable loading VPAID ads allowVPAID option has to be set to Yes (No by default).', 'vidorev-extensions'),
		));
		$group_vast_preroll = $main_options->add_field(array(
			'id'          => $prefix.'vast_preroll',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST preRoll', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));	
			$main_options->add_group_field( $group_vast_preroll, array(
				'name' => esc_html__( 'The url of the VAST XML', 'vidorev-extensions'),
				'id'   => $prefix.'vast_tag_pre',
				'type' => 'text_url',
				'repeatable' => false,
				'description' => esc_html__( 'Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions'),
			));
		
		$group_vast_postroll = $main_options->add_field(array(
			'id'          => $prefix.'vast_postroll',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST postRoll', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));
			$main_options->add_group_field( $group_vast_postroll, array(
				'name' => esc_html__( 'The url of the VAST XML', 'vidorev-extensions'),
				'id'   => $prefix.'vast_tag_post',
				'type' => 'text_url',
				'repeatable' => false,
				'description' => esc_html__( 'Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions'),
			));
			
		$group_vast_pauseroll = $main_options->add_field(array(
			'id'          => $prefix.'vast_pauseroll',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST pauseRoll', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));	
			$main_options->add_group_field( $group_vast_pauseroll, array(
				'name' => esc_html__( 'The url of the VAST XML', 'vidorev-extensions'),
				'id'   => $prefix.'vast_tag_pause',
				'type' => 'text_url',
				'repeatable' => false,
				'description' => esc_html__( 'Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions'),
			));	
		
		$group_vast_midroll = $main_options->add_field(array(
			'id'          => $prefix.'vast_midroll',
			'type'        => 'group',
			'repeatable'  => true,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST midRoll {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));
			$main_options->add_group_field( $group_vast_midroll, array(
				'name' => esc_html__( 'The url of the VAST XML', 'vidorev-extensions'),
				'id'   => $prefix.'vast_tag_mid',
				'type' => 'text_url',
				'repeatable' => false,
				'description' => esc_html__( 'Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions'),
			));
			$main_options->add_group_field( $group_vast_midroll, array(
				'name' => esc_html__( 'Timer', 'vidorev-extensions'),
				'id'   => $prefix.'vast_timer_seconds',
				'type' => 'text_small',
				'default' => '50',
				'repeatable' => false,
				'attributes' => array(
					'type' => 'number',
					'min'  => '1',
					'max'  => '99999999',
				),
				'description' => esc_html__( 'The number of seconds until the ad begins. Example: 10', 'vidorev-extensions'),
			));
		/*VAST*/
		
		/*Dynamic*/
		$group_dynamic = $main_options->add_field(array(
			'id'          => $prefix.'group_dynamic',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] Dynamic Ads', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));	
			$main_options->add_group_field( $group_dynamic, array(
				'name'    => esc_html__( 'Dynamic Type', 'vidorev-extensions'),
				'id'      => $prefix.'dynamic_type',
				'type'    => 'select',
				'default' => 'image',
				'options' => array(
					'image'	 => esc_html__( 'Image', 'vidorev-extensions'),
					'html'   => esc_html__( 'HTML', 'vidorev-extensions'),
				),
			));	
			
			$main_options->add_group_field( $group_dynamic, array(
				'name'    => esc_html__( 'Ad Size for Desktop', 'vidorev-extensions'),
				'id'      => $prefix.'dynamic_size_desktop',
				'type'    => 'select',
				'default' => '336x280',
				'options' => array(
					'336x280'	=> esc_html__( '336x280 (px)', 'vidorev-extensions'),
					'300x250'	=> esc_html__( '300x250 (px)', 'vidorev-extensions'),
					'728x90'	=> esc_html__( '728x90 (px)', 'vidorev-extensions'),
					'468x60'	=> esc_html__( '468x60 (px)', 'vidorev-extensions'),
					'250x250'	=> esc_html__( '250x250 (px)', 'vidorev-extensions'),
					'200x200'	=> esc_html__( '200x200 (px)', 'vidorev-extensions'),
				),
			));	
			$main_options->add_group_field( $group_dynamic, array(
				'name'    => esc_html__( 'Ad Size for Mobile', 'vidorev-extensions'),
				'id'      => $prefix.'dynamic_size_mobile',
				'type'    => 'select',
				'default' => '300x250',
				'options' => array(
					'300x250'	=> esc_html__( '300x250 (px)', 'vidorev-extensions'),
					'320x50'	=> esc_html__( '320x50 (px)', 'vidorev-extensions'),
					'320x100'	=> esc_html__( '320x100 (px)', 'vidorev-extensions'),
					'250x250'	=> esc_html__( '250x250 (px)', 'vidorev-extensions'),
					'200x200'	=> esc_html__( '200x200 (px)', 'vidorev-extensions'),
				),
			));	
			
			$main_options->add_group_field( $group_dynamic, array(
				'name'    => esc_html__( 'Vertial Align', 'vidorev-extensions'),
				'id'      => $prefix.'dynamic_vertial_align',
				'type'    => 'select',
				'default' => 'bottom',
				'options' => array(
					'bottom'	=> esc_html__( 'Bottom', 'vidorev-extensions'),
					'middle'	=> esc_html__( 'Middle', 'vidorev-extensions'),
					'top'		=> esc_html__( 'Top', 'vidorev-extensions'),
				),
			));	
			
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[Image] Source for Desktop', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_image_source',
				'type' => 'file',
				'repeatable' => false,
			));	
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[Image] Source for Mobile', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_image_source_mob',
				'type' => 'file',
				'repeatable' => false,
			));	
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[Image] Link Target', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_image_link',
				'type' => 'text',
				'description' => esc_html__( 'Enter URL if you want this image to have a link.', 'vidorev-extensions'),
				'repeatable' => false,
			));
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[HTML] Source for Desktop', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_html_source',
				'description' => esc_html__( 'You can also use Google Adsense code here. Or HTML blocks developed by you.', 'vidorev-extensions'),
				'type' => 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),
				'repeatable' => false,
			));
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[HTML] Source for Mobile', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_html_source_mob',
				'description' => esc_html__( 'You can also use Google Adsense code here. Or HTML blocks developed by you.', 'vidorev-extensions'),
				'type' => 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),
				'repeatable' => false,
			));
		/*Dynamic*/
		
		$main_options->add_field( array(
			'name'    		=> esc_html__( 'Ad shows up after (seconds)', 'vidorev-extensions'),
			'id'      		=> $prefix.'time_to_show_ads',
			'type'    		=> 'text',
			'description' 	=> esc_html__( 'Example: 0,40,150,368. If blank, defaults to: 0', 'vidorev-extensions'),			
		));
		$main_options->add_field( array(
			'name'    		=> esc_html__( 'Skip Ad - Clickable After (seconds)', 'vidorev-extensions'),
			'id'      		=> $prefix.'time_skip_ads',
			'type'    		=> 'text',
			'description' 	=> esc_html__( 'If blank, defaults to: 5', 'vidorev-extensions'),			
		));
		$main_options->add_field( array(
			'name'    		=> esc_html__( 'Hide Ad After (seconds)', 'vidorev-extensions'),
			'id'      		=> $prefix.'time_to_hide_ads',
			'type'    		=> 'text',
			'description' 	=> esc_html__( 'If blank, defaults to: 10', 'vidorev-extensions'),			
		));
		
		$ads_hide_options = array(
			'free' 		=> esc_html__('FREE - Hide from everyone', 'vidorev-extensions'),	
		);
		
		if ( defined( 'PMPRO_VERSION' ) ) {
			global $wpdb;
			$sqlQuery 	= "SELECT * FROM $wpdb->pmpro_membership_levels WHERE 1 = 1 ORDER BY id ASC";
			$levels 	= $wpdb->get_results($sqlQuery, OBJECT);
			foreach($levels as $level){
				$ads_hide_options['hide_ads_membership_'.$level->id] = $level->name.esc_html__( ' - Membership', 'vidorev-extensions');		
			}
		}
		
		$main_options->add_field( array(
			'name'    		=> esc_html__( 'Hide Ad for subscription groups', 'vidorev-extensions'),
			'id'      		=> $prefix.'hide_ads_membership',
			'type'    		=> 'multicheck',
			'options'		=> $ads_hide_options,		
		));
		
		$wc_mb_ads_hide_options = array(
			'free' 		=> esc_html__('FREE - Hide from everyone', 'vidorev-extensions'),	
		);
		
		if(class_exists( 'WooCommerce' ) && function_exists('wc_memberships')){
			$wc_mb_array = get_posts( array(
				'post_type' 		=> 'wc_membership_plan',
				'posts_per_page' 	=> -1,
			) );
			
			if($wc_mb_array){
				foreach($wc_mb_array as $level){
					$wc_mb_ads_hide_options[$level->ID] = $level->post_title.esc_html__( ' - Membership', 'vidorev-extensions');		
				}
			}			
		}
		
		$main_options->add_field( array(
			'name'    		=> esc_html__( 'Hide Ad for subscription groups ( WooCommerce Membership )', 'vidorev-extensions'),
			'id'      		=> $prefix.'hide_ads_membership_wc_mb',
			'type'    		=> 'multicheck',
			'options'		=> $wc_mb_ads_hide_options,		
		));
	}
endif;
add_action( 'cmb2_admin_init', 'vidorev_register_video_ads_settings' );

if ( ! function_exists( 'vidorev_register_video_ads_metabox' ) ) :
	function vidorev_register_video_ads_metabox() {
		
		$prefix = VIDEOADS_PM_PREFIX;

		$main_options = new_cmb2_box( array(
			'id'           	=> $prefix.'videoads_settings_post',
			'title'        	=> esc_html__( 'Video Advertising', 'vidorev-extensions'),
			'object_types' 	=> array( 'post' ),				
			'context'       => 'normal',
			'priority'      => 'default',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));

		$main_options->add_field( array(
			'name'    => esc_html__( 'Enable Video Advertising', 'vidorev-extensions'),
			'id'      => $prefix.'video_ads',
			'type'    => 'select',
			'default' => '',
			'options' => array(
				''	 	=> esc_html__( 'Default', 'vidorev-extensions'),
				'no'	 => esc_html__( 'NO', 'vidorev-extensions'),
				'yes'  	 => esc_html__( 'YES', 'vidorev-extensions'),
			),
			'description' => esc_html__( 'Select "Default" to use settings in VidoRev > Video Advertising.', 'vidorev-extensions'),
		));
		
		$main_options->add_field( array(
			'name'    => esc_html__( 'Video Ad Type And Format', 'vidorev-extensions'),
			'id'      => $prefix.'video_ads_type',
			'type'    => 'select',
			'default' => '',
			'options' => array(
				''	 			=> esc_html__( 'Default', 'vidorev-extensions'),
				'google_ima'	=> esc_html__( 'Google IMA (Interactive Media Ads)', 'vidorev-extensions'),
				'image'   		=> esc_html__( 'Image', 'vidorev-extensions'),
				'html5_video'	=> esc_html__( 'HTML5 Video', 'vidorev-extensions'),
				'html'   		=> esc_html__( 'HTML', 'vidorev-extensions'),
				'vast'   		=> esc_html__( 'VAST ( Only work with Fluid Player )', 'vidorev-extensions'),
				'dynamic_ad'   	=> esc_html__( 'Dynamic', 'vidorev-extensions'),
			),
			'description' => esc_html__( 'Select "Default" to use settings in VidoRev > Video Advertising.', 'vidorev-extensions'),
		));
		
		/*Google IMA*/
		$group_google_ima = $main_options->add_field(array(
			'id'          => $prefix.'group_google_ima',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] Google IMA', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));		
		$main_options->add_group_field( $group_google_ima, array(
			'name' => esc_html__( 'Ad Tag URL (for desktop)', 'vidorev-extensions'),
			'id'   => $prefix.'ima_source',
			'type' => 'text_url',
			'repeatable' => true,
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
		));
		$main_options->add_group_field( $group_google_ima, array(
			'name' => esc_html__( 'Ad Tag URL (for tablet)', 'vidorev-extensions'),
			'id'   => $prefix.'ima_source_tablet',
			'type' => 'text_url',
			'repeatable' => true,
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
		));
		$main_options->add_group_field( $group_google_ima, array(
			'name' => esc_html__( 'Ad Tag URL (for mobile)', 'vidorev-extensions'),
			'id'   => $prefix.'ima_source_mobile',
			'type' => 'text_url',
			'repeatable' => true,
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
		));/*Google IMA*/	
		
		/*IMAGE*/
		$group_image = $main_options->add_field(array(
			'id'          => $prefix.'group_image',
			'type'        => 'group',
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
			'repeatable'  => true,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] Image Ads Group {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));		
		$main_options->add_group_field( $group_image, array(
			'name' => esc_html__( 'Image Source', 'vidorev-extensions'),
			'id'   => $prefix.'image_source',
			'type' => 'file',
			'repeatable' => false,
		));	
		$main_options->add_group_field( $group_image, array(
			'name' => esc_html__( 'Link Target', 'vidorev-extensions'),
			'id'   => $prefix.'image_link',
			'type' => 'text',
			'description' => esc_html__( 'Enter URL if you want this image to have a link.', 'vidorev-extensions'),
			'repeatable' => false,
		));/*IMAGE*/
		
		/*HTML5 Video*/
		$group_video = $main_options->add_field(array(
			'id'          => $prefix.'group_html5_video',
			'type'        => 'group',
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below.', 'vidorev-extensions'),
			'repeatable'  => true,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] HTML5 Video Ads Group {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));		
		$main_options->add_group_field( $group_video, array(
			'name' => esc_html__( 'Video Source', 'vidorev-extensions'),
			'desc' => wp_kses(__('
							If you want your video works in all platforms and browsers, you should provide various video formats for same video, if the video files are ready, put them on the list. <br>
							Recommended Format Solution: mp4 + webm + ogg.', 'vidorev-extensions'), 
							array('br'=>array(), 'code'=>array(), 'strong'=>array())		
						),
			'id'   => $prefix.'video_source',
			'type' => 'file_list',
			'repeatable' => false,
		));	
		$main_options->add_group_field( $group_video, array(
			'name' => esc_html__( 'Link Target', 'vidorev-extensions'),
			'id'   => $prefix.'video_link',
			'type' => 'text',
			'description' => esc_html__( 'Enter URL if you want this video to have a link.', 'vidorev-extensions'),
			'repeatable' => false,
		));/*HTML5 Video*/		
		
		/*HTML*/
		$group_html = $main_options->add_field(array(
			'id'          => $prefix.'group_html',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] HTML', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));
		$main_options->add_group_field( $group_html, array(
			'name' => esc_html__( 'Ads Source', 'vidorev-extensions'),
			'id'   => $prefix.'html_source',
			'description' => esc_html__( 'Ads will be randomly downloaded. Data depending on the group that you configured below - You will have to use CSS to customize this content. Make sure you can handle it.', 'vidorev-extensions'),
			'type' => 'textarea_code',
			'options' 		=> array( 'disable_codemirror' => true ),
			'repeatable' => true,
		));/*HTML*/
		
		/*VAST*/
		$main_options->add_field( array(
			'name'    => esc_html__( 'VPAID Mode', 'vidorev-extensions'),
			'id'      => $prefix.'vpaid_mode',
			'type'    => 'select',
			'default' => '',
			'options' => array(
				'no'	 => esc_html__( 'NO', 'vidorev-extensions'),
				'yes'  	 => esc_html__( 'YES', 'vidorev-extensions'),
			),
			'description' => esc_html__( 'To enable loading VPAID ads allowVPAID option has to be set to Yes (No by default).', 'vidorev-extensions'),
		));
		$group_vast_preroll = $main_options->add_field(array(
			'id'          => $prefix.'vast_preroll',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST preRoll', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));	
			$main_options->add_group_field( $group_vast_preroll, array(
				'name' => esc_html__( 'The url of the VAST XML', 'vidorev-extensions'),
				'id'   => $prefix.'vast_tag_pre',
				'type' => 'text_url',
				'repeatable' => false,
				'description' => esc_html__( 'Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions'),
			));
		
		$group_vast_postroll = $main_options->add_field(array(
			'id'          => $prefix.'vast_postroll',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST postRoll', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));
			$main_options->add_group_field( $group_vast_postroll, array(
				'name' => esc_html__( 'The url of the VAST XML', 'vidorev-extensions'),
				'id'   => $prefix.'vast_tag_post',
				'type' => 'text_url',
				'repeatable' => false,
				'description' => esc_html__( 'Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions'),
			));
			
		$group_vast_pauseroll = $main_options->add_field(array(
			'id'          => $prefix.'vast_pauseroll',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST pauseRoll', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));	
			$main_options->add_group_field( $group_vast_pauseroll, array(
				'name' => esc_html__( 'The url of the VAST XML', 'vidorev-extensions'),
				'id'   => $prefix.'vast_tag_pause',
				'type' => 'text_url',
				'repeatable' => false,
				'description' => esc_html__( 'Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions'),
			));	
		
		$group_vast_midroll = $main_options->add_field(array(
			'id'          => $prefix.'vast_midroll',
			'type'        => 'group',
			'repeatable'  => true,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST midRoll {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));
			$main_options->add_group_field( $group_vast_midroll, array(
				'name' => esc_html__( 'The url of the VAST XML', 'vidorev-extensions'),
				'id'   => $prefix.'vast_tag_mid',
				'type' => 'text_url',
				'repeatable' => false,
				'description' => esc_html__( 'Please note the VAST tag XML response Content-Type must be either application/xml or text/xml.', 'vidorev-extensions'),
			));
			$main_options->add_group_field( $group_vast_midroll, array(
				'name' => esc_html__( 'Timer', 'vidorev-extensions'),
				'id'   => $prefix.'vast_timer_seconds',
				'type' => 'text_small',
				'default' => '50',
				'repeatable' => false,
				'attributes' => array(
					'type' => 'number',
					'min'  => '1',
					'max'  => '99999999',
				),
				'description' => esc_html__( 'The number of seconds until the ad begins. Example: 10', 'vidorev-extensions'),
			));
		/*VAST*/
		
		/*Dynamic*/
		$group_dynamic = $main_options->add_field(array(
			'id'          => $prefix.'group_dynamic',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( '[Video Advertising] Dynamic Ads', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add Another Source', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Source', 'vidorev-extensions'),
				'sortable'      => true,
			),
		));	
			$main_options->add_group_field( $group_dynamic, array(
				'name'    => esc_html__( 'Dynamic Type', 'vidorev-extensions'),
				'id'      => $prefix.'dynamic_type',
				'type'    => 'select',
				'default' => 'image',
				'options' => array(
					'image'	 => esc_html__( 'Image', 'vidorev-extensions'),
					'html'   => esc_html__( 'HTML', 'vidorev-extensions'),
				),
			));	
			
			$main_options->add_group_field( $group_dynamic, array(
				'name'    => esc_html__( 'Ad Size for Desktop', 'vidorev-extensions'),
				'id'      => $prefix.'dynamic_size_desktop',
				'type'    => 'select',
				'default' => '336x280',
				'options' => array(
					'336x280'	=> esc_html__( '336x280 (px)', 'vidorev-extensions'),
					'300x250'	=> esc_html__( '300x250 (px)', 'vidorev-extensions'),
					'728x90'	=> esc_html__( '728x90 (px)', 'vidorev-extensions'),
					'468x60'	=> esc_html__( '468x60 (px)', 'vidorev-extensions'),
					'250x250'	=> esc_html__( '250x250 (px)', 'vidorev-extensions'),
					'200x200'	=> esc_html__( '200x200 (px)', 'vidorev-extensions'),
				),
			));	
			$main_options->add_group_field( $group_dynamic, array(
				'name'    => esc_html__( 'Ad Size for Mobile', 'vidorev-extensions'),
				'id'      => $prefix.'dynamic_size_mobile',
				'type'    => 'select',
				'default' => '300x250',
				'options' => array(
					'300x250'	=> esc_html__( '300x250 (px)', 'vidorev-extensions'),
					'320x50'	=> esc_html__( '320x50 (px)', 'vidorev-extensions'),
					'320x100'	=> esc_html__( '320x100 (px)', 'vidorev-extensions'),
					'250x250'	=> esc_html__( '250x250 (px)', 'vidorev-extensions'),
					'200x200'	=> esc_html__( '200x200 (px)', 'vidorev-extensions'),
				),
			));	
			
			$main_options->add_group_field( $group_dynamic, array(
				'name'    => esc_html__( 'Vertial Align', 'vidorev-extensions'),
				'id'      => $prefix.'dynamic_vertial_align',
				'type'    => 'select',
				'default' => 'bottom',
				'options' => array(
					'bottom'	=> esc_html__( 'Bottom', 'vidorev-extensions'),
					'middle'	=> esc_html__( 'Middle', 'vidorev-extensions'),
					'top'		=> esc_html__( 'Top', 'vidorev-extensions'),
				),
			));	
			
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[Image] Source', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_image_source',
				'type' => 'file',
				'repeatable' => false,
			));
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[Image] Source for Mobile', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_image_source_mob',
				'type' => 'file',
				'repeatable' => false,
			));		
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[Image] Link Target', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_image_link',
				'type' => 'text',
				'description' => esc_html__( 'Enter URL if you want this image to have a link.', 'vidorev-extensions'),
				'repeatable' => false,
			));
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[HTML] Source', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_html_source',
				'description' => esc_html__( 'You can also use Google Adsense code here. Or HTML blocks developed by you.', 'vidorev-extensions'),
				'type' => 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),
				'repeatable' => false,
			));
			$main_options->add_group_field( $group_dynamic, array(
				'name' => esc_html__( '[HTML] Source for Mobile', 'vidorev-extensions'),
				'id'   => $prefix.'dyn_html_source_mob',
				'description' => esc_html__( 'You can also use Google Adsense code here. Or HTML blocks developed by you.', 'vidorev-extensions'),
				'type' => 'textarea_code',
				'options' 		=> array( 'disable_codemirror' => true ),
				'repeatable' => false,
			));
		/*Dynamic*/
		
		$main_options->add_field( array(
			'name'    		=> esc_html__( 'Ad shows up after (seconds)', 'vidorev-extensions'),
			'id'      		=> $prefix.'time_to_show_ads',
			'type'    		=> 'text',
			'description' 	=> esc_html__( 'Example: 0,40,150,368. If blank, defaults to: 0', 'vidorev-extensions'),			
		));
		$main_options->add_field( array(
			'name'    		=> esc_html__( 'Skip Ad - Clickable After (seconds)', 'vidorev-extensions'),
			'id'      		=> $prefix.'time_skip_ads',
			'type'    		=> 'text',
			'description' 	=> esc_html__( 'If blank, defaults to: 5', 'vidorev-extensions'),			
		));
		$main_options->add_field( array(
			'name'    		=> esc_html__( 'Hide Ad After (seconds)', 'vidorev-extensions'),
			'id'      		=> $prefix.'time_to_hide_ads',
			'type'    		=> 'text',
			'description' 	=> esc_html__( 'If blank, defaults to: 10', 'vidorev-extensions'),			
		));
	}
endif;
add_action( 'cmb2_init', 'vidorev_register_video_ads_metabox' );