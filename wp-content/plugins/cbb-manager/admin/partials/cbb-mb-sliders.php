<?php
/**
 * Displays the user interface for the CBB Manager meta box by type content Sliders.
 *
 * This is a partial template that is included by the CBB Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-sliders-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
        $title = isset($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
        $subtitle = isset($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';
        $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
        $page = isset($values['mb_page']) ? (int)esc_attr($values['mb_page'][0]) : '';
        $text = isset($values['mb_text']) ? esc_attr($values['mb_text'][0]) : '';
        $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
        $align = isset($values['mb_align']) ? esc_attr($values['mb_align'][0]) : '';

        wp_nonce_field( 'sliders_meta_box_nonce', 'meta_box_nonce' );
    ?>
    
    <!-- Texto superior -->
    <p class="content-mb">
        <label for="mb_subtitle">Texto superior: </label>
        <input type="text" name="mb_subtitle" id="mb_subtitle" value="<?php echo $subtitle; ?>" />
    </p>
    
    <!-- Texto inferior -->
    <p class="content-mb">
        <label for="mb_title">Texto inferior: </label>
        <input type="text" name="mb_title" id="mb_title" value="<?php echo $title; ?>" />
    </p>
    
    <!-- Texto enlace-->
    <p class="content-mb">
        <label for="mb_text">Texto enlace: </label>
        <input type="text" name="mb_text" id="mb_text" value="<?php echo $text; ?>" />
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
    
    <p class="content-mb">
        <label for="mb_align">Alineación texto:</label>
        <select name="mb_align" id="mb_align">
            <option value="" <?php selected($align, ''); ?>>-- Seleccione alineación --</option>            
            <option value="left" <?php selected($align, 'left'); ?>>Izquierda</option>
            <option value="center" <?php selected($align, 'center'); ?>>Centrado</option>
            <option value="right" <?php selected($align, 'right'); ?>>Derecha</option>
        </select>
    </p>
    
    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Imagen Responsive</legend>

        <section class="GroupForm-flex GroupForm-flex--center">
            <div class="container-upload-file GroupForm-wrapperImage">
                <!--<h4 class="Fieldset-subtitle">Enlace PDF</h4>-->

                <p class="btn-add-file">
                    <a title="Agregar imagen" href="javascript:;" class="set-file button button-primary">Añadir Imagen</a>
                </p>

                <div class="hidden media-container">
                    <img src="<?php echo $responsive; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true );  ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true );  ?>" />
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar Imagen</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_responsive" value="<?php echo $responsive; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
        </section>
    </fieldset>
</div><!-- #single-post-meta-manager -->