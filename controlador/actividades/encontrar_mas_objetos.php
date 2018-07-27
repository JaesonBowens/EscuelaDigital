<?php
	session_start();

	include("../../modelo/imagen.php");
	include("../../modelo/actividad.php");
	include("../../modelo/ejercicio.php");
	include("../../modelo/ejercicio_imagen.php");
	include("../../modelo/prueba.php");
	include("../../modelo/ano_escolar.php");
	include("../../modelo/estudiante_seccion.php");

	$modeloImagen = new ModeloImagen;
	$modeloActividad = new ModeloActividad;
	$modeloEjercicio = new ModeloEjercicio;
	$modeloEjercicioImagen = new ModeloEjercicioImagen;
	$modeloPrueba = new ModeloPrueba;
	$modeloAnoEscolar = new ModeloAnoEscolar;
	$modeloEstudianteSeccion = new ModeloEstudianteSeccion;

	if(isset($_POST["consultarActividad"])){

		$nombre_actividad = "FIND THE IMAGES WITH THE MOST OBJECTS";
		//$num = "10";

		if(!isset($_SESSION["act16_consultar_imagenes"]) || $_SESSION['act16_consultar_imagenes'] == true){
			$id_imagen = array();

			//Ya con la base de datos se realiza la consulta eligiendo una resuesta al azar y enviamos
			//$resulA = $modeloActividad -> consultarActividadVarias($id_actividad, $num);
			$resulA = $modeloActividad -> consultarActividadPorNombre($nombre_actividad);

			$numFila = mysql_num_rows($resulA);

			if($resulA && $numFila > 3){
				while($filaA = mysql_fetch_array($resulA)){
					array_push($id_imagen, $filaA["id_img"]);
				}

				$_SESSION['act16_id_imagen'] = $id_imagen;
			}
			else{
				//Si no posee imagenes redireccionamos al menu con el mensaje correspondiente
				$_SESSION["mensaje"] = "There are no images to execute the activity";

				$actividad = array ();
					
				$actividad["id_img"] = "exit";

			    echo json_encode($actividad);
			    return;
			}
		}

		//Verificamos que aun halla imagenes para interactuar
		if( count($_SESSION["act16_id_imagen"]) > 3 ){
			$i = 0;
			$id_imag = array();

			while( $i != 4 ){
				$id_imag[$i] = comparar($id_imag, $modeloImagen, 0);

				$i++;
			}

			if( $id_imag[0] != null && $id_imag[1] != null && $id_imag[2] != null && $id_imag[3] != null ){
			
				$resul2 = $modeloImagen -> consultarUnoPorId($id_imag[0]);
				$resul3 = $modeloImagen -> consultarUnoPorId($id_imag[1]);
				$resul4 = $modeloImagen -> consultarUnoPorId($id_imag[2]);
				$resul5 = $modeloImagen -> consultarUnoPorId($id_imag[3]);

				if($resul2 && $resul3 && $resul4 && $resul5){
					$fila2 = mysql_fetch_array($resul2);
					$fila3 = mysql_fetch_array($resul3);
					$fila4 = mysql_fetch_array($resul4);
					$fila5 = mysql_fetch_array($resul5);

					$actividad["id_img"] = array(
						$fila2["id_imagen"], 
						$fila3["id_imagen"],
						$fila4["id_imagen"],
						$fila5["id_imagen"]
					);

					$actividad["direccion"] = array(
						'../'.$fila2["direccion_imagen"], 
						'../'.$fila3["direccion_imagen"],
						'../'.$fila4["direccion_imagen"],
						'../'.$fila5["direccion_imagen"]
					);

					$actividad["numero"] = array(
						$fila2["numero"], 
						$fila3["numero"],
						$fila4["numero"],
						$fila5["numero"]
					);	
					
					$actividad["lng_sena"] = array(
						$fila2["lenguaje_sena"], 
						$fila3["lenguaje_sena"],
						$fila4["lenguaje_sena"],
						$fila5["lenguaje_sena"]
					);

		    		echo json_encode($actividad);
				}
			}
			else{
				//Si se acaban las imagenes de la consulta redireccionamos al menu
				$_SESSION["mensaje"] = "Excellent";

				$actividad = array ();
					
				$actividad["id_img"] = "exit";

			    echo json_encode($actividad);
			}
		}
		else{
			//Si se acaban las imagenes de la consulta redireccionamos al menu
			$_SESSION["mensaje"] = "Excellent";

			$actividad = array ();
				
			$actividad["id_img"] = "exit";

		    echo json_encode($actividad);
		}
	
	}

	else if(isset($_POST["anotar"])){
		$arreglo 	= json_decode(stripslashes($_POST["anotar"])); 
		$intento 	= $arreglo->intentoP;

		$tiempo_llevado = $arreglo->tiempo_llevadoP;

		$imagen["id_imagen"] = array(
			$arreglo->id_imagenP1,
			$arreglo->id_imagenP2,
			$arreglo->id_imagenP3,
			$arreglo->id_imagenP4,
		);

		$id_estudiante  = $_SESSION["ses_id_estudiante"];

		$nombre_actividad = "FIND THE IMAGES WITH THE MOST OBJECTS";
		
		$id_actividad 	= $modeloActividad->conseguirIdActividad($nombre_actividad);

		date_default_timezone_set('America/Caracas');

		$fecha_prueba = date("Y-m-d");

		$iteracion = $_SESSION["act16_iteracion_prueba"];

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
					$_SESSION["act16_iteracion_prueba"] = $iteracion + 1;
					$_SESSION["act16_consultar_imagenes"] = false;
					$id_prueba = $modeloPrueba -> incluir($fecha_prueba, $iteracion, $id_actividad, $id_estudiante_seccion);
					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen);

					for ($x = 0; $x < 4; $x++) {
						$id_imagen = array_pop($imagen["id_imagen"]);
						$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen);
					} 
		
				}else{

					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					for ($x = 0; $x < 4; $x++) {
						$id_imagen = array_pop($imagen["id_imagen"]);
						$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen);
					} 
		
				}

			}
				
		}

	}

	function comparar($img_mostrar, $modeloImagen, $num){
		$comparacion = true;
		$cont = $num;

		//Capturamos el ultimo elemento del array
		$img = array_pop( $_SESSION['act16_id_imagen'] );

		//Consultamos lo que necesitamos de la imagen --numero--
		$resul = $modeloImagen -> consultarUnoPorId( $img );

		if( $resul ){
			$fila = mysql_fetch_array($resul);

			//Reccorremos lo que ya tenemos en el arreglo que pasamos como parametro
			for( $i = 0; $i < count($img_mostrar); $i++ ){
				//Consultamos lo que necesitamos de las imagenes que ya tenemos para mostrar --numero--
				$resul_mostrar = $modeloImagen -> consultarUnoPorId( $img_mostrar[$i] );

				$fila_mostrar = mysql_fetch_array($resul_mostrar);
				
				//Comparamos el numero del ultimo elemento del arreglo con los de las imagenes que ya tenemos para mostrar
				//Si son iguales guarda falso, es decir para no mostrar imagenes con la misma cantidad de objetos
				if( $fila["numero"] == $fila_mostrar["numero"] ){
					$comparacion = false;
				}
			}

			if( $comparacion ){
				return $img;
			}
			else{
				if( $cont == 10 ){
					return null;
				}
				else{
					$cont++;
					array_unshift($_SESSION['act16_id_imagen'], $img);
					return comparar($img_mostrar, $modeloImagen, $cont);
				}
			}
		}
		else{
			return null;
		}
	}
?>
