<?php

//Conexión a la base de datos

require '../../../includes/config/database.php';

$db = conectarDB();

    $idDocumento = $_GET['del'];
    $idDocumento = filter_var($idDocumento, FILTER_VALIDATE_INT);

    $idInmueble = $_GET['id'];
    
    if(!$idDocumento) {
        header('Location: ../Listado/index.php');
    }

    $queryBuscar = "SELECT idDocumentos FROM documentos WHERE id_Inmueble_Documentos = $idInmueble ORDER BY idDocumentos";

    // echo $queryBuscar;
    $resultadoBuscar = mysqli_query($db, $queryBuscar);
    // $resultadoBuscar = mysqli_fetch_assoc($resultadoBuscar);
    // echo '<pre>';
    // var_dump($resultadoBuscar) ;
    // echo '</pre>';

    $contador = 1;
    while($row =  mysqli_fetch_assoc($resultadoBuscar)){

        echo $contador;
        
        if($contador == $idDocumento){
            $documento = $row['idDocumentos'];
            $queryBorrar = "DELETE FROM documentos WHERE documentos.idDocumentos = '$documento'";
            echo  $queryBorrar  . '<br>';
            $resultadoBorrar = mysqli_query($db, $queryBorrar);
        }
        $contador = $contador + 1 ;
    }


    header('Location: ../Listado/index.php')

?>