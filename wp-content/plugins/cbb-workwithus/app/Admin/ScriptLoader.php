<?php

namespace CBB_WorkWithUs\Admin;

use CBB_WorkWithUs\Includes\Loader;
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

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct(Loader $loader, $version)
    {
        $this->loader = $loader;
        $this->version = $version;
    }

    /**
     * Defines the functionality responsible for loading the file.
     */
    public function enqueue()
    {
        global $post_type;

        if (isset($post_type) && 'jobapplications' === $post_type) {
            wp_enqueue_script(
                'cbb-workwithus-admin',
                plugin_dir_url(__FILE__).'Resources/js/cbb-workwithus-admin.js',
                array('jquery'),
                $this->version,
                true
            );
        }
    }

    /**
     * Registers the 'enqueue' function with the proper WordPress hook for
     * registering scripts.
     */
    public function init()
    {
        $this->loader->add_action('admin_enqueue_scripts', $this, 'enqueue');
    }

}
