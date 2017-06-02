<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Students.
 *
 * This is a partial template that is included by the Watson Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-students-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
        $lastname = isset($values['mb_lastname']) ? esc_attr($values['mb_lastname'][0]) : '';
        $dni = isset($values['mb_dni']) ? esc_attr($values['mb_dni'][0]) : '';
        $district = isset($values['mb_district']) ? (int)esc_attr($values['mb_district'][0]) : '';
        $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        $carrera = isset($values['mb_carrera']) ? (int)esc_attr($values['mb_carrera'][0]) : '';
        $work = isset($values['mb_work']) ? esc_attr($values['mb_work'][0]) : '';
        $centerwork = isset($values['mb_centerwork']) ? esc_attr($values['mb_centerwork'][0]) : '';
        $job = isset($values['mb_job']) ? esc_attr($values['mb_job'][0]) : '';
        $districtwork = isset($values['mb_districtwork']) ? (int)esc_attr($values['mb_districtwork'][0]) : '';
        $whopay = isset($values['mb_whopay']) ? esc_attr($values['mb_whopay'][0]) : '';
        $voucher = isset($values['mb_voucher']) ? esc_attr($values['mb_voucher'][0]) : '';
        $other = isset($values['mb_other']) ? esc_attr($values['mb_other'][0]) : '';

        $nameDistrict = '';
        if (!empty($district)) {
            $district = get_post($district);
            $nameDistrict = $district->post_title;
        }
        
        $nameDistrictWork = '';
        if (!empty($districtwork)) {
            $districtwork = get_post($districtwork);
            $nameDistrictWork = $districtwork->post_title;
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
    
    <!-- DNI-->
    <p class="content-mb">
        <label for="mb_dni">DNI o CE: </label>
        <input type="text" name="mb_dni" id="mb_dni" value="<?php echo $dni; ?>" />
    </p>
    
    <!-- District-->
    <p class="content-mb">
        <label for="mb_district">Distrito: </label>
        <input type="text" name="mb_district" id="mb_district" value="<?php echo $nameDistrict; ?>" />
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
    
    <!-- Carrera-->
    <p class="content-mb">
        <label for="mb_carrera">Carrera: </label>
        <input type="text" name="mb_carrera" id="mb_carrera" value="<?php echo $nameCarrera; ?>" />
    </p>
    
    <!-- Work-->
    <p class="content-mb">
        Trabaja: 
        <input type="radio" id="mb_work['si']" name="mb_work" value="si" <?php checked( $work, 'si' ); ?> />
        <label for="mb_work['si']">Si</label>
        
        <input type="radio" id="mb_work['no']" name="mb_work" value="no" <?php checked( $work, 'no' ); ?> />
        <label for="mb_work['no']">No</label>
    </p>
    
    <!-- Center Work -->
    <p class="content-mb">
        <label for="mb_centerwork">Centro de Trabajo: </label>
        <input type="text" name="mb_centerwork" id="mb_centerwork" value="<?php echo $centerwork; ?>" />
    </p>
    
    <!-- Job -->
    <p class="content-mb">
        <label for="mb_job">Cargo: </label>
        <input type="text" name="mb_job" id="mb_job" value="<?php echo $job; ?>" />
    </p>
    
    <!-- Job -->
    <p class="content-mb">
        <label for="mb_districtwork">Distrito Centro de Trabajo: </label>
        <input type="text" name="mb_districtwork" id="mb_districtwork" value="<?php echo $nameDistrictWork; ?>" />
    </p>
    
    <!-- Whopay-->
    <p class="content-mb">
        ¿Quién hará los pagos?
        <input type="radio" id="mb_whopay['1']" name="mb_whopay" value="1" <?php checked( $whopay, '1' ); ?> />
        <label for="mb_whopay['1']">Yo mismo</label>
        
        <input type="radio" id="mb_whopay['2']" name="mb_whopay" value="2" <?php checked( $whopay, '2' ); ?> />
        <label for="mb_whopay['2']">Mis Padres o Apoderados</label>
        
        <input type="radio" id="mb_whopay['3']" name="mb_whopay" value="3" <?php checked( $whopay, '3' ); ?> />
        <label for="mb_whopay['3']">La empresa donde laboro</label>
    </p>
    
    <!-- Voucher-->
    <p class="content-mb">
        Comprobante
        <input type="radio" id="mb_voucher['1']" name="mb_voucher" value="1" <?php checked( $voucher, '1' ); ?> />
        <label for="mb_voucher['1']">Boleta</label>
        
        <input type="radio" id="mb_voucher['1']" name="mb_voucher" value="2" <?php checked( $voucher, '2' ); ?> />
        <label for="mb_voucher['2']">Factura</label>
    </p>

    <!-- Other -->
    <p class="content-mb">
        <label for="mb_other">¿Cómo te enteraste? Otro: </label>
        <input type="text" name="mb_other" id="mb_other" value="<?php echo $other; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->