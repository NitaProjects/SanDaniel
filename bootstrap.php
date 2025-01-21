<?php

/**
 * Configuración inicial y carga de servicios
 */

// =====================
// Configuración Global
// =====================
ini_set('display_errors', 'On');
define('VIEWS', __DIR__ . '/src/views');

// Autoload de dependencias
require __DIR__ . '/vendor/autoload.php';

// =====================
// Dependencias Principales
// =====================
use App\Database\Database;
use App\Infrastructure\Routing\Router;
use App\Infrastructure\Routing\Request;

// =====================
// Controladores
// =====================
use App\Controllers\HomeController;
use App\Controllers\AssignTeacherController;
use App\Controllers\UserController;
use App\Controllers\TeacherController;
use App\Controllers\StudentController;
use App\Controllers\SubjectController;
use App\Controllers\CourseController;
use App\Controllers\DegreeController;
use App\Controllers\DepartmentController;
use App\Controllers\ExamController;
use App\Controllers\EnrollmentController;

// =====================
// Servicios
// =====================
use App\School\Services\AssignTeacherToDepartmentService;
use App\School\Services\UserService;
use App\School\Services\TeacherService;
use App\School\Services\StudentService;
use App\School\Services\SubjectService;
use App\School\Services\CourseService;
use App\School\Services\DegreeService;
use App\School\Services\DepartmentService;
use App\School\Services\ExamService;
use App\School\Services\EnrollmentService;

// =====================
// Repositorios
// =====================
use App\School\Repositories\Implementations\UserRepository;
use App\School\Repositories\Implementations\TeacherRepository;
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Repositories\Implementations\SubjectRepository;
use App\School\Repositories\Implementations\CourseRepository;
use App\School\Repositories\Implementations\DegreeRepository;
use App\School\Repositories\Implementations\DepartmentRepository;
use App\School\Repositories\Implementations\ExamRepository;
use App\School\Repositories\Implementations\EnrollmentRepository;

// =====================
// Inicialización
// =====================

// Conexión a la base de datos
$database = new Database();
$connection = $database->getConnection();

// =====================
// Repositorios
// =====================
$teacherRepository = new TeacherRepository($connection);
$departmentRepository = new DepartmentRepository($connection);
$userRepository = new UserRepository($connection);
$studentRepository = new StudentRepository($connection);
$subjectRepository = new SubjectRepository($connection);
$courseRepository = new CourseRepository($connection);
$degreeRepository = new DegreeRepository($connection);
$examRepository = new ExamRepository($connection);
$enrollmentRepository = new EnrollmentRepository($connection);

// =====================
// Servicios
// =====================
$assignTeacherService = new AssignTeacherToDepartmentService($teacherRepository, $departmentRepository);
$userService = new UserService($userRepository);
$teacherService = new TeacherService($teacherRepository);
$studentService = new StudentService($studentRepository);
$subjectService = new SubjectService($subjectRepository);
$courseService = new CourseService($courseRepository);
$degreeService = new DegreeService($degreeRepository);
$departmentService = new DepartmentService($departmentRepository);
$examService = new ExamService($examRepository);
$enrollmentService = new EnrollmentService($enrollmentRepository);

// =====================
// Controladores
// =====================
$homeController = new HomeController();
$assignTeacherController = new AssignTeacherController($assignTeacherService);
$userController = new UserController($userService);
$teacherController = new TeacherController($teacherService);
$studentController = new StudentController($studentService);
$subjectController = new SubjectController($subjectService);
$courseController = new CourseController($courseService);
$degreeController = new DegreeController($degreeService);
$departmentController = new DepartmentController($departmentService);
$examController = new ExamController($examService);
$enrollmentController = new EnrollmentController($enrollmentService);

// =====================
// Configuración del Enrutador
// =====================
$router = new Router();

// Rutas de Inicio
$router->addRoute('GET', '/', [$homeController, 'index']);
$router->addRoute('GET', '/management', [$homeController, 'management']);
$router->addRoute('GET', '/assign-teacher', [$assignTeacherController, 'assignTeacherPage']);
$router->addRoute('GET', '/teacher-departments', [$assignTeacherController, 'getTeacherDepartments']); 
$router->addRoute('POST', '/teachers/departments', [$assignTeacherController, 'assignDepartmentToTeacher']);
$router->addRoute('DELETE', '/teachers/departments', [$assignTeacherController, 'removeDepartmentFromTeacher']);

