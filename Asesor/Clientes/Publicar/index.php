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

    $errores = [];


    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        $nombre =  limpieza( mysqli_real_escape_string($db, $_POST['nombre']));
        $apellido = limpieza( mysqli_real_escape_string($db, $_POST['apellido']));
        $ine = limpieza( mysqli_real_escape_string($db, $_POST['ine']));
        $telefono = limpieza( mysqli_real_escape_string($db, $_POST['telefono']));
        $correo = limpieza( mysqli_real_escape_string($db, $_POST['correo']));
        $correoUsuario = limpieza( mysqli_real_escape_string($db, $_POST['correoUsuario']));
        $password = limpieza( mysqli_real_escape_string($db, $_POST['contraseña']));


        function validar_clave($password){
            if(strlen($password) < 8){
               return false;
            }
            if (!preg_match('`[a-z]`',$password)){
               
               return false;
            }
            if (!preg_match('`[A-Z]`',$password)){
               
               return false;
            }
            if (!preg_match('`[0-9]`',$password)){
              
               return false;
            }
            
            return true;
         }

         $validar = validar_clave($password,$errores);




        $queryComprobacion = "SELECT Correo FROM usuarios WHERE Correo = '$correoUsuario' ";
        $resultadoComprobacion = mysqli_fetch_assoc( mysqli_query($db, $queryComprobacion));

        if($resultadoComprobacion == NULL && $validar == true ){

            // Hash de la contraseña antes de insertar en la base de datos

            $passwordHash= password_hash($password, PASSWORD_DEFAULT);



            // Query asignando el correo y el password hasheado a la base de datos

            $queryUsuario = "INSERT INTO usuarios (Correo, Contrasena) VALUES ('$correoUsuario', '$passwordHash')";



            // Insertar la información de usuario en la base de datos

            $resultadoUsuario = mysqli_query($db,$queryUsuario);



            // Query para validar el idUsuario y asignarlo a la variable $Usuario_idUsuario

            $queryIdUsuario = "SELECT idUsuarios FROM usuarios WHERE Correo = '$correoUsuario'";



            // Query para hacer la consulta del idUsurarios que coincida con la variable $correo

            $Usuarios_idUsuarios = mysqli_query($db, $queryIdUsuario);



            $Usuarios_idUsuarios = mysqli_fetch_assoc($Usuarios_idUsuarios);

            $Usuarios_idUsuarios = $Usuarios_idUsuarios['idUsuarios'];


            $Usuarios_idUsuarios = (int)$Usuarios_idUsuarios;




            // Insertar la información de empleado en la base de datos

            $queryEmpleado = "INSERT INTO cliente (Nombre, Apellido, INE, Telefono, Correo, Cliente_idUsuarios, Cliente_idRol, Activo)
            VALUES ('$nombre', '$apellido', '$ine','$telefono', '$correo', '$Usuarios_idUsuarios', '3', 1)";



            $resultado = mysqli_query($db, $queryEmpleado);

            if($resultado){
                header('Location: ../Listado/index.php');
            }
            
        } else {

            if(!$resultadoComprobacion == NULL){
                $errores[] = "El usuario ya existe, intenta con otro correo";
            }

            if( !$validar == true){
                if(strlen($password) < 8){
                    $errores[] = "La clave debe tener al menos 8 caracteres";
                    
                 }
                 if (!preg_match('`[a-z]`',$password)){
                    $errores[] = "La clave debe tener al menos una letra minúscula";
                    
                 }
                 if (!preg_match('`[A-Z]`',$password)){
                    $errores[] = "La clave debe tener al menos una letra mayúscula";
                    
                 }
                 if (!preg_match('`[0-9]`',$password)){
                    $errores[] = "La clave debe tener al menos un caracter numérico";
                    
                 }
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
                        <li><a href="../../Propiedades/Listado/index.php"><span>Inmuebles</span></a></li>
                        <li><a href="../../Propiedades/VoBo/index.php"><span>VoBo Inmuebles</span></a></li>
                        <li><a href="../Listado/index.php">Clientes</a></li>
                        <li><a href="../../Mensaje/index.php">Mensaje</a></li>
                        <li><a href="../../Propiedades/Documentos/index.php">Documentos/Inmuebles</a></li>
                        <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </section>


        <section class="main__formulario">
        <?php foreach($errores as $error):?>

            <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>

            <form action="" method="POST" enctype="multipart/form-data">

                <label for="nombre">
                    <span>Nombre</span>
                    <input type="text" id= "nombre" name="nombre" placeholder = "Nombre" required maxlength="45">
                </label>

                <label for="apellido">
                    <span>Apellido</span>
                    <input type="text" id= "apellido" name="apellido"  placeholder = "Apellido" required maxlength="45">
                </label>

                <label for="correoUsuario">
                    <span>Correo (Iniciar Sesión)</span>
                    <input type="email" id= "correoUsuario" name="correoUsuario"  placeholder = "algo@example.com" required maxlength="45">
                </label>

                <label for="contraseña">
                    <span>Contraseña</span>
                    <input type="password" id= "contraseña" name="contraseña"  placeholder = "Contraseña" required maxlength="45">
                </label>

                <label for="ine">
                    <span>INE</span>
                    <input type="text" id= "ine" name="ine" placeholder = "INE" maxlength="9" required >
                </label>

                <label for="telefono">
                    <span>Telefono</span>
                    <input type="text" id= "telefono" name="telefono" placeholder = "Teléfono" required  maxlength="10">
                </label>

                <label for="correo">
                    <span>Correo (De contacto)</span>
                    <input type="email" id= "correo" name= "correo"  placeholder = "Correo de Contacto" required  maxlength="100">
                </label>
                <input type="submit" value = "Registrar" class = "signup__submit">
            </form>
        </section>
    </section>
    
</main>
<script src="JS/menu.js" ></script>
</body>
</html>