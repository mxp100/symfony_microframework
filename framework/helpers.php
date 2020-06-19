<?php

use Framework\Application;

if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return Application::getInstance()->basePath . $path;
    }
}

if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return Application::getInstance()->configPath . $path;
    }
}

if (!function_exists('storage_path')) {
    function storage_path($path = '')
    {
        return Application::getInstance()->storagePath . $path;
    }
}