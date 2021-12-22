<?php

namespace Chloe\Routeur;

class Router {

    /**
     * @var Route[]
     */
    private array $routes = [];

    /**
     * @param Route $route
     * @return $this
     */
    public function add(Route $route): self {
        if ($this->has($route->getName())) {
            throw new RouteAlreadyExistsException();
        }
        $this->routes[$route->getName()] = $route;
        return $this;
    }

    /**
     * @param string $name
     * @return Route
     */
    public function get(string $name): Route {
        if (!$this->has($name)) {
            throw new RouteNotFoundException();
        }
        return $this->routes[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool {
        return isset($this->routes[$name]);
    }

    /**
     * @return Route[]
     */
    public function getRouteCollection(): array {
        return $this->routes;
    }
}