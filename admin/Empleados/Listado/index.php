<?php
//Sesion

require '../../sesion.php';


if(!$auth){
    header('Location:../../../index.php');
}

//Conexión a la base de datos

require '../../../includes/config/database.php';

$db = conectarDB();

$queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

$resultadoEmpleadoNombre = mysqli_query($db, $queryEmpleado);

$resultadoEmpleadoNombre = mysqli_fetch_assoc($resultadoEmpleadoNombre);


$idRolEmpleado = $resultadoEmpleadoNombre['Rol_idRol'];

$idRolEmpleado = (int)$idRolEmpleado;


$queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
$resultadoRolEmpleado = mysqli_query($db, $queryRol);
$resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);

$queryEmpleado = "SELECT
empleado.idEmpleado,
empleado.Nombre_Apellido,
empleado.Activo,
Nombre_Cargo,
Nombre_rol,
Nombre_Oficina

FROM
empleado
INNER JOIN cargo ON empleado.Cargo_idCargo  = cargo.idCargo
INNER JOIN rol ON empleado.Rol_idRol   = rol.idRol
INNER JOIN oficina ON empleado.Oficina_idOficina = oficina.idOficina ORDER BY idEmpleado ASC";

$resultadoEmpleado = mysqli_query($db, $queryEmpleado);


// Consulta de los asesores para el select

$consultaidEmpleado = "SELECT idEmpleado FROM empleado";
$resultadoidEmpleado = mysqli_query($db, $consultaidEmpleado);


// Consulta de los asesores para el select

$consultaNombreEmpleado = "SELECT idEmpleado, Nombre_Apellido FROM empleado";
$resultadoNombreEmpleado = mysqli_query($db, $consultaNombreEmpleado);


// Consulta de los idInmueble para el select

$consultaCargo = "SELECT idCargo, Nombre_Cargo FROM cargo";
$resultadoCargo = mysqli_query($db, $consultaCargo);

// Consulta de los tipos de contratos activos para el select

$consultaRol = "SELECT idRol, Nombre_rol FROM rol";
$resultadoRol = mysqli_query($db, $consultaRol);

// Consulta de los tipos de inmueble activos para el select

$consultaOficina = "SELECT idOficina, Nombre_Oficina FROM oficina";
$resultadoOficina = mysqli_query($db, $consultaOficina);


$idEmpleado = null;
$Nombre_Apellido = null;
$cargo = null;
$rol = null;
$oficina = null;
$activo =  null;

if(isset ($_GET['del'])){
    $idEmpleado = (int)$_GET['del'];
    $queryConsultarInmuebles = "SELECT idInmueble FROM inmueble WHERE id_Empleado = $idEmpleado";
    $resultadoConsularInmuebles = mysqli_query($db, $queryConsultarInmuebles);
    
    while ($row = mysqli_fetch_assoc($resultadoConsularInmuebles)) {
        
        $inmueble = (int)$row['idInmueble'];
        
        $queryBorrarDatosBasicos = "DELETE from datos_basicos where Inmueble_idInmueble = $inmueble";
        $queryBorrarCaracteristicas = "DELETE from caracteristicas where idInmueble = $inmueble";
        $resultadoBorrar = mysqli_query($db, $queryBorrarDatosBasicos);
        $resultadoBorrar = mysqli_query($db, $queryBorrarCaracteristicas);
        # code...
    }
    $queryBorrarInmueble = "DELETE from inmueble where id_Empleado = $idEmpleado";
    $queryBorrarEmpleado = "DELETE FROM empleado WHERE idEmpleado = $idEmpleado";
    $queryConsultaUsuario = "SELECT Usuarios_idUsuarios FROM empleado WHERE idEmpleado = $idEmpleado";
    
    
    $resultadoConsultaUsuario = mysqli_query($db, $queryConsultaUsuario);
    $resultadoConsultaUsuario = mysqli_fetch_assoc($resultadoConsultaUsuario);
    $resultadoConsultaUsuario = $resultadoConsultaUsuario['Usuarios_idUsuarios'];
    $queryBorrarUsuario = "DELETE FROM usuarios WHERE  idUsuarios = $resultadoConsultaUsuario";
    $resultadoBorrar = mysqli_query($db, $queryBorrarInmueble);
    $resultadoBorrarEmpleado = mysqli_query($db, $queryBorrarEmpleado);
    $resultadoBorrarUsuario = mysqli_query($db, $queryBorrarUsuario);
    header('Location:index.php');
}



