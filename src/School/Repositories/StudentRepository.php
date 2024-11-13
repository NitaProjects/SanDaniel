<?php 

    /**
     * Interfaz StudentRepository, define los métodos para gestionar estudiantes.
     * Proporciona una estructura para guardar y buscar estudiantes por ID.
     */

    namespace App\School\Repositories;

    use App\School\Entities\Student;
    
    interface StudentRepository {
        /*
         * save: Guarda un estudiante en el repositorio.
         */
        public function save(Student $student);

        /*
         * findById: Busca y devuelve un estudiante por su ID.
         */
        public function findById($id);
    }
