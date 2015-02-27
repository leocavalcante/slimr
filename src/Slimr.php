<?php

namespace Slimr;

use Slim\Slim;

class Slimr implements SlimrInterface
{
    private $slim;
    private $middleware = [];
    private $services = [];
    private $routes = [];
    private $hooks = [];

    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }

    public function run()
    {
        foreach ($this->services as $serviceName => $serviceConfig) {
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

        foreach ($this->middleware as $middlewareConfig) {
            $middleware = new \ReflectionClass($middlewareConfig[0]);

            if (empty($middlewareConfig[1])) {
                $this->slim->add($middleware->newInstance());
                continue;
            }

            $this->slim->add($middleware->newInstanceArgs(array_map(function($serviceName) {
                return $this->slim->container[$serviceName];
            }, $middlewareConfig[1])));
        }

        foreach ($this->routes as $routeName => $routeConfig) {
            $this->slim->{$routeConfig[0]}($routeConfig[1], function() use($routeConfig) {
                $this->slim->container[$routeConfig[2]]->{$routeConfig[3]}($this->slim);
            })->name($routeName);
        }
    }

    public function middleware(array $middleware)
    {
        $this->middleware = $middleware;
        return $this;
    }

    public function services(array $services)
    {
        $this->services = $services;
        return $this;
    }

    public function routes(array $routes)
    {
        $this->routes = $routes;
        return $this;
    }

    public function hooks(array $hooks)
    {
        $this->hooks = $hooks;
        return $this;
    }
}