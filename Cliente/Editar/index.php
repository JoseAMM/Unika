<?php

    //Sesion

    require '../sesion.php';


    //Conexión a la base de datos

    require '../../includes/config/database.php';
    require '../limpieza.php';

    $db = conectarDB();


    $queryCliente = "SELECT * FROM cliente WHERE Cliente_idUsuarios = $idUsuarios";

    $resultadoCliente = mysqli_query($db, $queryCliente);

    $resultadoCliente = mysqli_fetch_assoc($resultadoCliente);
    $idCliente = $resultadoCliente['idCliente'];
    $idRol = $resultadoCliente['Cliente_idRol'];

    $idRol = (int)$idRol;


    $queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRol";
    $resultadoRol = mysqli_query($db, $queryRol);
    $resultadoRol = mysqli_fetch_assoc($resultadoRol);


    // Consulta información del cliente


    $queryConsutaCliente = "SELECT


    cliente.Telefono,
    cliente.Correo


    FROM

    cliente

    INNER JOIN usuarios ON cliente.Cliente_idUsuarios = usuarios.idUsuarios WHERE idCliente = $idCliente";


    $resultadoConsultaCliente = mysqli_query($db, $queryConsutaCliente);
    $resultadoConsultaCliente = mysqli_fetch_assoc($resultadoConsultaCliente);


    $telefono = $resultadoConsultaCliente['Telefono'];
    $correo = $resultadoConsultaCliente['Correo'];



    
    $errores = [];


    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $telefono = limpieza( mysqli_real_escape_string($db, $_POST['telefono']));
        $correo = limpieza( mysqli_real_escape_string($db, $_POST['correo']));


        $queryActualizar = "UPDATE cliente  SET Telefono = '$telefono' WHERE idCliente = $idCliente";
        $resultadoActualizar = mysqli_query($db, $queryActualizar);

        $queryActualizar = "UPDATE cliente  SET Correo = '$correo' WHERE idCliente = $idCliente";
        $resultadoActualizar = mysqli_query($db, $queryActualizar);

        header('Location: ../Listado/index.php');

        

       
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
                <a href="../../index.php"><img src="../../Assets/logo.png" alt=""></a>
            </section>

            <section class="header__name" >
                <p> Bienvenido <?php echo $resultadoCliente['Nombre']?></p>
                <p class="name__rol"> Su Rol es: <?php echo $resultadoRol['Nombre_rol']?> </p>
            </section>

        </div>
    </header>
    <main>      
        


    <section class="main__menu--content">
            <section class="main__menu" id="main__menu">
                <i>
                    <a id="button_open" href="#">
                        <img src="../../Assets/menu.png" alt="">
                    </a>
                </i>
            </section>
        </section>

        <section class="main__content">

            <section class="main__nav" id="main__nav">
                <nav>
                    <ul>
                        <li><a href="../Editar/index.php"><span>Mi Cuenta</span></a></li>
                        <li><a href="../Listado/index.php"><span>Inmuebles</span></a></li>
                        <li class="nav__logout"><a href="../cerrar-sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </section>


        <section class="main__formulario">
        <?php foreach($errores as $error):?>

            <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>

            <form action="" method="POST" enctype="multipart/form-data">

                <label for="correo">
                    <span>Correo (De Contacto)</span>
                    <input value="<?php echo $correo?>" type="email" id= "correo" name="correo"  placeholder = "algo@example.com" required maxlength="45">
                </label>


                <label for="telefono">
                    <span>Telefono</span>
                    <input value="<?php echo $telefono?>" type="text" id= "telefono" name="telefono" placeholder = "Teléfono" required  maxlength="10">
                </label>

                <input type="submit" value = "Registrar" class = "signup__submit">
            </form>
        </section>
    </section>
    
</main>
<script src="JS/menu.js" ></script>
</body>
</html>