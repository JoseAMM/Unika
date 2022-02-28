<?php

function conectarDB(){
    $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');

    if(!$db) {
    echo "Error en la conexión";
    exit;
} else {
    echo "Conexion Correcta";
    return $db;
}

}
?>

