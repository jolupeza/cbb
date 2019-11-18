<?php


namespace CBB_WorkWithUs\Admin\Entities;


use CBB_WorkWithUs\Includes\Loader;

class District
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
        $this->loader->add_action('add_meta_boxes', $this, 'cd_mb_districts_add');
        $this->loader->add_action('save_post', $this, 'cb_mb_districts_save');
        $this->loader->add_action('rest_api_init', $this, 'registerRestRouteByProvince');
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type districts.
     */
    public function cd_mb_districts_add()
    {
        add_meta_box(
            'mb-districts-id', 'Opciones', array($this, 'render_mb_districts'), 'districts', 'normal', 'core'
        );
    }

    public function cb_mb_districts_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'districts_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $data = array(
            'mb_province' => $_POST['mb_province']
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
    public function render_mb_districts()
    {
        require_once plugin_dir_path(__FILE__).'partials/cbb-mb-districts.php';
    }

    public function registerRestRouteByProvince()
    {
        register_rest_route('workwithus/v1', '/districts/province=(?P<idProvince>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'getByProvince'),
            'args' => array(
                'idProvince' => array(
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric($param);
                    }
                )
            )
        ));
    }

    public function getByProvince(\WP_REST_Request $request)
    {
        $province = (int)$request['idProvince'];

        $args = array(
            'post_type' => 'districts',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title',
            'meta_query' => array(
                array(
                    'key' => 'mb_province',
                    'value' => $province
                )
            )
        );

        $districts = new \WP_Query($args);

        if (!$districts->have_posts()) {
            return new \WP_Error('no_districts', 'Invalid province', array('status' => 404));
        }

        $districtsData = array();

        if ($districts->have_posts()) {
            while ($districts->have_posts()) {
                $districts->the_post();

                $districtsData[] = array(
                    'id' => get_the_ID(),
                    'name' => get_the_title(),
                );
            }
        }

        return $districtsData;
    }
}
