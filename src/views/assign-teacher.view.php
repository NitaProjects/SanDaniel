<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Profesor a Departamento</title>
    <link rel="stylesheet" href="/styles/management.css">
</head>

<body>
    <header>
        <h1>Asignar Profesor a Departamento</h1>
        <nav>
            <ul>
                <li><a href="/">Volver a Inicio</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Tabla de asignaciones existentes -->
        <section>
            <h2>Asignaciones Existentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Profesor</th>
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="assignments-table-body">
                    <tr id="no-assignments-message">
                        <td colspan="3">No hay asignaciones registradas.</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Formulario para asignar un profesor a un departamento -->
        <section>
            <h2>Asignar Nuevo Profesor</h2>
            <form id="assign-teacher-form">
                <label for="teacher">Profesor:</label>
                <select id="teacher" name="teacher_id" required>
                    <option value="" disabled selected>Selecciona un Profesor</option>
                    <!-- Opciones dinámicas -->
                </select>

                <label for="department">Departamento:</label>
                <select id="department" name="department_id" required>
                    <option value="" disabled selected>Selecciona un Departamento</option>
                    <!-- Opciones dinámicas -->
                </select>

                <button type="submit">Asignar</button>
            </form>
        </section>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="../../scripts/assign-teacher.js"></script>
</body>

</html>