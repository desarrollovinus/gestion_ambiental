<?php
//Se toma el id de la ficha
$id_ficha = $this->uri->segment(3);

//Se cargan los datos
$datos = $this->ica_model->cargar_2h($id_ficha);
$usos = $this->ica_model->cargar_2h_recurso($id_ficha);
$monitoreos = $this->ica_model->cargar_2h_monitoreos($id_ficha);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Indicador de Cumplimiento Ambiental 2h")
	->setDescription("Informe ICA 2h")
	->setKeywords("ica 2h - Estado del permiso, concesión o licencia de zonas de depósito")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(6); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); //Escala

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(13);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:O3');
$objPHPExcel->getActiveSheet()->mergeCells('P1:Q1');
$objPHPExcel->getActiveSheet()->mergeCells('P2:Q2');
$objPHPExcel->getActiveSheet()->mergeCells('P3:Q3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:Q4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:J5');
$objPHPExcel->getActiveSheet()->mergeCells('K5:Q5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
$objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
$objPHPExcel->getActiveSheet()->mergeCells('G6:H7');
$objPHPExcel->getActiveSheet()->mergeCells('I6:J7');
$objPHPExcel->getActiveSheet()->mergeCells('K6:L6');
$objPHPExcel->getActiveSheet()->mergeCells('D6:F6');
$objPHPExcel->getActiveSheet()->mergeCells('G6:H7');
$objPHPExcel->getActiveSheet()->mergeCells('M6:M7');
$objPHPExcel->getActiveSheet()->mergeCells('N6:Q7');

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('P2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('P3')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A4:Q7')->applyFromArray($titulo_centrado);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ESTADO DEL PERMISO, CONCESIÓN O LICENCIA DE ZONAS DE DEPÓSITO');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'FORMATO');
$objPHPExcel->getActiveSheet()->setCellValue('P2', 'Ica 2h');
$objPHPExcel->getActiveSheet()->setCellValue('P3', 'Hoja _ de _');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'ESTADO DEL PERMISO, AUTORIZACIÓN, CONCESIÓN Y LICENCIA');
$objPHPExcel->getActiveSheet()->setCellValue('A5', '1. OTORGADO');
$objPHPExcel->getActiveSheet()->setCellValue('K5', '2. EN TRÁMITE');
$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Terceros con licencia');
$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Nro. fecha acto administrativo');
$objPHPExcel->getActiveSheet()->setCellValue('C6', 'Permiso');
$objPHPExcel->getActiveSheet()->setCellValue('D6', 'Lleno');
$objPHPExcel->getActiveSheet()->setCellValue('C7', 'Nro. fecha acto administrativo');
$objPHPExcel->getActiveSheet()->setCellValue('D7', 'Si');
$objPHPExcel->getActiveSheet()->setCellValue('E7', 'No');
$objPHPExcel->getActiveSheet()->setCellValue('F7', 'Vigencia - Fecha acto administrativo');
$objPHPExcel->getActiveSheet()->setCellValue('G6', 'Autoridad ambiental competente');
$objPHPExcel->getActiveSheet()->setCellValue('I6', 'Vigencia');
$objPHPExcel->getActiveSheet()->setCellValue('K6', 'Tipo');
$objPHPExcel->getActiveSheet()->setCellValue('M6', 'Fecha de radicación');
$objPHPExcel->getActiveSheet()->setCellValue('N6', 'Autoridad ambiental competente');
$objPHPExcel->getActiveSheet()->setCellValue('K7', 'Nuevo');
$objPHPExcel->getActiveSheet()->setCellValue('L7', 'Renovación o modificación');

//******************************************** 1. otorgado; 2. En trámite ********************************************//
//Se declara fila
$fila = 8;
$fila_inicial = $fila;

