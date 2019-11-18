<?php

namespace CBB_WorkWithUs\Admin\Taxonomies;

use CBB_WorkWithUs\Includes\Loader;

class JobDegree
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
        $this->loader->add_action('init', $this, 'addTaxonomy');
        $this->loader->add_action('rest_api_init', $this, 'registerRestRoute');
    }

    /**
     * Add custom taxonomies jobdegrees to post type jobapplications.
     */
    public function addTaxonomy()
    {
        $labels = array(
            'name' => _x('Grados Académicos', 'Taxonomy plural name', $this->domain),
            'singular_name' => _x('Grado', 'Taxonomy singular name', $this->domain),
            'search_items' => __('Buscar Grado', $this->domain),
            'popular_items' => __('Grados Populares', $this->domain),
            'all_items' => __('Todos los Grados', $this->domain),
            'parent_item' => __('Grado Padre', $this->domain),
            'parent_item_colon' => __('Grado Padre', $this->domain),
            'edit_item' => __('Editar Grado', $this->domain),
            'update_item' => __('Actualizar Grado', $this->domain),
            'add_new_item' => __('Añadir nuevo Grado', $this->domain),
            'new_item_name' => __('Nuevo Grado', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Grado', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Grados Académicos', $this->domain),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true
        );

        register_taxonomy('jobdegrees', 'jobapplications', $args);
    }

    public function registerRestRoute()
    {
        register_rest_route('workwithus/v1', '/jobdegrees', array(
            'methods' => 'GET',
            'callback' => array($this, 'getTerms')
        ));
    }

    public function getTerms(\WP_REST_Request $request)
    {
        $args = array(
            'hide_empty' => false,
            'order' => 'ASC',
            'orderby' => 'term_id'
        );
        $degrees = get_terms('jobdegrees', $args);

        if (count($degrees) <= 0) {
            return new \WP_Error('no_jobdegrees', 'Invalid degree', array('status' => 404));
        }

        $degreesData = array();

        foreach ($degrees as $degree) {
            $degreesData[] = array(
                'id' => $degree->term_id,
                'name' => $degree->name,
            );
        }

        return $degreesData;
    }

}
