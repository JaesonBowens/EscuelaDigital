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

		if($actividad == "SPELL THE NUMBER"){
			$_SESSION["act4_consultar_imagenes"] = true;
			$_SESSION["act4_iteracion_prueba"] = 0;
		}	
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php titulo(); ?>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../../css/estilo_actividad.css">

		<!--<link rel="stylesheet" type="text/css" href="../css/media_queries_actividad.css">-->

		<script type="text/javascript" src="../../js/librerias/jquery -v1.11.2.js"></script>
		<script type="text/javascript" src="../../js/librerias/jQueryBlockUI.js"></script>
		<script type="text/javascript" src="../../js/actividades/escribir_numero.js"></script>
		<script type="text/javascript" src="../../js/librerias/ajax-jqueryUI-v1.9.js"></script>
	</head>

	<body>
		<div class="cuerpo-actividad">
			<header class="cabecera">
				<section id="cabecera-izq">
					<span><b>SPELL THE NUMBER</b></span>
				</section>

				<section id="cabecera-der">
					<a href="../menu_ninos_matematica.php"><img src="../../imagen/icon/puerta_salida.png" class="img-cerrar" title="Exit" /></a>
				</section>
			</header>

			<div class="tv-plasma">
			<?php
				$descripcion = "Spell the number that is shown in the image";
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
				</div>
			</section>

			<section class="preg-actividad-4">
				
			</section>

			<input type="hidden" name="contIntento" id="intentoCont" value="0" />

			<section class="resp-actividad-4">
				<input type="text" name="campoRespuesta" id="campoRespuesta" size="10" onKeyPress="return validarLetra(event)"/>
				<input id="enviarRespuesta" type="image" src="../../imagen/icon/ok.png" />
			</section>
		</div>
	</body>
</html>

