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

/**
 * * Consulta otras características
 */
$consultaOtrasCaracteristicas = "SELECT
otras_caracteristicas.idOtras_Caracteristicas,
otras_caracteristicas.idAmenidades,
amenidades.NombreAmenidades
FROM
(
    otras_caracteristicas
    INNER JOIN amenidades ON otras_caracteristicas.idAmenidades = amenidades.idAmenidades
)
WHERE
id_Inmueble = $idInmueble";
$consultaOtrasCaracteristicas = mysqli_query($db, $consultaOtrasCaracteristicas);

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

/**
 * + Consulta de los documentos oficiales
 */

/**
 * * Consulta del documento Aviso de Privacidad
 */
$queryDocumentoPrivacidad = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND Activo = 0 AND NombreDocumentosOficial = 'AvisoPrivacidad'";
$consultaDocumentoPrivacidad = mysqli_fetch_assoc(mysqli_query($db, $queryDocumentoPrivacidad));

if ($consultaDocumentoPrivacidad != NULL) {
    $classDescargarPrivacidad = "descargarEnabled";
} else {
    $classDescargarPrivacidad = "descargarDisabled";
}

/**
 * * Consulta del documento AceptacionSeguimientoCompraVenta
 */
$queryDocumentoAceptacionCompraVenta = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND Activo = 0 AND NombreDocumentosOficial = 'AceptacionSeguimientoCompraVenta'";
$consultaDocumentoAceptacionCompraVenta = mysqli_fetch_assoc(mysqli_query($db, $queryDocumentoAceptacionCompraVenta));

if ($consultaDocumentoAceptacionCompraVenta != NULL) {
    $classDescargarAceptacionCompraVenta = "descargarEnabled";
} else {
    $classDescargarAceptacionCompraVenta = "descargarDisabled";
}
/**
 * * Consulta del documento CartaDerechos
 */
$queryDocumentoDerechos = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND Activo = 0 AND NombreDocumentosOficial = 'CartaDerechos'";
$consultaDocumentoDerechos = mysqli_fetch_assoc(mysqli_query($db, $queryDocumentoDerechos));

if ($consultaDocumentoDerechos != NULL) {
    $classDescargarDerechos = "descargarEnabled";
} else {
    $classDescargarDerechos = "descargarDisabled";
}
/**
 * * Consulta del documento ContratoPromesaCompraVenta
 */
$queryDocumentoDerechos = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND Activo = 0 AND NombreDocumentosOficial = 'ContratoPromesaCompraVenta'";
$consultaDocumentoDerechos = mysqli_fetch_assoc(mysqli_query($db, $queryDocumentoDerechos));

if ($consultaDocumentoDerechos != NULL) {
    $classDescargarPromesa = "descargarEnabled";
} else {
    $classDescargarPromesa = "descargarDisabled";
}



