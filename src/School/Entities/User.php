<?php

    /**
     * Clase abstracta User, representa a un usuario con propiedades 
     * básicas como email, nombre, contraseña y marcas de tiempo.
     */

    namespace App\School\Entities;

    abstract class User {
        const MYSCHOOL = "CEFPNutria"; // Constante con el nombre de la escuela.
        
        protected string $email = "test@test.com"; // Email del usuario, con un valor por defecto.
        protected string $name; // Nombre del usuario.
        protected string $password; // Contraseña del usuario.
        protected ?\DateTime $createdAt = null; // Fecha de creación.
        protected ?\DateTime $updatedAt = null; // Fecha de última actualización.

        /*
         * Constructor: Inicializa el email y el nombre del usuario.
         */
        function __construct($email, $name) {
            $this->email = $email; // Asigna el email.
            $this->name = $name; // Asigna el nombre.
        }

        /*
         * setEmail: Establece el email del usuario.
         */
        function setEmail(string $email) {
            $this->email = $email; // Asigna el email.
            return $this; // Permite encadenar métodos.
        }

        /*
         * getEmail: Retorna el email del usuario.
         */
        function getEmail() {
            return $this->email;
        }
    }
