<?php

session_start();

$auth = $_SESSION['login'];
$idUsuarios = $_SESSION['idUsuarios'];

if(!$auth){
    header('Location:../../../index.php');
}

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

$queryInmueble = "SELECT
idInmueble,
inmueble.Activo,
Fecha_Registro,
Nombre_Apellido,
Nombre_Contrato,
Nombre_Tipo_Inmueble,
Nombre_Operacion
FROM
inmueble
INNER JOIN empleado ON idEmpleado = id_Empleado
INNER JOIN tipo_contrato ON inmueble.idTipo_Contrato   = tipo_contrato.idTipo_Contrato
INNER JOIN tipo_inmueble ON inmueble.idTipo_Inmueble   = tipo_inmueble.idTipo_Inmueble
INNER JOIN tipo_operacion ON inmueble.idTipo_Operacion = tipo_operacion.idTipo_Operacion ORDER BY idInmueble ASC";

$resultadoInmueble = mysqli_query($db, $queryInmueble);


// Consulta de los asesores activos para el select

$consultaAsesor = "SELECT idEmpleado, Nombre_Apellido FROM empleado";
$resultadoAsesor = mysqli_query($db, $consultaAsesor);

// Consulta de los idInmueble para el select

$consultaIdInmueble = "SELECT idInmueble FROM inmueble";
$resultadoIdImbueble = mysqli_query($db, $consultaIdInmueble);

// Consulta de los tipos de contratos activos para el select

$consultaContrato = "SELECT idTipo_Contrato, Nombre_Contrato, Activo FROM tipo_contrato";
$resultadoContrato = mysqli_query($db, $consultaContrato);

// Consulta de los tipos de inmueble activos para el select

$consultaTipoInmueble = "SELECT idTipo_Inmueble, Nombre_Tipo_Inmueble, Activo FROM tipo_inmueble";
$resultadoTipoInmueble = mysqli_query($db, $consultaTipoInmueble);

// Consulta de los tipos de operación activos para el select

$consultaOperacion = "SELECT idTipo_Operacion, Nombre_Operacion, Activo FROM tipo_operacion WHERE Activo = 1;";
$resultadoOperacion = mysqli_query($db, $consultaOperacion);


$asesor = null;
$contrato = null;
$inmueble = null; 
$operacion = null;
$id = null;
$activo = null;




