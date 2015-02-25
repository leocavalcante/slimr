<?php

namespace Slimr\Test;

class TwoService
{
    private $oneService;

    public function __construct(OneService $oneService)
    {
        $this->oneService = $oneService;
    }

    public function getOneService()
    {
        return $this->oneService;
    }
}