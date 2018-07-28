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

		if($actividad == "COMPLETE THE NUMBER SEQUENCES"){
			//$_SESSION["act5_consultar_imagenes"] = true;
			$_SESSION["act15_iteracion_prueba"] = 0;
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
		<script type="text/javascript" src="../../js/actividades/completar_secuencia.js"></script>
		<script type="text/javascript" src="../../js/librerias/ajax-jqueryUI-v1.9.js"></script>
	</head>

	<body>
		<div class="cuerpo-actividad">

			<header class="cabecera">
				<section id="cabecera-izq">
					<span><b>COMPLETE THE NUMBER SEQUENCES</b></span>
				</section>

				<section id="cabecera-der">
					<a href="../menu_ninos_matematica.php"><img src="../../imagen/icon/puerta_salida.png" class="img-cerrar" title="Exit" /></a>
				</section>
			</header>

			<div class="tv-plasma">
			<?php
				$descripcion = "Write the missing numbers in the indicated position";
				menuActividad($descripcion);
			?>
				<div class="alta-voz"></div>
				<div class="tv-boton"></div>
			</div>

			<section class="img-actividad">
				<div class="contenedor-seleccion">
					<ul id="lista-ordenable">
						
					</ul>
				</div>

				<div class="alerta">
					<img src="#" class="img-mensaje" />
				</div>
			</section>

			<section class="resp-actividad-8">
				
			</section>

			<input type="hidden" name="contIntento" id="intentoCont" value="0" />
			<input type="hidden" name="stopwatch2" id="stopwatch" value=" " />
			
		</div>
	</body>
</html>









