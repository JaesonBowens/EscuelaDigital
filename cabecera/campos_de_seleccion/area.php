<?php
	function cargarArea(){
		$resul = consultarArea();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<option value='".$fila["id_area"]."'>".$fila["nombre_area"]."</option>";
			}
		}
		else{
			$_SESSION["mensaje"] = "There is no area registered, consult your data base provider";
			echo "<script>setTimeout(function(){ window.location = 'menu_principal.php'; }, 0);</script>";
		}
	}

	function cargarAreaSeleccion($id_area){
		$resul = consultarArea();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				if($id_area == $fila["id_area"]){
					echo "<option value='".$fila["id_area"]."' selected='selected'>".$fila["nombre_area"]."</option>";
				}
				else{
					echo "<option value='".$fila["id_area"]."'>".$fila["nombre_area"]."</option>";
				}
			}
		}
	}

	function consultarArea(){

		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "SELECT id_area, nombre_area FROM area ORDER BY id_area;";

		$resul = mysql_query($sql);

		$conexion->cerrar_conexion();		

		return $resul;
	}
?>
