<?php


namespace Framework\Request;


use Framework\Router\RouteMetadata;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request extends BaseRequest implements RequestContract
{


    /**
     * @var RouteMetadata
     */
    protected $routeMetadata;

    /**
     * @return mixed
     */
    public function getRouteMetadata(): RouteMetadata
    {
        return $this->routeMetadata;
    }

    /**
     * @param mixed $routeMetadata
     */
    public function setRouteMetadata(RouteMetadata $routeMetadata): void
    {
        $this->routeMetadata = $routeMetadata;
    }

    /**
     * @inheritDoc
     */
    public function isJson(): bool
    {
        return 'XMLHttpRequest' == $this->headers->get('X-Requested-With');
    }
}