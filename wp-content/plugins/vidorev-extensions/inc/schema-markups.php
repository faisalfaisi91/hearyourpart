<?php
if(!function_exists('beeteam368_return_schema_contentUrl_video')){
	function beeteam368_return_schema_contentUrl_video($post_id){
		$vm_video_url 	= apply_filters( 'vidorev_single_video_url', trim(get_post_meta($post_id, 'vm_video_url', true)), $post_id );						
		$contentUrl 	= add_query_arg(array('video_embed' => $post_id), get_permalink($post_id));
		
		if(isset($_GET['video_index']) && is_numeric($_GET['video_index'])){
			$vm_video_multi_links = get_post_meta($post_id, 'vm_video_multi_links', true);
			
			$multiple_links_structure = get_post_meta($post_id, 'multiple_links_structure', true);				
			if($multiple_links_structure=='multi' && is_array($vm_video_multi_links)){
				$new_arr_video_multi_links = array();

				$ivurl=0;
				foreach($vm_video_multi_links as $videolinks_group){
					if( is_array($videolinks_group) && isset($videolinks_group['ml_url_mm']) && trim($videolinks_group['ml_url_mm'])!=''){
						$exp_videolinks_group = explode(PHP_EOL, $videolinks_group['ml_url_mm']);
						foreach($exp_videolinks_group as $video_item){
							if(strpos($video_item, 'http://')!==false || strpos($video_item, 'https://')!== false || strpos($video_item, 'http')!==false){
								$new_arr_video_multi_links[$ivurl]['ml_url'] = $video_item;
								$ivurl++;
							}
						}
					}
				}
				
				if(count($new_arr_video_multi_links) > 0){
					$vm_video_multi_links = $new_arr_video_multi_links;
				}
			}
			
			$video_ml_index = ((int)trim($_GET['video_index'])) - 1;
						
			if( $video_ml_index > -1 && is_array($vm_video_multi_links) && isset($vm_video_multi_links[$video_ml_index]) && ((isset($vm_video_multi_links[$video_ml_index]['ml_url']) && trim($vm_video_multi_links[$video_ml_index]['ml_url'])!='')) ){				
				$vm_video_url = isset($vm_video_multi_links[$video_ml_index]['ml_url'])?trim($vm_video_multi_links[$video_ml_index]['ml_url']):'';
			}
		}
		
		if($vm_video_url!=''){
			$vm_video_network 	= vidorev_video_fetch_data::getVideoNetwork($vm_video_url);	
			if($vm_video_network!='embeded-code'){
				
				$contentUrl = $vm_video_url;
				
				if($vm_video_network == 'self-hosted'){
					$get_videos_html_format = explode(PHP_EOL, $vm_video_url);
					foreach($get_videos_html_format as $video_format){
						if(trim($video_format) != ''){
							$contentUrl = trim($video_format);
							break;
						}
					}
				}
			}
		}	
		
		return $contentUrl;
	}
}

