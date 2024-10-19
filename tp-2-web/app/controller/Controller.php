<?php
require_once __DIR__ . '/../models/ModelsCliente.php';
require_once __DIR__ . '/../models/Models.php';
require_once __DIR__ . '/../views/Views.php';


class Controller
{
    private $model;
    private $view;
    private $modelCliente;

    public function __construct($res)
    {
        $this->model = new TaskModel();
        $this->modelCliente = new TaskModelCliente();
        $this->view = new TaskView($res->user);
    }

    public function showTurnos()
    {
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
        }

        // Ordenar los turnos por fecha (y hora si es necesario)
        usort($turnos, function ($a, $b) {
            $fechaA = strtotime($a->fecha_turno . ' ' . $a->hora_turno);
            $fechaB = strtotime($b->fecha_turno . ' ' . $b->hora_turno);
            return $fechaB - $fechaA; // descendente (más recientes primero)
        });

        // paso el areglo turno con el nombre agregado
        return $this->view->showTurnos($turnos);
    }


    function showForm()
    {
        $clientes = $this->modelCliente->getClientesSelect();

        return $this->view->showForm($clientes);
    }



    public function addTurno()
    {

        if (!isset($_POST["id_cliente"]) || empty($_POST["id_cliente"])) {
            return $this->view->showError('Falta completar el id del cliente');
        }
        if (!isset($_POST["fecha_turno"]) || empty($_POST["fecha_turno"])) {
            return $this->view->showError('Falta completar la fecha del turno');
        }
        if (!isset($_POST["hora_turno"]) || empty($_POST["hora_turno"])) {
            return $this->view->showError('Falta completar la hora del turno');
        }

        $id_cliente = $_POST["id_cliente"];
        $fecha_turno = $_POST["fecha_turno"];
        $hora_turno = $_POST["hora_turno"];

        // Verifico si el cliente existe
        if (!$this->model->clienteExist($id_cliente)) {
            return $this->view->showError('El cliente con ID ' . $id_cliente . ' no existe.');
        }
        // Verifico si ya existe un turno en la misma fecha y hora
        if ($this->model->turnoExist($fecha_turno, $hora_turno)) {
            return $this->view->showError('Ya existe un turno en la fecha ' . $fecha_turno . ' a las ' . $hora_turno . '.');
        }

        $id = $this->model->addTurno($fecha_turno, $hora_turno, $id_cliente);

        header('Location: ' . BASE_URL);
    }


    public function deleteTurno($id)
    {
        $turno = $this->model->getTurnos($id);

        if (!$turno) {
            return $this->view->showError("No existe el turno con el id=$id");
        }

        $this->model->deleteTurno($id);

        header('Location: ' . BASE_URL);
    }

    public function detailTurno($id_turno)
    {
        $turno = $this->model->getTurnoId($id_turno);

        $id_cliente = $turno->id_cliente;
            $cliente = $this->model->clienteExist($id_cliente);

            if ($cliente) {
                $turno->nombre_cliente = $cliente['nombre'];
                $turno->foto_cliente = $cliente['foto'];
            } else {
                return $this->view->showError('Cliente no encontrado');
            }

        if ($turno) {
            $this->view->showDetalle($turno);
        } else {
            return $this->view->showError("No encontrado el turno con el id=$id_turno");
        }
    }
    public function detailTurnosSinLog($id_turno)
    {
        $turno = $this->model->getTurnoId($id_turno);
        
        $id_cliente = $turno->id_cliente;
            $cliente = $this->model->clienteExist($id_cliente);

            if ($cliente) {
                $turno->nombre_cliente = $cliente['nombre'];
                $turno->foto_cliente = $cliente['foto'];
            } else {
                return $this->view->showError('Cliente no encontrado');
            }

        if ($turno) {
            $this->view->showDetalleSinLog($turno);
        } else {
            return $this->view->showError("No encontrado el turno con el id=$id_turno");
        }
    }

    public function finishTurno($id)
    {
        $turno = $this->model->getTurnos($id);

        if (!$turno) {
            return $this->view->showError("No existe el turno con el id=$id");
        }

        $this->model->finishTurno($id);

        header('Location: ' . BASE_URL);
    }
    public function editT($id_turno)
    {
        $turno = $this->model->getTurnoId($id_turno);

        if ($turno) {
            $this->view->ShowEditTurno($turno);
        } else {
            return $this->view->showError("No encontrado el turno con el id=$id_turno");
        }
    }

    public function editTurno()
    {
        if (!isset($_POST["id_turno"]) || empty($_POST["id_turno"])) {
            return $this->view->showError('Falta completar la fecha del turno');
        }

        if (!isset($_POST["fecha_turno"]) || empty($_POST["fecha_turno"])) {
            return $this->view->showError('Falta completar la fecha del turno');
        }
        if (!isset($_POST["hora_turno"]) || empty($_POST["hora_turno"])) {
            return $this->view->showError('Falta completar la hora del turno');
        }

        $id_turno = $_POST["id_turno"];
        $fecha_turno = $_POST["fecha_turno"];
        $hora_turno = $_POST["hora_turno"];
        $finalizado=0;

        $this->model->updateTurno($id_turno, $fecha_turno, $hora_turno, $finalizado);

        $turnos = $this->model->getTurnos();

        foreach ($turnos as $turno) {
            $id_cliente = $turno->id_cliente;
            $cliente = $this->model->clienteExist($id_cliente);

            if ($cliente) {
                $turno->nombre_cliente = $cliente['nombre'];
                $turno->foto_cliente = $cliente['foto'];
            } else {
                return $this->view->showError('Cliente no encontrado');
            }
        }

        // Ordenar los turnos por fecha (y hora si es necesario)
        usort($turnos, function ($a, $b) {
            $fechaA = strtotime($a->fecha_turno . ' ' . $a->hora_turno);
            $fechaB = strtotime($b->fecha_turno . ' ' . $b->hora_turno);
            return $fechaB - $fechaA; // descendente (más recientes primero)
        });

        return $this->view->showTurnos($turnos);
    }
    public function showHomeTurno (){
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
    return $this->view->showHomeTurno($clientes,$turnos);
}


}



/////
