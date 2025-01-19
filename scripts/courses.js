// Función de inicialización para la página de cursos
function initCoursesPage() {
    const form = document.getElementById("add-course-form");
    if (form) {
        form.addEventListener("submit", (event) => {
            event.preventDefault();
            addCourse();
        });
    }

    const editForm = document.getElementById("edit-course-data-form");
    if (editForm) {
        editForm.addEventListener("submit", (event) => {
            event.preventDefault();
            updateCourse();
        });
    }

    loadCourses();
}

// Función para cargar los cursos y mostrarlos en la tabla
async function loadCourses() {
    try {
        const response = await axios.get("/courses");
        const courses = response.data;

        const tableBody = document.getElementById("course-table-body");
        tableBody.innerHTML = "";

        courses.forEach((course) => {
            const row = `
                <tr>
                    <td>${course.id}</td>
                    <td>${course.name}</td>
                    <td>${course.degreeId}</td>
                    <td>
                        <button onclick="openEditCourseForm(${course.id})">Editar</button>
                        <button onclick="deleteCourse(${course.id})">Eliminar</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar los cursos:", error);
    }
}

// Función para añadir un curso
async function addCourse() {
    const name = document.getElementById("course-name").value;
    const degreeId = document.getElementById("degree-id").value;

    try {
        await axios.post("/courses", { name, degreeId });
        closeAddCourseForm();
        loadCourses();
    } catch (error) {
        console.error("Error al añadir el curso:", error);
    }
}

// Función para abrir el formulario de edición de un curso
async function openEditCourseForm(id) {
    try {
        const response = await axios.get(`/courses/${id}`);
        const course = response.data;

        document.getElementById("edit-course-id").value = course.id;
        document.getElementById("edit-course-name").value = course.name;
        document.getElementById("edit-degree-id").value = course.degreeId;

        document.getElementById("edit-course-form").style.display = "block";
    } catch (error) {
        console.error("Error al cargar los datos del curso:", error);
    }
}

// Función para actualizar un curso
async function updateCourse() {
    const id = document.getElementById("edit-course-id").value;
    const name = document.getElementById("edit-course-name").value;
    const degreeId = document.getElementById("edit-degree-id").value;

    try {
        await axios.put(`/courses/${id}`, { name, degreeId });
        closeEditCourseForm();
        loadCourses();
    } catch (error) {
        console.error("Error al actualizar el curso:", error);
    }
}

// Función para eliminar un curso
async function deleteCourse(id) {
    try {
        await axios.delete(`/courses/${id}`);
        loadCourses();
    } catch (error) {
        console.error("Error al eliminar el curso:", error);
    }
}

// Función para abrir el formulario de añadir curso
function openAddCourseForm() {
    document.getElementById("course-form").style.display = "block";
}

// Función para cerrar el formulario de añadir curso
function closeAddCourseForm() {
    document.getElementById("course-form").style.display = "none";
}

// Función para cerrar el formulario de edición de curso
function closeEditCourseForm() {
    document.getElementById("edit-course-form").style.display = "none";
}
