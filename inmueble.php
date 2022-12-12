<?php

$idInmueble = $_GET['id'];
$idInmueble = filter_var($idInmueble, FILTER_VALIDATE_INT);
if (!$idInmueble) {
    header('Location: ./index.html');
}


//Conexión a la base de datos
require './includes/config/database.php';
$db = conectarDB();
// Consulta de la información del inmueble
$consultaDatosInmueble = "SELECT
            empleado.Nombre_Apellido,
            tipo_contrato.Nombre_Contrato,
            tipo_inmueble.Nombre_Tipo_Inmueble,
            tipo_operacion.Nombre_Operacion,
            inmueble.Activo,
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

/**
 * * Consulta otras características
 */
$consultaOtrasCaracteristicas = "SELECT
otras_caracteristicas.idOtras_Caracteristicas,
otras_caracteristicas.idAmenidades,
amenidades.NombreAmenidades
FROM
(
    otras_caracteristicas
    INNER JOIN amenidades ON otras_caracteristicas.idAmenidades = amenidades.idAmenidades
)
WHERE
id_Inmueble = $idInmueble";
$consultaOtrasCaracteristicas = mysqli_query($db, $consultaOtrasCaracteristicas);

// Consulta de documentos asociados al inmueble
$queryDocuments = "SELECT * FROM documentos WHERE id_Inmueble_Documentos = $idInmueble";
$resultadoDocuments = mysqli_query($db, $queryDocuments);
$queryCountDocuments = "SELECT COUNT(id_Inmueble_Documentos) FROM documentos WHERE id_Inmueble_Documentos = $idInmueble";
$resultadoCountDocuments = mysqli_query($db, $queryCountDocuments);
$resultadoCountDocuments = mysqli_fetch_assoc($resultadoCountDocuments);
$resultadoCountDocuments = $resultadoCountDocuments['COUNT(id_Inmueble_Documentos)'];
$resultadoCountDocuments = (int)$resultadoCountDocuments;

// Consulta de los datos básicos asociados al inmueble
$consultaDatosBasicos = "SELECT * FROM datos_basicos WHERE Inmueble_idInmueble = $idInmueble";
$consultaDatosBasicos = mysqli_fetch_assoc(mysqli_query($db, $consultaDatosBasicos));

// Consulta de la colonia y código postal del inmueble
$colonia = $consultaDatosBasicos['Colonias_idColonias'];
$consultaColonia = "SELECT nombre, Codigo_postal FROM colonias WHERE id = '$colonia'";
$consultaColonia = mysqli_fetch_assoc(mysqli_query($db, $consultaColonia));
$consultaDocumentos = "SELECT idDocumentos, Titulo, id_Inmueble_Documentos FROM documentos WHERE id_Inmueble_Documentos = '$idInmueble'";
$consultaDocumentos = mysqli_query($db, $consultaDocumentos);

// Consulta de las fotos asociadas al inmueble
$consultaFotos = "SELECT NombreFotos FROM fotos WHERE id_Inmueble_Fotos = $idInmueble";
$consultaFotos =  mysqli_query($db, $consultaFotos);
// Consulta de las fotos asociadas al inmueble
$consultaFotos2 = "SELECT NombreFotos FROM fotos WHERE id_Inmueble_Fotos = $idInmueble";
$consultaFotos2 =  mysqli_query($db, $consultaFotos2);



$asesor = $consultaDatosInmueble['Nombre_Apellido'];
$contrato = $consultaDatosInmueble['Nombre_Contrato'];
$inmueble = $consultaDatosInmueble['Nombre_Tipo_Inmueble'];
$operacion = $consultaDatosInmueble['Nombre_Operacion'];
$disponible = $consultaDatosInmueble['Activo'];
$idCliente = $consultaDatosInmueble['idCliente'];

// Consulta de la información personal asociada al inmueble
$queryCliente = "SELECT * FROM cliente WHERE idCliente = " . $idCliente;
$consultaCliente = mysqli_fetch_assoc(mysqli_query($db, $queryCliente));

$superficie_terreno = (int)$consultaCaracteristicas['Superficie_Terreno'];
$superficie_construccion = (int)$consultaCaracteristicas['Superficie_Construccion'];
$habitaciones = $consultaCaracteristicas['Habitaciones'];
$bano = $consultaCaracteristicas['Banos'];
$estacionamiento = $consultaCaracteristicas['Puestos_Estacionamiento'];
$descripcion = $consultaCaracteristicas['Descripcion'];
$direccion = $consultaDatosBasicos['Direccion'];
$precio = $consultaDatosBasicos['Precio'];
$ubicacion = $consultaDatosBasicos['Ubicacion_Maps'];
$urlAnuncio = $consultaDatosBasicos['Url_anuncio_web'];
$urlVideo = $consultaDatosBasicos['Url_video'];
$colonia = $consultaColonia['nombre'];
$codigoPostal = $consultaColonia['Codigo_postal'];
require('./admin/Propiedades/Ver/reporte.php');
static $i = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Propiedad</title>
    <link rel="stylesheet" href="Inicio/inmueble/CSS/MOBILE/medium.css" media="(max-width: 950px)">
    <link rel="stylesheet" href="Inicio/inmueble/CSS/MEDIUM/medium.css" media="(min-width: 950px)">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet" />
</head>

<body>
    <header></header>
    <main>
        <!-- Container for the image gallery -->
        <section class="container">

            <?php while ($row = mysqli_fetch_assoc($consultaFotos)) : ?>

                <!-- Full-width images with number text -->
                <section class="mySlides">
                    <img src="./admin/Propiedades/Imagenes/<?php echo $row['NombreFotos'] ?>">
                </section>
            <?php endwhile; ?>
            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
            <?php

            while ($row = mysqli_fetch_assoc($consultaFotos2)) : ?>
                <!-- Thumbnail images -->
                <section class="row">
                    <section class="column">
                        <img class="demo cursor" src="./admin/Propiedades/Imagenes/<?php echo $row['NombreFotos'] ?>" onclick="currentSlide(<?php echo $i ?>)">
                    </section>
            <?php $i++;
            endwhile; ?>
                </section>
        </section>
    </main>
    <footer></footer>
</body>
<script src="./inmueble.js"></script>

</html>