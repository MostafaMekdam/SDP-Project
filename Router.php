<?php

class Router
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function route(string $controller, string $action, array $params = [])
    {
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

        $queryParams = $_GET;
        unset($queryParams['controller'], $queryParams['action']); // Remove reserved parameters
        if (isset($queryParams['id'])) {
            $params['id'] = $queryParams['id']; // Add `id` from the query string to the params array
        }
        $mergedParams = array_merge($queryParams, $params);
        $orderedParams = [$mergedParams]; // Wrap parameters in an array for the controller
        call_user_func_array([$controllerInstance, $action], $orderedParams);
    }

    private function error(string $message)
    {
        http_response_code(404);
        echo "<h1>Error</h1><p>$message</p>";
    }
}
