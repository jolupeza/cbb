<?php
/**
 * Displays the user interface for the VillaMaria Manager meta box by type content Templates.
 *
 * This is a partial template that is included by the VillaMaria Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-templates-id">
    <?php
        $values = get_post_custom(get_the_ID());
        
        $slug = isset($values['mb_slug']) ? esc_attr($values['mb_slug'][0]) : '';
        
        wp_nonce_field('templates_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <!-- Slug -->
    <p class="content-mb">
        <label for="mb_slug">Nombre Plantilla: </label>
        <input type="text" name="mb_slug" id="mb_slug" value="<?php echo $slug; ?>" />
    </p>
</div>