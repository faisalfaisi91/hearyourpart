<?php
namespace Elementor;
if(!class_exists('vidorev_Youtube_Live_Video_Widget')){
	class vidorev_Youtube_Live_Video_Widget extends Widget_Base {
		public function get_name() {
			return 'vidorev_youtube_live_video_addon';
		}
		
		public function get_title() {
			return esc_html__( 'Youtube Live Video', 'vidorev-extensions');
		}
	
		public function get_icon() {
			return 'fa fa-youtube-play';
		}
		
		public function get_categories() {
			return [ 'vidorev-addon-elements' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'vidorev_youtube_live_video_addon_global_settings',
				[
					'label' 		=> esc_html__( 'Youtube Live Video', 'vidorev-extensions')
				]
			);
			
			$list_shortcode = array();
			
			$args_query = array(
				'post_type'				=> 'youtube_live_video',
				'posts_per_page' 		=> -1,
				'post_status' 			=> 'publish',
			);
			
			$live_video_query = get_posts($args_query);
			
			if($live_video_query):
				foreach ( $live_video_query as $item) :
					$list_shortcode[$item->ID] = esc_html__('ID', 'vidorev-extensions').': '.esc_attr($item->ID).' - '.esc_html__('Name', 'vidorev-extensions').': '.esc_attr($item->post_title);
				endforeach;
			endif;
			
			$this->add_control(
				'live_id',
				[
					'label'			=> esc_html__( 'Live ID', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '0',
					'options'		=> $list_shortcode,
				]
			);
		}
		
		protected function render() {
			$params = $this->get_settings();
			
			$live_id = (isset($params['live_id'])&&trim($params['live_id'])!=''&&is_numeric(trim($params['live_id'])))?trim($params['live_id']):0;
			
			if($live_id==0){
				echo '';
				return;
			}
			
			echo do_shortcode('[youtube_live_video id="'.$live_id.'"]');
		}
		
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new vidorev_Youtube_Live_Video_Widget() );