<?php
//Se toma el id de la ficha
$id_ficha = $this->uri->segment(3);

//Se cargan las metas
$metas = $this->ica_model->cargar_metas($id_ficha);

//Se trae la información de la ficha
$ficha = $this->ica_model->informacion_ficha($id_ficha);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Indicador de Cumplimiento Ambiental 1a")
	->setDescription("Informe ICA 1a")
	->setKeywords("ica 1a informe cumplimiento ambiental")
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
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(5);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(25);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:I3');
$objPHPExcel->getActiveSheet()->mergeCells('J1:K1');
$objPHPExcel->getActiveSheet()->mergeCells('J2:K2');
$objPHPExcel->getActiveSheet()->mergeCells('J3:K3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
$objPHPExcel->getActiveSheet()->mergeCells('J4:K4');
$objPHPExcel->getActiveSheet()->mergeCells('H4:I4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:K5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:E6');
$objPHPExcel->getActiveSheet()->mergeCells('F6:G6');
$objPHPExcel->getActiveSheet()->mergeCells('H6:I6');
$objPHPExcel->getActiveSheet()->mergeCells('J6:K6');
$objPHPExcel->getActiveSheet()->mergeCells('B7:E7');

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('A1:K7')->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('J3:J4')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A6:K7')->applyFromArray($titulo_centrado);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ESTADO DE CUMPLIMIENTO DE LOS PROGRAMAS QUE CONFORMAN EL PLAN DE MANEJO AMBIENTAL'); //Titulo
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'FORMATO:');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'ICA - 1a');
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Hoja _ de _');
$objPHPExcel->getActiveSheet()->setCellValue('J4', 'CÓDIGO: '.$ficha->Numero);
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'PROGRAMA: '.$ficha->Nombre);
$objPHPExcel->getActiveSheet()->setCellValue('H4', 'Versión: '.$ficha->Version);
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'CUMPLIMIENTO DE METAS (INDICADORES DE ÉXITO)');
$objPHPExcel->getActiveSheet()->setCellValue('A6', '1. METAS');
$objPHPExcel->getActiveSheet()->setCellValue('F6', '2. PARÁMETROS DE CONTROL MEDIDO');
$objPHPExcel->getActiveSheet()->setCellValue('H6', '3. VALOR DE REFERENCIA O CARACTERÍSTICA DE CALIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('J6', '4. CUMPLIMIENTO');
$objPHPExcel->getActiveSheet()->setCellValue('A7', 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('B7', 'Descripción');
$objPHPExcel->getActiveSheet()->setCellValue('F7', 'Descripción');
$objPHPExcel->getActiveSheet()->setCellValue('G7', 'Valor');
$objPHPExcel->getActiveSheet()->setCellValue('H7', 'Descripción');
$objPHPExcel->getActiveSheet()->setCellValue('I7', 'Valor');
$objPHPExcel->getActiveSheet()->setCellValue('J7', 'Si');
$objPHPExcel->getActiveSheet()->setCellValue('K7', 'No');

//******************************************** Metas y parámetros ********************************************//
//Se declara fila y contador
$fila = 8;
$cont = 1;


//Se declara fila inicial
//$fila_inicial = $fila;

//Se recorren las metas
foreach ($metas as $meta) {
	//Se escriben las descripciones de las metas
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $cont); //Número de meta
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $meta->Descripcion); //Descripción de meta

	//Se combina
	//$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:E{$fila}");

	//Bordes
	$objPHPExcel->getActiveSheet()->getStyle("A{$fila}:K{$fila}")->applyFromArray($bordes);

	//Se cargan los parámetros de cada meta
	$parametros = $this->ica_model->cargar_parametros($meta->Pk_Id_Meta);

	//Contador de parámetros
	$cont_parametros = 0;

	//Fila inicial
	$fila_inicial = $fila;

	//Se recorren los parámetros de cada meta
	foreach ($parametros as $parametro) {
		//Se escriben esos parámetros
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $parametro->Parametro_Descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $parametro->Parametro_Valor);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $parametro->Calidad_Descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $parametro->Calidad_Valor);

		//Bordes
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':K'.$fila)->applyFromArray($bordes);

		//Estilos
		$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray($titulo_centrado);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray($titulo_centrado);

		//Si el parámetro cumple o no
		if ($parametro->Cumple == "1") {
			$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray($titulo_centrado);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, "X");
		} else {
			$objPHPExcel->getActiveSheet()->getStyle('K'.$fila, "X")->applyFromArray($titulo_centrado);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "X");
		}//Fin if

		//Se aumenta fila y contador
		$fila++;
		$cont_parametros++;
	}//Fin foreach parámetros

	$fila_final = $fila -1;

	//Si es mas de un parámetro, combinaremos las filas de la meta
	if ($cont_parametros > 0) {
		//Combinar celdas
		$objPHPExcel->getActiveSheet()->mergeCells("A{$fila_inicial}:A{$fila_final}");
		$objPHPExcel->getActiveSheet()->mergeCells("B{$fila_inicial}:E{$fila_final}");

		//Estilo centrado
		$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:A{$fila_final}")->applyFromArray($titulo_centrado);

		//Se reduce la fila para que no genere espacio en blanco
		$fila--;
	} else {
		//Se combina la fila unica
		$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:E{$fila}");

		//Estilo centrado
		$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:A{$fila_final}")->applyFromArray($titulo_centrado);
	}

 	//Aumentamos fila y contador
	$fila++;
	$cont++;
}//Fin foreach metas

