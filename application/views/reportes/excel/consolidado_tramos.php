<?php
//Se ejecuta el modelo que crea una hoja por cada anio que tenga solicitudes
$anios = $this->reporte_model->listar_anios();
$tramos = $this->solicitud_model->cargar_tramos();

//Se crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("John Arley Cano Salinas - Hatovial S.A.S.")
	->setLastModifiedBy("John Arley Cano Salinas")
	//->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Listado de solicitudes por tramo")
	->setDescription("En este listado se muestran las solicitudes Clasificadas por tramo y por mes")
	->setKeywords("consolidado listado solicitudes ambiental mensual")
    ->setCategory("Reporte");

//Definicion de las configuraciones por defecto en todo el libro
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica'); //Tipo de letra
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10); //Tamanio
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);//Ajuste de texto
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);// Alineacion centrada

//Estilo de los titulos
$estilo_titulos = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	),
);

//estilo de las celdas que totalizan
$estilo_totales = array(
	'font' => array(
		'bold' => true	
	)
);

//Estilo de los bordes
$bordes = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'argb' => 'FFFFFF'
            )
        ),
    ),
);

//Relleno 1
$relleno1 = array(
	'fill' => array(
	    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	    'rotation' => 90,
	    'startcolor' => array(
  	  		'argb' => 'DBDBDB'
        ),
	    'endcolor' => array(
			'argb' => 'DBDBDB'
    	),
    ),
);

