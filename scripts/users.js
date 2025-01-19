// Función de inicialización para la página de usuarios
function initUsersPage() {
    const form = document.getElementById("add-user-form");
    if (form) {
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            addUser();
        });
    }
    loadUsers();
}

// Función para cargar los usuarios y mostrarlos en la tabla
async function loadUsers() {
    try {
        const response = await axios.get("/users");
        const users = response.data;

        const tableBody = document.getElementById("user-table-body");
        tableBody.innerHTML = "";

        users.forEach((user) => {
            const row = `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.first_name} ${user.last_name}</td>
                    <td>${user.email}</td>
                    <td>${user.user_type}</td>
                    <td>
                        <button onclick="updateUser(${user.id})">Editar</button>
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
        await axios.post("/users", {
            first_name: firstName,
            last_name: lastName,
            email: email,
            password: password,
            user_type: userType,
        });

        closeAddUserForm();
        loadUsers();
    } catch (error) {
        console.error("Error al añadir usuario:", error);
    }
}

// Función para editar un usuario
async function updateUser(id) {
    try {
        // Obtener datos del usuario desde el backend
        const response = await axios.get(`/users/${id}`);
        const user = response.data;

        // Asignar valores a los campos del formulario de edición
        document.getElementById("edit-user-id").value = user.id || "";
        document.getElementById("edit-first-name").value = user.first_name || "";
        document.getElementById("edit-last-name").value = user.last_name || "";
        document.getElementById("edit-email").value = user.email || "";
        document.getElementById("edit-user-type").value = user.user_type || "";

        // Mostrar el formulario de edición
        document.getElementById("edit-user-form").style.display = "block";

        // Configurar el evento de envío del formulario
        const form = document.getElementById("edit-user-data-form");
        form.onsubmit = async (event) => {
            event.preventDefault();

            try {
                // Enviar datos actualizados al backend
                await axios.put(`/users/${id}`, {
                    first_name: document.getElementById("edit-first-name").value,
                    last_name: document.getElementById("edit-last-name").value,
                    email: document.getElementById("edit-email").value,
                    password: document.getElementById("edit-password").value || "",
                    user_type: document.getElementById("edit-user-type").value,
                });
                
                closeEditUserForm();
                loadUsers();
            } catch (error) {
                console.error("Error al actualizar usuario:", error);
            }
        };
    } catch (error) {
        console.error("Error al cargar los datos del usuario:", error);
    }
}




// Función para eliminar un usuario
async function deleteUser(id) {
    try {
        await axios.delete(`/users/${id}`);
        loadUsers();
    } catch (error) {
        console.error("Error al eliminar usuario:", error);
    }
}

// Función para mostrar el formulario de agregar usuario
function openAddUserForm() {
    document.getElementById("user-form").style.display = "block";
}

// Función para ocultar el formulario de agregar usuario
function closeAddUserForm() {
    document.getElementById("user-form").style.display = "none";
}

// Función para ocultar el formulario de edición
function closeEditUserForm() {
    document.getElementById("edit-user-form").style.display = "none";
}
