<?php
if(!function_exists('vidorev_amazon_ads_html')){
	function vidorev_amazon_ads_html($post_id = NULL){
		if($post_id == NULL){
			$post_id = get_the_ID();
		}
		
		$amazon_id = trim(get_post_meta($post_id, 'vid_m_amazon_associates', true));
		
		if(is_numeric($amazon_id)){
			$amazon_ads = trim(get_post_meta($amazon_id, 'amazon_native_ad', true));		
			if($amazon_ads!=''){	
				echo '<div id="amazon-native-ad" class="amazon-native-ad">'.$amazon_ads.'</div>';
			}
		}
	}
}

add_action('vidorev_amazon_ads_html', 'vidorev_amazon_ads_html');

if(!function_exists('vidorev_amazon_product_link')){
	function vidorev_amazon_product_link($post_id = NULL){
		if($post_id == NULL){
			$post_id = get_the_ID();
		}
		
		$amazon_id = trim(get_post_meta($post_id, 'vid_m_amazon_associates', true));
		
		if(is_numeric($amazon_id)){
			$amazon_associates = trim(get_post_meta($amazon_id, 'amazon_associates', true));		
			if($amazon_associates!=''){	
				echo '<div class="amazon-product-link amazon-product-link-control active-item">'.$amazon_associates.'<span class="amazon-action amazon-action-control basic-button basic-button-default" data-action="open"><i class="fa fa-amazon" aria-hidden="true"></i><span>'.esc_html__('Open', 'vidorev-extensions').'</span><i class="fa fa-angle-down" aria-hidden="true"></i></span><span class="amazon-action amazon-action-control basic-button basic-button-default" data-action="close"><i class="fa fa-amazon" aria-hidden="true"></i><span>'.esc_html__('Close', 'vidorev-extensions').'</span><i class="fa fa-angle-up" aria-hidden="true"></i></span></div>';
			}
		}
	}
}
add_action('vidorev_amazon_product_link', 'vidorev_amazon_product_link');