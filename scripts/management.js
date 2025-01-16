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

            // Inicializa scripts dinámicos
            if (entity === 'users') {
                initUsersPage(); 
            }
        })
        .catch(error => {
            console.error('Error:', error);
            contentContainer.innerHTML = '<p>Error al cargar la vista.</p>';
        });
}
