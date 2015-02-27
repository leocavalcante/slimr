<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Slim\Slim();

(new \Slimr\Slimr($app))
    ->middlewares(require(__DIR__ . '/app/middlewares.php'))
    ->services(require(__DIR__.'/app/services.php'))
    ->routes(require(__DIR__.'/app/routes.php'))
    ->hooks(require(__DIR__.'/app/hooks.php'))
    ->wire();

$app->run();