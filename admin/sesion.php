<?php     
session_start();


if(isset($_SESSION['login'])){
    $auth = $_SESSION['login'];
    $idUsuarios = $_SESSION['idUsuarios'];
    $time = $_SESSION['time'];
    if ($_SESSION['rolUsuarios'] != 1){
        header('Location: ../../../login/index.php');
    }
}


if(!isset($auth)){
    header('Location:../../../login/index.php');
} else {
    if ((time() -  $time) > 180000) {
        header('Location: ../../cerrar-sesion.php');
    }
}

