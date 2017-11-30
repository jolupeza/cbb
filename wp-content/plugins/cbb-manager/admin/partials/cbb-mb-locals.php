<?php
/**
 * Displays the user interface for the CBB Manager meta box by type content Locals.
 *
 * This is a partial template that is included by the CBB Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-locals-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
        $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
        $lat = isset($values['mb_lat']) ? esc_attr($values['mb_lat'][0]) : '';
        $long = isset($values['mb_long']) ? esc_attr($values['mb_long'][0]) : '';

        wp_nonce_field( 'locals_meta_box_nonce', 'meta_box_nonce' );
    ?>
    
    <!-- Address -->
    <p class="content-mb">
        <label for="mb_address">Dirección: </label>
        <input type="text" name="mb_address" id="mb_address" value="<?php echo $address; ?>" />
    </p>
    
    <!-- Phone -->
    <p class="content-mb">
        <label for="mb_phone">Teléfono: </label>
        <input type="text" name="mb_phone" id="mb_phone" value="<?php echo $phone; ?>" />
    </p>
    
    <!-- Email -->
    <p class="content-mb">
        <label for="mb_email">Correo electrónico Formulario de Contacto: </label>
        <input type="email" name="mb_email" id="mb_email" value="<?php echo $email; ?>" />
    </p>
    
    <!-- Latitud -->
    <p class="content-mb">
        <label for="mb_lat">Google Map Latitud: </label>
        <input type="text" name="mb_lat" id="mb_lat" value="<?php echo $lat; ?>" />
    </p>
    
    <!-- Longitud -->
    <p class="content-mb">
        <label for="mb_long">Google Map Longitud: </label>
        <input type="text" name="mb_long" id="mb_long" value="<?php echo $long; ?>" />
    </p>
    
    <!-- Parallax-->
    <p class="content-mb">
        <label for="mb_parallax">Seleccionar Parallax: </label>
        <select name="mb_parallax" id="mb_parallax">
            <option value="" <?php selected($parallax, ''); ?>>-- Seleccione parallax --</option>

        <?php
            $args = array(
                'post_type' => 'parallaxs',
                'posts_per_page' => -1
            );
            $parallaxs = new WP_Query($args);
            if ($parallaxs->have_posts()) :
                while ($parallaxs->have_posts()) :
                    $parallaxs->the_post();
                    $id = get_the_ID();
        ?>
            <option value="<?php echo $id; ?>" <?php selected($parallax, $id); ?>><?php the_title(); ?></option>
        <?php
                endwhile;
            endif;
            wp_reset_postdata();
        ?>

        </select>
    </p>
</div><!-- #mb-locals-id -->