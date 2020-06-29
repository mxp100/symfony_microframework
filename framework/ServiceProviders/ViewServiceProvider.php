<?php


namespace Framework\ServiceProviders;


use Framework\Contracts\ViewContract;
use Framework\Extensions\TwigExtension;
use Framework\Services\View;

class ViewServiceProvider extends ServiceProvider
{

    public $bindings = [
        ViewContract::class => View::class,
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {

    }

    public function boot(): void
    {
        /** @var View $view */
        $view = $this->application->make(ViewContract::class);
        $view->loadExtension(new TwigExtension());
    }
}