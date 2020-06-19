<?php


namespace App\Http;


use App\Http\Controllers\IndexController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Routes
{
    public function __construct(RouteCollection $routes)
    {
        $routes->add('index', new Route('/', [
            '_controller' => IndexController::class.'::index',
        ]));
    }
}