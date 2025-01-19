<?php

/**
 * Configuración inicial y carga de servicios
 */

// Configuración de errores y constantes globales
ini_set('display_errors', 'On');
define('VIEWS', __DIR__ . '/src/views');

// Autoload de dependencias
require __DIR__ . '/vendor/autoload.php';

// Dependencias principales
use App\Database\Database;
use App\Infrastructure\Routing\Router;
use App\Infrastructure\Routing\Request;
use App\Controllers\HomeController;

// Conexión a la base de datos
$database = new Database();
$connection = $database->getConnection();

// Configuración del enrutador
$router = new Router();

// =====================
// 1. Rutas de Inicio
// =====================
$homeController = new HomeController();
$router->addRoute('GET', '/', [$homeController, 'index']);
$router->addRoute('GET', '/management', [$homeController, 'management']);

// =====================
// 2. Rutas de Usuarios
// =====================
use App\School\Repositories\Implementations\UserRepository;
use App\School\Services\UserService;
use App\Controllers\UserController;

$userRepository = new UserRepository($connection);
$userService = new UserService($userRepository);
$userController = new UserController($userService);

// Operaciones CRUD básicas
$router->addRoute('POST', '/users', [$userController, 'addUser']); 
$router->addRoute('PUT', '/users/{id}', [$userController, 'updateUser']); 
$router->addRoute('GET', '/users/{id}', [$userController, 'getUserById']); 
$router->addRoute('DELETE', '/users/{id}', [$userController, 'deleteUser']); 
$router->addRoute('GET', '/users', [$userController, 'getAllUsers']);



// =====================
// 3. Rutas de Profesores
// =====================
use App\School\Repositories\Implementations\TeacherRepository;
use App\School\Services\TeacherService;
use App\Controllers\TeacherController;

$teacherRepository = new TeacherRepository($connection);
$teacherService = new TeacherService($teacherRepository);
$teacherController = new TeacherController($teacherService);

// Gestión básica de profesores
$router->addRoute('POST', '/teachers', [$teacherController, 'addTeacher']); // Cambiado a addTeacher
$router->addRoute('GET', '/teachers', [$teacherController, 'getAllTeachers']);
$router->addRoute('GET', '/teachers/{id}', [$teacherController, 'getTeacherById']);
$router->addRoute('PUT', '/teachers/{id}', [$teacherController, 'updateTeacher']); // Ruta para actualizar un profesor
$router->addRoute('DELETE', '/teachers/{id}', [$teacherController, 'deleteTeacher']);

// Gestión de departamentos asignados a profesores
$router->addRoute('GET', '/teachers/{id}/departments', [$teacherController, 'getDepartmentsForTeacher']);
$router->addRoute('POST', '/teachers/{id}/departments', [$teacherController, 'assignDepartmentToTeacher']);
$router->addRoute('DELETE', '/teachers/{id}/departments/{department_id}', [$teacherController, 'removeDepartmentFromTeacher']);


// =====================
// 4. Rutas de Estudiantes
// =====================
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Services\StudentService;
use App\Controllers\StudentController;

$studentRepository = new StudentRepository($connection);
$studentService = new StudentService($studentRepository);
$studentController = new StudentController($studentService);

$router->addRoute('POST', '/students', [$studentController, 'addStudent']); // Cambio aquí
$router->addRoute('GET', '/students', [$studentController, 'getAllStudents']);
$router->addRoute('GET', '/students/{id}', [$studentController, 'getStudentById']);
$router->addRoute('DELETE', '/students/{id}', [$studentController, 'deleteStudent']);


// =====================
// 5. Rutas de Asignaturas
// =====================
use App\School\Repositories\Implementations\SubjectRepository;
use App\School\Services\SubjectService;
use App\Controllers\SubjectController;

$subjectRepository = new SubjectRepository($connection);
$subjectService = new SubjectService($subjectRepository);
$subjectController = new SubjectController($subjectService);

// CRUD básico para asignaturas
$router->addRoute('POST', '/subjects', [$subjectController, 'createSubject']);
$router->addRoute('GET', '/subjects', [$subjectController, 'getAllSubjects']);
$router->addRoute('GET', '/subjects/{id}', [$subjectController, 'getSubjectById']);
$router->addRoute('PUT', '/subjects/{id}', [$subjectController, 'updateSubject']); 
$router->addRoute('DELETE', '/subjects/{id}', [$subjectController, 'deleteSubject']);


