<?php
/**
 * The file contains a base class for all types.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2013, OnePress Ltd
 * 
 * @package core 
 * @since 1.0.0
 */

/**
 * The base class that provides abstraction for custom post type.
 * 
 * @since 1.0.0
 */
abstract class FactoryTypes322_Type {
    
    /**
     * Internal type name.
     * 
     * @since 1.0.0
     * @var string 
     */
    public $name;
    
    /**
     * Plural visible title.
     * 
     * @since 1.0.0
     * @var string  
     */
    public $pluralTitle;
    
    /**
     * Singular visible title.
     * 
     * @since 1.0.0
     * @var string 
     */
    public $singularTitle;
    
    /**
     * A short descriptive summary of what the post type is.
     * 
     * @since 1.0.0
     * @var string
     */
    
    public $description;
    
    /**
     * One of pre defined templates for options.
     * Allowed values: public, private, internal.
     * 
     * @since 1.0.0
     * @var type 
     */
    public $template = 'public';
    
    /**
     * A view table is used to show type records in the admin area.
     * 
     * @since 1.0.0
     * @var FactoryViewtables320_Viewtable 
     */
    public $viewTable;
    
    /**
     * Capabilities for roles that have access to manage the type.
     * 
     * @link http://codex.wordpress.org/Roles_and_Capabilities
     * 
     * @since 1.0.0
     * @var string[] 
     */
    public $capabilities = array('administrator', 'editor');
    
    /**
     * Scripts that must be included on edit page.
     * 
     * @since 1.0.0
     * @var Factory325_ScriptList 
     */
    public $scripts;
    
    /**
     * Styles that must be included on edit page.
     * 
     * @since 1.0.0
     * @var Factory325_StyleList 
     */  
    public $styles;
    
    /**
     * A menu configurator for a type.
     * 
     * @var FactoryTypes322_Menu 
     */
    public $menu;

    /**
     * Contains a set of metaboxes for a given post type.
     * 
     * @var string[]
     */
    public $metaboxes;
    
    /**
     * Options for a custom type.
     * 
     * @link http://codex.wordpress.org/Function_Reference/register_post_type
     * @since 1.0.0
     */
    public $options = array(  
        'label' => null,   
        'labels' => null,   
        'description' => null,   
        'public' => null,   
        'publicly_queryable' => null,  
        'exclude_from_search' => null,   
        'show_ui' => null,  
        'show_in_menu' => null,   
        'menu_position' => null,   
        'menu_icon' => null,   
        'capability_type' => null,  
        'hierarchical' => false,  
        'supports' => array('title'),  
        'taxonomies' => array(),  
        'has_archive' => null,  
        'rewrite' => null,  
        'query_var' => null,  
        'show_in_nav_menus' => null  
    );
    
    /**
     * Messages for a custom post type.
     * 
     * @link http://codex.wordpress.org/Function_Reference/register_post_type
     * @since 1.0.0
     */
    public $messages = array();

    /**
     * Creates a new instance of a type.
     * 
     * @since 1.0.0
     */
    public function __construct( $plugin ) {
        $this->plugin = $plugin;
        
        $this->menu = new FactoryTypes322_Menu( $this );
        $this->metaboxes = array();
        
        $this->scripts = $this->plugin->newScriptList();
        $this->styles = $this->plugin->newStyleList();
        
        add_action('init', array($this, 'register'));
    }
    
    /**
     * Registers a custom post type.
     * 
     * @since 1.0.0
     * @return void
     */
    public function register() {
        if (!$this->useit()) return;
        
        // type's titles
        $singularName = $this->pluralTitle ? $this->pluralTitle : $this->name;
        $pluralName = $this->singularTitle ? $this->singularTitle : $this->name;   

        $this->options['labels'] = array(
           'name' => $singularName,
           'singular_name' => $pluralName,
        );    
                
        if ( $this->template ) {
            $this->applyTypeTemplate($this->template);
        }
        
        if ( is_admin() ) $this->registerForAdmin();
        else $this->registerForPublic();  
    }
    
    /**
     * Registers the custom post type for the public area.
     * 
     * @since 1.0.0
     * @return void
     */
    public function registerForPublic() {
        register_post_type( $this->name, $this->options );
    }   
    
