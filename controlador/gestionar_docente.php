<?php
	session_start();

	include("../modelo/docente.php");
	include("../modelo/usuario.php");
	include("../modelo/telefono.php");
	include("../modelo/telefono_docente.php");
	include("../modelo/telefono_estudiante.php");
	include("../modelo/docente_seccion.php");
	include("../modelo/ano_escolar.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		$modelo         = new ModeloDocente;
		$modeloUsuario  = new ModeloUsuario;
		$modeloTelefono = new ModeloTelefono;
		$modeloTelefonoDocente = new ModeloTelefonoDocente;
		$modeloTelefonoEstudiante = new ModeloTelefonoEstudiante;
		$modeloDocenteSeccion = new ModeloDocenteSeccion;
		$modeloAnoEscolar = new ModeloAnoEscolar;
		$modeloBitacora = new ModeloBitacora;

		if(isset($_POST["incluir"])){

			$arreglo 	= json_decode(stripslashes($_POST["incluir"]));

			$cedula          = $arreglo->cedulaD;
			$nombre          = mb_strtoupper($arreglo->nombreD, "utf-8");
			$apellido        = mb_strtoupper($arreglo->apellidoD, "utf-8");
			
			$id_codigo_tele  = $arreglo->id_codigo_teleD;
			$numero          = $arreglo->numeroD;
			$nombre_usuario  = $arreglo->nombre_usuarioD;
			$clave_usuario   = $arreglo->clave_usuarioD;
			$id_tipo_usuario = $arreglo->id_tipo_usuarioD;
			$estatus         = "A";

			$mensaje = array();

			$id_telefono = "";

			if($numero != "" && $id_codigo_tele != ""){

				$resulTelefono = $modeloTelefono -> consultar($numero, $id_codigo_tele);

				if(!$resulTelefono){

					$id_telefono = $modeloTelefono -> incluir($numero, $id_codigo_tele);

				}else{
					$id_telefono = $resulTelefono;
				}
			}

			$id_usuario  = $modeloUsuario -> incluir($nombre_usuario, $clave_usuario, $id_tipo_usuario);

			$resulDocente = $modelo -> incluir($cedula, $nombre, $apellido, $estatus, $id_usuario);

			$id_docente = $resulDocente;

			if($resulDocente){

					if($id_telefono != ""){

						$resulTelefonoDocente = $modeloTelefonoDocente -> incluir($id_docente, $id_telefono);

					}

					$tabla_bitacora = "teacher";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $id_docente.", ".$cedula.", ".$nombre.", ".$apellido;

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
					$mensaje["msj"] = 'Error registering teacher, consult your Data Base Provider';

					$msj = json_encode($mensaje);
					echo $msj;
			}
		}

		else if(isset($_POST["modificar"])){

			$arreglo 	= json_decode(stripslashes($_POST["modificar"]));

			$id_docente      = $arreglo->id_docenteD;
			$cedula          = $arreglo->cedulaD;
			$nombre          = mb_strtoupper($arreglo->nombreD, "utf-8");
			$apellido        = mb_strtoupper($arreglo->apellidoD, "utf-8");
			
			$id_codigo_tele  = $arreglo->id_codigo_teleD;
			$numero          = $arreglo->numeroD;
			$id_usuario      = $arreglo->id_usuarioD;
			$nombre_usuario  = $arreglo->nombre_usuarioD;
			$clave_usuario   = $arreglo->clave_usuarioD;
			$id_tipo_usuario = $arreglo->id_tipo_usuarioD;
			$estatus         = "A";

			$mensaje = array();

			$id_telefono = "";

			$telefono_modificado = false;

      if($numero != "" && $id_codigo_tele != "" ){

						$resulTelefono = $modeloTelefono -> consultar($numero, $id_codigo_tele);

						if(!$resulTelefono){

							$id_telefono = $modeloTelefono -> incluir($numero, $id_codigo_tele);

						}else{
							$id_telefono = $resulTelefono;
						}
			}else{
						$resulTD = $modeloTelefonoDocente->consultarPorIdDocente($id_docente);

						if($resulTD){
									$modeloTelefonoDocente->eliminarPorIdDocente($id_docente);

									$filaTD = mysql_fetch_array($resulTD);

									$id_eliminar = $filaTD['id_telefono'];

									$resulTeleEst = $modeloTelefonoEstudiante->consultarPorIdTelefono($id_telefono);

									$resulTeleDoc = $modeloTelefonoDocente->consultarPorIdTelefono($id_telefono);

									if($resulTeleEst == false && $resulTeleDoc == false){
											$modeloTelefono->eliminar($id_eliminar);
									}

									$telefono_modificado = true;
			
						}
			}

			if($id_telefono != ""){

							$resulTD = $modeloTelefonoDocente->consultarPorIdDocente($id_docente);

							if(!$resulTD){
									$modeloTelefonoDocente -> incluir($id_docente, $id_telefono);
									$telefono_modificado = true;	
							}else{
									$filaTD = mysql_fetch_array($resulTD);

									if($numero != $filaTD["numero"] || $id_codigo_tele != $filaTD["id_codigo_tele"]){
									   
											    $modeloTelefonoDocente -> modificar($id_docente, $id_telefono);
									    
								  }

									$telefono_modificado = true;
							}

					}

			$resul = $modelo -> consultarPorId($id_docente);

			if($resul){
				$fila = mysql_fetch_array($resul);

				if($cedula != $fila["cedula"] || $nombre != $fila["nombre"] || $apellido != ["apellido"] || $nombre_usuario != $fila["nombre_usuario"] || $clave_usuario != $fila["clave_usuario"] || $id_tipo_usuario != $fila["tipo_usuario"] || $telefono_modificado != false){

					if($nombre_usuario != $fila["nombre_usuario"] || $clave_usuario != $fila["clave_usuario"] || $id_tipo_usuario != $fila["id_tipo_usuario"]){
						$id_usuario  = $modeloUsuario -> modificarD($id_usuario, $nombre_usuario, $clave_usuario, $id_tipo_usuario);
					}

					$resulDocente = $modelo -> modificar($id_docente, $cedula, $nombre, $apellido, $estatus, $id_usuario);

					if($resulDocente){

						$tabla_bitacora = "teacher";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_docente.", ".$cedula.", ".$nombre.", ".$apellido;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					}

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Teacher´s Data Updated Successfully';

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
				$mensaje["msj"] = 'Error updating teacher´s data, consult your Data Base Provider';

				$msj = json_encode($mensaje);
				echo $msj;
			}
			
		}

		else if(isset($_POST["eliminar"])){

			$id_docente = antiInjectionSql($_POST["eliminar"]);

			$mensaje = array();

			$resul = $modelo -> verificarAsignacion($id_docente);

			if(!$resul){

				$resulEliminado = $modelo -> eliminar($id_docente);
	
				if($resulEliminado){

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Teacher Deleted Successfully';
					$msj = json_encode($mensaje);
					echo $msj;

				}else{

					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error deleting teacher´s data, consult your Data Base Provider';
					$msj = json_encode($mensaje);
					echo $msj;

				}

			}else{
				
					$mensaje["resultado"] = 'NOT SUCCESSFUL';
					$mensaje["msj"] = 'Sorry, the teacher is assigned to a section, you delete the assignment in order to delete the teacher´s record';
					$msj = json_encode($mensaje);
					echo $msj;
			}
			
		}

		else if(isset($_POST["consultar"])){

			$cedula = antiInjectionSql($_POST["consultar"]);

			$resul = $modelo -> consultar($cedula);

			$docente = array();

			if($resul){
				$fila = mysql_fetch_array($resul);

				$docente["id_docente"]      = $fila["id_docente"];
				$id_docente                 = $fila["id_docente"];
				$docente["cedula"]          = $cedula;
				$docente["nombre"]          = $fila["nombre"];
				$docente["apellido"]        = $fila["apellido"];
				$docente["id_usuario"]      = $fila["id_usuario"];
				$docente["nombre_usuario"]  = $fila["nombre_usuario"];
				$docente["clave_usuario"]   = $fila["clave_usuario"];
				$docente["id_tipo_usuario"] = $fila["id_tipo_usuario"];

				if($fila["estatus"] == "A"){
					$docente["estatus"] = "ACTIVE";
				}
				else{
					$docente["estatus"] = "NOT ACTIVE";	
				}

				$resulTD = $modeloTelefonoDocente->consultarPorIdDocente($id_docente);

				if(!$resulTD){
					$docente["id_telefono"]     = "NULL";
					$docente["id_codigo_tele"]  = "";
					$docente["numero"]          = "";
				}else{
					$filaTD = mysql_fetch_array($resulTD);

					$docente["id_telefono"]     = $filaTD["id_telefono"];
					$docente["id_codigo_tele"]  = $filaTD["id_codigo_tele"];
					$docente["numero"]          = $filaTD["numero"];
				}

				$resulAE = $modeloAnoEscolar->consultarActivo();

				if($resulAE){
						$filaAE = mysql_fetch_array($resulAE);
						$id_ano_escolar = $filaAE["id_ano_escolar"];
						$resulDocenteSeccion = $modeloDocenteSeccion->consultarDocenteAsignado($id_docente, $id_ano_escolar);

						if($resulDocenteSeccion){
								$filaDocenteSeccion = mysql_fetch_array($resulDocenteSeccion);

								$docente["asignado"] = 'YES';

								$docente["id_grado"]	= $filaDocenteSeccion["id_grado"];
								$docente["id_seccion"]	= $filaDocenteSeccion["id_seccion"];
						}else{
								$docente["asignado"] = 'NO';
						}
				}else{
						$docente["asignado"] = 'NO';
				}			
			}

			$doc = json_encode($docente);
			echo $doc;
		}

		else if(isset($_POST["activar"])){

			$id_docente = antiInjectionSql($_POST["activar"]);

			$mensaje = array();

			$resul = $modelo -> activarDocente($id_docente);

			if($resul){
				$mensaje["resultado"] = 'SUCCESSFUL';
				$mensaje["msj"] = 'Teacher Activated Successfully';
				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'DATA BASE ERROR';
				$mensaje["msj"] = 'Error activating teacher´s record, consult your Data Base Administrator';
				$msj = json_encode($mensaje);
				echo $msj;	
			}
		}

		else if(isset($_POST["consultaAvanzada"])){
			$arreglo 	= json_decode(stripslashes($_POST["consultaAvanzada"]));

			$cedula   = $arreglo->cedula;
			$nombre   = mb_strtoupper($arreglo->nombre, "utf-8");
			$apellido = mb_strtoupper($arreglo->apellido, "utf-8");
			$estatus  = $arreglo->estatus;			

			if($cedula == ""){
				$cedula = NULL;
			}

			if($nombre == ""){
				$nombre = NULL;
			}

			if($apellido == ""){
				$apellido = NULL;
			}

			$resul = $modelo -> realizarConsultaAvanzada($cedula, $nombre, $apellido, $estatus);

			$contador = 0;

			$docente["contador"] = array();

			if($resul){

				$contador = mysql_num_rows($resul);

				$docente["cedula"]   = array();
				$docente["nombre"]   = array();
				$docente["apellido"] = array();
				$docente["sexo"]     = array();
				$docente["estatus"]  = array();
				$docente["contador"] = $contador;

				$i = 0;

				while($fila = mysql_fetch_array($resul)){

					$docente["cedula"][$i]   = $fila["cedula"];
					$docente["nombre"][$i]   = $fila["nombre"];
					$docente["apellido"][$i] = $fila["apellido"];
					$docente["estatus"][$i]  = $fila["estatus"];

					$i++;
				}
			}

			echo json_encode($docente);
		}

	}
?>
