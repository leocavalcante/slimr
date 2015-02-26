<?php

namespace Slimr\Test;

use Slim\Slim;
use Slimr\Slimr;
use Slimr\SlimrInterface;

class SlimrTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Slim
     */
    private $app;

    /**
     * @var SlimrInterface
     */
    private $slimr;

    protected function setUp()
    {
        $this->app = new Slim();
        $this->slimr = new Slimr($this->app);
    }

    public function testServices()
    {
        $services = [
            'one_service' => ['Slimr\Test\OneService'],
            'two_service' => ['Slimr\Test\TwoService', ['one_service']]
        ];

        $this->slimr->services($services);

        $this->assertInstanceOf('Slimr\Test\OneService', $this->app->container['one_service']);
        $this->assertInstanceOf('Slimr\Test\TwoService', $this->app->container['two_service']);
        $this->assertInstanceOf('Slimr\Test\OneService', $this->app->container['two_service']->getOneService());
        $this->assertSame($this->app->container['one_service'], $this->app->container['two_service']->getOneService());
    }

    public function testRoutes()
    {
        $routes = [
            'one_route' => ['get', '/one', 'one_controller', 'handleGet']
        ];

        $this->slimr->routes($routes);

        $this->assertTrue($this->app->router()->hasNamedRoute('one_route'));
    }

    public function testMiddlewares()
    {
        $middlewares = [
            ['Slimr\Test\OneMiddleware']
        ];

        $this->slimr->middlewares($middlewares);
    }
}