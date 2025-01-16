// Función de inicialización específica para la página de usuarios
function initUsersPage() {

    // Busca el formulario y agrega el evento de envío
    const form = document.getElementById("add-user-form");
    if (form) {
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            addUser();
        });
    } else {
        console.warn("El formulario de agregar usuario no está disponible.");
    }

    // Cargar usuarios en la tabla
    loadUsers();
}

// Función para cargar los usuarios y mostrarlos en la tabla
async function loadUsers() {
    try {
        const tableBody = document.getElementById("user-table-body");
        if (!tableBody) {
            console.warn("El cuerpo de la tabla de usuarios no está disponible.");
            return;
        }

        const response = await fetch("/users");
        if (!response.ok) {
            throw new Error("Error al cargar los usuarios");
        }

        // Log de la respuesta JSON
        const users = await response.json();

        tableBody.innerHTML = ""; 

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
        console.error("Error al cargar los usuarios:", error);
    }
}


// Función para agregar un usuario
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

        console.log("Usuario añadido correctamente");
        closeAddUserForm();
        loadUsers(); // Recarga los usuarios tras añadir uno nuevo
    } catch (error) {
        console.error("Error al añadir usuario:", error);
    }
}

// Función para editar un usuario (placeholder)
function editUser(id) {
    // Obtén los datos del usuario desde el servidor
    fetch(`/users/${id}`)
        .then(response => {
            if (!response.ok) throw new Error("Error al obtener los datos del usuario");
            return response.json();
        })
        .then(user => {
            // Rellenar el formulario con los datos del usuario
            document.getElementById("edit-user-id").value = user.id;
            document.getElementById("edit-first-name").value = user.first_name;
            document.getElementById("edit-last-name").value = user.last_name;
            document.getElementById("edit-email").value = user.email;
            document.getElementById("edit-password").value = ""; 
            document.getElementById("edit-user-type").value = user.user_type;

            // Mostrar el formulario
            document.getElementById("edit-user-form").style.display = "block";
        })
        .catch(error => console.error("Error al cargar los datos del usuario:", error));
}


// Función para eliminar un usuario
async function deleteUser(id) {
    try {
        const response = await fetch(`/users/${id}`, { method: "DELETE" });
        if (!response.ok) {
            throw new Error("Error al eliminar usuario");
        }

        console.log("Usuario eliminado correctamente");
        loadUsers(); // Recarga los usuarios tras eliminar uno
    } catch (error) {
        console.error("Error al eliminar usuario:", error);
    }
}

// Función para mostrar el formulario de agregar usuario
function openAddUserForm() {
    const form = document.getElementById("user-form");
    if (form) {
        form.style.display = "block";
    } else {
        console.warn("El formulario de agregar usuario no está disponible.");
    }
}

// Función para ocultar el formulario de agregar usuario
function closeAddUserForm() {
    const form = document.getElementById("user-form");
    if (form) {
        form.style.display = "none";
    } else {
        console.warn("El formulario de agregar usuario no está disponible.");
    }
}

