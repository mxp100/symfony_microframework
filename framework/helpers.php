<?php

use Framework\Application;
use Framework\Contracts\EnvironmentContract;
use Framework\Contracts\ViewContract;

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

if (!function_exists('resource_path')) {
    function resource_path($path = '')
    {
        return Application::getInstance()->resourcePath . $path;
    }
}

if (!function_exists('view')) {
    function view(string $template, array $vars = [])
    {
        /** @var ViewContract $view */
        $view = Application::getInstance()->make(ViewContract::class);
        return $view->view($template, $vars);
    }
}

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        /** @var EnvironmentContract $env */
        $env = Application::getInstance()->make(EnvironmentContract::class);
        return $env->get($key, $default);
    }
}