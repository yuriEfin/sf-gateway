<?php

namespace App\CompillerPass;


use App\Context\Rest\Interfaces\HandlerResolverInterface;
use App\Context\Rest\RouteHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RouteHandlerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(HandlerResolverInterface::class)) {
            return;
        }
        
        $definition = $container->findDefinition(RouteHandler::class);
        
        $taggedServices = $container->findTaggedServiceIds('app.handler_route');
        
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addHandler', [new Reference($id)]);
        }
    }
}
