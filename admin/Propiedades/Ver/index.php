<?php
//Sesion
require '../../sesion.php';
$idInmueble = $_GET['id'];
$idInmueble = filter_var($idInmueble, FILTER_VALIDATE_INT);
if (!$idInmueble) {
    header('Location: ../Listado/index.php');
}
//Conexión a la base de datos
require '../../../includes/config/database.php';
$db = conectarDB();
// Consulta del nombre y rol del usuario 
$queryEmpleado = "SELECT * FROM empleado WHERE $idUsuarios = empleado.Usuarios_idUsuarios";
$resultadoEmpleadoNombre = mysqli_query($db, $queryEmpleado);
$resultadoEmpleadoNombre = mysqli_fetch_assoc($resultadoEmpleadoNombre);
$idRolEmpleado = $resultadoEmpleadoNombre['Rol_idRol'];
$idRolEmpleado = (int)$idRolEmpleado;
$queryRol = "SELECT Nombre_rol FROM rol WHERE idRol = $idRolEmpleado";
$resultadoRolEmpleado = mysqli_query($db, $queryRol);
$resultadoRolEmpleado = mysqli_fetch_assoc($resultadoRolEmpleado);
// Consulta de la información del inmueble
$consultaDatosInmueble = "SELECT
            empleado.Nombre_Apellido,
            tipo_contrato.Nombre_Contrato,
            tipo_inmueble.Nombre_Tipo_Inmueble,
            tipo_operacion.Nombre_Operacion,
            inmueble.Activo,
            inmueble.idCliente
        FROM
            (
                (
                    (
                        (
                            inmueble
                            INNER JOIN empleado ON inmueble.id_Empleado = empleado.idEmpleado
                        )
                        INNER JOIN tipo_contrato ON inmueble.idTipo_Contrato = tipo_contrato.idTipo_Contrato
                    )
                    INNER JOIN tipo_inmueble ON inmueble.idTipo_Inmueble = tipo_inmueble.idTipo_Inmueble
                )
                INNER JOIN tipo_operacion ON inmueble.idTipo_Operacion = tipo_operacion.idTipo_Operacion
            )
        WHERE
            idInmueble = '$idInmueble' ";
$consultaDatosInmueble = mysqli_fetch_assoc(mysqli_query($db, $consultaDatosInmueble));
$consultaCaracteristicas = "SELECT * FROM caracteristicas WHERE idInmueble_Caracteristicas = $idInmueble";
$consultaCaracteristicas = mysqli_fetch_assoc(mysqli_query($db, $consultaCaracteristicas));

// Consulta de documentos asociados al inmueble
$queryDocuments = "SELECT * FROM documentos WHERE id_Inmueble_Documentos = $idInmueble";
$resultadoDocuments = mysqli_query($db, $queryDocuments);
$queryCountDocuments = "SELECT COUNT(id_Inmueble_Documentos) FROM documentos WHERE id_Inmueble_Documentos = $idInmueble";
$resultadoCountDocuments = mysqli_query($db, $queryCountDocuments);
$resultadoCountDocuments = mysqli_fetch_assoc($resultadoCountDocuments);
$resultadoCountDocuments = $resultadoCountDocuments['COUNT(id_Inmueble_Documentos)'];
$resultadoCountDocuments = (int)$resultadoCountDocuments;

// Consulta de los datos básicos asociados al inmueble
$consultaDatosBasicos = "SELECT * FROM datos_basicos WHERE Inmueble_idInmueble = $idInmueble";
$consultaDatosBasicos = mysqli_fetch_assoc(mysqli_query($db, $consultaDatosBasicos));

// Consulta de la colonia y código postal del inmueble
$colonia = $consultaDatosBasicos['Colonias_idColonias'];
$consultaColonia = "SELECT nombre, Codigo_postal FROM colonias WHERE id = '$colonia'";
$consultaColonia = mysqli_fetch_assoc(mysqli_query($db, $consultaColonia));
$consultaDocumentos = "SELECT idDocumentos, Titulo, id_Inmueble_Documentos FROM documentos WHERE id_Inmueble_Documentos = '$idInmueble'";
$consultaDocumentos = mysqli_query($db, $consultaDocumentos);

// Consulta de las fotos asociadas al inmueble
$consultaFotos = "SELECT NombreFotos FROM fotos WHERE id_Inmueble_Fotos = $idInmueble";
$consultaFotos =  mysqli_query($db, $consultaFotos);


