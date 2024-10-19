<?php

require_once 'app/models/Model.php';
class TaskModelCliente extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function conectarBd()
    {
        $db = new PDO('mysql:host=localhost;' . 'dbname=gestion_turnos;charset=utf8', 'root', '');
        return $db;
    }
    function getClientesSelect()      
    {
        $query = "SELECT id_cliente, nombre FROM clientes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getClientes()     
    {
        $db = $this->conectarBd();
        $query = $db->prepare('SELECT * FROM clientes');
        $query->execute();

        $clientes = $query->fetchAll(PDO::FETCH_OBJ);
        return $clientes;
    }


    public function deleteCliente($id_cliente)
    {
        // Primero eliminar los turnos relacionados
        $query = "DELETE FROM turnos WHERE id_cliente = :id_cliente";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id_cliente' => $id_cliente]);

        // Luego eliminar el cliente
        $query = "DELETE FROM clientes WHERE id_cliente = :id_cliente";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id_cliente' => $id_cliente]);
    }

    function getTurnosClientes($id_cliente)
    {
        $db = $this->conectarBd();
        $query = $db->prepare('SELECT * FROM turnos WHERE id_cliente = :id_cliente');
        $query->execute([':id_cliente' => $id_cliente]);

        $turnos = $query->fetchAll(PDO::FETCH_OBJ);
        return $turnos;
    }

    public function addCliente($nombre, $telefono, $email, $id_cliente, $foto)
    {
       
        $query = $this->db->prepare('INSERT INTO clientes(nombre,telefono, email, id_cliente, foto) VALUES (?, ?,?, ?,?)');
        $query->execute([$nombre, $telefono, $email, $id_cliente, $foto]);

        $id = $this->db->lastInsertId();

        return $id;
    }

    public function updateCliente($id_cliente, $nombre, $telefono, $email)
    {
        $query = "UPDATE clientes SET nombre = :nombre, telefono = :telefono, email = :email WHERE id_cliente = :id_cliente";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id_cliente' => $id_cliente,
            ':nombre' => $nombre,
            ':telefono' => $telefono,
            ':email' => $email
        ]);
    }

    public function getClientePorId($id_cliente)
    {
        $query = "SELECT * FROM clientes WHERE id_cliente = :id_cliente";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id_cliente' => $id_cliente]);
        return $stmt->fetch(PDO::FETCH_OBJ); // Retorna el cliente como objeto
    }


}