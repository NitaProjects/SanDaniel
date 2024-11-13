<?php 

    /**
     * Clase Course, representa un curso en la escuela.
     * Contiene propiedades para almacenar el nombre del curso y una lista de materias.
     */

    namespace App\School\Entities;
    use App\School\Entities\Subject;

    class Course {
        protected $name; // Nombre del curso.
        protected $subjects = []; // Array para almacenar las materias asociadas al curso.

        /*
         * Constructor: Inicializa el nombre del curso.
         */
        function __construct(string $name) {
            $this->name = $name; // Asigna el nombre al curso.
        }

        /*
         * addSubject: Agrega una materia (Subject) al curso.
         */
        function addSubject(Subject $subject) {
            $this->subjects[] = $subject; // Añade la materia al array de materias.
            return $this; // Permite encadenar métodos.
        }
    }
