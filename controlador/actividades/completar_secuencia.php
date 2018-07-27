<?php
	session_start();

	include("../../modelo/secuencia.php");
	include("../../modelo/actividad.php");
	include("../../modelo/ejercicio.php");
	include("../../modelo/ejercicio_secuencia.php");
	include("../../modelo/prueba.php");
	include("../../modelo/ano_escolar.php");
	include("../../modelo/estudiante_seccion.php");

	$modeloSecuencia = new ModeloSecuencia;
	$modeloActividad = new ModeloActividad;
	$modeloEjercicio = new ModeloEjercicio;
	$modeloEjercicioSecuencia = new ModeloEjercicioSecuencia;
	$modeloPrueba = new ModeloPrueba;
	$modeloAnoEscolar = new ModeloAnoEscolar;
	$modeloEstudianteSeccion = new ModeloEstudianteSeccion;


	if(isset($_POST["anotar"])){
		$arreglo 	= json_decode(stripslashes($_POST["anotar"])); 
		$intento 	= $arreglo->intentoP;
		$tiempo_llevado = $arreglo->tiempo_llevadoP;
		$ordenamiento   = $arreglo->secuenciaP;  
 	
		$id_estudiante  = $_SESSION["ses_id_estudiante"];

		$nombre_actividad = "COMPLETE THE NUMBER SEQUENCES";
		
		$id_actividad 	= $modeloActividad->conseguirIdActividad($nombre_actividad);

		date_default_timezone_set('America/Caracas');

		$fecha_prueba = date("Y-m-d");

		$iteracion = $_SESSION["act15_iteracion_prueba"];

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
					$_SESSION["act15_iteracion_prueba"] = $iteracion + 1;
					$id_prueba = $modeloPrueba -> incluir($fecha_prueba, $iteracion, $id_actividad, $id_estudiante_seccion);
					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					$id_secuencia = $modeloSecuencia -> consultarSecuencia($ordenamiento);

					if($id_secuencia == false){
						$id_secuencia = $modeloSecuencia -> incluir($ordenamiento);
						$modeloEjercicioSecuencia -> incluir($id_ejercicio, $id_secuencia);
					}else{
						$modeloEjercicioSecuencia -> incluir($id_ejercicio, $id_secuencia);
					}
		
				}else{

					$id_ejercicio = $modeloEjercicio -> incluir($intento, $tiempo_llevado, $id_prueba);

					$id_secuencia = $modeloSecuencia -> consultarSecuencia($ordenamiento);

					if($id_secuencia == false){
						$id_secuencia = $modeloSecuencia -> incluir($ordenamiento);
						$modeloEjercicioSecuencia -> incluir($id_ejercicio, $id_secuencia);
					}else{
						$modeloEjercicioSecuencia -> incluir($id_ejercicio, $id_secuencia);
					}
		
				}

			}
				
		}

	}
?>
