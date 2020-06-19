<?php


namespace Framework\Contracts;


interface ContainerContract
{
    public function instance($abstract, $instance, $override = false);

    public function make($abstract);

}