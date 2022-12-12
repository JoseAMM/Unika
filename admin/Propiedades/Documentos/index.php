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


// Consulta de la información básica del inmueble para el Select

    $queryInmueble = "SELECT
    idInmueble,
    Nombre_Apellido,
    Nombre_Contrato,
    Nombre_Tipo_Inmueble,
    Nombre_Operacion,
    Direccion
    FROM
    inmueble
    INNER JOIN empleado ON idEmpleado = id_Empleado
    INNER JOIN tipo_contrato ON inmueble.idTipo_Contrato   = tipo_contrato.idTipo_Contrato
    INNER JOIN tipo_inmueble ON inmueble.idTipo_Inmueble   = tipo_inmueble.idTipo_Inmueble
    INNER JOIN tipo_operacion ON inmueble.idTipo_Operacion = tipo_operacion.idTipo_Operacion
    INNER JOIN datos_basicos ON inmueble.idInmueble = datos_basicos.Inmueble_idInmueble WHERE VoBo = 1 ORDER BY idInmueble ASC";

    $resultadoInmueble = mysqli_query($db, $queryInmueble);


    $errores = [];


    if($_SERVER['REQUEST_METHOD'] === 'POST') {



            $inmueble = $_POST['inmueble'];
            $titulo = limpieza($_POST['titulo']);


            $queryDocuments = "SELECT COUNT(id_Inmueble_Documentos) FROM documentos WHERE id_Inmueble_Documentos = $inmueble";
            $resultadoDocuments = mysqli_query($db, $queryDocuments);
            $resultadoDocuments = mysqli_fetch_assoc($resultadoDocuments);
            $resultadoDocuments = $resultadoDocuments['COUNT(id_Inmueble_Documentos)'];
            $resultadoDocuments = (int)$resultadoDocuments + 1;


            $carpetaDocuments = "Documents/";
            if(!is_dir($carpetaDocuments)){
                mkdir($carpetaDocuments);
            }



            if($_FILES['document']['size'] != 0){

                $document = $_FILES['document'];

                switch ($_FILES['document']['type']) {
                    case 'application/pdf':
                        # code...
                        $nombreDocumento = 'inmueble_'.$inmueble . 'documento'.$resultadoDocuments. '.pdf';
                        move_uploaded_file($document['tmp_name'], $carpetaDocuments . $nombreDocumento);
                        $queryDocumentos = "INSERT INTO documentos (idDocumentos, Titulo, id_Inmueble_Documentos ) VALUES ('$nombreDocumento', '$titulo', $inmueble)";
                        $resultadoDocumentos = mysqli_query($db, $queryDocumentos);

                        break;
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                        # code...

                        $nombreDocumento = 'inmueble_'.$inmueble . 'documento'.$resultadoDocuments. '.docx';
                        move_uploaded_file($document['tmp_name'], $carpetaDocuments . $nombreDocumento);
                        $queryDocumentos = "INSERT INTO documentos (idDocumentos, Titulo, id_Inmueble_Documentos ) VALUES ('$nombreDocumento', '$titulo', $inmueble)";
                        $resultadoDocumentos = mysqli_query($db, $queryDocumentos);
    
                        break;

                    case 'application/msword':
                        # code...

                        $nombreDocumento = 'inmueble_'.$inmueble . 'documento'.$resultadoDocuments. '.doc';
                        move_uploaded_file($document['tmp_name'], $carpetaDocuments . $nombreDocumento);
                        $queryDocumentos = "INSERT INTO documentos (idDocumentos, Titulo, id_Inmueble_Documentos ) VALUES ('$nombreDocumento', '$titulo', $inmueble)";
                        $resultadoDocumentos = mysqli_query($db, $queryDocumentos);
    
    
                        break;

                    case 'image/jpeg':
                        # code...

                        $nombreDocumento = 'inmueble_'.$inmueble . 'documento'.$resultadoDocuments. '.jpg';
                        move_uploaded_file($document['tmp_name'], $carpetaDocuments . $nombreDocumento);
                        $queryDocumentos = "INSERT INTO documentos (idDocumentos, Titulo, id_Inmueble_Documentos ) VALUES ('$nombreDocumento', '$titulo', $inmueble)";
                        $resultadoDocumentos = mysqli_query($db, $queryDocumentos);
    
    
                        break;

                    case 'image/png':
                        # code...
                        $nombreDocumento = 'inmueble_'.$inmueble . 'documento'.$resultadoDocuments. '.png';
                        move_uploaded_file($document['tmp_name'], $carpetaDocuments . $nombreDocumento);
                        $queryDocumentos = "INSERT INTO documentos (idDocumentos, Titulo, id_Inmueble_Documentos ) VALUES ('$nombreDocumento', '$titulo', $inmueble)";
                        $resultadoDocumentos = mysqli_query($db, $queryDocumentos);
    
                        break;
                    default:
                        # code...
                        break;
                }

                if($resultadoDocumentos){
                    header('Location: ../Listado/index.php');
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
                        <li><a href="index.php">Documentos/Inmuebles</a></li>
                        <li class="nav__logout"><a href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </section>


        <section class="main__formulario">
        <?php foreach($errores as $error):?>

        <div class="error"><p><?php  echo $error ?></p></div>

        <?php endforeach?>

            <form action="" method="POST" enctype="multipart/form-data">

                <section class="select">
                    <span>Inmueble (ID - Asesor - Tipo de Inmueble)* </span>
                    <select name="inmueble" id="" required>
                        <option><--Selecciona--></option>
                        <?php while($row = mysqli_fetch_assoc($resultadoInmueble)) : ?>
                            <option required value="<?php echo $row['idInmueble']; ?>"><?php echo $row['idInmueble'] ." - ". $row['Nombre_Apellido'] ." - ". $row['Nombre_Tipo_Inmueble']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </section>

                <label for="">
                    <span>Breve Descripción del Documento*</span>
                    <input type="text" id= "titulo" name="titulo" placeholder = "Título" max="50" required>
                </label>

                <label for="">
                    <span>Documentos (Max: 4 Mb)</span>
                    <input type="file" id= "document" name= "document" accept=".jpeg, .png, .jpg, .pdf, .doc, .docx">
                </label>

                <input type="submit" value = "Registrar" class = "signup__submit">
            </form>
        </section>
    </section>
    
</main>
<script src="JS/menu.js" ></script>
</body>
</html>