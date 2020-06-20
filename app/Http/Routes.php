<?php


namespace App\Http;


use App\Http\Controllers;
use App\Http\Controllers\API;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Routes
{
    public function __construct(RouteCollection $routes)
    {
        $this->initAPI($routes);
        $this->initFrontend($routes);
    }

    protected function initFrontend(RouteCollection $routes)
    {
        $routes->add('index', new Route('/', [
            '_controller' => Controllers\IndexController::class . '::index',
        ]));
    }

    protected function initAPI(RouteCollection $routes)
    {
        $group = new RouteCollection();
        $group->add('goods.generate', new Route('goods/generate', [
            API\GoodController::class . '::generate',
        ]));

        $group->addPrefix('api');
        $group->addNamePrefix('api.');
        $routes->addCollection($group);
    }
}