<?php
if(!function_exists('vidorev_video_player_sub_toolbar')){
	function vidorev_video_player_sub_toolbar($post_id = NULL, $ext_id_sc = ''){
		if($post_id == NULL || vidorev_get_redux_option('single_video_sub_toolbar', 'off', 'switch') == 'off' || beeteam368_return_embed()){
			return;
		}
		
		$is_user_logged_in 	= is_user_logged_in();
	?>
		<div class="video-sub-toolbar">
		
			<?php if(vidorev_get_redux_option('single_video_sub_toolbar_like_dislike_view_block', 'on', 'switch') == 'on'){?>				
				<div class="tb-left">
					<div class="site__row">
											
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content view-like-information">
								<?php
									$viewcount 		= 0;
									$likecount 		= 0;
									$dislikecount 	= 0;
									
									if(function_exists('pvc_get_post_views')){
										$viewcount = number_format_i18n(pvc_get_post_views($post_id));
									}
																		
									if(function_exists('vidorev_get_like_count') && function_exists('vidorev_get_dislike_count')){
										$likecount = vidorev_get_like_count_full($post_id);
										$dislikecount = vidorev_get_dislike_count_full($post_id);
									}
									
									if($likecount + $dislikecount == 0 || $likecount + $dislikecount < 0){
										$likebar_percent = 0;
									}else{
										$likebar_percent = $likecount / ($likecount + $dislikecount) * 100;
									}									
																					
								?>
								<div class="view-count h4">
									<?php echo esc_html($viewcount).' '.esc_html__('Views', 'vidorev-extensions')?>
								</div>
								<div class="like-dislike-bar">
									<span class="like-dislike-bar-percent-control" style="width:<?php echo esc_attr($likebar_percent)?>%"></span>
								</div>
								<div class="like-dislike-infor">
									<div class="like-number"><span class="block-icon"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span><span class="like-count-full" data-id="<?php echo esc_attr($post_id);?>"><?php echo esc_html(number_format_i18n($likecount));?></span></div>
									<div class="dislike-number"><span  class="block-icon"><i class="fa fa-thumbs-down" aria-hidden="true"></i></span><span class="dislike-count-full" data-id="<?php echo esc_attr($post_id);?>"><?php echo esc_html(number_format_i18n($dislikecount));?></span></div>
									<span></span>
								</div>
							</div>
						</div>
						
					</div>	
				</div>
			<?php }?>
			
			<div class="tb-right">
				<div class="site__row">
				
					<?php if(vidorev_get_redux_option('single_video_sub_toolbar_facebook_block', 'on', 'switch') == 'on'){?>
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content facebook-like-share">
								<div class="fb-like" data-href="<?php echo esc_url(vidorev_get_post_url($post_id)); ?>" data-layout="button_count" data-action="<?php echo apply_filters('vidorev_data_action_facebook_format', esc_attr('like'))?>" data-size="large" data-show-faces="false" data-share="true"></div>
							</div>
						</div>	
					<?php }?>
					
					<?php
					if(vidorev_get_redux_option('single_video_sub_toolbar_channel_subscribe', 'off', 'switch') == 'on' && defined('CHANNEL_PM_PREFIX') && vidorev_get_option('vid_channel_subscribe_fnc', 'vid_channel_subscribe_settings', 'yes')=='yes'){
						
						$channel_id	= beeteam368_get_channel_by_post_id($post_id);						
						if($channel_id > 0){
						
							$class_subscribe 	= '';
							$prefix_channel_sub = 'channel_sub_';
							$channel_data 		= $prefix_channel_sub.$channel_id;
							$dataLogin			= 'none';
							
							if(is_user_logged_in()){			
								$current_user 		= wp_get_current_user();
								$user_id 			= (int)$current_user->ID;		
								$meta_id			= $channel_data.'_'.$user_id;
								$current_sub 		= get_the_author_meta($meta_id, $user_id);
								$dataLogin			= 'true';
								
								if($current_sub == $channel_data){
									$class_subscribe = 'channel-subscribed';
								}
							}
							
							$subscribed_count = vidorev_count_channel_subscribed($channel_data);						
					?>
							<div class="site__col toolbar-item">
								<div class="toolbar-item-content">								
									<a href="javascript:;" data-login="<?php echo esc_attr($dataLogin)?>" class="item-button channel-subscribe subscribe-control <?php echo esc_attr($class_subscribe);?>" data-channel-id="<?php echo esc_attr($channel_id);?>"> 
									
										<span class="subtollbartolltip">
											<span class="repeatthis"><?php esc_html_e('Subscribe', 'vidorev-extensions');?></span>
											<span class="repeatthis subscribed-count subscribed-count-control"><?php echo esc_html(apply_filters('vidorev_number_format', $subscribed_count));?></span>
										</span>
										
										<span class="subscribe"><span class="item-icon"><i class="fa fa-user-plus" aria-hidden="true"></i></span><span class="item-text"><?php esc_html_e('Subscribe', 'vidorev-extensions');?></span></span>
										<span class="subscribed"><span class="item-icon"><i class="fa fa-check-square" aria-hidden="true"></i></span><span class="item-text"><?php esc_html_e('Subscribed', 'vidorev-extensions');?></span></span>
										<span class="loadmore-loading">
											<span class="loadmore-indicator"> 
												<svg>
													<polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
													<polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
												</svg>
											</span>
										</span>
									</a>
								</div>
							</div>
					<?php
						}
					}
					
					if(vidorev_get_redux_option('single_video_sub_toolbar_add_playlist', 'off', 'switch') == 'on'){
					?>
				
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content">								
								<a href="javascript:;" class="item-button add-playlist add-video-to-playlist-control" data-post-id="<?php echo esc_attr($post_id);?>"> 
									<span class="subtollbartolltip"><span class="repeatthis"><?php echo esc_html__( 'Add To Playlist', 'vidorev-extensions');?></span></span>
									<span class="item-icon"><i class="fa fa-plus-circle" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Playlist', 'vidorev-extensions');?></span>
								</a>
							</div>
						</div>
					
					<?php 
					}
					if(vidorev_get_redux_option('single_video_sub_toolbar_report_button', 'on', 'switch') == 'on'){
						$current_user 	= wp_get_current_user();
						$user_id 		= (int)$current_user->ID;						
						$report_text = __( 'Report', 'vidorev-extensions');
						$report_class = '';
						
						if( $user_id > 0 ){						
							$meta_id		= $post_id.'|'.$user_id;
							$exists = get_posts(array(
								'post_type'   	=> 'video_report_check',
								'post_status' 	=> 'any',
								'posts_per_page'=> 1,			
								'meta_query'  	=> array(
									array(
										'key'     => 'post_report_id',
										'value'   => $meta_id,
										'compare' => '=',
									),
								),
							));
							
							if($exists){
								$report_text = __( 'Reported', 'vidorev-extensions');
								$report_class = 'complete-action';
							}
						}
					?>
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content report-block report-block-control">								
								<span class="item-button report-video-btn report-video-control <?php echo esc_attr($report_class);?>">
									<span class="subtollbartolltip"><span class="reportthis reported-control"><?php echo esc_html($report_text);?></span></span>
									<span class="item-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span><span class="item-text reported-control"><?php echo esc_html($report_text);?></span>
									<?php if ( !$is_user_logged_in ) {?>
										<span class="login-tooltip login-req"><span><?php echo esc_html__( 'Please Login to Report', 'vidorev-extensions');?></span></span>
									<?php }?>
								</span>
								
								<?php 
								$close_class = '';
								if ( !$is_user_logged_in || $report_class != '') {
									$close_class = 'not-login-yet';
									if(!$is_user_logged_in){
										$close_class = 'not-login-yet show-report-login';
									}elseif($report_class != ''){
										$close_class = 'not-login-yet show-report-already';
									}
								}?>	
															
								<div class="report-form report-form-control dark-background <?php echo esc_attr($close_class);?>">
									<div class="report-no-data report-no-data-control report-info report-info-control"><?php echo esc_html__( 'Please enter your reasons.', 'vidorev-extensions');?></div>
									<div class="report-error report-error-control report-info report-info-control"><?php echo esc_html__( 'Error!! please try again later.', 'vidorev-extensions');?></div>
									<div class="report-success report-success-control report-info report-info-control"><?php echo esc_html__( 'Many thanks for your report.', 'vidorev-extensions');?></div>
									<div class="report-success report-already report-info"><?php echo esc_html__( 'You have already reported this video.', 'vidorev-extensions');?></div>
									<div class="report-error report-error-login report-info"><?php echo esc_html__( 'Please login to report.', 'vidorev-extensions');?></div>
									<div class="report-text">
										<textarea maxlength="100" class="report-textarea report-textarea-control" placeholder="<?php echo esc_attr__( 'Reasons for reporting content [ maximum length: 100 ]', 'vidorev-extensions');?>" data-id="<?php echo esc_attr($post_id)?>"></textarea>
									</div>
									<div class="report-submit">
										<a href="javascript:;" class="basic-button basic-button-default report-submit-btn report-submit-control"><?php echo esc_html__( 'Report', 'vidorev-extensions');?></a>
									</div>										
								</div>

							</div>							
						</div>
					<?php }?>	
					
					<?php if(vidorev_get_redux_option('single_video_sub_toolbar_repeat_button', 'on', 'switch') == 'on'){?>	
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content">								
								<span class="item-button repeat-video-control single-repeat-video-control" data-id="<?php echo esc_attr($post_id);?>"> 
									<span class="subtollbartolltip"><span class="repeatthis"><?php echo esc_html__( 'Repeat', 'vidorev-extensions');?></span></span>
									<span class="item-icon"><i class="fa fa-retweet" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Repeat', 'vidorev-extensions');?></span> 
								</span>
							</div>
						</div>
					<?php }?>		
					
					<?php if(vidorev_get_redux_option('single_video_sub_toolbar_lightbox_button', 'on', 'switch') == 'on'){?>	
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content">
								<a href="javascript:;" class="item-button video-popup-control" data-id="<?php echo esc_attr($post_id);?>"> 
									<span class="subtollbartolltip"><span class="repeatthis"><?php echo esc_html__( 'Open Video in Lightbox', 'vidorev-extensions');?></span></span>
									<span class="item-icon"><i class="fa fa-arrows-alt" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Lightbox', 'vidorev-extensions');?></span>
								</a>
							</div>
						</div>	
					<?php }?>
					
					<?php if(vidorev_get_redux_option('single_video_sub_toolbar_donation_button', 'off', 'switch') == 'on'){?>						
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content">
								<div class="item-button donation-element"> 
									<?php 
									if(class_exists('PayPalDonations')){
										echo do_shortcode('[paypal-donation]');
									}
									?>
								</div>
							</div>
						</div>
					<?php }?>
					
					<?php 
					if(isset($_GET['series']) && is_numeric($_GET['series'])){
						global $post_type_add_param_to_url;
						$post_type_add_param_to_url = array(
							'series' => $_GET['series']
						);
						
						if(isset($_GET['video_index']) && is_numeric($_GET['video_index'])){
							$post_type_add_param_to_url = array(
								'series' 		=> $_GET['series'],
								'video_index' 	=> $_GET['video_index']
							);
						}
					}
					if(vidorev_get_redux_option('single_video_sub_toolbar_prev_video', 'off', 'switch') == 'on'){
						$prevVideo = vidorev_get_adjacent_video_by_id( $post_id, true, true );
					?>
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content">								
								<a href="<?php echo esc_url(vidorev_get_post_url($prevVideo)); ?>" class="item-button prev-video"> 
									<span class="subtollbartolltip"><span class="repeatthis"><?php echo esc_html__( 'Previous Video', 'vidorev-extensions');?></span></span>
									<span class="item-icon"><i class="fa fa-fast-backward" aria-hidden="true"></i></span><span class="item-text"><?php echo esc_html__( 'Prev', 'vidorev-extensions');?></span> 
								</a>
							</div>
						</div>
					<?php }?>
					
					<?php if(vidorev_get_redux_option('single_video_sub_toolbar_next_video', 'off', 'switch') == 'on'){						
						$nextVideo = vidorev_get_adjacent_video_by_id($post_id, false, true);	
					?>
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content">								
								<a href="<?php echo esc_url(vidorev_get_post_url($nextVideo)); ?>" class="item-button next-video"> 
									<span class="subtollbartolltip"><span class="repeatthis"><?php echo esc_html__( 'Next Video', 'vidorev-extensions');?></span></span>
									<span class="item-text"><?php echo esc_html__( 'Next', 'vidorev-extensions');?></span><span class="item-icon"><i class="fa fa-fast-forward" aria-hidden="true"></i></span>
								</a>
							</div>
						</div>
					<?php }
					if(isset($_GET['series']) && is_numeric($_GET['series'])){
						$post_type_add_param_to_url = NULL;	
					}					
					?>
					
					<?php if(vidorev_get_redux_option('single_video_sub_toolbar_more_videos', 'off', 'switch') == 'on' && $ext_id_sc == ''){?>
						<div class="site__col toolbar-item">
							<div class="toolbar-item-content">								
								<span class="item-button more-videos more-videos-control"> 
									<span class="subtollbartolltip"><span class="repeatthis"><?php echo esc_html__( 'More Videos', 'vidorev-extensions');?></span></span>
									<span class="item-text"><?php echo esc_html__( 'More Videos', 'vidorev-extensions');?></span><span class="item-icon"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></span>
								</span>
							</div>
						</div>
					<?php }?>	
					
				</div>
			</div>				
			
		</div>
		
		<div class="member-playlist-lightbox dark-background">
			<div class="playlist-lightbox-listing">
				<div class="playlist-close playlist-items-control">
					<i class="fa fa-times" aria-hidden="true"></i>
				</div>
				
				<div class="ajax-playlist-list ajax-playlist-list-control">
					<span class="loadmore-loading playlist-loading-control">
						<span class="loadmore-indicator"> 
							<svg>
								<polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
								<polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
							</svg>
						</span>
					</span>
				</div>
				
				<?php
                $submit_video_page = vidorev_get_redux_option('submit_video_page', '');
				if(function_exists('pll_get_post')){
					$submit_video_page_crr_lang = pll_get_post($submit_video_page);
					
					if(is_numeric($submit_video_page_crr_lang) && $submit_video_page_crr_lang>0){
						$submit_video_page = $submit_video_page_crr_lang;
					}
				}
				?>				
				<div class="playlist-item add-new-playlist">
					<a href="<?php echo ($submit_video_page!='' && is_numeric($submit_video_page)?esc_url(add_query_arg(array('submit_tab' => 'playlist'), get_permalink($submit_video_page))):'#')?>" target="_blank">
						<i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp; <?php echo esc_html__('Add New Playlist', 'vidorev-extensions')?>
					</a>					
				</div>
								
			</div>
			
		</div>		
	<?php
	}
}
add_action( 'vidorev_video_player_sub_toolbar', 'vidorev_video_player_sub_toolbar', 10, 2 );

