<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

// Si trae id
if ($this->uri->segment(3)) {
	// Obliga a ventana emergente
	$ventana = "I";

	// Consulta los datos de la solicitud
	$solicitud = $this->solicitud_model->ver($this->uri->segment(3));
} else {
	// Obliga a descarga
	// $ventana = "I";
	$ventana = "D";

	// Arreglo vacío
	$solicitud = array();
} // if

// Consulta de los métodos de recepción
$formas = $this->solicitud_model->cargar_formas_recepcion();

// Consulta de lugares de recepción
$lugares = $this->solicitud_model->cargar_lugares_recepcion();

// Consulta de tipos de solicitudes
$tipos = $this->solicitud_model->cargar_tipos_solicitud();

// Consulta de tipos de documento
$tipos_documentos = $this->solicitud_model->cargar_tipos_documentos();

// Se totalizan los tipos consultados para, posteriormente, recorrerlos en el formulario
$total_tipos = count($formas) + count($lugares) + count($tipos);

/*
 * Clase PDF
 */
class PDF extends FPDF{
	/*
	 * Cabecera del reporte
	 */
	function Header(){
	    //Fuente
	    $this->SetFont('Arial','',12);

	    // Logo ANI
	    $this->Cell( 37, 36, $this->Image('../gestion_ambiental/img/logo_ani.jpg', $this->GetX()+2, $this->GetY()+4, 33.78), 1, 0, 'C', false );
	    
	    $this->setX(47);
	    $this->MultiCell(85,9, utf8_decode('PROYECTO CONCESIÓN VÍAS DEL NUS VINUS'),1,'C');
	    $this->setX(47);
	    $this->MultiCell(85,9, utf8_decode('RECEPCIÓN DE PETICIONES, QUEJAS, RECLAMOS Y SUGERENCIAS'),1,'C');
	    
	    // Logo Vinus
	    $this->setXY(132, 5);
	    $this->Cell( 30, 36, $this->Image('../gestion_ambiental/img/logo2.png', $this->GetX()+2, $this->GetY()+2, 25), 1, 0, 'C', false );

	    // Versión
	    $this->SetFont('Arial','',10);
	    $this->Cell(44,12, utf8_decode('Código: GCSP-F-134'),1,1,'C');
	    $this->setX(162);
	    $this->Cell(44,12, utf8_decode('Versión 1.01'),1,1,'C');
	    $this->setX(162);
	    $this->Cell(44,12, utf8_decode('Fecha: 29/04/2016'),1,0,'C');
	    
	    // Salto de línea
	    $this->Ln(20);
	}//Fin header

	/*
	 * Pie de pagina
	 */
	function Footer(){
		//Color negro
		$this->SetTextColor(0,0,0);
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Se define la fuente del footer
	    $this->SetFont('Arial','',8);
	    // Número de página
	    $this->Cell(0,10, utf8_decode('Sistema de gestión Social - Página').$this->PageNo().' de {nb}',0,0,'R');
	}
}//Fin PDF

/*
 * 
 * Informacion del reporte
 * 
 */
// Creacion del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

//Alias para el numero de paginas(numeracion)
$pdf->AliasNbPages();

//Se definen las margenes
$pdf->SetMargins(10, 5, 6);

//Anadir pagina
$pdf->AddPage();

//Parametros adicionales
$pdf->SetAuthor('John Arley Cano - VINUS S.A.S.');
$pdf->SetTitle('John Arley Cano - VINUS S.A.S.');
$pdf->SetCreator('John Arley Cano - VINUS S.A.S.');

//Fuente
$fuente = 'Arial';

// Si trae una solicitud
if (isset($solicitud->Pk_Id_Solicitud)) {
	$tamanio_observacion = 6;
	$tamanio_columna_inicial = 196/3;

	// Consulta las variables
	$fecha = $this->auditoria_model->formato_fecha($solicitud->Fecha_Creacion);
	$radicado_entrada = $solicitud->Radicado_Entrada;
	$nombres = $solicitud->Nombres;
	$documento = $solicitud->Documento;
	$direccion = $solicitud->Direccion;
	$telefono = $solicitud->Telefono;
	$municipio = $solicitud->Municipio;
	$sector = $solicitud->Sector;
	$email = $solicitud->Email;
	$descripcion = $solicitud->Descripcion_Solicitud;
} else {
	$tamanio_observacion = 45;
	$tamanio_columna_inicial = 196/2;

	// Variables vacías
	$fecha = "";
	$radicado_entrada = "";
	$nombres = "";
	$documento = "";
	$direccion = "";
	$telefono = "";
	$municipio = "";
	$sector = "";
	$email = "";
	$descripcion = "";
} // if

