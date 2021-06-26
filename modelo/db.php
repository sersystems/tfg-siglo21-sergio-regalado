<?php

class DataBase{

    //DATOS DE CONEXION
    private static $host="127.0.0.1";
    private static $port=3306;
    private static $username="root";
    private static $password="root";
    private static $dbname="biblioteca_popular_sur";

    private static function conectar() : PDO
    {
        try {
            $conexion = new PDO('mysql:
                host='.self::$host.';
                dbname='.self::$dbname.';
                port='.self::$port, 
                self::$username, 
                self::$password);
            return $conexion;
        } catch (PDOException $e) {
            die('Error BD001. No se ha logrado establecer la conexi&oacute;n con la Base de Datos. '.$e->getMessage());
            exit;
        }
    }

    public static function sentenciar($sentencia) : PDOStatement
    {
        $PDOStatement = new PDOStatement();
        try {
            $conexion = self::conectar();
            $PDOStatement = $conexion->query($sentencia);
        } catch (PDOException $e) {
            echo 'Error BD002. No se ha logrado ejecutar la sentencia. '.$e->getMessage();
        }
        return $PDOStatement;
    }

    public static function respaldarDB() : array
    {
        $verificacion = array('estado' => false, 'nombre' => '', 'mensaje' => 'La base de datos No se ha logrado respaldar.');
        $respaldo_ruta = $_SESSION['RAIZ'].'db_backup/';
        $respaldo_nombre = 'backupTFG_fecha'.date('(Y-m-d_H.i').'hs).sql';
        $respaldo_destino = $respaldo_ruta.$respaldo_nombre;
        $comando = '"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump" --opt -h '.self::$host.' -port='.self::$port.' -u '.self::$username.' -p'.self::$password.' '.self::$dbname.' > '.$respaldo_destino; 
        system($comando, $proceso); //Ejecuta el proceso de backup
        if ($proceso == 0) { 
            $verificacion['estado'] = true; 
            $verificacion['nombre'] = $respaldo_nombre; 
            $verificacion['mensaje'] = 'La base de datos se ha respaldado satisfactoriamente.'; 
        }
        return array($verificacion);
    }

    public static function restaurarDB($respaldo_nombre) : array
    {
        $verificacion = array('estado' => false, 'nombre' => '', 'mensaje' => 'La base de datos No se ha logrado restaurar.');
        if(!empty($respaldo_nombre)){
            $respaldo_origen = $_SESSION['RAIZ'].'db_backup/'.$respaldo_nombre;
            $comando = '"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql" -h '.self::$host.' -port='.self::$port.' -u '.self::$username.' -p'.self::$password.' '.self::$dbname.' < '.$respaldo_origen; 
            system($comando, $proceso); //Ejecuta el proceso de backup
            if ($proceso == 0) { 
                $verificacion['estado'] = true; 
                $verificacion['nombre'] = $respaldo_nombre; 
                $verificacion['mensaje'] = 'La base de datos se ha restaurado satisfactoriamente.'; 
            }
        }else{ $verificacion['mensaje'] = 'Debe seleccionar una copia de seguridad.'; }
        return array($verificacion);
    }

    public static function generarId($tabla) : int
    {
        $id = 1;
        try {
            $conexion = self::conectar();
            $dato = $conexion->query('SELECT MAX(id) AS id FROM '.$tabla);
            $id += $dato->fetch()['id'];
        } catch (PDOException $e) {
            echo 'Error BD005. No se ha logrado generar el ID. '.$e->getMessage();
        }
        return $id;
    }
}
?>