if(!function_exists('vidorev_get_playlist_by_user_login')){
	function vidorev_get_playlist_by_user_login(){
		
		$theme_data = wp_get_theme();
		if(!defined('PLAYLIST_PM_PREFIX') || !isset($_POST['post_id']) || !is_numeric($_POST['post_id']) || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' ) || !is_user_logged_in()){
			echo '<div class="no-playlist">'.esc_html__('No playlists yet!', 'vidorev-extensions').'<br>'.esc_html__('You must be logged in to view your playlists!', 'vidorev-extensions').'</div>';
			die();
			return;
		}
		
		$post_id = $_POST['post_id'];
		
		ob_start();
				
			$current_user 		= wp_get_current_user();
			$user_id 			= (int)$current_user->ID;
			
			$args_query = array(
								'post_type'				=> 'vid_playlist',
								'posts_per_page' 		=> -1,
								'post_status' 			=> 'publish',
								'ignore_sticky_posts' 	=> 1,
								'author'				=> $user_id,							
							);	
							
			$playlist_query = get_posts($args_query);
			
			$playlist_query 	= new WP_Query($args_query);
			if($playlist_query->have_posts()):
				while($playlist_query->have_posts()):
					$playlist_query->the_post();
					
					$playlist_id = get_the_ID();
					
					$class_ready_in = '';
					
					$videos_in = get_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', true);					
					if(is_array($videos_in)){
						if (($i = array_search($post_id, $videos_in)) !== FALSE){						
							$class_ready_in = 'ready-in';						
						}else{
							$class_ready_in = '';	
						}
					}
					?>
					<div class="playlist-item">
						<div class="playlist-item-name"><?php echo esc_html(get_the_title());?></div><div class="playlist-item-btn">
						
							<a class="basic-button basic-button-default playlist-item-add-control <?php echo esc_attr($class_ready_in)?>" href="javascript:;" data-post-id="<?php echo esc_attr($post_id);?>" data-playlist-id="<?php echo esc_attr($playlist_id);?>">
								<i class="fa fa-plus-square add-icon" aria-hidden="true"></i>
								<i class="fa fa-check-square verify-icon" aria-hidden="true"></i>
							</a>
							
						</div>
					</div>
					<?php
				endwhile;
			else:
				echo '<div class="no-playlist">'.esc_html__('No playlists yet!', 'vidorev-extensions').'</div>';		
			endif;
			wp_reset_postdata();
			
		$output_string = ob_get_contents();
		ob_end_clean();	
		
		echo apply_filters( 'vidorev_playlist_lightbox_add', $output_string );
	
		die();
	}
}
add_action( 'wp_ajax_get_playlist_by_user_login', 'vidorev_get_playlist_by_user_login' );
add_action( 'wp_ajax_nopriv_get_playlist_by_user_login', 'vidorev_get_playlist_by_user_login' );

