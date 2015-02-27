<?php

namespace Slimr\Example;

use Slim\Middleware;

class PlainTextMiddleware extends Middleware
{

    /**
     * Call
     *
     * Perform actions specific to this middleware and optionally
     * call the next downstream middleware.
     */
    public function call()
    {
        $this->app->response()->header('Content-Type', 'text/plain');
        $this->next->call();
    }
}