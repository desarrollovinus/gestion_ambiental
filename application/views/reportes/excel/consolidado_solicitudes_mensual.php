<?php
// Se consultan las solicitudes
$solicitudes = $this->reporte_model->consolidado_solicitudes_mensual($anio, $mes);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Listado de solicitudes por mes")
	->setDescription("En este listado se muestran las solicitudes clasificadas por año y mes")
	->setKeywords("consolidado listado solicitudes ambiental mensual")
    ->setCategory("Reporte");

//Se establece la orientación de la hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamaño carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); //Escala

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada
$objPHPExcel->getActiveSheet()->setTitle('Consolidado mensual'); //Titulo de la hoja

// Ocultar las cuadrículas
$objPHPExcel->getActiveSheet()->setShowGridlines(false);

// Salto de página
// $objPHPExcel->getActiveSheet()->setBreak( 'A10' , PHPExcel_Worksheet::BREAK_ROW );

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.6); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.6); //Izquierda
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1); //Abajo

/**
 * Estilos
 */
// Título centrado y en negrita
$titulo_centrado_negrita = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

// Borde simple 
$bordes = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'argb' => '000000'
            )
        ),
    ),
);




//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(100);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(100);

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);

//Celdas a combinar
// $objPHPExcel->getActiveSheet()->mergeCells('A1:M1');

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Día');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Mes');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Año');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Fecha exacta');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Nombres');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Teléfono');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Sector');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Municipio');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Tramo');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Tipo');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Causa');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Tema');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Asunto');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Remitido');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Respuesta');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Estado');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Observaciones');

// Declaraciones de fila
$fila = 2;

// Se recorren las solicitudes
foreach ($solicitudes as $solicitud) {
	// Contenido
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", $solicitud->Dia);
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $solicitud->Mes);
	$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", $solicitud->Anio);
	$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", $solicitud->Fecha);
	$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", $solicitud->Nombres);
	$objPHPExcel->getActiveSheet()->setCellValue("F{$fila}", $solicitud->Telefono);
	$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", $solicitud->Sector);
	$objPHPExcel->getActiveSheet()->setCellValue("H{$fila}", $solicitud->Municipio);
	$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", $solicitud->Tramo);
	$objPHPExcel->getActiveSheet()->setCellValue("J{$fila}", $solicitud->Tipo);
	$objPHPExcel->getActiveSheet()->setCellValue("K{$fila}", $solicitud->Causa);
	$objPHPExcel->getActiveSheet()->setCellValue("L{$fila}", $solicitud->Tema);
	$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $solicitud->Asunto);
	$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", $solicitud->Remitido);
	$objPHPExcel->getActiveSheet()->setCellValue("O{$fila}", $solicitud->Respuesta);
	$objPHPExcel->getActiveSheet()->setCellValue("P{$fila}", $solicitud->Estado);
	$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila}", $solicitud->Observaciones);

	// Aumento del contador
	$fila++;
} // foreach solicitudes

$fila--;

/**
 * Formato del texto
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle("A1:Q{$fila}")->applyFromArray($bordes);

/*
 *
 * Pie de pagina
 *
 */
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Consolidado_mensual.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>