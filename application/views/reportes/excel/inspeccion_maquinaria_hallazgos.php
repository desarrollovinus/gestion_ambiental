<?php
// Se listan los hallazgos
$hallazgos = $this->siso_model->cargar_hallazgos();

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Hallazgos luego de la inspección de maquinaria")
	->setDescription("En este reporte se registran los hallazgos de la inspección de maquinaria individual")
	->setKeywords("inspeccion maquinaria hatovial hallazgos siso socio ambiental")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(7); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);// Alineacion centrada

//Se establece la configuracion de la pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT); //Orientacion vertical
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100); //Escala

//Se indica el rango de filas que se van a repetir en el momento de imprimir. (Encabezado del reporte)
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2);

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

/*
 * Definicion de la anchura de las columnas
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'CONTROL DE INSPECCIÓN DE MAQUINARIA - HALLAZGOS');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'CÓDIGO DE LA MÁQUINA');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'FECHA DE LA INSPECCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'HALLAZGO');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'ACCIÓN DE MEJORA');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'RESPONSABLE');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'FECHA DE EJECUCIÓN');

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);

//Celdas a combinar
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');

// Declaraciones de fila
$fila_inicial = 3;
$fila = 3;
$cont = 1;

// Recorrido de los hallazgos
foreach ($hallazgos as $hallazgo) {
	// Datos
	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", $cont);
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $hallazgo->Maquina);
	$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", date('Y-m-d (h:i)', strtotime($hallazgo->Fecha_Creacion)));
	$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", $hallazgo->Descripcion);
	$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", $hallazgo->Accion_Mejora);
	$objPHPExcel->getActiveSheet()->setCellValue("F{$fila}", $hallazgo->Nombres.' '.$hallazgo->Apellidos);
	$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", $hallazgo->Fecha_Mejora);

	//Aumento de contadores
	$fila++;
	$cont++;
}// foreach

// Disminución de la fila
$fila--;

/**
 * Estiloa
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:G2')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle("A1:G{$fila}")->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()->getStyle('A1:G2')->applyFromArray($color_titulos);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Hallazgos");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Hallazgos.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>