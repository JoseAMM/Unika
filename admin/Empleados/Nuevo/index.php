<?php

    require '../../sesion.php';

    //Conexión a la base de datos

    require '../../../includes/config/database.php';

    $db = conectarDB();


    // Funcion para la limpieza de datos

    require '../limpieza.php';

    $queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

    $resultadoEmpleadoNombre = mysqli_query($db, $queryEmpleado);

    $resultadoEmpleadoNombre = mysqli_fetch_assoc($resultadoEmpleadoNombre);

    $idRolEmpleado = $resultadoEmpleadoNombre['Rol_idRol'];

    $idRolEmpleado = (int)$idRolEmpleado;


    $queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
    $resultadoRolEmpleado = mysqli_query($db, $queryRol);
    $resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);


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

        if($resultadoComprobacion == NULL){

            // Hash de la contraseña antes de insertar en la base de datos

            $passwordHash= password_hash($password, PASSWORD_DEFAULT);



            // Query asignando el correo y el password hasheado a la base de datos

            $queryUsuario = "INSERT INTO usuarios (Correo, Contrasena) VALUES ('$correo', '$passwordHash')";



            // Insertar la información de usuario en la base de datos

            $resultadoUsuario = mysqli_query($db,$queryUsuario);



            // Query para validar el idUsuario y asignarlo a la variable $Usuario_idUsuario

            $queryIdUsuario = "SELECT idUsuarios FROM usuarios WHERE Correo = '$correo'";



            // Query para hacer la consulta del idUsurarios que coincida con la variable $correo

            $Usuarios_idUsuarios = mysqli_query($db, $queryIdUsuario);



            $Usuarios_idUsuarios = mysqli_fetch_assoc($Usuarios_idUsuarios);

            $Usuarios_idUsuarios = $Usuarios_idUsuarios['idUsuarios'];


            $Usuarios_idUsuarios = (int)$Usuarios_idUsuarios;




            // Insertar la información de empleado en la base de datos

            $queryEmpleado = "INSERT INTO empleado (Nombre_Apellido,Documento_Identidad,Telefono,Cargo_idCargo,Rol_idRol,Oficina_idOficina,Usuarios_idUsuarios, Activo)
            VALUES ('$nombre','$doc_identidad','$telefono','$Cargo_idCargo','$Rol_idRol','$Oficina_idOficina','$Usuarios_idUsuarios', $activo)";



            $resultado = mysqli_query($db, $queryEmpleado);
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
    <link rel="stylesheet" href="CSS/MOBILE/mobile.css" media="(max-width: 840px)">
    <link rel="stylesheet" href="CSS/MEDIUM/mobile.css" media="(min-width: 840px )">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Unika|Nuevo Empleado</title>
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
                    <li><a href="../../Propiedades/Listado/index.php"><span>Inmuebles</span></a></li>
                    <li><a href=""><span>VoBo Inmuebles</span></a></li>
                    <li><a href="../Listado/index.php">Asesores</a></li>
                    <li><a href="../../Clientes/Listado/index.php">Clientes</a></li>
                    <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </section>


        <?php foreach($errores as $error):?>

        <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>
        <section class="formulario__content">
        <section class="formulario">

        <form action="" method="POST">

            <label for="nombre">
                <span>Nombre y Apellido</span>
                <input type="text" id= "nombre" name="nombre" placeholder = "Nombre y Apellido" required maxlength="50">
            </label>

            <label for="correo">
                <span>Correo Electrónico</span>
                <input type="email" id= "correo" name="correo" placeholder = "Correo Electrónico" required maxlength="45">
            </label>

            <label for="password">
                <span>Constraseña</span>
                <input type="password" id= "password" name="password" placeholder = "Contraseña" required>
            </label>

            <label for="telefono">
                <span>Teléfono</span>
                <input maxlength="10" class="form__buttonNumber" type="tel" id= "telefono" name="telefono" placeholder = "Teléfono" required >
            </label>

            <label for="doc_identidad">
                <span>Documento de Identidad</span>
                <input type="text" id= "doc_identidad" name= "doc_identidad"  placeholder = "Documento de Identidad" required maxlength="45">
            </label>


            <section class="select">
                <span>Rol</span>
                <select name="rol" id="">
                    <option value="0"><--Selecciona--></option>
                    <?php while($row = mysqli_fetch_assoc($resultadoRol)) : ?>
                        <option value="<?php echo $row['idRol']; ?>"><?php echo $row['Nombre_rol']; ?></option>
                    <?php endwhile; ?>
                </select>
                <div class="button__new">
                    <a class="new" href="../Rol/index.php">Nuevo Rol</a>
                </div>
            </section>

            <section class="select">
                <span>Cargo</span>
                <select name="cargo" id="">
                    <option ><--Selecciona--></option>
                    <?php while($row = mysqli_fetch_assoc($resultadoCargo)) : ?>
                        <option value="<?php echo $row['idCargo']; ?>"><?php echo $row['Nombre_Cargo']; ?></option>
                    <?php endwhile; ?>

                </select>

                <div class="button__new">
                    <a class="new" href="../Cargo/index.php">Nuevo Cargo</a>
                </div>
            </section>

            <section class="select">
                <span>Oficina</span>
                <select name="oficina" id="">
                    <option><--Selecciona--></option>
                    <?php while($row = mysqli_fetch_assoc($resultadoOficina)) : ?>
                        <option required value="<?php echo $row['idOficina']; ?>"><?php echo $row['Nombre_Oficina']; ?></option>
                    <?php endwhile; ?>
                </select>
                <div class="button__new">
                    <a class="new" href="../Oficina/index.php">Nueva Oficina</a>
                </div>
            </section>

            <section class="content__buttons">
                
                
                <a class="signup__submit" href="../Listado/index.php">Volver</a>
                <input type="submit" value = "Registrar" class = "signup__submit">
               
                
                

            </section>
            
        </form>
        </section>
        </section>

    </main>


<?php

require '../../../includes/footer.php'

?>
<script src="JS/menu.js" ></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>