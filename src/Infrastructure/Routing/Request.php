<?php

    /**
     * Clase Request para gestionar la solicitud HTTP del usuario.
     * Extrae, proporciona y permite modificar el método HTTP y la ruta solicitada.
     */

    namespace App\Infrastructure\Routing;

    class Request {
        private string $method; // Almacena el método HTTP de la solicitud (GET, POST, etc.).
        private string $path; // Almacena la ruta solicitada.

        /* 
         * Constructor: Inicializa la solicitud obteniendo el método y la ruta.
         */
        function __construct() {
            $this->method = $_SERVER['REQUEST_METHOD']; // Obtiene el método HTTP.
            $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Obtiene la ruta sin parámetros.
        }
         
        /*
         * getMethod: Retorna el método HTTP de la solicitud.
         */
        public function getMethod() {
            return $this->method;
        }

        /*
         * setMethod: Permite establecer manualmente el método HTTP.
         */
        public function setMethod($method) {
            $this->method = $method; // Establece un nuevo método HTTP.
            return $this; // Devuelve la instancia para permitir encadenamiento.
        }

        /*
         * getPath: Retorna la ruta solicitada.
         */
        public function getPath() {
            return $this->path;
        }

        /*
         * setPath: Permite establecer manualmente la ruta solicitada.
         */
        public function setPath($path) {
            $this->path = $path; // Establece una nueva ruta.
            return $this; // Devuelve la instancia para permitir encadenamiento.
        }
    }
