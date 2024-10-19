
   <?php

function mostrarTabla(){
    
    $db = new PDO('mysql:host=localhost;'.'dbname=gestion_turnos;charset=utf8', 'root', '');
    
        $query = $db->prepare('SELECT * FROM turnos');
        $query->execute();
        $turnos = $query->fetchAll(PDO::FETCH_OBJ);
    
        // Crear la tabla HTML
        echo "<table border='1'>";
        echo "<tr><th>ID turno</th><th>id cliente</th><th>Fecha de turno</th><th>Hora de turno</th></tr>";
        foreach ($turnos as $turno) {
            echo "<tr>";
            echo "<td>" . $turno -> id_turno."</td>";
            echo "<td>" . $turno->id_cliente."</td>";
            echo "<td>" . $turno->fecha_turno. "</td>";
            echo "<td>" . $turno->hora_turno. "</td>";
            echo "</tr>";
        }

        // Cerrar la tabla HTML
        echo "</table>";
    
     
}
