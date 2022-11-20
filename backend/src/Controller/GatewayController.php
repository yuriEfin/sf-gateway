<?php

namespace App\Controller;


use App\Context\Rest\Interfaces\HandlerResolverInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'gateway_')]
class GatewayController extends AbstractApiController
{
    public function __construct(private readonly HandlerResolverInterface $handlerResolver)
    {
    }
    
    public function index()
    {
        return $this->json(
            [
                'test'    => 'Ok',
                'handler' => $this->handlerResolver->resolve(),
            ]
        );
    }
}
