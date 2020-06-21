<?php


namespace Framework;


use Exception;
use Framework\Contracts\ExceptionHandlerContract;
use Framework\Contracts\RequestContract;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ExceptionHandler implements ExceptionHandlerContract
{
    protected $whoops;

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
            $request = Application::getInstance()->make(RequestContract::class);


            if ($request->isJson()) {
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
}