<?php

function conectarDB(){
    $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');

    if(!$db) {

    exit;
} else {
    
    return $db;
}
}
?>