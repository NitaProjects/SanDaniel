function loadContent(entity) {
    const contentContainer = document.getElementById('dynamic-content');

    // Asegúrate de que apunte al directorio correcto
    const viewPath = `/src/views/${entity}.view.php`;

    fetch(viewPath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar la vista');
            }
            return response.text(); 
        })
        .then(html => {
            contentContainer.innerHTML = html; 
        })
        .catch(error => {
            console.error('Error:', error);
            contentContainer.innerHTML = '<p>Error al cargar la vista.</p>';
        });
}

