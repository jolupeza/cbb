<?php
/**
 * Displays the user interface for the CBB Manager meta box by type content Pages.
 *
 * This is a partial template that is included by the CBB Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-pages-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
        $template = isset($values['mb_template']) ? esc_attr($values['mb_template'][0]) : '';
        $youtube = isset($values['mb_youtube']) ? esc_attr($values['mb_youtube'][0]) : '';
        $poster = isset($values['mb_poster']) ? esc_attr($values['mb_poster'][0]) : '';
        $webm = isset($values['mb_webm']) ? esc_attr($values['mb_webm'][0]) : '';
        $mp4 = isset($values['mb_mp4']) ? esc_attr($values['mb_mp4'][0]) : '';
        $ogv = isset($values['mb_ogv']) ? esc_attr($values['mb_ogv'][0]) : '';
        $poster2 = isset($values['mb_poster2']) ? esc_attr($values['mb_poster2'][0]) : '';
        $webm2 = isset($values['mb_webm2']) ? esc_attr($values['mb_webm2'][0]) : '';
        $mp42 = isset($values['mb_mp42']) ? esc_attr($values['mb_mp42'][0]) : '';
        $ogv2 = isset($values['mb_ogv2']) ? esc_attr($values['mb_ogv2'][0]) : '';
        $poster3 = isset($values['mb_poster3']) ? esc_attr($values['mb_poster3'][0]) : '';
        $webm3 = isset($values['mb_webm3']) ? esc_attr($values['mb_webm3'][0]) : '';
        $mp43 = isset($values['mb_mp43']) ? esc_attr($values['mb_mp43'][0]) : '';
        $ogv3 = isset($values['mb_ogv3']) ? esc_attr($values['mb_ogv3'][0]) : '';
        $pdf = isset($values['mb_pdf']) ? esc_attr($values['mb_pdf'][0]) : '';
        $titleMainColor = !empty($values['mb_title_main_color']) ? esc_attr($values['mb_title_main_color'][0]) : 'red';
        $icon = isset($values['mb_icon']) ? esc_attr($values['mb_icon'][0]) : '';
        $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
        $page = isset($values['mb_page']) ? (int)esc_attr($values['mb_page'][0]) : '';
        $text = isset($values['mb_text']) ? esc_attr($values['mb_text'][0]) : '';
        $buttonAlign = !empty($values['mb_button_align']) ? esc_attr($values['mb_button_align'][0]) : 'center';
        $buttonSize = !empty($values['mb_button_size']) ? esc_attr($values['mb_button_size'][0]) : 'small';
        $buttonColor = !empty($values['mb_button_color']) ? esc_attr($values['mb_button_color'][0]) : 'red';
        $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
        $title = isset($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
        $subtitle = isset($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';

        $more = !empty($values['mb_more']) ? esc_attr($values['mb_more'][0]) : 'off';

        wp_nonce_field('pages_meta_box_nonce', 'meta_box_nonce');
    ?>

    <!-- Template-->
    <p class="content-mb">
        <label for="mb_template">Seleccionar Plantilla: </label>
        <select name="mb_template" id="mb_template">
            <option value="" <?php selected($template, ''); ?>>-- Seleccione plantilla --</option>

        <?php
            $args = array(
                'post_type' => 'templates',
                'posts_per_page' => -1
            );
            $templates = new WP_Query($args);
            if ($templates->have_posts()) :
                while ($templates->have_posts()) :
                    $templates->the_post();
                    $id = get_the_ID();
        ?>
            <option value="<?php echo $id; ?>" <?php selected($template, $id); ?>><?php the_title(); ?></option>
        <?php
                endwhile;
            endif;
            wp_reset_postdata();
        ?>

        </select>
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

    <!-- youtube -->
    <p class="content-mb">
        <label for="mb_youtube">Ids vídeo youtube (si son más de dos separarlos con ";"): </label>
        <input type="text" name="mb_youtube" id="mb_youtube" value="<?php echo $youtube; ?>" />
    </p>

    <!-- More -->
    <p class="content-mb">
        <label for="mb_more">Mostrar información adicional:</label>
        <input type="checkbox" name="mb_more" id="mb_more" <?php checked($more, 'on'); ?> />
    </p>

    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Video 1</legend>
        
        <section class="GroupForm-flex">
            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Poster Imagen</h4>
                
                <p class="btn-add-file">
                    <a title="Agregar poster" href="javascript:;" class="set-file button button-primary">Añadir poster</a>
                </p>

                <div class="hidden media-container">
                    <img src="<?php echo $poster; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true ); ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true ); ?>" />
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar poster" href="javascript:;" class="remove-file button button-secondary">Quitar poster</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_poster" value="<?php echo $poster; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
            
            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video Webm</h4>
                
                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_webm" value="<?php echo $webm; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->

            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video MP4</h4>

                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_mp4" value="<?php echo $mp4; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->

            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video OGV</h4>

                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_ogv" value="<?php echo $ogv; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
        </section>
    </fieldset><!-- end GroupFrm -->

    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Video 2</legend>
        
        <section class="GroupForm-flex">
            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Poster Imagen</h4>
                
                <p class="btn-add-file">
                    <a title="Agregar poster" href="javascript:;" class="set-file button button-primary">Añadir poster</a>
                </p>

                <div class="hidden media-container">
                    <img src="<?php echo $poster2; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true ); ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true ); ?>" />
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar poster" href="javascript:;" class="remove-file button button-secondary">Quitar poster</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_poster2" value="<?php echo $poster2; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
            
            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video Webm</h4>
                
                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar video" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_webm2" value="<?php echo $webm2; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->

            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video MP4</h4>

                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar video" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_mp42" value="<?php echo $mp42; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->

            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video OGV</h4>

                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar video" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_ogv2" value="<?php echo $ogv2; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
        </section>
    </fieldset><!-- end GroupFrm -->

    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Video 3</legend>
        
        <section class="GroupForm-flex">
            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Poster Imagen</h4>
                
                <p class="btn-add-file">
                    <a title="Agregar poster" href="javascript:;" class="set-file button button-primary">Añadir poster</a>
                </p>

                <div class="hidden media-container">
                    <img src="<?php echo $poster3; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true ); ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true ); ?>" />
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar poster" href="javascript:;" class="remove-file button button-secondary">Quitar poster</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_poster3" value="<?php echo $poster3; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
            
            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video Webm</h4>
                
                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar video" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_webm3" value="<?php echo $webm3; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->

            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video MP4</h4>

                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar video" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_mp43" value="<?php echo $mp43; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->

            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Video OGV</h4>

                <p class="btn-add-file">
                    <a title="Agregar video" href="javascript:;" class="set-file button button-primary">Añadir video</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-video-alt"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar video" href="javascript:;" class="remove-file button button-secondary">Quitar video</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_ogv3" value="<?php echo $ogv3; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
        </section>
    </fieldset><!-- end GroupFrm -->

    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">PDF</legend>
        
        <section class="GroupForm-flex GroupForm-flex--center">
            <div class="container-upload-file GroupForm-wrapperImage">
                <h4 class="Fieldset-subtitle">Enlace PDF</h4>
                
                <p class="btn-add-file">
                    <a title="Agregar pdf" href="javascript:;" class="set-file button button-primary">Añadir PDF</a>
                </p>

                <div class="hidden media-container">
                    <i class="Fieldset-icon dashicons-before dashicons-media-text"></i>
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar pdf" href="javascript:;" class="remove-file button button-secondary">Quitar PDF</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_pdf" value="<?php echo $pdf; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
        </section>
    </fieldset>

    <!-- Title Main Color -->
    <p class="content-mb">
        <label for="mb_title_main_color">Color título principal: </label>
        <select name="mb_title_main_color" id="mb_title_main_color">
            <option value="white" <?php selected($titleMainColor, 'white'); ?>>Blanco</option>
            <option value="red" <?php selected($titleMainColor, 'red'); ?>>Rojo</option>
            <option value="gray" <?php selected($titleMainColor, 'gray'); ?>>Gris</option>
            <option value="azul" <?php selected($titleMainColor, 'azul'); ?>>Azul</option>
            <option value="celeste" <?php selected($titleMainColor, 'celeste'); ?>>Celeste</option>
        </select>
    </p>

    <!-- Icon -->
    <p class="content-mb">
        <label for="mb_icon">Seleccionar Ícono: </label>
        <select name="mb_icon" id="mb_icon">
            <option value="" <?php selected($icon, ''); ?>>-- Seleccione ícono --</option>
            <option value="actividad-ludica" <?php selected($icon, 'actividad-ludica'); ?>>Actividad lúdica</option>
            <option value="autonomia" <?php selected($icon, 'autonomia'); ?>>Autonomía</option>
            <option value="desarrollo-academico" <?php selected($icon, 'desarrollo-academico'); ?>>Desarrollo académico</option>
            <option value="desarrollo-cientifico" <?php selected($icon, 'desarrollo-cientifico'); ?>>Desarrollo científico</option>
            <option value="desarrollo-vocacional" <?php selected($icon, 'desarrollo-vocacional'); ?>>Desarrollo vocacional</option>
            <option value="ejercicio-de-ciudadania" <?php selected($icon, 'ejercicio-de-ciudadania'); ?>>Ejercicio de ciudadania</option>
            <option value="formacion-de-sentimientos" <?php selected($icon, 'formacion-de-sentimientos'); ?>>Formación de sentimientos</option>
            <option value="habilidad-investigativa" <?php selected($icon, 'habilidad-investigativa'); ?>>Habilidad investigativa</option>
            <option value="protagonismo" <?php selected($icon, 'protagonismo'); ?>>Protagonismo</option>
            <option value="trabajo-cooperativo" <?php selected($icon, 'trabajo-cooperativo'); ?>>Trabajo cooperativo</option>
        </select>
    </p>

    <!-- Texto principal -->
    <p class="content-mb">
        <label for="mb_title">Texto principal: </label>
        <input type="text" name="mb_title" id="mb_title" value="<?php echo $title; ?>" />
    </p>

    <!-- Texto secundario -->
    <p class="content-mb">
        <label for="mb_subtitle">Texto secundario: </label>
        <input type="text" name="mb_subtitle" id="mb_subtitle" value="<?php echo $subtitle; ?>" />
    </p>

    <!-- Texto enlace-->
    <p class="content-mb">
        <label for="mb_text">Texto botón enlace: </label>
        <input type="text" name="mb_text" id="mb_text" value="<?php echo $text; ?>" />
    </p>

    <!-- Button align -->
    <p class="content-mb">
        <label for="mb_button_align">Alineación del bóton: </label>
        <select name="mb_button_align" id="mb_button_align">
            <option value="left" <?php selected($buttonAlign, 'left'); ?>>Izquierda</option>
            <option value="center" <?php selected($buttonAlign, 'center'); ?>>Centrado</option>
            <option value="right" <?php selected($buttonAlign, 'right'); ?>>Derecho</option>
        </select>
    </p>

    <!-- Button size -->
    <p class="content-mb">
        <label for="mb_button_size">Tamaño del bóton: </label>
        <select name="mb_button_size" id="mb_button_size">
            <option value="big" <?php selected($buttonSize, 'big'); ?>>Grande</option>
            <option value="medium" <?php selected($buttonSize, 'medium'); ?>>Normal</option>
            <option value="small" <?php selected($buttonSize, 'small'); ?>>Pequeño</option>
        </select>
    </p>

    <!-- Button color -->
    <p class="content-mb">
        <label for="mb_button_color">Color del bóton: </label>
        <select name="mb_button_color" id="mb_button_color">
            <option value="red" <?php selected($buttonColor, 'red'); ?>>Rojo</option>
            <option value="blue" <?php selected($buttonColor, 'blue'); ?>>Azul</option>
            <option value="yellow" <?php selected($buttonColor, 'yellow'); ?>>Amarillo</option>
        </select>
    </p>

    <!-- URL-->
    <p class="content-mb">
        <label for="mb_url">Url: </label>
        <input type="text" name="mb_url" id="mb_url" value="<?php echo $url; ?>" />
    </p>

    <!-- Target-->
    <p class="content-mb">
        <label for="mb_target">Mostrar en otra pestaña:</label>
        <input type="checkbox" name="mb_target" id="mb_target" <?php checked($target, 'on'); ?> />
    </p>

<?php
    $args = [
        'post_type' => 'page',
        'posts_per_page' => -1,
        'post_parent' => 0
    ];
    $pages = new WP_Query($args);

    if ($pages->have_posts()) :
?>
    <p class="content-mb">
        <label for="mb_page">Seleccionar página a enlazar</label>
        <select name="mb_page" id="mb_page">
            <option value="" <?php selected($page, ''); ?>>-- Seleccione página a enlazar --</option>

            <?php while ($pages->have_posts()) : ?>
                <?php $pages->the_post(); ?>
            <option value="<?php echo get_the_ID(); ?>" <?php selected($page, get_the_ID()); ?>><?php the_title(); ?></option>
            <?php endwhile; ?>

        </select>
    </p>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
</div><!-- #single-post-meta-manager -->