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
        $this->loader->add_action('add_meta_boxes', $this, 'cdMbDegreesAdd');
        $this->loader->add_action('save_post', $this, 'cdMbDegreesSave');
        $this->loader->add_action('rest_api_init', $this, 'registerRestRouteByType');
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

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type degrees.
     */
    public function cdMbDegreesAdd()
    {
        add_meta_box(
            'mb-degrees-id',
            'Opciones',
            array($this, 'renderMbDegrees'),
            'degrees',
            'normal',
            'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function renderMbDegrees()
    {
        require_once plugin_dir_path(__FILE__).'partials/cbb-mb-degrees.php';
    }

    public function cdMbDegreesSave($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'degrees_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        delete_post_meta($post_id, 'mb_type');

        $typeApplications = get_terms([
            'taxonomy' => 'joblevels',
            'hide_empty' => false,
            'fields' => 'id=>name'
        ]);

        foreach ($typeApplications as $id => $type) {
            if (isset($_POST['mb_type_' . $id])) {
                update_post_meta($post_id, 'mb_type_' . $id, true);
            } else {
                delete_post_meta($post_id, 'mb_type_' . $id);
            }
        }
    }

    public function registerRestRouteByType()
    {
        register_rest_route('workwithus/v1', '/degrees/type=(?P<type>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'getByType'),
            'args' => array(
                'type' => array(
                    'validate_callback' => function ($param, $request, $key) {
                        return is_numeric($param);
                    }
                )
            )
        ));
    }

    public function getByType(\WP_REST_Request $request)
    {
        $type = (int) $request['type'];

        $args = array(
            'post_type' => 'degrees',
            'post_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'meta_query' => array(
                array(
                    'key' => 'mb_type_' . $type,
                    'value' => true
                )
            )
        );

        $degrees = new \WP_Query($args);

        if (!$degrees->have_posts()) {
            return new \WP_Error('no_degrees', 'Invalid type', array('status' => 404));
        }

        $degreesData = array();

        if ($degrees->have_posts()) {
            while ($degrees->have_posts()) {
                $degrees->the_post();

                $degreesData[] = array(
                    'id' => get_the_ID(),
                    'name' => get_the_title()
                );
            }
        }

        return $degreesData;
    }
}
