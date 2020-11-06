<?php
if ( ! function_exists( 'vidorev_youtube_importer_videos' ) ) :
	function vidorev_youtube_importer_videos(){
	?>
	<div class="wrap">
		<h2><strong><?php echo esc_html__('Youtube Importer', 'vidorev-extensions')?></strong></h2>
		<div class="metabox-holder">
			<div id="vidorev_youtube_importer_videos">				
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for="video_source"><?php echo esc_html__('Source:', 'vidorev-extensions');?></label>
							</th>
							<td>
								<input type="text" class="regular-text" id="video_source" name="video_source" placeholder="<?php echo esc_attr__('eg: https://www.youtube.com/user/Battlefield ', 'vidorev-extensions')?>" style="width:35em; max-width:100%;">
								<p class="description">
								<?php echo 	
										wp_kses(
											__('Paste your [channel or playlist] urls to here.
											<br><br><strong>For Example:</strong>
											<br>https://www.youtube.com/watch?v=wqfofPnUpTo
											<br>https://www.youtube.com/user/Battlefield
											<br>https://www.youtube.com/channel/UCoDcFZ5KZ0KwBC_omalJuiA
											<br>https://www.youtube.com/playlist?list=PLZeek85Kuka2o8JkicDxLOh47frrPi10X', 
											'vidorev-extensions'
											),
											array(
												'br'=>array(), 
												'strong'=>array()
											)
										);
								?>
								</p>
							</td>
						</tr>						
					</tbody>
				</table>
				<div class="settings-submit">
					<p class="submit">
						<input type="button" class="button button-primary button-large analyze-youtube-control" value="<?php echo esc_html__('ANALYZE', 'vidorev-extensions');?>">
					</p>							
				</div>
				
				<div class="error-submit">
					<span class="error-source"><?php echo esc_html__('Cannot find appropriate URL, please input a URL.', 'vidorev-extensions');?></span>
					<span class="error-data"><?php echo esc_html__('Data Error!!! Please make sure query parameters are correct.', 'vidorev-extensions');?></span>
				</div>
				
				<div class="import-content">
					<table class="wp-list-table widefat striped">
						<thead>
							<tr>
								<td class="check-column">
									<input id="cb-select-all-1" type="checkbox">
								</td>
								<th class="column-thumb"><?php echo esc_html__('Thumbnail', 'vidorev-extensions');?></th>
								<th class="column-title"><?php echo esc_html__('Title', 'vidorev-extensions');?></th>
								<th class="column-status"><?php echo esc_html__('Import', 'vidorev-extensions');?></th>
							</tr>
						</thead>
						
						<tbody id="the-list">
							
						</tbody>
						
						<tfoot>
							<tr>
								<td class="check-column">
									<input id="cb-select-all-2" type="checkbox">
								</td>
								<th class="column-thumb"><?php echo esc_html__('Thumbnail', 'vidorev-extensions');?></th>
								<th class="column-title"><?php echo esc_html__('Title', 'vidorev-extensions');?></th>
								<th class="column-status"><?php echo esc_html__('Import', 'vidorev-extensions');?></th>
							</tr>
						</tfoot>
					</table>
					
					<div class="import-settings">
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<label for="import_post_status"><?php echo esc_html__('Post status:')?></label>
									</th>
									<td>										
										<select name="import_post_status" id="import_post_status">
											<option value="publish"><?php echo esc_html__('Published', 'vidorev-extensions');?></option>
											<option value="draft"><?php echo esc_html__('Draft', 'vidorev-extensions');?></option>
											<option value="pending"><?php echo esc_html__('Pending', 'vidorev-extensions');?></option>
											<option value="private"><?php echo esc_html__('Private', 'vidorev-extensions');?></option>											
										</select>            
									</td>
								</tr>
								
								<tr>
									<th scope="row">
										<?php echo esc_html__('Categories:')?>
									</th>
									<td>
										<?php 
										$all_categories = get_categories(array('hide_empty'=> 0));
										if($all_categories){
											foreach( $all_categories as $category ) {
										?>
												<label for="import_category_<?php echo esc_attr($category->term_id);?>" style="display:block; margin-bottom:10px;">
													<input type="checkbox" id="import_category_<?php echo esc_attr($category->term_id);?>" value="<?php echo esc_attr($category->term_id);?>" name="import_category[]">
													<?php echo esc_html($category->name);?>
												</label>
										<?php 
											}
										}
										?>
									</td>
								</tr>
								
								<tr>
									<th scope="row">
									</th>
									<td>
										<label for="import_post_date"><input type="checkbox" id="import_post_date" value="1" checked> <?php echo esc_html__('Fetch Video Published Date.', 'vidorev-extensions');?></label>
									</td>
								</tr>						
							</tbody>
						</table>
						
						<div class="import-submit">
							<p class="submit">
								<input type="button" class="button button-primary button-large import-youtube-control" value="<?php echo esc_html__('IMPORT', 'vidorev-extensions');?>">
							</p>							
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
	
	<style>	
	.import-content{
		margin-top:30px;
		display:none;
	}
	.import-content.show{
		display:block;
	}
	.import-content .column-thumb{
		width:60px;
	}
	.import-content .column-thumb img {
		width:60px;
		height:auto;
		display:block;
	}
	.import-loading{
		opacity:0.5 !important;
		pointer-events:none !important;
	}
	.error-submit{
		font-size:18px;
		font-weight:700;
		color:#FF0000;
	}
	.error-submit > *{
		display:none;
	}
	.error-submit > *.show {
		display:block;
	}
	
	.result-done{
		color:#209404;
	}
	
	.result-error{
		color:#FF0000;
	}
	</style>
	
	<script>
		;(function($){
			$(document).ready(function(){
				
				var api_url = 'https://www.googleapis.com/youtube/v3/',
					google_api_key = '<?php echo trim(vidorev_get_redux_option('google_api_key', ''));?>';
				
				/*get user ID*/
				youtube_user_parser = function(url){
					var idString 	= url.slice(url.indexOf('/user/')+6);
									
					if(idString!==''){
						return (idString.split('/'))[0];
					}		
					return '';	
				}/*get user ID*/
				
				/*get channel ID*/
				youtube_channel_parser = function(url){
					var idString 	= url.slice(url.indexOf('/channel/')+9);
						
					if(idString!==''){
						return (idString.split('/'))[0];
					}		
					return '';		
				}/*get channel ID*/
				
				/*get playlist ID*/
				youtube_playlist_parser = function(url){
					var reg 	= new RegExp("[&?]list=([a-z0-9_-]+)","i"),
						match 	= reg.exec(url);
						
					if(match&&match[1].length>0){
						return match[1];
					}
					return '';
				}/*get playlist ID*/
				
				/*get video ID*/
				youtube_video_parser = function(url){
					var regExp 	= /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/,
						match 	= url.match(regExp);
					return (match&&match[7].length==11)? match[7] : '';
				}/*get video ID*/
			
				/*youtube URL Validate*/
				youtube_validate = function(url){
					var regExp 	= /^(?:https?:\/\/)?(?:www\.)?youtube\.com|youtu\.be(?:\S+)?$/;
					return url.match(regExp)&&url.match(regExp).length>0;		
				}/*youtube URL Validate*/	
				
				auto_detect = function(url){
					var t_id = {};
					if(youtube_validate(url)){
						
						if(url.indexOf('/user/')!==-1){
							t_id['id'] 		= youtube_user_parser(url);
							t_id['type']	= 'user';
																					
						}else if(url.indexOf('/channel/')!==-1){
							t_id['id'] 		= youtube_channel_parser(url);
							t_id['type']	= 'channel';
														
						}else if(url.indexOf('list=')!==-1){
							t_id['id'] 		= youtube_playlist_parser(url);	
							t_id['type']	= 'playlist';										
											
						}else if(youtube_video_parser(url)!==''){
							t_id['id'] 		= youtube_video_parser(url);	
							t_id['type']	= 'video';													
						}	
							
					}
					
					return t_id;
				}
				
				/*build url user*/
				build_url_user = function(id){
					return (api_url)+'channels?part=snippet,contentDetails,brandingSettings,statistics&forUsername='+id+'&key='+(google_api_key);
				}/*build url user*/	
				
				/*build url channel*/
				build_url_channel = function(id){
					return (api_url)+'channels?id='+id+'&part=snippet,contentDetails,brandingSettings,statistics&maxResults=1&key='+(google_api_key);
				}/*build url channel*/
				
				/*build url playlist*/
				build_url_playlist = function(id, pageToken){
					var pt_string = '';
					
					if(typeof(pageToken)!=='undefined' && pageToken!==''){
						pt_string='&pageToken='+pageToken;
					}
					
					return (api_url)+'playlistItems?playlistId='+id+'&part=contentDetails,snippet&maxResults=50&key='+(google_api_key)+(pt_string);
				}/*build url playlist*/
				
				var html_builder = '';
				
				$('.analyze-youtube-control').on('click', function(){
					
					var $t = $(this);
					$t.addClass('import-loading');
					
					$('#cb-select-all-1, #cb-select-all-2, input[name="import_category[]"]').prop('checked', false);
					$('#import_post_date').prop('checked', true);
					$('option:selected', $('#import_post_status')).removeAttr('selected');
					
					$('.import-content').removeClass('show');
					
					html_builder = '';
					
					var youtubeSource 	= $.trim($('#video_source').val()),					
						source 			= auto_detect(youtubeSource);
						
					if(typeof(source)!=='object' || typeof(source['id'])==='undefined' || typeof(source['type'])==='undefined' || source['id'] == '' || source['type'] == ''){
						$('.error-submit .error-source').addClass('show');
						$('.error-submit .error-data').removeClass('show');
						$('.analyze-youtube-control').removeClass('import-loading');
						return false;
					}				
					
					
					var url_import = '';
					
					switch(source['type']){
						case 'user':
							
							$.ajax({
								url: 		build_url_user(source['id']),
								type: 		'GET',
								cache: 		true,
								dataType: 	'jsonp',
								success: 	function(data){
									if(typeof(data)!=='undefined' && typeof(data.items)!=='undefined' && typeof(data.items[0])!=='undefined'){						
										$.ajax({
											url: 		build_url_channel(data.items[0].id),
											type: 		'GET',
											cache: 		true,
											dataType: 	'jsonp',
											success: 	function(data){
												
												if(typeof(data)!=='undefined' && typeof(data.items)!=='undefined' && typeof(data.items[0])!=='undefined'){
													url_import = build_url_playlist(data.items[0].contentDetails.relatedPlaylists.uploads);	
													$(document).trigger('youtubeBuildPlaylistReady', [url_import, data.items[0].contentDetails.relatedPlaylists.uploads]);	
												}else{
													$(document).trigger('youtubeBuildPlaylistReady', ['', 'error: case user']);
												}												
																																					
											},
											error: 		function(err){
												$(document).trigger('youtubeBuildPlaylistReady', ['', 'error: case user']);							
											}
										});
									}else{
										$(document).trigger('youtubeBuildPlaylistReady', ['', 'error: case user']);
									}
								},
								error: 		function(err){
									$(document).trigger('youtubeBuildPlaylistReady', ['', 'error: case user']);				
								}
							});
							
							break;
							
						case 'channel':	
						
							$.ajax({
								url: 		build_url_channel(source['id']),
								type: 		'GET',
								cache: 		true,
								dataType: 	'jsonp',
								success: 	function(data){
									
									if(typeof(data)!=='undefined' && typeof(data.items)!=='undefined' && typeof(data.items[0])!=='undefined'){						
										url_import = build_url_playlist(data.items[0].contentDetails.relatedPlaylists.uploads);	
										$(document).trigger('youtubeBuildPlaylistReady', [url_import, data.items[0].contentDetails.relatedPlaylists.uploads]);											
									}else{
										$(document).trigger('youtubeBuildPlaylistReady', ['', 'error: case channel']);
									}									
																								
								},
								error: 		function(err){
									$(document).trigger('youtubeBuildPlaylistReady', ['', 'error: case channel']);												
								}
							});
							
							break;
							
						case 'playlist':
						
							url_import = build_url_playlist(source['id']);
							$(document).trigger('youtubeBuildPlaylistReady', [url_import, source['id']]);	
							
							break;
						
						case 'video':
						
							url_import = (api_url)+'videos?id='+source['id']+'&part=contentDetails,snippet,id&maxResults=1&key='+(google_api_key);
							$(document).trigger('youtubeBuildPlaylistReady', [url_import, source['id']]);
								
					}		
				});
				
				var action_jsonp_load = function(url_import, playlist_id){
					$.ajax({
						url: 		url_import,
						type: 		'GET',
						cache: 		true,
						dataType: 	'jsonp',
						success: 	function(data){	
						
							if(typeof(data)==='object' && typeof(data.error)==='undefined'){	
								
								$.each(data.items, function(i, value){
									
									if(typeof(value.snippet) === 'undefined' || (typeof(value.snippet.publishedAt) === 'undefined' && typeof(value.contentDetails.videoPublishedAt) === 'undefined') || typeof(value.snippet.thumbnails) === 'undefined' || typeof(value.snippet.thumbnails.default)==='undefined' || typeof(value.snippet.thumbnails.default.url)==='undefined'){															
										return;
									}
									
									var video_f_id = typeof(value.contentDetails.videoId)!=='undefined'?value.contentDetails.videoId:( typeof(value.id)!=='undefined'?value.id:'' );
									
									if(video_f_id == ''){
										return;
									}
									
									var video_plsa_time = typeof(value.contentDetails.videoPublishedAt)!=='undefined'?value.contentDetails.videoPublishedAt:( typeof(value.snippet.publishedAt)!=='undefined'?value.snippet.publishedAt:'' );
									
									html_builder+=	'<tr id="' +( video_f_id )+ '">\
														<th class="check-column">\
															<input id="cb-select-' +( video_f_id )+ '" type="checkbox" name="youtubevideo[]" value="' +( video_f_id )+ '">\
														</th>\
														<td class="column-thumb">\
															<a href="https://www.youtube.com/watch?v='+(video_f_id)+'" target="_blank"><img src="' + ( value.snippet.thumbnails.default.url ) + '"></a>\
														</td>\
														<td class="column-title">\
															<strong>\
																<a href="https://www.youtube.com/watch?v=' +( video_f_id )+ '" class="row-title" target="_blank">' +( value.snippet.title.replace(/['"]+/g, '') )+ '</a>\
															</strong>\
														</td>\
														<td class="column-status">\
														</td>\
														<input type="hidden" value="'+(value.snippet.title.replace(/['"]+/g, ''))+'" id="post_title_'+(video_f_id)+'">\
														<input type="hidden" value="'+(video_plsa_time)+'" id="post_date_'+(video_f_id)+'">\
													</tr>';
								});
														
								if(typeof(data.nextPageToken)!=='undefined' && data.nextPageToken!='' && typeof(playlist_id)!=='undefined'){
									action_jsonp_load(build_url_playlist(playlist_id, data.nextPageToken), playlist_id);
								}else{
									console.log('Finish Setup');
									$('#the-list').html(html_builder);
									
									$('.import-youtube-control').off('.bulkImportYoutube').on('click.bulkImportYoutube', function(e){
										var $t = $(this);
										$t.addClass('import-loading');
										
										var videoVal = [];
										videoVal = $('input[name="youtubevideo[]"]:checked').map(function(_, el) {
											return $(el).val();
										}).get();
										
										if(videoVal.length === 0){
											alert('<?php echo esc_html__('Please select at least one item before import', 'vidorev-extensions');?>');
											$t.removeClass('import-loading');
											return;
										}
										
										var categoriesVal = [];
										categoriesVal = $('input[name="import_category[]"]:checked').map(function(_, el) {
											return $(el).val();
										}).get();
										
										var post_status = $('#import_post_status').val();
										var fetch_date 	= $('#import_post_date').prop('checked');
										
										var total_video_proc = videoVal.length;
										
										$.each(videoVal, function(i, value){
											
											$('#'+(value)).find('.column-status').html('<?php echo esc_html__('Processing...', 'vidorev-extensions');?>');
											
											newParamsRequest = {
												'action':		'vidorev_import_single_video',
												'cats': 		categoriesVal,
												'post_status': 	post_status,
												'fetch_date': 	fetch_date,
												'video_id':		value,
												'video_title':	$('#post_title_'+(value)).val(),
												'video_date':	$('#post_date_'+(value)).val(),	
											}											
																																
											$.ajax({
												url:		'<?php echo esc_url(admin_url('admin-ajax.php'));?>',						
												type: 		'POST',
												data:		newParamsRequest,
												dataType: 	'json',
												cache:		false,
												success: 	function(data){
													$('#'+(value)).find('.column-status').html(data.result);
													total_video_proc--;
													
													if(total_video_proc == 0){
														$t.removeClass('import-loading');
													}
												},
												error:		function(){
													$('#'+(value)).find('.column-status').html('<span class="result-error"><?php echo esc_html__('Error, please try again', 'vidorev-extensions');?></span>');
													total_video_proc--;
													if(total_video_proc == 0){
														$t.removeClass('import-loading');
													}
												},
											});
										});
										
										if(total_video_proc == 0){
											$t.removeClass('import-loading');
										}
										
									});
									
									$('.import-content').addClass('show');
									$('.analyze-youtube-control').removeClass('import-loading');
									$('.error-submit .error-source').removeClass('show');
									$('.error-submit .error-data').removeClass('show');
								}
							}else{
								$('.analyze-youtube-control').removeClass('import-loading');
								$('.error-submit .error-data').addClass('show');
							}
																													
						},
						error: 		function(err){
							$('.analyze-youtube-control').removeClass('import-loading');
							$('.error-submit .error-data').addClass('show');									
						}
					});
				}				
				
				$(document).on("youtubeBuildPlaylistReady",function(event, url_import, error_or_id){
					if(url_import!=''){
						
						console.log(url_import);
						
						var playlist_id = error_or_id;
						
						action_jsonp_load(url_import, playlist_id);
						
					}else{
						if(typeof(error_or_id)!=='undefined'){
							console.log(error_or_id);
						}else{
							console.log('Error');
						}
						
						$('.analyze-youtube-control').removeClass('import-loading');
						$('.error-submit .error-source').removeClass('show');
						$('.error-submit .error-data').addClass('show');						
					}
				});
			});
		}(jQuery));
	</script>	
	
	<?php	
	}
