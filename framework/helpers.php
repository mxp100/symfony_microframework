<?php

use Framework\Application;
use Framework\Contracts\EnvironmentContract;
use Framework\Contracts\RouterContract;
use Framework\Contracts\ViewContract;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return Application::getInstance()->basePath . $path;
    }
}

if (!function_exists('app_path')) {
    function app_path($path = '')
    {
        return Application::getInstance()->applicationPath . $path;
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

if (!function_exists('url')) {
    function url($relative = '')
    {
        /** @var RouterContract $router */
        $router = Application::getInstance()->make(RouterContract::class);
        $requestContext = $router->getRequestContext();

        $url = $requestContext->getScheme() . '://'
            . $requestContext->getHost();

        if ($requestContext->isSecure()) {
            if ($port = $requestContext->getHttpsPort() !== 443) {
                $url .= ':' . $port;
            }
        } else {
            if ($port = $requestContext->getHttpPort() !== 80) {
                $url .= ':' . $port;
            }
        }
        if ($relative) {
            $url .= ($relative[0] != '/' ? '/' : '') . $relative;
        }
        return $url;
    }
}

if (!function_exists('route')) {
    function route($name, $parameters = [], $absolute = true)
    {
        /** @var RouterContract $router */
        $router = Application::getInstance()->make(RouterContract::class);

        return $router->getUrlGenerator()->generate($name, $parameters,
            $absolute ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::ABSOLUTE_PATH);
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