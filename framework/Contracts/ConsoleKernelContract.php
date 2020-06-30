<?php


namespace Framework\Contracts;


interface ConsoleKernelContract
{
    /**
     * Handle console commands
     */
    public function handle(): void;
}