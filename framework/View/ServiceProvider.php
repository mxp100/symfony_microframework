<?php


namespace Framework\View;


use Framework\AbstractServiceProvider;
use Framework\View\Extensions\TwigExtension;

class ServiceProvider extends AbstractServiceProvider
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