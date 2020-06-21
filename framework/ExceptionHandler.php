<?php


namespace Framework;


use Exception;
use Framework\Contracts\ExceptionHandlerContract;
use Framework\Contracts\RequestContract;
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
     * ExceptionHandler constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->whoops = new Run();
        $plainTextHandler = new PlainTextHandler(Logger::default());
        if (env('APP_DEBUG', false)) {
            /** @var RequestContract $request */
            $this->request = Application::getInstance()->make(RequestContract::class);


            if ($this->request->isJson()) {
                $this->whoops->pushHandler(new JsonResponseHandler());
            } else {
                $this->whoops->pushHandler(new PrettyPageHandler());
            }

            $plainTextHandler->loggerOnly(false);
        } else {
            $plainTextHandler->loggerOnly(true);
        }

        $this->whoops->pushHandler($plainTextHandler);
        $this->whoops->register();
    }

    /**
     * @inheritDoc
     */
    public function handle(Throwable $throwable): Response
    {
        if (method_exists($throwable, 'render')) {
            return $throwable->render($this->request);
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
        }

        if ($this->request && $this->request->isJson()) {
            $response = ['error' => $error,];
            if ($code) {
                $response['code'] = $code;
            }
            return new Response(json_encode($response), $httpStatus);
        }

        return new Response($error, $httpStatus);
    }
}