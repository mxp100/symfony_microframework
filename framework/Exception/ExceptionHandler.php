<?php


namespace Framework\Exception;


use Framework\Application;
use Framework\Log\Logger;
use Framework\Request\RequestContract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Throwable;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ExceptionHandler implements ExceptionHandlerContract
{
    /**
     * @var Run
     */
    protected $whoops;
    /**
     * @var RequestContract|null
     */
    protected $request;
    /**
     * @var Application
     */
    protected $application;


    /**
     * ExceptionHandler constructor.
     * @param Application $application
     * @param Run $whoops
     */
    public function __construct(Application $application, Run $whoops)
    {
        $this->whoops = $whoops;
        $this->application = $application;

        set_exception_handler([$this, 'handle']);
    }

    /**
     * @inheritDoc
     */
    public function handle(Throwable $throwable): ?Response
    {
        if (method_exists($throwable, 'render')) {
            return $throwable->render($this->request);
        }

        $plainTextHandler = new PlainTextHandler(Logger::default());
        if (env('APP_DEBUG', false)) {
            if ($this->application->has(RequestContract::class)) {
                /** @var RequestContract $request */
                $this->request = $this->application->make(RequestContract::class);


                if ($this->request->isJson()) {
                    $this->whoops->pushHandler(new JsonResponseHandler());
                } else {
                    $this->whoops->pushHandler(new PrettyPageHandler());
                }
            }
            $plainTextHandler->loggerOnly(false);
        } else {
            $plainTextHandler->loggerOnly(true);
        }

        $error = $throwable->getMessage();
        $code = $throwable->getCode();

        if (method_exists($throwable, 'getHttpStatus')) {
            $httpStatus = $throwable->getHttpStatus();
        } else {
            $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        switch (true) {
            case $throwable instanceof ResourceNotFoundException:
                $error = $error ?: 'resource not found';
                $httpStatus = Response::HTTP_NOT_FOUND;
                break;
            case $throwable instanceof MethodNotAllowedException:
                $error = $error ?: 'method not allowed';
                $httpStatus = Response::HTTP_METHOD_NOT_ALLOWED;
                break;
        }

        if ($this->request && $this->request->isJson()) {
            $response = ['error' => $error,];
            if ($code) {
                $response['code'] = $code;
            }
            return new Response(json_encode($response), $httpStatus);
        }

        $this->whoops->appendHandler($plainTextHandler);
        $this->whoops->handleException($throwable);

        return null;
    }
}