endif;

if ( ! function_exists( 'vidorev_youtube_importer_menu' ) ) :
	function vidorev_youtube_importer_menu(){
		add_submenu_page('vidorev-theme-settings', esc_html__( 'Youtube Importer', 'vidorev-extensions'), esc_html__( 'Youtube Importer', 'vidorev-extensions'), 'manage_options', 'vidorev_youtube_importer_videos', 'vidorev_youtube_importer_videos' );
	}
endif;

if(is_admin()){	
	add_action('admin_menu', 'vidorev_youtube_importer_menu');	
}

if(!function_exists('vidorev_import_single_video')){
	function vidorev_import_single_video(){
		if(!isset($_POST['post_status']) || !isset($_POST['fetch_date']) || !isset($_POST['video_id']) || !isset($_POST['video_title']) || !isset($_POST['video_date'])){
			return;
		}
		
		$params = array();
		
		$cats = 		(isset($_POST['cats'])&&is_array($_POST['cats']))?$_POST['cats']:array();
		$post_status = 	trim($_POST['post_status']);
		$fetch_date = 	trim($_POST['fetch_date']);
		$video_id = 	trim($_POST['video_id']);
		$video_title = 	trim($_POST['video_title']);
		$video_date =	trim($_POST['video_date']);
		
		
		$exists = new WP_Query(array(
			'post_type'   	=> 'post',
			'post_status' 	=> 'any',
			'tax_query'		=> array(
				'taxonomy'  => 'post_format',
				'field'    	=> 'slug',
				'terms'     => array('post-format-video'),
				'operator'  => 'IN',
			),
			'meta_query'  	=> array(
				array(
					'key'     => 'youtube_import_fetch_id',
					'value'   => $video_id,
					'compare' => '=',
				),
			),
		));

		if($exists->have_posts()){
			
			wp_reset_postdata();
			
			$params['result'] = '<span class="result-error">'.esc_html__('Video already exists', 'vidorev-extensions').'</span>';
			
			wp_send_json($params);
			
			return;
		}
		
		wp_reset_postdata();
		
		$postData = array();
		
		$video_url = 'https://www.youtube.com/watch?v='.$video_id;
											
		$postData['post_title'] = $video_title;	
		$postData['post_status'] = $post_status;
		
		if(count($cats)>0){
			$postData['post_category'] = $cats;
		}
		
		if($fetch_date == 'true' && $video_date!=''){
			$postData['post_date'] = $video_date;	
		}
		
		$newPostID = wp_insert_post($postData);
		
		if(!is_wp_error($newPostID) && $newPostID){
			
			set_post_format($newPostID, 'video' );			
			update_post_meta($newPostID, 'vm_video_url', $video_url);
			update_post_meta($newPostID, 'youtube_import_fetch_id', $video_id);	
			
			$_POST['auto_fetch_extensions'] = 'on';
			
			$new_post = array(
				'ID' => $newPostID,
			);								
			wp_update_post( $new_post );
			
			$params['result'] = 
				'<span class="result-done">'.
					wp_kses(
						__('Done!!! [ <a href="'.esc_url(get_edit_post_link($newPostID)).'" target="_blank">Edit</a> | <a href="'.esc_url(get_permalink($newPostID)).'" target="_blank">View</a> ]', 'vidorev-extensions'
						),
						array(
							'a'=>array('href' => array(), 'target' => array()),
						)
					)
				.'</span>';	
			
		}else{
			
			$params['result'] = '<span class="result-error">'.esc_html__('Error, please try again', 'vidorev-extensions').'</span>';
			
		}
		
		wp_send_json($params);
		
		die();
	}
}

if(!function_exists('vidorev_import_single_video_ajax')){
	function vidorev_import_single_video_ajax(){
		if(is_admin() && isset($_POST['video_id']) && $_POST['video_id']!=''){
			add_action('wp_ajax_vidorev_import_single_video', 'vidorev_import_single_video');
			add_action('wp_ajax_nopriv_vidorev_import_single_video', 'vidorev_import_single_video');	
		}	
	}
}

add_action('admin_init', 'vidorev_import_single_video_ajax');