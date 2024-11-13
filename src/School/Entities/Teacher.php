<?php

    /**
     * Clase Teacher, representa a un profesor en la escuela.
     * Hereda de User y utiliza el trait Timestampable para gestionar
     * marcas de tiempo. Puede asignarse a un departamento.
     */

    namespace App\School\Entities;

    use App\School\Trait\Timestampable;
    use App\School\Entities\User;
    use App\School\Entities\Department;

    class Teacher extends User {
        use Timestampable; // Agrega métodos para manejar marcas de tiempo.

        protected $department; // Departamento al que pertenece el profesor.

        /*
         * Constructor: Inicializa email y nombre, y actualiza marcas de tiempo.
         */
        function __construct($email, $name) {
            parent::__construct($email, $name); // Llama al constructor de User.
            $this->updateTimestamps(); // Establece createdAt y updatedAt.
        }

        /*
         * addToDepartment: Asigna el profesor a un departamento.
         */
        public function addToDepartment(Department $dept) {
            $this->department = $dept; // Asigna el departamento.
        }
    }
