<?php
/**
 * Displays the user interface for the CBB WorkWithUs meta box by type content Provinces.
 *
 * This is a partial template that is included by the CBB WorkWithUs
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-provinces-id">

    <?php
    $values = get_post_custom( get_the_ID() );
    $city = !empty($values['mb_city']) ? esc_attr($values['mb_city'][0]) : '';

    wp_nonce_field( 'provinces_meta_box_nonce', 'meta_box_nonce' );
    ?>

    <!-- City-->
    <p class="content-mb">
        <label for="mb_city">Seleccionar Departamento: </label>
        <select name="mb_city" id="mb_city">
            <option value="" <?php selected($city, ''); ?>>Seleccionar</option>

            <?php
            $args = array(
                'post_type' => 'cities',
                'posts_per_page' => -1
            );
            $cities = new WP_Query($args);
            if ($cities->have_posts()) :
                while ($cities->have_posts()) :
                    $cities->the_post();
                    $id = get_the_ID();
                    ?>
                    <option value="<?php echo $id; ?>" <?php selected($city, $id); ?>><?php the_title(); ?></option>
                <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>

        </select>
    </p>
</div><!-- #mb-provinces-id -->
