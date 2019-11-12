<?php if (!empty($webm) || !empty($mp4) || !empty($ogv)) : ?>
    <section class="Video text-center">
        <video class="img-responsive" autoplay="true" loop="true" poster="<?php echo $poster; ?>">
            <?php if (!empty($webm)) : ?>
                <source src="<?php echo $webm; ?>" type="video/webm" />
            <?php endif; ?>

            <?php if (!empty($mp4)) : ?>
                <source src="<?php echo $mp4; ?>" type="video/mp4" />
            <?php endif; ?>

            <?php if (!empty($ogv)) : ?>
                <source src="<?php echo $ogv; ?>" type="video/ogg" />
            <?php endif; ?>
            Su navegador no admite etiquetas de video HTML5.
        </video>

        <?php if (is_object($previousNextItemMenu['prev'])) : ?>
            <?php $prev = $previousNextItemMenu['prev']; ?>
            <a href="<?php echo $prev->url; ?>" class="left NavMenu">
                <span><?php echo strtolower($prev->title); ?></span>
                <i class="glyphicon glyphicon-chevron-left"></i>
            </a>
        <?php endif; ?>

        <?php if (is_object($previousNextItemMenu['next'])) : ?>
            <?php $next = $previousNextItemMenu['next']; ?>
            <a href="<?php echo $next->url; ?>" class="right NavMenu">
                <span><?php echo strtolower($next->title); ?></span>
                <i class="glyphicon glyphicon-chevron-right"></i>
            </a>
        <?php endif; ?>
    </section>
<?php elseif (!empty($term)) : ?>
    <?php
        $args = [
            'post_type' => 'sliders',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'tax_query' => [
                [
                    'taxonomy' => 'sections',
                    'field' => 'slug',
                    'terms' => $term,
                ]
            ]
        ];

        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) :
            $i = 0; $j = 0;
    ?>

            <section id="carousel-<?php esc_attr_e($term); ?>" class="carousel slide Carousel Carousel--home" data-ride="carousel">
                <?php if ($the_query->post_count > 1) : ?>
                    <ol class="carousel-indicators">
                    <?php while ($the_query->have_posts()) : ?>
                        <?php $the_query->the_post(); ?>
                        <li data-target="#carousel-<?php esc_attr_e($term); ?>" data-slide-to="<?php echo $j; ?>"<?php echo ($j === 0) ? 'class="active"' : ''; ?>></li>
                        <?php $j++ ?>
                    <?php endwhile; ?>
                    </ol>
                <?php endif; ?>

                <div class="carousel-inner" role="listbox">
                    <?php while ($the_query->have_posts()) : ?>
                        <?php $the_query->the_post(); ?>

                        <?php
                            $values = get_post_custom(get_the_id());
                            $title = isset($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
                            $subtitle = isset($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';
                            $text = isset($values['mb_text']) ? esc_attr($values['mb_text'][0]) : '';
                            $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
                            $pageLink = isset($values['mb_page']) ? (int)esc_attr($values['mb_page'][0]) : 0;
                            $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
                            $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
                            $align = isset($values['mb_align']) ? esc_attr($values['mb_align'][0]) : 'left';
                            $responsive = isset($values['mb_responsive']) ? esc_attr($values['mb_responsive'][0]) : '';
                        ?>
                        <div class="item<?php echo ($i === 0) ? ' active' : ''; ?>">
                            <?php if (has_post_thumbnail()) : ?>
                            <picture>
                                <source class="img-responsive center-block" media="(max-width: 767px) and (orientation: portrait)" srcset="<?php echo $responsive; ?>" alt="<?php echo get_the_title(); ?>" />
                                <?php the_post_thumbnail('full', [
                                    'class' => 'img-responsive center-block',
                                    'alt' => get_the_title()
                                ]);
                                ?>
                            </picture>
                            <?php endif; ?>

                            <div class="carousel-caption carousel-caption--<?php echo $align; ?>">
                            <?php if (!empty($subtitle)) : ?><h3><?php echo $subtitle; ?></h3><?php endif; ?>
                            <?php if (!empty($title)) : ?><h2><?php echo $title; ?></h2><?php endif; ?>
                            <?php the_content(); ?>

                            <?php if (!empty($url) || $pageLink > 0) : ?>
                                <?php $link = ($pageLink > 0) ? get_page_link($pageLink) : $url; ?>
                                <p><a class="Button Button--red" href="<?php echo $link; ?>"<?php echo $target; ?>><?php echo $text; ?></a></p>
                            <?php endif; ?>
                            </div>
                        </div>
                        <?php $i++; ?>
                    <?php endwhile; ?>
                </div>

                <button class="Arrow js-move-scroll" data-href="content">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>

                <?php if (is_object($previousNextItemMenu['prev'])) : ?>
                    <?php $prev = $previousNextItemMenu['prev']; ?>
                    <a href="<?php echo $prev->url; ?>" class="left NavMenu">
                        <span><?php echo strtolower($prev->title); ?></span>
                        <i class="glyphicon glyphicon-chevron-left"></i>
                    </a>
                <?php endif; ?>

                <?php if (is_object($previousNextItemMenu['next'])) : ?>
                    <?php $next = $previousNextItemMenu['next']; ?>
                    <a href="<?php echo $next->url; ?>" class="right NavMenu">
                        <span><?php echo strtolower($next->title); ?></span>
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </section>
            <?php wp_reset_postdata(); ?>
    <?php endif; ?>
<?php endif; ?>