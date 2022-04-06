<?php

    //Conexión a la base de datos

    require '../includes/config/database.php';

    $db = conectarDB();


    $errores = [];



    require '../admin/limpieza.php';



    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        // Asignación de variables y escape de datos para la prevención de inyección SQL

        $correo = limpieza(mysqli_real_escape_string($db, $_POST['correo']));
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $Usuarios_idUsuarios = null;
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = "6Lf8UqUeAAAAAGRvq7HxYsF16nTp-TJjK2s1cm9y";
        $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
        $atributos = json_decode($respuesta, TRUE);




        // Función que valida que la contraseña tenga lo complejidad necesaria 

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


         // Manda el password del usuario a la función y valida si tiene la complejidad
         // necesaria

        $validar = validar_clave($password);

         // Query que comprueba si el correo al registrarse ya existe en la base de datos
        $queryComprobacion = "SELECT Correo FROM usuarios WHERE Correo = '$correo' ";
        $resultadoComprobacion = mysqli_fetch_assoc( mysqli_query($db, $queryComprobacion));



         // Evalua si el password tiene la complejidad necesaria y si el correo no existe aún
         // en la base de datos
        if($resultadoComprobacion != NULL && $validar == true ){

            // Comprueba si el captcha está verificado

            if(!$atributos['success']){

                $errores[] = "Verifica el Captcha";
            } else {

            $passwordMail = $password;

            // Hash de la contraseña antes de insertar en la base de datos

            $passwordHash= password_hash($password, PASSWORD_DEFAULT);


            // Actualización de contraseña

            $queryActualizar = "UPDATE usuarios SET Contrasena = '$passwordHash' WHERE Correo = '$correo'";
            $resultadoActualizar = mysqli_query($db, $queryActualizar);

            $mail = $correo;
            $contenido = "Tu nueva contraseña es: " . $passwordMail . "\r\n" . "Atentamente: Unika - Soporte";
            $header = "From: " . "contacto@unika.com" . "\r\n";
            $header.= "Reply-to: contacto@unika.com" ."\r\n";
            $header.= "X-Mailer: PHP/" . phpversion();
            $mail = @mail($mail, $asunto, $contenido, $header);

            if($mail){
                header('Location: ../login/index.php');
            }




            }
        } else {

            if($resultadoComprobacion != NULL ){
                $errores[] = "El usuario no existe, intenta con otro correo";
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
    <link rel="stylesheet" href="CSS/MEDIUM/mobile.css" media="(min-width: 840px )">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Sign Up</title>
</head>
<body>
    <header class="header__global">
        <section>
                <a href="../index.html">
                    <img src="../Assets/logo.png" alt="">
                </a>
        </section>
    </header>

    <main class="main__signup">
        <?php foreach($errores as $error):?>

        <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>
        <section>

        <form action="" method="POST">



            <label for="correo">
                <span>Correo Electrónico</span>
                <input type="email" id= "correo" name="correo" placeholder = "Correo Electrónico" required maxlength="45">
            </label>

            <label for="password">
                <span>Nueva Constraseña</span>
                <input type="password" id= "password" name="password" placeholder = "Contraseña" required>
            </label>







            <section class="content__buttons">



                <a class="signup__submit" href="../login/index.php">Volver</a>
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