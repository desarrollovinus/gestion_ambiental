<?php
class PDF extends FPDF{
	// Cabecera de página
	function Header(){
	    // Logo
	    // $this->Image('logo_pb.png',10,8,33);
	    // Arial bold 15
	    $this->SetFont('Arial', 'B', 12);
	    // Movernos a la derecha
	    $this->Cell(80);
	    // Título
	    $this->Cell(30, 10, utf8_decode('REGISTRO FOTOGRÁFICO DEL INFORME DE CUMPLIMIENTO AMBIENTAL NIQUÍA - HATILLO'), 0, 0, 'C');
	    // Salto de línea
	    $this->Ln(20);
	}

	// Pie de página
	function Footer(){
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    // Arial italic 8
    	
    	// Logo

	    $this->SetFont('Arial','I',8);
	    // Número de página
	    // $this->Cell(0,10, utf8_decode('Sistema de Gestión Socio Ambiental - Página '.$this->PageNo().' de {nb}'),0,0,'C');

	    $this->SetY(-20);
	    // $this->MultiCell(50, 3, $this->Image('./img/banner_pie.png', $this->GetX(),$this->GetY()),1,0,'C');

	    $this->MultiCell(0, 20, $this->Image('./img/banner_pie.png', 62,$this->GetY()), 0, 'C', 0);
	}
}

//Se listan los nombres de las fichas
$fichas = $this->reporte_model->listar_fichas_fotos_1a();

// Creacion del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

//Se definen las margenes
$pdf->SetMargins(10, 5, 10);

$pdf->AliasNbPages();

//Anadir pagina
$pdf->AddPage();

$pdf->SetFont('Arial','',10);

$cont_fichas = 1;

//Se recorren las fichas
foreach ($fichas as $ficha) {
    $pdf->Cell(0,10, utf8_decode(strtoupper($ficha->Nombre)),0,1, 'C');

	//Se consultan los anexos para esa ficha
	$fotos = $this->reporte_model->listar_fotos_1a($ficha->Pk_Id_Ficha);

	//Inicialización contador
	$cont_fotos = 1;

	//Se recorren las fotos
	foreach ($fotos as $foto) {
		//Declaro la ruta
		$ruta = './archivos/'.$foto->Pk_Id_Anexo.'/';

		//Abrimos la carpeta
		$directorio = opendir($ruta);

		//Recorremos los archivos
		while ($anexo = readdir($directorio)){
			//Validacion
			if($anexo == '.' or $anexo == '..'){ 
			
			} else { 
				//Impresión de imagen
				$pdf->Image($ruta.$anexo, 53, null, 108);
				// $pdf->Cell(110, 5, $pdf->Image($ruta.$anexo, 53,110),'LR',1,'R');

				//Datos de la foto
				// $pdf->Cell(50,7, utf8_decode($ruta),1,1,'C');
				$pdf->setX(53);
				$pdf->MultiCell(108, 5, utf8_decode("FOTOGRAFÍA No. ".$cont_fichas.".".$cont_fotos), 0, 'L', 0);
				$pdf->setX(53);
				$pdf->MultiCell(108, 5, utf8_decode("FECHA: ".date('d-m-Y', strtotime($foto->Fecha_Inicio)) ), 0, 'L', 0);
				$pdf->setX(53);
				$pdf->MultiCell(108, 5, utf8_decode("LUGAR: ".$foto->Lugar), 0, 'L', 0);
				$pdf->setX(53);
				$pdf->SetFont('Arial','',9);
				$pdf->MultiCell(108, 5, utf8_decode(substr("OBSERVACIONES: ".$foto->Descripcion." - ".$foto->Observacion, 0, 138)), 0, 'L', 0);

				$pdf->Ln();
			}//Fin if

		}//Fin while anexo

		//Sólo dos fotos por página
		if ($cont_fotos%2 == 0 && $cont_fotos != count($fotos)) {
			//Anadir pagina
			$pdf->AddPage();
		}

		$cont_fotos++;
	}// foreach fotos
	
	

	$cont_fichas++;
} // foreach fichas

$pdf->Output('Registro_Fotografico_1a.pdf', 'I');
?>