<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//mostrar errores en pantalla


//require_once 'app/controller/Controller.php';
require_once 'libs/response.php';
require_once 'app/middlewares/session.auth.middleware.php';
require_once 'app/controller/Controller.php';
require_once 'app/controller/ControllerCliente.php';
require_once 'app/controller/auth.controller.php';


define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$res = new Response();

$action = 'listar';

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);


switch ($params[0]) {
    case 'formulario':

        sessionAuthMiddleware($res);
        $controller = new Controller($res);
        $controller->showForm();

        break;
    case 'listar':

        sessionAuthMiddleware($res); // Verifica que el usuario esté logueado y setea $res->user o redirige a login
        $controller = new Controller($res);
        $controller->showTurnos();
        break;

    case 'agregar':

        sessionAuthMiddleware($res);
        $controller = new Controller($res);
        $controller->addTurno();
        break;

    case 'eliminar':

        sessionAuthMiddleware($res);
        $controller = new Controller($res);
        $controller->deleteTurno($params[1]);
        break;
    case 'detalles':

        sessionAuthMiddleware($res);
        $controller = new Controller($res);
        $controller->detailTurno($params[1]);
        break;

        case 'detalle':

          
            $controller = new Controller($res);
            $controller->detailTurnosSinLog($params[1]);
            break;

    case 'editarT':

        $id = null;
        if (isset($params[1]))
            $id = $params[1];

        sessionAuthMiddleware($res);
        $controller = new Controller($res);
        $controller->editT($id);
        break;

    case 'editarTurno':

        $id = null;
        if (isset($params[1]))
            $id = $params[1];

        sessionAuthMiddleware($res);
        $controller = new Controller($res);
        $controller->editTurno($id);
        break;

    case 'completar':

        sessionAuthMiddleware($res);
        $controller = new Controller($res);
        $controller->finishTurno($params[1]);
        break;
    case 'showLogin':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;


        //clientes

    case 'clientes':
        sessionAuthMiddleware($res);
        $controller = new ControllerCliente($res);
        $controller->showClientes();

        break;
    case 'eliminarCliente':
        $id = null;
        if (isset($params[1]))
            $id = $params[1];

        sessionAuthMiddleware($res);
        $controller = new ControllerCliente($res);
        $controller->deleteCliente($id);

        break;
    case 'turnosClientes':
        $id = null;
        if (isset($params[1]))
            $id = $params[1];
        sessionAuthMiddleware($res);
        $controller = new ControllerCliente($res);
        $controller->turnosClientes($id);

        break;
    case 'turnosClientesSinLog':
        $id = null;
        if (isset($params[1]))
            $id = $params[1];
        
        $controller = new ControllerCliente($res);
        $controller->turnosClientesSinLog($id);

        break;  
    case 'agregarCliente':
        sessionAuthMiddleware($res);
        $controller = new ControllerCliente($res);
        $controller->addCliente();

        break;
    case 'formCliente':
        sessionAuthMiddleware($res);
        $controller = new ControllerCliente($res);
        $controller->formCliente();

        break;
    case 'editarCliente':
        sessionAuthMiddleware($res);
        $controller = new ControllerCliente($res);
        $controller->editCliente();

        break;
    case 'editar':
        if (isset($params[1]))
            $id = $params[1];

        sessionAuthMiddleware($res);
        $controller = new ControllerCliente($res);
        $controller->showEdit($id);

        break;
    case 'homeTurno':
        $controller = new Controller($res);
        $controller->showHomeTurno();;

        break;
        case 'homeCliente':
            $controller = new ControllerCliente($res);
            $controller->showHomeCliente();;
    
            break;
    default:
        echo ('404 Page not found');
        break;
}
