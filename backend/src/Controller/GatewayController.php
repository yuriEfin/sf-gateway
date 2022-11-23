<?php

namespace App\Controller;


use App\Context\Exceptions\RouteHandlerNotExistsException;
use App\Context\Rest\Interfaces\HandlerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'gateway_')]
class GatewayController extends AbstractApiController
{
    public function __construct(private readonly HandlerInterface $routeHandler)
    {
    }
    
    public function index()
    {
        try {
            $handlerData = $this->routeHandler->handle();
        } catch (RouteHandlerNotExistsException $ex) {
            return $this->json(
                [
                    'errors' => [
                        'message' => sprintf('Resource "%s" not found', $ex->getRoute()),
                    ],
                ]
            );
        } catch (\Throwable $ex) {
            return $this->json(
                [
                    'errors' => [
                        'message' => $ex->getMessage(),
                        'trace'   => $this->getParameter('APP_DEBUG') ? $ex->getTraceAsString() : null,
                    ],
                ]
            );
        }
        
        return $this->json($handlerData);
    }
}
