<?php
if(!function_exists('vidorev_megamenu_fields_list')):
	function vidorev_megamenu_fields_list() {
		return array(
			'vidorev-megamenu-active' => esc_html__('Activate MegaMenu', 'vidorev'),
			'vidorev-megamenu-extra_class' => esc_html__('Extra Class Name', 'vidorev'),
		);
	}
endif;

if(!function_exists('vidorev_megamenu_fields')):
	function vidorev_megamenu_fields( $id, $item, $depth, $args ) {
		
		$fields = vidorev_megamenu_fields_list();
		
		foreach ( $fields as $_key => $label ) :
			$key   = sprintf( 'menu-item-%s', $_key );
			$id    = sprintf( 'edit-%s-%s', $key, $item->ID );
			$name  = sprintf( '%s[%s]', $key, $item->ID );
			$value = get_post_meta( $item->ID, $key, true );
			$class = sprintf( 'field-%s', $_key );
			if($_key=='vidorev-megamenu-extra_class'){
			?>
				<p class="description description-wide <?php echo esc_attr( $class ) ?>">
					<label for="<?php echo esc_attr( $id ); ?>">
						<?php echo esc_attr( $label ); ?>
						<br>
						<input type="text" id="<?php echo esc_attr( $id ); ?>" class="widefat code edit-menu-item-url" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr($value)?>">
					</label>
				</p>
			<?php	
			}else{
				$checked_itb = ( $value == 1 ) ? 'checked' : '';
			?>
				<p class="description description-wide <?php echo esc_attr( $class ) ?>">
					<label for="<?php echo esc_attr( $id ); ?>"><input type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo esc_attr($checked_itb); ?> /><?php echo esc_attr( $label ); ?></label>
				</p>
			<?php
			}
		endforeach;
		
	}
endif;

if(!function_exists('vidorev_megamenu_columns')):
	function vidorev_megamenu_columns( $columns ) {
		$fields = vidorev_megamenu_fields_list();
		$columns = array_merge( $columns, $fields );
		return $columns;
	}
endif;

if(!function_exists('vidorev_megamenu_save')):
	function vidorev_megamenu_save( $menu_id, $menu_item_db_id, $menu_item_args ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );
		$fields = vidorev_megamenu_fields_list();
		foreach ( $fields as $_key => $label ) {
			
			$key = sprintf( 'menu-item-%s', $_key );
	
			if ( ! empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
	
				$value = sanitize_text_field($_POST[ $key ][ $menu_item_db_id ]);
			} else {
				$value = null;
			}
	
			if ( ! is_null( $value ) ) {
				update_post_meta( $menu_item_db_id, $key, $value );
				//echo "key:$key<br />";
			} else {
				delete_post_meta( $menu_item_db_id, $key );
			}
		}
	}
endif;

if(!function_exists('vidorev_megamenu_filter_walker')):
	function vidorev_megamenu_filter_walker( $walker ) {
		$walker = 'vidorev_MegaMenu_Walker_Edit';
		if ( ! class_exists( $walker ) ) {
			require_once get_template_directory() . '/inc/mega-menu/menu-edit.php';
		}
		return $walker;
	}
endif;

if(!function_exists('vidorev_register_filter_action_megamenu')):
	function vidorev_register_filter_action_megamenu(){
		if(vidorev_get_redux_option('mega_menu', 'off', 'switch') == 'on'):
			add_action( 'wp_nav_menu_item_custom_fields', 'vidorev_megamenu_fields', 10, 4 );
			add_filter( 'manage_nav-menus_columns', 'vidorev_megamenu_columns', 99 );
			add_action( 'wp_update_nav_menu_item', 'vidorev_megamenu_save', 10, 3 );
			add_filter( 'wp_edit_nav_menu_walker', 'vidorev_megamenu_filter_walker', 99 );
		endif;
	}
endif;
add_action('admin_init', 'vidorev_register_filter_action_megamenu');