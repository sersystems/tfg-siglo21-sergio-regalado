<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $suscripcion = new Suscripcion();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($suscripcion->crearMatriz($suscripcion->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $suscripcion->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $suscripcion->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'mensaje' => 'El ID del registro es incorrecto.');
        $suscripcion = new Suscripcion(
            $_POST['id'],
            (new Usuario())->obtener($_POST['usuario_id']),
            $_POST['fecha_vto'],
            $_POST['importe'],
            $_POST['estado'],
            "", //fecha_creacion: Se auto-asignan en la BD.
            ""  //fecha modificacion: Se auto-asignan en la BD.
        );
        if ($_GET['operacion'] == 'insertar'){
            $suscripcion->insertar();
            $respuesta['id'] = $suscripcion->getId();
            $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
        }else{
            $suscripcion->actualizar();
            $respuesta['id'] = $suscripcion->getId();
            $respuesta['mensaje'] = 'Los cambios se registraron satisfactoriamente.';
        }
        echo json_encode($respuesta);
	}

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'pagar') {     
        MercadoPago\SDK::setAccessToken(Cfg::obtenerAccessTokenMP());
        $item = new MercadoPago\Item();
        $item->id = $_POST['id'];
        $item->title = 'Suscripción Bibliotecaria';
        $item->currency_id = 'ARS';
        $item->description = 'Periodo de suscripción - Biblioteca Popular Sur';
        $item->quantity = 1;
        $item->unit_price = $_POST['importe'];      

        $preference = new MercadoPago\Preference();
        $preference->back_urls = array(
            "approved" => $_SERVER['HTTP_HOST'].('\public_html\index.php'),
            "success" => $_SERVER['HTTP_HOST'].('\public_html\index.php'),
            "failure" => $_SERVER['HTTP_HOST'].('\public_html\index.php'),
            "pending" => $_SERVER['HTTP_HOST'].('\public_html\index.php')
        );
        $preference->auto_return = "approved";
        $preference->external_reference = $_POST['id']; //Importante: Recupera el id de la suscripción.
        $preference->items = array($item);
        $preference->save();
        $respuesta['url'] = $preference->init_point;
        $respuesta['mensaje'] = 'todo ok';      

        echo json_encode($respuesta);
	}

?>

