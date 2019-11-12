<?php
/**
 * Displays the user interface for the VillaMaria Manager meta box by type content Page.
 *
 * This is a partial template that is included by the VillaMaria Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-page-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $template = isset($values['mb_template']) ? esc_attr($values['mb_template'][0]) : '';
        $summary = !empty($values['mb_summary']) ? $values['mb_summary'][0] : '';
        $more = !empty($values['mb_more']) ? $values['mb_more'][0] : '';
        $important = !empty($values['mb_important']) ? $values['mb_important'][0] : '';
        $inHome = isset($values['mb_inhome']) ? esc_attr($values['mb_inhome'][0]) : 'off';
        
        wp_nonce_field('page_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <!-- Homepage -->
    <p class="content-mb">
        <label for="mb_inhome">¿Se muestra en el homepage?</label>
        <input type="checkbox" name="mb_inhome" id="mb_inhome" <?php checked($inHome, 'on'); ?> />
    </p>
    
    <?php
        $args = [
            'post_type' => 'templates',
            'posts_per_page' => -1,
        ];
        
        $templates = new WP_Query($args);
    ?>
    <!-- Template -->
    <p class="content-mb">
        <label for="mb_template">Plantillas: </label>
        <select name="mb_template" id="mb_template">
            <option value="">-- Seleccione plantilla --</option>
            <?php if ($templates->have_posts()) : ?>
                <?php while ($templates->have_posts()) : ?>
                    <?php 
                        $templates->the_post();
                        $vals = get_post_custom(get_the_ID());
                        $templateSlug = !empty($vals['mb_slug']) ? esc_attr($vals['mb_slug'][0]) : '';
                    ?>
                    <?php if (empty($templateSlug)) { continue; } ?>
                    <option value="<?php echo $templateSlug; ?>" <?php selected($template, $templateSlug); ?>><?php the_title(); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </select>
    </p>
    
    <!-- Summary -->
    <h2 class="Subtitle hndle"><span>Resumen:</span></h2>
    <?php
        $settings = array(
            'wpautop' => false,
            'textarea_name' => 'mb_summary',
            'media_buttons' => true,
            'textarea_rows' => 10,
        );
        wp_editor($summary, 'mb_summary', $settings);
    ?>
    
    <!-- More -->
    <h2 class="Subtitle hndle"><span>Más contenido:</span></h2>
    <?php
        $settingsMore = array(
            'wpautop' => false,
            'textarea_name' => 'mb_more',
            'media_buttons' => true,
            'textarea_rows' => 10,
        );
        wp_editor($more, 'mb_more', $settingsMore);
    ?>
    
    <!-- Important -->
    <h2 class="Subtitle hndle"><span>Destacado:</span></h2>
    <?php
        $settings = array(
            'wpautop' => false,
            'textarea_name' => 'mb_important',
            'media_buttons' => true,
            'textarea_rows' => 10,
        );
        wp_editor($important, 'mb_important', $settings);
    ?>
</div>