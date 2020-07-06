<?php


namespace Framework\Router;


use App\Http\Routes;
use Framework\Helpers\Arr;
use Framework\Request\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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

    /**
     * @inheritDoc
     */
    public function getUrl($relative = ''): string
    {
        $requestContext = $this->requestContext;

        $url = $requestContext->getScheme() . '://'
            . $requestContext->getHost();

        if ($requestContext->isSecure()) {
            if (($port = $requestContext->getHttpsPort()) !== 443) {
                $url .= ':' . $port;
            }
        } else {
            if (($port = $requestContext->getHttpPort()) !== 80) {
                $url .= ':' . $port;
            }
        }
        if ($relative) {
            $url .= ($relative[0] != '/' ? '/' : '') . $relative;
        }
        return $url;
    }

    /**
     * @inheritDoc
     */
    public function getRoute(string $name, array $parameters = [], bool $absolute = true): string
    {
        return $this->urlGenerator->generate($name, $parameters,
            $absolute ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    /**
     * @inheritDoc
     */
    public function matchRoute(Request $request): RouteMetadata
    {
        $this->urlMatcher->getContext()->fromRequest($request);
        $matchedRoute = $this->urlMatcher->match($request->getPathInfo());

        $controller = explode('::', $matchedRoute['_controller'], 2);
        if (count($controller) === 2) {
            [$controller, $method] = $controller;
        } else {
            $controller = $controller[0];
            $method = null;
        }

        $routeMetadata = new RouteMetadata();
        $routeMetadata
            ->setName($matchedRoute['_route'] ?? null)
            ->setController($controller)
            ->setMethod($method)
            ->setArguments(Arr::except($matchedRoute, ['_controller', '_middleware', '_route']));

        return $routeMetadata;
    }

    protected function loadRoutes(): void
    {
        new Routes($this->routes);
    }

}