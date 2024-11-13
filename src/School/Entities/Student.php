<?php

    /**
     * Clase Student, representa a un estudiante en la escuela.
     * Hereda de User y usa el trait Timestampable para gestionar marcas de tiempo.
     * Contiene una lista de inscripciones y muestra el nombre de la escuela.
     */

    namespace App\School\Entities;

    use App\School\Entities\User;
    use App\School\Trait\Timestampable;

    class Student extends User {
        use Timestampable; // Agrega métodos para manejar marcas de tiempo.

        protected $enrollments = []; // Array para almacenar las inscripciones del estudiante.

        /*
         * showSchool: Muestra el nombre de la escuela (constante MYSCHOOL de User).
         */
        public function showSchool() {
            echo parent::MYSCHOOL; // Muestra el valor de la constante MYSCHOOL.
        }

        /*
         * Constructor: Inicializa marcas de tiempo para el estudiante.
         */
        function __construct($email, $name) {
            parent::__construct($email, $name); // Llama al constructor de User.
            $this->updateTimestamps(); // Establece createdAt y updatedAt.
        }
    }
