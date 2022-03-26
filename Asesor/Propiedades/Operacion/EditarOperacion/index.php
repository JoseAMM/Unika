<?php

    //Sesion

    require '../../../sesion.php';

    //Conexión a la base de datos

    require '../../../../includes/config/database.php';

    $db = conectarDB();

    $idTipo_Operacion = $_GET['id'];
    $idTipo_Operacion = filter_var($idTipo_Operacion, FILTER_VALIDATE_INT);

    if(!$idTipo_Operacion) {
        header('Location: ../../Listado/index.php');
}


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

    $queryOperacion = "SELECT * FROM tipo_operacion WHERE idTipo_Operacion = $idTipo_Operacion";
    $resultadoOperacion = mysqli_query($db, $queryOperacion);
    $resultadoOperacion = mysqli_fetch_assoc($resultadoOperacion);
    $resultadoOperacion = $resultadoOperacion['Nombre_Operacion'];

 







    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        $operacion = limpieza( mysqli_real_escape_string($db, $_POST['operacion']));

        $queryEditarOperacion = "UPDATE tipo_operacion SET Nombre_Operacion = '$operacion' WHERE idTipo_Operacion = $idTipo_Operacion";

        $resultadoEditarOperacion = mysqli_query($db, $queryEditarOperacion);

        if($resultadoEditarOperacion) {
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
                    <li><a href="../../Listado/index.php">Inmuebles</a></li>
                    <li><a href="">Mensaje</a></li>
                    <li><a href="">Asesores</a></li>
                    <li><a href="">Clientes</a></li>
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
                <input type="text"  value="<?php echo $resultadoOperacion?>" id= "operacion" name="operacion" placeholder = "Operacion Name" required maxlength="50">
            </label>


            <section class="content__buttons">
                
                
                <a class="signup__submit" href="../../Publicar/index.php">Volver</a>
                <input type="submit" value = "Editar" class = "signup__submit">
               
                
                

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