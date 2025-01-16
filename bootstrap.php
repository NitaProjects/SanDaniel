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

$router->addRoute('POST', '/users', [$userController, 'createUser']);
$router->addRoute('GET', '/users', [$userController, 'getAllUsers']);
$router->addRoute('GET', '/users/search', [$userController, 'searchUsers']);
$router->addRoute('GET', '/users/{id}', [$userController, 'getUserById']);
$router->addRoute('DELETE', '/users/{id}', [$userController, 'deleteUser']);

// =====================
// 3. Rutas de Profesores
// =====================
use App\School\Repositories\Implementations\TeacherRepository;
use App\School\Services\TeacherService;
use App\Controllers\TeacherController;

$teacherRepository = new TeacherRepository($connection);
$teacherService = new TeacherService($teacherRepository);
$teacherController = new TeacherController($teacherService);

$router->addRoute('POST', '/teachers', [$teacherController, 'createTeacher']);
$router->addRoute('GET', '/teachers', [$teacherController, 'getAllTeachers']);
$router->addRoute('GET', '/teachers/{id}', [$teacherController, 'getTeacherById']);
$router->addRoute('GET', '/teachers/user/{user_id}', [$teacherController, 'getTeacherByUserId']);
$router->addRoute('DELETE', '/teachers/{id}', [$teacherController, 'deleteTeacher']);

// =====================
// 4. Rutas de Estudiantes
// =====================
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Services\StudentService;
use App\Controllers\StudentController;

$studentRepository = new StudentRepository($connection);
$studentService = new StudentService($studentRepository);
$studentController = new StudentController($studentService);

$router->addRoute('POST', '/students', [$studentController, 'createStudent']);
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

$router->addRoute('POST', '/subjects', [$subjectController, 'createSubject']);
$router->addRoute('GET', '/subjects', [$subjectController, 'getAllSubjects']);
$router->addRoute('GET', '/subjects/{id}', [$subjectController, 'getSubjectById']);
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

$router->addRoute('POST', '/courses', [$courseController, 'createCourse']);
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

$router->addRoute('POST', '/degrees', [$degreeController, 'createDegree']);
$router->addRoute('GET', '/degrees', [$degreeController, 'getAllDegrees']);
$router->addRoute('GET', '/degrees/{id}', [$degreeController, 'getDegreeById']);
$router->addRoute('DELETE', '/degrees/{id}', [$degreeController, 'deleteDegree']);

// =====================
// 8. Rutas de Departamentos
// =====================
use App\School\Repositories\Implementations\DepartmentRepository;
use App\School\Services\DepartmentService;
use App\Controllers\DepartmentController;

$departmentRepository = new DepartmentRepository($connection);
$departmentService = new DepartmentService($departmentRepository);
$departmentController = new DepartmentController($departmentService);

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

$examRepository = new ExamRepository($connection);
$examService = new ExamService($examRepository);
$examController = new ExamController($examService);

$router->addRoute('POST', '/exams', [$examController, 'createExam']);
$router->addRoute('GET', '/exams', [$examController, 'getAllExams']);
$router->addRoute('GET', '/exams/{id}', [$examController, 'getExamById']);
$router->addRoute('PUT', '/exams/{id}', [$examController, 'updateExam']);
$router->addRoute('DELETE', '/exams/{id}', [$examController, 'deleteExam']);

// =====================
// 10. Rutas de Matrículas
// =====================
use App\School\Repositories\Implementations\EnrollmentRepository;
use App\School\Services\EnrollmentService;
use App\Controllers\EnrollmentController;

$enrollmentRepository = new EnrollmentRepository($connection);
$enrollmentService = new EnrollmentService($enrollmentRepository);
$enrollmentController = new EnrollmentController($enrollmentService);

$router->addRoute('POST', '/enrollments', [$enrollmentController, 'createEnrollment']);
$router->addRoute('GET', '/enrollments', [$enrollmentController, 'getAllEnrollments']);
$router->addRoute('GET', '/enrollments/{id}', [$enrollmentController, 'getEnrollmentById']);
$router->addRoute('PUT', '/enrollments/{id}', [$enrollmentController, 'updateEnrollment']);
$router->addRoute('DELETE', '/enrollments/{id}', [$enrollmentController, 'deleteEnrollment']);

// =====================
// Procesar la solicitud HTTP
// =====================
$request = new Request();
$router->dispatch($request);
