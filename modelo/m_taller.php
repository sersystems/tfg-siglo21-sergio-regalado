<?php

class Taller{

	private $id;
	private $titulo;	
	private $dia_horario;
	private $fecha_inicio;
	private $fecha_cierre;
	private $carga_horaria;
	private $cupo_max;
	private $cupo_actual;
	private $estado;
	private $fecha_creacion;
	private $fecha_modificacion;

    function __construct() 
    {
        if(func_num_args() == 11){
            $this->id = func_get_arg(0);
            $this->titulo = func_get_arg(1);
            $this->dia_horario = func_get_arg(2);
            $this->fecha_inicio = func_get_arg(3);
            $this->fecha_cierre = func_get_arg(4);
            $this->carga_horaria = func_get_arg(5);
            $this->cupo_max = func_get_arg(6);
            $this->cupo_actual = func_get_arg(7);
            $this->estado = func_get_arg(8);
            $this->fecha_creacion = func_get_arg(9);
            $this->fecha_modificacion = func_get_arg(10);
        }
    }

	public function actualizar() : Taller
	{
        if($this->id > 0){
            DataBase::sentenciar("UPDATE taller SET 
                titulo = UPPER('".$this->titulo."'),
                dia_horario = UPPER('".$this->dia_horario."'),
                fecha_inicio = '".$this->fecha_inicio."',
                fecha_cierre = '".$this->fecha_cierre."',
                cupo_max = ".$this->cupo_max.",
                estado = UPPER('".$this->estado."'),
                fecha_modificacion = CURRENT_TIMESTAMP WHERE id = ".$this->id.";");
            $this->actualizarCargaHoraria($this->id); //Importante: actualiza la carga horaria automáticamente.
            $this->actualizarCupo($this->id); //Importante: actualiza el cupo automáticamente.
        }
        return $this;
	}

    private function actualizarCargaHoraria($id) : void
	{
        if($id > 0){
            $datos = DataBase::sentenciar("SELECT SUM(c.duracion) AS carga_horaria FROM taller t 
                INNER JOIN clase c ON c.taller_id = t.id 
                WHERE t.id = ".$id.";");
            $this->carga_horaria = (int)$datos->fetchColumn(0) + 0;
            DataBase::sentenciar("UPDATE taller SET carga_horaria = (".$this->carga_horaria.") WHERE taller.id = ".$id.";");
        }
	}

    private function actualizarCupo($id) : void
	{
        if($id > 0){
            $datos = DataBase::sentenciar("SELECT (count(*)) AS cupo FROM taller t 
                INNER JOIN inscripcion i ON i.taller_id = t.id 
                WHERE t.id = ".$id.";");
            $this->cupo_actual = $this->cupo_max - (int)$datos->fetchColumn(0);
            DataBase::sentenciar("UPDATE taller SET cupo_actual = (".$this->cupo_actual.") WHERE taller.id = ".$id.";");
        }
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM taller WHERE id = ".$id.";");
	}

	public function insertar() : Taller
	{
        $this->id = DataBase::generarId('taller');
        $this->carga_horaria = 0;
        $this->cupo_actual = $this->cupo_max;
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO taller (id, titulo, dia_horario, fecha_inicio, fecha_cierre, carga_horaria, cupo_max, cupo_actual, estado) VALUES (
                ".$this->id.",
                UPPER('".$this->titulo."'),
                UPPER('".$this->dia_horario."'),
                '".$this->fecha_inicio."',
                '".$this->fecha_cierre."',
                ".$this->carga_horaria.",
                ".$this->cupo_max.",
                ".$this->cupo_actual.",
                UPPER('".$this->estado."'));");
        }
        return $this;
	}

    public function obtener($id) : Taller
    {
        $datos = DataBase::sentenciar("SELECT * FROM taller WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Taller(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM taller WHERE id = ".$valor.";"); }
        if ($filtro == "titulo") { $datos = DataBase::sentenciar("SELECT * FROM taller WHERE titulo LIKE '%".$valor."%';"); }
        if ($filtro == "taller_disponibilidad") { $datos = DataBase::sentenciar("SELECT * FROM taller WHERE estado = 'PENDIENTE' AND cupo_actual > 0;"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Taller();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }
 
	private function instanciar($fila) : Taller
    {
        $this->id = $fila['id'];
        $this->titulo = $fila['titulo'];
        $this->dia_horario = $fila['dia_horario'];
        $this->fecha_inicio = $fila['fecha_inicio'];
        $this->fecha_cierre = $fila['fecha_cierre'];
        $this->carga_horaria = $fila['carga_horaria'];
        $this->cupo_max = $fila['cupo_max'];
        $this->cupo_actual = $fila['cupo_actual'];
        $this->estado = $fila['estado'];
		$this->fecha_creacion = $fila['fecha_creacion'];
        $this->fecha_modificacion = $fila['fecha_modificacion'];
        return $this;
    }

    public function crearMatriz(Taller $taller)
    {
        return array( 
            'id' => $taller->id,
            'titulo' => $taller->titulo,
            'dia_horario' => $taller->dia_horario,
            'fecha_inicio' => $taller->fecha_inicio,
            'fecha_cierre' => $taller->fecha_cierre,
            'carga_horaria' => $taller->carga_horaria,
            'cupo_max' => $taller->cupo_max,
            'cupo_actual' => $taller->cupo_actual,
            'estado' => $taller->estado,
            'fecha_creacion' => $taller->fecha_creacion,
            'fecha_modificacion' => $taller->fecha_modificacion
        );
    }

	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getTitulo() { return $this->titulo; }
	public function setTitulo($titulo) { $this->titulo = $titulo; return $this; }
	public function getDescripcion_corta() { return $this->dia_horario;	}
	public function setDescripcion_corta($dia_horario) { $this->dia_horario = $dia_horario; return $this;	}
	public function getFechaInicio() { return $this->fecha_inicio;	}
	public function setFechaInicio($fecha_inicio) { $this->fecha_inicio = $fecha_inicio; return $this;	}
	public function getFechaCierre() { return $this->fecha_cierre;	}
	public function setFechaCierre($fecha_cierre) { $this->fecha_cierre = $fecha_cierre; return $this;	}
	public function getCargaHoraria() { return $this->carga_horaria;	}
	public function setCargaHoraria($carga_horaria) { $this->carga_horaria = $carga_horaria; return $this;	}
    public function getCupoMax() { return $this->cupo_max;	}
	public function setCupoMax($cupo_max) { $this->cupo_max = $cupo_max; return $this;	}
    public function getCupoActual() { return $this->cupo_actual;	}
	public function setCupoActual($cupo_actual) { $this->cupo_actual = $cupo_actual; return $this;	}
    public function getEstado() { return $this->estado; }
	public function setEstado($estado) { $this->estado = $estado; return $this;	}
	public function getFechaCreacion() { return $this->fecha_creacion;	}
	public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; return $this;	}
	public function getFechaModificacion() { return $this->fecha_modificacion;	}
	public function setFechaModificacion($fecha_modificacion) { $this->fecha_modificacion = $fecha_modificacion; return $this;	}
}
?>