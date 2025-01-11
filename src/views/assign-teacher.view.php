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
    <table>
        <thead>
            <tr>
                <th>Profesor</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teachers as $teacher): ?>
                <tr>
                    <td><?= htmlspecialchars($teacher->getFirstName() . ' ' . $teacher->getLastName()); ?></td>
                    <td><?= htmlspecialchars($teacher->getDepartment() ? $teacher->getDepartment()->getName() : 'Sin asignar'); ?></td>
                    <td>
                        <a href="/edit-teacher?id=<?= $teacher->getId(); ?>">Editar</a>
                        <form action="/delete-teacher" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $teacher->getId(); ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <form action="/assign-teacher" method="POST">
        <h3>Asignar Profesor</h3>
        <label for="teacher">Profesor:</label>
        <select name="teacher_id" required>
            <?php foreach ($teachersWithoutDepartment as $teacher): ?>
                <option value="<?= $teacher->getId(); ?>"><?= htmlspecialchars($teacher->getFirstName() . ' ' . $teacher->getLastName()); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="department">Departamento:</label>
        <select name="department_id" required>
            <?php foreach ($departments as $department): ?>
                <option value="<?= $department->getId(); ?>"><?= htmlspecialchars($department->getName()); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Asignar</button>
    </form>
</body>
</html>
