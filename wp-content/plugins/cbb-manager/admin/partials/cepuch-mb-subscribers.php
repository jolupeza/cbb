<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Contacts.
 *
 * This is a partial template that is included by the Watson Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-subscribers-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
        $lastname = isset($values['mb_lastname']) ? esc_attr($values['mb_lastname'][0]) : '';
        $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        $carrera = isset($values['mb_carrera']) ? (int)esc_attr($values['mb_carrera'][0]) : '';
        $district = isset($values['mb_district']) ? (int)esc_attr($values['mb_district'][0]) : '';
        $other = isset($values['mb_other']) ? esc_attr($values['mb_other'][0]) : '';

        $nameDistrict = '';
        if (!empty($district)) {
            $district = get_post($district);
            $nameDistrict = $district->post_title;
        }
        
        $nameCarrera = '';
        if (!empty($carrera)) {
            $carrera = get_post($carrera);
            $nameCarrera = $carrera->post_title;
        }
        
//        wp_nonce_field('models_meta_box_nonce', 'meta_box_nonce');
    ?>

    <!-- Name-->
    <p class="content-mb">
        <label for="mb_name">Nombre: </label>
        <input type="text" name="mb_name" id="mb_name" value="<?php echo $name; ?>" />
    </p>
    
    <!-- LastName-->
    <p class="content-mb">
        <label for="mb_lastname">Apellidos: </label>
        <input type="text" name="mb_lastname" id="mb_lastname" value="<?php echo $lastname; ?>" />
    </p>
    
    <!-- Email-->
    <p class="content-mb">
        <label for="mb_email">Correo electrónico: </label>
        <input type="text" name="mb_email" id="mb_email" value="<?php echo $email; ?>" />
    </p>
    
    <!-- Phone-->
    <p class="content-mb">
        <label for="mb_phone">Teléfono: </label>
        <input type="text" name="mb_phone" id="mb_phone" value="<?php echo $phone; ?>" />
    </p>
    
    <!-- District-->
    <p class="content-mb">
        <label for="mb_district">Distrito: </label>
        <input type="text" name="mb_district" id="mb_district" value="<?php echo $nameDistrict; ?>" />
    </p>
    
    <!-- Carrera-->
    <p class="content-mb">
        <label for="mb_carrera">Carrera: </label>
        <input type="text" name="mb_carrera" id="mb_carrera" value="<?php echo $nameCarrera; ?>" />
    </p>

    <!-- Other -->
    <p class="content-mb">
        <label for="mb_other">¿Cómo te enteraste? Otro: </label>
        <input type="text" name="mb_other" id="mb_other" value="<?php echo $other; ?>" />
    </p>

</div><!-- #single-post-meta-manager -->