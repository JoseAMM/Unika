<?php

//Sesion

require '../../sesion.php';


//Conexión a la base de datos

require '../../../includes/config/database.php';


$db = conectarDB();

// Funcion para la limpieza de datos

require '../../limpieza.php';


// Consulta del nombre y rol del usuario 

$queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

$resultadoEmpleadoNombre = mysqli_query($db, $queryEmpleado);

$resultadoEmpleadoNombre = mysqli_fetch_assoc($resultadoEmpleadoNombre);

$idRolEmpleado = $resultadoEmpleadoNombre['Rol_idRol'];

$idRolEmpleado = (int)$idRolEmpleado;


$queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
$resultadoRolEmpleado = mysqli_query($db, $queryRol);
$resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);

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

// Consulta de los tipos de amenidades para el select primario

$consultaAmenidadesPrimario = "SELECT idAmenidades, NombreAmenidades FROM amenidades;";
$resultadoAmenidadesPrimario = mysqli_query($db, $consultaAmenidadesPrimario);

// Consulta de los tipos de amenidades para el select secundario

$consultaAmenidadesSecundario = "SELECT idAmenidades, NombreAmenidades FROM amenidades;";
$resultadoAmenidadesSecundario = mysqli_query($db, $consultaAmenidadesSecundario);



