<?php
include_once('./includeFormatos.php');
// function aceptacionSeguimientoCompraVenta(
//     $idInmueble,
//     $nombreDocumento
// ) {

global $pdf;
global $db;

use Luecano\NumeroALetras\NumeroALetras;

$formatter = new NumeroALetras();
// if (file_exists('../DocumentosFirmados/AvisoPrivacidad' . $idInmueble . '.pdf')){
//     unlink('../DocumentosFirmados/AvisoPrivacidad' . $idInmueble . '.pdf');
// }
$pdf = new PDF();
$pdf->AddFont('Regular', '', 'Montserrat-Regular.php');
$pdf->AddFont('Bold', '', 'Montserrat-Bold.php');
$pdf->AddFont('Black', '', 'Montserrat-Black.php');

nuevaPagina();

/**
 * * Título del documento
 */
$pdf->SetY(55);
$pdf->SetX(66);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 13);
$pdf->Write(1, utf8_decode('Contrato promesa de compraventa'));
/**
 * * Línea debajo del titulo del documento
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(65, 59, 153, 59);
/**
 * * Cuerpo 1
 */
$pdf->SetY(65);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('Contrato de promesa de compraventa que celebran por una parte la SRA.'), 0, 'FJ', 1);

/**
 * * Línea arriba de la dirección
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 81, 190, 81);
/**
 * * Cuerpo 1.1
 */
$pdf->SetY(85);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('a quien en lo sucesivo del presente se les denominará como "LA PARTE VENDEDORA", quien se identifica con la INE número'), 0, 'FJ', 1);
/**
 * * Línea INE
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 113, 190, 113);
/**
 * * Cuerpo 1.2
 */
$pdf->SetY(120);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('y con domicilio en,'), 0, 'FJ', 1);
/**
 * * Línea para domicilio
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 138, 190, 138);
/**
 * * Cuerpo 1.3
 */
$pdf->SetY(146);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('alcaldía'), 0, 'FJ', 1);
/**
 * * Línea para alcaldía
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(38, 153, 190, 153);
/**
 * * Cuerpo 1.4
 */
$pdf->SetY(158);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode(',C.P.'), 0, 'FJ', 1);
/**
 * * Cuerpo 1.5
 */
$pdf->SetY(158);
$pdf->SetX(60);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(130, 10, utf8_decode('en la CDMX y por la otra parte la SRA.'), 0, 'FJ', false);
/**
 * * Línea C.P.
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(32, 165, 60, 165);
/**
 * * Línea Nombre Comprador
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 178, 190, 178);
/**
 * * Cuerpo 1.6
 */
$pdf->SetY(182);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('a quien en lo sucesivo y para efectos del presente contrato se le denominará como "LA PARTE COMPRADORA", quien se identifica con la INE número'), 0, 'FJ', false);
/**
 * * Línea Nombre Comprador
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 212, 190, 212);
/**
 * * Cuerpo 1.7
 */
$pdf->SetY(220);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('y con domicilio en'), 0, 'FJ', false);
/**
 * * Línea dirección 
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 238, 190, 238);


/**
 * + Página 2
 */
nuevaPagina();
/**
 * * Cuerpo 2.2
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('alcaldía'), 0, 'FJ', false);
/**
 * * Línea para alcaldía
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(38, 62, 190, 62);
/**
 * * Cuerpo 2.3
 */
$pdf->SetY(73);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode(',C.P.'), 0, 'FJ', false);
/**
 * * Cuerpo 2.4
 */
$pdf->SetY(73);
$pdf->SetX(60);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(130, 10, utf8_decode('en la CDMX, respecto del departamento marcado con dirección en'), 0, 'FJ', false);
/**
 * * Línea C.P.
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(32, 80, 60, 80);
/**
 * * Línea Dirección
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 93, 190, 93);
/**
 * * Cuerpo 2.5
 */
$pdf->SetY(105);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('alcaldía'), 0, 'FJ', 1);
/**
 * * Línea para alcaldía
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(38, 112, 190, 112);
/**
 * * Cuerpo 2.6
 */
