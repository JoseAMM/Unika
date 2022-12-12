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

	// while ($row = mysqli_fetch_assoc($consultaOtrasCaracteristicas)) {

	// 	global $row;
	// 	$consultaAmenidadesSecundario = "SELECT idAmenidades, NombreAmenidades FROM amenidades";
	// 	$resultadoAmenidadesSecundario = mysqli_query($db, $consultaAmenidadesSecundario);
	
	
	// 	while ($row2 = mysqli_fetch_assoc($resultadoAmenidadesSecundario)) :
	// 		if ($row['NombreAmenidades'] == $row2['NombreAmenidades']) {
	// 			echo $row['NombreAmenidades'];
	// 			echo $row2['NombreAmenidades'] . "\n\n";
	// 		} else {
	// 			echo "falso";
	// 		}
	// 	endwhile;
	// }
?>