<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Slim\Slim();

$slimr = new \Slimr\Slimr($app);
$slimr->services(require(__DIR__.'/app/services.php'));
$slimr->routes(require(__DIR__.'/app/routes.php'));

$app->run();