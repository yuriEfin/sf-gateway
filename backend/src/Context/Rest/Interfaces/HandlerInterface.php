<?php

namespace App\Context\Rest\Interfaces;


interface HandlerInterface
{
    public function handle();
    
    public function addHandler(RouteHandlerInterface $handler): void;
}