//Relleno 2
$relleno2 = array(
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

//Relleno titulos
$relleno_titulos = array(
	'fill' => array(
	    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	    'rotation' => 90,
	    'startcolor' => array(
  	  		'argb' => '979797'
        ),
	    'endcolor' => array(
			'argb' => '979797'
    	),
    ),
);

//Se declara el numero de la hoja en la que se va a trabajar
$hoja = 1;

//Se hace el recorrido por anios
foreach ($anios as $anio){
	//Si la hoja es la primera
	if($hoja === 1){
		$hoja = $objPHPExcel->getActiveSheet()->setTitle($anio->Anio); //Titulo de la hoja
	}else{
		$hoja = $objPHPExcel->createSheet($anio->Anio); //Nueva hoja
		$hoja->setTitle($anio->Anio);//Titulo de la hoja
	}//Fin if anios

	//Se establece la configuracion de la pagina
	$hoja->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Orientacion horizontal
	$hoja->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER); //Tamano carta
	$hoja->getPageSetup()->setScale(100); //Escala

	//Se establecen las margenes
	$hoja->getPageMargins()->setTop(0,90); //Arriba
	$hoja->getPageMargins()->setRight(0,70); //Derecha
	$hoja->getPageMargins()->setLeft(0,70); //Izquierda
	$hoja->getPageMargins()->setBottom(0,90); //Abajo

	//Celdas a combinar
	$hoja->mergeCells('A1:N3');
	
	/*
	 * Definicion de la anchura de las columnas
	 */
	$hoja->getColumnDimension('A')->setWidth(28);
	$hoja->getColumnDimension('B')->setWidth(7);
	$hoja->getColumnDimension('C')->setWidth(8);
	$hoja->getColumnDimension('D')->setWidth(7);
	$hoja->getColumnDimension('E')->setWidth(5);
	$hoja->getColumnDimension('F')->setWidth(6);
	$hoja->getColumnDimension('G')->setWidth(6);
	$hoja->getColumnDimension('H')->setWidth(6);
	$hoja->getColumnDimension('I')->setWidth(8);
	$hoja->getColumnDimension('J')->setWidth(12);
	$hoja->getColumnDimension('K')->setWidth(8);
	$hoja->getColumnDimension('L')->setWidth(12);
	$hoja->getColumnDimension('M')->setWidth(12);
	$hoja->getColumnDimension('N')->setWidth(12);

	/*
	 *
	 * Encabezado
	 *
	 */
	$hoja->setCellValue('A1', 'CONSOLIDADO DE ATENCIÓN DE SOLICITUDES COMUNITARIAS '.$anio->Anio.' - GESTIÓN SOCIO AMBIENTAL'); //Titulo
	$hoja->setCellValue('A4', 'Tramos'); //Tramos
	$hoja->setCellValue('N4', 'Total por tramo'); //Totales
	$hoja->getStyle("A4:N4")->applyFromArray($relleno_titulos);
	$hoja->getStyle('A4:N4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

	//Se listan los meses desde el modelo
	$meses = $this->solicitud_model->listar_meses();

	//Se declara el numero
	$fila_tramo = 5;

	//Se hace un recorrido de los tramos
	foreach ($tramos as $tramo){
		//Estilo para la fila
		if($fila_tramo %2 == 1){
			//A las filas impares se le define el relleno 1
			$hoja->getStyle("A{$fila_tramo}:N{$fila_tramo}")->applyFromArray($relleno1);	
		}else{
			//A las filas pares se le define el relleno 1
			$hoja->getStyle("A{$fila_tramo}:N{$fila_tramo}")->applyFromArray($relleno2);	
		}

		//Se escribe el nombre del tramo
		$hoja->setCellValue('A'.$fila_tramo, $tramo->Nombre);

		//Se recorre mes a mes
		foreach ($meses as $mes){
			//Se ejecuta la consulta que obtiene el numero de solicitudes
			$numero_solicitudes = $this->reporte_model->contar_solicitudes($tramo->Pk_Id_Tramo, $anio->Anio, $mes['Numero']);
			
			//Se escribe el numero de solicitudes correspondientes			
			$hoja->setCellValue($mes['Columna'].$fila_tramo, $numero_solicitudes);

			//Cuando llega el fin del recorrido
			if(end($mes)){
				//Se escriben los meses
				$hoja->setCellValue($mes['Columna'].'4', $mes['Nombre']);
				
				//Formula que calcula el total por tramo
				$hoja->setCellValue('N'.$fila_tramo, "=sum(B{$fila_tramo}:M{$fila_tramo})");

				//Estilo de los totales por tramo
				$hoja->getStyle("N{$fila_tramo}")->applyFromArray($estilo_totales);
			}//Fin if end($mes)
		}//Fin foreach meses

		//Se aumenta el numero de la fila
		$fila_tramo++;
	}//Fin foreach tramos

	//Titulo de totales por meses
	$hoja->setCellValue('A'.$fila_tramo, 'Total por mes');

	//Al arreglo de los meses le agregamos un arreglo mas que contiene el total definitivo de solicitudes
	array_push($meses, array('Numero' => 13, 'Nombre' => 'Totales', 'Columna' => 'N'));

	//Se recorren nuevamente los meses
	foreach ($meses as $mes){
		//Se obtiene el valor de la columna
		$columna = $mes['Columna'];

		//Se obtiene el valor de la fila, que debe ser una fila menos para el calculo
		$fila = $fila_tramo - 1;

		//Se realiza la funcion que suma por mes
		$hoja->setCellValue($columna.$fila_tramo, "=sum({$columna}5:{$columna}{$fila})");
	}//Fin foreach meses

	/*
	 * Definicion de los estilos
	 */
	$hoja->getStyle('A1:N3')->applyFromArray($estilo_titulos);
	$hoja->getStyle('A4:N4')->applyFromArray($estilo_titulos);
	$hoja->getStyle('A'.$fila_tramo)->applyFromArray($estilo_titulos);
	$hoja->getStyle("B{$fila_tramo}:N{$fila_tramo}")->applyFromArray($estilo_totales);
	$hoja->getStyle("A{$fila_tramo}:N{$fila_tramo}")->applyFromArray($relleno_titulos);
	$hoja->getStyle("A{$fila_tramo}:N{$fila_tramo}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
	$hoja->getStyle('A1:'.$columna.$fila_tramo)->applyFromArray($bordes);

	//Se da el formato numerico
	$hoja->getStyle('B5:N60')->getNumberFormat()->setFormatCode('#,##0');

	//Logo
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo Hatovial S.A.S.');
	$objDrawing->setDescription('Logo de uso exclusivo de Hatovial S.A.S.');
	$objDrawing->setPath('./img/logo.png');
	$objDrawing->setCoordinates('A1');
	$objDrawing->setHeight(50);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	$objDrawing->getShadow()->setDirection(45);

	//Se aumenta el numero de la hoja
	$hoja++;
}//Fin foreach anios

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
header('Content-Disposition: attachment; filename="Consolidado_tramos.xlsx"');

//Se genera el excel
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>