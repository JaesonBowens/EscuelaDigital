<?php
	function cargarCodigoTelefono(){
		$resul = consultarCodigoTelefono();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<option value='".$fila["id_codigo_tele"]."'>".$fila["opcion_codigo"]."</option>";
			}
		}
		else{
			$_SESSION["mensaje"] = "Please register a telephone code!";
			echo "<script>setTimeout(function(){ window.location = 'menu_principal.php'; }, 0);</script>";
		}
	}

	function cargarCodigoTelefonoSeleccion($id_codigo_tele){
		$resul = consultarCodigoTelefono();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				if($id_codigo_tele == $fila["id_codigo_tele"]){
					echo "<option value='".$fila["id_codigo_tele"]."' selected='selected'>".$fila["opcion_codigo"]."</option>";
				}
				else{
					echo "<option value='".$fila["id_codigo_tele"]."'>".$fila["opcion_codigo"]."</option>";
				}
			}
		}
	}

	function consultarCodigoTelefono(){

		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "SELECT id_codigo_tele, opcion_codigo FROM codigo_tele ORDER BY id_codigo_tele;";

		$resul = mysql_query($sql);	

		$conexion->cerrar_conexion();	

		return $resul;
	}
?>
