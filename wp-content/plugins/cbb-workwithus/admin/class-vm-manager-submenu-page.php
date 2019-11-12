<?php

namespace VM_Manager\Admin;

use VM_Manager\Shared\VM_Manager_Deserializer as Deserializer;

/**
 * Creates the submenu page for the plugin.
 *
 * @package VM_Manager
 */
 
/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package VM_Manager
 */
class VM_Manager_Submenu_Page
{
    /**
     *
     * @var \VM_Manager\Shared\VM_Manager_Deserializer
     */
    private $deserializer;

    /**
     * 
     * @param Deserializer $deserializer
     */
    public function __construct(Deserializer $deserializer)
    {
        $this->deserializer = $deserializer;
    }
 
    /**
     * This function renders the contents of the page associated with the Submenu
     * that invokes the render method. In the context of this plugin, this is the
     * Submenu class.
     */
    public function render()
    {
        $email = $this->deserializer->get_value('admin-email');
        
        $emailResponse = $this->deserializer->get_value('email-response');
        
        $subjectEmail = $this->deserializer->get_value('subject-email');
        
//        $aboutPage = $this->deserializer->get_value('page-about');
//        
//        $projectCurrent = $this->deserializer->get_value('project-current');
//        
//        $projectCurrentTitle = $this->deserializer->get_value('project-current-title');
        
        require_once plugin_dir_path(__FILE__) . 'views/settings-manager.php';
    }
}