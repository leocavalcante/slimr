<?php

return [
    'foo_service' => ['Slimr\Example\FooService'],
    'bar_service' => ['Slimr\Example\BarService', ['foo_service']],
    'baz_controller' => ['Slimr\Example\BazController', ['bar_service']]
];