<?php
/*Template Name: Blog Page Template*/

get_header();

$page_id			= get_the_ID();
$paged 				= get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);

$sidebarControl 	= vidorev_sidebar_control();
$archive_style 		= vidorev_archive_style();

$blog_page_title						= get_post_meta($page_id, 'blog_page_title', true);
$blog_page_heading						= get_post_meta($page_id, 'blog_page_heading', true);
$vidorev_post_meta_control_template 	= vidorev_post_meta_control_template();
$vidorev_category_element_template		= vidorev_category_element_template();
$vidorev_excerpt_element_template		= vidorev_excerpt_element_template();
$blog_items_per_page					= get_post_meta($page_id, 'blog_items_per_page', true);
$pagination_type 						= get_post_meta($page_id, 'blog_pag_type', true);

$wp_query 			= vidorev_detech_wp_query();	
$wp					= vidorev_detech_wp();
?>

<div id="primary-content-wrap" class="primary-content-wrap">
	<div class="primary-content-control">
		<div class="site__container fullwidth-vidorev-ctrl container-control">
			
			<?php 
			if($paged==1 || $blog_page_heading == 'on'){
				do_action( 'vidorev_nav_breadcrumbs' );
			?>			
				<div class="site__row sidebar-direction sidebar-template-direction">							
					<main id="main-content" class="site__col main-content main-template-content">	
						
						<div class="single-page-wrapper global-single-wrapper">
								
							<?php
							while ( have_posts() ) : the_post();
				
								get_template_part( 'template-parts/content', 'page' );
				
								if ( (comments_open() || get_comments_number()!=0 ) && vidorev_get_redux_option('single_page_comment', 'on', 'switch')=='on') :
									comments_template();
								endif;
				
							endwhile;
							?>
								
						</div>
						
					</main>
				</div>			
			<?php 
			}
			
			/*adv filter*/
			$adv_keyword 				= isset($_GET['keyword'])?esc_attr(trim($_GET['keyword'])):'';
			$adv_tags					= isset($_GET['tags'])?esc_attr(trim($_GET['tags'])):'';
			$adv_tags					= explode(',', $adv_tags);
			$blog_page_advance_search 	= get_post_meta($page_id, 'blog_page_advance_search', true);
 			/*adv filter*/
			
			$template_post_query = array(
				'post_type' 			=> 'post',
				'posts_per_page' 		=> is_numeric($blog_items_per_page)?$blog_items_per_page:10,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1,
				'paged' 				=> $paged,
			);
			
			$args_re = array('relation' => 'OR');
			
			$category 			= trim(get_post_meta($page_id, 'blog_page_ic', true));
			$tag 				= trim(get_post_meta($page_id, 'blog_page_it', true));
			$ex_category 		= trim(get_post_meta($page_id, 'blog_page_ec', true));
			$ids 				= trim(get_post_meta($page_id, 'blog_page_ip', true));
			
			if($ids!='' && $blog_page_advance_search!='on'){
				$idsArray = array();
				$idsExs = explode(',', $ids);
				foreach($idsExs as $idsEx){	
					if(is_numeric(trim($idsEx))){					
						array_push($idsArray, trim($idsEx));
					}
				}
				
				if(count($idsArray)>0){
					$template_post_query['post__in'] = $idsArray;
				}
			}
			
			$s_tax_query = 'category';			
						
			if($ex_category!='' && $blog_page_advance_search!='on'){
				$ex_catArray = array();
				
				$ex_catExs = explode(',', $ex_category);
				
				foreach($ex_catExs as $ex_catEx){	
					if(is_numeric(trim($ex_catEx))){					
						array_push($ex_catArray, trim($ex_catEx));
					}else{
						$slug_ex_cat = get_term_by('slug', trim($ex_catEx), $s_tax_query);					
						if($slug_ex_cat){
							$ex_cat_term_id = $slug_ex_cat->term_id;
							array_push($ex_catArray, $ex_cat_term_id);
						}
					}
				}
				
				if(count($ex_catArray) > 0){
					$ex_def = array(
						'field' 			=> 'id',
						'operator' 			=> 'NOT IN',
					);
					
					if(count($ex_catArray) > 0){						
						$args_ex_cat_query = wp_parse_args(
							array(
								'taxonomy'	=> $s_tax_query,
								'terms'		=> $ex_catArray,
							),
							$ex_def
						);
						
						$args_re[] = $args_ex_cat_query;
					}
				}	
			}
			
			if(($category!='' || $tag!='') && $blog_page_advance_search!='on'){
				$catArray = array();
				$tagArray = array();
			
				$catExs = explode(',', $category);
				$tagExs = explode(',', $tag);
				
				foreach($catExs as $catEx){	
					if(is_numeric(trim($catEx))){					
						array_push($catArray, trim($catEx));
					}else{
						$slug_cat = get_term_by('slug', trim($catEx), $s_tax_query);					
						if($slug_cat){
							$cat_term_id = $slug_cat->term_id;
							array_push($catArray, $cat_term_id);
						}
					}
				}			
				
				foreach($tagExs as $tagEx){	
					if(is_numeric(trim($tagEx))){					
						array_push($tagArray, trim($tagEx));
					}else{
						$slug_tag = get_term_by('slug', trim($tagEx), 'post_tag');									
						if($slug_tag){
							$tag_term_id = $slug_tag->term_id;	
							array_push($tagArray, $tag_term_id);
						}
					}
				}
				
				if(count($catArray) > 0 || count($tagArray) > 0){
					$taxonomies = array();
					
					$def = array(
						'field' 			=> 'id',
						'operator' 			=> 'IN',
					);
					
					if(count($catArray) > 0){
						array_push($taxonomies, $s_tax_query);
						$args_cat_query = wp_parse_args(
							array(
								'taxonomy'	=> $s_tax_query,
								'terms'		=> $catArray,
							),
							$def
						);
					}
					
					if(count($tagArray) > 0){
						array_push($taxonomies, 'post_tag');
						$args_tag_query = wp_parse_args(
							array(
								'taxonomy'	=> 'post_tag',
								'terms'		=> $tagArray,
							),
							$def
						);
					}
					
					if(count($taxonomies) > 1){
						$args_re[] = array(
							'relation' => 'OR',
							$args_cat_query,
							$args_tag_query,	
						);
					}else{
						if(count($catArray) > 0 && count($tagArray) == 0){
							$args_re[] = $args_cat_query;
						}elseif(count($catArray) == 0 && count($tagArray) > 0){
							$args_re[] = $args_tag_query;
						}
					}			
					
				}
			}
			
			if(count($args_re)>1 && $blog_page_advance_search!='on'){
				if(count($args_re)>2){
					$args_re['relation'] = 'AND';
				}
				$template_post_query['tax_query'] = $args_re;
			}
			
			if($blog_page_advance_search == 'on'){
				if($adv_keyword!=''){
					$template_post_query['s'] = $adv_keyword;
				}
				
				if(is_array($adv_tags) && count($adv_tags)>0){
					$template_post_query['tag__and'] = $adv_tags;
				}
			}
			
			$fn_template_post_query = apply_filters('beeteam368_template_blog_query', $template_post_query, $blog_page_advance_search);
																			
			$post_query = new WP_Query($fn_template_post_query);						
									
			$wp_query = $post_query;
			?>
			
			<div class="site__row sidebar-direction">
            	<?php 				
				$blog_page_advance_search_id = get_post_meta($page_id, 'blog_page_advance_search_id', true);
				$filter_arr = get_post_meta($blog_page_advance_search_id, 'filter_tags_settings_group', true);
				
				if($blog_page_advance_search == 'on' && is_array($filter_arr) && count($filter_arr)>0){
				?>
                	<aside id="main-sidebar" class="site__col main-sidebar sidebar-filter main-sidebar-control">
                        <div class="sidebar-content sidebar-content-control">
                            <div class="sidebar-content-inner sidebar-content-inner-control">
                            	<div class="widget r-widget-control vidorev-advance-search">
                                	<div class="widget-item-wrap">                                    	
                                        <h2 class="widget-title h5 extra-bold">
                                        	<span class="title-wrap"><?php echo esc_html__('Advance Search', 'vidorev-extensions')?></span>
                                        </h2>
                                        <ul class="ft-search-box ft-search-box-control ft-search-box-top">
                                        	<li>
                                            	<input type="text" class="ft-keyword-control-top" placeholder="<?php echo esc_html__('Keyword...', 'vidorev-extensions')?>" value="<?php echo esc_attr($adv_keyword);?>">
                                                <button class="apply-ft-control" data-url="<?php echo esc_url(add_query_arg( array('paged' => '1'), vidorev_get_nopaging_url()));?>"><?php echo esc_html__('Apply', 'vidorev-extensions')?></button>
                                            </li>
                                        </ul>
                                        <ul class="filter-block">                                        
											<?php 
                                            foreach($filter_arr as $filter_item){
												$z_g = 1;
                                            ?>
                                            	<li class="ft-group ft-group-control">
                                                	<h6 class="filter-group-title filter-group-title-control"><?php echo isset($filter_item['group_name'])?esc_html($filter_item['group_name']):'. . .'?> <i class="fa fa-angle-double-up" aria-hidden="true"></i></h6>
                                                    <ul class="ft-group-items ft-group-items-control">
                                                    <?php 
													if(isset($filter_item['tags']) && is_array($filter_item['tags']) && count($filter_item['tags'])>0){														
														foreach($filter_item['tags'] as $tag_id){
															$tag_item = get_tags(array('hide_empty'=>false, 'include' => array( $tag_id )));
															if($tag_item){
																foreach ( $tag_item as $tag_details ) :
														?>
                                                        			<li><input type="checkbox" name="tag_item_ft[]" value="<?php echo esc_attr($tag_details->term_id);?>" id="<?php echo esc_attr('g'.$z_g.$tag_details->term_id);?>"<?php echo array_search($tag_details->term_id, $adv_tags)!==FALSE?' checked':''?>> &nbsp; <label for="<?php echo esc_attr('g'.$z_g.$tag_details->term_id);?>"><?php echo esc_html($tag_details->name);?></label></li>
                                                        <?php
																endforeach;	
															}
															
														}
													}
													?>
                                                    </ul>
                                                </li>
                                            <?php
												$z_g++;    
                                            }	
                                            ?>
                                        </ul>
                                        <ul class="ft-search-box ft-search-box-control ft-search-box-bottom">
                                        	<li>
                                            	<input type="text" class="ft-keyword-control-bottom" placeholder="<?php echo esc_html__('Keyword...', 'vidorev-extensions')?>" value="<?php echo esc_attr($adv_keyword);?>">
                                                <button class="apply-ft-control" data-url="<?php echo esc_url(add_query_arg( array('paged' => '1'), vidorev_get_nopaging_url()));?>"><?php echo esc_html__('Apply', 'vidorev-extensions')?></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>    
                                
                                <?php dynamic_sidebar( 'advancesearch-sidebar' ); ?>
                            </div>
                        </div>
                    </aside>
                <?php
				}
				?>
            							
				<div class="site__col main-content">	
					
					<?php 
					if($blog_page_title != ''){
					?>
					<div class="blog-page-title">
						<h2 class="h4 extra-bold"><?php echo esc_html($blog_page_title);?></h2>
					</div>
					<?php
					}
					
					if ( have_posts() ) :
					?>
					
                        <div class="blog-wrapper global-blog-wrapper blog-wrapper-control">
    
                            <script>vidorev_jav_js_object['query_vars'] = <?php echo json_encode($wp_query->query_vars);?>;</script>
                            
                            <div class="blog-items blog-items-control site__row <?php echo esc_attr($archive_style);?>">
                                <?php																	
                                while ( have_posts() ) : the_post();
                                    if($archive_style!='movie-grid'){			
                                        do_action('vidorev_between_post_content_ads');
                                    }
                                    get_template_part( 'template-parts/content', $archive_style );
                    
                                endwhile;								
                                ?>
                            </div>
                            
                            <?php do_action('vidorev_pagination', 'template-parts/content', $archive_style, $pagination_type); ?>
                            
                        </div>
					<?php
					else:
						if($blog_page_advance_search == 'on'){
							?>
								<h5 class="nore-ft-adv"><?php echo esc_html__('Sorry, no matches found for your query.', 'vidorev-extensions');?></h5>
							<?php										
						}	
					endif;
					wp_reset_postdata();
					?>
				</div>
				
				<?php								
				if($sidebarControl!='hidden' && $blog_page_advance_search != 'on'){
					get_sidebar();
				}
				?>
				
			</div>
			
		</div>
	</div>
</div>

<?php
get_footer();