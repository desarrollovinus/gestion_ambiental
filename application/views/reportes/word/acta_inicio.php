<?php
// Create a new PHPWord Object
$PHPWord = new PHPWord();

// Every element you want to append to the word document is placed in a section. So you need a section:
$section = $PHPWord->createSection();

/**
 * Configuración por defecto
 */
$PHPWord->setDefaultFontName('Arial');
$PHPWord->setDefaultFontSize(11);
$properties = $PHPWord->getProperties();
$properties->setCreator('John Arley Cano Salinas'); 
$properties->setCompany('Hatovial S.A.S.');
$properties->setTitle('Acta de Inicio');
$properties->setDescription('Acta e Inicio de obra'); 
$properties->setCategory('informe');
$properties->setLastModifiedBy('John Arley Cano Salinas');
/*$properties->setCreated( mktime(0, 0, 0, 3, 12, 2010) );
$properties->setModified( mktime(0, 0, 0, 3, 14, 2010) );
$properties->setSubject('My subject'); 
$properties->setKeywords('my, key, word');*/

/**
 * Estilos
 */
$centrado = array ('align' => 'center', 'valign' => 'center');
$izquierda = array ('align' => 'left', 'valign' => 'center');
$justificado = array ('align' => 'both', 'valign' => 'center');

$PHPWord->addFontStyle('titulo_cabecera', array( 'name'=>'Arial', 'size'=> 22, 'color'=>'000000', 'bold'=> true, 'italic' => true)); 	// Título principal de la cabecera
$PHPWord->addFontStyle('subtitulo1_cabecera', array( 'name'=>'Arial', 'size'=> 12, 'color'=>'000000', 'bold'=> true));					// Subtítulo 1 de cabecera
$PHPWord->addFontStyle('estilo1', array( 'name'=>'Arial', 'size'=> 11, 'color'=>'000000', 'bold'=> true));								// Texto en negrilla
$PHPWord->addFontStyle('estilo2', array( 'name'=>'Arial', 'size'=> 11, 'color'=>'000000', 'bold'=> false));								// Texto en negrilla
$tableStyle =array('borderColor'=>'000000', 'borderSize'=> 6);														// Estilo de tabla
$borde_tabla = array('borderSize' => 8, 'borderColor' => '1E1E1E',  'cellMarginTop' => 500, 'rules' => 'cols');								// Borde Tabla

$borde_colores = array(    'borderRightSize' => 50, 'borderBottomColor' => '009900',    'borderBottomSize' => 50, 'borderRightColor' => '00CCFF',    'borderTopSize' => 50, 'borderTopColor' => '00CCFF',    'borderLeftSize' => 50, 'borderLeftColor' => '00CCFF'); 

// $styleCell = array('valign' => 'center');
// $fontStyle20 = array('bold' => true, 'align' => 'left', 'size' => 20);
// $fontStyle = array('bold' => true, 'align' => 'left', 'size' => 10);

/**
 * 
 * Cabecera
 * 
 */
$PHPWord->addTableStyle('tabla1', $borde_tabla);
$cabecera = $section->createHeader();
$table = $cabecera->addTable('tabla1');
$table->addRow(1000);
$table->addCell(4000)->addText('COCAN', 'titulo_cabecera', $centrado);
$table->addCell(10000)->addText('ACTA DE INICIO DE OBRA', 'subtitulo1_cabecera', $centrado);
$table->addCell(4000)->addText(utf8_decode('Página'), $centrado);

/**
 *
 * Pié de página
 * 
 */
$footer = $section->createFooter();
$footer->addPreserveText(utf8_decode('Página').' {PAGE} de {NUMPAGES}.', $centrado);


$section->addTextBreak();
$section->addText('CONTRATO No. XXXX', 'estilo1', $centrado);
$section->addTextBreak();
$section->addText(utf8_decode('CONTRATISTA: '.'JOHN ARLEY CÁNO Ñ'.' CON NIT: '.'XXX.XXX.XXX-2'), 'estilo1', $izquierda);
$section->addText(utf8_decode('CONTRATANTE: '.'CONSORCIO CONSTRUCTOR ABURRÁ NORTE -COCAN-'.' CON NIT: '.'XXX.XXX.XXX-2'), 'estilo1', $izquierda);

$section->addText(utf8_decode('El (XX-XX-XXX Fecha), en las oficinas del Consorcio Constructor Aburrá Norte -COCAN-, ubicadas en el municipio de Copacabana (Antioquia), se reunieron el ingeniero JORGE ORTIZ quien actúa en representación de Consorcio COCAN (Contratante), y el señor XXXXX-XXXXX, quien obra en representación de la sociedad XXXXXXX, con el  fin de suscribir el acta de inicio de obra, para efectos de determinar el inicio del plazo del Contrato N° 069 de 2013  , cuyo objeto es el siguiente: '), 'estilo2', $justificado);

$section->addText(utf8_decode('Realizar la construcción de las obras de recuperación de la banca vial en el km7+400 (ancón norte) del tramo Niquía –El Hatillo, municipio de Copacabana  – Antioquia, para el proyecto “Desarrollo Vial del Aburrá Norte”'), 'estilo2', $justificado);

$section->addTextBreak();
$section->addText('CONDICIONES CONTRACTUALES', 'estilo1', $centrado);
$section->addTextBreak();














/*$table->addRow(0);
$table->addCell(4000)->addText('Cell 4');*/





// $section->addText('JOHN ARLEY CANO SALINAS', 'negrilla');

// After creating a section, you can append elements:
// $section->addText('Hello world!');

// You can directly style your text by giving the addText function an array:
// $section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));

// If you often need the same style again you can create a user defined style to the word document
// and give the addText function the name of the style:
// $PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
// $section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');

// You can also putthe appended element to local object an call functions like this:
/*$myTextElement = $section->addText('Hello World!');
$myTextElement->setBold();
$myTextElement->setName('Verdana');
$myTextElement->setSize(22);*/

// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('Prueba.docx');

header('Location: '.base_url().'Prueba.docx');
?>