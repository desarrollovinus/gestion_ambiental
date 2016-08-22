<?php
// Datos por URL
$anio = $this->uri->segment(3);
$mes = $this->uri->segment(4);
$mes_nombre = $this->uri->segment(5);

// Se consultan las capacitaciones
$capacitaciones = $this->reporte_model->cargar_capacitaciones($anio, $mes);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Vinus S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Listado de capacitaciones al personal vinculado")
	->setDescription("En este listado se muestran las capacitaciones al personal vinculado por año y mes")
    ->setCategory("Reporte");

//Se establece la orientación de la hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT); //Orientacion horizontal
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamaño carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(55); //Escala

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(11); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada
$objPHPExcel->getActiveSheet()->setTitle('Capacitaciones'); //Titulo de la hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true); // Centrar página

// Ocultar las cuadrículas
$objPHPExcel->getActiveSheet()->setShowGridlines(true);

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(9);

//Se establecen las margenes
// $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1); //Arriba
// $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.6); //Derecha
// $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.6); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1); //Abajo

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(50);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A1:A3");
$objPHPExcel->getActiveSheet()->mergeCells("A5:I5");
$objPHPExcel->getActiveSheet()->mergeCells("A7:C8");
$objPHPExcel->getActiveSheet()->mergeCells("B1:G1");
$objPHPExcel->getActiveSheet()->mergeCells("B2:G3");
$objPHPExcel->getActiveSheet()->mergeCells("D7:F7");
$objPHPExcel->getActiveSheet()->mergeCells("G7:G8");
$objPHPExcel->getActiveSheet()->mergeCells("H7:H8");
$objPHPExcel->getActiveSheet()->mergeCells("I7:I8");
$objPHPExcel->getActiveSheet()->mergeCells("H1:H3");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("I")->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));

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

// Título centrado y en negrita
$titulo_centrado_negrita = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

//Relleno 1
$relleno1 = array(
	'fill' => array(
	    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	    'rotation' => 90,
	    'startcolor' => array(
  	  		'argb' => 'FF5454'
        ),
	    'endcolor' => array(
			'argb' => 'FF5454'
    	),
    ),
);

$centrado = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER ) ); // Alineación centrada

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Período a reportar: '.$mes_nombre);
$objPHPExcel->getActiveSheet()->setCellValue('A7', 'TEMA');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CONCESIÓN VÍAS DEL NUS - VINUS');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'FORMATO DE REGISTRO DE CONSOLIDADO DE EDUCACIÓN Y CAPACITACIÓN A TRABAJADORES');
$objPHPExcel->getActiveSheet()->setCellValue('D7', 'FECHA DE CAPACITACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('D8', 'DD');
$objPHPExcel->getActiveSheet()->setCellValue('E8', 'MM');
$objPHPExcel->getActiveSheet()->setCellValue('F8', 'AAA');
$objPHPExcel->getActiveSheet()->setCellValue('G7', 'Nro. TRABAJADORES OBJETO DE CAPACITACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('H7', 'Nro. TRABAJADORES CAPACITADOS');
$objPHPExcel->getActiveSheet()->setCellValue('I7', '% TRABAJADORES CAPACITADOS');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Código: F026');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Versión: 1.00');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Fecha: 12/08/2016');

// logo ANI
$objDrawing2 = new PHPExcel_Worksheet_Drawing();
$objDrawing2->setName('Logo ANI');
$objDrawing2->setDescription('Logo de uso exclusivo de ANI');
$objDrawing2->setPath('./img/logo_ani.jpg');
$objDrawing2->setCoordinates('A1');
// $objDrawing2->setHeight(50);
$objDrawing2->setWidth(140);
$objDrawing2->setOffsetX(45);
$objDrawing2->setOffsetY(5);
$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());

// Logo Vinus
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Vinus');
$objDrawing->setDescription('Logo de uso exclusivo de Vinus');
$objDrawing->setPath('./img/logo_vinus.png');
$objDrawing->setCoordinates('H1');
// $objDrawing->setHeight(60);
$objDrawing->setWidth(90);
$objDrawing->setOffsetX(30);
$objDrawing->setOffsetY(5);
$objDrawing->getShadow()->setDirection(160);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Fila inicial
$fila = 9;

