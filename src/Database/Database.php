<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {

    private $pdo;

    public function __construct(){
        
        // Cargar la configuración de la base de datos desde config.php
        $config = require __DIR__ . '/../../config/config.php';


        // Crear la DSN (Data Source Name) para la conexión
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";

        try {
            // Crear una nueva instancia de PDO
            $this->pdo = new PDO($dsn, $config['username'], $config['password']);
            // Configurar PDO para que lance excepciones en caso de error
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Manejo de errores de conexión
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Método para obtener la instancia de PDO
    public function getConnection(){
        return $this->pdo;
    }
}
