<?php
//Se toma el id de la ficha
$id_ficha = $this->uri->segment(3);

//Se cargan los datos
$datos = $this->ica_model->cargar_2d($id_ficha);
$usos = $this->ica_model->cargar_2d_recurso($id_ficha);
$monitoreos = $this->ica_model->cargar_2d_monitoreos($id_ficha);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Indicador de Cumplimiento Ambiental 2d")
	->setDescription("Informe ICA 2d")
	->setKeywords("ica 2d - Estado del permiso de ocupación de cauces")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(7); //Tamanio
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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(11);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:O3');
$objPHPExcel->getActiveSheet()->mergeCells('P1:Q1');
$objPHPExcel->getActiveSheet()->mergeCells('P2:Q2');
$objPHPExcel->getActiveSheet()->mergeCells('P3:Q3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:Q4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:J5');
$objPHPExcel->getActiveSheet()->mergeCells('K5:Q5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:C7');
$objPHPExcel->getActiveSheet()->mergeCells('D6:H7');
$objPHPExcel->getActiveSheet()->mergeCells('I6:J7');
$objPHPExcel->getActiveSheet()->mergeCells('K6:L6');
$objPHPExcel->getActiveSheet()->mergeCells('N6:Q7');

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('P2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('P3')->applyFromArray($titulo_centrado);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ESTADO DEL PERMISO DE OCUPACIÓN DE CAUCES');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'FORMATO');
$objPHPExcel->getActiveSheet()->setCellValue('P2', 'Ica 2d');
$objPHPExcel->getActiveSheet()->setCellValue('P3', 'Hoja _ de _');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'ESTADO DEL PERMISO, AUTORIZACIÓN, CONCESIÓN Y LICENCIA');
$objPHPExcel->getActiveSheet()->setCellValue('A5', '1. OTORGADO');
$objPHPExcel->getActiveSheet()->setCellValue('K5', '2. EN TRÁMITE');
$objPHPExcel->getActiveSheet()->setCellValue('A6', 'No. y fecha del acto administrativo');
$objPHPExcel->getActiveSheet()->setCellValue('D6', 'Autoridad ambiental competente');
$objPHPExcel->getActiveSheet()->setCellValue('I6', 'Vigencia');
$objPHPExcel->getActiveSheet()->setCellValue('K6', 'Tipo');
$objPHPExcel->getActiveSheet()->setCellValue('K7', 'Nuevo');
$objPHPExcel->getActiveSheet()->setCellValue('L7', 'Renovación o modificación');
$objPHPExcel->getActiveSheet()->setCellValue('M6', 'Fecha de radicación');
$objPHPExcel->getActiveSheet()->setCellValue('N6', 'Autoridad ambiental competente');

//******************************************** 1. otorgado; 2. En trámite ********************************************//
//Se declara fila
$fila = 8;
$fila_inicial = $fila;

//Se recorren los datos
foreach ($datos as $dato) {
	//Combinar celdas
	$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:C{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("D{$fila}:H{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:Q{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $dato->Numero_Acto);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $dato->Autoridad1);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $dato->Vigencia);
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

//Disminuimos una fila
$fila--;

//Estilos y bordes
$objPHPExcel->getActiveSheet()->getStyle("A4:Q{$fila}")->applyFromArray($titulo_centrado);

//Aumentar fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:Q{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "ESTADO DE CUMPLIMIENTO (INDICADORES DE CUMPLIMIENTO)");

//Estilos
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}:Q{$fila}")->applyFromArray($titulo_centrado_negrita);

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:Q{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "3. USO DEL RECURSO");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}")->applyFromArray($titulo_centrado);

//Aumentamos la fila
$fila++;

$fila_inicial = $fila;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:F{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Ocupación");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "Actividades que causan la ocupación");
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, "Nombre de la fuente");
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, "Coordenadas / Origen");
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, "PMA Relacionado");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila_inicial}:K{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("L{$fila_inicial}:M{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("N{$fila_inicial}:P{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("Q{$fila_inicial}:Q{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("D{$fila}:E{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "No.");
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "Temporal");
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "Permanente");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "Duración de la ocupación");
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Fecha de inicio de la ocupación");

//Aumentamos la fila
$fila++;

//******************************************** 3. Uso del recurso ********************************************//
foreach ($usos as $uso) {
	//Combinar celdas
	$objPHPExcel->getActiveSheet()->mergeCells("D{$fila}:E{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:K{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("L{$fila}:M{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:P{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $uso->Numero);
	
	if ($uso->Tipo == "1") {
		$objPHPExcel->getActiveSheet()->setCellValue("B".$fila, "X");
	} else {
		$objPHPExcel->getActiveSheet()->setCellValue("C".$fila, "X");
	}//Fin if
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $uso->Duracion_Ocupacion);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $uso->Fecha_Ocupacion);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $uso->Actividades);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $uso->Nombre_Fuente);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $uso->Coordenadas);
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $uso->PMA_Relacionado);

	//Tamaño de las filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

	//Aumentamos la fila
	$fila++;
}//Fin foreach uso

$fila_inicial_titulo = $fila;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:L{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("M{$fila}:N{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("P{$fila}:Q{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "4. MONITOREO E INSPECCIÓN AMBIENTAL");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "5. NORMA NACIONAL / INTERNACIONAL");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "6. COMPROMISO EN EL ESTUDIO AMBIENTAL");
$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, "7. PROGRAMAS DEL PMA RELACIONADOS");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:Q{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "ESTADO DEL PERMISO, AUTORIZACIÓN, CONCESIÓN Y LICENCIA");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("F{$fila}:G{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("H{$fila}:I{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:L{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("P{$fila}:Q{$fila}");

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

$fila_inicial = $fila;

//Estilos y bordes
$objPHPExcel->getActiveSheet()->getStyle("A4:Q{$fila}")->applyFromArray($titulo_centrado);

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
$objPHPExcel->getActiveSheet()->setTitle("ICA 2d");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="ICA_2d.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>