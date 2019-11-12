<div class="wrap">
 
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 
    <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">
        <h2 class="title">Formulario de Contacto</h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="admin-email">Formulario de Contact Email</label>
                </th>
                <td>
                    <input name="admin-email" type="text" id="admin-email" value="<?php echo esc_attr($email); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="subject-email">Asunto Formulario de Contacto</label>
                </th>
                <td>
                    <input name="subject-email" type="text" id="subject-email" value="<?php echo esc_attr($subjectEmail); ?>" class="large-text code" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="email-response">Mensaje de respuesta al cliente del formulario de contacto</label>
                </th>
                <td>
                    <textarea class="large-text code" name="email-response" id="email-response" rows="5" cols="50"><?php echo esc_attr($emailResponse); ?></textarea>
                </td>
            </tr>
            <?php /*
                $pages = get_pages([
                    'parent' => 0
                ]);
            ?>
            <tr>
                <th scope="row">
                    <label for="page-about">Página Nosotros</label>
                </th>
                <td>
                    <select name="page-about" id="page-about">
                        <option value="">-- Seleccione página Nosotros --</option>
                        <?php if (count($pages)) : ?>
                            <?php foreach ($pages as $page) : ?>
                                <option value="<?php echo $page->ID ?>" <?php selected($aboutPage, $page->ID); ?>><?php echo $page->post_title; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
             * 
             */ ?>
        </table>
        
        <?php /*
        <h2 class="title">Proyecto Actual</h2>
        <table class="form-table">
            <?php
            $args = [
                'post_type' => 'projects',
                'posts_per_page' => -1,
                'post_status' => 'publish'
            ];

            $projects = new WP_Query($args);
            ?>
            <tr>
                <th scope="row">
                    <label for="project-current">Proyecto Actual</label>
                </th>
                <td>
                    <select name="project-current" id="project-current">
                        <option value="">-- Seleccione proyecto actual --</option>
                        <?php if ($projects->have_posts()) : ?>
                            <?php while ($projects->have_posts()) : ?>
                                <?php $projects->the_post(); ?>
                                <option value="<?php echo get_the_ID() ?>" <?php selected($projectCurrent, get_the_ID()); ?>><?php the_title(); ?></option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_postdata(); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="project-current-title">Título Proyecto Actual</label>
                </th>
                <td>
                    <input name="project-current-title" type="text" id="project-current-title" value="<?php echo esc_attr($projectCurrentTitle); ?>" class="large-text code" />
                </td>
            </tr>
        </table>
         * 
         */ ?>
            
        <?php        
            wp_nonce_field( 'vm-manager-settings-save', 'vm-manager-custom-message' );
            
            submit_button();
        ?>
    </form>
 
</div><!-- .wrap -->