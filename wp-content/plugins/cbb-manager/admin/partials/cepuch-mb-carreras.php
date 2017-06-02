<?php
/**
 * Displays the user interface for the Cepuch Manager meta box by type content Carreras.
 *
 * This is a partial template that is included by the Cepuch Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>

<div id="mb-carreras-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $video = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';
        
        $duration = isset($values['mb_duration']) ? esc_attr($values['mb_duration'][0]) : '';
        $price = isset($values['mb_price']) ? esc_attr($values['mb_price'][0]) : '';
        $about = (isset($values['mb_about'])) ? $values['mb_about'][0] : '';
        $plan = (isset($values['mb_plan'])) ? $values['mb_plan'][0] : '';
        $planstudy = isset( $values['mb_planstudy'] ) ? esc_attr($values['mb_planstudy'][0]) : '';
        $horario = (isset($values['mb_horario'])) ? $values['mb_horario'][0] : '';
        $inscription = (isset($values['mb_inscription'])) ? $values['mb_inscription'][0] : '';


//        $pronto_mount = (isset($values['mb_pronto_mount'])) ? esc_attr($values['mb_pronto_mount'][0]) : '';
//        $pronto_legend = (isset($values['mb_pronto_legend'])) ? esc_attr($values['mb_pronto_legend'][0]) : '';
//        $corp_mount = (isset($values['mb_corp_mount'])) ? esc_attr($values['mb_corp_mount'][0]) : '';
//        $corp_legend = (isset($values['mb_corp_legend'])) ? esc_attr($values['mb_corp_legend'][0]) : '';
//        $pref_mount = (isset($values['mb_pref_mount'])) ? esc_attr($values['mb_pref_mount'][0]) : '';
//        $pref_legend = (isset($values['mb_pref_legend'])) ? esc_attr($values['mb_pref_legend'][0]) : '';
        
        $arrDsctos = [];
        if (!empty($dsctos)) {
            $arrDsctos = unserialize($dsctos);
        }        
        
        wp_nonce_field('carreras_meta_box_nonce', 'meta_box_nonce');
    ?>

    <!-- Video-->
    <p class="content-mb">
        <label for="mb_video">Id video: </label>
        <input type="text" name="mb_video" id="mb_video" value="<?php echo $video; ?>" />
    </p>
    
    <!-- Duration-->
    <p class="content-mb">
        <label for="mb_duration">Duración de la carrera: </label>
        <input type="text" name="mb_duration" id="mb_duration" value="<?php echo $duration; ?>" />
    </p>
    
    <!-- Price-->
    <p class="content-mb">
        <label for="mb_price">Inversión mensual: </label>
        <input type="text" name="mb_price" id="mb_price" value="<?php echo $price; ?>" />
    </p>
    
    <?php /*
    <fieldset>
        <legend>Descuentos y ofertas</legend>
        <section class="Block-flex">
            <article class="Block-column-3 Block">
                <h2 class="Block-column-title text-center">Pronto Pago</h2>
                
                <!-- Mount-->
                <div class="Form-group Form-group--horizontal">
                    <label for="mb_pronto_mount" class="Form-label">Monto: </label>
                    <input class="Form-input" type="text" name="mb_pronto_mount" id="mb_pronto_mount" value="<?php echo $pronto_mount; ?>" />
                </div>
                
                <!-- Leyenda-->
                <div class="Form-group Form-group--horizontal">
                    <label for="mb_pronto_legend" class="Form-label">Leyenda: </label>
                    <input class="Form-input" type="text" name="mb_pronto_legend" id="mb_pronto_legend" value="<?php echo $pronto_legend; ?>" />
                </div>
            </article>
            
            <article class="Block-column-3 Block">
                <h2 class="Block-column-title text-center">Corporativo</h2>
                
                <!-- Mount-->
                <div class="Form-group Form-group--horizontal">
                    <label for="mb_corp_mount" class="Form-label">Monto: </label>
                    <input class="Form-input" type="text" name="mb_corp_mount" id="mb_corp_mount" value="<?php echo $corp_mount; ?>" />
                </div>
                
                <!-- Leyenda-->
                <div class="Form-group Form-group--horizontal">
                    <label for="mb_corp_legend" class="Form-label">Leyend: </label>
                    <input class="Form-input" type="text" name="mb_corp_legend" id="mb_corp_legend" value="<?php echo $corp_legend; ?>" />
                </div>
            </article>
            
            <article class="Block-column-3 Block">
                <h2 class="Block-column-title text-center">Preferencial</h2>
                
                <!-- Mount-->
                <div class="Form-group Form-group--horizontal">
                    <label for="mb_pref_mount" class="Form-label">Monto: </label>
                    <input class="Form-input" type="text" name="mb_pref_mount" id="mb_pref_mount" value="<?php echo $pref_mount; ?>" />
                </div>
                
                <!-- Leyenda-->
                <div class="Form-group Form-group--horizontal">
                    <label for="mb_pref_legend" class="Form-label">Leyenda: </label>
                    <input class="Form-input" type="text" name="mb_pref_legend" id="mb_pref_legend" value="<?php echo $pref_legend; ?>" />
                </div>
            </article>
        </section>
    </fieldset>
     */ ?>

    <fieldset>
        <legend>Conocer más</legend>
        <p>
            <label for="mb_about"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_about',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($about, 'mb_about', $settings);
            ?>
        </p>
    </fieldset>
    
    <fieldset>
        <legend>Plan de Estudio</legend>
        <p>
            <label for="mb_plan"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_plan',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($plan, 'mb_plan', $settings);
            ?>
        </p>
        
        <div class="container-upload-file">
            <p class="btn-add-file">
                <a title="Agregar Plan" href="javascript:;" class="set-file button button-primary">Añadir Plan de Estudio</a>
            </p>

            <div class="hidden media-container">
                <p>
                    <span class="dashicons dashicons-media-default"></span>
                    <span class="name">Plan de Estudio</span>
                </p>
            </div><!-- .media-container -->

            <p class="hidden">
                <a title="Remove Footer Image" href="javascript:;" class="remove-file button button-secondary">Quitar Plan de Estudio</a>
            </p>

            <p class="media-info">
                <input class="hd-src" type="hidden" name="mb_planstudy" value="<?php echo $planstudy; ?>" />
            </p><!-- .media-info -->
        </div><!-- end container-upload-file -->
    </fieldset>
    
    <fieldset>
        <legend>Horarios</legend>
        <p>
            <label for="mb_horario"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_horario',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($horario, 'mb_horario', $settings);
            ?>
        </p>
    </fieldset>
    
    <fieldset>
        <legend>Inscripción</legend>
        <p>
            <label for="mb_inscription"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_inscription',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($inscription, 'mb_inscription', $settings);
            ?>
        </p>
    </fieldset>
</div><!-- #single-post-meta-manager -->