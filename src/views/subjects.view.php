<h2>Gestión de Asignaturas</h2>

<!-- Tabla para mostrar asignaturas -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Curso</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="subject-table-body">
        <!-- Se llenará dinámicamente con JavaScript -->
    </tbody>
</table>

<!-- Modal para añadir asignatura -->
<div id="add-subject-form" style="display: none;">
    <h3>Añadir Asignatura</h3>
    <form id="add-subject-data-form">
        <input type="text" id="add-subject-name" placeholder="Nombre de la Asignatura" required />
        <input type="number" id="add-subject-course-id" placeholder="ID del Curso" required />
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddSubjectForm()">Cancelar</button>
    </form>
</div>

<!-- Modal para editar asignatura -->
<div id="edit-subject-form" style="display: none;">
    <h3>Editar Asignatura</h3>
    <form id="edit-subject-data-form">
        <input type="hidden" id="edit-subject-id" />
        <input type="text" id="edit-subject-name" placeholder="Nombre de la Asignatura" required />
        <input type="number" id="edit-subject-course-id" placeholder="ID del Curso" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="closeEditSubjectForm()">Cancelar</button>
    </form>
</div>

<button onclick="openAddSubjectForm()">Añadir Asignatura</button>
