<?php

namespace CBB_WorkWithUs\Admin\Entities;

use CBB_WorkWithUs\Includes\Loader;

class Specialty
{
    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    private $loader;

    private $domain;

    /**
     * @param Loader $loader
     */
    public function __construct(Loader $loader, $domain)
    {
        $this->loader = $loader;
        $this->domain = $domain;
    }

    public function init()
    {
        $this->loader->add_action('init', $this, 'registerPostType');
    }

    public function registerPostType()
    {
        $labels = array(
            'name' => __('Especialidades', $this->domain),
            'singular_name' => __('Especialidad', $this->domain),
            'add_new' => __('Nueva especialidad', $this->domain),
            'add_new_item' => __('Agregar nueva especialidad', $this->domain),
            'edit_item' => __('Editar especialidad', $this->domain),
            'new_item' => __('Nueva especialidad', $this->domain),
            'view_item' => __('Ver especialidad', $this->domain),
            'search_items' => __('Buscar especialidad', $this->domain),
            'not_found' => __('Especialidad no encontrada', $this->domain),
            'not_found_in_trash' => __('Especialidad no encontrada en la papelera', $this->domain),
            'all_items' => __('Todos las especialidades', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de Especialidades.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_rest' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-welcome-learn-more',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                // 'editor',
//                'custom-fields',
                'author',
                // 'thumbnail',
                'page-attributes',
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
        register_post_type('specialties', $args);
    }

}
