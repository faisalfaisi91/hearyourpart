<?php
if(!class_exists('vidorev_walkernav')):
	class vidorev_walkernav extends Walker_Nav_Menu{
		public $megaMenuID;
		public $megaMenuHTML;
		
		public function __construct(){
			$this->megaMenuID = 0;
			$this->megaMenuHTML = '';
		}
		
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
	 
			$classes = array( 'sub-menu' );
	 
			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			if ($this->megaMenuID != 0 && $depth > 0) {
				$output .= '';
			}else{
				if ($this->megaMenuID != 0 && $depth == 0) {
					$output .= "{$n}{$indent}<ul$class_names><li class='megamenu-wrapper megamenu-wrapper-control dark-background'><ul class='megamenu-menu body-typography'>{$n}";
				}else{	
					$output .= "{$n}{$indent}<ul$class_names>{$n}";
				}
			}
		}
	 
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
			
			if ($this->megaMenuID != 0 && $depth > 0) {
				$output .= '';
			}else{
				if ($this->megaMenuID != 0 && $depth == 0) {
					$post_html 			= $this->megaMenuHTML;
					$this->megaMenuHTML = '';
					$output .= "$indent</ul><ul class='megamenu-content body-typography'><li>".$post_html."</li></ul></li></ul>{$n}";
				}else{	
					$output .= "$indent</ul>{$n}";
				}
			}
		}
	
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
	 
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			
			$extraClassName = trim(get_post_meta( $item->ID, 'menu-item-vidorev-megamenu-extra_class', true ));
			
			if($extraClassName!=''){
				$classes[] = $extraClassName;
			}
			
			if ($this->megaMenuID != 0 && $this->megaMenuID != intval($item->menu_item_parent) && $depth == 0) {
				$this->megaMenuID = 0;
			}
			
			$hasMegaMenu = get_post_meta( $item->ID, 'menu-item-vidorev-megamenu-active', true );
			if($depth==0 && $hasMegaMenu && vidorev_get_redux_option('mega_menu', 'off', 'switch') == 'on'){
				$classes[] = 'top-megamenu';
				$this->megaMenuID = $item->ID;
			}
	 
			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
	 
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	 
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	 		
			if ($this->megaMenuID != 0 && $depth > 1) {
				$output .= '';
			}else{	 		
				$output .= $indent . '<li' . $id . $class_names .'>';
			}	
			 
			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
	 
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
	 
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
	 
			$title = apply_filters( 'the_title', $item->title, $item->ID );

			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
	 		
			$hasParentMegaMenu = false;
			if($depth==1){
				if(isset($item->menu_item_parent)){
					$hasParentMegaMenu = get_post_meta( $item->menu_item_parent, 'menu-item-vidorev-megamenu-active', true );
				}
				
			}
			
			if($hasParentMegaMenu && vidorev_get_redux_option('mega_menu', 'off', 'switch') == 'on'){
				$id_control = $item->object_id.'-'.rand(1, 99999);
				$item_output = '<h3 class="megamenu-item-heading h7 megamenu-item-control" data-id="'.esc_attr($id_control).'"><a href="'.esc_url($atts['href']).'">'.esc_html($title).'</a></h3>';
				
				if(isset($item->type) && isset($item->object) && isset($item->object_id) && $item->type=='taxonomy' && $item->object!='' && $item->object_id != 0){
					$html = '';
					if(vidorev_get_redux_option('mega_menu_pag', 'off', 'switch') == 'off'){
						$args_query = array(
							'post_type'				=> 'post',
							'posts_per_page' 		=> 4,
							'post_status' 			=> 'publish',
							'ignore_sticky_posts' 	=> 1,
							'tax_query' 			=> array(
								'relation' => 'AND',
								array(
									'taxonomy' 			=> $item->object,							
									'terms' 			=> array( $item->object_id ),							
								),
							),		
						);					
						
						$posts = get_posts( $args_query );					
						if($posts){
							ob_start();
							?>
								<div class="blog-wrapper global-blog-wrapper blog-wrapper-control" data-id="<?php echo esc_attr($id_control);?>">
									<div class="blog-items site__row grid-default">
										<?php 
										foreach ( $posts as $post):
										?>
											<article <?php post_class('post-item site__col'); ?>>
												<div class="post-item-wrap">
												
													<?php
													$image_ratio_case = vidorev_image_ratio_case('1x'); 
													do_action('vidorev_thumbnail', apply_filters('vidorev_custom_grid_megamenu_image_size', 'vidorev_thumb_16x9_1x'), apply_filters('vidorev_custom_grid_megamenu_image_ratio', 'class-16x9'), 1, $post->ID, $image_ratio_case ); 
													?>
													
													<div class="listing-content">
														
														<h3 class="entry-title h6 post-title"> 
															<a href="<?php echo esc_url(vidorev_get_post_url($post->ID)); ?>" title="<?php esc_attr(get_the_title($post->ID)); ?>"><?php echo get_the_title($post->ID);?></a> 
														</h3>
													
													</div>
													
												</div>
											</article>
										<?php 
										endforeach;
										?>
									</div>
								</div>
							<?php
							$html = ob_get_contents();
							ob_end_clean();
						}
					}elseif(vidorev_get_redux_option('mega_menu_pag', 'off', 'switch') == 'on'){
						$html = do_shortcode('[block_sc layout="grid-sm-4-col" category="'.$item->object_id.'" items_per_page="4" post_count="-1" image_ratio="16_9" display_categories="no" display_author="no" display_date="no" display_comment_count="no" display_view_count="no" display_like_count="no" display_dislike_count="no" overwirte_rnd="'.$id_control.'"]');
					}
					
					$this->megaMenuHTML.=$html;
				}
				
			}elseif($this->megaMenuID != 0 && $depth > 1){
				$item_output = '';
			}else{
				$argsBefore 	= ( is_array($args) && isset($args['before']) )?$args['before']:( isset($args->before)?$args->before:'' );
				$argsAfter 		= ( is_array($args) && isset($args['after']) )?$args['after']:( isset($args->after)?$args->after:'' );			
				$argsLinkBefore = ( is_array($args) && isset($args['link_before']) )?$args['link_before']:( isset($args->link_before)?$args->link_before:'' );
				$argsLinkAfter 	= ( is_array($args) && isset($args['link_after']) )?$args['link_after']:( isset($args->link_after)?$args->link_after:'' );
				
				$item_output = $argsBefore;
				$item_output .= '<a'. $attributes .'>';
				$item_output .= $argsLinkBefore . $title . $argsLinkAfter;
				$item_output .= '</a>';
				$item_output .= $argsAfter;
			}

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
		
		public function end_el( &$output, $item, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			if ($this->megaMenuID != 0 && $depth > 1) {
				$output .= '';
			}else{
				$output .= "</li>{$n}";
			}
		}
	}
endif;