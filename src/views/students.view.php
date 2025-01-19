<h2>Gestión de Estudiantes</h2>
<button onclick="openAddStudentForm()">Añadir Estudiante</button>

<!-- Formulario para agregar estudiante -->
<div id="add-student-form" style="display: none;">
    <h3>Añadir Estudiante</h3>
    <form id="add-student-data-form">
        <input type="number" id="add-student-user-id" placeholder="ID del Usuario" required />
        <input type="text" id="add-student-dni" placeholder="DNI" required />
        <input type="number" id="add-student-enrollment-year" placeholder="Año de Inscripción" required />
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddStudentForm()">Cancelar</button>
    </form>
</div>

<!-- Formulario para editar estudiante -->
<div id="edit-student-form" style="display: none;">
    <h3>Editar Estudiante</h3>
    <form id="edit-student-data-form">
        <input type="hidden" id="edit-student-id" />
        <input type="text" id="edit-student-dni" placeholder="DNI" required />
        <input type="number" id="edit-student-enrollment-year" placeholder="Año de Inscripción" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="closeEditStudentForm()">Cancelar</button>
    </form>
</div>

<!-- Tabla de estudiantes -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario ID</th>
            <th>DNI</th>
            <th>Año de Inscripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="student-table-body">
        <!-- Se llenará dinámicamente con JavaScript -->
    </tbody>
</table>