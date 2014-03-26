<?php
namespace Stack\Aura\Tests\Fixtures;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TestApp implements HttpKernelInterface {


    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if($request->getRequestUri() == "/") return new Response("public");
        if($request->getRequestUri() == "/protected") return new Response("protected");
        if($request->getRequestUri() == "/anon") return new Response("anonymous");
        return new Response("invalid");
    }



}