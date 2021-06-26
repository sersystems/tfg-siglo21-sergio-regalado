<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');

    $usuario = new Usuario();
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtener') {
        echo json_encode($usuario->crearMatriz($usuario->obtener($_GET['id'])));
    }

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'listar') {
        $listaObjeto = $usuario->listar($_GET['filtro'], $_GET['valor']);
        $listaJSON = array();
        for ($i=0; $i < count($listaObjeto); $i++) {
            $listaJSON[$i] = $usuario->crearMatriz($listaObjeto[$i]); 
        }
        echo json_encode($listaJSON);
    }

    if (isset($_GET['operacion']) && ($_GET['operacion'] == 'insertar' || $_GET['operacion'] == 'actualizar')) {
        $respuesta = array('id' => '', 'estado' => false, 'mensaje' => 'El ID del registro es incorrecto.');
        if($usuario->verificarUnicidadCorreo($_GET['operacion'], $_POST['correo_electronico'], $_POST['id'])){
            $usuario = new Usuario(
                $_POST['id'],
                $_POST['rol'],
                $_POST['nombre'],
                $_POST['apellido'],
                (new DocumentoTipo())->obtener($_POST['documento_tipo_id']),
                $_POST['documento_nro'],
                $_POST['sexo'],
                $_POST['fecha_nacimiento'],
                $_POST['correo_electronico'],
                (isset($_FILES["fotografiaFILE"])) ? '' : $_POST['fotografiaSRC'],
                $_POST['estado'],
                "", //fecha_creacion: Se auto-asignan en la BD.
                ""  //fecha modificacion: Se auto-asignan en la BD.
            );
            if ($_GET['operacion'] == 'insertar'){
                $usuario->insertar();
                $respuesta['id'] = $usuario->getId();
                $respuesta['estado'] = true;
                $respuesta['mensaje'] = 'Los datos se registraron satisfactoriamente.';
            }else{
                $usuario->actualizar();
                $respuesta['id'] = $usuario->getId();
                $respuesta['estado'] = true;
                $respuesta['mensaje'] = 'Los cambios se registraron satisfactoriamente.';
            }
            if(isset($_FILES["fotografiaFILE"]) && $_FILES["fotografiaFILE"]["size"] > 0){
                if($_FILES["fotografiaFILE"]['type'] == 'image/jpeg'){
                    $usuario->subirFotografia($_FILES["fotografiaFILE"]);
                }else{ 
                    $respuesta['mensaje'] = 'Solo se pueden subir fotografías de tipo JPG.'; 
                }
            }
        }else{
            $respuesta['mensaje'] = 'El correo electrónico ya se encuentra registrado en la base de datos.';
        }
        echo json_encode($respuesta);
	}

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'iniciarSesion') {
        $respuesta = array('estado' => false, 'mensaje' => 'El correo electrónico o contraseña es inválido.', 'titulo' => 'Acceso Al Sistema');
        $validacion = $usuario->validarUsuario($_POST['correo_electronico'], $_POST['contrasenia']);
        if ($validacion['estado']){
			$_SESSION['ID'] = $validacion['id'];          
			$_SESSION['ROL'] = $validacion['rol'];
			$_SESSION['APELLIDO'] = $validacion['apellido'];
			$_SESSION['NOMBRE'] = $validacion['nombre'];
			$_SESSION['FOTOGRAFIA'] = $validacion['fotografia'];
                $respuesta['estado'] = true;
                $respuesta['mensaje'] = 'Bienvenido al sistema.';    
        };
        echo json_encode($respuesta);
	}
    
    if (isset($_GET['operacion']) && $_GET['operacion'] == 'obtenerSesion') {
        echo json_encode(array(
            'id' => $_SESSION['ID'], 
            'rol' => $_SESSION['ROL'], 
            'apellido' => $_SESSION['APELLIDO'], 
            'nombre' => $_SESSION['NOMBRE'], 
            'fotografia' => $_SESSION['FOTOGRAFIA']));
	}

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'cerrarSesion') {
        session_destroy();
        session_start();
        $_SESSION['RAIZ'] = $_SERVER['DOCUMENT_ROOT'].'/';
        echo json_encode(array('mensaje' => '¡Hasta pronto!'));
	}
?>
     