if(!function_exists('vidorev_add_post_to_playlist_by_user_login')){
	function vidorev_add_post_to_playlist_by_user_login(){
		
		$json_params = array();
		
		$theme_data = wp_get_theme();
		if(	!defined('PLAYLIST_PM_PREFIX') || !isset($_POST['post_id']) || !is_numeric($_POST['post_id']) || !isset($_POST['playlist_id']) || !is_numeric($_POST['playlist_id']) 
			|| !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).'true' ) || !is_user_logged_in()
		){
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$current_user 		= wp_get_current_user();
		$user_id 			= (int)$current_user->ID;
		
		$post_id 		= $_POST['post_id'];
		$playlist_id 	= $_POST['playlist_id'];
		
		$post_author = get_post_field( 'post_author', $playlist_id );
		
		if($post_author != $user_id){
			$json_params['error'] = '1';
			wp_send_json($json_params);			
			die();
			return;
		}
		
		$videos_in = get_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', true);					
		if(is_array($videos_in)){
						
			if (($i = array_search($post_id, $videos_in)) !== FALSE && isset($videos_in[$i])) {
				unset($videos_in[$i]);
				$json_params['success'] = 'not-in';						
			}else{				
				array_push($videos_in, $post_id);
				$json_params['success'] = 'in';	
			}						
			update_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', array_map('strval', $videos_in));
			
		}else{
			update_post_meta($playlist_id, PLAYLIST_PM_PREFIX.'videos', array_map('strval', array($post_id)));
			$json_params['success'] = 'in';
		}
		
		wp_send_json($json_params);			
		die();
	}
}

