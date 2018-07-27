<?php
	function cargarDiscapacidad(){
		$resul = consultarDiscapacidad();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<option value='".$fila["id_discapacidad"]."'>".$fila["nombre_discapacidad"]."</option>";
			}
		}
		else{
			$_SESSION["mensaje"] = "Please register a discapacity";
			echo "<script>setTimeout(function(){ window.location = 'menu_principal.php'; }, 0);</script>";
		}
	}

	function cargarDiscapacidadSeleccion($id_discapacidad){
		$resul = consultarDiscapacidad();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				if($id_discapacidad == $fila["id_discapacidad"]){
					echo "<option value='".$fila["id_discapacidad"]."' selected='selected'>".$fila["nombre_discapacidad"]."</option>";
				}
				else{
					echo "<option value='".$fila["id_discapacidad"]."'>".$fila["nombre_discapacidad"]."</option>";
				}
			}
		}
	}

	function consultarDiscapacidad(){

		$conexion = new conexionBD;
		$conexion->conexion();
		
		$sql = "SELECT id_discapacidad, nombre_discapacidad FROM discapacidad ORDER BY id_discapacidad;";

		$resul = mysql_query($sql);		

		return $resul;

		$conexion->cerrar_conexion();
	}
?>
