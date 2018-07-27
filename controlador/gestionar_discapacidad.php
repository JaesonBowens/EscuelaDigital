<?php
	session_start();

	//Incluimos al ModeloGestionardiscapacidad.php
	include("../modelo/discapacidad.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos la clase
		$modelo = new ModeloDiscapacidad;
		$modeloBitacora = new ModeloBitacora;

		//Verificapos si la opcion que se pulso fue la de incluir
		if(isset($_POST["incluir"])){

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_discapacidad = mb_strtoupper($_POST["incluir"], "utf-8");

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($nombre_discapacidad);

			if(!$numFila){
				$resul = $modelo -> incluir($nombre_discapacidad);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){

					$tabla_bitacora = "functional_discapacity";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $nombre_discapacidad;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $nombre_discapacidad, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Discapacity Registered Successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error registering discapacity, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A discapacity already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de modificar
		else if(isset($_POST["modificar"])){

			$arreglo 	= json_decode(stripslashes($_POST["modificar"]));

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_discapacidad    = mb_strtoupper($arreglo->nombre_discapacidadD, "utf-8");
			$id_discapacidad = $arreglo->id_discapacidadD;
			
			$mensaje = array();

			$nombre = $modelo -> consultarParaModificar($id_discapacidad);

			//Si se verifica que realizo cambios
			if($nombre != $nombre_discapacidad){
				$numFila = $modelo -> consultarSiExiste($nombre_discapacidad);

				if(!$numFila){
					//Enviamos a modificar 
					$resul = $modelo -> modificar($id_discapacidad, $nombre_discapacidad);

					//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
					if($resul){

						$tabla_bitacora = "functional_discapacity";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_discapacidad.", ".$nombre_discapacidad;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'Discapacity Updated Successfully';

						$msj = json_encode($mensaje);
						echo $msj;

					}

					else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating discapacity, consult your Data Base Administrator';

						$msj = json_encode($mensaje);
						echo $msj;
					}
				}
				else{
					$mensaje["resultado"] = 'ALREADY EXIST';
					$mensaje["msj"] = 'A discapacity already exist with this name';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'NO CHANGE';
				$mensaje["msj"] = 'Sorry, You didn´t realized any change';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

		//Verificapos si la opcion que se pulso fue la de eliminar
		else if(isset($_POST["eliminar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_discapacidad     = antiInjectionSql($_POST["eliminar"]);

			$numFila = $modelo -> consultarUso($id_discapacidad);

			if(!$numFila){
				$resul = $modelo -> eliminar($id_discapacidad);

				if($resul){
					$tabla_bitacora = "functionl_discapacity";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_discapacidad;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Discapacity Deleted Successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}
				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error deleting discapacity, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'BEING USED';
				$mensaje["msj"] = 'Sorry, You can´t delete this discapacity because it´s being used';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de consultar
		else if(isset($_GET["consultaAvanzada"])){
			$nombre_discapacidad = mb_strtoupper(antiInjectionSql($_GET["consultaAvanzada"]), "utf-8");
			$resul = $modelo -> realizarConsultaAvanzada($nombre_discapacidad);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					echo "<tr>
						<td class='seleccion' width='350px' id='".$fila["id_discapacidad"]."' title='Double Click on the discapacity that you wish to modify' ondblclick='seleccion(this, \"id_discapacidad\", \"nombre_discapacidad\")'>".$fila["nombre_discapacidad"]."</td>
					  </tr>";
				}
			}
		}

		else if(isset($_POST["consultar"])){
			$arreglo = json_decode(stripslashes($_POST["consultar"]));

			if($arreglo->id_discapacidadD != ''){
				$id_discapacidad = $arreglo->id_discapacidadD;
			}else{
				$id_discapacidad = NULL;
			}

			$nombre_discapacidad = $arreglo->nombre_discapacidadD;

			$mensaje = array();

			$resul = $modelo -> verificarDiscapacidad($id_discapacidad, $nombre_discapacidad);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = '';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '(!) A discapacity already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

		if(isset($_POST["incluirNuevaDiscapacidad"])){

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_discapacidad = mb_strtoupper($_POST["incluirNuevaDiscapacidad"], "utf-8");

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($nombre_discapacidad);

			if(!$numFila){
				$resul = $modelo -> incluir($nombre_discapacidad);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){
					$resul = $modelo -> consultarSiExisteUno($nombre_discapacidad);

					$fila = mysql_fetch_array($resul);

					$tabla_bitacora = "functional_discapacity";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $nombre_discapacidad;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Discapacity Registered Successfully';
					$mensaje["id_discapacidad"] = $fila["id_discapacidad"];
					$mensaje["nombre_discapacidad"] = $fila["nombre_discapacidad"];

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error registering discapacity, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A discapacity already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}
	}
?>
