<?php

use Doctrine\ORM\EntityManager;
use Framework\Application;
use Framework\Database\DatabaseContract;
use Framework\Environment\EnvironmentContract;
use Framework\Router\RouterContract;
use Framework\View\ViewContract;

/**
 * Path helpers
 */
if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return Application::getInstance()->basePath($path);
    }
}

if (!function_exists('app_path')) {
    function app_path(string $path = ''): string
    {
        return Application::getInstance()->path($path);
    }
}

if (!function_exists('config_path')) {
    function config_path(string $path = ''): string
    {
        return Application::getInstance()->configPath($path);
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $path = ''): string
    {
        return Application::getInstance()->storagePath($path);
    }
}

if (!function_exists('resource_path')) {
    function resource_path(string $path = ''): string
    {
        return Application::getInstance()->resourcePath($path);
    }
}

/**
 * URL helpers
 */
if (!function_exists('url')) {
    function url(string $relative = ''): string
    {
        /** @var RouterContract $router */
        $router = Application::getInstance()->make(RouterContract::class);
        return $router->getUrl($relative);
    }
}

if (!function_exists('route')) {
    function route(string $name, array $parameters = [], bool $absolute = true): string
    {
        /** @var RouterContract $router */
        $router = Application::getInstance()->make(RouterContract::class);
        return $router->getRoute($name, $parameters, $absolute);
    }
}

/**
 * View helpers
 */
if (!function_exists('view')) {
    function view(string $template, array $vars = []): string
    {
        /** @var ViewContract $view */
        $view = Application::getInstance()->make(ViewContract::class);
        return $view->view($template, $vars);
    }
}

/**
 * ORM helpers
 */
if (!function_exists('em')) {
    function em(): EntityManager
    {
        /** @var DatabaseContract $database */
        $database = Application::getInstance()->make(DatabaseContract::class);

        return $database->getEntityManager();
    }
}

/**
 * Environment helpers
 */
if (!function_exists('env')) {
    function env($key, $default = null)
    {
        /** @var EnvironmentContract $env */
        $env = Application::getInstance()->make(EnvironmentContract::class);
        return $env->get($key, $default);
    }
}