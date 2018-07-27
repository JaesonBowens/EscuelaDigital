<?php

	if(isset($_GET["consultar"])){

		include("../../modelo/conexion_bd.php");

		$id_ano_escolar = htmlentities($_GET["consultar"]);

		if(!empty($id_ano_escolar)){

			echo "<option value=''>SELECT</option>";
			cargarGrado();
		}
		else{
			echo "<option value=''>SELECT</option>";
		}
	}

	function cargarGrado(){
		$resul = consultarGrado();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				echo "<option value='".$fila["id_grado"]."'>".$fila["nivel"]."</option>";
			}
		}
		else{
			$_SESSION["mensaje"] = "In order to register a section, you must have atleast one grade registered";
			echo "<script>setTimeout(function(){ window.location = 'menu_principal.php'; }, 0);</script>";
		}
	}

	function cargarGradoSeleccion($id_grado){
		$resul = consultarGrado();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				if($id_grado == $fila["id_grado"]){
					echo "<option value='".$fila["id_grado"]."' selected='selected'>".$fila["nivel"]."</option>";
				}
				else{
					echo "<option value='".$fila["id_grado"]."'>".$fila["nivel"]."</option>";
				}
			}
		}
	}

	function consultarGrado(){
		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "SELECT id_grado, nivel, nivel_numero FROM grado ORDER BY nivel_numero;";

		$resul = mysql_query($sql);

		$conexion->cerrar_conexion();		

		return $resul;
	}
?>