$pdf->SetY(123);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode(',C.P.'), 0, 'FJ', false);
/**
 * * Cuerpo 2.7
 */
$pdf->SetY(123);
$pdf->SetX(60);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(130, 10, utf8_decode('en la CDMX, que en lo sucesivo se le denominará "EL INMUEBLE",'), 0, 'FJ', false);
/**
 * * Cuerpo 2.7.1
 */
$pdf->SetY(141);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('sujetándose a las siguientes declaraciones y cláusulas.'), 0, 'FJ', false);
/**
 * * Línea C.P.
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(32, 130, 60, 130);
/**
 * + Declaraciones
 */
/**
 * * Cuerpo 2.8
 */
$pdf->SetY(166);
$pdf->SetX(56);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 12);
$pdf->MultiCell(100, 10, utf8_decode('D E C L A R A C I O N E S'), 0, 'FJ', false);
/**
 * * Cuerpo 2.9
 */
$pdf->SetY(184);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 12, utf8_decode('PRIMERA. - "LA PARTE VENDEDORA" declara ser la legítima propietaria del inmueble ubicado en'), 0, 'FJ', false);
/**
 * * Línea para dirección
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(32, 203, 190, 203);
/**
 * * Cuerpo 2.9
 */
$pdf->SetY(212);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('cuya propiedad la acredita mediante la escritura pública número'), 0, 'FJ', false);
/**
 * * Línea para escritura pública
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 232, 190, 232);
/**
 * + Página 3 - Sección Declaraciones
 */
nuevaPagina();
/**
 * * Cuerpo 3.1
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('libro'), 0, 'FJ', false);
/**
 * * Línea para alcaldía
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(35, 62, 190, 62);
/**
 * * Cuerpo 3.2
 */
$pdf->SetY(73);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(20, 10, utf8_decode('de fecha'), 0, 'FJ', false);
/**
 * * Línea fecha
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(44, 80, 80, 80);
/**
 * * Cuerpo 3.2.1
 */
$pdf->SetY(73);
$pdf->SetX(82);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(110, 10, utf8_decode('otorgada ante la fé del licenciado'), 0, 'FJ', false);
/**
 * * Línea nombre licenciado
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 95, 190, 95);
/**
 * * Cuerpo 3.3
 */
$pdf->SetY(103);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(110, 10, utf8_decode('titular de la notaría pública número'), 0, 'FJ', false);
/**
 * * Línea número notaria publica
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(134, 110, 190, 110);
/**
 * * Cuerpo 3.3.1
 */
$pdf->SetY(121);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('de la CDMX.'), 0, 'FJ', false);
/**
 * * Cuerpo 3.4
 */
$pdf->SetY(135);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 15, utf8_decode('SEGUNDA. - "LA PARTE COMPRADORA" declara tener plena capacidad económica para celebrar el presente contrato de compraventa, así como declarar que la procedencia de los recursos provienen de actividades lícitas.'), 0, 'FJ', false);

/**
 * + Página 4
 */

nuevaPagina();
/**
 * * Cuerpo 4.1
 */
$pdf->SetY(55);
$pdf->SetX(70);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 12);
$pdf->MultiCell(80, 10, utf8_decode('C L A Ú S U L A S'), 0, 'FJ', false);
/**
 * * Cuerpo 4.2
 */
$pdf->SetY(73);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(48, 10, utf8_decode('PRIMERA. - La SRA/SR.'), 0, 'FJ', false);
/**
 * * Línea nombre vendedor
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(72, 80, 190, 80);
/**
 * * Cuerpo 4.3
 */
$pdf->SetY(91);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(48, 10, utf8_decode('vende y la SRA/SR.'), 0, 'FJ', false);
/**
 * * Línea nombre comprador
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(72, 98, 190, 98);
/**
 * * Cuerpo 4.4
 */
$pdf->SetY(109);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('compra el inmueble ubicado en:'), 0, 'FJ', false);
/**
 * * Línea nombre comprador
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 129, 190, 129);
/**
 * * Cuerpo 4.5
 */
