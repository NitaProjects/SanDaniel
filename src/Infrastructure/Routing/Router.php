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
        $method = $request->getMethod(); // Obtiene el método HTTP de la solicitud.
        $path = $request->getPath(); // Obtiene el path solicitado.
        
        // Verifica si la ruta existe en el array de rutas.
        if (isset($this->routes[$method][$path])) {
            $action = $this->routes[$method][$path];
            
            if (is_callable($action)) {
                call_user_func($action); // Ejecuta la función callable.
            } elseif (is_array($action) && count($action) === 2) {
                [$controller, $method] = $action;
                if (method_exists($controller, $method)) {
                    call_user_func([$controller, $method]); // Llama al método del controlador.
                } else {
                    throw new \Exception("Método $method no encontrado en el controlador.");
                }
            } else {
                throw new \Exception("Acción no válida para la ruta.");
            }
        } else {
            http_response_code(404); // Envía un código de respuesta 404.
            echo "Route not found"; // Muestra un mensaje de error.
        }
    }
}
