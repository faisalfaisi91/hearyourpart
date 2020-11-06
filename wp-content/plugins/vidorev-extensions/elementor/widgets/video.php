<?php
namespace Elementor;
if(!class_exists('vidorev_video_element')){
	class vidorev_video_element extends Widget_Base {
		public function get_name() {
			return 'vidorev_video_element_addon';
		}
		
		public function get_title() {
			return esc_html__( 'Video', 'vidorev-extensions');
		}
	
		public function get_icon() {
			return 'fa fa-play-circle';
		}
		
		public function get_categories() {
			return [ 'vidorev-addon-elements' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'vidorev_video_element_addon_global_settings',
				[
					'label' 		=> esc_html__( 'Video', 'vidorev-extensions')
				]
			);
			
			$this->add_control(
				'pvids',
				[
					'label'			=> esc_html__( 'Post Video ID', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Enter Post Video ID, eg: 1136, 2251, ...', 'vidorev-extensions'),		
				]
			);	
			
			$this->add_control(
				'pvstyle',
				[
					'label'			=> esc_html__( 'Toolbar Style', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'description' 	=> esc_html__('Select style for toolbar.', 'vidorev-extensions'),
					'default'		=> 'vp-small-item',
					'options'		=> [
						'vp-small-item' => esc_html__('SMALL', 'vidorev-extensions'),																		
						'full-text' 	=> esc_html__('FULL', 'vidorev-extensions'),									
					]
				]
			);
		}
		
		protected function render() {
			$params = $this->get_settings();
			
			$pvids 		= (isset($params['pvids'])&&trim($params['pvids'])!=''&&is_numeric(trim($params['pvids'])))?trim($params['pvids']):0;
			$pvstyle	= (isset($params['pvstyle'])&&trim($params['pvstyle'])!='')?trim($params['pvstyle']):'vp-small-item';
			
			if($pvids==0){
				echo '';
				return;
			}
			
			echo do_shortcode('[single_video_player id="'.$pvids.'" style="'.$pvstyle.' sc-video-elm-widget"]');
		}
		
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new vidorev_video_element() );