//******************************************** Acciones ********************************************//
//Aumentamos la fila
$fila++;

//Se declara fila inicial
$fila_inicial = $fila;

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:B{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("C{$fila}:D{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("E{$fila}:F{$fila}");

//Altura de filas
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(25);

//Títulos
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, '5. ACCIONES DE MANEJO, CORRECCIÓN O COMPENSACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, '6. ACCIONES DE VERIFICACIÓN PERIÓDICA');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, '7. ACCIONES SEGÚN DE VERIFICACIÓN SEGÚN AVANCE');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, '8. OBSERVACIONES');
$fila++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, 'Descripción');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, 'Periodicidad de la verificación');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, '% de cumplimiento');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, '% de avance programado');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, '% de avance a la fecha');

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila_inicial}:K{$fila}");
//$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $fila);

/**
 * Aplicación de estilos
 */
$objPHPExcel->getActiveSheet()->getStyle('A'.$fila_inicial.':K'.$fila)->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A'.$fila_inicial.':K'.$fila)->applyFromArray($bordes);

//Aumentamos la fila
$fila++;

//Se inicializa un contador
$cont = 1;

//Fila inicial
$fila_inicial = $fila;

//Recorremos las metas para 
foreach ($metas as $meta) {
	//Se guarda la fila inicial
	$fila_inicial = $fila;

	//Se pinta la meta
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $cont);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $meta->Descripcion);

	//Se cargan las acciones por meta
	$acciones = $this->ica_model->cargar_acciones($meta->Pk_Id_Meta);

	//Bordes y estilos
	$objPHPExcel->getActiveSheet()->getStyle('A'.$fila_inicial.':K'.$fila)->applyFromArray($bordes);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':A'.$fila)->applyFromArray($titulo_centrado);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($titulo_centrado);

	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:K{$fila}");

	//Se aumenta la fila y el contador
	$fila++;
	$cont++;

	//Se recorren las acciones
	foreach ($acciones as $accion) {
		//Se pinta la accion
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $accion->Descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $accion->Periodicidad);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $accion->Porcentaje_Cumplimiento);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $accion->Porcentaje_Avance_Programado);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $accion->Porcentaje_Avance_Actual);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $accion->Observacion);

		//Celdas a combinar
		$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:K{$fila}");

		//Bordes y estilos
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':K'.$fila)->applyFromArray($bordes);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($titulo_centrado);
		$objPHPExcel->getActiveSheet()->getStyle("C{$fila}:F{$fila}")->applyFromArray($titulo_centrado);

		//Tamaño de celdas
		$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(60);

		//Se aumenta la fila
		$fila++;
	}//Fin foreach acciones
	
	//Se declara fila final
	$fila_final = $fila - 1;

	//Se combinan las celdas
	$objPHPExcel->getActiveSheet()->mergeCells("A{$fila_inicial}:A{$fila_final}");
}//Fin foreach metas

//******************************************** Pie ********************************************//
//Se combinan las celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:I{$fila}");
$objPHPExcel->getActiveSheet()->mergeCells("J{$fila}:K{$fila}");

//Titulos
$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, '9. PORCENTAJE DE CUMPLIMIENTO DEL PROGRAMA ');

//Estilos
$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($titulo_derecho);
$objPHPExcel->getActiveSheet()->getStyle("A{$fila}:K{$fila}")->applyFromArray($bordes);

//Se aumenta la fila
$fila++;

$fila_inicial = $fila;

//Se combinan las celdas
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:K{$fila}");

//Titulos
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'PROFESIONAL RESPONSABLE');

//Se aumenta la fila
$fila++;

//Se combinan las celdas
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:K{$fila}");

//Tamaño de celda
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

//Titulos
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'Nombre:');

//Se aumenta la fila
$fila++;

//Se combinan las celdas
$objPHPExcel->getActiveSheet()->mergeCells("G{$fila}:K{$fila}");

//Titulos
$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 'Firma:');

//Tamaño de celda
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

//Se combinan las celdas
$objPHPExcel->getActiveSheet()->mergeCells("A{$fila_inicial}:F{$fila}");

//Bordes
$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:K{$fila}")->applyFromArray($bordes);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="ICA_1a.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>