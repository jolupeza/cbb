<?php


namespace CBB_WorkWithUs\Admin\Entities;


use CBB_WorkWithUs\Includes\Loader;

class Province
{
    private $loader;

    private $domain;

    private $allowed = array();

    public function __construct(Loader $loader, $domain)
    {
        $this->loader = $loader;
        $this->domain = $domain;
    }

    public function init()
    {
        $this->loader->add_action('add_meta_boxes', $this, 'cd_mb_provinces_add');
        $this->loader->add_action('save_post', $this, 'cb_mb_provinces_save');
        $this->loader->add_action('rest_api_init', $this, 'registerRestRouteByCity');
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type provinces.
     */
    public function cd_mb_provinces_add()
    {
        add_meta_box(
            'mb-provinces-id', 'Opciones', array($this, 'render_mb_provinces'), 'provinces', 'normal', 'core'
        );
    }

    public function cb_mb_provinces_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'provinces_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $data = array(
            'mb_city' => $_POST['mb_city']
        );

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

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_provinces()
    {
        require_once plugin_dir_path(__FILE__).'partials/cbb-mb-provinces.php';
    }

    public function registerRestRouteByCity()
    {
        register_rest_route('workwithus/v1', '/provinces/city=(?P<idCity>\d+)', array(
           'methods' => 'GET',
           'callback' => array($this, 'getByCity'),
           'args' => array(
               'idCity' => array(
                   'validate_callback' => function($param, $request, $key) {
                       return is_numeric($param);
                   }
               )
           )
        ));
    }

    public function getByCity(\WP_REST_Request $request)
    {
        $city = (int)$request['idCity'];

        $args = array(
            'post_type' => 'provinces',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title',
            'meta_query' => array(
                array(
                    'key' => 'mb_city',
                    'value' => $city
                )
            )
        );

        $provinces = new \WP_Query($args);

        if (!$provinces->have_posts()) {
            return new \WP_Error('no_provinces', 'Invalid city', array('status' => 404));
        }

        $provincesData = array();

        if ($provinces->have_posts()) {
            while ($provinces->have_posts()) {
                $provinces->the_post();

                $provincesData[] = array(
                    'id' => get_the_ID(),
                    'name' => get_the_title(),
                );
            }
        }

        return $provincesData;
    }

}