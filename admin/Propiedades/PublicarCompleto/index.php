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




    $errores = [];


    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(isset($_POST['cp']) AND isset($_POST['asesor']) AND isset($_POST['contrato']) AND isset($_POST['inmueble']) AND isset($_POST['direccion']) == FALSE){
            echo "hola";
            $cp = $_POST['cp'];
            $asesor = $_POST['asesor'];
            echo $asesor;
            $consultaColonia = "SELECT idColonias, Nombre_Colonia FROM colonias WHERE Codigo_Postal = $cp ";
            $resultadoColonia = mysqli_query($db, $consultaColonia);
            $contrato = $_POST['contrato'];
            $inmueble = $_POST['inmueble'];
            $operacion = $_POST['operacion'];
            $superficie_terreno = filter_var(mysqli_real_escape_string($db, $_POST['superficie_terreno']), FILTER_SANITIZE_NUMBER_FLOAT);
            $superficie_construccion = filter_var(mysqli_real_escape_string($db, $_POST['superficie_construccion']), FILTER_SANITIZE_NUMBER_FLOAT);
            $habitaciones = filter_var(mysqli_real_escape_string($db, $_POST['habitaciones']), FILTER_SANITIZE_NUMBER_INT);
            $estacionamiento = filter_var(mysqli_real_escape_string($db, $_POST['estacionamiento']), FILTER_SANITIZE_NUMBER_INT);
            $otras = limpieza( mysqli_real_escape_string($db, $_POST['otras']));
            
        } if(isset($_POST['direccion'])){
            
            $direccion =  limpieza( mysqli_real_escape_string($db, $_POST['direccion']));
            $ubicacion = limpieza( mysqli_real_escape_string($db, $_POST['ubicacion']));

            $queryBuscarInmueble = "SELECT Direccion FROM datos_basicos WHERE Direccion = '$direccion' AND Ubicacion_Maps = '$ubicacion'";
            $resultadoBuscarInmueble = mysqli_fetch_assoc( mysqli_query($db, $queryBuscarInmueble));

            


        if($resultadoBuscarInmueble == NULL) {
             // Asignación de variables y escape de datos para la prevención de inyección SQL
            $asesor = $_POST['asesor'];
            $contrato = $_POST['contrato'];
            $inmueble = $_POST['inmueble'];
            $operacion = $_POST['operacion'];
            $colonia = $_POST['colonia'];


            
            $carpetaImagenes = "../../../admin/Propiedades/Imagenes/";
            
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }
            
            
            
             
            $superficie_terreno = filter_var(mysqli_real_escape_string($db, $_POST['superficie_terreno']), FILTER_SANITIZE_NUMBER_FLOAT);
            $superficie_construccion = filter_var(mysqli_real_escape_string($db, $_POST['superficie_construccion']), FILTER_SANITIZE_NUMBER_FLOAT);
            $habitaciones = filter_var(mysqli_real_escape_string($db, $_POST['habitaciones']), FILTER_SANITIZE_NUMBER_INT);
            $estacionamiento = filter_var(mysqli_real_escape_string($db, $_POST['estacionamiento']), FILTER_SANITIZE_NUMBER_INT);
            $otras = limpieza( mysqli_real_escape_string($db, $_POST['otras']));
            $precio = filter_var(mysqli_real_escape_string($db, $_POST['precio']), FILTER_SANITIZE_NUMBER_FLOAT);
            
            $urlAnuncio = limpieza( filter_var(mysqli_real_escape_string($db, $_POST['urlAnuncio']), FILTER_SANITIZE_URL));
            $urlVideo = limpieza( filter_var(mysqli_real_escape_string($db, $_POST['urlVideo']), FILTER_SANITIZE_URL));
            
            
            $queryInmueble = "INSERT INTO inmueble (Activo, idTipo_Contrato, idTipo_Inmueble, idTipo_Operacion, id_Empleado, VoBo) VALUES (1, $contrato, $inmueble, $operacion, $asesor, 1)";
            $resultadoInmueble = mysqli_query($db, $queryInmueble);
            
            
            
            // $resultadoInmueble = mysqli_fetch_assoc($resultadoContrato);
        
            
            $queryAsignarFK = "SELECT idInmueble FROM inmueble ORDER BY idInmueble DESC LIMIT 1";
            $resultadoAsignarFK = mysqli_query($db, $queryAsignarFK);
            $resultadoAsignarFK = mysqli_fetch_assoc($resultadoAsignarFK);
            $resultadoAsignarFK = (int)$resultadoAsignarFK['idInmueble'];
            
            
            


            
            
            
            
            
            
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

           

            if($_FILES['foto1']['size'] != 0){
                $imagen1 = $_FILES['foto1'];
                $nombreImagen = 'inmueble_'.$resultadoAsignarFK . 'foto1'. '.jpg';
                move_uploaded_file($imagen1['tmp_name'], $carpetaImagenes . $nombreImagen);
                $queryFotos = "INSERT INTO fotos1 (idFotos1) VALUES ('$nombreImagen')";
                $resultadoFotos = mysqli_query($db, $queryFotos);
                $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos1 = '$nombreImagen' WHERE Inmueble_idInmueble = $resultadoAsignarFK";
                $resultadoFoto = mysqli_query($db, $queryFoto);
            }

            if($_FILES['foto2']['size'] != 0) {
                $imagen2 = $_FILES['foto2'];
                $nombreImagen = 'inmueble_'.$resultadoAsignarFK . 'foto2'. '.jpg';
                move_uploaded_file($imagen2['tmp_name'], $carpetaImagenes . $nombreImagen);

                $queryFotos = "INSERT INTO fotos2 (idFotos2) VALUES ('$nombreImagen')";
                $resultadoFotos = mysqli_query($db, $queryFotos);

                $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos2 = '$nombreImagen' WHERE Inmueble_idInmueble = $resultadoAsignarFK";
                $resultadoFoto = mysqli_query($db, $queryFoto);

            }
            if($_FILES['foto3']['size'] != 0) {

                $imagen3 = $_FILES['foto3'];
                $nombreImagen = 'inmueble_'.$resultadoAsignarFK . 'foto3'. '.jpg';
                move_uploaded_file($imagen3['tmp_name'], $carpetaImagenes . $nombreImagen);

                $queryFotos = "INSERT INTO fotos3 (idFotos3) VALUES ('$nombreImagen')";
                $resultadoFotos = mysqli_query($db, $queryFotos);

                $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos3 = '$nombreImagen' WHERE Inmueble_idInmueble = $resultadoAsignarFK";
                $resultadoFoto = mysqli_query($db, $queryFoto);

            }
            if($_FILES['foto4']['size'] != 0) {

                $imagen4 = $_FILES['foto4'];
                $nombreImagen = 'inmueble_'.$resultadoAsignarFK . 'foto4'. '.jpg';
                move_uploaded_file($imagen4['tmp_name'], $carpetaImagenes . $nombreImagen);

                $queryFotos = "INSERT INTO fotos4 (idFotos4) VALUES ('$nombreImagen')";
                $resultadoFotos = mysqli_query($db, $queryFotos);

                $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos4 = '$nombreImagen' WHERE Inmueble_idInmueble = $resultadoAsignarFK";
                $resultadoFoto = mysqli_query($db, $queryFoto);
                

            }
            if($_FILES['foto5']['size'] != 0) {

                $imagen5 = $_FILES['foto5'];
                $nombreImagen = 'inmueble_'.$resultadoAsignarFK . 'foto5'. '.jpg';
                move_uploaded_file($imagen5['tmp_name'], $carpetaImagenes . $nombreImagen);

                $queryFotos = "INSERT INTO fotos5 (idFotos5) VALUES ('$nombreImagen')";
                $resultadoFotos = mysqli_query($db, $queryFotos);

                $queryFoto = "UPDATE datos_basicos SET Fotos_idFotos5 = '$nombreImagen' WHERE Inmueble_idInmueble = $resultadoAsignarFK";
                $resultadoFoto = mysqli_query($db, $queryFoto);
                

            }
        if($resultadoInmueble){
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Unika|Publicar Propiedad</title>
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


        <section class="main__formulario">
        <?php foreach($errores as $error):?>

        <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>

            <form action="" method="POST" enctype="multipart/form-data">


                <section class="select">
                <span>Asesor*</span>
                    <select name="asesor" id="" required>
                        <option value=""><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoAsesor)) : ?>
                            <option <?php echo $asesor == $row['idEmpleado']  ? 'selected' : '' ; ?> value="<?php echo $row['idEmpleado']; ?>"><?php echo $row['Nombre_Apellido']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    
                </section>
                <section class="select__config">
                    <span>Tipo de Contrato*</span>
                    <select name="contrato" id="" required>
                        <option value=""><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoContrato)) : ?>
                            <option <?php echo $contrato == $row['idTipo_Contrato'] ? 'selected' : '' ; ?> value="<?php echo $row['idTipo_Contrato']; ?>"><?php echo $row['Nombre_Contrato']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="button__new">
                        <a class="new" href="../Contrato/index.php">Nuevo Contrato</a>
                    </div>
                </section>
                <section class="select__config">
                    <span>Tipo de Inmueble*</span>
                    <select name="inmueble" id="" required>
                        <option value=""><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoInmueble)) : ?>
                            <option <?php echo $inmueble == $row['idTipo_Inmueble'] ? 'selected' : '' ; ?> value="<?php echo $row['idTipo_Inmueble']; ?>"><?php echo $row['Nombre_Tipo_Inmueble']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="button__new">
                        <a class="new" href="../T.Inmueble/index.php">Nuevo Tipo de Inmueble</a>
                    </div>
                </section>
                <section class="select__config">
                    <span>Tipo de Operación*</span>
                    <select name="operacion" id="" required>
                        <option value=""><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoOperacion)) : ?>
                            <option <?php echo $operacion == $row['idTipo_Operacion'] ? 'selected' : '' ; ?> value="<?php echo $row['idTipo_Operacion']; ?>"><?php echo $row['Nombre_Operacion']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="button__new">
                        <a class="new" href="../Operacion/index.php">Nueva Operación</a>
                    </div>
                </section>
                <label for="superficie_terreno">
                    <span>Superficie del Terreno*</span>
                    <input type="number" id= "superficie_terreno" value="<?php echo $superficie_terreno?>" name="superficie_terreno" placeholder = "En m2" min="50" required>
                </label>

                <label for="superficie_construccion">
                    <span>Superficie de Construcción*</span>
                    <input type="number" id= "superficie_construccion"  value="<?php echo $superficie_construccion?>" name="superficie_construccion"  placeholder = "En m2"  min="50" required maxlength="45">
                </label>

                <label for="habitaciones">
                    <span>Introduce el Número de Habitaciones*</span>
                    <input type="number" id= "habitaciones"  value="<?php echo $habitaciones?>" name="habitaciones" placeholder = "N° de Habitaciones" min="1" required>
                </label>

                <label for="estacionamiento">
                    <span>Introduce el Número de Lugares de Estacionamiento*</span>
                    <input type="number" id= "estacionamiento"  value="<?php echo $estacionamiento?>" name="estacionamiento" placeholder = "N° de Lugares" min="0" required >
                </label>

                <label for="otras">
                    <span>Otras Características*</span>
                    <input type="text" id= "otras" name= "otras"  value="<?php echo $otras?>" placeholder = "Otras Características" required  maxlength="100">
                </label>

                <label for="cp">
                    <span>Código Postal*</span>
                    <input type="text" id= "cp"  value="<?php echo $cp?>" name="cp" placeholder = "3100" readonly max="7" required>
                </label>

                <section class="select">
                    <span>Colonia* </span>
                    <select name="colonia" id="">
                        <option><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoColonia)) : ?>
                            <option required value="<?php echo $row['idColonias']; ?>"><?php echo $row['Nombre_Colonia']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </section>
                    <label for="direccion">
                        <span>Dirección*</span>
                        <input type="text" id= "direccion" name="direccion" placeholder = "Dirección" max="250" required>
    
                    </label>
                    <label for="precio">
                    <span>Precio*</span>
                    <input type="number" id= "precio" name="precio"  placeholder = "$0000"  min="1000" required maxlength="10">
                </label>

                <label for="ubicacion">
                    <span>Ubicación</span>
                    <input type="text" id= "ubicacion" name="ubicacion" placeholder ="En Coordenadas" min="1" >
                </label>

                <label for="urlAnuncio">
                    <span>URL del Anuncio</span>
                    <input type="url" id= "urlAnuncio" name="urlAnuncio" placeholder = "URL"  >
                </label>

                <label for="urlVideo">
                    <span>URL del video</span>
                    <input type="url" id= "urlVideo" name= "urlVideo"  placeholder = "URL"   maxlength="100">
                </label>

                <label for="urlVideo">
                    <span>Foto 1 (Max: 4 Mb)</span>
                    <input type="file" id= "foto1" name= "foto1" accept="image/jpeg, image/png">
                </label>
                <label for="urlVideo">
                    <span>Foto 2 (Max: 4 Mb)</span>
                    <input type="file" id= "foto2" name= "foto2"   accept="image/jpeg, image/png">
                </label>
                <label for="urlVideo">
                    <span>Foto 3 (Max: 4 Mb)</span>
                    <input type="file" id= "foto3" name= "foto3"   accept="image/jpeg, image/png">
                </label>
                <label for="urlVideo">
                    <span>Foto 4 (Max: 4 Mb)</span>
                    <input type="file" id= "foto4" name= "foto4"   accept="image/jpeg, image/png">
                </label>
                <label for="urlVideo">
                    <span>Foto 5 (Max: 4 Mb)</span>
                    <input type="file" id= "foto5" name= "foto5"   accept="image/jpeg, image/png">
                </label>


                <input type="submit" value = "Registrar" class = "signup__submit">
            </form>
        </section>
    </section>
    
</main>
<script src="JS/menu.js" ></script>
</body>
</html>