if(!function_exists('beeteam368_return_schema')){
	function beeteam368_return_schema(){
		$schema = array();
		if(is_single()){
			$post_id 		= get_the_ID();
			$post_type 		= get_post_type($post_id);
			$post_format 	= get_post_format($post_id);
			
			if($post_type == 'post'){
				switch($post_format){
					case 'video':
						$schema['@context'] 		= 'https://schema.org';
						$schema['@type'] 			= 'VideoObject';
						$schema['name'] 			= get_the_title($post_id);
						$schema['description'] 		= get_the_excerpt($post_id);
						if(has_post_thumbnail($post_id)){
							$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_16x9_2x');
							if($img_src){
								$schema['thumbnailUrl'] = $img_src[0];
							}
						}
						$schema['uploadDate'] 		= get_the_time( 'c', $post_id );
						
						$duration = trim(get_post_meta($post_id, 'vm_duration', true));
						if($duration!='' && strtotime($duration)!==false){
														
							$ret 	= 'PT';
							$arr 	= array_reverse(explode(':', $duration));
							$ct 	= count($arr);
							if ($ct >= 3) $ret.=$arr[2].'H';
							if ($ct >= 2) $ret.=$arr[1].'M';
							if ($ct >= 1) $ret.=$arr[0].'S';
							
							$schema['duration']		= $ret;
						}				
											
						$schema['contentUrl'] 		= esc_url(beeteam368_return_schema_contentUrl_video($post_id));
						if(vidorev_get_redux_option('single_video_main_toolbar_share', 'on', 'switch')=='on' && vidorev_get_redux_option('single_video_main_toolbar_share_iframe', 'on', 'switch')=='on'){
							$schema['embedUrl'] 		= esc_url(add_query_arg(array('video_embed' => $post_id), get_permalink($post_id)));
						}
						$schema['publisher'] 		= array('@type' => 'Organization', 'name' => get_bloginfo('title'), 'logo' => array( '@type'=>'ImageObject', 'url' => trim(vidorev_get_redux_option('main_logo', '', 'media_get_src')) ));	
						
						$aggregateRating = vidorev_rating_average($post_id);
						if($aggregateRating!=''){
							$schema['aggregateRating'] 	= array('@type'=>'AggregateRating', 'ratingValue'=> $aggregateRating, 'reviewCount'=> vidorev_rating_average($post_id, true));
						}
						break;
						
					default:
					
						$schema['@context'] 		= 'https://schema.org';
						$schema['@type'] 			= 'NewsArticle';
						$schema['mainEntityOfPage'] = array('@type' => 'WebPage', '@id' => "https://google.com/article");
						$schema['headline'] 		= get_the_title($post_id);
						$schema['description'] 		= get_the_excerpt($post_id);
						$schema['datePublished'] 	= get_the_time( 'c', $post_id );
						$schema['dateModified'] 	= get_the_modified_time( 'c', $post_id );
						if(has_post_thumbnail($post_id)){
							$img_src = array();
							
							$img_src_1 = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_1x1_2x');
							if($img_src_1){
								array_push($img_src, $img_src_1[0]);
							}
							$img_src_2 = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_4x3_2x');
							if($img_src_2){
								array_push($img_src, $img_src_2[0]);
							}
							$img_src_3 = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'vidorev_thumb_16x9_2x');
							if($img_src_3){
								array_push($img_src, $img_src_3[0]);
							}
							
							if(count($img_src)>0){
								$schema['image'] = $img_src;	
							}
						}
						$author_id = get_post_field ('post_author', $post_id);
						$schema['author'] 			= array('@type' => 'Person', 'name' => get_the_author_meta( 'nickname', $author_id ));
						$schema['publisher'] 		= array('@type' => 'Organization', 'name' => get_bloginfo('title'), 'logo' => array( '@type'=>'ImageObject', 'url' => trim(vidorev_get_redux_option('main_logo', '', 'media_get_src')) ));						
				}
			}
		}
		
		if(count($schema)>0){
			echo '<script type="application/ld+json">'.json_encode($schema).'</script>';
		}
	}
}

add_action('wp_footer', 'beeteam368_return_schema');

if(!function_exists('beeteam368_return_og_tag')){
	function beeteam368_return_og_tag(){
		
		$meta_html = '';
		
		if(is_single()){
			$post_id 		= get_the_ID();
			$post_type 		= get_post_type($post_id);
			$post_format 	= get_post_format($post_id);
			if($post_type == 'post'){
				switch($post_format){
					case 'video':
						
						$meta_html.='<meta property="og:type" content="video.other">';
						$meta_html.='<meta property="og:video:url" content="'.esc_url(beeteam368_return_schema_contentUrl_video($post_id)).'">';
						if(vidorev_get_redux_option('single_video_main_toolbar_share', 'on', 'switch')=='on' && vidorev_get_redux_option('single_video_main_toolbar_share_iframe', 'on', 'switch')=='on'){
							$meta_html.='<meta property="og:video:secure_url" content="'.esc_url(add_query_arg(array('video_embed' => $post_id), get_permalink($post_id))).'">';
						}
						$meta_html.='<meta property="og:video:type" content="text/html">';
						$meta_html.='<meta property="og:video:width" content="1280">';
						$meta_html.='<meta property="og:video:height" content="720">';
						$posttags = get_the_tags();
						if($posttags){
							foreach($posttags as $tag) {
								$meta_html.='<meta property="video:tag" content="'.esc_attr($tag->name).'">';
							}
						}
						break;
				}
			}
		}
		
		if($meta_html!=''){
			echo $meta_html;
		}
	}
}
add_action('vidorev_meta_tags', 'beeteam368_return_og_tag');