<?php


namespace Framework;


use App\Http\Routes;
use Framework\Contracts\RouterContract;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Router implements RouterContract
{
    protected $routes;
    protected $urlMatcher;
    protected $requestContext;

    public function __construct()
    {
        $this->routes = new RouteCollection();
        $this->requestContext = new RequestContext();

        $this->loadRoutes();

        $this->urlMatcher = new UrlMatcher($this->routes, $this->requestContext);

    }

    public function getUrlMatcher(): UrlMatcher
    {
        return $this->urlMatcher;
    }

    protected function loadRoutes(): void
    {
        new Routes($this->routes);
    }

}