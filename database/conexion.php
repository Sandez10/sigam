<?php
// conexion.php

require_once 'config.php';

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $this->connection = new mysqli(
            DB_HOST, 
            DB_USERNAME, 
            DB_PASSWORD, 
            DB_DATABASE
        );
        
        if ($this->connection->connect_error) {
            error_log("Error de conexión: " . $this->connection->connect_error);
            
            if (ENVIRONMENT === 'development') {
                die("Error de conexión: " . $this->connection->connect_error);
            } else {
                die("Error al conectar con el servidor");
            }
        }
        
        $this->connection->set_charset(DB_CHARSET);
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Uso:
// $db = Database::getInstance();
// $conn = $db->getConnection();