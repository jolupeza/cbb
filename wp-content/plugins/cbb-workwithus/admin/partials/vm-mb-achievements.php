<?php
/**
 * Displays the user interface for the VillaMaria Manager meta box by type content Achievements.
 *
 * This is a partial template that is included by the VillaMaria Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-achievements-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $image = isset($values['mb_image']) ? esc_attr($values['mb_image'][0]) : '';

        wp_nonce_field('achievements_meta_box_nonce', 'meta_box_nonce');
    ?>

    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Image</legend>

        <section class="GroupForm-flex GroupForm-flex--center">
            <div class="container-upload-file GroupForm-wrapperImage">
                <h3 class="Fieldset-subtitle">Imagen 200 x 150</h3>
                
                <p class="btn-add-file">
                    <a title="Agregar imagen" href="javascript:;" class="set-file button button-primary">Añadir Imagen</a>
                </p>

                <div class="hidden media-container">
                    <img src="<?php echo $image; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true );  ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true );  ?>" />
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar Imagen</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_image" value="<?php echo $image; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
        </section>
    </fieldset>
</div><!-- #single-post-meta-manager -->