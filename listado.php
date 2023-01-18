<?php

require 'includes/config/database.php';

$db = conectarDB();
$idTipo_Operacion = $_GET['idTipo_Operacion'];
$idTipo_Operacion = filter_var($idTipo_Operacion, FILTER_VALIDATE_INT);
if (!$idTipo_Operacion) {
    header('Location: ./index.html');
} else {
    if ($idTipo_Operacion == 10) {
        $nombreOperacion = "Renta";
    }
    if ($idTipo_Operacion == 2) {
        $nombreOperacion = "Venta";
    }
}




// Consulta de la información del inmueble

$consultaDatosInmueble = "SELECT
    inmueble.idInmueble,
    empleado.Nombre_Apellido,
    tipo_contrato.Nombre_Contrato,
    tipo_inmueble.Nombre_Tipo_Inmueble,
    tipo_operacion.Nombre_Operacion,
    datos_basicos.Colonias_idColonias,
    colonias.ciudad,
    colonias.nombre,
    colonias.Codigo_postal,
    municipios.nombreMunicipio,
    caracteristicas.Superficie_Terreno,
    caracteristicas.Superficie_Construccion,
    caracteristicas.Habitaciones,
    caracteristicas.Puestos_Estacionamiento,
    caracteristicas.Banos,
    datos_basicos.Precio,
    fotos.FotoPortada
FROM
    inmueble
    INNER JOIN empleado ON inmueble.id_Empleado = empleado.idEmpleado
    INNER JOIN tipo_contrato ON inmueble.idTipo_Contrato = tipo_contrato.idTipo_Contrato
    INNER JOIN tipo_inmueble ON inmueble.idTipo_Inmueble = tipo_inmueble.idTipo_Inmueble
    INNER JOIN tipo_operacion ON inmueble.idTipo_Operacion = tipo_operacion.idTipo_Operacion
    INNER JOIN datos_basicos ON inmueble.idInmueble = datos_basicos.Inmueble_idInmueble
    INNER JOIN caracteristicas ON inmueble.idInmueble = caracteristicas.idInmueble_Caracteristicas
    INNER JOIN colonias ON datos_basicos.Colonias_idColonias = colonias.id
    INNER JOIN municipios ON colonias.municipio = municipios.idMunicipios
    INNER JOIN fotos ON inmueble.idInmueble = id_Inmueble_Fotos
WHERE
    inmueble.Activo = 1
    AND municipios.estado = 9
    AND inmueble.VoBo = 1
    AND fotos.FotoPortada IS NOT NULL
    AND inmueble.idTipo_Operacion = $idTipo_Operacion
ORDER BY
    municipios.nombreMunicipio ASC";


$resultadoConsultaDatosInmueble = mysqli_query($db, $consultaDatosInmueble);

function utf8($string)
{
    $uft8 = mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
    return $uft8;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Inicio/listado/CSS/MOBILE/medium.css" media="(max-width: 950px)">
    <link rel="stylesheet" href="Inicio/listado/CSS/MEDIUM/medium.css" media="(min-width: 950px)">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet" />
    <title>Unika|Comprar</title>
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

        <section class="main__vender">
            <h1>INMUEBLES EN <?php echo strtoupper($nombreOperacion) ?></h1>
            <p>En CDMX</p>
        </section>
        <section class="main__inmuebles">

            <?php while ($row = mysqli_fetch_assoc($resultadoConsultaDatosInmueble)) : ?>



                <a class="main__cardMunicipio" href="./inmueble.php?id=<?php echo $row['idInmueble']; ?>">
                    <h1><?php echo utf8($row['nombreMunicipio']) ?></h1>
                    <section class="cardMunicipio__cardInmueble">


                        <section class="cardImg">
                            <img src="admin/Propiedades/Imagenes/<?php echo $row['FotoPortada'] ?>" alt="">
                        </section>

                        <section class="cardInfo">
                            <h2> COLONIA: <?php echo  " " . strtoupper($row['nombre']) ?></h2>
                            <p>Superficie de Construccion:<?php echo  " " . $row['Superficie_Construccion'] .  ' m2' ?></p>
                            <p>Superficie de Terreno:<?php echo  " " . $row['Superficie_Terreno'] . ' m2' ?> </p>
                            <?php if ($row['Habitaciones'] != 0) : ?>
                                <span class="cardInfo__habitaciones"></span>
                                <p>Habitaciones: <?php echo " " .  $row['Habitaciones'] ?> </p>
                            <?php endif; ?>

                            <?php if ($row['Puestos_Estacionamiento'] != 0) : ?>
                                <span class="cardInfo__estacionamiento"></span>
                                <p>Estacionamiento: <?php echo " " . $row['Puestos_Estacionamiento'] ?> </p>
                            <?php endif; ?>

                            <?php if ($row['Banos'] != 0) : ?>
                                <span class="cardInfo__banos"></span>
                                <p>Baños: <?php echo " " . $row['Banos'] ?> </p>
                            <?php endif; ?>
                            <p>Precio: $ <?php echo number_format($row['Precio']) . " MXN" ?></p>
                        </section>
                    </section>
                </a>

            <?php endwhile; ?>
        </section>
    </main>
    <script src="Inicio/JS/menu.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <a href="https://api.whatsapp.com/send?phone=+525195508107&text=Hola,quisiera más información" class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
</body>