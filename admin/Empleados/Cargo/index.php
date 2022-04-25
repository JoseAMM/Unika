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

    $queryCargo = "SELECT * FROM cargo ORDER BY idCargo DESC";
    $resultadoCargo = mysqli_query($db, $queryCargo);

 

    if(isset($_GET['del'])) {
        $idCargo = $_GET['del'];
        $queryBorrarCargo = "DELETE FROM cargo where idCargo = $idCargo";
        $queryEditarEmpleado = "UPDATE empleado SET Cargo_idCargo = 5 WHERE Cargo_idCargo = $idCargo";
        $resultadoEditarEmpleado = mysqli_query($db, $queryEditarEmpleado);
        $resultadoBorrar = mysqli_query($db, $queryBorrarCargo);
        header('Location: index.php');
    }





    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        if (isset( $_POST['Activo'])){
            
            $idCargo = (int)$_POST['Activo'];
    
            $queryCargoActivo = "SELECT Activo FROM cargo WHERE idCargo = $idCargo";
            $resultadoRolActivo = mysqli_query($db, $queryCargoActivo);
            $resultadoRolActivo = mysqli_fetch_assoc($resultadoRolActivo);
            
            
            
            if ($resultadoRolActivo['Activo'] == 1){
                $queryDesactivar = "UPDATE cargo SET Activo = 0 WHERE idCargo = $idCargo";
                $resultadoDesactivar = mysqli_query($db, $queryDesactivar);
                header('Location:index.php');
                
            }
            else {
                $queryActivar = "UPDATE cargo SET Activo = 1 WHERE idCargo = $idCargo";
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
                        <li><a href="../../Propiedades/Listado/index.php"><span>Inmuebles</span></a></li>
                        <li><a href="../../Propiedades/VoBo/index.php"><span>VoBo Inmuebles</span></a></li>
                        <li><a href="../Listado/index.php">Asesores</a></li>
                        <li><a href="../../Clientes/Listado/index.php">Clientes</a></li>
                        <li><a href="../../Propiedades/Documentos/index.php">Documentos/Inmuebles</a></li>
                        <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </section>

            <section class="main__table">

                <section class="table__buttons">
                    <div class="button__volver">
                        <a class="volver" href="../Nuevo/index.php">Volver</a>
                    </div>
                    <div class="button__new">
                        <a class="new" href="NuevoCargo/index.php">Nuevo Cargo</a>
                    </div>
                </section>

                <section  class="table__title">
                    <table>
                        <tr>
                            <td>Nombre</td>
                            <td>Editar</td>
                            <td>Activo</td>
                            <td>Borrar</td>
                        </tr>

                    </table>

                </section table__title="" >

                <?php while($row = mysqli_fetch_assoc($resultadoCargo)): ?>


                <section class="table__content">

                    <table>
                        <tr>

                            <td><?php  echo $row['Nombre_Cargo']?></td>
                            <td class="table__editar">
                                <a href="EditarCargo/index.php?id=<?php echo $row['idCargo']?>">
                                    <img src="../../../Assets/editar.png" alt="">
                                </a>
                            </td>
                            <td class="table__editar">
                                <form method="POST">
                                <?php

                                if($row['Activo'] == 1){

                                    ?>
                                    <a href="">
                                        <input type="hidden"  class="input-activar" name="Activo" value="<?php echo $row['idCargo']?>">
                                        <input type="submit" class="input-activar" alt="" >
                                    </a>
                                    
                                <?php
                                }
                                else{

                                ?>
                                    <a href="">
                                        <input type="hidden"  class="input-desactivar" name="Activo" value="<?php echo $row['idCargo']?>">
                                        <input type="submit" class="input-desactivar" alt="" >
                                    </a>
                                <?php

                                }
                                ?>
                                </form>
                            </td>

                            <td class="table__editar">

                                        <input type="hidden"  class="input-borrar" onclick="preguntar(<?php echo $row['idCargo']?>)" >
                                        <input type="button" class="input-borrar" alt="" onclick="preguntar(<?php echo $row['idCargo']?>)">
                            </td>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

    function preguntar(id){
        // id.preventDefault();

        Swal.fire({
        title: '¿Estás seguro de borrar este cargo?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrarlo'
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Borrado!',
                'El cargo ha sido borrado.',
                'success'
                )
                setTimeout(function(){
                    window.location.href = "index.php?del=" + id;
                }, 2000);
            }
            
        })
    }

</script>
<script src="JS/menu.js" ></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>