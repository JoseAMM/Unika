<?php

//Sesion

require '../../sesion.php';


$idInmueble = $_GET['id'];
$idInmueble = filter_var($idInmueble, FILTER_VALIDATE_INT);

if (!$idInmueble) {
    header('Location:../../');
}


//Conexión a la base de datos

require '../../../includes/config/database.php';

$db = conectarDB();


// Consulta del nombre y rol del usuario 

$queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

$resultadoEmpleadoNombre = mysqli_query($db, $queryEmpleado);

$resultadoEmpleadoNombre = mysqli_fetch_assoc($resultadoEmpleadoNombre);

$idRolEmpleado = $resultadoEmpleadoNombre['Rol_idRol'];

$idRolEmpleado = (int)$idRolEmpleado;


$queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
$resultadoRolEmpleado = mysqli_query($db, $queryRol);
$resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);



$errores = [];

// Consulta de los asesores activos para el select

$consultaAsesor = "SELECT * FROM empleado WHERE Activo = 1";
$resultadoAsesor = mysqli_query($db, $consultaAsesor);

// Consulta de los tipos de contratos activos para el select

$consultaContrato = "SELECT idTipo_Contrato, Nombre_Contrato, Activo FROM tipo_contrato WHERE Activo = 1";
$resultadoContrato = mysqli_query($db, $consultaContrato);

// Consulta de los tipos de inmueble activos para el select

$consultaInmueble = "SELECT idTipo_Inmueble, Nombre_Tipo_Inmueble, Activo FROM tipo_inmueble WHERE Activo = 1;";
$resultadoInmueble = mysqli_query($db, $consultaInmueble);

// Consulta de los tipos de operación activos para el select

$consultaOperacion = "SELECT idTipo_Operacion, Nombre_Operacion, Activo FROM tipo_operacion WHERE Activo = 1;";
$resultadoOperacion = mysqli_query($db, $consultaOperacion);

// Consulta de los clientes activos para el select 

$consultaCliente = "SELECT idCliente, Correo FROM cliente WHERE Activo = 1;";
$resultadoCliente = mysqli_query($db, $consultaCliente);




// Consulta de la información del inmueble

$consultaDatosInmueble = "SELECT
            empleado.idEmpleado,
            tipo_contrato.idTipo_Contrato,
            tipo_inmueble.idTipo_Inmueble,
            tipo_operacion.idTipo_Operacion,
            inmueble.idCliente
        FROM
            (
                (
                    (
                        (
                            inmueble
                            INNER JOIN empleado ON inmueble.id_Empleado = empleado.idEmpleado
                        )
                        INNER JOIN tipo_contrato ON inmueble.idTipo_Contrato = tipo_contrato.idTipo_Contrato
                    )
                    INNER JOIN tipo_inmueble ON inmueble.idTipo_Inmueble = tipo_inmueble.idTipo_Inmueble
                )
                INNER JOIN tipo_operacion ON inmueble.idTipo_Operacion = tipo_operacion.idTipo_Operacion
            )
        WHERE
            idInmueble = '$idInmueble' ";

$consultaDatosInmueble = mysqli_fetch_assoc(mysqli_query($db, $consultaDatosInmueble));

$consultaCaracteristicas = "SELECT * FROM caracteristicas WHERE idInmueble_Caracteristicas = $idInmueble";
$consultaCaracteristicas = mysqli_fetch_assoc(mysqli_query($db, $consultaCaracteristicas));


$consultaDatosBasicos = "SELECT * FROM datos_basicos WHERE Inmueble_idInmueble = $idInmueble";
$consultaDatosBasicos = mysqli_fetch_assoc(mysqli_query($db, $consultaDatosBasicos));


$asesor = $consultaDatosInmueble['idEmpleado'];
$contrato = $consultaDatosInmueble['idTipo_Contrato'];
$inmueble = $consultaDatosInmueble['idTipo_Inmueble'];
$operacion = $consultaDatosInmueble['idTipo_Operacion'];
$cliente = $consultaDatosInmueble['idCliente'];
$superficie_terreno = (int)$consultaCaracteristicas['Superficie_Terreno'];
$superficie_construccion = (int)$consultaCaracteristicas['Superficie_Construccion'];
$habitaciones = $consultaCaracteristicas['Habitaciones'];
$estacionamiento = $consultaCaracteristicas['Puestos_Estacionamiento'];
$otras = $consultaCaracteristicas['Otras_Caracteristicas'];
$direccion = $consultaDatosBasicos['Direccion'];
$precio = $consultaDatosBasicos['Precio'];
$ubicacion = $consultaDatosBasicos['Ubicacion_Maps'];
$urlAnuncio = $consultaDatosBasicos['Url_anuncio_web'];
$urlVideo = $consultaDatosBasicos['Url_video'];
$colonia = $consultaDatosBasicos['Colonias_idColonias'];

