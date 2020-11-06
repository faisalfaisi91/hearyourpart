<?php
if ( !function_exists('vidorev_social_sharing' ) ):
	function vidorev_social_sharing($post_id = 0, $extra_class = 's-grid big-icon', $echo = true){
		if($post_id==0){
			$post_id = get_the_ID();			
		}		
		
		$title 		= get_the_title($post_id);
		$picture 	= wp_get_attachment_url(get_post_thumbnail_id($post_id));
		$link		= get_permalink($post_id);
		$blog_info	= get_bloginfo('name');
		
		ob_start();
	?>
		<ul class="social-block <?php echo esc_attr($extra_class);?>">
			<?php if(vidorev_get_redux_option('share_facebook', 'off', 'switch')=='on'){?>	
			<li class="facebook-link">
				<a href="<?php echo esc_url('//facebook.com/sharer/sharer.php?u='.$link);?>" data-share="on" data-source="facebook" target="_blank" title="<?php echo esc_attr__('Share on Facebook', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-facebook"></i></span>						
				</a>
			</li>	
			<?php }
			if(vidorev_get_redux_option('share_twitter', 'off', 'switch')=='on'){
			?>				
			<li class="twitter-link">
				<a href="<?php echo esc_url('//twitter.com/share?text='.$title.'&url='.$link);?>" data-share="on" data-source="twitter" target="_blank" title="<?php echo esc_attr__('Share on Twitter', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-twitter"></i></span>						
				</a>
			</li>
			<?php }
			if(vidorev_get_redux_option('share_google_plus', 'off', 'switch')=='on'){
			?>	
			<li class="google-plus-link">
				<a href="<?php echo esc_url('//plus.google.com/share?url='.$link);?>" target="_blank" data-share="on" data-source="googleplus" title="<?php echo esc_attr__('Share on Google Plus', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-google-plus"></i></span>						
				</a>
			</li>	
            <?php }
			if(vidorev_get_redux_option('share_whatsapp', 'off', 'switch')=='on'){
			?>	
            <li class="whatsapp-link">
            	<a href="whatsapp://send?text=<?php echo vidorev_convert_special_text(esc_attr($title).' '.esc_url($link));?>" target="_blank" data-share="on" data-source="whatsapp" data-action="share/whatsapp/share" title="<?php echo esc_attr__('Share on WhatsApp', 'vidorev-extensions');?>">
                	<span class="icon"><i class="fa fa-whatsapp"></i></span>	
                </a>
			</li>	
			<?php }
			if(vidorev_get_redux_option('share_email', 'off', 'switch')=='on'){?>
			<li class="email-link">
				<a href="<?php echo 'mailto:?subject='.esc_url($title).'&body='.esc_url($link);?>" target="_blank" data-share="on" data-source="email" title="<?php echo esc_attr__('Email this', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-envelope"></i></span>						
				</a>
			</li>
			<?php }
			if(vidorev_get_redux_option('share_linkedin', 'off', 'switch')=='on'){
			?>			
			<li class="linkedin-link">
				<a href="<?php echo esc_url('//linkedin.com/shareArticle?mini=true&url='.$link.'&title='.$title.'&source='.$blog_info);?>" target="_blank" data-share="on" data-source="linkedin" title="<?php echo esc_attr__('Share on LinkedIn', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-linkedin"></i></span>						
				</a>
			</li>
			<?php }
			if(vidorev_get_redux_option('share_tumblr', 'off', 'switch')=='on'){
			?>	
			<li class="tumblr-link">
				<a href="<?php echo esc_url('//tumblr.com/share/link?url='.$link.'&name='.$title);?>" target="_blank" data-share="on" data-source="tumblr" title="<?php echo esc_attr__('Share on Tumblr', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-tumblr"></i></span>						
				</a>
			</li>
			<?php }
			if(vidorev_get_redux_option('share_pinterest', 'off', 'switch')=='on'){
			?>	
			<li class="pinterest-link">
				<a href="<?php echo esc_url('//pinterest.com/pin/create/button/?url='.$link.'&media='.$picture.'&description='.$title);?>" data-share="on" data-source="pinterest" target="_blank" title="<?php echo esc_attr__('Pin this', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-pinterest"></i></span>						
				</a>
			</li>
			<?php }
			if(vidorev_get_redux_option('share_vk', 'off', 'switch')=='on'){
			?>	
			<li class="vk-link">
				<a href="<?php echo esc_url('//vkontakte.ru/share.php?url='.$link);?>" target="_blank" data-share="on" data-source="vk" title="<?php echo esc_attr__('Share on VK', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-vk"></i></span>						
				</a>
			</li>	
			<?php }
            if(vidorev_get_redux_option('share_weibo', 'off', 'switch')=='on'){
			?>	
			<li class="vk-link">
				<a href="<?php echo esc_url('//service.weibo.com/share/share.php?url='.$link.'&title='.$title.'&pic='.$picture );?>" target="_blank" data-share="on" data-source="weibo" title="<?php echo esc_attr__('Share on Weibo', 'vidorev-extensions');?>">
					<span class="icon"><i class="fa fa-weibo" aria-hidden="true"></i></span>						
				</a>
			</li>	
			<?php }?>													
		</ul>
	<?php
		$output_string = ob_get_contents();
		ob_end_clean();	
		
		if($echo){	
			echo apply_filters( 'vidorev_social_sharing_html', $output_string );	
		}else{
			return apply_filters( 'vidorev_social_sharing_html', $output_string );
		}
	}
