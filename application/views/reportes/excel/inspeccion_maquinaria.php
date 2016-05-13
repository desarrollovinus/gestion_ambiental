<?php
// Se toma el id de la maquinaria
$id_maquinaria = $this->uri->segment(3);

// Se consultan los estados
$estados = $this->siso_model->cargar_estados_maquinas();

// Se cargan los datos de la máquina
$maquina = $this->siso_model->listar_inspeccion_maquinaria($id_maquinaria);

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Inspección de maquinaria")
	->setDescription("En este reporte se registra la inspección de maquinaria individual")
	->setKeywords("ínspeccion maquinaria hatovial siso socio ambiental")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT); //Orientacion vertical
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); //Escala

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
// $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0,90); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0,70); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0,70); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,500); //Abajo

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

// Título centrado
$titulo_centrado = array(
	'font' => array(
		'bold' => false
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)
);

// Título alineado a la derecha
$titulo_derecho = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
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

// Borde simple gris
$borde_gris = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'argb' => '868686'
            )
        ),
    ),
);

//Borde exterior simple
$bordes_externos = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'argb' => '000000'
            )
        ),
    ),
);

// Borde exterior grueso
$bordes_externos_negrita = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
            'color' => array(
                'argb' => '000000'
            )
        ),
    ),
);

// Celdas color gris
$color_titulos = array(
	'fill' => array(
	    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	    'rotation' => 90,
	    'startcolor' => array(
  	  		'argb' => 'BCBABA'
        ),
	    'endcolor' => array(
			'argb' => 'BCBABA'
    	),
    ),
);

//Centrar página
$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered();