if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $_POST['idEmpleado'] != NULL OR $_POST['Nombre_Apellido'] != NULL OR $_POST['Cargo_idCargo'] != NULL OR $_POST['Rol_idRol'] != NULL OR $_POST['Oficina_idOficina'] != NULL OR $_POST['activo'] != NULL
    // isset($_POST['idEmpleado']) != NULL OR isset($_POST['Nombre_Apellido']) != NULL OR isset($_POST['Cargo_idCargo']) != NULL OR isset($_POST['Rol_idRol']) != NULL OR isset($_POST['Oficina_idOficina']) != NULL OR isset($_POST['activo']) != NULL

    if(isset($_POST['idEmpleado']) != NULL OR isset($_POST['Nombre_Apellido']) != NULL OR isset($_POST['Cargo_idCargo']) != NULL OR isset($_POST['Rol_idRol']) != NULL OR isset($_POST['Oficina_idOficina']) != NULL OR isset($_POST['activo']) != NULL) {


    // Asignación de variables y escape de datos para la prevención de inyección SQL
        $idEmpleado = (int)$_POST['idEmpleado'];
        $Nombre_Apellido = (string)$_POST['Nombre_Apellido'];
        $cargo = (int)$_POST['Cargo_idCargo'];
        $rol = (int)$_POST['Rol_idRol'];
        $oficina = (int)$_POST['Oficina_idOficina'];
        $activo = (int)$_POST['activo'];


        foreach ($_POST as $key => $value) {

            if ($value == NULL){
                unset($_POST[$key]);
            }
        }


        $queryBuscar = "SELECT
        empleado.idEmpleado,
        empleado.Nombre_Apellido,
        empleado.Activo,
        Nombre_Cargo,
        Nombre_rol,
        Nombre_Oficina
        
        FROM
        empleado
        INNER JOIN cargo ON empleado.Cargo_idCargo  = cargo.idCargo
        INNER JOIN rol ON empleado.Rol_idRol   = rol.idRol
        INNER JOIN oficina ON empleado.Oficina_idOficina = oficina.idOficina WHERE ";

        foreach ($_POST as $key => $value) {

            if($key == "activo" ){
                $key = ucfirst($key);
            }

            if(count($_POST) > 1 ) {

                $queryBuscar = $queryBuscar ."empleado.". $key . " = " . "'". $value. "'" . " AND " ;
                unset($_POST[$key]);

            } else if (count($_POST) == 1){

                $queryBuscar = $queryBuscar ."empleado.". $key . " = " . "'".$value."'" ;
                unset($_POST[$key]);
            }
        }

        // echo "<pre>";
        // var_dump($queryBuscar);
        // echo "</pre>";

        $resultadoBuscar = mysqli_query($db, $queryBuscar);
    }





        if (isset($_POST['Activo'])){

        $idEmpleado = (int)$_POST['Activo'];

        $queryEmpleadoActivo = "SELECT Activo From empleado WHERE idEmpleado = $idEmpleado";
        $resultadoEmpleadoActivo = mysqli_query($db, $queryEmpleadoActivo);
        $resultadoEmpleadoActivo = mysqli_fetch_assoc($resultadoEmpleadoActivo);
        
        
        
        if ($resultadoEmpleadoActivo['Activo'] == 1){
            $queryDesactivar = "UPDATE empleado SET Activo = 0 WHERE idEmpleado = $idEmpleado";
            $resultadoDesactivar = mysqli_query($db, $queryDesactivar);
            header('Location:index.php');
            
        }
        else {
            $queryActivar = "UPDATE empleado SET Activo = 1 WHERE idEmpleado = $idEmpleado";
            $resultadoDesactivar = mysqli_query($db, $queryActivar);
            header('Location:index.php');
            
        }
        
        
    }

    if(isset($resultadoBuscar)){
        $resultadoEmpleado = $resultadoBuscar;
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
        <title>Unika|Listado Propiedades</title>
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
                    <li><a href=""><span>VoBo Inmuebles</span></a></li>
                    <li><a href="index.php">Asesores</a></li>
                    <li><a href="../../Clientes/Listado/index.php">Clientes</a></li>
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
                <a class="new" href="../Nuevo/index.php">Nuevo Asesor</a>
            </div>


        </section>

        <form method="POST" class="table__search">
            <div class="search__title">
                <p>Buscar por:</p>
            </div>

                <div class="search__element">
                    <span>ID</span>
                    <select name="idEmpleado" id="">
                        <option value=""><----></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoidEmpleado)) : ?>
                            <option <?php echo $idEmpleado == $row['idEmpleado'] ? 'selected' : '' ; ?>value="<?php echo $row['idEmpleado']; ?>"><?php echo $row['idEmpleado']; ?></option>
                        <?php endwhile; ?>
                    </select>

                </div>


                <div class="search__element">

                    <span>Nombre</span>
                    <select name="Nombre_Apellido" id="">
                            <option value=""><----></option>
                            <?php while($row = mysqli_fetch_assoc($resultadoNombreEmpleado)) : ?>
                                <option value="<?php echo $row['Nombre_Apellido']; ?>"><?php echo $row['Nombre_Apellido']; ?></option>
                            <?php endwhile; ?>
                        </select>

                </div>

                <div class="search__element">

                    <span>Cargo</span>
                    <select name="Cargo_idCargo" id="">
                            <option value=""><----></option>
                            <?php while($row = mysqli_fetch_assoc($resultadoCargo)) : ?>
                                <option value="<?php echo $row['idCargo']; ?>"><?php echo $row['Nombre_Cargo']; ?></option>
                            <?php endwhile; ?>
                        </select>

                </div>

                <div class="search__element">

                    <span>Rol</span>
                    <select name="Rol_idRol" id="">
                            <option value=""><----></option>
                            <?php while($row = mysqli_fetch_assoc($resultadoRol)) : ?>
                                <option value="<?php echo $row['idRol']; ?>"><?php echo $row['Nombre_rol']; ?></option>
                            <?php endwhile; ?>
                    </select>

                </div>
                
                <div class="search__element">
                    
                    <span>Oficina</span>
                    <select name="Oficina_idOficina" id="">
                        <option value=""><----></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoOficina)) : ?>
                            <option value="<?php echo $row['idOficina']; ?>"><?php echo $row['Nombre_Oficina']; ?></option>
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
                <td>Nombre</td>
                <td>Cargo</td>
                <td>Rol</td>
                <td>Oficina</td>
                <td>Editar</td>
                <td>Activo</td>
                <td>Borrar</td>

            </tr>
        </table>
    </section>


    <?php while($row = mysqli_fetch_assoc($resultadoEmpleado)): ?>


        <section class="table__content">
            <table>
                <tr>
                    <td class="table__id"><?php echo $row['idEmpleado']?></td>
                    <td><?php  echo $row['Nombre_Apellido']?></td>
                    <td><?php  echo $row['Nombre_Cargo']?></td>
                    <td><?php  echo $row['Nombre_rol']?></td>
                    <td><?php  echo $row['Nombre_Oficina']?></td>

                    <td class="table__editar">
                        <a href="../Editar/index.php?id=<?php echo $row['idEmpleado']?>">
                            <img src="../../../Assets/editar.png" alt="">
                        </a>
                    </td>




                    <td class="table__editar">
                        <form method="POST">
                        <?php

                        if($row['Activo'] == 1){

                            ?>

                                <input type="hidden"  class="input-activar" name="Activo" value="<?php echo $row['idEmpleado']?>">
                                <input type="submit" class="input-activar" alt="" >

                            
                        <?php

                        }



                        else{

                        ?>

 
                                <input type="hidden"  class="input-desactivar" name="Activo" value="<?php echo $row['idEmpleado']?>">
                                <input type="submit" class="input-desactivar" alt="" >

                        <?php

                        }
                        ?>


                        </form>




                </td>

                    <td class="table__editar">
                            
                                <input type="hidden"  class="input-borrar" name="borrar" onclick="preguntar(<?php echo $row['idEmpleado']?>)">
                                <input type="submit" class="input-borrar" alt=""  onclick="preguntar(<?php echo $row['idEmpleado']?>)">
                    </td>
                </tr>
            </table>
        </section>

    <?php endwhile; ?>

    </section>

    </main>
    <script type="text/javascript">

    function preguntar(id){
        if(confirm('¿Estas seguro que deseas borrar este empleado?')){
            window.location.href = "index.php?del=" + id;
        }
    }

    </script>
        <script src="JS/menu.js" ></script>
</body>
</html>