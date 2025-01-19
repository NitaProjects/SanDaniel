<?php

namespace App\Infrastructure\Routing;

class Request {
    private string $method; // Método HTTP de la solicitud (GET, POST, etc.).
    private string $path;   // Ruta solicitada.

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD']; 
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function setMethod(string $method): self {
        $this->method = $method;
        return $this;
    } 

    public function getPath(): string {
        return $this->path;
    }

    public function setPath(string $path): self {
        $this->path = $path;
        return $this;
    }

    // **Nuevo método:** Obtener parámetros de consulta (GET).
    public function getQueryParams(): array {
        return $_GET ?? [];
    }

    // **Nuevo método:** Obtener parámetros de cuerpo (POST o PUT).
    public function getBody(): array {
        $input = file_get_contents('php://input');
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (str_contains($contentType, 'application/json')) {
            return json_decode($input, true) ?? [];
        }

        return $_POST ?? [];
    }
}
