<?php 

require 'includes/config/database.php';

$db = conectarDB();


// Consulta de la información del inmueble, combinando varias tablas

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
    datos_basicos.Precio,
    datos_basicos.Fotos_idFotos1
    
FROM
    (
        (
            (
                (
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
                    INNER JOIN datos_basicos ON inmueble.idInmueble = datos_basicos.Inmueble_idInmueble
                )
                INNER JOIN caracteristicas ON inmueble.idInmueble = caracteristicas.idInmueble
            )
            INNER JOIN colonias ON datos_basicos.Colonias_idColonias = colonias.id
        )
        INNER JOIN municipios ON colonias.municipio = municipios.idMunicipios
    ) WHERE inmueble.Activo = 1 AND municipios.estado = 9 AND inmueble.VoBo = 1 AND tipo_operacion.idTipo_Operacion = 3 ORDER BY municipios.nombreMunicipio DESC";


    $resultadoConsultaDatosInmueble = mysqli_query($db, $consultaDatosInmueble);


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="Inicio/compracdmx/CSS/MOBILE/medium.css"  media="(max-width: 950px)">
  <link rel="stylesheet" href="Inicio/compracdmx/CSS/MEDIUM/medium.css" media="(min-width: 950px)">
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
        <h1>CASAS EN VENTA</h1>
        <p>En CDMX</p>
      </section>
    <section class="main__inmuebles">

    <?php while($row = mysqli_fetch_assoc($resultadoConsultaDatosInmueble)): ?>



        <section class="main__cardMunicipio">
            <h1><?php echo  $row['nombreMunicipio'] ?></h1>
            <section class="cardMunicipio__cardInmueble">


                <section class="cardImg">
                    <img src="admin/Propiedades/Imagenes/<?php echo $row['Fotos_idFotos1']?>" alt="">
                </section>

                <section class="cardInfo">
                    <h2>  COLONIA: <?php echo  " " . strtoupper( $row['nombre'])?></h2>
                    <p>Superficie de Construccion:<?php echo  " ". $row['Superficie_Construccion'] . " m2"?></p>
                    <p>Superficie de Terreno:<?php echo  " ". $row['Superficie_Terreno']?> . " m2"</p>
                    <p>Habitaciones: <?php echo " ".  $row['Habitaciones']?> </p>
                    <p>Estacionamiento:  <?php echo " ". $row['Puestos_Estacionamiento']?> </p>
                    <p>Precio: $ <?php echo $row['Precio'] . " MXN"?></p>
                </section>
            </section>
        </section>

    <?php endwhile; ?>
    </section>
</main>

<script src="Inicio/JS/menu.js" ></script>
</body>
</html>