<?php

//Sesion

require '../../sesion.php';


//Conexión a la base de datos

require '../../../includes/config/database.php';

$db = conectarDB();


$queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

$resultadoEmpleado = mysqli_query($db, $queryEmpleado);

$resultadoEmpleado = mysqli_fetch_assoc($resultadoEmpleado);

$idRol = $resultadoEmpleado['Rol_idRol'];

$idRol = (int)$idRol;


$queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRol";
$resultadoRol = mysqli_query($db, $queryRol);
$resultadoRol = mysqli_fetch_assoc($resultadoRol);

$queryCliente = "SELECT * FROM cliente ORDER BY idCliente ASC";

$resultadoCliente = mysqli_query($db, $queryCliente);


if(isset($_GET['del'])) {
    $idCliente = $_GET['del'];
    $queryCliente = "SELECT Cliente_idUsuarios FROM cliente WHERE idCliente = $idCliente";
    $resultadoCliente = mysqli_query($db, $queryCliente);
    $resultadoCliente = mysqli_fetch_assoc($resultadoCliente);
    $resultadoCliente = $resultadoCliente['Cliente_idUsuarios'];
    $queryBorrarUsuario = "DELETE FROM usuarios WHERE idUsuarios = $resultadoCliente";
    $queryBorrarCliente = "DELETE FROM cliente WHERE idCliente = $idCliente";
    $resultadoBorrar = mysqli_query($db, $queryBorrarCliente);
    $resultadoBorrar = mysqli_query($db, $queryBorrarUsuario);
    header('Location: index.php');
}



if (isset( $_POST['Activo'])){

    $idCliente = (int)$_POST['Activo'];

    $queryClienteActivo = "SELECT Activo From cliente WHERE idCliente = $idCliente";
    $resultadoClienteActivo = mysqli_query($db, $queryClienteActivo);
    $resultadoClienteActivo = mysqli_fetch_assoc($resultadoClienteActivo);



if ($resultadoClienteActivo['Activo'] == 1){
    $queryDesactivar = "UPDATE cliente SET Activo = 0 WHERE idCliente = $idCliente";
    $resultadoDesactivar = mysqli_query($db, $queryDesactivar);
     header('Location:index.php');

}
else {
    $queryActivar = "UPDATE cliente SET Activo = 1 WHERE idCliente = $idCliente";
    $resultadoDesactivar = mysqli_query($db, $queryActivar);
    header('Location:index.php');
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
        <title>Unika|Listado Clientes</title>
</head>
<body>
    <header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="../../index.php"><img src="../../../Assets/logo.png" alt=""></a>
            </section>

            <section class="header__name" >
                <p> Bienvenido <?php echo $resultadoEmpleado['Nombre_Apellido']?></p>
                <p class="name__rol"> Su Rol es: <?php echo $resultadoRol['Nombre_rol']?> </p>
            </section>

        </div>

    </header>

    <main >

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
                    <li><a href="../../Empleados/Listado/index.php">Asesores</a></li>
                    <li><a href="../../Clientes/Listado/index.php">Clientes</a></li>
                    <li><a href="../../Propiedades/Documentos/index.php">Documentos/Inmuebles</a></li>
                    <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </section>
    <section class="main__table">


    <section class="table__title ">


        <section class="table__buttons">

            <div class="button__new">
                <a class="new" href="../Mensaje/index.php">Nuevo Mensaje</a>
            </div>
            <div class="button__new">
                <a class="new" href="../Publicar/index.php">Nuevo Cliente</a>
            </div>
        </section>

        


        <table>
            <tr>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>INE</td>
                <td>Teléfono</td>
                <td>Correo</td>
                <td>Editar</td>
                <td>Activo</td>
                <td>Borrar</td>

            </tr>
        </table>
    </section>


    <?php while($row = mysqli_fetch_assoc($resultadoCliente)): ?>


        <section class="table__content">
            <table>
                <tr>
                    <td><?php echo $row['Nombre']?></td>
                    <td><?php  echo $row['Apellido']?></td>
                    <td><?php  echo $row['INE']?></td>
                    <td><?php  echo $row['Telefono']?></td>
                    <td><?php  echo $row['Correo']?></td>

                    <td class="table__editar">
                        <a href="../Editar/index.php?id=<?php echo $row['idCliente']?>">
                            <img src="../../../Assets/editar.png" alt="">
                        </a>
                    </td>




                    <td class="table__editar">
                        <form method="POST">
                        <?php

                        if($row['Activo'] == 1){

                            ?>

                                <input type="hidden"  class="input-activar" name="Activo" value="<?php echo $row['idCliente']?>">
                                <input type="submit" class="input-activar" alt="" >

                            
                        <?php

                        }



                        else{

                        ?>

 
                                <input type="hidden"  class="input-desactivar" name="Activo" value="<?php echo $row['idCliente']?>">
                                <input type="submit" class="input-desactivar" alt="" >

                        <?php

                        }
                        ?>


                        </form>




                </td>

                    <td class="table__editar">
                            
                                <input type="hidden"  class="input-borrar" name="borrar" onclick="preguntar(<?php echo $row['idCliente']?>)">
                                <input type="submit" class="input-borrar" alt=""  onclick="preguntar(<?php echo $row['idCliente']?>)">
                    </td>
                </tr>
            </table>
        </section>

    <?php endwhile; ?>

    </section>

    </main>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

    function preguntar(id){
        // id.preventDefault();

        Swal.fire({
        title: '¿Estás seguro de borrar este cliente?',
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
                'El cliente ha sido borrado.',
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
</body>
</html>