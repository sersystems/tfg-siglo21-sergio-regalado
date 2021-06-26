<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $contrasenia = new Contrasenia();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($contrasenia->crearMatriz($contrasenia->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $contrasenia->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $contrasenia->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'mensaje' => 'El ID del registro es incorrecto.');
        $comprobacion = Cfg::comprobarContrasenia($_POST['contrasenia']);
        if ($comprobacion['estado']) {
            $contrasenia = new Contrasenia(
                $_POST['id'],
                (new Usuario())->obtener($_POST['usuario_id']),
                Cfg::encriptarContrasenia($_POST['contrasenia'], $_POST['hash_original']),
                "", //fecha_creacion: Se auto-asignan en la BD.
                ""  //fecha modificacion: Se auto-asignan en la BD.
            );
            if ($_GET['operacion'] == 'insertar'){
                $contrasenia->insertar();
                $respuesta['id'] = $contrasenia->getId();
                $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
            }else{
                $contrasenia->actualizar();
                $respuesta['id'] = $contrasenia->getId();
                $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
            }
        }else{ $respuesta['mensaje'] = $comprobacion['causa']; }
        if (!empty($_POST['contrasenia'])) { echo json_encode($respuesta); }
	}

?>

