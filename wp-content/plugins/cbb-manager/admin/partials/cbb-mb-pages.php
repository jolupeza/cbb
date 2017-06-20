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
</div><!-- #single-post-meta-manager -->