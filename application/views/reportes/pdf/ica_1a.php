<?php
//Se cargan las metas
$metas = $this->ica_model->cargar_metas(22);

//Se declara un contador
$num = 1; 

// Creacion del objeto de la clase heredada
$pdf = new FPDF('L','mm','Letter');

//Se definen las margenes
$pdf->SetMargins(5, 10, 5);

//Anadir pagina
$pdf->AddPage();

//Fuente
$fuente = 'Helvetica';

//Encabezado
$pdf->SetFont($fuente,'B',9);
$pdf->Cell(28, 12, '', 1, 0, 'C');
$pdf->Cell(210, 12, utf8_decode("ESTADO DE CUMPLIMIENTO DE LOS PROGRAMAS QUE CONFORMAN EL PLAN DE MANEJO AMBIENTAL"), 1, 0, 'C');
$pdf->SetFont($fuente,'',9);
$pdf->Cell(30, 4, 'FORMATO', 1, 0, 'C');
$pdf->SetFont($fuente,'B',9);
$pdf->SetXY(243, 14);
$pdf->Cell(30, 4, 'ICA-1A', 1, 1, 'C');
$pdf->SetFont($fuente,'',9);
$pdf->SetXY(243, 18);
$pdf->Cell(30, 4, 'Hoja 1 de 1', 1, 1, 'C');

$pdf->SetFont($fuente,'',7);
$pdf->Cell(185, 5, 'PROGRAMA: ', 1, 0, 'L');
$pdf->Cell(53, 5, utf8_decode('VERSIÓN: '), 1, 0, 'L');
$pdf->Cell(30, 5, utf8_decode('CÓDIGO: '), 1, 1, 'L');
$pdf->Cell(268, 5, utf8_decode('CUMPLIMIENTO DE METAS (INDICADORES DE ÉXITO)'), 1, 1, 'C');

$pdf->SetFont($fuente,'', 7);
$pdf->Cell(127, 8, utf8_decode('1. METAS'), 1, 0, 'C');
$pdf->Cell(55, 8, utf8_decode('2. PARÁMETROS DE CONTROL MEDIDO'), 1, 1, 'C');

$pdf->SetXY(187, 32);
$pdf->MultiCell(55, 4, utf8_decode('3. VALOR DE REFERENCIA O CARACTERÍSTICA DE CALIDAD'), 1, 'C', false);

$pdf->SetXY(242, 32);
$pdf->Cell(31, 8, utf8_decode('4. CUMPLIMIENTO'), 1, 1, 'C');

$pdf->SetY(40);
$pdf->Cell(7, 4, utf8_decode('No.'), 1, 0, 'C');
$pdf->Cell(120, 4, utf8_decode('Descripción'), 1, 0, 'C');
$pdf->Cell(35, 4, utf8_decode('Descripción'), 1, 0, 'C');
$pdf->Cell(20, 4, utf8_decode('Valor'), 1, 0, 'C');

$pdf->Cell(35, 4, utf8_decode('Descripción'), 1, 0, 'C');
$pdf->Cell(20, 4, utf8_decode('Valor'), 1, 0, 'C');
$pdf->Cell(15.5, 4, utf8_decode('Si'), 1, 0, 'C');
$pdf->Cell(15.5, 4, utf8_decode('No'), 1, 1, 'C');

$num = 1;

//Se recorren las metas
foreach ($metas as $meta) {
	$pdf->Cell(7, 7, utf8_decode($num), 1, 0, 'C');
	$pdf->Cell(120, 7, utf8_decode($meta->Descripcion), 1, 0, 'L');
	$pdf->Cell(35, 7, utf8_decode($meta->Parametro_Descripcion), 1, 0, 'C');
	$pdf->Cell(20, 7, utf8_decode($meta->Parametro_Valor), 1, 0, 'C');
	$pdf->Cell(35, 7, utf8_decode($meta->Calidad_Descripcion), 1, 0, 'C');
	$pdf->Cell(20, 7, utf8_decode($meta->Calidad_Valor), 1, 0, 'C');

	if ($meta->Cumple == "1") {
		$pdf->Cell(15.5, 7, utf8_decode('X'), 1, 0, 'C');
		$pdf->Cell(15.5, 7, utf8_decode(''), 1, 1, 'C');
	} else {
		$pdf->Cell(15.5, 7, utf8_decode(''), 1, 0, 'C');
		$pdf->Cell(15.5, 7, utf8_decode('X'), 1, 1, 'C');
	}

	//Se aumenta el contador
	$num++;
}//Fin foreach

