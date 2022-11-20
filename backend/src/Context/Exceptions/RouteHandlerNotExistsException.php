<?php

namespace App\Context\Exceptions;


use Exception;
use Throwable;

class RouteHandlerNotExistsException extends Exception
{
    private ?string $route = null;
    
    public function __construct(?string $route = null, string $message = 'Not found handler for route', int $code = 0, ?Throwable $previous = null)
    {
        $this->route = $route;
        parent::__construct($message .': '. $route, $code, $previous);
    }
    
    /**
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }
}
