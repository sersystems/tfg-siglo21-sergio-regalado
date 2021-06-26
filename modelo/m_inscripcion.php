<?php

class Inscripcion{
    
	private $id;
	private Usuario $usuario;
	private Taller $taller;
	private $fecha_inscripcion;
	private $asistencia_final;
	private $calificacion_final;
	private $situacion_cursada;
	private Diploma $diploma;
    
    function __construct() 
    {
        if(func_num_args() == 8){
            $this->id = func_get_arg(0);
            $this->usuario = func_get_arg(1);
            $this->taller = func_get_arg(2);
            $this->fecha_inscripcion = func_get_arg(3);
            $this->asistencia_final = func_get_arg(4);
            $this->calificacion_final = func_get_arg(5);
            $this->situacion_cursada = func_get_arg(6);
            $this->diploma = func_get_arg(7);
        }
    }

    public function actualizar() : Inscripcion
	{
        $diploma_id = (!empty($this->diploma->getId())) ? $this->diploma->getId() : 'null';
        if($this->id > 0){
            DataBase::sentenciar("UPDATE inscripcion SET 
                usuario_id = ".$this->usuario->getId().",
                taller_id = ".$this->taller->getId().",
                fecha_inscripcion = '".$this->fecha_inscripcion."',
                asistencia_final = ".$this->asistencia_final.",
                calificacion_final = ".$this->calificacion_final.",
                situacion_cursada = UPPER('".$this->situacion_cursada."'),
                diploma_id = ".$diploma_id." WHERE id = ".$this->id.";");
        }
        return $this;
	}

    public function actualizarIdDiploma($id, $diploma_id) : void
	{
        if($id > 0){
            DataBase::sentenciar("UPDATE inscripcion SET diploma_id = ".$diploma_id." WHERE id = ".$id.";");
        }
	}

	public function eliminar($id) : void
	{
        DataBase::sentenciar("DELETE FROM inscripcion WHERE id = ".$id.";");
	}

	public function insertar() : Inscripcion
	{
        $this->id = DataBase::generarId('inscripcion');
        $diploma_id = (!empty($this->diploma->getId())) ? $this->diploma->getId() : 'null';
        if($this->id > 0){
            DataBase::sentenciar("INSERT INTO inscripcion (id, usuario_id, taller_id, fecha_inscripcion, asistencia_final, calificacion_final, situacion_cursada, diploma_id) VALUES (
                ".$this->id.",
                ".$this->usuario->getId().",
                ".$this->taller->getId().",
                '".$this->fecha_inscripcion."',
                ".$this->asistencia_final.",
                ".$this->calificacion_final.",
                UPPER('".$this->situacion_cursada."'),
                ".$diploma_id.");");
        }
        return $this;
	}

    public function obtener($id) : Inscripcion
    {
        $datos = DataBase::sentenciar("SELECT * FROM inscripcion WHERE id = ".$id.";");
        if($datos->rowCount() == 1){ return $this->instanciar($datos->fetch()); }
        else{ return new Inscripcion(); }
    }
  
    public function listar($filtro, $valor) : ArrayObject
    {
        $listado = new ArrayObject();
        if ($filtro == "id") { $datos = DataBase::sentenciar("SELECT * FROM inscripcion WHERE id = ".$valor.";"); }
        if ($filtro == "usuario_id") { $datos = DataBase::sentenciar("SELECT * FROM inscripcion WHERE usuario_id = ".$valor.";"); }
        if ($filtro == "taller_id") { $datos = DataBase::sentenciar("SELECT * FROM inscripcion WHERE taller_id = ".$valor.";"); }
        if(isset($datos) && $datos->rowCount() > 0){
            while ($fila = $datos->fetch()) {
                $objeto = new Inscripcion();
                $listado->append($objeto->instanciar($fila));
            }
        }
        return $listado;
    }
  
    private function instanciar($fila) : Inscripcion
    {
        $this->id = $fila['id'];
        $this->usuario = ($fila['usuario_id'] > 0) ? (new Usuario())->obtener($fila['usuario_id']) : new Usuario();
        $this->taller = ($fila['taller_id'] > 0) ? (new Taller())->obtener($fila['taller_id']) : new Taller();
        $this->fecha_inscripcion = $fila['fecha_inscripcion'];
        $this->asistencia_final = $fila['asistencia_final'];
        $this->calificacion_final = $fila['calificacion_final'];
        $this->situacion_cursada = $fila['situacion_cursada'];
        $this->diploma = ($fila['diploma_id'] > 0) ? (new Diploma())->obtener($fila['diploma_id']) : new Diploma();
        return $this;
    }

    public function crearMatriz(Inscripcion $inscripcion)
    {
        return array( 
            'id' => $inscripcion->id,
            'usuario_id' => $inscripcion->usuario->getId(),
            'taller_id' => $inscripcion->taller->getId(),
            'fecha_inscripcion' => $inscripcion->fecha_inscripcion,
            'asistencia_final' => $inscripcion->asistencia_final,
            'calificacion_final' => $inscripcion->calificacion_final,
            'situacion_cursada' => $inscripcion->situacion_cursada,
            'diploma' => array(
                'id' => $inscripcion->diploma->getId(),
                'codigo_verificacion' => $inscripcion->diploma->getCodigoVerificacion(),
                'bloque_smart_contract' => $inscripcion->diploma->getBloqueSmartContract(),
                'fecha_creacion' => $inscripcion->diploma->getFechaCreacion())
        );
    }
    
    public function verificarDobleInscripcion($usuario_id, $taller_id) : bool
    {
        $verificacion = true;
        $datos = DataBase::sentenciar("SELECT count(*) FROM usuario u 
            INNER JOIN inscripcion i ON i.usuario_id = u.id 
            WHERE (i.situacion_cursada = 'EN CURSO' OR i.situacion_cursada = 'PENDIENTE') AND u.id = ".$usuario_id." AND i.taller_id = ".$taller_id.";");
        $cuenta = ($datos->rowCount() > 0) ? $datos->fetchColumn(0) : 0 ;
        if ($cuenta > 0) { $verificacion = false; }
        return $verificacion;
    }

    public function verificarLimiteInscripcion($usuario_id) : bool
    {
        $verificacion = true;
        $datos = DataBase::sentenciar("SELECT count(*) FROM usuario u 
            INNER JOIN inscripcion i ON i.usuario_id = u.id 
            WHERE (i.situacion_cursada = 'EN CURSO' OR i.situacion_cursada = 'PENDIENTE') AND u.id = ".$usuario_id.";");
        $cuenta = ($datos->rowCount() > 0) ? $datos->fetchColumn(0) : 0 ;
        if ($cuenta >= 3) { $verificacion = false; }
        return $verificacion;
    }

	public function getId() { return $this->id; }
	public function setId($id) { $this->id = $id; return $this; }
	public function getUsuario() { return $this->usuario;	}
	public function setUsuario(Usuario $usuario) { $this->usuario = $usuario; return $this;	}
	public function getTaller() { return $this->taller;	}
	public function setTaller(Taller $taller) { $this->taller = $taller; return $this;	}
	public function getFechaAlta() { return $this->fecha_inscripcion; }
	public function setFechaAlta($fecha_inscripcion) { $this->fecha_inscripcion = $fecha_inscripcion; return $this; }
	public function getCalificacionFinal() { return $this->calificacion_final;	}
	public function setCalificacionFinal($calificacion_final) { $this->calificacion_final = $calificacion_final; return $this;	}
	public function getEstadoCurso() { return $this->situacion_cursada; }
	public function setEstadoCurso($situacion_cursada) { $this->situacion_cursada = $situacion_cursada; return $this; }
	public function getDiploma() { return $this->diploma;	}
	public function setDiploma(Diploma $diploma) { $this->diploma = $diploma; return $this;	}
}
?>