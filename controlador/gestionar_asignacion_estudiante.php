<?php
	session_start();

	include("../modelo/estudiante.php");	

	include("../modelo/estudiante_seccion.php");	
	
	include("../modelo/bitacora.php");

	include("../modelo/ano_escolar.php");

	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		$modelo = new ModeloEstudianteSeccion;

		$modeloEstudiante = new ModeloEstudiante;
		
		$modeloBitacora = new ModeloBitacora;

		$modeloAnoEscolar = new ModeloAnoEscolar;

		//$modeloGrado = new ModeloGrado;

		if(isset($_POST["incluir"])){
			$cont = antiInjectionSql($_POST["cont"]);
			$resul = true;

			if($cont != 0){
				$id_estudiante  = $_POST["id_estudiante_asignado"];
				$id_seccion     = $_POST["id_seccion_asignado"];
				$id_ano_escolar = $_POST["id_ano_escolar_asignado"];

				$contArreglo = count($id_estudiante);

				for($i=0; $i<$contArreglo; $i++){
					
					$resul = $modelo -> incluir('A', $id_estudiante[$i], $id_seccion[$i], $id_ano_escolar[$i]);

					if(!$resul){
						$resul = false;
					}
				}

				if($resul){
					$_SESSION["mensaje"] = "Assignment Registered Successfully";

					$tabla_bitacora = "student_section";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = " ";

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
				}
				else{
					$_SESSION["mensaje"] = "Error registering, consult your Data Base Provider";
				}
			}
			else{
				$_SESSION["mensaje"] = "Please Assign Students";
			}

			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_estudiante.php'/>";
		}

		else if(isset($_POST["modificar"])){
			$cont = antiInjectionSql($_POST["cont"]);

			$resulM = true;
			$resulE = true;

			if($cont != 0){

				$id_estudiante      = $_POST["id_estudiante_asignado"];
				$id_seccion     = $_POST["id_seccion_asignado"];
				$id_ano_escolar = $_POST["id_ano_escolar_asignado"];

				$contArreglo = count($id_estudiante);
				
				for($i=0; $i<$contArreglo; $i++){

					$resul_existe  = $modelo -> consultarEstatusActivo($id_estudiante[$i], $id_seccion[$i], $id_ano_escolar[$i]);
					
					if(!$resul_existe){
						$resul_estatus = $modelo -> consultarEstatusInactivo($id_estudiante[$i], $id_seccion[$i], $id_ano_escolar[$i]);
						
						if($resul_estatus){
							$resulM = $modelo -> activarEstatus($id_estudiante[$i], $id_seccion[$i], $id_ano_escolar[$i]);

							if(!$resulM){						
								$resulM = false;
							}
						}
						else{
							$resulM = $modelo -> incluir('A', $id_estudiante[$i], $id_seccion[$i], $id_ano_escolar[$i]);

							if(!$resulM){						
								$resulM = false;
							}
						}
					}
				}

				$resul_elimi = $modelo -> consultarModificar("", $id_seccion[0], $id_ano_escolar[0]);

				if($resul_elimi){
					while($file = mysql_fetch_array($resul_elimi)){
						$comparacion = false;

						for($i=0; $i<$contArreglo; $i++){
							if($file["id_estudiante"] == $id_estudiante[$i]){
								$comparacion = true;
							}
						}

						if(!$comparacion){
							$resulE = $modelo -> eliminar($file["id_estudiante"], $id_seccion[0], $id_ano_escolar[0]);
						}
					}
				}

				if($resulM && $resulE){
					$_SESSION["mensaje"] = "Assignment Updated Successfully";

					$tabla_bitacora = "student_section";
					$operacion_bitacora = "UPDATE";
					$detalle_bitacora = " ";

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
				}
				else{
					$_SESSION["mensaje"] = "Error updating, consult your Data Base Provider";
				}
			}
			else{
				$_SESSION["mensaje"] = "Please Assign Students";
			}

			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_estudiante.php'/>";
		}

		else if(isset($_POST["eliminar"])){
			$cont = antiInjectionSql($_POST["cont"]);

			$resulE = false;

			if($cont != 0){
				$id_estudiante      = $_POST["id_estudiante_asignado"];
				$id_seccion     = $_POST["id_seccion_asignado"];
				$id_ano_escolar = $_POST["id_ano_escolar_asignado"];

				$contArreglo = count($id_estudiante);

				for($i=0; $i<$contArreglo; $i++){

					$resulE = $modelo -> eliminar($id_estudiante[$i], $id_seccion[$i], $id_ano_escolar[$i]);
				}

				if($resulE){
					$_SESSION["mensaje"] = "Assignment Deleted Successfully";

					$tabla_bitacora = "student_section";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = " ";

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
				}
				else{
					$_SESSION["mensaje"] = "Error deleting, consult your Data Base Provider";
				}
			}
			else{
				$_SESSION["mensaje"] = "Please Assign Students";
			}

			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_estudiante.php'/>";
		}

		else if(isset($_POST["consultaAvanzada"])){
			$arreglo = json_decode(stripslashes( $_POST["consultaAvanzada"] ));

			$id_ano_escolar = $arreglo->id_ano_escolar;

			$resul = $modelo -> realizarConsultaAvanzada($id_ano_escolar);

			$contador = 0;

			$asignacion["contador"] = array();

			if($resul){
				$contador = mysql_num_rows($resul);

				$asignacion["id_grado"]            = array();
				$asignacion["nivel"]               = array();
				$asignacion["id_seccion"]          = array();
				$asignacion["grupo"]               = array();
				$asignacion["id_ano_escolar"]      = array();
				$asignacion["cantidad_estudiante"] = array();
				$asignacion["contador"]            = $contador;

				$i = 0;

				while($fila = mysql_fetch_array($resul)){
					$asignacion["id_grado"][$i]            = $fila["id_grado"];
					$asignacion["nivel"][$i]               = $fila["nivel"];
					$asignacion["id_seccion"][$i]          = $fila["id_seccion"];
					$asignacion["grupo"][$i]               = $fila["grupo"];
					$asignacion["id_ano_escolar"][$i]      = $fila["id_ano_escolar"];
					$asignacion["cantidad_estudiante"][$i] = $fila["cantidad_estudiante"];

					$i++;
				}
			}

			echo json_encode($asignacion);
		}

		else if(isset($_POST["consultaDinamica"])){
			$arreglo = json_decode(stripslashes($_POST["consultaDinamica"]));

			$nombre         = $arreglo->consultar;
			$id_ano_escolar = $arreglo->ano_escolar;

			$resul = $modeloEstudiante -> consultarAvanzada(NULL, $nombre, NULL);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					$id_estudiante     = $fila["id_estudiante"];

					$consulta = $modelo -> consultarEstudianteInscrito($id_estudiante, $id_ano_escolar);

					if(!$consulta){
						$cadena[] = $fila;
					}
				}

				$cad = json_encode($cadena);
				echo $cad;
			}
			else{
				$cad = json_encode(NULL);
				echo $cad;
			}
		}

		else if(isset($_POST["consultarModificar"])){
			

			$arreglo = json_decode(stripslashes($_POST["consultarModificar"]));

			$nombre         = $arreglo->consultar;
			$id_seccion     = $arreglo->seccion;
			$id_ano_escolar = $arreglo->ano_escolar;

			$resul = $modelo -> consultarModificar($nombre, $id_seccion, $id_ano_escolar);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					$cadena[] = $fila;
				}

				$cad = json_encode($cadena);
				echo $cad;
			}
			else{
				$cad = json_encode(NULL);
				echo $cad;
			}
		}

		else if(isset($_POST["consultarSiguienteGrado"])){
			$id_grado = antiInjectionSql($_POST["consultarSiguienteGrado"]);

			$resul = $modelo -> consultarNivelNumero($id_grado);

			if($resul){
				$fila = mysql_fetch_array($resul);

				$nivel_numero = $fila["nivel_numero"] + 1;

				$resul = $modelo -> consultarSiguienteGrado($nivel_numero);

				if($resul){
					$fila = mysql_fetch_array($resul);

					$cadena["grado"] = array(
											$fila["id_grado"],
											$fila["nivel"]
										);

					echo json_encode($cadena);
				}
				else{
					echo NULL;
				}
			}
			else{
				echo NULL;
			}
		}

		else if(isset($_POST["consultarAnoEscolarA"])){
			$resul = $modeloAnoEscolar -> consultarActivo();

			if($resul){
				$fila = mysql_fetch_array($resul);

				echo json_encode($fila);
			}
			else{
				echo json_encode(NULL);
			}
		}

		else if(isset($_POST["cancelar"])){
			$_SESSION["accion"] = "";
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_estudiante.php' />";
		}

		else{
			$_SESSION["accion"] = "";
			$_SESSION["mensaje"] = "Invalid Option";
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_estudiante.php' />";
		}
	}
?>