    /**
     * Registers the custom post type for the admin area.
     * 
     * @since 1.0.0
     * @return void
     */
    public function registerForAdmin() {

        $this->buildLables();
        $this->buildMessages();

        $metaboxes = array();
        $this->configure();

        // adds metaboxes that needed to load
        foreach($this->metaboxes as $metabox) {
            FactoryMetaboxes321::registerFor($metabox, $this->name, $this->plugin);
        }
               
        if ( !$this->scripts->isEmpty('bootstrap')|| !$this->styles->isEmpty('bootstrap') ) {
            add_action('factory_bootstrap_enqueue_scripts_' . $this->plugin->pluginName, array($this, 'actionAdminBootstrapScripts'));
        }
        
        // includes styles and scripts
        if ( !$this->scripts->isEmpty() || !$this->styles->isEmpty() ) {
            add_action('admin_enqueue_scripts', array($this, 'actionAdminScripts'));
        }
        
        // updates messages thats displays during changes
        add_filter( 'post_updated_messages', array( $this, 'actionUpdatedMessages' ));
        
        // redefines the Publish metabox for non-public types
        if ( $this->template !== 'public') {
            //FactoryMetaboxes321::registerFor('FactoryMetaboxes321_PublishMetabox', $this->name);
            add_action('add_meta_boxes', array($this, 'actionAddMetaboxs'));
        }
        
        if ( !empty( $this->capabilities ) ) {
            
            $this->options['capability_type'] = $this->name;
            $this->options['capabilities'] = array(
                'edit_post' => 'edit_' . $this->name,
                'read_post' => 'read_' . $this->name,
                'delete_post' => 'delete_' . $this->name,
                'delete_posts' => 'delete_' . $this->name . 's',
                'edit_posts' => 'edit_' . $this->name . 's',
                'edit_others_posts' => 'edit_others_' . $this->name . 's',
                'publish_posts' => 'publish_' . $this->name . 's',
                'read_private_posts' => 'read_private_' . $this->name . 's',
                'create_posts' => 'edit_' . $this->name . 's'
            );
            
        } elseif ( $this->options['capability_type'] == null ) {
            $this->options['capability_type'] = 'post';
        }

        // register view table
        if ( !empty( $this->viewTable ) && class_exists( $this->viewTable ) ) {
            $this->viewTable = new $this->viewTable( $this->plugin );
            $this->viewTable->connect( $this );
        }
        
        // sets menu icon
        if ( !empty($this->menu) ) {

            if ( !empty( $this->menu->icon ) ) {
                $this->options['menu_icon'] = $this->menu->icon;
            } else {
                $this->options['menu_icon'] = 'none';
            }

            if ( !empty( $this->menu->title) ) {
                add_action( 'admin_menu', array($this, 'actionAdminMenu'));   
            }
        }

        register_post_type( $this->name, $this->options );
    }
    
    /**
     * Actions that includes registered fot this type scritps and styles.
     * @global type $post
     * @param type $hook
     */
    public function actionAdminBootstrapScripts( $hook ) {
        global $post;

	if ( !in_array( $hook, array('post.php', 'post-new.php')) ) return;
        if ( $post->post_type != $this->name ) return;
        if ( $this->scripts->isEmpty('bootstrap') && $this->styles->isEmpty('bootstrap') ) return;
                
        $this->scripts->connect('bootstrap');
        $this->styles->connect('bootstrap'); 
    }  

    /**
     * Actions that includes registered fot this type scritps and styles.
     * @global type $post
     * @param type $hook
     */
    public function actionAdminScripts( $hook ) {
        global $post;

	if ( !in_array( $hook, array('post.php', 'post-new.php')) ) return;
        if ( $post->post_type != $this->name ) return;
        if ( $this->scripts->isEmpty() && $this->styles->isEmpty() ) return;
                
        $this->scripts->connect();
        $this->styles->connect(); 
    }
    
    /**
     * Applies a given template to the type options.
     * @param string $templateName allowed values: 'public', 'private', 'internal'
     * @throws Exception Invalide template name for the type "%s"
     */
    private function applyTypeTemplate( $templateName ) {
        
        if (!in_array($templateName, array('public', 'private', 'internal')))
            throw new Exception(sprintf('Invalide template name for the type "%s"', $this->name));
                
        switch ($templateName) {
            case 'public':
                
                $this->options['public'] = true;
                
                break;
            case 'private':
                
                $this->options['public'] = false;
                
                $this->options['show_in_menu'] = true;
                $this->options['show_ui'] = true;
                $this->options['publicly_queryable'] = false;
                $this->options['exclude_from_search'] = true;
                
                break;
            case 'internal':
                
                $this->options['public'] = false;           
                break;
        }
    }
    
