<?php

namespace App\Context\Rest\Interfaces;


use Symfony\Component\HttpFoundation\InputBag;

interface HandlerParamsInterface
{
    public function getBasePath(): string;
    
    public function getMethod(): string;
    
    public function getParams(): array;
}
