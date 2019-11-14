<?php

namespace CBB_WorkWithUs\Admin\Taxonomies;

use CBB_WorkWithUs\Includes\Loader;

class Joblevel
{

    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    private $loader;

    private $domain;

    /**
     * @param Loader $loader
     */
    public function __construct(Loader $loader, $domain)
    {
        $this->loader = $loader;
        $this->domain = $domain;
    }

    public function init()
    {
        $this->loader->add_action('init', $this, 'addTaxonomiesJobapplications');
        $this->loader->add_action('joblevels_add_form_fields', $this, 'addTaxonomyImage');
        $this->loader->add_action('created_joblevels', $this, 'saveTaxonomyImage', 10, 2);
        $this->loader->add_action('joblevels_edit_form_fields', $this, 'updateTaxonomyImage', 10, 2);
        $this->loader->add_action('edited_joblevels', $this, 'updatedTaxonomyImage', 10, 2);
        $this->loader->add_action('admin_enqueue_scripts', $this, 'loadMedia');
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
            'show_in_nav_menus' => false,
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

    public function loadMedia()
    {
        wp_enqueue_media();
    }

    /**
     * Add a form field in the new taxonomy page
     */
    public function addTaxonomyImage($taxonomy)
    {
    ?>
        <div class="form-field term-group">
            <h4>Imagen</h4>

            <p class="btn-add-file">
                <a title="<?php _e('Agregar Imagen', $this->domain); ?>" href="javascript:;" class="set-file button button-primary"><?php _e('Agregar Imagen', $this->domain); ?></a>
            </p>

            <div class="hidden media-container">
                <img src="" style="margin:0;padding:0;max-height:100px;" />
            </div>

            <p class="hidden">
                <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary"><?php _e('Quitar Imagen', $this->domain); ?></a>
            </p>

            <p class="media-info">
                <input class="hd-src" type="hidden" id="joblevels-image-id" name="joblevels-image-id" value="" />
            </p>
        </div>
    <?php
    }

    /**
     * Save the form field
     */
    public function saveTaxonomyImage($term_id, $tt_id)
    {
        if (isset($_POST['joblevels-image-id']) && '' !== $_POST['joblevels-image-id']) {
            $image = $_POST['joblevels-image-id'];
            add_term_meta($term_id, 'joblevels-image-id', $image, true);

            // @TODO: Remove image with JS
        }
    }

    /**
     * Edit the form field
     */
    public function updateTaxonomyImage($term, $taxonomy)
    {
    ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="joblevels-image-id"><?php _e( 'Image', $this->domain ); ?></label>
            </th>
            <td>
                <?php $image_id = get_term_meta($term->term_id, 'joblevels-image-id', true); ?>

                <p class="btn-add-file">
                    <a title="Agregar imagen" href="javascript:;" class="set-file button button-primary">Añadir Imagen</a>
                </p>

                <div class="hidden media-container">
                    <?php if ( $image_id ) : ?>
                        <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                    <?php else : ?>
                        <img src="" style="margin:0;padding:0;max-height:100px;" />
                    <?php endif; ?>
                </div>

                <p class="hidden">
                    <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar Imagen</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" id="joblevels-image-id" name="joblevels-image-id" value="<?php echo $image_id; ?>" />
                </p>
            </td>
        </tr>
    <?php
    }

    /**
     * Update the form field
     */
    public function updatedTaxonomyImage($term_id, $tt_id)
    {
        if (isset($_POST['joblevels-image-id']) && '' !== $_POST['joblevels-image-id']) {
            $image = $_POST['joblevels-image-id'];
            update_term_meta($term_id, 'joblevels-image-id', $image);
        } else {
            update_term_meta($term_id, 'joblevels-image-id', '');
        }
    }

}
