<?php

//Sesion

require '../../sesion.php';


$idInmueble = $_GET['id'];
$idInmueble = filter_var($idInmueble, FILTER_VALIDATE_INT);

if(!$idInmueble) {
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




// Consulta de la información del inmueble

        $consultaDatosInmueble = "SELECT
            empleado.Nombre_Apellido,
            tipo_contrato.Nombre_Contrato,
            tipo_inmueble.Nombre_Tipo_Inmueble,
            tipo_operacion.Nombre_Operacion

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

        $consultaCaracteristicas = "SELECT * FROM caracteristicas WHERE idInmueble = $idInmueble";
        $consultaCaracteristicas = mysqli_fetch_assoc(mysqli_query($db, $consultaCaracteristicas));


        $consultaDatosBasicos = "SELECT * FROM datos_basicos WHERE Inmueble_idInmueble = $idInmueble";
        $consultaDatosBasicos = mysqli_fetch_assoc(mysqli_query($db, $consultaDatosBasicos));

        $colonia = $consultaDatosBasicos['Colonias_idColonias'];

        $consultaColonia = "SELECT nombre, Codigo_postal FROM colonias WHERE id = '$colonia'";
        $consultaColonia = mysqli_fetch_assoc(mysqli_query($db, $consultaColonia));


    $asesor = $consultaDatosInmueble['Nombre_Apellido'];
    $contrato = $consultaDatosInmueble['Nombre_Contrato'];
    $inmueble = $consultaDatosInmueble['Nombre_Tipo_Inmueble'] ;
    $operacion = $consultaDatosInmueble['Nombre_Operacion'];
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
    $colonia = $consultaColonia['nombre'];

    $foto1 = $consultaDatosBasicos['Fotos_idFotos1'];
    $foto2 = $consultaDatosBasicos['Fotos_idFotos2'];
    $foto3 = $consultaDatosBasicos['Fotos_idFotos3'];
    $foto4 = $consultaDatosBasicos['Fotos_idFotos4'];
    $foto5 = $consultaDatosBasicos['Fotos_idFotos5'];

    

    if($foto1 == NULL){
        $foto1 = "vacio.png";
    }

    if($foto2 == NULL){
        $foto2 = "vacio.png";
    }
    if($foto3 == NULL){
        $foto3 = "vacio.png";
    }
    if($foto4 == NULL){
        $foto4 = "vacio.png";
    }
    if($foto5 == NULL){
        $foto5 = "vacio.png";
    }






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/MOBILE/mobile.css" media="(max-width: 840px)">
    <link rel="stylesheet" href="CSS/MEDIUM/mobile.css" media="(min-width: 840px)">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Unika|Editar Propiedad</title>
</head>
<body>
    <header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="../../index.php"><img src="../../../Assets/logo.png" alt=""></a>
            </section>

            
            <section class="header__name" >
                <p> Bienvenido <?php echo $resultadoEmpleadoNombre['Nombre_Apellido']?></p>
                <p class="name__rol"> Su Rol es: <?php echo $resultadoRolEmpleado['Nombre_rol']?> </p>
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
                        <li><a href=""><span>VoBo Inmuebles</span></a></li>
                        <li><a href="../../Empleados/Listado/index.php">Asesores</a></li>
                        <li><a href="../../Clientes/Listado/index.php">Clientes</a></li>
                        <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </section>

            <section  class="main__formulario">
                <form action="" method="POST">
                        <label for="">
                            <span>Asesor</span>
                            <p> <?php echo $asesor ?></p>
                        </label>



                        <label for="">
                            <span>Tipo de Contrato</span>
                            <p> <?php echo $contrato ?></p>
                        </label>


                        <label for="">
                            <span>Tipo de Inmueble</span>
                            <p> <?php echo $inmueble ?></p>
                        </label>




                        
                        <label for="">
                            <span>Tipo de Operación</span>
                            <p> <?php echo $operacion ?></p>
                        </label>


                    <label for="">
                        <span>Superficie del Terreno</span>
                        <p><?php echo $superficie_terreno;  ?></p>
                    </label>

                    <label for="superficie_construccion">
                        <span>Superficie de Construcción</span>
                        <p><?php echo $superficie_construccion;  ?></p>
                    </label>

                    <label for="habitaciones">
                        <span>Habitaciones</span>
                        <p><?php echo $habitaciones;  ?></p>
                    </label>

                    <label for="estacionamiento">
                        <span>Lugares de Estacionamiento</span>
                        <p><?php echo $estacionamiento;  ?></p>
                    </label>

                    <label for="otras">
                        <span>Otras Características</span>
                        <p><?php echo $otras;  ?></p>
                    </label>
                    
                    <label for="">
                    <span>Colonia </span>
                    <p><?php echo $colonia;  ?></p>
                    </label>

                    <label for="direccion">
                        <span>Dirección</span>
                        <p><?php echo $direccion;  ?></p>
                    </label>

                    <label for="precio">
                        <span>Precio</span>
                        <p><?php echo "$" .$precio;  ?></p>
                    </label>

                    <label for="ubicacion">
                        <span>Ubicación</span>
                        <p><?php echo $ubicacion;  ?></p>
                    </label>

                    <label for="urlAnuncio">
                        <span>URL del Anuncio</span>
                        <a href=""></a>
                        <p><a href="<?php echo $urlAnuncio;  ?>" target="_blank"><?php echo $urlAnuncio;  ?></a></p>
                    </label>

                    <label for="urlVideo">
                        <span>URL del video</span>
                        <p><a href="<?php echo $urlAnuncio;  ?>" target="_blank"><?php echo $urlAnuncio;  ?></a></p>
                    </label>

                    <label for="foto1">
                        <span>Foto 1</span>
                        <p><img src="../Imagenes/<?php  echo $foto1?>" alt=""></p>
                    </label>

                    <label for="foto2">
                        <span>Foto 2</span>
                        <p><img src="../Imagenes/<?php  echo $foto2?>" alt=""></p>
                    </label>

                    <label for="foto3">
                        <span>Foto 3</span>
                        <p><img src="../Imagenes/<?php  echo $foto3?>" alt=""></p>
                    </label>

                    <label for="foto4">
                        <span>Foto 4</span>
                        <p><img src="../Imagenes/<?php  echo $foto4?>" alt=""></p>
                    </label>

                    <label for="foto5">
                        <span>Foto 5</span>
                        <p><img src="../Imagenes/<?php  echo $foto5?>" alt=""></p>
                    </label>

                </form>
            </section>

        </section>
</main>
<script src="JS/menu.js" ></script>

</body>
</html>