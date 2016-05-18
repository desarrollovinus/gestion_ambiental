<?php
//seleccciono el archivo base
$file = './formatos/reportePQRS_F-136.xlsx';
$tipo = 'Excel2007';
$Reader = PHPExcel_IOFactory::createReader($tipo);
// se genera un nuevo objPHPExcel apartir del archivo base
$objPHPExcel = $Reader->load($file);
$hoja = $objPHPExcel->getActiveSheet()->setTitle('Hoja1');

/*
 * modelos
 */
$solicitudes = $this->solicitud_model->listar();

//Se establece la configuracion general
$objPHPExcel->getProperties()
	->setCreator("Luis David Moreno Lopera - Hatovial S.A.S.")
	->setLastModifiedBy("Luis David Moreno Lopera")
	->setTitle("Sistema de Gestión Socio Ambiental - Generado el ".$this->auditoria_model->formato_fecha(date('Y-m-d')).' - '.date('h:i A'))
	->setSubject("Listado de solicitudes por mes")
	->setDescription("En este listado se muestran las solicitudes clasificadas por año y mes")
	->setKeywords("consolidado listado solicitudes ambiental mensual")
  ->setCategory("Reporte");

//Fecha
$objPHPExcel->getActiveSheet()->setCellValue('V3', 'Fecha: ' . date('d/m/Y'));

// rellenando informacion
// primer fila de relleno
$fila = 9;
foreach ($solicitudes as $solicitud)
{
	//carga subconsultas de una solicitud
	$detalle = $this->solicitud_model->ver($solicitud->Pk_Id_Solicitud);
	//configuracion de fecha
	$fecha = strtotime($solicitud->Fecha_Creacion);
	$dia = date('d', $fecha);
	$mes = date('m', $fecha);
	$anio = substr(date('Y', $fecha), 2, 3);

	$objPHPExcel->getActiveSheet()->setCellValue("A{$fila}", $dia);
	$objPHPExcel->getActiveSheet()->setCellValue("B{$fila}", $mes);
	$objPHPExcel->getActiveSheet()->setCellValue("C{$fila}", $anio);
	$objPHPExcel->getActiveSheet()->setCellValue("D{$fila}", $solicitud->Radicado_Entrada);

	switch ($detalle->Tipo_Solicitud) {
		case 'Petición':
			$objPHPExcel->getActiveSheet()->setCellValue("E{$fila}", "X");
			break;

		case 'Queja':
			$objPHPExcel->getActiveSheet()->setCellValue("F{$fila}", "X");
			break;

		case 'Reclamo':
			$objPHPExcel->getActiveSheet()->setCellValue("G{$fila}", "X");
			break;

		case 'Solicitud':
			$objPHPExcel->getActiveSheet()->setCellValue("H{$fila}", "X");
			break;

		case 'Consulta':
			$objPHPExcel->getActiveSheet()->setCellValue("I{$fila}", "X");
			break;
	}

	$objPHPExcel->getActiveSheet()->setCellValue("J{$fila}", $solicitud->Nombres);
	$objPHPExcel->getActiveSheet()->setCellValue("K{$fila}", $solicitud->Documento);
	$objPHPExcel->getActiveSheet()->setCellValue("L{$fila}", $detalle->Municipio);
	$objPHPExcel->getActiveSheet()->setCellValue("M{$fila}", $detalle->Descripcion_Solicitud);

	switch ($detalle->Forma_Recepcion)
	{
		case 'Personal':
			$objPHPExcel->getActiveSheet()->setCellValue("N{$fila}", 'X');
			break;

		case 'Telefónica':
			$objPHPExcel->getActiveSheet()->setCellValue("O{$fila}", 'X');
			break;

		case 'Buzón':
			$objPHPExcel->getActiveSheet()->setCellValue("P{$fila}", 'X');
			break;

		case 'Correo electrónico':
			$objPHPExcel->getActiveSheet()->setCellValue("Q{$fila}", 'X');
			break;

		case 'Correspondencia Física':
			$objPHPExcel->getActiveSheet()->setCellValue("R{$fila}", 'X');
			break;
	}

	switch ($detalle->Lugar_Recepcion) {
		case 'Oficina Fija 1':
		case 'Oficina Fija 2':
			$objPHPExcel->getActiveSheet()->setCellValue("S{$fila}", 'X');
			break;
		case 'Oficina Móvil 1':
		case 'Oficina Móvil 2':
			$objPHPExcel->getActiveSheet()->setCellValue("T{$fila}", 'X');
			break;
	}

	// 1:Abierto='En trámite' <------->  2:Cerrado='Resueltas'
	if ($solicitud->Fk_Id_Solicitud_Estado == 1)
	{
		$objPHPExcel->getActiveSheet()->setCellValue("W{$fila}", 'X');
	} else if($solicitud->Fk_Id_Solicitud_Estado == 2) {
		$objPHPExcel->getActiveSheet()->setCellValue("X{$fila}", 'X');
	}
	$objPHPExcel->getActiveSheet()->setCellValue("Y{$fila}", $solicitud->Radicado_Salida);
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($fila + 1, 1);
	$fila++;
}

//Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Cache-Control: max-age=0');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Recepcion_solicitudes.xlsx"');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
