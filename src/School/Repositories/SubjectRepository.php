<?php

    /**
     * Interfaz SubjectRepository, define los métodos para gestionar materias.
     * Proporciona una estructura para guardar y buscar materias por ID.
     */

    namespace App\School\Repositories;
    use App\School\Entities\Subject;

    interface SubjectRepository {
        /*
         * save: Guarda una materia en el repositorio.
         */
        public function save(Subject $subject);

        /*
         * findById: Busca y devuelve una materia por su ID.
         */
        public function findById($id);
    }
