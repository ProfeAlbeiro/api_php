<?php
class Router {
    private $routes = [];

    public function addRoute($method, $path, $controller, $action, $db) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'db' => $db
        ];
    }

    public function route() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['PATH_INFO'] ?? '/';

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path)) {
                $controllerFile = 'controllers/' . $route['controller'] . '.php';
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controller = new $route['controller']($route['db']);
                    $action = $route['action'];
                    $controller->$action($this->getParams($route['path'], $path));
                    return;
                } else {
                    http_response_code(500);
                    echo json_encode(['mensaje' => 'Error interno del servidor: Controlador no encontrado']);
                    return;
                }
            }
        }

        http_response_code(404);
        echo json_encode(['mensaje' => 'Ruta no encontrada']);
    }

    private function matchPath($routePath, $requestPath) {
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        for ($i = 0; $i < count($routeParts); $i++) {
            if (substr($routeParts[$i], 0, 1) === '{') {
                continue;
            }
            if ($routeParts[$i] !== $requestParts[$i]) {
                return false;
            }
        }

        return true;
    }

    private function getParams($routePath, $requestPath) {
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));
        $params = [];

        for ($i = 0; $i < count($routeParts); $i++) {
            if (substr($routeParts[$i], 0, 1) === '{') {
                $paramName = trim($routeParts[$i], '{}');
                $params[$paramName] = $requestParts[$i];
            }
        }
        if (count($params) > 0 ){
            return $params;
        }else{
            return null;
        }
    }
}
?>