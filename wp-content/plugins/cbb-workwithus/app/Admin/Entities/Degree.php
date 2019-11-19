<?php

namespace CBB_WorkWithUs\Admin\Entities;

use CBB_WorkWithUs\Includes\Loader;

class Degree
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
            'name' => __('Grados Académicos', $this->domain),
            'singular_name' => __('Grado Académico', $this->domain),
            'add_new' => __('Nuevo grado', $this->domain),
            'add_new_item' => __('Agregar nuevo grado', $this->domain),
            'edit_item' => __('Editar grado', $this->domain),
            'new_item' => __('Nuevo grado', $this->domain),
            'view_item' => __('Ver grado', $this->domain),
            'search_items' => __('Buscar grado', $this->domain),
            'not_found' => __('Grado no encontrado', $this->domain),
            'not_found_in_trash' => __('Grado no encontradi en la papelera', $this->domain),
            'all_items' => __('Todos los grados', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de Grados Académicos.',
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
        register_post_type('degrees', $args);
    }

}
