<?php

namespace App\Context\Rest\Common;


use App\Context\Rest\Interfaces\RouteHandlerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractRouteHandler implements RouteHandlerInterface
{
    public function __construct(protected HttpClientInterface $httpClient)
    {
    }
    
    protected function doRequest()
    {
    }
    
    protected function request()
    {
        $this->doRequest();
    }
    
    protected function requestAsync()
    {
    }
    
    protected function get()
    {
    }
    
    protected function post()
    {
    }
}
