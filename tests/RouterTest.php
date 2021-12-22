<?php

namespace Chloe\Routeur\Tests;

use Chloe\Routeur\Route;
use Chloe\Routeur\RouteAlreadyExistsException;
use Chloe\Routeur\RouteNotFoundException;
use Chloe\Routeur\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

    public function test() {
        $router = new Router();

        $route = new Route("home", "/", function() {
            echo "Hello World";
        });

        $router->add($route);
        $this->assertCount(1, $router->getRouteCollection());

        $this->assertContainsOnlyInstancesOf(Route::class, $router->getRouteCollection());

        $this->assertEquals($route, $router->get("home"));
    }

    // vérifie si la route n'existe pas
    public function testIfRouteNotFound() {
        $router = new Router();
        $this->expectException(RouteNotFoundException::class);
        $router->get("fail");
    }

    // verifie si la route existe déja
    public function testIfRouteAlreadyExists() {
        $router = new Router();
        $router->add(new Route("home", "/", function () {}));
        $this->expectException(RouteAlreadyExistsException::class);
        $router->add(new Route("home", "/", function () {}));
    }
}