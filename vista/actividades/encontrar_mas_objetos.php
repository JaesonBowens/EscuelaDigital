<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){	
		$_SESSION["mensaje"] = "¡Inicia sesión, por favor!";
		header("Location: ../../index.php");
		die();
	}

	include("../../cabecera/titulo.php");
	include("../../cabecera/menu_actividad.php");

	if(isset($_GET["Actividad"])){
		$actividad = $_GET["Actividad"];

		if($actividad == "FIND THE IMAGES WITH THE MOST OBJECTS"){
			$_SESSION["act16_consultar_imagenes"] = true;
			$_SESSION["act16_iteracion_prueba"] = 0;
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
		<script type="text/javascript" src="../../js/librerias/ajax-jqueryUI-v1.9.js"></script>
		<script type="text/javascript" src="../../js/librerias/jQueryBlockUI.js"></script>
		<script type="text/javascript" src="../../js/actividades/encontrar_mas_objetos.js"></script>

	</head>

	<body>
		<div class="cuerpo-actividad">
			<header class="cabecera">
				<section id="cabecera-izq">
					<span><b>FIND THE IMAGES WITH THE MOST OBJECTS</b></span>
				</section>

				<section id="cabecera-der">
					<a href="../menu_ninos_matematica.php"><img src="../../imagen/icon/puerta_salida.png" class="img-cerrar" title="Exit"/></a>
				</section>
			</header>

			<div class="tv-plasma">
			<?php
				$descripcion = "Select the image that contains the most objects";
				menuActividad($descripcion);
			?>
				<div class="alta-voz"></div>
				<div class="tv-boton"></div>
			</div>			
			
			<section class="img-actividad">
				<div class="contenedor-seleccion-uno">
					<div class="seleccion-uno"><img src="#"/></div>
					<div class="seleccion-uno"><img src="#"/></div>
					<div class="seleccion-uno"><img src="#"/></div>
					<div class="seleccion-uno"><img src="#"/></div>
				</div>

				<div class="alerta">
					<img src="#" class="img-mensaje" />
				</div>
			</section>

			<input type="hidden" name="contIntento" id="intentoCont" value="0" />
			<input type="hidden" name="stopwatch2" id="stopwatch" value=" " />			
		</div>
	</body>
</html>

