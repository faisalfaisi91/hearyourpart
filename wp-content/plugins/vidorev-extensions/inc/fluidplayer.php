<?php
if ( ! function_exists( 'vidorev_register_fluidplayer_settings' ) ) :
	function vidorev_register_fluidplayer_settings() {
		
		$prefix = FLUIDPLAYER_PM_PREFIX;

		$main_options = new_cmb2_box( array(
			'id'           			=> $prefix.'fluidplayer_settings_page',
			'title'        			=> esc_html__( 'Fluid Player', 'vidorev-extensions'),
			'object_types' 			=> array( 'options-page' ),	
			'option_key'      		=> $prefix.'fluidplayer_settings_page',			
			'parent_slug'     		=> 'vidorev-theme-settings',
		));

		$main_options->add_field( array(
			'name'    => esc_html__( 'Enable Fluid Player', 'vidorev-extensions'),
			'id'      => $prefix.'fluidplayer',
			'type'    => 'select',
			'default' => 'yes',
			'options' => array(
				'yes'   => esc_html__( 'YES', 'vidorev-extensions'),
				'no'	 => esc_html__( 'NO', 'vidorev-extensions'),				
			),
		));
		
		$main_options->add_field( array(
			'name'    => esc_html__( 'Fluid Player Version', 'vidorev-extensions'),
			'id'      => $prefix.'fluidplayer_version',
			'type'    => 'select',
			'default' => 'v2',
			'options' => array(
				'v2'   	=> esc_html__( 'V2', 'vidorev-extensions'),
				'v3'	=> esc_html__( 'V3', 'vidorev-extensions'),				
			),
		));
		
		/*Logo*/
		$group_styling = $main_options->add_field(array(
			'id'          => $prefix.'styling',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( 'Styling', 'vidorev-extensions'),				
				'sortable'      => true,
			),
		));
		
			$main_options->add_group_field( $group_styling, array(
				'name' => esc_html__( 'Logo URL', 'vidorev-extensions'),
				'id'   => $prefix.'logo_url',
				'type' => 'file',
				'repeatable' => false,
			));
			$main_options->add_group_field( $group_styling, array(
				'name' => esc_html__( 'Logo Hover URL', 'vidorev-extensions'),
				'id'   => $prefix.'logo_hover_url',
				'type' => 'file',
				'repeatable' => false,
			));
			$main_options->add_group_field( $group_styling, array(
				'name' => esc_html__( 'Logo Click URL', 'vidorev-extensions'),
				'id'   => $prefix.'logo_click_url',
				'type' => 'text_url',
				'repeatable' => false,
			));
			$main_options->add_group_field( $group_styling, array(
				'name'    => esc_html__( 'Display Logo', 'vidorev-extensions'),
				'id'      => $prefix.'display_logo',
				'type'    => 'select',
				'default' => 'top left',
				'options' => array(
					'top left'			=> esc_html__( 'Top Left', 'vidorev-extensions'),
					'top right'   		=> esc_html__( 'Top Right', 'vidorev-extensions'),
					'bottom left'		=> esc_html__( 'Bottom Left', 'vidorev-extensions'),
					'bottom right'   	=> esc_html__( 'Bottom Right', 'vidorev-extensions'),
				),
			));
			$main_options->add_group_field( $group_styling, array(
				'name' => esc_html__( 'Logo Opacity', 'vidorev-extensions'),
				'id'   => $prefix.'logo_opacity',
				'type' => 'text_small',
				'repeatable' => false,
				'attributes' => array(
					'type' => 'number',
					'min'  => '10',
					'max'  => '100'
				),
				'default' => 100,
			));
			$main_options->add_group_field( $group_styling, array(
				'name' => esc_html__( 'Logo Margin', 'vidorev-extensions'),
				'id'   => $prefix.'logo_margin',
				'type' => 'text_small',
				'repeatable' 	=> false,				
				'default' 		=> '15px',
			));
			$main_options->add_group_field( $group_styling, array(
				'name' => esc_html__( 'Primary Color', 'vidorev-extensions'),
				'id'   => $prefix.'primary_color',
				'type' => 'colorpicker',
				'repeatable' 	=> false,
			));
		/*Logo*/
		
		/*VAST CF*/
		$group_vast_configuration = $main_options->add_field(array(
			'id'          => $prefix.'vast_configuration',
			'type'        => 'group',
			'repeatable'  => false,
			'options'     => array(
				'group_title'   => esc_html__( 'VAST Configuration', 'vidorev-extensions'),
			),
		));
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Skip Button Caption', 'vidorev-extensions'),
				'id'   => $prefix.'skipbuttoncaption',
				'type' => 'text',
				'default' => esc_html__('Skip ad in [seconds]', 'vidorev-extensions'),
				'repeatable' => false,
				'description' => esc_html__( 'The text to display the countdown during an ad. The [seconds] placeholder is used for the second countdown. (Default: “Skip ad in [seconds]“)', 'vidorev-extensions'),
			));			
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Skip Button Click Caption', 'vidorev-extensions'),
				'id'   => $prefix.'skipbuttonclickcaption',
				'type' => 'textarea_code',
				'default' => 'Skip ad <span class="skip_button_icon"></span>',
				'options' => array( 'disable_codemirror' => true ),
				'repeatable' => false,
				'description' => esc_html__( 'This defines the text to show when the countdown is finished and the user can skip to the main video. (Default: ‘Skip ad ’)', 'vidorev-extensions'),
			));
			
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Ad Text', 'vidorev-extensions'),
				'id'   => $prefix.'adtext',
				'type' => 'text',
				'repeatable' => false,
				'description' => esc_html__( 'Custom text can be shown when an in-stream ad plays. This text appears in the top left corner of the player and will be set to the primary colour. ', 'vidorev-extensions'),
			));
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Ad Text Position', 'vidorev-extensions'),
				'id'   => $prefix.'adtextposition',
				'type'    => 'select',
				'default' => 'top left',
				'options' => array(
					'top left'			=> esc_html__( 'Top Left', 'vidorev-extensions'),
					'top right'   		=> esc_html__( 'Top Right', 'vidorev-extensions'),
					'bottom left'		=> esc_html__( 'Bottom Left', 'vidorev-extensions'),
					'bottom right'   	=> esc_html__( 'Bottom Right', 'vidorev-extensions'),
				),
				'repeatable' => false,
				'description' => esc_html__( 'That can have values, like ‘top right’, ‘top left’, ‘bottom right’, ‘bottom left’.', 'vidorev-extensions'),
			));			
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Ad CTA Text', 'vidorev-extensions'),
				'id'   => $prefix.'adctatext',
				'type' => 'text',
				'default' => esc_html__('Visit now!', 'vidorev-extensions'),
				'repeatable' => false,
				'description' => esc_html__( 'The landing page of the advertisement will show in the adCTAText area. You can add custom text above this URL, or you choose to disable this.', 'vidorev-extensions'),
			));
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Ad CTA Text Position', 'vidorev-extensions'),
				'id'   => $prefix.'adctatextposition',
				'type'    => 'select',
				'default' => 'bottom right',
				'options' => array(
					'disable'			=> esc_html__( 'Disable', 'vidorev-extensions'),
					'top left'			=> esc_html__( 'Top Left', 'vidorev-extensions'),
					'top right'   		=> esc_html__( 'Top Right', 'vidorev-extensions'),
					'bottom left'		=> esc_html__( 'Bottom Left', 'vidorev-extensions'),
					'bottom right'   	=> esc_html__( 'Bottom Right', 'vidorev-extensions'),
				),
				'repeatable' => false,
				'description' => esc_html__( 'That can have values, like ‘top right’, ‘top left’, ‘bottom right’, ‘bottom left’.', 'vidorev-extensions'),
			));			
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Vast Timeout', 'vidorev-extensions'),
				'id'   => $prefix.'vasttimeout',
				'type' => 'text_small',
				'default' => '5000',
				'attributes' => array(
					'type' => 'number',
					'min'  => '1000',
					'max'  => '10000',
				),
				'repeatable' => false,
				'description' => esc_html__( 'This parameter lets you set the time, in milliseconds, to wait for the VAST to load. (Default: 5000)', 'vidorev-extensions'),
			));
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Max Allowed Vast Tag Redirects', 'vidorev-extensions'),
				'id'   => $prefix.'maxallowedvasttagredirects',
				'type' => 'text_small',
				'default' => '3',
				'attributes' => array(
					'type' => 'number',
					'min'  => '1',
					'max'  => '10',
				),
				'repeatable' => false,
				'description' => esc_html__( 'Fluid Player supports VAST wrappers through .The maxAllowedVastTagRedirects sets the maximum allowed redirects (wrappers).', 'vidorev-extensions'),
			));
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Vertial Align (only for nonLinear, optional)', 'vidorev-extensions'),
				'id'   => $prefix.'valign',
				'type'    => 'select',
				'default' => 'bottom',
				'options' => array(
					'bottom'		=> esc_html__( 'Bottom', 'vidorev-extensions'),
					'top'   		=> esc_html__( 'Top', 'vidorev-extensions'),
					'middle'		=> esc_html__( 'Middle', 'vidorev-extensions'),
				),
				'repeatable' => false,
				'description' => esc_html__('The available vertical positions for nonLinear Ads: top, middle, bottom. Default: bottom.', 'vidorev-extensions'),
			));
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'nonLinear Duration (only for nonLinear, optional)', 'vidorev-extensions'),
				'id'   => $prefix.'nonlinearduration',
				'type' => 'text_small',
				'default' => '10',
				'attributes' => array(
					'type' => 'number',
					'min'  => '10',
					'max'  => '100',
				),
				'repeatable' => false,
				'description' => esc_html__( 'The number of seconds until the nonLinear Ad will be shown. If not set nor the minSuggestedDuration attribute of VAST XML than wont close until end of video.', 'vidorev-extensions'),
			));	
			$main_options->add_group_field( $group_vast_configuration, array(
				'name' => esc_html__( 'Size (only for nonLinear, optional)', 'vidorev-extensions'),
				'id'   => $prefix.'size',
				'type'    => 'select',
				'default' => '728x90',
				'options' => array(
					'728x90'		=> esc_html__( '728x90', 'vidorev-extensions'),
					'300x250'   	=> esc_html__( '300x250', 'vidorev-extensions'),
					'468x60'		=> esc_html__( '468x60', 'vidorev-extensions'),
				),
				'repeatable' => false,
				'description' => esc_html__('The dimension of the Ad. Supported sizes: 468x60, 300x250, 728x90', 'vidorev-extensions'),
			));	
		/*VAST CF*/
	}
endif;
add_action( 'cmb2_admin_init', 'vidorev_register_fluidplayer_settings' );