<?php

    /**
     * Funciones auxiliares para depuración y carga de vistas.
     */

    /*Es una función de depuración que imprime el contenido de uno 
    o más argumentos de manera legible y luego detiene el script.
    */
    function dd(){
        // Recorre todos los argumentos que recibe la función.
        foreach(func_get_args() as $arg){
            echo "<pre>"; // Inicia el formato preformateado para una mejor legibilidad.
            var_dump($arg); // Muestra el contenido detallado de cada argumento.
            echo "</pre>"; // Cierra el formato preformateado.
        }
        die; // Detiene la ejecución del script.
    }

    /*Carga una vista (archivo de plantilla) y, si hay datos, los convierte en variables dentro de la vista. 
    Devuelve el contenido de la vista como un string.
    */
    function view($template, $data = null){
        // Si hay datos, los convierte en variables individuales.
        if($data){
            extract($data, EXTR_OVERWRITE); // Convierte el array en variables.
        }
        ob_start(); // Inicia el almacenamiento en buffer.
        require VIEWS . '/' . $template . '.view.php'; // Carga la vista.
        return ob_get_clean(); // Devuelve el contenido del buffer y limpia el buffer.
    }

