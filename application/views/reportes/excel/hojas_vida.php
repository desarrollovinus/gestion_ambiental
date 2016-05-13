<?php
// Se amplía la memoria para que soporte todos los datos
ini_set('memory_limit', '-1');

//Define si es para hojas de vida recibida o vinculados
$tipo = $this->uri->segment(3);

//Si son 
if ($tipo == "0") {
	//Se obtienen del modelo las hojas de vida
	$curriculos = $this->hoja_vida_model->listado_reporte_consolidado();
}else{
	//Se obtienen del modelo las hojas de vida
	$curriculos = $this->hoja_vida_model->listado_reporte($tipo);
}

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Consolidado de hojas de vida")
	->setDescription("Hojas de vida hatovial sas")
	->setKeywords("Consolidado ICA Hojas Vida Hatovial SAS")
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
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2);

//Se establecen las margenes
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0,90); //Arriba
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0,70); //Derecha
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0,70); //Izquierda
// $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0,500); //Abajo

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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);

/**
 * Definición de altura de las filas
 */
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);

//Celdas a combinar
// $objPHPExcel->getActiveSheet()->mergeCells('A1:T1');

//Encabezados
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Recepción');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Documento');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Nombres');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Teléfono');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Fecha de Nacimiento');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Edad');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Cargo');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Municipio');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Barrio / Vereda');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Dirección');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Tramo');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Frente');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Operaciones / Obra');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Calificado');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Contratado');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Contratista');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Observaciones');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Sexo');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Ubicación');

//Fila para iniciar el contenido
$fila = 2;

//Contador
$cont = 1;

//Recorrido de las hojas de vida
foreach ($curriculos as $curriculo) {
	// echo date('d-m-Y', strtotime($curriculo->Fecha_Nacimiento)).": ";
	// echo $this->hoja_vida_model->calcular_edad(date('d-m-Y', strtotime($curriculo->Fecha_Nacimiento)))."<br>";

	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", $cont);
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $curriculo->Fecha_Recepcion);
	$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", $curriculo->Documento);
	$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", $curriculo->Nombres);
	$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", $curriculo->Telefono);
	$objPHPExcel->getActiveSheet()->setCellValue("F{$fila}", $curriculo->Fecha_Nacimiento);
	$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", $this->hoja_vida_model->calcular_edad(date('d-m-Y', strtotime($curriculo->Fecha_Nacimiento))));
	$objPHPExcel->getActiveSheet()->setCellValue("H{$fila}", $curriculo->Oficio);
	$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", $curriculo->Municipio);
	$objPHPExcel->getActiveSheet()->setCellValue("J{$fila}", $curriculo->Sector);
	$objPHPExcel->getActiveSheet()->setCellValue("K{$fila}", $curriculo->Direccion);
	$objPHPExcel->getActiveSheet()->setCellValue("L{$fila}", $curriculo->Tramo);
	$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $curriculo->Frente);
	$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", $curriculo->Labor_Ejecutada);
	$objPHPExcel->getActiveSheet()->setCellValue("O{$fila}", $curriculo->Calificado);
	$objPHPExcel->getActiveSheet()->setCellValue("P{$fila}", $curriculo->Contratado);
	$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila}", $curriculo->Subcontratista);
	$objPHPExcel->getActiveSheet()->setCellValue("R{$fila}", $curriculo->Observaciones);
	$objPHPExcel->getActiveSheet()->setCellValue("S{$fila}", $curriculo->Genero);
	$objPHPExcel->getActiveSheet()->setCellValue("T{$fila}", $curriculo->Ubicacion_Fisica);

	//Aumentamos la fila y contador
	$fila++;
	$cont++;
}

$fila--;

/**
 * Aplicacion de los estilos a la cabecera
 */
$objPHPExcel->getActiveSheet()->getStyle('A1:T1')->applyFromArray($titulo_centrado_negrita);
$objPHPExcel->getActiveSheet()->getStyle('A1:T'.$fila)->applyFromArray($bordes);

//Pié de página
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .$objPHPExcel->getProperties()->getTitle() . '&RPágina &P de &N');

//Título de la hoja
$objPHPExcel->getActiveSheet()->setTitle("Hojas de vida");

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Hojas de vida.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>