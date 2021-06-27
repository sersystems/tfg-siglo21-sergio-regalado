<?php

class Institucion{

	private $id;
	private $razon_social;
	private $cuit;
	private $responsable_tipo;
	private $fecha_contrato_social;
	private $registro_conabip;
	private $correo_electronico;
	private $fecha_creacion;
	private $fecha_modificacion;

    function __construct() 
    {
        if(func_num_args() == 9){
            $this->id = func_get_arg(0);
            $this->razon_social = func_get_arg(1);
            $this->cuit = func_get_arg(2);
            $this->responsable_tipo = func_get_arg(3);
            $this->fecha_contrato_social = func_get_arg(4);
            $this->registro_conabip = func_get_arg(5);
            $this->correo_electronico = func_get_arg(6);
            $this->fecha_creacion = func_get_arg(7);
            $this->fecha_modificacion = func_get_arg(8);
        }
    }

	public function actualizar() : Institucion
	{
        if($this->id > 0){
            DataBase::sentenciar("UPDATE institucion SET 
                razon_social = UPPER('".$this->razon_social."'),
                cuit = '".$this->cuit."',
                responsable_tipo = UPPER('".$this->responsable_tipo."'),
                fecha_contrato_social = '".$this->fecha_contrato_social."',
                registro_conabip = '".$this->registro_conabip."',
                correo_electronico = LOWER('".$this->correo_electronico."'),
                fecha_modificacion = CURRENT_TIMESTAMP WHERE id = ".$this->id.";");
        }
        return $this;
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM institucion WHERE id = ".$id.";");
	}

	public function insertar() : Institucion
	{
        $this->id = DataBase::generarId('institucion');
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO institucion (id, razon_social, cuit, responsable_tipo, fecha_contrato_social, registro_conabip, correo_electronico) VALUES (
                ".$this->id.",
                UPPER('".$this->razon_social."'),
                '".$this->cuit."',
                UPPER('".$this->responsable_tipo."'),
                '".$this->fecha_contrato_social."',
                '".$this->registro_conabip."',
                LOWER('".$this->correo_electronico."'));");
        }
        return $this;
	}

    public function obtener($id) : Institucion
    {
        $datos = DataBase::sentenciar("SELECT * FROM institucion WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Institucion(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM institucion WHERE id = ".$valor.";"); }
        if ($filtro == "razon_social") { $datos = DataBase::sentenciar("SELECT * FROM institucion WHERE razon_social LIKE '%".$valor."%';"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Institucion();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }
 
	private function instanciar($fila) : Institucion
    {
        $this->id = $fila['id'];
        $this->razon_social = $fila['razon_social'];
        $this->cuit = $fila['cuit'];
        $this->responsable_tipo = $fila['responsable_tipo'];
        $this->fecha_contrato_social = $fila['fecha_contrato_social'];
        $this->registro_conabip = $fila['registro_conabip'];
        $this->correo_electronico = $fila['correo_electronico'];
		$this->fecha_creacion = $fila['fecha_creacion'];
        $this->fecha_modificacion = $fila['fecha_modificacion'];
        return $this;
    }

    public function crearMatriz(Institucion $institucion) : array
    {
        return array( 
            'id' => $institucion->id,
            'razon_social' => $institucion->razon_social,
            'cuit' => $institucion->cuit,
            'responsable_tipo' => $institucion->responsable_tipo,
            'fecha_contrato_social' => $institucion->fecha_contrato_social,
            'registro_conabip' => $institucion->registro_conabip,
            'correo_electronico' => $institucion->correo_electronico,
            'responsable_tipo' => $institucion->responsable_tipo,
            'fecha_creacion' => $institucion->fecha_creacion,
            'fecha_modificacion' => $institucion->fecha_modificacion
        );
    }

 	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getRazonSocial() { return $this->razon_social; }
	public function setRazonSocial($razon_social) { $this->razon_social = $razon_social; return $this; }
	public function getCuit()	{ return $this->cuit;	}
	public function setCuit($cuit) { $this->cuit = $cuit; return $this;	}
	public function getResponsableTipo() { return $this->responsable_tipo;	}
	public function setResponsableTipo($responsable_tipo) { $this->responsable_tipo = $responsable_tipo; return $this;	}
	public function getFechaContratoSocial() { return $this->fecha_contrato_social; }
	public function setFechaContratoSocial($fecha_contrato_social) { $this->fecha_contrato_social = $fecha_contrato_social; return $this; }
	public function getRegistroConabip() { return $this->registro_conabip; }
	public function setRegistroConabip($registro_conabip) { $this->registro_conabip = $registro_conabip; return $this;	}
	public function getCorreoElectronico() { return $this->correo_electronico; }
	public function setCorreoElectronico($correo_electronico) { $this->correo_electronico = $correo_electronico; return $this; }
    public function getFechaCreacion()	{ return $this->fecha_creacion;	}
	public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; return $this;	}
	public function getFechaModificacion()	{ return $this->fecha_modificacion;	}
	public function setFechaModificacion($fecha_modificacion) { $this->fecha_modificacion = $fecha_modificacion; return $this;	}
}
?>