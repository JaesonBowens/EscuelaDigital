<?php
	session_start();

	if(isset($_POST["comprobar"])) {
		
		$mensaje = array();
	
		if($_POST["comprobar"] == $_SESSION["codigo_seguridad"]){
			$mensaje["igual"] = 'YES';
			
		}else if($_POST["comprobar"] != $_SESSION["codigo_seguridad"]){
			$mensaje["igual"] = 'NO';
		}

		$msj = json_encode($mensaje);
		echo $msj;
	}
?>
