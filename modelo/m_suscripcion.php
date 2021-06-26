<?php

class Suscripcion{
    
	private $id;
	private Usuario $usuario;
	private $fecha_vto;
	private $importe;
	private $estado;
	private $fecha_creacion;
	private $fecha_modificacion;

    function __construct() 
    {
        if(func_num_args() == 7){
            $this->id = func_get_arg(0);
            $this->usuario = func_get_arg(1);
            $this->fecha_vto = func_get_arg(2);
            $this->importe = func_get_arg(3);
            $this->estado = func_get_arg(4);
            $this->fecha_creacion = func_get_arg(5);
            $this->fecha_modificacion = func_get_arg(6);
        }
    }

    public function actualizar() : Suscripcion
	{
        if($this->id > 0){
            DataBase::sentenciar("UPDATE suscripcion SET 
                usuario_id = ".$this->usuario->getId().",
                fecha_vto = '".$this->fecha_vto."',
                importe = ".$this->importe.",
                estado = '".$this->estado."',
                fecha_modificacion = CURRENT_TIMESTAMP WHERE id = ".$this->id.";");
        }
        return $this;
    }

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM suscripcion WHERE id = ".$id.";");
	}

	public function insertar() : Suscripcion
	{
        $this->id = DataBase::generarId('suscripcion');
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO suscripcion (id, usuario_id, fecha_vto, importe, estado) VALUES (
                ".$this->id.",
                ".$this->usuario->getID().",
                null,
                ".$this->importe.",
                '".$this->estado."');");
        }
        return $this;
	}

    public function obtener($id) : Suscripcion
    {
        $datos = DataBase::sentenciar("SELECT * FROM suscripcion WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Suscripcion(); }
    }

    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM suscripcion WHERE id = ".$valor.";"); }
        if ($filtro == "usuario_id") { $datos = DataBase::sentenciar("SELECT * FROM suscripcion WHERE usuario_id = ".$valor.";"); }
        if ($filtro == "usuario_id_deducir_nueva_suscripcion") { $datos = DataBase::sentenciar("SELECT * FROM suscripcion WHERE usuario_id = ".$valor." AND (fecha_vto > NOW() OR ISNULL(fecha_vto)) ORDER BY fecha_modificacion DESC LIMIT 1;"); }
        if ($filtro == "usuario_id_ultima_suscripcion") { $datos = DataBase::sentenciar("SELECT * FROM suscripcion WHERE usuario_id = ".$valor." ORDER BY fecha_modificacion DESC LIMIT 1;"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Suscripcion();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }

    private function instanciar($fila) : Suscripcion
    {
        $this->id = $fila['id'];
        $this->usuario = ($fila['usuario_id'] > 0) ? (new Usuario())->obtener($fila['usuario_id']) : new Usuario();
        $this->fecha_vto = $fila['fecha_vto'];
        $this->importe = $fila['importe'];
        $this->estado = $fila['estado'];
        $this->fecha_creacion = $fila['fecha_creacion'];
        $this->fecha_modificacion = $fila['fecha_modificacion'];
        return $this;
    }

    public function crearMatriz(Suscripcion $suscripcion)
    {
        return array( 
            'id' => $suscripcion->id,
            'usuario_id' => $suscripcion->usuario->getId(),
            'fecha_vto' => $suscripcion->fecha_vto,
            'importe' => $suscripcion->importe,
            'estado' => $suscripcion->estado
        );
    }

	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getUsuario() { return $this->usuario;	}
	public function setUsuario(Usuario $usuario) { $this->usuario = $usuario; return $this;	}
    public function getFechaVto() { return $this->fecha_vto; }
	public function setFechaVto($fecha_vto) { $this->fecha_vto = $fecha_vto; return $this; }
    public function getImporte() { return $this->importe; }
	public function setImporte($importe) { $this->importe = $importe; return $this; }
    public function getEstado() { return $this->estado; }
	public function setEstado($estado) { $this->estado = $estado; return $this; }
    public function getFechaCreacion()	{ return $this->fecha_creacion;	}
	public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; return $this;	}
	public function getFechaModificacion()	{ return $this->fecha_modificacion;	}
	public function setFechaModificacion($fecha_modificacion) { $this->fecha_modificacion = $fecha_modificacion; return $this; }
}
?>