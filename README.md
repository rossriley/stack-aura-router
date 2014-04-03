## Stack Aura Router

### Technologies Used

You need to build your app using <a href="http://stackphp.com">Stack PHP</a>


### Installation

Is best done via composer, all you need to do is add this to the (or ignore any packages that you already have) require block of your composer.json file:

    require: {
        ....
        "aura/router": "~2.0@dev" ,
        "rossriley/stack-aura-router": "1.0.*@dev",
        "stack/builder" : "dev-master",
        "stack/url-map" : "dev-master",
        "stack/run"     : "dev-master",
        ....
    }



### How it works

This project works on a very simple concept. Using <a href="https://github.com/auraphp/Aura.Router/">Aura Router</a> which is a lovely decoupled Routing package you can define your routes and add the data to an HTTP request object.

Here's an example of bootstrapping an application:

First up configure your routes:

    #routes.php
    <?php
    use Aura\Router\RouterFactory;
    $router_factory = new RouterFactory;
    $router = $router_factory->newInstance();
    $router->setValues(['controller' => 'YourNamespace\Controller\Main']);
    $router->add("homepage", '/'')->addValues(["action"=>"index"]);
    $router->add("signup", '/signup')->addValues(["action"=>"signup"]);
    ......


Then bootstrap your app:

    #public/index.php

    $router = include(__DIR__."/../config/routes.php");

    $app = new YourNamespace\Application;


    $app = (new Stack\Builder())
            ->push('Stack\Session')
            ->push('Stack\Aura\RequestRouter', $router)
            ->resolve($app);

    Stack\run($app);


### How to use the compiled routes.

Since your Stack app handles an `HttpKernelInterface $request` instance, your route details can be fetched directly from the request

    $route = $request->attributes->get("route");
    // This outputs with a request to /
    Array (
        [controller] => YourNamespace\Controller\Main
        [action] => index
        [_name] => homepage
        [_route] => /
    )

As you'll see this output matches the route you described in your `routes.php` file.

Similarly, the signup route would output the following:

    $route = $request->attributes->get("route");
    // This outputs with a request to /signup
    Array (
        [controller] => YourNamespace\Controller\Main
        [action] => signup
        [_name] => signup
        [_route] => /signup
    )


### Contributions Welcome

This is a relatively new project in early alpha stage, although it's being used in the wild by a few fairly large projects. Pull requests / ideas for improvement are most welcome.

