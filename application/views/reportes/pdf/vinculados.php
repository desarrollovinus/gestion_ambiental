<?php
// Datos que llegan por URL
$anio_inicio = $this->uri->segment(3);
$mes_inicio = $this->uri->segment(4);
$anio_fin = $this->uri->segment(5);
$mes_fin = $this->uri->segment(6);
($this->uri->segment(7) == "") ? $vinculados_proveedores = 0 : $vinculados_proveedores = $this->uri->segment(7) ;

$fecha_inicio = "{$anio_inicio}-{$mes_inicio}-01";
$fecha_fin = "{$anio_fin}-{$mes_fin}-31";

// Se consulta los datos del tramo
// $tramo = $this->solicitud_model->cargar_tramos($id_tramo);

// Se consultan los frentes de los vinculados
$frentes = $this->reporte_model->cargar_frentes_vinculados($fecha_inicio, $fecha_fin);

class PDF extends FPDF{
	/*
	 * Cabecera del reporte
	 */
	function Header(){
		//Fuente
	    $this->SetFont('Arial','',11);

	    // Logo ANI
	    $this->setXY(15, 10);
	    $this->Cell( 42, 30, $this->Image('./img/logo_ani.jpg', $this->GetX()+2, $this->GetY()+2, 33.78), 1, 0, 'C', false );

	    $this->setX(57);
	    $this->MultiCell(130,10, utf8_decode('PROYECTO CONCESIÓN VÍAS DEL NUS - VINUS'),1,'C');
	    $this->setX(57);
	    $this->MultiCell(130,20, utf8_decode('INFORME DE MANO DE OBRA VINCULADA AL PROYECTO'),1,'C');

	    // Logo Vinus
	    $this->setXY(187,10);
	    $this->Cell( 30, 30, $this->Image('./img/logo_vinus.png', $this->GetX()+5, $this->GetY()+2, 20), 1, 0, 'C', false );

	    // Versión
	    $this->SetFont('Arial','',10);
	    $this->setXY(217,10);
	    $this->Cell(48,10, utf8_decode('Código: F-140'),1,1,'C');
	    $this->setX(217);
	    $this->Cell(48,10, utf8_decode('Versión 1.00'),1,1,'C');
	    $this->setX(217);
	    $this->Cell(48,10, utf8_decode('Fecha: 22/08/2016'),1,0,'C');

	    // Salto de línea
	    $this->Ln(15);
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
	    $this->SetFont('Arial', '', 8);
	    // Número de página
	    $this->Cell(0,10, utf8_decode('Sistema de Gestión Ambiental - Página ').$this->PageNo().' de {nb}',0,0,'R');
	}//Fin Footer
}//Fin PDF


// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','Letter');

//Anadir pagina
$pdf->AliasNbPages();

//Anadir pagina
$pdf->AddPage();

//Se definen las margenes
$pdf->SetMargins(15, 15, 15);

// Datos generales
$pdf->SetFont('Arial', '', 8);
$pdf->setX(15);
$pdf->Cell(50, 5, utf8_decode("Fecha: {$this->auditoria_model->formato_fecha(date('Y-m-d'))}"), 1, 0, 'L');
$pdf->Cell(100, 5, utf8_decode("Período reportado: ".$this->auditoria_model->formato_fecha(date($fecha_inicio))." al ".$this->auditoria_model->formato_fecha(date($fecha_fin))), 1, 0, 'L');
$pdf->Cell(100, 5, utf8_decode("Unidad funcional: UF5 - Cisneros - Alto de Dolores"), 1, 0, 'L');

// Salto de línea
$pdf->Ln(10);