$asesor = $consultaDatosInmueble['Nombre_Apellido'];
$contrato = $consultaDatosInmueble['Nombre_Contrato'];
$inmueble = $consultaDatosInmueble['Nombre_Tipo_Inmueble'];
$operacion = $consultaDatosInmueble['Nombre_Operacion'];
$disponible = $consultaDatosInmueble['Activo'];
$idCliente = $consultaDatosInmueble['idCliente'];

// Consulta de la información personal asociada al inmueble
$queryCliente = "SELECT * FROM cliente WHERE idCliente = " . $idCliente;
$consultaCliente = mysqli_fetch_assoc(mysqli_query($db, $queryCliente));

$superficie_terreno = (int)$consultaCaracteristicas['Superficie_Terreno'];
$superficie_construccion = (int)$consultaCaracteristicas['Superficie_Construccion'];
$habitaciones = $consultaCaracteristicas['Habitaciones'];
$bano = $consultaCaracteristicas['Banos'];
$estacionamiento = $consultaCaracteristicas['Puestos_Estacionamiento'];
$descripcion = $consultaCaracteristicas['Descripcion'];
$direccion = $consultaDatosBasicos['Direccion'];
$precio = $consultaDatosBasicos['Precio'];
$ubicacion = $consultaDatosBasicos['Ubicacion_Maps'];
$urlAnuncio = $consultaDatosBasicos['Url_anuncio_web'];
$urlVideo = $consultaDatosBasicos['Url_video'];
$colonia = $consultaColonia['nombre'];
$codigoPostal = $consultaColonia['Codigo_postal'];
require('reporte.php');


$documentos;
if ($resultadoCountDocuments != 0) {
    $documentos = 1;
} else {
    $documentos = 0;
}

$queryDocumentoPrivacidad = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND Activo = 0" ;
$consultaDocumentoPrivacidad = mysqli_fetch_assoc(mysqli_query($db, $queryDocumentoPrivacidad));

if($consultaDocumentoPrivacidad != NULL){
    $classDescargarPrivacidad = "descargarPrivacidadEnabled";
}else {
    $classDescargarPrivacidad = "descargarPrivacidadDisabled";
}

