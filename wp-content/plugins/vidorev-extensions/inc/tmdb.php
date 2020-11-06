<?php
if ( ! function_exists( 'beeteam368_custom_field_tmdb_search' ) ) :
	function beeteam368_custom_field_tmdb_search($field_args, $field){		
		$id          = $field->args( 'id' );
		$label       = $field->args( 'name' );
		$name        = $field->args( '_name' );
		$value       = $field->escaped_value();
		$description = $field->args( 'description' );
		$post_id	 = is_numeric($field->object_id)?$field->object_id:'';
	?>
		<div class="custom-column-display custom-filter-tmdb-movie-display-control">
			<p><label for="<?php echo esc_attr($id);?>"><?php echo esc_html($label);?></label></p>
			<p class="bee_select_2">
				<select id="<?php echo esc_attr($id);?>" data-placeholder="<?php echo esc_attr__('Select a Movie', 'vidorev-extensions');?>" class="vidorev-admin-ajax admin-ajax-find-tmdb-movie-control" name="<?php echo esc_attr($name);?>[]" multiple>
					<?php
					if($post_id!='' && is_array($value) && count($value)>0){
						$tmdb_api_key 	= apply_filters('beeteam368_tmdb_movie_api_key', '6f2a688b4bd7ca287e759544a0198ecd');
						$tmdb_language 	= apply_filters('beeteam368_tmdb_movie_language', 'en-US');		
						foreach ( $value as $item ) {							
							if(is_numeric($item)){
								
								$query_url = 'https://api.themoviedb.org/3/movie/'.($item).'?api_key='.$tmdb_api_key.'&language='.$tmdb_language;
								$args = array(
									'timeout'     => 368,				
								);
								$response = wp_remote_get($query_url, $args);
								
								if(is_wp_error($response)){
									
								}else {
									$result = json_decode($response['body']);
									if(!isset($result->{'id'}) || !is_numeric($result->{'id'}) || $result->{'id'}<1){				
										
									}else{
									?>
                                    	<option value="<?php echo esc_attr($result->id);?>" selected="selected"><?php echo esc_html($result->original_title);?></option>
                                    <?php	
									}
								}				
							}
						}
					}
					?>
				</select>
			</p>
			<p class="description"><?php echo wp_kses_post($description); ?></p>
		</div>
	<?php	
	}
endif;

if(!function_exists('vidorev_adminAjaxGetAllTMDBMovies')){
	function vidorev_adminAjaxGetAllTMDBMovies(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=2)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true) )){
			wp_send_json($json_params);
			return;
			die();
		}
		
		$tmdb_api_key 	= apply_filters('beeteam368_tmdb_movie_api_key', '6f2a688b4bd7ca287e759544a0198ecd');
		$tmdb_language 	= apply_filters('beeteam368_tmdb_movie_language', 'en-US');
		
		$query_url = 'https://api.themoviedb.org/3/search/movie?api_key='.$tmdb_api_key.'&language='.$tmdb_language.'&page=1&include_adult=true&query='.$keyword;
		
		$args = array(
			'timeout'     => 368,				
		);
		$response = wp_remote_get($query_url, $args);
		
		if(is_wp_error($response)){
			wp_send_json($json_params);
			return;
			die();
		}else {
			$result = json_decode($response['body']);
			if(!isset($result->{'total_results'}) || !is_numeric($result->{'total_results'}) || $result->{'total_results'}<1 || !isset($result->{'results'}) || !is_array($result->{'results'}) || count($result->{'results'})<1){				
				wp_send_json($json_params);
				return;
				die();
			}else{
				foreach ( $result->{'results'} as $movie_item ) {
					array_push($json_params['results'], array('id'=>esc_html($movie_item->id), 'text'=>esc_html($movie_item->original_title)));
				}
			}
		}
				
		wp_send_json($json_params);
		return;
		die();
	}
}
add_action('wp_ajax_adminAjaxGetAllTMDBMovies', 'vidorev_adminAjaxGetAllTMDBMovies');
add_action('wp_ajax_nopriv_adminAjaxGetAllTMDBMovies', 'vidorev_adminAjaxGetAllTMDBMovies');