$pdf->SetY(145);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('SEGUNDA. - El precio total de la compraventa que conviene "LA PARTE COMPRADORA" pagar por el citado inmueble es de'), 0, 'FJ', false);
/**
 * * Cuerpo 4.6
 */
$precioLetras = $formatter->toMoney(27530000, 2, 'PESOS', 'CENTAVOS');
$pdf->SetY(165);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$pdf->MultiCell(168, 10, '$' . utf8_decode(number_format(27530000) . " (" . $precioLetras . " 0/100 M.N.),"), 0, 'FJ', false);
/**
 * * Línea precio
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 173, 190, 173);
/**
 * * Cuerpo 4.7
 */
$pdf->SetY(189);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(160, 10, utf8_decode('que "LA PARTE COMPRADORA" pagará a "LA PARTE VENDEDORA" de la siguiente manera: la cantidad de'), 0, 'FJ', false);
/**
 * * Cuerpo 4.8
 */
$precioLetras = $formatter->toMoney(27530000, 2, 'PESOS', 'CENTAVOS');
$pdf->SetY(211);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$pdf->MultiCell(168, 10, '$' . utf8_decode(number_format(27530000) . " (" . $precioLetras . " 0/100 M.N.),"), 0, 'FJ', false);
/**
 * * Línea precio
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 219, 190, 219);
/**
 * * Cuerpo 4.9
 */
$pdf->SetY(229);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('mediante transferencia bancaria a la firma del presente contrato a la cuenta'), 0, 'FJ', false);

/**
 * + Página 5
 */
nuevaPagina();
/**
 * * Línea cuenta
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 63, 92, 63);
/**
 * * Línea numero
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(112, 63, 190, 63);
/**
 * * Cuerpo 5.1
 */
$pdf->SetY(55);
$pdf->SetX(93);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('número'), 0, 'FJ', false);
/**
 * * Cuerpo 5.2
 */
$pdf->SetY(73);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('con clabe interbancaria número'), 0, 'FJ', false);
/**
 * * Línea número
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 95, 190, 95);
/**
 * * Cuerpo 5.3
 */
$pdf->SetY(105);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('a nombre de'), 0, 'FJ', false);
/**
 * * Línea nombre
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 125, 190, 125);
/**
 * * Cuerpo 5.4
 */
$pdf->SetY(135);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('y el resto sera cubierto una parte por medio de un crédito hipotecario de banco'), 0, 'FJ', false);

/**
 * * Línea banco
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 155, 190, 155);
/**
 * * Cuerpo 5.4
 */