//Logo
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo Hatovial S.A.S.');
$objDrawing->setDescription('Logo de uso exclusivo de Hatovial S.A.S.');
$objDrawing->setPath('./img/logo2.png');
$objDrawing->setCoordinates('A1');
$objDrawing->setHeight(35);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objDrawing->getShadow()->setDirection(45);

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(23);
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(5);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
$objPHPExcel->getActiveSheet()->mergeCells('N1:P1');
$objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
$objPHPExcel->getActiveSheet()->mergeCells('D3:E3');
$objPHPExcel->getActiveSheet()->mergeCells('D4:E4');
$objPHPExcel->getActiveSheet()->mergeCells('F3:I3');
$objPHPExcel->getActiveSheet()->mergeCells('F4:I4');
$objPHPExcel->getActiveSheet()->mergeCells('J3:M3');
$objPHPExcel->getActiveSheet()->mergeCells('J4:M4');
$objPHPExcel->getActiveSheet()->mergeCells('N3:P3');
$objPHPExcel->getActiveSheet()->mergeCells('A5:B6');
$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
$objPHPExcel->getActiveSheet()->mergeCells('F5:F6');
$objPHPExcel->getActiveSheet()->mergeCells('G5:I6');
$objPHPExcel->getActiveSheet()->mergeCells('J5:K6');
$objPHPExcel->getActiveSheet()->mergeCells('L5:N6');
$objPHPExcel->getActiveSheet()->mergeCells('O5:P6');
$objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
$objPHPExcel->getActiveSheet()->mergeCells('J7:K7');
$objPHPExcel->getActiveSheet()->mergeCells('O7:P7');
$objPHPExcel->getActiveSheet()->mergeCells('A8:C8');
$objPHPExcel->getActiveSheet()->mergeCells('D8:F8');
$objPHPExcel->getActiveSheet()->mergeCells('G8:J8');
$objPHPExcel->getActiveSheet()->mergeCells('K8:P8');
$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
$objPHPExcel->getActiveSheet()->mergeCells('C10:D10');
$objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
$objPHPExcel->getActiveSheet()->mergeCells('G10:I10');
$objPHPExcel->getActiveSheet()->mergeCells('J10:P12');
$objPHPExcel->getActiveSheet()->mergeCells('B11:F11');
$objPHPExcel->getActiveSheet()->mergeCells('B12:I12');

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'INSPECCIÓN DE MAQUINARIA');
$objPHPExcel->getActiveSheet()->setCellValue('N1', '12.F31');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Obra');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Máquina o equipo');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Operador');
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Identificación');
$objPHPExcel->getActiveSheet()->setCellValue('N3', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Desarrollo Vial del Aburrá Norte');
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Código Máquina');
$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Licencia de conducción del operador');
$objPHPExcel->getActiveSheet()->setCellValue('C6', 'Categoría');
$objPHPExcel->getActiveSheet()->setCellValue('D6', 'Corresponde a la categoría');
$objPHPExcel->getActiveSheet()->setCellValue('E6', 'Vigencia');
$objPHPExcel->getActiveSheet()->setCellValue('F5', '¿Requiere SOAT?');
$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Vence');
$objPHPExcel->getActiveSheet()->setCellValue('J5', '¿Requiere Revisión Técnico Mecánica?');
$objPHPExcel->getActiveSheet()->setCellValue('L5', 'Vence');
$objPHPExcel->getActiveSheet()->setCellValue('O5', 'Horómetro o kilometraje actual');
$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Firma operador');
$objPHPExcel->getActiveSheet()->setCellValue('G8', 'Firma gestor CASS');
$objPHPExcel->getActiveSheet()->setCellValue('A10', 'B-->Bueno');
$objPHPExcel->getActiveSheet()->setCellValue('C10', 'M-->Malo');
$objPHPExcel->getActiveSheet()->setCellValue('E10', 'N.A.-->No Aplica');
$objPHPExcel->getActiveSheet()->setCellValue('G10', 'Estado');
$objPHPExcel->getActiveSheet()->setCellValue('J10', 'Observaciones');
$objPHPExcel->getActiveSheet()->setCellValue('A11', 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('B11', 'Descripción');
$objPHPExcel->getActiveSheet()->setCellValue('G11', 'B');
$objPHPExcel->getActiveSheet()->setCellValue('H11', 'M');
$objPHPExcel->getActiveSheet()->setCellValue('I11', 'N/A');
$objPHPExcel->getActiveSheet()->setCellValue('A12', 'A');
$objPHPExcel->getActiveSheet()->setCellValue('B12', 'Estado de la máquina');

// Datos de encabezado
$objPHPExcel->getActiveSheet()->setCellValue('D4', $maquina->Tipo);
$objPHPExcel->getActiveSheet()->setCellValue('F4', $maquina->Operador);
$objPHPExcel->getActiveSheet()->setCellValue('J4', $maquina->Documento);
$objPHPExcel->getActiveSheet()->setCellValue('N4', date("d", strtotime($maquina->Fecha_Creacion)));
$objPHPExcel->getActiveSheet()->setCellValue('O4', date("m", strtotime($maquina->Fecha_Creacion)));
$objPHPExcel->getActiveSheet()->setCellValue('P4', date("Y", strtotime($maquina->Fecha_Creacion)));
$objPHPExcel->getActiveSheet()->setCellValue('A7', $maquina->Nombre);
$objPHPExcel->getActiveSheet()->setCellValue('C7', $maquina->Categoria);
$objPHPExcel->getActiveSheet()->setCellValue('D7', $maquina->Categoria_Observacion);
$objPHPExcel->getActiveSheet()->setCellValue('E7', $maquina->Fecha_Vigencia);
$objPHPExcel->getActiveSheet()->setCellValue('F7', $maquina->Soat_Requerido);
$objPHPExcel->getActiveSheet()->setCellValue('G7', date("d", strtotime($maquina->Fecha_Vencimiento_Soat)));
$objPHPExcel->getActiveSheet()->setCellValue('H7', date("m", strtotime($maquina->Fecha_Vencimiento_Soat)));
$objPHPExcel->getActiveSheet()->setCellValue('I7', date("Y", strtotime($maquina->Fecha_Vencimiento_Soat)));
$objPHPExcel->getActiveSheet()->setCellValue('J7', $maquina->Revision_requerida);
$objPHPExcel->getActiveSheet()->setCellValue('L7', date("d", strtotime($maquina->Fecha_Vencimiento_Revision)));
$objPHPExcel->getActiveSheet()->setCellValue('M7', date("m", strtotime($maquina->Fecha_Vencimiento_Revision)));
$objPHPExcel->getActiveSheet()->setCellValue('N7', date("Y", strtotime($maquina->Fecha_Vencimiento_Revision)));
$objPHPExcel->getActiveSheet()->setCellValue('O7', $maquina->Horometro);

//Firma
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Firma operador');
$objDrawing->setDescription('Logo de uso exclusivo de Hatovial S.A.S.');
$objDrawing->setPath('./archivos/firmas/'.$maquina->Pk_Id_Siso_Maquinaria.'.png');
$objDrawing->setCoordinates('D8');
$objDrawing->setHeight(25);
$objDrawing->setOffsetX(45);
$objDrawing->setOffsetY(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objDrawing->getShadow()->setDirection(40);
 $objPHPExcel->getActiveSheet()->getStyle('D8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// Declaraciones de fila
$fila_inicial = 13;
$fila = 13;
$cont = 1;

// Se recorren los estados
foreach ($estados as $estado) {
	// Consultamos si el estado ha sido marcado para esta inspección
	$marca = $this->siso_model->consultar_marcado($id_maquinaria, $estado->Pk_Id_Valor);

	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:F{$fila}");
	$objPHPExcel->getActiveSheet()->mergeCells("J{$fila}:P{$fila}");

	// Contenido
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", $cont);
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $estado->Nombre);

	// Si el estado se marcó dentro de la inspección
	if(isset($marca->Valor)){
		// Dependiendo donde esté marcado
		switch ($marca->Valor) {
			case '0':
				// Se marca como malo
				$objPHPExcel->getActiveSheet()->setCellValue("H{$fila}", "X");
				break;
			
			case '1':
				// Se marca como bueno
				$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", "X");
				break;

			case '2':
				// Se marca como N/A
				$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", "X");
				break;
		}

		// Observación
		$objPHPExcel->getActiveSheet()->setCellValue("J{$fila}", $marca->Observacion);
	} // if

	//Si el estado tiene más de 50 caracteres
	if(strlen($estado->Nombre) > 45){
		// Ampliamos la altura de la fila
		$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(32);
	} // if

	// Aumento del contador y fila
	$cont++;
	$fila++;
} // foreach estados

//Se disminuye una fila
$fila--;

/**
 * Formato del texto
 */
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A3:N3')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A5:P6')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle('A8:P12')->applyFromArray($titulo_centrado);
$objPHPExcel->getActiveSheet()->getStyle("G{$fila_inicial}:I{$fila}")->applyFromArray($titulo_centrado);

/**
 * Forato de los colores
 */
$objPHPExcel->getActiveSheet()->getStyle('A3:P3')->applyFromArray($color_titulos);
$objPHPExcel->getActiveSheet()->getStyle('A5:O5')->applyFromArray($color_titulos);
$objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($color_titulos);
$objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($color_titulos);
$objPHPExcel->getActiveSheet()->getStyle('A12:I12')->applyFromArray($color_titulos);
$objPHPExcel->getActiveSheet()->getStyle('J10')->applyFromArray($color_titulos);

/**
 * Formato de los bordees
 */
$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($borde_gris);
$objPHPExcel->getActiveSheet()->getStyle('A3:P8')->applyFromArray($borde_gris);
$objPHPExcel->getActiveSheet()->getStyle("A10:P{$fila}")->applyFromArray($borde_gris);
$objPHPExcel->getActiveSheet()->getStyle('A3:P8')->applyFromArray($bordes_externos);
$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($bordes_externos_negrita);
$objPHPExcel->getActiveSheet()->getStyle("A10:P{$fila}")->applyFromArray($bordes_externos);
$objPHPExcel->getActiveSheet()->getStyle('A3:P8')->applyFromArray($bordes_externos);

// Aumento de la fila
$fila++;

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(5);

// Aumento de la fila
$fila++;

// Fila inicial
$fila_inicial = $fila;

// Si hay hallazgos
if ($maquina->Hallazgos > 0) {
	/**
	 * Definición de altura de las filas
	 */
	$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(22);

	//Celdas a combinar
	$objPHPExcel->getActiveSheet()->mergeCells("A{$fila_inicial}:E{$fila_inicial}");
	$objPHPExcel->getActiveSheet()->mergeCells("F{$fila_inicial}:H{$fila_inicial}");
	$objPHPExcel->getActiveSheet()->mergeCells("I{$fila_inicial}:J{$fila_inicial}");
	$objPHPExcel->getActiveSheet()->mergeCells("K{$fila_inicial}:M{$fila_inicial}");
	$objPHPExcel->getActiveSheet()->mergeCells("N{$fila_inicial}:P{$fila_inicial}");

	//Encabezados
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila_inicial}", 'Correcciones a realizar - Acciones de mejora');
	$objPHPExcel->getActiveSheet()->setCellValue("F{$fila_inicial}", 'Responsable (maquinaria y equipo)');
	$objPHPExcel->getActiveSheet()->setCellValue("I{$fila_inicial}", 'Firma');
	$objPHPExcel->getActiveSheet()->setCellValue("K{$fila_inicial}", 'Fecha programada');
	$objPHPExcel->getActiveSheet()->setCellValue("N{$fila_inicial}", 'Fecha ejecución');

	// Recorrido para las celdas vacías
	for ($i = 0; $i <= $maquina->Hallazgos; $i++) {
		// Combinación de celdas
		$objPHPExcel->getActiveSheet()->mergeCells("A{$fila}:E{$fila}");
		$objPHPExcel->getActiveSheet()->mergeCells("F{$fila}:H{$fila}");
		$objPHPExcel->getActiveSheet()->mergeCells("I{$fila}:J{$fila}");
		$objPHPExcel->getActiveSheet()->mergeCells("K{$fila}:M{$fila}");
		$objPHPExcel->getActiveSheet()->mergeCells("N{$fila}:P{$fila}");

		// Ampliamos la altura de la fila
		$objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(20);

		// Aumentar fila
	    $fila++;
	} // for

	// Reducir fila
	$fila--;

	/**
	 * Formato de los bordees
	 */
	$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:P{$fila}")->applyFromArray($borde_gris);
	$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:P{$fila}")->applyFromArray($bordes_externos);

	/**
	 * Forato de los colores
	 */
	$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:P{$fila_inicial}")->applyFromArray($color_titulos);

	/**
	 * Formato del texto
	 */
	$objPHPExcel->getActiveSheet()->getStyle("A{$fila_inicial}:P{$fila_inicial}")->applyFromArray($titulo_centrado);
}

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Inspección de maquinaria");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Inspeccion_Maquinaria.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>