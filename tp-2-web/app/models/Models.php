<?php

require_once 'app/models/Model.php';

class TaskModel extends Model
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

    function getTurnos()
    {
        $db = $this->conectarBd();
        $query = $db->prepare('SELECT * FROM turnos');
        $query->execute();

        $turnos = $query->fetchAll(PDO::FETCH_OBJ);
        return $turnos;
    }
    public function getTurnoId($id_turno)
    {
       
        $query = $this->db->prepare("SELECT * FROM turnos WHERE id_turno = ?");
        $query->execute([$id_turno]);
        return $query->fetch(PDO::FETCH_OBJ); // Asegúrate de que esto retorne el objeto correctamente
    }
    public function clienteExist($id_cliente)
    {

        $query = $this->db->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
        $query->execute([$id_cliente]);

        $cliente = $query->fetch(PDO::FETCH_ASSOC); //arreglo con los datos del cliente
        if ($cliente) {
            return $cliente; // Devuelve el array con la información del cliente si existe
        } else {
            return false; // Si no encuentra el cliente, devuelve false
        }
    }

    public function turnoExist($fecha_turno, $hora_turno)
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM turnos WHERE fecha_turno = ? AND hora_turno = ?");
        $query->execute([$fecha_turno, $hora_turno]);

        $existe = $query->fetchColumn(); // Obtener solo el conteo
        return $existe > 0; // Retorna true si existe al menos un turno
    }


    public function addTurno($fecha_turno, $hora_turno, $id_cliente)
    {
        $query = $this->db->prepare('INSERT INTO `turnos`(`fecha_turno`,`hora_turno`,`id_cliente`) VALUES (?, ?,?)');
        $query->execute([$fecha_turno, $hora_turno, $id_cliente]);

        $id = $this->db->lastInsertId();

        return $id;
    }

    public function deleteTurno($id)
    {
        $query = $this->db->prepare('DELETE FROM turnos WHERE id_turno = ?');
        $query->execute([$id]);
    }

    public function finishTurno($id)
    {
        $query = $this->db->prepare('UPDATE turnos SET finalizado = 1 WHERE id_turno = ?');
        $query->execute([$id]);
    }


    public function updateTurno($id_turno, $fecha_turno, $hora_turno, $finalizado)
    {
        $query = $this->db->prepare('UPDATE turnos SET fecha_turno = ?, hora_turno = ?, finalizado=? WHERE id_turno = ?');
        $query->execute([$fecha_turno, $hora_turno, $finalizado, $id_turno]);
    }



}
