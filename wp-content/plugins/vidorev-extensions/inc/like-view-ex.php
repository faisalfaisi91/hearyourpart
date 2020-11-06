<?php
if(!class_exists('vidorev_like_view_sorting')):
	class vidorev_like_view_sorting{
		
		static function vidorev_post_join_view($sql){
			global $wpdb;		
			return $sql . ' LEFT JOIN ' . $wpdb->prefix . 'post_views vid_pvc ON (vid_pvc.id = ' . $wpdb->prefix . 'posts.ID)';
		}
		
		static function vidorev_post_where_view_all($sql){
			global $wpdb;		
			return $sql . ' AND vid_pvc.type = 4';
		}
		
		static function vidorev_post_where_view_day($sql){
			global $wpdb;		
			
			$day = date('Ymd');		
			return $sql . ' AND vid_pvc.type = 0 AND vid_pvc.period = '.$day;
		}
	
		static function vidorev_post_where_view_week($sql){
			global $wpdb;
			
			$week = date('YW');
			return $sql . ' AND vid_pvc.type = 1 AND vid_pvc.period = '.$week;
		}
	
		static function vidorev_post_where_view_month($sql){
			global $wpdb;
			
			$month = date('Ym');		
			return $sql . ' AND vid_pvc.type = 2 AND vid_pvc.period = '.$month;
		}
	
		static function vidorev_post_where_view_year($sql){
			global $wpdb;
			
			$year = date('Y');		
			return $sql . ' AND vid_pvc.type = 3 AND vid_pvc.period = '.$year;
		}
	
		static function vidorev_post_order_view($sql){
			global $wpdb;		
			return 'vid_pvc.count DESC';
		}
		
		static function vidorev_post_order_view_asc($sql){
			global $wpdb;		
			return 'vid_pvc.count ASC';
		}
		
		static function vidorev_post_fields_like($sql){
			global $wpdb;		
			return $sql . ', SUM(vid_ld.value) AS like_count';
		}
		
		static function vidorev_post_join_like($sql){
			global $wpdb;		
			return $sql . ' LEFT JOIN ' . $wpdb->prefix . 'vpe_like_dislike vid_ld ON (vid_ld.post_id = ' . $wpdb->prefix . 'posts.ID)';
		}
		
		static function vidorev_post_where_like_all($sql){
			global $wpdb;			
			return $sql . ' AND vid_ld.value > 0';
		}
		
		static function vidorev_post_where_like_day($sql){
			global $wpdb;
			$last_date = vidorev_get_last_date('1');			
			return $sql . ' AND vid_ld.value > 0 AND DATE(vid_ld.date_time) >= "'.$last_date.'"';
		}
		
		static function vidorev_post_where_like_week($sql){
			global $wpdb;
			$last_date = vidorev_get_last_date('7');	
			return $sql . ' AND vid_ld.value > 0 AND DATE(vid_ld.date_time) >= "'.$last_date.'"';
		}
		
		static function vidorev_post_where_like_month($sql){
			global $wpdb;	
			$last_date = vidorev_get_last_date('1m');
			return $sql . ' AND vid_ld.value > 0 AND DATE(vid_ld.date_time) >= "'.$last_date.'"';
		}
		
		static function vidorev_post_where_like_year($sql){
			global $wpdb;	
			$last_date = vidorev_get_last_date('1y');
			return $sql . ' AND vid_ld.value > 0 AND DATE(vid_ld.date_time) >= "'.$last_date.'"';
		}
		
		static function vidorev_post_order_like($sql){
			global $wpdb;		
			return 'like_count DESC';
		}
		
		static function vidorev_post_order_like_asc($sql){
			global $wpdb;		
			return 'like_count ASC';
		}
		
		static function vidorev_posts_groupby($groupby) {
			global $wpdb;
			$groupby = $wpdb->prefix . 'posts.ID';
			return $groupby;
		}
		
		static function vidorev_post_fields_view_like($sql){
			global $wpdb;		
			return $sql . ', (SUM(vid_ld.value) + vid_pvc.count) AS total_view_like';
		}
		
		static function vidorev_post_join_view_like($sql){
			global $wpdb;		
			return $sql . ' LEFT JOIN ' . $wpdb->prefix . 'post_views vid_pvc ON (vid_pvc.id = ' . $wpdb->prefix . 'posts.ID)  LEFT JOIN ' . $wpdb->prefix . 'vpe_like_dislike vid_ld ON (vid_ld.post_id = ' . $wpdb->prefix . 'posts.ID)';
		}
		
		static function vidorev_post_where_view_like_all($sql){
			global $wpdb;		
			return $sql . ' AND vid_pvc.type = 4 AND vid_ld.value > 0';
		}
		
		static function vidorev_post_order_view_like($sql){
			global $wpdb;		
			return 'total_view_like DESC';
		}
		
		static function vidorev_post_order_view_like_asc($sql){
			global $wpdb;		
			return 'total_view_like ASC';
		}		
		
		static function vidorev_post_join_view_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view_sorting'), 10);		
				return $sql . ' LEFT JOIN ' . $wpdb->prefix . 'post_views vid_pvc ON (vid_pvc.id = ' . $wpdb->prefix . 'posts.ID)';
			}
		}

		static function vidorev_post_where_view_all_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all_sorting'), 10);			
				return $sql . ' AND vid_pvc.type = 4';
			}
		}

		static function vidorev_post_order_view_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;		
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view_sorting'), 10);
				return 'vid_pvc.count DESC';
			}
		}

		static function vidorev_post_fields_like_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like_sorting'), 10);		
				return $sql . ', SUM(vid_ld.value) AS like_count';
			}
		}
	
		static function vidorev_post_join_like_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like_sorting'), 10);		
				return $sql . ' LEFT JOIN ' . $wpdb->prefix . 'vpe_like_dislike vid_ld ON (vid_ld.post_id = ' . $wpdb->prefix . 'posts.ID)';
			}
		}

		static function vidorev_post_where_like_all_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all_sorting'), 10);			
				return $sql . ' AND vid_ld.value > 0';
			}
		}

		static function vidorev_post_order_like_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;	
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like_sorting'), 10);	
				return 'like_count DESC';
			}
		}

		static function vidorev_posts_groupby_sorting($groupby, $query) {
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;
				$groupby = $wpdb->prefix . 'posts.ID';
				remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby_sorting'), 10);
				return $groupby;
			}
		}

		static function vidorev_post_where_alphabet($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_alphabet'), 10);	
				return $sql . ' AND ' .$wpdb->prefix . 'posts.post_title LIKE "'.sanitize_title(sprintf('%s', trim($_GET['alphabet_filter']))).'%"';
			}
		}

		static function vidorev_post_where_alphabet_temp($sql){
			
			$alphabet_filter = '';
			if(isset($_GET['alphabet_filter']) && trim($_GET['alphabet_filter'])!=''){
				$alphabet_filter = trim($_GET['alphabet_filter']);
			}elseif(isset($_POST['alphabet_filter']) && trim($_POST['alphabet_filter'])!=''){
				$alphabet_filter = trim($_POST['alphabet_filter']);
			}
					
			global $wpdb;					
			return $sql . ' AND ' .$wpdb->prefix . 'posts.post_title LIKE "'.sanitize_title(sprintf('%s', $alphabet_filter)).'%"';
	
		}
		
		/*subscribed*/
		static function vidorev_post_fields_subscribed($sql){
			global $wpdb;		
			return $sql . ', vid_channel_count.meta_value';
		}		
		static function vidorev_post_join_subscribed($sql){
			global $wpdb;		
			return $sql . ' LEFT JOIN ' . $wpdb->prefix . 'postmeta vid_channel_count ON (vid_channel_count.post_id = ' . $wpdb->prefix . 'posts.ID)';
		}
		static function vidorev_post_where_subscribed($sql){
			global $wpdb;			
			return $sql . ' AND vid_channel_count.meta_key = "vidorev_channel_sub_count"';
		}
		static function vidorev_post_order_subscribed_desc($sql){
			global $wpdb;		
			return 'vid_channel_count.meta_value DESC';
		}
		static function vidorev_post_order_subscribed_asc($sql){
			global $wpdb;		
			return 'vid_channel_count.meta_value ASC';
		}
		
		static function vidorev_post_fields_subscribed_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_subscribed_sorting'), 10);		
				return $sql . ', vid_channel_count.meta_value';
			}
		}		
		static function vidorev_post_join_subscribed_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;	
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_subscribed_sorting'), 10);			
				return $sql . ' LEFT JOIN ' . $wpdb->prefix . 'postmeta vid_channel_count ON (vid_channel_count.post_id = ' . $wpdb->prefix . 'posts.ID)';
			}
		}
		static function vidorev_post_where_subscribed_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;			
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_subscribed_sorting'), 10);	
				return $sql . ' AND vid_channel_count.meta_key = "vidorev_channel_sub_count"';
			}
		}
		static function vidorev_post_order_subscribed_sorting($sql, $query){
			if($query->is_main_query() && $query->is_archive()){
				global $wpdb;	
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_subscribed_sorting'), 10);		
				return 'vid_channel_count.meta_value DESC';
			}
		}
		/*subscribed*/	
		
		/*star rating*/
		static function vidorev_post_fields_star_rating($sql){
			global $wpdb;
			
			$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');
			
			switch($user_rating_mode){
				case 'single':
					return $sql . ', COUNT(vid_YASR_sr.post_id) AS number_of_votes, (SUM(vid_YASR_sr.vote) / COUNT(vid_YASR_sr.post_id)) AS result';
					break;
					
				case 'multi-sets':
					return $sql . ', COUNT(vid_YASR_sr.post_id) AS number_of_rows, ( SUM( (vid_YASR_sr.sum_votes/vid_YASR_sr.number_of_votes) ) / COUNT(vid_YASR_sr.post_id)) AS result';
					break;
					
				default:	
					return $sql;	
			}
		}		
		static function vidorev_post_join_star_rating($sql){
			global $wpdb;
			
			$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');
			
			switch($user_rating_mode){
				case 'single':
					return $sql . ' LEFT JOIN ' . YASR_LOG_TABLE . ' vid_YASR_sr ON (vid_YASR_sr.post_id = ' . $wpdb->prefix . 'posts.ID)';
					break;
					
				case 'multi-sets':
					return $sql . ' LEFT JOIN ' . YASR_MULTI_SET_VALUES_TABLE . ' vid_YASR_sr ON (vid_YASR_sr.post_id = ' . $wpdb->prefix . 'posts.ID)';
					break;
					
				default:	
					return $sql;	
			}			
		}
		static function vidorev_post_where_star_rating($sql){
			global $wpdb;
			
			$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');
			
			switch($user_rating_mode){
				case 'single':
					return $sql . ' AND vid_YASR_sr.vote > 0';
					break;
					
				case 'multi-sets':
					$user_rating_multi_sets = vidorev_get_redux_option('user_rating_multi_sets', '');
					if(!is_numeric($user_rating_multi_sets)){
						$user_rating_multi_sets = -1;
					}
					
					return $sql . " AND vid_YASR_sr.set_type = '".$user_rating_multi_sets."' AND vid_YASR_sr.number_of_votes > 0";
					break;
					
				default:	
					return $sql;	
			}
		}		
		static function vidorev_post_order_star_rating_desc($sql){
			global $wpdb;
			
			$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');
			
			switch($user_rating_mode){
				case 'single':
					return 'result DESC, number_of_votes DESC';
					break;
					
				case 'multi-sets':
					return 'result DESC, number_of_rows DESC';
					break;
					
				default:	
					return $sql;	
			}
		}
		static function vidorev_post_order_star_rating_asc($sql){
			global $wpdb;	
			
			$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');
			
			switch($user_rating_mode){
				case 'single':
					return 'result ASC, number_of_votes ASC';
					break;
					
				case 'multi-sets':
					return 'result ASC, number_of_rows ASC';
					break;
					
				default:	
					return $sql;	
			}
		}
		
			static function vidorev_post_fields_star_rating_sorting($sql, $query){
				if($query->is_main_query() && $query->is_archive()){
					global $wpdb;
					remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_star_rating_sorting'), 10);
					
					$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');

					switch($user_rating_mode){
						case 'single':
							return $sql . ', COUNT(vid_YASR_sr.post_id) AS number_of_votes, (SUM(vid_YASR_sr.vote) / COUNT(vid_YASR_sr.post_id)) AS result';
							break;
							
						case 'multi-sets':
							return $sql . ', COUNT(vid_YASR_sr.post_id) AS number_of_rows, ( SUM( (vid_YASR_sr.sum_votes/vid_YASR_sr.number_of_votes) ) / COUNT(vid_YASR_sr.post_id)) AS result';
							break;
							
						default:	
							return $sql;	
					}
					
				}
			}		
			static function vidorev_post_join_star_rating_sorting($sql, $query){
				if($query->is_main_query() && $query->is_archive()){
					global $wpdb;						
					remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_star_rating_sorting'), 10);	
					
					$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');
					
					switch($user_rating_mode){
						case 'single':
							return $sql . ' LEFT JOIN ' . YASR_LOG_TABLE . ' vid_YASR_sr ON (vid_YASR_sr.post_id = ' . $wpdb->prefix . 'posts.ID)';
							break;
							
						case 'multi-sets':
							return $sql . ' LEFT JOIN ' . YASR_MULTI_SET_VALUES_TABLE . ' vid_YASR_sr ON (vid_YASR_sr.post_id = ' . $wpdb->prefix . 'posts.ID)';
							break;
							
						default:	
							return $sql;	
					}
				}
			}
			static function vidorev_post_where_star_rating_sorting($sql, $query){
				if($query->is_main_query() && $query->is_archive()){
					global $wpdb;							
					remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_star_rating_sorting'), 10);	
					
					$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');
					
					switch($user_rating_mode){
						case 'single':
							return $sql . ' AND vid_YASR_sr.vote > 0';
							break;
							
						case 'multi-sets':
							$user_rating_multi_sets = vidorev_get_redux_option('user_rating_multi_sets', '');
							if(!is_numeric($user_rating_multi_sets)){
								$user_rating_multi_sets = -1;
							}
							
							return $sql . " AND vid_YASR_sr.set_type = '".$user_rating_multi_sets."' AND vid_YASR_sr.number_of_votes > 0";
							break;
							
						default:	
							return $sql;	
					}
				}
			}
			static function vidorev_post_order_star_rating_sorting($sql, $query){
				if($query->is_main_query() && $query->is_archive()){
					global $wpdb;					
					remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_star_rating_sorting'), 10);	
					
					$user_rating_mode = vidorev_get_redux_option('user_rating_mode', 'single');
					
					switch($user_rating_mode){
						case 'single':
							return 'result DESC, number_of_votes DESC';
							break;
							
						case 'multi-sets':
							return 'result DESC, number_of_rows DESC';
							break;
							
						default:	
							return $sql;	
					}
				}
			}
		/*star rating*/
		
		/*post filter*/
			static function vidorev_add_ttt_1(){
				add_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_view_like'));
				add_filter('posts_join', array(__CLASS__, 'vidorev_post_join_view_like'));
				add_filter('posts_where', array(__CLASS__, 'vidorev_post_where_view_like_all'));
				add_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));	
				add_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_view_like'));				
			}
			static function vidorev_remove_ttt_1(){
				remove_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_view_like'));
				remove_filter('posts_join', array(__CLASS__, 'vidorev_post_join_view_like'));
				remove_filter('posts_where', array(__CLASS__, 'vidorev_post_where_view_like_all'));
				remove_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_view_like'));
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_view_like_asc'));	
			}
			
			static function vidorev_add_ttt_2(){
				add_filter('posts_join', array(__CLASS__, 'vidorev_post_join_view'));
				add_filter('posts_where', array(__CLASS__, 'vidorev_post_where_view_all'));
				add_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_view'));
			}
			static function vidorev_remove_ttt_2(){
				remove_filter('posts_join', array(__CLASS__, 'vidorev_post_join_view'));
				remove_filter('posts_where', array(__CLASS__, 'vidorev_post_where_view_all'));
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_view'));
			}
			
			static function vidorev_add_ttt_3(){
				add_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_like'));
				add_filter('posts_join', array(__CLASS__, 'vidorev_post_join_like'));
				add_filter('posts_where', array(__CLASS__, 'vidorev_post_where_like_all'));
				add_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));
				add_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_like'));
			}
			static function vidorev_remove_ttt_3(){
				remove_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_like'));
				remove_filter('posts_join', array(__CLASS__, 'vidorev_post_join_like'));
				remove_filter('posts_where', array(__CLASS__, 'vidorev_post_where_like_all'));	
				remove_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));				
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_like'));
			}
			
			static function vidorev_add_ttt_4(){
				add_filter('posts_join', array(__CLASS__, 'vidorev_post_join_view'));
				add_filter('posts_where', array(__CLASS__, 'vidorev_post_where_view_all'));
				add_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_view'));
			}
			static function vidorev_remove_ttt_4(){
				remove_filter('posts_join', array(__CLASS__, 'vidorev_post_join_view'));
				remove_filter('posts_where', array(__CLASS__, 'vidorev_post_where_view_all'));
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_view'));
			}
			
			static function vidorev_add_ttt_5(){
				add_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_like'));
				add_filter('posts_join', array(__CLASS__, 'vidorev_post_join_like'));
				add_filter('posts_where', array(__CLASS__, 'vidorev_post_where_like_all'));
				add_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));
				add_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_like'));
			}
			static function vidorev_remove_ttt_5(){
				remove_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_like'));
				remove_filter('posts_join', array(__CLASS__, 'vidorev_post_join_like'));
				remove_filter('posts_where', array(__CLASS__, 'vidorev_post_where_like_all'));	
				remove_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));				
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_like'));
			}
			
			static function vidorev_add_ttt_6(){
				add_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_subscribed'));
				add_filter('posts_join', array(__CLASS__, 'vidorev_post_join_subscribed'));
				add_filter('posts_where', array(__CLASS__, 'vidorev_post_where_subscribed'));
				add_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));	
				add_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_subscribed_desc'));
			}
			static function vidorev_remove_ttt_6(){
				remove_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_subscribed'));
				remove_filter('posts_join', array(__CLASS__, 'vidorev_post_join_subscribed'));
				remove_filter('posts_where', array(__CLASS__, 'vidorev_post_where_subscribed'));
				remove_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));	
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_subscribed_desc'));
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_subscribed_asc'));
			}
			
			static function vidorev_add_ttt_7(){
				add_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_star_rating'));
				add_filter('posts_join', array(__CLASS__, 'vidorev_post_join_star_rating'));
				add_filter('posts_where', array(__CLASS__, 'vidorev_post_where_star_rating'));						
				add_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));	
				add_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_star_rating_desc'));
			}
			static function vidorev_remove_ttt_7(){
				remove_filter('posts_fields', array(__CLASS__, 'vidorev_post_fields_star_rating'));
				remove_filter('posts_join', array(__CLASS__, 'vidorev_post_join_star_rating'));
				remove_filter('posts_where', array(__CLASS__, 'vidorev_post_where_star_rating'));						
				remove_filter('posts_groupby', array(__CLASS__, 'vidorev_posts_groupby'));	
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_star_rating_desc'));
				remove_filter('posts_orderby', array(__CLASS__, 'vidorev_post_order_star_rating_asc'));
			}
			
			static function vidorev_add_ttt_8(){
				add_filter('posts_where', array(__CLASS__, 'vidorev_post_where_alphabet_temp'));
			}
			static function vidorev_remove_ttt_8(){
				remove_filter('posts_where', array(__CLASS__, 'vidorev_post_where_alphabet_temp'));
			}
			
			static function vidorev_add_ttt_9(){
				add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
				add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
				add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
			}
			static function vidorev_remove_ttt_9(){
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_view'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_view_all'));
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_view'));
			}
			
			static function vidorev_add_ttt_10(){
				add_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
				add_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
				add_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));
				add_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));
				add_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
			}
			static function vidorev_remove_ttt_10(){
				remove_filter('posts_fields', array('vidorev_like_view_sorting', 'vidorev_post_fields_like'));
				remove_filter('posts_join', array('vidorev_like_view_sorting', 'vidorev_post_join_like'));
				remove_filter('posts_where', array('vidorev_like_view_sorting', 'vidorev_post_where_like_all'));	
				remove_filter('posts_groupby', array('vidorev_like_view_sorting', 'vidorev_posts_groupby'));				
				remove_filter('posts_orderby', array('vidorev_like_view_sorting', 'vidorev_post_order_like'));
			}
		/*post filter*/
	}
endif;

if(!class_exists('vidorev_extensions_action')):
	class vidorev_extensions_action{
		static function detect_source(){
			$_detect_theme = wp_get_theme();
			if ( 'VidoRev' === $_detect_theme->name || 'VidoRev' === $_detect_theme->parent_theme ) {
				return true;
			}        
			return false;
		}    
	}
endif;	