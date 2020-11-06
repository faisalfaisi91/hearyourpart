<?php
namespace Elementor;
if(!class_exists('vidorev_Categories_Widget')){
	class vidorev_Categories_Widget extends Widget_Base {
		public function get_name() {
			return 'vidorev_categories_addon';
		}
		
		public function get_title() {
			return esc_html__( 'Categories', 'vidorev-extensions');
		}
	
		public function get_icon() {
			return 'fa fa-list';
		}
		
		public function get_categories() {
			return [ 'vidorev-addon-elements' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'vidorev_categories_addon_global_settings',
				[
					'label' 		=> esc_html__( 'Categories', 'vidorev-extensions')
				]
			);
			
			$this->add_control(
				'style',
				[
					'label'			=> esc_html__( 'Style', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> [
						'' 	=> esc_html__('Default', 'vidorev-extensions'),							
					]
				]
			);
		}
		
		public function get_categories_listing($cat, $i = 0) {
			$args_query = array(
				'orderby' 		=> 'name',
				'order'   		=> 'ASC',
				'hide_empty'	=> 0,
				'parent'		=> $cat,
			);
			
			$ex_category 	= trim(vidorev_get_option('ex_category', 'user_submit_settings', ''));
			$s_tax_query 	= 'category';
			
			if($ex_category!=''){
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
					
					$args_query['exclude'] = $ex_catArray;
					
				}	
			}
			if(!isset($i)){
				$i = 0;
			}
			
			$next = get_categories($args_query);
			
			$html = '';
			
			if( $next ) :
				$z = $i+1;
				$heading_class = 'h6';
				if($i==0){
					$html.='<div class="categories-listing-wrapper"><div class="categories-listing-content site__row">';
					$heading_class = 'h4 extra-bold';
				}		
				foreach( $next as $cat ) :
					$html.='<div class="category-item site__col">';	
							$html.='<div class="category-item-content">';
								$archive_img = get_metadata('term', $cat->term_id, CATEGORY_PM_PREFIX.'image', true);
								if($archive_img!=''){	
									$html.='<div class="category-item-img"><a class="category-link" href="'.esc_url(get_category_link($cat->term_id)).'"><img alt="'.esc_attr($cat->name).'" src="'.esc_url($archive_img).'"></a></div>';
								}
								$html.='<div class="category-item-text">';
									$html.='<h2 class="category-title '.$heading_class.'">';
										$html.='<a class="category-link" href="'.esc_url(get_category_link($cat->term_id)).'">'.esc_html($cat->name).'</a>';
									$html.='</h2>';
									$html.='<span class="category-post-count"><i class="fa fa-rss" aria-hidden="true"></i>&nbsp;&nbsp;'.esc_html(apply_filters('vidorev_number_format', $cat->category_count)).'</a>';
								$html.='</div>';
							$html.='</div>';	
						$html.=$this->get_categories_listing( $cat->term_id, $z);
					$html.='</div>';
				endforeach; 
				
				if($i==0){
					$html.='</div></div>';
				}  
				
				return $html;  
			endif;
		}
		
		protected function render() {
			$params = $this->get_settings();
			
			$style = (isset($params['style'])&&trim($params['style'])!='')?trim($params['style']):'';			
			
			echo $this->get_categories_listing(0);
	
		}
		
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new vidorev_Categories_Widget() );