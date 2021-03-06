<?php


namespace Framework\HttpKernel\ArgumentResolver;


use Framework\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Resolve objects from container
 *
 * Class ContainerValueResolver
 * @package Framework\HttpKernel\ArgumentResolver
 */
class ContainerValueResolver implements ArgumentValueResolverInterface
{

    /**
     * @inheritDoc
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return Application::getInstance()->has($argument->getType());
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield Application::getInstance()->make($argument->getType());
    }
}