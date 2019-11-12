<?php

namespace VM_Manager\Admin;

class VM_Manager_Services
{
    public function cd_mb_services_add()
    {
        add_meta_box(
            'mb-services-id',
            'Configuración',
            array($this, 'render_mb_services'),
            'services',
            'normal',
            'core'
        );
    }
    
    public function cd_mb_services_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (empty(filter_input(INPUT_POST, 'meta_box_nonce')) || !wp_verify_nonce(filter_input(INPUT_POST, 'meta_box_nonce'), 'services_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
                
        $data = [
            'mb_inhome' => !empty(filter_input(INPUT_POST, 'mb_inhome')) ? 'on' : 'off',
        ];
        
        $this->updateCustomMeta($post_id, $data);
    }
    
    private function updateCustomMeta($postId, $data = array())
    {
        foreach ($data as $meta => $value) {
            if (!empty($value)) {
                if (is_array($value) && $value[1]) {
                    update_post_meta($postId, $meta, wp_kses($value[0], $this->allowed));
                } else {
                    update_post_meta($postId, $meta, esc_attr($value));
                }
            } else {
                delete_post_meta($postId, $meta);
            }
        }
    }
    
    public function render_mb_services()
    {
        require_once plugin_dir_path(__FILE__).'partials/vm-mb-services.php';
    }
    
    /**
     * Add custom taxonomies categories_service to post type services.
     */
    public function add_taxonomies_services()
    {
        $labels = array(
            'name' => _x('Categorías', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Categoría', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Categoría', THEMEDOMAIN),
            'popular_items' => __('Categorías Populares', THEMEDOMAIN),
            'all_items' => __('Todos las Categorías', THEMEDOMAIN),
            'parent_item' => __('Categoría Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Categoría Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Categoría', THEMEDOMAIN),
            'update_item' => __('Actualizar Categoría', THEMEDOMAIN),
            'add_new_item' => __('Añadir nueva Categoría', THEMEDOMAIN),
            'new_item_name' => __('Nueva Categoría', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Categoría', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Categorías', THEMEDOMAIN),
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

        register_taxonomy('categories_service', 'services', $args);
    }

}
