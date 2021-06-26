<?php

class Contrasenia{
    
	private $id;
	private Usuario $usuario;
	private $hash;
	private $fecha_creacion;
	private $fecha_modificacion;

    function __construct() 
    {
        if(func_num_args() == 5){
            $this->id = func_get_arg(0);
            $this->usuario = func_get_arg(1);
            $this->hash = func_get_arg(2);
            $this->fecha_creacion = func_get_arg(3);
            $this->fecha_modificacion = func_get_arg(4);
        }
    }

    public function actualizar() : Contrasenia
	{
        if($this->id > 0){
            DataBase::sentenciar("UPDATE contrasenia SET 
                usuario_id = ".$this->usuario->getId().",
                hash = '".$this->hash."',
                fecha_modificacion = CURRENT_TIMESTAMP WHERE id = ".$this->id.";");
        }
        return $this;
    }

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM contrasenia WHERE id = ".$id.";");
	}

	public function insertar() : Contrasenia
	{
        $this->id = DataBase::generarId('contrasenia');
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO contrasenia (id, usuario_id, hash) VALUES (
                ".$this->id.",
                ".$this->usuario->getId().",
                '".$this->hash."');");
        }
        return $this;
	}

    public function obtener($id) : Contrasenia
    {
        $datos = DataBase::sentenciar("SELECT * FROM contrasenia WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Contrasenia(); }
    }

    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM contrasenia WHERE id = ".$valor.";"); }
        if ($filtro == "usuario_id") { $datos = DataBase::sentenciar("SELECT * FROM contrasenia WHERE usuario_id = ".$valor.";"); }
        if ($filtro == "usuario_id_contrasenia_ultima") { $datos = DataBase::sentenciar("SELECT * FROM contrasenia WHERE usuario_id = ".$valor." ORDER BY fecha_modificacion DESC LIMIT 1;"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Contrasenia();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }

    private function instanciar($fila) : Contrasenia
    {
        $this->id = $fila['id'];
        $this->usuario = ($fila['usuario_id'] > 0) ? (new Usuario())->obtener($fila['usuario_id']) : new Usuario();
        $this->hash = $fila['hash'];
        $this->fecha_creacion = $fila['fecha_creacion'];
        $this->fecha_modificacion = $fila['fecha_modificacion'];
        return $this;
    }

    public function crearMatriz(Contrasenia $contrasenia)
    {
        return array( 
            'id' => $contrasenia->id,
            'usuario_id' => $contrasenia->usuario->getId(),
            'hash' => $contrasenia->hash
        );
    }
    
	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getUsuario() { return $this->usuario;	}
	public function setUsuario(Usuario $usuario) { $this->usuario = $usuario; return $this;	}
    public function getHash() { return $this->hash; }
	public function setHash($hash) { $this->hash = $hash; return $this; }
	public function getFechaCreacion()	{ return $this->fecha_creacion;	}
	public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; return $this;	}
	public function getFechaModificacion()	{ return $this->fecha_modificacion;	}
	public function setFechaModificacion($fecha_modificacion) { $this->fecha_modificacion = $fecha_modificacion; return $this; }
}
?>