<?php


namespace Framework;


use Framework\Contracts\ExceptionHandlerContract;
use Framework\Contracts\RequestContract;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ExceptionHandler implements ExceptionHandlerContract
{
    protected $whoops;

    public function __construct()
    {
        if (env('APP_DEBUG', false)) {
            /** @var RequestContract $request */
            $request = Application::getInstance()->make(RequestContract::class);

            $this->whoops = new Run();
            if ($request->isJson()) {
                $this->whoops->pushHandler(new JsonResponseHandler());
            } else {
                $this->whoops->pushHandler(new PrettyPageHandler());
            }
            $this->whoops->register();
        }
    }
}