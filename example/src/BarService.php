<?php

namespace Slimr\Example;

class BarService
{
    private $fooService;

    public function __construct(FooService $fooService)
    {
        $this->fooService = $fooService;
    }

    public function doAnotherThingNice($str)
    {
        return str_repeat($this->fooService->doSomethingNice($str), 2);
    }
}