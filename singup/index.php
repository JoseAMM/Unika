<?php

    //Conexión a la base de datos

    require '../includes/config/database.php';

    $db = conectarDB();


    $errores = [];









    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        // Asignación de variables y escape de datos para la prevención de inyección SQL

        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
        $correo = mysqli_real_escape_string($db, $_POST['correo']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $telefono = mysqli_real_escape_string($db, $_POST['telefono']);
        $Usuarios_idUsuarios = null;
        $rol = 3;
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = "6Lf8UqUeAAAAAGRvq7HxYsF16nTp-TJjK2s1cm9y";
        $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
        $atributos = json_decode($respuesta, TRUE);

        // Sanitización de datos

        $telefono = filter_var($telefono, FILTER_SANITIZE_NUMBER_INT);

        $queryComprobacion = "SELECT Correo FROM usuarios WHERE Correo = '$correo' ";
        $resultadoComprobacion = mysqli_fetch_assoc( mysqli_query($db, $queryComprobacion));

        if($resultadoComprobacion == NULL){

            if(!$atributos['success']){

                $errores[] = "Verifica el Captcha";
    
            } else {

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

            $queryEmpleado = "INSERT INTO cliente (Nombre,Telefono, Correo, Cliente_idUsuarios, Cliente_idRol)
            VALUES ('$nombre','$telefono', '$correo', '$Usuarios_idUsuarios', '$rol')";



            $resultado = mysqli_query($db, $queryEmpleado);
            }
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Sign Up</title>
</head>
<body>
    <header class="header__global">
            <section><img src="../Assets/logo.png" alt=""></section>
            <nav>
                <ul>
                    <li><a href="" target="_blanck">Inicio</a></li>
                    <li><a href="" target="_blanck">Nosotros</a></li>
                    <li><a href="" target="_blanck">Contacto</a></li>
                    <li><a href="" target="_blanck">Servicios</a></li>
                </ul>
            </nav>
    </header>

    <main class="main__signup">
        <?php foreach($errores as $error):?>

        <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>
        <section>

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
                <span>Nueva Constraseña</span>
                <input type="password" id= "password" name="password" placeholder = "Contraseña" required>
            </label>

            <label for="telefono">
                <span>Teléfono</span>
                <input maxlength="10" class="form__buttonNumber" type="tel" id= "telefono" name="telefono" placeholder = "Teléfono" required >
            </label>

            
            <section class="content__buttons">
                
                
                
                <a class="signup__submit" href="../index.php">Volver</a>
                <input type="submit" value = "Registrar" class = "signup__submit">
                
                

            </section>


            <div class="captcha">
            <div class="g-recaptcha" data-sitekey="6Lf8UqUeAAAAAMcuV8LP0YFnsTIRzbhi5vcXfJd3">hol</div>
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