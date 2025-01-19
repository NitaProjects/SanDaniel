<h2>Gestión de Titulaciones</h2>

<!-- Tabla para mostrar titulaciones -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Años de Duración</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="degree-table-body">
        <!-- Se llenará dinámicamente con JavaScript -->
    </tbody>
</table>

<!-- Modal para añadir titulación -->
<div id="add-degree-form" style="display: none;">
    <h3>Añadir Titulación</h3>
    <form id="add-degree-data-form">
        <input type="text" id="add-degree-name" placeholder="Nombre de la Titulación" required />
        <input type="number" id="add-degree-duration" placeholder="Años de Duración" required />
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddDegreeForm()">Cancelar</button>
    </form>
</div>

<!-- Modal para editar titulación -->
<div id="edit-degree-form" style="display: none;">
    <h3>Editar Titulación</h3>
    <form id="edit-degree-data-form">
        <input type="hidden" id="edit-degree-id" />
        <input type="text" id="edit-degree-name" placeholder="Nombre de la Titulación" required />
        <input type="number" id="edit-degree-duration" placeholder="Años de Duración" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="closeEditDegreeForm()">Cancelar</button>
    </form>
</div>

<button onclick="openAddDegreeForm()">Añadir Titulación</button>
