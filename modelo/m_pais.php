<?php

class Pais{
    
	private $id;
	private $denominacion;

    function __construct() 
    {
        if(func_num_args() == 2){
            $this->id = func_get_arg(0);
            $this->denominacion = func_get_arg(1);
        }
    }

    public function actualizar() : Pais
	{
        if($this->getId() > 0){
            DataBase::sentenciar("UPDATE pais SET 
                denominacion = '".$this->denominacion."' WHERE id = ".$this->id.";");
        }
        return $this;
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM pais WHERE id = ".$id.";");
	}

	public function insertar() : Pais
	{
        if($this->getId() > 0){
            DataBase::sentenciar("INSERT INTO pais (id, denominacion) VALUES (
                ".$this->id.",
                UPPER('".$this->denominacion."'));");
        }
        return $this;
	}

    public function obtener($id) : Pais
    {
        $datos = DataBase::sentenciar("SELECT * FROM pais WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Pais(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM telefono WHERE id = ".$valor.";"); }
        if ($filtro == "denominacion") { $datos = DataBase::sentenciar("SELECT * FROM telefono WHERE denominacion LIKE '%".$valor."'%;"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Pais();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }
    
    private function instanciar($fila) : Pais
    {
        $this->id = $fila['id'];
        $this->denominacion = $fila['denominacion'];
        return $this;
    }

    public function crearMatriz(Pais $pais) : array
    {
        return array( 
            'id' => $pais->id,
            'denominacion' => $pais->denominacion
        );
    }

	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getDenominacion() { return $this->denominacion;	}
	public function setDenominacion($denominacion) { $this->denominacion = $denominacion; return $this;	}
}
?>