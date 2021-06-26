<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $taller = new Taller();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($taller->crearMatriz($taller->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $taller->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $taller->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'carga_horaria' => '', 'cupo_actual' => '', 'estado' => false, 'mensaje' => 'El ID del registro es incorrecto.');
        $taller = new Taller(
            $_POST['id'],
            $_POST['titulo'],
            $_POST['dia_horario'],
            $_POST['fecha_inicio'],
            $_POST['fecha_cierre'],
            $_POST['carga_horaria'],
            $_POST['cupo_max'],
            $_POST['cupo_actual'],
            $_POST['estado'],
            "", //fecha_creacion: Se auto-asignan en la BD.
            ""  //fecha modificacion: Se auto-asignan en la BD.
        );
        if ($_GET['operacion'] == 'insertar'){
            $taller->insertar();
            $respuesta['id'] = $taller->getId();
            $respuesta['cupo_actual'] = $taller->getCupoActual();
            $respuesta['carga_horaria'] = $taller->getCargaHoraria();
            $respuesta['estado'] = true;
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }else{
            $taller->actualizar();
            $respuesta['id'] = $taller->getId();
            $respuesta['cupo_actual'] = $taller->getCupoActual();
            $respuesta['carga_horaria'] = $taller->getCargaHoraria();
            $respuesta['estado'] = true;
            $respuesta['mensaje'] = 'Los cambios se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
	}

?>
     