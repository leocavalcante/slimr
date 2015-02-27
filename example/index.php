<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Slim\Slim();

(new \Slimr\Slimr($app))
    ->middleware(require(__DIR__.'/app/middleware.php'))
    ->services(require(__DIR__.'/app/services.php'))
    ->routes(require(__DIR__.'/app/routes.php'))
    ->hooks(require(__DIR__.'/app/hooks.php'))
    ->run();

$app->run();