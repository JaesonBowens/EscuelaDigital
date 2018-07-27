<?php

	function cargarOperacionSobreTabla(){
		$resul = consultarOperacion();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<option value='".$fila["operacion"]."'>".$fila["operacion"]."</option>";
			}
		}
	}

	function consultarOperacion(){

		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "SELECT DISTINCT(operacion_bitacora) AS operacion FROM bitacora;";

		$resul = mysql_query($sql);		

		return $resul;

		$conexion_bd->cerrar_conexion();

	}
?>
