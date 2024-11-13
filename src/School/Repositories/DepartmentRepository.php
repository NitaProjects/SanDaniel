<?php

    /**
     * Interfaz DepartmentRepository, define los métodos para gestionar departamentos.
     * Proporciona una estructura para guardar y buscar departamentos por ID.
     */

    namespace App\School\Repositories;
    use App\School\Entities\Department;

    interface DepartmentRepository {
        /*
         * save: Guarda un departamento en el repositorio.
         */
        public function save(Department $department);

        /*
         * findById: Busca y devuelve un departamento por su ID.
         */
        public function findById($id);
    }
