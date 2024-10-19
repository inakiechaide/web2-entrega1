<?php
require_once __DIR__ . '/../models/Models.php';
require_once __DIR__ . '/../models/ModelsCliente.php';
require_once __DIR__ . '/../views/Views.php';



class ControllerCliente
{
    private $modelCliente;
    private $model;
    private $view;

    public function __construct($res)
    {
        $this->model = new TaskModel();
        $this->modelCliente = new TaskModelCliente();
        $this->view = new TaskView($res->user);
    }

    function showClientes()        //cliente por mati
    {
        $clientes = $this->modelCliente->getClientes();


        foreach ($clientes as $cliente) {

            return $this->view->showClientes($clientes);
        }
    }

    function formCliente()
    {
        return $this->view->formCliente();
    }


    public function showEdit($id_cliente)
    {
        // Obtener los datos del cliente por su ID desde el modelo
        $cliente = $this->modelCliente->getClientePorId($id_cliente);

        // Verificar si el cliente existe
        if ($cliente) {
            // Pasar el cliente a la vista para que lo muestre
            $this->view->showEdit($cliente);
        } else {
            echo "Cliente no encontrado";
        }
    }

    public function deleteCliente($id)
    {
        // obtengo la Cliente por id
        $cliente = $this->modelCliente->getClientes($id);

        if (!$cliente) {
            return $this->view->showError("No existe el turno con el id=$id");
        }

        // borro el Cliente y redirijo
        $this->modelCliente->deleteCliente($id);

        $clientes = $this->modelCliente->getClientes();

        return $this->view->showClientes($clientes);
    }

    public function turnosClientes($id)
    {

        $turnos = $this->modelCliente->getTurnosClientes($id);


        foreach ($turnos as $turno) {
            //agarro id cliente del turno
            $id_cliente = $turno->id_cliente;

            // Ome quedo con el arreglo del cliente
            $cliente = $this->model->clienteExist($id_cliente);

            // Si se encuentra el cliente, agrega el nombre al objeto turno
            if ($cliente) {
                $turno->nombre_cliente = $cliente['nombre'];
            } else {
                // Si no  encuentra el cliente
                $turno->nombre_cliente = 'Cliente no encontrado';
            }
        }
        // paso el areglo turno con el nombre agregado
        return $this->view->turnosClientes($turnos);
    }

    public function turnosClientesSinLog($id)
    {

        $turnos = $this->modelCliente->getTurnosClientes($id);


        foreach ($turnos as $turno) {
            //agarro id cliente del turno
            $id_cliente = $turno->id_cliente;

            // Ome quedo con el arreglo del cliente
            $cliente = $this->model->clienteExist($id_cliente);

            // Si se encuentra el cliente, agrega el nombre al objeto turno
            if ($cliente) {
                $turno->nombre_cliente = $cliente['nombre'];
            } else {
                // Si no  encuentra el cliente
                $turno->nombre_cliente = 'Cliente no encontrado';
            }
        }
        // paso el areglo turno con el nombre agregado
        return $this->view->turnosClientesSinLog($turnos);
    }

    public function addCliente()
    {

        if (!isset($_POST["nombre"]) || empty($_POST["nombre"])) {
            return $this->view->showError('Falta completar la fecha del turno');
        }
        if (!isset($_POST["telefono"]) || empty($_POST["telefono"])) {
            return $this->view->showError('Falta completar la hora del turno');
        }
        if (!isset($_POST["email"]) || empty($_POST["email"])) {
            return $this->view->showError('Falta completar la hora del turno');
        }

        $id_cliente = NULL;
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];

        $foto = null; // Inicializamos la variable de la foto como null por si no se sube una

        // Manejo de la subida de la foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $directorioSubida = 'uploads/'; // Carpeta de destino
            $nombreArchivo = basename($_FILES['foto']['name']);
            $rutaDestino = $directorioSubida . $nombreArchivo;

            // Intentar mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                $foto = $rutaDestino; // Guardar la ruta de la foto
            } else {
                return $this->view->showError('Error al subir la foto. Verifique los permisos de la carpeta.');
            }
        }


        $id = $this->modelCliente->addCliente($nombre, $telefono, $email, $id_cliente, $foto);

        $clientes = $this->modelCliente->getClientes();

        return $this->view->showClientes($clientes);
    }

    public function editCliente()
    {
        //if (!isset($_POST["id_cliente"]) || empty($_POST["id_cliente"])) {
          //  return $this->view->showError('Falta completar el id del cliente');
        //}
        if (!isset($_POST["nombre"]) || empty($_POST["nombre"])) {
            return $this->view->showError('Falta completar la fecha del turno');
        }
        if (!isset($_POST["telefono"]) || empty($_POST["telefono"])) {
            return $this->view->showError('Falta completar la hora del turno');
        }
        if (!isset($_POST["email"]) || empty($_POST["email"])) {
            return $this->view->showError('Falta completar la hora del turno');
        }

        // Obtener los datos del formulario
        $id_cliente = $_POST['id_cliente'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];

        // Actualizar el cliente en la base de datos
        $this->modelCliente->updateCliente($id_cliente, $nombre, $telefono, $email);


        $clientes = $this->modelCliente->getClientes();

        return $this->view->showClientes($clientes);
    }

    public function showHomeCliente (){
        $clientes = $this->modelCliente->getClientes();
        
        $turnos = $this->model->getTurnos();
        foreach ($turnos as $turno) {
            $id_cliente = $turno->id_cliente;
            $cliente = $this->model->clienteExist($id_cliente);

            // Si se encuentra el cliente, agrego el nombre al objeto turno
            if ($cliente) {
                $turno->nombre_cliente = $cliente['nombre'];
                $turno->foto_cliente = $cliente['foto'];
            } else {
                // Si no  encuentra el cliente
                return $this->view->showError('El cliente no encontrado.');
            }

            usort($turnos, function ($a, $b) {
                $fechaA = strtotime($a->fecha_turno . ' ' . $a->hora_turno);
                $fechaB = strtotime($b->fecha_turno . ' ' . $b->hora_turno);
                return $fechaB - $fechaA; // descendente (más recientes primero)
            });
       
       
          }
    return $this->view->showHomeCliente($clientes,$turnos);
}
}