<?php
namespace Stack\Aura;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Aura\Router\Router;

class RequestRouter implements HttpKernelInterface
{

    private $app;

    public function __construct(HttpKernelInterface $app, Router $router)
    {
        $this->app = $app;

        if (!isset($router)) {
            throw new \InvalidArgumentException(
                "You must pass an Aura Router Object into the Stack Middleware"
            );
        }

        $this->router = $router;

    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $type) {
            return $this->app->handle($request, $type, $catch);
        }

        $route = $this->router->match($request->getPathInfo(),$request->server->all());
        if($route) {
            $params = $route->params;
            $params["_name"] = $route->name;
            $params["_route"] = $route->path;
            $request->attributes->set("route", $params);
        }

        return $this->app->handle($request, $type, $catch);
    }
}