<h2>Gestión de Usuarios</h2>
<button onclick="openAddUserForm()">Añadir Usuario</button>
<div id="user-form" style="display: none;">
    <form id="add-user-form">
        <input type="text" id="first-name" placeholder="Nombre" required />
        <input type="text" id="last-name" placeholder="Apellido" required />
        <input type="email" id="email" placeholder="Correo Electrónico" required />
        <input type="password" id="password" placeholder="Contraseña" required />
        <select id="user-type">
            <option value="admin">Admin</option>
            <option value="teacher">Profesor</option>
            <option value="student">Estudiante</option>
        </select>
        <button type="submit">Guardar</button>
        <button type="button" onclick="closeAddUserForm()">Cancelar</button>
    </form>
</div>
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


<script src="../../scripts/users.js"></script>

