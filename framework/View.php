<?php


namespace Framework;


use Framework\Contracts\ViewContract;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class View implements ViewContract
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(resource_path('views'));
        $this->twig = new Environment($loader, [
            'cache' => storage_path('cache/views')
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
}