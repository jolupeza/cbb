<?php

/**
 * The CBB Manager Admin defines all functionality for the dashboard
 * of the plugin.
 */

/**
 * The CBB Manager Admin defines all functionality for the dashboard
 * of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since    1.0.0
 */
class Cbb_Manager_Admin
{
    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Labels indicate allowed in custom fields.
     *
     * @var array
     */
    private $allowed;

    private $domain;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version)
    {
        $this->version = $version;
        $this->allowed = array(
            'h2' => array(
              'style' => array(),
            ),
            'h4' => array(
              'style' => array(),
            ),
            'h5' => array(
              'style' => array(),
            ),
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
            'span' => array(),
        );

        $this->domain = 'cbb-framework';
//        add_action('wp_ajax_generate_pdf', array(&$this, 'generate_pdf'));
//        add_action('wp_ajax_download_cv', array(&$this, 'download_cv'));
    }

    /**
     * Enqueues the style sheet responsible for styling the contents of this
     * meta box.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'cbb-manager-admin',
            plugin_dir_url(__FILE__).'css/cbb-manager-admin.css',
            array(),
            $this->version,
            false
        );
    }

    /**
     * Enqueues the scripts responsible for functionality.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'cbb-manager-admin',
            plugin_dir_url(__FILE__).'js/cbb-manager-admin.js',
            array('jquery'),
            $this->version,
            true
        );
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type sliders.
     */
    public function cd_mb_sliders_add()
    {
        add_meta_box(
            'mb-sliders-id', 'Configuraciones', array($this, 'render_mb_sliders'), 'sliders', 'normal', 'core'
        );
    }

    public function cd_mb_sliders_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'sliders_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Title
        if (isset($_POST['mb_title']) && !empty($_POST['mb_title'])) {
            update_post_meta($post_id, 'mb_title', esc_attr($_POST['mb_title']));
        } else {
            delete_post_meta($post_id, 'mb_title');
        }
        
        // SubTitle
        if (isset($_POST['mb_subtitle']) && !empty($_POST['mb_subtitle'])) {
            update_post_meta($post_id, 'mb_subtitle', esc_attr($_POST['mb_subtitle']));
        } else {
            delete_post_meta($post_id, 'mb_subtitle');
        }

        // Text Link
        if (isset($_POST['mb_text']) && !empty($_POST['mb_text'])) {
            update_post_meta($post_id, 'mb_text', esc_attr($_POST['mb_text']));
        } else {
            delete_post_meta($post_id, 'mb_text');
        }

        // URL
        if (isset($_POST['mb_url']) && !empty($_POST['mb_url'])) {
            update_post_meta($post_id, 'mb_url', esc_attr($_POST['mb_url']));
        } else {
            delete_post_meta($post_id, 'mb_url');
        }

        // Target
        $target = isset($_POST['mb_target']) && $_POST['mb_target'] ? 'on' : 'off';
        update_post_meta($post_id, 'mb_target', $target);

        // Carrera
        /*if (isset($_POST['mb_carrera']) && !empty($_POST['mb_carrera'])) {
            update_post_meta($post_id, 'mb_carrera', esc_attr($_POST['mb_carrera']));
        } else {
            delete_post_meta($post_id, 'mb_carrera');
        }

        // Image Responsive
        if (isset($_POST['mb_responsive']) && !empty($_POST['mb_responsive'])) {
            update_post_meta($post_id, 'mb_responsive', esc_attr($_POST['mb_responsive']));
        } else {
            delete_post_meta($post_id, 'mb_responsive');
        }*/
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_sliders()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/cbb-mb-sliders.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type sliders.
     */
    public function cd_mb_partners_add()
    {
        add_meta_box(
            'mb-partners-id', 'Configuraciones', array($this, 'render_mb_partners'), 'partners', 'normal', 'core'
        );
    }

    public function cd_mb_partners_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'partners_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // URL
        if (isset($_POST['mb_url']) && !empty($_POST['mb_url'])) {
            update_post_meta($post_id, 'mb_url', esc_attr($_POST['mb_url']));
        } else {
            delete_post_meta($post_id, 'mb_url');
        }

        // Target
        $target = isset($_POST['mb_target']) && $_POST['mb_target'] ? 'on' : 'off';
        update_post_meta($post_id, 'mb_target', $target);
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_partners()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/cbb-mb-partners.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type locals.
     */
    public function cd_mb_locals_add()
    {
        add_meta_box(
            'mb-locals-id', 'Configuraciones', array($this, 'render_mb_locals'), 'locals', 'normal', 'core'
        );
    }

    public function cd_mb_locals_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'locals_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Address
        if (isset($_POST['mb_address']) && !empty($_POST['mb_address'])) {
            update_post_meta($post_id, 'mb_address', esc_attr($_POST['mb_address']));
        } else {
            delete_post_meta($post_id, 'mb_address');
        }

        // Phone
        if (isset($_POST['mb_phone']) && !empty($_POST['mb_phone'])) {
            update_post_meta($post_id, 'mb_phone', esc_attr($_POST['mb_phone']));
        } else {
            delete_post_meta($post_id, 'mb_phone');
        }
        
        // Latitud
        if (isset($_POST['mb_lat']) && !empty($_POST['mb_lat'])) {
            update_post_meta($post_id, 'mb_lat', esc_attr($_POST['mb_lat']));
        } else {
            delete_post_meta($post_id, 'mb_lat');
        }
        
        // Longitud
        if (isset($_POST['mb_long']) && !empty($_POST['mb_long'])) {
            update_post_meta($post_id, 'mb_long', esc_attr($_POST['mb_long']));
        } else {
            delete_post_meta($post_id, 'mb_long');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_locals()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/cbb-mb-locals.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type parallaxs.
     */
    public function cd_mb_parallaxs_add()
    {
        add_meta_box(
            'mb-parallaxs-id', 'Configuraciones', array($this, 'render_mb_parallaxs'), 'parallaxs', 'normal', 'core'
        );
    }

    public function cd_mb_parallaxs_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'parallaxs_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // title
        if (isset($_POST['mb_title']) && !empty($_POST['mb_title'])) {
            update_post_meta($post_id, 'mb_title', esc_attr($_POST['mb_title']));
        } else {
            delete_post_meta($post_id, 'mb_title');
        }

        // legend
        if (isset($_POST['mb_legend']) && !empty($_POST['mb_legend'])) {
            update_post_meta($post_id, 'mb_legend', esc_attr($_POST['mb_legend']));
        } else {
            delete_post_meta($post_id, 'mb_legend');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_parallaxs()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/cbb-mb-parallaxs.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type page.
     */
    public function cd_mb_pages_add()
    {
        add_meta_box(
            'mb-pages-id',
            'Configuraciones',
            array($this, 'render_mb_pages'),
            'page',
            'normal',
            'core'
        );
    }

    public function cd_mb_pages_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'pages_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Template
        if (isset($_POST['mb_template']) && !empty($_POST['mb_template'])) {
            update_post_meta($post_id, 'mb_template', esc_attr($_POST['mb_template']));
        } else {
            delete_post_meta($post_id, 'mb_template');
        }

        // Parallax
        if (isset($_POST['mb_parallax']) && !empty($_POST['mb_parallax'])) {
            update_post_meta($post_id, 'mb_parallax', esc_attr($_POST['mb_parallax']));
        } else {
            delete_post_meta($post_id, 'mb_parallax');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_pages()
    {
        require_once plugin_dir_path(__FILE__).'partials/cbb-mb-pages.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type achievements.
     */
    public function cd_mb_achievements_add()
    {
        add_meta_box(
            'mb-achievements-id', 'Configuraciones', array($this, 'render_mb_achievements'), 'achievements', 'normal', 'core'
        );
    }

    public function cd_mb_achievements_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'achievements_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // URL
        if (isset($_POST['mb_url']) && !empty($_POST['mb_url'])) {
            update_post_meta($post_id, 'mb_url', esc_attr($_POST['mb_url']));
        } else {
            delete_post_meta($post_id, 'mb_url');
        }

        // Target
        $target = isset($_POST['mb_target']) && $_POST['mb_target'] ? 'on' : 'off';
        update_post_meta($post_id, 'mb_target', $target);
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_achievements()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/cbb-mb-achievements.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type contacts.
     */
    public function cd_mb_contacts_add()
    {
        add_meta_box(
            'mb-contacts-id',
            'Datos del Contacto',
            array($this, 'render_mb_contacts'),
            'contacts',
            'normal',
            'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_contacts()
    {
        require_once plugin_dir_path(__FILE__).'partials/cbb-mb-contacts.php';
    }

    public function custom_columns_contacts($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Nombre'),
            'email' => __('Correo electrónico'),
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
        }
    }

    public function contacts_button_view_edit($views)
    {
        echo '<p>'
        . '<a href="' . plugin_dir_url(dirname(__FILE__)) . 'contacts/generateExcel" class="button button-primary">Generar excel</a>'
        . '</p>';

        return $views;
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type prestudents.
     */
    public function cd_mb_prestudents_add()
    {
        add_meta_box(
            'mb-prestudents-id',
            'Datos del Alumno',
            array($this, 'render_mb_prestudents'),
            'prestudents',
            'normal',
            'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_prestudents()
    {
        require_once plugin_dir_path(__FILE__).'partials/cbb-mb-prestudents.php';
    }

    public function custom_columns_prestudents($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Nombre'),
            'email' => __('Correo electrónico'),
            'date' => __('Fecha'),
        );

        return $columns;
    }
    
    public function custom_column_prestudents($column)
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
        }
    }

    /**
     * Add custom content type slides.
     */
    public function add_post_type()
    {
        $labels = array(
            'name'               => __('Sliders', $this->domain),
            'singular_name'      => __('Slider', $this->domain),
            'add_new'            => __('Nuevo slider', $this->domain),
            'add_new_item'       => __('Agregar nuevo slider', $this->domain),
            'edit_item'          => __('Editar slider', $this->domain),
            'new_item'           => __('Nuevo slider', $this->domain),
            'view_item'          => __('Ver slider', $this->domain),
            'search_items'       => __('Buscar slider', $this->domain),
            'not_found'          => __('Slider no encontrado', $this->domain),
            'not_found_in_trash' => __('Slider no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los sliders', $this->domain),
//            'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
//            'attributes' - Label for the attributes meta box. Default is 'Post Attributes' / 'Page Attributes'. 
//            'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
//            'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
//            'featured_image' - Default is Featured Image.
//            'set_featured_image' - Default is Set featured image.
//            'remove_featured_image' - Default is Remove featured image.
//            'use_featured_image' - Default is Use as featured image.
//            'menu_name' - Default is the same as `name`.
//            'filter_items_list' - String for the table views hidden heading.
//            'items_list_navigation' - String for the table pagination hidden heading.
//            'items_list' - String for the table hidden heading.
//            'name_admin_bar' - String for use in New in Admin menu bar. Default is the same as `singular_name`. 
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Sliders visibles en el homepage',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-images-alt2',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
             'rewrite'     => false
        );
        register_post_type('sliders', $args);
        
        $labels = array(
            'name'               => __('Asociados', $this->domain),
            'singular_name'      => __('Asociado', $this->domain),
            'add_new'            => __('Nuevo asociado', $this->domain),
            'add_new_item'       => __('Agregar nuevo asociado', $this->domain),
            'edit_item'          => __('Editar asociado', $this->domain),
            'new_item'           => __('Nuevo asociado', $this->domain),
            'view_item'          => __('Ver asociado', $this->domain),
            'search_items'       => __('Buscar asociado', $this->domain),
            'not_found'          => __('Asociado no encontrado', $this->domain),
            'not_found_in_trash' => __('Asociado no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los asociados', $this->domain),
//            'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
//            'attributes' - Label for the attributes meta box. Default is 'Post Attributes' / 'Page Attributes'. 
//            'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
//            'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
//            'featured_image' - Default is Featured Image.
//            'set_featured_image' - Default is Set featured image.
//            'remove_featured_image' - Default is Remove featured image.
//            'use_featured_image' - Default is Use as featured image.
//            'menu_name' - Default is the same as `name`.
//            'filter_items_list' - String for the table views hidden heading.
//            'items_list_navigation' - String for the table pagination hidden heading.
//            'items_list' - String for the table hidden heading.
//            'name_admin_bar' - String for use in New in Admin menu bar. Default is the same as `singular_name`. 
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Instituciones Asociadas',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-groups',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
//                'editor',
                'custom-fields',
                'author',
                'thumbnail',
//                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
             'rewrite'     => false
        );
        register_post_type('partners', $args);
        
        $labels = array(
            'name'               => __('Infraestructura', $this->domain),
            'singular_name'      => __('Sede', $this->domain),
            'add_new'            => __('Nueva sede', $this->domain),
            'add_new_item'       => __('Agregar nueva sede', $this->domain),
            'edit_item'          => __('Editar sede', $this->domain),
            'new_item'           => __('Nueva sede', $this->domain),
            'view_item'          => __('Ver sede', $this->domain),
            'search_items'       => __('Buscar sede', $this->domain),
            'not_found'          => __('Sede no encontrada', $this->domain),
            'not_found_in_trash' => __('Sede no encontrada en la papelera', $this->domain),
            'all_items'          => __('Todas las sedes', $this->domain),
//            'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
//            'attributes' - Label for the attributes meta box. Default is 'Post Attributes' / 'Page Attributes'. 
//            'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
//            'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
//            'featured_image' - Default is Featured Image.
//            'set_featured_image' - Default is Set featured image.
//            'remove_featured_image' - Default is Remove featured image.
//            'use_featured_image' - Default is Use as featured image.
//            'menu_name' - Default is the same as `name`.
//            'filter_items_list' - String for the table views hidden heading.
//            'items_list_navigation' - String for the table pagination hidden heading.
//            'items_list' - String for the table hidden heading.
//            'name_admin_bar' - String for use in New in Admin menu bar. Default is the same as `singular_name`. 
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Nuestras Sedes',
            'public' => true,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-networking',
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
             'has_archive' => true,
             'rewrite'     => [
                 'slug' => 'infraestructura'
             ]
        );
        register_post_type('locals', $args);
        
        $labels = array(
            'name'               => __('Parallaxs', $this->domain),
            'singular_name'      => __('Parallax', $this->domain),
            'add_new'            => __('Nuevo parallax', $this->domain),
            'add_new_item'       => __('Agregar nuevo parallax', $this->domain),
            'edit_item'          => __('Editar parallax', $this->domain),
            'new_item'           => __('Nuevo parallax', $this->domain),
            'view_item'          => __('Ver parallax', $this->domain),
            'search_items'       => __('Buscar parallax', $this->domain),
            'not_found'          => __('Parallax no encontrado', $this->domain),
            'not_found_in_trash' => __('Parallax no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los parallaxs', $this->domain),
//            'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
//            'attributes' - Label for the attributes meta box. Default is 'Post Attributes' / 'Page Attributes'. 
//            'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
//            'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
//            'featured_image' - Default is Featured Image.
//            'set_featured_image' - Default is Set featured image.
//            'remove_featured_image' - Default is Remove featured image.
//            'use_featured_image' - Default is Use as featured image.
//            'menu_name' - Default is the same as `name`.
//            'filter_items_list' - String for the table views hidden heading.
//            'items_list_navigation' - String for the table pagination hidden heading.
//            'items_list' - String for the table hidden heading.
//            'name_admin_bar' - String for use in New in Admin menu bar. Default is the same as `singular_name`. 
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Todos los Parallaxs',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-format-image',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
                'thumbnail',
//                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
             'rewrite'     => false
        );
        register_post_type('parallaxs', $args);
        
        $labels = array(
            'name'               => __('Logros', $this->domain),
            'singular_name'      => __('Logro', $this->domain),
            'add_new'            => __('Nuevo logro', $this->domain),
            'add_new_item'       => __('Agregar nuevo logro', $this->domain),
            'edit_item'          => __('Editar logro', $this->domain),
            'new_item'           => __('Nuevo logro', $this->domain),
            'view_item'          => __('Ver logro', $this->domain),
            'search_items'       => __('Buscar logro', $this->domain),
            'not_found'          => __('Logro no encontrado', $this->domain),
            'not_found_in_trash' => __('Logro no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los logros', $this->domain),
//            'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
//            'attributes' - Label for the attributes meta box. Default is 'Post Attributes' / 'Page Attributes'. 
//            'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
//            'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
//            'featured_image' - Default is Featured Image.
//            'set_featured_image' - Default is Set featured image.
//            'remove_featured_image' - Default is Remove featured image.
//            'use_featured_image' - Default is Use as featured image.
//            'menu_name' - Default is the same as `name`.
//            'filter_items_list' - String for the table views hidden heading.
//            'items_list_navigation' - String for the table pagination hidden heading.
//            'items_list' - String for the table hidden heading.
//            'name_admin_bar' - String for use in New in Admin menu bar. Default is the same as `singular_name`. 
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Nuestros logros',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-thumbs-up',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
//                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
             'rewrite'     => false
        );
        register_post_type('achievements', $args);
        
        $labels = array(
            'name'               => __('Plantillas', $this->domain),
            'singular_name'      => __('Plantilla', $this->domain),
            'add_new'            => __('Nueva plantilla', $this->domain),
            'add_new_item'       => __('Agregar nueva plantilla', $this->domain),
            'edit_item'          => __('Editar plantilla', $this->domain),
            'new_item'           => __('Nuevo plantilla', $this->domain),
            'view_item'          => __('Ver plantilla', $this->domain),
            'search_items'       => __('Buscar plantilla', $this->domain),
            'not_found'          => __('Plantilla no encontrada', $this->domain),
            'not_found_in_trash' => __('Plantilla no encontrada en la papelera', $this->domain),
            'all_items'          => __('Todas las plantillas', $this->domain),
//            'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
//            'attributes' - Label for the attributes meta box. Default is 'Post Attributes' / 'Page Attributes'. 
//            'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
//            'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
//            'featured_image' - Default is Featured Image.
//            'set_featured_image' - Default is Set featured image.
//            'remove_featured_image' - Default is Remove featured image.
//            'use_featured_image' - Default is Use as featured image.
//            'menu_name' - Default is the same as `name`.
//            'filter_items_list' - String for the table views hidden heading.
//            'items_list_navigation' - String for the table pagination hidden heading.
//            'items_list' - String for the table hidden heading.
//            'name_admin_bar' - String for use in New in Admin menu bar. Default is the same as `singular_name`. 
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de Plantillas',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-welcome-widgets-menus',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
//                'editor',
//                'custom-fields',
                'author',
//                'thumbnail',
//                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
             'rewrite'     => false
        );
        register_post_type('templates', $args);
        
        $labels = array(
            'name'               => __('Contactos', $this->domain),
            'singular_name'      => __('Contacto', $this->domain),
            'add_new'            => __('Nuevo contacto', $this->domain),
            'add_new_item'       => __('Agregar nuevo contacto', $this->domain),
            'edit_item'          => __('Editar contacto', $this->domain),
            'new_item'           => __('Nuevo contacto', $this->domain),
            'view_item'          => __('Ver contacto', $this->domain),
            'search_items'       => __('Buscar contacto', $this->domain),
            'not_found'          => __('Contacto no encontrado', $this->domain),
            'not_found_in_trash' => __('Contactp no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los contactos', $this->domain),
  //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
  //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
  //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
  //          'featured_image' - Default is Featured Image.
  //          'set_featured_image' - Default is Set featured image.
  //          'remove_featured_image' - Default is Remove featured image.
  //          'use_featured_image' - Default is Use as featured image.
  //          'menu_name' - Default is the same as `name`.
  //          'filter_items_list' - String for the table views hidden heading.
  //          'items_list_navigation' - String for the table pagination hidden heading.
  //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Listado de usuarios que realizaron alguna consulta a través del formulario de contacto.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-money',
            // 'hierarchical'        => false,
            'supports' => array(
//                'title',
//                'editor',
                'custom-fields',
                'author',
//                'thumbnail',
//                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
             'rewrite'     => false
        );
        register_post_type('contacts', $args);
        
        $labels = array(
            'name'               => __('Admisión', $this->domain),
            'singular_name'      => __('Registro', $this->domain),
            'add_new'            => __('Nuevo registro', $this->domain),
            'add_new_item'       => __('Agregar nuevo registro', $this->domain),
            'edit_item'          => __('Editar registro', $this->domain),
            'new_item'           => __('Nuevo registro', $this->domain),
            'view_item'          => __('Ver reistro', $this->domain),
            'search_items'       => __('Buscar registro', $this->domain),
            'not_found'          => __('Registro no encontrado', $this->domain),
            'not_found_in_trash' => __('Registro no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los registros', $this->domain),
  //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
  //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
  //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
  //          'featured_image' - Default is Featured Image.
  //          'set_featured_image' - Default is Set featured image.
  //          'remove_featured_image' - Default is Remove featured image.
  //          'use_featured_image' - Default is Use as featured image.
  //          'menu_name' - Default is the same as `name`.
  //          'filter_items_list' - String for the table views hidden heading.
  //          'items_list_navigation' - String for the table pagination hidden heading.
  //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Relación de niños inscriptos en el proceso de admisión.',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-media-document',
            // 'hierarchical'        => false,
            'supports' => array(
//                'title',
//                'editor',
                'custom-fields',
                'author',
//                'thumbnail',
//                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
             'rewrite'     => false
        );
        register_post_type('prestudents', $args);
        
        flush_rewrite_rules();
    }

    public function unregister_post_type()
    {
        global $wp_post_types;
        
        dump_exit($wp_post_types);

        if (isset($wp_post_types[ 'testimonials' ])) {
            unset($wp_post_types[ 'testimonials' ]);

            return true;
        }

        return false;
    }
    
    /**
     * Add custom taxonomies areas to post type post.
     */
    public function add_taxonomies_post()
    {
        $labels = array(
            'name' => _x('Zonas', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Zona', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Zonas', THEMEDOMAIN),
            'popular_items' => __('Zonas Populares', THEMEDOMAIN),
            'all_items' => __('Todas las Zonas', THEMEDOMAIN),
            'parent_item' => __('Zona Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Zona Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Zona', THEMEDOMAIN),
            'update_item' => __('Actualizar Zona', THEMEDOMAIN),
            'add_new_item' => __('Añadir nueva Zona', THEMEDOMAIN),
            'new_item_name' => __('Nueva Zona', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Zona', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Zonas', THEMEDOMAIN),
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
              'slug' => 'zona',
            ),
//            'capabilities' => array(),
        );

        register_taxonomy('areas', 'post', $args);
    }
    
    public function remove_taxonomies_post()
    {
        wp_delete_term(3, 'areas');
        wp_delete_term(4, 'areas');
        wp_delete_term(5, 'areas');
        
        unregister_taxonomy('areas');
    }
    
    /**
     * Add custom taxonomies areas to post type sliders.
     */
    public function add_taxonomies_sliders()
    {
        $labels = array(
            'name' => _x('Secciones', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Sección', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Sección', THEMEDOMAIN),
            'popular_items' => __('Secciones Populares', THEMEDOMAIN),
            'all_items' => __('Todas las Secciones', THEMEDOMAIN),
            'parent_item' => __('Sección Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Sección Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Sección', THEMEDOMAIN),
            'update_item' => __('Actualizar Sección', THEMEDOMAIN),
            'add_new_item' => __('Añadir nueva Sección', THEMEDOMAIN),
            'new_item_name' => __('Nueva Sección', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Sección', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Secciones', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => false,
//            'capabilities' => array(),
        );

        register_taxonomy('sections', 'sliders', $args);
    }
    
    /**
     * Add custom taxonomies areas to post type prestudents.
     */
    public function add_taxonomies_prestudents()
    {
        $labels = array(
            'name' => _x('Grados', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Grado', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Grado', THEMEDOMAIN),
            'popular_items' => __('Grados Populares', THEMEDOMAIN),
            'all_items' => __('Todos los Grados', THEMEDOMAIN),
            'parent_item' => __('Grado Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Grado Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Grado', THEMEDOMAIN),
            'update_item' => __('Actualizar Grado', THEMEDOMAIN),
            'add_new_item' => __('Añadir nuevo Grado', THEMEDOMAIN),
            'new_item_name' => __('Nuevo Grado', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Grado', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Grados', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => false,
//            'capabilities' => array(),
        );

        register_taxonomy('levels', 'prestudents', $args);
    }
}
