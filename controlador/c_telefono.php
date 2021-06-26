<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $telefono = new Telefono();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($telefono->crearMatriz($telefono->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $telefono->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $telefono->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'mensaje' => 'El ID del registro es incorrecto.');
        $telefono = new Telefono(
            $_POST['id'],
            (isset($_POST['usuario_id'])) ? (new Usuario())->obtener($_POST['usuario_id']) : new Usuario(),
            (isset($_POST['institucion_id'])) ? (new Institucion())->obtener($_POST['institucion_id']) : new Institucion(),
            $_POST['telefono_tipo'],
            $_POST['telefono_prefijo'],
            $_POST['telefono_numero']
        );
        if ($_GET['operacion'] == 'insertar'){
            $telefono->insertar();
            $respuesta['id'] = $telefono->getId();
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }else{
            $telefono->actualizar();
            $respuesta['id'] = $telefono->getId();
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'eliminar') {
        if($_POST['id'] > 0){
            $telefono->eliminar($_POST['id']);
            echo json_encode(array('estado' => 'Los datos se eliminaron satisfactoriamente.'));
        }
	}

?>

