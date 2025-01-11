<?php

/**
 * Configuración inicial y enrutamiento de la aplicación.
 * Activa la visualización de errores, define la ruta de vistas,
 * carga las dependencias, y configura las rutas principales.
 */

ini_set('display_errors', 'On'); // Activa la visualización de errores en pantalla para depuración.
define('VIEWS', __DIR__ . '/src/views'); // Define una constante para la ruta de las vistas.

require __DIR__ . '/vendor/autoload.php'; // Carga automática de clases mediante Composer.

// Prueba de conexión a la base de datos
use App\Database\Database;

$database = new Database(); // Crea una instancia de la clase Database
$connection = $database->getConnection(); // Obtiene la conexión

// Importa las clases necesarias para el enrutamiento y controladores.
use App\Infrastructure\Routing\Router; 
use App\Controllers\HomeController;
use App\Controllers\AssignTeacherController;
use App\Controllers\AssignStudentController;
use App\Infrastructure\Routing\Request;

$router = new Router(); // Crea una instancia del enrutador.

$router->addRoute('GET', '/', [new HomeController(), 'index']) // Ruta principal (inicio).
        ->addRoute('GET', '/teachers', [new HomeController(), 'teachers']) // Ruta para "teachers".

        ->addRoute('GET', '/assign-teacher', [new AssignTeacherController(), 'assignTeacherPage']) // Página para asignar profesor a departamento
        ->addRoute('POST', '/assign-teacher', [new AssignTeacherController(), 'assignTeacherAction']) // Acción para guardar cambios en asignaciones

        ->addRoute('GET', '/assign-student', [new AssignStudentController(), 'assignStudentPage']) // Página para asignar alumno a curso
        ->addRoute('POST', '/assign-student', [new AssignStudentController(), 'assignStudentAction']); // Acción para guardar cambios en asignaciones


$router->dispatch(new Request()); // Procesa la solicitud y envía la respuesta correspondiente.
