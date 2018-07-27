<?php
	session_start();

	//Incluimos al ModeloGrado.php
	include("../modelo/grado.php");

	//Incluimos al ModeloSeccion.php
	include("../modelo/seccion.php");

	//Incluimos al ModeloSeccion.php
	include("../modelo/bitacora.php");

	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos la clase ModeloSeccion
		$modelo = new ModeloSeccion;

		//Instanciamos la clase ModeloGrado
		$modeloGrado = new ModeloGrado;

		//Instanciamos la clase ModeloBitacora
		$modeloBitacora = new ModeloBitacora;

		//Verificapos si la opcion que se pulso fue la de incluir
		if(isset($_POST["incluir"])){

			$arreglo = json_decode(stripslashes($_POST["incluir"]));

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_grado = $arreglo->id_gradoS;
			$grupo    = mb_strtoupper($arreglo->grupoS, "utf-8");

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($grupo, $id_grado);

			if(!$numFila){
				$resul = $modelo -> incluir($grupo, $id_grado);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){
					$tabla_bitacora = "section";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $grupo.", ".$id_grado;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Section Registered Successfull';

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error updating section, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				  $mensaje["resultado"] = 'ALREADY EXIST';
					$mensaje["msj"] = 'This section is already registered';

					$msj = json_encode($mensaje);
					echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de modificar
		else if(isset($_POST["modificar"])){

			$arreglo = json_decode(stripslashes($_POST["modificar"]));

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_grado   = $arreglo->id_gradoM;
			$id_seccion = $arreglo->id_seccionM;
			$grupo      = mb_strtoupper($arreglo->grupoM, "utf-8");

			$mensaje = array();

			$fila = $modelo -> consultarParaModificar($id_seccion);

			//Si se verifica que realizo cambios
			if($fila["grupo"] != $grupo || $fila["id_grado"] != $id_grado){
				$numFila = $modelo -> consultarSiExiste($grupo, $id_grado);

				if(!$numFila){
					//Enviamos a modificar 
					$resul = $modelo -> modificar($id_seccion, $grupo, $id_grado);

					//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
					if($resul){
						$tabla_bitacora = "section";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_seccion.", ".$grupo.", ".$id_grado;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'Section Updated Successfully';

						$msj = json_encode($mensaje);
						echo $msj;
					}

					else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating section, consult your Data Base Administrator';

						$msj = json_encode($mensaje);
						echo $msj;
					}
				}
				else{
					$mensaje["resultado"] = 'ALREADY EXIST';
					$mensaje["msj"] = 'This section is already registered';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'NO CHANGES';
				$mensaje["msj"] = 'Sorry, You didn´t realized any changes';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de eliminar
		else if(isset($_POST["eliminar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_seccion = $_POST["eliminar"];

			$numFila = $modelo -> consultarUso($id_seccion);

			if(!$numFila){
				$resul = $modelo -> eliminar($id_seccion);

				if($resul){
					$tabla_bitacora = "section";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_seccion;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Section Deleted Successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}
				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error deleting section, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
					$mensaje["resultado"] = 'BEING USED';
					$mensaje["msj"] = 'Sorry, You can´t delete this seccion because it´s being used';

					$msj = json_encode($mensaje);
					echo $msj;
			}

		}
		
		//Verificapos si la opcion que se pulso fue la de consultar
		else if(isset($_GET["consultaAvanzada"])){

			if(isset($_GET["grado"])){
				$id_grado = $_GET["grado"];
			}else{
				$id_grado = NULL;
			}

			if(isset($_GET["grupo"])){
				$grupo = $_GET["grupo"];
			}else{
				$grupo = NULL;
			}

			$resul = $modelo -> realizarConsultaAvanzada($grupo, $id_grado);
			
			if($resul){
				if($id_grado == NULL){
					while($fila = mysql_fetch_array($resul)){
						echo "<tr class='seleccion' id='".$fila["id_seccion"]."' title='Double Click on the section that you wish to modify' >
							<td width='150px'><input type='hidden' name='id_grado' value='".$fila["id_grado"]."' />".$fila["nivel"]."</td>
							<td width='100px'>".$fila["grupo"]."</td>
						</tr>";
					}
				}else if($id_grado != NULL){
					while($fila = mysql_fetch_array($resul)){
						if($id_grado == $fila["id_grado"]){
							echo "<tr class='seleccion' id='".$fila["id_seccion"]."' title='Double Click on the section that you wish to modify' >
								<td width='150px'><input type='hidden' name='id_grado' value='".$fila["id_grado"]."' />".$fila["nivel"]."</td>
								<td width='100px'>".$fila["grupo"]."</td>
							</tr>";
						}
					}
				}
			}
		}

		else if(isset($_POST["consultar"])){

			$arreglo = json_decode(stripslashes($_POST["consultar"]));

			if($arreglo->id_seccionS != ''){
					$id_seccion = $arreglo->id_seccionS;
			}else{
					$id_seccion = NULL;
			}

			$grupo = $arreglo->grupoS;

			$id_grado = $arreglo->id_gradoS;

			$mensaje = array();

			$resul = $modelo -> verificarSeccion($id_seccion, $grupo, $id_grado);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = ' ';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '(!) This section is already registered';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

	}
?>
