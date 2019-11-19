<?php

namespace CBB_WorkWithUs\Admin\Entities;

use CBB_WorkWithUs\Admin\Taxonomies\Joblevel;
use CBB_WorkWithUs\Includes\Loader;

class Jobapplications
{
    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    private $loader;

    protected $domain;

    public function __construct(Loader $loader, $domain)
    {
        $this->loader = $loader;
        $this->domain = $domain;
    }

    public function init()
    {
        $adminJobLevels = new Joblevel($this->loader, $this->domain);
        $adminJobLevels->init();

        $this->loader->add_action('wp_ajax_register_application', $this, 'register');
        $this->loader->add_action('wp_ajax_nopriv_register_application', $this, 'register');
    }

    public function register()
    {
        $nonce = $_POST['nonce'];
        $data = array();

        $result = array(
            'status' => false,
            'msg' => '',
            'error' => ''
        );

        if (!wp_verify_nonce($nonce, 'axios-vuejs')) {
            die('¡Acceso denegado!');
        }

        if (!$this->validData($_POST)) {
            $result['msg'] = 'Por favor verifique que sus datos sean correctos y vuelva a intentarlo.';
            wp_send_json($result);
        }

        $data['name'] = sanitize_text_field($_POST['name']);
        $data['apepaterno'] = sanitize_text_field($_POST['apepaterno']);
        $data['apematerno'] = sanitize_text_field($_POST['apematerno']);
        $data['document'] = sanitize_text_field($_POST['document']);
        $data['gender'] = sanitize_text_field($_POST['gender']);
        $data['birthday'] = sanitize_text_field($_POST['birthday']);
        $data['age'] = (int)sanitize_text_field($_POST['age']);
        $data['phone'] = sanitize_text_field($_POST['phone']);
        $data['mobile'] = sanitize_text_field($_POST['mobile']);
        $data['email'] = sanitize_email($_POST['email']);
        $data['address'] = sanitize_text_field($_POST['address']);
        $data['reference'] = sanitize_text_field($_POST['reference']);
        $data['review'] = sanitize_text_field($_POST['review']);
        $data['level'] = (int)sanitize_text_field($_POST['level']);

        $this->saveApplication($data);

        $result['status'] = true;
        $result['msg'] = 'Postulación agregada correctamente.';

        wp_send_json($result);
    }

    protected function validData($data)
    {
        return !empty($data['name']) && !empty($data['apepaterno']) && !empty($data['apematerno']) && !empty($data['document'])
            && (strlen($data['document']) >= 8 || strlen($data['document']) <= 15) && !empty($data['birthday'])
            && (!empty($data['age']) && ($data['age'] >= 18 || $data['age'] <= 80 ))
            && (!empty($data['email']) && is_email($data['email']))
            && !empty($data['address']);
    }

