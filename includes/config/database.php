<?php

function conectarDB(){
    $db = mysqli_connect('localhost', 'unikacor_user', 'Mercurial123.', 'unikacor_bienes_raices');

    if(!$db) {

    exit;
} else {
    
    return $db;
}
}
?>