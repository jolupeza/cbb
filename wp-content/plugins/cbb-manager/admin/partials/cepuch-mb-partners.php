<?php
/**
 * Displays the user interface for the Cepuch Manager meta box by type content Partners.
 *
 * This is a partial template that is included by the Cepuch Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>

<div id="mb-partners-id">
    <?php
    $values = get_post_custom(get_the_ID());

    $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';

    wp_nonce_field('partners_meta_box_nonce', 'meta_box_nonce');
    ?>

    <!-- Url-->
    <p class="content-mb">
        <label for="mb_url">Link: </label>
        <input type="text" name="mb_url" id="mb_url" value="<?php echo $url; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->