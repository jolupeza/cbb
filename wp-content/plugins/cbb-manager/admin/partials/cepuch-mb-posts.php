<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Posts.
 *
 * This is a partial template that is included by the Cepuch Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-posts-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $avatar = isset( $values['mb_avatar'] ) ? esc_attr($values['mb_avatar'][0]) : '';
        $date = isset( $values['mb_date'] ) ? esc_attr($values['mb_date'][0]): '';
        $dateEnd = isset( $values['mb_date_end'] ) ? esc_attr($values['mb_date_end'][0]): '';
        $time = isset( $values['mb_time'] ) ? esc_attr($values['mb_time'][0]): '';
        $site = isset( $values['mb_site'] ) ? esc_attr($values['mb_site'][0]): '';
        $price = isset( $values['mb_price'] ) ? esc_attr($values['mb_price'][0]): '';
        $link = isset( $values['mb_link'] ) ? esc_attr($values['mb_link'][0]): '';
        $link_text = isset( $values['mb_link_text'] ) ? esc_attr($values['mb_link_text'][0]): '';

        wp_nonce_field( 'posts_meta_box_nonce', 'meta_box_nonce' );
    ?>

    <p class="content-mb">
        <label for="mb_date">Fecha inicial del evento:</label>
        <input type="date" name="mb_date" id="mb_date" value="<?php echo $date; ?>" />
    </p>

    <p class="content-mb">
        <label for="mb_date_end">Fecha final del evento:</label>
        <input type="date" name="mb_date_end" id="mb_date_end" value="<?php echo $dateEnd; ?>" />
    </p>

    <p class="content-mb">
        <label for="mb_time">Hora del evento:</label>
        <input type="text" name="mb_time" id="mb_time" value="<?php echo $time; ?>" />
    </p>

    <p class="content-mb">
        <label for="mb_site">Lugar del evento:</label>
        <input type="text" name="mb_site" id="mb_site" value="<?php echo $site; ?>" />
    </p>

    <p class="content-mb">
        <label for="mb_price">Costo del evento:</label>
        <input type="text" name="mb_price" id="mb_price" value="<?php echo $price; ?>" />
    </p>

    <p class="content-mb">
        <label for="mb_link_text">Texto enlace:</label>
        <input type="text" name="mb_link_text" id="mb_link_text" value="<?php echo $link_text; ?>" />
    </p>

    <p class="content-mb">
        <label for="mb_link">Enlace evento:</label>
        <input type="text" name="mb_link" id="mb_link" value="<?php echo $link; ?>" />
    </p>

    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Avatar</legend>

        <div class="container-upload-file GroupForm-wrapperImage">
            <p class="btn-add-file">
                <a title="Set Slider Image" href="javascript:;" class="set-file button button-primary">Añadir</a>
            </p>

            <div class="hidden media-container">
                <img src="<?php echo $avatar; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true ); ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true ); ?>" />
            </div><!-- .media-container -->

            <p class="hidden">
                <a title="Qutar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar</a>
            </p>

            <p class="media-info">
                <input class="hd-src" type="hidden" name="mb_avatar" value="<?php echo $avatar; ?>" />
            </p><!-- .media-info -->
        </div><!-- end container-upload-file -->

    </fieldset><!-- end GroupFrm -->
</div><!-- #single-post-meta-manager -->
