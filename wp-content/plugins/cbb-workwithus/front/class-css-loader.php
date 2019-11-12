<?php

namespace VM_Manager\Front;

use VM_Manager\Util\Assets_Interface;
use VM_Manager\Shared\VM_Manager_Deserializer;

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
class CSS_Loader implements Assets_Interface
{
    /**
     *
     * @var \Ilc_Simulator\Shared\Ilc_Simulator_Deserializer
     */
    private $deserializer;

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version, VM_Manager_Deserializer $deserializer)
    {
        $this->version = $version;
        $this->deserializer = $deserializer;
    }

    /**
     * Defines the functionality responsible for loading the file.
     */
    public function enqueue()
    {
        $pageID = $this->deserializer->get_value('simulator-page');

        if ( ! empty($pageID) && $pageID > 0 ) {
            if ( is_page( (int) $pageID ) ) {
                wp_enqueue_style(
                    'ilc-simulator-bootstrapSwitch',
                    plugin_dir_url(__FILE__) . '/css/bootstrap-switch.min.css',
                    array(),
                    $this->version,
                    false
                );

                wp_enqueue_style(
                    'ilc-simulator-animate',
                    plugin_dir_url(__FILE__) . '/css/animate.css',
                    array(),
                    $this->version,
                    false
                );

                wp_enqueue_style(
                    'ilc-simulator-public',
                    plugin_dir_url(__FILE__) . '/css/style.css',
                    array(),
                    $this->version,
                    false
                );
            }
        }
    }

    /**
     * Registers the 'enqueue' function with the proper WordPress hook for
     * registering stylesheets.
     */
    public function init()
    {
        add_action(
            'wp_enqueue_scripts',
            array( $this, 'enqueue' )
        );
    }

}
