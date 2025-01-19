// Función de inicialización para la página de departamentos
function initDepartmentsPage() {
    const addForm = document.getElementById("add-department-data-form");
    if (addForm) {
        addForm.addEventListener("submit", (event) => {
            event.preventDefault();
            addDepartment();
        });
    }

    const editForm = document.getElementById("edit-department-data-form");
    if (editForm) {
        editForm.addEventListener("submit", (event) => {
            event.preventDefault();
            updateDepartment();
        });
    }

    loadDepartments();
}

// Función para cargar los departamentos y mostrarlos en la tabla
async function loadDepartments() {
    try {
        const response = await axios.get("/departments");
        const departments = response.data;

        const tableBody = document.getElementById("department-table-body");
        tableBody.innerHTML = "";

        departments.forEach((department) => {
            const row = `
                <tr>
                    <td>${department.id}</td>
                    <td>${department.name}</td>
                    <td>
                        <button onclick="openEditDepartmentForm(${department.id})">Editar</button>
                        <button onclick="deleteDepartment(${department.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar los departamentos:", error);
    }
}

// Función para añadir un departamento
async function addDepartment() {
    const name = document.getElementById("add-department-name").value;

    try {
        await axios.post("/departments", { name });
        closeAddDepartmentForm();
        loadDepartments();
    } catch (error) {
        console.error("Error al añadir departamento:", error);
    }
}

// Función para abrir el formulario de edición de un departamento
async function openEditDepartmentForm(id) {
    try {
        const response = await axios.get(`/departments/${id}`);
        const department = response.data;

        document.getElementById("edit-department-id").value = department.id;
        document.getElementById("edit-department-name").value = department.name;

        document.getElementById("edit-department-form").style.display = "block";
    } catch (error) {
        console.error("Error al cargar los datos del departamento:", error);
    }
}

// Función para actualizar un departamento
async function updateDepartment() {
    const id = document.getElementById("edit-department-id").value;
    const name = document.getElementById("edit-department-name").value;

    try {
        await axios.put(`/departments/${id}`, { name });
        closeEditDepartmentForm();
        loadDepartments();
    } catch (error) {
        console.error("Error al actualizar el departamento:", error);
    }
}

// Función para eliminar un departamento
async function deleteDepartment(id) {
    try {
        await axios.delete(`/departments/${id}`);
        loadDepartments();
    } catch (error) {
        console.error("Error al eliminar el departamento:", error);
    }
}

// Función para abrir el formulario de añadir departamento
function openAddDepartmentForm() {
    document.getElementById("add-department-form").style.display = "block";
}

// Función para cerrar el formulario de añadir departamento
function closeAddDepartmentForm() {
    document.getElementById("add-department-form").style.display = "none";
}

// Función para cerrar el formulario de edición de departamento
function closeEditDepartmentForm() {
    document.getElementById("edit-department-form").style.display = "none";
}
