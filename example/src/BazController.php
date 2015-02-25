<?php

namespace Slimr\Example;

use Slim\Slim;

class BazController
{
    private $barService;

    public function __construct(BarService $barService)
    {
        $this->barService = $barService;
    }

    public function handleGet(Slim $app)
    {
        $bar = $app->router()
            ->getCurrentRoute()
            ->getParam('bar');

        $content = $this->barService
            ->doAnotherThingNice($bar);

        $app->response()
            ->setBody($content);
    }
}