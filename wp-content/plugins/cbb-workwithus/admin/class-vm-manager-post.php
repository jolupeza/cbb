<?php

namespace VM_Manager\Admin;

class VM_Manager_Post
{
    protected $allowed;
    
    public function __construct()
    {
        $this->allowed = array(
            'p' => array(
                'style' => array(),
            ),
            'a' => array(// on allow a tags
                'href' => array(),
                'target' => array(),
            ),
            'ul' => array(
                'class' => array(),
            ),
            'ol' => array(),
            'li' => array(
                'style' => array(),
            ),
            'strong' => array(),
            'br' => array(),
            'span' => [
                'class' => [],
            ],
            'h1' => [],
            'h2' => [],
            'h3' => [],
            'img' => [
                'alt' => [],
                'class' => [],
                'src' => [],
            ],
        );
    }
    
    public function cd_mb_post_add()
    {
        add_meta_box(
            'mb-post-id',
            'Configuración',
            array($this, 'render_mb_post'),
            'post',
            'normal',
            'core'
        );
    }
    
    public function cd_mb_post_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (empty(filter_input(INPUT_POST, 'meta_box_nonce')) || !wp_verify_nonce(filter_input(INPUT_POST, 'meta_box_nonce'), 'post_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        $data = [
            'mb_more' => [filter_input(INPUT_POST, 'mb_more'), true],
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
    
    public function render_mb_post()
    {
        require_once plugin_dir_path(__FILE__).'partials/vm-mb-post.php';
    }
}
