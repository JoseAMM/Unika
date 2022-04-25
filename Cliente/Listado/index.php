<?php

//Sesion

require '../sesion.php';


//Conexión a la base de datos

require '../../includes/config/database.php';

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

$queryInmueble = "SELECT
idInmueble,
inmueble.Activo,
Fecha_Registro,
Nombre_Apellido,
Nombre_Contrato,
Nombre_Tipo_Inmueble,
Nombre_Operacion,
datos_basicos.Fotos_idFotos1,
datos_basicos.Direccion
FROM
inmueble
INNER JOIN empleado ON idEmpleado = id_Empleado
INNER JOIN tipo_contrato ON inmueble.idTipo_Contrato   = tipo_contrato.idTipo_Contrato
INNER JOIN tipo_inmueble ON inmueble.idTipo_Inmueble   = tipo_inmueble.idTipo_Inmueble
INNER JOIN tipo_operacion ON inmueble.idTipo_Operacion = tipo_operacion.idTipo_Operacion
INNER JOIN datos_basicos ON inmueble.idInmueble = datos_basicos.Inmueble_idInmueble WHERE VoBo = 1 AND inmueble.idCliente = $idCliente ";

$resultadoInmueble = mysqli_query($db, $queryInmueble);


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
        <title>Unika|Listado Propiedades</title>
</head>
<body>
<header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="index.php"><img src="../../Assets/logo.png" alt=""></a>
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
        
        <section class="main__nav" id="main__nav" >
            <nav>
                <ul>
                    <li><a href="../Editar/index.php"><span>Mi Cuenta</span></a></li>
                    <li><a href="index.php"><span>Inmuebles</span></a></li>
                    <li><a href="../Mensaje/index.php"><span>Mensajes</span></a></li>
                    <li class="nav__logout"><a href="../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </section>


    <section class="main__table">





    <section class="table__config ">

        <table class="table__title">
            <tr>
                <td>Ver</td>
                <td>Foto</td>
                <td>Direccion</td>
                <td>Asesor</td>
                <td>Contrato</td>
                <td>Tipo de Inmueble</td>
                <td>Operacion</td>
                <td>Activo</td>

            </tr>
        </table>
    </section>


    <?php while($row = mysqli_fetch_assoc($resultadoInmueble)): ?>





        <section class="table__content">

            <table>
                <tr>
                    <td class="content__ver">
                        <a  class="input-view" href="../Ver/index.php?id=<?php echo $row['idInmueble']?>"></a>
                    </td>
                    <td ><img class="content__imagen" src="../../admin/Propiedades/Imagenes/<?php  echo $row['Fotos_idFotos1']?>" alt=""></td>
                    <td><?php  echo $row['Direccion']?></td>
                    <td><?php  echo $row['Nombre_Apellido']?></td>
                    <td><?php  echo $row['Nombre_Contrato']?></td>
                    <td><?php  echo $row['Nombre_Tipo_Inmueble']?></td>
                    <td><?php  echo $row['Nombre_Operacion']?></td>

                    <td class="table__editar">
                        <form method="POST">
                        <?php

                        if($row['Activo'] == 1){

                            ?>

                            <a href="">

                                <input type=""  class="input-activar" alt="" disabled >
                            </a>
                            
                        <?php

                        }



                        else{

                        ?>

                            <a href="">

                                <input type="" class="input-desactivar" alt="" disabled >
                            </a>

                        <?php

                        }
                        ?>


                        </form>




                </td>

                </tr>
            </table>
        </section>

    <?php endwhile; ?>
    </section>
    </section>

    </main>
    <script type="text/javascript">

        function preguntar(id){
            if(confirm('¿Estas seguro que deseas borrar el inmueble?')){
                window.location.href = "index.php?del=" + id;
            }
        }

    </script>

    <script src="JS/menu.js" ></script>
    <script src="JS/borrar.js" ></script>
</body>
</html>