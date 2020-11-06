<?php
if(!function_exists('vidorev_add_social_profile')):
	function vidorev_add_social_profile( $user ) { 
	?>
		<h3><?php esc_html_e('Social Accounts', 'vidorev-extensions') ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="vpct_facebook"><?php echo esc_html__('Facebook', 'vidorev-extensions');?></label></th>
				<td>
					<input type="text" name="vpct_facebook" id="vpct_facebook" value="<?php echo esc_attr(get_the_author_meta( 'vpct_facebook', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php esc_html_e('Enter your Facebook profile url.', 'vidorev-extensions')?></span>
				</td>
			</tr>
			<tr>
				<th><label for="vpct_twitter"><?php echo esc_html__('Twitter', 'vidorev-extensions');?></label></th>
				<td>
					<input type="text" name="vpct_twitter" id="vpct_twitter" value="<?php echo esc_attr(get_the_author_meta( 'vpct_twitter', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php esc_html_e('Enter your Twitter profile url.', 'vidorev-extensions')?></span>
				</td>
			</tr>
			<tr>
				<th><label for="vpct_google_plus"><?php echo esc_html__('Google Plus', 'vidorev-extensions');?></label></th>
				<td>
					<input type="text" name="vpct_google_plus" id="vpct_google_plus" value="<?php echo esc_attr(get_the_author_meta( 'vpct_google_plus', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php esc_html_e('Enter your Google+ profile url.', 'vidorev-extensions')?></span>
				</td>
			</tr>
			<tr>
				<th><label for="vpct_linkedin"><?php echo esc_html__('LinkedIn', 'vidorev-extensions');?></label></th>
				<td>
					<input type="text" name="vpct_linkedin" id="vpct_linkedin" value="<?php echo esc_attr(get_the_author_meta( 'vpct_linkedin', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php esc_html_e('Enter your Linkedin profile url.', 'vidorev-extensions')?></span>
				</td>
			</tr>			
			<tr>
				<th><label for="vpct_tumblr"><?php echo esc_html__('Tumblr', 'vidorev-extensions');?></label></th>
				<td>
					<input type="text" name="vpct_tumblr" id="vpct_tumblr" value="<?php echo esc_attr(get_the_author_meta( 'vpct_tumblr', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php esc_html_e('Enter your Tumblr profile url.', 'vidorev-extensions')?></span>
				</td>
			</tr>
			<tr>
				<th><label for="vpct_pinterest"><?php echo esc_html__('Pinterest', 'vidorev-extensions');?></label></th>
				<td>
					<input type="text" name="vpct_pinterest" id="vpct_pinterest" value="<?php echo esc_attr(get_the_author_meta('vpct_pinterest', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php esc_html_e('Enter your Pinterest profile url.', 'vidorev-extensions')?></span>
				</td>
			</tr>
			<tr>
				<th><label for="vpct_vk"><?php echo esc_html__('VK', 'vidorev-extensions');?></label></th>
				<td>
					<input type="text" name="vpct_vk" id="vpct_vk" value="<?php echo esc_attr(get_the_author_meta('vpct_vk', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php esc_html_e('Enter your VK profile url.', 'vidorev-extensions')?></span>
				</td>
			</tr>
			<tr>
				<th><label for="vpct_email"><?php echo esc_html__('Email', 'vidorev-extensions');?></label></th>
				<td>
					<input type="text" name="vpct_email" id="vpct_email" value="<?php echo esc_attr(get_the_author_meta('vpct_email', $user->ID)); ?>" class="regular-text" /><br />
					<span class="description"><?php esc_html_e('Enter your Email address.', 'vidorev-extensions')?></span>
				</td>
			</tr>
			
		</table>
		
	<?php 
	}
endif;
add_action('show_user_profile', 'vidorev_add_social_profile');
add_action('edit_user_profile', 'vidorev_add_social_profile');

if(!function_exists('vidorev_save_social_profile')):
	function vidorev_save_social_profile( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) ){
			return false;
		}
		
		update_user_meta( $user_id, 'vpct_twitter', $_POST['vpct_twitter'] );
		update_user_meta( $user_id, 'vpct_facebook', $_POST['vpct_facebook'] );
		update_user_meta( $user_id, 'vpct_linkedin', $_POST['vpct_linkedin'] );
		update_user_meta( $user_id, 'vpct_google_plus', $_POST['vpct_google_plus'] );
		update_user_meta( $user_id, 'vpct_tumblr', $_POST['vpct_tumblr'] );
		update_user_meta( $user_id, 'vpct_pinterest', $_POST['vpct_pinterest'] );
		update_user_meta( $user_id, 'vpct_vk', $_POST['vpct_vk'] );
		update_user_meta( $user_id, 'vpct_email', $_POST['vpct_email'] );
	
	}
