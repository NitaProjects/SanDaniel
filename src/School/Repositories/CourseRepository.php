<?php

    /**
     * Interfaz CourseRepository, define los métodos para gestionar cursos.
     * Proporciona una estructura para guardar y buscar cursos por ID.
     */

    namespace App\School\Repositories;
    use App\School\Entities\Course;

    interface CourseRepository {
        /*
         * save: Guarda un curso en el repositorio.
         */
        public function save(Course $course);

        /*
         * findById: Busca y devuelve un curso por su ID.
         */
        public function findById($id);
    }
