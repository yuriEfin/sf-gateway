<?php

namespace App\Context\Rest\Interfaces;


interface RouteHandlerInterface extends SupportInterface
{
    public function handle(HandlerParamsInterface $params);
}