// Encabezado
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 20, utf8_decode("SECTOR O TRAYECTO"), 1, 0, 'C');
$pdf->Multicell(60, 5, utf8_decode("TRABAJADORES VINCULADOS AL PROYECTO"), 1, 'C');
$pdf->setXY(65, $pdf->GetY());
$pdf->Cell(20, 10, utf8_decode("No. D"), 1, 0, 'C');
$pdf->Cell(20, 10, utf8_decode("No. I"), 1, 0, 'C');
$pdf->Cell(20, 10, utf8_decode("TOTAL"), 1, 0, 'C');
$pdf->setXY(125, $pdf->GetY()-10);
$pdf->Multicell(40, 10, utf8_decode("ORIGEN"), 1, 'C');
$pdf->setXY(125, $pdf->GetY());
$pdf->Cell(20, 10, utf8_decode("No. AID"), 1, 0, 'C');
$pdf->Cell(20, 10, utf8_decode("No. AII"), 1, 0, 'C');
$pdf->setXY(165, $pdf->GetY()-10);
$pdf->Multicell(40, 10, utf8_decode("GÉNERO"), 1, 'C');
$pdf->setXY(165, $pdf->GetY());
$pdf->Cell(20, 10, utf8_decode("No. M"), 1, 0, 'C');
$pdf->Cell(20, 10, utf8_decode("No. F"), 1, 0, 'C');
$pdf->setXY(205, $pdf->GetY()-10);
$pdf->Multicell(20, (20/4), utf8_decode("No. MIEMBROS PROGRAMA ACR"), 1, 'C');
$pdf->setXY(225, $pdf->GetY()-20);
$pdf->Multicell(40, 10, utf8_decode("CATEGORÍA"), 1, 'C');
$pdf->setXY(225, $pdf->GetY());
$pdf->Cell(20, 10, utf8_decode("No. MOC"), 1, 0, 'C');
$pdf->Cell(20, 10, utf8_decode("No. MONC"), 1, 1, 'C');

// Se listan los frentes de los vinculados
foreach ($frentes as $frente) {
	// // Se cuentan los vinculados de Vinus y otros
	$vinculados_directos = $this->reporte_model->contar_vinculados_directos($frente->Pk_Id_Frente, true, $fecha_inicio, $fecha_fin);
	$vinculados_indirectos = $this->reporte_model->contar_vinculados_directos($frente->Pk_Id_Frente, false, $fecha_inicio, $fecha_fin);

	// Datos
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(50, 6, utf8_decode($frente->Nombre), 1, 0, 'L');
	$pdf->Cell(20, 6, utf8_decode($vinculados_directos), 1, 0, 'R');
	$pdf->Cell(20, 6, utf8_decode($vinculados_indirectos), 1, 0, 'R');
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 6, utf8_decode($frente->Total), 1, 0, 'R');
	$pdf->SetFont('Arial', '', 8);

	// Se cuentan vinculados y no vinculados
	$vinculados_aid = $this->reporte_model->contar_vinculados_area_influencia($frente->Pk_Id_Frente, 1, $fecha_inicio, $fecha_fin);
	$vinculados_aii = $this->reporte_model->contar_vinculados_area_influencia($frente->Pk_Id_Frente, 0, $fecha_inicio, $fecha_fin);

	// Área de influencia
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(20, 6, utf8_decode($vinculados_aid), 1, 0, 'R');
	$pdf->Cell(20, 6, utf8_decode($vinculados_aii), 1, 0, 'R');

	// Se cuentan los hombres y mujeres
	$vinculados_hombres = $this->reporte_model->contar_vinculados_genero($frente->Pk_Id_Frente, 1, $fecha_inicio, $fecha_fin);
	$vinculados_mujeres = $this->reporte_model->contar_vinculados_genero($frente->Pk_Id_Frente, 2, $fecha_inicio, $fecha_fin);

	// Género
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(20, 6, utf8_decode($vinculados_hombres), 1, 0, 'R');
	$pdf->Cell(20, 6, utf8_decode($vinculados_mujeres), 1, 0, 'R');

	// Se cuentan los que pertenecen al programa ACR
	$vinculados_acr = $this->reporte_model->contar_vinculados_acr($frente->Pk_Id_Frente, 1, $fecha_inicio, $fecha_fin);

	// ACR
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(20, 6, utf8_decode($vinculados_acr), 1, 0, 'R');

	// Se cuentan los que pertenecen al programa ACR
	$vinculados_calificados = $this->reporte_model->contar_vinculados_calificados($frente->Pk_Id_Frente, 1, $fecha_inicio, $fecha_fin);
	$vinculados_no_calificados = $this->reporte_model->contar_vinculados_calificados($frente->Pk_Id_Frente, 0, $fecha_inicio, $fecha_fin);

	// Mano de obra calificada y no calificada
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(20, 6, utf8_decode($vinculados_calificados), 1, 0, 'R');
	$pdf->Cell(20, 6, utf8_decode($vinculados_no_calificados), 1, 0, 'R');

	$pdf->Ln();
} // foreach frentes

