<?php
//Se toma el id de la ficha
$id_ficha = $this->uri->segment(3);

//Se cargan los datos
$datos = $this->ica_model->cargar_2g($id_ficha);
$usos = $this->ica_model->cargar_2g_recurso($id_ficha);
$monitoreos = $this->ica_model->cargar_2g_monitoreos($id_ficha);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Indicador de Cumplimiento Ambiental 2g")
	->setDescription("Informe ICA 2g")
	->setKeywords("ica 2g - Estado de manejo de residuos sólidos")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:Q3');
$objPHPExcel->getActiveSheet()->mergeCells('R1:S1');
$objPHPExcel->getActiveSheet()->mergeCells('R2:S2');
$objPHPExcel->getActiveSheet()->mergeCells('R3:S3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:S4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
$objPHPExcel->getActiveSheet()->mergeCells('M5:S5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:B7');
$objPHPExcel->getActiveSheet()->mergeCells('C6:I7');
$objPHPExcel->getActiveSheet()->mergeCells('J6:L7');
$objPHPExcel->getActiveSheet()->mergeCells('M6:N6');
$objPHPExcel->getActiveSheet()->mergeCells('O6:P7');
$objPHPExcel->getActiveSheet()->mergeCells('Q6:S7');

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('R1')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('R2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('R3')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A4:R7')->applyFromArray($titulo_centrado);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ESTADO DE MANEJO DE RESIDUOS SÓLIDOS');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'FORMATO');
$objPHPExcel->getActiveSheet()->setCellValue('R2', 'Ica 2f');
$objPHPExcel->getActiveSheet()->setCellValue('R3', 'Hoja _ de _');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'ESTADO DEL PERMISO, AUTORIZACIÓN, CONCESIÓN Y LICENCIA');
$objPHPExcel->getActiveSheet()->setCellValue('A5', '1. OTORGADO');
$objPHPExcel->getActiveSheet()->setCellValue('M5', '2. EN TRÁMITE');
$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Nro. y fecha del acto administrativo');
$objPHPExcel->getActiveSheet()->setCellValue('C6', 'Autoridad ambiental competente');
$objPHPExcel->getActiveSheet()->setCellValue('J6', 'Vigencia');
$objPHPExcel->getActiveSheet()->setCellValue('M6', 'Tipo');
$objPHPExcel->getActiveSheet()->setCellValue('M7', 'Nuevo');
$objPHPExcel->getActiveSheet()->setCellValue('N7', 'Renovación y modificación');
$objPHPExcel->getActiveSheet()->setCellValue('O6', 'Fecha de radicación');
$objPHPExcel->getActiveSheet()->setCellValue('Q6', 'Autoridad competente');

//******************************************** 1. otorgado; 2. En trámite ********************************************//
//Se declara fila
$fila = 8;
// $fila_inicial = $fila;

//Se recorren los datos
foreach ($datos as $dato) {
	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:B{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("C{$fila}:I{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("J{$fila}:L{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("O{$fila}:P{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("Q{$fila}:S{$fila}");
	
	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $dato->Numero_Acto." - ".$dato->Fecha_Acto);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $dato->Autoridad1);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $dato->Vigencia);
	//Según el tipo
	if ($dato->Tipo == "1") {
		$objPHPExcel->getActiveSheet()->setCellValue("M".$fila, "X");
	} else {
		$objPHPExcel->getActiveSheet()->setCellValue("N".$fila, "X");
	}//Fin if
	$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $dato->Fecha_Radicacion);
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $dato->Autoridad2);

	//Tamaño de las filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

	//Aumentamos la fila
	$fila++;
}//Fin foreach datos

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:S{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "ESTADO DE CUMPLIMIENTO (INDICADORES DE CUMPLIMIENTO)");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:S{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "3. USO DEL RECURSO");

//Aumentamos la fila
$fila++;

$fila_inicial = $fila;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:E{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:H{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:N{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("O{$fila}:R{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Tipo de residuos");
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Fuente de generación");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "Cantidades / toneladas");
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, "Sistema de tratamiento");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "Sitio de disposición");
$objPHPExcel->getActiveSheet()->setCellValue('S'.$fila, "PMA RELACIONADOS");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("F{$fila_inicial}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("J{$fila}:K{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("Q{$fila}:R{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("S{$fila_inicial}:S{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Nro.");
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "Domésticos");
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "Industriales");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "Hospitalarios");
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "Otros");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "Autorizados");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "Dispuestos");
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, "Lixiviados");
$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, "Relleno sanitario");
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, "Botadero");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "Incineración");
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, "Otro");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "Nombre");
$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, "Vida útil");
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, "Localización y coordenadas / origen");

