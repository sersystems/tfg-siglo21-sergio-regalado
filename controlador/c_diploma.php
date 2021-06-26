<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $diploma = new Diploma();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($diploma->crearMatriz($diploma->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $diploma->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $diploma->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'insertar') {
        $respuesta = array('id' => '', 'mensaje' => 'El ID del registro es incorrecto.');
        $diploma = new Diploma(
            $_POST['id'],
            $_POST['codigo_verificacion'],
            $_POST['bloque_smart_contract'],
            "" //fecha_creacion: Se auto-asignan en la BD.
        );
        if ($_GET['operacion'] == 'insertar'){
            $diploma->insertar();
            $respuesta['id'] = $diploma->getId();
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
	}

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'confeccionar') {
        $datos = $diploma->confeccionarDiploma($_GET['inscripcion_id']); 
        require_once($_SESSION['RAIZ'].'util/fpdf/fpdf.php');
        $usuarioLongitud = strlen($datos['usuario']);
        $documentoLongitud = strlen($datos['documento']);
        $tallerLongitud = strlen($datos['taller']); 
        $pdf = new FPDF();
        $pdf->AddPage('P','Letter');
        $pdf->SetTitle('Diploma');
        $pdf->SetAuthor('Biblioteca Popular Sur');
        $pdf->Image($_SESSION['RAIZ'].'public_html/img/plantilla_diploma.jpg',4,5,208);
        $pdf->SetFont('Arial','B',22);
        $pdf->Text((104-($usuarioLongitud*2.24)), 175, $datos['usuario']);
        $pdf->SetFont('Arial','B',18);
        $pdf->Text((104-($documentoLongitud*1.3)), 185, $datos['documento']);
        $pdf->SetFont('Arial','B',22);
        $pdf->Text((104-($tallerLongitud*2.34)), 213, $datos['taller']);
        $pdf->SetFont('Arial','B',14);
        $pdf->Text(85.1, 237.1, $datos['cu']);
        $pdf->Text(77.6, 244.15, $datos['fecha_cierre']);
        $pdf->Text(65, 251.25, $datos['carga_horaria'].'hs.');
        //unlink('diploma.pdf');
        $pdf->Output('F', $_SESSION['RAIZ'].'public_html/diploma.pdf');
        echo json_encode(array('ruta' => 'diploma.pdf'));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'verificar') {
        $respuesta = array('estado' => '', 'bloque_smart_contract' => '', 'mensaje' => 'DIPLOMA NO VERIFICADO');
        $datos = $diploma->verificarDiploma($_GET['codigo_verificacion']);
        if($datos['estado']){
            $respuesta['estado'] = $datos['estado'];
            $respuesta['bloque_smart_contract'] = $datos['bloque_smart_contract'];
            $respuesta['mensaje'] = 'DIPLOMA VERIFICADO';
        }
        echo json_encode($respuesta);
    }
?>