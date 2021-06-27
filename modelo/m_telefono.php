<?php

class Telefono{
    
	private $id;
	private Usuario $usuario;
	private Institucion $institucion;
	private $tipo;
	private $prefijo;
	private $numero;
    
    function __construct() 
    {
        if(func_num_args() == 6){
            $this->id = func_get_arg(0);
            $this->usuario = func_get_arg(1);
            $this->institucion = func_get_arg(2);
            $this->tipo = func_get_arg(3);
            $this->prefijo = func_get_arg(4);
            $this->numero = func_get_arg(5);
        }
    }

    public function actualizar() : Telefono
	{
        $usuario_id = (!empty($this->usuario->getId())) ? $this->usuario->getId() : 'null';
        $institucion_id = (!empty($this->institucion->getId())) ? $this->institucion->getId() : 'null';
        if($this->id > 0){
            DataBase::sentenciar("UPDATE telefono SET 
                usuario_id = ".$usuario_id.",
                institucion_id = ".$institucion_id.",
                tipo = UPPER('".$this->tipo."'),
                prefijo = UPPER('".$this->prefijo."'),
                numero = UPPER('".$this->numero."') WHERE id = ".$this->id.";");
        }
        return $this;
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM telefono WHERE id = ".$id.";");
	}

	public function insertar() : Telefono
	{
        $this->id = DataBase::generarId('telefono');
        $usuario_id = (!empty($this->usuario->getId())) ? $this->usuario->getId() : 'null';
        $institucion_id = (!empty($this->institucion->getId())) ? $this->institucion->getId() : 'null';
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO telefono (id, usuario_id, institucion_id, tipo, prefijo, numero) VALUES (
                ".$this->id.",
                ".$usuario_id.",
                ".$institucion_id.",
                UPPER('".$this->tipo."'),
                UPPER('".$this->prefijo."'),
                UPPER('".$this->numero."'));");
        }
        return $this;
	}

    public function obtener($id) : Telefono
    {
        $datos = DataBase::sentenciar("SELECT * FROM telefono WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Telefono(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM telefono WHERE id = ".$valor.";"); }
        if ($filtro == "usuario_id") { $datos = DataBase::sentenciar("SELECT * FROM telefono WHERE usuario_id = ".$valor.";"); }
        if ($filtro == "institucion_id") { $datos = DataBase::sentenciar("SELECT * FROM telefono WHERE institucion_id = ".$valor.";"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Telefono();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }
  
    private function instanciar($fila) : Telefono
    {
        $this->id = $fila['id'];
        $this->usuario = ($fila['usuario_id'] > 0) ? (new Usuario())->obtener($fila['usuario_id']) : new Usuario();
        $this->institucion = ($fila['institucion_id'] > 0) ? (new Institucion())->obtener($fila['institucion_id']) : new Institucion();
        $this->tipo = $fila['tipo'];
        $this->prefijo = $fila['prefijo'];
        $this->numero = $fila['numero'];
        return $this;
    }

    public function crearMatriz(Telefono $telefono) : array
    {
        return array( 
            'id' => $telefono->id,
            'usuario_id' => $telefono->usuario->getId(),
            'institucion_id' => $telefono->institucion->getId(),
            'tipo' => $telefono->tipo,
            'prefijo' => $telefono->prefijo,
            'numero' => $telefono->numero
        );
    }
    
	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getUsuario() { return $this->usuario;	}
	public function setUsuario(Usuario $usuario) { $this->usuario = $usuario; return $this;	}
	public function getInstitucion() { return $this->institucion;	}
	public function setInstitucion(Institucion $institucion) { $this->institucion = $institucion; return $this;	}
	public function getTipo() { return $this->tipo; }
	public function setTipo($tipo) { $this->tipo = $tipo; return $this; }
	public function getPrefijo() { return $this->prefijo;	}
	public function setPrefijo($prefijo) { $this->prefijo = $prefijo; return $this;	}
	public function getNumero() { return $this->numero; }
	public function setNumero($numero) { $this->numero = $numero; return $this; }
}
?>