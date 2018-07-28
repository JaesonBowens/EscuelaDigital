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

		if($actividad == "SUBTRACT THE OBJECTS"){
			$_SESSION["act12_consultar_imagenes"] = true;
			$_SESSION["act12_iteracion_prueba"] = 0;
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
		<script type="text/javascript" type="text/javascript" src="../../js/librerias/jQueryBlockUI.js"></script>
		<script type="text/javascript" src="../../js/actividades/restar_objetos.js"></script>
		<script type="text/javascript" src="../../js/librerias/ajax-jqueryUI-v1.9.js"></script>
	</head>

	<body>
		<div class="cuerpo-actividad">
			<header class="cabecera">
				<section id="cabecera-izq">
					<span><b>SUBTRACT THE OBJECTS</b></span>
				</section>

				<section id="cabecera-der">
					<a href="../menu_ninos_matematica.php"><img src="../../imagen/icon/puerta_salida.png" class="img-cerrar" title="Exit"/></a>
				</section>
			</header>
			<div class="tv-plasma">
			<?php
				$descripcion = "Subtract the objects shown on the board";
				menuActividad($descripcion);
			?>
				<div class="alta-voz"></div>
				<div class="tv-boton"></div>
			</div>
			
			<section class="img-actividad">
				<img src="#" id="img-cargar1" />
				<span class="signo-resta">-</span>
				<img src="#" id="img-cargar2" />

				<div class="alerta">
					<img src="#" class="img-mensaje" />
				</div>
			</section>

			<input type="hidden" name="contIntento" id="intentoCont" value="0" />
			<input type="hidden" name="stopwatch2" id="stopwatch" value=" " />

			<section class="resp-actividad-10">
				<span id="signo-igual">=</span>
				<input type="text" name="campoRespuesta" id="campoRespuesta-resultado" class="pequeno" size="" onKeyPress="return validarNumero(event)"/>
				<input id="enviarRespuesta" type="image" src="../../imagen/icon/ok.png" />
			</section>			
		</div>
	</body>
</html>
