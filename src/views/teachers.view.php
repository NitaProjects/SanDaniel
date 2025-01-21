<h2>Gestión de Profesores</h2>

<!-- Tabla de profesores -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="teacher-table-body">
        <!-- Se llenará dinámicamente con JavaScript -->
    </tbody>
</table>

<!-- Modal para agregar o editar un profesor -->
<div id="teacher-modal" style="display: none;">
    <h3 id="modal-title">Agregar/Editar Profesor</h3>
    <form id="teacher-form">
        <input type="hidden" id="teacher-id" />
        <label for="teacher-name">Nombre:</label>
        <input type="text" id="teacher-name" required />
        <label for="teacher-email">Correo:</label>
        <input type="email" id="teacher-email" required />
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeTeacherModal()">Cancelar</button>
    </form>
</div>
