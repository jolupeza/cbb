<?php

namespace CBB_WorkWithUs\Shared;

class Spafile
{

    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getFilesSpa($type)
    {
        $pathSpa = plugin_dir_path(CBB_WORKWITHUS_FILE) . 'spa/dist/' . $type;
        $fileSpa = file_exists($pathSpa) ? scandir($pathSpa) : false;

        return $fileSpa ? array_values(array_filter(array_slice($fileSpa, 2), function($file) {
            return !strpos($file, '.map');
        })) : $fileSpa;
    }

}