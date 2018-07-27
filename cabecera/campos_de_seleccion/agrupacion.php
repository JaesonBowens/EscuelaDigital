<?php
	function cargarAgrupacion(){
		$resul = consultarAgrupacion();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<option value='".$fila["id_agrupacion"]."'>".$fila["nombre_agrupacion"]."</option>";
			}
		}
		
	}

	function cargarAgrupacionAsignacionPC(){
		$resul = consultarAgrupacion();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<tr>
						<td> <input type='checkbox' title='Seleccionar agrupacion' name='seleccion' value='".$fila["id_Agrupacion"]."' /> </td>
						<td> ".$fila["nombre_agrupacion"]." </td>
					</tr>
				";
			}
		}
		else{
			$_SESSION["mensaje"] = "Please register a grouping!";
			echo "<script>setTimeout(function(){ window.location = 'menu_principal.php'; }, 0);</script>";
		}
	}

	function cargarAgrupacionSeleccion($id_agrupacion){
		$resul = consultarAgrupacion();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				if($id_Agrupacion == $fila["id_agrupacion"]){
					echo "<option value='".$fila["id_agrupacion"]."' selected='selected'>".$fila["nombre_Agrupacion"]."</option>";
				}
				else{
					echo "<option value='".$fila["id_agrupacion"]."'>".$fila["nombre_agrupacion"]."</option>";
				}
			}
		}
	}

	function consultarAgrupacion(){

		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "SELECT id_agrupacion, nombre_agrupacion FROM agrupacion ORDER BY nombre_agrupacion;";

		$resul = mysql_query($sql);

		$conexion->cerrar_conexion();				

		return $resul;
	}
?>
