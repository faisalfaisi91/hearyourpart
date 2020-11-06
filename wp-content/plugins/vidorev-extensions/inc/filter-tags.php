<?php
if ( ! function_exists( 'vidorev_register_filter_tags' ) ) :
	function vidorev_register_filter_tags() {
		$filter_tags_permalink 	= esc_html_x('filter_tags', 'slug', 'vidorev-extensions');
		register_post_type('filter_tags',
			apply_filters('vidorev_register_post_type_filter_tags',
				array(
					'labels'              => array(
							'name'                  => esc_html__('Advanced Search', 'vidorev-extensions'),
							'singular_name'         => esc_html__('Advanced Search', 'vidorev-extensions'),
							'menu_name'             => esc_html_x('Advanced Search', 'Admin Menu Name', 'vidorev-extensions'),
							'add_new'               => esc_html__('Add Advanced Search', 'vidorev-extensions'),
							'add_new_item'          => esc_html__('Add New Advanced Search', 'vidorev-extensions'),
							'edit'                  => esc_html__('Edit', 'vidorev-extensions'),
							'edit_item'             => esc_html__('Edit Advanced Search', 'vidorev-extensions'),
							'new_item'              => esc_html__('New Advanced Search', 'vidorev-extensions'),
							'view'                  => esc_html__('View Advanced Search', 'vidorev-extensions'),
							'view_item'             => esc_html__('View Advanced Search', 'vidorev-extensions'),
							'search_items'          => esc_html__('Search', 'vidorev-extensions'),
							'not_found'             => esc_html__('No AS found', 'vidorev-extensions'),
							'not_found_in_trash'    => esc_html__('No AS found in trash', 'vidorev-extensions'),
							'parent'                => esc_html__('Parent Advanced Search', 'vidorev-extensions'),
							'featured_image'        => esc_html__('Advanced Search Image', 'vidorev-extensions'),
							'set_featured_image'    => esc_html__('Set Advanced Search image', 'vidorev-extensions'),
							'remove_featured_image' => esc_html__('Remove Advanced Search image', 'vidorev-extensions'),
							'use_featured_image'    => esc_html__('Use as Advanced Search image', 'vidorev-extensions'),
							'insert_into_item'      => esc_html__('Insert into Advanced Search', 'vidorev-extensions'),
							'uploaded_to_this_item' => esc_html__('Uploaded to this Advanced Search', 'vidorev-extensions'),
							'filter_items_list'     => esc_html__('Advanced Search', 'vidorev-extensions'),
							'items_list_navigation' => esc_html__('Advanced Search navigation', 'vidorev-extensions'),
							'items_list'            => esc_html__('Advanced Search list', 'vidorev-extensions'),
						),
					'description'         => esc_html__('This is where you can add new Advanced Search to your site.', 'vidorev-extensions'),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => array('beeteam368_manager','beeteam368_managers'),
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => $filter_tags_permalink?array('slug' => untrailingslashit($filter_tags_permalink), 'with_front' => false, 'feeds' => true):false,
					'query_var'           => true,
					'supports'            => array('title'),
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'show_in_menu' 		  => 'edit.php',
					'menu_icon'			  => 'dashicons-video-alt3',
					'menu_position'		  => 6,
				)
			)
		);
	}
endif;	
add_action('init', 'vidorev_register_filter_tags', 10);

