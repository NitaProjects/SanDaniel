<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$name;?></title>
    <link rel="stylesheet" href="../../styles/home.css">
</head>
<body>
    <header class="header">
        <div class="overlay">
            <div class="container">
                <h1>Bienvenido al <?=$name;?></h1>
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
        </ul>
    </nav>
    
    <main>
        <section id="about" class="about">
            <div class="container">
                <h2>Sobre Nosotros</h2>
                <p>En el <?=$name;?>, ofrecemos una experiencia educativa de calidad con los mejores recursos y un enfoque en el éxito de nuestros estudiantes.</p>
            </div>
        </section>
        
        <section id="courses" class="courses">
            <div class="container">
                <h2>Nuestros Cursos</h2>
                <div class="course-list">
                    <div class="course">
                        <h3>Desarrollo de Software</h3>
                        <p>Aprende a programar y construir aplicaciones modernas.</p>
                    </div>
                    <div class="course">
                        <h3>Matemáticas Avanzadas</h3>
                        <p>Descubre los secretos del cálculo y el álgebra.</p>
                    </div>
                    <div class="course">
                        <h3>Historia Moderna</h3>
                        <p>Explora los eventos que moldearon el mundo actual.</p>
                    </div>
                    <div class="course">
                        <h3>Física Cuántica</h3>
                        <p>Adéntrate en el fascinante mundo de las partículas.</p>
                    </div>
                    <div class="course">
                        <h3>Psicología Aplicada</h3>
                        <p>Entiende cómo funciona la mente humana.</p>
                    </div>
                    <div class="course">
                        <h3>Historia Moderna</h3>
                        <p>Explora los eventos que moldearon el mundo actual.</p>
                    </div>
                    <div class="course">
                        <h3>Física Cuántica</h3>
                        <p>Adéntrate en el fascinante mundo de las partículas.</p>
                    </div>
                    <div class="course">
                        <h3>Psicología Aplicada</h3>
                        <p>Entiende cómo funciona la mente humana.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <footer id="contact" class="footer">
            <div class="container">
                <h2>Contacto</h2>
                <div class="contact-info">
                    <p>Email: contacto@<?=$name;?>.com</p>
                    <p>Teléfono: +34 123 456 789</p>
                    <p>Dirección: Calle Ficticia 123, Ciudad Educativa</p>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
