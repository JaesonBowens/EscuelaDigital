<?php
	session_start();

	include("../../modelo/imagen.php");
	include("../../modelo/actividad.php");
	include("../../modelo/ejercicio.php");
	include("../../modelo/ejercicio_imagen.php");
	include("../../modelo/prueba.php");
	include("../../modelo/ano_escolar.php");
	include("../../modelo/estudiante_seccion.php");
	include("../../modelo/agrupacion.php");
	include("../../modelo/agrupacion_imagen.php");

	$modeloImagen = new ModeloImagen;
	$modeloActividad = new ModeloActividad;
	$modeloEjercicio = new ModeloEjercicio;
	$modeloEjercicioImagen = new ModeloEjercicioImagen;
	$modeloPrueba = new ModeloPrueba;
	$modeloAnoEscolar = new ModeloAnoEscolar;
	$modeloEstudianteSeccion = new ModeloEstudianteSeccion;
	$modeloAgrupacion = new ModeloAgrupacion;
	$modeloAgrupacionImagen = new ModeloAgrupacionImagen;

	if(isset($_POST["consultarActividad"])){

		//Optenemos el id de la actividad
		$nombre_actividad = "SUM THE OBJECTS";

		//Verificamos que no posea iteraciones
		if(!isset($_SESSION["act11_consultar_imagenes"]) || $_SESSION['act11_consultar_imagenes'] == true){

			$id_agrupacion = array();

			//Consultamos las imagenes para las actividades
			$resulA = $modeloAgrupacion -> consultarAleatoria();

			//Verificamos que la BD posea imagenes dependiendo de la actividad
			if($resulA){
				while($filaA = mysql_fetch_array($resulA)){
					//Copiamos la consulta al arreglo id_imagen
					array_push($id_agrupacion, $filaA["id_agrupacion"]);
				}

				//Guardamos el arreglo en una variable de sesion
				$_SESSION["act11_id_agrupacion"] = $id_agrupacion;

			}else{
				//Si no posee imagenes redireccionamos al menu con el mensaje correspondiente
				$_SESSION["mensaje"] = "There are no images to execute the activity";

				$actividad = array ();
					
				$actividad["id_img1"] = "exit";

			    echo json_encode($actividad);
			    return;
			}
		}
		
		//Verificamos que aun halla imagenes para interactuar
		if(count($_SESSION["act11_id_agrupacion"]) != 0){
			$id_agrupacion_consultar = array_pop($_SESSION['act11_id_agrupacion']);

			$resulAgrupacionImagen = $modeloAgrupacionImagen -> consultarPorIdAgrupacion($id_agrupacion_consultar);

			$id_imagen = array();

			if($resulAgrupacionImagen){
				while($filaAgrupacionImagen = mysql_fetch_array($resulAgrupacionImagen)){
					//Copiamos la consulta al arreglo id_imagen
					array_push($id_imagen, $filaAgrupacionImagen["id_imagen"]);
				}

			}

			//Extraemos el ultimo elemento del arreglo
			$id_imag1 = array_pop($id_imagen);
			$id_imag2 = array_pop($id_imagen);
				
			$resul1 = $modeloImagen -> consultarUnoPorId($id_imag1);
			$resul2 = $modeloImagen -> consultarUnoPorId($id_imag2);

			if($resul1 && $resul2){
				//Extraemos la consulta y enviamos al cliente
				$fila1 = mysql_fetch_array($resul1);
				$fila2 = mysql_fetch_array($resul2);

				$actividad = array ();
				
				$actividad["id_img1"]    = $fila1["id_imagen"];
				$actividad["direccion1"] = '../'.$fila1["direccion_imagen"];
				$actividad["lng_sena1"] = $fila1["lenguaje_sena"];
				$actividad["numero1"]  = $fila1["numero"];

				$actividad["id_img2"]    = $fila2["id_imagen"];
				$actividad["direccion2"] = '../'.$fila2["direccion_imagen"];
				$actividad["lng_sena2"] = $fila2["lenguaje_sena"];
				$actividad["numero2"]  = $fila2["numero"];

		    	echo json_encode($actividad);
			}
		}
		else{
			//Si se acaban las imagenes de la consulta redireccionamos al menu
			$_SESSION["mensaje"] = "Excellent";

			$actividad = array ();
				
			$actividad["id_img1"] = "exit";

		    echo json_encode($actividad);
		}	
	}

	else if(isset($_POST["anotar"])){
		$arreglo 	= json_decode(stripslashes($_POST["anotar"])); 
		$intento 	= $arreglo->intentoP;

		$tiempo_llevado = $arreglo->tiempo_llevadoP;
		$id_imagen1 	= $arreglo->id_imagen1;
		$id_imagen2 	= $arreglo->id_imagen2;
		$id_estudiante 	= $_SESSION["ses_id_estudiante"];

		$nombre_actividad = "SUM THE OBJECTS";
		
		$id_actividad 	= $modeloActividad->conseguirIdActividad($nombre_actividad);

		date_default_timezone_set('America/Caracas');

		$fecha_prueba = date("Y-m-d");

		$iteracion = $_SESSION["act11_iteracion_prueba"];

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
					$_SESSION["act11_iteracion_prueba"] = $iteracion + 1;
					$_SESSION["act11_consultar_imagenes"] = false;
					$id_prueba = $modeloPrueba -> incluir($fecha_prueba, $iteracion, $id_actividad, $id_estudiante_seccion);
					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen1);

					$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen2);
		
				}else{

					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen1);

					$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen2);
		
				}

			}
				
		}

	}
?>
