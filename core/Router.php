<?php

namespace Core;

use App\controllers\ErrorController;

class Router
{
    private array $routes = [];

    public function register_route($method, $uri, $action, $middleware = null)
    {
        list($controller, $controllerMethod) = explode("@", $action);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    public function get($uri, $action, $middleware = null)
    {
        $this->register_route('GET', $uri, $action, $middleware);
    }

    public function put($uri, $action, $middleware = null)
    {
        $this->register_route('PUT', $uri, $action, $middleware);
    }

    public function post($uri, $action, $middleware = null)
    {
        $this->register_route('POST', $uri, $action, $middleware);
    }

    public function delete($uri, $action, $middleware = null)
    {
        $this->register_route('DELETE', $uri, $action, $middleware);
    }

    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        $uriSegments = explode('/', trim($uri, '/'));
        $uriSegmentsCount = count($uriSegments);

        foreach ($this->routes as $route) {
            $routeUri = trim($route['uri'], '/');
            $routeUriSegments = explode('/', $routeUri);
            $routeUriSegmentsCount = count($routeUriSegments);

            if ($requestMethod === strtoupper($route['method']) && $uriSegmentsCount === $routeUriSegmentsCount) {
                $params = [];
                $matched = true;

                for ($i = 0; $i < $uriSegmentsCount; $i++) {
                    if ($uriSegments[$i] === $routeUriSegments[$i]) {
                        continue;
                    }
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
                if ($matched) {
                    if (isset($route['middleware']) && is_array($route['middleware'])) {
                            (new Authorize())->handle($route['middleware']);
                    }
                    $controllerClass = 'App\\controllers\\' . $route['controller'];
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