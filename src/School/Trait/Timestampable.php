<?php

    /**
     * Trait Timestampable para gestionar marcas de tiempo en entidades.
     * Proporciona una función para actualizar las propiedades de 
     * creación y última modificación.
     */

    namespace App\School\Trait;

    trait Timestampable {

        /*
         * updateTimestamps: Actualiza las propiedades de tiempo.
         * Si la entidad no tiene fecha de creación, la establece.
         * Siempre actualiza la fecha de última modificación.
         */
        public function updateTimestamps() {
            $now = new \DateTime(); // Obtiene la fecha y hora actuales.
            $this->updatedAt = $now; // Establece la fecha de última modificación.
            
            // Establece la fecha de creación solo si no está definida.
            if (!$this->createdAt) {
                $this->createdAt = $now;
            }
        }
    }
