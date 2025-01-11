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
                <th>Acciones</th>
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
                        <button onclick="toggleDepartments('teacher-<?= $teacher->getId(); ?>')">Ver Departamentos</button>
                        <ul id="teacher-<?= $teacher->getId(); ?>" style="display: none;">
                            <?php foreach ($teachers as $t): ?>
                                <?php if ($t->getUserId() === $teacher->getUserId() && $t->getDepartment()): ?>
                                    <li><?= htmlspecialchars($t->getDepartment()->getName()); ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <form action="/delete-teacher" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $teacher->getId(); ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulario para asignar departamento -->
    <h3>Asignar Profesor a Departamento</h3>
    <form action="/assign-teacher" method="POST">
        <label for="teacher">Profesor:</label>
        <select name="teacher_id" required>
            <?php foreach ($teachers as $teacher): ?>
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

        <button type="submit">Asignar</button>
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
    </script>
</body>
</html>
