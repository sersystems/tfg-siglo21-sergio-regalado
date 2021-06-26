<?php

class Usuario{

	private $id;
	private $rol;	
	private $nombre;
	private $apellido;
	private DocumentoTipo $documento_tipo;
	private $documento_nro;
	private $sexo;
	private $fecha_nacimiento;
	private $correo_electronico;
	private $fotografia;
	private $estado;
	private $fecha_creacion;
	private $fecha_modificacion;

    function __construct() 
    {
        if(func_num_args() == 13){
            $this->id = func_get_arg(0);
            $this->rol = func_get_arg(1);
            $this->nombre = func_get_arg(2);
            $this->apellido = func_get_arg(3);
            $this->documento_tipo = func_get_arg(4);
            $this->documento_nro = func_get_arg(5);
            $this->sexo = func_get_arg(6);
            $this->fecha_nacimiento = func_get_arg(7);
            $this->correo_electronico = func_get_arg(8);
            $this->fotografia = func_get_arg(9);
            $this->estado = func_get_arg(10);
            $this->fecha_creacion = func_get_arg(11);
            $this->fecha_modificacion = func_get_arg(12);
        }
    }

	public function actualizar() : Usuario
	{
        if($this->id > 0){
            DataBase::sentenciar("UPDATE usuario SET 
                rol = UPPER('".$this->rol."'),
                nombre = UPPER('".$this->nombre."'),
                apellido = UPPER('".$this->apellido."'),
                documento_tipo_id = ".$this->documento_tipo->getId().",
                documento_nro = '".$this->documento_nro."',
                sexo = UPPER('".$this->sexo."'),
                fecha_nacimiento = '".$this->fecha_nacimiento."',
                correo_electronico = LOWER('".$this->correo_electronico."'),
                fotografia = '".$this->fotografia."',
                estado = UPPER('".$this->estado."'),
                fecha_modificacion = CURRENT_TIMESTAMP WHERE id = ".$this->id.";");
        }
        return $this;
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM usuario WHERE id = ".$id.";");
	}

	public function insertar() : Usuario
	{
        $this->id = DataBase::generarId('usuario');
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO usuario (id, rol, nombre, apellido, documento_tipo_id, documento_nro, sexo, fecha_nacimiento, correo_electronico, fotografia, estado) VALUES (
                ".$this->id.",
                UPPER('".$this->rol."'),
                UPPER('".$this->nombre."'),
                UPPER('".$this->apellido."'),
                ".$this->documento_tipo->getId().",
                '".$this->documento_nro."',
                UPPER('".$this->sexo."'),
                '".$this->fecha_nacimiento."',
                LOWER('".$this->correo_electronico."'),
                '".$this->fotografia."',
                UPPER('".$this->estado."'));");
        }
        return $this;
	}

