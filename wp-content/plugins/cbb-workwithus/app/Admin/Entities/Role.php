<?php

namespace CBB_WorkWithUs\Admin\Entities;

use CBB_WorkWithUs\Includes\Loader;

class Role
{
    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    private $loader;

    protected $domain;

    public function __construct(Loader $loader, $domain)
    {
        $this->loader = $loader;
        $this->domain = $domain;
    }

    public function init()
    {
        $this->loader->add_action('init', $this, 'addRoleRRHH');
        $this->loader->add_action('admin_init', $this, 'addAdminCaps');
    }

    public function addRoleRRHH()
    {
//        remove_role('rrhh');

        add_role('rrhh', __('Recursos Humanos'), array(
            'read' => true,
            'read_jobapplication' => true,
            'edit_jobapplication' => true,
            'edit_jobapplications' => true,
            'delete_jobapplication' => true,
            'edit_others_jobapplications' => true,
            'publish_jobapplications' => true,
            'read_private_jobapplications' => true,
            'edit_published_jobapplications' => true,
            'delete_jobapplications' => true,
            'delete_published_jobapplications' => true,
            'delete_others_jobapplications' => true
        ));
    }

    public function addAdminCaps()
    {
        $role = get_role('administrator');
        $role->add_cap('read_jobapplication');
        $role->add_cap('edit_jobapplication');
        $role->add_cap('edit_jobapplications');
        $role->add_cap('delete_jobapplication');
        $role->add_cap('edit_others_jobapplications');
        $role->add_cap('publish_jobapplications');
        $role->add_cap('read_private_jobapplications');
        $role->add_cap('edit_published_jobapplications');
        $role->add_cap('delete_jobapplications');
        $role->add_cap('delete_published_jobapplications');
        $role->add_cap('delete_others_jobapplications');
    }
}
