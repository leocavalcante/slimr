[![Build Status](https://travis-ci.org/leocavalcante/slimr.svg?branch=master)](https://travis-ci.org/leocavalcante/slimr)

# Slimr
Wire up services, middlewares, routes and hooks in your Slim application, manage your dependencies and use Controllers as Services.

## How

### Services
    ['service_name' => ['ServiceClass', ['dependency_service_name']]];

### Middlewares
    [['MiddlewareClass', ['dependency_service_name']]];

### Hooks
    ['hook_name' => ['service_name', 'serviceMethod']];
    
### Routes
    ['route_name' => ['method', 'pattern', 'service_name', 'serviceMethod']];

