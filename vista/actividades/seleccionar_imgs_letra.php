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

		if($actividad == "SELECT THE OBJECTS WHOSE FIRST LETTER IS EQUAL TO THE INDICATED"){
			$_SESSION["act13_consultar_imagenes"] = true;
			$_SESSION["act13_iteracion_prueba"] = 0;
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
		<script type="text/javascript" type="text/javascript" src="../../js/librerias/jQueryBlockUI.js"></script>
		<script type="text/javascript" src="../../js/librerias/ajax-jqueryUI-v1.9.js"></script>
		<script type="text/javascript" src="../../js/actividades/seleccionar_imgs_letra.js"></script>
		
	</head>

	<body>
		<div class="cuerpo-actividad">
			<header class="cabecera">
				<section id="cabecera-izq">
					<span id="titulo-13"><b>Select the objects whose first letter is equal to the indicated letter</b></span>
				</section>

				<section id="cabecera-der">
					<a href="../menu_ninos_lenguaje.php"><img src="../../imagen/icon/puerta_salida.png" class="img-cerrar" title="Salir"/></a>
				</section>
			</header>

			<div class="tv-plasma">
			<?php
				$descripcion = "Select the objects whose first letter starts with the indicated letter";
				menuActividad($descripcion);
			?>
				<div class="alta-voz"></div>
				<div class="tv-boton"></div>
			</div>
			
			<section class="img-actividad">
				<div class="contenedor-seleccion">
					<div id="img-1" class="seleccion">
						<img src="#" id="img-cargar13-1" class="img-cargar13" />
						<p id="palabra1" class="palabra"></p>
					</div>

					<div id="img-2" class="seleccion">
						<img src="#" id="img-cargar13-2" class="img-cargar13"/>
						<p id="palabra2" class="palabra"></p>
					</div>

					<div id="img-3" class="seleccion">
						<img src="#" id="img-cargar13-3" class="img-cargar13"/>
						<p id="palabra3" class="palabra"></p>
					</div>

					<div id="img-4" class="seleccion">
						<img src="#" id="img-cargar13-4" class="img-cargar13"/>
						<p id="palabra4" class="palabra"></p>
					</div>

					<div id="img-5" class="seleccion">
						<img src="#" id="img-cargar13-5" class="img-cargar13"/>
						<p id="palabra5" class="palabra"></p>
					</div>

					<div id="img-6" class="seleccion">
						<img src="#" id="img-cargar13-6" class="img-cargar13"/>
						<p id="palabra6" class="palabra"></p>
					</div>
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

