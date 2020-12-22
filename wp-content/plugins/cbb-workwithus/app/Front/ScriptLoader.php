<?php

namespace CBB_WorkWithUs\Front;

use CBB_WorkWithUs\Includes\Loader;
use CBB_WorkWithUs\Shared\Spafile;
use CBB_WorkWithUs\Util\AssetsInterface;

/**
 * Provides a consistent way to enqueue all administrative-related scripts.
 */

/**
 * Provides a consistent way to enqueue all administrative-related scripts.
 *
 * Implements the AssetsInterface by defining the init function and the
 * enqueue function.
 *
 * The first is responsible for hooking up the enqueue
 * callback to the proper WordPress hook. The second is responsible for
 * actually registering and enqueuing the file.
 *
 * @implements AssetsInterface
 * @since      1.1.0
 */
class ScriptLoader implements AssetsInterface
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

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue()
    {
        if (is_tax('joblevels')) {
            $filesJs = $this->spaFile->getFilesSpa('js');

            if (!empty($filesJs)) {
                $this->registerChunk($filesJs);

                $this->registerApp($filesJs);
            } else {
                wp_enqueue_script(
                    'vue_workwithus_chunk',
                    'http://localhost:8080/js/chunk-vendors.js',
                    array(), $this->version, true);

                wp_register_script(
                    'vue_workwithus_app',
                    'http://localhost:8080/js/app.js',
                    array(), $this->version, true);

                wp_localize_script(
                    'vue_workwithus_app',
                    'wpData',
                    $this->getWpData()
                );

                wp_enqueue_script('vue_workwithus_app');
            }
        }
    }

    private function registerChunk($files)
    {
        foreach ($files as $file) {
            if (strpos($file, 'chunk-') === 0) {
                wp_enqueue_script(
                    'vue_workwithus_chunk',
                    plugin_dir_url(CBB_WORKWITHUS_FILE) . 'spa/dist/js/' . $file,
                    array(), $this->version, true);
            }
        }
    }

    private function registerApp($files)
    {
        foreach ($files as $file) {
            if (strpos($file, 'app.') === 0) {
                wp_register_script(
                    'vue_workwithus_app',
                    plugin_dir_url(CBB_WORKWITHUS_FILE) . 'spa/dist/js/' . $file,
                    array(), $this->version, true);

                wp_localize_script(
                    'vue_workwithus_app',
                    'wpData',
                    $this->getWpData()
                );

                wp_enqueue_script('vue_workwithus_app');
            }
        }
    }

    private function getWpData()
    {
        $areas = get_terms([
            'taxonomy' => 'joblevels',
            'hide_empty' => false,
            'fields' => 'id=>slug'
        ]);

        $specialities = get_terms(array(
            'taxonomy' => 'job_specialities',
            'hide_empty' => false,
            'fields' => 'id=>name'
        ));

        $locals = get_terms(array(
            'taxonomy' => 'job_locals',
            'hide_empty' => false,
            'fields' => 'id=>name'
        ));

        $levels = get_terms(array(
            'taxonomy' => 'job_levels',
            'hide_empty' => false,
            'fields' => 'id=>name'
        ));

        return [
            'plugin_directory_uri' => plugin_dir_url(CBB_WORKWITHUS_FILE),
            'rest_url' => untrailingslashit(esc_url_raw(rest_url())),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'areas' => $areas,
            'locals' => $locals,
            'levels' => $levels,
            'specialities' => $specialities,
            'dataUbigeo' => plugin_dir_path(CBB_WORKWITHUS_FILE) . 'resources'
        ];

    }

}
