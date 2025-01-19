<h2>Gestión de Exámenes</h2>

<!-- Tabla para mostrar exámenes -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Asignatura</th>
            <th>Fecha del Examen</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="exam-table-body">
        <!-- Se llenará dinámicamente con JavaScript -->
    </tbody>
</table>

<!-- Modal para añadir examen -->
<div id="add-exam-form" style="display: none;">
    <h3>Añadir Examen</h3>
    <form id="add-exam-data-form">
        <label for="add-exam-subject-id">ID de la Asignatura:</label>
        <input type="number" id="add-exam-subject-id" placeholder="ID de la Asignatura" required />
        <label for="add-exam-date">Fecha del Examen:</label>
        <input type="date" id="add-exam-date" required />
        <label for="add-exam-description">Descripción:</label>
        <input type="text" id="add-exam-description" placeholder="Descripción del Examen" required />
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddExamForm()">Cancelar</button>
    </form>
</div>

<!-- Modal para editar examen -->
<div id="edit-exam-form" style="display: none;">
    <h3>Editar Examen</h3>
    <form id="edit-exam-data-form">
        <input type="hidden" id="edit-exam-id" />
        <label for="edit-exam-subject-id">ID de la Asignatura:</label>
        <input type="number" id="edit-exam-subject-id" required />
        <label for="edit-exam-date">Fecha del Examen:</label>
        <input type="date" id="edit-exam-date" required />
        <label for="edit-exam-description">Descripción:</label>
        <input type="text" id="edit-exam-description" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="closeEditExamForm()">Cancelar</button>
    </form>
</div>

<button onclick="openAddExamForm()">Añadir Examen</button>
