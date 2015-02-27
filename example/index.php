<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use Slim\Slim;
use Slimr\Slimr;

$app = new Slim();

(new Slimr($app))
    ->middlewares(Yaml::parse(file_get_contents(__DIR__.'/app/middlewares.yml')))
    ->services(Yaml::parse(file_get_contents(__DIR__.'/app/services.yml')))
    ->routes(Yaml::parse(file_get_contents(__DIR__.'/app/routes.yml')))
    ->hooks(Yaml::parse(file_get_contents(__DIR__.'/app/hooks.yml')))
    ->wire();

$app->run();