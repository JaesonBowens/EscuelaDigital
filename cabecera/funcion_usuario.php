<?php
	include("librerias/json.php");
	include("../modelo/conexion_bd.php");
	$conexion = new conexionBD;
	$conexion->conexion();

	if(isset($_GET["consultarUso"])){
		
		$json = new Services_JSON();
		
		$id_tipo_usuario = $_GET["consultarUso"];

		$sql = "SELECT id_funcion_usuario, nombre_funcion_usuario FROM asignacion_funcion JOIN funcion_usuario USING(id_funcion_usuario) WHERE id_tipo_usuario = '".$id_tipo_usuario."';";

		$resul = mysql_query($sql);		

		if($resul){
			while($fila = mysql_fetch_array($resul)){
				$cadena[] = $fila;
			}

			$cad = $json->encode($cadena);
			echo $cad;
		}
		else{
			$cad = $json->encode(NULL);
			echo $cad;
		}
	}

	function cargarFuncionUsuario(){
		$resul = consultarFuncionUsuario();

		$numFila = mysql_num_rows($resul);
		
		while ($fila = mysql_fetch_array($resul)) {
			echo "<tr class='seleccion-funcion' title='Double Click on the Function that you want to assign to this Type of User.'>
						<td width='395px'><input type='hidden' name='id_funcion' value='".$fila["id_funcion_usuario"]."' />".$fila["nombre_funcion_usuario"]."</td>
					</tr>";
		}
	}

	function consultarFuncionUsuario(){
		$sql = "SELECT id_funcion_usuario, nombre_funcion_usuario FROM funcion_usuario ORDER BY nombre_funcion_usuario;";

		$resul = mysql_query($sql);		

		return $resul;
	}
?>
