<?php 
    session_start();
    var_dump($_SESSION);

    $auth = $_SESSION['login'];

    if(!$auth){
        header('Location: ../login/index.php');
    }
?>