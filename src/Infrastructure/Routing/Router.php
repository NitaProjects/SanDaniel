<?php 

    /**
     * Clase Router para gestionar y despachar rutas en la aplicación.
     * Permite definir rutas y ejecutar las acciones correspondientes
     * basadas en las solicitudes del usuario.
     */
    
    namespace App\Infrastructure\Routing;

    use App\Infrastructure\Routing\Request;

    class Router {
        private array $routes = []; // Array para almacenar las rutas.

        /* 
         * addRoute: Agrega una nueva ruta al enrutador.
         * Recibe el método HTTP, la ruta y la acción a ejecutar.
         */
        function addRoute(string $method, string $path, callable $action) {
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
                call_user_func($this->routes[$method][$path]); // Ejecuta la acción asociada a la ruta.
            } else {
                http_response_code(404); // Envía un código de respuesta 404.
                echo "Route not found"; // Muestra un mensaje de error.
            }
        }
    }
