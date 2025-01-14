<?php 

namespace App\Infrastructure\Routing;

use App\Infrastructure\Routing\Request;

class Router {
    private array $routes = []; // Array para almacenar las rutas.
    
    /* 
     * addRoute: Agrega una nueva ruta al enrutador.
     * Recibe el método HTTP, la ruta y la acción a ejecutar (callable o array controlador-método).
     */
    function addRoute(string $method, string $path, callable|array $action) {
        $this->routes[$method][$path] = $action; // Guarda la acción en el array de rutas.
        return $this; // Permite encadenar múltiples llamadas a addRoute.
    }

    /*
     * dispatch: Procesa la solicitud y ejecuta la acción correspondiente.
     * Verifica si la ruta solicitada existe y, de ser así, llama a la función asociada.
     */
    function dispatch(Request $request) {
        $method = $request->getMethod();
        $path = $request->getPath();
    
        // Verificar rutas estáticas
        if (isset($this->routes[$method][$path])) {
            $this->executeAction($this->routes[$method][$path]);
            die; // Detiene el flujo después de ejecutar la acción
        }
    
        // Verificar rutas dinámicas
        foreach ($this->routes[$method] ?? [] as $route => $action) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
            if (preg_match("#^$pattern$#", $path, $matches)) {
                array_shift($matches); // Quitar el path completo
                $this->executeAction($action, $matches);
                return; // Detiene el flujo después de ejecutar la acción
            }
        }
    
        // Ruta no encontrada
        http_response_code(404);
        echo "Route not found";
        die; // Detiene el flujo si no se encuentra la ruta
    }
    
    
    
    
    private function executeAction($action, array $params = []) {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
        } elseif (is_array($action) && count($action) === 2) {
            [$controller, $method] = $action;
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                throw new \Exception("Método $method no encontrado en el controlador.");
            }
        } else {
            throw new \Exception("Acción no válida para la ruta.");
        }
    }
    
}
