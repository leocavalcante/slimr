<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Slim\Slim();

$slimr = new \Slimr\Slimr($app);
$slimr->wireServices(require(__DIR__.'/app/services.php'));
$slimr->wireRoutes(require(__DIR__.'/app/routes.php'));

$app->run();