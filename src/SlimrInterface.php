<?php

namespace Slimr;

interface SlimrInterface
{
    /**
     * @param array $middlewares
     * @return SlimrInterface
     */
    public function middlewares(array $middlewares);

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

    public function wire();
}