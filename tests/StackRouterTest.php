<?php
namespace Stack\Aura\Tests;
use Symfony\Component\HttpFoundation\Request;
use Stack\Aura\RequestRouter;

use Aura\Router\RouterFactory;

class StackRouterTest extends \PHPUnit_Framework_TestCase
{

    public function testSimpleRoute()
    {
        $testapp = new Fixtures\TestApp;
        $router = $this->getRouter();
        $router->add('default', '/{controller}/{action}/{id}');
        $testapp = new RequestRouter($testapp, $router);

        $response = $testapp->handle(Request::create("/test/test/123","GET"));
        $params = unserialize($response->getContent());
        $this->assertEquals("test", $params["route"]["controller"]);
        $this->assertEquals("test", $params["route"]["action"]);
        $this->assertEquals("123",  $params["route"]["id"]);
    }

    public function testComplexRoute()
    {
        $testapp = new Fixtures\TestApp;
        $router = $this->getRouter();
        $router->add('complex', '/complex/{controller}/{action}/{id}{format}')
               ->addTokens([
                    'id'     => '[0-9a-z\-]+',
                    'format' => '(\.[^/]+)?',
        ]);
        $testapp = new RequestRouter($testapp, $router);
        $response = $testapp->handle(Request::create("/complex/test/test/abc-123.json","GET"));
        $params = unserialize($response->getContent());
        $this->assertEquals("test",     $params["route"]["controller"]);
        $this->assertEquals("test",     $params["route"]["action"]);
        $this->assertEquals("abc-123",  $params["route"]["id"]);
        $this->assertEquals(".json",    $params["route"]["format"]);
    }

    public function testResourceRoute() ]
    {
        $router = $this->getRouter();
        $router->attachResource('resources', '/resources');
        $testapp = new Fixtures\TestApp;
        $testapp = new RequestRouter($testapp, $router);
        $response = $testapp->handle(Request::create("/resources/300/edit","GET"));
        $params = unserialize($response->getContent());
        $this->assertEquals("resources",     $params["route"]["controller"]);
        $this->assertEquals("GET",           $params["route"]["REQUEST_METHOD"]);
    }

    protected function getRouter()
    {
        $router_factory = new RouterFactory;
        $router = $router_factory->newInstance();
        return $router;
    }

}