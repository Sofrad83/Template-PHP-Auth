<?php

namespace Core;

class Route
{
    private static $routes = [];

    public static function get($uri, $controller)
    {
        self::$routes['GET'][$uri] = $controller;
    }

    public static function post($uri, $controller)
    {
        self::$routes['POST'][$uri] = $controller;
    }

    public static function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset(self::$routes[$method][$uri])) {
            $controllerAction = explode('@', self::$routes[$method][$uri]);
            $controllerName = 'App\\Controllers\\' . $controllerAction[0];
            $action = $controllerAction[1];

            $controller = new $controllerName();
            $controller->$action();
        } else {
            http_response_code(404);
            echo "404 - Page Not Found"; //TODO Customiser la 404
        }
    }
}
