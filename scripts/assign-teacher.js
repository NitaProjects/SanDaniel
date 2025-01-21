document.addEventListener("DOMContentLoaded", () => {
    loadTeachersAndDepartments();
    loadAssignments();

    const form = document.getElementById("assign-teacher-form");
    if (form) {
        form.addEventListener("submit", handleFormSubmit);
    }
});

// Cargar profesores y departamentos
async function loadTeachersAndDepartments() {
    try {
        const [teachers, departments] = await Promise.all([
            axios.get("/teachers"),
            axios.get("/departments"),
        ]);

        populateSelect("teacher", teachers.data, "id", "first_name");
        populateSelect("department", departments.data, "id", "name");
    } catch (error) {
        console.error("Error al cargar datos:", error);
    }
}

// Llenar un select dinámicamente
function populateSelect(selectId, data, valueKey, textKey) {
    const select = document.getElementById(selectId);
    if (!select) return;

    // Mantener la opción de selección inicial
    select.innerHTML = '<option value="" disabled selected>Selecciona una opción</option>';

    data.forEach((item) => {
        const option = document.createElement("option");
        option.value = item[valueKey];
        option.textContent = item[textKey];
        select.appendChild(option);
    });
}


// Cargar asignaciones y renderizar la tabla
async function loadAssignments() {
    try {
        const response = await axios.get("/teacher-departments");
        renderAssignmentsTable(response.data);
    } catch (error) {
        console.error("Error al cargar asignaciones:", error);
    }
}

// Renderizar la tabla de asignaciones
function renderAssignmentsTable(assignments) {
    const tableBody = document.getElementById("assignments-table-body");
    tableBody.innerHTML = assignments.length
        ? assignments.map(assignment => `
            <tr>
                <td>${assignment.teacher}</td>
                <td>${assignment.department}</td>
                <td>
                    <button 
                        data-teacher-id="${assignment.teacherId}" 
                        data-department-id="${assignment.departmentId}" 
                        onclick="deleteAssignment(this)">
                        Eliminar
                    </button>
                </td>
            </tr>`).join("")
        : `<tr><td colspan="3">No hay asignaciones registradas.</td></tr>`;
}

// Manejar el envío del formulario de asignación
async function handleFormSubmit(event) {
    event.preventDefault();

    const teacherId = document.getElementById("teacher").value;
    const departmentId = document.getElementById("department").value;

    if (!teacherId || !departmentId) {
        alert("Por favor selecciona un profesor y un departamento.");
        return;
    }

    try {
        await axios.post(`/teachers/departments`, {
            teacher_id: teacherId, // Incluye teacher_id en el cuerpo
            department_id: departmentId,
        });

        alert("Profesor asignado correctamente");
        loadAssignments(); // Recargar asignaciones
    } catch (error) {
        console.error("Error al asignar profesor:", error.response?.data || error);
        alert(error.response?.data?.error || "Error al asignar profesor. Verifique los datos.");
    }
}



// Manejar la eliminación de una asignación
async function deleteAssignment(button) {
    const { teacherId, departmentId } = button.dataset;

    try {
        await axios.delete('/teachers/departments', {
            data: { teacher_id: teacherId, department_id: departmentId }, 
        });

        alert("Asignación eliminada correctamente");
        loadAssignments(); // Recargar asignaciones
    } catch (error) {
        console.error("Error al eliminar asignación:", error.response?.data || error);
        alert(error.response?.data?.error || "Error al eliminar la asignación.");
    }
}

