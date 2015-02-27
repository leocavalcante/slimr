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

        $this->slimr
            ->services($services)
            ->run();

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

        $this->slimr
            ->routes($routes)
            ->run();

        $this->assertTrue($this->app->router()->hasNamedRoute('one_route'));
    }

    public function testMiddlewares()
    {
        $services = [
            'one_service' => ['Slimr\Test\OneService']
        ];

        $middleware = [
            ['Slimr\Test\OneMiddleware'],
            ['Slimr\Test\TwoMiddleware', ['one_service']]
        ];

        $this->slimr
            ->middleware($middleware)
            ->services($services)
            ->run();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage It works
     */
    public function testHooks()
    {
        $hookName = 'one_hook';

        $hooks = [
            $hookName => ['one_service', 'oneMethod']
        ];

        $services = [
            'one_service' => ['Slimr\Test\OneService']
        ];

        $this->slimr
            ->services($services)
            ->hooks($hooks)
            ->run();

        $this->assertArrayHasKey($hookName, $this->app->getHooks());
        $this->app->applyHook($hookName);
    }
}