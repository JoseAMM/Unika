<?php

    //Sesion

    require '../../../sesion.php';

    //Conexión a la base de datos

    require '../../../../includes/config/database.php';

    $db = conectarDB();


    // Funcion para la limpieza de datos

    require '../../../limpieza.php';

    $queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

    $resultadoEmpleadoNombre = mysqli_query($db, $queryEmpleado);

    $resultadoEmpleadoNombre = mysqli_fetch_assoc($resultadoEmpleadoNombre);

    $idRolEmpleado = $resultadoEmpleadoNombre['Rol_idRol'];

    $idRolEmpleado = (int)$idRolEmpleado;


    $queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
    $resultadoRolEmpleado = mysqli_query($db, $queryRol);
    $resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);


    $errores = [];

    $queryContrato = "SELECT * FROM tipo_contrato";
    $resultadoContrato = mysqli_query($db, $queryContrato);

 







    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $operacion = limpieza( mysqli_real_escape_string($db, $_POST['operacion']));


        $queryNewOperacion = "INSERT INTO tipo_operacion (Nombre_Operacion, Activo) VALUES ('$operacion', '1')";

        $resultadoNewOperacion = mysqli_query($db, $queryNewOperacion);

        if($resultadoNewOperacion) {
        header('Location: ../index.php');
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
    <title>Unika|Nuevo Contrato</title>
</head>
<body>
<header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="../../../index.php"><img src="../../../../Assets/logo.png" alt=""></a>
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
                    <img src="../../../../Assets/menu.png" alt="">
                </a>
            </i>
        </section>
        </section>

        <section class="main__content">

        <section class="main__nav" id="main__nav">
            <nav>
                <ul>
                    <li><a href="../../Listado/index.php"><span>Inmuebles</span></a></li>
                    <li><a href="../../VoBo/index.php"><span>VoBo Inmuebles</span></a></li>
                    <li><a href="../../../Clientes/Listado/index.php">Clientes</a></li>
                    <li><a href="../../../Mensaje/index.php">Mensaje</a></li>
                    <li><a href="../../Documentos/index.php">Documentos/Inmuebles</a></li>
                    <li class="nav__logout"><a href="../../../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </section>


        <?php foreach($errores as $error):?>

        <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>
        <section class="formulario__content">
        <section class="formulario">

        <form action="" method="POST">

            <label for="operacion">
                <span>Operación</span>
                <input type="text" id= "operacion" name="operacion" placeholder = "Operación Name" required maxlength="50">
            </label>


            <section class="content__buttons">
                
                
                <a class="signup__submit" href="../../Publicar/index.php">Volver</a>
                <input type="submit" value = "Registrar" class = "signup__submit">
               
                
                

            </section>
            
        </form>
        </section>
        </section>

</section>

    </main>


<?php

require '../../../../includes/footer.php'

?>
<script src="JS/menu.js" ></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>