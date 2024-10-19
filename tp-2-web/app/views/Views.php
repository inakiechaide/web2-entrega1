<?php

class TaskView
{
    private $user = null;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function showTurnos($turnos)
    {
        $count = count($turnos);

        require 'templates/lista_turnos.phtml';
    }

    public function showForm($clientes)
    {
        require 'templates/formulario.phtml';
    }

    public function showError($error)
    {
        require 'templates/error.phtml';
    }


    ////cliente

    public function showClientes($clientes)
    {

        require 'templates/clientes.phtml';
    }

    public function turnosClientes($turnos)
    {
    
        $count = count($turnos);

        require 'templates/turnoCliente.phtml';
    }
    public function turnosClientesSinLog($turnos)
    {
    
        $count = count($turnos);

        require 'templates/turnoClienteSinLog.phtml';
    }
    public function clienteCargado($clientes)
    {
        require 'templates/clientes.phtml';
    }
    public function formCliente()
    {
        require 'templates/nuevoCliente.phtml';
    }
    public function showEdit($cliente)
    {
        require 'templates/editarCliente.phtml';
    }

    public function showEditTurno($turno)
    {
        require 'templates/editarTurno.phtml';
    }
    public function showDetalle($turno)
    {
        require 'templates/turno_detalles.phtml';
    }
    public function showDetalleSinLog($turno)
    {
        require 'templates/turno_detallE.phtml';
    }
    public function ShowHomeTurno ($clientes , $turnos){
        require 'templates/homeTurno.phtml';
    }
    public function ShowHomeCliente ($clientes , $turnos){
        require 'templates/homeCliente.phtml';
    }
}
