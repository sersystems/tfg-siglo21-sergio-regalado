<?php

class Cfg
{
    public static function encriptarContrasenia($contrasenia, $hashOriginal) : string
    {
        $hash = $hashOriginal;
        if(strlen($contrasenia) >= 8 && strlen($contrasenia) <= 12){ //Detección de modificación de contraseña
            $opciones = ['cost' => 12];
            $hash = password_hash($contrasenia, PASSWORD_BCRYPT, $opciones);
        }
        return $hash;
    }

    public static function comprobarContrasenia($contrasenia) : array
    {
        $verificacion = array('p1' => false, 'p2' => false, 'p3' => false, 'p4' => false);
        $numeros = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $mayusculas = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $minusculas = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');              
        $simbolosPermitidos = array('#', '$', '%', '&', '*', '+', '-', '.', '@', '^', '_', '|', '~');              
        if(strlen($contrasenia) >= 8 && strlen($contrasenia) <= 12){
            for ($i=0; $i < strlen($contrasenia); $i++) {
                for ($n=0; $n < count($numeros); $n++) { if ($contrasenia[$i] == $numeros[$n]) { $verificacion['p1'] = true; }}
                for ($y=0; $y < count($mayusculas); $y++) { if ($contrasenia[$i] == $mayusculas[$y]) { $verificacion['p2'] = true; }}
                for ($m=0; $m < count($minusculas); $m++) { if ($contrasenia[$i] == $minusculas[$m]) { $verificacion['p3'] = true; }}
                for ($p=0; $p < count($simbolosPermitidos); $p++) { if ($contrasenia[$i] == $simbolosPermitidos[$p]) { $verificacion['p4'] = true; }}
            }
            if ($verificacion['p1'] == false) { return array('estado' => false, 'mensaje' => 'La contraseña debe contener al menos un número.');
            }elseif($verificacion['p2'] == false) { return array('estado' => false, 'mensaje' => 'La contraseña debe contener al menos una mayúscula.');
            }elseif($verificacion['p3'] == false) { return array('estado' => false, 'mensaje' => 'La contraseña debe contener al menos una minúscula.');
            }elseif($verificacion['p4'] == false) { return array('estado' => false, 'mensaje' => 'La contraseña debe contener al menos un símbolo permitido.'); }
        }else { return array('estado' => false, 'mensaje' => 'La contraseña debe tener entre 8 a 12 caracteres.'); }
        return array('estado' => true, 'mensaje' => 'OK');
    }

    public static function obtenerPublicKeyMP() : string
    {
        return 'TEST-135113ab-5cd6-4fe7-806d-1f76dc8fca33';
    }
    
    public static function obtenerAccessTokenMP() : string
    {
        return 'TEST-2527268415868067-060106-f7b25e72af428a058e21246d6d3a26d0-40796759';
    }
}
?>
