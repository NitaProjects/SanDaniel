<h2>Gestión de Profesores</h2>

<!-- Tabla de profesores -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Departamentos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="teacher-table-body">
        <!-- Se llenará dinámicamente con JavaScript -->
    </tbody>
</table>

<!-- Modal para asignar un departamento -->
<div id="assign-department-modal" style="display: none;">
    <h3>Asignar Departamento</h3>
    <form id="assign-department-form">
        <input type="hidden" id="teacher-id" />
        <label for="department-select">Selecciona un Departamento:</label>
        <select id="department-select">
            <!-- Opciones cargadas dinámicamente -->
        </select>
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAssignDepartmentModal()">Cancelar</button>
    </form>
</div>

<!-- Modal para eliminar un departamento -->
<div id="remove-department-modal" style="display: none;">
    <h3>Eliminar Departamento</h3>
    <form id="remove-department-form">
        <input type="hidden" id="remove-teacher-id" />
        <label for="remove-department-select">Selecciona un Departamento:</label>
        <select id="remove-department-select">
            <!-- Opciones cargadas dinámicamente -->
        </select>
        <button type="submit">Eliminar</button>
        <button type="button" onclick="closeRemoveDepartmentModal()">Cancelar</button>
    </form>
</div>
