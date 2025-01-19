// Inicializar la página
function initTeachersPage() {
    const assignDepartmentForm = document.getElementById("assign-department-form");
    if (assignDepartmentForm) {
        assignDepartmentForm.addEventListener("submit", (event) => {
            event.preventDefault();
            assignDepartmentToTeacher();
        });
    }

    const removeDepartmentForm = document.getElementById("remove-department-form");
    if (removeDepartmentForm) {
        removeDepartmentForm.addEventListener("submit", (event) => {
            event.preventDefault();
            removeSpecificDepartment();
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

        if (!Array.isArray(teachers)) {
            console.error("El contenido de 'teachers' no es un array:", teachers);
            return;
        }

        teachers.forEach((teacher) => {
            const row = `
                <tr>
                    <td>${teacher.id}</td>
                    <td>${teacher.first_name} ${teacher.last_name}</td>
                    <td>${teacher.email}</td>
                    <td>${Array.isArray(teacher.departments)
                        ? teacher.departments.map(dep => dep.name).join(", ")
                        : "Sin departamentos"}</td>
                    <td>
                        <button onclick="openAssignDepartmentModal(${teacher.id})">Asignar Departamento</button>
                        <button onclick="openRemoveDepartmentModal(${teacher.id})">Eliminar Departamento</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error al cargar los profesores:", error);
    }
}


// Asignar un departamento a un profesor
async function assignDepartmentToTeacher() {
    const teacherId = document.getElementById("teacher-id").value;
    const departmentId = document.getElementById("department-select").value;

    try {
        await axios.post(`/teachers/${teacherId}/departments`, { department_id: departmentId });
        closeAssignDepartmentModal();
        loadTeachers();
    } catch (error) {
        console.error("Error al asignar departamento:", error);
    }
}

// Eliminar un departamento específico de un profesor
async function removeSpecificDepartment() {
    const teacherId = document.getElementById("remove-teacher-id").value;
    const departmentId = document.getElementById("remove-department-select").value;

    try {
        await axios.delete(`/teachers/${teacherId}/departments/${departmentId}`);
        closeRemoveDepartmentModal();
        loadTeachers();
    } catch (error) {
        console.error("Error al eliminar departamento:", error);
    }
}

// Abrir modal para asignar departamento
function openAssignDepartmentModal(teacherId) {
    document.getElementById("teacher-id").value = teacherId;
    loadAvailableDepartments(teacherId);
    document.getElementById("assign-department-modal").style.display = "block";
}

// Abrir modal para eliminar departamento
function openRemoveDepartmentModal(teacherId) {
    document.getElementById("remove-teacher-id").value = teacherId;
    loadAssignedDepartments(teacherId);
    document.getElementById("remove-department-modal").style.display = "block";
}

async function loadAvailableDepartments(teacherId) {
    try {
        const response = await axios.get(`/departments`);
        const assignedResponse = await axios.get(`/teachers/${teacherId}/departments`);

        // Si `assignedResponse.data` no es un array, ajustarlo
        const assignedDepartmentIds = Array.isArray(assignedResponse.data)
            ? assignedResponse.data.map(dep => dep.id)
            : []; // Si no es un array, usamos un array vacío

        const departmentSelect = document.getElementById("department-select");
        if (!departmentSelect) return;

        departmentSelect.innerHTML = "";

        response.data
            .filter(dep => !assignedDepartmentIds.includes(dep.id)) 
            .forEach((department) => {
                const option = document.createElement("option");
                option.value = department.id;
                option.textContent = department.name;
                departmentSelect.appendChild(option);
            });
    } catch (error) {
        console.error("Error al cargar los departamentos disponibles:", error);
    }
}


// Cargar departamentos asignados al profesor
async function loadAssignedDepartments(teacherId) {
    try {
        const response = await axios.get(`/teachers/${teacherId}/departments`);
        const departmentSelect = document.getElementById("remove-department-select");
        departmentSelect.innerHTML = "";

        response.data.forEach((department) => {
            const option = document.createElement("option");
            option.value = department.id;
            option.textContent = department.name;
            departmentSelect.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar departamentos asignados:", error);
    }
}

// Cerrar modal de asignar departamento
function closeAssignDepartmentModal() {
    document.getElementById("assign-department-modal").style.display = "none";
}

// Cerrar modal de eliminar departamento
function closeRemoveDepartmentModal() {
    document.getElementById("remove-department-modal").style.display = "none";
}
