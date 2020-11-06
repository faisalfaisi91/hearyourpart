<?php
if ( !function_exists('vidorev_IMDb_ratings_html' ) ):
	function vidorev_IMDb_ratings_html(){
		$post_id 		= get_the_ID();
		$imdb_user 		= trim(vidorev_get_redux_option('imdb_user', ''));
		$imdb_ratings 	= trim(get_post_meta($post_id, MOVIE_PM_PREFIX.'imdb_ratings', true));
		$imdb_data		= trim(get_post_meta($post_id, 'beeteam368_imdb_data', true));
		
		if($imdb_user!='' && $imdb_ratings!=''){
			?>
			<div class="imdbRatingPlugin imdbRatingPlugin-control dark-background" data-user="<?php echo esc_attr($imdb_user);?>" data-title="<?php echo esc_attr($imdb_ratings);?>" data-imdbdata='<?php echo apply_filters('vidorev_imdb_datas', $imdb_data, $post_id);?>'></div>
			<?php
		}
	}
endif;
add_action('vidorev_IMDb_ratings_html', 'vidorev_IMDb_ratings_html');