if($_SERVER['REQUEST_METHOD'] === 'POST') {


    // isset($_POST['id_Empleado']) != NULL OR isset($_POST['idTipo_Contrato']) != NULL OR isset($_POST['idTipo_Inmueble']) != NULL OR isset($_POST['idTipo_Operacion']) != NULL OR isset($_POST['idInmueble']) != NULL OR isset($_POST['activo']) != NULL
    // $_POST['id_Empleado']!= NULL OR $_POST['idTipo_Contrato'] != NULL OR $_POST['idTipo_Inmueble'] != NULL OR $_POST['idTipo_Operacion'] != NULL OR $_POST['idInmueble'] != NULL OR $_POST['activo'] != NULL

    if(isset($_POST['id_Empleado']) != NULL OR isset($_POST['idTipo_Contrato']) != NULL OR isset($_POST['idTipo_Inmueble']) != NULL OR isset($_POST['idTipo_Operacion']) != NULL OR isset($_POST['idInmueble']) != NULL OR isset($_POST['activo']) != NULL) {


    // Asignación de variables y escape de datos para la prevención de inyección SQL
        $asesor = (int)$_POST['id_Empleado'];
        $contrato = (int)$_POST['idTipo_Contrato'];
        $inmueble = (int)$_POST['idTipo_Inmueble'];
        $operacion = (int)$_POST['idTipo_Operacion'];
        $id = (int)$_POST['idInmueble'];
        $activo = (int)$_POST['activo'];

        $queryInmueble = $queryInmueble ." WHERE ";


        foreach ($_POST as $key => $value) {

            if ($value == NULL){
                unset($_POST[$key]);
            }
        }


        $queryBuscar = "SELECT
        idInmueble,
        inmueble.Activo,
        Fecha_Registro,
        Nombre_Apellido,
        Nombre_Contrato,
        Nombre_Tipo_Inmueble,
        Nombre_Operacion
        FROM
        inmueble
        INNER JOIN empleado ON idEmpleado = id_Empleado
        INNER JOIN tipo_contrato ON inmueble.idTipo_Contrato   = tipo_contrato.idTipo_Contrato
        INNER JOIN tipo_inmueble ON inmueble.idTipo_Inmueble   = tipo_inmueble.idTipo_Inmueble
        INNER JOIN tipo_operacion ON inmueble.idTipo_Operacion = tipo_operacion.idTipo_Operacion WHERE ";

        foreach ($_POST as $key => $value) {

            if($key == "activo" ){
                $key = ucfirst($key);
            }

            if(count($_POST) > 1 ) {

                $queryBuscar = $queryBuscar ."inmueble.". $key . " = " . $value . " AND " ;
                unset($_POST[$key]);

            } else if (count($_POST) == 1){

                $queryBuscar = $queryBuscar ."inmueble.". $key . " = " . $value ;
                unset($_POST[$key]);
            }
        }


        $resultadoBuscar = mysqli_query($db, $queryBuscar);
    }



        if(isset ($_POST['idInmuebles'])){
            $idInmueble = (int)$_POST['idInmuebles'];
            var_dump($idInmueble);
            $queryBorrarInmueble = "DELETE from inmueble where idInmueble = $idInmueble";
            $queryBorrarDatosBasicos = "DELETE from datos_basicos where Inmueble_idInmueble = $idInmueble";
            $queryBorrarCaracteristicas = "DELETE from caracteristicas where idInmueble = $idInmueble";
            $resultadoBorrar = mysqli_query($db, $queryBorrarDatosBasicos);
            $resultadoBorrar = mysqli_query($db, $queryBorrarCaracteristicas);
            $resultadoBorrar = mysqli_query($db, $queryBorrarInmueble);
            header('Location: index.php');
        }
        
        if (isset( $_POST['Activo'])){
            
        $idInmueble = (int)$_POST['Activo'];

        $queryInmuebleActivo = "SELECT Activo From inmueble WHERE idInmueble = $idInmueble";
        $resultadoInmuebleActivo = mysqli_query($db, $queryInmuebleActivo);
        $resultadoInmuebleActivo = mysqli_fetch_assoc($resultadoInmuebleActivo);
        
        
        
        if ($resultadoInmuebleActivo['Activo'] == 1){
            $queryDesactivar = "UPDATE inmueble SET Activo = 0 WHERE idInmueble = $idInmueble";
            $resultadoDesactivar = mysqli_query($db, $queryDesactivar);
            header('Location:index.php');
            
        }
        else {
            $queryActivar = "UPDATE inmueble SET Activo = 1 WHERE idInmueble = $idInmueble";
            $resultadoDesactivar = mysqli_query($db, $queryActivar);
            header('Location:index.php');
            
        }
        
        
    }

    if(isset($resultadoBuscar)){
        $resultadoInmueble = $resultadoBuscar;
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
        <link rel="stylesheet" href="CSS/MEDIUM/mobile.css" media="(min-width:840px)">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
        <title>Unika|Listado Propiedades</title>
</head>
<body>
<header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="index.php"><img src="../../../Assets/logo.png" alt=""></a>
            </section>

            <section class="header__name" >
                <p> Bienvenido <?php echo $resultadoEmpleado['Nombre_Apellido']?></p>
                <p class="name__rol"> Su Rol es: <?php echo $resultadoRol['Nombre_rol']?> </p>
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
        
        <section class="main__nav" id="main__nav" >
            <nav>
                <ul>
                    <li><a href=""><span>Inmuebles</span></a></li>
                    <li><a href="">Vender</a></li>
                    <li><a href="">Comprar</a></li>
                    <li><a href="">Rentar</a></li>
                    <li><a href="">Mensaje</a></li>
                    <li><a href="../../Empleados/Listado/index.php">Empleados</a></li>
                    <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </section>


    <section class="main__table">



    <section class="table__title ">

        <section class="table__buttons">
            

            <div class="button__new">
                <a class="new" href="../Operacion/index.php">Nueva Operación</a>
            </div>

            <div class="button__new">
                <a class="new" href="../T.Inmueble/index.php">Nuevo Tipo Inmueble</a>
            </div>
            <div class="button__new">
                <a class="new" href="../Contrato/index.php">Nuevo Contrato</a>
            </div>
            
            <div class="button__new">
                <a class="new" href="../Publicar/index.php">Nuevo Inmueble</a>
            </div>
        </section>

        <form method="POST" class="table__search">
            <div class="search__title">
                <p>Buscar por:</p>
            </div>

                <div class="search__element">
                    <span>ID</span>
                    <select name="idInmueble" id="">
                        <option value=""><----></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoIdImbueble)) : ?>
                            <option <?php echo $id == $row['idInmueble'] ? 'selected' : '' ; ?>value="<?php echo $row['idInmueble']; ?>"><?php echo $row['idInmueble']; ?></option>
                        <?php endwhile; ?>
                    </select>

                </div>


                <div class="search__element">

                    <span>Asesor</span>
                    <select name="id_Empleado" id="">
                            <option value=""><----></option>
                            <?php while($row = mysqli_fetch_assoc($resultadoAsesor)) : ?>
                                <option value="<?php echo $row['idEmpleado']; ?>"><?php echo $row['Nombre_Apellido']; ?></option>
                            <?php endwhile; ?>
                        </select>

                </div>

                <div class="search__element">

                    <span>Contrato</span>
                    <select name="idTipo_Contrato" id="">
                            <option value=""><----></option>
                            <?php while($row = mysqli_fetch_assoc($resultadoContrato)) : ?>
                                <option value="<?php echo $row['idTipo_Contrato']; ?>"><?php echo $row['Nombre_Contrato']; ?></option>
                            <?php endwhile; ?>
                        </select>

                </div>

                <div class="search__element">

                    <span>Tipo de Inmueble</span>
                    <select name="idTipo_Inmueble" id="">
                            <option value=""><----></option>
                            <?php while($row = mysqli_fetch_assoc($resultadoTipoInmueble)) : ?>
                                <option value="<?php echo $row['idTipo_Inmueble']; ?>"><?php echo $row['Nombre_Tipo_Inmueble']; ?></option>
                            <?php endwhile; ?>
                    </select>

                </div>
                
                <div class="search__element">
                    
                    <span>Operación</span>
                    <select name="idTipo_Operacion" id="">
                        <option value=""><----></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoOperacion)) : ?>
                            <option value="<?php echo $row['idTipo_Operacion']; ?>"><?php echo $row['Nombre_Operacion']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>


                    <div class="search__element">
                        <span>Activo</span>
                        <select name="activo" id="">
                            <option value=""><----></option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>


                    </div>

            <div class="search__title">
                <input type="submit" value="Buscar">
            </div>


        </form>


        <table>
            <tr>
                <td class="table__id">ID</td>
                <td class="table__fecha">Fecha</td>
                <td>Asesor</td>
                <td>Contrato</td>
                <td>Tipo de Inmueble</td>
                <td>Operacion</td>
                <td>Editar</td>
                <td>Activo</td>
                <td>Borrar</td>

            </tr>
        </table>
    </section>


    <?php while($row = mysqli_fetch_assoc($resultadoInmueble)): ?>


        <section class="table__content">
            <table>
                <tr>
                    <td class="table__id"><?php echo $row['idInmueble']?></td>
                    <td class="table__fecha"><?php echo$row['Fecha_Registro']?></td>
                    <td><?php  echo $row['Nombre_Apellido']?></td>
                    <td><?php  echo $row['Nombre_Contrato']?></td>
                    <td><?php  echo $row['Nombre_Tipo_Inmueble']?></td>
                    <td><?php  echo $row['Nombre_Operacion']?></td>

                    <td class="table__editar">
                        <a href="../Editar/index.php?id=<?php echo $row['idInmueble']?>">
                            <img src="../../../Assets/editar.png" alt="">
                        </a>
                    </td>




                    <td class="table__editar">
                        <form method="POST">
                        <?php

                        if($row['Activo'] == 1){

                            ?>

                            <a href="">
                                <input type="hidden"  class="input-activar" name="Activo" value="<?php echo $row['idInmueble']?>">
                                <input type="submit" class="input-activar" alt="" >
                            </a>
                            
                        <?php

                        }



                        else{

                        ?>

                            <a href="">
                                <input type="hidden"  class="input-desactivar" name="Activo" value="<?php echo $row['idInmueble']?>">
                                <input type="submit" class="input-desactivar" alt="" >
                            </a>

                        <?php

                        }
                        ?>


                        </form>




                </td>

                    <td class="table__editar">
                        <form method="POST">
                            
                                <input type="hidden"  class="input-borrar" name="idInmuebles" value="<?php echo $row['idInmueble']?>">
                                <input type="submit" class="input-borrar" alt="" >
                            


                        </form>

                    </td>
                </tr>
            </table>
        </section>

    <?php endwhile; ?>
    </section>
    </section>

    </main>

    <script src="JS/menu.js" ></script>
</body>
</html>