if ( ! function_exists( 'vidorev_filter_tags_settings' ) ){
	function vidorev_filter_tags_settings(){
		$hidden_all_meta_box = trim(vidorev_get_option('hidden_all_meta_box', 'javascript_libraries_settings', 'no'));
		if($hidden_all_meta_box=='yes' && !beeteam368_get_user_role()){
			return;
		}
		
		$cmb = new_cmb2_box( array(
			'id'            => 'filter_tags_settings',
			'title'         => esc_html__( 'Filter Group', 'vidorev-extensions'),
			'object_types'  => array( 'filter_tags' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'show_in_rest' 	=> WP_REST_Server::ALLMETHODS,
		));
		
		
		$group = $cmb->add_field(array(
			'id'          => 'filter_tags_settings_group',
			'type'        => 'group',			
			'options'     => array(
				'group_title'   => esc_html__( 'Filter {#}', 'vidorev-extensions'),
				'add_button'    => esc_html__( 'Add More Filter', 'vidorev-extensions'),
				'remove_button' => esc_html__( 'Remove Filter', 'vidorev-extensions'),
				'sortable'      => false,
				'closed'		=> false,
			),
			'repeatable'  => true,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'group_name',
			'name' 			=> esc_html__( 'Group Name', 'vidorev-extensions'),
			'type' 			=> 'text',
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'id'   			=> 'group_all',
			'name' 			=> esc_html__( 'All Text', 'vidorev-extensions'),
			'type' 			=> 'text',
			'default'		=> esc_html__( 'All', 'vidorev-extensions'),
			'repeatable' 	=> false,
		));
		
		$cmb->add_group_field($group, array(
			'name' 			=> esc_html__( 'Tags', 'vidorev-extensions'),
			'desc' 			=> esc_html__( 'Add tags to Filter Group.', 'vidorev-extensions'),
			'id'			=> 'tags',
			'type' 			=> 'text',
			'column'  		=> false,
			'render_row_cb' => 'beeteam368_custom_field_tags_search',
			'save_field' 	=> true,
		));
	}
}
add_action( 'cmb2_init', 'vidorev_filter_tags_settings' );

if(!function_exists('vidorev_adminAjaxGetAllTags')){
	function vidorev_adminAjaxGetAllTags(){
		$json_params 			= array();
		$json_params['results'] = array();
		
		$keyword = (isset($_POST['keyword'])&&trim($_POST['keyword'])!=''&&strlen($_POST['keyword'])>=2)?trim($_POST['keyword']):'';
		
		$theme_data = wp_get_theme();
		if($keyword=='' || !wp_verify_nonce(trim($_POST['security']), 'BeeTeam368-vidorev'.$theme_data->get( 'Version' ).$theme_data->get( 'Name' ).var_export(is_user_logged_in(), true) )){
			wp_send_json($json_params);
			return;
			die();
		}
		
		$args = array('search'=>$keyword, 'hide_empty'=>false, 'orderby'=>'name', 'order'=>'ASC');		
		$tags_array = get_tags( $args );
		
		if($tags_array){
			foreach ( $tags_array as $tag_item ) {
				array_push($json_params['results'], array('id'=>$tag_item->term_id, 'text'=>esc_html($tag_item->name)));
			}
		}
		
		wp_send_json($json_params);
		return;
		die();
	}
}
add_action('wp_ajax_adminAjaxGetAllTags', 'vidorev_adminAjaxGetAllTags');
add_action('wp_ajax_nopriv_adminAjaxGetAllTags', 'vidorev_adminAjaxGetAllTags');

if ( ! function_exists( 'beeteam368_custom_field_tags_search' ) ) :
	function beeteam368_custom_field_tags_search($field_args, $field){		
		$id          = $field->args( 'id' );
		$label       = $field->args( 'name' );
		$name        = $field->args( '_name' );
		$value       = $field->escaped_value();
		$description = $field->args( 'description' );
		$post_id	 = is_numeric($field->object_id)?$field->object_id:'';
	?>
		<div class="custom-column-display custom-filter-tags-display-control">
			<p><label for="<?php echo esc_attr($id);?>"><?php echo esc_html($label);?></label></p>
			<p class="bee_select_2">
				<select id="<?php echo esc_attr($id);?>" data-placeholder="<?php echo esc_attr__('Select a Tag', 'vidorev-extensions');?>" class="vidorev-admin-ajax admin-ajax-find-tags-control" name="<?php echo esc_attr($name);?>[]" multiple>
					<?php
					if($post_id!='' && is_array($value) && count($value)>0){
						foreach ( $value as $item_id ) {
							$tag_item = get_tags(array('hide_empty'=>false, 'include' => array( $item_id )));
							if($tag_item){
								foreach ( $tag_item as $tag_details ) :
					?>
									<option value="<?php echo esc_attr($tag_details->term_id);?>" selected="selected"><?php echo esc_html($tag_details->name);?></option>
					<?php
								endforeach;
							}
						}
					}
					?>
				</select>
			</p>
			<p class="description"><?php echo wp_kses_post($description); ?></p>
		</div>
	<?php	
	}
endif;
