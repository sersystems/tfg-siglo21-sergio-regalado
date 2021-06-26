<?php

class DocumentoTipo{
    
	private $id;
	private $denominacion_corta;
	private $denominacion_larga;
	private $pais;

    function __construct() 
    {
        if(func_num_args() == 4){
            $this->id = func_get_arg(0);
            $this->denominacion_corta = func_get_arg(1);
            $this->denominacion_larga = func_get_arg(2);
            $this->pais = func_get_arg(3);
        }
    }

    public function actualizar() : DocumentoTipo
	{
        if($this->getId() > 0){
            DataBase::sentenciar("UPDATE documento_tipo SET 
                denominacion_corta = UPPER('".$this->denominacion_corta."'),
                denominacion_larga = UPPER('".$this->denominacion_larga."'),
                pais_id = ".$this->pais->getId()." WHERE id = ".$this->id.";");
        }
        return $this;
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM documento_tipo WHERE id = ".$id.";");
	}

	public function insertar() : DocumentoTipo
	{
        if($this->getId() > 0){
            DataBase::sentenciar("INSERT INTO documento_tipo (id, denominacion_corta, denominacion_larga, pais_id) VALUES (
                ".$this->id.",
                UPPER('".$this->denominacion_corta."'),
                UPPER('".$this->denominacion_larga."'),
                ".$this->pais->getId().");");
        }
        return $this;
	}

    public function obtener($id) : DocumentoTipo
    {
        $datos = DataBase::sentenciar("SELECT * FROM documento_tipo WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new DocumentoTipo(); }
    }
  
    public function listar() : ArrayObject
    {
        $listado = new ArrayObject();
        $datos = DataBase::sentenciar("SELECT * FROM documento_tipo;");
        if($datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $listado->append($this->instanciar($fila));
            }
        }  
        return $listado;
    }

    private function instanciar($fila) : DocumentoTipo
    {
        $this->id = $fila['id'];
        $this->denominacion_corta = $fila['denominacion_corta'];
        $this->denominacion_larga = $fila['denominacion_larga'];
        $this->pais = (new Pais())->obtener($fila['pais_id']);
        return $this;
    }

	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getDenominacionCorta() { return $this->denominacion_corta;	}
	public function setDenominacionCorta($denominacion_corta) { $this->denominacion_corta = $denominacion_corta; return $this; }
	public function getDenominacionLarga() { return $this->denominacion_larga;	}
	public function setDenominacionLarga($denominacion_larga) { $this->denominacion_larga = $denominacion_larga; return $this;	}
    public function getPais() { return $this->pais; }
	public function setPais(Pais $pais) { $this->pais = $pais; return $this; }
}
?>