<?php
//Defino año y mes
// $anio = 2015;
// $mes = 02;
// $id_area = 2;

// Creacion del objeto de la clase heredada
$pdf = new FPDF('P','mm','Letter');

//Se definen las margenes
$pdf->SetMargins(10, 5, 6);

//Anadir pagina
$pdf->AddPage();

//Fuente
$fuente = 'Helvetica';

//Titulo del reporte
$pdf->SetFont($fuente,'B',19);
$pdf->MultiCell(0, 6, utf8_decode('Registro Fotográfico del Informe de Cumplimiento Ambiental '), 0, 'C', 0);
// Si el área es 1 (social)
if ($id_area == 1) {
	$pdf->MultiCell(0, 6, utf8_decode('Área social'), 0, 'C', 0);
}
$pdf->Ln();

//Título del tramo
$pdf->SetFont($fuente,'B',16);

//Se cargan los tramos
$tramos = $this->reporte_model->tramos_fotos($anio, $mes, $id_area);

//Se recorren los tramos
foreach ($tramos as $tramo) {
	//Titulo de los tramos
	$pdf->MultiCell(0, 6, utf8_decode("Tramo ".$tramo->Nombre), 0, 'C', 0);
	$pdf->Ln();

	//Consulta de fichas
	$fichas = $this->reporte_model->fichas_fotos($anio, $mes, $tramo->Pk_Id_Tramo, $id_area);
	
	//Recorrido de las fichas
	foreach ($fichas as $ficha) {
		//Fuente
		$pdf->SetFont($fuente,'',15);

		//Nombre de ficha
		$pdf->MultiCell(0, 6, utf8_decode($ficha->Nombre), 0, 'C', 0);

		//Cargo los anexos
		$anexos = $this->reporte_model->anexos_fotos($anio, $mes, $tramo->Pk_Id_Tramo, $ficha->Pk_Id_Ficha, $id_area);

		foreach ($anexos as $anexo) {
			//$pdf->MultiCell(0, 6, utf8_decode($anexo->Pk_Id_Anexo), 0, 'C', 0);

			//Declaro la ruta
			$ruta = './archivos/'.$anexo->Pk_Id_Anexo.'/';

			//Abrimos la carpeta
			$directorio = opendir($ruta);

			//Recorremos los archivos
			while ($anexo = readdir($directorio)){ 
				//Validacion
				if($anexo == '.' or $anexo == '..'){ 
				
				} else { 
					//Impresión de imagen
					$pdf->Image($ruta.$anexo, 57, null, 110);
				}//Fin if
			}//Fin while anexo
		}//Fin foreach anexo
	}//Fin foreach fichas

	//Salto de línea
	$pdf->Ln();
}

//Se imprime el Reporte
$pdf->Output('Registro_Fotografico.pdf', 'D');
?>