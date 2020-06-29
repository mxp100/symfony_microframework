<?php


namespace Framework\Services;


use Framework\Contracts\ViewContract;
use Framework\Extensions\TwigExtension;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\Loader\FilesystemLoader;

class View implements ViewContract
{
    /** @var Environment */
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(resource_path('views'));
        $this->twig = new Environment($loader, [
            'cache' => env('APP_ENV') == 'production' ? storage_path('cache/views') : false,
        ]);
    }

    /**
     * @inheritDoc
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function view(string $template, array $vars = []): string
    {
        return $this->twig->render($template . '.twig', $vars);
    }

    public function loadExtension(AbstractExtension $extension)
    {
        $this->twig->addExtension($extension);
    }
}