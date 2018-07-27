<?php
	session_start();

	include("../modelo/estudiante.php");
	include("../modelo/telefono.php");
	include("../modelo/telefono_estudiante.php");
	include("../modelo/telefono_docente.php");
	include("../modelo/estudiante_seccion.php");
	include("../modelo/ano_escolar.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		$modelo         = new ModeloEstudiante;
		$modeloTelefono = new ModeloTelefono;
		$modeloTelefonoEstudiante = new ModeloTelefonoEstudiante;
		$modeloTelefonoDocente = new ModeloTelefonoDocente;
		$modeloEstudianteSeccion = new ModeloEstudianteSeccion;
		$modeloAnoEscolar = new ModeloAnoEscolar;
		$modeloBitacora = new ModeloBitacora;

		if(isset($_POST["incluir"])){
			$arreglo 	= json_decode(stripslashes($_POST["incluir"]));
			
			$nombre          = mb_strtoupper($arreglo->nombreEst, "utf-8");
			$apellido        = mb_strtoupper($arreglo->apellidoEst, "utf-8");
			$fecha_nac       = $arreglo->fecha_nacEst;
			$sexo            = $arreglo->sexoEst;
			$id_codigo_tele  = $arreglo->id_codigo_teleEst;
			$numero          = $arreglo->numeroEst;
			$id_discapacidad = $arreglo->id_discapacidadEst;
			$estatus         = "A";

			$mensaje = array();

			//list($ano, $mes, $dia) = explode("-", $fecha);

			//$fecha_nac = $ano."-".$mes."-".$dia;

			$id_telefono = "";

			if($numero != "" && $id_codigo_tele != ""){

				$resulTelefono = $modeloTelefono -> consultar($numero, $id_codigo_tele);

				if(!$resulTelefono){

					$id_telefono = $modeloTelefono -> incluir($numero, $id_codigo_tele);

				}else{
					$id_telefono = $resulTelefono;
				}
			}

			$resulEstudiante = $modelo -> incluir($nombre, $apellido, $fecha_nac, $sexo, $estatus, $id_discapacidad);

			$id_estudiante = $resulEstudiante;		

			if($resulEstudiante){

					if($id_telefono != ""){
						$resulTelefonoEstudiante = $modeloTelefonoEstudiante -> incluir($id_estudiante, $id_telefono);
					}

					$tabla_bitacora = "student";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $id_estudiante.", ".$nombre.", ".$apellido;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);	

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Registered Successfully';

					$msj = json_encode($mensaje);
					echo $msj;
			}else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error registering student´s data, consult your Data Base Provider';

					$msj = json_encode($mensaje);
					echo $msj;
			}

		}

		else if(isset($_POST["modificar"])){

			$arreglo 	= json_decode(stripslashes($_POST["modificar"]));

			$id_estudiante   = $arreglo->id_estudianteEst;
			$nombre          = mb_strtoupper($arreglo->nombreEst, "utf-8");
			$apellido        = mb_strtoupper($arreglo->apellidoEst, "utf-8");
			$fecha_nac       = $arreglo->fecha_nacEst;
			$sexo            = $arreglo->sexoEst;
			$id_codigo_tele  = $arreglo->id_codigo_teleEst;
			$numero          = $arreglo->numeroEst;
			$id_discapacidad = $arreglo->id_discapacidadEst;
			$estatus         = "A";

			$mensaje = array();

			//list($ano, $mes, $dia) = explode("-", $fecha);

			//$fecha_nac = $ano."-".$mes."-".$dia;

			$id_telefono = "";

			$telefono_modificado = false;

			if($numero != "" && $id_codigo_tele != ""){

							$resulTelefono = $modeloTelefono -> consultar($numero, $id_codigo_tele);

							if(!$resulTelefono){

								$id_telefono = $modeloTelefono -> incluir($numero, $id_codigo_tele);

							}else{

								$id_telefono = $resulTelefono;
							
                     }
			}else{
						$resulTE = $modeloTelefonoEstudiante->consultarPorIdEstudiante($id_estudiante);

						if($resulTE){
									$modeloTelefonoEstudiante->eliminarPorIdEstudiante($id_estudiante);

									$filaTE = mysql_fetch_array($resulTE);
										
									$id_eliminar = $filaTE["id_telefono"];

									$resulTeleEst = $modeloTelefonoEstudiante->consultarPorIdTelefono($id_telefono);

									$resulTeleDoc = $modeloTelefonoDocente->consultarPorIdTelefono($id_telefono);

									if($resulTeleEst == false && $resulTeleDoc == false){
											$modeloTelefono->eliminar($id_eliminar);
									}

									$telefono_modificado = true;
			
						}
			}

						if($id_telefono != ""){

							$resulTE = $modeloTelefonoEstudiante->consultarPorIdEstudiante($id_estudiante);

							if(!$resulTE){
									$modeloTelefonoEstudiante -> incluir($id_estudiante, $id_telefono);	

									$telefono_modificado = true;
							}else{
									$filaTE = mysql_fetch_array($resulTE);

									if($numero != $filaTE["numero"] || $id_codigo_tele != $filaTE["id_codigo_tele"]){
									    
											    $modeloTelefonoEstudiante -> modificar($id_estudiante, $id_telefono);
									   
								  }

									$telefono_modificado = true;
							}

					}

			$resul = $modelo -> consultarPorId($id_estudiante);

			if($resul){
					$fila = mysql_fetch_array($resul);

					if($nombre != $fila["nombre"] || $apellido != ["apellido"] || $fecha_nac != $fila["fecha_nac"] || $sexo != $fila["sexo"] || $id_discapacidad != $fila["id_discapacidad"] || $numero != $fila["numero"] || $telefono_modificado != false ){


						$resulEstudiante = $modelo -> modificar($id_estudiante, $nombre, $apellido, $fecha_nac, $sexo, $id_discapacidad, $id_sector);

						if($resulEstudiante){

								$tabla_bitacora = "student";
								$operacion_bitacora = "UPDATED";
								$detalle_bitacora = $id_estudiante.", ".$nombre.", ".$apellido;

								date_default_timezone_set('America/Caracas');

								$fecha_bitacora = date("Y-m-d"); 
								$hora_bitacora = date("H:i:s");
								$id_usuario = $_SESSION["ses_id_usuario"];

								$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);	
						}

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'Updated Succesfully';

						$msj = json_encode($mensaje);
						echo $msj;

				}else{
						$mensaje["resultado"] = 'NO CHANGES';
						$mensaje["msj"] = 'Sorry, You didn´t realized any changes';
						$msj = json_encode($mensaje);
						echo $msj;
				}
			}else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating student´s record, consult your Data Base Administrator';
						$msj = json_encode($mensaje);
						echo $msj;
			}
		}

		else if(isset($_POST["eliminar"])){

			$id_estudiante = antiInjectionSql($_POST["eliminar"]);

			$mensaje = array();

			$resul = $modelo -> consultarAsignacion($id_estudiante);

			if(!$resul){
					$resulDesactivado = $modelo -> desactivarRegistroEstudiantil($id_estudiante);
					
					if($resulDesactivado){

						$tabla_bitacora = "estudiante";
						$operacion_bitacora = "ELIMINAR";
						$detalle_bitacora = $id_estudiante;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'You have desactivated the student´s record successfully';
						$msj = json_encode($mensaje);
						echo $msj;
					}else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error desactivating student´s record, consult your Data Base Administrator';
						$msj = json_encode($mensaje);
						echo $msj;
					}
			}else{

				$mensaje["resultado"] = 'UNSUCCESSFUL';
				$mensaje["msj"] = 'Sorry, the student is assigned to a section, you delete the assignment in order to delete the student´s record';
				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

		/*else if(isset($_POST["consultar"])){
			$arreglo = json_decode(stripslashes($_POST["consultar"]));

			$nombre   = mb_strtoupper($arreglo->nombre, "utf-8");
			$apellido = mb_strtoupper($arreglo->apellido, "utf-8");

			$resul = $modelo -> consultarPorNombreyApellido($nombre, $apellido);

			$estudiante = array();

			if($resul){
				$fila = mysql_fetch_array($resul);

				$estudiante["id_estudiante"] = $fila["id_estudiante"];
				$id_estudiante = $fila["id_estudiante"];
				$estudiante["nombre"] = $fila["nombre"];
				$estudiante["apellido"] = $fila["apellido"];

				list($ano, $mes, $dia) = explode("-", $fila["fecha_nac"]);
				$fecha_nac = $dia."/".$mes."/".$ano;

				list($diaHoy, $mesHoy, $anoHoy) = explode("-", date("d-m-Y"));

				$edad = $anoHoy - $ano;
				
				$estudiante["fecha_nac"] = $fecha_nac;
				$estudiante["edad"] = $edad;
				$estudiante["sexo"] = $fila["sexo"];
				$estudiante["id_discapacidad"] = $fila["id_discapacidad"];

				if($fila["estatus"] == "A"){
					$estudiante["estatus"] = "ACTIVE";
				}
				else{
					$estudiante["estatus"] = "NOT ACTIVE";	
				}

				$resulTE = $modeloTelefonoEstudiante->consultarPorIdEstudiante($id_estudiante);

				if($resulTE){
					$filaTE = mysql_fetch_array($resulTE);

					$estudiante["id_telefono"]     = $filaTE["id_telefono"];
					$estudiante["id_codigo_tele"]  = $filaTE["id_codigo_tele"];
					$estudiante["numero"]          = $filaTE["numero"];
				}else{
					$estudiante["id_telefono"]     = "";
					$estudiante["id_codigo_tele"]  = "";
					$estudiante["numero"]          = "";
				}

				$resulAE = $modeloAnoEscolar->consultarActivo();

				if($resulAE){
						$filaAE = mysql_fetch_array($resulAE);
						$id_ano_escolar = $filaAE["id_ano_escolar"];
						$resulEstSec = $modeloEstudianteSeccion->consultarEstudianteInscrito($id_estudiante, $id_ano_escolar);

						if($resulEstSec){
								$filaEstSec = mysql_fetch_array($resulEstSec);

								$estudiante["asignado"] = 'YES';

								$estudiante["id_grado"]	= $filaEstSec["id_grado"];
								$estudiante["id_seccion"]	= $filaEstSec["id_seccion"];
						}else{
								$estudiante["asignado"] = 'NO';
						}
				}else{
						$estudiante["asignado"] = 'NO';
				}
			
							
			}
			else{
				$estudiante["nombre"] = $nombre;
				$estudiante["apellido"] = $apellido;
			}

			$est = json_encode($estudiante);
			echo $est;
		}*/
		
		else if(isset($_POST["consultarPorId"])){
			$id_estudiante = antiInjectionSql($_POST["consultarPorId"]);

			$resul = $modelo -> consultarPorId($id_estudiante);

			$estudiante = array();

			if($resul){
				$fila = mysql_fetch_array($resul);

				$estudiante["id_estudiante"] = $fila["id_estudiante"];
				$id_estudiante = $fila["id_estudiante"];
				$estudiante["nombre"] = $fila["nombre"];
				$estudiante["apellido"] = $fila["apellido"];

				list($ano, $mes, $dia) = explode("-", $fila["fecha_nac"]);
				
				//date in mm/dd/yyyy format; or it can be in other formats as well
				$fecha_nac = $dia."/".$mes."/".$ano;
								
				//explode the date to get month, day and year
				$fecha_nac = explode("/", $fecha_nac);
				
				//get age from date or birthdate
				$edad = (date("md", date("U", mktime(0, 0, 0, $fecha_nac[0], $fecha_nac[1], $fecha_nac[2]))) > date("md")
					? ((date("Y") - $fecha_nac[2]) - 1)
					: (date("Y") - $fecha_nac[2]));
				
				$estudiante["fecha_nac"] = $fila["fecha_nac"];
				$estudiante["edad"] = $edad;
				$estudiante["sexo"] = $fila["sexo"];
				$estudiante["id_discapacidad"] = $fila["id_discapacidad"];

				if($fila["estatus"] == "A"){
					$estudiante["estatus"] = "ACTIVE";
				}
				else{
					$estudiante["estatus"] = "NOT ACTIVE";	
				}

				$resulTE = $modeloTelefonoEstudiante->consultarPorIdEstudiante($id_estudiante);

				if($resulTE){
					$filaTE = mysql_fetch_array($resulTE);

					$estudiante["id_telefono"]     = $filaTE["id_telefono"];
					$estudiante["id_codigo_tele"]  = $filaTE["id_codigo_tele"];
					$estudiante["numero"]          = $filaTE["numero"];
				}else{
					$estudiante["id_telefono"]     = "";
					$estudiante["id_codigo_tele"]  = "";
					$estudiante["numero"]          = "";
				}

				$resulAE = $modeloAnoEscolar->consultarActivo();

				if($resulAE){
						$filaAE = mysql_fetch_array($resulAE);
						$id_ano_escolar = $filaAE["id_ano_escolar"];
						$resulEstSec = $modeloEstudianteSeccion->consultarEstudianteInscrito($id_estudiante, $id_ano_escolar);

						if($resulEstSec){
								$filaEstSec = mysql_fetch_array($resulEstSec);

								$estudiante["asignado"] = 'YES';

								$estudiante["id_grado"]	= $filaEstSec["id_grado"];
								$estudiante["id_seccion"]	= $filaEstSec["id_seccion"];
						}else{
								$estudiante["asignado"] = 'NO';
						}
				}else{
						$estudiante["asignado"] = 'NO';
				}
			
							
			}
			

			$est = json_encode($estudiante);
			echo $est;
		}

		else if(isset($_POST["activar"])){

			$id_estudiante = antiInjectionSql($_POST["activar"]);

			$mensaje = array();

			$resul = $modelo -> activarRegistroEstudiantil($id_estudiante);

			if($resul){
					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'You have activated the student´s record successfully';
					$msj = json_encode($mensaje);
					echo $msj;
			}else{	

					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error activating student´s record, consult your Data Base Administrator';
					$msj = json_encode($mensaje);
					echo $msj;
			}
			
		}

		else if(isset($_POST["consultaAvanzada"])){
			$arreglo 	= json_decode(stripslashes($_POST["consultaAvanzada"]));

			$nombre   = mb_strtoupper($arreglo->nombre, "utf-8");
			$apellido = mb_strtoupper($arreglo->apellido, "utf-8");
			$estatus  = $arreglo->estatus;			

			if($nombre == ""){
				$nombre = NULL;
			}

			if($apellido == ""){
				$apellido = NULL;
			}

			$resul = $modelo -> consultaAvanzadaUno($nombre, $apellido, $estatus);

			$contador = 0;

			$estudiante["contador"] = array();

			if($resul){

				$contador = mysql_num_rows($resul);

				$estudiante["id_estudiante"] = array();
				$estudiante["nombre"] = array();
				$estudiante["apellido"] = array();
				$estudiante["sexo"] = array();
				$estudiante["estatus"] = array();
				$estudiante["contador"] = $contador;

				$i = 0;

				while($fila = mysql_fetch_array($resul)){
					$estudiante["id_estudiante"][$i] = $fila["id_estudiante"];
					$estudiante["nombre"][$i] = $fila["nombre"];
					$estudiante["apellido"][$i] = $fila["apellido"];
					$estudiante["sexo"][$i] = $fila["sexo"];
					$estudiante["estatus"][$i] = $fila["estatus"];

					$i++;
				}
			}

			echo json_encode($estudiante);
		}		
	}
?>