// Rutas de Usuarios
$router->addRoute('POST', '/users', [$userController, 'addUser']);
$router->addRoute('PUT', '/users/{id}', [$userController, 'updateUser']);
$router->addRoute('GET', '/users/{id}', [$userController, 'getUserById']);
$router->addRoute('DELETE', '/users/{id}', [$userController, 'deleteUser']);
$router->addRoute('GET', '/users', [$userController, 'getAllUsers']);

// Rutas de Profesores
$router->addRoute('POST', '/teachers', [$teacherController, 'addTeacher']); 
$router->addRoute('GET', '/teachers', [$teacherController, 'getAllTeachers']); 
$router->addRoute('GET', '/teachers/{id}', [$teacherController, 'getTeacherById']); 
$router->addRoute('PUT', '/teachers/{id}', [$teacherController, 'updateTeacher']); 
$router->addRoute('DELETE', '/teachers/{id}', [$teacherController, 'deleteTeacher']); 


// Rutas de Estudiantes
$router->addRoute('POST', '/students', [$studentController, 'addStudent']);
$router->addRoute('GET', '/students', [$studentController, 'getAllStudents']);
$router->addRoute('GET', '/students/{id}', [$studentController, 'getStudentById']);
$router->addRoute('DELETE', '/students/{id}', [$studentController, 'deleteStudent']);

// Rutas de Asignaturas
$router->addRoute('POST', '/subjects', [$subjectController, 'addSubject']);
$router->addRoute('GET', '/subjects', [$subjectController, 'getAllSubjects']);
$router->addRoute('GET', '/subjects/{id}', [$subjectController, 'getSubjectById']);
$router->addRoute('PUT', '/subjects/{id}', [$subjectController, 'updateSubject']);
$router->addRoute('DELETE', '/subjects/{id}', [$subjectController, 'deleteSubject']);

// Rutas de Cursos
$router->addRoute('POST', '/courses', [$courseController, 'addCourse']);
$router->addRoute('GET', '/courses', [$courseController, 'getAllCourses']);
$router->addRoute('GET', '/courses/{id}', [$courseController, 'getCourseById']);
$router->addRoute('DELETE', '/courses/{id}', [$courseController, 'deleteCourse']);

// Rutas de Titulaciones
$router->addRoute('POST', '/degrees', [$degreeController, 'addDegree']);
$router->addRoute('GET', '/degrees', [$degreeController, 'getAllDegrees']);
$router->addRoute('GET', '/degrees/{id}', [$degreeController, 'getDegreeById']);
$router->addRoute('DELETE', '/degrees/{id}', [$degreeController, 'deleteDegree']);

// Rutas de Departamentos
$router->addRoute('POST', '/departments', [$departmentController, 'addDepartment']);
$router->addRoute('GET', '/departments', [$departmentController, 'getAllDepartments']);
$router->addRoute('GET', '/departments/{id}', [$departmentController, 'getDepartmentById']);
$router->addRoute('DELETE', '/departments/{id}', [$departmentController, 'deleteDepartment']);

// Rutas de Exámenes
$router->addRoute('POST', '/exams', [$examController, 'addExam']);
$router->addRoute('GET', '/exams', [$examController, 'getAllExams']);
$router->addRoute('GET', '/exams/{id}', [$examController, 'getExamById']);
$router->addRoute('PUT', '/exams/{id}', [$examController, 'updateExam']);
$router->addRoute('DELETE', '/exams/{id}', [$examController, 'deleteExam']);

// Rutas de Matrículas
$router->addRoute('POST', '/enrollments', [$enrollmentController, 'add']);
$router->addRoute('GET', '/enrollments', [$enrollmentController, 'getAll']);
$router->addRoute('GET', '/enrollments/{id}', [$enrollmentController, 'getById']);
$router->addRoute('PUT', '/enrollments/{id}', [$enrollmentController, 'update']);
$router->addRoute('DELETE', '/enrollments/{id}', [$enrollmentController, 'delete']);

// =====================
// Procesar la Solicitud HTTP
// =====================
$request = new Request();
$router->dispatch($request);
