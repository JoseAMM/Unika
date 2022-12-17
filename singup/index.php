<?php

//Conexión a la base de datos

require '../includes/config/database.php';

$db = conectarDB();


$errores = [];



require '../admin/limpieza.php';



// Consulta de los tipos de roles para el select

$consultaRol = "SELECT idRol, Nombre_rol FROM rol WHERE idRol IN(2,3)";
$resultadoRol = mysqli_query($db, $consultaRol);

// Consulta de los tipos de cargos para el select

$consultaCargo = "SELECT idCargo, Nombre_Cargo FROM cargo";
$resultadoCargo = mysqli_query($db, $consultaCargo);

// Consulta de las oficinas para el select

$consultaOficina = "SELECT idOficina, Nombre_Oficina FROM oficina WHERE idOficina > 0;";
$resultadoOficina = mysqli_query($db, $consultaOficina);




if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Asignación de variables y escape de datos para la prevención de inyección SQL

    $nombre = limpieza(mysqli_real_escape_string($db, $_POST['nombre']));
    $apellido = limpieza(mysqli_real_escape_string($db, $_POST['apellido']));
    $correo = limpieza(mysqli_real_escape_string($db, $_POST['correo']));
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $telefono = limpieza(mysqli_real_escape_string($db, $_POST['telefono']));
    $ine = limpieza(mysqli_real_escape_string($db, $_POST['ine']));
    $rol = limpieza(mysqli_real_escape_string($db, $_POST['rol']));
    $cargo = limpieza(mysqli_real_escape_string($db, $_POST['cargo']));
    $oficina = limpieza(mysqli_real_escape_string($db, $_POST['oficina']));
    $Usuarios_idUsuarios = null;
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $secretkey = "6Lf8UqUeAAAAAGRvq7HxYsF16nTp-TJjK2s1cm9y";
    $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
    $atributos = json_decode($respuesta, TRUE);
    $telefono = filter_var($telefono, FILTER_SANITIZE_NUMBER_INT);



    // Función que valida que la contraseña tenga lo complejidad necesaria 

    function validar_clave($password)
    {
        if (strlen($password) < 8) {
            return false;
        }
        if (!preg_match('`[a-z]`', $password)) {

            return false;
        }
        if (!preg_match('`[A-Z]`', $password)) {

            return false;
        }
        if (!preg_match('`[0-9]`', $password)) {
            // preg_match('`[@#_^*%/.+:;=]`', $password)

            return false;
        }

        return true;
    }


    // Manda el password del usuario a la función y valida si tiene la complejidad
    // necesaria

    $validar = validar_clave($password);

    // Query que comprueba si el correo al registrarse ya existe en la base de datos
    $queryComprobacion = "SELECT Correo FROM usuarios WHERE Correo = '$correo' ";
    $resultadoComprobacion = mysqli_fetch_assoc(mysqli_query($db, $queryComprobacion));



    // Evalua si el password tiene la complejidad necesaria y si el correo no existe aún
    // en la base de datos
    if ($resultadoComprobacion == NULL && $validar == true) {

        // Comprueba si el captcha está verificado

        if (!$atributos['success']) {

            $errores[] = "Verifica el Captcha";
        } else {

            // Hash de la contraseña antes de insertar en la base de datos

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);





            // Query asignando el correo y el password hasheado a la base de datos

            $queryUsuario = "INSERT INTO usuarios (Correo, Contrasena) VALUES ('$correo', '$passwordHash')";



            // Insertar la información de usuario en la base de datos

            $resultadoUsuario = mysqli_query($db, $queryUsuario);



            // Query para validar el idUsuario y asignarlo a la variable $Usuario_idUsuario

            $queryIdUsuario = "SELECT idUsuarios FROM usuarios WHERE Correo = '$correo'";



            // Query para hacer la consulta del idUsurarios que coincida con la variable $correo

            $Usuarios_idUsuarios = mysqli_query($db, $queryIdUsuario);



            $Usuarios_idUsuarios = mysqli_fetch_assoc($Usuarios_idUsuarios);

            $Usuarios_idUsuarios = $Usuarios_idUsuarios['idUsuarios'];


            $Usuarios_idUsuarios = (int)$Usuarios_idUsuarios;



            if ($rol == 2) {

                // Insertar la información de empleado en la base de datos 
                $queryAsesor = "INSERT INTO empleado (Nombre_Apellido, Documento_Identidad, Telefono, Usuarios_idUsuarios, Cargo_idCargo, Rol_idRol, Oficina_idOficina, Activo)
                    VALUES ('$nombre', '$ine','$telefono', '$Usuarios_idUsuarios', '$cargo', '$rol', '$oficina', 0  )";
                $resultado = mysqli_query($db, $queryAsesor);
                if ($resultado) {
                    header('Location: ../login/index.php');
                }
            }
            if ($rol == 3) {
                $queryEmpleado = "INSERT INTO cliente (Nombre, Apellido, INE, Telefono, Correo, Cliente_idUsuarios, Cliente_idRol, Activo)
                    VALUES ('$nombre', '$apellido','$ine','$telefono', '$correo', '$Usuarios_idUsuarios', '$rol', 0)";
                $resultado = mysqli_query($db, $queryEmpleado);
                if ($resultado) {
                    header('Location: ../login/index.php');
                }
            }
        }
    } else {

        if (!$resultadoComprobacion == NULL) {
            $errores[] = "El usuario ya existe, intenta con otro correo";
        }

        if (!$validar == true) {
            if (strlen($password) < 8) {
                $errores[] = "La clave debe tener al menos 8 caracteres";
            }
            if (!preg_match('`[a-z]`', $password)) {
                $errores[] = "La clave debe tener al menos una letra minúscula";
            }
            if (!preg_match('`[A-Z]`', $password)) {
                $errores[] = "La clave debe tener al menos una letra mayúscula";
            }
            if (!preg_match('`[0-9]`', $password)) {
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet" />
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
        <?php foreach ($errores as $error) : ?>

            <div class="error">
                <p><?php echo $error ?></p>
            </div>

        <?php endforeach ?>
        <section>

            <form action="" method="POST">

                <label for="nombre">
                    <span>Nombre</span>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required maxlength="45">
                </label>

                <label for="apellido">
                    <span>Apellido</span>
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido" required maxlength="45">
                </label>


                <label for="correo">
                    <span>Correo Electrónico</span>
                    <input type="email" id="correo" name="correo" placeholder="Correo Electrónico" required maxlength="45">
                </label>

                <label for="password">
                    <span>Nueva Constraseña</span>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                </label>

                <label for="telefono">
                    <span>Teléfono</span>
                    <input maxlength="10" class="form__buttonNumber" type="tel" id="telefono" name="telefono" placeholder="Teléfono" required>
                </label>

                <label for="ine">
                    <span>INE</span>
                    <input type="text" id="ine" name="ine" placeholder="INE" required maxlength="45">
                </label>

                <label for="">
                    <span>Rol</span>
                    <select name="rol" id="">
                        <option value="0">
                            <--Selecciona-->
                        </option>
                        <?php while ($row = mysqli_fetch_assoc($resultadoRol)) : ?>
                            <option value="<?php echo $row['idRol']; ?>"><?php echo $row['Nombre_rol']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </label>

                <label for="">
                    <span>Cargo</span>
                    <select name="cargo" id="">
                        <option>
                            <--Selecciona-->
                        </option>
                        <?php while ($row = mysqli_fetch_assoc($resultadoCargo)) : ?>
                            <option value="<?php echo $row['idCargo']; ?>"><?php echo $row['Nombre_Cargo']; ?></option>
                        <?php endwhile; ?>

                    </select>
                </label>



                <label for="">
                    <span>Oficina</span>
                    <select name="oficina" id="">
                        <option>
                            <--Selecciona-->
                        </option>
                        <?php while ($row = mysqli_fetch_assoc($resultadoOficina)) : ?>
                            <option required value="<?php echo $row['idOficina']; ?>"><?php echo $row['Nombre_Oficina']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </label>




                <section class="content__buttons">



                    <a class="signup__submit" href="../login/index.php">Volver</a>
                    <input type="submit" value="Registrar" class="signup__submit">



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