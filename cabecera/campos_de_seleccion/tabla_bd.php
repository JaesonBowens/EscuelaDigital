<?php

	function cargarTablaBD(){
		$resul = consultarTablaBD();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<option value='".$fila["table_name"]."'>".$fila["table_name"]."</option>";
			}
		}
	}

	function consultarTablaBD(){

		include("../modelo/conexion_bd.php");
		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "select table_name from information_schema.tables where table_schema='software_educativo';";

		$resul = mysql_query($sql);		

		return $resul;

		$conexion_bd->cerrar_conexion();

	}
?>
