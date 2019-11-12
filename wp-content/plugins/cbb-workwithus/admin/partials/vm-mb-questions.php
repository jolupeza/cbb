<?php
/**
 * Displays the user interface for the VillaMaria Manager meta box.
 *
 * This is a partial template that is included by the VillaMaria Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-questions-id">
    <?php
        $values = get_post_custom(get_the_ID());

        $page = isset($values['mb_page']) ? esc_attr($values['mb_page'][0]) : '';

        wp_nonce_field('questions_meta_box_nonce', 'meta_box_nonce');
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
            <?php endif; ?>11
            <?php wp_reset_postdata(); ?>
        </select>
    </p>
</div><!-- #maletek-meta-manager -->