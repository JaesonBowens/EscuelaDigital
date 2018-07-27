<?php
	session_start();

	include("../modelo/conexion_bd.php");

	//incluimos el modelo
	include("../modelo/ano_escolar.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos el modelo
		$modelo = new ModeloAnoEscolar;
		$modeloBitacora = new ModeloBitacora;

		//Si se activa la opcion incluir (activar en vista)
		if(isset($_POST["incluir"])){

			$arreglo = json_decode(stripslashes($_POST["incluir"]));

			$fecha_inicio = $arreglo->fecha_inicioAE;
			$fecha_fin    = $arreglo->fecha_finAE;
			$denominacion = $arreglo->anio_escolarAE;

			$estatus = "A";

			$mensaje = array();

			$resul = $modelo -> consultarActivo();

			$numFila = mysql_num_rows($resul);

			if(!$numFila){
				$resul = $modelo -> incluirAnoEscolar($fecha_inicio, $fecha_fin, $denominacion, $estatus);

				if($resul){

					$tabla_bitacora = "shool_year";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $fecha1.", ".$fecha2.", ".$denominacion;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'School year registered successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}
				else{

					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error saving school year, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'Sorry, there´s already an active school year';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

		//Si se activa modificar
		else if(isset($_POST["modificar"])){

			$arreglo 	= json_decode(stripslashes($_POST["modificar"]));

			$ano_escolar    = $arreglo->anio_escolarAE;
			$id_ano_escolar = $arreglo->id_anio_escolarAE;
			$fecha_inicio   = $arreglo->fecha_inicioAE;
			$fecha_fin      = $arreglo->fecha_finAE;

			$mensaje = array();

			$denominacion = $modelo -> consultarModificar($ano_escolar);
			$resul = $modelo -> consultarPorId($id_ano_escolar);

			if($resul){

			$fila = mysql_fetch_array($resul);
				//Si se verifica que realizo cambios
				if($fecha_inicio != $fila["fecha_inicio"] || $fecha_fin != $fila["fecha_fin"]){
					//Enviamos a modificar 
					$resul = $modelo -> modificarAnoEscolar($id_ano_escolar, $fecha_inicio, $fecha_fin, $ano_escolar);

					//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
					if($resul){

						$tabla_bitacora = "school_year";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_ano_escolar.", ".$fecha_inicio.", ".$fecha_fin.", ".$ano_escolar;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'School year updated successfully';

						$msj = json_encode($mensaje);
						echo $msj;
					}else{

						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating school year, consult your Data Base Administrator';

						$msj = json_encode($mensaje);
						echo $msj;
					}
				}else{
						$mensaje["resultado"] = 'NO CHANGE';
						$mensaje["msj"] = 'Sorry, you didn´t make any changes';

						$msj = json_encode($mensaje);
						echo $msj;
				}
			}else{
				$mensaje["resultado"] = 'DATA BASE ERROR';
				$mensaje["msj"] = 'Error updating the school year, consult your Data Base Administrator';

				$msj = json_encode($mensaje);
				echo $msj;
			}
			
		}

		//Si se activa eliminar
		else if(isset($_POST["eliminar"])) {
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_ano_escolar = antiInjectionSql($_POST["eliminar"]);

			$mensaje = array();

			$numFila = $modelo -> verificarUso($id_ano_escolar);

			if(!$numFila){
				$resul = $modelo -> eliminarAnoEscolar($id_ano_escolar);

				if($resul){

					$tabla_bitacora = "school_year";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_ano_escolar;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'School year deleted successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}
				else{

					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error deleting school year, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{

					$mensaje["resultado"] = 'BEING USED';
					$mensaje["msj"] = 'Sorry, you can´t delete this school year because it´s being used';

					$msj = json_encode($mensaje);
					echo $msj;
			}
		}

		//Si se activa consultar
		else if(isset($_GET["consultaAvanzada"])) {
			$denominacion = antiInjectionSql($_GET["consultaAvanzada"]);

			$resul = $modelo -> consultarAvanzada($denominacion);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					echo "<tr id='".$fila["id_ano_escolar"]."' title='Double Click on the school year that you want to modify' ondblclick='seleccionAnioEscolar(\"".$fila["id_ano_escolar"]."\")'>
					<td width='200px'>".$fila["denominacion"]."</td>
					<td width='200px'>".$fila["fecha_inicio"]."</td>
					<td width='200px'>".$fila["fecha_fin"]."</td>";
					if($fila["estatus"] == "A"){
						echo "<td width='210px'> Active </td>";
					}else{
						echo "<td width='210px'> Not Active </td>";
					}
					echo "</tr>";
				}
			}
		}

		else if(isset($_POST["consultar"])){

			$id_ano_escolar = antiInjectionSql($_POST["consultar"]);

			//Consultamos por el Id que se selecciono
			$resul = $modelo -> consultarPorId($id_ano_escolar);

			$anio_escolar = array();

			if($resul){
				$fila = mysql_fetch_array($resul);

				$anio_escolar["id_ano_escolar"] = $fila["id_ano_escolar"];
				$anio_escolar["fecha_inicio"] = $fila["fecha_inicio"];
				$anio_escolar["fecha_fin"] = $fila["fecha_fin"];
				$anio_escolar["denominacion"] = $fila["denominacion"];
				$anio_escolar["estatus"] = $fila["estatus"];

				$ae = json_encode($anio_escolar);
				echo $ae;

			}

		}
		
	}
?>
