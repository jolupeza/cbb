<?php
/**
 * Displays the user interface for the CBB WorkWithUs meta box by type content Districts.
 *
 * This is a partial template that is included by the CBB WorkWithUs
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-districts-id">

    <?php
    $values = get_post_custom( get_the_ID() );
    $province = !empty($values['mb_province']) ? esc_attr($values['mb_province'][0]) : '';

    wp_nonce_field( 'districts_meta_box_nonce', 'meta_box_nonce' );
    ?>

    <!-- Province-->
    <p class="content-mb">
        <label for="mb_province">Seleccionar Provincia: </label>
        <select name="mb_province" id="mb_province">
            <option value="" <?php selected($province, ''); ?>>Seleccionar</option>

            <?php
            $args = array(
                'post_type' => 'provinces',
                'posts_per_page' => -1
            );
            $provinces = new WP_Query($args);
            if ($provinces->have_posts()) :
                while ($provinces->have_posts()) :
                    $provinces->the_post();
                    $id = get_the_ID();
                    ?>
                    <option value="<?php echo $id; ?>" <?php selected($province, $id); ?>><?php the_title(); ?></option>
                <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>

        </select>
    </p>
</div><!-- #mb-districts-id -->