$pdf->SetY(165);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 12, utf8_decode('y otra parte con recursos propios por medio de transferencia bancaria a la misma cuenta el día de la firma de la escritura correspondiente.

Se establece un plazo máximo para la firma de escritura de 120 días hábiles a partir de la autorización del crédito señalado en el párrafo precedente, con referencia a la citación que la notaría correspondiente realice para la protocolización.'), 0, 'FJ', false);


/**
 * + Página 6
 */
nuevaPagina();

/**
 * * Cuerpo 6.1
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('TERCERA. - El objeto de este contrato de compraventa es la venta del inmueble ubicado en:'), 0, 'FJ', false);
/**
 * * Línea dirección inmueble
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 75, 190, 75);
/**
 * * Cuerpo 6.2
 */
$pdf->SetY(85);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(100, 10, utf8_decode('con una superficie de terreno de:'), 0, 'FJ', false);
/**
 * * Línea supTerreno
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(125, 92, 190, 92);
/**
 * * Cuerpo 6.2.1
 */
$pdf->SetY(85);
$pdf->SetX(127);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$pdf->MultiCell(30, 10, utf8_decode(number_format(100.83)) . ' m2', 0, 'FJ', false);
/**
 * * Línea supTerreno en palabras
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(22, 105, 190, 105);
/**
 * * Cuerpo 6.3
 */
$pdf->SetY(97);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$supTerreno = $formatter->toWords(100.83) . ' METROS CUADRADOS';
$pdf->MultiCell(168, 10, utf8_decode('(' . $supTerreno . '),'), 0, 'FJ', false);
/**
 * * Cuerpo 6.4
 */
$pdf->SetY(110);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 12, utf8_decode('no habiendo lugar a reclamación por ninguna de las dos partes en caso de variaciones a favor o en contra con relación al precio acordado y/o validez de este contrato.
y con las siguientes medidas y colindancias:'), 0, 'FJ', false);
/**
 * * Cuerpo 6.5
 */
$pdf->SetY(145);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(40, 12, utf8_decode('AL NORESTE:
AL NOROESTE:
AL SUROESTE:
AL SURESTE:
AL SUROESTE:
AL SURESTE:
AL NORESTE:
AL SURESTE:
AL SUROESTE:'), 0, 'L', false);

/**
 * + Página 7
 */
nuevaPagina();
/**
 * * Cuerpo 7.1
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(40, 12, utf8_decode('AL NORESTE:
AL SURESTE:
AL NORESTE:
AL SURESTE:
AL NORESTE:
AL NOROESTE:
ARRIBA:
ABAJO:'), 0, 'L', false);
/**
 * * Cuerpo 7.2
 */
$pdf->SetY(155);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 12, utf8_decode('CUARTO. - "LA PARTE VENDEDORA" se obliga a entregar el citado inmueble libre de todo gravamen, al corriente en el pago de servicios de agua, luz, cuotas de mantenimiento del fraccionamiento, predial y todos los servicios correspondientes al inmueble.
"LA PARTE VENDEDORA" se hará responsable por el saneamiento en caso de evicción.
QUINTA. - "LA PARTE COMPRADORA" se obliga a asumir los gastos de escrituración y "LA PARTE VENDEDORA" se obliga a realizar el pago del impuesto sobre la renta que se pudiera generar de esta operación y que en su caso le corresponda.'), 0, 'FJ', false);

/**
 * + Página 8
 */
nuevaPagina();
/**
 * * Cuerpo 8.1
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 12, utf8_decode('SEXTA. - "AMBAS PARTES" acuerdan una pena convencional del 10% (diez por ciento) del precio de la presente compraventa, en caso de que alguna de las partes no cumpla con las obligaciones que asume en este contrato de compraventa.

En caso de incumplimiento por "LA PARTE VENDEDORA" esta se obliga a devolver los montos recibidos como anticipo más la pena convencional y en caso de incumplimiento de “la parte compradora” autoriza que de los anticipos se descuente la pena convencional y se le devolverá el restante. en caso de que los anticipos no alcancen a cubrir la pena "LA PARTE COMPRADORA" deberá cubrir el faltante.

En caso de aplicar alguna pena convencional para alguna de las partes se establece un máximo de tres días hábiles para el pago de esta, así como la devolución de excedentes que diera lugar. en caso contrario se aplicará un interés del 10% mensual sobre la pena convencional y/o excedentes a devolver.'), 0, 'FJ', false);

/**
 * + Página 9
 */
nuevaPagina();
/**
 * * Cuerpo 9.1
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 12, utf8_decode('SÉPTIMA. - La posesión material del inmueble se entregará a "LA PARTE COMPRADORA" al momento en que se acredite la liquidación total del precio convenido y se firme la escritura pública respectiva, debido a que es una propiedad no nueva se entregará bajo la premisa "AD CORPUS".

OCTAVA. - "AMBAS PARTES" convienen que para la interpretación y cumplimiento de este contrato de compraventa se somete a la jurisdicción de los tribunales de la Ciudad de México.

NOVENA. - "AMBAS PARTES" señalan como domicilio para oír y recibir toda clase de notificaciones, emplazamientos o cualquier otro efecto legal, los antes mencionados en este contrato de compraventa.

DÉCIMA. - "AMBOS CONTRATANTES" declaran bajo protesta de decir verdad que tienen capacidad jurídica para contraer derechos y obligaciones, así mismo que en el presente contrato no existe ningún vicio, error, dolo o mala fe que pueda anularlo.'), 0, 'FJ', false);
/**
 * + Página 10
 */
nuevaPagina();
/**
 * * Cuerpo 10.1
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 12, utf8_decode('DÉCIMA PRIMERA. - "AMBAS PARTES" acuerdan que en caso de controversia entre las mismas eximen a la inmobiliaria y/o sus asesores de cualquier responsabilidad por saber ambas que su actividad es de mediador mercantil exclusivamente.

DÉCIMA SEGUNDA. - "AMBAS PARTES" en este contrato declaran haberlo leído en su integridad y estar conformes con su contenido.

Firmado, en la Ciudad de México a las XX:XX pm del día XXX 17 del mes de XXXXXX del año 20XX, en tres tantos.'), 0, 'FJ', false);

/**
 * + Sección: Firma de recibido
 */

/**
 * * Texto: Firma de recibido
 */
$pdf->SetY(170);
$pdf->SetX(36);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('"LA PARTE VENDEDORA"'));

/**
 * * Botón "recibido" para firmar digitalmente
 */
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect(35, 190, 46, 10, 'FD');
// $pdf->Link(82, 200, 46, 10, 'https://unikabienesraices.com/Canva/index.php?id=' . $idInmueble . '&document=' . $nombreDocumento);
$pdf->SetY(195);
$pdf->SetX(37);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Bold', '', 10);
$pdf->Write(1, utf8_decode('Click aquí para firmar'));

/**
 * * Línea para Botón "recibido"
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->Line(35, 200, 81, 200);

/**
 * * Texto: Nombre:
 */
$pdf->SetY(209);
$pdf->SetX(49);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Nombre:'));

/**
 * * Texto: Nombre del asesor
 */
$pdf->SetY(217);
$pdf->SetX(35);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->MultiCell(46, 10, utf8_decode('José Antonio Medina Martinez'), 0, 'FJ', false);
/**
 * * Línea 1 para Nombre:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(35, 227, 81, 227);
/**
 * * Línea 2 para Nombre:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(35, 237, 81, 237);
/**
 * + Sección: Firma de entrega
 */
/**
 * * Texto: Firma de entrega
 */
$pdf->SetY(170);
$pdf->SetX(119);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('"LA PARTE COMPRADORA"'));

/**
 * * Botón "recibido" para firmar digitalmente
 */
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect(119, 190, 46, 10, 'FD');
// $pdf->Link(82, 200, 46, 10, 'https://unikabienesraices.com/Canva/index.php?id=' . $idInmueble . '&document=' . $nombreDocumento);
$pdf->SetY(195);
$pdf->SetX(121);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Bold', '', 10);
$pdf->Write(1, utf8_decode('Click aquí para firmar'));

/**
 * * Línea para Botón "recibido"
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->Line(119, 200, 165, 200);

/**
 * * Texto: Nombre:
 */
$pdf->SetY(209);
$pdf->SetX(135);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Nombre:'));

/**
 * * Texto: Nombre del asesor
 */
$pdf->SetY(217);
$pdf->SetX(119);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->MultiCell(46, 10, utf8_decode('José Antonio Medina Martinez'), 0, 'FJ', false);
/**
 * * Línea 1 para Nombre:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(119, 227, 165, 227);
/**
 * * Línea 2 para Nombre:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(119, 237, 165, 237);


// $queryInsertarEnTablaTemporal = "INSERT INTO informaciontemporaldocumentosoficiales (NombreCliente, Domicilio, Telefono, RFC, Correo, idInmueble_InformacionTemporalDocumentosOficiales, NombreDocumento) VALUES ('$nombrePrivacidad', '$domicilioPrivacidad', '$telefonoPrivacidad', '$rfcPrivacidad', '$emailPrivacidad', $idInmueble, '$nombreDocumento')";
// mysqli_query($db, $queryInsertarEnTablaTemporal);
$name = $pdf->SetTitle('aceptacionSeguimientoCompraVenta.pdf');
$pdf->Output('I', 'aceptacionSeguimientoCompraVenta.pdf');
