<?php

namespace App\Context\Rest\Interfaces;


interface HandlerResolverInterface
{
    public function resolve(): RouteHandlerInterface;
    
    public function addHandler(RouteHandlerInterface $handler): void;
}
