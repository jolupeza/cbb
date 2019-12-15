<?php
/**
 * Displays the user interface for the CBB WorkWithUs meta box by type content Degrees.
 *
 * This is a partial template that is included by the CBB WorkWithUs
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-degrees-id">

    <?php
    $values = get_post_custom( get_the_ID() );

    $typeApplications = get_terms([
        'taxonomy' => 'joblevels',
        'hide_empty' => false,
        'fields' => 'id=>name'
    ]);

    $types = [];
    foreach ($typeApplications as $id => $type) {
        $types[$id] = !empty($values['mb_type_' . $id]) ? true : false;
    }

    wp_nonce_field( 'degrees_meta_box_nonce', 'meta_box_nonce' );
    ?>

    <!-- types applications -->
    <?php foreach ($typeApplications as $id => $type) : ?>
        <p class="content-mb">
            <label for="mb_type_<?php esc_attr_e($id); ?>"><?php esc_attr_e($type); ?>: </label>
            <input type="checkbox"
                name="mb_type_<?php esc_attr_e($id); ?>"
                id="mb_type_<?php esc_attr_e($id); ?>"
                value="<?php esc_attr_e($id); ?>" <?php checked($types[$id], true); ?> />
        </p>
    <?php endforeach; ?>
</div><!-- #mb-districts-id -->
