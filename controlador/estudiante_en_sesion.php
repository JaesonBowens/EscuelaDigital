<?php
	session_start();

	include("../modelo/estudiante.php");

	$modeloEstudiante = new ModeloEstudiante;

	if(isset($_POST["consultar"])){
		$id_estudiante = $_SESSION["ses_id_estudiante"];

		$resulEstudiante = $modeloEstudiante -> consultarPorId($id_estudiante);

		if($resulEstudiante){
			$estudiante = array ();

			$filaEstudiante = mysql_fetch_array($resulEstudiante);

			$estudiante["cedula"] = $filaEstudiante["cedula"];
			$estudiante["nombre"] = $filaEstudiante["nombre"];
			$estudiante["apellido"] = $filaEstudiante["apellido"];
			
			echo json_encode($estudiante);
		}
	}

?>
