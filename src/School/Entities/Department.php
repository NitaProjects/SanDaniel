<?php 

    /**
     * Clase Department, representa un departamento en la escuela.
     * Contiene una propiedad para almacenar el nombre del departamento.
     */

    namespace App\School\Entities;

    class Department {
        protected $name; // Nombre del departamento.

        /*
         * Constructor: Inicializa el nombre del departamento.
         */
        function __construct($name) {
            $this->name = $name; // Asigna el nombre al departamento.
        }
    }