/**
 * + Activación de los documentos
 */

 /**
  * * Activacion de documento Aceptacion Compra Venta
  */
  if (isset($_POST['activarAceptacion'])) {

    /**
     * / Include del documento
     */
    include_once('DocumentosCanva/AceptacionSeguimientoCompraVenta.php');

    /**
     * / Variables para el documento
     */
    $nombreCompradorAceptacion = $_POST['nombreCompradorAceptacion'];
    $ubicacionAceptacion = $_POST['ubicacionAceptacion'];

    /**
     * / Comprueba si en documentosoficiales ya hay documento activo/inactivo, si ya se firmó o no se ha firmado , actualiza a activo "1", para volver a firmarlo, si no se ha generado ningún documento oficial, se inserta en la base de datos
     */

     $queryBorrarInformacionTemporal = "DELETE FROM informaciontemporaldocumentosoficiales WHERE idInmueble_InformacionTemporalDocumentosOficiales = $idInmueble AND NombreDocumento = 'AceptacionSeguimientoCompraVenta'";
     $consultaBorrarInformacionTemporal = mysqli_query($db, $queryBorrarInformacionTemporal);

    $queryComprobacionDocumento = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND NombreDocumentosOficial = 'AceptacionSeguimientoCompraVenta'";
    $consultaComprobacionDocumento = mysqli_fetch_assoc(mysqli_query($db, $queryComprobacionDocumento));



    if ($consultaComprobacionDocumento != NULL) {
        $idDocumentosOficiales = $consultaComprobacionDocumento['idDocumentosOficiales'];
        $queryActualizarDocumento = "UPDATE documentosoficiales SET Activo = 1 WHERE idDocumentosOficiales = $idDocumentosOficiales";
        $resultadoActualizarDocumento = mysqli_query($db, $queryActualizarDocumento);
    } else {
        $queryActualizarDocumento = "INSERT INTO documentosoficiales (NombreDocumentosOficial, idInmueble_DocumentosOficiales, Activo) VALUES ('AceptacionSeguimientoCompraVenta', $idInmueble, 1)";
        $resultadoActualizarDocumento = mysqli_query($db, $queryActualizarDocumento);
    }

    aceptacionSeguimientoCompraVenta($nombreCompradorAceptacion, $ubicacionAceptacion, $idInmueble, 'AceptacionSeguimientoCompraVenta');
}
/**
  * * Activacion de documento Carta de Derechos
  */
  if (isset($_POST['activarDerechos'])) {

    /**
     * / Include del documento
     */
    include_once('DocumentosCanva/CartaDerechos.php');

    /**
     * / Variables para el documento
     */
    $nombreClienteDerechos = $_POST['nombreClienteDerechos'];
    $cargoClienteDerechos = $_POST['cargoClienteDerechos'];
    $nombreAsesorDerechos = $_POST['nombreAsesorDerechos'];
    $cargoAsesorDerechos = $_POST['cargoAsesorDerechos'];

    /**
     * / Comprueba si en documentosoficiales ya hay documento activo/inactivo, si ya se firmó o no se ha firmado , actualiza a activo "1", para volver a firmarlo, si no se ha generado ningún documento oficial, se inserta en la base de datos
     */

    $queryBorrarInformacionTemporal = "DELETE FROM informaciontemporaldocumentosoficiales WHERE idInmueble_InformacionTemporalDocumentosOficiales = $idInmueble AND NombreDocumento = 'CartaDerechos'";
    $consultaBorrarInformacionTemporal = mysqli_query($db, $queryBorrarInformacionTemporal);

    $queryComprobacionDocumento = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND NombreDocumentosOficial = 'CartaDerechos'";
    $consultaComprobacionDocumento = mysqli_fetch_assoc(mysqli_query($db, $queryComprobacionDocumento));



    if ($consultaComprobacionDocumento != NULL) {
        $idDocumentosOficiales = $consultaComprobacionDocumento['idDocumentosOficiales'];
        $queryActualizarDocumento = "UPDATE documentosoficiales SET Activo = 1 WHERE idDocumentosOficiales = $idDocumentosOficiales";
        $resultadoActualizarDocumento = mysqli_query($db, $queryActualizarDocumento);
    } else {
        $queryActualizarDocumento = "INSERT INTO documentosoficiales (NombreDocumentosOficial, idInmueble_DocumentosOficiales, Activo) VALUES ('CartaDerechos', $idInmueble, 1)";
        $resultadoActualizarDocumento = mysqli_query($db, $queryActualizarDocumento);
    }

    cartaDerechos($nombreClienteDerechos, $cargoClienteDerechos, $nombreAsesorDerechos, $cargoAsesorDerechos, $idInmueble, 'CartaDerechos');
}
 /**
  * * Activacion de documento Privacidad
  */
