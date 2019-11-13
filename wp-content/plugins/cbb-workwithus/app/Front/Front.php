<?php

namespace CBB_WorkWithUs\Front;

use CBB_WorkWithUs\Includes\Loader;

/**
 * The CBB WorkWithUs Public defines all functionality for the public-facing
 * sides of the plugin.
 */

/**
 * The CBB WorkWithUs Public defines all functionality for the public-facing
 * sides of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since    1.0.0
 */
class Front
{

    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    private $loader;

    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    private $domain;

    public function __construct(Loader $loader, $domain, $version)
    {
        $this->loader = $loader;
        $this->version = $version;
        $this->domain = $domain;
    }

    public function init()
    {
        $this->loader->add_filter('archive_template', $this, 'loadArchiveTemplate');
    }

    public function loadArchiveTemplate($archive)
    {
        var_dump($archive);
        exit();
    }
}