<?php
if(!function_exists('vidorev_get_option')):
	function vidorev_get_option( $option, $section, $default = '' ) {
	
		$options = get_option( $section );
	
		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}
	
		return $default;
	}
endif;

if(!function_exists('vidorev_get_redux_option')):
	function vidorev_get_redux_option( $id, $default_value = '', $type = NULL ){ //type string, switch ...
		
		global $vidorev_theme_options;
		
		if(isset($vidorev_theme_options) && is_array($vidorev_theme_options) && isset($vidorev_theme_options[$id]) && $vidorev_theme_options[$id]!=''){
			
			switch($type){
				case 'switch':					
					if($vidorev_theme_options[$id]==1){
						return 'on';
					}else{
						return 'off';
					}
					break;
					
				case 'media_get_src':
					if(is_array($vidorev_theme_options[$id]) && isset($vidorev_theme_options[$id]['url']) && $vidorev_theme_options[$id]['url']!=''){
						return trim($vidorev_theme_options[$id]['url']);
					}else{
						return $default_value;
					}
					break;
					
				case 'media_get_id':
					if(is_array($vidorev_theme_options[$id]) && isset($vidorev_theme_options[$id]['id']) && $vidorev_theme_options[$id]['id']!=''){
						return trim($vidorev_theme_options[$id]['id']);
					}else{
						return $default_value;
					}
					break;				
			}
			
			return $vidorev_theme_options[$id];
				
		}
		
		return $default_value;
	}
endif;