if (isset($_POST['activarPrivacidad'])) {
    /**
     * / Include del documento
     */
    include_once('DocumentosCanva/AvisoPrivacidad.php');

    /**
     * / Variables
     */
    $nombrePrivacidad = $_POST['nombrePrivacidad'];
    $domicilioPrivacidad = $_POST['domicilioPrivacidad'];
    $telefonoPrivacidad = $_POST['telefonoPrivacidad'];
    $rfcPrivacidad = $_POST['rfcPrivacidad'];
    $emailPrivacidad = $_POST['emailPrivacidad'];


    /**
     * / Borra la información temporal almacenada en la base de datos
     */
    
    $queryBorrarInformacionTemporal = "DELETE FROM informaciontemporaldocumentosoficiales WHERE idInmueble_InformacionTemporalDocumentosOficiales = $idInmueble AND NombreDocumento = 'AvisoPrivacidad'";
    $consultaBorrarInformacionTemporal = mysqli_query($db, $queryBorrarInformacionTemporal);
    
    /**
     * / Comprueba si en documentosoficiales ya hay documento activo/inactivo, si ya se firmó o no se ha firmado , actualiza a activo "1", para volver a firmarlo, si no se ha generado ningún documento oficial, se inserta en la base de datos
     */
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
 /**
  * * Activacion de documento ContratoPromesaCompraVenta
  */
if (isset($_POST['activarPromesa'])) {
    /**
     * / Include del documento
     */
    include_once('DocumentosCanva/ContratoPromesaCompraVenta.php');

    /**
     * / Variables
     */
    $nombrePropietarioPromesa = $_POST['nombrePropietarioPromesa'];
    $INEPropietarioPromesa = $_POST['INEPropietarioPromesa'];
    $domicilioPropietarioPromesa = $_POST['domicilioPropietarioPromesa'];
    $alcaldiaPropietarioPromesa = $_POST['alcaldiaPropietarioPromesa'];
    $CPPropietarioPromesa = $_POST['CPPropietarioPromesa'];
    $direccionInmueblePromesa = $_POST['direccionInmueblePromesa'];
    $alcaldiaInmueblePromesa = $_POST['alcaldiaInmueblePromesa'];
    $CPInmueblePromesa = $_POST['CPInmueblePromesa'];
    $numeroEscrituraPromesa = $_POST['numeroEscrituraPromesa'];
    $libroEscrituraPromesa = $_POST['libroEscrituraPromesa'];
    $fechaEscrituraPromesa = $_POST['fechaEscrituraPromesa'];
    $nombreLicenciadoPromesa = $_POST['nombreLicenciadoPromesa'];
    $numeroTitularPromesa = $_POST['numeroTitularPromesa'];
    $precioTotalPromesa = $_POST['precioTotalPromesa'];
    $cantidadTransferenciaPromesa = $_POST['cantidadTransferenciaPromesa'];
    $bancoReceptorPromesa = $_POST['bancoReceptorPromesa'];
    $numeroCuentaTransferenciaPromesa = $_POST['numeroCuentaTransferenciaPromesa'];
    $numeroCLABETransferenciaPromesa = $_POST['numeroCLABETransferenciaPromesa'];
    $nombreCuentahabientePromesa = $_POST['nombreCuentahabientePromesa'];
    $bancoHipotecaPromesa = $_POST['bancoHipotecaPromesa'];
    $superficieTerrenoPromesa = $_POST['superficieTerrenoPromesa'];
    $noreste1Promesa = $_POST['noreste1Promesa'];
    $noroeste1Promesa = $_POST['noroeste1Promesa'];
    $suroeste1Promesa = $_POST['suroeste1Promesa'];
    $sureste1Promesa = $_POST['sureste1Promesa'];
    $arriba1Promesa = $_POST['arriba1Promesa'];
    $abajo1Promesa = $_POST['abajo1Promesa'];
    $nombreCompradorPromesa = $_POST['nombreCompradorPromesa'];
    $INECompradorPromesa = $_POST['INECompradorPromesa'];
    $domicilioCompradorPromesa = $_POST['domicilioCompradorPromesa'];
    $alcaldiaCompradorPromesa = $_POST['alcaldiaCompradorPromesa'];
    $CPCompradorPromesa = $_POST['CPCompradorPromesa'];
    


    
    
    $queryBorrarInformacionTemporal = "DELETE FROM informaciontemporaldocumentosoficiales WHERE idInmueble_InformacionTemporalDocumentosOficiales = $idInmueble AND NombreDocumento = 'ContratoPromesaCompraVenta'";
    $consultaBorrarInformacionTemporal = mysqli_query($db, $queryBorrarInformacionTemporal);
    
    /**
     * / Comprueba si en documentosoficiales ya hay documento activo/inactivo, si ya se firmó o no se ha firmado , actualiza a activo "1", para volver a firmarlo, si no se ha generado ningún documento oficial, se inserta en la base de datos
     */
    $queryComprobacionDocumentoPrivacidad = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND NombreDocumentosOficial = 'ContratoPromesaCompraVenta'";
    $consultaComprobacionDocumentoPrivacidad = mysqli_fetch_assoc(mysqli_query($db, $queryComprobacionDocumentoPrivacidad));


    if ($consultaComprobacionDocumentoPrivacidad != NULL) {
        $idDocumentosOficiales = $consultaComprobacionDocumentoPrivacidad['idDocumentosOficiales'];
        $queryActualizarDocumentoPrivacidad = "UPDATE documentosoficiales SET Activo = 1 WHERE idDocumentosOficiales = $idDocumentosOficiales";
        $resultadoActualizarDocumentoPrivacidad = mysqli_query($db, $queryActualizarDocumentoPrivacidad);
    } else {
        $queryInsertarDocumentoPrivacidad = "INSERT INTO documentosoficiales (NombreDocumentosOficial, idInmueble_DocumentosOficiales, Activo) VALUES ('ContratoPromesaCompraVenta', $idInmueble, 1)";
        $resultadoInsertarDocumentoPrivacidad = mysqli_query($db, $queryInsertarDocumentoPrivacidad);
    }

    ContratoPromesaCompraVenta(
        $nombrePropietarioPromesa,
        $INEPropietarioPromesa,
        $domicilioPropietarioPromesa,
        $alcaldiaPropietarioPromesa,
        $CPPropietarioPromesa,
        $direccionInmueblePromesa,
        $alcaldiaInmueblePromesa,
        $CPInmueblePromesa,
        $numeroEscrituraPromesa,
        $libroEscrituraPromesa,
        $fechaEscrituraPromesa,
        $nombreLicenciadoPromesa,
        $numeroTitularPromesa,
        $precioTotalPromesa,
        $cantidadTransferenciaPromesa,
        $bancoReceptorPromesa,
        $numeroCuentaTransferenciaPromesa,
        $numeroCLABETransferenciaPromesa,
        $nombreCuentahabientePromesa,
        $bancoHipotecaPromesa,
        $superficieTerrenoPromesa,
        $noreste1Promesa,
        $noroeste1Promesa,
        $suroeste1Promesa,
        $sureste1Promesa,
        $arriba1Promesa,
        $abajo1Promesa,
        $nombreCompradorPromesa,
        $INECompradorPromesa,
        $domicilioCompradorPromesa,
        $alcaldiaCompradorPromesa,
        $CPCompradorPromesa,
        $idInmueble,
        'ContratoPromesaCompraVenta'
    );
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
        /**
         * * Declaración de variables para mostrar/ocultar los parámetros de cada documento
         */
        let privacidad = 1;
        let aceptacion = 1;
        let derechos = 1;
        let promesa = 1;


        /**
         * * Documento Privacidad
         */

        $('#editarPrivacidad').click(function(e) {
            e.preventDefault();

            privacidad++;
            if (privacidad % 2 == 0) {
                $('#acciones__firmaPrivacidad').after(
                    '<section class="parametros" id="parametrosPrivacidad">' +
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
                    $('#activarPrivacidad').removeClass("activarDisabled");
                    $('#activarPrivacidad').addClass("activarEnabled");
                    
            } else {
                $('#parametrosPrivacidad').remove();
                $('#activarPrivacidad').prop("disabled" , true);
                $('#activarPrivacidad').removeClass("activarEnabled");
                $('#activarPrivacidad').addClass("activarDisabled");
            }
        });

        /**
         * * Documento Aceptación
         */
        $('#editarAceptacion').click(function(e) {
            e.preventDefault();

            aceptacion++;
            if (aceptacion % 2 == 0) {
                $('#acciones__firmaAceptacion').after(
                    '<section class="parametros" id="parametrosAceptacion">' +
                    '<section>' +
                    '<span>Nombre del comprador</span>' +
                    '<input type="text" value="Sin nombre registrado" name="nombreCompradorAceptacion" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Ubicación del Inmueble</span>' +
                    '<input  type="text" value="<?php if($direccion != NULL){ echo ($direccion);} else {echo ("Sin ubicación registrada");}?>" name="ubicacionAceptacion" required>' +
                    '</section>' +
                    '</section>');
                    $('#activarAceptacion').prop("disabled" , false);
                    $('#activarAceptacion').removeClass("activarDisabled");
                    $('#activarAceptacion').addClass("activarEnabled");
                    
            } else {
                $('#parametrosAceptacion').remove();
                $('#activarAceptacion').prop("disabled" , true);
                $('#activarAceptacion').removeClass("activarEnabled");
                $('#activarAceptacion').addClass("activarDisabled");
            }
        });

        /**
         * * Documento Derechos
         */

         $('#editarDerechos').click(function(e) {
            e.preventDefault();

            derechos++;
            if (derechos % 2 == 0) {
                $('#acciones__firmaDerechos').after(
                    '<section class="parametros" id="parametrosDerechos">' +
                    '<section>' +
                    '<span>Nombre del Cliente</span>' +
                    '<input type="text" value="" name="nombreClienteDerechos" placeholder="Nombre Completo" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Cargo del Cliente</span>' +
                    '<input  type="text" name="cargoClienteDerechos" placeholder="..." required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Nombre del Asesor</span>' +
                    '<input type="text" value="" name="nombreAsesorDerechos" placeholder="Nombre Completo" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Cargo del Asesor</span>' +
                    '<input  type="text" name="cargoAsesorDerechos" placeholder="..." required>' +
                    '</section>' +
                    '</section>');
                    $('#activarDerechos').prop("disabled" , false);
                    $('#activarDerechos').removeClass("activarDisabled");
                    $('#activarDerechos').addClass("activarEnabled");
                    
            } else {
                $('#parametrosDerechos').remove();
                $('#activarDerechos').prop("disabled" , true);
                $('#activarDerechos').removeClass("activarEnabled");
                $('#activarDerechos').addClass("activarDisabled");
            }
        });
        /**
         * * Documento ContratoPromesaCompraVenta
         */

         $('#editarPromesa').click(function(e) {
            e.preventDefault();

            promesa++;
            if (promesa % 2 == 0) {
                $('#acciones__firmaPromesa').after(
                    '<section class="parametros" id="parametrosPromesa">' +
                    '<section>' +
                    '<span>Nombre del/la Propietario</span>' +
                    '<input type="text" value="<?php if($consultaCliente['Nombre'] != NULL){ echo ($consultaCliente['Nombre']);} else {echo ("Sin nombre registrado");}?>" name="nombrePropietarioPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>INE del Propietario</span>' +
                    '<input  type="text" name="INEPropietarioPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Domicilio del/la Propietario</span>' +
                    '<input  type="text" name="domicilioPropietarioPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Alcaldía donde recide el Propietario</span>' +
                    '<input  type="text" name="alcaldiaPropietarioPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>C.P. donde recide el Propietario</span>' +
                    '<input  type="text" name="CPPropietarioPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Dirección del Inmueble</span>' +
                    '<input  type="text" name="direccionInmueblePromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Alcaldía del Inmueble</span>' +
                    '<input  type="text" name="alcaldiaInmueblePromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>C.P. del Inmueble</span>' +
                    '<input  type="text" name="CPInmueblePromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Número de la Escritura Pública</span>' +
                    '<input  type="text" name="numeroEscrituraPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Libro de la Escritura pública</span>' +
                    '<input  type="text" name="libroEscrituraPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Fecha de la Ecritura</span>' +
                    '<input  type="date" name="fechaEscrituraPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Nombre del Licenciado, titular de la Notaria</span>' +
                    '<input  type="text" name="nombreLicenciadoPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Número del Titular de la Notaría Pública</span>' +
                    '<input  type="text" name="numeroTitularPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Precio Total del Inmueble</span>' +
                    '<input  type="number" name="precioTotalPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Cantidad que Será Enviada por Transferencia</span>' +
                    '<input  type="number" name="cantidadTransferenciaPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Banco Receptor para la Transferencia</span>' +
                    '<input  type="text" name="bancoReceptorPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Número de Cuenta para Transferencia</span>' +
                    '<input  type="text" name="numeroCuentaTransferenciaPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Número de CLABE Transferencia</span>' +
                    '<input  type="text" name="numeroCLABETransferenciaPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Nombre del Cuentahabiente para la Transferencia</span>' +
                    '<input  type="text" name="nombreCuentahabientePromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Nombre del Banco para Crédito Hipotecario</span>' +
                    '<input  type="text" name="bancoHipotecaPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Superficie de Terreno del Inmueble</span>' +
                    '<input  type="number" name="superficieTerrenoPromesa" value="<?php if($superficie_terreno != NULL){ echo ($superficie_terreno);} else {echo ("000");}?>"required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Noreste</span>' +
                    '<input  type="text" name="noreste1Promesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Noroeste</span>' +
                    '<input  type="text" name="noroeste1Promesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Suroeste</span>' +
                    '<input  type="text" name="suroeste1Promesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Sureste</span>' +
                    '<input  type="text" name="sureste1Promesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Arriba</span>' +
                    '<input  type="text" name="arriba1Promesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Abajo</span>' +
                    '<input  type="text" name="abajo1Promesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Nombre del/la Compradora</span>' +
                    '<input  type="text" name="nombreCompradorPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>INE del/la Comprador</span>' +
                    '<input  type="text" name="INECompradorPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Domicilio del/la comprador</span>' +
                    '<input  type="text" name="domicilioCompradorPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>Alcaldía donde recide el/la Comprador</span>' +
                    '<input  type="text" name="alcaldiaCompradorPromesa" required>' +
                    '</section>' +
                    '<section>' +
                    '<span>C.P. donde recide el/la Comprador</span>' +
                    '<input  type="text" name="CPCompradorPromesa" required>' +
                    '</section>' +
                    '</section>');
                    $('#activarPromesa').prop("disabled" , false);
                    $('#activarPromesa').removeClass("activarDisabled");
                    $('#activarPromesa').addClass("activarEnabled");
                    
            } else {
                $('#parametrosPromesa').remove();
                $('#activarPromesa').prop("disabled" , true);
                $('#activarPromesa').removeClass("activarEnabled");
                $('#activarPromesa').addClass("activarDisabled");
            }
        });
    });
</script>
<body>
    <header class="header__propiedades">
        <div>
            <section class="header__logo">
                <a href="#"><img src="../../../Assets/logo.png" alt=""></a>
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

                    <?php while ($rowOtrasCaracteristicas = mysqli_fetch_assoc($consultaOtrasCaracteristicas)) : ?>
                    <label for="otras" class="normal">
                        <span>Otras Características</span>
                        <p><?php echo $rowOtrasCaracteristicas['NombreAmenidades'];  ?></p>
                    </label>

                    <?php endwhile;?>
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
                        <p><a href=""></a><?php echo $ubicacion;  ?></p>
                    </label>
                    <label for="urlAnuncio" class="normal">
                        <span>URL del Anuncio</span>
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
                        </section>
                    </label>
                    <label for="descargar" class="input__firma">
                        <span>Aceptación de Seguimiento de Compra y Venta</span>
                        <section class="contenedor__firma">
                            <section class="acciones__firma" id="acciones__firmaAceptacion">
                                <button id="editarAceptacion" class="editar">Editar parámetros del PDF</button>
                                <input disabled id="activarAceptacion" type="submit" value="Activar PDF para firma" name="activarAceptacion" class="activarDisabled">
                                <a href="./DocumentosFirmados/aceptacionSeguimientoCompraVenta<?php echo($idInmueble . '.pdf')?>" class="<?php echo $classDescargarAceptacionCompraVenta ?>" download>Descargar PDF firmado</a>
                            </section>
                        </section>
                    </label>
                    <label for="descargar" class="input__firma">
                        <span>Aviso de Privacidad</span>
                        <section class="contenedor__firma">
                            <section class="acciones__firma" id="acciones__firmaPrivacidad">
                                <button id="editarPrivacidad" class="editar">Editar parámetros del PDF</button>
                                <input disabled id="activarPrivacidad" type="submit" value="Activar PDF para firma" name="activarPrivacidad" class="activarDisabled">
                                <a href="./DocumentosFirmados/AvisoPrivacidad<?php echo($idInmueble . '.pdf')?>" class="<?php echo $classDescargarPrivacidad ?>" download>Descargar PDF firmado</a>
                            </section>
                        </section>
                    </label>
                    <label for="descargar" class="input__firma">
                        <span>Carta de Derechos</span>
                        <section class="contenedor__firma">
                            <section class="acciones__firma" id="acciones__firmaDerechos">
                                <button id="editarDerechos" class="editar">Editar parámetros del PDF</button>
                                <input disabled id="activarDerechos" type="submit" value="Activar PDF para firma" name="activarDerechos" class="activarDisabled">
                                <a href="./DocumentosFirmados/CartaDerechos<?php echo($idInmueble . '.pdf')?>" class="<?php echo $classDescargarDerechos ?>" download>Descargar PDF firmado</a>
                            </section>
                        </section>
                    </label>
                    <label for="descargar" class="input__firma">
                        <span>Contarto de Promesa Compra-Venta</span>
                        <section class="contenedor__firma">
                            <section class="acciones__firma" id="acciones__firmaPromesa">
                                <button id="editarPromesa" class="editar">Editar parámetros del PDF</button>
                                <input disabled id="activarPromesa" type="submit" value="Activar PDF para firma" name="activarPromesa" class="activarDisabled">
                                <a href="./DocumentosFirmados/ContratoPromesaCompraVenta<?php echo($idInmueble . '.pdf')?>" class="<?php echo $classDescargarPromesa ?>" download>Descargar PDF firmado</a>
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