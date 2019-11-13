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
        $this->loader->add_action('joblevels_add_form_fields', $this, 'addTaxonomyImage');
        $this->loader->add_action('created_joblevels', $this, 'saveTaxonomyImage', 10, 2);
        $this->loader->add_action('joblevels_edit_form_fields', $this, 'updateTaxonomyImage', 10, 2);
        $this->loader->add_action('edited_joblevels', $this, 'updatedTaxonomyImage', 10, 2);
        $this->loader->add_action('admin_enqueue_scripts', $this, 'loadMedia');
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