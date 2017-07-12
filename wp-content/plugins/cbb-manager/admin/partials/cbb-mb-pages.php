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
        $poster = isset($values['mb_poster']) ? esc_attr($values['mb_poster'][0]) : '';
        $webm = isset($values['mb_webm']) ? esc_attr($values['mb_webm'][0]) : '';
        $mp4 = isset($values['mb_mp4']) ? esc_attr($values['mb_mp4'][0]) : '';
        $ogv = isset($values['mb_ogv']) ? esc_attr($values['mb_ogv'][0]) : '';
        
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
    
    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Videos</legend>
        
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
</div><!-- #single-post-meta-manager -->