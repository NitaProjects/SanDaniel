<h2>Gestión de Departamentos</h2>

<!-- Tabla para mostrar departamentos -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="department-table-body">
        <!-- Se llenará dinámicamente con JavaScript -->
    </tbody>
</table>

<!-- Modal para añadir departamento -->
<div id="add-department-form" style="display: none;">
    <h3>Añadir Departamento</h3>
    <form id="add-department-data-form">
        <input type="text" id="add-department-name" placeholder="Nombre del Departamento" required />
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddDepartmentForm()">Cancelar</button>
    </form>
</div>

<!-- Modal para editar departamento -->
<div id="edit-department-form" style="display: none;">
    <h3>Editar Departamento</h3>
    <form id="edit-department-data-form">
        <input type="hidden" id="edit-department-id" />
        <input type="text" id="edit-department-name" placeholder="Nombre del Departamento" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="closeEditDepartmentForm()">Cancelar</button>
    </form>
</div>

<button onclick="openAddDepartmentForm()">Añadir Departamento</button>
