<?php


namespace Framework;


use Framework\Contracts\RequestContract;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request extends BaseRequest implements RequestContract
{
    /**
     * @inheritDoc
     */
    public function isJson(): bool
    {
        return 0 === strpos($this->headers->get('Content-Type'), 'application/json');
    }
}