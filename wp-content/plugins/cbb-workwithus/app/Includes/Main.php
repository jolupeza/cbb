<?php

namespace CBB_WorkWithUs\Includes;

use CBB_WorkWithUs\Admin\Admin;
use CBB_WorkWithUs\Admin\Entities\Jobapplications;
use CBB_WorkWithUs\Admin\ScriptLoader;
use CBB_WorkWithUs\Admin\Taxonomies\Joblevel;
use CBB_WorkWithUs\Includes\Loader;

// use CBB_WorkWithUs\Admin\CBB_WorkWithUs_Admin;
// use CBB_WorkWithUs\Admin\CBB_WorkWithUs_Jobapplications;
// use CBB_WorkWithUs\Admin\Taxonomies\Joblevel;

// use VM_Manager\Shared\VM_Manager_Deserializer as Deserializer;
// use VM_Manager\Admin\VM_Manager_Admin;
// use VM_Manager\Admin\CSS_Loader;
// use VM_Manager\Admin\Script_Loader;
// use VM_Manager\Admin\VM_Manager_Contacts;
// use VM_Manager\Admin\VM_Manager_Templates;
// use VM_Manager\Admin\VM_Manager_Fronts;
// use VM_Manager\Admin\VM_Manager_Page;
// use VM_Manager\Admin\VM_Manager_Post;
// use VM_Manager\Admin\VM_Manager_Achievements;
// use VM_Manager\Admin\VM_Manager_Staff;
// use VM_Manager\Admin\VM_Manager_Services;
// use VM_Manager\Admin\VM_Manager_Sliders;
// use VM_Manager\Admin\VM_Manager_Questions;
// use VM_Manager\Admin\VM_Manager_Submenu_Page;
// use VM_Manager\Admin\VM_Manager_Submenu;
// use VM_Manager\Admin\VM_Manager_Serializer as Serializer;

// use VM_Manager\Front\VM_Manager_Public;
// use VM_Manager\Front\Script_Loader as Script_Loader_Public;

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
        $admin = new Admin($this->loader, $this->plugin_domain, $this->get_version());
        $admin->init();

        $adminJobApplications = new Jobapplications($this->loader, $this->plugin_domain);
        $adminJobApplications->init();

        $adminJobLevels = new Joblevel($this->loader, $this->plugin_domain);
        $adminJobLevels->init();

        $adminJsLoader  = new ScriptLoader($this->loader, $this->get_version());
        $adminJsLoader->init();
        
        // $cssLoader = new CSS_Loader($this->get_version());
        // $this->loader->add_action('admin_enqueue_scripts', $cssLoader, 'enqueue');

        // $jsLoader = new Script_Loader($this->get_version());
        // $this->loader->add_action('admin_enqueue_scripts', $jsLoader, 'enqueue');

        // $adminPage = new VM_Manager_Page();
        // $this->loader->add_action('add_meta_boxes', $adminPage, 'cd_mb_page_add');
        // $this->loader->add_action('save_post', $adminPage, 'cd_mb_page_save');
        
        // $adminPost = new VM_Manager_Post();
        // $this->loader->add_action('add_meta_boxes', $adminPost, 'cd_mb_post_add');
        // $this->loader->add_action('save_post', $adminPost, 'cd_mb_post_save');

        // $adminContacts = new VM_Manager_Contacts();
        // $this->loader->add_action('add_meta_boxes', $adminContacts, 'cd_mb_contacts_add');
        // $this->loader->add_filter('manage_edit-contacts_columns', $adminContacts, 'custom_columns_contacts');
        // $this->loader->add_action('manage_contacts_posts_custom_column', $adminContacts, 'custom_column_contacts');
        // $this->loader->add_action('init', $adminContacts, 'add_taxonomies_contacts');
        // $this->loader->add_filter('views_edit-contacts', $adminContacts, 'buttonDownloadExcel');

        // $adminTemplates = new VM_Manager_Templates();
        // $this->loader->add_action('add_meta_boxes', $adminTemplates, 'cd_mb_templates_add');
        // $this->loader->add_action('save_post', $adminTemplates, 'cd_mb_templates_save');
        
        // $adminFronts = new VM_Manager_Fronts();
        // $this->loader->add_action('add_meta_boxes', $adminFronts, 'cd_mb_fronts_add');
        // $this->loader->add_action('save_post', $adminFronts, 'cd_mb_fronts_save');
        
        // $adminAchievements = new VM_Manager_Achievements();
        // $this->loader->add_action('add_meta_boxes', $adminAchievements, 'cd_mb_achievements_add');
        // $this->loader->add_action('save_post', $adminAchievements, 'cd_mb_achievements_save');
        
        // $adminStaff = new VM_Manager_Staff();
        // $this->loader->add_action('init', $adminStaff, 'add_taxonomies_staff');
        
        // $adminServices = new VM_Manager_Services();
        // $this->loader->add_action('init', $adminServices, 'add_taxonomies_services');
        // $this->loader->add_action('add_meta_boxes', $adminServices, 'cd_mb_services_add');
        // $this->loader->add_action('save_post', $adminServices, 'cd_mb_services_save');
        
        // $adminSliders = new VM_Manager_Sliders();
        // $this->loader->add_action('add_meta_boxes', $adminSliders, 'cd_mb_sliders_add');
        // $this->loader->add_action('save_post', $adminSliders, 'cd_mb_sliders_save');
        
        // $adminQuestions = new VM_Manager_Questions();
        // $this->loader->add_action('add_meta_boxes', $adminQuestions, 'cd_mb_questions_add');
        // $this->loader->add_action('save_post', $adminQuestions, 'cd_mb_questions_save');
        
        // $deserializer = new Deserializer();
        // $serializer = new Serializer();

        // $submenu = new VM_Manager_Submenu($this->version, new VM_Manager_Submenu_Page($deserializer));

        // $this->loader->add_action('admin_menu', $submenu, 'add_options_page');
        // $this->loader->add_action('admin_post', $serializer, 'save');
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
        // $deserializer = new Deserializer();

        // $public = new VM_Manager_Public($this->version, $deserializer);

        // //$cssLoader = new CSS_Loader($this->get_version(), $deserializer);
        // $jsLoader = new Script_Loader_Public($this->version);

        // $this->loader->add_action('wp_enqueue_scripts', $jsLoader, 'enqueue', 50);
        // //$this->loader->add_action('wp_enqueue_scripts', $cssLoader, 'enqueue');
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
