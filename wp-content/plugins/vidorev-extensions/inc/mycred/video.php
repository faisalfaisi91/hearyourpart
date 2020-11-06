<?php
add_filter( 'mycred_setup_hooks', 'beeteam368_mycred_video_hook' );
if(!function_exists('beeteam368_mycred_video_hook')){
	function beeteam368_mycred_video_hook( $installed ){
		$installed['beeteam368_viewing_video'] = array(
			'title'       => esc_html__( '[VidoRev] %plural% for Viewing Videos', 'vidorev-extensions' ),
			'description' => esc_html__( 'This hook award points from users when they visit any video post.', 'vidorev-extensions' ),
			'callback'    => array( 'beeteam368_mycred_video_class' )
		);
		return $installed;
	}
}

if(class_exists('myCRED_Hook') && !class_exists('beeteam368_mycred_video_class')){
	class beeteam368_mycred_video_class extends myCRED_Hook {
		function __construct( $hook_prefs, $type = 'mycred_default' ) {
			parent::__construct( array(
				'id'       => 'beeteam368_viewing_video',
				'defaults' => array(
					'creds'   => 1,
					'log'     => '%plural% for Viewing Video'
				)
			), $hook_prefs, $type );
		}
		
		public function run() {
			add_action( 'beeteam368_video_fne',  array( $this, 'beeteam368_video_viewing_update' ), 10, 2 );
		}
		
		public function beeteam368_video_viewing_update( $user_id, $post_id ) {
			if ( $this->core->exclude_user( $user_id ) ) return;
			/*if ( $this->has_entry( 'beeteam368_video_update_'.time(), '', $user_id ) ) return;*/
			
			$this->core->add_creds(
				'beeteam368_video_viewing_update',
				$user_id,
				$this->prefs['creds'],
				$this->prefs['log'],
				'',
				'',
				$this->mycred_type
			);
		}
		
		public function preferences() {
			
			$prefs = $this->prefs; ?>
			
			<label class="subheader"><?php echo esc_html($this->core->plural()); ?></label>
			<ol>
				<li>
					<div class="h2"><input type="text" name="<?php echo esc_attr($this->field_name( 'creds' )); ?>" id="<?php echo $this->field_id( 'creds' ); ?>" value="<?php echo esc_attr( $prefs['creds'] ); ?>" size="8" /></div>
				</li>
			</ol>
			
			<label class="subheader"><?php esc_html_e( 'Log template', 'vidorev-extensions' ); ?></label>
			<ol>
				<li>
					<div class="h2"><input type="text" name="<?php echo esc_attr($this->field_name( 'log' )); ?>" id="<?php echo esc_attr($this->field_id( 'log' )); ?>" value="<?php echo esc_attr( $prefs['log'] ); ?>" class="long" /></div>
				</li>
			</ol>
		<?php
		}

		public function sanitise_preferences( $data ) {
			
			$new_data = $data;

			$new_data['creds'] = ( !empty( $data['creds'] ) ) ? $data['creds'] : $this->defaults['creds'];
			$new_data['log'] = ( !empty( $data['log'] ) ) ? sanitize_text_field( $data['log'] ) : $this->defaults['log'];
	
			return $new_data;
		}
	}
}

add_filter( 'mycred_all_references', 'beeteam368_pro_add_video_references' );
if(!function_exists('beeteam368_pro_add_video_references')){
	function beeteam368_pro_add_video_references( $references ) {
		$references['beeteam368_video_viewing_update'] = esc_html__( '[VidoRev] Viewing Video', 'vidorev-extensions' );
		return $references;
	
	}
}