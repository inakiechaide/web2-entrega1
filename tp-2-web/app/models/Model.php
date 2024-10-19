<?php

// Constantes de conexión a la base de datos
const MYSQL_USER = 'root';
const MYSQL_PASS = '';
const MYSQL_DB = 'gestion_turnos';
const MYSQL_HOST = 'localhost';

class Model {
    protected $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=".MYSQL_HOST.";charset=utf8", 
            MYSQL_USER, MYSQL_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // Modo de errores a excepciones
        );
        $this->deploy();
    }

    private function deploy() {
        $user_admin = '$2y$10$Xxy87ae1/GhzUWqfX6FanOPneJlBr/Lk306/1fPCd7h.9O1AHi3ey'; // Hash de contraseña admin
        $password = '$2y$10$ChL0oFh99tZDrEnJgRLGCe4lMrG3Od.Vna4XOFamuSzyd7dbWxey6';  // Otro hash de contraseña

        // Creando la base de datos si no existe
        $db_name = MYSQL_DB;
        $this->db->exec("CREATE DATABASE IF NOT EXISTS `$db_name`");

        // Reconectar a la base de datos ya creada
        $this->db->exec("USE `$db_name`");

        // Verificar si las tablas ya existen
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();

        if (count($tables) == 0) {
            $sql = <<<SQL
CREATE TABLE `usuario` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(250) NOT NULL,
    `password` char(60) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Insertar usuarios por defecto
INSERT INTO `usuario` (`email`, `password`) VALUES
('webadmin', '$user_admin'),
('inaki@hola.com', '$password');

-- Crear tabla clientes
CREATE TABLE `clientes` (
    `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(255) NOT NULL,
    `telefono` varchar(50) NOT NULL,
    `email` varchar(255) NOT NULL,
    `foto` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Insertar clientes por defecto
INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `email`, `foto`) VALUES
(2, 'Juan García', '987654321', 'juan@mail.com', NULL),
(23, 'jjaass', '232322', 'ajnsajnasj@ansjsns.com', NULL),
(44, 'jaj', '1122', 'ajaj@jaja.com', 'uploads/_DSC5415.jpg'),
(63, 'anasnas', '1212', 'jansjnas@jnansjas.com', NULL),
(67, 'anasnas', '1212', 'jansjnas@jnansjas.com', NULL),
(233, 'jjaass', '232322', 'ajnsajnasj@ansjsns.com', NULL),
(321, 'juanchi', '12222', '122@jaja.com', 'uploads/marian2.jpeg');

-- Crear tabla turnos
CREATE TABLE `turnos` (
    `id_turno` int(11) NOT NULL AUTO_INCREMENT,
    `id_cliente` int(11) NOT NULL,
    `fecha_turno` date NOT NULL,
    `hora_turno` time NOT NULL,
    `finalizado` tinyint(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id_turno`),
    FOREIGN KEY (`id_cliente`) REFERENCES `clientes`(`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Insertar turnos por defecto
INSERT INTO `turnos` (`id_turno`, `id_cliente`, `fecha_turno`, `hora_turno`, `finalizado`) VALUES
(45, 2, '2024-10-10', '03:03:00', 0),
(53, 23, '2024-10-03', '11:11:00', 0),
(54, 44, '2024-10-10', '03:03:00', 0);
SQL;

            // Ejecutamos el SQL para crear las tablas y agregar datos iniciales
            $this->db->exec($sql);
        }
    }
}


