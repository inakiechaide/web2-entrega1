<?php 

function agregar(){
   require_once"templates/formulario.php";

//me conecto a la base de datos gestion_turnos
$db = new PDO('mysql:host=localhost;'.'dbname=gestion_turnos;charset=utf8', 'root', '');

// abro la consola de sql y le hago un insert en la tabla pagos y todos los parametros
if (isset($_POST["nombre_cliente"]) &&  $_POST["fecha_turno"]&&  $_POST["hora_turno"]) {
    $deudor = $_POST["nombre_cliente"]; //falta conseguir id_cliente pedir nombre getId();
   
    $fecha_turno= $_POST["fecha_turno"];
    $hora_turno= $_POST["hora_turno"];
    $id_cliente=1; //provisorio mando constante

    $query2 = $db->prepare('INSERT INTO `turnos`(`id_cliente`,`fecha_turno`,`hora_turno`)
                                VALUES (?,?,?)');


//ejecuta el comando
$query2->execute([$id_cliente,$fecha_turno,$hora_turno]);
}

mostrarTabla();
 
}

    

