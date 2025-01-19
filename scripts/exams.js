// Inicialización de la página de exámenes
function initExamsPage() {
    const addForm = document.getElementById("add-exam-data-form");
    if (addForm) {
        addForm.addEventListener("submit", (event) => {
            event.preventDefault();
            addExam();
        });
    }

    const editForm = document.getElementById("edit-exam-data-form");
    if (editForm) {
        editForm.addEventListener("submit", (event) => {
            event.preventDefault();
            updateExam();
        });
    }

    loadExams();
}

// Cargar exámenes y mostrarlos en la tabla
async function loadExams() {
    try {
        const response = await axios.get("/exams");
        const exams = response.data;

        const tableBody = document.getElementById("exam-table-body");
        tableBody.innerHTML = "";

        exams.forEach((exam) => {
            const row = `
                <tr>
                    <td>${exam.id}</td>
                    <td>${exam.subjectId}</td>
                    <td>${exam.examDate}</td>
                    <td>${exam.description}</td>
                    <td>
                        <button onclick="openEditExamForm(${exam.id})">Editar</button>
                        <button onclick="deleteExam(${exam.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar los exámenes:", error);
    }
}

// Añadir un examen
async function addExam() {
    const subjectId = document.getElementById("add-exam-subject-id").value;
    const examDate = document.getElementById("add-exam-date").value;
    const description = document.getElementById("add-exam-description").value;

    try {
        await axios.post("/exams", {
            subjectId: parseInt(subjectId),
            examDate,
            description,
        });
        closeAddExamForm();
        loadExams();
    } catch (error) {
        console.error("Error al añadir examen:", error);
    }
}

// Abrir formulario para editar examen
async function openEditExamForm(id) {
    try {
        const response = await axios.get(`/exams/${id}`);
        const exam = response.data;

        document.getElementById("edit-exam-id").value = exam.id;
        document.getElementById("edit-exam-subject-id").value = exam.subjectId;
        document.getElementById("edit-exam-date").value = exam.examDate;
        document.getElementById("edit-exam-description").value = exam.description;

        document.getElementById("edit-exam-form").style.display = "block";
    } catch (error) {
        console.error("Error al cargar los datos del examen:", error);
    }
}

// Actualizar un examen
async function updateExam() {
    const id = document.getElementById("edit-exam-id").value;
    const subjectId = document.getElementById("edit-exam-subject-id").value;
    const examDate = document.getElementById("edit-exam-date").value;
    const description = document.getElementById("edit-exam-description").value;

    try {
        await axios.put(`/exams/${id}`, {
            subjectId: parseInt(subjectId),
            examDate,
            description,
        });
        closeEditExamForm();
        loadExams();
    } catch (error) {
        console.error("Error al actualizar el examen:", error);
    }
}

// Eliminar un examen
async function deleteExam(id) {
    try {
        await axios.delete(`/exams/${id}`);
        loadExams();
    } catch (error) {
        console.error("Error al eliminar el examen:", error);
    }
}

// Mostrar formulario de añadir examen
function openAddExamForm() {
    document.getElementById("add-exam-form").style.display = "block";
}

// Ocultar formulario de añadir examen
function closeAddExamForm() {
    document.getElementById("add-exam-form").style.display = "none";
}

// Ocultar formulario de edición de examen
function closeEditExamForm() {
    document.getElementById("edit-exam-form").style.display = "none";
}
