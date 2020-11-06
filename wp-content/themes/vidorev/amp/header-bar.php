<header id="top" class="amp-wp-header">
	<div>
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<?php 
			$main_logo_mobile	= '';
			$l_width			= 153;
			$l_height			= 30;
			
			if(is_single() || is_page()){
				$post_id				= get_the_ID();
				$main_logo_mobile		= trim(get_post_meta($post_id, 'main_logo_mobile', true));
				$main_logo_mobile_id	= trim(get_post_meta($post_id, 'main_logo_mobile_id', true));
			}			
			if($main_logo_mobile==''){
				$main_logo_mobile 		= trim(vidorev_get_redux_option('main_logo_mobile', '', 'media_get_src'));
				$main_logo_mobile_id 	= trim(vidorev_get_redux_option('main_logo_mobile', '', 'media_get_id'));
			}
			
			if($main_logo_mobile==''){
				$main_logo_mobile 	= get_template_directory_uri().'/img/logo-mobile.png';				
			}
			
			if(isset($main_logo_mobile_id) && is_numeric($main_logo_mobile_id)){
				$l_info = wp_get_attachment_metadata($main_logo_mobile_id);
				if($l_info){
					$l_width	= isset($l_info['width'])?$l_info['width']:153;
					$l_height	= isset($l_info['height'])?$l_info['height']:30;
				}
			}
			
			if ( $main_logo_mobile!='' ) { 
			?>
                <amp-img width="<?php echo esc_attr($l_width)?>" height="<?php echo esc_attr($l_height)?>" class="amp-wp-site-logo" src="<?php echo esc_url($main_logo_mobile);?>" alt="<?php esc_attr_e('Logo', 'vidorev');?>"></amp-img>
			<?php 
			}
			?>
		</a>

		<?php $canonical_link_url = $this->get( 'post_canonical_link_url' ); ?>
		<?php if ( $canonical_link_url ) : ?>
			<?php $canonical_link_text = $this->get( 'post_canonical_link_text' ); ?>
			<a class="amp-wp-canonical-link" href="<?php echo esc_url( $canonical_link_url ); ?>">
				<?php echo esc_html( $canonical_link_text ); ?>
			</a>
		<?php endif; ?>
	</div>
</header>
