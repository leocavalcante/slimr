<?php

namespace Slimr;

interface SlimrInterface
{
    /**
     * @param array $middleware
     * @return SlimrInterface
     */
    public function middleware(array $middleware);

    /**
     * @param array $services
     * @return SlimrInterface
     */
    public function services(array $services);

    /**
     * @param array $routes
     * @return SlimrInterface
     */
    public function routes(array $routes);

    /**
     * @param array $hooks
     * @return SlimrInterface
     */
    public function hooks(array $hooks);

    public function run();
}