<?php

namespace Framework;

use Framework\Contracts\ExceptionHandlerContract;
use Framework\Contracts\KernelContract;
use Framework\Contracts\RequestContract;
use Framework\Contracts\RouterContract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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

    public function __construct(Application $application)
    {
        $this->application = $application;

        $this->registerBindings();

        $this->controllerResolver = new ControllerResolver();
        $this->argumentResolver = new ArgumentResolver();
    }

    public function handle(RequestContract $request = null): Response
    {
        if (is_null($request)) {
            $request = $this->application->make(RequestContract::class);
        }

        $this->registerMiddleware($request);

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
     * @param RequestContract $request
     * @todo Must be implementing via classes
     */
    protected function registerMiddleware(RequestContract $request)
    {
        if ($request->isJson()) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }
    }

    protected function registerBindings()
    {
        $this->application->instance(RouterContract::class, new Router());
        $this->application->instance(RequestContract::class, Request::createFromGlobals());
        $this->application->instance(ExceptionHandlerContract::class, new ExceptionHandler());
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
        } catch (ResourceNotFoundException $exception) {
            return new Response('Not found resource', Response::HTTP_NOT_FOUND);
        }
    }


}