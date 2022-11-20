<?php

namespace App\Context\Rest\Interfaces;


interface SupportInterface
{
    public function support(HandlerParamsInterface $params): bool;
}
