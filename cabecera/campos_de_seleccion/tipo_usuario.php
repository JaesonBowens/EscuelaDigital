<?php
	function cargarTipoUsuario(){
		$resul = consultarTipoUsuario();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			echo "<option value=''>SELECT</option>";

			while ($fila = mysql_fetch_array($resul)) {
				if($fila["id_tipo_usuario"] != 1){
					echo "<option value='".$fila["id_tipo_usuario"]."'>".$fila["descripcion_tipo_usuario"]."</option>";
				}
			}
		}
		else{
			$_SESSION["mensaje"] = "You must register a Type of User";
			echo "<script>setTimeout(function(){ window.location = 'menu_principal.php'; }, 0);</script>";
		}
	}

	function cargarTipoUsuarioSeleccion($id_tipo_usuario){
		$resul = consultarTipoUsuario();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				if($fila["id_tipo_usuario"] != 1){
					if($id_tipo_usuario == $fila["id_tipo_usuario"]){
						echo "<option value='".$fila["id_tipo_usuario"]."' selected='selected'>".$fila["descripcion_tipo_usuario"]."</option>";
					}
					else{
						echo "<option value='".$fila["id_tipo_usuario"]."'>".$fila["descripcion_tipo_usuario"]."</option>";
					}
				}
			}
		}
	}

	function consultarTipoUsuario(){

		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "SELECT id_tipo_usuario, descripcion_tipo_usuario FROM tipo_usuario ORDER BY descripcion_tipo_usuario;";

		$resul = mysql_query($sql);

		$conexion->cerrar_conexion();		

		return $resul;
	}
?>
