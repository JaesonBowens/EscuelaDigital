<?php
	session_start();

	include("../modelo/docente.php");
	include("../modelo/docente_seccion.php");
	include("../modelo/seccion.php");
	include("../modelo/ano_escolar.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("ControladorSalir.php");

		if($tiempo_sesion){

		$modelo = new ModeloDocenteSeccion;
		$modeloDocente = new ModeloDocente;
		$modeloSeccion = new ModeloSeccion;
		$modeloAnoEscolar = new ModeloAnoEscolar;
		$modeloBitacora = new ModeloBitacora;

		if(isset($_POST["incluir"])){
			$cont = $_POST["cont"];

			if($cont != 0){
				$id_docente     = $_POST["id_docente_asignado"];
				$id_seccion     = $_POST["id_seccion_asignado"];
				$id_ano_escolar = $_POST["id_ano_escolar_asignado"];

				$contArreglo = count($id_docente);

				for($i=0; $i<$contArreglo; $i++){

					$modelo -> incluir($id_docente[$i], $id_seccion[$i], $id_ano_escolar[$i]);
				}

				$_SESSION["mensaje"] = "Registered Successfully";

				$tabla_bitacora = "teacher_section";
				$operacion_bitacora = "INCLUDE";
				$detalle_bitacora = " ";

				date_default_timezone_set('America/Caracas');

				$fecha_bitacora = date("Y-m-d"); 
				$hora_bitacora = date("H:i:s");
				$id_usuario = $_SESSION["ses_id_usuario"];

				$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

				echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_docente.php'/>";
			}
			else{
				$_SESSION["mensaje"] = "Please assign teachers!";
				echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_docente.php'/>";
			}
		}

		else if(isset($_POST["modificar"])){
			$cont = antiInjectionSql($_POST["cont"]);

			if($cont != 0){
				$id_docente     = $_POST["id_docente_asignado"];
				$id_seccion     = $_POST["id_seccion_asignado"];
				$id_ano_escolar = $_POST["id_ano_escolar_asignado"];
				
				$contArreglo = count($id_docente);

				for($i=0; $i<$contArreglo; $i++){
					$resulM = $modelo -> consultarAvanzada($id_ano_escolar[0]);
					$comparacionM = true;

					while($filaM = mysql_fetch_array($resulM)){
						if($filaM["id_docente"] == $id_docente[$i]){
							if($filaM["id_seccion"] != $id_seccion[$i]){
								$modelo -> modificar($id_docente[$i], $id_seccion[$i], $id_ano_escolar[$i]);
							}
							
							$comparacionM = false;
						}
					}

					if($comparacionM){
						$modelo -> incluir($id_docente[$i], $id_seccion[$i], $id_ano_escolar[$i]);
					}
				}

				$resulE = $modelo -> consultarAvanzada($id_ano_escolar[0]);

				while($filaE = mysql_fetch_array($resulE)){
					$comparacionE = true;

					for($i=0; $i<$contArreglo; $i++){
						if($filaE["id_docente"] == $id_docente[$i]){
							$comparacionE = false;
						}
					}

					if($comparacionE){
						$modelo -> eliminar($filaE["id_docente"], $id_ano_escolar[0]);
					}
				}

				$_SESSION["mensaje"] = "Updated Successfully";

				$tabla_bitacora = "teacher_section";
				$operacion_bitacora = "UPDATE";
				$detalle_bitacora = " ";

				date_default_timezone_set('America/Caracas');

				$fecha_bitacora = date("Y-m-d"); 
				$hora_bitacora = date("H:i:s");
				$id_usuario = $_SESSION["ses_id_usuario"];

				$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
			}
			else{
				$_SESSION["mensaje"] = "Please assign teachers";
			}

			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_docente.php'/>";
		}

		else if(isset($_POST["eliminar"])){
			$cont = antiInjectionSql($_POST["cont"]);

			if($cont != 0){
				$id_docente     = $_POST["id_docente_asignado"];
				$id_seccion     = $_POST["id_seccion_asignado"];
				$id_ano_escolar = $_POST["id_ano_escolar_asignado"];
				
				$contArreglo = count($id_docente);

				for($i=0; $i<$contArreglo; $i++){
					$modelo -> eliminar($id_docente[$i], $id_ano_escolar[$i]);
				}

				$_SESSION["mensaje"] = "Deleted Successfully";

				$tabla_bitacora = "teacher_section";
				$operacion_bitacora = "DELETE";
				$detalle_bitacora = " ";

				date_default_timezone_set('America/Caracas');

				$fecha_bitacora = date("Y-m-d"); 
				$hora_bitacora = date("H:i:s");
				$id_usuario = $_SESSION["ses_id_usuario"];

				$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
			}
			else{
				$_SESSION["mensaje"] = "Please assign teachers";
			}

			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_docente.php'/>";
		}

		else if(isset($_POST["consultaAvanzada"])){
			$arreglo = json_decode(stripslashes( $_POST["consultaAvanzada"] ));

			$id_ano_escolar = $arreglo->id_ano_escolar;

			$resul = $modelo -> realizarConsultaAvanzada($id_ano_escolar);

			$contador = 0;

			$asignacion["contador"] = array();

			if($resul){
				$contador = mysql_num_rows($resul);

				$asignacion["id_docente"] = array();
				$asignacion["cedula"]     = array();
				$asignacion["nombre"]     = array();
				$asignacion["apellido"]   = array();
				$asignacion["nivel"]      = array();
				$asignacion["id_seccion"] = array();
				$asignacion["grupo"]      = array();
				$asignacion["contador"]   = $contador;

				$i = 0;

				while($fila = mysql_fetch_array($resul)){
					$asignacion["id_docente"][$i] = $fila["id_docente"];
					$asignacion["cedula"][$i]     = $fila["cedula"];
					$asignacion["nombre"][$i]     = $fila["nombre"];
					$asignacion["apellido"][$i]   = $fila["apellido"];
					$asignacion["nivel"][$i]      = $fila["nivel"];
					$asignacion["id_seccion"][$i] = $fila["id_seccion"];
					$asignacion["grupo"][$i]      = $fila["grupo"];

					$i++;
				}
			}

			echo json_encode($asignacion);
		}

		else if(isset($_POST["consultaDinamica"])){
			$arreglo = json_decode(stripslashes($_POST["consultaDinamica"]));

			$nombre         = $arreglo->consultar;
			$id_ano_escolar = $arreglo->ano_escolar;

			$resul = $modeloDocente -> consultarDinamica($nombre);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					$id_docente     = $fila["id_docente"];

					$consulta = $modelo -> consultarDocente($id_docente, $id_ano_escolar);

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
			$id_ano_escolar = $arreglo->ano_escolar;

			$resul = $modelo -> consultarModificar($nombre, $id_ano_escolar);

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

		else if(isset($_POST["consultarSeccion"])){
			$arreglo = json_decode(stripslashes($_POST["consultarSeccion"]));

			$id_grado       = $arreglo->consultar;
			$seccion        = $arreglo->seccion;
			$id_ano_escolar = $arreglo->ano_escolar;

			$resul = $modeloSeccion -> consultarSeccionAsignada($id_grado);

			if($resul){
				echo "<option value=''>SELECT</option>";

				while($fila = mysql_fetch_array($resul)){
					$comparacion1 = false;
					$comparacion2 = false;
				
					if(count($seccion) != 0){
						for($i = 0; $i < count($seccion); $i++){
							if($fila['id_seccion'] == $seccion[$i]){
								$comparacion1 = true;
							}
						}
					}

					$resul_comparar = $modelo -> realizarConsultaAvanzada($id_ano_escolar);

					while($fila_comp = mysql_fetch_array($resul_comparar)){
						if($fila['id_seccion'] == $fila_comp['id_seccion']){
							$comparacion2 = true;
						}
					}
					
					if(!$comparacion1 && !$comparacion2){
						echo "<option value='".$fila['id_seccion']."'>".$fila['grupo']."</option>";
					}
				}
			}
			else{
				echo "<option value=''>SELECT</option>";
			}
		}

		else if(isset($_POST["consultarSeccionModificar"])){
			$arreglo = json_decode(stripslashes($_POST["consultarSeccionModificar"]));

			$id_grado       = $arreglo->consultar;
			$seccion        = $arreglo->seccion;
			$id_ano_escolar = $arreglo->ano_escolar;

			$resul = $modeloSeccion -> consultarSeccionAsignada($id_grado);

			//$resul_comparar = $modelo -> consultarAvanzada($id_ano_escolar);

			if($resul){
				echo "<option value=''>SELECT</option>";

				while($fila = mysql_fetch_array($resul)){
					$comparacion1 = false;
					$comparacion2 = false;
				
					if(count($seccion) != 0){
						for($i = 0; $i < count($seccion); $i++){
							if($fila['id_seccion'] == $seccion[$i]){
								$comparacion1 = true;
							}
						}
					}

					if(!$comparacion1){
						echo "<option value='".$fila['id_seccion']."'>".$fila['grupo']."</option>";
					}
				}
			}
			else{
				echo "<option value=''>SELECT</option>";
			}
		}

		else if(isset($_POST["consultarIdAnoActivo"])){
			$id_ano_escolar = antiInjectionSql($_POST["consultarIdAnoActivo"]);

			$resul = $modeloAnoEscolar -> consultarPorId($id_ano_escolar);

			$array = array();

			if($resul){
				$fila = mysql_fetch_array($resul);

				$array["estatus"] = $fila["estatus"] ;
			}

			echo json_encode($array);
		}

		else if(isset($_POST["cancelar"])){
			$_SESSION["accion"] = "";
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_docente.php' />";
		}

		else{
			$_SESSION["accion"] = "";
			$_SESSION["mensaje"] = "Invalid Option";
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_asignacion_docente.php' />";
		}
	}
?>
