// Inicialización de la página de matrículas
function initEnrollmentsPage() {
    const addForm = document.getElementById("add-enrollment-data-form");
    if (addForm) {
        addForm.addEventListener("submit", (event) => {
            event.preventDefault();
            addEnrollment();
        });
    }

    const editForm = document.getElementById("edit-enrollment-data-form");
    if (editForm) {
        editForm.addEventListener("submit", (event) => {
            event.preventDefault();
            updateEnrollment();
        });
    }

    loadEnrollments();
}

// Cargar las matrículas y mostrarlas en la tabla
async function loadEnrollments() {
    try {
        const response = await axios.get("/enrollments");
        const enrollments = response.data;

        const tableBody = document.getElementById("enrollment-table-body");
        tableBody.innerHTML = "";

        enrollments.forEach((enrollment) => {
            const row = `
                <tr>
                    <td>${enrollment.id}</td>
                    <td>${enrollment.studentId}</td>
                    <td>${enrollment.subjectId}</td>
                    <td>${new Date(enrollment.enrollmentDate).toLocaleDateString()}</td>
                    <td>
                        <button onclick="openEditEnrollmentForm(${enrollment.id})">Editar</button>
                        <button onclick="deleteEnrollment(${enrollment.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar las matrículas:", error);
    }
}

// Añadir una nueva matrícula
async function addEnrollment() {
    const studentId = document.getElementById("add-student-id").value;
    const subjectId = document.getElementById("add-subject-id").value;
    const enrollmentDate = document.getElementById("add-enrollment-date").value;

    try {
        await axios.post("/enrollments", {
            studentId,
            subjectId,
            enrollmentDate,
        });

        closeAddEnrollmentForm();
        loadEnrollments();
    } catch (error) {
        console.error("Error al añadir matrícula:", error);
    }
}

// Abrir el formulario de edición para una matrícula específica
async function openEditEnrollmentForm(id) {
    try {
        const response = await axios.get(`/enrollments/${id}`);
        const enrollment = response.data;

        document.getElementById("edit-enrollment-id").value = enrollment.id;
        document.getElementById("edit-student-id").value = enrollment.studentId;
        document.getElementById("edit-subject-id").value = enrollment.subjectId;
        document.getElementById("edit-enrollment-date").value = enrollment.enrollmentDate;

        document.getElementById("edit-enrollment-form").style.display = "block";
    } catch (error) {
        console.error("Error al cargar la matrícula:", error);
    }
}

// Actualizar una matrícula
async function updateEnrollment() {
    const id = document.getElementById("edit-enrollment-id").value;
    const studentId = document.getElementById("edit-student-id").value;
    const subjectId = document.getElementById("edit-subject-id").value;
    const enrollmentDate = document.getElementById("edit-enrollment-date").value;

    try {
        await axios.put(`/enrollments/${id}`, {
            studentId,
            subjectId,
            enrollmentDate,
        });

        closeEditEnrollmentForm();
        loadEnrollments();
    } catch (error) {
        console.error("Error al actualizar la matrícula:", error);
    }
}

// Eliminar una matrícula
async function deleteEnrollment(id) {
    try {
        await axios.delete(`/enrollments/${id}`);
        loadEnrollments();
    } catch (error) {
        console.error("Error al eliminar la matrícula:", error);
    }
}

// Abrir el formulario de añadir matrícula
function openAddEnrollmentForm() {
    document.getElementById("add-enrollment-form").style.display = "block";
}

// Cerrar el formulario de añadir matrícula
function closeAddEnrollmentForm() {
    document.getElementById("add-enrollment-form").style.display = "none";
}

// Cerrar el formulario de edición de matrícula
function closeEditEnrollmentForm() {
    document.getElementById("edit-enrollment-form").style.display = "none";
}