$pdf->Ln(2);

$pdf->MultiCell(92, 13, utf8_decode('3. VALOR DE REFERENCIA O CARACTERÍSTICA DE CALIDAD'), 1, 'C', false);
$pdf->Cell(7, 5, utf8_decode('No.'), 1, 0, 'C');
$pdf->Cell(85, 5, utf8_decode('Descripción'), 1, 0, 'C');

$pdf->SetXY(97, $pdf->GetY() - 13);
//$pdf->Cell(45, 4, utf8_decode('Descripción'), 1, 1, 'C');
$pdf->MultiCell(45, 5, utf8_decode('6. ACCIONES DE VERIFICACIÓN PERIÓDICA'), 1, 'C', false);
$pdf->SetX(97);
$pdf->MultiCell(25, 4, utf8_decode('Periodicidad de la verificación'), 1, 'C', false);
$pdf->SetXY(122, $pdf->GetY() - 8);
$pdf->MultiCell(20, 4, utf8_decode('% de cumplimiento'), 1, 'C', false);

$pdf->SetXY(142, $pdf->GetY() - 18);
$pdf->MultiCell(45, 5, utf8_decode('7. ACCIONES DE VERIFICACIÓN SEGÚN AVANCE'), 1, 'C', false);
$pdf->SetX(142);
$pdf->MultiCell(25, 4, utf8_decode('% de avance programado'), 1, 'C', false);
$pdf->SetXY(167, $pdf->GetY() - 8);
$pdf->MultiCell(20, 4, utf8_decode('% de avance a la fecha'), 1, 'C', false);

$pdf->SetXY(187, $pdf->GetY() - 18);
$pdf->MultiCell(86, 18, utf8_decode('8. OBSERVACIONES'), 1, 'C', false);

$pdf->SetFont($fuente,'',7);

$num = 1;

//Recorro nuevamente las metas
foreach ($metas as $meta) {
	$pdf->Cell(7, 30, $num, 1, 1, 'C');





	/*
	$pdf->SetX(5);
	$pdf->MultiCell(7, 12, utf8_decode($num), 1, 'C', false); //Número
	$pdf->SetX(12, $pdf->GetY()-12);
	$pdf->MultiCell(175, 6, utf8_decode("Acciones de Manejo '".$meta->Descripcion."'"), 1, 'C', false); //Descripción

	foreach ($this->ica_model->cargar_acciones($meta->Pk_Id_Meta) as $accion) {
		$pdf->SetXY(187, $pdf->GetY() - 6);
		$pdf->MultiCell(86, 4, utf8_decode($accion->Observacion), 1, 'L', false);
	}

	/*
	
	$pdf->SetXY($pdf->GetX() + 7, $pdf->GetY() - 15);
	$pdf->MultiCell(85, 6, utf8_decode($meta->Descripcion), 1, 'C', false);
	
	$pdf->SetXY(97, $pdf->GetY()-5);
	$pdf->MultiCell(90, 6, utf8_decode(''), 1, 'C', false);
	
	//Se recorren las acciones
	foreach ($this->ica_model->cargar_acciones($meta->Pk_Id_Meta) as $accion) {
		$pdf->SetX(12);
		$pdf->MultiCell(85, 7, utf8_decode($accion->Descripcion), 1, 'L', false);
	}
	*/
	$num++;
}

//Se imprime el Reporte
$pdf->Output('Registro_Fotografico.pdf', 'I');
?>