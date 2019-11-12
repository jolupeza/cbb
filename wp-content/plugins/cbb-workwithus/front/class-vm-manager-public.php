<?php

namespace VM_Manager\Front;

use VM_Manager\Shared\VM_Manager_Deserializer;

/**
 * The VillaMaria Manager Public defines all functionality for the public-facing
 * sides of the plugin.
 */

/**
 * The VillaMaria Manager Public defines all functionality for the public-facing
 * sides of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since    1.0.0
 */
class VM_Manager_Public
{
    /**
     *
     * @var VM_Manager\Shared\VM_Manager_Deserializer
     */
    private $deserializer;

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version, VM_Manager_Deserializer $deserializer)
    {
        $this->version = $version;

        $this->deserializer = $deserializer;

        add_action('wp_ajax_register_contact', array(&$this, 'register_contact_callback'));
        add_action('wp_ajax_nopriv_contact_simulator', array(&$this, 'register_contact_callback'));
    }

    /**
     * Uses the partial located in the admin directory for rendering the
     * post meta data the end of the post content.
     *
     * @param string $content The post content.
     *
     * @return string $content    The post content including the given posts meta data.
     */
    public function display_post_meta_data($content)
    {
        ob_start();

        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/ilc-simulator.php';
        $template = ob_get_contents();
        $content .= $template;

        ob_end_clean();

        return $content;
    }

    public function register_contact_callback()
    {
        $nonce = $_POST['nonce'];
        $data = [];
        $result = [
            'result' => false,
            'msg' => '',
            'content' => ''
        ];

        if ( !wp_verify_nonce( $nonce, 'villamariaajax-nonce') ) {
            die( 'Acceso denegado' );
        }

        if ( ! $this->validateData($_POST) ) {
            $result['msg'] = 'Por favor verifique que ha completado correctamente los datos solicitados y vuelva a intentarlo.';

            echo json_encode($result); die();
        }

        $data['name']  = sanitize_text_field($_POST['name']);
        $data['email'] = sanitize_email($_POST['email']);
        $data['phone'] = sanitize_text_field($_POST['phone']);
        $data['message'] = sanitize_textarea_field($_POST['message']);
        $data['subject'] = (int) sanitize_text_field($_POST['subject']);

        if ( ! $this->getDataSubject($data['subject']) ) {
            $result['msg'] = 'No ha seleccionado el asunto. Por favor vuelva a intentarlo.';

            echo json_encode($result); die();
        }

        $this->saveContact($data);

        $this->sendEmailContact($data);

        $this->sendEmailContactAdmin($data);

        $result['result'] = true;
        $result['msg'] = 'Hemos registrado correctamente su consulta. En breve un asesor se contactará con usted para resolver su consulta.';

        $path = plugin_dir_path(__FILE__) . 'partials/contact-finish.php';

        if (file_exists($path)) {
            $responseContact = $this->deserializer->get_value('email-response');

            ob_start();
            include $path;
            $content = ob_get_contents();
            ob_get_clean();

            $result['content'] = $content;
        }

        echo json_encode($result); die();
    }

    private function validateData($data)
    {
        return !empty($data['name'])
                && !empty($data['email']) && is_email($data['email'])
                && !empty($data['phone']) && preg_match('/^[0-9]+$/', $data['phone'])
                && (strlen($data['phone']) > 6 || strlen($data['phone']) < 10)
                && !empty($data['message'])
                && (int) $data['subject'] > 0;
    }

    private function getDataSubject($subject)
    {
        return get_term_by('id', $subject, 'subjects');
    }

    private function saveContact($data)
    {
        $contact_id = wp_insert_post([
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'contacts'
        ]);

        add_post_meta($contact_id, 'mb_name', $data['name']);
        add_post_meta($contact_id, 'mb_email', $data['email']);
        add_post_meta($contact_id, 'mb_phone', $data['phone']);
        add_post_meta($contact_id, 'mb_message', $data['message']);

        wp_set_object_terms($contact_id, $data['subject'], 'subjects');
    }

    private function sendEmailContact($data)
    {
        if (file_exists(plugin_dir_path(__FILE__) . 'templates/template-email-contact.php')) {
            $emailResponse = $this->deserializer->get_value('email-response');

            ob_start();

            include plugin_dir_path(__FILE__) . 'templates/template-email-contact.php';

            $content = ob_get_contents();

            ob_get_clean();

            $headers[] = "From: Colegio Villa María Miraflores";
            // $headers[] = "Reply-To: $email";
            $headers[] = "Content-type: text/html; charset=utf-8";
            $subjectEmail = $this->deserializer->get_value('subject-email');

            wp_mail($data['email'], $subjectEmail, $content, $headers);
        }
    }

    private function sendEmailContactAdmin($data)
    {
        if (file_exists(plugin_dir_path(__FILE__) . 'templates/template-email-contactAdmin.php')) {
            $receiverEmail = $this->getAdminEmail();

            $subjectName = $this->getDataSubject($data['subject'])->name;

            ob_start();

            include plugin_dir_path(__FILE__) . 'templates/template-email-contactAdmin.php';

            $content = ob_get_contents();

            ob_get_clean();

            $headers[] = "From: Colegio Villa María Miraflores";
            // $headers[] = "Reply-To: $email";
            $headers[] = "Content-type: text/html; charset=utf-8";
            $subjectEmail = $this->deserializer->get_value('subject-email');

            wp_mail($receiverEmail, $subjectEmail, $content, $headers);
        }
    }

    private function getAdminEmail()
    {
        $receiverEmail = $this->deserializer->get_value('admin-email');

        //If none is specified, get the WP admin email
        if (!isset($receiverEmail) || empty($receiverEmail)) {
            $receiverEmail = get_option('admin_email');
        }

        return $receiverEmail;
    }
}
