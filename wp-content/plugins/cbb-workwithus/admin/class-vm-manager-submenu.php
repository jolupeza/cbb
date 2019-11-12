<?php

namespace VM_Manager\Admin;

use VM_Manager\Admin\VM_Manager_Submenu_Page as Submenu_Page;

/**
 * Creates the submenu item for the plugin.
 *
 * @package VM_Manager
 */
 
/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package VM_Manager
 */

class VM_Manager_Submenu
{
    /**
     * A reference the class responsible for rendering the submenu page.
     *
     * @var    \VM_Manager\Admin\VM_Manager_Submenu_Page
     * @access private
     */
    private $submenuPage;
    
    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;
    
    /**
     * Initializes all of the partial classes.
     *
     * @param Submenu_Page $submenu_page A reference to the class that renders 
     * the page for the plugin.
     */
    public function __construct($version, Submenu_Page $submenuPage)
    {
        $this->submenuPage = $submenuPage;
        $this->version = $version;
    }
    
    /**
     * Adds a submenu for this plugin to the 'Tools' menu.
     */
    public function init()
    {
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }
    
    /**
     * Creates the submenu item and calls on the Submenu Page object to render
     * the actual contents of the page.
     */
    public function add_options_page()
    { 
        add_options_page(
            'VillaMaria Manager - Configuración de Opciones',
            'Opciones Plugins VillaMaria Administrador',
            'manage_options',
            'custom-admin-page-vm-manager',
            array( $this->submenuPage, 'render' )
        );
    }
}
