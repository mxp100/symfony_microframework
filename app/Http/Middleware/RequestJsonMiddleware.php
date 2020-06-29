<?php


namespace App\Http\Middleware;


use Framework\Contracts\MiddlewareContract;
use Framework\Request;

class RequestJsonMiddleware implements MiddlewareContract
{

    /**
     * @inheritDoc
     */
    public function handle(Request $request): void
    {
        if ($request->isJson()) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }
    }
}