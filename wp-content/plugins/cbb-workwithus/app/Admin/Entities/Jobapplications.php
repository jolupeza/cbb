<?php

namespace CBB_WorkWithUs\Admin\Entities;

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
        $this->loader->add_action('init', $this, 'addTaxonomiesJobapplications');
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
    
    /**
     * Add custom taxonomies levels to post type jobapplications.
     */
    public function addTaxonomiesJobapplications()
    {
        $labels = array(
            'name' => _x('Niveles', 'Taxonomy plural name', $this->domain),
            'singular_name' => _x('Nivel', 'Taxonomy singular name', $this->domain),
            'search_items' => __('Buscar Nivel', $this->domain),
            'popular_items' => __('Niveles Populares', $this->domain),
            'all_items' => __('Todos los Niveles', $this->domain),
            'parent_item' => __('Nivel Padre', $this->domain),
            'parent_item_colon' => __('Nivel Padre', $this->domain),
            'edit_item' => __('Editar Nivel', $this->domain),
            'update_item' => __('Actualizar Nivel', $this->domain),
            'add_new_item' => __('Añadir nuevo Nivel', $this->domain),
            'new_item_name' => __('Nuevo Nivel', $this->domain),
            'add_or_remove_items' => __('Añadir o eliminar Nivel', $this->domain),
            'choose_from_most_used' => __('Choose from most used text-domain', $this->domain),
            'menu_name' => __('Niveles', $this->domain),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'convocatorias'
            ),
        );

        register_taxonomy('joblevels', 'jobapplications', $args);
    }

}
