<?php
//Se toma el id de la ficha
$id_ficha = $this->uri->segment(3);

//Se cargan los datos
$datos = $this->ica_model->cargar_estado_concesion($id_ficha);
$usos = $this->ica_model->cargar_uso_concesion($id_ficha);
$monitoreos = $this->ica_model->cargar_monitoreos_concesion($id_ficha);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Indicador de Cumplimiento Ambiental 2a")
	->setDescription("Informe ICA 2b")
	->setKeywords("ica 2b Estado de la concesión de aguas")
    ->setCategory("Reporte");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="ICA_2a.xlsx"');

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
//$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

/**
 * Definición de altura de las filas
 */


//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:M3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:N4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:G5');
$objPHPExcel->getActiveSheet()->mergeCells('H5:N5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:B7');
$objPHPExcel->getActiveSheet()->mergeCells('C6:F7');
$objPHPExcel->getActiveSheet()->mergeCells('G6:G7');
$objPHPExcel->getActiveSheet()->mergeCells('H6:I6');
$objPHPExcel->getActiveSheet()->mergeCells('J6:K7');
$objPHPExcel->getActiveSheet()->mergeCells('L6:N7');

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('N2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('N3')->applyFromArray($titulo_centrado);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ESTADO DE LA CONCESIÓN DE AGUAS');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'FORMATO');
$objPHPExcel->getActiveSheet()->setCellValue('N2', 'ICA - 2B');
$objPHPExcel->getActiveSheet()->setCellValue('N3', 'Hoja _ de _');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'ESTADO DEL PERMISO, AUTORIZACIÓN, CONCESIÓN O LICENCIA');
$objPHPExcel->getActiveSheet()->setCellValue('A5', '1. OTORGADO');
$objPHPExcel->getActiveSheet()->setCellValue('H5', '2. EN TRÁMITE');
$objPHPExcel->getActiveSheet()->setCellValue('A6', 'No. y fecha del acto administrativo');
$objPHPExcel->getActiveSheet()->setCellValue('C6', 'Autoridad ambiental competente');
$objPHPExcel->getActiveSheet()->setCellValue('G6', 'Vigencia');
$objPHPExcel->getActiveSheet()->setCellValue('H6', 'Tipo');
$objPHPExcel->getActiveSheet()->setCellValue('H7', 'Nuevo');
$objPHPExcel->getActiveSheet()->setCellValue('I7', 'Renovación o modificación');
$objPHPExcel->getActiveSheet()->setCellValue('J6', 'Fecha de radicación');
$objPHPExcel->getActiveSheet()->setCellValue('L6', 'Autoridad ambiental competente');

//******************************************** 1. otorgado; 2. En trámite ********************************************//
//Se declara fila y contador
$fila = 8;
$cont = 1;
$fila_inicial_titulos = $fila;
/*$fila_inicial = $fila;
$fila_inicial_bordes = 1;*/

//Se recorren los datos
foreach ($datos as $dato) {
	//Combinar celdas
	$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:B{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("C{$fila}:F{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("J{$fila}:K{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("L{$fila}:N{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $dato->Numero_Acto.' - '.$dato->Fecha_Acto);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $dato->Autoridad1);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $dato->Vigencia);
	//Según el tipo
	if ($dato->Tipo == "1") {
		$objPHPExcel->getActiveSheet()->setCellValue("H".$fila, "X");
	} else {
		$objPHPExcel->getActiveSheet()->setCellValue("I".$fila, "X");
	}//Fin if
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $dato->Fecha_Radicacion);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $dato->Autoridad2);

	//Aumentamos la fila
	$fila++;
}//Fin foreach datos

//Disminuimos una fila
$fila--;

//Estilos y bordes
$objPHPExcel->getActiveSheet()->getStyle('A4:N'.$fila)->applyFromArray($titulo_centrado);

//Aumentar fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:N{$fila}");

//Estilos y bordes
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}")->applyFromArray($titulo_centrado_negrita);

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "ESTADO DE CUMPLIMIENTO (INDICADORES DE CUMPLIMIENTO)");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:N{$fila}");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}")->applyFromArray($titulo_centrado);

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "3. USO DEL RECURSO");