    /**
     * Builds labels for the post type.
     */
    private function buildLables() {
        
        // type's titles
        $singularName = $this->options['labels']['singular_name'];
        $pluralName = $this->options['labels']['name'];    
        
        $labels = array(
            'singular_name' => $singularName,
            'name' => $pluralName,          
            'all_items' => sprintf( __('All %1$s', 'factory_types_322'), $pluralName ),
            'add_new' => sprintf( __('Add %1$s', 'factory_types_322'), $singularName ),
            'add_new_item' => sprintf( __('Add new', 'factory_types_322'), $singularName ),
            'edit' => sprintf( __('Edit', 'factory_types_322') ),
            'edit_item' => sprintf( __('Edit %1$s', 'factory_types_322'), $singularName ),
            'new_item' => sprintf( __('New %1$s', 'factory_types_322'), $singularName ),
            'view' => sprintf( __('View', 'factory_types_322') ),
            'view_item' => sprintf( __('View %1$s', 'factory_types_322'), $singularName ),
            'search_items' => sprintf( __('Search %1$s', 'factory_types_322'), $pluralName ),
            'not_found' => sprintf( __('No %1$s found', 'factory_types_322'), $pluralName ),
            'not_found_in_trash' => sprintf( __('No %1$s found in trash', 'factory_types_322'), $pluralName ),
            'parent' => sprintf( __('Parent %1$s', 'factory_types_322'), $pluralName )
        );
        
        $this->options['labels'] = $labels;
    }
    
    /**
     * Builds messages for the post type.
     */
    private function buildMessages()
    {
        $this->messages = array(
            // Unused. Messages start at index 1.
            0 => '',
            1 => $this->template == 'public' 
                ? '{singular} updated. <a href="{view_url}">View {singular}</a>'
                : '{singular} updated.',
            2 => 'Custom field updated',
            3 => 'Custom field deleted',
            4 => '{singular} updated.',
            5 => isset($_GET['revision']) 
                ? '{singular} restored to revision from {revision}'
                : false,
            6 => $this->template == 'public' 
                ? '{singular} published. <a href="{view_url}">View {singular}</a>'
                : '{singular} created.',
            7 => '{singular} saved.',
            8 => $this->template == 'public' 
                ? '{singular} submitted. <a target="_blank" href="{preview_url}">Preview {singular}</a>'
                : '{singular} submitted.',
            9 => $this->template == 'public' 
                ? '{singular} scheduled for: <strong>{scheduled}</strong>. <a target="_blank" href="{preview_url}">Preview {singular}</a>'
                : '{singular} scheduled for: <strong>{scheduled}</strong>.',
            10 => $this->template == 'public' 
                ? '{singular} draft updated. <a target="_blank" href="{preview_url}">Preview {singular}</a>'
                : '{singular} draft updated.'
        );
    }
    
    public function actionUpdatedMessages( $messages ) 
    {
        global $post, $post_ID;
        if ($post->post_type !== $this->name) return $messages;
        
        $replacements = array(
            array('{singular}', $this->options['labels']['singular_name']),
            array('{view_url}', esc_url( get_permalink($post_ID) ) ),
            array('{preview_url}', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
            array('{revision}', isset($_GET['revision']) 
                ? wp_post_revision_title( (int) $_GET['revision'], false ) : false),
            array('{scheduled}', date_i18n( __( 'M j, Y @ G:i', 'factory_types_322' ), strtotime( $post->post_date ) ) )
        );
        
        foreach($this->messages as $index => $message)
        {
            foreach($replacements as $replacement) {
                $message = str_replace($replacement[0], $replacement[1], $message);
            }
            $this->messages[$index] = $message;
        }
        
        $messages[$this->name] = $this->messages;    
        return $messages;
    }
    
    public function actionAddMetaboxs() 
    {
        //remove_meta_box('submitdiv', $this->name, 'side');
    }

    public function actionAdminMenu() {
        global $menu;
        global $submenu;
        
        foreach($menu as $index => $item) {
            
            if ( isset( $item[2] ) && $item[2] === 'edit.php?post_type=' . $this->name ) {
                $menu[$index][0] = $this->menu->title; 
                break;
            }
        }
    }
    
    public abstract function configure ();

    public function useit() { return true; }
}