if (isset($_POST['activarPrivacidad'])) {
    $nombrePrivacidad = $_POST['nombrePrivacidad'];
    $domicilioPrivacidad = $_POST['domicilioPrivacidad'];
    $telefonoPrivacidad = $_POST['telefonoPrivacidad'];
    $rfcPrivacidad = $_POST['rfcPrivacidad'];
    $emailPrivacidad = $_POST['emailPrivacidad'];

    require_once('DocumentosCanva/avisoPrivacidad.php');

    $queryComprobacionDocumentoPrivacidad = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND NombreDocumentosOficial = 'AvisoPrivacidad'";
    $consultaComprobacionDocumentoPrivacidad = mysqli_fetch_assoc(mysqli_query($db, $queryComprobacionDocumentoPrivacidad));


    
    if ($consultaComprobacionDocumentoPrivacidad != NULL) {
        $idDocumentosOficiales = $consultaComprobacionDocumentoPrivacidad['idDocumentosOficiales'];
        $queryActualizarDocumentoPrivacidad = "UPDATE documentosoficiales SET Activo = 1 WHERE idDocumentosOficiales = $idDocumentosOficiales";
        $resultadoActualizarDocumentoPrivacidad = mysqli_query($db, $queryActualizarDocumentoPrivacidad);
        
    } else {
        $queryInsertarDocumentoPrivacidad = "INSERT INTO documentosoficiales (NombreDocumentosOficial, idInmueble_DocumentosOficiales, Activo) VALUES ('AvisoPrivacidad', $idInmueble, 1)";
        $resultadoInsertarDocumentoPrivacidad = mysqli_query($db, $queryInsertarDocumentoPrivacidad);
        
    }
    
    avisoPrivacidad($nombrePrivacidad, $domicilioPrivacidad, $telefonoPrivacidad, $rfcPrivacidad, $emailPrivacidad, $idInmueble, 'AvisoPrivacidad');
    
}
if (isset($_POST['download'])) {
    $download = 1;
    $share = 0;
    $print = 0;
    pdf(
        $idInmueble,
        $consultaFotos,
        $operacion,
        $precio,
        $inmueble,
        $disponible,
        $habitaciones,
        $estacionamiento,
        $bano,
        $descripcion,
        $contrato,
        $superficie_construccion,
        $superficie_terreno,
        $colonia,
        $codigoPostal,
        $download,
        $share,
        $print,
        $documentos
    );
}
if (isset($_POST['print']) or isset($_POST['share'])) {
    $download = 0;
    $share = 1;
    $print = 1;
    pdf(
        $idInmueble,
        $consultaFotos,
        $operacion,
        $precio,
        $inmueble,
        $disponible,
        $habitaciones,
        $estacionamiento,
        $contrato,
        $superficie_construccion,
        $superficie_terreno,
        $colonia,
        $codigoPostal,
        $otras,
        $download,
        $share,
        $print,
        $documentos
    );
}
if (isset($_GET['del'])) {
    $idMensaje = $_GET['del'];
    $queryBorrarMensaje = "DELETE FROM mensajes where idMensaje = '$idMensaje'";
    $resultadoBorrar = mysqli_query($db, $queryBorrarMensaje);
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/MOBILE/mobile.css" media="(max-width: 840px)">
    <link rel="stylesheet" href="CSS/MEDIUM/mobile.css" media="(min-width: 840px)">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet" />
    <script language="javascript" src="../../../jquery-3.6.1.min.js"></script>
    <title>Unika|Editar Propiedad</title>
</head>
<script language="javascript">
    $(document).ready(function() {
        let i = 1;

        $('#editarPrivacidad').click(function(e) {
            e.preventDefault();

            i++;
            if (i % 2 == 0) {
                $('#acciones__firma').after(
                    '<section class="parametros" id="parametros">' +
                    '<section>' +
                    '<span>Nombre del cliente</span>' +
                    '<input type="text" value="<?php if($consultaCliente['Nombre'] != NULL){ echo ($consultaCliente['Nombre']);} else {echo ("Sin nombre registrado");}?>" name="nombrePrivacidad" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Domicilio</span>' +
                    '<input  type="text" name="domicilioPrivacidad" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Teléfono</span>' +
                    '<input  type="text" value="<?php if($consultaCliente['Telefono'] != NULL){ echo ($consultaCliente['Telefono']);} else {echo ("Sin teléfono registrado");}?>" name="telefonoPrivacidad" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>R.F.C</span>' +
                    '<input  type="text" name="rfcPrivacidad" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Email</span>' +
                    '<input  type="text" value="<?php if($consultaCliente['Correo'] != NULL){ echo ($consultaCliente['Correo']);} else {echo ("Sin correo registrado");}?>" name="emailPrivacidad" required>' +
                    '</section>' +
                    '</section>');
                    $('#activarPrivacidad').prop("disabled" , false);
                    $('#activarPrivacidad').removeClass("activarPrivacidadDisabled");
                    $('#activarPrivacidad').addClass("activarPrivacidadEnabled");
                    
            } else {
                $('#parametros').remove();
                $('#activarPrivacidad').prop("disabled" , true);
                $('#activarPrivacidad').removeClass("activarPrivacidadEnabled");
                $('#activarPrivacidad').addClass("activarPrivacidadDisabled");
            }








        });
    });
</script>

<body>
    <header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="../../index.php"><img src="../../../Assets/logo.png" alt=""></a>
            </section>
            <section class="header__name">
                <p> Bienvenido <?php echo $resultadoEmpleadoNombre['Nombre_Apellido'] ?></p>
                <p class="name__rol"> Su Rol es: <?php echo $resultadoRolEmpleado['Nombre_rol'] ?> </p>
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
                <form action="" method="POST">
                    <label for="" class="normal">
                        <span>Asesor</span>
                        <p> <?php echo $asesor ?></p>
                    </label>
                    <label for="" class="normal">
                        <span>Tipo de Contrato</span>
                        <p> <?php echo $contrato ?></p>
                    </label>
                    <label for="" class="normal">
                        <span>Tipo de Inmueble</span>
                        <p> <?php echo $inmueble ?></p>
                    </label>
                    <label for="" class="normal">
                        <span>Tipo de Operación</span>
                        <p> <?php echo $operacion ?></p>
                    </label>
                    <label for="" class="normal">
                        <span>Superficie del Terreno</span>
                        <p><?php echo $superficie_terreno;  ?></p>
                    </label>
                    <label for="superficie_construccion" class="normal">
                        <span>Superficie de Construcción</span>
                        <p><?php echo $superficie_construccion;  ?></p>
                    </label>
                    <label for="habitaciones" class="normal">
                        <span>Habitaciones</span>
                        <p><?php echo $habitaciones;  ?></p>
                    </label>
                    <label for="estacionamiento" class="normal">
                        <span>Lugares de Estacionamiento</span>
                        <p><?php echo $estacionamiento;  ?></p>
                    </label>
                    <label for="otras" class="normal">
                        <span>Otras Características</span>
                        <p><?php echo $otras;  ?></p>
                    </label>
                    <label for="" class="normal">
                        <span>Código Postal </span>
                        <p><?php echo $codigoPostal;  ?></p>
                    </label>
                    <label for="" class="normal">
                        <span>Colonia </span>
                        <p><?php echo $colonia;  ?></p>
                    </label>
                    <label for="direccion" class="normal">
                        <span>Dirección</span>
                        <p><?php echo $direccion;  ?></p>
                    </label>
                    <label for="precio" class="normal">
                        <span>Precio</span>
                        <p><?php echo "$" . $precio;  ?></p>
                    </label>
                    <label for="ubicacion" class="normal">
                        <span>Ubicación</span>
                        <p><?php echo $ubicacion;  ?></p>
                    </label>
                    <label for="urlAnuncio" class="normal">
                        <span>URL del Anuncio</span>
                        <a href=""></a>
                        <p><a href="<?php echo $urlAnuncio;  ?>" target="_blank"><?php echo $urlAnuncio;  ?></a></p>
                    </label>
                    <label for="urlVideo" class="normal">
                        <span>URL del video</span>
                        <p><a href="<?php echo $urlAnuncio;  ?>" target="_blank"><?php echo $urlAnuncio;  ?></a></p>
                    </label>
                    <?php static $i = 1;
                    while ($row = mysqli_fetch_assoc($consultaFotos)) : ?>
                        <label for=" <?php echo 'foto' . $i ?>" class="normal">
                            <span> <?php echo 'Foto ' . $i ?> </span>
                            <p><img src="../Imagenes/<?php echo $row['NombreFotos'] ?>" alt=""></p>
                        </label>
                    <?php $i++;
                    endwhile; ?>
                    <label for="descargar" class="input__download">
                        <span>Generar reporte del Inmueble en PDF</span>
                        <section>
                            <input type="submit" name="download" value="" class="download">
                            <input type="submit" target="_blank" name="share" value="" class="share">
                            <input type="submit" target="_blank" name="print" value="" class="print">
                        </section>
                    </label>
                    <label for="descargar" class="input__firma">
                        <span>Aviso de Privacidad</span>
                        <section class="contenedor__firma">
                            <section class="acciones__firma" id="acciones__firma">
                                <input type="submit" name="downloadPrivacidad" value="Descargar PDF firmado" class="<?php echo $classDescargarPrivacidad?>">
                                <input disabled id="activarPrivacidad" type="submit" value="Activar PDF para firma" name="activarPrivacidad" class="activarPrivacidadDisabled">
                                <button id="editarPrivacidad" class="editarPrivacidad">Editar parámetros del PDF</button>
                            </section>

                        </section>



                    </label>
                    <?php while ($row = mysqli_fetch_assoc($resultadoDocuments)) : ?>
                        <?php
                        static $contador = 0;
                        $contador = $contador + 1 ?>
                        <label for="descargar" class="input__download">
                            <span>Documento (<?php echo $row['Titulo'] ?>)</span>
                            <section>
                                <a href="../Documentos/Documents/<?php echo $row['idDocumentos'] ?>" download="<?php echo $row['idDocumentos'] ?>"></a>
                                <input type="hidden" class="input-borrar" name="borrar" onclick="preguntar(<?php echo $contador . ' ,' . $idInmueble ?>)">
                                <input type="button" class="input-borrar" alt="" onclick="preguntar(<?php echo $contador . ' ,' . $idInmueble ?>)">
                            </section>
                        </label>
                    <?php endwhile; ?>
                </form>
            </section>
        </section>
    </main>
    <footer>
        <section></section>
    </footer>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function preguntar(id, Inmueble) {
            // id.preventDefault();
            Swal.fire({
                title: '¿Estás seguro de borrar este documento?',
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
                        'El documento ha sido borrado.',
                        'success'
                    )
                    setTimeout(function() {
                        window.location.href = "borrar.php?del=" + id + "&id=" + Inmueble;
                    }, 2000);
                }
            })
        }
    </script>
    <script src="JS/menu.js"></script>
</body>

</html>