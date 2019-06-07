<?php
/****************************************/
/* Define Constants */
/****************************************/
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT . '/images');
define('THEMEDOMAIN', 'cbb-framework');

/****************************************/
/* Load JS Files */
/****************************************/
function load_custom_scripts() {
  wp_enqueue_script('vendor_script', THEMEROOT . '/js/vendor.min.js', array('jquery'), false, true);
  wp_enqueue_script('main_script', THEMEROOT . '/js/main.js', array('jquery'), false, true);
  wp_enqueue_script('app_script', THEMEROOT.'/js/app.js', array(), false, true);
  wp_localize_script('main_script', 'CbbAjax', array('url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('cbbajax-nonce')));
}

add_action('wp_enqueue_scripts', 'load_custom_scripts');

/****************************************/
/* Add Theme Support */
/****************************************/
if ( function_exists('add_theme_support') ) {
  add_theme_support('post-thumbnails', array('post', 'page', 'sliders', 'partners', 'parallaxs', 'achievements', 'locals', 'banners'));
}

/****************************************/
/* Add Logo Theme */
/****************************************/
function my_theme_setup() {
  add_theme_support('custom-logo', [
    'height'  => 66,
    'width' => 225,
    'flex-height' => true
  ]);
}

add_action('after_setup_theme', 'my_theme_setup');

/****************************************/
/* Add Menus */
/****************************************/
function register_my_menus() {
  register_nav_menus([
    'main-menu' => __('Main Menu', THEMEDOMAIN),
    'categories-zone-menu' => __('Categorías Zona Menu', THEMEDOMAIN),
    'categories-zone-menu-galeria' => __('Categorías Zona Galería Menu', THEMEDOMAIN),
    'locals-menu' => __('Infraestructura Menu', THEMEDOMAIN),
    'footer-menu' => __('Footer Menu', THEMEDOMAIN),
  ]);
}

add_action('init', 'register_my_menus');

/****************************************/
/* Menu Walker Main Menu */
/****************************************/
class CBB_Walker_Nav_Menu extends Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    /*public function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }*/

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
    * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

        if ( $depth > 0 ) {
          $varPost = get_post($item->object_id);

          if (is_page($item->post_parent)) {
            $attributes .= ! empty($item->url) ? " href=\"#{$varPost->post_name}\"" : '';
            $attributes .= ' class="js-move-scroll menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
          } else {
            $url = get_permalink($item->post_parent) . "#{$varPost->post_name}";
            $attributes .= ! empty($item->url) ? " href=\"$url\"" : '';
            $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
          }
        } else {
          $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
          $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
        }


        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/****************************************/
/* Menu Walker Main Menu */
/****************************************/
class CBB_Walker_Nav_Menu_Hashtag extends Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    /*public function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }*/

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
    * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'#content"' : '';

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/****************************************/
/* Add Sidebar Support */
/****************************************/
if (function_exists('register_sidebar')) {
  $args = array(
    'name'          => __('Main Sidebar', THEMEDOMAIN),
    'id'            => 'main-sidebar',
    'description'   => __('Área sidebar buscador en Vida Escolar', THEMEDOMAIN),
    // 'class'         => '',
    'before_widget' => '<div class="Sidebar-widget">',
    'after_widget'  => '</div>',
    // 'before_title'  => '<h2 class="widgettitle">',
    // 'after_title'   => '</h2>'
  );

  register_sidebar($args);

  $args = array(
    'name'          => __('Entrada Sidebar', THEMEDOMAIN),
    'id'            => 'single-sidebar',
    'description'   => __('Área sidebar en detalle de noticias o entradas', THEMEDOMAIN),
    // 'class'         => '',
    'before_widget' => '<div class="Sidebar-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="Sidebar-title Single-related-title">',
    'after_title'   => '</h4>'
  );

  register_sidebar($args);
}

/****************************************/
/* Add Excerpt to Page */
/****************************************/
function cbb_add_excerpts_to_pages() {
  add_post_type_support('page', 'excerpt');
}

add_action('init', 'cbb_add_excerpts_to_pages');

/****************************************/
/* Search only Posts */
/****************************************/
function cbb_search_only_posts($query) {
  if ($query->is_search() && !is_admin()) {
    $query->set('post_type', 'post');
  }

  return $query;
}

add_filter('pre_get_posts', 'cbb_search_only_posts');

/****************************************/
/* Setting Mailtrap */
/****************************************/
function mailtrap($phpmailer) {
  $phpmailer->isSMTP();
  $phpmailer->Host = 'smtp.mailtrap.io';
  $phpmailer->SMTPAuth = true;
  $phpmailer->Port = 2525;
  $phpmailer->Username = 'e6e50f29dbe2dd';
  $phpmailer->Password = 'f1ea173da928d9';
}

// add_action('phpmailer_init', 'mailtrap');

// Bugs send emails WP 4.6.1
add_filter('wp_mail_from', function() {
  return 'no-reply@cbb.edu.pe';
});

// Function to change sender name
function cbb_sender_name($originalEmailFrom) {
  return 'Colegio Bertolt Brecht';
}

add_filter('wp_mail_from_name', 'cbb_sender_name');

/***********************************************************/
/* Register subscriptor via ajax */
/***********************************************************/
add_action('wp_ajax_register_contact', 'register_contact_callback');
add_action('wp_ajax_nopriv_register_contact', 'register_contact_callback');

function register_contact_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'msg' => '',
    'error' => ''
  );

  if (!wp_verify_nonce($nonce, 'cbbajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $name = trim($_POST['contact_name']);
  $email = trim($_POST['contact_email']);
  $phone = trim($_POST['contact_phone']);
  $level = (int)trim($_POST['contact_level']);
  // $subject = (int)trim($_POST['contact_subject']);
  $message = trim($_POST['contact_message']);
  $local = (int)trim($_POST['contact_local']);

  if (!empty($name) && !empty($email) && is_email($email) && !empty($phone) && preg_match('/^[0-9]+$/', $phone) && (strlen($phone) > 6 || strlen($phone) < 10) && !empty($message) && $level > 0) {
    $options = get_option('cbb_custom_settings');

    $name = sanitize_text_field($name);
    $email = sanitize_email($email);
    $phone = sanitize_text_field($phone);
    $message = sanitize_text_field($message);

    // Validate Level
    // $dataSubject = get_term_by('id', $subject, 'subjects');
    $dataLevel = get_term_by('id', $level, 'levels_contact');

    if (is_object($dataLevel)) {
      // Get data Local
      $dataLocal = ($local > 0) ? get_post($local) : null;

      $receiverEmail = $options['email'];

      if (!isset($receiverEmail) || empty($receiverEmail)) {
        $receiverEmail = get_option('admin_email');
      }

      if (!is_null($dataLocal)) {
        $values = get_post_custom($dataLocal->ID);
        $receiverEmail = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : $receiverEmail;
      }

      $subjectEmail = "Consulta Web Colegio Bertolt Brecht";

      ob_start();
      $filename = TEMPLATEPATH . '/templates/email-contact.php';
      if (file_exists($filename)) {
        include $filename;

        $content = ob_get_contents();
        ob_get_clean();

        $headers[] = 'From: Colegio Bertolt Brecht';
        //$headers[] = 'Reply-To: jolupeza@icloud.com';
        $headers[] = 'Content-type: text/html; charset=utf-8';

        if (wp_mail($receiverEmail, $subjectEmail, $content, $headers)) {
          // Send email to customer
          $subjectEmail = "Consulta enviada al Colegio Bertolt Brecht";

          ob_start();
          $filename = TEMPLATEPATH . '/templates/email-gratitude.php';
          if (file_exists($filename)) {
            $textEmail = (isset($options['response_contact']) && !empty($options['response_contact'])) ? esc_attr($options['response_contact']) : "Ya tenemos su consulta. En breve nos pondremos en contacto con usted.";

            include $filename;

            $content = ob_get_contents();
            ob_get_clean();

            $headers[] = 'From: Colegio Bertolt Brecht';
            //$headers[] = 'Reply-To: jolupeza@icloud.com';
            $headers[] = 'Content-type: text/html; charset=utf-8';

            wp_mail($email, $subjectEmail, $content, $headers);

            $post_id = wp_insert_post(array(
                'post_author' => 1,
                'post_status' => 'publish',
                'post_type' => 'contacts',
            ));
            update_post_meta($post_id, 'mb_name', $name);
            update_post_meta($post_id, 'mb_email', $email);
            update_post_meta($post_id, 'mb_phone', $phone);
            update_post_meta($post_id, 'mb_message', $message);
            if (!is_null($dataLocal)) {
              update_post_meta($post_id, 'mb_local', $local);
            }
            wp_set_object_terms($post_id, $level, 'levels_contact');

            $result['result'] = true;
            $result['msg'] = $options['response_contact_forms'];
          } else {
            $result['error'] = 'Plantilla email no encontrada.';
            ob_get_clean();
          }
        } else {
          $result['error'] = 'No se puedo enviar el email.';
        }
      } else {
        $result['error'] = 'Plantilla email no encontrada.';
        ob_get_clean();
      }
    } else {
      $result['error'] = 'Debe seleccionar el grado al que postula.';
    }
  } else {
    $result['error'] = 'Verifique que ha ingresado los datos correctamente.';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Register subscriptor via ajax */
/***********************************************************/
add_action('wp_ajax_register_admision', 'register_admision_callback');
add_action('wp_ajax_nopriv_register_admision', 'register_admision_callback');

function register_admision_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'msg' => '',
    'error' => ''
  );

  if (!wp_verify_nonce($nonce, 'axios-vuejs')) {
      die('¡Acceso denegado!');
  }

  $name = trim($_POST['fields']['parent_name']);
  $dni = trim($_POST['fields']['parent_dni']);
  $phone = trim($_POST['fields']['parent_phone']);
  $email = trim($_POST['fields']['parent_email']);
  $sede = (int)trim($_POST['fields']['parent_sede']);
  $sonName = trim($_POST['fields']['son_name']);
  $level = (int)trim($_POST['fields']['son_level']);
  $schedule = (int)trim($_POST['fields']['schedule']);
  $scheduleCustom = !empty($_POST['fields']['schedule_custom']) ? $_POST['fields']['schedule_custom'] : '';

  if (!empty($name) && !empty($dni) && preg_match('/^[0-9]+$/', $dni) && strlen($dni) === 8 && !empty($phone) && preg_match('/^[0-9]+$/', $phone) && (strlen($phone) > 6 || strlen($phone) < 10) && !empty($email) && is_email($email) && $sede > 0 && !empty($sonName) && $level > 0) {
    if (!$schedule && empty($scheduleCustom)) {
      $result['error'] = 'Por favor indica una fecha personalizada.';
      echo json_encode($result);
      die();
    }

    $options = get_option('cbb_custom_settings');

    $name = sanitize_text_field($name);
    $dni = sanitize_text_field($dni);
    $phone = sanitize_text_field($phone);
    $email = sanitize_email($email);
    $sonName = sanitize_text_field($sonName);

    // Validate Sede
    $dataSede = get_post($sede);
    if (!is_null($dataSede)) {
      // Validate Level
      $dataLevel = get_term_by('id', $level, 'levels');

      if (is_object($dataLevel)) {
        // Validate Schedule
        $dataSchedule = ($schedule) ? get_post($schedule) : null;
        $receiverEmail = $options['email'];

        if (!isset($receiverEmail) || empty($receiverEmail)) {
          $receiverEmail = get_option('admin_email');
        }

        $subjectEmail = "Admisión Colegio Bertolt Brecht";

        ob_start();
        $filename = TEMPLATEPATH . '/templates/email-admision.php';
        if (file_exists($filename)) {
          include $filename;

          $content = ob_get_contents();
          ob_get_clean();

          $headers[] = 'From: Colegio Bertolt Brecht';
          //$headers[] = 'Reply-To: jolupeza@icloud.com';
          $headers[] = 'Content-type: text/html; charset=utf-8';

          if (wp_mail($receiverEmail, $subjectEmail, $content, $headers)) {
            // Send email to customer
            $subjectEmail = "Formulario de Admisión enviada al Colegio Bertolt Brecht";

            ob_start();
            $filename = TEMPLATEPATH . '/templates/email-gratitude.php';
            if (file_exists($filename)) {
              $textEmail = (isset($options['response_admision']) && !empty($options['response_admision'])) ? esc_attr($options['response_admision']) : "Gracias por registrarse. En breve nos pondremos en contacto con usted.";

              include $filename;

              $content = ob_get_contents();
              ob_get_clean();

              $headers[] = 'From: Colegio Bertolt Brecht';
              //$headers[] = 'Reply-To: jolupeza@icloud.com';
              $headers[] = 'Content-type: text/html; charset=utf-8';

              wp_mail($email, $subjectEmail, $content, $headers);

              $post_id = wp_insert_post(array(
                  'post_author' => 1,
                  'post_status' => 'publish',
                  'post_type' => 'prestudents',
              ));
              update_post_meta($post_id, 'mb_name', $name);
              update_post_meta($post_id, 'mb_dni', $dni);
              update_post_meta($post_id, 'mb_phone', $phone);
              update_post_meta($post_id, 'mb_email', $email);
              update_post_meta($post_id, 'mb_sede', $sede);
              update_post_meta($post_id, 'mb_sonName', $sonName);
              update_post_meta($post_id, 'mb_schedule', $schedule);
              update_post_meta($post_id, 'mb_scheduleCustom', $scheduleCustom);
              update_post_meta($post_id, 'mb_year', isset($options['admision_year']) && !empty($options['admision_year']) ? $options['admision_year'] : date("Y") + 1);
              wp_set_object_terms($post_id, $level, 'levels');

              $result['result'] = true;
              $result['msg'] = $options['response_admision_forms'];
            } else {
              $result['error'] = 'Plantilla email no encontrada.';
              ob_get_clean();
            }
          } else {
            $result['error'] = 'No se puedo enviar el email.';
          }
        } else {
          $result['error'] = 'Plantilla email no encontrada.';
          ob_get_clean();
        }
      } else {
        $result['error'] = 'Debe seleccionar el grado al que desea postular.';
      }
    } else {
      $result['error'] = 'Debe seleccionar la sede de su interés.';
    }
  } else {
    $result['error'] = 'Verifique que ha ingresado los datos correctamente.';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Load Schedules via ajax */
/***********************************************************/
add_action('wp_ajax_load_schedule', 'load_schedule_callback');
add_action('wp_ajax_nopriv_load_schedule', 'load_schedule_callback');

function load_schedule_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'posts' => [],
    'error' => ''
  );

  if (!wp_verify_nonce($nonce, 'axios-vuejs')) {
      die('¡Acceso denegado!');
  }

  $local = (int)trim($_POST['local']);

  if ($local > 0) {
    // Validate Local
    $dataLocal = get_post($local);
    if (!is_null($dataLocal)) {
      // Get schedules y retornar como json
      $args = [
        'post_type' => 'schedules',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => [
          [
            'key' => 'mb_local',
            'value' => $local,
          ],
          /*[
            'key' => 'mb_grade',
            'value' => $level
          ]*/
        ]
      ];
      $schedules = new WP_Query($args);

      if ($schedules->have_posts()) {
        $result['posts'] = $schedules->posts;
        $result['result'] = true;
      } else {
        $result['error'] = 'No existen horarios para la sede seleccionada.';
      }
      wp_reset_postdata();
    } else {
      $result['error'] = 'La sede seleccionada no es válida.';
    }
  } else {
    $result['error'] = 'La sede seleccionada no es válida.';
  }

  echo json_encode($result);
  die();
}

/**********************************************/
/* Load Theme Options Page and Custom Widgets */
/**********************************************/
require_once(TEMPLATEPATH . '/functions/cbb-theme-customizer.php');
require_once(TEMPLATEPATH . '/functions/widget-ad-320.php');

function getPreviousNextLinkItemMenu($currentItem, $locationMenu) {
  $mainMenu = wp_get_nav_menu_object($locationMenu);
  $menuItems = wp_get_nav_menu_items($mainMenu->term_id, [
    'post_parent' => 0
  ]);

  $keyCurrentItem = NULL;
  $result = [];

  foreach ($menuItems as $key => $item) {
    if ((int)$item->object_id === $currentItem) {
      $keyCurrentItem = $key;
      break;
    }
  }

  if (!is_null($keyCurrentItem)) {
    $result['prev'] = array_key_exists($keyCurrentItem - 1, $menuItems) ? $menuItems[$keyCurrentItem - 1] : null;
    $result['next'] = array_key_exists($keyCurrentItem + 1, $menuItems) ? $menuItems[$keyCurrentItem + 1] : null;
  }

  return $result;
}

/*
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
  function dump($var, $label = 'Dump', $echo = true) {
    // Store dump in variable
    ob_start();
    var_dump($var);
    $output = ob_get_clean();

    // Add formatting
    $output = preg_replace("/\]\=\>\n(\s+)/m", '] => ', $output);
    $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">'.$label.' => '.$output.'</pre>';

    // Output
    if ($echo == true) {
      echo $output;
    } else {
      return $output;
    }
  }
}

if (!function_exists('dump_exit')) {
  function dump_exit($var, $label = 'Dump', $echo = true) {
    dump($var, $label, $echo);
    exit;
  }
}
