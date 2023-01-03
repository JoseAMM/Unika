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

$consultaAmenidades = "SELECT otras_caracteristicas.idAmenidades, 
amenidades.NombreAmenidades,
amenidades.NombreImagenAmenidades
FROM otras_caracteristicas
INNER JOIN amenidades ON otras_caracteristicas.idAmenidades = amenidades.idAmenidades WHERE id_Inmueble = $idInmueble";
$consultaAmenidades = mysqli_query($db, $consultaAmenidades);

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
$consultaColonia = "SELECT nombre, Codigo_postal, ciudad FROM colonias WHERE id = '$colonia'";
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
$tipoContrato = $consultaDatosInmueble['Nombre_Contrato'];
$tipoInmueble = $consultaDatosInmueble['Nombre_Tipo_Inmueble'];
$tipoOperacion = $consultaDatosInmueble['Nombre_Operacion'];
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
$ciudad = $consultaColonia['ciudad'];
include_once('./reporte.php');

if (isset($_POST['download'])) {
    $download = 1;
    $share = 0;
    $print = 0;
    pdf(
        $idInmueble,
        $consultaFotos,
        $tipoOperacion,
        $precio,
        $tipoInmueble,
        $disponible,
        $habitaciones,
        $estacionamiento,
        $bano,
        $descripcion,
        $tipoContrato,
        $superficie_construccion,
        $superficie_terreno,
        $colonia,
        $codigoPostal,
        $download,
        $share,
        $print,
        0
    );
}
static $i = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Propiedad</title>
    <link rel="stylesheet" href="Inicio/inmueble/CSS/MOBILE/medium.css" media="(max-width: 1260px)">
    <link rel="stylesheet" href="Inicio/inmueble/CSS/MEDIUM/medium.css" media="(min-width: 1000px)">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;900&display=swap" rel="stylesheet" />
</head>

