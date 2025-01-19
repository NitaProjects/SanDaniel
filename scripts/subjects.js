// Función de inicialización para la página de asignaturas
function initSubjectsPage() {
    const addForm = document.getElementById("add-subject-data-form");
    if (addForm) {
        addForm.addEventListener("submit", (event) => {
            event.preventDefault();
            addSubject();
        });
    }

    const editForm = document.getElementById("edit-subject-data-form");
    if (editForm) {
        editForm.addEventListener("submit", (event) => {
            event.preventDefault();
            updateSubject();
        });
    }

    loadSubjects();
}

// Función para cargar las asignaturas y mostrarlas en la tabla
async function loadSubjects() {
    try {
        const response = await axios.get("/subjects");
        const subjects = response.data;

        const tableBody = document.getElementById("subject-table-body");
        tableBody.innerHTML = "";

        subjects.forEach((subject) => {
            const row = `
                <tr>
                    <td>${subject.id}</td>
                    <td>${subject.name}</td>
                    <td>${subject.course_id}</td>
                    <td>
                        <button onclick="openEditSubjectForm(${subject.id})">Editar</button>
                        <button onclick="deleteSubject(${subject.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar las asignaturas:", error);
    }
}

// Función para añadir una asignatura
async function addSubject() {
    const name = document.getElementById("add-subject-name").value;
    const courseId = document.getElementById("add-subject-course-id").value;

    try {
        await axios.post("/subjects", { name, course_id: courseId });
        closeAddSubjectForm();
        loadSubjects();
    } catch (error) {
        console.error("Error al añadir la asignatura:", error);
    }
}

// Función para abrir el formulario de edición de una asignatura
async function openEditSubjectForm(id) {
    try {
        const response = await axios.get(`/subjects/${id}`);
        const subject = response.data;

        document.getElementById("edit-subject-id").value = subject.id;
        document.getElementById("edit-subject-name").value = subject.name;
        document.getElementById("edit-subject-course-id").value = subject.course_id;

        document.getElementById("edit-subject-form").style.display = "block";
    } catch (error) {
        console.error("Error al cargar los datos de la asignatura:", error);
    }
}

// Función para actualizar una asignatura
async function updateSubject() {
    const id = document.getElementById("edit-subject-id").value;
    const name = document.getElementById("edit-subject-name").value;
    const courseId = document.getElementById("edit-subject-course-id").value;

    try {
        await axios.put(`/subjects/${id}`, { name, course_id: courseId });
        closeEditSubjectForm();
        loadSubjects();
    } catch (error) {
        console.error("Error al actualizar la asignatura:", error);
    }
}

// Función para eliminar una asignatura
async function deleteSubject(id) {
    try {
        await axios.delete(`/subjects/${id}`);
        loadSubjects();
    } catch (error) {
        console.error("Error al eliminar la asignatura:", error);
    }
}

// Función para abrir el formulario de añadir asignatura
function openAddSubjectForm() {
    document.getElementById("add-subject-form").style.display = "block";
}

// Función para cerrar el formulario de añadir asignatura
function closeAddSubjectForm() {
    document.getElementById("add-subject-form").style.display = "none";
}

// Función para cerrar el formulario de edición de asignatura
function closeEditSubjectForm() {
    document.getElementById("edit-subject-form").style.display = "none";
}