    protected function saveApplication($data)
    {
        $postId = wp_insert_post(array(
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'jobapplications',
            'post_title' => "{$data['name']} {$data['apepaterno']} {$data['apematerno']}"
        ));

        update_post_meta($postId, 'mb_name', $data['name']);
        update_post_meta($postId, 'mb_ape_paterno', $data['apepaterno']);
        update_post_meta($postId, 'mb_ap_materno', $data['apematerno']);
        update_post_meta($postId, 'mb_document', $data['document']);
        update_post_meta($postId, 'mb_gender', $data['gender']);
        update_post_meta($postId, 'mb_birthday', $data['birthday']);
        update_post_meta($postId, 'mb_age', $data['age']);
        update_post_meta($postId, 'mb_phone', $data['phone']);
        update_post_meta($postId, 'mb_mobile', $data['mobile']);
        update_post_meta($postId, 'mb_email', $data['email']);
        update_post_meta($postId, 'mb_address', $data['address']);
        update_post_meta($postId, 'mb_reference', $data['reference']);
        update_post_meta($postId, 'mb_review', $data['review']);

        wp_set_object_terms($postId, $data['level'], 'joblevels');
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type jobapplications.
     */
    public function cd_mb_contacts_add()
    {
        add_meta_box(
            'mb-contacts-id', 'Datos del Usuario', array($this, 'render_mb_contacts'), 'contacts', 'normal', 'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_contacts()
    {
        require_once plugin_dir_path(__FILE__).'partials/vm-mb-contacts.php';
    }

    public function custom_columns_contacts($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Nombre'),
            'email' => __('Correo electrónico'),
            'subject' => __('Asunto'),
            'date' => __('Fecha'),
        );

        return $columns;
    }

    public function custom_column_contacts($column)
    {
        global $post;

        // Setup some vars
        $edit_link = get_edit_post_link($post->ID);
        $post_type_object = get_post_type_object($post->post_type);
        $can_edit_post = current_user_can('edit_post', $post->ID);
        $values = get_post_custom($post->ID);

        switch ($column) {
            case 'name':
                $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';

                // Display the name
                if (!empty($name)) {
                    if($can_edit_post && $post->post_status != 'trash') {
                        echo '<a class="row-title" href="' . $edit_link . '" title="' . esc_attr(__('Editar este elemento')) . '">' . $name . '</a>';
                    } else {
                        echo $name;
                    }
                }

                // Add admin actions
                $actions = array();
                if ($can_edit_post && 'trash' != $post->post_status) {
                    $actions['edit'] = '<a href="' . get_edit_post_link($post->ID, true) . '" title="' . esc_attr(__( 'Editar este elemento')) . '">' . __('Editar') . '</a>';
                }

                if (current_user_can('delete_post', $post->ID)) {
                    if ('trash' == $post->post_status) {
                        $actions['untrash'] = "<a title='" . esc_attr(__('Restaurar este elemento desde la papelera')) . "' href='" . wp_nonce_url(admin_url(sprintf($post_type_object->_edit_link . '&amp;action=untrash', $post->ID)), 'untrash-post_' . $post->ID) . "'>" . __('Restaurar') . "</a>";
                    } elseif(EMPTY_TRASH_DAYS) {
                        $actions['trash'] = "<a class='submitdelete' title='" . esc_attr(__('Mover este elemento a la papelera')) . "' href='" . get_delete_post_link($post->ID) . "'>" . __('Papelera') . "</a>";
                    }

                    if ('trash' == $post->post_status || !EMPTY_TRASH_DAYS) {
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr(__('Borrar este elemento permanentemente')) . "' href='" . get_delete_post_link($post->ID, '', true) . "'>" . __('Borrar permanentemente') . "</a>";
                    }
                }

                $html = '<div class="row-actions">';
                if (isset($actions['edit'])) {
                    $html .= '<span class="edit">' . $actions['edit'] . ' | </span>';
                }
                if (isset($actions['trash'])) {
                    $html .= '<span class="trash">' . $actions['trash'] . '</span>';
                }
                if (isset($actions['untrash'])) {
                    $html .= '<span class="untrash">' . $actions['untrash'] . ' | </span>';
                }
                if (isset($actions['delete'])) {
                    $html .= '<span class="delete">' . $actions['delete'] . '</span>';
                }
                $html .= '</div>';

                echo $html;
                break;
            case 'email':
                $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
                echo $email;
                break;
            case 'subject':
                $subjects = wp_get_post_terms($post->ID, 'subjects');
                if ($subjects) {
                    $subject = $subjects[0];

                    if ($subject) {
                        echo $subject->name;
                    }
                }

                break;
        }
    }

    public function buttonDownloadExcel($views)
    {
        echo '<p>'
            . '<a href="' . plugin_dir_url(dirname(__FILE__)) . 'contacts/generateExcel"'
            . ' id="generate-excel" class="button button-primary">Generar excel</a>'
            . '</p>';
    }

}