<body>
    <header>
        <section class="header__content">

            <section class="header__up">
                <section class="header__up--logo">
                    <img src="Assets/logo.png" alt="">
                </section>
                <section class="header__up--slogan">
                    <p>Cumplir tus sueños es nuestra misión!</p>
                </section>
                <section class="header__up--buttons">
                    <section class="buttons__contacto">
                        <a href="contacto.php">Contacto</a>
                    </section>
                    <section class="buttons__login">
                        <section>
                            <a href="login/index.php">Soy Cliente</a>
                        </section>
                        <section>
                            <a href="login/index.php">Soy Asesor</a>
                        </section>
                    </section>
                </section>
            </section>
            <section class="header__down">
                <nav>
                    <section class="menu" id="down__menu">
                        <i class="i" id="button_open"></i>
                    </section>
                    <ul id="ul__menu">
                        <li class="nav__left"><a href="index.html">Inicio</a></li>
                        <li><a href="acerca.html">Acerca de</a></li>
                        <li><a href="servicios.html">Nuestros Servicios</a></li>
                        <li><a href="vender.html">¿Quieres Vender?</a></li>
                        <li><a href="rentar.html">¿Quieres Rentar?</a></li>
                        <li><a href="comprar.html">¿Quieres Comprar?</a></li>
                        <li class="nav__right"><a href="preguntas.html">Preguntas Frecuentes</a></li>
                    </ul>
                </nav>
            </section>
        </section>
    </header>
    <main>

        <section class="main__fotos_informacion">
            <section class="main__fotos">
                <!-- Next and previous buttons -->
                <section class="main__buttonsSlides">
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </section>
                <!-- Container for the image gallery -->
                <section class="main__containerSlides">
                    <?php while ($row = mysqli_fetch_assoc($consultaFotos)) : ?>
                        <!-- Full-width images with number text -->
                        <section class="mySlides">
                            <img src="./admin/Propiedades/Imagenes/<?php echo $row['NombreFotos'] ?>">
                        </section>
                    <?php endwhile; ?>
                    <section>
                    </section>
                    <section class="containerSlides__row">
                        <?php
                        while ($row = mysqli_fetch_assoc($consultaFotos2)) : ?>
                            <!-- Thumbnail images -->
                            <section class="column">
                                <img class="demo cursor" src="./admin/Propiedades/Imagenes/<?php echo $row['NombreFotos'] ?>" onclick="currentSlide(<?php echo $i ?>)">
                            </section>
                        <?php $i++;
                        endwhile; ?>
                    </section>
                </section>
            </section>

            <section class="main__informacion">

                <section class="informacion__basica">
                    <p class="informacion__basica--tipoInmueble"><?php echo $tipoInmueble ?></p>
                    <p class="informacion__basica--tipoOperacion"><?php echo $tipoOperacion ?></p>
                    <p class="informacion__basica--ciudad"><?php echo $colonia . ", " . $ciudad . ", " . $codigoPostal ?></p>
                </section>

                <section class="informacion__superficie">

                    <section class="informacion__superficie--terreno">
                        <figure>
                            <img src="./Assets/Icon Amenities/Sup.Construccion.png" alt="">
                        </figure>
                        <p>Sup.Terreno <?php echo number_format($superficie_terreno) ?> m<sup>2</sup> </p>
                    </section>



                    <section class="informacion__superficie--construccion">
                        <figure>
                            <img src="./Assets/Icon Amenities/Casa.png" alt="">
                        </figure>
                        <p>Sup.Construcción <?php echo number_format($superficie_construccion) ?> m<sup>2</sup> </p>
                    </section>
                </section>
                <section class="informacion__amenidadesBasicas">
                    <?php if ($habitaciones != 0) : ?>
                        <section class="informacion__amenidadesBasicas--habitaciones">
                            <figure>
                                <img src="./Assets/Icon Amenities/Recamaras.png" alt="">
                            </figure>
                            <p><?php echo $habitaciones ?> Recámaras</p>
                        </section>
                    <?php endif; ?>
                    <?php if ($bano != 0) : ?>
                        <section class="informacion__amenidadesBasicas--banos">
                            <figure>
                                <img src="./Assets/Icon Amenities/Bano.png" alt="">
                            </figure>
                            <p><?php echo $bano ?> Baños</p>
                        </section>
                    <?php endif; ?>
                    <?php if ($estacionamiento != 0) : ?>
                        <section class="informacion__amenidadesBasicas--estacionamiento">
                            <figure>
                                <img src="./Assets/Icon Amenities/GarageSinTecho.png" alt="">
                            </figure>
                            <p><?php echo $estacionamiento ?> Lugares</p>
                        </section>

                    <?php endif; ?>
                </section>
                <section class="informacion__precio">
                    <p class="informacion__precio--desde">Desde:</p>
                    <p class="informacion__precio--cantidad">$2<?php echo number_format($precio) ?> MXN</p>
                </section>
            </section>

        </section>

        <section class="main__carcateristicasGenerales">
            <section class="carcateristicasGenerales__descripcion">
                <p class="main__carcateristicasGenerales--titulo1">Descripción:</p>
                <p class="main__carcateristicasGenerales--contenido"><?php echo utf8_decode($descripcion) ?></p>
                <p class="main__carcateristicasGenerales--titulo2">Amenidades:</p>
            </section>

            <section></section>

            <section class="carcateristicasGenerales__amenidades">
                <?php while ($row = mysqli_fetch_assoc($consultaAmenidades)) : ?>
                    <section class="carcateristicasGenerales__amenidades--amenidad">
                        <figure>
                            <img src="./Assets/Icon Amenities/<?php echo $row['NombreImagenAmenidades'] ?>" alt="">
                        </figure>
                        <p><?php echo $row['NombreAmenidades'] ?></p>
                    </section>
                <?php endwhile; ?>
            </section>
        </section>

        <section class="main__pdf">
            <form action="" method="POST">
                <button type="submit" name="download" class="pdf">
                    <p>Descargar PDF</p>
                </button>
            </form>
        </section>
    </main>
    <footer></footer>
    <script src="Inicio/JS/menu.js"></script>
    <script src="./inmueble.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <a href="https://api.whatsapp.com/send?phone=5195508107&text=Hola,quisiera más información" class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
</body>