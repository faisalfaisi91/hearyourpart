<?php
if ( ! function_exists( 'vidorev_transfer_videos' ) ) :
	function vidorev_transfer_videos() {		
	?>
	<div class="wrap">
		<h2><strong><?php echo esc_html__('( Beta Version - 1.0 ) Transfer Videos to VidoRev', 'vidorev-extensions')?></strong></h2>
		
		<div class="metabox-holder">
			<div id="vidorev_transfer_videos">
				<div class="no-data"><?php echo esc_html__('No Data Found!!!', 'vidorev-extensions')?></div>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for="old_post_type_video_data"><?php echo esc_html__('[OLD] Post Type', 'vidorev-extensions')?></label>
							</th>
							<td>
								<input type="text" class="regular-text" id="old_post_type_video_data" name="old_post_type_video_data" placeholder="<?php echo esc_attr__('eg: post', 'vidorev-extensions')?>" value="<?php echo esc_attr('post')?>" style="width:35em; max-width:100%;">
								<p class="description"><?php echo esc_html__('Post Type from your old theme. Default: post', 'vidorev-extensions');?></p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="old_post_meta_video_data"><?php echo esc_html__('[OLD] Post Meta Data', 'vidorev-extensions')?></label>
							</th>
							<td>
								<input type="text" class="regular-text" id="old_post_meta_video_data" name="old_post_meta_video_data" placeholder="<?php echo esc_attr__('eg: dp_video_file, dp_video_url, dp_video_code', 'vidorev-extensions')?>" style="width:35em; max-width:100%;">
								<p class="description"><?php echo esc_html__('List of "Post Meta" that you need to convert, separated by a comma. For Example ( DeTube Theme ): dp_video_file, dp_video_url, dp_video_code', 'vidorev-extensions');?></p>
							</td>
						</tr>
						<tr>
							<th scope="row">
							</th>
							<td>
								<label for="already_been_converted"><input type="checkbox" id="already_been_converted" value="1" checked> <?php echo esc_html__('Ignore posts that have already been converted.', 'vidorev-extensions');?></label>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="settings-submit">
					<p class="submit">
						<input type="button" class="button button-primary button-large analyze-data-control" value="<?php echo esc_html__('ANALYZE', 'vidorev-extensions');?>">
					</p>							
				</div>	
			</div>
			
			<div id="vidorev_transfer_videos_action" style="display:none;">
				<div class="transfer-number">
					<span class="current-number">0</span>
					/
					<span class="total-number"></span>
				</div>
				<div class="loading-bar">
					<div class="loading"><span></span></div>
				</div>
				<div class="button-transfer">
					<?php 						
						$fetch_title 		= vidorev_get_redux_option('fetch_video_title', 'on', 'switch');					
						$fetch_description 	= vidorev_get_redux_option('fetch_video_description', 'on', 'switch');			
						$fetch_tags 		= vidorev_get_redux_option('fetch_video_tags', 'off', 'switch');
						
						$ex_class = '';	
						$ex_class_div = '';	
						if($fetch_title=='on' || $fetch_description=='on' || $fetch_tags=='on'){
							$ex_class = 'transfer-disable';	
							$ex_class_div = 'active';
						}		
					?>
					
					<div class="transfer-war <?php echo esc_attr($ex_class_div);?>">
						<strong style="font-size:20px;">
							<?php echo esc_html__('Please check the following before performing Data Transfer:', 'vidorev-extensions');?>							
						</strong>
						<br><br>
						<?php echo esc_html__('Fetch Video Title: OFF', 'vidorev-extensions');?><br>
						<?php echo esc_html__('Fetch Video Description: OFF', 'vidorev-extensions');?><br>
						<?php echo esc_html__('Fetch Video Tags: OFF', 'vidorev-extensions');?><br>
						<br><br>
						<img src="<?php echo esc_url(VPE_PLUGIN_URL.'/assets/front-end/img/turn-off-fetch.jpg');?>">
						<br><br><br>
					</div>
					
					<input type="button" class="button button-primary button-large transfer-data-control <?php echo esc_attr($ex_class);?>" value="<?php echo esc_html__('TRANSFER', 'vidorev-extensions');?>">					
					<input type="button" class="button button-primary button-large transfer-cancel-control" value="<?php echo esc_html__('CANCEL', 'vidorev-extensions');?>">
				</div>
			</div>
		</div>
	</div>
	<style>	
		.transfer-war{
			display:none;
		}
		.transfer-war.active{
			display:block !important;
		}
		.no-data{
			font-size:20px;
			font-weight:bold;
			margin-bottom:20px;
			color:#FF0000;
			display:none;
		}
		.no-data.active{
			display:block;
		}
		.transfer-disable{
			opacity:0.5 !important;
			pointer-events:none !important;
		}	
		.transfer-loading{
			opacity:0.5;
			pointer-events:none;
		}
		#vidorev_transfer_videos_action .transfer-number{
			font-size:20px;
			font-weight:bold;
			margin-bottom:20px;
		}
		#vidorev_transfer_videos_action .loading-bar{
			margin-bottom:30px;
		}
		#vidorev_transfer_videos_action .loading-bar .loading{
			position:relative;
			width:100%;
			height:30px;
			background-color:#6B6B6B;
			border:2px solid #000000;
		}
		
		#vidorev_transfer_videos_action .loading-bar .loading span{
			background-color:#CC0000;
			position:absolute;
			top:0;
			left:0;
			bottom:0;
			width:0;
		}
	</style>
	<script>
		;(function($){
			$(document).ready(function(){					
				$('.analyze-data-control').on('click', function(){
					var $t 				= $(this);
					$t.addClass('disable-button');
					$('#vidorev_transfer_videos').addClass('transfer-loading');	
						
					var newParamsRequest = {
						action:'vidorev_analyze_videos',
						'analyze':'yes',
						'post_type':$('#old_post_type_video_data').val(),
						'post_meta':$('#old_post_meta_video_data').val(),
						'already_convert':$('#already_been_converted').prop('checked'),
					}
					
					$.ajax({
						url:		'<?php echo esc_url(admin_url('admin-ajax.php'));?>',						
						type: 		'POST',
						data:		newParamsRequest,
						dataType: 	'json',
						cache:		false,
						success: 	function(data){	
						
							if(typeof(data)==='object'){
								
								if(typeof(data.total_posts)!=='undefined' && parseFloat(data.total_posts)>0){
									
									$('#vidorev_transfer_videos').find('.no-data').removeClass('active');
									
									var total_posts = parseFloat(data.total_posts),
										stop_action = 0;
									
									$('#vidorev_transfer_videos_action').find('.total-number').text(total_posts);
									
									$('.transfer-data-control').off('.transferData').on('click.transferData', function(){
										var $tc = $(this);										
										$tc.addClass('transfer-loading').val('<?php echo esc_attr__('PROCESSING...', 'vidorev-extensions')?>');
										
										var paged = 1,
											post_proc = 0;
										
										var transferAction = function(data){
											var param_action = {
												action:'vidorev_analyze_videos',
												'transfer':'yes',
												'post_type':data.post_type,
												'post_meta':data.post_meta,
												'already_convert':data.already_convert,
												'posts_per_page': 5,
												'paged': paged,
											}
											
											$.ajax({
												url:		'<?php echo esc_url(admin_url('admin-ajax.php'));?>',						
												type: 		'POST',
												data:		param_action,
												dataType: 	'json',
												cache:		false,
												success: 	function(results){	
													if(typeof(results)==='object' && typeof(results.total_proc)!=='undefined' && parseFloat(results.total_proc)>0){	
														
														post_proc = post_proc + parseFloat(results.total_proc);	
																						
														$('#vidorev_transfer_videos_action').find('.current-number').text(post_proc);									
														$('#vidorev_transfer_videos_action').find('.loading-bar .loading span').css({'width': (post_proc/total_posts*100)+'%' });	
															
														paged++;
														
														console.log(paged);
														
														if(stop_action===1){
															$('#vidorev_transfer_videos_action').find('.loading-bar .loading span').css({'width':0});
															$('#vidorev_transfer_videos_action').find('.current-number').text('0');
															$tc.removeClass('transfer-loading');
															return;
														}
																										
														transferAction(data);
														
													}else{
														if(paged > 1){
															$tc.val('<?php echo esc_attr__('COMPLETE: 100%', 'vidorev-extensions')?>');
														}
													}
													
												},
												error:		function(){
													
												},
											});
										}
										
										transferAction(data);
									});
									
									$('.transfer-cancel-control').off('.cancelTransferData').on('click.cancelTransferData', function(){
										
										stop_action = 1;
										
										$('.transfer-data-control').off('.transferData').removeClass('transfer-loading').val('<?php echo esc_attr__('TRANSFER', 'vidorev-extensions')?>');
										
										$('#vidorev_transfer_videos').removeClass('transfer-loading').show();
										
										$('#vidorev_transfer_videos_action').hide();
										
										$('#vidorev_transfer_videos_action').find('.loading-bar .loading span').css({'width':0});
										$('#vidorev_transfer_videos_action').find('.current-number').text('0');
										$('#vidorev_transfer_videos_action').find('.total-number').text('');
									});
									
									if(typeof(data.disable_transfer)!=='undefined' && data.disable_transfer == 1){
										$('#vidorev_transfer_videos_action').find('.transfer-war').addClass('active');
										$('.transfer-data-control').addClass('transfer-disable');
									}else{
										$('#vidorev_transfer_videos_action').find('.transfer-war').removeClass('active');
										$('.transfer-data-control').removeClass('transfer-disable');
									}
									
									$('#vidorev_transfer_videos').hide();
									$('#vidorev_transfer_videos_action').show();									
									
								}else{
									$('#vidorev_transfer_videos').removeClass('transfer-loading');
									$('#vidorev_transfer_videos').find('.no-data').addClass('active');
								}
								
							}else{
								$('#vidorev_transfer_videos').removeClass('transfer-loading');
								$('#vidorev_transfer_videos').find('.no-data').addClass('active');
							}
							
						},
						error:		function(){
							$('#vidorev_transfer_videos').removeClass('transfer-loading');
							$('#vidorev_transfer_videos').find('.no-data').addClass('active');
						},
					});	

				});
			});
		}(jQuery));
	</script>
	
	<?php	
	}
