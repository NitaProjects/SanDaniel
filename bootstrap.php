<?php

/**
 * Configuración inicial y carga de servicios
 */

ini_set('display_errors', 'On'); // Habilita la visualización de errores para depuración
define('VIEWS', __DIR__ . '/src/views'); // Define la ruta base de vistas

require __DIR__ . '/vendor/autoload.php'; // Carga automática de dependencias con Composer

use App\Database\Database;
use App\Infrastructure\Routing\Router;
use App\Controllers\HomeController;
use App\Controllers\AssignTeacherController;
use App\Controllers\AssignStudentController;

// Conexión a la base de datos
$database = new Database();
$connection = $database->getConnection();

// Configuración del enrutador
$router = new Router();

$router->addRoute('GET', '/', [new HomeController(), 'index'])
       ->addRoute('GET', '/teachers', [new HomeController(), 'teachers'])
       ->addRoute('GET', '/assign-teacher', [new AssignTeacherController(), 'assignTeacherPage'])
       ->addRoute('POST', '/assign-teacher', [new AssignTeacherController(), 'assignTeacherAction'])
       ->addRoute('POST', '/delete-department', [new AssignTeacherController(), 'deleteDepartmentAction'])
       ->addRoute('GET', '/assign-student', [new AssignStudentController(), 'assignStudentPage'])
       ->addRoute('POST', '/assign-student', [new AssignStudentController(), 'assignStudentAction'])
       ->addRoute('POST', '/delete-enrollment', [new AssignStudentController(), 'deleteEnrollmentAction']);
