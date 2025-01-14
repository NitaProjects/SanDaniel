document.addEventListener("DOMContentLoaded", () => {
    loadUsers();

    const form = document.getElementById("add-user-form");
    form.addEventListener("submit", (event) => {
        event.preventDefault();
        addUser();
    });
});

async function loadUsers() {
    try {
        const response = await fetch("/users");
        if (!response.ok) {
            throw new Error("Error al cargar los usuarios");
        }
        const users = await response.json();

        const tableBody = document.getElementById("user-table-body");
        tableBody.innerHTML = ""; // Limpia la tabla antes de agregar filas

        users.forEach((user) => {
            const row = `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.first_name} ${user.last_name}</td>
                    <td>${user.email}</td>
                    <td>${user.user_type}</td>
                    <td>
                        <button onclick="editUser(${user.id})">Editar</button>
                        <button onclick="deleteUser(${user.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error(error);
    }
}

async function addUser() {
    const firstName = document.getElementById("first-name").value;
    const lastName = document.getElementById("last-name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const userType = document.getElementById("user-type").value;

    try {
        const response = await fetch("/users", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ first_name: firstName, last_name: lastName, email, password, user_type: userType }),
        });

        if (!response.ok) {
            throw new Error("Error al añadir usuario");
        }

        closeAddUserForm();
        loadUsers(); // Recarga los usuarios tras añadir uno nuevo
    } catch (error) {
        console.error(error);
    }
}

function editUser(id) {
    alert(`Editar usuario con ID: ${id}`);
}

async function deleteUser(id) {
    try {
        const response = await fetch(`/users/${id}`, { method: "DELETE" });
        if (!response.ok) {
            throw new Error("Error al eliminar usuario");
        }
        loadUsers(); // Recarga los usuarios tras eliminar uno
    } catch (error) {
        console.error(error);
    }
}

console.log("El archivo users.js está funcionando.");

function openAddUserForm() {
    document.getElementById('user-form').style.display = 'block';
}

function closeAddUserForm() {
    document.getElementById('user-form').style.display = 'none';
}

