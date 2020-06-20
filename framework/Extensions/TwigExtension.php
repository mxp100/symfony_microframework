<?php


namespace Framework\Extensions;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('env', 'env'),
        ];
    }
}