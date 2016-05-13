<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

// Se consulta la información de la solicitud
$solicitud = $this->solicitud_model->ver($id_solicitud);
$seguimientos = $this->solicitud_model->ver_seguimientos($id_solicitud);

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
	    $this->MultiCell(85,9, utf8_decode('SEGUIMIENTO DE PETICIONES, QUEJAS, RECLAMOS Y SUGERENCIAS'),1,'C');
	    
	    // Logo Vinus
	    $this->setXY(132, 5);
	    $this->Cell( 30, 36, $this->Image('../gestion_ambiental/img/logo2.png', $this->GetX()+2, $this->GetY()+2, 25), 1, 0, 'C', false );

	    // Versión
	    $this->SetFont('Arial','',10);
	    $this->Cell(44,12, utf8_decode('Código: GCSP-F-135'),1,1,'C');
	    $this->setX(162);
	    $this->Cell(44,12, utf8_decode('Versión 1.00'),1,1,'C');
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

// Información general 1
$pdf->SetFont($fuente,'B',10);
$pdf->Cell(50,6, utf8_decode('Solicitud '.utf8_decode($this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud))),1, 0, 'L', 0);
$pdf->SetFont($fuente,'',10);
$pdf->Cell(50,6, utf8_decode('Fecha: '.utf8_decode($this->auditoria_model->formato_fecha($solicitud->Fecha_Creacion))),1, 0, 'L', 0);

// Datos de remisión
$pdf->Cell(96,6, utf8_decode('Radicado de ingreso: '.$solicitud->Radicado_Entrada),1, 0, 'L', 0);
$pdf->Ln(10);
$pdf->Cell(98,6, utf8_decode('Área responsable del trámite: '.$solicitud->Area_Encargada),1, 0, 'L', 0);
$pdf->Cell(98,6, utf8_decode('Fecha de remisión: '.$this->auditoria_model->formato_fecha($solicitud->Fecha_Remision)),1, 0, 'L', 0);
$pdf->Ln(10);
$pdf->SetFont($fuente,'B',10);
$pdf->Cell(40,6, utf8_decode('Avance en el trámite:'),0, 0, 'L', 0);
$pdf->SetFont($fuente,'',10);
$pdf->Cell(98,6, utf8_decode($solicitud->Accion_Emprendida),0, 1, 'L', 0);
$pdf->MultiCell(196,6, utf8_decode($solicitud->Descripcion_Accion), 1, 'L');

//Si hay remision
if ($solicitud->Pk_Id_Remision) {
	$pdf->MultiCell(196,6, utf8_decode("Datos de remisión: {$solicitud->Funcionario} ({$solicitud->Cargo} de {$solicitud->Empresa}) el {$this->auditoria_model->formato_fecha($solicitud->Fecha_Remision)} con radicado {$solicitud->Radicado_Remision}."), 1, 'L');
	$pdf->MultiCell(196,6, utf8_decode("s"), 1, 'L');
} // if

//Si hay seguimientos
if($seguimientos){
	//Se declara la numeracion de los seguimientos
	$numero = 1;

	//Si tiene seguimientos, los muestra
	foreach ($seguimientos as $seguimiento) {
		$pdf->MultiCell(196,6, utf8_decode("Seguimiento {$numero}: {$seguimiento->Descripcion}"), 1, 'L');

		//Se aumenta el contador
		$numero++;
	} // foreach seguimientos
} // if
$pdf->Ln();

// Si la solicitud está cerrada
if ($solicitud->Fk_Id_Solicitud_Estado != 1) {
 	$fecha = $this->auditoria_model->formato_fecha($solicitud->Fecha_Cierre);
 	$radicado_respuesta = $solicitud->Radicado_Respuesta;
} else {
	$fecha = "";
	$radicado_respuesta = "";
} // if

// Respuesta
$pdf->Cell(50,6, utf8_decode("Fecha de respuesta: "),1, 0, 'L', 0);
$pdf->Cell(48,6, utf8_decode($fecha),1, 0, 'L', 0);
$pdf->Cell(50,6, utf8_decode("Radicado de salida: "),1, 0, 'L', 0);
$pdf->Cell(48,6, utf8_decode($radicado_respuesta),1, 1, 'L', 0);

// Respuesta
$pdf->Cell(148,6, utf8_decode("Respuesta recibida a satisfacción por el peticionario: "),1, 0, 'L', 0);
$pdf->Cell(24,6, utf8_decode("Si ____"),1, 0, 'L', 0);
$pdf->Cell(24,6, utf8_decode("No ____"),1, 1, 'L', 0);
$pdf->Cell(148,6, utf8_decode("Estado del requerimiento: "),1, 0, 'L', 0);

// Si está solucionado
if ($solicitud->Fk_Id_Solicitud_Estado == 1) {
	$pdf->Cell(24,6, utf8_decode("Abierto _X_"),1, 0, 'L', 0);
	$pdf->Cell(24,6, utf8_decode("Cerrado ___"),1, 0, 'L', 0);
} else {
	$pdf->Cell(24,6, utf8_decode("Abierto ___"),1, 0, 'L', 0);
	$pdf->Cell(24,6, utf8_decode("Cerrado _X_"),1, 0, 'L', 0);
} // if

$pdf->Ln(10);
$pdf->MultiCell(196,6, utf8_decode("Observaciones"), 0, 'L');
$pdf->MultiCell(196,6, utf8_decode($solicitud->Descripcion_Respuesta), 1, 'L');
$pdf->Cell(196, 6, utf8_decode('Anexos:'),1, 1, 'L', 0);

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


//Se imprime el Reporte
$pdf->Output('Solicitud '.$this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud).'.pdf', 'I');