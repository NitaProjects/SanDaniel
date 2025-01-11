<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($name); ?></title>
    <link rel="stylesheet" href="../../styles/home.css">
</head>

<body>
    <header class="header">
        <div class="overlay">
            <div class="container">
                <h1><?= htmlspecialchars($name); ?></h1>
                <p>Un gran poder conlleva una gran responsabilidad.</p>
                <a href="/login" class="login-button">Iniciar Sesión</a>
            </div>
        </div>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="#about">Sobre Nosotros</a></li>
            <li><a href="#courses">Cursos</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li><a href="/assign-teacher">Asignar Profesor a Departamento</a></li>
            <li><a href="/assign-student">Asignar Alumno a Curso</a></li>
        </ul>
    </nav>

    <main>
        <section id="about" class="about">
            <div class="container">
                <h2>Sobre Nosotros</h2>
                <p>En el <?= htmlspecialchars($name); ?>, ofrecemos una experiencia educativa de calidad con los mejores recursos y un enfoque en el éxito de nuestros estudiantes.</p>
            </div>
        </section>

        <section id="courses" class="courses">
            <div class="container">
                <h2>Nuestros Cursos</h2>
                <div class="course-list">
                    <!-- Iterar sobre los cursos -->
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="course">
                                <h3><?= htmlspecialchars($course->getName()); ?></h3>
                                <p>
                                    Titulación: <?= htmlspecialchars($course->getDegree() ? $course->getDegree()->getName() : 'No asignada'); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay cursos disponibles en este momento.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <footer id="contact" class="footer">
            <div class="container">
                <h2>Contacto</h2>
                <div class="contact-info">
                    <p>Email: contacto@<?= htmlspecialchars($name); ?>.com</p>
                    <p>Teléfono: +34 123 456 789</p>
                    <p>Dirección: Calle Ficticia 123, Ciudad Educativa</p>
                </div>
            </div>
        </footer>
    </main>
</body>

</html>