if ( ! function_exists( 'beeteam368_custom_field_tmdb_search_tv_shows' ) ) :
	function beeteam368_custom_field_tmdb_search_tv_shows($field_args, $field){		
		$id          = $field->args( 'id' );
		$label       = $field->args( 'name' );
		$name        = $field->args( '_name' );
		$value       = $field->escaped_value();
		$description = $field->args( 'description' );
		$post_id	 = is_numeric($field->object_id)?$field->object_id:'';
	?>
		<div class="custom-column-display custom-filter-tmdb-tv-shows-display-control">
			<p><label for="<?php echo esc_attr($id);?>"><?php echo esc_html($label);?></label></p>
			<p class="bee_select_2">
				<select id="<?php echo esc_attr($id);?>" data-placeholder="<?php echo esc_attr__('Select a TV-Shows', 'vidorev-extensions');?>" class="vidorev-admin-ajax admin-ajax-find-tmdb-tv-shows-control" name="<?php echo esc_attr($name);?>[]" multiple>
					<?php
					if($post_id!='' && is_array($value) && count($value)>0){
						$tmdb_api_key 	= apply_filters('beeteam368_tmdb_movie_api_key', '6f2a688b4bd7ca287e759544a0198ecd');
						$tmdb_language 	= apply_filters('beeteam368_tmdb_movie_language', 'en-US');		
						foreach ( $value as $item ) {							
							if(is_numeric($item)){
								
								$query_url = 'https://api.themoviedb.org/3/tv/'.($item).'?api_key='.$tmdb_api_key.'&language='.$tmdb_language;
								$args = array(
									'timeout'     => 368,				
								);
								$response = wp_remote_get($query_url, $args);
								
								if(is_wp_error($response)){
									
								}else {
									$result = json_decode($response['body']);
									if(!isset($result->{'id'}) || !is_numeric($result->{'id'}) || $result->{'id'}<1){				
										
									}else{
									?>
                                    	<option value="<?php echo esc_attr($result->id);?>" selected="selected"><?php echo esc_html($result->name);?></option>
                                    <?php	
									}
								}				
							}
						}
					}
					?>
				</select>
			</p>
			<p class="description"><?php echo wp_kses_post($description); ?></p>
		</div>
	<?php	
	}
endif;

if(!function_exists('vidorev_adminAjaxGetAllTMDBTVShows')){
	function vidorev_adminAjaxGetAllTMDBTVShows(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=2)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true) )){
			wp_send_json($json_params);
			return;
			die();
		}
		
		$tmdb_api_key 	= apply_filters('beeteam368_tmdb_movie_api_key', '6f2a688b4bd7ca287e759544a0198ecd');
		$tmdb_language 	= apply_filters('beeteam368_tmdb_movie_language', 'en-US');
		
		$query_url = 'https://api.themoviedb.org/3/search/tv?api_key='.$tmdb_api_key.'&language='.$tmdb_language.'&page=1&include_adult=true&query='.$keyword;
		
		$args = array(
			'timeout'     => 368,				
		);
		$response = wp_remote_get($query_url, $args);
		
		if(is_wp_error($response)){
			wp_send_json($json_params);
			return;
			die();
		}else {
			$result = json_decode($response['body']);
			if(!isset($result->{'total_results'}) || !is_numeric($result->{'total_results'}) || $result->{'total_results'}<1 || !isset($result->{'results'}) || !is_array($result->{'results'}) || count($result->{'results'})<1){				
				wp_send_json($json_params);
				return;
				die();
			}else{
				foreach ( $result->{'results'} as $tv_item ) {
					array_push($json_params['results'], array('id'=>esc_html($tv_item->id), 'text'=>esc_html($tv_item->name)));
				}
			}
		}
				
		wp_send_json($json_params);
		return;
		die();
	}
}
add_action('wp_ajax_adminAjaxGetAllTMDBTVShows', 'vidorev_adminAjaxGetAllTMDBTVShows');
add_action('wp_ajax_nopriv_adminAjaxGetAllTMDBTVShows', 'vidorev_adminAjaxGetAllTMDBTVShows');

