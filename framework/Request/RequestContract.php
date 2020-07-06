<?php


namespace Framework\Request;

use Framework\Router\RouteMetadata;

/**
 * Interface RequestContract
 * @package Framework\Contracts
 */
interface RequestContract
{
    /**
     * Current request is json type
     * @return bool
     */
    public function isJson(): bool;

    /**
     * Get route metadata
     * @return RouteMetadata
     */
    public function getRouteMetadata(): RouteMetadata;

    /**
     * Set route metadata
     * @param RouteMetadata $routeMetadata
     */
    public function setRouteMetadata(RouteMetadata $routeMetadata): void;
}