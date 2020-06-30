<?php


namespace Framework\View\Extensions;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('env', 'env'),
            new TwigFunction('url', 'url'),
            new TwigFunction('route', 'route'),
        ];
    }
}