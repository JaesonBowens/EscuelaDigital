<?php
	include("reporte_cabecera_pie.php");
	include("../modelo/ejercicio_imagen.php");
	include("../modelo/ejercicio_letra.php");


	class ReporteDesempenoEstudiantil{

		function reporte($resul_1, $resul_2, $resul_3, $nombre_apellido){
			$modeloEjercicioImagen = new ModeloEjercicioImagen;
			$modeloEjercicioLetra = new ModeloEjercicioLetra;
			$pdf = new PDF('P', 'mm', 'letter');
			$pdf->SetLeftMargin(13);
			$pdf->SetRightMargin(13);

			$pdf->AddPage();
			$pdf->AliasNbPages();
			$pdf->SetFont("Arial", "BU", 14);

			$titulo = "hola";
			$pdf->SetTitle($titulo);

			$pdf->Cell(200,10,utf8_decode('Student´s Performance'),0,1,'C');

			$pdf->Ln(10);
			
			$pdf->SetFont("Arial", "B", 12);
			$pdf->SetFillColor( 111, 187, 245 );
			$pdf->Cell(45,10,utf8_decode('Name & Surname: '), 1, 0, 'R', true);
			$pdf->SetFont("Arial", "I", 12);
			$pdf->Cell(60,10, "  ".utf8_decode($nombre_apellido), 1, 1, 'L');


			$area      = "";
			$actividad = "";
			$prueba    = "";
			$ejercicio = "";
			$contadorFila = "";
			$datos_personales = false;
			$denominacion = "";
			$nivel = "";
			$grupo = "";

			if($resul_1){
			   while($fila = mysql_fetch_array($resul_1)){
				$id_prueba = $fila["id_prueba"];
				$id_actividad = $fila["id_actividad"];
				$id_area = $fila["id_area"];
				$iteracion     = $fila["iteracion"];
				$nombre_actividad = $fila["nombre_actividad"];
				$fecha_prueba   = $fila["fecha_prueba"];
				$nombre_area = $fila["nombre_area"];
				$id_ano_escolar = $fila["id_ano_escolar"];
				$denominacion = "  ".$fila["denominacion"];
				$id_grado = $fila["id_grado"];
				$nivel = "  ".$fila["nivel"];
				$id_seccion = $fila["id_seccion"];
				$grupo = "  ".$fila["grupo"];

				if( $datos_personales == false){

					$datos_personales = true;

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(45, 10, utf8_decode('School Year: '), 1, 0, 'R', true);
					$pdf->SetFont("Arial", "I", 12);
					$pdf->Cell(60, 10, utf8_decode($denominacion), 1, 1, 'L');

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(45, 10, utf8_decode('Grade: '), 1, 0, 'R',true);
					$pdf->SetFont("Arial", "I", 12);
					$pdf->Cell(60, 10, utf8_decode($nivel), 1, 1, 'L');

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(45, 10, utf8_decode('Section: '), 1, 0, 'R', true);

					$pdf->SetFont("Arial", "I", 12);
					$pdf->Cell(60, 10, utf8_decode($grupo), 1, 1, 'L');

					$pdf->Ln(5);
				}

				if($id_area != $area){

					$area = $id_area;

					$pdf->Ln(15);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->Cell(30, 10, utf8_decode('Area: '), 0, 0, 'R');

					$pdf->SetFont("Arial", "U", 12);
					$pdf->Cell(160, 10, utf8_decode($nombre_area), 0, 0, 'L');

				}
				
				if($id_prueba != $prueba){

					$prueba = $id_prueba;

					$contadorFila = 0;

					$pdf->Ln(15);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(25, 20, utf8_decode('Activity: '), 1, 0, 'R', true);

					$pdf->SetFont("Arial", "", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(165, 20, utf8_decode($nombre_actividad), 1, 1, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(25, 10, utf8_decode('Iteration:'), 1, 0, 'R', true);

					$pdf->SetFont("Arial", "", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(55, 10, utf8_decode($iteracion), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(30, 10, utf8_decode('Date: '), 1, 0, 'R', true);

					$pdf->SetFont("Arial", "", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(80, 10, utf8_decode($fecha_prueba), 1, 1, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );

					if($nombre_actividad == "PLACE THE FIRST LETTER" || $nombre_actividad == "PLACE THE VOWELS"){
						$pdf->Cell(60, 10, utf8_decode('Word'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}else if($nombre_actividad == "COUNT THE OBJECTS"){
						$pdf->Cell(60, 10, utf8_decode('Quantity of Objects'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}else if($nombre_actividad == "IDENTIFY THE NUMBER" ){
						$pdf->Cell(60, 10, utf8_decode('Number'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}else if($nombre_actividad == "SPELL THE NUMBER"){
						$pdf->Cell(60, 10, utf8_decode('Number'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}else if($nombre_actividad == "WHAT TIME IS IT?"){
						$pdf->Cell(60, 10, utf8_decode('Time'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}else if($nombre_actividad == "WRITE THE FIRST LETTER OF THE OBJECT"){
						$pdf->Cell(60, 10, utf8_decode('Object'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}else if($nombre_actividad == "ARRANGE THE WORD"){
						$pdf->Cell(60, 10, utf8_decode('Word'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}else if($nombre_actividad == "SUM THE OBJECTS"){
						$pdf->Cell(60, 10, utf8_decode('Sum'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}else if($nombre_actividad == "SUBTRACT THE OBJECTS"){
						$pdf->Cell(60, 10, utf8_decode('Subtraction'), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}
				}

				
				$pdf->SetFont("Arial", "", 12);

				$palabra     = $fila["palabra"];
				$numero      = $fila["numero"];
				$hora        = $fila["hora"];					
				$intento_sin_exito        = $fila["intento_sin_exito"];
				$tiempo_llevado = $fila["tiempo_llevado"];
				$id_ejercicio = $fila["id_ejercicio"];
				
				if($nombre_actividad == "PLACE THE FIRST LETTER" || $nombre_actividad == "PLACE THE VOWELS"){

					$contadorFila++;

					if($contadorFila & 1){
						$pdf->Cell(60, 10, utf8_decode($palabra), 1, 0, 'C');
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($palabra), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}
					
				}else if($nombre_actividad == "COUNT THE OBJECTS"){

					$contadorFila++;

					if($contadorFila & 1){
						$pdf->Cell(60, 10, utf8_decode($numero), 1, 0, 'C');
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($numero), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}

					
				}else if($nombre_actividad == "IDENTIFY THE NUMBER" ){

					$contadorFila++;

					if($contadorFila & 1){
						$pdf->Cell(60, 10, utf8_decode($numero), 1, 0, 'C');
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($numero), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}
					
				}else if($nombre_actividad == "SPELL THE NUMBER"){

					$contadorFila++;

					if($contadorFila & 1){
						$pdf->Cell(60, 10, utf8_decode($palabra), 1, 0, 'C');
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($palabra), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}
					
				}else if($nombre_actividad == "WHAT TIME IS IT?"){
	
					$contadorFila++;

					if($contadorFila & 1){
						$pdf->Cell(60, 10, utf8_decode($hora), 1, 0, 'C');
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($hora), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}
					
				}else if($nombre_actividad == "WRITE THE FIRST LETTER OF THE OBJECT"){

					$contadorFila++;

					if($contadorFila & 1){
						$pdf->Cell(60, 10, utf8_decode($palabra), 1, 0, 'C');
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($palabra), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}
					
				}else if($nombre_actividad == "ARRANGE THE WORD"){

					$contadorFila++;

					if($contadorFila & 1){
						$pdf->Cell(60, 10, utf8_decode($palabra), 1, 0, 'C');
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($palabra), 1, 0, 'C', true);
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}
					
				}else if($nombre_actividad == "SUM THE OBJECTS"){
					
					if($id_ejercicio != $ejercicio){

						$imagen = array();
	
						$ejercicio = $id_ejercicio;

						$resul = $modeloEjercicioImagen -> consultarImagen($id_ejercicio);

						while($filaImagen = mysql_fetch_array($resul)){
							array_push($imagen, $filaImagen["numero"]);
						}

						$numero1 = array_pop($imagen);
						$numero2 = array_pop($imagen);

						$contadorFila++;

						if($contadorFila & 1){
							$pdf->Cell(60, 10, utf8_decode($numero1."  +  ".$numero2), 1, 0, 'C');
							$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
							$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
						}else{
							$pdf->SetFillColor( 233, 235, 237 );
							$pdf->Cell(60, 10, utf8_decode($numero1."  +  ".$numero2), 1, 0, 'C', true);
							$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
							$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
						}

					}

				}else if($nombre_actividad == "SUBTRACT THE OBJECTS" && $id_ejercicio != $ejercicio ){

					$imagen = array();
	
					$ejercicio = $id_ejercicio;

					$resul = $modeloEjercicioImagen -> consultarImagen($id_ejercicio);

					while($filaImagen = mysql_fetch_array($resul)){
						array_push($imagen, $filaImagen["numero"]);
					}

					$numero1 = array_pop($imagen);
					$numero2 = array_pop($imagen);

					$contadorFila++;

					if($contadorFila & 1){

						if($numero1 > $numero2){
							$pdf->Cell(60, 10, utf8_decode($numero1."  -  ".$numero2), 1, 0, 'C');
						}else{
							$pdf->Cell(60, 10, utf8_decode($numero2."  -  ".$numero1), 1, 0, 'C');
						}	

						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');

					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						if($numero1 > $numero2){
							$pdf->Cell(60, 10, utf8_decode($numero1."  -  ".$numero2), 1, 0, 'C', true);
						}else{
							$pdf->Cell(60, 10, utf8_decode($numero2."  -  ".$numero1), 1, 0, 'C', true);
						}	

						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);

					}
				}else if($nombre_actividad == "SELECT THE IMAGES WHOOSE FIRST LETTER IS EQUAL TO THE INDICATED" && $id_ejercicio != $ejercicio ){

					$imagen = array();
	
					$ejercicio = $id_ejercicio;

					$resulImagen = $modeloEjercicioImagen -> consultarImagen($ejercicio);

					while($filaImagen = mysql_fetch_array($resulImagen)){
						array_push($imagen, $filaImagen["palabra"]);
					}

					$objeto1 = array_pop($imagen);
					$objeto2 = array_pop($imagen);
					$objeto3 = array_pop($imagen);
					$objeto4 = array_pop($imagen);
					$objeto5 = array_pop($imagen);
					$objeto6 = array_pop($imagen);

					$letra_buscada = $modeloEjercicioLetra -> consultarLetra($id_ejercicio);

					$contadorFila++;

					if($contadorFila & 1){
						$pdf->SetFont("Arial", "", 12);
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts:  '.$intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode('Duration:  '.$tiempo_llevado), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode('Letter:  '.$letra_buscada), 1, 1, 'C');

						$pdf->Cell(30, 10, utf8_decode('Objects:'), 1, 0, 'C');
						$pdf->Cell(160, 10, utf8_decode($objeto1.", ".$objeto2.", ".$objeto3.", ".$objeto4.", ".$objeto5.", ".$objeto6), 1, 1, 'C');

					}else{
						$pdf->SetFont("Arial", "", 12);
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(70, 10, utf8_decode('Failed Attempts:  '.$intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode('Duration:  '.$tiempo_llevado), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode('Letter:  '.$letra_buscada), 1, 1, 'C');

						$pdf->Cell(30, 10, utf8_decode('Objects:'), 1, 0, 'C');
						$pdf->Cell(160, 10, utf8_decode($objeto1.", ".$objeto2.", ".$objeto3.", ".$objeto4.", ".$objeto5.", ".$objeto6), 1, 1, 'C', true);
				
					}

				}else if($nombre_actividad == "SELECT THE IMAGE THAT´S ASSOCIATED TO THE WORD" && $id_ejercicio != $ejercicio ){

					$imagen = array();
	
					$ejercicio = $id_ejercicio;

					$resul = $modeloEjercicioImagen -> consultarImagen($id_ejercicio);

					while($filaImagen = mysql_fetch_array($resul)){
						array_push($imagen, $filaImagen["palabra"]);
					}

					$objeto1 = array_pop($imagen);
					$objeto2 = array_pop($imagen);
					$objeto3 = array_pop($imagen);
					$objeto4 = array_pop($imagen);

					$contadorFila++;

					if($contadorFila & 1){

						$pdf->SetFont("Arial", "", 12);
						$pdf->Cell(30, 10, utf8_decode('Objects:'), 1, 0, 'C');
						$pdf->Cell(160, 10, utf8_decode($objeto1.", ".$objeto2.", ".$objeto3.", ".$objeto4), 1, 1, 'C');
				
						$pdf->Cell(100, 10, utf8_decode('Failed:  '.$intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(90, 10, utf8_decode('Duration:  '.$tiempo_llevado), 1, 1, 'C');

					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->SetFont("Arial", "", 12);
						$pdf->Cell(30, 10, utf8_decode('Objects:'), 1, 0, 'C', true);
						$pdf->Cell(160, 10, utf8_decode($objeto1.", ".$objeto2.", ".$objeto3.", ".$objeto4), 1, 1, 'C', true);
				
						$pdf->Cell(100, 10, utf8_decode('Failed Attempts:  '.$intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(90, 10, utf8_decode('Duration:  '.$tiempo_llevado), 1, 1, 'C', true);

					}
				}else if($nombre_actividad == "ASSOCIATE THE WORDS WITH THE IMAGES" && $id_ejercicio != $ejercicio ){

					$imagen = array();
	
					$ejercicio = $id_ejercicio;

					$resul = $modeloEjercicioImagen -> consultarImagen($id_ejercicio);

					while($filaImagen = mysql_fetch_array($resul)){
						array_push($imagen, $filaImagen["palabra"]);
					}

					$objeto1 = array_pop($imagen);
					$objeto2 = array_pop($imagen);
					$objeto3 = array_pop($imagen);
					$objeto4 = array_pop($imagen);

					$contadorFila++;

					if($contadorFila & 1){

						$pdf->SetFont("Arial", "", 12);
						$pdf->Cell(30, 10, utf8_decode('Objects:'), 1, 0, 'C');
						$pdf->Cell(160, 10, utf8_decode($objeto1.", ".$objeto2.", ".$objeto3.", ".$objeto4), 1, 1, 'C');
				
						$pdf->Cell(100, 10, utf8_decode('Failed Attempts:  '.$intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(90, 10, utf8_decode('Duration:  '.$tiempo_llevado), 1, 1, 'C');

					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->SetFont("Arial", "", 12);
						$pdf->Cell(30, 10, utf8_decode('Objects:'), 1, 0, 'C', true);
						$pdf->Cell(160, 10, utf8_decode($objeto1.", ".$objeto2.", ".$objeto3.", ".$objeto4), 1, 1, 'C', true);
				
						$pdf->Cell(100, 10, utf8_decode('Failed Attempts:  '.$intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(90, 10, utf8_decode('Duration:  '.$tiempo_llevado), 1, 1, 'C', true);

					}
				}else if($nombre_actividad == "FIND THE IMAGES WITH THE MOST OBJECTS" && $id_ejercicio != $ejercicio ){

					$imagen = array();
	
					$ejercicio = $id_ejercicio;

					$resul = $modeloEjercicioImagen -> consultarImagen($id_ejercicio);

					while($filaImagen = mysql_fetch_array($resul)){
						array_push($imagen, $filaImagen["numero"]);
					}

					$objeto1 = array_pop($imagen);
					$objeto2 = array_pop($imagen);
					$objeto3 = array_pop($imagen);
					$objeto4 = array_pop($imagen);

					$contadorFila++;

					if($contadorFila & 1){

						$pdf->SetFont("Arial", "", 12);
						$pdf->Cell(50, 10, utf8_decode('Quantity of Objects:'), 1, 0, 'C');
						$pdf->Cell(140, 10, utf8_decode($objeto1.", ".$objeto2.", ".$objeto3.", ".$objeto4), 1, 1, 'C');
				
						$pdf->Cell(100, 10, utf8_decode('Failed Attempts:  '.$intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(90, 10, utf8_decode('Duration:  '.$tiempo_llevado), 1, 1, 'C');

					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->SetFont("Arial", "", 12);
						$pdf->Cell(50, 10, utf8_decode('Quantity of Objects:'), 1, 0, 'C', true);
						$pdf->Cell(140, 10, utf8_decode($objeto1.", ".$objeto2.", ".$objeto3.", ".$objeto4), 1, 1, 'C', true);
				
						$pdf->Cell(100, 10, utf8_decode('Failed Attempts:  '.$intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(90, 10, utf8_decode('Duration:  '.$tiempo_llevado), 1, 1, 'C', true);
					}
				}
		

			   }
			
			}

			if($resul_2){
			   while($fila_2 = mysql_fetch_array($resul_2)){
				$id_prueba = $fila_2["id_prueba"];
				$id_actividad = $fila_2["id_actividad"];
				$id_area = $fila_2["id_area"];
				$iteracion     = $fila_2["iteracion"];
				$nombre_actividad = $fila_2["nombre_actividad"];
				$fecha_prueba   = $fila_2["fecha_prueba"];
				$nombre_area = $fila_2["nombre_area"];
				$id_ano_escolar = $fila_2["id_ano_escolar"];
				$denominacion = "  ".$fila_2["denominacion"];
				$id_grado = $fila_2["id_grado"];
				$nivel = "  ".$fila_2["nivel"];
				$id_seccion = $fila_2["id_seccion"];
				$grupo = "  ".$fila_2["grupo"];

				if($nombre_actividad == "FIND THE LETTERS"){

					if( $datos_personales == false){

						$datos_personales = true;

						$pdf->SetFont("Arial", "B", 12);
						$pdf->SetFillColor( 111, 187, 245 );
						$pdf->Cell(45, 10, utf8_decode('school Year: '), 1, 0, 'R', true);
						$pdf->SetFont("Arial", "I", 12);
						$pdf->Cell(60, 10, utf8_decode($denominacion), 1, 1, 'L');

						$pdf->SetFont("Arial", "B", 12);
						$pdf->SetFillColor( 111, 187, 245 );
						$pdf->Cell(45, 10, utf8_decode('Grade: '), 1, 0, 'R',true);
						$pdf->SetFont("Arial", "I", 12);
						$pdf->Cell(60, 10, utf8_decode($nivel), 1, 1, 'L');

						$pdf->SetFont("Arial", "B", 12);
						$pdf->SetFillColor( 111, 187, 245 );
						$pdf->Cell(45, 10, utf8_decode('Section: '), 1, 0, 'R', true);

						$pdf->SetFont("Arial", "I", 12);
						$pdf->Cell(60, 10, utf8_decode($grupo), 1, 1, 'L');

						$pdf->Ln(5);
					}

					if($id_prueba != $prueba){
						$prueba = $id_prueba;

						$id_area = $area;

						$contadorFila = 0;

						$pdf->Ln(8);

						$pdf->SetFont("Arial", "B", 12);
						$pdf->SetFillColor( 111, 187, 245 );
						$pdf->Cell(30, 10, utf8_decode('Area: '), 1, 0, 'C', true);

						$pdf->SetFont("Arial", "", 12);
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(160, 10, utf8_decode($nombre_area), 1, 1, 'C', true);

						$pdf->SetFont("Arial", "B", 12);
						$pdf->SetFillColor( 111, 187, 245 );
						$pdf->Cell(30, 10, utf8_decode('Activity: '), 1, 0, 'C', true);

						$pdf->SetFont("Arial", "", 12);
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(160, 10, utf8_decode($nombre_actividad), 1, 1, 'C', true);

						$pdf->SetFont("Arial", "B", 12);
						$pdf->SetFillColor( 111, 187, 245 );
						$pdf->Cell(30, 10, utf8_decode('Iteration:'), 1, 0, 'C', true);

						$pdf->SetFont("Arial", "", 12);
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(50, 10, utf8_decode($iteracion), 1, 0, 'C', true);

						$pdf->SetFont("Arial", "B", 12);
						$pdf->SetFillColor( 111, 187, 245 );
						$pdf->Cell(30, 10, utf8_decode('Date: '), 1, 0, 'C', true);

						$pdf->SetFont("Arial", "", 12);
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(80, 10, utf8_decode($fecha_prueba), 1, 1, 'C', true);

						$pdf->SetFont("Arial", "B", 12);
						$pdf->SetFillColor( 111, 187, 245 );
						$pdf->Cell(60, 10, utf8_decode('Letter'), 1, 0, 'C', true);

						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}

					$pdf->SetFont("Arial", "", 12);

					$letra        	   = $fila_2["caracter"];					
					$intento_sin_exito = $fila_2["intento_sin_exito"];
					$tiempo_llevado    = $fila_2["tiempo_llevado"];

					$contadorFila++;

					if($contadorFila & 1){
						$pdf->Cell(60, 10, utf8_decode($letra), 1, 0, 'C');
				
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');
					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($letra), 1, 0, 'C', true);
				
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}
				
				}
			}

		}

		if($resul_3){
			   while($fila_3 = mysql_fetch_array($resul_3)){
				$id_prueba = $fila_3["id_prueba"];
				$id_actividad = $fila_3["id_actividad"];
				$id_area = $fila_3["id_area"];
				$iteracion     = $fila_3["iteracion"];
				$nombre_actividad = $fila_3["nombre_actividad"];
				$fecha_prueba   = $fila_3["fecha_prueba"];
				$nombre_area = $fila_3["nombre_area"];
				$id_ano_escolar = $fila_3["id_ano_escolar"];
				$denominacion = "  ".$fila_3["denominacion"];
				$id_grado = $fila_3["id_grado"];
				$nivel = "  ".$fila_3["nivel"];
				$id_seccion = $fila_3["id_seccion"];
				$grupo = "  ".$fila_3["grupo"];

				if( $datos_personales == false){

					$datos_personales = true;

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(45, 10, utf8_decode('School Year: '), 1, 0, 'R', true);
					$pdf->SetFont("Arial", "I", 12);
					$pdf->Cell(60, 10, utf8_decode($denominacion), 1, 1, 'L');

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(45, 10, utf8_decode('Grade: '), 1, 0, 'R',true);
					$pdf->SetFont("Arial", "I", 12);
					$pdf->Cell(60, 10, utf8_decode($nivel), 1, 1, 'L');

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(45, 10, utf8_decode('Section: '), 1, 0, 'R', true);

					$pdf->SetFont("Arial", "I", 12);
					$pdf->Cell(60, 10, utf8_decode($grupo), 1, 1, 'L');

					$pdf->Ln(5);
				}

				if($id_prueba != $prueba){
					$prueba = $id_prueba;

					$id_area = $area;

					$contadorFila = 0;

					$pdf->Ln(8);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(30, 10, utf8_decode('Area: '), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(160, 10, utf8_decode($nombre_area), 1, 1, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(30, 10, utf8_decode('Activity: '), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(160, 10, utf8_decode($nombre_actividad), 1, 1, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(30, 10, utf8_decode('Iteration:'), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(50, 10, utf8_decode($iteracion), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );
					$pdf->Cell(30, 10, utf8_decode('Date: '), 1, 0, 'C', true);

					$pdf->SetFont("Arial", "", 12);
					$pdf->SetFillColor( 233, 235, 237 );
					$pdf->Cell(80, 10, utf8_decode($fecha_prueba), 1, 1, 'C', true);

					$pdf->SetFont("Arial", "B", 12);
					$pdf->SetFillColor( 111, 187, 245 );

					if($nombre_actividad == "COMPLETE THE SEQUENCE OF NUMBERS"){
						$pdf->Cell(60, 10, utf8_decode('Sequence of Numbers'), 1, 0, 'C', true);

						$pdf->Cell(70, 10, utf8_decode('Failed Attempts'), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode('Duration'), 1, 1, 'C', true);
					}
				}

				
				$pdf->SetFont("Arial", "", 12);

				if($nombre_actividad == "COMPLETE THE SEQUENCE OF NUMBERS"){
					$secuencia_numero  = $fila_3["ordenamiento"];					
					$intento_sin_exito = $fila_3["intento_sin_exito"];
					$tiempo_llevado    = $fila_3["tiempo_llevado"];

					$contadorFila++;

					if($contadorFila & 1){

						$pdf->Cell(60, 10, utf8_decode($secuencia_numero), 1, 0, 'C');
				
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C');
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C');

					}else{
						$pdf->SetFillColor( 233, 235, 237 );
						$pdf->Cell(60, 10, utf8_decode($secuencia_numero), 1, 0, 'C', true);
				
						$pdf->Cell(70, 10, utf8_decode($intento_sin_exito), 1, 0, 'C', true);
						$pdf->Cell(60, 10, utf8_decode($tiempo_llevado), 1, 1, 'C', true);
					}
				}
			}

		}

		$pdf->Output(utf8_decode('Student´s Performance.pdf'),'i');
		}
	}
?>
