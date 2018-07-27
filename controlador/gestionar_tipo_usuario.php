<?php
	session_start();

	//Incluimos al ModeloTipoUsuario.php
	include("../modelo/tipo_usuario.php");

	//Incluimos al ModeloAsignacionFuncion.php
	include("../modelo/asignacion_funcion.php");

	//Incluimos al ModeloBitacora.php
	include("../modelo/bitacora.php");

	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		//Instanciamos la clase ModeloTipoUsuario
		$modelo = new ModeloTipoUsuario;

		//Instanciamos la clase ModeloAssignacionFuncion
		$modeloAsignacionFuncion = new ModeloAsignacionFuncion;

		//Instanciamos la clase ModeloBitacora
		$modeloBitacora = new ModeloBitacora;

		//Verificapos si la opcion que se pulso fue la de incluir
		if(isset($_POST["incluir"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$descripcion_tipo_usuario = mb_strtoupper(antiInjectionSql($_POST["descripcion_tipo_usuario"]), "utf-8");
			$cont                     = antiInjectionSql($_POST["cont"]);

			$numFila = $modelo -> consultarSiExiste($descripcion_tipo_usuario);

			if($cont != 0){
				if(!$numFila){
					$resul = $modelo -> incluir($descripcion_tipo_usuario);

					$id_tipo_usuario = $resul;

					$resul_asig = true;

					if($resul){
						$id_funcion_usuario = $_POST["id_funcion_usuario"];

						for($i = 0; $i<$cont; $i++){
							$resul_asig = $modeloAsignacionFuncion -> incluirAsigFuncion($id_funcion_usuario[$i], $id_tipo_usuario);

							if(!$resul_asig){
								return false;
							}
						}
					}				

					//Dependiendo de si se incluyo o no ($resul = true o $resul = false se envian los mensajes)
					if($resul && $resul_asig){
						$_SESSION["mensaje"] = "Tipo de Usuario Registrado con Éxito";

						$tabla_bitacora = "type_user";
						$operacion_bitacora = "INCLUDE";
						$detalle_bitacora = $descripcion_tipo_usuario;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
					}

					else{
						$_SESSION["mensaje"] = "Error registering type of user, consult your Data Base Provider";
					}
				}
				else{
					$_SESSION["mensaje"] = "A type of user already exist with this name";
				}
			}
			else{
				$_SESSION["mensaje"] = "You must assign functions to the user";
			}

			//Redireccionamos
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_tipo_usuario.php'>";
		}

		//Verificapos si la opcion que se pulso fue la de modificar
		else if(isset($_POST["modificar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_tipo_usuario          = antiInjectionSql($_POST["id_tipo_usuario"]);
			$descripcion_tipo_usuario = mb_strtoupper(antiInjectionSql($_POST["descripcion_tipo_usuario"]), "utf-8");
			$cont                     = antiInjectionSql($_POST["cont"]);

			if($cont != 0){			
				//Enviamos a modificar 
				$resul = $modelo -> modificar($id_tipo_usuario, $descripcion_tipo_usuario);

				$id_funcion_usuario = $_POST["id_funcion_usuario"];

				$resulAsigFuncion = $modeloAsignacionFuncion -> consultarPorIdTipoUsuario($id_tipo_usuario);

				if($resulAsigFuncion){
					while($fila = mysql_fetch_array($resulAsigFuncion)){
						$id_funcion_usuario1 = $fila["id_funcion_usuario"];
						$comparacion = false;

						for($i = 0; $i<$cont; $i++){
							
							if($id_funcion_usuario[$i] == $fila["id_funcion_usuario"]){
								$comparacion = true;
							}
						}

						if(!$comparacion){
							$modeloAsignacionFuncion -> eliminarAsigFuncion($id_funcion_usuario1, $id_tipo_usuario);
						}
					}
				}

				for($i = 0; $i<$cont; $i++){
					$id_funcion_usuario1 = $id_funcion_usuario[$i];

					$resulExiste = $modeloAsignacionFuncion -> consultarSiExisteAsig($id_funcion_usuario1, $id_tipo_usuario);

					if(!$resulExiste){
						$modeloAsignacionFuncion -> incluirAsigFuncion($id_funcion_usuario[$i], $id_tipo_usuario);
					}
				}

				//Dependiendo de si se modifico o no ($resul = true o $resul = false se envian los mensajes)
				if($resul){
					$_SESSION["mensaje"] = "Type Of User Updated Successfully";

					$tabla_bitacora = "type_user";
					$operacion_bitacora = "UPDATE";
					$detalle_bitacora = $id_tipo_usuario.", ".$descripcion_tipo_usuario;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
				}

				else{
					$_SESSION["mensaje"] = "Error updating type of user, consult your Data Base Provider";
				}
			}
			else{
				$_SESSION["mensaje"] = "You must assign functions to the user";
			}

			//Redireccionamos
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_tipo_usuario.php'>";
		}

		//Verificapos si la opcion que se pulso fue la de eliminar
		else if(isset($_POST["eliminar"])){
			//Guardamos en una nueva variable lo que se halla escrito en el campo correspondiente
			$id_tipo_usuario = antiInjectionSql($_POST["id_tipo_usuario"]);

			$numFila = $modelo -> consultarUso($id_tipo_usuario);

			if(!$numFila){
				$resul = $modelo -> eliminar($id_tipo_usuario);
				$modeloAsignacionFuncion -> eliminarTodaAsigFuncion($id_tipo_usuario);

				if($resul){
					$_SESSION["mensaje"] = "Type Of User Deleted Successfully";

					$tabla_bitacora = "type_user";
					$operacion_bitacora = "DELETE";
					$detalle_bitacora = $id_tipo_usuario;

					date_default_timezone_set('America/Caracas');

					$fecha_bitacora = date("Y-m-d"); 
					$hora_bitacora = date("H:i:s");
					$id_usuario = $_SESSION["ses_id_usuario"];

					$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);
				}
				else{
					$_SESSION["mensaje"] = "Error deleting type of user, consult your Data Base Provider";
				}
			}
			else{
				$_SESSION["mensaje"] = "Sorry, You can´t delete this type of user because it´s being used";
			}

			//Redireccionamos
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_tipo_usuario.php'>";
		}

		//Verificapos si la opcion que se pulso fue la de consultar
		else if(isset($_GET["consultar"])){
			$descripcion_tipo_usuario = mb_strtoupper(antiInjectionSql($_GET["consultar"]), "utf-8");

			$resul = $modelo -> consultarAvanzado($descripcion_tipo_usuario);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					if($fila["id_tipo_usuario"] != 1){
						echo "<tr>
							<td class='seleccion' width='400px' id='".$fila["id_tipo_usuario"]."' title='Double Click on the type of user that you wish to modify'>".html_entity_decode($fila["descripcion_tipo_usuario"])."</td>
						  </tr>";
					}
				}
			}
		}

		//Si no se pulso ninguna opcion
		else{
			$_SESSION["mensaje"] = "Invalid Option";

			//Redireccionamos
			echo "<meta http-equiv='refresh' content='0; url=../vista/gestionar_tipo_usuario.php'>";
		}
	}
?>
