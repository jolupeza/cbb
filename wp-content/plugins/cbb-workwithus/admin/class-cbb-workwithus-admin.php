<?php

namespace CBB_WorkWithUs\Admin;

/**
 * The CBB WorkWithUs Admin defines all functionality for the dashboard
 * of the plugin.
 */

/** 
 * The CBB WorkWithUs Admin defines all functionality for the dashboard
 * of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since    1.0.0
 */
class CBB_WorkWithUs_Admin
{
    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Labels indicate allowed in custom fields.
     *
     * @var array
     */
    private $allowed;
    
    private $domain;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $domain  Text domain plugin
     * @param string $version The current version of this plugin.
     */
    public function __construct($domain, $version)
    {
        $this->version = $version;
        $this->domain  = $domain;

        $this->allowed = array(
            'p' => array(
                'style' => array(),
            ),
            'a' => array(// on allow a tags
                'href' => array(),
                'target' => array(),
            ),
            'ul' => array(
                'class' => array(),
            ),
            'ol' => array(),
            'li' => array(
                'style' => array(),
            ),
            'strong' => array(),
            'br' => array(),
            'span' => array(),
        );
    }
    
    /**
     * Add custom content type
     */
    public function add_post_type()
    {
        $this->registerJobPostulations();
    }
    
    private function registerJobPostulations()
    {
        $labels = array(
            'name' => __('Postulaciones', $this->domain),
            'singular_name' => __('Postulación', $this->domain),
            'add_new' => __('Nueva postulación', $this->domain),
            'add_new_item' => __('Agregar nueva postulación', $this->domain),
            'edit_item' => __('Editar postulación', $this->domain),
            'new_item' => __('Nueva postulación', $this->domain),
            'view_item' => __('Ver postulación', $this->domain),
            'search_items' => __('Buscar postulación', $this->domain),
            'not_found' => __('Postulación no encontrada', $this->domain),
            'not_found_in_trash' => __('Postulación no encontrada en la papelera', $this->domain),
            'all_items' => __('Todos las postulaciones', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de postulaciones.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-id',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                // 'editor',
                'custom-fields',
                'author',
                // 'thumbnail',
//                'page-attributes',
            // 'excerpt'
            // 'trackbacks'
            // 'comments',
            // 'revisions',
            // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            'rewrite' => false
        );
        register_post_type('jobapplications', $args);
    }
    
    public function unregister_post_type()
    {
        global $wp_post_types;
        
        if (isset($wp_post_types['models'])) {
            unset($wp_post_types['models']);
            return TRUE;
        }
        
        return FALSE;
    }
}
