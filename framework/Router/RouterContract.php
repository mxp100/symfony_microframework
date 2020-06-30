<?php


namespace Framework\Router;


use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

interface RouterContract
{
    public function getUrlMatcher(): UrlMatcher;

    public function getUrlGenerator(): UrlGenerator;

    public function getRequestContext(): RequestContext;
}