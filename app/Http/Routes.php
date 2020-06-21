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
        $routes->add(
            'index',
            (new Route('/', [
                '_controller' => Controllers\IndexController::class . '::index',
            ]))->setMethods('get')
        );
    }

    protected function initAPI(RouteCollection $routes)
    {
        $group = new RouteCollection();
        $group->add(
            'goods.index',
            (new Route('goods', [
                '_controller' => API\GoodController::class . '::index',
            ]))->setMethods('get')
        );
        $group->add(
            'orders.create',
            (new Route('orders', [
                '_controller' => API\OrderController::class . '::create',
            ]))->setMethods('post')
        );
        $group->add(
            'orders.pay',
            (new Route('orders/{orderId}/pay', [
                '_controller' => API\OrderController::class . '::pay',
            ]))->setMethods('post')
        );

        $group->addPrefix('api');
        $group->addNamePrefix('api.');
        $routes->addCollection($group);
    }
}