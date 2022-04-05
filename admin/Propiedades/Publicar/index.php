<?php

//Sesion

require '../../sesion.php';


//Conexión a la base de datos

require '../../../includes/config/database.php';


$db = conectarDB();

// Funcion para la limpieza de datos

require '../../limpieza.php';


// Consulta del nombre y rol del usuario 

$queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";

$resultadoEmpleadoNombre = mysqli_query($db, $queryEmpleado);

$resultadoEmpleadoNombre = mysqli_fetch_assoc($resultadoEmpleadoNombre);

$idRolEmpleado = $resultadoEmpleadoNombre['Rol_idRol'];

$idRolEmpleado = (int)$idRolEmpleado;


$queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
$resultadoRolEmpleado = mysqli_query($db, $queryRol);
$resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);

// Consulta de los asesores activos para el select

    $consultaAsesor = "SELECT * FROM empleado WHERE Activo = 1";
    $resultadoAsesor = mysqli_query($db, $consultaAsesor);

// Consulta de los tipos de contratos activos para el select

    $consultaContrato = "SELECT idTipo_Contrato, Nombre_Contrato, Activo FROM tipo_contrato WHERE Activo = 1";
    $resultadoContrato = mysqli_query($db, $consultaContrato);

// Consulta de los tipos de inmueble activos para el select

    $consultaInmueble = "SELECT idTipo_Inmueble, Nombre_Tipo_Inmueble, Activo FROM tipo_inmueble WHERE Activo = 1;";
    $resultadoInmueble = mysqli_query($db, $consultaInmueble);

// Consulta de los tipos de operación activos para el select

    $consultaOperacion = "SELECT idTipo_Operacion, Nombre_Operacion, Activo FROM tipo_operacion WHERE Activo = 1;";
    $resultadoOperacion = mysqli_query($db, $consultaOperacion);

// Consulta de los clientes activos para el select 

    $consultaCliente = "SELECT idCliente, Correo FROM cliente WHERE Activo = 1;";
    $resultadoCliente = mysqli_query($db, $consultaCliente);

    

    $errores = [];

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
                        <li><a href="../../Empleados/Listado/index.php">Asesores</a></li>
                        <li><a href="../../Clientes/Listado/index.php">Clientes</a></li>
                        <li><a href="../Documentos/index.php">Documentos/Inmuebles</a></li>
                        <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </section>


        <section class="main__formulario">
        <?php foreach($errores as $error):?>

        <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>

            <form action="../PublicarCompleto/index.php" method="POST" >


                <section class="select">
                <span>Asesor*</span>
                    <select name="asesor" id="" required>
                        <option value=""><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoAsesor)) : ?>
                            <option value="<?php echo $row['idEmpleado']; ?>"><?php echo $row['Nombre_Apellido']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    
                </section>
                <section class="select__config">
                    <span>Tipo de Contrato*</span>
                    <select name="contrato" id="" required>
                        <option value=""><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoContrato)) : ?>
                            <option value="<?php echo $row['idTipo_Contrato']; ?>"><?php echo $row['Nombre_Contrato']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="button__new">
                        <a class="new" href="../Contrato/index.php">Nuevo Contrato</a>
                    </div>
                </section>
                <section class="select__config">
                    <span>Tipo de Inmueble*</span>
                    <select name="inmueble" id="" required>
                        <option value=""><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoInmueble)) : ?>
                            <option required value="<?php echo $row['idTipo_Inmueble']; ?>"><?php echo $row['Nombre_Tipo_Inmueble']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="button__new">
                        <a class="new" href="../T.Inmueble/index.php">Nuevo Tipo de Inmueble</a>
                    </div>
                </section>
                <section class="select__config">
                    <span>Tipo de Operación*</span>
                    <select name="operacion" id="" required>
                        <option value=''><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoOperacion)) : ?>
                            <option required value="<?php echo $row['idTipo_Operacion']; ?>"><?php echo $row['Nombre_Operacion']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="button__new">
                        <a class="new" href="../Operacion/index.php">Nueva Operación</a>
                    </div>
                </section>
                <section class="select__config">
                    <span>Cliente*</span>
                    <select name="cliente" id="" required>
                        <option value=''><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoCliente)) : ?>
                            <option required value="<?php echo $row['idCliente']; ?>"><?php echo $row['Correo']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <div class="button__new">i
                        <a class="new" href="../../Empleados/Nuevo/index.php">Nuevo Cliente</a>
                    </div>
                </section>
                <label for="superficie_terreno">
                    <span>Superficie del Terreno*</span>
                    <input class="input__text" type="number" id= "superficie_terreno" name="superficie_terreno" placeholder = "En m2" min="50" required>
                </label>

                <label for="superficie_construccion">
                    <span>Superficie de Construcción*</span>
                    <input  class="input__text" type="number" id= "superficie_construccion" name="superficie_construccion"  placeholder = "En m2"  min="50" required maxlength="45">
                </label>

                <label for="habitaciones">
                    <span>Introduce el Número de Habitaciones*</span>
                    <input  class="input__text" type="number" id= "habitaciones" name="habitaciones" placeholder = "N° de Habitaciones" min="1" required>
                </label>

                <label for="estacionamiento">
                    <span>Introduce el Número de Lugares de Estacionamiento*</span>
                    <input  class="input__text" type="number" id= "estacionamiento" name="estacionamiento" placeholder = "N° de Lugares" min="0" required >
                </label>

                <label for="otras">
                    <span>Otras Características*</span>
                    <input  class="input__text" type="text" id= "otras" name= "otras"  placeholder = "Otras Características" required  maxlength="100">
                </label>
                <section class="select__config">
                <label for="cp">
                    <span>Código Postal*</span>
                    <input  class="input__text" type="text" id= "cp" name="cp" placeholder = "cp"  max="7" required>
                    <div class="button__new">
                        <input type="submit" class="new" value="Buscar CP">
                    </div>
                </label>
                </section>
            </form>
        </section>
    </section>
    
</main>
<script src="JS/menu.js" ></script>
</body>
</html>