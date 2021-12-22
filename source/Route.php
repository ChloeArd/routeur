<?php

namespace Chloe\Routeur;

use ReflectionFunction;
use ReflectionParameter;

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
        return preg_match($pattern, $path);
    }

    public function call(string $path) {
        $pattern = str_replace("/", "\/", $this->path);
        $pattern = sprintf("/^%s$/", $pattern);
        $pattern = preg_replace("/(\{\w+\})/", "(.+)", $pattern);
        preg_match($pattern, $path, $matches);

        array_shift($matches);

        preg_match_all("/\{(\w+)\}/", $this->path, $paramMatches);

        // dépile un élément au début d'un tableau, supprimer le 1er élément
        $parameters = $paramMatches[1];

        $argsValue = [];

        if (count($parameters) > 0) {
            $parameters = array_combine($parameters, $matches);
            $reflectionFunc = new ReflectionFunction($this->callable);

            $args = array_map(fn (ReflectionParameter $param) => $param->getName(), $reflectionFunc->getParameters());

            $argsValue = array_map(function (string $name) use ($parameters) {
                return $parameters[$name];
            },$args);
        }

        return call_user_func_array($this->callable, $argsValue);
    }
}