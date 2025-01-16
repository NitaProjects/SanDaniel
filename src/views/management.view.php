<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión</title>
    <link rel="stylesheet" href="../../styles/management.css">
</head>

<body>
    <header>
        <h1>Gestión de Entidades</h1>
        <nav>
            <ul>
                <li><a href="#" onclick="loadContent('users')">Usuarios</a></li>
                <li><a href="#" onclick="loadContent('students')">Estudiantes</a></li>
                <li><a href="#" onclick="loadContent('teachers')">Profesores</a></li>
                <li><a href="#" onclick="loadContent('subjects')">Asignaturas</a></li>
                <li><a href="#" onclick="loadContent('courses')">Cursos</a></li>
                <li><a href="#" onclick="loadContent('departments')">Departamentos</a></li>
                <li><a href="#" onclick="loadContent('degrees')">Titulaciones</a></li>
                <li><a href="#" onclick="loadContent('enrollments')">Matrículas</a></li>
                <li><a href="#" onclick="loadContent('exams')">Exámenes</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Contenedor para el contenido dinámico -->
        <section id="dynamic-content" class="dynamic-content">
            <h2>Selecciona una entidad para gestionar</h2>
        </section>
    </main>

    <!-- Scripts globales -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="../../scripts/management.js"></script>

    <!-- Scripts específicos para cada entidad -->
    <script src="../../scripts/users.js"></script>
    <script src="../../scripts/students.js"></script>
    <script src="../../scripts/teachers.js"></script>
    <script src="../../scripts/subjects.js"></script>
    <script src="../../scripts/courses.js"></script>
    <script src="../../scripts/departments.js"></script>
    <script src="../../scripts/degrees.js"></script>
    <script src="../../scripts/enrollments.js"></script>
    <script src="../../scripts/exams.js"></script>
</body>

</html>
