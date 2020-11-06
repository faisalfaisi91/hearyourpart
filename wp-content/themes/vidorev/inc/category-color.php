<?php
if(!function_exists('vidorev_save_category')):
	function vidorev_save_category($term_id) {

		if( !defined('CATEGORY_PM_PREFIX') ){
			return;
		}
		
		$term_taxonomy_color_custom = get_option( 'term_taxonomy_color_custom', array() );
		
		if(!is_array($term_taxonomy_color_custom) || count($term_taxonomy_color_custom)==0){			
			$term_taxonomy_color_custom = array();
			add_option( 'term_taxonomy_color_custom', $term_taxonomy_color_custom, '', 'yes' );
		}		
		
		$text_color = '';
		if(isset($_POST[CATEGORY_PM_PREFIX.'text_color'])){
			$text_color = sanitize_text_field(trim($_POST[CATEGORY_PM_PREFIX.'text_color']));
		}
		
		$background_color = '';
		if(isset($_POST[CATEGORY_PM_PREFIX.'background_color'])){
			$background_color = sanitize_text_field(trim($_POST[CATEGORY_PM_PREFIX.'background_color']));
		}
		
		$arr_key = 'cat_'.$term_id;

		$term_taxonomy_color_custom[$arr_key]['text'] = $text_color;
		$term_taxonomy_color_custom[$arr_key]['background'] = $background_color;
		
		if(($text_color=='' || $text_color=='#') && ($background_color=='' || $background_color=='#')){
			unset($term_taxonomy_color_custom[$arr_key]);
		}
		
		update_option( 'term_taxonomy_color_custom', $term_taxonomy_color_custom);
	}
endif;
add_action( 'edited_category', 'vidorev_save_category', 10 );
add_action( 'create_category', 'vidorev_save_category', 10 );