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

		$nombre_actividad = "PLACE THE FIRST LETTER";

		//Verificamos que no posea iteraciones
		if(!isset($_SESSION["act1_consultar_imagenes"]) || $_SESSION['act1_consultar_imagenes'] == true){

			$id_imagen = array();

			//Consultamos las imagenes para las actividades
			$resulA = $modeloActividad -> consultarActividadPorNombre($nombre_actividad);

			//Verificamos que la BD posea imagenes dependiendo de la actividad
			if($resulA){
				while($filaA = mysql_fetch_array($resulA)){
					//Copiamos la consulta al arreglo id_imagen
					array_push($id_imagen, $filaA["id_img"]);
				}

				//Guardamos el arreglo en una variable de sesion
				//Para que en las iteraciones trabajar con las imagenes consultadas al comienzo
				$_SESSION["act1_id_imagen"] = $id_imagen;
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
		if(count($_SESSION["act1_id_imagen"]) != 0){
			//Extraemos el ultimo elemento del arreglo
			$id_imag = array_pop($_SESSION["act1_id_imagen"]);

			//Consultamos la imagen	
			$resulB = $modeloImagen -> consultarUnoPorId($id_imag);

			if($resulB){
				//Extraemos la consulta y enviamos al cliente
				$filaB = mysql_fetch_array($resulB);

				$actividad = array ();
				
				$actividad["id_img"] = $filaB["id_imagen"];
				$actividad["direccion"] = '../'.$filaB["direccion_imagen"];
				$actividad["lng_sena"] = $filaB["lenguaje_sena"];
				$actividad["audio"] = $filaB["direccion_audio"];
				$actividad["pregunta"] = $filaB["palabra"];

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
		$id_imagen   	= $arreglo->id_imagen;
		$id_estudiante  = $_SESSION["ses_id_estudiante"];

		$nombre_actividad = "PLACE THE FIRST LETTER";
		
		$id_actividad 	= $modeloActividad->conseguirIdActividad($nombre_actividad);

		date_default_timezone_set('America/Caracas');

		$fecha_prueba = date("Y-m-d");

		$iteracion = $_SESSION["act1_iteracion_prueba"];

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
					$_SESSION["act1_iteracion_prueba"] = $iteracion + 1;
					$_SESSION["act1_consultar_imagenes"] = false;
					$id_prueba = $modeloPrueba -> incluir($fecha_prueba, $iteracion, $id_actividad, $id_estudiante_seccion);
					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen);
		
				}else{

					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					$modeloEjercicioImagen -> incluir($id_ejercicio, $id_imagen);
		
				}

			}
				
		}

	}
?>
