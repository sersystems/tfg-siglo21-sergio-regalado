<?php 

    if(session_status() != 2) session_start();
    require_once($_SESSION['RAIZ'].'controlador/router.php');


    if (isset($_GET['operacion']) && $_GET['operacion'] == 'respaldar') {
        echo json_encode(DataBase::respaldarDB());
    }  

    if (isset($_GET['operacion']) && $_GET['operacion'] == 'restaurar') {
        echo json_encode(DataBase::restaurarDB($_GET['respaldo_nombre']));        
    } 
    
?>