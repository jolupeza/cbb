<?php

namespace VM_Manager\Admin;

class VM_Manager_Staff
{
    /**
     * Add custom taxonomies areas_staff to post type staff.
     */
    public function add_taxonomies_staff()
    {
        $labels = array(
            'name' => _x('Áreas', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Área', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Área', THEMEDOMAIN),
            'popular_items' => __('Áreas Populares', THEMEDOMAIN),
            'all_items' => __('Todos las Áreas', THEMEDOMAIN),
            'parent_item' => __('Área Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Área Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Área', THEMEDOMAIN),
            'update_item' => __('Actualizar Área', THEMEDOMAIN),
            'add_new_item' => __('Añadir nueva Área', THEMEDOMAIN),
            'new_item_name' => __('Nueva Área', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Área', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Áreas', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => false,
//            'capabilities' => array(),
        );

        register_taxonomy('areas_staff', 'staff', $args);
    }

}
