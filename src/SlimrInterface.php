<?php

namespace Slimr;

interface SlimrInterface
{
    public function middlewares(array $middlewares);
    public function services(array $services);
    public function routes(array $routes);
    public function hooks(array $hooks);
}