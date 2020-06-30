<?php


namespace Framework\Router;


use App\Http\Routes;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Router implements RouterContract
{
    /**
     * @var RouteCollection
     */
    protected $routes;
    /**
     * @var UrlMatcher
     */
    protected $urlMatcher;
    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;
    /**
     * @var RequestContext
     */
    protected $requestContext;

    public function __construct()
    {
        $this->routes = new RouteCollection();
        $this->requestContext = new RequestContext();

        $this->loadRoutes();

        $this->urlMatcher = new UrlMatcher($this->routes, $this->requestContext);
        $this->urlGenerator = new UrlGenerator($this->routes, $this->requestContext);
    }

    public function getUrlMatcher(): UrlMatcher
    {
        return $this->urlMatcher;
    }

    public function getUrlGenerator(): UrlGenerator
    {
        return $this->urlGenerator;
    }

    public function getRequestContext(): RequestContext
    {
        return $this->requestContext;
    }

    protected function loadRoutes(): void
    {
        new Routes($this->routes);
    }

}