<?php

function conectarDB(){
    // $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');
    $db = mysqli_connect('localhost', 'unikabie_admin', 'Ivan1975*', 'unikabie_bienesraices');
    
    if(!$db) {

    exit;
} else {
    
    return $db;
}
}
?>

<!-- $db = mysqli_connect('localhost', 'unikacor_user', 'Mercurial123.', 'unikacor_bienes_raices'); -->