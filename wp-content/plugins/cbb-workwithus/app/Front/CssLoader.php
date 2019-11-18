<?php

namespace CBB_WorkWithUs\Front;

use CBB_WorkWithUs\Includes\Loader;
use CBB_WorkWithUs\Shared\Spafile;
use CBB_WorkWithUs\Util\AssetsInterface;

/**
 * Provides a consistent way to enqueue all administrative-related stylesheets.
 */

/**
 * Provides a consistent way to enqueue all administrative-related stylesheets.
 *
 * Implements the Assets_Interface by defining the init function and the
 * enqueue function.
 *
 * The first is responsible for hooking up the enqueue
 * callback to the proper WordPress hook. The second is responsible for
 * actually registering and enqueuing the file.
 *
 * @implements Assets_Interface
 * @since      1.1.0
 */
class CssLoader implements AssetsInterface
{

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    private $loader;

    private $spaFile;

    public function __construct(Loader $loader, $version)
    {
        $this->loader = $loader;
        $this->version = $version;
        $this->spaFile = Spafile::getInstance();
    }

    public function init()
    {
        $this->loader->add_action('wp_enqueue_scripts', $this, 'enqueue');
    }

    public function enqueue()
    {
        if (is_tax('joblevels')) {
            $filesJs = $this->spaFile->getFilesSpa('css');

            /*echo '<pre>';
            var_dump($filesJs);
            echo '</pre>';
            exit();*/

            if (!empty($filesJs)) {
                $this->registerApp($filesJs);
            }
        }
    }

    private function registerApp($files)
    {
        foreach ($files as $file) {
            if (strpos($file, 'app.') === 0) {
                wp_enqueue_style(
                    'vue_workwithus_app',
                    plugin_dir_url(CBB_WORKWITHUS_FILE) . 'spa/dist/css/' . $file,
                    array(), $this->version, false);
            }
        }
    }
}
