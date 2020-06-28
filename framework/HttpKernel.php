<?php

namespace Framework;

use Exception;
use Framework\Contracts\ExceptionHandlerContract;
use Framework\Contracts\KernelContract;
use Framework\Contracts\MiddlewareContract;
use Framework\Contracts\RequestContract;
use Framework\Contracts\RouterContract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class HttpKernel implements KernelContract
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

        $this->application->getContainer()->set('request', Request::createFromGlobals());

        $this->controllerResolver = new ControllerResolver();
        $this->argumentResolver = new ArgumentResolver();
    }

    /**
     * Add middleware
     * @param MiddlewareContract $middleware
     * @return HttpKernel
     */
    public function pushMiddleware(MiddlewareContract $middleware): self
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    public function handle(): Response
    {
        $request = $this->application->getContainer()->get('request');

//        if (is_null($request)) {
//            $request = $this->application->getContainer()->get(RequestContract::class);
//        }

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
     * @param RequestContract $request
     */
    protected function handleMiddleware(RequestContract $request)
    {
        foreach ($this->middleware as $middleware) {
            $middleware->handle($request);
        }
    }

    protected function handleRequest(Request $request)
    {
        /** @var RouterContract $router */
        $router = $this->application->getContainer()->get('router');

        $matcher = $router->getUrlMatcher();

        $matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (Exception $exception) {
            /** @var ExceptionHandlerContract $exceptionHandler */
            $exceptionHandler = $this->application->getContainer()->get('exception');
            return $exceptionHandler->handle($exception);
        }
    }


}