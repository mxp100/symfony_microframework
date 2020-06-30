<?php


namespace Framework\ConsoleKernel;


interface ConsoleKernelContract
{
    /**
     * Handle console commands
     */
    public function handle(): void;
}