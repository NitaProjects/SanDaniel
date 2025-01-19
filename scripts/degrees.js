// Función de inicialización para la página de titulaciones
function initDegreesPage() {
    const addForm = document.getElementById("add-degree-data-form");
    if (addForm) {
        addForm.addEventListener("submit", (event) => {
            event.preventDefault();
            addDegree();
        });
    }

    const editForm = document.getElementById("edit-degree-data-form");
    if (editForm) {
        editForm.addEventListener("submit", (event) => {
            event.preventDefault();
            updateDegree();
        });
    }

    loadDegrees();
}

// Función para cargar las titulaciones y mostrarlas en la tabla
async function loadDegrees() {
    try {
        const response = await axios.get("/degrees");
        const degrees = response.data;

        const tableBody = document.getElementById("degree-table-body");
        tableBody.innerHTML = "";

        degrees.forEach((degree) => {
            const row = `
                <tr>
                    <td>${degree.id}</td>
                    <td>${degree.name}</td>
                    <td>${degree.durationYears}</td>
                    <td>
                        <button onclick="openEditDegreeForm(${degree.id})">Editar</button>
                        <button onclick="deleteDegree(${degree.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar las titulaciones:", error);
    }
}

// Función para añadir una titulación
async function addDegree() {
    const name = document.getElementById("add-degree-name").value;
    const durationYears = document.getElementById("add-degree-duration").value;

    try {
        await axios.post("/degrees", { name, durationYears: parseInt(durationYears, 10) });
        closeAddDegreeForm();
        loadDegrees();
    } catch (error) {
        console.error("Error al añadir la titulación:", error);
    }
}

// Función para abrir el formulario de edición de una titulación
async function openEditDegreeForm(id) {
    try {
        const response = await axios.get(`/degrees/${id}`);
        const degree = response.data;

        document.getElementById("edit-degree-id").value = degree.id;
        document.getElementById("edit-degree-name").value = degree.name;
        document.getElementById("edit-degree-duration").value = degree.durationYears;

        document.getElementById("edit-degree-form").style.display = "block";
    } catch (error) {
        console.error("Error al cargar los datos de la titulación:", error);
    }
}

// Función para actualizar una titulación
async function updateDegree() {
    const id = document.getElementById("edit-degree-id").value;
    const name = document.getElementById("edit-degree-name").value;
    const durationYears = document.getElementById("edit-degree-duration").value;

    try {
        await axios.put(`/degrees/${id}`, { name, durationYears: parseInt(durationYears, 10) });
        closeEditDegreeForm();
        loadDegrees();
    } catch (error) {
        console.error("Error al actualizar la titulación:", error);
    }
}

// Función para eliminar una titulación
async function deleteDegree(id) {
    try {
        await axios.delete(`/degrees/${id}`);
        loadDegrees();
    } catch (error) {
        console.error("Error al eliminar la titulación:", error);
    }
}

// Función para abrir el formulario de añadir titulación
function openAddDegreeForm() {
    document.getElementById("add-degree-form").style.display = "block";
}

// Función para cerrar el formulario de añadir titulación
function closeAddDegreeForm() {
    document.getElementById("add-degree-form").style.display = "none";
}

// Función para cerrar el formulario de edición de titulación
function closeEditDegreeForm() {
    document.getElementById("edit-degree-form").style.display = "none";
}
