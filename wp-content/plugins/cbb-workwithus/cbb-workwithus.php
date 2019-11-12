<?php
/**
 * The file responsible for starting the CBB WorkWithUs plugin.
 *
 * The CBB WorkWithUs is a plugin it allows admins job applications.
 *
 * @package           CBB_WorkWithUs
 *
 * @wordpress-plugin
 * Plugin Name:       CBB Trabaja Con Nosotros
 * Plugin URI:        https://gitlab.com/joseluis2/villamaria
 * Description:       Manage job applications.
 * Version:           1.0.0
 * Author:            Agencia Watson
 * Author URI:        http://watson.pe
 * Text Domain:       cbb-workwithus-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

namespace CBB_WorkWithUs;

use CBB_WorkWithUs\Includes\CBB_WorkWithUs;

// If this file is called directly, then abort execution.
if (!defined('WPINC')) {
    die;
}

require_once( trailingslashit(dirname(__FILE__)) . 'inc/autoloader.php' );

/**
 * Instantiates the Ibisa Manager class and then
 * calls its run method officially starting up the plugin.
 */
function run_cbb_workwithus()
{
    $spmm = new CBB_WorkWithUs();
    $spmm->run();
}

// Call the above function to begin execution of the plugin.
run_cbb_workwithus();
