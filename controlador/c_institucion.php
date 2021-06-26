<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $institucion = new Institucion();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($institucion->crearMatriz($institucion->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $institucion->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $institucion->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'estado' => false, 'mensaje' => 'El ID del registro es incorrecto.');
        $institucion = new Institucion(
            $_POST['id'],
            $_POST['razon_social'],
            $_POST['cuit'],
            $_POST['responsable_tipo'],
            $_POST['fecha_contrato_social'],
            $_POST['registro_conabip'],
            $_POST['correo_electronico'],
            "", //fecha_creacion: Se auto-asignan en la BD.
            ""  //fecha modificacion: Se auto-asignan en la BD.
        );
        if ($_GET['operacion'] == 'insertar'){
            $institucion->insertar();
            $respuesta['id'] = $institucion->getId();
            $respuesta['estado'] = true;
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }else{
            $institucion->actualizar();
            $respuesta['id'] = $institucion->getId();
            $respuesta['estado'] = true;
            $respuesta['mensaje'] = 'Los cambios se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
	}

?>
     