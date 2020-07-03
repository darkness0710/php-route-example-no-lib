<?php

class Route
{
    private $request;
    public static $routes = [];

    public static function __callStatic($method, $args)
    {
        @list($url, $callback) = $args;
        self::$routes[$method][$url] = $callback;
    }

    public function run()
    {
        return self::process();
    }

    public function process()
    {
        // Turn off notice and errors
        error_reporting(0);

        $call = self::hasRequestMethod(self::getRequestMethod(), self::getQueryString());
        if (is_null($call)) {
            $newQueryString = str_replace(
                end(explode('/', self::getQueryString())),
                '*',
                self::getQueryString()
            );
            $try = self::hasRequestMethod(self::getRequestMethod(), $newQueryString);
            if (is_null($try)) {
                return self::invalidMethod();
            }
            echo $try();
            return;
        }
        echo $call();
    }

    public function getRequestMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getQueryString()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function invalidMethod()
    {
        echo 'This page not found!';
    }

    public function hasRequestMethod($method, $queryString)
    {
        return self::$routes[$method][$queryString] ?? null;
    }
}