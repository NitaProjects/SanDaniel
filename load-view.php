<?php
$entity = $_GET['entity'] ?? null;

if ($entity) {
    $viewPath = __DIR__ . "/src/views/{$entity}.view.php";

    if (file_exists($viewPath)) {
        include $viewPath;
        exit;
    }
}

http_response_code(404);
echo "Vista no encontrada.";
