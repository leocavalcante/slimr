<?php

namespace Slimr;

use Slim\Middleware;
use Slim\Slim;

class Slimr implements SlimrInterface
{
    private $slim;
    private $middlewares = [];
    private $services = [];
    private $routes = [];
    private $hooks = [];

    public function __construct(Slim $slim)
    {
        $this->slim = $slim;
    }

    public function wire()
    {
        foreach ($this->services as $serviceConfig) {
            if (count($serviceConfig) < 2) {
                throw new \InvalidArgumentException('Service configuration must have at least a name and a class');
            }

            $serviceName = array_shift($serviceConfig);
            $serviceClass = array_shift($serviceConfig);

            $this->slim->container->singleton(
                $serviceName, function($container) use ($serviceClass, $serviceConfig) {
                    $service = new \ReflectionClass($serviceClass);

                    if (empty($serviceConfig)) {
                        return $service->newInstance();
                    }

                    return $service->newInstanceArgs(
                        array_map(
                            function($serviceName) use ($container) {
                                return $container[$serviceName];
                            }, $serviceConfig
                        )
                    );
                }
            );
        }

        foreach ($this->middlewares as $middlewareConfig) {
            if (count($middlewareConfig) < 1) {
                throw new \InvalidArgumentException('Middleware configuration must have at least a class');
            }

            $middlewareClass = array_shift($middlewareConfig);

            $middleware = new \ReflectionClass($middlewareClass);

            if (empty($middlewareConfig)) {
                /**
                 * @var Middleware $middlewareInstance
                 */
                $middlewareInstance = $middleware->newInstance();
                $this->slim->add($middlewareInstance);
                continue;
            }

            /**
             * @var Middleware $middlewareInstance
             */
            $middlewareInstance = $middleware->newInstanceArgs(
                array_map(
                    function($serviceName) {
                        return $this->slim->container[$serviceName];
                    }, $middlewareConfig
                )
            );

            $this->slim->add($middlewareInstance);
        }

        foreach ($this->hooks as $hookConfig) {
            if (count($hookConfig) < 3) {
                throw new \InvalidArgumentException('Hook configuration must have a name, an object and a method');
            }

            $this->slim->hook($hookConfig[0], [$this->slim->container[$hookConfig[1]], $hookConfig[2]]);
        }

        foreach ($this->routes as $routeConfig) {
            if (count($routeConfig) < 5) {
                throw new \InvalidArgumentException('Route configuration must have a name, a method, a pattern, a service name and a service method');
            }

            $this->slim->{$routeConfig[1]}($routeConfig[2], function() use ($routeConfig) {
                $this->slim->container[$routeConfig[3]]->{$routeConfig[4]}($this->slim);
            })->name($routeConfig[0]);
        }
    }

    public function middlewares(array $middlewares)
    {
        $this->middlewares = $middlewares;
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