if(!function_exists('vidorev_tmdb_single_block_html')){
	function vidorev_tmdb_single_block_html(){
		$post_id 	= get_the_ID();
		$tmdb_block	= get_post_meta($post_id, 'beeteam368_tmdb_data', true);
		
		if(is_array($tmdb_block) && count($tmdb_block)>0){
			foreach($tmdb_block as $movie_data){
				if(is_array($movie_data) && (count($movie_data)==2 || count($movie_data)==3) && isset($movie_data['movie_details']) && isset($movie_data['movie_credits'])){
					$movie_details = gettype($movie_data['movie_details'])==='object'?$movie_data['movie_details']:json_decode($movie_data['movie_details']);
					$movie_credits = gettype($movie_data['movie_credits'])==='object'?$movie_data['movie_credits']:json_decode($movie_data['movie_credits']);;
					
					if(isset($movie_details->{'id'})){
						$backdrop_path 	= isset($movie_details->{'backdrop_path'})&&$movie_details->{'backdrop_path'}!=''?'style="background-image:url(https://image.tmdb.org/t/p/w1280'.$movie_details->{'backdrop_path'}.');"':'';
						$poster_path 	= isset($movie_details->{'poster_path'})&&$movie_details->{'poster_path'}!=''?'<span class="ul-placeholder-bg class-2x3"></span><img class="blog-picture tmdb-picture" src="https://image.tmdb.org/t/p/w300'.$movie_details->{'poster_path'}.'">':'<span class="tmdb-no-image"><i class="fa fa-film" aria-hidden="true"></i></span>';
						$original_title = isset($movie_details->{'original_title'})&&$movie_details->{'original_title'}!=''?$movie_details->{'original_title'}:'';
						$global_title	= isset($movie_details->{'title'})&&$movie_details->{'title'}!=''?$movie_details->{'title'}:'';
					?>
                    
                        <header class="entry-header tmdb-movie-banner dark-background movie-style" <?php echo $backdrop_path;?>>
                            <div class="pp-wrapper">
                            
                                <div class="pp-image"><?php echo $poster_path;?></div>
                                
                                <div class="pp-content-wrapper">
                                
                                	<div class="entry-meta post-meta meta-font">
                                        <div class="post-meta-wrap">
                                            <div>
                                                <span><?php echo esc_html__('Status:', 'vidorev-extensions').' '.$movie_details->{'status'};?> </span>                                                
                                            </div>
                                            <div>
                                                <span><?php echo esc_html__('Release Date:', 'vidorev-extensions').' '.$movie_details->{'release_date'};?> </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h2 class="entry-title extra-bold h6-mobile">
										<?php 
											if($original_title!=$global_title){
												echo esc_html($global_title);
												echo '<span class="tmdb-original-title h6">'.esc_html($original_title).'</span>';
											}else{
												echo esc_html($original_title);
											}
										?>
                                    </h2>
                                    
                                    <?php 
									if( isset($movie_details->{'genres'}) && count($movie_details->{'genres'})>0 ){
									?>
                                        <div class="entry-meta post-meta meta-font">
                                            <div class="post-meta-wrap">
                                                <?php
                                                foreach($movie_details->{'genres'} as $genres){
                                                ?>
                                                    <div class="role"><i class="fa fa-plus-circle" aria-hidden="true"></i><span><?php echo esc_html($genres->{'name'})?></span></div>	
                                                <?php
                                                }
                                                ?>											
                                            </div>
                                        </div>
                                    <?php
									}
                                    ?>
                                                    
                                </div>
                            </div>
                        </header>
                    
                    <?php
					}
					if(isset($movie_details->{'overview'}) && $movie_details->{'overview'}!=''){
					?>
                    	<div class="actor-element tmdb-section-overview single-element">
                            <h3 class="actor-element-title extra-bold h4"><i class="fa fa-rss" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_overview_single_title', esc_html__('Overview', 'vidorev-extensions'));?></span> &nbsp; </h3>    
                            <p><?php echo esc_html($movie_details->{'overview'});?></p>     
                        </div>
                    <?php	
					}
					
					if(isset($movie_details->{'trailers'}) && isset($movie_details->{'trailers'}->{'youtube'}) && isset($movie_details->{'trailers'}->{'youtube'}[0]->{'source'})){
					?>
                    	<div class="actor-element tmdb-section-trailer single-element">
                            <h3 class="actor-element-title extra-bold h4"><i class="fa fa-film" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_trailer_single_title', esc_html__('Trailer', 'vidorev-extensions'));?></span> &nbsp; </h3>    
                            <div class="tmdb-trailer"><iframe src="https://www.youtube.com/embed/<?php echo esc_attr($movie_details->{'trailers'}->{'youtube'}[0]->{'source'})?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>     
                        </div>
                    <?php	
					}elseif(isset($movie_data['movie_details_en_us'])){
						$movie_details_en_us = gettype($movie_data['movie_details_en_us'])==='object'?$movie_data['movie_details_en_us']:json_decode($movie_data['movie_details_en_us']);
						if(isset($movie_details_en_us->{'trailers'}) && isset($movie_details_en_us->{'trailers'}->{'youtube'}) && isset($movie_details_en_us->{'trailers'}->{'youtube'}[0]->{'source'})){
					?>
                            <div class="actor-element tmdb-section-trailer single-element">
                                <h3 class="actor-element-title extra-bold h4"><i class="fa fa-film" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_trailer_single_title', esc_html__('Trailer', 'vidorev-extensions'));?></span> &nbsp; </h3>    
                                <div class="tmdb-trailer"><iframe src="https://www.youtube.com/embed/<?php echo esc_attr($movie_details_en_us->{'trailers'}->{'youtube'}[0]->{'source'})?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>     
                            </div>
                    <?php		
						}
					}
					
					if(isset($movie_credits->{'cast'}) && count($movie_credits->{'cast'})>0){						
					?>
                        <div class="actor-element tmdb-section tmdb-section-control single-element">
                            <h3 class="actor-element-title extra-bold h4"><i class="fa fa-user-circle" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_cast_single_title', esc_html__('Cast', 'vidorev-extensions'));?></span> &nbsp; </h3>                            
                            <div class="site__row ex_col_tmdb">
                                <?php							
                                foreach ( $movie_credits->{'cast'} as $item) :
                                   $profile_path 	= isset($item->{'profile_path'})&&$item->{'profile_path'}!=''?'<span class="ul-placeholder-bg class-2x3"><img class="blog-picture tmdb-picture" src="https://image.tmdb.org/t/p/w92'.$item->{'profile_path'}.'">':'<span class="tmdb-no-image"><i class="fa fa-user" aria-hidden="true"></i></span>';
								   $name 			= isset($item->{'name'})&&$item->{'name'}!=''?$item->{'name'}:'';
								   $character 		= isset($item->{'character'})&&$item->{'character'}!=''?$item->{'character'}:'';
                                ?>	
                                    <div class="site__col">
                                        <div class="ac-di-content">
                                            <div class="post-img"><?php echo $profile_path;?></div>
                                            <div class="post-content">
                                                <h6 class="post-title"><?php echo esc_html($name)?></h6>
                                                <div class="entry-meta post-meta meta-font">
                                                <div class="post-meta-wrap">
                                                    <div class="role"><span><?php echo esc_html($character)?></span></div>												
                                                </div>
                                            </div>
                                            </div>									
                                        </div>                                   
                                    </div>				
                                <?php				
                                endforeach;
                                ?>
                            </div>
                            <div class="tmdb_showmore_wrapper"><span class="tmdb_showmore_button tmdb_showmore_button_control"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span></div>                        
                        </div>
                    
                    <?php }
					if(isset($movie_credits->{'crew'}) && count($movie_credits->{'crew'})>0){	
					?>                    
                        <div class="actor-element tmdb-section tmdb-section-control single-element">
                            <h3 class="actor-element-title extra-bold h4"><i class="fa fa-universal-access" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_crew_single_title', esc_html__('Crew', 'vidorev-extensions'));?></span> &nbsp; </h3>
                            
                            <div class="site__row ex_col_tmdb">
                                <?php						
                                foreach ( $movie_credits->{'crew'} as $item) :
                                	$profile_path 	= isset($item->{'profile_path'})&&$item->{'profile_path'}!=''?'<span class="ul-placeholder-bg class-2x3"><img class="blog-picture tmdb-picture" src="https://image.tmdb.org/t/p/w92'.$item->{'profile_path'}.'">':'<span class="tmdb-no-image"><i class="fa fa-user" aria-hidden="true"></i></span>';
									$name 			= isset($item->{'name'})&&$item->{'name'}!=''?$item->{'name'}:'';
									$department 	= isset($item->{'department'})&&$item->{'department'}!=''?$item->{'department'}:'';
                                ?>	
                                    <div class="site__col">
                                        <div class="ac-di-content">
                                            <div class="post-img"><?php echo $profile_path;?></div>
                                            <div class="post-content">
                                                <h6 class="post-title"><?php echo esc_html($name)?></h6>
                                                <div class="entry-meta post-meta meta-font">
                                                <div class="post-meta-wrap">
                                                    <div class="role"><span><?php echo esc_html($department)?></span></div>												
                                                </div>
                                            </div>
                                            </div>									
                                        </div>                                   
                                    </div>				
                                <?php				
                                endforeach;
                                ?>
                            </div>
                            <div class="tmdb_showmore_wrapper"><span class="tmdb_showmore_button tmdb_showmore_button_control"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span></div>                        
                        </div>
                    <?php
					}
				}
			}
		}
	}
}

