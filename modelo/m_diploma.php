<?php

class Diploma{
    
	private $id;
	private $codigo_verificacion;
	private $bloque_smart_contract;
	private $fecha_creacion;
    
    function __construct() 
    {
        if(func_num_args() == 4){
            $this->id = func_get_arg(0);
            $this->codigo_verificacion = func_get_arg(1);
            $this->bloque_smart_contract = func_get_arg(2);
            $this->fecha_creacion = func_get_arg(3);
        }
    }

	public function insertar() : Diploma
	{
        $this->id = DataBase::generarId('diploma');
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO diploma (id, codigo_verificacion, bloque_smart_contract) VALUES (
                ".$this->id.",
                '".$this->codigo_verificacion."',
                ".$this->bloque_smart_contract.");");
        }
        return $this;
	}

    public function obtener($id) : Diploma
    {
        $datos = DataBase::sentenciar("SELECT * FROM diploma WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Diploma(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM diploma WHERE id = ".$valor.";"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Diploma();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }
  
    private function instanciar($fila) : Diploma
    {
        $this->id = $fila['id'];
        $this->codigo_verificacion = $fila['codigo_verificacion'];
        $this->bloque_smart_contract = $fila['bloque_smart_contract'];
        $this->fecha_creacion = $fila['fecha_creacion'];
        return $this;
    }

    public function crearMatriz(Diploma $diploma)
    {
        return array( 
            'id' => $diploma->id,
            'codigo_verificacion' => $diploma->codigo_verificacion,
            'bloque_smart_contract' => $diploma->bloque_smart_contract,
            'fecha_creacion' => $diploma->fecha_creacion
        );
    }
    
    public function confeccionarDiploma($inscripcion_id) : array
    {
        $validacion = array('usuario' => '', 'documento' => '', 'taller' => '', 'cu' => '', 'fecha_cierre' => '', 'carga_horaria' => '');
        $datos = DataBase::sentenciar("SELECT CONCAT(u.apellido, ' ', u.nombre) AS usuario, CONCAT(dt.denominacion_corta, ' ', u.documento_nro) AS documento, t.titulo AS taller, d.codigo_verificacion AS cu, t.fecha_cierre, t.carga_horaria FROM usuario u
            INNER JOIN documento_tipo dt ON dt.id = u.documento_tipo_id
            INNER JOIN inscripcion i ON i.usuario_id = u.id
            INNER JOIN taller t ON t.id = i.taller_id
            INNER JOIN diploma d ON d.id = i.diploma_id
            WHERE i.id = ".$inscripcion_id.";");
        $fila = $datos->fetch();
        if($datos->rowCount() == 1){
            $validacion['usuario'] = $fila['usuario'];
            $validacion['documento'] = $fila['documento'];
            $validacion['taller'] = $fila['taller'];
            $validacion['cu'] = $fila['cu'];
            $validacion['fecha_cierre'] = $fila['fecha_cierre'];
            $validacion['carga_horaria'] = $fila['carga_horaria'];
        }
        return $validacion;
    }

    public function verificarDiploma($codigo_verificacion) : array
    {
        $validacion = array('estado' => false, 'bloque_smart_contract' => '');
        $datos = DataBase::sentenciar("SELECT bloque_smart_contract FROM diploma WHERE codigo_verificacion = '".$codigo_verificacion."';");
        $fila = $datos->fetch();
        if($datos->rowCount() == 1){
            $validacion['estado'] = true;
            $validacion['bloque_smart_contract'] = $fila['bloque_smart_contract'];
         }
        return $validacion;
    }

	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getCodigoVerificacion() { return $this->codigo_verificacion;	}
	public function setCodigoVerificacion($codigo_verificacion) { $this->codigo_verificacion = $codigo_verificacion; return $this;	}
	public function getBloqueSmartContract() { return $this->bloque_smart_contract;	}
	public function setBloqueSmartContract($bloque_smart_contract) { $this->bloque_smart_contract = $bloque_smart_contract; return $this;	}
	public function getFechaCreacion() { return $this->fecha_creacion;	}
	public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; return $this;	}
}
?>