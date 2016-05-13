<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

//Se cargan los modelos que tienen  la informacion
$solicitudes = $this->solicitud_model->ver($id_solicitud);
$seguimientos = $this->solicitud_model->ver_seguimientos($id_solicitud);

/*
 * Clase PDF
 */
class PDF extends FPDF{
	/*
	 * Cabecera del reporte
	 */
	function Header(){
	    //Fuente
	    $this->SetFont('Arial','',10);
	    
	    //Logo
	    $this->Image('../gestion_ambiental/img/logo2.png', 10, 9);

	    //Titulo
	    $this->SetFont('Arial', 'B');
	    $this->setXY(50, 11);
	    $this->MultiCell(100,6, utf8_decode('ATENCIÓN DE SOLICITUDES COMUNITARIAS      GESTIÓN SOCIAL  Y AMBIENTAL'),0,'C');
	    
	    //Espacio para el radicado
	    $this->setXY(150, 5);
	    $this->SetFont('Arial', '', 12);
	    $this->SetTextColor(159,148,148);
	    $this->Cell(60,24, utf8_decode('Sticker radicado Orfeo'),1,0,'C');
	    
	    // Salto de línea
	    $this->Ln(29);
	}//Fin Header

	/*
	 * Pie de pagina
	 */
	function Footer(){
		//Color negro
		$this->SetTextColor(0,0,0);
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Se define la fuente del footer
	    $this->SetFont('Arial','',8);
	    // Número de página
	    $this->Cell(0,10, utf8_decode('Sistema de gestión Socio - Ambiental - Página').$this->PageNo().' de {nb}',0,0,'R');
	}
}//Fin PDF

/*
 * 
 * Informacion del reporte
 * 
 */
// Creacion del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');

//Alias para el numero de paginas(numeracion)
$pdf->AliasNbPages();

//Se definen las margenes
$pdf->SetMargins(10, 5, 6);

//Anadir pagina
$pdf->AddPage();

