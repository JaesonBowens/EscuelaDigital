<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		//echo "<meta http-equiv='refresh' content='0 url=../index.php'/>";	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../../cabecera/titulo.php");
	include("../../cabecera/menu_actividad.php");

	if(isset($_GET["Actividad"])){
		$actividad = $_GET["Actividad"];

		if($actividad == "ASSOCIATE THE WORDS WITH THE IMAGES"){
			$_SESSION["act17_consultar_imagenes"] = true;
			$_SESSION["act17_iteracion_prueba"] = 0;
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
		<script type="text/javascript" src="../../js/actividades/asociar_imagen_palabra.js"></script>

	</head>

	<body>
		<div class="cuerpo-actividad">
			<header class="cabecera">
				<section id="cabecera-izq">
					<span><b>ASSOCIATE THE WORDS WITH THE IMAGES</b></span>
				</section>

				<section id="cabecera-der">
					<a href="../menu_ninos_lenguaje.php"><img src="../../imagen/icon/puerta_salida.png" class="img-cerrar" title="Exit	"/></a>
				</section>
			</header>

			<div class="tv-plasma">
			<?php
				$descripcion = "Move the word to the image that it corresponds";
				menuActividad($descripcion);
			?>
				<div class="alta-voz"></div>
				<div class="tv-boton"></div>
			</div>			
			
			<section class="img-actividad">
				<div class="contenedor-seleccion-uno">
					<div class="imagen-asociar" id="soltar1"><img class="imagen" src="#" id="soltar1" alt="" /><p></p></div>
					<div class="imagen-asociar" id="soltar2"><img class="imagen" src="#" id="soltar2" alt="" /><p></p></div>
					<div class="imagen-asociar" id="soltar3"><img class="imagen" src="#" id="soltar3" alt="" /><p></p></div>
					<div class="imagen-asociar" id="soltar4"><img class="imagen" src="#" id="soltar4" alt="" /><p></p></div>
				</div>

				<div class="alerta">
					<img src="#" class="img-mensaje" />
				</div>
			</section>

			<section class="resp-actividad-asociar-img-pal">
				<section class="resp-img-pal-interno">
					<div id="superior">
						<p class="der" id="arrastrable1"></p>
						<p class="izq" id="arrastrable2"></p>
					</div>
				
					<div id="inferior">
						<p class="der" id="arrastrable3"></p>
						<p class="izq" id="arrastrable4"></p>
					</div>
				</section>
			</section>

			<input type="hidden" name="contIntento" id="intentoCont" value="0" />
			<input type="hidden" name="stopwatch2" id="stopwatch" value=" " />			
		</div>
	</body>
</html>

