<?php
namespace Stack\Aura\Tests\Fixtures;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TestApp implements HttpKernelInterface {


    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        return new Response(serialize($request->attributes->all()));
    }



}