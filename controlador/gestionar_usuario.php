<?php
	session_start();
	include("../modelo/conexion_bd.php");
	$conexion = new conexionBD;
	$conexion->conexion();

	include("../modelo/usuario.php");
	include("../modelo/bitacora.php");
	include("seguridad_sql.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		$modelo = new ModeloUsuario;
		$modeloBitacora = new ModeloBitacora;

		if(isset($_POST["modificar"])){
			$arreglo = json_decode(stripslashes($_POST["modificar"]));
			$id_usuario     = $arreglo->id_usuarioU;
			$nombre_usuario = $arreglo->nombre_usuarioU;
			$clave_usuario = $arreglo->clave_usuarioU;

			$mensaje = array();

			$resul = $modelo->verificarNombreUsuario($id_usuario, $nombre_usuario);

			if(!$resul){	
					$resul = $modelo -> consultar($id_usuario);

			if($resul){
				$fila = mysql_fetch_array($resul);

				$nombre = $fila["nombre_usuario"];
				$clave  = $fila["clave_usuario"];

				if($nombre != $nombre_usuario || $clave != $clave_usuario){

					$resul = $modelo -> modificar($id_usuario, $nombre_usuario, $clave_usuario);

					if($resul){
						$tabla_bitacora = "user";
						$operacion_bitacora = "UPDATE";
						$detalle_bitacora = $nombre.", ".$clave;

						date_default_timezone_set('America/Caracas');

						$fecha_bitacora = date("Y-m-d"); 
						$hora_bitacora = date("H:i:s");
						$id_usuario = $_SESSION["ses_id_usuario"];

						$modeloBitacora -> registrarAccion($tabla_bitacora, $operacion_bitacora, $fecha_bitacora, $hora_bitacora, $detalle_bitacora, $id_usuario);

						$mensaje["resultado"] = 'SUCCESSFUL';
						$mensaje["msj"] = 'User´s Data Updated Successfully';

						$msj = json_encode($mensaje);
						echo $msj;
					}else{
						$mensaje["resultado"] = 'DATA BASE ERROR';
						$mensaje["msj"] = 'Error updating user´s data, consult your Data Base Administrator';

						$msj = json_encode($mensaje);
						echo $msj;
					}
				}
				else{
						$mensaje["resultado"] = 'NO CHANGES';
						$mensaje["msj"] = 'You didn´t realized any changes';

						$msj = json_encode($mensaje);
						echo $msj;
				}
			}
			else{
				$mensaje["resultado"] = 'DATA BASE ERROR';
				$mensaje["msj"] = 'Error updating the user´s data, consult your Data Base Administrator';

				$msj = json_encode($mensaje);
				echo $msj;
			}
				
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = 'A user is already registered with this name, the user names must be distinct';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}
		else if(isset($_POST["consultar"])){
			$id_usuario = antiInjectionSql($_POST["consultar"]);

			$resul = $modelo -> consultar($id_usuario);

			if($resul){
				$fila = mysql_fetch_array($resul);

				$nombre_usuario = $fila["nombre_usuario"];

				$_SESSION["ses_nombre_usuario"] = $nombre_usuario;
				
				$clave_usuario          = $fila["clave_usuario"];

				$cadena["usuario"] = array(
												$nombre_usuario,
												$clave_usuario
											);
				
				echo json_encode($cadena);
			}
			else{
				echo NULL;
			}
		}
		else if(isset($_POST["verificarNombreUsuario"])){

			$arreglo = json_decode(stripslashes($_POST["verificarNombreUsuario"]));

			if($arreglo->id_usuarioU != ''){
				$id_usuario = $arreglo->id_usuarioU;
			}else{
				$id_usuario = NULL;
			}

			$nombre_usuario = $arreglo->nombre_usuarioU;

			$mensaje = array();

			$resul = $modelo->verificarNombreUsuario($id_usuario, $nombre_usuario);

			if(!$resul){
				$mensaje["resultado"] = 'DON´T EXIST';
				$mensaje["msj"] = ' ';

				$msj = json_encode($mensaje);
				echo $msj;
			}else{
				$mensaje["resultado"] = 'ALREADY EXIST';
				$mensaje["msj"] = '&#x2718; A user is already registered with this name';

				$msj = json_encode($mensaje);
				echo $msj;
			}
		}
	}
?>
