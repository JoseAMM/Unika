<?php

session_start();

$auth = $_SESSION['login'];
$idUsuarios = $_SESSION['idUsuarios'];

if(!$auth){
    header('Location:../../../index.php');
}

//Conexión a la base de datos

require '../../../includes/config/database.php';

$db = conectarDB();

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

// Consulta de las colonias para el select
    $consultaColonia = "SELECT idColonias, Nombre_Colonia FROM colonias ";
    $resultadoColonia = mysqli_query($db, $consultaColonia);


    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        // Asignación de variables y escape de datos para la prevención de inyección SQL
        $asesor = $_POST['asesor'];
        $contrato = $_POST['contrato'];
        $inmueble = $_POST['inmueble'];
        $operacion = $_POST['operacion'];
        $colonia = $_POST['colonia'];

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


        $queryInmueble = "INSERT INTO inmueble (Activo, idTipo_Contrato, idTipo_Inmueble, idTipo_Operacion, id_Empleado) VALUES (1, $contrato, $inmueble, $operacion, $asesor)";
        $resultadoInmueble = mysqli_query($db, $queryInmueble);



        // $resultadoInmueble = mysqli_fetch_assoc($resultadoContrato);

        // echo "<pre>";
        // var_dump($resultadoInmueble);
        // echo "</pre>";


        $queryAsignarFK = "SELECT idInmueble FROM inmueble ORDER BY idInmueble DESC LIMIT 1";
        $resultadoAsignarFK = mysqli_query($db, $queryAsignarFK);
        $resultadoAsignarFK = mysqli_fetch_assoc($resultadoAsignarFK);
        $resultadoAsignarFK = (int)$resultadoAsignarFK['idInmueble'];

        // echo "<pre>";
        // var_dump($resultadoAsignarFK);
        // echo "</pre>";

        $queryCaracteristicas = "INSERT INTO caracteristicas (Superficie_Terreno,
        Superficie_Construccion,
        Habitaciones,
        Puestos_Estacionamiento,
        Otras_Caracteristicas,
        idInmueble) VALUES ($superficie_terreno,
        $superficie_construccion,
        $habitaciones,
        $estacionamiento,
        '$otras',
        $resultadoAsignarFK);";
        $resultadoCaracteristicas = mysqli_query($db, $queryCaracteristicas);

        $queryDatos = "INSERT INTO datos_basicos (Direccion,
        Precio,
        Inmueble_idInmueble,
        Colonias_idColonias,
        Ubicacion_Maps,
        Url_anuncio_web,
        Url_video) VALUES ('$direccion',
        $precio,
        $resultadoAsignarFK,
        $colonia,
        '$ubicacion',
        '$urlAnuncio',
        '$urlVideo')";

        $resultadoDatos = mysqli_query($db, $queryDatos);

        if($resultadoInmueble){
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
    <link rel="stylesheet" href="CSS/SMALL/mobile.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Unika|Publicar Propiedad</title>
</head>
<body>
<header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="../../index.php"><img src="../../../Assets/logo.png" alt=""></a>
            </section>

        </div>

        <section class="header__tittle">
            <p>Publicar Propiedad</p>
        </section>
    </header>
    <main>
        <section>
            <form action="" method="POST">
                <div class="button__volver">
                    <a class="volver" href="../Listado/index.php">Volver</a>
                </div>
                <p class="form__titleInmueble"> Inmueble </p>
                <span>Asesor</span>
                    <select name="asesor" id="">
                        <option value="0"><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoAsesor)) : ?>
                            <option value="<?php echo $row['idEmpleado']; ?>"><?php echo $row['Nombre_Apellido']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <span>Tipo de Contrato</span>
                    <select name="contrato" id="">
                        <option ><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoContrato)) : ?>
                            <option value="<?php echo $row['idTipo_Contrato']; ?>"><?php echo $row['Nombre_Contrato']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <span>Tipo de Inmueble</span>
                    <select name="inmueble" id="">
                        <option><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoInmueble)) : ?>
                            <option required value="<?php echo $row['idTipo_Inmueble']; ?>"><?php echo $row['Nombre_Tipo_Inmueble']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <span>Tipo de Operación</span>
                    <select name="operacion" id="">
                        <option><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoOperacion)) : ?>
                            <option required value="<?php echo $row['idTipo_Operacion']; ?>"><?php echo $row['Nombre_Operacion']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <p class="form__titleCaracteristicas">Características</p>
                <label for="superficie_terreno">
                    <span>Superficie del Terreno</span>
                    <input type="number" id= "superficie_terreno" name="superficie_terreno" placeholder = "En m2" min="50" required>
                </label>

                <label for="superficie_construccion">
                    <span>Superficie de Construcción</span>
                    <input type="number" id= "superficie_construccion" name="superficie_construccion"  placeholder = "En m2"  min="50" required maxlength="45">
                </label>

                <label for="habitaciones">
                    <span>Introduce el Número de Habitaciones</span>
                    <input type="number" id= "habitaciones" name="habitaciones" placeholder = "N° de Habitaciones" min="1" required>
                </label>

                <label for="estacionamiento">
                    <span>Introduce el Número de Lugares de Estacionamiento</span>
                    <input type="number" id= "estacionamiento" name="estacionamiento" placeholder = "N° de Lugares" min="0" required >
                </label>

                <label for="otras">
                    <span>Otras Características</span>
                    <input type="text" id= "otras" name= "otras"  placeholder = "Otras Características" required  maxlength="100">
                </label>

                <p class="form__titleDatos">Datos del Inmueble</p>
                <label for="direccion">
                    <span>Dirección</span>
                    <input type="text" id= "direccion" name="direccion" placeholder = "Dirección" max="250" required>
                </label>

                <label for="precio">
                    <span>Precio</span>
                    <input type="number" id= "precio" name="precio"  placeholder = "$0000"  min="1000" required maxlength="10">
                </label>

                <label for="ubicacion">
                    <span>Ubicación</span>
                    <input type="text" id= "ubicacion" name="ubicacion" placeholder ="En Coordenadas" min="1" required>
                </label>

                <label for="urlAnuncio">
                    <span>URL del Anuncio</span>
                    <input type="url" id= "urlAnuncio" name="urlAnuncio" placeholder = "URL" required >
                </label>

                <label for="urlVideo">
                    <span>URL del video</span>
                    <input type="url" id= "urlVideo" name= "urlVideo"  placeholder = "URL" required  maxlength="100">
                </label>
                <span>Colonia </span>
                <select name="colonia" id="">
                        <option><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoColonia)) : ?>
                            <option required value="<?php echo $row['idColonias']; ?>"><?php echo $row['Nombre_Colonia']; ?></option>
                        <?php endwhile; ?>
                </select>


                <input type="submit" value = "Registrar" class = "signup__submit">
        </form>
    </section>
</main>

</body>
</html>