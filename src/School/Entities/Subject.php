<?php

    /**
     * Clase Subject, representa una materia en la escuela.
     * Tiene propiedades para el nombre de la materia y el curso al que pertenece.
     */

    namespace App\School\Entities;

    use App\School\Entities\Course;

    class Subject {
        protected string $name; // Nombre de la materia.
        protected Course $course; // Curso al que pertenece la materia.

        /*
         * Constructor: Inicializa el nombre de la materia.
         */
        function __construct(string $name) {
            $this->name = $name; // Asigna el nombre de la materia.
        }
    }
