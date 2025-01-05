<?php

class Router {
    private $routes;

    public function __construct(array $routes) {
        $this->routes = $routes;
    }

    public function route(string $controller, string $action, array $params = []) {
        $controller = htmlspecialchars($controller);
        $action = htmlspecialchars($action);

        if (!array_key_exists($controller, $this->routes)) {
            $this->error("Controller '$controller' not found.");
            return;
        }

        $controllerClass = $this->routes[$controller];
        if (!class_exists($controllerClass)) {
            $this->error("Controller class '$controllerClass' does not exist.");
            return;
        }

        $controllerInstance = new $controllerClass();
        if (!method_exists($controllerInstance, $action)) {
            $this->error("Action '$action' not found in controller '$controllerClass'.");
            return;
        }

        call_user_func_array([$controllerInstance, $action], $params);
    }

    private function error(string $message) {
        http_response_code(404);
        echo "<h1>Error</h1><p>$message</p>";
    }
}