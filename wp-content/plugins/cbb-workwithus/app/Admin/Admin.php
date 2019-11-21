<?php

namespace CBB_WorkWithUs\Admin;

use CBB_WorkWithUs\Admin\Entities\Degree;
use CBB_WorkWithUs\Admin\Entities\District;
use CBB_WorkWithUs\Admin\Entities\Province;
use CBB_WorkWithUs\Admin\Entities\Specialty;
use CBB_WorkWithUs\Includes\Loader;

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
class Admin
{
    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    private $loader;

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
    public function __construct(Loader $loader, $domain, $version)
    {
        $this->loader = $loader;
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

    public function init()
    {
        $this->loader->add_action('init', $this, 'addPostType');

        $this->loader->add_action('init', $this, 'unregisterPostType');

        $degree = new Degree($this->loader, $this->domain);
        $degree->init();

        $specialty = new Specialty($this->loader, $this->domain);
        $specialty->init();
    }

    /**
     * Add custom content type
     */
    public function addPostType()
    {
        $this->registerJobPostulations();
        /*$this->registerCities();
        $this->registerProvinces();
        $this->registerDistricts();*/
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

    private function registerCities()
    {
        $labels = array(
            'name' => __('Departamentos', $this->domain),
            'singular_name' => __('Departamento', $this->domain),
            'add_new' => __('Nuevo departamento', $this->domain),
            'add_new_item' => __('Agregar nuevo departamento', $this->domain),
            'edit_item' => __('Editar departamento', $this->domain),
            'new_item' => __('Nuevo departamento', $this->domain),
            'view_item' => __('Ver departamento', $this->domain),
            'search_items' => __('Buscar departamento', $this->domain),
            'not_found' => __('Departamento no encontrado', $this->domain),
            'not_found_in_trash' => __('Departamento no encontrado en la papelera', $this->domain),
            'all_items' => __('Todos los departamentos', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de departamentos.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_rest' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-location',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                // 'editor',
//                'custom-fields',
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
        register_post_type('cities', $args);
    }

    private function registerProvinces()
    {
        $labels = array(
            'name' => __('Provincias', $this->domain),
            'singular_name' => __('Provincia', $this->domain),
            'add_new' => __('Nueva provincia', $this->domain),
            'add_new_item' => __('Agregar nueva provincia', $this->domain),
            'edit_item' => __('Editar provincia', $this->domain),
            'new_item' => __('Nueva provincia', $this->domain),
            'view_item' => __('Ver provincia', $this->domain),
            'search_items' => __('Buscar provincia', $this->domain),
            'not_found' => __('Provincia no encontrada', $this->domain),
            'not_found_in_trash' => __('Provincia no encontrada en la papelera', $this->domain),
            'all_items' => __('Todos las provincias', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de provincias.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_rest' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-location',
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
        register_post_type('provinces', $args);
    }

    private function registerDistricts()
    {
        $labels = array(
            'name' => __('Distritos', $this->domain),
            'singular_name' => __('Distrito', $this->domain),
            'add_new' => __('Nuevo distrito', $this->domain),
            'add_new_item' => __('Agregar nuevo distrito', $this->domain),
            'edit_item' => __('Editar distrito', $this->domain),
            'new_item' => __('Nuevo distrito', $this->domain),
            'view_item' => __('Ver distrito', $this->domain),
            'search_items' => __('Buscar distrito', $this->domain),
            'not_found' => __('Distrito no encontrado', $this->domain),
            'not_found_in_trash' => __('Distrito no encontrado en la papelera', $this->domain),
            'all_items' => __('Todos los distritos', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de distritos.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_rest' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-location',
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
        register_post_type('districts', $args);
    }

    public function unregisterPostType()
    {
        unregister_post_type('cities');
        unregister_post_type('provinces');
        unregister_post_type('districts');
    }
}
