<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

/*
 * Clase PDF
 */
class PDF extends FPDF{
	/*
	 * Cabecera del reporte
	 */
	function Header(){
	    //Fuente
	    $this->SetFont('Arial','',10);
	    
	    //Logo
	    $this->Image('../gestion_ambiental/img/logo2.png', 10, 9);

	    //Titulo
	    $this->SetFont('Arial', 'B');
	    $this->setXY(50, 11);
	    $this->MultiCell(100,6, utf8_decode('ATENCIÓN DE SOLICITUDES COMUNITARIAS      GESTIÓN SOCIAL  Y AMBIENTAL'),0,'C');
	    
	    //Espacio para el radicado
	    $this->setXY(150, 5);
	    $this->SetFont('Arial', '', 12);
	    $this->SetTextColor(159,148,148);
	    $this->Cell(60,24, utf8_decode('Sticker radicado Orfeo'),1,0,'C');
	    
	    // Salto de línea
	    $this->Ln(26);
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
	    $this->Cell(0,10, utf8_decode('Sistema de gestión Socio - Ambiental - Página').$this->PageNo().' de {nb}',0,0,'R');
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

//Fuente
$fuente = 'Arial';
$backgroundColor = array('r' => '159', 'g' => '148', 'b' => '148');
//Color de relleno de las celdas de titulos
$pdf->setFillColor($backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']); 

//Parametros adicionales
$pdf->SetAuthor('John Arley Cano - Hatovial S.A.S.');
$pdf->SetTitle('John Arley Cano - Hatovial S.A.S.');
$pdf->SetCreator('John Arley Cano - Hatovial S.A.S.');

//Informacion general 1
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(40,6, utf8_decode('Número de Solicitud'),1, 0, 'C', 1);
$pdf->Cell(50,6, utf8_decode('Proyecto'),1, 0, 'C', 1);
$pdf->Cell(50,6, utf8_decode('Unidad Funcional'),1, 0, 'C', 1);
$pdf->Cell(40,6, utf8_decode('Fecha'),1, 0, 'C', 1);
$pdf->Cell(20,6, utf8_decode('Hora'),1, 0, 'C', 1);
$pdf->Ln();

//Contenido informacion general 1
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->Cell(40,6, '',1, 0, 'L');
$pdf->Cell(50,6, substr(utf8_decode('Vías del Nus'), 0, 33),1, 0, 'L');
$pdf->Cell(50,6, '',1, 0, 'L');
$pdf->Cell(40,6, '',1, 0, 'L');
$pdf->Cell(20,6, '',1, 0, 'L');
$pdf->Ln(10);

//Informacion general 2
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(70,6, utf8_decode('Nombres y apellidos del solicitante'),1, 0, 'C', 1);
$pdf->Cell(25,6, utf8_decode('Teléfono'),1, 0, 'C', 1);
$pdf->Cell(50,6, utf8_decode('Dirección'),1, 0, 'C', 1);
$pdf->Cell(55,6, utf8_decode('Lugar'),1, 0, 'C', 1);
$pdf->Ln();


//Contenido informacion general 2
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->Cell(70,6, '',1, 0, 'L');
$pdf->Cell(25,6, '',1, 0, 'R');
$pdf->Cell(50,6, '',1, 0, 'L');
$pdf->Cell(55,6, '',1, 0, 'L');
$pdf->Ln(10);

//Informacion general 3
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(40,6, utf8_decode('Tipo de solicitud'),1, 0, 'C', 1);
$pdf->Cell(40,6, utf8_decode('Forma de recepción'),1, 0, 'C', 1);
$pdf->Cell(40,6, utf8_decode('Área encargada'),1, 0, 'C', 1);
$pdf->Cell(80,6, utf8_decode('Tema'),1, 0, 'C', 1);
$pdf->Ln();

//Contenido informacion general 3
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->Cell(40,6, '',1, 0, 'L');
$pdf->Cell(40,6, '',1, 0, 'L');
$pdf->Cell(40,6, '',1, 0, 'L');
$pdf->Cell(80,6, '',1, 0, 'L');
$pdf->Ln(10);

//Descripcion de la solicitud
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(200,6, utf8_decode('Descripción detallada de la solicitud'),1, 0, 'C', 1);
$pdf->Ln();

//Contenidos descripcion de la solicitud
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->MultiCell(200,25, '', 1, 'L');
$pdf->Ln(5);

//Accion emprendida
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(75,6, utf8_decode('Acción emprendida'),1, 0, 'C', 1);
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->Cell(125,6, '',1, 0, 'L');
$pdf->Ln();
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(200,6, utf8_decode('Descripción detallada de la acción emprendida'),1, 0, 'C', 1);
$pdf->Ln();

//Contenido accion emprendida
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->MultiCell(200,25, '', 1, 'L');
$pdf->Ln(5);

//Datos de remision
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(200,6, utf8_decode('Datos de remisión'),1, 0, 'C', 1);
$pdf->Ln();
$pdf->Cell(70,6, utf8_decode('Funcionario'),1, 0, 'C', 1);
$pdf->Cell(50,6, utf8_decode('Cargo - Entidad'),1, 0, 'C', 1);
$pdf->Cell(40,6, utf8_decode('Fecha'),1, 0, 'C', 1);
$pdf->Cell(40,6, utf8_decode('Radicado de remisión'),1, 0, 'C', 1);
$pdf->Ln();

//Contenido datos de remision
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->Cell(70,6, '',1, 0, 'L');
$pdf->Cell(50,6, '',1, 0, 'L');
$pdf->Cell(40,6, '',1, 0, 'L');
$pdf->Cell(40,6, '',1, 0, 'L');
$pdf->Ln(10);

//Seguimiento
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(200,6, utf8_decode('Seguimientos'),1, 0, 'C', 1);
$pdf->Ln();

//Seguimientos
for ($i = 1; $i < 3; $i++) { 
	//Contenido seguimientos
	$pdf->SetFont($fuente,'B',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->Cell(10,6, utf8_decode($i),1, 0, 'R');
	$pdf->SetFont($fuente,'',9);
	$pdf->Cell(190,6, '',1, 0, 'L');
	$pdf->Ln();
}//Fin for seguimientos

$pdf->Ln();

//Respuesta
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(200,6, utf8_decode('Respuesta'),1, 0, 'C', 1);
$pdf->Ln();

//Contenido respuesta
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->MultiCell(200,15, '', 1, 'L');
$pdf->Ln(0);

//Datos respuesta
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(50,6, utf8_decode('Fecha'),1, 0, 'C', 1);
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->Cell(50,6, '',1, 0, 'L');
$pdf->SetFont($fuente,'B',10);
$pdf->SetTextColor('255,0,0');
$pdf->SetDrawColor('255,0,0');
$pdf->Cell(50,6, utf8_decode('Radicado de salida'),1, 0, 'C', 1);
$pdf->SetFont($fuente,'',9);
$pdf->SetTextColor('0,0,0');
$pdf->SetDrawColor('159,148,148');
$pdf->Cell(50,6, '',1, 0, 'L');
$pdf->Ln(20);

$pdf->SetFont($fuente,'B',10);
$pdf->Cell(100,5, utf8_decode('_______________________________'),0, 0, 'C');
$pdf->Cell(100,5, utf8_decode('_______________________________'),0, 0, 'C');
$pdf->Ln();
$pdf->Cell(100,5, utf8_decode('Firma de Gestión Social'),0, 0, 'C');
$pdf->Cell(100,5, utf8_decode('Firma del solicitante'),0, 0, 'C');
$pdf->Ln();
$pdf->setX(130);
$pdf->Cell(70,5, utf8_decode('C.C.'),0, 0, 'L');

//Se imprime el Reporte
$pdf->Output('Plantilla_Solicitud.pdf', 'D');
?>