// Consulta de las colonias para el select
$consultaColonia = "SELECT Codigo_postal FROM colonias WHERE id = $colonia";
$resultadoColonia = mysqli_query($db, $consultaColonia);
$resultadoColonia = mysqli_fetch_assoc($resultadoColonia);
$resultadoColonia = $resultadoColonia['Codigo_postal'];
$cp = $resultadoColonia;

$consultaColonia = "SELECT id, nombre, Codigo_postal FROM colonias WHERE Codigo_postal = $resultadoColonia";
$resultadoColonia = mysqli_query($db, $consultaColonia);


// Consulta de las fotos asociadas al inmueble
$consultaFotos = "SELECT NombreFotos FROM fotos WHERE id_Inmueble_Fotos = $idInmueble";
$consultaFotos =  mysqli_query($db, $consultaFotos);


$n = 1;

while ($row = $consultaFotos->fetch_assoc()) {
    switch ($n){
        case 1:
            $foto1 = $consultaFotos['NombreFotos'];
            break;
        case 2:
            $foto2 = $consultaFotos['NombreFotos'];
            break;
        case 3:
            $foto3 = $consultaFotos['NombreFotos'];
            break;
        case 4:
            $foto4 = $consultaFotos['NombreFotos'];
            break;
        case 5:
            $foto5 = $consultaFotos['NombreFotos'];
            break;
        case 6:
            $foto6 = $consultaFotos['NombreFotos'];
            break;
        case 7:
            $foto7= $consultaFotos['NombreFotos'];
            break;
        case 8:
            $foto8 = $consultaFotos['NombreFotos'];
            break;
        case 9:
            $foto9 = $consultaFotos['NombreFotos'];
            break;
        case 10:
            $foto10 = $consultaFotos['NombreFotos'];
            break;
        case 11:
            $foto11 = $consultaFotos['NombreFotos'];
            break;
        case 12:
            $foto12 = $consultaFotos['NombreFotos'];
            break;
        case 13:
            $foto13 = $consultaFotos['NombreFotos'];
            break;
        case 14:
            $foto14 = $consultaFotos['NombreFotos'];
            break;
        case 15:
            $foto15 = $consultaFotos['NombreFotos'];
            break;
    }

    $n++;
}



