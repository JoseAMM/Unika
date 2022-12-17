<?php
    //Sesion

    require '../../sesion.php';


    //Conexión a la base de datos

    require '../../../includes/config/database.php';


    $db = conectarDB();
	
	$cp = $_POST['cp'];
	$consultaColonia = "SELECT id, nombre FROM colonias WHERE Codigo_postal = $cp ";
    $resultadoColonia = mysqli_query($db, $consultaColonia);
	
	
	while($rowM = $resultadoColonia->fetch_assoc())
	{
		$html.= "<option value='".$rowM['id']."'>".$rowM['nombre']."</option>";
	}
	
	echo $html;
?>