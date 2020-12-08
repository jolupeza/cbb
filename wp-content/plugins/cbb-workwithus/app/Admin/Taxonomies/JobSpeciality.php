<?php

namespace CBB_WorkWithUs\Admin\Taxonomies;

use CBB_WorkWithUs\Includes\Loader;

class JobSpeciality
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
        $this->loader->add_action('init', $this, 'addTaxonomyJobSpeciality');
    }

    public function addTaxonomyJobSpeciality()
    {
        $args = array(
            'labels' => $this->getLabelsTaxonomyJobSpeciality(),
            'public' => false,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'convocatorias'
            ),
        );

        register_taxonomy('job_specialities', 'jobapplications', $args);
    }

    /**
     * Return labels for declaration taxonomy job_specialities
     *
     * @return array
     */
    private function getLabelsTaxonomyJobSpeciality()
    {
        return array(
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
            'new_item_name' => __('Nueva  Especialidad', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Especialidad', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Especialidades', $this->domain),
        );
    }
}