// Se totalizan
$total_directos = $this->reporte_model->contar_vinculados_directos(null, true, $fecha_inicio, $fecha_fin);
$total_indirectos = $this->reporte_model->contar_vinculados_directos(null, false, $fecha_inicio, $fecha_fin);
$total_aid = $this->reporte_model->contar_vinculados_area_influencia(NULL, 1, $fecha_inicio, $fecha_fin);
$total_aii = $this->reporte_model->contar_vinculados_area_influencia(NULL, 0, $fecha_inicio, $fecha_fin);
$total_hombres = $this->reporte_model->contar_vinculados_genero(NULL, 1, $fecha_inicio, $fecha_fin);
$total_mujeres = $this->reporte_model->contar_vinculados_genero(NULL, 2, $fecha_inicio, $fecha_fin);
$total_acr = $this->reporte_model->contar_vinculados_acr(NULL, 1, $fecha_inicio, $fecha_fin);
$total_calificados = $this->reporte_model->contar_vinculados_calificados(NULL, 1, $fecha_inicio, $fecha_fin);
$total_no_calificados = $this->reporte_model->contar_vinculados_calificados(NULL, 0, $fecha_inicio, $fecha_fin);

// Totales
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 7, utf8_decode("TOTAL"), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_directos), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_indirectos), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_directos + $total_indirectos), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_aid), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_aii), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_hombres), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_mujeres), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_acr), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_calificados), 1, 0, 'R');
$pdf->Cell(20, 7, utf8_decode($total_no_calificados), 1, 0, 'R');

// Salto de línea
$pdf->Ln(10);

// Total vinculados y proveedores
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(250, 5, utf8_decode("TOTAL DE TRABAJADORES VINCULADOS AL PROYECTO: ".$this->reporte_model->contar_vinculados()), 1, 1, 'L');
$pdf->Cell(250, 5, utf8_decode("TOTAL DE TRABAJADORES CONTRATADOS POR LOS PROVEEDORES PRINCIPALES: ".$vinculados_proveedores), 1, 0, 'L');

// Salto de línea
$pdf->Ln(10);

// Pié de página
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(250/2, 6, utf8_decode("Profesional social concesionario"), 1, 0, 'L');
$pdf->Cell(250/2, 6, utf8_decode("Profesional social interventoría"), 1, 1, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(250/2, 6, utf8_decode("Nombre:"), 1, 0, 'L');
$pdf->Cell(250/2, 6, utf8_decode("Nombre:"), 1, 1, 'L');
$pdf->Cell(250/2, 12, utf8_decode("Firma:"), 1, 0, 'L');
$pdf->Cell(250/2, 12, utf8_decode("Firma:"), 1, 1, 'L');
$pdf->Cell(250/2, 6, utf8_decode("Cédula:"), 1, 0, 'L');
$pdf->Cell(250/2, 6, utf8_decode("Cédula:"), 1, 1, 'L');
$pdf->Cell(250/2, 6, utf8_decode("Fecha:"), 1, 0, 'L');
$pdf->Cell(250/2, 6, utf8_decode("Fecha:"), 1, 1, 'L');

// Salto de línea
$pdf->Ln(10);

// Pié de página
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(50, 3, utf8_decode("SIGLAS:"), 0, 1, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(250, 3, utf8_decode("TRABAJADORES: D-Directos (Contratados directamente por el concesionario); I-Indirectos (Contratados a través de terceros) "), 0, 1, 'L');
$pdf->Cell(250, 3, utf8_decode("ORIGEN: AID-Área de Influencia Directa; AII-Área de Influencia Indirecta"), 0, 1, 'L');
$pdf->Cell(250, 3, utf8_decode("SEXO: M-Masculino; F-Femenino"), 0, 1, 'L');
$pdf->Cell(250, 3, utf8_decode("PROGRAMA ACR: Agencia Colombiana para la Reintegración"), 0, 1, 'L');
$pdf->Cell(250, 3, utf8_decode("CATEGORÍA: MOC-Mano de Obra Calificada; MONC: Mano de Obra No Calificada"), 0, 1, 'L');

// Título
$pdf->SetTitle("Vinculados (01-{$mes_inicio}-{$anio_inicio} a 31-{$mes_fin}-{$anio_fin})");

//Se imprime el Reporte
$pdf->Output("Vinculados (01-{$mes_inicio}-{$anio_inicio} a 31-{$mes_fin}-{$anio_fin}).pdf", 'I');
?>