<?php

namespace Chloe\Routeur;

class Route {

    private string $name;
    private string $path;
    /**
     * @var array|callable
     */
    private $callable;

    /**
     * @param string $name
     * @param string $path
     * @param array|callable $callable
     */
    public function __construct(string $name, string $path, $callable) {
        $this->name = $name;
        $this->path = $path;
        $this->callable = $callable;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * @return array|callable
     */
    public function getCallable() {
        return $this->callable;
    }

    // transformer le chemin en regex pour récupérer ici son id
    public function test(string $path): bool {
        $pattern = str_replace("/", "\/", $this->path);
        $pattern = sprintf("/^%s$/", $pattern);
        $pattern = preg_replace("/(\{\w+\})/", "(.+)", $pattern);
        return preg_match_all($pattern, $path);
    }

    public function call() {
        return call_user_func_array($this->callable, []);
    }
}