if ($foto1 == NULL) {
    $foto1 = "vacio.png";
}
if ($foto2 == NULL) {
    $foto2 = "vacio.png";
}
if ($foto3 == NULL) {
    $foto3 = "vacio.png";
}
if ($foto4 == NULL) {
    $foto4 = "vacio.png";
}
if ($foto5 == NULL) {
    $foto5 = "vacio.png";
}
if ($foto6 == NULL) {
    $foto6 = "vacio.png";
}
if ($foto7 == NULL) {
    $foto7 = "vacio.png";
}
if ($foto8 == NULL) {
    $foto8 = "vacio.png";
}
if ($foto9 == NULL) {
    $foto9 = "vacio.png";
}
if ($foto10 == NULL) {
    $foto10 = "vacio.png";
}
if ($foto11 == NULL) {
    $foto11 = "vacio.png";
}
if ($foto12 == NULL) {
    $foto12 = "vacio.png";
}
if ($foto13 == NULL) {
    $foto13 = "vacio.png";
}
if ($foto14 == NULL) {
    $foto14 = "vacio.png";
}
if ($foto15 == NULL) {
    $foto15 = "vacio.png";
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Asignación de variables y escape de datos para la prevención de inyección SQL
    $asesor = $_POST['asesor'];
    $contrato = $_POST['contrato'];
    $inmueble = $_POST['inmueble'];
    $operacion = $_POST['operacion'];
    $colonia = $_POST['colonia'];
    $cliente = $_POST['cliente'];

    $superficie_terreno = filter_var(mysqli_real_escape_string($db, $_POST['superficie_terreno']), FILTER_SANITIZE_NUMBER_FLOAT);
    $superficie_construccion = filter_var(mysqli_real_escape_string($db, $_POST['superficie_construccion']), FILTER_SANITIZE_NUMBER_FLOAT);
    $habitaciones = filter_var(mysqli_real_escape_string($db, $_POST['habitaciones']), FILTER_SANITIZE_NUMBER_INT);
    $estacionamiento = filter_var(mysqli_real_escape_string($db, $_POST['estacionamiento']), FILTER_SANITIZE_NUMBER_INT);
    $otras = mysqli_real_escape_string($db, $_POST['otras']);
    $direccion = mysqli_real_escape_string($db, $_POST['direccion']);
    $precio = filter_var(mysqli_real_escape_string($db, $_POST['precio']), FILTER_SANITIZE_NUMBER_FLOAT);
    $ubicacion = mysqli_real_escape_string($db, $_POST['ubicacion']);
    $urlAnuncio = filter_var(mysqli_real_escape_string($db, $_POST['urlAnuncio']), FILTER_SANITIZE_URL);
    $urlVideo = filter_var(mysqli_real_escape_string($db, $_POST['urlVideo']), FILTER_SANITIZE_URL);

    $carpetaImagenes = "../Imagenes/";

    if (!is_dir($carpetaImagenes)) {
        mkdir($carpetaImagenes);
    }



    if ($_FILES['foto1']['size'] != 0) {

        $imagen1 = $_FILES['foto1'];
        $nombreImagen = 'inmueble_' . $idInmueble . 'foto1' . '.jpg';
        move_uploaded_file($imagen1['tmp_name'], $carpetaImagenes . $nombreImagen);

        if ($foto1 == "vacio.png") {

            $queryFotos = "INSERT INTO fotos1  (idFotos1) VALUES  ('$nombreImagen')";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos1 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        } else {

            $queryFotos = "UPDATE fotos1 SET idFotos1 = '$nombreImagen' WHERE idFotos1 = '$foto2'";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos1 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        }
    }

    if ($_FILES['foto2']['size'] != 0) {
        $imagen2 = $_FILES['foto2'];
        $nombreImagen = 'inmueble_' . $idInmueble . 'foto2' . '.jpg';
        move_uploaded_file($imagen2['tmp_name'], $carpetaImagenes . $nombreImagen);

        if ($foto2 == "vacio.png") {

            $queryFotos = "INSERT INTO fotos2  (idFotos2) VALUES  ('$nombreImagen')";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos2 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        } else {

            $queryFotos = "UPDATE fotos2 SET idFotos2 = '$nombreImagen' WHERE idFotos2 = '$foto2'";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos2 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        }
    }

    if ($_FILES['foto3']['size'] != 0) {

        $imagen3 = $_FILES['foto3'];
        $nombreImagen = 'inmueble_' . $idInmueble . 'foto3' . '.jpg';
        move_uploaded_file($imagen3['tmp_name'], $carpetaImagenes . $nombreImagen);

        if ($foto3 == "vacio.png") {

            $queryFotos = "INSERT INTO fotos3  (idFotos3) VALUES  ('$nombreImagen')";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos3 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        } else {

            $queryFotos = "UPDATE fotos3 SET idFotos3 = '$nombreImagen' WHERE idFotos3 = '$foto3'";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos3 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        }
    }
    if ($_FILES['foto4']['size'] != 0) {

        $imagen4 = $_FILES['foto4'];
        $nombreImagen = 'inmueble_' . $idInmueble . 'foto4' . '.jpg';
        move_uploaded_file($imagen4['tmp_name'], $carpetaImagenes . $nombreImagen);

        if ($foto4 == "vacio.png") {

            $queryFotos = "INSERT INTO fotos4  (idFotos4) VALUES  ('$nombreImagen')";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos4 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        } else {

            $queryFotos = "UPDATE fotos4 SET idFotos4 = '$nombreImagen' WHERE idFotos4 = '$foto4'";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos4 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        }
    }
    if ($_FILES['foto5']['size'] != 0) {

        $imagen5 = $_FILES['foto5'];
        $nombreImagen = 'inmueble_' . $idInmueble . 'foto5' . '.jpg';
        move_uploaded_file($imagen5['tmp_name'], $carpetaImagenes . $nombreImagen);

        if ($foto5 == "vacio.png") {

            $queryFotos = "INSERT INTO fotos5  (idFotos5) VALUES  ('$nombreImagen')";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos5 = '$nombreImagen' WHERE Inmueble_idInmueble = $idInmueble";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        } else {

            $queryFotos = "UPDATE fotos5 SET idFotos5 = '$nombreImagen' WHERE idFotos5 = '$foto5'";
            $resultadoFotos = mysqli_query($db, $queryFotos);

            $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos5 = '$nombreImagen' WHERE Inmueble_idInmueble = $resultadoAsignarFK";
            $resultadoFoto = mysqli_query($db, $queryFoto);
        }
    }


    $queryInmueble = "UPDATE inmueble SET Activo = 1 WHERE idInmueble = $idInmueble";
    $resultadoInmueble = mysqli_query($db, $queryInmueble);

    $queryInmueble = "UPDATE inmueble SET idTipo_Contrato = $contrato WHERE idInmueble = $idInmueble";
    $resultadoInmueble = mysqli_query($db, $queryInmueble);

    $queryInmueble = "UPDATE inmueble SET idTipo_Inmueble = $inmueble WHERE idInmueble = $idInmueble";
    $resultadoInmueble = mysqli_query($db, $queryInmueble);

    $queryInmueble = "UPDATE inmueble SET idTipo_Operacion = $operacion WHERE idInmueble = $idInmueble";
    $resultadoInmueble = mysqli_query($db, $queryInmueble);

    $queryInmueble = "UPDATE inmueble SET id_Empleado = $asesor WHERE idInmueble = $idInmueble";
    $resultadoInmueble = mysqli_query($db, $queryInmueble);

    $queryInmueble = "UPDATE inmueble SET idCliente = $cliente WHERE idInmueble = $idInmueble";
    $resultadoInmueble = mysqli_query($db, $queryInmueble);

    $queryCaracteristicas = "UPDATE caracteristicas SET Superficie_Terreno = $superficie_terreno WHERE idInmueble = '$idInmueble'";
    $resultadoCaracteristicas = mysqli_query($db, $queryCaracteristicas);

    $queryCaracteristicas = "UPDATE caracteristicas SET Superficie_Construccion = $superficie_construccion WHERE idInmueble = '$idInmueble'";
    $resultadoCaracteristicas = mysqli_query($db, $queryCaracteristicas);

    $queryCaracteristicas = "UPDATE caracteristicas SET Habitaciones = $habitaciones WHERE idInmueble = '$idInmueble'";
    $resultadoCaracteristicas = mysqli_query($db, $queryCaracteristicas);

    $queryCaracteristicas = "UPDATE caracteristicas SET Puestos_Estacionamiento = $estacionamiento WHERE idInmueble = '$idInmueble'";
    $resultadoCaracteristicas = mysqli_query($db, $queryCaracteristicas);

    $queryCaracteristicas = "UPDATE caracteristicas SET Otras_Caracteristicas = '$otras' WHERE idInmueble = '$idInmueble'";
    $resultadoCaracteristicas = mysqli_query($db, $queryCaracteristicas);

    $queryDatos = "UPDATE datos_basicos SET Direccion = '$direccion' WHERE Inmueble_idInmueble = $idInmueble";
    $resultadoDatos = mysqli_query($db, $queryDatos);

    $queryDatos = "UPDATE datos_basicos SET Precio = $precio WHERE Inmueble_idInmueble = $idInmueble";
    $resultadoDatos = mysqli_query($db, $queryDatos);

    $queryDatos = "UPDATE datos_basicos SET Colonias_idColonias = $colonia WHERE Inmueble_idInmueble = $idInmueble";
    $resultadoDatos = mysqli_query($db, $queryDatos);

    $queryDatos = "UPDATE datos_basicos SET Ubicacion_Maps = '$ubicacion' WHERE Inmueble_idInmueble = $idInmueble";
    $resultadoDatos = mysqli_query($db, $queryDatos);

    $queryDatos = "UPDATE datos_basicos SET Url_anuncio_web = '$urlAnuncio' WHERE Inmueble_idInmueble = $idInmueble";
    $resultadoDatos = mysqli_query($db, $queryDatos);

    $queryDatos = "UPDATE datos_basicos SET Url_video = '$urlVideo' WHERE Inmueble_idInmueble = $idInmueble";
    $resultadoDatos = mysqli_query($db, $queryDatos);

    if ($resultadoInmueble) {
        header('Location:../Listado/index.php');
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/MOBILE/mobile.css" media="(max-width: 840px)">
    <link rel="stylesheet" href="CSS/MEDIUM/mobile.css" media="(min-width:840px)">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet" />
    <title>Unika|Publicar Propiedad</title>
</head>

<body>
    <header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="../../index.php"><img src="../../../Assets/logo.png" alt=""></a>
            </section>

            <section class="header__name">
                <p> Bienvenido <?php echo $resultadoEmpleadoNombre['Nombre_Apellido'] ?></p>
                <p class="name__rol"> Su Rol es: <?php echo $resultadoRolEmpleado['Nombre_rol'] ?> </p>
            </section>

        </div>
    </header>
    <main>



        <section class="main__menu--content">
            <section class="main__menu" id="main__menu">
                <i>
                    <a id="button_open" href="#">
                        <img src="../../../Assets/menu.png" alt="">
                    </a>
                </i>
            </section>
        </section>

        <section class="main__content">

            <section class="main__nav" id="main__nav">
                <nav>
                    <ul>
                        <li><a href="../Listado/index.php"><span>Inmuebles</span></a></li>
                        <li><a href="../VoBo/index.php"><span>VoBo Inmuebles</span></a></li>
                        <li><a href="../../Empleados/Listado/index.php">Asesores</a></li>
                        <li><a href="../../Clientes/Listado/index.php">Clientes</a></li>
                        <li><a href="../Documentos/index.php">Documentos/Inmuebles</a></li>
                        <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </section>


            <section class="main__formulario">
                <?php foreach ($errores as $error) : ?>

                    <div class="error">
                        <p><?php echo $error ?></p>
                    </div>

                <?php endforeach ?>

                <form action="" method="POST" enctype="multipart/form-data">


                    <section class="select">
                        <span>Asesor</span>
                        <select name="asesor" id="" required>
                            <option value="0">
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoAsesor)) : ?>
                                <option <?php echo $asesor == $row['idEmpleado'] ? 'selected' : ''; ?> value="<?php echo $row['idEmpleado']; ?>"><?php echo $row['Nombre_Apellido']; ?></option>
                            <?php endwhile; ?>
                        </select>

                    </section>
                    <section class="select__config">
                        <span>Tipo de Contrato</span>
                        <select name="contrato" id="" required>
                            <option>
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoContrato)) : ?>
                                <option <?php echo $contrato == $row['idTipo_Contrato'] ? 'selected' : ''; ?> value="<?php echo $row['idTipo_Contrato']; ?>"><?php echo $row['Nombre_Contrato']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="button__new">
                            <a class="new" href="../Contrato/index.php">Nuevo Contrato</a>
                        </div>
                    </section>
                    <section class="select__config">
                        <span>Tipo de Inmueble</span>
                        <select name="inmueble" id="" required>
                            <option>
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoInmueble)) : ?>
                                <option <?php echo $inmueble == $row['idTipo_Inmueble'] ? 'selected' : ''; ?> value="<?php echo $row['idTipo_Inmueble']; ?>"><?php echo $row['Nombre_Tipo_Inmueble']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="button__new">
                            <a class="new" href="../T.Inmueble/index.php">Nuevo Tipo de Inmueble</a>
                        </div>
                    </section>
                    <section class="select__config">
                        <span>Tipo de Operación</span>
                        <select name="operacion" id="" required>
                            <option>
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoOperacion)) : ?>
                                <option <?php echo $operacion == $row['idTipo_Operacion'] ? 'selected' : ''; ?> value="<?php echo $row['idTipo_Operacion']; ?>"><?php echo $row['Nombre_Operacion']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="button__new">
                            <a class="new" href="../Operacion/index.php">Nueva Operación</a>
                        </div>
                    </section>

                    <section class="select__config">
                        <span>Cliente*</span>
                        <select name="cliente" id="" required>
                            <option value=''>
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoCliente)) : ?>
                                <option <?php echo $cliente == $row['idCliente'] ? 'selected' : ''; ?> required value="<?php echo $row['idCliente']; ?>"><?php echo $row['Correo']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="button__new">i
                            <a class="new" href="../../Empleados/Nuevo/index.php">Nuevo Cliente</a>
                        </div>
                    </section>
                    <label for="superficie_terreno">
                        <span>Superficie del Terreno</span>
                        <input value="<?php echo $superficie_terreno;  ?>" type="number" id="superficie_terreno" name="superficie_terreno" placeholder="En m2" min="50" required>
                    </label>

                    <label for="superficie_construccion">
                        <span>Superficie de Construcción</span>
                        <input value="<?php echo $superficie_construccion;  ?>" type="number" id="superficie_construccion" name="superficie_construccion" placeholder="En m2" maxlength="45">
                    </label>

                    <label for="habitaciones">
                        <span>Introduce el Número de Habitaciones</span>
                        <input value="<?php echo $habitaciones;  ?>" type="number" id="habitaciones" name="habitaciones" placeholder="N° de Habitaciones">
                    </label>

                    <label for="estacionamiento">
                        <span>Introduce el Número de Lugares de Estacionamiento</span>
                        <input value="<?php echo $estacionamiento;  ?>" type="number" id="estacionamiento" name="estacionamiento" placeholder="N° de Lugares">
                    </label>

                    <label for="otras">
                        <span>Otras Características</span>
                        <input value="<?php echo $otras;  ?>" type="text" id="otras" name="otras" placeholder="Otras Características" maxlength="100">
                    </label>

                    <label for="cp">
                        <span>Código Postal</span>
                        <input type="text" id="cp" value="<?php echo $cp ?>" name="cp" placeholder="3100" readonly max="7" required>
                    </label>

                    <section class="select">
                        <span>Colonia </span>
                        <select name="colonia" id="" required>
                            <option value="">
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoColonia)) : ?>
                                <option <?php echo $colonia == $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </section>
                    <label for="direccion">
                        <span>Dirección</span>
                        <input value="<?php echo $direccion;  ?>" type="text" id="direccion" name="direccion" placeholder="Dirección" max="250" required>

                    </label>
                    <label for="precio">
                        <span>Precio</span>
                        <input value="<?php echo $precio;  ?>" type="number" id="precio" name="precio" placeholder="$0000" min="1000" required maxlength="10">
                    </label>

                    <label for="ubicacion">
                        <span>Ubicación</span>
                        <input value="<?php echo $ubicacion;  ?>" type="text" id="ubicacion" name="ubicacion" placeholder="En Coordenadas" min="1">
                    </label>

                    <label for="urlAnuncio">
                        <span>URL del Anuncio</span>
                        <input value="<?php echo $urlAnuncio;  ?>" type="url" id="urlAnuncio" name="urlAnuncio" placeholder="URL">
                    </label>

                    <label for="urlVideo">
                        <span>URL del video</span>
                        <input value="<?php echo $urlVideo;  ?>" type="url" id="urlVideo" name="urlVideo" placeholder="URL" maxlength="100">
                    </label>

                    <label for="urlVideo">
                        <span>Foto 1 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto1" name="foto1" accept="image/jpeg, image/png" required>
                    </label>
                    <label for="urlVideo">
                        <span>Foto 1</span>
                        <p><img src="../Imagenes/<?php echo $foto1 ?>" alt=""></p>
                    </label>

                    <label for="urlVideo">
                        <span>Foto 2 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto2" name="foto2" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 2</span>
                        <p><img src="../Imagenes/<?php echo $foto2 ?>" alt=""></p>
                    </label>

                    <label for="urlVideo">
                        <span>Foto 3 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto3" name="foto3" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 3</span>
                        <p><img src="../Imagenes/<?php echo $foto4 ?>" alt=""></p>
                    </label>
                    <label for="urlVideo">
                        <span>Foto 4 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto4" name="foto4" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 5 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto5" name="foto5" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 6 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto6" name="foto6" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 7 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto7" name="foto7" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 8 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto8" name="foto8" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 9 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto9" name="foto9" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 10 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto10" name="foto10" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 11 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto11" name="foto11" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 12 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto12" name="foto12" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 13 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto13" name="foto13" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 14 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto14" name="foto14" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 15 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto15" name="foto15" accept="image/jpeg, image/png">
                    </label>




                    <input type="submit" value="Registrar" class="signup__submit">
                </form>
            </section>
        </section>

    </main>
    <script src="JS/menu.js"></script>
</body>

</html>