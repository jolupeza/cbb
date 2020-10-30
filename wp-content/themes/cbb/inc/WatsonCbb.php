<?php

class WatsonCbb
{
    public function __construct()
    {
        $this->includeCustomFields();
    }

    public function includeCustomFields()
    {
        include_once 'custom_fields/acf_page.php';
    }
}
