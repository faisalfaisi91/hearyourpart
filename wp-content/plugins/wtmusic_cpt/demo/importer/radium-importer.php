<?php

/**
 * Class Radium_Theme_Importer
 *
 * This class provides the capability to import demo content as well as import widgets and WordPress menus
 *
 * @since 0.0.2
 *
 * @category RadiumFramework
 * @package  NewsCore WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 *
 */

 // Exit if accessed directly
 if ( !defined( 'ABSPATH' ) ) exit;

 // Don't duplicate me!
 if ( !class_exists( 'Radium_Theme_Importer' ) ) {

		if ( !function_exists( 'mysql_import' ) ) {

			function mysql_import($filename) {
				global $wpdb;

				// Temporary variable, used to store current query
				$templine = '';
				// Read in entire file
				$lines = file($filename);
				// Loop through each line
				foreach ($lines as $line)
				{
					// Skip it if it's a comment
					if (substr($line, 0, 2) == '--' || $line == '')
					    continue;

					// Add this line to the current segment
					$templine .= $line;
					// If it has a semicolon at the end, it's the end of the query
					if (substr(trim($line), -1, 1) == ';')
					{
					    // Perform the query
					    $wpdb->query($templine);
					    // Reset temp variable to empty
					    $templine = '';
					}
				}

			}
		}

		function change_img_Path($imgPath){
			$imgPathstrpos = strrpos($imgPath, 'uploads/');
			if(isset($imgPathstrpos)){
				$imgPath = substr($imgPath, strrpos($imgPath, 'uploads/'));
				$imgPath = get_site_url()."/wp-content/".$imgPath;
			}
			return $imgPath;
		}

	class Radium_Theme_Importer {

		/**
		 * Set the theme framework in use
		 *
		 * @since 0.0.3
		 *
		 * @var object
		 */
		public $theme_options_framework = 'optiontree'; //supports radium framework and option tree				// radium

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $theme_options_file;

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $widgets;

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $content_demo;

		/**
		 * Flag imported to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $flag_as_imported = array( 'content' => false, 'menus' => false, 'options' => false, 'widgets' =>false, 'slider' =>false, 'pages' =>false );

		/**
		 * imported sections to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $imported_demos = array();

		/**
		 * Flag imported to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var bool
		 */
		public $add_admin_menu = true;

	    /**
	     * Holds a copy of the object for easy reference.
	     *
	     * @since 0.0.2
	     *
	     * @var object
	     */
	    private static $instance;

	    /**
	     * Constructor. Hooks all interactions to initialize the class.
	     *
	     * @since 0.0.2
	     */
	    public function __construct() {

	        self::$instance = $this;

	        $this->demo_files_path 		= apply_filters('radium_theme_importer_demo_files_path', $this->demo_files_path);

	        $this->theme_options_file 	= apply_filters('radium_theme_importer_theme_options_file', $this->demo_files_path . $this->theme_options_file_name);

	        $this->slider_file 			= apply_filters('radium_theme_importer_slider_file', $this->demo_files_path . $this->slider_file_name);

	        $this->widgets 				= apply_filters('radium_theme_importer_widgets_file', $this->demo_files_path . $this->widgets_file_name);

	        $this->content_demo 		= apply_filters('radium_theme_importer_content_demo_file', $this->demo_files_path . $this->content_demo_file_name);
	       
	        $this->pages_demo 			= apply_filters('radium_theme_importer_pages_demo_file', $this->demo_files_path . $this->pages_demo_file_name);

			$this->imported_demos 		= get_option( 'radium_imported_demo' );

            if( $this->theme_options_framework == 'optiontree' ) {
                
				$this->theme_option_name = 'option_tree'; // ot_options_id(); //  // 'my_theme_options_name';		// ;
				
            }

	        if( $this->add_admin_menu ) add_action( 'admin_menu', array($this, 'add_admin') );

			add_filter( 'add_post_metadata', array( $this, 'check_previous_meta' ), 10, 5 );

      		add_action( 'radium_import_end', array( $this, 'after_wp_importer' ) );

			add_action( 'wp_ajax_process_pages', array( $this, 'process_pages' ) ); 
			add_action( 'wp_ajax_nopriv_process_pages', array( $this, 'process_pages' ) );
			add_action( 'wp_ajax_process_options', array( $this, 'process_options' ) ); 
			add_action( 'wp_ajax_nopriv_process_options', array( $this, 'process_options' ) );
			add_action( 'wp_ajax_process_imports', array( $this, 'process_imports' ) ); 
			add_action( 'wp_ajax_nopriv_process_imports', array( $this, 'process_imports' ) );
			add_action( 'wp_ajax_process_content', array( $this, 'process_content' ) ); 
			add_action( 'wp_ajax_nopriv_process_content', array( $this, 'process_content' ) );
			add_action( 'wp_ajax_process_widgets', array( $this, 'process_widgets' ) ); 
			add_action( 'wp_ajax_nopriv_process_widgets', array( $this, 'process_widgets' ) );
			add_action( 'wp_ajax_process_slider', array( $this, 'process_slider' ) ); 
			add_action( 'wp_ajax_nopriv_process_slider', array( $this, 'process_slider' ) );

	    }

		/**
		 * Add Panel Page
		 *
		 * @since 0.0.2
		 
	    public function add_admin() {

	        add_submenu_page('themes.php', "Import Demo", "Import Demo", 'switch_themes', 'radium_demo_installer', array($this, 'demo_installer'));

	    }*/

	    /**
         * Avoids adding duplicate meta causing arrays in arrays from WP_importer
         *
         * @param null    $continue
         * @param unknown $post_id
         * @param unknown $meta_key
         * @param unknown $meta_value
         * @param unknown $unique
         *
         * @since 0.0.2
         *
         * @return
         */
        public function check_previous_meta( $continue, $post_id, $meta_key, $meta_value, $unique ) {

			$old_value = get_metadata( 'post', $post_id, $meta_key );

			if ( count( $old_value ) == 1 ) {

				if ( $old_value[0] === $meta_value ) {

					return false;

				} elseif ( $old_value[0] !== $meta_value ) {

					update_post_meta( $post_id, $meta_key, $meta_value );
					return false;

				}

			}

    	}

    	/**
    	 * Add Panel Page
    	 *
    	 * @since 0.0.2
    	 */
    	public function after_wp_importer() {

			do_action( 'radium_importer_after_content_import');

			update_option( 'radium_imported_demo', $this->flag_as_imported );

		}

    	public function intro_html() {

			?>

            <h2>Please Read This Part</h2><hr />

            <div style="background-color: #F5FAFD; margin:10px 0;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;">
	            <table class="notes-table">
	            	<tbody>
	                    <tr>   	
	                        <td>
	                            <ol>
	                                <li><?php _e('We recommend running this importer with a fresh WP installation.', 'T20'); ?></li>
	                                <li><?php _e('Before you begin, make sure all the required plugins are activated.', 'T20'); ?></li>
	                                <li><?php _e('Masterslider and Essential grid data should be import manually.', 'T20'); ?></li>
	                                <li>
	                            		<p style="margin-top:0;"><?php _e('If you are facing a white screen and import is not succeed, please check your server’s configuration and if necessary increase the limits in <strong>php.ini</strong>', 'T20'); ?></p>
										<ul style="float:left;list-style-type:disc;padding-left:32px;">
											<li>max_execution_time = 1000</li>
											<li>memory_limit = 256M</li>
											<li>post_max_size = 32M</li>
										</ul>
										<ul style="float:left;list-style-type:disc;padding-left:32px;">
											<li>max_input_time = 1000</li>
											<li>max_input_vars = 10000</li>
											<li>upload_max_filesize = 32M</li>
										</ul>
										<ul style="float:left;list-style-type:disc;padding-left:32px;">
											<li>max_input_nesting_level = 10000</li>
											<li>post_max_size = 32M</li>
										</ul>
									</li>
	                            </ol>
	                        </td>                      
	                    </tr>  
	                                        
	            	</tbody>
	            </table>
			 </div>

			 <?php

    	}

	    /**
	     * demo_installer Output
	     *
	     * @since 0.0.2
	     *
	     * @return null
	     */
	    public function demo_installer() {

			// $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
			if (isset($_POST['demo-data'])) {
				$action = 'demo-data';
			} else if (isset($_POST['demo-options'])) {
				$action = 'demo-options';
			} else if (isset($_POST['demo-widgets'])) {
				$action = 'demo-widgets';
			} else if (isset($_POST['demo-content'])) {
				$action = 'demo-content';
			} else if (isset($_POST['demo-slider'])) {
				$action = 'demo-slider';
			} else if (isset($_POST['demo-pages'])) {
				$action = 'demo-pages';
			} else {
				$action = '';
			}

			if( !empty($this->imported_demos ) ) {

				$button_text = __('Import all data again', 'radium');

			} else {

				$button_text = __('Import all data', 'radium');

			}

	        ?>
			<style>
                 .demo_screenshots img { border:1px solid #ccc; padding:5px; background-color:#fff; }
            </style> 
            <div id="icon-tools" class="icon32"><br></div>
	       
			<?php 
				
				$post_action = false;
				
				if (isset($_POST['action'])) {
					
					$post_action = true;
					
				}

				if (empty($_POST['import_demo'])) {
					$_POST['import_demo'] = '';
				}
			
			?>
             
	       	<div class="radium-importer-wrap" data-demo-id="1"  data-nonce="<?php echo wp_create_nonce('radium-demo-code'); ?>">

		    <form id="importer_t" method="post">
                	<br />
                    <h2>Choose Your Demo</h2><hr />
                    
                    <table cellpadding="5" cellspacing="5" class="demo_screenshots">
                    	<tr>
                        	<td>
                            <label>
                                <img src="<?php echo plugins_url( 'demo-files/demo-1/screenshot.png', dirname(__FILE__) ); ?>" alt="demo-1" width="200" height="136" /><br />
                                <input name="import_demo" value="1" type="radio" 
                                
                                <?php if (!$post_action) { echo ' checked="checked" '; } else { if ( $_POST['import_demo'] == 1) echo ' checked="checked" '; } ?>
                                
                                 /> Demo 1
                            </label>
                            </td>
                        	<td>
                            <label>
                                <img src="<?php echo plugins_url( 'demo-files/demo-2/screenshot.png', dirname(__FILE__) ); ?>" alt="demo-2" width="200" height="136" /><br />
                                <input name="import_demo" value="2" disabled="disabled" type="radio"
                                
                                <?php if ( $_POST['import_demo'] == 2) echo ' checked="checked" '; ?>
                                
                                 /> Demo 2
                            </label>
                            </td>
                        	<td>
                            <label>
                                <img src="<?php echo plugins_url( 'demo-files/demo-3/screenshot.png', dirname(__FILE__) ); ?>" alt="demo-3" width="200" height="136" /><br />
                                <input name="import_demo" value="3" disabled="disabled" type="radio"
                                
                                <?php if ( $_POST['import_demo'] == 3) echo ' checked="checked" '; ?>
                                
                                 /> Demo 3
                            </label>
                            </td>
                        	<td
                            <label>
                            <label>
                                <img src="<?php echo plugins_url( 'demo-files/demo-4/screenshot.png', dirname(__FILE__) ); ?>" alt="demo-4" width="200" height="136" /><br />
                                <input name="import_demo" value="4" disabled="disabled" type="radio"
                                
                                <?php if ( $_POST['import_demo'] == 4) echo ' checked="checked" '; ?>
                                
                                 /> Demo 4
                            </label>
                            </td>
                        	<td>
                            <label>
                                <img src="<?php echo plugins_url( 'demo-files/demo-5/screenshot.png', dirname(__FILE__) ); ?>" alt="demo-5" width="200" height="136" /><br />
                                <input name="import_demo" value="5" disabled="disabled" type="radio"
                                
                                <?php if ( $_POST['import_demo'] == 5) echo ' checked="checked" '; ?>
                                
                                 /> Demo 5
                            </label>
                            </td>
                        </tr>
                    </table>   

					<!-- <?php if( !empty($this->imported_demos) ) { ?>
                		<br />
						<div style="background-color: #FAFFFB; margin:10px 0;padding: 5px 10px;color: #8AB38A;border: 2px solid #a1d3a2; clear:both; width:90%; line-height:18px;">
							<p><?php _e('Demo already imported', 'radium'); ?></p>
						</div>
					<?php } ?>
                    
                	<br />

                    <h2>Choose Method</h2><hr />
		          	<input type="hidden" name="demononce" value="<?php echo wp_create_nonce('radium-demo-code'); ?>" />
		          	<input name="demo-data" data-action="process_imports" class="panel-save button-primary radium-import-start" type="submit" value="<?php echo $button_text ; ?>" />
					<div class="radium-importer-message clear">
				        <?php 
						
								if( 'demo-data' === $action && check_admin_referer('radium-demo-code' , 'demononce')){
								
								$this->process_imports(intval($_POST['import_demo']));
								
			 	        } ?>
					</div> -->

		          	<br />
					<h2>Click to Start Import</h2><hr />
		          	<br />
		          				<strong>1. </strong>
					          	<input type="hidden" name="demononces" value="<?php echo wp_create_nonce('radium-options'); ?>" />
					          	<input name="demo-options" data-action="process_options" class="panel-save button-primary radium-import-start" type="submit" value="Theme Options" />
								<div class="radium-importer-message clear">
								<?php 
									if( 'demo-options' === $action && check_admin_referer('radium-options' , 'demononces')) {

										$this->process_options(intval($_POST['import_demo']));
											
									}
								?>
								</div>
		          	<br />

                    <table cellpadding="5" cellspacing="5" class="demo_screenshots">
                    	<tr>
                        	<td>
		          				<strong>2. </strong>
					          	<input type="hidden" name="demononcesaa" value="<?php echo wp_create_nonce('radium-content'); ?>" />
					          	<input name="demo-content" data-action="process_content" class="panel-save button-primary radium-import-start" type="submit" value="Content + Menus + Attachments" />
								<div class="radium-importer-message clear">
								<?php 
									if( 'demo-content' === $action && check_admin_referer('radium-content' , 'demononcesaa')) {

										$this->process_content(intval($_POST['import_demo']));
											
									}
								?>
								</div>
                            </td>
                        	<td>
					          	OR
                            </td>
                        	<td>
					          	<input type="hidden" name="demononcepages" value="<?php echo wp_create_nonce('radium-pages'); ?>" />
					          	<input name="demo-pages" data-action="process_pages" class="panel-save button-primary radium-import-start" type="submit" value="Only Pages" />
								<div class="radium-importer-message clear">
								<?php 
									if( 'demo-pages' === $action && check_admin_referer('radium-pages' , 'demononcepages')) {

										$this->process_pages(intval($_POST['import_demo']));
											
									}
								?>
								</div>
                            </td>
                        </tr>
                    </table>
		          	<br />
		          				<strong>3. </strong>
					          	<input type="hidden" name="demononcess" value="<?php echo wp_create_nonce('radium-widgets'); ?>" />
					          	<input name="demo-widgets" data-action="process_widgets" class="panel-save button-primary radium-import-start" type="submit" value="Widgets" />
								<div class="radium-importer-message clear">
								<?php 
									if( 'demo-widgets' === $action && check_admin_referer('radium-widgets' , 'demononcess')) {
										
										$this->process_widgets(intval($_POST['import_demo']));
											
									}
								?>
								</div>
		          	<br />
		          				<strong>4. </strong>
					          	<input type="hidden" name="demononcesss" value="<?php echo wp_create_nonce('radium-slider'); ?>" />
					          	<input name="demo-slider" data-action="process_slider" class="panel-save button-primary radium-import-start" type="submit" value="Revolution Slider" />
								<div class="radium-importer-message clear">
								<?php 
									if( 'demo-slider' === $action && check_admin_referer('radium-slider' , 'demononcesss')) {
	
										$this->process_slider(intval($_POST['import_demo']));
											
									}
								?>
								</div>
		          	<br />
		          	<br />

		          	<?php $this->intro_html(); ?>
	 	        </form>

	 	        <script>
	 	        jQuery(document).ready(function($) {
					$("#importer_t input[type='submit']").click(function(){

						var getName = $(this).attr("data-action");
						var getNameS = getName.replace("process_", "");
						var getNameS = getNameS.toLowerCase().replace(/\b[a-z]/g, function(letter) {
							return letter.toUpperCase();
						});
						var getChecked = $("input[name='import_demo']:checked").val();

						if (getName == 'process_pages') {
							var confirm_s = window.confirm("If you've clicked on 'Content + Menus + Attachments' before, do not need import pages again, so please click on cancel and do next step.");
						} else if (getName == 'process_content') {
							var confirm_s = window.confirm("Are you sure ?! - You will NOT lose your current content..");
						} else if (getName == 'process_options') {
							var confirm_s = window.confirm("Are you sure ?! - You will lose your current theme options settings.");
						} else {
							var confirm_s = true;
						}
						if(confirm_s == false){
							return false;
						} else {
							$('.importing div').html('');
							if (getName == 'process_content') {
								$('.importing div').html('It may take several minutes to import');
							}
							$('.imported').hide();
							$('.s_message, .importing, .full_bg').fadeIn();
							var datas = {
								action: getName,
								import_demo: getChecked
							};
							$.ajax({
								type: "POST",
								url: '<?php echo home_url("/"); ?>wp-admin/admin-ajax.php',
								dataType: 'html',
								data: (datas),
								success: function(data){
									$('.importing').fadeOut();

									if (data !== '0' || data !== '-1' || data !== null) {
										$('.imported').delay(400).html('<i class="ok_T20"></i>' + $('input[data-action='+getName+']').val() + ' was imported successfully (Demo '+getChecked+')').fadeIn();
									} else {
										$('.imported').delay(400).html('<i class="cancel_T20"></i>' + $('input[data-action='+getName+']').val() + ' was  not imported, Please try again!').fadeIn();
									}

									console.log(getName + ' ' + getChecked + ' ' + data);

									$('input[data-action='+getName+']').val($('input[data-action='+getName+']').val() + ' Imported').attr('disabled', 'disabled');
									$('<i class="ok_T20"></i>').insertAfter('input[data-action='+getName+']');
									$('.s_message, .imported, .full_bg').delay(3000).fadeOut();
								}
							});
						}

						return false;
				    });

				});
	 	        </script>

	 	        <div class="full_bg"></div>
	 	        <div class="s_message importertt">
	 	        	<div class="inner_sm">
	 	        		<div class="importing"><img src="<?php echo plugin_dir_url( __FILE__ ) .'/process2.gif'; ?>"><div></div></div>
	 	        		<div class="imported"></div>

	 	        		<div class="imported_data"></div>
	 	        	</div>
	 	        </div>

 	        </div>

	       
	        
	        <?php

	    }

	    /**
	     * Process all imports
	     *
	     * @since 0.0.3
	     * @return null
	     */
	    public function process_imports( $import_demo ) {
			
			$import_demo = $_POST['import_demo'];

			echo '<div style="background-color: #F5FAFD; margin:0 0 10px;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;"><p>Imported Demo #' . $import_demo . '</p></div>';


				$import_demo_path = 'demo-' . $import_demo . '/';
				
				$this->content_demo = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $this->content_demo);
			

				//if ( $content && !empty( $this->content_demo ) && is_file( $this->content_demo ) ) { } // $content = true;
				
				$this->set_demo_data( $this->content_demo, $import_demo, 'true' ); 
				
				$homepage = get_page_by_title( 'Home' );
				$posts_page = get_page_by_title( 'News' );

				if ($homepage->ID > 0) {
					update_option( 'page_on_front', $homepage->ID );
					update_option( 'show_on_front', 'page' );
				}	
				if ($posts_page->ID > 0) {
					update_option('page_for_posts', $posts_page->ID);
				}		
				
				// if ( $menus ) {}
				$this->set_demo_menus();
			
				// if ( $options && !empty( $this->theme_options_file ) && is_file( $this->theme_options_file ) ) { }		// $options = true;
				$this->set_demo_theme_options( $this->theme_options_file, $import_demo );

				//if ( $widgets && !empty( $this->widgets ) && is_file( $this->widgets ) ) { }	// $widgets = true;
				$this->process_widget_import_file( $this->widgets, $import_demo );

				// import slider
				$this->process_slider_import_file( $this->slider_file, $import_demo );

				do_action( 'radium_import_end');

			die();
			
        }

	    public function process_content( $import_demo ) {
			
			$import_demo = $_POST['import_demo'];

			echo '<div style="background-color: #F5FAFD; margin:0 0 10px;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;"><p>Imported Demo #' . $import_demo . '</p></div>';


			$import_demo_path = 'demo-' . $import_demo . '/'; // path
				
			$this->content_demo = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $this->content_demo);
				
			$this->set_demo_data( $this->content_demo, $import_demo, 'true' );
				
			$homepage = get_page_by_title( 'Home' );
			$posts_page = get_page_by_title( 'News' );

			if ($homepage->ID > 0) {

				update_option( 'page_on_front', $homepage->ID );
				update_option( 'show_on_front', 'page' );
					
			}	
			if ($posts_page->ID > 0) {
				update_option('page_for_posts', $posts_page->ID);
			}		
				
			// if ( $menus ) {}
			$this->set_demo_menus();

			do_action( 'radium_import_end');

			die();

        }

	    public function process_pages( $import_demo ) {

			$import_demo = $_POST['import_demo'];

			echo '<div style="background-color: #F5FAFD; margin:0 0 10px;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;"><p>Imported Demo #' . $import_demo . '</p></div>';

			$import_demo_path = 'demo-' . $import_demo . '/';
			$this->pages_demo = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $this->pages_demo);
			$this->set_demo_data( $this->pages_demo, $import_demo, '' ); 

			do_action( 'radium_import_end');

			die();

        }

	    public function process_options( $import_demo ) {

	    	$import_demo = $_POST['import_demo'];

			echo '<div style="background-color: #F5FAFD; margin:0 0 10px;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;"><p>Imported Options #' . $import_demo . '</p></div>';

			$import_demo_path = 'demo-' . $import_demo . '/';
				
			$this->content_demo = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $this->content_demo);
			
			$this->set_demo_theme_options( $this->theme_options_file, $import_demo );

			do_action( 'radium_import_end');

			die();

        }

	    public function process_widgets( $import_demo ) {

			$import_demo = $_POST['import_demo'];
			
			echo '<div style="background-color: #F5FAFD; margin:0 0 10px;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;"><p>Imported widgets #' . $import_demo . '</p></div>';

			$import_demo_path = 'demo-' . $import_demo . '/';
				
			$this->content_demo = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $this->content_demo);
			
			$this->process_widget_import_file( $this->widgets, $import_demo );

			do_action( 'radium_import_end');

			die();
			
        }

	    public function process_slider( $import_demo ) {
			
			$import_demo = $_POST['import_demo'];
			
			echo '<div style="background-color: #F5FAFD; margin:0 0 10px;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;"><p>Imported slider #' . $import_demo . '</p></div>';
			
			$this->process_slider_import_file( $this->slider_file, $import_demo );

			do_action( 'radium_import_end');

			die();
			
	    }

	    function process_slider_import_file( $file, $import_demo ) {

				if( class_exists('UniteFunctionsRev') ) {
					$import_demo_path = 'demo-' . $import_demo . '/'; // path
					$file = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $file);

					$rev_directory_txt = $file; 
					$rev_files_txt = array();

					if (file_exists($rev_directory_txt)) {
					
						foreach( glob( $rev_directory_txt . 'home-*.txt' ) as $filename ) {
							$filename = basename($filename);
							$rev_files_txt[] = $file . $filename ;
						}
												
						foreach( $rev_files_txt as $rev_file ) {
							
							$get_file = file_get_contents( $rev_file, true );
							$arrSlider = unserialize( $get_file );
		
							$sliderParams = $arrSlider["params"];
		
							if(isset($sliderParams["background_image"])) {
								$sliderParams["background_image"] = change_img_Path($sliderParams["background_image"]);
							}
		
							$json_params = json_encode($sliderParams);
		
							$arrInsert = array();
							$arrInsert["params"] = $json_params;
							$arrInsert["title"] = UniteFunctionsRev::getVal($sliderParams, "title");
							$arrInsert["alias"] = UniteFunctionsRev::getVal($sliderParams, "alias");
							global $wpdb;
							$wpdb->insert(GlobalsRevSlider::$table_sliders, $arrInsert);
							$sliderID = $wpdb->insert_id;
		
							//create all slides
							$arrSlides = $arrSlider["slides"];
							foreach($arrSlides as $slide){
								
								$params = $slide["params"];
								$layers = $slide["layers"];
								
								
								//convert params images:
								if(isset($params["image"])) {
									$params["image"] = change_img_Path($params["image"]);
								}
								
								if(isset($params["slide_thumb"])) {
									$params["slide_thumb"] = change_img_Path($params["slide_thumb"]);
								}
								
								//convert layers images:
								foreach($layers as $key=>$layer){					
									if(isset($layer["image_url"])){
										$layer["image_url"] = change_img_Path($layer["image_url"]);
									}
									
									if(!empty($layer["video_image_url"])){
										$layer["video_image_url"] = change_img_Path($layer["video_image_url"]);
									}
									
									if(isset($layer["video_data"])){
										$layer_video_data = $layer["video_data"];
										
										if(!empty($layer_video_data->urlPoster)){
											$layer_video_data->urlPoster = change_img_Path($layer_video_data->urlPoster);
										}
										if(!empty($layer_video_data->urlMp4)){
											$layer_video_data->urlMp4 = change_img_Path($layer_video_data->urlMp4);
										}
										if(!empty($layer_video_data->urlWebm)){
											$layer_video_data->urlWebm = change_img_Path($layer_video_data->urlWebm);
										}
										if(!empty($layer_video_data->urlOgv)){
											$layer_video_data->urlOgv = change_img_Path($layer_video_data->urlOgv);
										}
									}
									$layers[$key] = $layer;
								}
														
								//create new slide
								$arrCreate = array();
								$arrCreate["slider_id"] = $sliderID;
								$arrCreate["slide_order"] = $slide["slide_order"];				
								$arrCreate["layers"] = json_encode($layers);
								$arrCreate["params"] = json_encode($params);
								
								$wpdb->insert(GlobalsRevSlider::$table_slides,$arrCreate);				
							}
						}
						
						
						/* Revolution Slider Dynamic CSS Import
						--------------------------------------------------------------------------*/

						$rev_directory_sql = $file; 
						$rev_files_sql = array();

						foreach( glob( $rev_directory_sql . 'style-*.txt' ) as $filename ) {
							$filename = basename($filename);
							$rev_files_sql[] = $file . $filename ;
						}

						foreach( $rev_files_sql as $rev_file ) {
							mysql_import($rev_file);
						}


						/* Revolution Slider Images
						--------------------------------------------------------------------------*/
						$upload = wp_upload_dir();
						$upload_dir = $upload['basedir'];
						$revslider = $upload_dir . '/revslider/';
						if (! is_dir($revslider)) { mkdir( $revslider, 0700 ); }

						$upload_dir1 = $upload_dir . '/revslider/rev_home/';
						if (! is_dir($upload_dir1)) { mkdir( $upload_dir1, 0700 ); }
						foreach(glob( $file . 'rev_home/' . '{*.jpg,*.JPG,*.png,*.PNG,*.gif,*.GIF}', GLOB_BRACE ) as $filer) {
							$filename = basename($filer);
							copy($filer, $upload_dir1 . $filename);
						}

						$upload_dir2 = $upload_dir . '/revslider/rev_home2/';
						if (! is_dir($upload_dir2)) { mkdir( $upload_dir2, 0700 ); }
						foreach(glob( $file . 'rev_home2/' . '{*.jpg,*.JPG,*.png,*.PNG,*.gif,*.GIF}', GLOB_BRACE ) as $filer) {
							$filename = basename($filer);
							copy($filer, $upload_dir2 . $filename);
						}

						$upload_dir3 = $upload_dir . '/revslider/rev_home6/';
						if (! is_dir($upload_dir3)) { mkdir( $upload_dir3, 0700 ); }
						foreach(glob( $file . 'rev_home6/' . '{*.jpg,*.JPG,*.png,*.PNG,*.gif,*.GIF}', GLOB_BRACE ) as $filer) {
							$filename = basename($filer);
							copy($filer, $upload_dir3 . $filename);
						}
					}
				}
		}

	    /**
	     * add_widget_to_sidebar Import sidebars
	     * @param  string $sidebar_slug    Sidebar slug to add widget
	     * @param  string $widget_slug     Widget slug
	     * @param  string $count_mod       position in sidebar
	     * @param  array  $widget_settings widget settings
	     *
	     * @since 0.0.2
	     *
	     * @return null
	     */
	    public function add_widget_to_sidebar($sidebar_slug, $widget_slug, $count_mod, $widget_settings = array()){

	        $sidebars_widgets = get_option('sidebars_widgets');

	        if(!isset($sidebars_widgets[$sidebar_slug]))
	           $sidebars_widgets[$sidebar_slug] = array('_multiwidget' => 1);

	        $newWidget = get_option('widget_'.$widget_slug);

	        if(!is_array($newWidget))
	            $newWidget = array();

	        $count = count($newWidget)+1+$count_mod;
	        $sidebars_widgets[$sidebar_slug][] = $widget_slug.'-'.$count;

	        $newWidget[$count] = $widget_settings;

	        update_option('sidebars_widgets', $sidebars_widgets);
	        update_option('widget_'.$widget_slug, $newWidget);

	    }

	    public function set_demo_data( $file, $import_demo, $attachments ) {
			
			

		    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

	        require_once ABSPATH . 'wp-admin/includes/import.php';

	        $importer_error = false;

	        if ( !class_exists( 'WP_Importer' ) ) {

	            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

	            if ( file_exists( $class_wp_importer ) ){

	                require_once($class_wp_importer);

	            } else {

	                $importer_error = true;

	            }

	        }

	        if ( !class_exists( 'WP_Import' ) ) {

	            $class_wp_import = dirname( __FILE__ ) .'/wordpress-importer.php';

	            if ( file_exists( $class_wp_import ) )
	                require_once($class_wp_import);
	            else
	                $importer_error = true;

	        }

	        if($importer_error){

	            die("Error on import");

	        } else {

	            if(!is_file( $file )){

	                echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";

	            } else {

	               	$wp_import = new WP_Import();
	               	
					if ($attachments) {
						
						$wp_import->fetch_attachments = true;
					
					} else {
						
						$wp_import->fetch_attachments = false;
						
					}

					/*
					$import_demo_path = 'demo-' . $import_demo . '/'; // path
					$file = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $file);					
					*/
					
	               	$wp_import->import( $file );
					
					// echo $file;
					
					$this->flag_as_imported['content'] = true;

	         	}

	    	}

	    	do_action( 'radium_importer_after_theme_content_import');


	    }

	    // public function set_demo_menus() {}
		public function set_demo_menus(){

			// Menus to Import and assign - you can remove or add as many as you want
			$primary_menu    	= get_term_by('name', 'primary', 'nav_menu');
			$onepage_menu   	= get_term_by('name', 'onepage', 'nav_menu');
			$footer_menu 		= get_term_by('name', 'footer',  'nav_menu');

			/*
			set_theme_mod( 'nav_menu_locations', array(
					'primary'	=> $primary_menu->term_id,
					'onepage'	=> $onepage_menu->term_id,
					'footer' 	=> $footer_menu->term_id
				)
			);
			*/
			
			$locations = get_theme_mod('nav_menu_locations');
			
			$locations['primary'] 	= $primary_menu->term_id;
			$locations['onepage'] 	= $onepage_menu->term_id;
			$locations['footer'] 	= $footer_menu->term_id;
									
			set_theme_mod('nav_menu_locations', $locations);		

			$this->flag_as_imported['menus'] = true;

		}
		

	    public function set_demo_theme_options( $file, $import_demo ) {


			$import_demo_path = 'demo-' . $import_demo . '/'; // path
			$file = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $file);


	    	// Does the File exist?
			if ( file_exists( $file ) ) {
				
				
				// echo '<p>' . 'Working at theme options: ' . $file . '<p>';

				// Get file contents and decode
				$data = file_get_contents( $file );

				if( $this->theme_options_framework == 'radium') {

					//radium framework
					$data = unserialize( trim($data, '###') );

				} elseif( $this->theme_options_framework == 'optiontree' ) {

					//option tree import
					$data = $this->optiontree_decode($data);

				} else {

					//other frameworks
					//$data = json_decode( $data, true );
					$data = maybe_unserialize( $data );

				}

				// Only if there is data
				if ( !empty( $data ) || is_array( $data ) ) {
					
					
					// var_dump($data);

					// Hook before import

					$data = apply_filters( 'radium_theme_import_theme_options', $data );
										
					
					// $data = json_encode($data);
					
					$old_option = get_option( 'option_tree' );
					
					if (empty($old_option)) {
						
							// add_option( 'option_tree', $data, '', 'yes' );
	
							global $wpdb;
							
							$table_name = $wpdb->base_prefix . 'options';
							
							$wpdb->insert($table_name,
							
							array(
								'option_name' => 'option_tree',
								'option_value' => $data),
							array(
								'%s',
								'%s'
							));						 

						
					} else {
					
							delete_option( 'option_tree' ); 
						
							//add_option( 'option_tree', $data, '', 'yes' );
							
							// update_option( 'option_tree', $data );
							
							global $wpdb;
							
							$table_name = $wpdb->base_prefix . 'options';
							
							$wpdb->insert($table_name,
							
							array(
								'option_name' => 'option_tree',
								'option_value' => $data),
							array(
								'%s',
								'%s'
							));
					
					}

					$this->flag_as_imported['options'] = true;
					
					// 	echo $data;
				}

	      		do_action( 'radium_importer_after_theme_options_import' );

      		} else {

	      		wp_die(
      				__( 'Theme options Import file could not be found. Please try again.', 'radium' ),
      				'',
      				array( 'back_link' => true )
      			);
       		}

	    }

	    /**
	     * Available widgets
	     *
	     * Gather site's widgets into array with ID base, name, etc.
	     * Used by export and import functions.
	     *
	     * @since 0.0.2
	     *
	     * @global array $wp_registered_widget_updates
	     * @return array Widget information
	     */
	    function available_widgets() {

	    	global $wp_registered_widget_controls;

	    	$widget_controls = $wp_registered_widget_controls;

	    	$available_widgets = array();

	    	foreach ( $widget_controls as $widget ) {

	    		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

	    			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
	    			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

	    		}

	    	}

	    	return apply_filters( 'radium_theme_import_widget_available_widgets', $available_widgets );

	    }


	    /**
	     * Process import file
	     *
	     * This parses a file and triggers importation of its widgets.
	     *
	     * @since 0.0.2
	     *
	     * @param string $file Path to .wie file uploaded
	     * @global string $widget_import_results
	     */
	    function process_widget_import_file( $file, $import_demo ) {
			
			$import_demo_path = 'demo-' . $import_demo . '/'; // path
			$file = str_replace('/demo-files/', '/demo-files/' . $import_demo_path, $file);			

	    	// File exists?
	    	if ( ! file_exists( $file ) ) {
	    		wp_die(
	    			__( 'Widget Import file could not be found. Please try again.', 'radium' ),
	    			'',
	    			array( 'back_link' => true )
	    		);
	    	}

	    	// Get file contents and decode
	    	$data = file_get_contents( $file );
	    	$data = json_decode( $data );

	    	// Delete import file
	    	//unlink( $file );

	    	// Import the widget data
	    	// Make results available for display on import/export page
	    	$this->widget_import_results = $this->import_widgets( $data );

	    }


	    /**
	     * Import widget JSON data
	     *
	     * @since 0.0.2
	     * @global array $wp_registered_sidebars
	     * @param object $data JSON widget data from .json file
	     * @return array Results array
	     */
	    public function import_widgets( $data ) {

	    	global $wp_registered_sidebars;

	    	// Have valid data?
	    	// If no data or could not decode
	    	if ( empty( $data ) || ! is_object( $data ) ) {
	    		return;
	    	}

	    	// Hook before import
	    	$data = apply_filters( 'radium_theme_import_widget_data', $data );

	    	// Get all available widgets site supports
	    	$available_widgets = $this->available_widgets();

	    	// Get all existing widget instances
	    	$widget_instances = array();
	    	foreach ( $available_widgets as $widget_data ) {
	    		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	    	}

	    	// Begin results
	    	$results = array();

	    	// Loop import data's sidebars
	    	foreach ( $data as $sidebar_id => $widgets ) {

	    		// Skip inactive widgets
	    		// (should not be in export file)
	    		if ( 'wp_inactive_widgets' == $sidebar_id ) {
	    			continue;
	    		}

	    		// Check if sidebar is available on this site
	    		// Otherwise add widgets to inactive, and say so
	    		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
	    			$sidebar_available = true;
	    			$use_sidebar_id = $sidebar_id;
	    			$sidebar_message_type = 'success';
	    			$sidebar_message = '';
	    		} else {
	    			$sidebar_available = false;
	    			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
	    			$sidebar_message_type = 'error';
	    			$sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'radium' );
	    		}

	    		// Result for sidebar
	    		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
	    		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
	    		$results[$sidebar_id]['message'] = $sidebar_message;
	    		$results[$sidebar_id]['widgets'] = array();

	    		// Loop widgets
	    		foreach ( $widgets as $widget_instance_id => $widget ) {

	    			$fail = false;

	    			// Get id_base (remove -# from end) and instance ID number
	    			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
	    			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

	    			// Does site support this widget?
	    			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
	    				$fail = true;
	    				$widget_message_type = 'error';
	    				$widget_message = __( 'Site does not support widget', 'radium' ); // explain why widget not imported
	    			}

	    			// Filter to modify settings before import
	    			// Do before identical check because changes may make it identical to end result (such as URL replacements)
	    			$widget = apply_filters( 'radium_theme_import_widget_settings', $widget );

	    			// Does widget with identical settings already exist in same sidebar?
	    			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

	    				// Get existing widgets in this sidebar
	    				$sidebars_widgets = get_option( 'sidebars_widgets' );
	    				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

	    				// Loop widgets with ID base
	    				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
	    				foreach ( $single_widget_instances as $check_id => $check_widget ) {

	    					// Is widget in same sidebar and has identical settings?
	    					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

	    						$fail = true;
	    						$widget_message_type = 'warning';
	    						$widget_message = __( 'Widget already exists', 'radium' ); // explain why widget not imported

	    						break;

	    					}

	    				}

	    			}

	    			// No failure
	    			if ( ! $fail ) {

	    				// Add widget instance
	    				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
	    				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
	    				$single_widget_instances[] = (array) $widget; // add it

    					// Get the key it was given
    					end( $single_widget_instances );
    					$new_instance_id_number = key( $single_widget_instances );

    					// If key is 0, make it 1
    					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
    					if ( '0' === strval( $new_instance_id_number ) ) {
    						$new_instance_id_number = 1;
    						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
    						unset( $single_widget_instances[0] );
    					}

    					// Move _multiwidget to end of array for uniformity
    					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
    						$multiwidget = $single_widget_instances['_multiwidget'];
    						unset( $single_widget_instances['_multiwidget'] );
    						$single_widget_instances['_multiwidget'] = $multiwidget;
    					}

    					// Update option with new widget
    					update_option( 'widget_' . $id_base, $single_widget_instances );

	    				// Assign widget instance to sidebar
	    				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
	    				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
	    				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
	    				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

	    				// Success message
	    				if ( $sidebar_available ) {
	    					$widget_message_type = 'success';
	    					$widget_message = __( 'Imported', 'radium' );
	    				} else {
	    					$widget_message_type = 'warning';
	    					$widget_message = __( 'Imported to Inactive', 'radium' );
	    				}

	    			}

	    			// Result for widget instance
	    			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
	    			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = isset( $widget->title ) ? $widget->title : __( 'No Title', 'radium' );
	    			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
	    			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

	    		}

	    	}

			$this->flag_as_imported['widgets'] = true;

	    	// Hook after import
	    	do_action( 'radium_theme_import_widget_after_import' );

	    	// Return results
	    	return apply_filters( 'radium_theme_import_widget_results', $results );

	    }

	    /**
	     * Helper function to return option tree decoded strings
	     *
	     * @return    string
	     *
	     * @access    public
	     * @since     0.0.3
	     */
	    public function optiontree_decode( $value ) {

			$func = 'base64' . '_decode';
			return $func( $value );

	    }

	}//class

}//function_exists

?>
