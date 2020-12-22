<?php

namespace CBB_WorkWithUs\Admin\Taxonomies;

use CBB_WorkWithUs\Includes\Loader;

class JobLevels
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
        $this->loader->add_action('init', $this, 'addTaxonomyJobLevels');
    }

    public function addTaxonomyJobLevels()
    {
        $args = array(
            'labels' => $this->getLabelsTaxonomyJobLevels(),
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

        register_taxonomy('job_levels', 'jobapplications', $args);
    }

    /**
     * Return labels for declaration taxonomy job_specialities
     *
     * @return array
     */
    private function getLabelsTaxonomyJobLevels()
    {
        return array(
            'name' => _x('Niveles', 'Taxonomy plural name', $this->domain),
            'singular_name' => _x('Nivel', 'Taxonomy singular name', $this->domain),
            'search_items' => __('Buscar Nivel', $this->domain),
            'popular_items' => __('Niveles Populares', $this->domain),
            'all_items' => __('Todos los Niveles', $this->domain),
            'parent_item' => __('Nivel Padre', $this->domain),
            'parent_item_colon' => __('Nivel Padre', $this->domain),
            'edit_item' => __('Editar Nivel', $this->domain),
            'update_item' => __('Actualizar Nivel', $this->domain),
            'add_new_item' => __('Añadir nuevo Nivel', $this->domain),
            'new_item_name' => __('Nueva Nivel', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Nivel', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Niveles', $this->domain),
        );
    }
}
