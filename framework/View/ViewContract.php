<?php


namespace Framework\View;


interface ViewContract
{
    /**
     * Compile and return template
     *
     * @param string $template
     * @param array $vars
     * @return string
     */
    public function view(string $template, array $vars = []): string;
}