// Si trae una solicitud
$pdf->SetFont($fuente,'B',10);
if (isset($solicitud->Pk_Id_Solicitud)) {
	// Número de solicitud
	$pdf->Cell($tamanio_columna_inicial,6, utf8_decode('Solicitud '.$this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud)),1, 0, 'L', 0);
} // if

// Información general 1
$pdf->SetFont($fuente,'',10);
$pdf->Cell($tamanio_columna_inicial,6, utf8_decode('Fecha: '.$fecha),1, 0, 'L', 0);
$pdf->Cell($tamanio_columna_inicial,6, utf8_decode('Radicado de ingreso: '.$radicado_entrada),1, 0, 'L', 0);

$pdf->Ln(10);

// Información general 2
$pdf->SetFont($fuente,'',10);
$pdf->Cell((196 / $total_tipos) * count($formas), 6, utf8_decode('Método de recepción'),1, 0, 'L', 0);
$pdf->Cell((196 / $total_tipos) * count($lugares), 6, utf8_decode('Lugar de recepción'),1, 0, 'L', 0);
$pdf->Cell((196 / $total_tipos) * count($tipos), 6, utf8_decode('Tipo de solicitud'),1, 0, 'L', 0);
$pdf->Ln();

// Recorrido de las formas de recepción
foreach ($formas as $forma) {
	// Si la forma escogida es igual a la que tiene la solicitud
	if (isset($solicitud->Fk_Id_Recepcion_Forma) && $solicitud->Fk_Id_Recepcion_Forma == $forma->Pk_Id_Recepcion_Forma) {
		$check = "_X_";
	} else {
		$check = "___";
	} // if

	// Formas de recepción
	$pdf->Cell(196 / $total_tipos,6, utf8_decode($forma->Abreviatura." ".$check),1, 0, 'L', 0);
} // foreach formas

// Recorrido de los lugares de recepción
foreach ($lugares as $lugar) {
	// Si la forma escogida es igual a la que tiene la solicitud
	if (isset($solicitud->Fk_Id_Lugar_Recepcion) && $solicitud->Fk_Id_Lugar_Recepcion == $lugar->Pk_Id_Recepcion_Lugar) {
		$check = "_X_";
	} else {
		$check = "___";
	} // if

	// Lugares de recepción
	$pdf->Cell(196 / $total_tipos,6, utf8_decode($lugar->Abreviatura.$check),1, 0, 'L', 0);
} // foreach lugares

// Recorrido de los tipos de recepción
foreach ($tipos as $tipo) {
	// Si la forma escogida es igual a la que tiene la solicitud
	if (isset($solicitud->Fk_Id_Solicitud_Tipo) && $solicitud->Fk_Id_Solicitud_Tipo == $tipo->Pk_Id_Solicitud_Tipo) {
		$check = "_X_";
	} else {
		$check = "___";
	} // if

	// Lugares de recepción
	$pdf->Cell(196 / $total_tipos,6, utf8_decode($tipo->Abreviatura.$check),1, 0, 'L', 0);
} // foreach tipos
$pdf->Ln();

// Información general 3
$pdf->Cell(196, 6, utf8_decode('Nombre del solicitante: '.$nombres),1, 1, 'L', 0);
$pdf->Cell(46, 6, utf8_decode('Tipo de documento:'),1, 0, 'L', 0);

// Recorrido de los tipos de documento
foreach ($tipos_documentos as $tipo_documento) {
	// Si la forma escogida es igual a la que tiene la solicitud
	if (isset($solicitud->Fk_Id_Documento_Tipo) && $solicitud->Fk_Id_Documento_Tipo == $tipo_documento->Pk_Id_Documento_Tipo) {
		$check = "_X_";
	} else {
		$check = "___";
	} // if

	// Tipos de documento
	$pdf->Cell(80 / count($tipos_documentos),6, utf8_decode($tipo_documento->Abreviatura.$check),1, 0, 'L', 0);
} // foreach tipos

