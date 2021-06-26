<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'vendor/autoload.php');
    require_once($_SESSION['RAIZ'].'config.php');
    require_once($_SESSION['RAIZ'].'modelo/db.php');
    require_once($_SESSION['RAIZ'].'modelo/m_clase.php');
    require_once($_SESSION['RAIZ'].'modelo/m_contrasenia.php');
    require_once($_SESSION['RAIZ'].'modelo/m_diploma.php');
    require_once($_SESSION['RAIZ'].'modelo/m_direccion.php');
    require_once($_SESSION['RAIZ'].'modelo/m_documentoTipo.php');
    require_once($_SESSION['RAIZ'].'modelo/m_inscripcion.php');
    require_once($_SESSION['RAIZ'].'modelo/m_institucion.php');
    require_once($_SESSION['RAIZ'].'modelo/m_pais.php');
    require_once($_SESSION['RAIZ'].'modelo/m_suscripcion.php');
    require_once($_SESSION['RAIZ'].'modelo/m_taller.php');
    require_once($_SESSION['RAIZ'].'modelo/m_telefono.php');
    require_once($_SESSION['RAIZ'].'modelo/m_usuario.php');

?>