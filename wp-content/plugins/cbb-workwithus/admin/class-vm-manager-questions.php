<?php

namespace VM_Manager\Admin;

class VM_Manager_Questions
{
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type questions.
     */
    public function cd_mb_questions_add()
    {
        add_meta_box(
            'mb-questions-id', 'Datos de la Pregunta Frecuente', array($this, 'render_mb_questions'), 'questions', 'normal', 'core'
        );
    }
    
    public function cd_mb_questions_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (empty(filter_input(INPUT_POST, 'meta_box_nonce')) || !wp_verify_nonce(filter_input(INPUT_POST, 'meta_box_nonce'), 'questions_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        $data = [
            'mb_page' => filter_input(INPUT_POST, 'mb_page'),
        ];
        
        $this->updateCustomMeta($post_id, $data);
    }
    
    private function updateCustomMeta($postId, $data = array())
    {
        foreach ($data as $meta => $value) {
            if (!empty($value)) {
                update_post_meta($postId, $meta, esc_attr($value));
            } else {
                delete_post_meta($postId, $meta);
            }
        }
    }
    
    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_questions()
    {
        require_once plugin_dir_path(__FILE__).'partials/vm-mb-questions.php';
    }

}
