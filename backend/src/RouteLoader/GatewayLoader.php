<?php

namespace App\RouteLoader;


use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class GatewayLoader extends Loader
{
    private const TYPE         = 'json';
    private const PREFIX_ROUTE = 'gateway_';
    private bool             $isLoaded = false;
    private ?RouteCollection $routes   = null;
    
    public function load(mixed $resource, string $type = null): RouteCollection
    {
        if (true === $this->isLoaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }
        if (!file_exists($resource)) {
            throw new \RuntimeException(sprintf('Resource "%s" not found', $resource));
        }
        $this->routes = new RouteCollection();
        $files = Finder::create()->in($resource);
        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);
            $this->loadRoutes($data);
        }
        
        $this->isLoaded = true;
        
        return $this->routes;
    }
    
    public function supports(mixed $resource, string $type = null): bool
    {
        return self::TYPE === $type;
    }
    
    private function loadRoutes(array $items)
    {
        foreach ($items as $item) {
            // prepare a new route
            $path = $item['route'];
            $routeName = $this->getRouteName($path);
            $defaults = [
                '_controller' => 'App\Controller\GatewayController::index',
            ];
            $requirements = [];
            $route = new Route($path, $defaults, $requirements, [], null, [], $item['methods']);
            
            // add the new route to the route collection
            $routeName = self::PREFIX_ROUTE . $routeName;
            $this->routes->add($routeName, $route);
        }
    }
    
    private function getRouteName(string $route): string
    {
        $items = explode('/', $route);
        if (count($items) > 1) {
            return implode('_', $items);
        }
        
        return trim($route);
    }
}