//Fuente
$fuente = 'Arial';
$backgroundColor = array('r' => '159', 'g' => '148', 'b' => '148');
//Color de relleno de las celdas de titulos
$pdf->setFillColor($backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']); 

//Se inicia el recorrido
foreach ($solicitudes as $solicitud) {
	//Parametros adicionales
	$pdf->SetAuthor('John Arley Cano - Hatovial S.A.S.');
	$pdf->SetTitle('Solicitud '.$this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud).' - Hatovial S.A.S.');
	$pdf->SetCreator('John Arley Cano - Hatovial S.A.S.');

	//Informacion general 1
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(40,6, utf8_decode('Número de Solicitud'),1, 0, 'C', 1);
	$pdf->Cell(50,6, utf8_decode('Proyecto'),1, 0, 'C', 1);
	$pdf->Cell(50,6, utf8_decode('Tramo'),1, 0, 'C', 1);
	$pdf->Cell(40,6, utf8_decode('Fecha'),1, 0, 'C', 1);
	$pdf->Cell(20,6, utf8_decode('Hora'),1, 0, 'C', 1);
	$pdf->Ln();

	//Contenido informacion general 1
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->Cell(40,6, substr(utf8_decode($this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud)), 0, 12),1, 0, 'R');
	$pdf->Cell(50,6, substr(utf8_decode('Desarrollo Vial del Aburrá Norte'), 0, 33),1, 0, 'L');
	$pdf->Cell(50,6, substr(utf8_decode($solicitud->Tramo), 0, 25),1, 0, 'L');
	$pdf->Cell(40,6, substr(utf8_decode($this->auditoria_model->formato_fecha($solicitud->Fecha_Creacion)), 0, 24),1, 0, 'L');
	$pdf->Cell(20,6, substr(utf8_decode(date('H:i A', strtotime($solicitud->Fecha_Creacion))), 0, 10),1, 0, 'L');
	$pdf->Ln(10);

	//Informacion general 2
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(70,6, utf8_decode('Nombres y apellidos del solicitante'),1, 0, 'C', 1);
	$pdf->Cell(25,6, utf8_decode('Teléfono'),1, 0, 'C', 1);
	$pdf->Cell(50,6, utf8_decode('Dirección'),1, 0, 'C', 1);
	$pdf->Cell(55,6, utf8_decode('Lugar'),1, 0, 'C', 1);
	$pdf->Ln();

	//Contenido informacion general 2
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->Cell(70,6, substr(utf8_decode($solicitud->Nombres), 0, 43),1, 0, 'L');
	$pdf->Cell(25,6, substr(utf8_decode($solicitud->Telefono), 0, 15),1, 0, 'R');
	$pdf->Cell(50,6, substr(utf8_decode($solicitud->Direccion), 0, 30),1, 0, 'L');
	$pdf->Cell(55,6, substr(utf8_decode($solicitud->Tipo_Sector.' '.$solicitud->Sector.', '.$solicitud->Municipio), 0, 35),1, 0, 'L');
	$pdf->Ln(10);

	//Informacion general 3
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(40,6, utf8_decode('Tipo de solicitud'),1, 0, 'C', 1);
	$pdf->Cell(40,6, utf8_decode('Forma de recepción'),1, 0, 'C', 1);
	$pdf->Cell(40,6, utf8_decode('Área encargada'),1, 0, 'C', 1);
	$pdf->Cell(80,6, utf8_decode('Tema'),1, 0, 'C', 1);
	$pdf->Ln();

	//Contenido informacion general 3
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->Cell(40,6, substr(utf8_decode($solicitud->Tipo_Solicitud), 0, 25),1, 0, 'L');
	$pdf->Cell(40,6, substr(utf8_decode($solicitud->Forma_Recepcion), 0, 25),1, 0, 'L');
	$pdf->Cell(40,6, substr(utf8_decode($solicitud->Area_Encargada), 0, 25),1, 0, 'L');
	$pdf->Cell(80,6, substr(utf8_decode($solicitud->Tema), 0, 50),1, 0, 'L');
	$pdf->Ln(10);

	//Descripcion de la solicitud
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(200,6, utf8_decode('Descripción detallada de la solicitud'),1, 0, 'C', 1);
	$pdf->Ln();

	//Contenidos descripcion de la solicitud
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->MultiCell(200,5, utf8_decode($solicitud->Descripcion_Solicitud), 1, 'L');
	$pdf->Ln(5);

	//Accion emprendida
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(35,6, utf8_decode('Acción emprendida'),1, 0, 'C', 1);
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->Cell(50,6, substr(utf8_decode($solicitud->Accion_Emprendida), 0, 30),1, 0, 'L');
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(115,6, utf8_decode('Descripción detallada de la acción emprendida'),1, 0, 'C', 1);
	$pdf->Ln();

	//Contenido accion emprendida
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->MultiCell(200,5, utf8_decode($solicitud->Descripcion_Accion), 1, 'L');
	$pdf->Ln();

	//Si hay remision
	if ($solicitud->Pk_Id_Remision) {
		//Datos de remision
		$pdf->SetFont($fuente,'B',10);
		$pdf->SetTextColor('255,0,0');
		$pdf->SetDrawColor('255,0,0');
		$pdf->Cell(70,6, utf8_decode('Funcionario'),1, 0, 'C', 1);
		$pdf->Cell(50,6, utf8_decode('Cargo - Entidad'),1, 0, 'C', 1);
		$pdf->Cell(40,6, utf8_decode('Fecha'),1, 0, 'C', 1);
		$pdf->Cell(40,6, utf8_decode('Radicado de remisión'),1, 0, 'C', 1);
		$pdf->Ln();

		//Contenido datos de remision
		$pdf->SetFont($fuente,'',9);
		$pdf->SetTextColor('0,0,0');
		$pdf->SetDrawColor('159,148,148');
		$pdf->Cell(70,6, substr(utf8_decode($solicitud->Funcionario), 0, 43),1, 0, 'L');
		$pdf->Cell(50,6, substr(utf8_decode($solicitud->Cargo.' '.$solicitud->Empresa), 0, 32),1, 0, 'L');
		$pdf->Cell(40,6, substr(utf8_decode($this->auditoria_model->formato_fecha($solicitud->Fecha_Remision)), 0, 24),1, 0, 'L');
		$pdf->Cell(40,6, substr(utf8_decode($solicitud->Radicado_Remision), 0, 12),1, 0, 'L');
		$pdf->Ln(10);
	}//Fin if
	

	//Si hay seguimientos
	if($seguimientos){
		//Se declara la numeracion de los seguimientos
		$numero = 1;

		//Seguimiento
		$pdf->SetFont($fuente,'B',10);
		$pdf->SetTextColor('255,0,0');
		$pdf->SetDrawColor('255,0,0');
		$pdf->Cell(200,6, utf8_decode('Seguimientos'),1, 0, 'C', 1);
		$pdf->Ln();

		//Si tiene seguimientos, los muestra
		foreach ($seguimientos as $seguimiento) {
			//Contenido seguimientos
			$pdf->SetFont($fuente,'',9);
			$pdf->SetTextColor('0,0,0');
			$pdf->SetDrawColor('159,148,148');

			$pdf->MultiCell(200,5, utf8_decode($numero.' - '.$seguimiento->Descripcion), 1, 'L');
			/*
			
			$pdf->SetDrawColor('159,148,148');
			$pdf->Cell(10,6, utf8_decode($numero),1, 0, 'R');
			$pdf->SetFont($fuente,'',9);
			$pdf->Cell(190,6, substr(utf8_decode($seguimiento->Descripcion), 0, 130),1, 0, 'L');
			$pdf->Ln();

			
			*/
			//Se aumenta el contador
			$numero++;
		}//Fin foreach seguimientos
		$pdf->Ln();
		//Si la solicitud aun esta en tramite, entonces pintar campos vacios
	}elseif($solicitud->Fk_Id_Solicitud_Estado == 1){
		//Seguimiento
		$pdf->SetFont($fuente,'B',10);
		$pdf->SetTextColor('255,0,0');
		$pdf->SetDrawColor('255,0,0');
		$pdf->Cell(200,6, utf8_decode('Seguimientos'),1, 0, 'C', 1);
		$pdf->Ln();

		for ($i = 1; $i < 5; $i++) { 
			//Contenido seguimientos
			$pdf->SetFont($fuente,'B',9);
			$pdf->SetTextColor('0,0,0');
			$pdf->SetDrawColor('159,148,148');
			$pdf->Cell(10,6, utf8_decode($i),1, 0, 'R');
			$pdf->SetFont($fuente,'',9);
			$pdf->Cell(190,6, '',1, 0, 'L');
			$pdf->Ln();
		}//Fin for seguimientos
		$pdf->Ln();
	}//Fin if

	//Respuesta
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(200,6, utf8_decode('Respuesta'),1, 0, 'C', 1);
	$pdf->Ln();

	//Contenido respuesta
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->MultiCell(200,5, utf8_decode($solicitud->Descripcion_Respuesta), 1, 'L');
	$pdf->Ln(0);

	//Datos respuesta
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(50,6, utf8_decode('Fecha'),1, 0, 'C', 1);
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->Cell(50,6, substr(utf8_decode($this->auditoria_model->formato_fecha($solicitud->Fecha_Cierre)), 0, 24),1, 0, 'L');
	$pdf->SetFont($fuente,'B',10);
	$pdf->SetTextColor('255,0,0');
	$pdf->SetDrawColor('255,0,0');
	$pdf->Cell(50,6, utf8_decode('Radicado de salida'),1, 0, 'C', 1);
	$pdf->SetFont($fuente,'',9);
	$pdf->SetTextColor('0,0,0');
	$pdf->SetDrawColor('159,148,148');
	$pdf->Cell(50,6, substr(utf8_decode($solicitud->Radicado_Respuesta), 0, 24),1, 0, 'L');
	$pdf->Ln(30);
	
	$pdf->SetFont($fuente,'B',10);
	$pdf->Cell(100,5, utf8_decode('_______________________________'),0, 0, 'C');
	$pdf->Cell(100,5, utf8_decode('_______________________________'),0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(100,5, utf8_decode('Firma de Gestión Social'),0, 0, 'C');
	$pdf->Cell(100,5, utf8_decode('Firma del solicitante'),0, 0, 'C');
	$pdf->Ln();
	$pdf->setX(130);
	$pdf->Cell(70,5, utf8_decode('C.C.'),0, 0, 'L');
}//Fin foreach solicitud

//Se imprime el Reporte
$pdf->Output('Solicitud '.$this->auditoria_model->numero_solicitud($solicitud->Pk_Id_Solicitud).'.pdf', 'I');
?>