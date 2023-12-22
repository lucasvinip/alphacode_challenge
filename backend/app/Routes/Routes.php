<?php
include 'util/MessagesError.php';

class Routes
{
    private $routes = [];

    public function add($pattern, $method, $callback)
    {
        $this->routes[] = [
            'pattern' => $pattern,
            'method' => $method,
            'callback' => $callback,
        ];
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            $pattern = '#' . $route['pattern'] . '#';
            if ($method === $route['method'] && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }

        $notFound = new MessagesError();
        $notFound->pathNotFound($method, $uri);
    }
}