// Inicializar la página
function initTeachersPage() {
    const teacherForm = document.getElementById("teacher-form");
    if (teacherForm) {
        teacherForm.addEventListener("submit", (event) => {
            event.preventDefault();
            addTeacher();
        });
    }

    loadTeachers();
}

// Cargar profesores y mostrar en la tabla
async function loadTeachers() {
    try {
        const response = await axios.get("/teachers");
        const teachers = response.data;

        const tableBody = document.getElementById("teacher-table-body");
        tableBody.innerHTML = "";

        if (!Array.isArray(teachers) || teachers.length === 0) {
            tableBody.innerHTML = "<tr><td colspan='4'>No hay profesores registrados</td></tr>";
            return;
        }

        teachers.forEach((teacher) => {
            const row = `
                <tr>
                    <td>${teacher.id}</td>
                    <td>${teacher.first_name} ${teacher.last_name}</td>
                    <td>${teacher.email}</td>
                    <td>
                        <button onclick="editTeacher(${teacher.id})">Editar</button>
                        <button onclick="deleteTeacher(${teacher.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar los profesores:", error);
    }
}

// Guardar (crear o actualizar) un profesor
async function addTeacher() {
    const teacherId = document.getElementById("teacher-id").value;
    const firstName = document.getElementById("teacher-name").value;
    const email = document.getElementById("teacher-email").value;

    try {
        if (teacherId) {
            await axios.put(`/teachers/${teacherId}`, { first_name: firstName, email });
        } else {
            await axios.post("/teachers", { first_name: firstName, email });
        }

        closeTeacherModal();
        loadTeachers();
    } catch (error) {
        console.error("Error al guardar el profesor:", error.response?.data || error);
        alert(error.response?.data?.error || "Error al guardar el profesor. Inténtalo de nuevo.");
    }
}

// Editar un profesor
async function editTeacher(teacherId) {
    try {
        const response = await axios.get(`/teachers/${teacherId}`);
        const teacher = response.data;

        document.getElementById("teacher-id").value = teacher.id;
        document.getElementById("teacher-name").value = teacher.first_name;
        document.getElementById("teacher-email").value = teacher.email;

        openTeacherModal("Editar Profesor");
    } catch (error) {
        console.error("Error al cargar los datos del profesor:", error);
    }
}

// Eliminar un profesor
async function deleteTeacher(teacherId) {
    try {
        await axios.delete(`/teachers/${teacherId}`);
        loadTeachers();
    } catch (error) {
        console.error("Error al eliminar el profesor:", error);
        alert("Error al eliminar el profesor.");
    }
}

// Abrir modal para agregar o editar un profesor
function openTeacherModal(title = "Agregar Profesor") {
    document.getElementById("modal-title").textContent = title;

    document.getElementById("teacher-id").value = "";
    document.getElementById("teacher-name").value = "";
    document.getElementById("teacher-email").value = "";

    document.getElementById("teacher-modal").style.display = "block";
}

// Cerrar modal de profesor
function closeTeacherModal() {
    document.getElementById("teacher-id").value = "";
    document.getElementById("teacher-name").value = "";
    document.getElementById("teacher-email").value = "";
    document.getElementById("teacher-modal").style.display = "none";
}

// Inicializar la página al cargar
document.addEventListener("DOMContentLoaded", initTeachersPage);
