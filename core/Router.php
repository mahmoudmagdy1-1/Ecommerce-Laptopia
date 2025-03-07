<?php

namespace Core;

use App\controllers\ErrorController;
class Router
{
    private array $routes = [];

    public function register_route($method, $uri, $action)
    {
        list($controller, $controllerMethod) = explode("@", $action);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
        ];
    }

    public function get($uri, $action)
    {
        $this->register_route('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->register_route('POST', $uri, $action);
    }

    public function route($uri)
    {
        // Get the request method and check for _method override on POST
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        // Trim leading/trailing slashes and split the URI into segments
        $uriSegments = explode('/', trim($uri, '/'));
        $uriSegmentsCount = count($uriSegments);

        foreach ($this->routes as $route) {
            // Trim the route URI and split it into segments
            $routeUri = trim($route['uri'], '/');
            $routeUriSegments = explode('/', $routeUri);
            $routeUriSegmentsCount = count($routeUriSegments);

            // Compare the request method (ensuring same case) and segment count
            if ($requestMethod === strtoupper($route['method']) && $uriSegmentsCount === $routeUriSegmentsCount) {
                $params = [];
                $matched = true;

                // Loop through each segment to match literals and parameters
                for ($i = 0; $i < $uriSegmentsCount; $i++) {
                    // If segments are identical, move to the next segment
                    if ($uriSegments[$i] === $routeUriSegments[$i]) {
                        continue;
                    }
                    // Check if the current route segment is a parameter placeholder
                    if (str_starts_with($routeUriSegments[$i], '{') && str_ends_with($routeUriSegments[$i], '}')) {
                        if ($uriSegments[$i] !== '') {
                            $paramName = substr($routeUriSegments[$i], 1, -1);
                            $params[$paramName] = $uriSegments[$i];
                        }
                    } else {
                        $matched = false;
                        break;
                    }
                }
                // If a match was found, process middleware and dispatch the controller
                if ($matched) {
//                    if (isset($route['middleware']) && is_array($route['middleware'])) {
//                        foreach ($route['middleware'] as $middleware) {
//                            (new Authorize())->handle($middleware);
//                        }
//                    }
//                    foreach(get_declared_classes() as $name){
//                        inspect($name);
//                    }
                    $controllerClass = 'App\\controllers\\' . $route['controller'];
//                    inspectAndDie($controllerClass);
                    $controllerMethod = $route['controllerMethod'];

                    $controllerInstance = new $controllerClass();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }

        ErrorController::notFound();
    }

}