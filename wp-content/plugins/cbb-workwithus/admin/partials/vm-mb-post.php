<?php
/**
 * Displays the user interface for the VillaMaria Manager meta box by type content Post.
 *
 * This is a partial template that is included by the VillaMaria Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-post-id">
    <?php
        $values = get_post_custom(get_the_ID());
        
        $more = !empty($values['mb_more']) ? $values['mb_more'][0] : '';
        
        wp_nonce_field('post_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <!-- More -->
    <h2 class="Subtitle hndle"><span>Más contenido:</span></h2>
    <?php
        $settingsMore = array(
            'wpautop' => false,
            'textarea_name' => 'mb_more',
            'media_buttons' => true,
            'textarea_rows' => 10,
        );
        wp_editor($more, 'mb_more', $settingsMore);
    ?>
</div>