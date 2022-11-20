<?php

namespace App\Context\Rest;


use App\Context\Rest\Interfaces\HandlerParamsInterface;
use Symfony\Component\HttpFoundation\InputBag;

class HandlerParams implements HandlerParamsInterface
{
    public function __construct(
        private readonly string $route,
        private readonly string $method,
        private readonly array $params = []
    ) {
    }
    
    public function getBasePath(): string
    {
        return $this->route;
    }
    
    public function getMethod(): string
    {
        return $this->method;
    }
    
    public function getParams(): array
    {
        return $this->params;
    }
}

