<?php

namespace App\Context\Rest\Common\Auth;


use App\Context\Rest\Common\AbstractRouteHandler;
use App\Context\Rest\Interfaces\HandlerParamsInterface;
use App\Context\Rest\Interfaces\RouteHandlerInterface;
use Symfony\Component\HttpFoundation\Request;

class AuthHandler extends AbstractRouteHandler
{
    private const ROUTE = '/auth/token';
    
    public function handle(HandlerParamsInterface $params)
    {
    }
    
    public function support(HandlerParamsInterface $params): bool
    {
        return $params->getMethod() === Request::METHOD_POST &&
            $params->getBasePath() === self::ROUTE;
    }
}
