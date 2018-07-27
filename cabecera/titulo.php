<?php
	function titulo(){

		$pagina = obtenerNombrePagina();

		if($pagina != "localhost/MiEscuelaDigital/index.php"){

			echo "<link rel='shortcut icon' type='image/png' href='../imagen/logo.png' />";
		
			echo "<link rel='shortcut icon' type='image/png' href='../../imagen/logo.png' />";

		}else{

			echo "<link rel='shortcut icon' type='image/png' href='imagen/logo.png' />";

		}

		echo "<title>
			Mi Escuela Digital
		      </title>";
		
	}

	function obtenerNombrePagina(){

		$pageURL = '';
 			
		if ($_SERVER["SERVER_PORT"] != "80") {
  			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 		} else {
  			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 		}

 		return $pageURL;
	}

?>