add_action( 'wp_ajax_add_post_to_playlist_by_user_login', 'vidorev_add_post_to_playlist_by_user_login' );
add_action( 'wp_ajax_nopriv_add_post_to_playlist_by_user_login', 'vidorev_add_post_to_playlist_by_user_login' );

if(!function_exists('vidorev_video_player_more_videos')){
	function vidorev_video_player_more_videos($post_id = NULL){
		if($post_id == NULL || vidorev_get_redux_option('single_video_sub_toolbar', 'off', 'switch') == 'off' || vidorev_get_redux_option('single_video_sub_toolbar_more_videos', 'off', 'switch') == 'off'){
			return;
		}
		
		$single_post_related_query = vidorev_get_redux_option('single_post_related_query',  'same-category');
		$single_post_related_order = vidorev_get_redux_option('single_post_related_order',  'latest');
		$single_post_related_count = 10;
		
		$related_query = array(
			'post_type'             => 'post',
			'post_status'           => 'publish',
			'posts_per_page'        => $single_post_related_count,
			'post__not_in'          => array($post_id),
			'ignore_sticky_posts'   => 1,
			'tax_query'				=> array(
				'relation' => 'AND',
				array(
					'taxonomy' 	=> 'post_format',
					'field' 	=> 'slug',
					'terms' 	=> array('post-format-video'),
					'operator' 	=> 'IN',
				)
			),
		);
		
		switch($single_post_related_order){
			case 'latest':
				$related_query['order'] 	= 'DESC';
				$related_query['orderby'] 	= 'date';
				break;
				
			case 'most-viewed':
				if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
					add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
					add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
					add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
				}
				break;
				
			case 'most-liked':
				if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
					add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
					add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
					add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));
					add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
					add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
				}
				break;
				
			case 'random':
				$related_query['orderby'] 	= 'rand';
				break;			
		}
		
		switch($single_post_related_query){
			case 'same-category':
				
				$categories = array();
				$post_categories = get_the_category($post_id);				
				if ( ! empty( $post_categories ) && count($post_categories) > 0) {
					foreach( $post_categories as $category ) {						
						array_push($categories, $category->term_id);
					}  
					
					$related_query['category__in'] =  $categories;
				}
							
				break;
				
			case 'same-tag':
				
				$tags = array();
				$post_tags = wp_get_post_tags( $post_id );
				
				if ( ! empty( $post_tags ) && count($post_tags) > 0) {
					foreach( $post_tags as $tag ) {						
						array_push($tags, $tag->term_id);
					}  
					
					$related_query['tag__in'] =  $tags;
				}
				
				break;	
		}
		
		$related_query_action = new WP_Query($related_query);
		
		switch($single_post_related_order){
			case 'most-viewed':
				if(class_exists('vidorev_like_view_sorting') && class_exists('Post_Views_Counter')){
					remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
					remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
					remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
				}
				break;
				
			case 'most-liked':
				if(class_exists('vidorev_like_view_sorting') && class_exists('vidorev_like_dislike_settings')){
					remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
					remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
					remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));	
					remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));				
					remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
				}
				break;			
		}
		
		if($related_query_action->have_posts()):
		?>
			<div class="show-more-videos show-more-videos-control">
				<div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
					<div class="blog-items blog-items-control site__row grid-small">
						<?php
						while($related_query_action->have_posts()):
							$related_query_action->the_post();
							$item_class = 'post-item site__col';
							if(get_the_ID() == $post_id){
								$item_class = 'post-item site__col current-playing';
							}
							?><article <?php post_class($item_class); ?>>
								<div class="post-item-wrap">				
									<?php 
									$image_ratio_case = vidorev_image_ratio_case('1x');
									do_action('vidorev_thumbnail', 'vidorev_thumb_16x9_0x', 'class-16x9', 1, NULL, $image_ratio_case); 
									?>
									
									<div class="listing-content">
										
										<h3 class="entry-title h6 post-title"> 
											<a href="<?php echo esc_url(vidorev_get_post_url()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title();?></a> 
										</h3>	
										
										<?php do_action( 'vidorev_posted_on', array('author', 'date-time'), 'archive' ); ?>	
										<?php do_action( 'vidorev_posted_on', array('', '', 'comment-count', 'view-count', 'like-count', 'dislike-count'), 'archive' ); ?>		
									
									</div>
									
								</div>
							</article><?php
						endwhile;	
						?>
					</div>
				</div>
			</div>
		<?php
		endif;
	
		wp_reset_postdata();
	}	
}
add_action( 'vidorev_video_player_more_videos', 'vidorev_video_player_more_videos', 10, 1 );