<?php

/**
 * Configuración inicial y carga de servicios
 */

ini_set('display_errors', 'On'); // Habilita la visualización de errores para depuración
define('VIEWS', __DIR__ . '/src/views'); // Define la ruta base de vistas

require __DIR__ . '/vendor/autoload.php'; // Carga automática de dependencias con Composer

use App\Database\Database;
use App\Infrastructure\Routing\Router;
use App\Infrastructure\Routing\Request;

use App\School\Repositories\Implementations\UserRepository;
use App\School\Services\UserService;
use App\Controllers\UserController;

use App\School\Repositories\Implementations\TeacherRepository;
use App\School\Services\TeacherService;
use App\Controllers\TeacherController;

use App\School\Repositories\Implementations\SubjectRepository;
use App\School\Services\SubjectService;
use App\Controllers\SubjectController;

use App\School\Repositories\Implementations\StudentRepository;
use App\School\Services\StudentService;
use App\Controllers\StudentController;

use App\School\Repositories\Implementations\ExamRepository;
use App\School\Services\ExamService;
use App\Controllers\ExamController;

use App\School\Repositories\Implementations\CourseRepository;
use App\School\Services\CourseService;
use App\Controllers\CourseController;

use App\School\Repositories\Implementations\DegreeRepository;
use App\School\Services\DegreeService;
use App\Controllers\DegreeController;

use App\School\Repositories\Implementations\DepartmentRepository;
use App\School\Services\DepartmentService;
use App\Controllers\DepartmentController;

use App\School\Repositories\Implementations\EnrollmentRepository;
use App\School\Services\EnrollmentService;
use App\Controllers\EnrollmentController;



// Conexión a la base de datos
$database = new Database();
$connection = $database->getConnection();

// Configuración del enrutador
$router = new Router();

// Instancia de repositorio, servicio y controlador para usuarios
$userRepository = new UserRepository($connection);
$userService = new UserService($userRepository);
$userController = new UserController($userService);

$teacherRepository = new TeacherRepository($connection);
$teacherService = new TeacherService($teacherRepository);
$teacherController = new TeacherController($teacherService);

// Añadir rutas del controlador de usuarios
$router->addRoute('POST', '/users', [new UserController($userService), 'createUser']);
$router->addRoute('GET', '/users', [new UserController($userService), 'getAllUsers']);
$router->addRoute('GET', '/users/search', [new UserController($userService), 'searchUsers']);
$router->addRoute('GET', '/users/{id}', [new UserController($userService), 'getUserById']);
$router->addRoute('DELETE', '/users/{id}', [new UserController($userService), 'deleteUser']);

$router->addRoute('POST', '/teachers', [new TeacherController($teacherService), 'createTeacher']);
$router->addRoute('GET', '/teachers', [new TeacherController($teacherService), 'getAllTeachers']);
$router->addRoute('GET', '/teachers/{id}', [new TeacherController($teacherService), 'getTeacherById']);
$router->addRoute('GET', '/teachers/user/{user_id}', [new TeacherController($teacherService), 'getTeacherByUserId']);
$router->addRoute('DELETE', '/teachers/{id}', [new TeacherController($teacherService), 'deleteTeacher']);

$router->addRoute('POST', '/subjects', [new SubjectController($subjectService), 'createSubject']);
$router->addRoute('GET', '/subjects', [new SubjectController($subjectService), 'getAllSubjects']);
$router->addRoute('GET', '/subjects/{id}', [new SubjectController($subjectService), 'getSubjectById']);
$router->addRoute('DELETE', '/subjects/{id}', [new SubjectController($subjectService), 'deleteSubject']);

$router->addRoute('POST', '/students', [new StudentController($studentService), 'createStudent']);
$router->addRoute('GET', '/students', [new StudentController($studentService), 'getAllStudents']);
$router->addRoute('GET', '/students/{id}', [new StudentController($studentService), 'getStudentById']);
$router->addRoute('DELETE', '/students/{id}', [new StudentController($studentService), 'deleteStudent']);

$router->addRoute('POST', '/exams', [new ExamController($examService), 'createExam']);
$router->addRoute('GET', '/exams', [new ExamController($examService), 'getAllExams']);
$router->addRoute('GET', '/exams/{id}', [new ExamController($examService), 'getExamById']);
$router->addRoute('PUT', '/exams/{id}', [new ExamController($examService), 'updateExam']);
$router->addRoute('DELETE', '/exams/{id}', [new ExamController($examService), 'deleteExam']);

$router->addRoute('POST', '/enrollments', [new EnrollmentController($enrollmentService), 'createEnrollment']);
$router->addRoute('GET', '/enrollments', [new EnrollmentController($enrollmentService), 'getAllEnrollments']);
$router->addRoute('GET', '/enrollments/{id}', [new EnrollmentController($enrollmentService), 'getEnrollmentById']);
$router->addRoute('PUT', '/enrollments/{id}', [new EnrollmentController($enrollmentService), 'updateEnrollment']);
$router->addRoute('DELETE', '/enrollments/{id}', [new EnrollmentController($enrollmentService), 'deleteEnrollment']);

$router->addRoute('POST', '/departments', [new DepartmentController($departmentService), 'createDepartment']);
$router->addRoute('GET', '/departments', [new DepartmentController($departmentService), 'getAllDepartments']);
$router->addRoute('GET', '/departments/{id}', [new DepartmentController($departmentService), 'getDepartmentById']);
$router->addRoute('DELETE', '/departments/{id}', [new DepartmentController($departmentService), 'deleteDepartment']);

$router->addRoute('POST', '/degrees', [new DegreeController($degreeService), 'createDegree']);
$router->addRoute('GET', '/degrees', [new DegreeController($degreeService), 'getAllDegrees']);
$router->addRoute('GET', '/degrees/{id}', [new DegreeController($degreeService), 'getDegreeById']);
$router->addRoute('DELETE', '/degrees/{id}', [new DegreeController($degreeService), 'deleteDegree']);

$router->addRoute('POST', '/courses', [new CourseController($courseService), 'createCourse']);
$router->addRoute('GET', '/courses', [new CourseController($courseService), 'getAllCourses']);
$router->addRoute('GET', '/courses/{id}', [new CourseController($courseService), 'getCourseById']);
$router->addRoute('DELETE', '/courses/{id}', [new CourseController($courseService), 'deleteCourse']);







// Procesar la solicitud HTTP
$request = new Request();
$router->dispatch($request);
