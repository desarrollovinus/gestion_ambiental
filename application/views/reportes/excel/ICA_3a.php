<?php
//Se toman los id necesarios
$id_periodo = $this->uri->segment(3);
$id_tramo = $this->uri->segment(4);
$id_ficha = $this->uri->segment(5);

//Se cargan los requerimientos
$requerimientos = $this->ica_model->listar_3a_requerimientos($id_periodo, $id_tramo, $id_ficha);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Indicador de Cumplimiento Ambiental 2h")
	->setDescription("Informe ICA 3a")
	->setKeywords("ica 3a - Estado de cumplimiento de los requerimientos de los actos administrativos")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); //Escala

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(7);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0,90); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0,70); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0,70); //Izquierda
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,90); //Abajo

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();

/**
 * Estilos
 */
//Estilo de los titulos
$titulo_centrado_negrita = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$titulo_negrita = array(
	'font' => array(
		'bold' => true
	),
);

$titulo_centrado = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

$titulo_izquierdo = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
	)
);

$titulo_derecho = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
	)
);

//Estilo de los bordes
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

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:G3');
$objPHPExcel->getActiveSheet()->mergeCells('H2:H3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:I5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:A7');
$objPHPExcel->getActiveSheet()->mergeCells('G6:I7');
$objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
$objPHPExcel->getActiveSheet()->mergeCells('E6:F6');
$objPHPExcel->getActiveSheet()->mergeCells('G6:I7');

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A4:A5')->applyFromArray($titulo_negrita);
$objPHPExcel->getActiveSheet()->getStyle('A6:I7')->applyFromArray($titulo_centrado);

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ESTADO DE CUMPLIMIENTO DE LOS REQUERIMIENTOS DE LOS ACTOS ADMINISTRATIVOS');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'FECHA DE LA VISITA: ');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'No. DEL ÚLTIMO REPORTE DEL INFORME DE CUMPLIMIENTO: ');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'FORMATO');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Ica 3a');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Hoja _ de _');
$objPHPExcel->getActiveSheet()->setCellValue('A4', '1: ACTO ADMINISTRATIVO: ');
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'FECHA: ');
$objPHPExcel->getActiveSheet()->setCellValue('A6', '2. REQUERIMIENTOS: ');
$objPHPExcel->getActiveSheet()->setCellValue('B6', '3. CUMPLIMIENTO: ');
$objPHPExcel->getActiveSheet()->setCellValue('E6', '4. FECHAS: ');
$objPHPExcel->getActiveSheet()->setCellValue('G6', '5. JUSTIFICACIÓN U OBSERVACIONES: ');
$objPHPExcel->getActiveSheet()->setCellValue('B7', 'Si');
$objPHPExcel->getActiveSheet()->setCellValue('C7', 'No');
$objPHPExcel->getActiveSheet()->setCellValue('D7', 'Parcial (%)');
$objPHPExcel->getActiveSheet()->setCellValue('E7', 'De inicio');
$objPHPExcel->getActiveSheet()->setCellValue('F7', 'De culminación');

//******************************************** 1. Requerimientos ********************************************//
//Se declara fila
$fila = 8;

//Se recorren los requerimientos
foreach ($requerimientos as $requerimiento) {
	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:I{$fila}");
	

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $requerimiento->Descripcion);
	//Si cumple
	if ($requerimiento->Cumplimiento == "1") {
		$objPHPExcel->getActiveSheet()->setCellValue("B".$fila, "X");
	} else {
		$objPHPExcel->getActiveSheet()->setCellValue("C".$fila, "X");
	}//Fin if
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $requerimiento->Cumplimiento_Parcial);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $requerimiento->Fecha_Inicial);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $requerimiento->Fecha_Final);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $requerimiento->Observaciones);

	//Aumentamos la fila
	$fila++;
}//Fin foreach requerimientos

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A8:Q{$fila}")->applyFromArray($titulo_centrado);

$fila_inicial = $fila;

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("H{$fila}:I{$fila}");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A".$fila)->applyFromArray($titulo_izquierdo);

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Obsevaciones:");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "PROFESIONAL RESPONSABLE");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("H".$fila)->applyFromArray($titulo_centrado);

//Aumentamos la fila
$fila++;

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("H".$fila)->applyFromArray($titulo_izquierdo);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("H{$fila}:I{$fila}");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "Nombre:");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(30);

//Aumentamos la fila
$fila++;

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("H".$fila)->applyFromArray($titulo_izquierdo);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("H{$fila}:I{$fila}");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "Firma:");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(30);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila_inicial}:G{$fila}");

//Bordes
$objPHPExcel->getActiveSheet()->getStyle('A1:I'.$fila)->applyFromArray($bordes);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("ICA 3a");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="ICA_3a.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>