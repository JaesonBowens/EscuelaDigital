<?php
	session_start();

	include("../modelo/imagen.php");
	include("../modelo/actividad.php");

	$modeloImagen = new ModeloImagen;
	$modeloActividad = new ModeloActividad;

	if(isset($_REQUEST["id_estudiante"])){
		$id_estudiante = htmlentities($_REQUEST["id_estudiante"]);
		$contenido          = json_decode(stripslashes($_REQUEST["contenido"]));

		$_SESSION["ses_id_estudiante"] = $id_estudiante;

		$_SESSION["id_contenido"] = $contenido->contenido;

		header("location: ../vista/menu_ninos.php");
	}

	if(isset($_GET["actualizar"])){
		$contenido = json_decode(stripslashes($_GET["contenido"]));

		$_SESSION["id_contenido"] = $contenido->contenido;

		header("location: ../vista/menu_ninos.php");
	}

	if(isset($_POST["comprobarActividad"])){
		$contenido = json_decode(stripslashes($_POST["comprobarActividad"]));

		//Consultamos para verificar que posea imagenes cargadas
		$resul = $modeloImagen -> realizarConsultaAvanzada(NULL, NULL, NULL);

		$numFila = mysql_num_rows($resul);

		if( $numFila > 0 ){
			//Consultamos todas las actividades
			$resul_act = $modeloActividad -> consultarTodo();

			if( $resul_act ){
				$cont = 0;
				//Recorremos todas las actividades
				while( $fila = mysql_fetch_array($resul_act) ){
					$nombre_actividad = $fila["nombre_actividad"];

					//Verificamos que las actividades posean suficientes imagenes para poder ejecutarse
					$resulAct = $modeloActividad -> consultarParaMenu($nombre_actividad, $contenido->contenido);

					if( $resulAct ){
						$numFila_act = mysql_num_rows($resulAct);
						
						//Verificamos que posea mas de 5 imagenes asociadas a la actividad
						if( $numFila_act > 5 ){
							$_SESSION[$nombre_actividad] = "YES";
							$cont++;
						}
						else{
							$_SESSION[$nombre_actividad] = "NO";
						}
					}
					else if($nombre_actividad == "FIND THE LETTERS"){
						$_SESSION[$nombre_actividad] = "YES";
					}
					else if($nombre_actividad == "COMPLETE THE NUMBER SEQUENCES"){
						$_SESSION[$nombre_actividad] = "YES";
					}
					else{
						$_SESSION[$nombre_actividad] = "NO";
					}
				}

				if( $cont != 0 ){
					$mensaje["resultado"] = "YES";
				}
				else{
					$mensaje["resultado"] = "NO";

					if( count($contenido->contenido) > 1 ){
						$mensaje["msj"] = "The selected contents don´t have sufficient image";
					}
					else{
						$mensaje["msj"] = "The selected contents don´t have sufficient image";
					}
				}
			}
			else{
				$mensaje["resultado"] = "NO";
				$mensaje["msj"] = "Error loading the Activities";
			}
		}
		else{
			$mensaje["resultado"] = "NO";
			$mensaje["msj"] = "There´s not enough images";
		}

		echo json_encode($mensaje);
	}
?>
