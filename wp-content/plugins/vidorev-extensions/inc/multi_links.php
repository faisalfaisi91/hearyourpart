<?php
if ( !function_exists('vidorev_single_post_display_multi_links' ) ):
	function vidorev_single_post_display_multi_links($post_id = 0){
		if($post_id == 0){
			$post_id = get_the_ID();			
		}
		
		$vm_video_multi_links = get_post_meta($post_id, 'vm_video_multi_links', true);		
		
		$video_index = 0;
		if(isset($_GET['video_index']) && is_numeric($_GET['video_index'])){
			$video_index = (int)trim($_GET['video_index']);
		}		
		
		if(is_array($vm_video_multi_links)){
			
			$multiple_links_structure = get_post_meta($post_id, 'multiple_links_structure', true);	
			
			if($multiple_links_structure=='multi'){
				
				$new_arr_video_multi_links = array();
				$i = 1;
				$z = 0;
				$y = 0;
				global $post_type_add_param_to_url;
				if(isset($post_type_add_param_to_url) && is_array($post_type_add_param_to_url) && count($post_type_add_param_to_url)>0){
					$old_post_type_add_param_to_url = $post_type_add_param_to_url;
				}
				ob_start();
				foreach($vm_video_multi_links as $videolinks_group){
					$default_group = esc_html__('Multi-Links', 'vidorev-extensions').' '.$i;
					if(isset($videolinks_group['ml_label']) && trim($videolinks_group['ml_label'])!=''){
						$default_group = trim($videolinks_group['ml_label']);
					}
					?>
                    
                    <div class="series-items">
                    	<div class="series-items-wrap">
                        	<div class="series-name">
                            	<h5 class="extra-bold"><?php echo esc_html($default_group);?></h5>
                            </div>
                            <div class="series-listing">
                            	<?php								
								$exp_videolinks_group = explode(PHP_EOL, $videolinks_group['ml_url_mm']);
								foreach($exp_videolinks_group as $video_item){
									if(strpos($video_item, 'http://')!==false || strpos($video_item, 'https://')!== false || strpos($video_item, 'http')!==false){
										$new_arr_video_multi_links[$z]['ml_url'] = $video_item;																			
										$z++;	
										$post_type_add_param_to_url = array(
											'video_index' => $z,
										);
										if(isset($_GET['series']) && is_numeric($_GET['series'])){
											$post_type_add_param_to_url = array(
												'series' 		=> $_GET['series'],
												'video_index' 	=> $z,
											);
										}
										if(isset($_GET['playlist']) && is_numeric($_GET['playlist'])){
											$post_type_add_param_to_url = array(
												'playlist' 		=> $_GET['playlist'],
												'video_index' 	=> $z,
											);
										}
										$default_name = esc_html__('Link', 'vidorev-extensions').' '.$z;
										if(isset($new_arr_video_multi_links[$z-1]['ml_label'])){
											$default_name = $new_arr_video_multi_links[$z-1]['ml_label'];
										}
										?>
                                        <a href="<?php echo esc_url(vidorev_get_post_url($post_id));?>" class="series-item <?php if($video_index == $z){echo 'active-item';}?>" title="<?php echo esc_attr($default_name); ?>">
                                            <i class="fa fa-play-circle" aria-hidden="true"></i><span><?php echo esc_html($default_name); ?></span>
                                        </a>
                                        <?php										
									}else{
										$new_arr_video_multi_links[$y]['ml_label'] = $video_item;
										$y++;										
									}								
								}
								?>
                            </div>
                        </div>
                    </div>
                    
                    <?php
					$i++;					
				}
				$output_string = ob_get_contents();
				ob_end_clean();
				$post_type_add_param_to_url = NULL;
				if(isset($old_post_type_add_param_to_url)){
					$post_type_add_param_to_url = $old_post_type_add_param_to_url;
				}
				
				if(trim($output_string)!=''){
					echo '<div class="series-wrapper">'.$output_string.'</div>';
				}
				
			}else{
				
				if($video_index > count($vm_video_multi_links) || $video_index < 1){
					$video_index = 0;
				}
				
				$i = 1;
				global $post_type_add_param_to_url;
				if(isset($post_type_add_param_to_url) && is_array($post_type_add_param_to_url) && count($post_type_add_param_to_url)>0){
					$old_post_type_add_param_to_url = $post_type_add_param_to_url;
				}
				
				ob_start();
				foreach($vm_video_multi_links as $videolinks){			
					
					
					$default_name = esc_html__('Link', 'vidorev-extensions').' '.$i;
					$default_group = esc_html__('Multi-Links', 'vidorev-extensions');
					$default_original = __('Original Video', 'vidorev-extensions');
					$multi_links_title = trim(get_post_meta($post_id, 'multi_links_title', true));
					$original_video_title = trim(get_post_meta($post_id, 'original_video_title', true));
					if($multi_links_title != ''){
						$default_group = $multi_links_title;
					}
					if($original_video_title != ''){
						$default_original = $original_video_title;
					}
					
					if(isset($videolinks['ml_label']) && trim($videolinks['ml_label'])!=''){
						$default_name = trim($videolinks['ml_label']);
					}
					
					if($i == 1){
						$post_type_add_param_to_url = NULL;
						if(isset($_GET['series']) && is_numeric($_GET['series'])){
							$post_type_add_param_to_url = array(
								'series' 		=> $_GET['series'],							
							);
						}
						if(isset($_GET['playlist']) && is_numeric($_GET['playlist'])){
							$post_type_add_param_to_url = array(
								'playlist' 		=> $_GET['playlist'],								
							);
						}
					?>
						<a href="<?php echo esc_url(vidorev_get_post_url($post_id));?>" class="series-item <?php if($video_index == 0){echo 'active-item';}?>" title="<?php echo esc_attr($default_original); ?>">
							<i class="fa fa-play-circle" aria-hidden="true"></i><span><?php echo esc_html($default_original);?></span>
						</a>
					<?php
					}
					
					$post_type_add_param_to_url = array(
						'video_index' => $i
					);
					
					if(isset($_GET['series']) && is_numeric($_GET['series'])){
						$post_type_add_param_to_url = array(
							'series' 		=> $_GET['series'],
							'video_index' 	=> $i
						);
					}
					
					if(isset($_GET['playlist']) && is_numeric($_GET['playlist'])){
						$post_type_add_param_to_url = array(
							'playlist' 		=> $_GET['playlist'],
							'video_index' 	=> $i,
						);
					}
					?>
						
						<a href="<?php echo esc_url(vidorev_get_post_url($post_id));?>" class="series-item <?php if($video_index == $i){echo 'active-item';}?>" title="<?php echo esc_attr($default_name); ?>">
							<i class="fa fa-play-circle" aria-hidden="true"></i><span><?php echo esc_html($default_name);?></span>
						</a>
	
					<?php
					$i++;
				}
				$output_string = ob_get_contents();
				ob_end_clean();
				$post_type_add_param_to_url = NULL;
				if(isset($old_post_type_add_param_to_url)){
					$post_type_add_param_to_url = $old_post_type_add_param_to_url;
				}	
				
				if(trim($output_string)!=''){
					echo '<div class="series-wrapper"><div class="series-items"><div class="series-items-wrap"><div class="series-name"><h5 class="extra-bold">'.$default_group.'</h5></div><div class="series-listing">'.$output_string.'</div></div></div></div>';
				}
			}
		}
	}
endif;
add_action( 'vidorev_video_multi_links_element', 'vidorev_single_post_display_multi_links', 10 ,1 );