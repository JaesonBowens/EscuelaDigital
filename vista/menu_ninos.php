<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../cabecera/titulo.php");
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>

		<?php titulo(); ?>

		<link rel="stylesheet" type="text/css" href="../css/estilo_menu_nino.css" media="all" />
		<link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
		<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

		<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
		<script type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
		<script type="text/javascript" src="../js/menu_ninos.js"></script>
		<script type="text/javascript" src="../js/estudiante_en_sesion.js"></script>
		<script type="text/javascript" src="../js/librerias/ajax-jqueryUI-v1.9.js"></script>
	</head>
	<body>
		<div id="cuerpo1">
			<div id="profesora"></div>
			<div class="pizarra-actividad">
				<section class="menu-actividad">
					<section class="instruccion"><p>Choose an option</p></section>
					<a class="matematica" href="menu_ninos_matematica.php">
						<div id="ico-matematica" class="ico-matematica" title="Matemática">						
						</div>
						<video loop muted autoplay id="ico-video-matematica" class="video" hidden>
							<source src="../video/matematica/matematica.webm" type="video/ogg" class="src-video-ogg"/>
						</video>
						<p>Mathematics</p>
					</a>
					
					<a class="lenguaje" href="menu_ninos_lenguaje.php" >
						<div id="ico-lenguaje" title="Lenguaje" >
						</div>
						<video loop muted autoplay id="ico-video-lenguaje" class="video" hidden>
							<source src="../video/lenguaje/lenguaje.webm" type="video/ogg" class="src-video-ogg"/>
						</video>
						<p>Language Art</p>
					</a>
				</section>

				<section><button id="cambiar-contenido">Change Themes</button></section>
			</div>

			<a href="../controlador/cerrar_sesion_est.php">
				<div id="puerta-salir"></div>
			</a>

			<section id="section-asig-contenido">
				<table class="tabla-asig-contenido" frame="box" rules="*" cellpadding="7">
					<thead class="cabecera-tabla-asig-contenido">
						<tr>
							<th width="90px"><input type="button" id="seleccion-todo" title="Press to select all of the themes" value="All" /></th>
							<th width="750px">List of themes</th>
						</tr>
					</thead>

					<tbody class="asig-contenido" id="asig-contenido">
						
					</tbody>
				</table>

				<button id="actualizar">Update</button>
				<button id="cerrar">Close</button>
			</section>
		</div>
	<body>
</html>
