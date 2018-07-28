<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../../index.php");
		die();
	}

	include("../../cabecera/titulo.php");
	include("../../cabecera/menu_actividad.php");

	if(isset($_GET["Actividad"])){
		$actividad = $_GET["Actividad"];

		if($actividad == "PLACE THE FIRST LETTER"){
			$_SESSION["act1_consultar_imagenes"] = true;
			$_SESSION["act1_iteracion_prueba"] = 0;
		}	
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<?php titulo(); ?>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../../css/estilo_actividad.css">

		<script type="text/javascript" src="../../js/librerias/jquery -v1.11.2.js"></script>
		<script type="text/javascript" src="../../js/librerias/jQueryBlockUI.js"></script>
		<script type="text/javascript" src="../../js/actividades/colocar_primera_letra.js"></script>
		<script type="text/javascript" src="../../js/librerias/ajax-jqueryUI-v1.9.js"></script>
	</head>

	<body>
		<div class="cuerpo-actividad">
			<header class="cabecera">
				<section id="cabecera-izq">
					<span><b>PLACE THE FIRST LETTER</b></span>
				</section>

				<section id="cabecera-der">
					<a href="../menu_ninos_lenguaje.php"><img src="../../imagen/icon/puerta_salida.png" class="img-cerrar" title="Exit"/></a>
				</section>
			</header>
			
			<div class="tv-plasma">
			<?php
				$descripcion = "Select the missing letter in the word that's associated to the image";
				menuActividad($descripcion);
			?>
				<div class="alta-voz"></div>
				<div class="tv-boton"></div>
			</div>			
			
			<section class="img-actividad">
				<img src="#" id="img-cargar" />

				<audio controls id="tocar-audio" src=" "  hidden>
				</audio>

				<div class="alerta">
					<img src="#" class="img-mensaje" />

					<video id="video-mensaje" class="video-mensaje">
						<source src="#" type="video/mp4" class="src-video-mp4"/>
					</video>
				</div>

			</section>

			<section class="preg-actividad-1">
				
			</section>

			<section class="resp-lng-sena">
				<img src="#" id="img-resp-lng-sena" />
			</section>

			<section class="resp-actividad-1">
				
			</section>

			<input type="hidden" name="contIntento" id="intentoCont" value="0" />
			<input type="hidden" name="stopwatch2" id="stopwatch" value=" " />			
		</div>
	</body>
</html>