add_action('vidorev_tmdb_single_block_html', 'vidorev_tmdb_single_block_html', 10, 1);

if(!function_exists('vidorev_tmdb_tv_single_block_html')){
	function vidorev_tmdb_tv_single_block_html(){
		$post_id 	= get_the_ID();
		$tmdb_block	= get_post_meta($post_id, 'beeteam368_tmdb_tv_data', true);
		
		if(is_array($tmdb_block) && count($tmdb_block)>0){
			foreach($tmdb_block as $tv_data){
				if(is_array($tv_data) && count($tv_data)==2 && isset($tv_data['tv_details']) && isset($tv_data['tv_credits'])){
					$tv_details = gettype($tv_data['tv_details'])==='object'?$tv_data['tv_details']:json_decode($tv_data['tv_details']);
					$tv_credits = gettype($tv_data['tv_credits'])==='object'?$tv_data['tv_credits']:json_decode($tv_data['tv_credits']);
					
					if(isset($tv_details->{'id'})){
						$backdrop_path 	= isset($tv_details->{'backdrop_path'})&&$tv_details->{'backdrop_path'}!=''?'style="background-image:url(https://image.tmdb.org/t/p/w1280'.$tv_details->{'backdrop_path'}.');"':'';
						$poster_path 	= isset($tv_details->{'poster_path'})&&$tv_details->{'poster_path'}!=''?'<span class="ul-placeholder-bg class-2x3"></span><img class="blog-picture tmdb-picture" src="https://image.tmdb.org/t/p/w300'.$tv_details->{'poster_path'}.'">':'<span class="tmdb-no-image"><i class="fa fa-film" aria-hidden="true"></i></span>';
						$original_name = isset($tv_details->{'original_name'})&&$tv_details->{'original_name'}!=''?$tv_details->{'original_name'}:'';
						$global_name	= isset($tv_details->{'name'})&&$tv_details->{'name'}!=''?$tv_details->{'name'}:'';
					?>
                    	<header class="entry-header tmdb-movie-banner dark-background movie-style" <?php echo $backdrop_path;?>>
                            <div class="pp-wrapper">
                            
                                <div class="pp-image"><?php echo $poster_path;?></div>
                                
                                <div class="pp-content-wrapper">
                                
                                	<div class="entry-meta post-meta meta-font">
                                        <div class="post-meta-wrap">
                                            <div>
                                                <span><?php echo esc_html__('First aired:', 'vidorev-extensions').' '.$tv_details->{'first_air_date'};?> </span>                                                
                                            </div>
                                            <div>
                                                <span><?php echo esc_html__('Last air date:', 'vidorev-extensions').' '.$tv_details->{'last_air_date'};?> </span>                                                
                                            </div>
                                            <div>
                                                <span><?php echo esc_html__('Episodes/Seasons:', 'vidorev-extensions').' '.$tv_details->{'number_of_episodes'}.' / '.$tv_details->{'number_of_seasons'};?> </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h2 class="entry-title extra-bold h6-mobile">
										<?php 
											if($original_name!=$global_name){
												echo esc_html($global_name);
												echo '<span class="tmdb-original-title h6">'.esc_html($original_name).'</span>';
											}else{
												echo esc_html($original_name);
											}
										?>
                                    </h2>
                                    
                                    <?php 
									if( isset($tv_details->{'genres'}) && count($tv_details->{'genres'})>0 ){
									?>
                                        <div class="entry-meta post-meta meta-font">
                                            <div class="post-meta-wrap">
                                                <?php
                                                foreach($tv_details->{'genres'} as $genres){
                                                ?>
                                                    <div class="role"><i class="fa fa-plus-circle" aria-hidden="true"></i><span><?php echo esc_html($genres->{'name'})?></span></div>	
                                                <?php
                                                }
                                                ?>											
                                            </div>
                                        </div>
                                    <?php
									}
                                    ?>
                                                    
                                </div>
                            </div>
                        </header>
                    <?php
					}
					
					if(isset($tv_details->{'overview'}) && $tv_details->{'overview'}!=''){
					?>
                    	<div class="actor-element tmdb-section-overview single-element">
                            <h3 class="actor-element-title extra-bold h4"><i class="fa fa-rss" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_overview_single_title', esc_html__('Overview', 'vidorev-extensions'));?></span> &nbsp; </h3>    
                            <p><?php echo esc_html($tv_details->{'overview'});?></p>     
                        </div>
                    <?php	
					}
					
					if(isset($tv_credits->{'cast'}) && count($tv_credits->{'cast'})>0){						
					?>
                        <div class="actor-element tmdb-section tmdb-section-control single-element">
                            <h3 class="actor-element-title extra-bold h4"><i class="fa fa-user-circle" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_cast_single_title', esc_html__('Cast', 'vidorev-extensions'));?></span> &nbsp; </h3>                            
                            <div class="site__row ex_col_tmdb">
                                <?php							
                                foreach ( $tv_credits->{'cast'} as $item) :
                                   $profile_path 	= isset($item->{'profile_path'})&&$item->{'profile_path'}!=''?'<span class="ul-placeholder-bg class-2x3"><img class="blog-picture tmdb-picture" src="https://image.tmdb.org/t/p/w92'.$item->{'profile_path'}.'">':'<span class="tmdb-no-image"><i class="fa fa-user" aria-hidden="true"></i></span>';
								   $name 			= isset($item->{'name'})&&$item->{'name'}!=''?$item->{'name'}:'';
								   $character 		= isset($item->{'character'})&&$item->{'character'}!=''?$item->{'character'}:'';
                                ?>	
                                    <div class="site__col">
                                        <div class="ac-di-content">
                                            <div class="post-img"><?php echo $profile_path;?></div>
                                            <div class="post-content">
                                                <h6 class="post-title"><?php echo esc_html($name)?></h6>
                                                <div class="entry-meta post-meta meta-font">
                                                <div class="post-meta-wrap">
                                                    <div class="role"><span><?php echo esc_html($character)?></span></div>												
                                                </div>
                                            </div>
                                            </div>									
                                        </div>                                   
                                    </div>				
                                <?php				
                                endforeach;
                                ?>
                            </div>
                            <div class="tmdb_showmore_wrapper"><span class="tmdb_showmore_button tmdb_showmore_button_control"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span></div>                        
                        </div>
                    
                    <?php }
					if(isset($tv_credits->{'crew'}) && count($tv_credits->{'crew'})>0){	
					?>                    
                        <div class="actor-element tmdb-section tmdb-section-control single-element">
                            <h3 class="actor-element-title extra-bold h4"><i class="fa fa-universal-access" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_crew_single_title', esc_html__('Crew', 'vidorev-extensions'));?></span> &nbsp; </h3>
                            
                            <div class="site__row ex_col_tmdb">
                                <?php						
                                foreach ( $tv_credits->{'crew'} as $item) :
                                	$profile_path 	= isset($item->{'profile_path'})&&$item->{'profile_path'}!=''?'<span class="ul-placeholder-bg class-2x3"><img class="blog-picture tmdb-picture" src="https://image.tmdb.org/t/p/w92'.$item->{'profile_path'}.'">':'<span class="tmdb-no-image"><i class="fa fa-user" aria-hidden="true"></i></span>';
									$name 			= isset($item->{'name'})&&$item->{'name'}!=''?$item->{'name'}:'';
									$department 	= isset($item->{'department'})&&$item->{'department'}!=''?$item->{'department'}:'';
                                ?>	
                                    <div class="site__col">
                                        <div class="ac-di-content">
                                            <div class="post-img"><?php echo $profile_path;?></div>
                                            <div class="post-content">
                                                <h6 class="post-title"><?php echo esc_html($name)?></h6>
                                                <div class="entry-meta post-meta meta-font">
                                                <div class="post-meta-wrap">
                                                    <div class="role"><span><?php echo esc_html($department)?></span></div>												
                                                </div>
                                            </div>
                                            </div>									
                                        </div>                                   
                                    </div>				
                                <?php				
                                endforeach;
                                ?>
                            </div>
                            <div class="tmdb_showmore_wrapper"><span class="tmdb_showmore_button tmdb_showmore_button_control"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span></div>                        
                        </div>
                    <?php
					}
					
					if(isset($tv_details->{'seasons'}) && count($tv_details->{'seasons'})>0){
					?>
                        <div class="actor-element tmdb-section tmdb-section-control single-element">
                            <h3 class="actor-element-title extra-bold h4"><i class="fa fa-film" aria-hidden="true"></i><span><?php echo apply_filters('vidorev_seasons_single_title', esc_html__('Seasons', 'vidorev-extensions'));?></span> &nbsp; </h3>                            
                            <div class="site__row ex_col_tmdb">
                                <?php							
                                foreach ( $tv_details->{'seasons'} as $item) :
                                   $poster_path 	= isset($item->{'poster_path'})&&$item->{'poster_path'}!=''?'<span class="ul-placeholder-bg class-2x3"><img class="blog-picture tmdb-picture" src="https://image.tmdb.org/t/p/w92'.$item->{'poster_path'}.'">':'<span class="tmdb-no-image"><i class="fa fa-film" aria-hidden="true"></i></span>';
								   $name 			= isset($item->{'name'})&&$item->{'name'}!=''?$item->{'name'}:'';
								   $air_date 		= isset($item->{'air_date'})&&$item->{'air_date'}!=''?$item->{'air_date'}:'';
								   $episode_count	= isset($item->{'episode_count'})&&$item->{'episode_count'}!=''?$item->{'episode_count'}:'';
                                ?>	
                                    <div class="site__col">
                                        <div class="ac-di-content">
                                            <div class="post-img"><?php echo $poster_path;?></div>
                                            <div class="post-content">
                                                <h6 class="post-title"><?php echo esc_html($name)?></h6>
                                                <div class="entry-meta post-meta meta-font">
                                                <div class="post-meta-wrap">
                                                    <div class="role"><span><?php echo esc_html__('Air Date:', 'vidorev-extensions').' '.esc_html($air_date)?></span></div>												
                                                </div>
                                                <div class="post-meta-wrap">
                                                    <div class="role"><span><?php echo esc_html__('Episodes:', 'vidorev-extensions').' '.esc_html($episode_count)?></span></div>												
                                                </div>
                                            </div>
                                            </div>									
                                        </div>                                   
                                    </div>				
                                <?php				
                                endforeach;
                                ?>
                            </div>
                            <div class="tmdb_showmore_wrapper"><span class="tmdb_showmore_button tmdb_showmore_button_control"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span></div>                        
                        </div>
                    <?php
					}
				}
			}
		}
	}
}

add_action('vidorev_tmdb_tv_single_block_html', 'vidorev_tmdb_tv_single_block_html', 10, 1);