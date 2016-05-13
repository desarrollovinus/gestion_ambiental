<?php
//Desde base de datos se traen las fichas con sus versiones creadas
$fichas = $this->reporte_model->ICA_0($this->uri->segment(3));

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("ICA 0 - Estructura del Plan de Manejo Ambiental")
	->setDescription("En este listado se muestran las fichas del ICA 0 y las versiones creadas para las mismas")
	->setKeywords("ICA 0 ambiental lista estructura plan manejo ambiental")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9); //Tamaño
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada
$objPHPExcel->getActiveSheet()->setTitle('ICA 0'); //Titulo de la hoja

//Se establece la orientación de la hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamaño carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); //Escala

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(5);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.6); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.6); //Izquierda
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1); //Abajo

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

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

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:F3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:G4');

/**
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);

/**
 * Encabezado
 */
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'ESTRUCTURA DEL PLAN DE MANEJO AMBIENTAL')
->setCellValue('G1', 'FORMATO:')
->setCellValue('G2', 'ICA-0')
->setCellValue('G3', 'Hoja _ de _')
->setCellValue('A4', 'CODIFICACIÓN DE PROGRAMAS Y PROYECTOS O FICHAS')
->setCellValue('A5', '1. CÓDIGO')
->setCellValue('B5', '2. DESCRIPCIÓN')
->setCellValue('C5', '3. VERSIÓN APROBADA/FECHA')
->setCellValue('E5', '1. CÓDIGO')
->setCellValue('F5', '2. DESCRIPCIÓN')
->setCellValue('G5', '3. VERSIÓN APROBADA/FECHA')
/*
->setCellValue('A25', 'Observaciones Generales:')
*/;

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:G2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A4:G5')->applyFromArray($titulo_centrado_negrita);

//Obtengo el total de fichas
$total_fichas = count($fichas);

//Divido el total de fichas en dos, para la posterior creacion de las columnas
$fichas_por_columna = round(($total_fichas / 2), 0, PHP_ROUND_HALF_UP);

//Creo un arreglo donde almaceno la primera mitad
$columna1 = array_slice($fichas, 0, $fichas_por_columna);

//En un segundo arreglo, guardo la otra mitad de datos del arreglo de fichas
$columna2 = array_slice($fichas, $fichas_por_columna, $total_fichas);

//Se declara laa filaa donde se empezarán a ingresar los contenidos
$fila_columna1 = 6;
$fila_columna2 = 6;

//Se recorren las fichas de la primera columna
foreach ($columna1 as $ficha) {
	//Imprimo los datos
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$fila_columna1, $ficha->Codigo)
		->setCellValue('B'.$fila_columna1, $ficha->Nombre)
		->setCellValue('C'.$fila_columna1, $ficha->Version);

	//Aumento el contador de filas de la primera columna
	$fila_columna1++;
}//Fin foreach columna1

//Se recorren las fichas de la segunda columna
foreach ($columna2 as $ficha) {
	//Imprimo los datos
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('E'.$fila_columna2, $ficha->Codigo)
		->setCellValue('F'.$fila_columna2, $ficha->Nombre)
		->setCellValue('G'.$fila_columna2, $ficha->Version);

	//Aumento el contador de filas de la segunda columna
	$fila_columna2++;
}//Fin foreach columna2

/**
 * Contenido del pié de página
 */
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A{$fila_columna1}", 'Observaciones Generales:')
	->setCellValue("G{$fila_columna1}", 'PROFESIONAL RESPONSABLE')
	->setCellValue('G'.number_format($fila_columna1 + 1), 'Nombre:')
	->setCellValue('G'.number_format($fila_columna1 + 2), 'Firma:');

//
$fila_final = $fila_columna1 -1;

/**
 * Aplicacion de estilos al contenido y al pie de página
 */

$objPHPExcel->getActiveSheet()->getStyle('A1:G'.number_format($fila_final + 3))->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle('A6:A'.$fila_final)->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('C6:C'.$fila_final)->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('D6:D'.$fila_final)->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('G6:G'.$fila_final)->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila_columna1.':F'.number_format($fila_columna1 + 2)); //Combinacion de celdas
$objPHPExcel->getActiveSheet()->mergeCells('D5:D'.$fila_final); //Combinacion de celdas
$objPHPExcel->getActiveSheet()->getStyle('A'.$fila_columna1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); //Alineacion de celdas
$objPHPExcel->getActiveSheet()->getStyle('G'.number_format($fila_final + 2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); //Alineacion de celdas
$objPHPExcel->getActiveSheet()->getStyle('G'.number_format($fila_final + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); //Alineacion 
$objPHPExcel->getActiveSheet()->getStyle('G'.$fila_columna1)->applyFromArray($titulo_centrado_negrita);

/**
 * Definicion de la altura de las celdas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(number_format($fila_final + 2))->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(number_format($fila_final + 3))->setRowHeight(30);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Estructura del Plan de Manejo Ambiental.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>