//Tamaño de las filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

//Aumentamos la fila
$fila++;

//******************************************** 3. Uso del recurso ********************************************//
foreach ($usos as $uso) {
	//Combinar celdas
	$objPHPExcel->getActiveSheet()->mergeCells("J{$fila}:K{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("Q{$fila}:R{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $uso->Numero);

	//Tipo de residuo
	switch ($uso->Tipo_Residuo) {
		case '1':
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "X");
			break;

		case '2':
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "X");
			break;

		case '3':
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "X");
			break;
	}//suiche

	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $uso->Otro_Tipo_Residuo);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $uso->Fuente_Generacion);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $uso->Cantidad_Autorizada);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $uso->Cantidad_Dispuesta);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $uso->Sistema_Lixiviados);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $uso->Sistema_Relleno);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $uso->Sistema_Botadero);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $uso->Sistema_Incineracion);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $uso->Sistema_Otro);
	$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $uso->Nombre_Sitio);
	$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $uso->Vida_Util);
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $uso->Coordenadas);
	$objPHPExcel->getActiveSheet()->setCellValue('S'.$fila, $uso->PMA_Relacionado);

	//Tamaño de las filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

	//Aumentamos la fila
	$fila++;
}//Fin foreach uso

$fila_inicial = $fila;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:N{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("O{$fila}:P{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "4. MONITOREO E INSPECCIÓN AMBIENTAL");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "5. NORMA NACIONAL / INTERNACIONAL");
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, "6. COMPROMISO EN EL ESTUDIO AMBIENTAL");
$objPHPExcel->getActiveSheet()->setCellValue('R'.$fila, "7. PROGRAMAS DEL PMA RELACIONADOS");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("R{$fila_inicial}:S{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:L{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Nro.");
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "Parámetros");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "Unidad de medición");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "Valor");
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, "Método de muestra");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "Método de análisis");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "Fecha de muestreo");
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, "Localización de punto de muestreo");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "No. Norma");
$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, "Valor");
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, "Valor");

//Aumentamos la fila
$fila++;

//******************************************** 4. Monitoreo e Inspección Ambiental ********************************************//
foreach ($monitoreos as $monitoreo) {
	//Combinar celdas
	$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:F{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:L{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("R{$fila}:S{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $monitoreo->Numero);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $monitoreo->Parametros);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $monitoreo->Unidad_Medicion);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $monitoreo->Valor_Medicion);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $monitoreo->Metodo_Muestra);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $monitoreo->Metodo_Analisis);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $monitoreo->Fecha_Muestreo);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $monitoreo->Localizacion_Muestreo);
	$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $monitoreo->Numero_Norma);
	$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $monitoreo->Valor_Norma);
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $monitoreo->Valor_Compromiso);
	$objPHPExcel->getActiveSheet()->setCellValue('R'.$fila, $monitoreo->Pma_Relacionado);

	//Tamaño de las filas
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

	//Aumentamos la fila
	$fila++;
}//Fin foreach monitoreos

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A8:S{$fila}")->applyFromArray($titulo_centrado);

$fila_inicial = $fila;

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("O{$fila}:S{$fila}");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A".$fila)->applyFromArray($titulo_izquierdo);

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Obsevaciones:");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "PROFESIONAL RESPONSABLE");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("O".$fila)->applyFromArray($titulo_centrado);

//Aumentamos la fila
$fila++;

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("O".$fila)->applyFromArray($titulo_izquierdo);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("O{$fila}:S{$fila}");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "Nombre:");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(40);

//Aumentamos la fila
$fila++;

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("O".$fila)->applyFromArray($titulo_izquierdo);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("O{$fila}:S{$fila}");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, "Firma:");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(40);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila_inicial}:N{$fila}");

//Bordes
$objPHPExcel->getActiveSheet()->getStyle('A1:S'.$fila)->applyFromArray($bordes);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

// Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("ICA 2g");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="ICA_2g.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>