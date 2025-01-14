<?php

require __DIR__ . '/bootstrap.php'; // Carga la configuración inicial

use App\Infrastructure\Routing\Request;

// Procesa la solicitud y despacha las rutas
$router->dispatch(new Request());
