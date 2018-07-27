<?php
	session_start();

	//Incluimos al ModeloGestionarAgrupacion.php
	include("../modelo/conexion_bd.php");
	include("../modelo/agrupacion.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos la clase
		$modelo = new ModeloAgrupacion;
		$modeloBitacora = new ModeloBitacora;

		//Verificapos si la opcion que se pulso fue la de incluir
		if(isset($_POST["incluir"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_agrupacion = mb_strtoupper($_POST["incluir"], "utf-8");

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($nombre_agrupacion);

			if(!$numFila){
				$resul = $modelo -> incluir($nombre_agrupacion);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){
					$tabla_bitacora = "grouping";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $nombre_agrupacion;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Grouping registered successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error saving the grouping, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A grouping already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de modificar
		else if(isset($_POST["modificar"])){

			$arreglo 	= json_decode(stripslashes($_POST["modificar"]));

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_agrupacion = mb_strtoupper($arreglo->nombre_agrupacionA, "utf-8");
			$id_agrupacion = $arreglo->id_agrupacionA;
			
			$mensaje = array();

			$nombre = $modelo -> consultarParaModificar($id_agrupacion);

			//Si se verifica que realizo cambios
			if($nombre != $nombre_agrupacion){
				//$numFila = $modelo -> consultarSiExiste($nombre_tema);

				//if(!$numFila){
					//Enviamos a modificar 
					$resul = $modelo -> modificar($id_agrupacion, $nombre_agrupacion);

					//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
					if($resul){

						$tabla_bitacora = "grouping";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_agrupacion.", ".$nombre_agrupacion;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'Grouping modified successfully';

						$msj = json_encode($mensaje);
						echo $msj;
					}

					else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating grouping, consult your Data Base Administrator';

						$msj = json_encode($mensaje);
						echo $msj;
					}
				
			}
			else{
				$mensaje["resultado"] = 'NO CHANGE';
				$mensaje["msj"] = 'Sorry, you didn´t realized any change';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de eliminar
		else if(isset($_POST["eliminar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_agrupacion     = antiInjectionSql($_POST["eliminar"]);

			$numFila = $modelo -> consultarUso($id_agrupacion);

			if(!$numFila){
				$resul = $modelo -> eliminar($id_agrupacion);

				if($resul){
					$tabla_bitacora = "grouping";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_agrupacion;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Grouping deleted successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}
				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error deleting the grouping, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'BEING USED';
				$mensaje["msj"] = 'Sorry, you can´t delete this grouping because it´s being used';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de consultar
		else if(isset($_GET["consultaAvanzada"])){
			$nombre_agrupacion = mb_strtoupper(antiInjectionSql($_GET["consultaAvanzada"]), "utf-8");

			$resul = $modelo -> realizarConsultaAvanzada($nombre_agrupacion);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					echo "<tr>
						<td class='seleccion' width='250px' id='".$fila["id_agrupacion"]."' title='Double Click on the grouping that you want modify' ondblclick='seleccion(this, \"id_agrupacion\", \"nombre_agrupacion\")'>".$fila["nombre_agrupacion"]."</td>
				      </tr>";
				}
			}
		}

		else if(isset($_POST["consultar"])){
			$arreglo = json_decode(stripslashes($_POST["consultar"]));

			if($arreglo->id_agrupacionA != ''){
				$id_agrupacion = $arreglo->id_agrupacionA;
			}else{
				$id_agrupacion = NULL;
			}

			$nombre_agrupacion = $arreglo->nombre_agrupacionA;

			$mensaje = array();

			$resul = $modelo -> verificarAgrupacion($id_agrupacion, $nombre_agrupacion);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = ' ';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '(!) A grouping already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

		if(isset($_POST["incluirNuevoAgrupacion"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_agrupacion = mb_strtoupper($_POST["incluirNuevoAgrupacion"], "utf-8");

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($nombre_agrupacion);

			if(!$numFila){
				$resul = $modelo -> incluir($nombre_agrupacion);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){
					$tabla_bitacora = "grouping";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $nombre_agrupacion;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$resul = $modelo -> consultarNuevoAgrupacion($nombre_agrupacion);

					$fila = mysql_fetch_array($resul);

					$mensaje["id_agrupacion"] = $fila["id_agrupacion"];
					$mensaje["nombre_agrupacion"] = $fila["nombre_agrupacion"];

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Grouping registered successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error saving grouping, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A grouping already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}
	}
?>
