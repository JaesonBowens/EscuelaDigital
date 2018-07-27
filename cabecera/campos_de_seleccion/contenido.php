<?php
	function cargarContenido(){
		$resul = consultarContenido();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<option value='".$fila["id_contenido"]."'>".$fila["nombre_contenido"]."</option>";
			}
		}
		else{
			$_SESSION["mensaje"] = "Please register the contents";
			echo "<script>setTimeout(function(){ window.location = 'VistaMenuPrincipal.php'; }, 0);</script>";
		}
	}

	function cargarContenidoAsignacionPC(){
		$id_seccion = $_SESSION["id_seccion"];

		$resul = consultarContenidoContado($id_seccion);

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				echo "<tr>
						<td width='25px'> <input type='checkbox' title='Select a content' name='seleccion' value='".$fila["id_contenido"]."' /> </td>
						<td width='250px'> ".$fila["nombre_contenido"]." -  Quantity of Img ( ".$fila["contado"]." ) </td>
					</tr>
				";
			}
		}
		else{
			$_SESSION["mensaje"] = "Please register a content!";
			echo "<script>setTimeout(function(){ window.location = '../index.php'; }, 0);</script>";
		}
	}

	function cargarContenidoAsignacionPCJs(){
		$id_seccion = $_SESSION["id_seccion"];
		$tr = "";

		$resul = consultarContenidoContado($id_seccion);

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)) {
				$tr .= "<tr>
						<td width='25px'> <input type='checkbox' title='Select a content' name='seleccion' value='".$fila["id_contenido"]."' /> </td>
						<td width='750px'> ".$fila["nombre_contenido"]." -  Quantity of Img ( ".$fila["contado"]." ) </td>
					</tr>
				";
			}
		}
		
		return $tr;
	}

	function cargarContenidoSeleccion($id_contenido){
		$resul = consultarContenido();

		$numFila = mysql_num_rows($resul);

		if($numFila){
			while ($fila = mysql_fetch_array($resul)){
				if($id_contenido == $fila["id_contenido"]){
					echo "<option value='".$fila["id_contenido"]."' selected='selected'>".$fila["nombre_contenido"]."</option>";
				}
				else{
					echo "<option value='".$fila["id_contenido"]."'>".$fila["nombre_contenido"]."</option>";
				}
			}
		}
	}

	function consultarContenido(){

		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "SELECT id_contenido, nombre_contenido FROM contenido ORDER BY nombre_contenido;";

		$resul = mysql_query($sql);

		$conexion->cerrar_conexion();				

		return $resul;
	}

	function consultarContenidoContado($id_seccion){

		$conexion = new conexionBD;
		$conexion->conexion();

		$sql = "SELECT cont.id_contenido, cont.nombre_contenido, COUNT( * ) AS contado FROM contenido AS cont
INNER JOIN contenido_imagen AS cont_img ON cont.id_contenido = cont_img.id_contenido INNER JOIN seccion_imagen AS sec_img ON cont_img.id_imagen = sec_img.id_imagen WHERE sec_img.id_seccion = $id_seccion GROUP BY cont.nombre_contenido;";

		$resul = mysql_query($sql);

		$conexion->cerrar_conexion();				

		return $resul;
	}

	if(isset($_POST["contenido"])){
		session_start();
		include("../../modelo/conexion_bd.php");

		$resul = cargarContenidoAsignacionPCJs();

		echo $resul;
	}
?>