//Aumentamos la fila
$fila++;

$fila_inicial = $fila;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:C{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("D{$fila}:E{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("F{$fila}:M{$fila}");


//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "FUENTE DE AGUA");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "CANTIDADES");
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "CAPTACIÓN");

//Aumentamos la fila
$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("N{$fila_inicial}:N{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "No.");
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "Superficial");
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "Subterránea");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "Autorizado");
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "Utilizado");
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Tipo de Captación");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "Nombre de la fuente");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "Aforo de la fuente");
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, "Coordenadas / Origen");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "Valor de la inversión");
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, "Valor 1%");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "Tasa por Uso");
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila_inicial, "PMA Relacionado");

//Aumentamos la fila
$fila++;

//Inicialización de contador
$cont = 1;

//******************************************** 3. Uso del recurso ********************************************//
foreach ($usos as $uso) {
	//Combinar celdas
	$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $cont);
	//Fuente de agua
	if ($uso->Fuente_Agua == "1") {
		$objPHPExcel->getActiveSheet()->setCellValue("B".$fila, "X");
	} else {
		$objPHPExcel->getActiveSheet()->setCellValue("C".$fila, "X");
	}//Fin if
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $uso->Autorizado);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $uso->Utilizado);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $uso->Tipo_Captacion);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $uso->Nombre_Fuente);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $uso->Aforo_Fuente);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $uso->Coordenadas);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $uso->Valor_Inversion);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $uso->Valor_1);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $uso->Tasa_Uso);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $uso->PMA_Relacionado);


	//Aumentamos la fila y el contador
	$fila++;
	$cont++;
}//Fin foreach usos

$fila_inicial = $fila;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:J{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:L{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "4. MONITOREO E INSPECCIÓN AMBIENTAL");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "5. NORMA NACIONAL / INTERNACIONAL");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "6. COMPROMISO EN EL ESTUDIO AMBIENTAL");
$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, "7. PROGRAMAS DEL PMA RELACIONADOS");

$fila++;

//Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells("N{$fila_inicial}:N{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "No.");
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, "Parámetros");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, "Unidad de Medición");
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "Valor");
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Método de toma de muestra");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "Método de análisis");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, "Fecha de muestreo");
$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, "Localización de punto de muestreo");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "No. Norma");
$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, "Valor");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "Valor");

//Aumentamos la fila
$fila++;

//******************************************** 4. Monitoreo e Inspección Ambiental ********************************************//
$cont = 1;
foreach ($monitoreos as $monitoreo) {
	//Combinar celdas
	$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");

	//Contenido
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $cont);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $monitoreo->Parametros);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $monitoreo->Unidad_Medicion);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $monitoreo->Valor_Medicion);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $monitoreo->Metodo_Muestra);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $monitoreo->Metodo_Analisis);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $monitoreo->Fecha_Muestreo);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $monitoreo->Localizacion_Muestreo);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $monitoreo->Numero_Norma);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $monitoreo->Valor_Norma);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $monitoreo->Valor_Compromiso);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $monitoreo->Pma_Relacionado);

	//Aumentamos la fila y el contador
	$fila++;
	$cont++;
}//Fin foreach monitoreos

$fila--;

//Estilos y bordes
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial_titulos}:N{$fila}")->applyFromArray($titulo_centrado);

$fila++;

//
$fila_inicial = $fila;

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:N{$fila}");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("A".$fila)->applyFromArray($titulo_izquierdo);

//Contenido
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "Obsevaciones:");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "PROFESIONAL RESPONSABLE");

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("K".$fila)->applyFromArray($titulo_centrado);

//Aumentamos la fila
$fila++;

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("K".$fila)->applyFromArray($titulo_izquierdo);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:N{$fila}");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "Nombre:");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(40);

//Aumentamos la fila
$fila++;

//Estilo
$objPHPExcel->getActiveSheet()->getStyle("K".$fila)->applyFromArray($titulo_izquierdo);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:N{$fila}");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "Firma:");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(40);

//Combinar celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila_inicial}:J{$fila}");

//Bordes
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$fila)->applyFromArray($bordes);


//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

$objPHPExcel->getActiveSheet()->setTitle("ICA 2b");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="ICA_2b.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>