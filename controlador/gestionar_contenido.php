<?php
	session_start();

	//Incluimos al ModeloGestionarcontenido.php
	include("../modelo/contenido.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos la clase
		$modelo = new ModeloContenido;
		$modeloBitacora = new ModeloBitacora;

		//Verificapos si la opcion que se pulso fue la de incluir
		if(isset($_POST["incluir"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_contenido = mb_strtoupper($_POST["incluir"], "utf-8");

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($nombre_contenido);

			if(!$numFila){
				$resul = $modelo -> incluir($nombre_contenido);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){
					$tabla_bitacora = "content";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $nombre_contenido;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Content registered successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error registering content, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A content already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de modificar
		else if(isset($_POST["modificar"])){

			$arreglo 	= json_decode(stripslashes($_POST["modificar"]));

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_contenido = mb_strtoupper($arreglo->nombre_contenidoC, "utf-8");
			$id_contenido = $arreglo->id_contenidoC;
			
			$mensaje = array();

			$nombre = $modelo -> consultarParaModificar($id_contenido);

			//Si se verifica que realizo cambios
			if($nombre != $nombre_contenido){
				//$numFila = $modelo -> consultarSiExiste($nombre_contenido);

				//if(!$numFila){
					//Enviamos a modificar 
					$resul = $modelo -> modificar($id_contenido, $nombre_contenido);

					//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
					if($resul){

						$tabla_bitacora = "content";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_contenido.", ".$nombre_contenido;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'Content Updated Successfully';

						$msj = json_encode($mensaje);
						echo $msj;
					}

					else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating content, consult your Data Base Administrator';

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
			$id_contenido     = antiInjectionSql($_POST["eliminar"]);

			$numFila = $modelo -> consultarUso($id_contenido);

			if(!$numFila){
				$resul = $modelo -> eliminar($id_contenido);

				if($resul){
					$tabla_bitacora = "content";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_contenido;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Content Deleted Successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}
				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error deleting content, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'BEING USED';
				$mensaje["msj"] = 'Sorry, You can´t delete this content because it´s being used';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de consultar
		else if(isset($_GET["consultaAvanzada"])){
			$nombre_contenido = mb_strtoupper(antiInjectionSql($_GET["consultaAvanzada"]), "utf-8");

			$resul = $modelo -> realizarConsultaAvanzada($nombre_contenido);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					echo "<tr>
						<td class='seleccion' width='250px' id='".$fila["id_contenido"]."' title='Double Click on the content that you wish to modify' ondblclick='seleccion(this, \"id_contenido\", \"nombre_contenido\")'>".$fila["nombre_contenido"]."</td>
				      </tr>";
				}
			}
		}

		else if(isset($_POST["consultar"])){
			$arreglo = json_decode(stripslashes($_POST["consultar"]));

			if($arreglo->id_contenidoC != ''){
				$id_contenido = $arreglo->id_contenidoC;
			}else{
				$id_contenido = NULL;
			}

			$nombre_contenido = $arreglo->nombre_contenidoC;

			$mensaje = array();

			$resul = $modelo -> verificarContenido($id_contenido, $nombre_contenido);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = ' ';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '(!) A content already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

		if(isset($_POST["incluirNuevoContenido"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nombre_contenido = mb_strtoupper($_POST["incluirNuevoContenido"], "utf-8");

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($nombre_contenido);

			if(!$numFila){
				$resul = $modelo -> incluir($nombre_contenido);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){
					$tabla_bitacora = "content";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $nombre_contenido;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$resul = $modelo -> consultarNuevoContenido($nombre_contenido);

					$fila = mysql_fetch_array($resul);

					$mensaje["id_contenido"] = $fila["id_contenido"];
					$mensaje["nombre_contenido"] = $fila["nombre_contenido"];

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Content Registered Successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error registering content, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A content already exist with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}
	}
?>