endif;

if(!function_exists('vidorev_social_sharing_otps')){
	function vidorev_social_sharing_otps($opt_name){
		if ( ! class_exists( 'Redux' ) ) {
			return;
		}		
		Redux::setSection( $opt_name, array(
			'title' 	=> esc_html__( 'Social Sharing', 'vidorev-extensions'),
			'id'    	=> 'social_share',
			'icon'  	=> 'el el-share',
			'fields'	=>	array(
				array(
					'id' 		=> 'share_facebook',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Facebook', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable Facebook Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_twitter',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Twitter', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable Twitter Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_google_plus',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Google Plus', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable Google Plus Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_linkedin',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('LinkedIn', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable LinkedIn Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_tumblr',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Tumblr', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable Tumblr Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_whatsapp',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('WhatsApp', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable WhatsApp Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_pinterest',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Pinterest', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable Pinterest Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_vk',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('VK', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable VK Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_weibo',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Weibo', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable Weibo Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
				array(
					'id' 		=> 'share_email',
					'type'	 	=> 'switch',
					'title' 	=> esc_html__('Email', 'vidorev-extensions'),
					'desc'      => esc_html__('Enable Email Share Button', 'vidorev-extensions'),				
					'default' 	=> false,
				),
			)
		));
	}
}
add_action('vidorev_social_sharing_otps', 'vidorev_social_sharing_otps', 10 , 1);

if(!function_exists('vidorev_social_accounts_elements')){
	function vidorev_social_accounts_elements(){
		$social_accounts = 	array( 
								array('facebook', esc_html__('Facebook', 'vidorev-extensions')), 
								array('twitter', esc_html__('Twitter', 'vidorev-extensions')), 
								array('google-plus', esc_html__('Google Plus', 'vidorev-extensions')), 
								array('linkedin', esc_html__('LinkedIn', 'vidorev-extensions')), 
								array('tumblr', esc_html__('Tumblr', 'vidorev-extensions')), 
								array('pinterest', esc_html__('Pinterest', 'vidorev-extensions')), 
								array('vk', esc_html__('VK', 'vidorev-extensions')), 
								array('youtube', esc_html__('Youtube', 'vidorev-extensions')), 
								array('instagram', esc_html__('Instagram', 'vidorev-extensions')),
							);	
		foreach($social_accounts as $social_account){
			$social_url 	= vidorev_get_redux_option($social_account[0], '');
			$social_label 	= $social_account[1];
			
			if($social_url != ''){					
			?>
				<li class="<?php echo esc_attr($social_account[0]);?>-link">
					<a href="<?php echo esc_url($social_url);?>" title="<?php echo esc_attr($social_label);?>" target="_blank">	
						<span class="icon">
							<i class="fa fa-<?php echo esc_attr($social_account[0]);?>"></i>
						</span>							
					</a>
				</li>
			<?php 
			}
		}	
						
		$custom_scs = vidorev_get_redux_option('custom_scs', '');
		if($custom_scs){
			foreach ($custom_scs as $custom_sc){
				if(isset($custom_sc["url"]) && isset($custom_sc['description']) && $custom_sc["url"]!='' && $custom_sc['description']!=''){
				?>
					<li class="<?php echo 'custom-'.esc_attr($custom_sc['description']);?>-link">
						<a href="<?php echo esc_url($custom_sc["url"]);?>" title="<?php echo esc_attr($custom_sc["title"]);?>" target="_blank">							
							<span class="icon">
								<i class="fa <?php echo esc_attr($custom_sc["description"]);?>"></i>
							</span>							
						</a>
					</li>
			<?php
				}
			}
		}
	}
}
add_action('vidorev_social_accounts_elements', 'vidorev_social_accounts_elements', 10 , 1);

if(!function_exists('vidorev_social_accounts_otps')){
	function vidorev_social_accounts_otps($opt_name){
		if ( ! class_exists( 'Redux' ) ) {
			return;
		}		
		
		Redux::setSection( $opt_name, array(
			'title' 	=> esc_html__( 'Social Accounts', 'vidorev-extensions'),
			'id'    	=> 'social_accs',
			'icon'  	=> 'el el-group',
			'fields'	=>	array(
				array(
					'id' 		=> 'facebook',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Facebook', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'twitter',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Twitter', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'google-plus',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Google Plus', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'linkedin',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('LinkedIn', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'tumblr',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Tumblr', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'pinterest',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Pinterest', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'vk',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('VK', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'youtube',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Youtube', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'instagram',
					'type'	 	=> 'text',
					'title' 	=> esc_html__('Instagram', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Enter full link to your profile page', 'vidorev-extensions'),
				),
				array(
					'id' 		=> 'custom_scs',
					'type'	 	=> 'slides',
					'title' 	=> esc_html__('Custom Social Account', 'vidorev-extensions'),
					'desc' 		=> esc_html__('Add more social account using Font Awesome Icons', 'vidorev-extensions'),
					'show' 		=> array(
								'title' 		=> true,
								'description' 	=> true,
								'url' 			=> true,							
					),
					'placeholder' => array(
						'title'           => esc_html__('Title', 'vidorev-extensions'),
						'description'     => esc_html__('FontAwesome Icons. Enter FontAwesome class (ex: fa-instagram)', 'vidorev-extensions'),
						'url'             => esc_html__('Enter full link to your social account (including http)', 'vidorev-extensions'),
					),
				),
			)
		));
	}
}
add_action('vidorev_social_accounts_otps', 'vidorev_social_accounts_otps', 10 , 1);