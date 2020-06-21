<?php


namespace App\Exceptions;


use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ResponseException extends Exception
{

    protected $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(
        $message = "",
        $code = 0,
        $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable $previous = null
    ) {
        $this->httpStatus = $httpStatus;
        parent::__construct($message, $code, $previous);
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    public static function fromException(Throwable $exception, $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return new self($exception->getMessage(), $exception->getCode(), $httpStatus, $exception->getPrevious());
    }
}