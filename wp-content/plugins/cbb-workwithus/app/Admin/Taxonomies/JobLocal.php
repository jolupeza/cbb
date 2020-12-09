<?php

namespace CBB_WorkWithUs\Admin\Taxonomies;

use CBB_WorkWithUs\Includes\Loader;

class JobLocal
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
        $this->loader->add_action('init', $this, 'addTaxonomyJobLocal');
    }

    public function addTaxonomyJobLocal()
    {
        $args = array(
            'labels' => $this->getLabelsTaxonomyJobLocal(),
            'public' => false,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => false,
        );

        register_taxonomy('job_locals', 'jobapplications', $args);
    }

    /**
     * Return labels for declaration taxonomy job_specialities
     *
     * @return array
     */
    private function getLabelsTaxonomyJobLocal()
    {
        return array(
            'name' => _x('Sedes', 'Taxonomy plural name', $this->domain),
            'singular_name' => _x('Sede', 'Taxonomy singular name', $this->domain),
            'search_items' => __('Buscar Sede', $this->domain),
            'popular_items' => __('Sedes Populares', $this->domain),
            'all_items' => __('Todos las Sedes', $this->domain),
            'parent_item' => __('Sede Padre', $this->domain),
            'parent_item_colon' => __('Sede Padre', $this->domain),
            'edit_item' => __('Editar Sede', $this->domain),
            'update_item' => __('Actualizar Sede', $this->domain),
            'add_new_item' => __('Añadir nueva Sede', $this->domain),
            'new_item_name' => __('Nueva Sede', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Sede', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Sedes', $this->domain),
        );
    }

}
