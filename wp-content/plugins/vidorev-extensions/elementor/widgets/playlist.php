<?php
namespace Elementor;
if(!class_exists('vidorev_playlist_element')){
	class vidorev_playlist_element extends Widget_Base {
		public function get_name() {
			return 'vidorev_playlist_element_addon';
		}
		
		public function get_title() {
			return esc_html__( 'Playlist', 'vidorev-extensions');
		}
	
		public function get_icon() {
			return 'fa fa-list';
		}
		
		public function get_categories() {
			return [ 'vidorev-addon-elements' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'vidorev_playlist_element_addon_global_settings',
				[
					'label' 		=> esc_html__( 'Playlist', 'vidorev-extensions')
				]
			);
			
			$this->add_control(
				'ppids',
				[
					'label'			=> esc_html__( 'Playlist ID', 'vidorev-extensions'),
					'type'			=> Controls_Manager::TEXT,
					'description' 	=> esc_html__('Enter Playlist ID, eg: 1136, 2251, ...', 'vidorev-extensions'),		
				]
			);
			
			$this->add_control(
				'ppstyle',
				[
					'label'			=> esc_html__( 'Toolbar Style', 'vidorev-extensions'),
					'type'			=> Controls_Manager::SELECT,
					'description' 	=> esc_html__('Select style for toolbar.', 'vidorev-extensions'),
					'default'		=> 'pe-small-item',
					'options'		=> [
						'pe-small-item' => esc_html__('SMALL', 'vidorev-extensions'),																		
						'full-text' 	=> esc_html__('FULL', 'vidorev-extensions'),									
					]
				]
			);	
		}
		
		protected function render() {
			$params = $this->get_settings();
			
			$ppids 		= (isset($params['ppids'])&&trim($params['ppids'])!=''&&is_numeric(trim($params['ppids'])))?trim($params['ppids']):0;
			$ppstyle	= (isset($params['ppstyle'])&&trim($params['ppstyle'])!='')?trim($params['ppstyle']):'pe-small-item';
			
			if($ppids==0){
				echo '';
				return;
			}
			
			echo do_shortcode('[single_video_playlist id="'.$ppids.'" style="'.$ppstyle.'"]');
		}
		
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new vidorev_playlist_element() );