endif;

add_action( 'personal_options_update', 'vidorev_save_social_profile' );
add_action( 'edit_user_profile_update', 'vidorev_save_social_profile' );

if(!function_exists('vidorev_author_social_follow')){
	function vidorev_author_social_follow(){
	?>
    	<div class="author-social">
            <ul class="social-block s-grid light-style">                	                 
                <?php if(get_the_author_meta('vpct_facebook')!=''){ ?>
                <li class="facebook-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_facebook')); ?>" target="_blank" title="<?php echo esc_attr__('Facebook', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-facebook"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_twitter')!=''){ ?>
                <li class="twitter-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_twitter')); ?>" target="_blank" title="<?php echo esc_attr__('Twitter', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-twitter"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_google_plus')!=''){ ?>
                <li class="google-plus-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_google_plus')); ?>" target="_blank" title="<?php echo esc_attr__('Google Plus', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-google-plus"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_linkedin')!=''){ ?>
                <li class="linkedin-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_linkedin')); ?>" target="_blank" title="<?php echo esc_attr__('LinkedIn', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-linkedin"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_tumblr')!=''){ ?>
                <li class="tumblr-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_tumblr')); ?>" target="_blank" title="<?php echo esc_attr__('Tumblr', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-tumblr"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_pinterest')!=''){ ?>
                <li class="pinterest-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_pinterest')); ?>" target="_blank" title="<?php echo esc_attr__('Pinterest', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-pinterest"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_vk')!=''){ ?>
                <li class="pinterest-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_vk')); ?>" target="_blank" title="<?php echo esc_attr__('VK', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-vk"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_email')!=''){ ?>
                <li class="email">                                                
                    <a href="mailto:<?php echo esc_url(get_the_author_meta('vpct_email'));?>" title="<?php echo esc_attr__('Email', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-envelope-o"></i></span>
                    </a>
                </li>
                <?php }?>
            </ul>
        </div>
    <?php	
	}
}
add_action( 'vidorev_author_social_follow', 'vidorev_author_social_follow' );

if(!function_exists('vidorev_single_author_social_follow')){
	function vidorev_single_author_social_follow($u_id = 0){
	?>
   		<div class="author-social">
            <ul class="social-block s-grid light-style">                	                 
                <?php if(get_the_author_meta('vpct_facebook', $u_id)!=''){ ?>
                <li class="facebook-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_facebook', $u_id)); ?>" target="_blank" title="<?php echo esc_attr__('Facebook', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-facebook"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_twitter', $u_id)!=''){ ?>
                <li class="twitter-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_twitter', $u_id)); ?>" target="_blank" title="<?php echo esc_attr__('Twitter', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-twitter"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_google_plus', $u_id)!=''){ ?>
                <li class="google-plus-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_google_plus', $u_id)); ?>" target="_blank" title="<?php echo esc_attr__('Google Plus', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-google-plus"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_linkedin', $u_id)!=''){ ?>
                <li class="linkedin-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_linkedin', $u_id)); ?>" target="_blank" title="<?php echo esc_attr__('LinkedIn', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-linkedin"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_tumblr', $u_id)!=''){ ?>
                <li class="tumblr-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_tumblr', $u_id)); ?>" target="_blank" title="<?php echo esc_attr__('Tumblr', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-tumblr"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_pinterest', $u_id)!=''){ ?>
                <li class="pinterest-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_pinterest', $u_id)); ?>" target="_blank" title="<?php echo esc_attr__('Pinterest', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-pinterest"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_vk', $u_id)!=''){ ?>
                <li class="pinterest-link">                                                
                    <a href="<?php echo esc_url(get_the_author_meta('vpct_vk', $u_id)); ?>" target="_blank" title="<?php echo esc_attr__('VK', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-vk"></i></span>
                    </a>
                </li>
                <?php }
                
                if(get_the_author_meta('vpct_email', $u_id)!=''){ ?>
                <li class="email">                                                
                    <a href="mailto:<?php echo esc_url(get_the_author_meta('vpct_email', $u_id));?>" title="<?php echo esc_attr__('Email', 'vidorev-extensions');?>">
                        <span class="icon"><i class="fa fa-envelope-o"></i></span>
                    </a>
                </li>
                <?php }?>
            </ul>
        </div>
    <?php	
	}
}

add_action( 'vidorev_single_author_social_follow', 'vidorev_single_author_social_follow', 10, 1 );