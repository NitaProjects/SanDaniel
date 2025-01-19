<h2>Gestión de Usuarios</h2>
<button onclick="openAddUserForm()">Añadir Usuario</button>

<!-- Formulario para agregar usuario -->
<div id="user-form" style="display: none;">
    <form id="add-user-form">
        <input type="text" id="first-name" placeholder="Nombre" required />
        <input type="text" id="last-name" placeholder="Apellido" required />
        <input type="email" id="email" placeholder="Correo Electrónico" required />
        <input type="password" id="password" placeholder="Contraseña" required />
        <select id="user-type">
            <option value="teacher">Profesor</option>
            <option value="student">Estudiante</option>
        </select>
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddUserForm()">Cancelar</button>
    </form>
</div>

<!-- Formulario para editar usuario -->
<div id="edit-user-form" style="display: none;">
    <form id="edit-user-data-form">
        <input type="hidden" id="edit-user-id" />
        <input type="text" id="edit-first-name" placeholder="Nombre"/>
        <input type="text" id="edit-last-name" placeholder="Apellido"/>
        <input type="email" id="edit-email" placeholder="Correo Electrónico"/>
        <input type="password" id="edit-password" placeholder="Contraseña" />
        <select id="edit-user-type">
            <option value="teacher">Profesor</option>
            <option value="student">Estudiante</option>
        </select>

        </select>
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="closeEditUserForm()">Cancelar</button>
    </form>
</div>


<!-- Tabla de usuarios -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="user-table-body">
    </tbody>
</table>

<script>
    // Función para cerrar el formulario de edición
    function closeEditUserForm() {
        document.getElementById("edit-user-form").style.display = "none";
    }
</script>