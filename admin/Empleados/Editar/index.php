<?php
    require '../../sesion.php';

    $idEmpleado = $_GET['id'];
    $idEmpleado = filter_var($idEmpleado, FILTER_VALIDATE_INT);

    if(!$idEmpleado) {
        header('Location:../../../index.php');
    }

    //Conexión a la base de datos

    require '../../../includes/config/database.php';

    $db = conectarDB();

    // Funcion para la limpieza de datos

    require '../../limpieza.php';


    $errores = [];

    // Consulta de los tipos de roles para el select

    $consultaRol = "SELECT idRol, Nombre_rol FROM rol";
    $resultadoRol = mysqli_query($db, $consultaRol);

    // Consulta de los tipos de cargos para el select

    $consultaCargo = "SELECT idCargo, Nombre_Cargo FROM cargo";
    $resultadoCargo = mysqli_query($db, $consultaCargo);

    // Consulta de las oficinas para el select

    $consultaOficina = "SELECT idOficina, Nombre_Oficina FROM oficina WHERE idOficina > 0;";
    $resultadoOficina = mysqli_query($db, $consultaOficina);

    $consultaDatosEmpleado = "SELECT * FROM empleado WHERE idEmpleado = $idEmpleado";
    $resultadoDatosEmpleado = mysqli_query($db, $consultaDatosEmpleado);
    $resultadoDatosEmpleado = mysqli_fetch_assoc($resultadoDatosEmpleado);
    $idUsuario = $resultadoDatosEmpleado['Usuarios_idUsuarios'];


    $consultaDatosUsuario = "SELECT * FROM usuarios WHERE idUsuarios = $idUsuario";
    $resultadoDatosUsario = mysqli_query($db, $consultaDatosUsuario);
    $resultadoDatosUsario = mysqli_fetch_assoc($resultadoDatosUsario);
    

    $correo   = $resultadoDatosUsario['Correo'];
    $nombre   = $resultadoDatosEmpleado['Nombre_Apellido'];
    $telefono = $resultadoDatosEmpleado['Telefono'];
    $doc_identidad = $resultadoDatosEmpleado['Documento_Identidad'];
    $Cargo_idCargo = $resultadoDatosEmpleado['Cargo_idCargo'];
    $Rol_idRol = $resultadoDatosEmpleado['Rol_idRol'];
    $Oficina_idOficina = $resultadoDatosEmpleado['Oficina_idOficina'];







    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        // Asignación de variables y escape de datos para la prevención de inyección SQL

        $nombre = limpieza( mysqli_real_escape_string($db, $_POST['nombre']));
        $correo = limpieza( mysqli_real_escape_string($db, $_POST['correo']));
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $telefono = mysqli_real_escape_string($db, $_POST['telefono']);
        $doc_identidad = limpieza( mysqli_real_escape_string( $db, $_POST['doc_identidad']));
        $Cargo_idCargo = $_POST['cargo'];
        $Rol_idRol = $_POST['rol'];
        $Oficina_idOficina = $_POST['oficina'];
        $Usuarios_idUsuarios = null;
        $activo = 1;

        // Sanitización de datos

        $telefono = filter_var($telefono, FILTER_SANITIZE_NUMBER_INT);

        $queryComprobacion = "SELECT Correo FROM usuarios WHERE Correo = '$correo' ";
        $resultadoComprobacion = mysqli_fetch_assoc( mysqli_query($db, $queryComprobacion));

        if($resultadoComprobacion['Correo'] == $correo OR $resultadoComprobacion['Correo'] != $correo){


            // Query para actualizar el correo en la base de datos

            $queryUsuario = "UPDATE usuarios SET Correo = '$correo' WHERE idUsuarios = $idUsuario";



            // Actualizar la información de usuario en la base de datos

            $resultadoUsuario = mysqli_query($db,$queryUsuario);


            // Insertar la información de empleado en la base de datos

            $queryNombre = "UPDATE empleado SET Nombre_Apellido = '$nombre' WHERE idEmpleado = $idEmpleado";
            $queryDocumento = "UPDATE empleado SET Documento_Identidad = '$doc_identidad' WHERE idEmpleado = $idEmpleado";
            $queryTelefono = "UPDATE empleado SET Telefono  = $telefono  WHERE idEmpleado = $idEmpleado";
            $queryCargo = "UPDATE empleado SET Cargo_idCargo = $Cargo_idCargo  WHERE idEmpleado = $idEmpleado";
            $queryRol = "UPDATE empleado SET Rol_idRol = $Rol_idRol  WHERE idEmpleado = $idEmpleado";
            $queryOficina = "UPDATE empleado SET Oficina_idOficina = $Oficina_idOficina  WHERE idEmpleado = $idEmpleado";

            
            $resultadoNombre = mysqli_query($db, $queryNombre );
            $resultadoDocumento = mysqli_query($db, $queryDocumento );
            $resultadoTelefono = mysqli_query($db, $queryTelefono );
            $resultadoCargo = mysqli_query($db, $queryCargo );
            $resultadoRol = mysqli_query($db, $queryRol );
            $resultadoOficina = mysqli_query($db, $queryOficina );
            

            header('Location:../Listado/index.php');
        } else {
            $errores[] = "El usuario ya existe, intenta con otro correo";
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
    <title>Unika|Editar Asesor</title>
</head>
<body>
    <header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="../../index.php"><img src="../../../Assets/logo.png" alt=""></a>
            </section>

        </div>

        <section class="header__tittle">
            <p>Nuevo Empleado</p>
        </section>
    </header>

    <main>
        <div class="button__volver">
            <a class="volver" href="../Listado/index.php">Volver</a>
        </div>

        <?php foreach($errores as $error):?>

        <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>
        <section>

        <form action="" method="POST">

            <label for="nombre">
                <span>Nombre y Apellido</span>
                <input value="<?php echo $nombre;  ?>" type="text" id= "nombre" name="nombre" placeholder = "Nombre y Apellido" required maxlength="50">
            </label>

            <label for="correo">
                <span>Correo Electrónico</span>
                <input value="<?php echo $correo;  ?>" type="email" id= "correo" name="correo" placeholder = "Correo Electrónico" required maxlength="45">
            </label>


            <label for="telefono">
                <span>Teléfono</span>
                <input value="<?php echo $telefono;  ?>" maxlength="10" class="form__buttonNumber" type="tel" id= "telefono" name="telefono" placeholder = "Teléfono" required >
            </label>

            <label for="doc_identidad">
                <span>Documento de Identidad</span>
                <input value="<?php echo $doc_identidad;  ?>" type="text" id= "doc_identidad" name= "doc_identidad"  placeholder = "Documento de Identidad" required maxlength="45">
            </label>

            <span>Rol</span>
            <select name="rol" id="">
                <option value="0"><--Selecciona--></option>
                <?php while($row = mysqli_fetch_assoc($resultadoRol)) : ?>
                    <option <?php echo $Rol_idRol == $row['idRol'] ? 'selected' : '' ; ?> value="<?php echo $row['idRol']; ?>"><?php echo $row['Nombre_rol']; ?></option>
                <?php endwhile; ?>
            </select>

            <span>¿Qué cargo desempeñas?</span>
            <select name="cargo" id="">
                <option ><--Selecciona--></option>
                <?php while($row = mysqli_fetch_assoc($resultadoCargo)) : ?>
                    <option  <?php echo $Cargo_idCargo == $row['idCargo'] ? 'selected' : '' ; ?> value="<?php echo $row['idCargo']; ?>"><?php echo $row['Nombre_Cargo']; ?></option>
                <?php endwhile; ?>

            </select>

            <span>¿En que oficina laborará?</span>
            <select name="oficina" id="">
                <option><--Selecciona--></option>
                <?php while($row = mysqli_fetch_assoc($resultadoOficina)) : ?>
                    <option <?php echo $Oficina_idOficina == $row['idOficina'] ? 'selected' : '' ; ?> required value="<?php echo $row['idOficina']; ?>"><?php echo $row['Nombre_Oficina']; ?></option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value = "Registrar" class = "signup__submit">
        </form>
        </section>

    </main>


<?php

require '../../../includes/footer.php'

?>
</body>
</html>