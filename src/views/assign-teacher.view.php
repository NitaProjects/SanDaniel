<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Profesor a Departamento</title>
    <link rel="stylesheet" href="../../styles/department.css">
</head>

<body>
    <h1>Asignar Profesor a Departamento</h1>

    <!-- Tabla de profesores -->
    <h2>Lista de Profesores</h2>
    <table>
        <thead>
            <tr>
                <th>Profesor</th>
                <th>Departamentos Asignados</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $uniqueTeachers = [];
            foreach ($teachers as $teacher):
                if (in_array($teacher->getUserId(), $uniqueTeachers)) {
                    continue; // Evita duplicados
                }
                $uniqueTeachers[] = $teacher->getUserId();
            ?>
                <tr>
                    <td><?= htmlspecialchars($teacher->getFirstName() . ' ' . $teacher->getLastName()); ?></td>
                    <td>
                        <button class="toggle-btn" onclick="toggleDepartments('teacher-<?= $teacher->getId(); ?>')">Ver Departamentos</button>
                        <ul id="teacher-<?= $teacher->getId(); ?>" class="department-list" style="display: none;">
                            <?php foreach ($teachers as $t): ?>
                                <?php if ($t->getUserId() === $teacher->getUserId() && $t->getDepartment()): ?>
                                    <li>
                                        <?= htmlspecialchars($t->getDepartment()->getName()); ?>
                                        <form action="/delete-department" method="POST" class="inline-form" onsubmit="return deleteDepartment(event, this);">
                                            <input type="hidden" name="teacher_id" value="<?= $teacher->getUserId(); ?>">
                                            <input type="hidden" name="department_id" value="<?= $t->getDepartment()->getId(); ?>">
                                            <button type="submit" class="btn-delete">Eliminar</button>
                                        </form>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulario para asignar departamento -->
    <h3>Asignar Profesor a Departamento</h3>
    <form action="/assign-teacher" method="POST" class="form-assign">
        <label for="teacher">Profesor:</label>
        <select name="teacher_id" required>
            <?php
            $teacherIds = [];
            foreach ($teachers as $teacher):
                if (in_array($teacher->getUserId(), $teacherIds)) {
                    continue; // Evita duplicados
                }
                $teacherIds[] = $teacher->getUserId();
            ?>
                <option value="<?= $teacher->getUserId(); ?>">
                    <?= htmlspecialchars($teacher->getFirstName() . ' ' . $teacher->getLastName()); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="department">Departamento:</label>
        <select name="department_id" required>
            <?php foreach ($departments as $department): ?>
                <option value="<?= $department->getId(); ?>">
                    <?= htmlspecialchars($department->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-assign">Asignar</button>
    </form>

    <script>
        function toggleDepartments(id) {
            const element = document.getElementById(id);
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
        
    function deleteDepartment(event, form) {
        event.preventDefault(); // Evita que el formulario recargue la página

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('No se pudo eliminar el departamento');
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
                alert('El departamento fue eliminado con éxito.');
            } else {
                alert(data.message || 'Error al eliminar el departamento.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al procesar la solicitud.');
        });

        return false; // Previene el comportamiento normal del formulario
    }
    </script>
</body>

</html>