<?php
	session_start();

	//Incluimos al ModeloGestionarGrado.php
	include("../modelo/grado.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos la clase
		$modelo = new ModeloGrado;
		$modeloBitacora = new ModeloBitacora;

		//Verificapos si la opcion que se pulso fue la de incluir
		if(isset($_POST["incluir"])){

			$arreglo = json_decode(stripslashes($_POST["incluir"]));

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$nivel = mb_strtoupper($arreglo->nivelG, "utf-8");
			$nivel_numero = $arreglo->nivel_numeroG;

			$mensaje = array();

			$numFila = $modelo -> consultarSiExiste($nivel, $nivel_numero);

			if(!$numFila){
				$resul = $modelo -> incluir($nivel, $nivel_numero);

				//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){

					$tabla_bitacora = "grade";
					$operacion_bitacora = "INCLUDE";
					$detalle_bitacora = $nivel;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Grade Registered Successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}

				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error registering grade, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A grade already exist with this number and name';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de modificar
		else if(isset($_POST["modificar"])){

			$arreglo = json_decode(stripslashes($_POST["modificar"]));

			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_grado = $arreglo->id_gradoG;
			$nivel = mb_strtoupper($arreglo->nivelG, "utf-8");
			$nivel_numero = $arreglo->nivel_numeroG;

			$mensaje = array();

			$resul = $modelo -> consultarParaModificar($id_grado);

			$fila = mysql_fetch_array($resul);

			$nivel2        = $fila["nivel"];
			$nivel_numero2 = $fila["nivel_numero"];

			//Si se verifica que realizo cambios
			if($nivel2 != $nivel || $nivel_numero2 != $nivel_numero ){
				$numFila = $modelo -> consultarSiExisteM($id_grado, $nivel, $nivel_numero);

				if(!$numFila){
					//Enviamos a modificar 
					$resul = $modelo -> modificar($id_grado, $nivel, $nivel_numero);

					//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
					if($resul){
						$tabla_bitacora = "grade";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $id_grado.", ".$nivel;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'Grade Updated Successfully';

						$msj = json_encode($mensaje);
						echo $msj;
					}

					else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating the grade, consult your Data Base Administrator';

						$msj = json_encode($mensaje);
						echo $msj;
					}
				}
				else{
					$mensaje["resultado"] = 'ALREADY EXIST';
					$mensaje["msj"] = 'A grade already exist with this number and name';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'NO CHANGES';
				$mensaje["msj"] = 'Sorry, You didn´t realized any change';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de eliminar
		else if(isset($_POST["eliminar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_grado = antiInjectionSql($_POST["eliminar"]);

			$mensaje = array();

			$numFila = $modelo -> consultarUso($id_grado);

			if(!$numFila){
				$resul = $modelo -> eliminar($id_grado);

				if($resul){

					$tabla_bitacora = "grade";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_grado;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

					$mensaje["resultado"] = 'SUCCESSFUL';
					$mensaje["msj"] = 'Grade Deleted Successfully';

					$msj = json_encode($mensaje);
					echo $msj;
				}
				else{
					$mensaje["resultado"] = 'DATA BASE ERROR';
					$mensaje["msj"] = 'Error deleting grade, consult your Data Base Administrator';

					$msj = json_encode($mensaje);
					echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'BEING USED';
				$mensaje["msj"] = 'Sorry, You can´t delete this grade because it´s being used';

				$msj = json_encode($mensaje);
				echo $msj;
			}

		}

		//Verificapos si la opcion que se pulso fue la de consultar
		else if(isset($_GET["consultaAvanzada"])){
			$nivel = mb_strtoupper(antiInjectionSql($_GET["consultaAvanzada"]), "utf-8");

			$resul = $modelo -> realizarConsultaAvanzada($nivel);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					echo "<tr>
						<td class='seleccion' width='200px' id='".$fila["id_grado"]."' title='Double Click on the grade that you wish to modify' ><input type='hidden' name='nivel_numero' value='".$fila["nivel_numero"]."' />".$fila["nivel"]."</td>
					  </tr>";
				}
			}
		}

		else if(isset($_POST["consultar"])){

			$arreglo = json_decode(stripslashes($_POST["consultar"]));

			if($arreglo->id_gradoG != ''){
					$id_grado = $arreglo->id_gradoG;
			}else{
					$id_grado = NULL;
			}

			if($arreglo->nivelG != ''){
					$nivel = $arreglo->nivelG;
			}else{
					$nivel = NULL;
			}

			if($arreglo->nivel_numeroG != ''){
					$nivel_numero = $arreglo->nivel_numeroG;
			}else{
					$nivel_numero = NULL;
			}

			$mensaje = array();

			$resul = $modelo -> verificarGrado($id_grado, $nivel, $nivel_numero);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = ' ';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '(!) A grade already exist with this name and number';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

		else if(isset($_POST["consultarNivel"])){

			$arreglo = json_decode(stripslashes($_POST["consultarNivel"]));

			$nivel = $arreglo->nivelG;
			$nivel_numero = $arreglo->nivel_numeroG;

			$mensaje = array();

			$resul = $modelo -> consultarSiExisteNivel($nivel, $nivel_numero);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = ' ';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '(!) A grade already exist with this name and iteration';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}

		else if(isset($_POST["consultarNivelNumero"])){

			$arreglo = json_decode(stripslashes($_POST["consultarNivelNumero"]));

			$nivel = $arreglo->nivelG;
			$nivel_numero = $arreglo->nivel_numeroG;

			$mensaje = array();

			$resul = $modelo -> consultarSiExisteNivelNumero($nivel, $nivel_numero);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = ' ';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '(!) A grade already exist with this name and iteration';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}
		
	}
?>
