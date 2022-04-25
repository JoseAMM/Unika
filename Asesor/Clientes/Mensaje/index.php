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

    $idAsesor = $resultadoEmpleadoNombre['idEmpleado'];


    $queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
    $resultadoRolEmpleado = mysqli_query($db, $queryRol);
    $resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);


    $errores = [];

    $queryConsulta = "SELECT * FROM mensajes WHERE mensajes.Remitente = $idAsesor ORDER BY idMensaje DESC";
    $resultadoConsulta = mysqli_query($db, $queryConsulta);

 

    if(isset($_GET['del'])) {
        $idMensaje = $_GET['del'];
        $queryBorrar = "DELETE FROM mensajes WHERE idMensaje = $idMensaje";
        $resultadoBorrar = mysqli_query($db, $queryBorrar);
        header('Location: index.php');
    }





    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset( $_POST['Activo'])){
            
            $idMensaje = (int)$_POST['Activo'];
    
            $queryActivo = "SELECT Activo FROM mensajes WHERE idMensaje = $idMensaje";
            $resultadoActivo = mysqli_query($db, $queryActivo);
            $resultadoActivo = mysqli_fetch_assoc($resultadoActivo);
            
            
            
            if ($resultadoActivo['Activo'] == 1){
                $queryDesactivar = "UPDATE mensajes SET Activo = 0 WHERE idMensaje = $idMensaje";
                $resultadoDesactivar = mysqli_query($db, $queryDesactivar);
                header('Location:index.php');
                
            }
            else {
                $queryActivar = "UPDATE mensajes SET Activo = 1 WHERE idMensaje = $idMensaje";
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
    <title>Unika|Listado Mensajes</title>
</head>
<body>
<header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href=""><img src="../../../Assets/logo.png" alt=""></a>
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

            <section class="main__table">

                <section class="table__buttons">
                    <div class="button__volver">
                        <a class="volver" href="../Listado/index.php">Volver</a>
                    </div>
                    <div class="button__new">
                        <a class="new" href="NuevoMensaje/index.php">Nuevo Mensaje</a>
                    </div>
                </section>

                <section  class="table__title">
                    <table>
                        <tr>
                            <td>Remitente</td>
                            <td>Destinatario</td>
                            <td>Título</td>
                            <td>Editar</td>
                            <td>Activo</td>
                            <td>Ver</td>
                        </tr>

                    </table>

                </section table__title="" >

                <?php while($row = mysqli_fetch_assoc($resultadoConsulta)): ?>


                <section class="table__content">

                    <table>
                        <tr>

                            <td><?php
                                $idRemitente = $row['Remitente'];
                                $queryNombre = "SELECT Nombre_Apellido FROM empleado WHERE idEmpleado = $idRemitente";

                                $resultadoNombre = mysqli_query($db, $queryNombre);

                                
                                $resultadoNombre = mysqli_fetch_assoc($resultadoNombre);
                                echo $resultadoNombre['Nombre_Apellido'];?></td>
                            <td><?php  
                            if ($row['Destinatario'] == 0){
                                echo "Todos los Asesores";
                            } 
                            if($row['Destinatario'] == 1){
                                echo "Todos los clientes";
                            }
                            if ($row['Destinatario'] != 0 AND $row['Destinatario'] != 1) {
                                $idEmpleado = $row['Destinatario'];
                                $queryNombre = "SELECT Nombre_Apellido FROM empleado WHERE idEmpleado = $idEmpleado";

                                $resultadoNombre = mysqli_query($db, $queryNombre);

                                
                                $resultadoNombre = mysqli_fetch_assoc($resultadoNombre);
                                echo $resultadoNombre['Nombre_Apellido'];
                            } ?></td>
                            <td><?php  echo $row['Titulo']?></td>
                            <td class="table__editar">
                                <a href="<?php 
                                    if($row['Remitente'] == $idAsesor){
                                        echo "EditarMensaje/index.php?id=" . $row['idMensaje'];
                                    } else {
                                        echo "#";
                                    }
                                    ?>">

                                <!-- "EditarMensaje/index.php?id=<?php //echo $row['idMensajeEmpleado']?> -->
                                    <img src="<?php
                                    if($row['Remitente'] != $idAsesor){
                                        echo "../../../Assets/vacio.png";
                                    } else {
                                        echo "../../../Assets/editar.png";
                                    }
                                    ?>" alt="">
                                </a>
                            </td>
                            <td class="table__editar">
                                <form method="POST">
                                <?php

                                    if($row['Activo'] == 1){

                                        ?>
                                        <a href="">
                                            <input type="hidden"  class="input-activar" name="Activo" value="<?php echo $row['idMensaje']?>"
                                            <?php
                                                if ($row['Remitente'] != $idAsesor) {
                                                    echo "disabled";
                                                }
                                            ?>>
                                            <input type="submit" class="input-activar" alt=""
                                            <?php

                                                if ($row['Remitente'] != $idAsesor) {
                                                    echo "disabled";
                                                }
                                            ?>>
                                        </a>
                                        
                                    <?php
                                    }
                                    else{

                                    ?>
                                        <a href="">
                                            <input type="hidden"  class="input-desactivar" name="Activo" value="<?php echo $row['idMensaje']?>"
                                            <?php

                                            if ($row['Remitente'] != $idAsesor) {
                                                echo "disabled";
                                            }
                                            ?>>

                                            <input type="submit" class="input-desactivar" alt=""  
                                            <?php

                                            if ($row['Remitente'] != $idAsesor) {
                                                echo "disabled";
                                            }
                                            ?>>
                                        </a>
                                    <?php

                                    }
                                ?>
                                </form>
                            </td>

                            <td class="table__editar">
                                <a href="VerMensaje/index.php?id=<?php echo $row['idMensaje']?>">
                                    <img src="../../../Assets/ver.png" alt="">
                                </a>
                            </td>

                        </tr>
                    </table>
                </section>

                <?php endwhile; ?>

                    


            </section main__table="" >





        </section>

    </main>




<script type="text/javascript">

function preguntar(id){
    if(confirm('¿Estas seguro que deseas borrar este mensaje?')){
        window.location.href = "index.php?del=" + id;
    }
}

</script>
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
        Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {
        Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
        )
    }
    })
</script> -->
<script src="JS/menu.js" ></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>