$pdf->Cell(70, 6, utf8_decode('Nro.: '.$documento),1, 1, 'L', 0);
$pdf->Cell(80, 6, utf8_decode('Dirección: '.$direccion),1, 0, 'L', 0);
$pdf->Cell(40, 6, utf8_decode('Teléfono: '.$telefono),1, 0, 'L', 0);
$pdf->Cell(76, 6, utf8_decode('Municipio: '.$municipio),1, 1, 'L', 0);
$pdf->Cell(196, 6, utf8_decode('Correo electrónico: '.$email),1, 1, 'L', 0);
$pdf->Cell(196, 6, utf8_decode('Lugar de residencia: '.$sector),1, 1, 'L', 0);
$pdf->Ln();

// Información general 3
$pdf->Cell(196, 6, utf8_decode('Asunto:'),0, 1, 'L', 0);
$pdf->MultiCell(196,$tamanio_observacion, utf8_decode($descripcion), 1, 'L');
$pdf->Cell(196, 6, utf8_decode('Anexos:'),1, 1, 'L', 0);
$pdf->Ln();

// Firma solicitante
$pdf->SetFont('Arial', '', 12);
$pdf->SetY($pdf->GetY() + 15);
$pdf->Cell(60,6, utf8_decode('__________________________'),0,1,'C');
$pdf->Cell(60,6, utf8_decode('Firma del solicitante'),0,0,'C');

//Espacio para el radicado
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(146, $pdf->GetY()-20);
$pdf->SetTextColor(159,148,148);
$pdf->Cell(60,25, utf8_decode('Sticker radicado Orfeo'),1,1,'C');

// Datos profesionales
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(98, 6, utf8_decode('Profesional social concesionario'),0, 0, 'L', 0);
$pdf->Cell(98, 6, utf8_decode('Profesional social intenventoría'),0, 1, 'L', 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(98, 6, utf8_decode('Nombre:'),1, 0, 'L', 0);
$pdf->Cell(98, 6, utf8_decode('Nombre:'),1, 1, 'L', 0);
$pdf->Cell(98, 6, utf8_decode('Firma:'),1, 0, 'L', 0);
$pdf->Cell(98, 6, utf8_decode('Firma:'),1, 1, 'L', 0);
$pdf->Cell(98, 6, utf8_decode('Cédula:'),1, 0, 'L', 0);
$pdf->Cell(98, 6, utf8_decode('Cédula:'),1, 1, 'L', 0);
$pdf->Cell(98, 6, utf8_decode('Fecha de revisión:'),1, 0, 'L', 0);
$pdf->Cell(98, 6, utf8_decode('Fecha de revisión:'),1, 1, 'L', 0);
$pdf->Ln(4);

// Convenciones
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(98, 4, utf8_decode('Convenciones:'),0, 1, 'L', 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Medio de recepción:'),0, 0, 'L', 0);
// Recorrido de las formas de recepción
$pdf->SetFont('Arial', '', 8);
foreach ($formas as $forma) {
	// Formas de recepción
	$pdf->Cell((strlen($forma->Nombre)+2)*2.2, 4, utf8_decode($forma->Abreviatura." - ".$forma->Nombre),0, 0, 'L', 0);
} // foreach formas
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Lugar de recepción:'),0, 0, 'L', 0);
// Recorrido de los lugares de recepción
$pdf->SetFont('Arial', '', 8);
foreach ($lugares as $lugar) {
	// Lugares de recepción
	$pdf->Cell((strlen($lugar->Nombre)+2)*2.2, 4, utf8_decode($lugar->Abreviatura." - ".$lugar->Nombre),0, 0, 'L', 0);
} // foreach lugares
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 4, utf8_decode('Tipo de recepción:'),0, 0, 'L', 0);
// Recorrido de los tipos de recepción
$pdf->SetFont('Arial', '', 8);
foreach ($tipos as $tipo) {
	// Tipos de recepción
	$pdf->Cell((strlen($tipo->Nombre)+2)*2.2, 4, utf8_decode($tipo->Abreviatura." - ".$tipo->Nombre),0, 0, 'L', 0);
} // foreach tipos
$pdf->Ln();

//Se imprime el Reporte
$pdf->Output('Recepción de solicitud.pdf', $ventana);
?>