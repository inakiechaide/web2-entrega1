<?php
function completar($id){

    require_once"templates/formulario.php";

    //tomo los datos del formulario con un post y los guardo cada uno en su variable 
    
    //me conecto a la base de datos registrar-pagos-de-deudas
    $db = new PDO('mysql:host=localhost;'.'dbname=gestion_turnos;charset=utf8', 'root', '');
  // abro la consola de sql y le hago un insert en la tabla pagos y todos los parametros


if (isset($_POST["nombre_cliente"]) &&  $_POST["fecha_turno"]&&  $_POST["hora_turno"]) {
    $deudor = $_POST["nombre_cliente"]; //falta conseguir id_cliente pedir nombre getId();
   
    $fecha_turno= $_POST["fecha_turno"];
    $hora_turno= $_POST["hora_turno"];
    $id_cliente=1; //provisorio mando constante
        $query2 = $db->prepare('UPDATE `turnos` SET  hora_turno =?, fecha_turno = ? WHERE id = ?');

                                
        $query2->execute([$fecha_turno,$hora_turno, $id]);
    
    //intente meter las variables d elos parametros get en el values pero no funciono
    
    //ejecuta el comando
 
    }
    
    
     
    
    mostrarTabla();


}