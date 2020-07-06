<?php

namespace Framework\HttpKernel;

use Exception;
use Framework\Application;
use Framework\Contracts\MiddlewareContract;
use Framework\Exception\ExceptionHandlerContract;
use Framework\HttpKernel\ArgumentResolver\ClassValueResolver;
use Framework\HttpKernel\ArgumentResolver\ContainerValueResolver;
use Framework\Request\Request;
use Framework\Router\RouterContract;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class HttpKernel implements HttpKernelContract
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * Global middleware's
     * @var string[]
     */
    protected $middleware = [];

    /**
     * Registered middleware's
     * @var string[]
     */
    protected $middlewareRegistered = [];

    /**
     * Aliases for middleware's
     * @var array
     */
    protected $middlewareAlias = [];

    public function __construct(Application $application)
    {
        $this->application = $application;

        $this->controllerResolver = new ControllerResolver();
        $this->argumentResolver = new ArgumentResolver(null, [
            new RequestAttributeValueResolver(),
            new RequestValueResolver(),
            new SessionValueResolver(),
            new DefaultValueResolver(),
            new VariadicValueResolver(),
            new ContainerValueResolver(),
            new ClassValueResolver(),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function pushMiddleware(string $middleware)
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function registerMiddleware(string $middleware, ?string $alias = null)
    {
        $this->middlewareRegistered[] = $middleware;
        if (!is_null($alias)) {
            $this->middlewareAlias[$alias] = $middleware;
        }
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function handle(Request $request): Response
    {
        $this->application->bootstrap();

        $this->prepareRequest($request);
        $this->handleMiddleware($request);

        $response = $this->handleRequest($request);

        if ($response instanceof Response) {
            return $response;
        }

        if (is_array($response)) {
            $response = new JsonResponse($response);
        } else {
            $response = new Response($response);
        }

        return $response;
    }

    protected function prepareRequest(Request $request): void
    {
        /** @var RouterContract $router */
        $router = $this->application->make(RouterContract::class);

        $request->setRouteMetadata($router->matchRoute($request));
    }

    /**
     * Handle registered middleware
     * @param Request $request
     * @throws \ReflectionException
     */
    protected function handleMiddleware(Request $request)
    {
        foreach ($this->middleware as $key => $middleware) {
            if (is_string($middleware)) {
                $this->middleware[$key] = $middleware = $this->application->resolveInstance($middleware);
            }

            if ($middleware instanceof MiddlewareContract) {
                $middleware->handle($request);
            } else {
                throw new \RuntimeException('middleware not implemented MiddlewareContract');
            }

        }
    }

    protected function handleRequest(Request $request)
    {
        try {
            $routeMetadata = $request->getRouteMetadata();

            return $this->application->call(
                $routeMetadata->getController(),
                $routeMetadata->getMethod(),
                $routeMetadata->getArguments()
            );

        } catch (Exception $exception) {
            /** @var ExceptionHandlerContract $exceptionHandler */
            $exceptionHandler = $this->application->make(ExceptionHandlerContract::class);
            return $exceptionHandler->handle($exception);
        }
    }


}