<?php
/**
 * Displays the user interface for the CBB WorkWithUs meta box by type content JobApplications.
 *
 * This is a partial template that is included by the CBB WorkWithUs
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-job-applications-id">

<?php
    $values = get_post_custom( get_the_ID() );
    $name = !empty($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
    $firstName = !empty($values['mb_ape_paterno']) ? esc_attr($values['mb_ape_paterno'][0]) : '';
    $lastName = !empty($values['mb_ape_materno']) ?  esc_attr($values['mb_ape_materno'][0]) : '';
    $document = !empty($values['mb_document']) ?  esc_attr($values['mb_document'][0]) : '';
    $gender = !empty($values['mb_gender']) ? esc_attr($values['mb_gender'][0]) : '';
    $birthday = !empty($values['mb_birthday']) ? esc_attr(date('d-m-Y' , strtotime($values['mb_birthday'][0]))) : '';
    $age = !empty($values['mb_age']) ? esc_attr($values['mb_age'][0]) : '';
    $phone = !empty($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
    $mobile = !empty($values['mb_mobile']) ? esc_attr($values['mb_mobile'][0]) : '';
    $email = !empty($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
    $city = !empty($values['mb_city']) ? esc_attr($values['mb_city'][0]) : '';
    $province = !empty($values['mb_province']) ? esc_attr($values['mb_province'][0]) : '';
    $district = !empty($values['mb_district']) ? esc_attr($values['mb_district'][0]) : '';
    $address = !empty($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
    $reference = !empty($values['mb_reference']) ? esc_attr($values['mb_reference'][0]) : '';
    $review = !empty($values['mb_review']) ? esc_attr($values['mb_review'][0]) : '';
    $studies = !empty($values['mb_studies']) ? unserialize($values['mb_studies'][0]) : '';
    $experiences = !empty($values['mb_experiences']) ? unserialize($values['mb_experiences'][0]) : '';
    $local = !empty($values['mb_local']) ? (int)esc_attr($values['mb_local'][0]) : '';
    $levelEducation = !empty($values['mb_level_education']) ? esc_attr($values['mb_level_education'][0]) : '';
    $photo = !empty($values['mb_photo']) ? esc_url($values['mb_photo'][0]) : '';
    $cv = !empty($values['mb_cv']) ? esc_url($values['mb_cv'][0]) : '';

    $locals = get_posts([
        'post_type' => 'locals',
        'post_parent' => 0
    ]);

    wp_nonce_field( 'jobapplications_meta_box_nonce', 'meta_box_nonce' );
?>

    <!-- Name-->
    <p class="content-mb">
        <label for="mb_name">Nombre: </label>
        <input type="text" name="mb_name" id="mb_name" value="<?php echo $name; ?>" />
    </p>

    <!-- Firstname -->
    <p class="content-mb">
        <label for="mb_apepaterno">Apellido Paterno: </label>
        <input type="text" name="mb_apepaterno" id="mb_apepaterno" value="<?php echo $firstName; ?>" />
    </p>

    <!-- Lastname -->
    <p class="content-mb">
        <label for="mb_apematerno">Apellido Materno: </label>
        <input type="text" name="mb_apamaterno" id="mb_apematerno" value="<?php echo $lastName; ?>" />
    </p>

    <!-- Document -->
    <p class="content-mb">
        <label for="mb_document">Documento: </label>
        <input type="text" name="mb_document" id="mb_document" value="<?php echo $document; ?>" />
    </p>

    <!-- Gender -->
    <p class="content-mb">
        <label for="mb_gender">Género: </label>
        <select name="mb_gender" id="mb_gender">
            <option value="" <?php selected($gender, ''); ?>>Indicar</option>
            <option value="femenino" <?php selected($gender, 'femenino'); ?>><?php esc_attr_e('Femenino'); ?></option>
            <option value="masculino" <?php selected($gender, 'masculino'); ?>><?php esc_attr_e('Masculino'); ?></option>
        </select>
    </p>

    <!-- Document -->
    <p class="content-mb">
        <label for="mb_birthday">Fecha de Nacimiento: </label>
        <input type="text" name="mb_birthday" id="mb_birthday" value="<?php echo $birthday; ?>" />
    </p>

    <!-- Age -->
    <p class="content-mb">
        <label for="mb_age">Edad: </label>
        <input type="text" name="mb_age" id="mb_age" value="<?php echo $age; ?>" />
    </p>

    <!-- Phone -->
    <p class="content-mb">
        <label for="mb_phone">Teléfono fijo: </label>
        <input type="text" name="mb_phone" id="mb_phone" value="<?php echo $phone; ?>" />
    </p>

    <!-- Mobile -->
    <p class="content-mb">
        <label for="mb_mobile">Teléfono celular: </label>
        <input type="text" name="mb_mobile" id="mb_mobile" value="<?php echo $mobile; ?>" />
    </p>

    <!-- Email -->
    <p class="content-mb">
        <label for="mb_email">Correo electrónico: </label>
        <input type="email" name="mb_email" id="mb_email" value="<?php echo $email; ?>" />
    </p>

    <!-- City -->
    <p class="content-mb">
        <label for="mb_city">Departamento: </label>
        <input type="text" name="mb_city" id="mb_city" value="<?php echo $city; ?>" />
    </p>

    <!-- Province -->
    <p class="content-mb">
        <label for="mb_province">Provincia: </label>
        <input type="text" name="mb_province" id="mb_province" value="<?php echo $province; ?>" />
    </p>

    <!-- District -->
    <p class="content-mb">
        <label for="mb_district">Distrito: </label>
        <input type="text" name="mb_district" id="mb_district" value="<?php echo $district; ?>" />
    </p>

    <!-- Address -->
    <p class="content-mb">
        <label for="mb_address">Dirección: </label>
        <input type="text" name="mb_address" id="mb_address" value="<?php echo $address; ?>" />
    </p>

    <!-- Reference -->
    <p class="content-mb">
        <label for="mb_reference">Referencia: </label>
        <textarea rows="6" name="mb_reference" id="mb_reference"><?php echo $reference; ?></textarea>
    </p>

    <!-- Level Education -->
    <p class="content-mb">
        <label for="mb_level_education">Nivel: </label>
        <input type="text" name="mb_level_education" id="mb_level_education" value="<?php echo $levelEducation; ?>" />
    </p>

    <!-- Local -->
    <p class="content-mb">
        <label for="mb_gender">Sede a la que postula: </label>
        <select name="mb_local" id="mb_local">
            <option value="" <?php selected($local, ''); ?>>Indicar</option>
            <?php foreach ($locals as $item) : ?>
                <option value="<?php esc_attr_e($item->ID); ?>" <?php selected($local, $item->ID); ?>><?php esc_attr_e($item->post_title); ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <!-- Photo -->
    <p class="content-mb">
        <label for="mb_photo">Foto: </label>
        <img width="100" src="<?php echo $photo; ?>" alt="" />
    </p>

    <!-- Cv -->
    <p class="content-mb">
        <label for="mb_photo">CV: </label>
        <?php if (!empty($cv)) : ?>
            <a href="<?php echo $cv; ?>" target="_blank" download="" title="Descargar">
                <img src="<?php echo esc_url(includes_url() . '/images/media/document.png') ?>" alt="CV" />
            </a>
        <?php endif; ?>
    </p>

    <!-- Review -->
    <p class="content-mb">
        <label for="mb_review">Reseña: </label>
        <textarea rows="6" name="mb_review" id="mb_review"><?php echo $review; ?></textarea>
    </p>

    <?php if (!empty($studies)) : ?>
        <article class="Fields__table">
            <h3 class="hndle">Estudios Realizados</h3>
            <table class="widefat fixed striped">
                    <thead>
                    <tr>
                        <td class="manage-column column-cb check-column">ID</td>
                        <td class="manage-column">Carrera Profesional</td>
                        <td class="manage-column">Institución</td>
                        <td class="manage-column">Grado Acad.</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($studies as $index => $study) : ?>
                        <tr>
                            <td><?php esc_attr_e($index + 1); ?></td>
                            <td><?php esc_attr_e($study->profession); ?></td>
                            <td><?php esc_attr_e($study->institution); ?></td>
                            <td><?php esc_attr_e(get_post($study->degree)->post_title); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
        </article>
    <?php endif; ?>

    <?php if (!empty($experiences)) : ?>
        <article class="Fields__table">
            <h3 class="hndle">Experiencia</h3>
            <table class="widefat fixed striped">
                    <thead>
                    <tr>
                        <td class="manage-column column-cb check-column">ID</td>
                        <td class="manage-column">Institución</td>
                        <td class="manage-column">Cargo</td>
                        <td class="manage-column">Inicio</td>
                        <td class="manage-column">Fin</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($experiences as $index => $experience) : ?>
                        <?php
                            $dateEnd = $experience->dateEnd === 'Actualmente'
                                ? $experience->dateEnd
                                : date('d-m-Y', strtotime($experience->dateEnd));
                        ?>
                        <tr>
                            <td><?php esc_attr_e($index + 1); ?></td>
                            <td><?php esc_attr_e($experience->institution); ?></td>
                            <td><?php esc_attr_e($experience->job); ?></td>
                            <td><?php esc_attr_e(date('d-m-Y', strtotime($experience->dateStart))); ?></td>
                            <td><?php esc_attr_e($dateEnd); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
        </article>
    <?php endif; ?>
</div><!-- #mb-provinces-id -->
