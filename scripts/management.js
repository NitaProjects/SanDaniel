function loadContent(entity) {
    const contentContainer = document.getElementById('dynamic-content');
    const viewPath = `/load-view.php?entity=${entity}`;

    fetch(viewPath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar la vista');
            }
            return response.text();
        })
        .then(html => {
            contentContainer.innerHTML = html;

            // Inicializa scripts dinámicos según la entidad
            switch (entity) {
                case 'users':
                    initUsersPage();
                    break;
                case 'students':
                    initStudentsPage();
                    break;
                case 'teachers':
                    initTeachersPage();
                    break;
                case 'subjects':
                    initSubjectsPage();
                    break;
                case 'courses':
                    initCoursesPage();
                    break;
                case 'departments':
                    initDepartmentsPage();
                    break;
                case 'degrees':
                    initDegreesPage();
                    break;
                case 'enrollments':
                    initEnrollmentsPage();
                    break;
                case 'exams':
                    initExamsPage();
                    break;
                default:
                    console.warn(`Entidad desconocida: ${entity}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            contentContainer.innerHTML = '<p>Error al cargar la vista.</p>';
        });
}