$errores = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['cp']) and isset($_POST['asesor']) and isset($_POST['contrato']) and isset($_POST['inmueble']) and isset($_POST['direccion']) == FALSE) {

        $cp = $_POST['cp'];
        $asesor = $_POST['asesor'];
        $cliente = $_POST['cliente'];

        $consultaColonia = "SELECT id, nombre FROM colonias WHERE Codigo_postal = $cp ";
        $resultadoColonia = mysqli_query($db, $consultaColonia);
        $contrato = $_POST['contrato'];
        $inmueble = $_POST['inmueble'];
        $operacion = $_POST['operacion'];
        $superficie_terreno = filter_var(mysqli_real_escape_string($db, $_POST['superficie_terreno']), FILTER_SANITIZE_NUMBER_FLOAT);
        $superficie_construccion = filter_var(mysqli_real_escape_string($db, $_POST['superficie_construccion']), FILTER_SANITIZE_NUMBER_FLOAT);
        $habitaciones = filter_var(mysqli_real_escape_string($db, $_POST['habitaciones']), FILTER_SANITIZE_NUMBER_INT);
        $estacionamiento = filter_var(mysqli_real_escape_string($db, $_POST['estacionamiento']), FILTER_SANITIZE_NUMBER_INT);
        $otras = limpieza(mysqli_real_escape_string($db, $_POST['otras']));
    }
    if (isset($_POST['direccion'])) {

        $direccion =  limpieza(mysqli_real_escape_string($db, $_POST['direccion']));
        $ubicacion = limpieza(mysqli_real_escape_string($db, $_POST['ubicacion']));

        $queryBuscarInmueble = "SELECT Direccion FROM datos_basicos WHERE Direccion = '$direccion' AND Ubicacion_Maps = '$ubicacion'";
        $resultadoBuscarInmueble = mysqli_fetch_assoc(mysqli_query($db, $queryBuscarInmueble));




        if ($resultadoBuscarInmueble == NULL) {
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
            $observaciones = limpieza(mysqli_real_escape_string($db, $_POST['observaciones']));
            $descripcion = limpieza(mysqli_real_escape_string($db, $_POST['descripcion']));
            $ubicacion = limpieza(mysqli_real_escape_string($db, $_POST['ubicacion']));
            $precio = filter_var(mysqli_real_escape_string($db, $_POST['precio']), FILTER_SANITIZE_NUMBER_FLOAT);

            $urlAnuncio = limpieza(filter_var(mysqli_real_escape_string($db, $_POST['urlAnuncio']), FILTER_SANITIZE_URL));
            $urlVideo = limpieza(filter_var(mysqli_real_escape_string($db, $_POST['urlVideo']), FILTER_SANITIZE_URL));


            $queryInmueble = "INSERT INTO inmueble (Activo, 
            idTipo_Contrato, 
            idTipo_Inmueble, 
            idTipo_Operacion, 
            id_Empleado, 
            VoBo, 
            idCliente) 
            VALUES (1, 
            $contrato, 
            $inmueble, 
            $operacion, 
            $asesor, 
            1,
            $cliente)";
            $resultadoInmueble = mysqli_query($db, $queryInmueble);



            // $resultadoInmueble = mysqli_fetch_assoc($resultadoContrato);


            $queryAsignarFK = "SELECT idInmueble FROM inmueble ORDER BY idInmueble DESC LIMIT 1";
            $resultadoAsignarFK = mysqli_query($db, $queryAsignarFK);
            $resultadoAsignarFK = mysqli_fetch_assoc($resultadoAsignarFK);
            $resultadoAsignarFK = (int)$resultadoAsignarFK['idInmueble'];







            if ($superficie_construccion == NULL) {
                $superficie_construccion = 0.0;
            }
            if ($habitaciones == NULL) {
                $habitaciones = 0;
            }
            if ($estacionamiento == NULL) {
                $estacionamiento = 0;
            }


            for ($i = 0; $i <= 20; $i++) {

                if (isset($_POST['otras' . $i]) != NULL) {
                    $otrasCaracteristicas = $_POST['otras' . $i];
                    $queryOtrasCaracteristicas = "INSERT INTO otras_caracteristicas (idAmenidades, id_Inmueble) VALUES ($otrasCaracteristicas, $resultadoAsignarFK)";
                    $resultadoOtrasCaracteristicas = mysqli_query($db, $queryOtrasCaracteristicas);
                }
            }

            $queryCaracteristicas = "INSERT INTO caracteristicas (Superficie_Terreno,
            Superficie_Construccion,
            Habitaciones,
            Puestos_Estacionamiento,
            Observaciones,
            Descripcion,
            idInmueble_Caracteristicas) VALUES ($superficie_terreno,
            $superficie_construccion,
            $habitaciones,
            $estacionamiento,
            '$observaciones',
            '$descripcion',
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

            $carpetaImagenes = "../Imagenes/";

            if (!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }





            for ($i = 1; $i <= 15; $i++) {

                if ($_FILES['foto' . "$i"]['size'] > 0) {

                    if ($_FILES['foto' . "$i"] == $_FILES['foto1']) {
                        $imagen = $_FILES['foto' . "$i"];
                        //"image/jpeg, image/png"
                        if($imagen['type'] == "image/jpeg"){
                            $extension = ".jpg";
                        }else if($imagen['type'] == "image/png"){
                            $extension = ".png";
                        }
                        $nombreImagen = 'inmueble_' . $resultadoAsignarFK . 'foto' . $i . $extension;
                        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
                        $queryFotos = "INSERT INTO fotos (id_Inmueble_Fotos, NombreFotos, FotoPortada) VALUES ($resultadoAsignarFK, '$nombreImagen', '$nombreImagen')";
                        $resultadoFotos = mysqli_query($db, $queryFotos);
                    } else {

                        $imagen = $_FILES['foto' . "$i"];
                        if($imagen['type'] == "image/jpeg"){
                            $extension = ".jpg";
                        }else if($imagen['type'] == "image/png"){
                            $extension = ".png";
                        }
                        $nombreImagen = 'inmueble_' . $resultadoAsignarFK . 'foto' . $i . $extension;
                        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
                        $queryFotos = "INSERT INTO fotos (id_Inmueble_Fotos, NombreFotos) VALUES ($resultadoAsignarFK, '$nombreImagen')";
                        $resultadoFotos = mysqli_query($db, $queryFotos);
                    }
                }
            }


            if ($resultadoInmueble) {
                header('Location:../Listado/index.php');
            }
        } else {
            $errores[] = "No se puede registar el inmueble con las mismas coordenadas y dirección";
        }
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
    <script language="javascript" src="../../../jquery-3.6.1.min.js"></script>
    <title>Unika|Publicar Propiedad</title>

    <script language="javascript">
        $(document).ready(function() {
            $("#cbx_cp").change(function() {

                cp = $(this).val();
                // alert($('input:text[name=cbx_cp]').val());
                $.post("getcp.php", {
                    cp: cp
                }, function(data) {
                    $("#colonia").html(data);
                });
            })
        });
    </script>
    <script language="javascript">
        $(document).ready(function() {
            let i = 0;
            $('#add').click(function(e) {
                i++;

                e.preventDefault();

                if (i <= 20) {
                    $('#0').after('<section id="' + i + '" class="select__config">' +
                        '<span>Otras Características *</span>' +
                        '<select name=' + '"otras' + i + '"' + 'required>' +
                        '<option value=""><--Selecciona--></option>' +
                        '<?php while ($row = mysqli_fetch_assoc($resultadoAmenidadesSecundario)) : ?>' +
                        '<option value="<?php echo $row['idAmenidades']; ?>"><?php echo $row['NombreAmenidades']; ?></option>' +
                        '<?php endwhile; ?>' +
                        '</select>' +
                        '<div id="' + i + '" class="button__delete">' +
                        '<a  class="delete" >-</a>' +
                        '</div>' +
                        '</section>')
                } else {
                    $('.button__add').remove();
                    $('#add').remove();
                }


            });
        });

        $(document).on('click', '.button__delete', function() {
            var button_id = $(this).attr("id");
            $('#' + button_id).hide("slow");
            setTimeout(function() {
                $('#' + button_id).remove();
            }, 800);

        });
    </script>
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

                <form id="combo" name="combo" method="POST" enctype="multipart/form-data">


                    <section class="select">
                        <span>Asesor*</span>
                        <select name="asesor" id="" required>
                            <option value="">
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoAsesor)) : ?>
                                <option value="<?php echo $row['idEmpleado']; ?>"><?php echo $row['Nombre_Apellido']; ?></option>
                            <?php endwhile; ?>
                        </select>

                    </section>
                    <section class="select__config">
                        <span>Tipo de Contrato*</span>
                        <select name="contrato" id="" required>
                            <option value="">
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoContrato)) : ?>
                                <option value="<?php echo $row['idTipo_Contrato']; ?>"><?php echo $row['Nombre_Contrato']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="button__new">
                            <a class="new" href="../Contrato/index.php">Nuevo Contrato</a>
                        </div>
                    </section>
                    <section class="select__config">
                        <span>Tipo de Inmueble*</span>
                        <select name="inmueble" id="" required>
                            <option value="">
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoInmueble)) : ?>
                                <option required value="<?php echo $row['idTipo_Inmueble']; ?>"><?php echo $row['Nombre_Tipo_Inmueble']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="button__new">
                            <a class="new" href="../T.Inmueble/index.php">Nuevo Tipo de Inmueble</a>
                        </div>
                    </section>
                    <section class="select__config">
                        <span>Tipo de Operación*</span>
                        <select name="operacion" id="" required>
                            <option value=''>
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoOperacion)) : ?>
                                <option required value="<?php echo $row['idTipo_Operacion']; ?>"><?php echo $row['Nombre_Operacion']; ?></option>
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
                                <option required value="<?php echo $row['idCliente']; ?>"><?php echo $row['Correo']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="button__new">i
                            <a class="new" href="../../Empleados/Nuevo/index.php">Nuevo Cliente</a>
                        </div>
                    </section>
                    <label for="superficie_terreno">
                        <span>Superficie del Terreno*</span>
                        <input class="input__text" type="number" id="superficie_terreno" name="superficie_terreno" placeholder="En m2" min="50" required>
                    </label>

                    <label for="superficie_construccion">
                        <span>Superficie de Construcción</span>
                        <input class="input__text" type="number" id="superficie_construccion" name="superficie_construccion" placeholder="En m2" min="50" maxlength="45">
                    </label>

                    <label for="habitaciones">
                        <span>Introduce el Número de Habitaciones</span>
                        <input class="input__text" type="number" id="habitaciones" name="habitaciones" placeholder="N° de Habitaciones" min="1">
                    </label>

                    <label for="estacionamiento">
                        <span>Introduce el Número de Lugares de Estacionamiento</span>
                        <input class="input__text" type="number" id="estacionamiento" name="estacionamiento" placeholder="N° de Lugares" min="0">
                    </label>

                    <label for="banos">
                        <span>Introduce el Número de Baños</span>
                        <input class="input__text" type="number" id="banos" name="banos" placeholder="N° de Baños" min="0">
                    </label>

                    <label for="descripcion">
                        <span>Descripción*</span>
                        <input class="input__text" type="text" id="descripcion" name="descripcion" placeholder="Descripción" max="1000" required>
                    </label>

                    <label for="observaciones">
                        <span>Observaciones*</span>
                        <textarea class="input__text" type="text" id="observaciones" name="observaciones" placeholder="Observaciones" max="1000" required></textarea>
                    </label>

                    <section class="select__config" id="0">
                        <span>Otras Características *</span>
                        <select name="otras0" required>
                            <option value="">
                                <--Selecciona-->
                            </option>
                            <?php while ($row = mysqli_fetch_assoc($resultadoAmenidadesPrimario)) : ?>
                                <option value="<?php echo $row['idAmenidades']; ?>"><?php echo $row['NombreAmenidades']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="button__add">
                            <a id="add" class="add">+</a>
                        </div>
                    </section>

                    <section class="select">
                        <label for="cp">
                            <span>Código Postal*</span>
                            <input class="input__text" type="text" id="cbx_cp" name="cbx_cp" placeholder="cp" max="7" required>

                        </label>
                    </section>
                    <section class="select">
                        <span>Colonia* </span>
                        <select id="colonia" name="colonia" id="">
                            <option>
                                <--Selecciona-->
                            </option>

                        </select>
                    </section>

                    <label for="direccion">
                        <span>Dirección*</span>
                        <input class="input__text" type="text" id="direccion" name="direccion" placeholder="Dirección" max="250" required>
                    </label>

                    <label for="precio">
                        <span>Precio*</span>
                        <input class="input__text" type="number" id="precio" name="precio" placeholder="$0000" min="1000" required maxlength="10">
                    </label>

                    <label for="ubicacion">
                        <span>Ubicación</span>
                        <input class="input__text" type="text" id="ubicacion" name="ubicacion" placeholder="URL de Google Maps" min="1">
                    </label>

                    <label for="urlAnuncio">
                        <span>URL del Anuncio</span>
                        <input class="input__text" type="url" id="urlAnuncio" name="urlAnuncio" placeholder="URL">
                    </label>

                    <label for="urlVideo">
                        <span>URL del video</span>
                        <input class="input__text" type="url" id="urlVideo" name="urlVideo" placeholder="URL" maxlength="100">
                    </label>

                    <label for="urlVideo">
                        <span>Foto 1 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto1" name="foto1" accept="image/jpeg, image/png" required>
                    </label>
                    <label for="urlVideo">
                        <span>Foto 2 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto2" name="foto2" accept="image/jpeg, image/png">
                    </label>
                    <label for="urlVideo">
                        <span>Foto 3 (Max: 4 Mb)</span>
                        <input class="input__text" type="file" id="foto3" name="foto3" accept="image/jpeg, image/png">
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