<?php

namespace Slimr\Test;

use Slim\Middleware;

class TwoMiddleware extends Middleware
{
    public function __construct(OneService $oneService) {}

    /**
     * Call
     *
     * Perform actions specific to this middleware and optionally
     * call the next downstream middleware.
     */
    public function call()
    {
        // TODO: Implement call() method.
    }
}