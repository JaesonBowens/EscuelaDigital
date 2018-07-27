<?php
	function mostrarAnoEscolar(){
		$conexion = new conexionBD;

		$conexion -> conexion();

		$sql = "SELECT id_ano_escolar, fecha_inicio, fecha_fin, denominacion FROM ano_escolar WHERE estatus = 'A';";

		$resul = mysql_query($sql);

		$numFila = mysql_num_rows($resul);

		if($numFila){
			$fila = mysql_fetch_array($resul);
			list($ano1, $mes1, $dia1) = explode("-", $fila["fecha_inicio"]);
			list($ano2, $mes2, $dia2) = explode("-", $fila["fecha_fin"]);

			echo "<input type='hidden' id='id_ano_escolar' name='id_ano_escolar' value='".$fila["id_ano_escolar"]."' />";
			echo "<input type='text' id='ano_escolar' name='ano_escolar' value='".$ano1."-".$ano2."' title='Año Escolar' disabled='disabled' size='21px' />";
		}
		else{
			//$_SESSION["mensaje"] = "Por Favor, Active un Año Escolar";
			//echo "<script>setTimeout(function(){ window.location = 'VistaMenuPrincipal.php'; }, 0);</script>";

			echo '<script>
				alertify.confirm("There is no active school year<br/>Do you want to activate an academic period", function(c){
					if(c){
						window.location = "gestionar_anio_escolar.php";
					}
					else{
						window.location = "menu_principal.php";
					}
				});
			</script>';
		}
		
		$conexion->cerrar_conexion();
	}

	function cargarAnoEscolar(){
		$conexion = new conexionBD;

		$conexion -> conexion();

		$sql = "SELECT id_ano_escolar, fecha_inicio, fecha_fin, denominacion, estatus FROM ano_escolar;";

		$resul = mysql_query($sql);

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while($fila = mysql_fetch_array($resul)){

				echo "<option value='".$fila["id_ano_escolar"]."'>".$fila["denominacion"]."</option>";
				
			}
		}
		
		$conexion->cerrar_conexion();
	}
?>
