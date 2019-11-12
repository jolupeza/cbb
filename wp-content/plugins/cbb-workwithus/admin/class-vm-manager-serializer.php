<?php

namespace VM_Manager\Admin;

/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * @package VM_Manager
 */

/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * This will also check the specified nonce and verify that the current user has
 * permission to save the data.
 *
 * @package VM_Manager
 */
class VM_Manager_Serializer
{
    /**
     * Labels indicate allowed in custom fields.
     *
     * @var array
     */
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
        );
    }

    public function init()
    {
        add_action( 'admin_post', array( $this, 'save' ) );
    }

    public function save()
    {
        // First, validate the nonce and verify the user as permission to save.
        if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
            // TODO: Display an error message.
        }

        if ( null !== wp_unslash( $_POST['email-response'] )) {
            $value = sanitize_textarea_field($_POST['email-response']);
            update_option('email-response', $value);
        }

        // If the above are valid, sanitize and save the option.
        if ( null !== wp_unslash( $_POST['admin-email'] ) ) {
            $value = sanitize_text_field( $_POST['admin-email'] );
            update_option('admin-email', $value);
        }

        if ( null !== wp_unslash( $_POST['subject-email'] )) {
            $value = sanitize_textarea_field($_POST['subject-email']);
            update_option('subject-email', $value);
        }

//        if ( null !== wp_unslash($_POST['page-about'])) {
//            $pageId = sanitize_text_field($_POST['page-about']);
//            update_option('page-about', $pageId);
//        }

//        if ( null !== wp_unslash($_POST['project-current'])) {
//            $projectId = sanitize_text_field($_POST['project-current']);
//            update_option('project-current', $projectId);
//        }

//        if ( null !== wp_unslash($_POST['project-current-title'])) {
//            $projectCurrentTitle = wp_kses($_POST['project-current-title'], $this->allowed);
//
//            update_option('project-current-title', $projectCurrentTitle);
//        }

        $this->redirect();
    }

    /**
     * Determines if the nonce variable associated with the options page is set
     * and is valid.
     *
     * @access private
     *
     * @return boolean False if the field isn't set or the nonce value is invalid;
     *                       otherwise, true.
     */
    private function has_valid_nonce()
    {
        // If the field isn't even in the $_POST, then it's invalid.
        if ( ! isset( $_POST['vm-manager-custom-message'] ) ) { // Input var okay.
            return false;
        }

        $field  = wp_unslash( $_POST['vm-manager-custom-message'] );
        $action = 'vm-manager-settings-save';

        return wp_verify_nonce( $field, $action );
    }

    /**
     * Redirect to the page from which we came (which should always be the
     * admin page. If the referred isn't set, then we redirect the user to
     * the login page.
     *
     * @access private
     */
    private function redirect()
    {
        // To make the Coding Standards happy, we have to initialize this.
        if (!isset($_POST['_wp_http_referer'])) { // Input var okay.
            $_POST['_wp_http_referer'] = wp_login_url();
        }

        // Sanitize the value of the $_POST collection for the Coding Standards.
        $url = sanitize_text_field(
            wp_unslash($_POST['_wp_http_referer']) // Input var okay.
        );

        // Finally, redirect back to the admin page.
        wp_safe_redirect(urldecode($url));
        exit;
    }

}