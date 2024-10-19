<?php

function eliminar($id){
    //me conecto a la base de datos
    $db = new PDO('mysql:host=localhost;'.'dbname=gestion_turnos;charset=utf8', 'root', '');

    $query2 = $db->prepare('DELETE FROM `turnos` WHERE id = ?');
    $query2->execute([$id]);

//manejo de errores
echo "se elimino id:$id";
mostrarTabla();


}