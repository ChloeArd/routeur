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

}