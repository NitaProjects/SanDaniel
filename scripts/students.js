 // Inicializar la página
 function initStudentsPage() {
    const addForm = document.getElementById("add-student-data-form");
    if (addForm) {
        addForm.addEventListener("submit", (event) => {
            event.preventDefault();
            addStudent();
        });
    }

    const editForm = document.getElementById("edit-student-data-form");
    if (editForm) {
        editForm.addEventListener("submit", (event) => {
            event.preventDefault();
            updateStudent();
        });
    }

    loadStudents();
}

// Cargar estudiantes
async function loadStudents() {
    try {
        const response = await axios.get("/students");
        const students = response.data;

        const tableBody = document.getElementById("student-table-body");
        tableBody.innerHTML = "";

        students.forEach((student) => {
            const row = `
                <tr>
                    <td>${student.id}</td>
                    <td>${student.user_id}</td>
                    <td>${student.dni}</td>
                    <td>${student.enrollment_year}</td>
                    <td>
                        <button onclick="openEditStudentForm(${student.id})">Editar</button>
                        <button onclick="deleteStudent(${student.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar estudiantes:", error);
    }
}

// Añadir estudiante
async function addStudent() {
    const userId = document.getElementById("add-student-user-id").value;
    const dni = document.getElementById("add-student-dni").value;
    const enrollmentYear = document.getElementById("add-student-enrollment-year").value;

    try {
        await axios.post("/students", { user_id: userId, dni, enrollment_year: enrollmentYear });
        closeAddStudentForm();
        loadStudents();
    } catch (error) {
        console.error("Error al añadir estudiante:", error);
    }
}

// Abrir formulario de edición de estudiante
async function openEditStudentForm(id) {
    try {
        const response = await axios.get(`/students/${id}`);
        const student = response.data;

        document.getElementById("edit-student-id").value = student.id;
        document.getElementById("edit-student-dni").value = student.dni;
        document.getElementById("edit-student-enrollment-year").value = student.enrollment_year;

        document.getElementById("edit-student-form").style.display = "block";
    } catch (error) {
        console.error("Error al cargar datos del estudiante:", error);
    }
}

// Actualizar estudiante
async function updateStudent() {
    const id = document.getElementById("edit-student-id").value;
    const dni = document.getElementById("edit-student-dni").value;
    const enrollmentYear = document.getElementById("edit-student-enrollment-year").value;

    try {
        await axios.put(`/students/${id}`, { dni, enrollment_year: enrollmentYear });
        closeEditStudentForm();
        loadStudents();
    } catch (error) {
        console.error("Error al actualizar estudiante:", error);
    }
}

// Eliminar estudiante
async function deleteStudent(id) {
    try {
        await axios.delete(`/students/${id}`);
        loadStudents();
    } catch (error) {
        console.error("Error al eliminar estudiante:", error);
    }
}

// Funciones para manejar formularios
function openAddStudentForm() {
    document.getElementById("add-student-form").style.display = "block";
}

function closeAddStudentForm() {
    document.getElementById("add-student-form").style.display = "none";
}

function closeEditStudentForm() {
    document.getElementById("edit-student-form").style.display = "none";
}