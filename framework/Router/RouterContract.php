<?php


namespace Framework\Router;


use Framework\Request\Request;

interface RouterContract
{
    /**
     * Get URL
     *
     * @param string $relative
     * @return string
     */
    public function getUrl($relative = ''): string;

    /**
     * Get URL by route
     *
     * @param string $name
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    public function getRoute(string $name, array $parameters = [], bool $absolute = true): string;

    /**
     * Get route metadata by request
     *
     * @param Request $request
     * @return RouteMetadata
     */
    public function matchRoute(Request $request): RouteMetadata;
}