// Se recorren las capacitaciones
foreach ($capacitaciones as $capacitacion) {
	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:C{$fila}");

	// Datos
	$objPHPExcel->getActiveSheet()->setDinamicSizeRow($capacitacion->Nombre, $fila, "A:C");
	$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", str_pad($capacitacion->Dia, 2, 0, STR_PAD_LEFT));
	$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", str_pad($capacitacion->Mes, 2, 0, STR_PAD_LEFT));
	$objPHPExcel->getActiveSheet()->setCellValue("F{$fila}", $capacitacion->Anio);
	$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", $capacitacion->Convocados);
	$objPHPExcel->getActiveSheet()->setCellValue("H{$fila}", $capacitacion->Capacitados);

	// Si los capacitados es menor a 1
	if ($capacitacion->Convocados < 1) {
		$convocados = 1;
	} else {
		$convocados = $capacitacion->Convocados;
	} // if

	$porcentaje_capacitados = $capacitacion->Capacitados / $convocados;

	$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", $porcentaje_capacitados);

	// Estilos
	$objPHPExcel->getActiveSheet()->getStyle("D{$fila}")->getNumberFormat()->setFormatCode('00');
	$objPHPExcel->getActiveSheet()->getStyle("E{$fila}")->getNumberFormat()->setFormatCode('00');

	// Si el porcentaje es mayor a 100%
	if ($porcentaje_capacitados > 1) {
		// Relleno rojo
		$objPHPExcel->getActiveSheet()->getStyle("I{$fila}")->applyFromArray($relleno1);
	} // if

	// Aumento de fila
	$fila++;
} // foreach

// Disminución de fila
$fila--;

$objPHPExcel->getActiveSheet()->getStyle("A7:I{$fila}")->applyFromArray($bordes);

// Aumento de fila
$fila++;

// Aumento de fila
$fila++;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:B{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("C{$fila}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:I{$fila}");

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(45);

// Consultas
$vinculados_mes = $this->reporte_model->contar_vinculados_mes($anio, $mes);
$capacitados_mes = $this->reporte_model->contar_capacitados_mes($anio, $mes);
$vinculados_a_fecha = $this->reporte_model->contar_vinculados_a_fecha($anio, $mes);

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "TOTAL DE TRABAJADORES VINCULADOS AL PROYECTO EN EL PERÍODO");
$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", "TOTAL DE TRABAJADORES CAPACITADOS EN EL PERÍODO");
$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", "% TOTAL DE TRABAJADORES CAPACITADOS EN EL PERÍODO (Sobre {$vinculados_a_fecha} vinculados a la fecha en Vinus)");


// Fila temporal
$fila_temporal = $fila;

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}:I{$fila}")->applyFromArray($titulo_centrado_negrita);


// Aumento de fila
$fila++;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:B{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("C{$fila}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:I{$fila}");

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", $vinculados_mes);
$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", $capacitados_mes);
$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", $capacitados_mes / $vinculados_a_fecha);

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A1:I3")->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle("A1:I3")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("A7:I8")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("A7:I8")->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle("A5:I5")->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_temporal}:I{$fila}")->applyFromArray($centrado);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_temporal}:I{$fila}")->applyFromArray($bordes);
// Estilos
$objPHPExcel->getActiveSheet()->getStyle("G{$fila}")->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));

// Aumento de fila
$fila++;
$fila++;

// Fila temporal
$fila_temporal = $fila;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:D{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("E{$fila}:I{$fila}");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}:I{$fila}")->applyFromArray($centrado);

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "Profesional social concesionario");
$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", "Profesional social interventoría que verifica");

// Aumento de fila
$fila++;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:D{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("E{$fila}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:I{$fila}");

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "Nombre");
$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", "Nombre");

// Aumento de fila
$fila++;

// Definición de altura de las filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(45);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:D{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("E{$fila}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:I{$fila}");

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "Firma");
$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", "Firma");

// Aumento de fila
$fila++;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:D{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("E{$fila}:F{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:I{$fila}");

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "Cédula");
$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", "Cédula");

// Aumento de fila
$fila++;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:I{$fila}");

// Datos
$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", "Fecha: ");

// Estilos
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_temporal}:I{$fila}")->applyFromArray($bordes);

// Aumento de fila
$fila++;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:I{$fila}");

/*
 *
 * Pie de pagina
 *
 */
//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&HPlease treatthis document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Capacitaciones '.$mes_nombre.' de '.$anio.'.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>