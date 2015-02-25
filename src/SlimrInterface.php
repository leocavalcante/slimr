<?php

namespace Slimr;

interface SlimrInterface
{
    public function wireServices(array $services);
    public function wireRoutes(array $routes);
    public function wireHooks(array $hooks);
}