<?php

namespace CBB_WorkWithUs\Admin\Entities;

use CBB_WorkWithUs\Admin\Exports\JobApplication;
use CBB_WorkWithUs\Admin\Taxonomies\Joblevel;
use CBB_WorkWithUs\Admin\Taxonomies\JobLocal;
use CBB_WorkWithUs\Admin\Taxonomies\JobSpeciality;
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

    protected $typesImage = array('image/png', 'image/jpeg', 'image/gif');

    protected $typesCv = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf');

    protected $uploadDir;

    protected $postType;

    public function __construct(Loader $loader, $domain)
    {
        $this->loader = $loader;
        $this->domain = $domain;
        $this->uploadDir = wp_upload_dir();
        $this->postType = 'jobapplications';
    }

    public function init()
    {
        $adminJobLevels = new Joblevel($this->loader, $this->domain);
        $adminJobLevels->init();

        $adminJobSpeciality = new JobSpeciality($this->loader, $this->domain);
        $adminJobSpeciality->init();

        $adminJobLocal = new JobLocal($this->loader, $this->domain);
        $adminJobLocal->init();

        $this->loader->add_action('add_meta_boxes', $this, 'cdMbJobapplicationsAdd');
        $this->loader->add_filter('views_edit-jobapplications', $this, 'displayButtonDownloadApplications');
        $this->loader->add_action('admin_init', $this, 'exportJobApplications');

        $this->loader->add_action('wp_ajax_register_application', $this, 'register');
        $this->loader->add_action('wp_ajax_nopriv_register_application', $this, 'register');

        $this->loader->add_action('pre_get_posts', $this, 'extendAdminSearch');
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

        $data['photo'] = $_FILES['photo'];
        if (!$this->checkPhoto($data['photo'])) {
            $result['msg'] = 'La imagen de su foto no es válida. Por favor vuelva a cargarla.';
            wp_send_json($result);
        }

        $data['cv'] = isset($_FILES['cv']) ? $_FILES['cv'] : null;

        if (!$this->checkCv($data['cv'])) {
            $result['msg'] = 'Su cv no es válido. Por favor vuelva a cargarla.';
            wp_send_json($result);
        }

        if (!empty($this->uploadDir['basedir'])) {
            if (!file_exists("{$this->uploadDir['basedir']}/postulantes")) {
                wp_mkdir_p($this->uploadDir['basedir'] . '/postulantes');
            }
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
        $data['city'] = sanitize_text_field($_POST['city']);
        $data['province'] = sanitize_text_field($_POST['province']);
        $data['district'] = sanitize_text_field($_POST['district']);
        $data['address'] = sanitize_text_field($_POST['address']);
        $data['reference'] = sanitize_text_field($_POST['reference']);
        $data['levelEducation'] = !empty($_POST['levelEducation']) ? sanitize_text_field($_POST['levelEducation']) : null;
        $data['local'] = (int)sanitize_text_field($_POST['local']);
        $data['speciality'] = (int)sanitize_text_field($_POST['speciality']);
        $data['level'] = (int)sanitize_text_field($_POST['level']);
        $data['studies'] = json_decode(stripslashes($_POST['studies']));
        $data['experiences'] = json_decode(stripslashes($_POST['experiences']));

        if (!$this->validData($data)) {
            $result['msg'] = 'Por favor verifique que sus datos sean correctos y vuelva a intentarlo.';
            wp_send_json($result);
        }

        $this->saveApplication($data);

        $options = get_option('cbb_custom_settings');

        $result['status'] = true;
        $result['msg'] = $options['response_workwithus_forms'];

        wp_send_json($result);
    }

    protected function validData($data)
    {
        return !empty($data['name']) && !empty($data['apepaterno']) && !empty($data['apematerno']) && !empty($data['document'])
            && (strlen($data['document']) >= 8 || strlen($data['document']) <= 15) && !empty($data['birthday'])
            && (!empty($data['age']) && ($data['age'] >= 18 || $data['age'] <= 80 ))
            && (!empty($data['email']) && is_email($data['email']))
            && !empty($data['city']) && !empty($data['province']) && !empty($data['district'])
            && !empty($data['address'])
            && count($data['studies']) > 0 && count($data['experiences']) > 0;
    }

    protected function checkPhoto($photo)
    {
        return !empty($photo) && in_array($photo['type'], $this->typesImage) && $photo['size'] <= 2097152;
    }

    protected function checkCv($cv)
    {
        return !is_null($cv) ? in_array($cv['type'], $this->typesCv) && $cv['size'] <= 3145728 : true;
    }

    protected function saveApplication($data)
    {
        $postId = wp_insert_post(array(
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'jobapplications',
            'post_title' => "{$data['name']} {$data['apepaterno']} {$data['apematerno']} - {$data['email']}"
        ));

        $ext = explode('.', $data['photo']['name']);
        $ext = $ext[count($ext) - 1];
        $namePhoto = "{$data['document']}-{$postId}.{$ext}";

        if ($this->uploadPhoto($namePhoto, $data['photo'])) {
            add_post_meta($postId, 'mb_photo', "{$this->uploadDir['baseurl']}/postulantes/{$namePhoto}");
        }

        $ext = explode('.', $data['cv']['name']);
        $ext = $ext[count($ext) - 1];
        $nameCv = "{$data['document']}-{$postId}.{$ext}";

        if ($this->uploadCv($nameCv, $data['cv'])) {
            add_post_meta($postId, 'mb_cv', "{$this->uploadDir['baseurl']}/postulantes/{$nameCv}");
        }

        add_post_meta($postId, 'mb_name', $data['name']);
        add_post_meta($postId, 'mb_ape_paterno', $data['apepaterno']);
        add_post_meta($postId, 'mb_ape_materno', $data['apematerno']);
        add_post_meta($postId, 'mb_document', $data['document']);
        add_post_meta($postId, 'mb_gender', $data['gender']);
        add_post_meta($postId, 'mb_birthday', $data['birthday']);
        add_post_meta($postId, 'mb_age', $data['age']);
        add_post_meta($postId, 'mb_phone', $data['phone']);
        add_post_meta($postId, 'mb_mobile', $data['mobile']);
        add_post_meta($postId, 'mb_email', $data['email']);
        add_post_meta($postId, 'mb_city', $data['city']);
        add_post_meta($postId, 'mb_province', $data['province']);
        add_post_meta($postId, 'mb_district', $data['district']);
        add_post_meta($postId, 'mb_address', $data['address']);
        if (!is_null($data['levelEducation'])) {
            add_post_meta($postId, 'mb_level_education', $data['levelEducation']);
        }
        add_post_meta($postId, 'mb_reference', $data['reference']);
        add_post_meta($postId, 'mb_studies', $data['studies']);
        add_post_meta($postId, 'mb_experiences', $data['experiences']);

        wp_set_object_terms($postId, $data['level'], 'joblevels');
        wp_set_object_terms($postId, $data['speciality'], 'job_specialities');
        wp_set_object_terms($postId, $data['local'], 'job_locals');
    }

    protected function uploadPhoto($namePhoto, $photo)
    {
        $filePhoto = "{$this->uploadDir['basedir']}/postulantes/{$namePhoto}";

        return move_uploaded_file($photo['tmp_name'], $filePhoto);
    }

    protected function uploadCv($nameCv, $cv)
    {
        $fileCv = "{$this->uploadDir['basedir']}/postulantes/{$nameCv}";

        return move_uploaded_file($cv['tmp_name'], $fileCv);
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type jobapplications.
     */
    public function cdMbJobapplicationsAdd()
    {
        add_meta_box(
            'mb-job-applications-id',
            'Datos del Postulante',
            array($this, 'renderMbJobApplications'),
            'jobapplications',
            'normal',
            'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function renderMbJobApplications()
    {
        require_once plugin_dir_path(__FILE__).'partials/cbb-mb-job-applications.php';
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

    public function displayButtonDownloadApplications($views)
    {
        echo '<form action="#" method="POST">'
            . '<input type="hidden" id="jobapplications_export_excel" name="jobapplications_export_excel" value="1" />'
            . '<input class="button button-primary user_export_button" style="margin-top:3px;" type="submit" value="Exportar a Excel" />'
            .'</form>';

        return $views;
    }

    public function exportJobApplications()
    {
        if (!empty($_POST['jobapplications_export_excel'])) {
            $exportJobApplications = new JobApplication();

            $exportJobApplications->generateExcel();
        }
    }

    public function extendAdminSearch($query)
    {
        $customFields = array(
            'mb_name',
            'mb_ape_paterno',
            'mb_ape_materno',
            'mb_document',
        );

        if ( ! is_admin() ) {
            return;
        }

        if ( $query->query['post_type'] !== $this->postType ) {
            return;
        }

        $search_term = $query->query_vars['s'];

        // Set to empty, otherwise it won't find anything
        $query->query_vars['s'] = '';

        if ( $search_term != '' ) {
            $meta_query = array( 'relation' => 'OR' );

            foreach( $customFields as $customField ) {
                array_push( $meta_query, array(
                    'key' => $customField,
                    'value' => $search_term,
                    'compare' => 'LIKE'
                ));
            }

            $query->set( 'meta_query', $meta_query );
        }
    }

}
