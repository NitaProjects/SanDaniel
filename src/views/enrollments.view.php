<h2>Gestión de Matrículas</h2>
<button onclick="openAddEnrollmentForm()">Añadir Matrícula</button>

<!-- Formulario para agregar matrícula -->
<div id="add-enrollment-form" style="display: none;">
    <form id="add-enrollment-data-form">
        <input type="number" id="add-student-id" placeholder="ID del Estudiante" required />
        <input type="number" id="add-subject-id" placeholder="ID de la Asignatura" required />
        <input type="date" id="add-enrollment-date" required />
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddEnrollmentForm()">Cancelar</button>
    </form>
</div>

<!-- Formulario para editar matrícula -->
<div id="edit-enrollment-form" style="display: none;">
    <form id="edit-enrollment-data-form">
        <input type="hidden" id="edit-enrollment-id" />
        <input type="number" id="edit-student-id" placeholder="ID del Estudiante" required />
        <input type="number" id="edit-subject-id" placeholder="ID de la Asignatura" required />
        <input type="date" id="edit-enrollment-date" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="closeEditEnrollmentForm()">Cancelar</button>
    </form>
</div>

<!-- Tabla para listar matrículas -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Estudiante</th>
            <th>Asignatura</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="enrollment-table-body">
        <!-- Se llenará dinámicamente con JavaScript -->
    </tbody>
</table>
