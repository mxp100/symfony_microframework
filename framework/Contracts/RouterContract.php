<?php


namespace Framework\Contracts;


use Symfony\Component\Routing\Matcher\UrlMatcher;

interface RouterContract
{
    public function getUrlMatcher(): UrlMatcher;
}