<?php
add_filter('vidorev_preview_control_class', function($class, $post_id, $post_type, $post_format){
	if(isset($post_id) && is_numeric($post_id) && $post_id > 0 && $post_type == 'post' && $post_format == 'video'){
		
		$preview_check = trim(get_post_meta($post_id, 'vid_preview_mode', true));
		
		if($preview_check == ''){
			$preview_check = vidorev_get_redux_option('vid_preview_mode', 'off', 'switch');
		}
		
		if($preview_check != 'off'){
			$class = ' wrap_preview wrap_preview_control';
			if($preview_check == 'screenshots'){
				$vm_screenshot_preview = get_post_meta($post_id, 'vm_screenshot_preview', true);
				if(is_array($vm_screenshot_preview)){
					$class.=' preview-screenshots';							
				}else{
					$class='';
				}				
			}else{
				$class.=' preview-df-video';
			}
		}
	}
	
	return $class;
	
}, 10, 4);

add_filter('vidorev_preview_action_control', function($html, $post_id, $post_type, $post_format, $size, $ratio, $wrapper, $ratio_case, $imdb_elms){
	if(isset($post_id) && is_numeric($post_id) && $post_id > 0 && $post_type == 'post' && $post_format == 'video'){
		$preview_check = trim(get_post_meta($post_id, 'vid_preview_mode', true));
		if($preview_check == 'screenshots'){
			$vm_screenshot_preview = get_post_meta($post_id, 'vm_screenshot_preview', true);
			if(is_array($vm_screenshot_preview)){
				$img_preview_arr = array();
				foreach($vm_screenshot_preview as $preview_item){
					if(is_array($preview_item) && isset($preview_item['preview_source_file_id']) && is_numeric($preview_item['preview_source_file_id'])){
						ob_start();
						do_action('vidorev_thumbnail', $size, $ratio, 7, $preview_item['preview_source_file_id'], $ratio_case);	
						$output_preview = ob_get_contents();
						ob_end_clean();	
						
						array_push($img_preview_arr, $output_preview);			
					}
				}
				
				if(count($img_preview_arr)>0){
					$rnd = rand();				
					return '<div class="preview-video preview-video-control" data-imgpreview="'.esc_attr($post_id.$rnd).'"><script>vidorev_jav_js_preview['.$post_id.$rnd.']='.wp_json_encode($img_preview_arr).'</script></div>';
				}
			}
		}elseif($preview_check != 'off'){
			return '<div class="preview-video preview-video-control" data-iframepreview="'.esc_url(add_query_arg(array('video_embed' => $post_id, 'preview_mode' => 1, 'watch_trailer' => 1), get_permalink($post_id))).'"></div>';
		}
	}

	return $html;

}, 10, 9);
