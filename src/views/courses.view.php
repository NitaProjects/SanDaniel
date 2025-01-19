<h2>Gestión de Cursos</h2>
<button onclick="openAddCourseForm()">Añadir Curso</button>

<!-- Formulario para agregar curso -->
<div id="course-form" style="display: none;">
    <form id="add-course-form">
        <input type="text" id="course-name" placeholder="Nombre del Curso" required />
        <input type="number" id="degree-id" placeholder="ID de la Titulación" required />
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddCourseForm()">Cancelar</button>
    </form>
</div>

<!-- Formulario para editar curso -->
<div id="edit-course-form" style="display: none;">
    <form id="edit-course-data-form">
        <input type="hidden" id="edit-course-id" />
        <input type="text" id="edit-course-name" placeholder="Nombre del Curso" required />
        <input type="number" id="edit-degree-id" placeholder="ID de la Titulación" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="closeEditCourseForm()">Cancelar</button>
    </form>
</div>

<!-- Tabla de cursos -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>ID Titulación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="course-table-body">
    </tbody>
</table>
