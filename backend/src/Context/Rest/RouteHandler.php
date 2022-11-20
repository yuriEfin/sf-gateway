<?php

namespace App\Context\Rest;


use App\Context\Exceptions\RouteHandlerNotExistsException;
use App\Context\Rest\Interfaces\RouteHandlerInterface;
use App\Context\Rest\Interfaces\HandlerResolverInterface;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\HttpFoundation\RequestStack;

class RouteHandler implements HandlerResolverInterface
{
    private array        $handlers;
    private RequestStack $request;
    
    public function __construct(RewindableGenerator $handlers, RequestStack $request)
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
        
        $this->request = $request;
    }
    
    public function resolve(): RouteHandlerInterface
    {
        $request = $this->request->getCurrentRequest();
        $params = new HandlerParams(
            $request->getPathInfo(),
            $request->getMethod(),
            []
        );
        foreach ($this->handlers as $handler) {
            if ($handler->support($params)) {
                return $handler;
            }
        }
        
        throw new RouteHandlerNotExistsException($request->getPathInfo());
    }
    
    public function addHandler(RouteHandlerInterface $handler): void
    {
        $this->handlers[get_class($handler)] = $handler;
    }
    
    public function getHandlers()
    {
        return $this->handlers;
    }
}
