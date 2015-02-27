<?php

namespace Slimr\Example;

class FooService
{
    public function doSomethingNice($str)
    {
        return strtoupper($str);
    }

    public function hookMethod()
    {
        // never do that
        echo 'Hook works';
    }
}