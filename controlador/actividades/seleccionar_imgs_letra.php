<?php
	session_start();

	include("../../modelo/imagen.php");
	include("../../modelo/actividad.php");
	include("../../modelo/ejercicio.php");
	include("../../modelo/ejercicio_imagen.php");
	include("../../modelo/letra.php");
	include("../../modelo/ejercicio_letra.php");
	include("../../modelo/prueba.php");
	include("../../modelo/ano_escolar.php");
	include("../../modelo/estudiante_seccion.php");

	$modeloImagen = new ModeloImagen;
	$modeloActividad = new ModeloActividad;
	$modeloEjercicio = new ModeloEjercicio;
	$modeloEjercicioImagen = new ModeloEjercicioImagen;
	$modeloLetra = new ModeloLetra;
	$modeloEjercicioLetra = new ModeloEjercicioLetra;
	$modeloPrueba = new ModeloPrueba;
	$modeloAnoEscolar = new ModeloAnoEscolar;
	$modeloEstudianteSeccion = new ModeloEstudianteSeccion;

	if(isset($_POST["consultarActividad"])){

		$nombre_actividad = "SELECT THE OBJECTS WHOSE FIRST LETTER IS EQUAL TO THE INDICATED";

		if(!isset($_SESSION["act13_consultar_imagenes"]) || $_SESSION['act13_consultar_imagenes'] == true){

			$id_imagen = array();

			//Ya con la base de datos se realiza la consulta eligiendo una resuesta al azar y enviamos
			//$resulA = $modeloActividad -> consultarActividadVarias($id_actividad, $num);
			$resulA = $modeloActividad -> consultarVariasImagenes($nombre_actividad);

			if($resulA){
				while($filaA = mysql_fetch_array($resulA)){
					array_push($id_imagen, $filaA["id_img"]);
				}

				$_SESSION['act13_id_imagen'] = $id_imagen;
			}else{
				//Si no posee imagenes redireccionamos al menu con el mensaje correspondiente
				$_SESSION["mensaje"] = "There are no images to execute the activity";

				$actividad = array ();
					
				$actividad["id_img"] = "exit";

			    echo json_encode($actividad);
			    return;
			}
		}

		
		//Verificamos que aun halla imagenes para interactuar
		if(isset($_SESSION["act13_id_imagen"]) && count($_SESSION["act13_id_imagen"]) >= 6){

			$imagen = array();

			for ($x = 0; $x < 6; $x++) {
				$id_imagen_pasar = array_pop($_SESSION['act13_id_imagen']);
				array_push($imagen, $id_imagen_pasar);
			}
		
			$id_imag1 = array_pop($imagen);
			$id_imag2 = array_pop($imagen);
			$id_imag3 = array_pop($imagen);
			$id_imag4 = array_pop($imagen);
			$id_imag5 = array_pop($imagen);
			$id_imag6 = array_pop($imagen);
			
			$resul2 = $modeloImagen -> consultarUnoPorId($id_imag1);
			$resul3 = $modeloImagen -> consultarUnoPorId($id_imag2);
			$resul4 = $modeloImagen -> consultarUnoPorId($id_imag3);
			$resul5 = $modeloImagen -> consultarUnoPorId($id_imag4);
			$resul6 = $modeloImagen -> consultarUnoPorId($id_imag5);
			$resul7 = $modeloImagen -> consultarUnoPorId($id_imag6);


			if($resul2 && $resul3 && $resul4 && $resul5 && $resul6 && $resul7){
				$fila2 = mysql_fetch_array($resul2);
				$fila3 = mysql_fetch_array($resul3);
				$fila4 = mysql_fetch_array($resul4);
				$fila5 = mysql_fetch_array($resul5);
				$fila6 = mysql_fetch_array($resul6);
				$fila7 = mysql_fetch_array($resul7);

				$actividad["id_img"] = array(
					$fila2["id_imagen"], 
					$fila3["id_imagen"],
					$fila4["id_imagen"],
					$fila5["id_imagen"],
					$fila6["id_imagen"],
					$fila7["id_imagen"]
				);

				$actividad["direccion"] = array(
					'../'.$fila2["direccion_imagen"], 
					'../'.$fila3["direccion_imagen"],
					'../'.$fila4["direccion_imagen"],
					'../'.$fila5["direccion_imagen"],
					'../'.$fila6["direccion_imagen"],
					'../'.$fila7["direccion_imagen"]
				);

				$actividad["palabra"] = array(
					ucfirst(strtolower($fila2["palabra"])), 
					ucfirst(strtolower($fila3["palabra"])),
					ucfirst(strtolower($fila4["palabra"])),
					ucfirst(strtolower($fila5["palabra"])),
					ucfirst(strtolower($fila6["palabra"])),
					ucfirst(strtolower($fila7["palabra"]))
				);	
				
				$actividad["lng_sena"] = array(
					
					$fila2["lenguaje_sena"], 
					$fila3["lenguaje_sena"],
					$fila4["lenguaje_sena"],
					$fila5["lenguaje_sena"],
					$fila6["lenguaje_sena"],
					$fila7["lenguaje_sena"]
				);

	    		echo json_encode($actividad);
			}

		}else{
			//Si se acaban las imagenes de la consulta redireccionamos al menu
			$_SESSION["mensaje"] = "Excellent";

			$actividad = array ();
				
			$actividad["id_img"] = "exit";

		    	echo json_encode($actividad);
		}
	
	}


	//Si la respuesta que se envie al servidor es diferente de vacia
	//Osea que el alumno interactuo con el juego
	//Procedemos a crear el codigo para guardar en BD si lo hizo bien o no
		

	else if(isset($_POST["anotar"])){
		$arreglo 	= json_decode(stripslashes($_POST["anotar"])); 
		$intento 	= $arreglo->intentoP;

		$tiempo_llevado = $arreglo->tiempo_llevadoP;

		$caracter   	= $arreglo->caracterP;

		$imagen["id_imagen"] = array(
			$arreglo->id_imagenP1,
			$arreglo->id_imagenP2,
			$arreglo->id_imagenP3,
			$arreglo->id_imagenP4,
			$arreglo->id_imagenP5,
			$arreglo->id_imagenP6
		);

		$id_estudiante  = $_SESSION["ses_id_estudiante"];

		$nombre_actividad = "SELECT THE OBJECTS WHOSE FIRST LETTER IS EQUAL TO THE INDICATED";
		
		$id_actividad 	= $modeloActividad->conseguirIdActividad($nombre_actividad);

		date_default_timezone_set('America/Caracas');

		$fecha_prueba = date("Y-m-d");

		$iteracion = $_SESSION["act13_iteracion_prueba"];

		$resulC = $modeloAnoEscolar->consultarActivo();

		if($resulC){
			$filaC = mysql_fetch_array($resulC);
			$id_ano_escolar = $filaC['id_ano_escolar'];
			$resulD = $modeloEstudianteSeccion->consultarEstudianteInscrito($id_estudiante, $id_ano_escolar);
			
			if($resulD){
				$filaD = mysql_fetch_array($resulD);
				$id_estudiante_seccion = $filaD['id_estudiante_seccion'];
				
				$id_prueba = $modeloPrueba -> consultar($iteracion, $id_estudiante_seccion, $id_actividad);

				if($id_prueba == false){
					$iteracion = $modeloPrueba -> contar($id_estudiante_seccion, $id_actividad);
					$_SESSION["act13_iteracion_prueba"] = $iteracion + 1;
					$_SESSION["act13_consultar_imagenes"] = false;
					$id_prueba = $modeloPrueba -> incluir($fecha_prueba, $iteracion, $id_actividad, $id_estudiante_seccion);
					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen);

					for ($x = 0; $x < 6; $x++) {
						$id_imagen = array_pop($imagen["id_imagen"]);
						$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen);
					} 

					$id_letra = $modeloLetra -> consultarLetra($caracter);

					if($id_letra == false){
						$id_letra = $modeloLetra -> incluir($caracter);
						$modeloEjercicioLetra -> incluir($id_ejercicio, $id_letra);
					}else{
						$modeloEjercicioLetra -> incluir($id_ejercicio, $id_letra);
					}
		
				}else{

					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					for ($x = 0; $x < 6; $x++) {
						$id_imagen = array_pop($imagen["id_imagen"]);
						$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen);
					} 

					if($id_letra == false){
						$id_letra = $modeloLetra -> incluir($caracter);
						$modeloEjercicioLetra -> incluir($id_ejercicio, $id_letra);
					}else{
						$modeloEjercicioLetra -> incluir($id_ejercicio, $id_letra);
					}
		
				}

			}
				
		}

	}
?>
