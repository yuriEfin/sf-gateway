<?php

namespace App\Context\Rest;


use App\Context\Exceptions\RouteHandlerNotExistsException;
use App\Context\Rest\Interfaces\RouteHandlerInterface;
use App\Context\Rest\Interfaces\HandlerInterface;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\HttpFoundation\RequestStack;

class RouteHandler implements HandlerInterface
{
    private array                  $handlers;
    private RequestStack           $request;
    private ?RouteHandlerInterface $currentHandler = null;
    
    public function __construct(RewindableGenerator $handlers, RequestStack $request)
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
        
        $this->request = $request;
    }
    
    public function handle()
    {
        $request = $this->request->getCurrentRequest();
        $params = new HandlerParams(
            $request->getPathInfo(),
            $request->getMethod(),
            [
                'get'  => $request->query->all(),
                'post' => $request->request->all(),
                'body' => json_decode($request->getContent() ?? [], true),
            ]
        );
        
        /** @var RouteHandlerInterface $handler */
        foreach ($this->handlers as $handler) {
            if ($handler->support($params)) {
                $this->currentHandler = $handler;
                
                break;
            }
        }
        if (!$this->currentHandler) {
            throw new RouteHandlerNotExistsException($request->getPathInfo());
        }
        
        return $this->currentHandler->handle($params);
    }
    
    public function addHandler(RouteHandlerInterface $handler): void
    {
        $this->handlers[get_class($handler)] = $handler;
    }
    
    public function getCurrentHandler(): ?array
    {
        return $this->currentHandler;
    }
}
