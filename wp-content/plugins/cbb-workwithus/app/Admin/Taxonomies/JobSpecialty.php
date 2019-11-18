<?php

namespace CBB_WorkWithUs\Admin\Taxonomies;

use CBB_WorkWithUs\Includes\Loader;

class JobSpecialty
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
            'name' => _x('Especialidades', 'Taxonomy plural name', $this->domain),
            'singular_name' => _x('Especialidad', 'Taxonomy singular name', $this->domain),
            'search_items' => __('Buscar Especialidad', $this->domain),
            'popular_items' => __('Especialidades Populares', $this->domain),
            'all_items' => __('Todos las Especialidades', $this->domain),
            'parent_item' => __('Especialidad Padre', $this->domain),
            'parent_item_colon' => __('Especialidad Padre', $this->domain),
            'edit_item' => __('Editar Especialidad', $this->domain),
            'update_item' => __('Actualizar Especialidad', $this->domain),
            'add_new_item' => __('Añadir nueva Especialidad', $this->domain),
            'new_item_name' => __('Nueva Especialidad', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Especialidad', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Especialidades', $this->domain),
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

        register_taxonomy('jobspecialties', 'jobapplications', $args);
    }

    public function registerRestRoute()
    {
        register_rest_route('workwithus/v1', '/jobspecialties', array(
            'methods' => 'GET',
            'callback' => array($this, 'getTerms')
        ));
    }

    public function getTerms(\WP_REST_Request $request)
    {
        $args = array(
            'hide_empty' => false,
            'order' => 'ASC',
            'orderby' => 'name'
        );
        $specialties = get_terms('jobspecialties', $args);

        if (count($specialties) <= 0) {
            return new \WP_Error('no_jobspecialties', 'Invalid specialty', array('status' => 404));
        }

        $jobspecialtiesData = array();

        foreach ($specialties as $specialty) {
            $jobspecialtiesData[] = array(
                'id' => $specialty->term_id,
                'name' => $specialty->name,
            );
        }

        return $jobspecialtiesData;
    }

}
