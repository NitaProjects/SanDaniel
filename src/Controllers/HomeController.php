<?php 

    /**
     * Controlador principal de la aplicación, maneja las acciones de la página de inicio y profesores.
     */

    namespace App\Controllers;

    class HomeController {

        /*
         * index: Muestra la vista de inicio.
         * Prepara los datos necesarios y llama a la vista 'home'.
         */
        function index() {
            $data = ['name' => 'Colegio San Daniel']; // Datos a pasar a la vista.
            echo view('home', $data); // Carga y muestra la vista 'home' con los datos.
        }

        /*
         * teachers: Muestra un mensaje de texto sobre los profesores.
         */
        function teachers() {
            echo 'teachers'; // Muestra el texto 'teachers'.
        }
    }
