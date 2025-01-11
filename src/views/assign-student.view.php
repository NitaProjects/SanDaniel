<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Alumno a Curso</title>
</head>

<body>
    <h1>Asignar Alumno a Curso</h1>
    <table>
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student->getFirstName() . ' ' . $student->getLastName()); ?></td>
                    <td>
                        <?php if (count($student->getCourses()) > 0): ?>
                            <?php foreach ($student->getCourses() as $course): ?>
                                <?= htmlspecialchars($course->getName()); ?><br>
                            <?php endforeach; ?>
                        <?php else: ?>
                            Sin asignar
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="/edit-student?id=<?= $student->getId(); ?>">Editar</a>
                        <form action="/delete-student" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $student->getId(); ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <form action="/assign-student" method="POST">
        <h3>Asignar Alumno</h3>
        <label for="student">Alumno:</label>
        <select name="student_id" required>
            <?php foreach ($studentsWithoutCourse as $student): ?>
                <option value="<?= $student->getId(); ?>"><?= htmlspecialchars($student->getFirstName() . ' ' . $student->getLastName()); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="course">Curso:</label>
        <select name="course_id" required>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course->getId(); ?>"><?= htmlspecialchars($course->getName()); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Asignar</button>
    </form>
</body>

</html>