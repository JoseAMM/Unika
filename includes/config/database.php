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




<!-- // function conectarDB(){
//     $db = mysqli_connect('localhost', 'id18485046_root', '1co%NG~[O\L=Z|Vg', 'id18485046_bienes_raices');

//     if(!$db) {
    
//     exit;
// } else {
    
//     return $db;
// }

// } -->
