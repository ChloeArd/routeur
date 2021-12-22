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

        $routeHome = new Route("home", "/", function() {
            return "Hello world";
        });

        $routeArticle = new Route("article", "/blog/{id}/{slug}", function(string $id, string $slug) {
            return sprintf("%s : %s", $id, $slug);
        });

        $router->add($routeHome);
        $router->add($routeArticle);

        $this->assertCount(2, $router->getRouteCollection());

        $this->assertContainsOnlyInstancesOf(Route::class, $router->getRouteCollection());

        $this->assertEquals($routeHome, $router->get("home"));

        $this->assertEquals($routeHome, $router->match("/"));
        $this->assertEquals($routeArticle, $router->match("/blog/12/mon-article"));

        $this->assertEquals("Hello world", $router->match("/")->call());

    }

    public function testIfRouteNotFoundByMatch() {
        $router = new Router();
        $this->expectException(RouteNotFoundException::class);
        $router->match("/");
    }

    // vérifie si la route n'existe pas
    public function testIfRouteNotFoundByGet() {
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