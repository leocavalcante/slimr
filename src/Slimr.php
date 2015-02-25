<?php

namespace Slimr;

use Slim\Slim;

class Slimr implements SlimrInterface
{
    private $slim;

    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }

    public function wireServices(array $services)
    {
        foreach ($services as $serviceName => $serviceConfig) {
            $this->slim->container->singleton($serviceName, function($container) use($serviceConfig) {
                $service = new \ReflectionClass($serviceConfig[0]);

                if (empty($serviceConfig[1])) {
                    return $service->newInstance();
                }

                return $service->newInstanceArgs(array_map(function($serviceName) use($container) {
                    return $container[$serviceName];
                }, $serviceConfig[1]));
            });
        }
    }

    public function wireRoutes(array $routes)
    {
        foreach ($routes as $routeName => $routeConfig) {
            $this->slim->{$routeConfig[0]}($routeConfig[1], function() use($routeConfig) {
                $this->slim->container[$routeConfig[2]]->{$routeConfig[3]}($this->slim);
            })->name($routeName);
        }
    }

    public function wireHooks(array $hooks)
    {
        // TODO: Implement wireHooks() method.
    }
}