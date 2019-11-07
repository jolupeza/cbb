<?php
/***********************************************************************************************/
/* Add a menu option to link to the customizer */
/***********************************************************************************************/
add_action('admin_menu', 'display_custom_options_link');

function display_custom_options_link() {
    add_theme_page('Theme CBB Options', 'Theme CBB Options', 'edit_theme_options', 'customize.php');
}

/***********************************************************************************************/
/* Add a menu option to link to the customizer */
/***********************************************************************************************/
add_action('customize_register', 'cbb_customize_register');

function cbb_customize_register($wp_customize) {
  // Links Social Media
  $wp_customize->add_section('cbb_social', [
    'title' => __('Links Redes Sociales', THEMEDOMAIN),
    'description' => __('Mostrar links a redes sociales', THEMEDOMAIN),
    'priority' => 35
  ]);

  $wp_customize->add_setting('cbb_custom_settings[display_social_link]', [
    'default' => 0,
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[display_social_link]', [
    'label' => __('¿Mostrar links?', THEMEDOMAIN),
    'section' => 'cbb_social',
    'settings' => 'cbb_custom_settings[display_social_link]',
    'type' => 'checkbox'
  ]);

  // Facebook
  $wp_customize->add_setting('cbb_custom_settings[facebook]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[facebook]', [
    'label' => __('Facebook', THEMEDOMAIN),
    'section' => 'cbb_social',
    'settings' => 'cbb_custom_settings[facebook]',
    'type' => 'text'
  ]);

  // Whatsapp
  $wp_customize->add_setting('cbb_custom_settings[whatsapp]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[whatsapp]', [
    'label' => __('Whatsapp', THEMEDOMAIN),
    'section' => 'cbb_social',
    'settings' => 'cbb_custom_settings[whatsapp]',
    'type' => 'text'
  ]);

  // Twitter
  $wp_customize->add_setting('cbb_custom_settings[twitter]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[twitter]', [
    'label' => __('Twitter', THEMEDOMAIN),
    'section' => 'cbb_social',
    'settings' => 'cbb_custom_settings[twitter]',
    'type' => 'text'
  ]);

  // Flickr
  $wp_customize->add_setting('cbb_custom_settings[flickr]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[flickr]', [
    'label' => __('Flickr', THEMEDOMAIN),
    'section' => 'cbb_social',
    'settings' => 'cbb_custom_settings[flickr]',
    'type' => 'text'
  ]);

  // Youtube
  $wp_customize->add_setting('cbb_custom_settings[youtube]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[youtube]', [
    'label' => __('Youtube', THEMEDOMAIN),
    'section' => 'cbb_social',
    'settings' => 'cbb_custom_settings[youtube]',
    'type' => 'text'
  ]);

  // Alexia
  $wp_customize->add_setting('cbb_custom_settings[alexia]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[alexia]', [
    'label' => __('Alexia', THEMEDOMAIN),
    'section' => 'cbb_social',
    'settings' => 'cbb_custom_settings[alexia]',
    'type' => 'text'
  ]);

  $wp_customize->add_setting('cbb_custom_settings[display_admision_link]', [
    'default' => 0,
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[display_admision_link]', [
    'label' => __('¿Mostrar enlace Admisión?', THEMEDOMAIN),
    'section' => 'cbb_social',
    'settings' => 'cbb_custom_settings[display_admision_link]',
    'type' => 'checkbox'
  ]);

  // Homepage
  $wp_customize->add_section('cbb_home', [
    'title' => __('Página de Inicio', THEMEDOMAIN),
    'description' => __('Configuración página de Inicio', THEMEDOMAIN),
    'priority' => 36
  ]);

  $wp_customize->add_setting('cbb_custom_settings[home_video_img]', array(
    'type' => 'option'
  ));

  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'home_video_img', array(
    'label' => __('Poster Video', THEMEDOMAIN),
    'section' => 'cbb_home',
    'settings' => 'cbb_custom_settings[home_video_img]'
  )));

  $wp_customize->add_setting('cbb_custom_settings[home_video_webm]', array(
    'type' => 'option'
  ));

  $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'home_video_webm', array(
    'label' => __('Formato Webm', THEMEDOMAIN),
    'section' => 'cbb_home',
    'settings' => 'cbb_custom_settings[home_video_webm]'
  )));

  $wp_customize->add_setting('cbb_custom_settings[home_video_mp4]', array(
    'type' => 'option'
  ));

  $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'home_video_mp4', array(
    'label' => __('Formato Mp4', THEMEDOMAIN),
    'section' => 'cbb_home',
    'settings' => 'cbb_custom_settings[home_video_mp4]'
  )));

  $wp_customize->add_setting('cbb_custom_settings[home_video_ogv]', array(
    'type' => 'option'
  ));

  $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'home_video_ogv', array(
    'label' => __('Formato Ogv', THEMEDOMAIN),
    'section' => 'cbb_home',
    'settings' => 'cbb_custom_settings[home_video_ogv]'
  )));

  // Infraestructura
  $wp_customize->add_section('cbb_locals', [
    'title' => __('Infraestructura', THEMEDOMAIN),
    'description' => __('Configuración página Infraestructura', THEMEDOMAIN),
    'priority' => 37
  ]);

  $sections = get_terms('sections');
  $sects = [];
  $i = 0;

  foreach ($sections as $section) {
    if ($i === 0) {
      $default = $section->term_id;
      $i++;
    }

    $sects[$section->term_id] = $section->name;
  }

  $wp_customize->add_setting('cbb_custom_settings[slider]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[slider]', array(
    'label'      => __('Sliders', THEMEDOMAIN),
    'section'    => 'cbb_locals',
    'settings'   => 'cbb_custom_settings[slider]',
    'type'       => 'select',
    'choices'    => $sects,
  ));

  $wp_customize->add_setting('cbb_custom_settings[infraestructura_video_img]', array(
    'type' => 'option'
  ));

  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'infraestructura_video_img', array(
    'label' => __('Poster Video', THEMEDOMAIN),
    'section' => 'cbb_locals',
    'settings' => 'cbb_custom_settings[infraestructura_video_img]'
  )));

  $wp_customize->add_setting('cbb_custom_settings[infraestructura_video_webm]', array(
    'type' => 'option'
  ));

  $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'infraestructura_video_webm', array(
    'label' => __('Formato Webm', THEMEDOMAIN),
    'section' => 'cbb_locals',
    'settings' => 'cbb_custom_settings[infraestructura_video_webm]'
  )));

  $wp_customize->add_setting('cbb_custom_settings[infraestructura_video_mp4]', array(
    'type' => 'option'
  ));

  $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'infraestructura_video_mp4', array(
    'label' => __('Formato Mp4', THEMEDOMAIN),
    'section' => 'cbb_locals',
    'settings' => 'cbb_custom_settings[infraestructura_video_mp4]'
  )));

  $wp_customize->add_setting('cbb_custom_settings[infraestructura_video_ogv]', array(
    'type' => 'option'
  ));

  $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'infraestructura_video_ogv', array(
    'label' => __('Formato Ogv', THEMEDOMAIN),
    'section' => 'cbb_locals',
    'settings' => 'cbb_custom_settings[infraestructura_video_ogv]'
  )));

  // Id Youtube
  $wp_customize->add_setting('cbb_custom_settings[infraestructura_youtube]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[infraestructura_youtube]', [
    'label' => __('Id video Youtube', THEMEDOMAIN),
    'section' => 'cbb_locals',
    'settings' => 'cbb_custom_settings[infraestructura_youtube]',
    'type' => 'text'
  ]);

  // Description
  $wp_customize->add_setting('cbb_custom_settings[infraestructura_desc]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[infraestructura_desc]', [
    'label' => __('Descripción', THEMEDOMAIN),
    'section' => 'cbb_locals',
    'settings' => 'cbb_custom_settings[infraestructura_desc]',
    'type' => 'textarea'
  ]);

  // Information
  $wp_customize->add_section('cbb_info', [
    'title' => __('Información de la Web', THEMEDOMAIN),
    'description' => __('Configuración acerca de información relevante de la Web', THEMEDOMAIN),
    'priority' => 38
  ]);

  // Email Contact
  $wp_customize->add_setting('cbb_custom_settings[email]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[email]', [
    'label' => __('Email', THEMEDOMAIN),
    'section' => 'cbb_info',
    'settings' => 'cbb_custom_settings[email]',
    'type' => 'text'
  ]);

  // Central phone
  $wp_customize->add_setting('cbb_custom_settings[phone]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[phone]', [
    'label' => __('Central Telefónica', THEMEDOMAIN),
    'section' => 'cbb_info',
    'settings' => 'cbb_custom_settings[phone]',
    'type' => 'text'
  ]);

  // Admisión
  $wp_customize->add_section('cbb_admision', [
    'title' => __('Admisión', THEMEDOMAIN),
    'description' => __('Configuración de parámetros de la sección de Admisión', THEMEDOMAIN),
    'priority' => 39
  ]);

  // Year
  $wp_customize->add_setting('cbb_custom_settings[admision_year]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[admision_year]', [
    'label' => __('Año Admisión', THEMEDOMAIN),
    'section' => 'cbb_admision',
    'settings' => 'cbb_custom_settings[admision_year]',
    'type' => 'text'
  ]);

  $wp_customize->add_setting('cbb_custom_settings[admision_page]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[admision_page]', array(
    'label'      => __('Página de Agradecimiento:', THEMEDOMAIN),
    'section'    => 'cbb_admision',
    'settings'   => 'cbb_custom_settings[admision_page]',
    'type'       => 'select',
    'choices'    => getPages(),
  ));

  // Text Emails
  $wp_customize->add_section('cbb_response_email', [
    'title' => __('Mensajes Emails', THEMEDOMAIN),
    'description' => __('Configurar los mensajes de respuesta a los formulario de contacto y registro de admisión', THEMEDOMAIN),
    'priority' => 40
  ]);

  // Response Contact
  $wp_customize->add_setting('cbb_custom_settings[response_contact]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[response_contact]', [
    'label' => __('Mensaje de respuesta al formulario de contacto', THEMEDOMAIN),
    'section' => 'cbb_response_email',
    'settings' => 'cbb_custom_settings[response_contact]',
    'type' => 'textarea'
  ]);

  // Response Admition
  $wp_customize->add_setting('cbb_custom_settings[response_admision]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[response_admision]', [
    'label' => __('Mensaje de respuesta al formulario de admisión', THEMEDOMAIN),
    'section' => 'cbb_response_email',
    'settings' => 'cbb_custom_settings[response_admision]',
    'type' => 'textarea'
  ]);

  // Messages user forms
  $wp_customize->add_section('cbb_response_forms', [
    'title' => __('Mensajes Respuesta Formularios', THEMEDOMAIN),
    'description' => __('Configurar los mensajes de respuesta al usuario de los formulario de contacto y registro de admisión', THEMEDOMAIN),
    'priority' => 41
  ]);

  // Response Contact
  $wp_customize->add_setting('cbb_custom_settings[response_contact_forms]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[response_contact_forms]', [
    'label' => __('Mensaje de respuesta del formulario de contacto', THEMEDOMAIN),
    'section' => 'cbb_response_forms',
    'settings' => 'cbb_custom_settings[response_contact_forms]',
    'type' => 'textarea'
  ]);

  // Response Admition
  $wp_customize->add_setting('cbb_custom_settings[response_admision_forms]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[response_admision_forms]', [
    'label' => __('Mensaje de respuesta del formulario de admisión', THEMEDOMAIN),
    'section' => 'cbb_response_forms',
    'settings' => 'cbb_custom_settings[response_admision_forms]',
    'type' => 'textarea'
  ]);

  // Information
  $wp_customize->add_panel('cbb_categories', [
    'title' => __('Categorías', THEMEDOMAIN),
    'description' => esc_html__('Configuraciones Categorías', THEMEDOMAIN),
    'priority' => 42,
    'capability' => 'edit_theme_options',
  ]);

  $wp_customize->add_section('cbb_blog', [
    'title' => __('Configuración Vida Escolar', THEMEDOMAIN),
    'description' => __('Configuración de opciones para la sección Vida Escolar', THEMEDOMAIN),
    'panel' => 'cbb_categories',
    'capability' => 'edit_theme_options',
  ]);

  $parallaxs = [];
  $args = array(
    'post_type' => 'parallaxs',
    'posts_per_page' => -1
  );

  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) {
    while ($the_query->have_posts()) {
      $the_query->the_post();
      $id = get_the_ID();
      $title = get_the_title();

      $parallaxs[$id] = $title;
    }
  }
  wp_reset_postdata();

  $wp_customize->add_setting('cbb_custom_settings[blog_parallax]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[blog_parallax]', array(
    'label'      => __('Parallax', THEMEDOMAIN),
    'section'    => 'cbb_blog',
    'settings'   => 'cbb_custom_settings[blog_parallax]',
    'type'       => 'select',
    'choices'    => $parallaxs,
  ));

  $wp_customize->add_setting('cbb_custom_settings[blog_menu]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[blog_menu]', array(
    'label'      => __('Menú Zonas', THEMEDOMAIN),
    'section'    => 'cbb_blog',
    'settings'   => 'cbb_custom_settings[blog_menu]',
    'type'       => 'select',
    'choices'    => getMenus(),
  ));

  $wp_customize->add_section('cbb_gallery', [
    'title' => __('Configuración Galería', THEMEDOMAIN),
    'description' => __('Configuración de opciones para la categoría Galería', THEMEDOMAIN),
    'panel' => 'cbb_categories',
    'capability' => 'edit_theme_options',
  ]);

  $wp_customize->add_setting('cbb_custom_settings[gallery_menu]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[gallery_menu]', array(
    'label'      => __('Menú Zonas', THEMEDOMAIN),
    'section'    => 'cbb_gallery',
    'settings'   => 'cbb_custom_settings[gallery_menu]',
    'type'       => 'select',
    'choices'    => getMenus(),
  ));

  // Pixel Facebook
  $wp_customize->add_section('cbb_pixel', [
    'title' => __('Configuración Pixel de Facebook', THEMEDOMAIN),
    'description' => __('Configuración de opciones para el funcionamiento de Pixel de Facebook', THEMEDOMAIN),
    'priority' => 43
  ]);

  // pixel code
  $wp_customize->add_setting('cbb_custom_settings[pixel_code]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[pixel_code]', [
    'label' => __('Código', THEMEDOMAIN),
    'section' => 'cbb_pixel',
    'settings' => 'cbb_custom_settings[pixel_code]',
    'type' => 'textarea'
  ]);

  $wp_customize->add_setting('cbb_custom_settings[pixel_all]', [
    'default' => 0,
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[pixel_all]', [
    'label' => __('¿Mostrar en todas las páginas?', THEMEDOMAIN),
    'section' => 'cbb_pixel',
    'settings' => 'cbb_custom_settings[pixel_all]',
    'type' => 'checkbox'
  ]);

  $wp_customize->add_setting('cbb_custom_settings[pixel_page]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[pixel_page]', array(
    'label'      => __('En página específica:', THEMEDOMAIN),
    'section'    => 'cbb_pixel',
    'settings'   => 'cbb_custom_settings[pixel_page]',
    'type'       => 'select',
    'choices'    => getPages(),
  ));

  // Google Ads
  $wp_customize->add_section('cbb_google_ads', [
    'title' => __('Configuración Google Ads', THEMEDOMAIN),
    'description' => __('Configuración de opciones para el funcionamiento de Google Ads', THEMEDOMAIN),
    'priority' => 44
  ]);

  // google ads code
  $wp_customize->add_setting('cbb_custom_settings[google_ads_code]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[google_ads_code]', [
    'label' => __('Código', THEMEDOMAIN),
    'section' => 'cbb_google_ads',
    'settings' => 'cbb_custom_settings[google_ads_code]',
    'type' => 'textarea'
  ]);

  $wp_customize->add_setting('cbb_custom_settings[google_ads_all]', [
    'default' => 0,
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[google_ads_all]', [
    'label' => __('¿Mostrar en todas las páginas?', THEMEDOMAIN),
    'section' => 'cbb_google_ads',
    'settings' => 'cbb_custom_settings[google_ads_all]',
    'type' => 'checkbox'
  ]);

  $wp_customize->add_setting('cbb_custom_settings[google_ads_page]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[google_ads_page]', array(
    'label'      => __('En página específica:', THEMEDOMAIN),
    'section'    => 'cbb_google_ads',
    'settings'   => 'cbb_custom_settings[google_ads_page]',
    'type'       => 'select',
    'choices'    => getPages(),
  ));

  // Calendar Settings
  $wp_customize->add_panel('cbb_calendar_panel', [
    'title' => __('Configuración Calendario Admisión', THEMEDOMAIN),
    'description' => esc_html__('Configuración de opciones para el calendario del formulario de Admisión', THEMEDOMAIN),
    'priority' => 45,
    'capability' => 'edit_theme_options',
  ]);

  $wp_customize->add_section('cbb_calendar', [
    'title' => __('Configuración General', THEMEDOMAIN),
    'description' => __('Configuración opciones generales', THEMEDOMAIN),
    'panel' => 'cbb_calendar_panel',
    'capability' => 'edit_theme_options',
  ]);

  // Placeholder Calendar
  $wp_customize->add_setting('cbb_custom_settings[placeholder_calendar]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[placeholder_calendar]', [
    'label' => __('Texto Calendario', THEMEDOMAIN),
    'section' => 'cbb_calendar',
    'settings' => 'cbb_custom_settings[placeholder_calendar]',
    'type' => 'text'
  ]);

  // Text Other schedule
  $wp_customize->add_setting('cbb_custom_settings[calendar_other]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[calendar_other]', [
    'label' => __('Texto Otro horario', THEMEDOMAIN),
    'section' => 'cbb_calendar',
    'settings' => 'cbb_custom_settings[calendar_other]',
    'type' => 'text'
  ]);

  // Text default select local
  $wp_customize->add_setting('cbb_custom_settings[admin_default_select_local]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[admin_default_select_local]', [
    'label' => __('Texto a mostrar cuando no ha seleccionado ninguna Sede', THEMEDOMAIN),
    'section' => 'cbb_calendar',
    'settings' => 'cbb_custom_settings[admin_default_select_local]',
    'type' => 'text'
  ]);

  $locals = getLocals();

  if (count($locals) > 0) {
    foreach ($locals as $key => $local) {
      $wp_customize->add_section("cbb_calendar_local_{$key}", [
        'title' => __($local, THEMEDOMAIN),
        'description' => __("Configuración sede {$local}", THEMEDOMAIN),
        'panel' => 'cbb_calendar_panel',
        'capability' => 'edit_theme_options'
      ]);

      $wp_customize->add_setting("cbb_custom_settings[schedule_status_{$key}]", [
        'default' => 0,
        'type' => 'option'
      ]);
    
      $wp_customize->add_control("cbb_custom_settings[schedule_status_{$key}]", [
        'label' => __('¿Mostrar horario personalizado?', THEMEDOMAIN),
        'section' => "cbb_calendar_local_{$key}",
        'settings' => "cbb_custom_settings[schedule_status_{$key}]",
        'type' => 'checkbox'
      ]);

      // Hour start
      $wp_customize->add_setting("cbb_custom_settings[hour_start_{$key}]", [
        'default' => '',
        'type' => 'option'
      ]);

      $wp_customize->add_control("cbb_custom_settings[hour_start_{$key}]", [
        'label' => __('Hora Inicial', THEMEDOMAIN),
        'section' => "cbb_calendar_local_{$key}",
        'settings' => "cbb_custom_settings[hour_start_{$key}]",
        'type' => 'text'
      ]);

      // Hour end
      $wp_customize->add_setting("cbb_custom_settings[hour_end_{$key}]", [
        'default' => '',
        'type' => 'option'
      ]);

      $wp_customize->add_control("cbb_custom_settings[hour_end_{$key}]", [
        'label' => __('Hora Final', THEMEDOMAIN),
        'section' => "cbb_calendar_local_{$key}",
        'settings' => "cbb_custom_settings[hour_end_{$key}]",
        'type' => 'text'
      ]);

      // Hour step
      $wp_customize->add_setting("cbb_custom_settings[hour_step_{$key}]", [
        'default' => '',
        'type' => 'option'
      ]);

      $wp_customize->add_control("cbb_custom_settings[hour_step_{$key}]", [
        'label' => __('Tiempo Saltos', THEMEDOMAIN),
        'section' => "cbb_calendar_local_{$key}",
        'settings' => "cbb_custom_settings[hour_step_{$key}]",
        'type' => 'text'
      ]);

      // Disabled Days
      $wp_customize->add_setting("cbb_custom_settings[disabled_days_{$key}]", [
        'default' => '',
        'type' => 'option'
      ]);

      $wp_customize->add_control("cbb_custom_settings[disabled_days_{$key}]", [
        'label' => __('Días no hábiles, separar con comas cada fecha', THEMEDOMAIN),
        'section' => "cbb_calendar_local_{$key}",
        'settings' => "cbb_custom_settings[disabled_days_{$key}]",
        'type' => 'textarea'
      ]);

      // Reception Email
      $wp_customize->add_setting("cbb_custom_settings[email_{$key}]", [
        'default' => '',
        'type' => 'option'
      ]);

      $wp_customize->add_control("cbb_custom_settings[email_{$key}]", [
        'label' => __('Correo Admin', THEMEDOMAIN),
        'section' => "cbb_calendar_local_{$key}",
        'settings' => "cbb_custom_settings[email_{$key}]",
        'type' => 'text'
      ]);
    }
  }

  // Calendar Settings
  $wp_customize->add_panel('cbb_general_panel', [
    'title' => __('Configuraciones Generales', THEMEDOMAIN),
    'description' => esc_html__('Configuración de opciones generales', THEMEDOMAIN),
    'priority' => 46,
    'capability' => 'edit_theme_options',
  ]);

  $wp_customize->add_section('cbb_page_contact', [
    'title' => __('Página de Contacto', THEMEDOMAIN),
    'description' => __('Establecer configuraciones de la página de Contacto', THEMEDOMAIN),
    'panel' => 'cbb_general_panel',
    'capability' => 'edit_theme_options',
  ]);

  // Text default select local
  $wp_customize->add_setting('cbb_custom_settings[cbb_default_select_local]', [
    'default' => '',
    'type' => 'option'
  ]);

  $wp_customize->add_control('cbb_custom_settings[cbb_default_select_local]', [
    'label' => __('Texto a mostrar cuando no ha seleccionado ninguna Sede', THEMEDOMAIN),
    'section' => 'cbb_page_contact',
    'settings' => 'cbb_custom_settings[cbb_default_select_local]',
    'type' => 'text'
  ]);
}

function getPages() {
  $pages = get_pages(['parent' => 0]);
  $listPages = ['' => "Seleccione"];

  foreach ($pages as $page) {
    $listPages[$page->ID] = $page->post_title;
  }

  return $listPages;
}

function getMenus() {
  $menus = get_registered_nav_menus();
  $listMenus = ['' => 'Seleccione'];

  foreach ($menus as $location => $description) {
    $listMenus[$location] = $description;
  }

  return $listMenus;
}
