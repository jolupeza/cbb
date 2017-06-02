<?php
/**
 * Displays the user interface for the Cepuch Manager meta box by type content Descuentos u Ofertas.
 *
 * This is a partial template that is included by the Cepuch Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>

<div id="mb-dsctos-id">
    <?php
        $values = get_post_custom(get_the_ID());
        
        $mount = isset($values['mb_mount']) ? esc_attr($values['mb_mount'][0]) : '';
        
        wp_nonce_field('dsctos_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <!-- Monto-->
    <p class="content-mb">
        <label for="mb_mount">Monto: </label>
        <input type="text" name="mb_mount" id="mb_mount" value="<?php echo $mount; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->