<?php
/**
 * Displays the user interface for the VillaMaria Manager meta box by type content Services.
 *
 * This is a partial template that is included by the VillaMaria Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-services-id">
    <?php
        $values = get_post_custom(get_the_ID());
        
        $inHome = isset($values['mb_inhome']) ? esc_attr($values['mb_inhome'][0]) : 'off';
        
        wp_nonce_field('services_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <!-- Homepage -->
    <p class="content-mb">
        <label for="mb_inhome">¿Se muestra en el homepage?</label>
        <input type="checkbox" name="mb_inhome" id="mb_inhome" <?php checked($inHome, 'on'); ?> />
    </p>
</div>