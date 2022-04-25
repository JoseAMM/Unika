<?php

    //Conexión a la base de datos

    require '../includes/config/database.php';

    $db = conectarDB();


    $errores = [];
    $ruta = '';


    session_start();


    if(isset($_SESSION['login'])){

        session_unset();
        session_destroy();
        header('Location: ../index.html' );


    }


    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // Escape de las variables $correo y $password

        $errores = [];
        $correo = mysqli_real_escape_string($db, $_POST['correo']);
        $password = mysqli_real_escape_string($db, $_POST['password']);


        // Código adjunto para el funcionamiento y validación del captcha

        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = "6LfyQDsfAAAAAO_yoUMgkyN35t4X8LGn-K5VT5ox";
        $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
        $atributos = json_decode($respuesta, TRUE);


        // Consulta a la BD para verificar que haya un usuario con el correo
        // proporcionado por el usuario

        $queryComprobacion = "SELECT * FROM usuarios WHERE Correo = '$correo'";
        $resultadoComprobacion = mysqli_query($db, $queryComprobacion);


        // Validación, si la consulta es exitosa, se procede a hacer toda la validación
        // de la contraseña


        if($resultadoComprobacion -> num_rows){

            // Se valida el password encriptado desde la BD

            $resultadoComprobacion = mysqli_fetch_assoc($resultadoComprobacion);

            $resultadoPassword = password_verify($password, $resultadoComprobacion['Contrasena']);

            // Si la verificación de la contraseña es TRUE, verificar si el captcha no está verificado
            // Si no está verificado asignar un error al array $errores
            // Si, sí está verificado, hacer la consulta del rol del cliente y redirigirlo a la
            // página de acuerdo a su rol

            if($resultadoPassword){

                if(!$atributos['success']){

                    $errores[] = "Verifica el Captcha";

                } else {


                $queryEmpleado = "SELECT Rol_idRol, Activo FROM empleado WHERE Usuarios_idUsuarios ='$resultadoComprobacion[idUsuarios]'";
                $resultadoEmpleado = mysqli_fetch_assoc( mysqli_query($db, $queryEmpleado));

                $queryCliente = "SELECT Cliente_idRol, Activo FROM cliente WHERE Cliente_idUsuarios ='$resultadoComprobacion[idUsuarios]'";
                $resultadoCliente = mysqli_fetch_assoc( mysqli_query($db, $queryCliente));

                if($resultadoEmpleado){
                    if($resultadoEmpleado['Activo'] == 0){
                        header('Location: ../Inactivo/index.php');
                    }
                    else {

                        if ($resultadoEmpleado['Rol_idRol'] == 1){
                            session_start();
                            header('Location:../admin/Propiedades/Listado/index.php');

                            // Declaración de variables en la superglobal $_SESSION

                            $_SESSION['usuario'] = $resultadoComprobacion['Correo'];
                            $_SESSION['idUsuarios'] = $resultadoComprobacion['idUsuarios'];
                            $_SESSION['login'] = true;
                            $_SESSION['time'] = time();
                        } else if ($resultadoEmpleado['Rol_idRol'] == 2){
                            session_start();
                            header('Location:../Asesor/Propiedades/Listado/index.php');

                            // Declaración de variables en la superglobal $_SESSION

                            $_SESSION['usuario'] = $resultadoComprobacion['Correo'];
                            $_SESSION['idUsuarios'] = $resultadoComprobacion['idUsuarios'];
                            $_SESSION['login'] = true;
                            $_SESSION['time'] = time();
                        } 
                    }
                }

                if($resultadoCliente){

                    if($resultadoCliente['Activo'] == 0){
                        header('Location: ../Inactivo/index.php');
                    } else {
                        if ($resultadoCliente['Cliente_idRol'] == 3 ){
                            header('Location: ../Cliente/Listado/index.php');
                            session_start();
                            $_SESSION['usuario'] = $resultadoComprobacion['Correo'];
                            $_SESSION['idUsuarios'] = $resultadoComprobacion['idUsuarios'];
                            $_SESSION['login'] = true;
                            $_SESSION['time'] = time();
                        }
                    }



                }




                }
            } else {
                $errores[] = "La contraseña es incorrecta";
            }
        } else {

            $errores[] = "El usuario no existe";


        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unika|Bienes Raíces</title>
    <link rel="stylesheet" href="css/SMALL/mobile.css" media="(max-width: 840px)">
    <link rel="stylesheet" href="css/MEDIUM/mobile.css" media="(min-width: 840px )">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    

</head>
<body>
    <header class="header__global">
        <section>
            <a href="../index.html">
                <img src="../Assets/logo.png" alt="">
            </a>
        </section>
    </header>
    <main class="main__login">

        <?php foreach($errores as $error):?>
            
            <div class="error"><p><?php  echo $error ?></p></div>
            
            <?php endforeach?>
            
            <section>
                <form action="" method="POST">

                    <label for="correo">
                        <input type="email" id= "correo" name="correo" placeholder = "Correo" required>
                    </label>

                    <label for="password">
                        <input type="password" id="password" name="password" placeholder = "Contraseña" required>
                    </label>

                    <a href="../Password/index.php" class="restore__password">Olvide Mi Contraseña</a>

                    <section class="content__buttons">
                        <input type="submit" value = "Entrar" class = "login__submit">
                        <a class="login__submit"href="../singup/index.php">Registrarme</a>
                    </section>

            <div class="captcha">
            <div class="g-recaptcha" data-sitekey="6LfyQDsfAAAAAPTRFJVSAZqsMFFl8_7x3HFOc5md"></div>
            </div>
        </form>

    </section>

    </main>
<?php

    require '../includes/footer.php'

?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>