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

		if($actividad == "WHAT TIME IS IT?"){
			$_SESSION["act7_consultar_imagenes"] = true;
			$_SESSION["act7_iteracion_prueba"] = 0;
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
		<script type="text/javascript" src="../../js/actividades/escribir_hora.js"></script>
		<script type="text/javascript" src="../../js/librerias/ajax-jqueryUI-v1.9.js"></script>
	</head>

	<body>
		<div class="cuerpo-actividad">
			<header class="cabecera">
				<section id="cabecera-izq">
					<span><b>WHAT TIME IS IT?</b></span>
				</section>

				<section id="cabecera-der">
					<a href="../menu_ninos_matematica.php"><img src="../../imagen/icon/puerta_salida.png" class="img-cerrar" title="Exit" /></a>
				</section>
			</header>

			<div class="tv-plasma">
			<?php
				$descripcion = "Write the correct time that is shown in the image";
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
			

			<input type="hidden" name="contIntento" id="intentoCont" value="0" />

			<section class="resp-actividad-7">
				<input type="number" name="hora" id="hora" max="12" min="1" size="2" maxlength="2" onKeyPress="return validarNumero(event)"/>
				<span id="dos-puntos">:</span>
				<input type="number" name="minuto" id="minuto" max="59" min="0" size="2" maxlength="2" onKeyPress="return validarNumero(event)"/>
				<input id="enviarRespuesta7" type="image" src="../../imagen/icon/ok.png" />
			</section>
		</div>
	</body>
</html>
