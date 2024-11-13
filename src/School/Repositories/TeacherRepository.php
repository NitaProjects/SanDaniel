<?php 

    /**
     * Interfaz TeacherRepository, define los métodos para gestionar profesores.
     * Proporciona una estructura para guardar y buscar profesores por ID.
     */

    namespace App\School\Repositories;

    use App\School\Entities\Teacher;

    interface TeacherRepository {
        /*
         * save: Guarda un profesor en el repositorio.
         */
        public function save(Teacher $teacher);

        /*
         * findById: Busca y devuelve un profesor por su ID.
         */
        public function findById($id);
    }
