<?php

namespace CBB_WorkWithUs\Includes;

use CBB_WorkWithUs\Admin\Admin;
use CBB_WorkWithUs\Admin\Entities\Jobapplications;
use CBB_WorkWithUs\Admin\Entities\Role;
use CBB_WorkWithUs\Admin\ScriptLoader;
use CBB_WorkWithUs\Front\Front;

/**
 * The CBB WorkWithUs is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin.
 */

/**
 * The CBB WorkWithUs is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin.
 *
 * The CBB WorkWithUs includes an instance to the CBB WorkWithUs
 * Loader which is responsible for coordinating the hooks that exist within the
 * plugin.
 *
 * It also maintains a reference to the plugin slug which can be used in
 * internationalization, and a reference to the current version of the plugin
 * so that we can easily update the version in a single place to provide
 * cache busting functionality when including scripts and styles.
 *
 * @since    1.0.0
 */
class Main
{
    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    protected $loader;

    /**
     * Represents the slug of hte plugin that can be used throughout the plugin
     * for internationalization and other purposes.
     *
     * @var string The single, hyphenated string used to identify this plugin.
     */
    protected $plugin_slug;

    /**
     * Contain text domain of plugin
     *
     * @var string
     */
    protected $plugin_domain;

    /**
     * Maintains the current version of the plugin so that we can use it throughout
     * the plugin.
     *
     * @var string The current version of the plugin.
     */
    protected $version;

    /**
     * Instantiates the plugin by setting up the core properties and loading
     * all necessary dependencies and defining the hooks.
     *
     * The constructor will define both the plugin slug and the verison
     * attributes, but will also use internal functions to import all the
     * plugin dependencies, and will leverage the Single_Post_Meta_Loader for
     * registering the hooks and the callback functions used throughout the
     * plugin.
     */
    public function __construct()
    {
        $this->plugin_slug = 'cbb-workwithus-slug';
        $this->plugin_domain = 'cbb-workwithus';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Imports the Single Post Meta administration classes, and the Single Post Meta Loader.
     *
     * The Single Post Meta Manager administration class defines all unique functionality for
     * introducing custom functionality into the WordPress dashboard.
     *
     * The Single Post Meta Manager Loader is the class that will coordinate the hooks and callbacks
     * from WordPress and the plugin. This function instantiates and sets the reference to the
     * $loader class property.
     */
    private function load_dependencies()
    {
        $this->loader = new Loader();
    }

    /**
     * Defines the hooks and callback functions that are used for setting up the plugin stylesheets
     * and the plugin's meta box.
     *
     * This function relies on the Maletek Manager Admin class and the Maletek Manager
     * Loader class property.
     */
    private function define_admin_hooks()
    {
        $adminRole = new Role($this->loader, $this->plugin_domain);
        $adminRole->init();

        $admin = new Admin($this->loader, $this->plugin_domain, $this->get_version());
        $admin->init();

        $adminJobApplication = new Jobapplications($this->loader, $this->plugin_domain);
        $adminJobApplication->init();

        $adminJsLoader  = new ScriptLoader($this->loader, $this->get_version());
        $adminJsLoader->init();
    }

    /**
     * Defines the hooks and callback functions that are used for rendering information on the front
     * end of the site.
     *
     * This function relies on the Single Post Meta Manager Public class and the Single Post Meta Manager
     * Loader class property.
     */
    private function define_public_hooks()
    {
        $public = new Front($this->loader, $this->plugin_domain, $this->get_version());
        $public->init();
    }

    /**
     * Sets this class into motion.
     *
     * Executes the plugin by calling the run method of the loader class which will
     * register all of the hooks and callback functions used throughout the plugin
     * with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * Returns the current version of the plugin to the caller.
     *
     * @return string $this->version    The current version of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
