<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $direccion = new Direccion();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($direccion->crearMatriz($direccion->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $direccion->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $direccion->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'mensaje' => 'El ID del registro es incorrecto.');
        $direccion = new Direccion(
            $_POST['id'],
            (isset($_POST['usuario_id'])) ? (new Usuario())->obtener($_POST['usuario_id']) : new Usuario(),
            (isset($_POST['institucion_id'])) ? (new Institucion())->obtener($_POST['institucion_id']) : new Institucion(),
            $_POST['direccion'],
            $_POST['codigo_postal'],
            $_POST['localidad'],
            $_POST['provincia'],
            (new Pais())->obtener($_POST['pais_id'])
        );
        if ($_GET['operacion'] == 'insertar'){
            $direccion->insertar();
            $respuesta['id'] = $direccion->getId();
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }else{
            $direccion->actualizar();
            $respuesta['id'] = $direccion->getId();
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
	}

?>