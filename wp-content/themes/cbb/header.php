<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
  <head>
    <meta charset="<?php bloginfo('charset') ?>" />
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />

    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Script required for extra functionality on the comment form -->
    <?php if (is_singular()) wp_enqueue_script( 'comment-reply' ); ?>

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <header class="Header">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <?php
              $customLogoId = get_theme_mod('custom_logo');
              $logo = wp_get_attachment_image_src($customLogoId, 'full');
            ?>
            <h1 class="Header-logo">
              <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <img class="img-responsive center-block" src="<?php echo $logo[0]; ?>" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>" />
              </a>
            </h1>
          </div>
          <div class="col-md-9">
            <menu class="Header-menu">
              <ul class="MainMenu">
                <li><a href="">Nosotros</a></li>
                <li><a href="">Propuesta educativa</a></li>
                <li><a href="">Infraestructura</a></li>
                <li><a href="">Vida Escolar</a></li>
                <li><a href="">Contáctanos</a></li>
                <li><a href="">Repositorio</a></li>
                <li><a href="">Admisión</a></li>
              </ul>
            </menu>
          </div>
        </div>
      </div>
    </header>
