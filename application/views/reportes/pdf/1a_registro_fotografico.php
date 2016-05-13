<?php
//Se recibe el número de ficha
$id_ficha = $this->uri->segment(3);

//Se consulta el nombre de la ficha
$nombre_ficha = $this->ica_model->cargar_nombre_select('tbl_fichas', 'Pk_Id_Ficha', $id_ficha);

//Se consultan los anexos para la ficha seleccionada
$fotos = $this->reporte_model->listar_fotos_1a($id_ficha);

class PDF extends FPDF{
	// Cabecera de página
	function Header(){
	    // Logo
	    // $this->Image('logo_pb.png',10,8,33);
	    // Arial bold 15
	    $this->SetFont('Arial', 'B', 12);
	    // Movernos a la derecha
	    // $this->Cell(80);
	    // Título
	    $this->Cell(0, 10, utf8_decode('REGISTRO FOTOGRÁFICO DEL INFORME DE CUMPLIMIENTO AMBIENTAL HATILLO - BARBOSA'), 0, 0, 'C');

	    $this->Ln(10);
	}

	// Pie de página
	function Footer(){
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    // Arial italic 8
    	
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    // $this->Cell(0,10, utf8_decode('Sistema de Gestión Socio Ambiental - Página '.$this->PageNo().' de {nb}'),0,0,'C');

	    $this->SetY(-20);
	    // $this->MultiCell(50, 3, $this->Image('./img/banner_pie.png', $this->GetX(),$this->GetY()),1,0,'C');

	    $this->MultiCell(0, 20, $this->Image('./img/banner_pie.png', 62,$this->GetY()), 0, 'C', 0);
	}
}

// Creacion del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

//Se definen las margenes
$pdf->SetMargins(10, 5, 10);

$pdf->AliasNbPages();

//Anadir pagina
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);

$pdf->Cell(0, 10, utf8_decode(strtoupper($nombre_ficha) . ' - 2013'), 0, 0, 'C');
$pdf->Ln(20);

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
			$pdf->SetFont('Arial','',9);
			$pdf->setX(53);
			$pdf->MultiCell(108, 5, utf8_decode("FOTOGRAFÍA No. ".$cont_fotos." (".$foto->Pk_Id_Anexo.")"), 0, 'L', 0);
			$pdf->setX(53);
			$pdf->MultiCell(108, 5, utf8_decode("FECHA: ".date('d-m-Y', strtotime($foto->Fecha_Inicio)) ), 0, 'L', 0);
			$pdf->setX(53);
			$pdf->MultiCell(108, 5, utf8_decode("LUGAR: ".$foto->Lugar), 0, 'L', 0);
			$pdf->setX(53);
			$pdf->MultiCell(108, 5, utf8_decode(substr("OBSERVACIONES: ".$foto->Observacion, 0, 138)), 0, 'L', 0);

			$pdf->Ln();
		}//Fin if
	}//Fin while anexo

	//Sólo dos fotos por página
	if ($cont_fotos%2 == 0 && $cont_fotos != count($fotos)) {
		//Anadir pagina
		$pdf->AddPage();
	}

	$cont_fotos++;
} // foreach fotos












$pdf->Output($nombre_ficha.'.pdf', 'I');
?>