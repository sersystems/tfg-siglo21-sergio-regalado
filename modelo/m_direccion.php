<?php

class Direccion{
    
	private $id;
	private Usuario $usuario;
	private Institucion $institucion;
	private $direccion;
	private $codigo_postal;
	private $localidad;
	private $provincia;
	private Pais $pais;

    function __construct() 
    {
        if(func_num_args() == 8){
            $this->id = func_get_arg(0);
            $this->usuario = func_get_arg(1);
            $this->institucion = func_get_arg(2);
            $this->direccion = func_get_arg(3);
            $this->codigo_postal = func_get_arg(4);
            $this->localidad = func_get_arg(5);
            $this->provincia = func_get_arg(6);
            $this->pais = func_get_arg(7);
        }
    }

    public function actualizar() : Direccion
	{
        $usuario_id = (!empty($this->usuario->getId())) ? $this->usuario->getId() : 'null';
        $institucion_id = (!empty($this->institucion->getId())) ? $this->institucion->getId() : 'null';
        if($this->id > 0){
            DataBase::sentenciar("UPDATE direccion SET 
                usuario_id = ".$usuario_id.",
                institucion_id = ".$institucion_id.",
                direccion = UPPER('".$this->direccion."'),
                codigo_postal = '".$this->codigo_postal."',
                localidad = UPPER('".$this->localidad."'),
                provincia = UPPER('".$this->provincia."'),
                pais_id = ".$this->pais->getId()." WHERE id = ".$this->id.";");
        }
        return $this;
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM direccion WHERE id = ".$id.";");
	}

	public function insertar() : Direccion
	{
        $this->id = DataBase::generarId('direccion');
        $usuario_id = (!empty($this->usuario->getId())) ? $this->usuario->getId() : 'null';
        $institucion_id = (!empty($this->institucion->getId())) ? $this->institucion->getId() : 'null';
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO direccion (id, usuario_id, institucion_id, direccion, codigo_postal, localidad, provincia, pais_id) VALUES (
                ".$this->id.",
                ".$usuario_id.",
                ".$institucion_id.",
                UPPER('".$this->direccion."'),
                '".$this->codigo_postal."',
                UPPER('".$this->localidad."'),
                UPPER('".$this->provincia."'),
                ".$this->pais->getId().");");
        }
        return $this;
	}

    public function obtener($id) : Direccion
    {
        $datos = DataBase::sentenciar("SELECT * FROM direccion WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Direccion(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM direccion WHERE id = ".$valor.";"); }
        if ($filtro == "usuario_id") { $datos = DataBase::sentenciar("SELECT * FROM direccion WHERE usuario_id = ".$valor.";"); }
        if ($filtro == "institucion_id") { $datos = DataBase::sentenciar("SELECT * FROM direccion WHERE institucion_id = ".$valor.";"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Direccion();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }

    private function instanciar($fila) : Direccion
    {
        $this->id = $fila['id'];
        $this->usuario = ($fila['usuario_id'] > 0) ? (new Usuario())->obtener($fila['usuario_id']) : new Usuario();
        $this->institucion = ($fila['institucion_id'] > 0) ? (new Institucion())->obtener($fila['institucion_id']) : new Institucion();
        $this->direccion = $fila['direccion'];
        $this->codigo_postal = $fila['codigo_postal'];
        $this->localidad = $fila['localidad'];
        $this->provincia = $fila['provincia'];
        $this->pais = ($fila['pais_id'] > 0) ? (new Pais())->obtener($fila['pais_id']) : new Pais();
        return $this;
    }

    public function crearMatriz(Direccion $direccion)
    {
        return array( 
            'id' => $direccion->id,
            'usuario_id' => $direccion->usuario->getId(),
            'institucion_id' => $direccion->institucion->getId(),
            'direccion' => $direccion->direccion,
            'codigo_postal' => $direccion->codigo_postal,
            'localidad' => $direccion->localidad,
            'provincia' => $direccion->provincia,
            'pais' => array(
                'id' => $direccion->getPais()->getId(),
                'denominacion' => $direccion->getPais()->getDenominacion())
        );
    }
    
	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getUsuario() { return $this->usuario;	}
	public function setUsuario(Usuario $usuario) { $this->usuario = $usuario; return $this;	}
    public function getInstitucion() { return $this->institucion;	}
	public function setInstitucion(Institucion $institucion) { $this->institucion = $institucion; return $this;	}
    public function getDireccion() { return $this->direccion; }
	public function setDireccion($direccion) { $this->direccion = $direccion; return $this; }
    public function getCodigoPostal() { return $this->codigo_postal; }
	public function setCodigoPostal($codigo_postal) { $this->codigo_postal = $codigo_postal; return $this;	}
	public function getLocalidad() { return $this->localidad;	}
	public function setLocalidad($localidad) { $this->localidad = $localidad; return $this;	}
	public function getProvincia() { return $this->provincia; }
	public function setProvincia($provincia) { $this->provincia = $provincia; return $this; }
	public function getPais() { return $this->pais; }
	public function setPais(Pais $pais) { $this->pais = $pais; return $this; }
}
?>