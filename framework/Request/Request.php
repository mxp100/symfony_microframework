<?php


namespace Framework\Request;


use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request extends BaseRequest implements RequestContract
{
    /**
     * @inheritDoc
     */
    public function isJson(): bool
    {
        return 'XMLHttpRequest' == $this->headers->get('X-Requested-With');
    }
}