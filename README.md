[![Build Status](https://travis-ci.org/leocavalcante/slimr.svg?branch=master)](https://travis-ci.org/leocavalcante/slimr)

# Slimr
Wire up services, middlewares, routes and hooks in your Slim application, manage your dependencies and use Controllers as Services.

## How
```
<?php

$services = [
    ['service_name', 'ServiceClass'(, ...service_dependencies)]
];

$middlewares = [
    ['MiddlewareClass'(, ...middleware_dependencies)]
];

$hooks = [
    ['hook_name', 'service_name', 'serviceMethod']
];

$routes = [
    ['route_name', 'route_method', 'pattern', 'service_name', 'serviceMethod']
];

// Note: Take a look at /example to see it using external Yaml files 

$app = new Slim();

(new Slimr($app))
    ->middlewares($middlewares)
    ->services($services)
    ->routes($routes)
    ->hooks($hooks)
    ->wire();

$app->run();
```