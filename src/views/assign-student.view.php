<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Estudiante a Asignatura</title>
    <link rel="stylesheet" href="../../styles/department.css">
</head>

<body>
    <h1>Asignar Estudiante a Asignatura</h1>

    <!-- Tabla de estudiantes -->
    <h2>Lista de Estudiantes</h2>
    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Asignaturas Inscritas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student->getFirstName() . ' ' . $student->getLastName()); ?></td>
                    <td>
                        <button class="toggle-btn" onclick="toggleSubjects('student-<?= $student->getId(); ?>')">Ver Asignaturas</button>
                        <ul id="student-<?= $student->getId(); ?>" class="subject-list" style="display: none;">
                            <?php foreach ($student->getSubjects() as $subject): ?>
                                <li>
                                    <?= htmlspecialchars($subject->getName()); ?>
                                    <form action="/delete-enrollment" method="POST" class="inline-form" onsubmit="return deleteEnrollment(event, this);">
                                        <input type="hidden" name="student_id" value="<?= $student->getUserId(); ?>">
                                        <input type="hidden" name="subject_id" value="<?= $subject->getId(); ?>">
                                        <button type="submit" class="btn-delete">Eliminar</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <!-- Formulario para asignar asignaturas -->
    <h3>Asignar Estudiante a Asignatura</h3>
    <form action="/assign-student" method="POST" class="form-assign">
        <label for="student">Estudiante:</label>
        <select name="student_id" required>
            <?php foreach ($students as $student): ?>
                <option value="<?= $student->getId(); ?>">
                    <?= htmlspecialchars($student->getFirstName() . ' ' . $student->getLastName()); ?>
                </option>
            <?php endforeach; ?>
        </select>


        <label for="subject">Asignatura:</label>
        <select name="subject_id" required>
            <?php foreach ($subjects as $subject): ?>
                <option value="<?= $subject->getId(); ?>">
                    <?= htmlspecialchars($subject->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-assign">Asignar</button>
    </form>

    <script>
        function toggleSubjects(id) {
            const element = document.getElementById(id);
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }

        function deleteEnrollment(event, form) {
            event.preventDefault(); // Evita que el formulario recargue la página

            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('No se pudo eliminar la inscripción');
                    }
                    return response.json(); // Asume que el backend devuelve una respuesta JSON
                })
                .then(data => {
                    if (data.success) {
                        // Elimina el elemento visualmente
                        const listItem = form.closest('li');
                        if (listItem) {
                            listItem.remove();
                        }
                        alert('La inscripción fue eliminada con éxito.');
                    } else {
                        alert(data.message || 'Error al eliminar la inscripción.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un problema al procesar la solicitud.');
                });

            return false;
        }
    </script>
</body>

</html>