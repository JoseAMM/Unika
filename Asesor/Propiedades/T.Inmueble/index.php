<?php

    //Sesion

    require '../../sesion.php';

    //Conexión a la base de datos

    require '../../../includes/config/database.php';

    $db = conectarDB();


    // Funcion para la limpieza de datos

    require '../../limpieza.php';

    $queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

    $resultadoEmpleadoNombre = mysqli_query($db, $queryEmpleado);

    $resultadoEmpleadoNombre = mysqli_fetch_assoc($resultadoEmpleadoNombre);

    $idRolEmpleado = $resultadoEmpleadoNombre['Rol_idRol'];

    $idRolEmpleado = (int)$idRolEmpleado;


    $queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
    $resultadoRolEmpleado = mysqli_query($db, $queryRol);
    $resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);


    $errores = [];

    $queryTipoInmueble = "SELECT * FROM tipo_inmueble ORDER BY idTipo_Inmueble DESC";
    $resultadoTipoInmueble = mysqli_query($db, $queryTipoInmueble);

 

    if(isset($_GET['del'])) {
        $idTipo_Inmueble = $_GET['del'];
        $queryBorrarInmueble = "DELETE from tipo_inmueble where idTipo_Inmueble = $idTipo_Inmueble";
        $queryEditarInmueble = "UPDATE inmueble SET idTipo_Inmueble = 84 WHERE idTipo_Inmueble = $idTipo_Inmueble";
        $resultadoEditarInmueble = mysqli_query($db, $queryEditarInmueble);
        $resultadoBorrar = mysqli_query($db, $queryBorrarInmueble);
        header('Location: index.php');
    }





    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        if (isset( $_POST['Activo'])){
            
            $idTipo_Inmueble = (int)$_POST['Activo'];
    
            $queryTipoInmuebleActivo = "SELECT Activo FROM tipo_inmueble WHERE idTipo_Inmueble = $idTipo_Inmueble";
            $resultadoTipoInmuebleActivo = mysqli_query($db, $queryTipoInmuebleActivo);
            $resultadoTipoInmuebleActivo = mysqli_fetch_assoc($resultadoTipoInmuebleActivo);
            
            
            
            if ($resultadoTipoInmuebleActivo['Activo'] == 1){
                $queryDesactivar = "UPDATE tipo_inmueble SET Activo = 0 WHERE idTipo_Inmueble = $idTipo_Inmueble";
                $resultadoDesactivar = mysqli_query($db, $queryDesactivar);
                header('Location:index.php');
                
            }
            else {
                $queryActivar = "UPDATE tipo_inmueble SET Activo = 1 WHERE idTipo_Inmueble = $idTipo_Inmueble";
                $resultadoDesactivar = mysqli_query($db, $queryActivar);
                header('Location:index.php');
                
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Unika|Nuevo Contrato</title>
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
                        <li><a href="../Listado/index.php"><span>Inmuebles</span></a></li>
                        <li><a href="../VoBo/index.php"><span>VoBo Inmuebles</span></a></li>
                        <li><a href="../../Clientes/Listado/index.php">Clientes</a></li>
                        <li><a href="../../Mensaje/index.php">Mensaje</a></li>
                        <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </section>

            <section class="main__table">

                <section class="table__buttons">
                    <div class="button__volver">
                        <a class="volver" href="../Publicar/index.php">Volver</a>
                    </div>
                    <div class="button__new">
                        <a class="new" href="NuevoT.Inmueble/index.php">Nuevo Tipo de Inmueble</a>
                    </div>
                </section>

                <section  class="table__title">
                    <table>
                        <tr>
                            <td>Nombre</td>
                            <td>Descripcion</td>
                        </tr>

                    </table>

                </section table__title="" >

                <?php while($row = mysqli_fetch_assoc($resultadoTipoInmueble)): ?>


                <section class="table__content">

                    <table>
                        <tr>

                            <td><?php  echo $row['Nombre_Tipo_Inmueble']?></td>
                            <td><?php  echo $row['Descripcion']?></td>
                            
                        </tr>
                    </table>
                </section>

                <?php endwhile; ?>

                    


            </section main__table="" >





        </section>

    </main>


<?php

require '../../../includes/footer.php'

?>

<script type="text/javascript">

function preguntar(id){
    if(confirm('¿Estas seguro que deseas borrar el tipo de Inmueble?')){
        window.location.href = "index.php?del=" + id;
    }
}

</script>
<script src="JS/menu.js" ></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>