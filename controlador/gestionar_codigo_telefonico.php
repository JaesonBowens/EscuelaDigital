<?php
	session_start();

	//Incluimos al ModeloGestionarCodigoTelefono.php
	include("../modelo/codigo_telefonico.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos la clase
		$modelo = new ModeloCodigoTelefonico;
		$modeloBitacora = new ModeloBitacora;

		//Verificapos si la opcion que se pulso fue la de incluir
		if(isset($_POST["incluir"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$opcion_codigo = $_POST["incluir"];

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($opcion_codigo);
			
			if(!$numFila){
				$resul = $modelo -> incluir($opcion_codigo);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){

					$tabla_bitacora = "tele_code";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $opcion_codigo;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Telephone code registered successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error registering telephone code, consult Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A telephone code already exist with this number';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de modificar
		else if(isset($_POST["modificar"])){

			$arreglo 	= json_decode(stripslashes($_POST["modificar"]));

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$opcion_codigo    = $arreglo->opcion_codigoCT;
			$id_codigo_tele = $arreglo->id_codigo_teleCT;
			
			$mensaje = array();

			$nombre = $modelo -> consultarParaModificar($id_codigo_tele);

			//Si se verifica que realizo cambios
			if($nombre != $opcion_codigo){
				$numFila = $modelo -> consultarSiExiste($opcion_codigo);

				if(!$numFila){
					//Enviamos a modificar 
					$resul = $modelo -> modificar($id_codigo_tele, $opcion_codigo);

					//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
					if($resul){

						$tabla_bitacora = "tele_code";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_codigo_tele.", ".$opcion_codigo;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'Telephone code updated successfully';

						$msj = json_encode($mensaje);
						echo $msj;
					}

					else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating telephone code, consult your Data Base Administrator';

						$msj = json_encode($mensaje);
						echo $msj;
					}
				}
				else{
					$mensaje["resultado"] = 'ALREADY EXIST';
					$mensaje["msj"] = 'A telephone code already exist with this name';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'NO CHANGE';
				$mensaje["msj"] = 'Sorry, you didn´t realized any changes';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de eliminar
		else if(isset($_POST["eliminar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_codigo_tele = antiInjectionSql($_POST["eliminar"]);

			$numFila = $modelo -> consultarUso($id_codigo_tele);

			$mensaje = array();

			if(!$numFila){
				$resul = $modelo -> eliminar($id_codigo_tele);

				if($resul){

					$tabla_bitacora = "tele_code";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_codigo_tele;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Telephone code deleted successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}
				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error deleting telephone code, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'BEING USED';
				$mensaje["msj"] = 'Sorry, you can´t delete this telephone code because it´s being used';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de consultar
		else if(isset($_GET["consultaAvanzada"])){
			$opcion_codigo = antiInjectionSql($_GET["consultaAvanzada"]);

			$resul = $modelo -> realizarConsultaAvanzada($opcion_codigo);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					echo "<tr>
						<td class='seleccion' width='200px' id='".$fila["id_codigo_tele"]."' title='Double Click on the telephone code if you wish to delete it' ondblclick='seleccion(this, \"id_codigo_tele\", \"opcion_codigo\")'>".$fila["opcion_codigo"]."</td>
					  </tr>";
				}
			}
		}

		else if(isset($_POST["consultar"])){

			$arreglo = json_decode(stripslashes($_POST["consultar"]));

			if($arreglo->id_codigo_teleCT != ''){
				$id_codigo_tele = $arreglo->id_codigo_teleCT;
			}else{
				$id_codigo_tele = NULL;
			}

			$opcion_codigo = $arreglo->opcion_codigoCT;

			$mensaje = array();

			$resul = $modelo -> verificarCodigoTelefonico($id_codigo_tele, $opcion_codigo);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = ' ';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '(!) A telephone code already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

	}
?>
