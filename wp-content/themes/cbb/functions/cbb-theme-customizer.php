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

  // Infraestructura
  $wp_customize->add_section('cbb_locals', [
    'title' => __('Infraestructura', THEMEDOMAIN),
    'description' => __('Configuración página Infraestructura', THEMEDOMAIN),
    'priority' => 36
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
}
