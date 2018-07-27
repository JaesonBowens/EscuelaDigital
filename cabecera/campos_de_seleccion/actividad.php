<?php
	include("../../modelo/conexion_bd.php");
	$conexion_bd = new conexionBD;
	$conexion_bd->conexion();

	if(isset($_POST["consultarIdArea"])){
		$id_area = htmlentities($_POST["consultarIdArea"]);

		$sql = "SELECT id_actividad, nombre_actividad FROM actividad WHERE id_area = '".$id_area."' ORDER BY id_actividad;";

		$resul = mysql_query($sql);		

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				$nombre_actividad = $fila["nombre_actividad"];
				if($nombre_actividad != "FIND THE LETTERS"){
					if($nombre_actividad != "COMPLETE THE SEQUENCE OF NUMBERS"){
						$cadena[] = $fila;
					}
							
				}
			}

			$cad = json_encode($cadena);
			echo $cad;
		}
	}

	if(isset($_POST["consultarIdAreaReporte"])){
		$id_area = htmlentities($_POST["consultarIdAreaReporte"]);

		$sql = "SELECT id_actividad, nombre_actividad FROM actividad WHERE id_area = '".$id_area."' ORDER BY id_actividad;";

		$resul = mysql_query($sql);		

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {

				$cadena[] = $fila;
				
			}

			$cad = json_encode($cadena);
			echo $cad;
		}
	}

	function cargarActividad(){
		$resul = consultarActividad();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				   echo "<option value='".$fila["id_actividad"]."'>".$fila["nombre_actividad"]."</option>";
			}
		}
		else{
			$_SESSION["mensaje"] = "Por Favor, registre las Actividades";
			echo "<script>setTimeout(function(){ window.location = 'menu_principal.php'; }, 0);</script>";
		}
	}

	function cargarActividadSeleccion($id_actividad){
		$resul = consultarActividad();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				if($id_actividad == $fila["id_actividad"]){
					
						echo "<option value='".$fila["id_actividad"]."' selected='selected'>".$fila["nombre_actividad"]."</option>";
				}
				else{
					echo "<option value='".$fila["id_actividad"]."'>".$fila["nombre_actividad"]."</option>";
				}
			}
		}
	}

	function consultarActividad(){
		$sql = "SELECT id_actividad, nombre_actividad FROM actividad ORDER BY id_actividad;";

		$resul = mysql_query($sql);		

		return $resul;
	}
?>
