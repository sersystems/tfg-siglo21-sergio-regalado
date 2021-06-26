<?php

class Clase{
    
	private $id;
	private Taller $taller;
	private $titulo;
	private $numero;
	private $fecha;
	private $horario;
	private $duracion;
	private $estado;
    
    function __construct() 
    {
        if(func_num_args() == 8){
            $this->id = func_get_arg(0);
            $this->taller = func_get_arg(1);
            $this->titulo = func_get_arg(2);
            $this->numero = func_get_arg(3);
            $this->fecha = func_get_arg(4);
            $this->horario = func_get_arg(5);
            $this->duracion = func_get_arg(6);
            $this->estado = func_get_arg(7);
        }
    }

    public function actualizar() : Clase
	{
        if($this->id > 0){
            DataBase::sentenciar("UPDATE clase SET 
                taller_id = ".$this->taller->getId().",
                titulo = UPPER('".$this->titulo."'),
                numero = ".$this->numero.",
                fecha = '".$this->fecha."',
                horario = '".$this->horario."',
                duracion = ".$this->duracion.",
                estado = UPPER('".$this->estado."') WHERE id = ".$this->id.";");
        }
        return $this;
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM clase WHERE id = ".$id.";");
	}

	public function insertar() : Clase
	{
        $this->id = DataBase::generarId('clase');
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO clase (id, taller_id, titulo, numero, fecha, horario, duracion, estado) VALUES (
                ".$this->id.",
                ".$this->taller->getId().",
                UPPER('".$this->titulo."'),
                ".$this->numero.",
                '".$this->fecha."',
                '".$this->horario."',
                ".$this->duracion.",
                UPPER('".$this->estado."'));");
        }
        return $this;
	}

    public function obtener($id) : Clase
    {
        $datos = DataBase::sentenciar("SELECT * FROM clase WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Clase(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM clase WHERE id = ".$valor.";"); }
        if ($filtro == "taller_id") { $datos = DataBase::sentenciar("SELECT * FROM clase WHERE taller_id = ".$valor.";"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Clase();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }
  
    private function instanciar($fila) : Clase
    {
        $this->id = $fila['id'];
        $this->taller = ($fila['taller_id'] > 0) ? (new Taller())->obtener($fila['taller_id']) : new Taller();
        $this->titulo = $fila['titulo'];
        $this->numero = $fila['numero'];
        $this->fecha = $fila['fecha'];
        $this->horario = $fila['horario'];
        $this->duracion = $fila['duracion'];
        $this->estado = $fila['estado'];
        return $this;
    }

    public function crearMatriz(Clase $clase)
    {
        return array( 
            'id' => $clase->id,
            'taller_id' => $clase->taller->getId(),
            'titulo' => $clase->titulo,
            'numero' => $clase->numero,
            'fecha' => $clase->fecha,
            'horario' => $clase->horario,
            'duracion' => $clase->duracion,
            'estado' => $clase->estado
        );
    }
    
	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getTaller() { return $this->taller;	}
	public function setTaller( $taller) { $this->taller = $taller; return $this;	}
	public function getTitulo() { return $this->titulo; }
	public function setTitulo($titulo) { $this->titulo = $titulo; return $this; }
	public function getNumero() { return $this->numero;	}
	public function setNumero($numero) { $this->numero = $numero; return $this;	}
	public function getFecha() { return $this->fecha;	}
	public function setFecha($fecha) { $this->fecha = $fecha; return $this;	}
	public function getHorario() { return $this->horario;	}
	public function setHorario($horario) { $this->horario = $horario; return $this;	}
	public function getDuracion() { return $this->duracion;	}
	public function setDuracion($duracion) { $this->duracion = $duracion; return $this;	}
	public function getEstado() { return $this->estado;	}
	public function setEstado($estado) { $this->estado = $estado; return $this;	}
}
?>