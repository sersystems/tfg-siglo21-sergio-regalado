<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $clase = new Clase();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($clase->crearMatriz($clase->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $clase->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $clase->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'estado' => 'El ID del registro es incorrecto.');
        $clase = new Clase(
            $_POST['id'],
            (new Taller())->obtener($_POST['taller_id']),
            $_POST['titulo'],
            $_POST['numero'],
            $_POST['fecha'],
            $_POST['horario'],
            $_POST['duracion'],
            $_POST['estado']
        );
        if ($_GET['operacion'] == 'insertar'){
            $clase->insertar();
            $respuesta['id'] = $clase->getId();
            $respuesta['estado'] = 'Los datos se registraron satisfactoriamente.';
        }else{
            $clase->actualizar();
            $respuesta['id'] = $clase->getId();
            $respuesta['estado'] = 'Los datos se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'eliminar') {
        if($_POST['id'] > 0){
            $clase->eliminar($_POST['id']);
            echo json_encode(array('estado' => 'Los datos se eliminaron satisfactoriamente.'));
        }
	}

?>

