<?php
/**
 * Displays the user interface for the VillaMaria Manager meta box.
 *
 * This is a partial template that is included by the VillaMaria Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-fronts-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $page = isset($values['mb_page']) ? esc_attr($values['mb_page'][0]) : '';
        $post = isset( $values['mb_post'] ) ? esc_attr( $values['mb_post'][0] ) : '';
        $category = isset($values['mb_category']) ? esc_attr($values['mb_category'][0]) : 'off';
        $homepage = isset($values['mb_homepage']) ? esc_attr($values['mb_homepage'][0]) : 'off';
        $position = !empty($values['mb_position']) ? esc_attr($values['mb_position'][0]) : '';
        $image = !empty($values['mb_image']) ? esc_attr($values['mb_image'][0]) : '';

        wp_nonce_field('fronts_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <?php
        $args = [
            'post_type' => 'page',
            'posts_per_page' => -1,
        ];
        
        $pages = new WP_Query($args);
    ?>
    <!-- Page -->
    <p class="content-mb">
        <label for="mb_page">Páginas: </label>
        <select name="mb_page" id="mb_page">
            <option value="">-- Seleccione página --</option>
            <?php if ($pages->have_posts()) : ?>
                <?php while ($pages->have_posts()) : ?>
                    <?php $pages->the_post(); ?>
                    <option value="<?php echo get_the_ID(); ?>" <?php selected($page, get_the_ID()) ?>>
                        <?php echo wp_get_post_parent_id(get_the_ID()) ? get_the_title(wp_get_post_parent_id(get_the_ID())) . ' - ' : ''; ?><?php the_title(); ?>
                    </option>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </select>
    </p>
    
    <?php $posts = get_posts(); ?>    
    <!-- Post -->
    <p class="content-mb">
        <label for="mb_post">Entradas: </label>
        <select name="mb_post" id="mb_post">
            <option value="">-- Seleccione entrada --</option>
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $p) : ?>
                    <option value="<?php echo $p->ID; ?>" <?php selected($post, $p->ID) ?>><?php echo $p->post_title; ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </select>
    </p>
    
    <!-- Homepage -->
    <p class="content-mb">
        <label for="mb_homepage">Página de inicio:</label>
        <input type="checkbox" name="mb_homepage" id="mb_homepage" <?php checked($homepage, 'on'); ?> />
    </p>
    
    <!-- Category -->
    <p class="content-mb">
        <label for="mb_category">Vida Escolar:</label>
        <input type="checkbox" name="mb_category" id="mb_category" <?php checked($category, 'on'); ?> />
    </p>
    
    <?php
        $positions = [
            'left' => 'Izquierda Centrado',
            'right' => 'Derecha Centrado',
            'left-bottom' => 'Izquierda Inferior',
            'right-bottom' => 'Derecha Inferior',
        ];
    ?>
    <!-- Position -->
    <p class="content-mb">
        <label for="mb_position">Posición texto: </label>
        <select name="mb_position" id="mb_page">
            <option value="">-- Seleccione posicionamiento --</option>
                <?php foreach ($positions as $key => $value) : ?>
                    <option value="<?php echo $key; ?>" <?php selected($position, $key) ?>><?php echo $value; ?></option>
                <?php endforeach; ?>
        </select>
    </p>
    
    <!-- Image -->
    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Imagen responsive</legend>

        <section class="GroupForm-flex GroupForm-flex--center">
            <div class="container-upload-file GroupForm-wrapperImage">
                <h3 class="Fieldset-subtitle">Imagen 768 x 1278</h3>
                
                <p class="btn-add-file">
                    <a title="Agregar imagen" href="javascript:;" class="set-file button button-primary">Añadir Imagen</a>
                </p>

                <div class="hidden media-container">
                    <img src="<?php echo $image; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true );  ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true );  ?>" />
                </div><!-- .media-container -->

                <p class="hidden">
                    <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar Imagen</a>
                </p>

                <p class="media-info">
                    <input class="hd-src" type="hidden" name="mb_image" value="<?php echo $image; ?>" />
                </p><!-- .media-info -->
            </div><!-- end container-upload-file -->
        </section>
    </fieldset>
</div><!-- #maletek-meta-manager -->