// =====================
// 6. Rutas de Cursos
// =====================
use App\School\Repositories\Implementations\CourseRepository;
use App\School\Services\CourseService;
use App\Controllers\CourseController;

$courseRepository = new CourseRepository($connection);
$courseService = new CourseService($courseRepository);
$courseController = new CourseController($courseService);

$router->addRoute('POST', '/courses', [$courseController, 'addCourse']); 
$router->addRoute('GET', '/courses', [$courseController, 'getAllCourses']);
$router->addRoute('GET', '/courses/{id}', [$courseController, 'getCourseById']);
$router->addRoute('DELETE', '/courses/{id}', [$courseController, 'deleteCourse']);


// =====================
// 7. Rutas de Titulaciones
// =====================
use App\School\Repositories\Implementations\DegreeRepository;
use App\School\Services\DegreeService;
use App\Controllers\DegreeController;

$degreeRepository = new DegreeRepository($connection);
$degreeService = new DegreeService($degreeRepository);
$degreeController = new DegreeController($degreeService);

$router->addRoute('POST', '/degrees', [$degreeController, 'addDegree']);
$router->addRoute('GET', '/degrees', [$degreeController, 'getAllDegrees']);
$router->addRoute('GET', '/degrees/{id}', [$degreeController, 'getDegreeById']);
$router->addRoute('DELETE', '/degrees/{id}', [$degreeController, 'deleteDegree']);


// =====================
// 8. Rutas de Departamentos
// =====================
use App\School\Repositories\Implementations\DepartmentRepository;
use App\School\Services\DepartmentService;
use App\Controllers\DepartmentController;

// Inicialización del repositorio, servicio y controlador
$departmentRepository = new DepartmentRepository($connection);
$departmentService = new DepartmentService($departmentRepository);
$departmentController = new DepartmentController($departmentService);

// Rutas
$router->addRoute('POST', '/departments', [$departmentController, 'createDepartment']); 
$router->addRoute('GET', '/departments', [$departmentController, 'getAllDepartments']); 
$router->addRoute('GET', '/departments/{id}', [$departmentController, 'getDepartmentById']); 
$router->addRoute('DELETE', '/departments/{id}', [$departmentController, 'deleteDepartment']); 


// =====================
// 9. Rutas de Exámenes
// =====================
use App\School\Repositories\Implementations\ExamRepository;
use App\School\Services\ExamService;
use App\Controllers\ExamController;

// Instanciar el repositorio, servicio y controlador de exámenes
$examRepository = new ExamRepository($connection);
$examService = new ExamService($examRepository);
$examController = new ExamController($examService);

// Rutas de gestión de exámenes
$router->addRoute('POST', '/exams', [$examController, 'addExam']); // Crear un nuevo examen
$router->addRoute('GET', '/exams', [$examController, 'getAllExams']); // Obtener todos los exámenes
$router->addRoute('GET', '/exams/{id}', [$examController, 'getExamById']); // Obtener un examen por ID
$router->addRoute('PUT', '/exams/{id}', [$examController, 'updateExam']); // Actualizar un examen existente
$router->addRoute('DELETE', '/exams/{id}', [$examController, 'deleteExam']); // Eliminar un examen


// =====================
// 10. Rutas de Matrículas
// =====================
use App\School\Repositories\Implementations\EnrollmentRepository;
use App\School\Services\EnrollmentService;
use App\Controllers\EnrollmentController;

$enrollmentRepository = new EnrollmentRepository($connection);
$enrollmentService = new EnrollmentService($enrollmentRepository);
$enrollmentController = new EnrollmentController($enrollmentService);

$router->addRoute('POST', '/enrollments', [$enrollmentController, 'add']); 
$router->addRoute('GET', '/enrollments', [$enrollmentController, 'getAll']);
$router->addRoute('GET', '/enrollments/{id}', [$enrollmentController, 'getById']);
$router->addRoute('PUT', '/enrollments/{id}', [$enrollmentController, 'update']);
$router->addRoute('DELETE', '/enrollments/{id}', [$enrollmentController, 'delete']);


// =====================
// Procesar la solicitud HTTP
// =====================
$request = new Request();
$router->dispatch($request);