//Se recorren los datos
foreach ($datos as $dato) {
	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:B{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:H{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:Q{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $dato->Numero_Acto."-".$dato->Fecha_Acto1);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $dato->Fecha_Acto2);
	//Si es lleno
	if ($dato->Lleno == "1") {
		$objPHPExcel->getActiveSheet()->setCellValue("D".$fila, "X");
	} else {
		$objPHPExcel->getActiveSheet()->setCellValue("E".$fila, "X");
	}//Fin if
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $dato->Vigencia1);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $dato->Autoridad1);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $dato->Vigencia1);
	//Según el tipo
	if ($dato->Tipo == "1") {
		$objPHPExcel->getActiveSheet()->setCellValue("K".$fila, "X");
	} else {
		$objPHPExcel->getActiveSheet()->setCellValue("L".$fila, "X");
	}//Fin if
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $dato->Fecha_Radicacion);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $dato->Autoridad2);

	//Tamaño de las filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

	//Aumentamos la fila
	$fila++;
}//Fin foreach datos

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:Q{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "INDICADORES DE CUMPLIMIENTO");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:Q{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "3. USO DEL RECURSO");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:Q{$fila}")->applyFromArray($titulo_centrado);

//Aumentamos la fila
$fila++;

$fila_inicial = $fila;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("D{$fila}:E{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:L{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:P{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Nro.");
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "Permiso / Autorización");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "Autorizado");
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Utilizado");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "Observaciones");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "Coordenadas / Origen");
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, "Nombre del sitio / Nombre de la fuente");
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, "PMA Relacionados");

//Aumentamos la fila
$fila++;

//******************************************** 3. Uso del recurso ********************************************//
foreach ($usos as $uso) {
	//Combinacion de celdas
	$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("D{$fila}:E{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:L{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:P{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $uso->Numero_Permiso);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $uso->Permiso);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $uso->Permiso_Autorizado);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $uso->Permiso_Utilizado);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $uso->Observaciones);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $uso->Coordenadas);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $uso->Nombre_Fuente);
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $uso->PMA_Relacionado);

	//Tamaño de las filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

	//Aumentamos la fila
	$fila++;
}//Fin foreach uso

//Estilos
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:Q{$fila}")->applyFromArray($titulo_centrado);

$fila_inicial = $fila;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:L{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:N{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "4. MONITOREO E INSPECCIÓN AMBIENTAL");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "5. NORMA NACIONAL / INTERNACIONAL");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "6. COMPROMISO EN EL ESTUDIO AMBIENTAL");
$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, "7. PROGRAMAS DEL PMA RELACIONADOS");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("F{$fila}:G{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("H{$fila}:I{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:L{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("P{$fila_inicial}:Q{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Nro.");
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "Parámetros");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "Unidad de medición");
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "Valor");
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Método de muestra");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "Método de análisis");
$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, "Fecha de muestreo");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "Localización de punto de muestreo");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "No. Norma");
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, "Valor");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "Valor");

//Aumentamos la fila
$fila++;

//******************************************** 4. Monitoreo e Inspección Ambiental ********************************************//
foreach ($monitoreos as $monitoreo) {
	//Combinar celdas
	$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("F{$fila}:G{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("H{$fila}:I{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:L{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("P{$fila}:Q{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $monitoreo->Numero);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $monitoreo->Parametros);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $monitoreo->Unidad_Medicion);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $monitoreo->Valor_Medicion);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $monitoreo->Metodo_Muestra);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $monitoreo->Metodo_Analisis);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $monitoreo->Fecha_Muestreo);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $monitoreo->Localizacion_Muestreo);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $monitoreo->Numero_Norma);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $monitoreo->Valor_Norma);
	$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $monitoreo->Valor_Compromiso);
	$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $monitoreo->Pma_Relacionado);

	//Tamaño de las filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

	//Aumentamos la fila
	$fila++;
}//Fin foreach monitoreos

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:Q{$fila}")->applyFromArray($titulo_centrado);

$fila_inicial = $fila;

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:Q{$fila}");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A".$fila)->applyFromArray($titulo_izquierdo);

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Obsevaciones:");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "PROFESIONAL RESPONSABLE");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("M".$fila)->applyFromArray($titulo_centrado);

//Aumentamos la fila
$fila++;

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("M".$fila)->applyFromArray($titulo_izquierdo);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:Q{$fila}");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "Nombre:");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(40);

//Aumentamos la fila
$fila++;

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("M".$fila)->applyFromArray($titulo_izquierdo);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:Q{$fila}");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "Firma:");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(40);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila_inicial}:L{$fila}");

//Bordes
$objPHPExcel->getActiveSheet()->getStyle('A1:Q'.$fila)->applyFromArray($bordes);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("ICA 2h");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="ICA_2h.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>