endif;

if ( ! function_exists( 'vidorev_transfer_videos_menu' ) ) :
	function vidorev_transfer_videos_menu(){
		add_submenu_page('vidorev-theme-settings', esc_html__( '[ Beta 1.0 ] Transfer Videos to VidoRev', 'vidorev-extensions'), esc_html__( '[ Beta 1.0 ] Transfer Videos to VidoRev', 'vidorev-extensions'), 'manage_options', 'vidorev_transfer_videos', 'vidorev_transfer_videos' );
	}
endif;

if(is_admin()){	
	add_action('admin_menu', 'vidorev_transfer_videos_menu');	
}

if(!function_exists('vidorev_analyze_videos_convert')){
	function vidorev_analyze_videos_convert(){
		if(!isset($_POST['post_type']) || !isset($_POST['post_meta']) || !isset($_POST['already_convert'])){
			return;
		}
		
		$params = array();
		$params['post_type'] 		= trim($_POST['post_type']);
		$params['post_meta'] 		= trim($_POST['post_meta']);
		$params['already_convert'] 	= trim($_POST['already_convert']);
		
		if($params['post_type']=='' || $params['post_meta']==''){
			return;
		}
		
		$args_query = array(
			'post_type'				=> $params['post_type'],
			'posts_per_page' 		=> 1,
			'post_status' 			=> 'any',
			'orderby'				=> 'ID',
			'order'					=> 'DESC',	
		);
		
		$transfer_action = false;
		
		if(isset($_POST['transfer']) && $_POST['transfer'] == 'yes'){
			$args_query['posts_per_page'] = (int)$_POST['posts_per_page'];
						
			if($params['already_convert'] == 'true'){
				$args_query['paged'] = 1;
			}else{
				$args_query['paged'] = (int)$_POST['paged'];
			}
			
			$transfer_action = true;
		}
		
		$metaQuery = explode(',', $params['post_meta']);
		
		$metaQueryArr = array();
		$metaQueryUpdate = array();
		
		foreach($metaQuery as $meta){	
			if(trim($meta) != ''){
				array_push($metaQueryArr, array(
					'key' 		=> trim($meta),
					'compare'	=> 'EXISTS',
				));
				
				array_push($metaQueryUpdate, trim($meta));
			}
		}
		
		if(count($metaQueryArr) == 0){
			return;
		}
		
		/*
		$metaQueryArr['relation'] = 'OR';
		$args_query['meta_query'] = $metaQueryArr;
		*/	
		
		if($params['already_convert'] == 'true'){
			$args_query['meta_query'] = array(
				'relation' => 'AND',
				array(
					'key'     => 'vidorev_transfer_data',
					'compare' => 'NOT EXISTS',
				),
				/*$metaQueryArr,*/
			);
		}
		
		$params['query'] = $args_query;
		
		$analyze_query = new WP_Query($args_query);
			$params['total_posts'] = $analyze_query->found_posts;	
			
			$i = 0;
			if($transfer_action){
				
				$results = array();
				
				if($analyze_query->have_posts()):
					while($analyze_query->have_posts()):
						$analyze_query->the_post();
						
						$post_id = get_the_ID();
						$complete = 0;
						
						foreach($metaQueryUpdate as $meta){
							$data = trim(get_post_meta($post_id, $meta, true));
							if($data != ''){
								
								if($params['post_type']!='post'){
									
									$postData = array();
									
									$postData['post_title']   	= get_post_field('post_title', $post_id);
									$postData['post_content'] 	= get_post_field('post_content', $post_id);
									$postData['post_excerpt'] 	= get_post_field('post_excerpt', $post_id);
									$postData['post_status']	= 'publish';
									
									$newPostID = wp_insert_post($postData);
									
									if(!is_wp_error($newPostID) && $newPostID){
										set_post_format($newPostID, 'video' );
										update_post_meta($newPostID, 'vm_video_url', $data);										
										update_post_meta($newPostID, 'vidorev_transfer_data', '1');
										
										$_POST['auto_fetch_extensions'] = 'on';
										
										$new_post = array(
											'ID' => $newPostID,
										);								
										wp_update_post( $new_post );
										
										$complete = 1;
									}
									
								}else{
									set_post_format($post_id, 'video' );
									update_post_meta($post_id, 'vm_video_url', $data);									
									update_post_meta($post_id, 'vidorev_transfer_data', '1');
									
									$multi_link_data = get_post_meta($post_id, 'tm_multi_link', true);
									if(is_array($multi_link_data) && count($multi_link_data)>0){
										
										update_post_meta($post_id, 'multiple_links_structure', 'multi');
										
										$new_multi_transfer_to_vidorev = array();
										$im = 0;
										foreach( $multi_link_data as $multi_link_item ) {
											if ( (isset( $multi_link_item['title'] ) && $multi_link_item['title'] != '') || (isset( $multi_link_item['links'] ) && $multi_link_item['links'] != '') ) {
												if(isset( $multi_link_item['title'] ) && $multi_link_item['title'] != ''){
													$new_multi_transfer_to_vidorev[$im]['ml_label'] = $multi_link_item['title'];
												}
												if(isset( $multi_link_item['links'] ) && $multi_link_item['links'] != ''){
													$new_multi_transfer_to_vidorev[$im]['ml_url_mm'] = $multi_link_item['links'];
												}
												$im++;
											}												
										}
										
										if(count($new_multi_transfer_to_vidorev) > 0){
											update_post_meta($post_id, 'vm_video_multi_links', $new_multi_transfer_to_vidorev);
										}
										
									}
									
									$new_post = array(
										'ID' => $post_id,
									);
									
									if(strpos($data, 'vimeo.com')!==false){
										update_post_meta($post_id, 'vm_video_fetch', 'off');
									}else{
										$_POST['auto_fetch_extensions'] = 'on';
										wp_update_post( $new_post );
									}
									
									$complete = 1;
									
									$results['current_post_ids'].=$post_id.',';
								}
								
								
								break;
							}
						}
						
						if($complete == 0){
							update_post_meta($post_id, 'vidorev_transfer_data', '1');
						}
						
						$i++;
					endwhile;	
					
					$results['total_proc'] = $i;
				endif;
				
				if($i==0){
					$results['total_proc'] = 0;
				}
				
				wp_reset_postdata();				
				wp_send_json($results);	
							
				return;	
			}			
				
		wp_reset_postdata();
		
		$fetch_title 		= vidorev_get_redux_option('fetch_video_title', 'on', 'switch');					
		$fetch_description 	= vidorev_get_redux_option('fetch_video_description', 'on', 'switch');			
		$fetch_tags 		= vidorev_get_redux_option('fetch_video_tags', 'off', 'switch');
		
		if($fetch_title=='on' || $fetch_description=='on' || $fetch_tags=='on'){
			$params['disable_transfer'] = 1;
		}
		
		wp_send_json($params);
		
		die();
	}
}

if(!function_exists('vidorev_analyze_videos_convert_ajax')){
	function vidorev_analyze_videos_convert_ajax(){
		if(is_admin() && ( (isset($_POST['analyze']) && $_POST['analyze']=='yes') || (isset($_POST['transfer']) && $_POST['transfer']=='yes') )){
			add_action('wp_ajax_vidorev_analyze_videos', 'vidorev_analyze_videos_convert');
			add_action('wp_ajax_nopriv_vidorev_analyze_videos', 'vidorev_analyze_videos_convert');	
		}	
	}
}

add_action('admin_init', 'vidorev_analyze_videos_convert_ajax');