    public function obtener($id) : Usuario
    {
        $datos = DataBase::sentenciar("SELECT * FROM usuario WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Usuario(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM usuario WHERE id = ".$valor.";"); }
        if ($filtro == "apellido_nombre") { $datos = DataBase::sentenciar("SELECT * FROM usuario WHERE CONCAT(apellido, ' ', nombre) LIKE '%".$valor."%';"); }
        if ($filtro == "correo_electronico") { $datos = DataBase::sentenciar("SELECT * FROM usuario WHERE correo_electronico LIKE '%".$valor."%';"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Usuario();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }
 
	private function instanciar($fila) : Usuario
    {
        $this->id = $fila['id'];
        $this->rol = $fila['rol'];
        $this->nombre = $fila['nombre'];
        $this->apellido = $fila['apellido'];
        $this->documento_tipo = (new DocumentoTipo())->obtener($fila['documento_tipo_id']);
        $this->documento_nro = $fila['documento_nro'];
        $this->sexo = $fila['sexo'];
        $this->fecha_nacimiento = $fila['fecha_nacimiento'];
        $this->correo_electronico = $fila['correo_electronico'];
        $this->fotografia = $fila['fotografia'];
        $this->estado = $fila['estado'];
		$this->fecha_creacion = $fila['fecha_creacion'];
        $this->fecha_modificacion = $fila['fecha_modificacion'];
        return $this;
    }

    public function crearMatriz(Usuario $usuario)
    {
        return array( 
            'id' => $usuario->id,
            'rol' => $usuario->rol,
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
            'documento_tipo' => array(
                'id' => $usuario->documento_tipo->getId(),
                'denominacion_corta' => $usuario->documento_tipo->getDenominacionCorta(),
                'denominacion_larga' => $usuario->documento_tipo->getDenominacionLarga(),
                'pais' => array(
                    'id' => $usuario->documento_tipo->getPais()->getId(),
                    'denominacion' => $usuario->documento_tipo->getPais()->getDenominacion())),
            'documento_nro' => $usuario->documento_nro,
            'sexo' => $usuario->sexo,
            'fecha_nacimiento' => $usuario->fecha_nacimiento,
            'correo_electronico' => $usuario->correo_electronico,
            'fotografia' => $usuario->fotografia,
            'estado' => $usuario->estado,
            'fecha_creacion' => $usuario->fecha_creacion,
            'fecha_modificacion' => $usuario->fecha_modificacion
        );
    }

    public function subirFotografia($fotografia) : bool
    {
        $confirmacionDeSubida = false;
        // ======= Preparación de Fotografía ======= //
        $destino_img = $_SESSION['RAIZ'].'public_html/img/fotografia/'; //Paso 1: Define la ruta de destino
        $nombre_nuevo_img = 'usuario_'.$this->id.'.jpg'; //Paso 2: Determina el nombre y extensión de la captura
        (is_file($destino_img.$nombre_nuevo_img)) ? unlink($destino_img.$nombre_nuevo_img) : null; //Paso 3: Elimina fotografia existente en el servidor.
        // ========== Edición Fotográfica ========== //
        if(move_uploaded_file($fotografia["tmp_name"], $destino_img.'tmp_'.$nombre_nuevo_img)){
            $lienzo_img = imagecreatetruecolor(1088, 816);
            $subida_img = imagecreatefromjpeg($destino_img.'tmp_'.$nombre_nuevo_img);
            imagecopyresampled($lienzo_img, $subida_img, 0, 0, 0, 0, 1088, 816, imagesx($subida_img), imagesy($subida_img));
            $logo_img = imagecreatefrompng($destino_img.'img_logo_fotografia.png');
            imagecopyresampled($lienzo_img, $logo_img, 234, 348, 0, 0, 620, 120, imagesx($logo_img), imagesy($logo_img));
            imagejpeg($lienzo_img, $destino_img.$nombre_nuevo_img, 100);
            imagedestroy($lienzo_img);
            unlink($destino_img.'tmp_'.$nombre_nuevo_img);
            $this->fotografia = '/public_html/img/fotografia/'.$nombre_nuevo_img;
            $this->actualizar();
            $confirmacionDeSubida = true;
        }
        return $confirmacionDeSubida;
    }

    public function verificarUnicidadCorreo($operacion, $correo, $id) : bool
    {
        $verificacion = true;
        if ($operacion == "insertar"){
            $datos = DataBase::sentenciar("SELECT * FROM usuario WHERE correo_electronico = '".$correo."';");
            if ($datos->rowCount() > 0){ $verificacion = false; }
        }
        if ($operacion == "actualizar"){
            $datos = DataBase::sentenciar("SELECT * FROM usuario WHERE id != ".$id." AND correo_electronico = '".$correo."';");
            if ($datos->rowCount() > 0){ $verificacion = false; }
        }        
        return $verificacion;
    }

    public function validarUsuario($correo, $contrasenia) : array
    {
        $validacion = array('estado' => false, 'id' => '', 'rol' => '', 'apellido' => '', 'nombre' => '', 'fotografia' => '');
        $datos = DataBase::sentenciar("SELECT u.id, c.hash FROM usuario u
            INNER JOIN contrasenia c ON c.usuario_id = u.id
            WHERE u.correo_electronico = '".$correo."' ORDER BY c.fecha_creacion DESC LIMIT 1;");
        $fila = $datos->fetch();
        if($datos->rowCount() == 1){
            if(password_verify($contrasenia, $fila['hash'])){
                $usuario = (new Usuario())->obtener($fila['id']);
                $validacion['estado'] = true;
                $validacion['id'] = $usuario->id;
                $validacion['rol'] = $usuario->rol;
                $validacion['apellido'] = $usuario->apellido;
                $validacion['nombre'] = $usuario->nombre;
                $validacion['fotografia'] = $usuario->fotografia;
            }
        }
        return $validacion;
    }

	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getRol() { return $this->rol; }
	public function setRol($rol) { $this->rol = $rol; return $this; }
	public function getNombre()	{ return $this->nombre;	}
	public function setNombre($nombre) { $this->nombre = $nombre; return $this;	}
	public function getApellido() { return $this->apellido;	}
	public function setApellido($apellido) { $this->apellido = $apellido; return $this;	}
	public function getDocumento_tipo() { return $this->documento_tipo; }
	public function setDocumento_tipo(DocumentoTipo $documento_tipo) { $this->documento_tipo = $documento_tipo; return $this; }
	public function getDocumento_nro() { return $this->documento_nro; }
	public function setDocumento_nro($documento_nro) { $this->documento_nro = $documento_nro; return $this;	}
	public function getSexo() { return $this->sexo; } 
	public function setSexo($sexo) { $this->sexo = $sexo; return $this;	}
	public function getFechaNacimiento() { return $this->fecha_nacimiento; }
	public function setFechaNacimiento($fecha_nacimiento) { $this->fecha_nacimiento = $fecha_nacimiento; return $this; }
	public function getCorreoElectronico() { return $this->correo_electronico; }
	public function setCorreoElectronico($correo_electronico) { $this->correo_electronico = $correo_electronico; return $this; }
	public function getFotografia()	{ return $this->fotografia; }
	public function setFotografia($fotografia) { $this->fotografia = $fotografia; return $this;	}
	public function getEstado() { return $this->estado; }
	public function setEstado($estado) { $this->estado = $estado; return $this;	}
	public function getFechaCreacion()	{ return $this->fecha_creacion;	}
	public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; return $this;	}
	public function getFechaModificacion()	{ return $this->fecha_modificacion;	}
	public function setFechaModificacion($fecha_modificacion) { $this->fecha_modificacion = $fecha_modificacion; return $this;	}
}
?>