<?php

namespace Framework;

use Exception;
use Framework\Contracts\ExceptionHandlerContract;
use Framework\Contracts\HttpKernelContract;
use Framework\Contracts\MiddlewareContract;
use Framework\Contracts\RequestContract;
use Framework\Contracts\RouterContract;
use Framework\HttpKernel\ArgumentResolver\ContainerValueResolver;
use Framework\Request;
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
     * @var ControllerResolver
     */
    protected $controllerResolver;
    /**
     * @var ArgumentResolver
     */
    protected $argumentResolver;
    /**
     * @var MiddlewareContract[]
     */
    protected $middleware = [];

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
        ]);
    }

    /**
     * @inheritDoc
     */
    public function pushMiddleware(MiddlewareContract $middleware)
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function handle(Request $request): Response
    {
        $this->application->bootstrap();

        $this->handleMiddleware($request);

        $response = $this->handleRequest($request);

        if ($response instanceof Response) {
            return $response;
        }

        if (is_array($response)) {
            $response = new Response(json_encode($response));
            $response->headers->set('Content-Type', 'application/json');
        } else {
            $response = new Response($response);
        }

        return $response;
    }

    /**
     * Handle registered middleware
     * @param Request $request
     */
    protected function handleMiddleware(Request $request)
    {
        foreach ($this->middleware as $middleware) {
            $middleware->handle($request);
        }
    }

    protected function handleRequest(Request $request)
    {
        /** @var RouterContract $router */
        $router = $this->application->make(RouterContract::class);

        $matcher = $router->getUrlMatcher();

        $matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (Exception $exception) {
            throw $exception;
            /** @var ExceptionHandlerContract $exceptionHandler */
            $exceptionHandler = $this->application->make(ExceptionHandlerContract::class);
            return $exceptionHandler->handle($exception);
        }
    }


}