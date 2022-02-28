<?php

session_start();

$auth = $_SESSION['login'];
$idUsuarios = $_SESSION['idUsuarios'];

if(!$auth){
    header('Location: ../../login/index.php');
}

//Conexión a la base de datos

require '../../includes/config/database.php';

$db = conectarDB();

$queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

$resultadoEmpleado = mysqli_query($db, $queryEmpleado);

$resultadoEmpleado = mysqli_fetch_assoc($resultadoEmpleado);

$idRol = $resultadoEmpleado['Rol_idRol'];

$idRol = (int)$idRol;


$queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRol";
$resultadoRol = mysqli_query($db, $queryRol);
$resultadoRol = mysqli_fetch_assoc($resultadoRol);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/SMALL/mobile.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Admin|Propiedades</title>
</head>
<body>
    <header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="../index.php"><img src="../../Assets/logo.png" alt=""></a>
            </section>

            <section class="header__name" >
                <p> Bienvenido <?php echo $resultadoEmpleado['Nombre_Apellido']?></p>
                <p class="name__rol"> Su Rol es: <?php echo $resultadoRol['Nombre_rol']?> </p>
                <a class="button_close_session" href="../cerrar-sesion.php">Cerrar Sesión</a>
            </section>
        </div>

        <section class="header__tittle">
            <p>Administrador de Propiedades</p>
        </section>
    </header>
    <main class="main__admin">
        <div class="button__volver">
            <a class="volver" href="../index.php">Volver</a>
        </div>
        <h1>Selecciona la opción que desea administrar de Propiedades</h1>

        <section class="main__module">
            <ul>
                <li><a href="Publicar/index.php" target="_blanck">Publicar Propiedades</a></li>
                <li><a href="" target="_blanck">VoBo de Propiedades</a></li>
                <li><a href="" target="_blanck">Editar Propiedades</a></li>
                <li><a href="Listado/index.php" target="_blanck">Listado de Propiedades</a></li>
                <li><a href="" target="_blanck">Buscar Propiedades</a></li>
                <li><a href="" target="_blanck">Dar de Baja Propiedades</a></li>
            </ul>
        </section>

    </main>
    <footer></footer>
</body>
</html>
