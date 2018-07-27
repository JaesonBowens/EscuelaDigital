<?php
	include("../librerias/json.php");

	if(isset($_POST["consultarIdGrado"])){
		include("../../modelo/conexion_bd.php");

		$id_grado = htmlentities($_POST["consultarIdGrado"]);

		if(!empty($id_grado)){
			$resul = consultarSeccion($id_grado);

			$numFila = mysql_num_rows($resul);

			if($numFila){
				while ($fila = mysql_fetch_array($resul)) {
					$cadena[] = $fila;			
				}
			}

			$cad = json_encode($cadena);
			echo $cad;
		}
	}

	if(isset($_GET["consultar"])){

		include("../../modelo/conexion_bd.php");

		$id_grado = htmlentities($_GET["consultar"]);

		if(!empty($id_grado)){
			$resul = consultarSeccion($id_grado);

			if($resul){
				echo "<option value=''>SELECT</option>";

				while($fila = mysql_fetch_array($resul)){
					echo "<option value='".$fila['id_seccion']."'>".$fila['grupo']."</option>";
				}
			}
		}
		else{
			echo "<option selected>SELECT</option>";
		}
	}

	if(isset($_GET["consultar_seleccionada"])){

		include("../../modelo/conexion_bd.php");
		
		$id_grado = htmlentities($_GET["consultar_seleccionada"]);

		$id_seccion = htmlentities($_GET["seleccion"]);

		cargarSeccionSeleccion($id_seccion, $id_grado);
	}

	//Si de asignacionEstudiante.js se llama a esta funcion es para a la hora de modificar
	//cuando seleccione de la busqueda avanzada seleccione la seccion a asignar
	if(isset($_POST["consultarModificar"])){
		include("../../modelo/conexion_bd.php");
		
		$arreglo = json_decode(stripslashes($_POST["consultarModificar"]));

		$id_grado   = $arreglo->grado;
		$id_seccion = $arreglo->seccion;

		cargarSeccionSeleccion($id_seccion, $id_grado);
	}

	function cargarSeccionSeleccion($id_seccion, $id_grado){
		$resul = consultarSeccion($id_grado);

		$numFila = mysql_num_rows($resul);

		if($numFila){
			echo "<option value=''>SELECT</option>";
			
			while ($fila = mysql_fetch_array($resul)){
				if($id_seccion == $fila["id_seccion"]){
					echo "<option value='".$fila["id_seccion"]."' selected='selected'>".$fila["grupo"]."</option>";
				}
				else{
					echo "<option value='".$fila["id_seccion"]."'>".$fila["grupo"]."</option>";
				}
			}
		}
	}

	function consultarSeccion($id_grado){
		
		$conexion = new conexionBD;
		$conexion->conexion();
		
		$sql = "SELECT id_seccion, grupo FROM seccion WHERE id_grado = '".$id_grado."';";

		$resul = mysql_query($sql);

		return $resul;
	}
?>
