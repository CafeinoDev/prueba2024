<?php

declare(strict_types=1);

namespace LG\Interfaces\App;

class Router
{
    private static $router;

    private function __construct(private array $routes = [])
    {
    }

    public static function getRouter(): self
    {

        if (!isset(self::$router)) {

            self::$router = new self();
        }

        return self::$router;
    }

    public function get(string $uri, mixed $action): void {

        $this->register($uri, $action, "GET");
    }

    public function post(string $uri, mixed $action): void {

        $this->register($uri, $action, "POST");
    }

    public function put(string $uri, mixed $action): void {

        $this->register($uri, $action, "PUT");
    }

    public function delete(string $uri, mixed $action): void{

        $this->register($uri, $action, "DELETE");
    }

    protected function register(string $uri, mixed $action, string $method): void {

        if(!isset($this->routes[$method])) $this->routes[$method] = [];

        list($controller, $function) = $this->extractAction($action);

        $this->routes[$method][$uri] = [
            'controller' => $controller,
            'method' => $function
        ];
    }

    protected function extractAction(mixed $action, string $separator = '@'): array {
        if(is_array($action)) return $action;

        $sepIdx = strpos($action, $separator);

        $controller = substr($action, 0, $sepIdx);
        $function = substr($action, $sepIdx + 1, strlen($action));

        return [$controller, $function];
    }

    public function route(string $method, string $uri): bool {

        list($result, $params) = Utils::dataGet($this->routes, $method .".". $uri);

        if (!$result) Utils::abort("Method not allowed to this endpoint", 404);

        $controller = $result['controller'];
        $function = $result['method'];

        if(class_exists($controller)) {

            $controllerInstance = new $controller();

            if(method_exists($controllerInstance, $function)) {
                $controllerInstance->params = $params;
                $controllerInstance->$function($params);
                return true;

            } else {

                Utils::abort("No method {$function} on class {$controller}", 500);
            }
        }

        return false;
    }
}