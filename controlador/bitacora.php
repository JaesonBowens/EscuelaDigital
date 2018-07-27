<?php
	session_start();

	include("../modelo/conexion_bd.php");

	include("../modelo/sesion_usuario.php");

	include("../modelo/bitacora.php");

	include("../cabecera/librerias/cierre_por_inactividad.php");

	$tiempo_sesion = cierrePorInactividad("salir.php");

	if($tiempo_sesion){

		$modeloSesionUsuario = new ModeloSesionUsuario;

		$modeloBitacora = new ModeloBitacora;

		if(isset($_GET["consultarActualizacion"])){
			//$nombre = htmlentities($_GET["consultaAvanzada"]);

			//$modelo -> nombre = strtoupper($nombre);

			if(isset($_GET["tabla"])){
				$tabla_bitacora = $_GET["tabla"];
			}else{
				$tabla_bitacora = NULL;
			}

			if(isset($_GET["operacion"])){
				$operacion_bitacora = $_GET["operacion"];
			}else{
				$operacion_bitacora = NULL;
			}

			if($_GET["fecha"] != "00/00/00"){
				$fecha = $_GET["fecha"];
				list($dia, $mes, $ano) = explode("/", $fecha);
				$fecha_bitacora = $ano."-".$mes."-".$dia;
			}else{
				$fecha_bitacora = NULL;
			}

			$resul = $modeloBitacora -> realizarConsultaAvanzada($tabla_bitacora, $operacion_bitacora, $fecha_bitacora);

			if($resul){
				while($fila = mysql_fetch_array($resul)){
					echo "
					<tr>
						<td width='170px'>".$fila["tabla_bitacora"]."</td>
						<td width='200px'>".$fila["operacion_bitacora"]."</td>
						<td width='110px'>".$fila["fecha_bitacora"]."</td>
						<td width='100px'>".$fila["hora_bitacora"]."</td>
						<td width='200px'>".$fila["nombre_usuario"]."</td>
						<td width='200px'>".$fila["detalle_bitacora"]."</td>
					</tr>
					";
				}
			}
		}

		if(isset($_GET["consultarEntradaSalida"])){
			//$nombre = htmlentities($_GET["consultaAvanzada"]);

			//$modelo -> nombre = strtoupper($nombre);

			if($_GET["fecha"] != "00/00/00"){
				$fecha = $_GET["fecha"];
				list($dia, $mes, $ano) = explode("/", $fecha);
				$fecha_sesion = $ano."-".$mes."-".$dia;
			}else{
				$fecha_sesion = NULL;
			}

			$resultado = $modeloSesionUsuario -> realizarConsultaAvanzada($fecha_sesion);

			if($resultado){
				while($fila = mysql_fetch_array($resultado)){

					if($fila["hora_fin"] == "00:00:00"){
						$hora_fin = "LOGGED IN";
					}else{
						$hora_fin = $fila["hora_fin"];
					}

					echo "
					<tr>
						<td width='200px'>".$fila["nombre_usuario"]."</td>
						<td width='200px'>".$fila["fecha_sesion"]."</td>
						<td width='200px'>".$fila["hora_inicio"]."</td>
						<td width='200px'>".$hora_fin."</td>
					</tr>
					";
				}
			}
		}
	}

?>
