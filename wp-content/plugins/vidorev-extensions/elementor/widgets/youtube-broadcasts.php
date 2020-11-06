<?php
namespace Elementor;
if(!class_exists('vidorev_Youtube_Broadcasts_Widget')){
	class vidorev_Youtube_Broadcasts_Widget extends Widget_Base {
		public function get_name() {
			return 'vidorev_youtube_broadcasts_addon';
		}
		
		public function get_title() {
			return esc_html__( 'Youtube Broadcasts', 'vidorev-extensions');
		}
	
		public function get_icon() {
			return 'fa fa-youtube-square';
		}
		
		public function get_categories() {
			return [ 'vidorev-addon-elements' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'vidorev_youtube_broadcasts_addon_global_settings',
				[
					'label' 		=> esc_html__( 'Youtube Live Broadcasts', 'vidorev-extensions')
				]
			);
			
			$list_shortcode = array();
			
			$args_query = array(
				'post_type'				=> 'youtube_broadcast',
				'posts_per_page' 		=> -1,
				'post_status' 			=> 'publish',
			);
			
			$boardcasts_query = get_posts($args_query);
			
			if($boardcasts_query):
				foreach ( $boardcasts_query as $item) :
					$list_shortcode[$item->ID] = esc_html__('ID', 'vidorev-extensions').': '.esc_attr($item->ID).' - '.esc_html__('Name', 'vidorev-extensions').': '.esc_attr($item->post_title);
				endforeach;
			endif;
			
			$this->add_control(
				'broadcast_id',
				[
					'label'			=> esc_html__( 'Broadcast ID', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '0',
					'options'		=> $list_shortcode,
				]
			);
		}
		
		protected function render() {
			$params = $this->get_settings();
			
			$broadcast_id = (isset($params['broadcast_id'])&&trim($params['broadcast_id'])!=''&&is_numeric(trim($params['broadcast_id'])))?trim($params['broadcast_id']):0;
			
			if($broadcast_id==0){
				echo '';
				return;
			}
			
			echo do_shortcode('[youtube_live_broadcasts id="'.$broadcast_id.'"]');
		}
		
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new vidorev_Youtube_Broadcasts_Widget() );