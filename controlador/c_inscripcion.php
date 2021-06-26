<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $inscripcion = new Inscripcion();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($inscripcion->crearMatriz($inscripcion->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $inscripcion->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $inscripcion->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'estado' => false, 'mensaje' => 'El ID del registro es incorrecto.');
        $inscripcion = new Inscripcion(
            $_POST['id'],
            (new Usuario())->obtener($_POST['usuario_id']),
            (new Taller())->obtener($_POST['taller_id']),
            $_POST['fecha_inscripcion'],
            $_POST['asistencia_final'],
            $_POST['calificacion_final'],
            $_POST['situacion_cursada'],
            (isset($_POST['diploma_id'])) ? (new Diploma())->obtener($_POST['diploma_id']) : new Diploma()
        );
        if ($_GET['operacion'] == 'insertar'){
            if ($inscripcion->verificarLimiteInscripcion($_POST['usuario_id'])){        
                if ($inscripcion->verificarDobleInscripcion($_POST['usuario_id'], $_POST['taller_id'])){        
                    $inscripcion->insertar();
                    $respuesta['id'] = $inscripcion->getId();
                    $respuesta['estado'] = true;
                    $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
                }else{ $respuesta['mensaje'] = 'No se registró la solicitud porque ya tienes una inscripción en este taller. '; }
            }else{ $respuesta['mensaje'] = 'Se alcanzó el límite máximo de inscripciones simultaneas.'; }
        }else{
            $inscripcion->actualizar();
            $respuesta['id'] = $inscripcion->getId();
            $respuesta['estado'] = true;
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
	}

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'actualizarIdDiploma') {
        $respuesta = array('id' => '', 'estado' => false, 'mensaje' => 'El ID del registro es incorrecto.');
        $inscripcion = new Inscripcion();
        if($_POST['id'] > 0 && $_POST['diploma_id'] > 0){
            $inscripcion->actualizarIdDiploma($_POST['id'], $_POST['diploma_id']);
            $respuesta['id'] = $inscripcion->getId();
            $respuesta['estado'] = true;
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
	}

?>