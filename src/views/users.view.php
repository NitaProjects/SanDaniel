<h2>Gestión de Usuarios</h2>
<button onclick="addUser()">Añadir Usuario</button>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Juan Pérez</td>
            <td>juan.perez@example.com</td>
            <td>
                <button onclick="editUser(1)">Editar</button>
                <button onclick="deleteUser(1)">Eliminar</button>
            </td>
        </tr>
    </tbody>
</table>

<script>
function addUser() {
    alert('Añadir Usuario');
}

function editUser(id) {
    alert(`Editar Usuario con ID: ${id}`);
}

function deleteUser(id) {
    alert(`Eliminar Usuario con ID: ${id}`);
}
</script>
