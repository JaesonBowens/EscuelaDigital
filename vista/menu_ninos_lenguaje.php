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
		<link rel="stylesheet" type="text/css" href="../css/librerias/style-slide-menu-nino.css" />
		<link rel="stylesheet" type="text/css" href="../css/estilo_actividad.css">
		
		<script type="text/javascript" src="../js/librerias/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" type="text/javascript" src="../js/librerias/jQueryBlockUI.js"></script>
		<script type="text/javascript" src="../js/librerias/jquery-menu-nino.easing.1.3.js"></script>
		<script type="text/javascript" src="../js/librerias/jquery-menu-nino.mousewheel.js"></script>
		<script type="text/javascript" src="../js/librerias/jquery-menu-nino.gridnav.js"></script>

		<script type="text/javascript">
			$(function() {
				$('#contenedor-menu').gridnav({
					rows	: 1,
					type	: {
						mode		: 'sequpdown', 		// use def | fade | seqfade | updown | sequpdown | showhide | disperse | rows
						speed		: 500,				// for fade, seqfade, updown, sequpdown, showhide, disperse, rows
						easing		: '',				// for fade, seqfade, updown, sequpdown, showhide, disperse, rows	
						factor		: 50,				// for seqfade, sequpdown, rows
						reverse		: false				// for sequpdown
					}
				});
			});

			function mostrar(link){
				var img = document.getElementById("img-pizarra");
				img.src = link;
			}

			function ocultar(){
				var img = document.getElementById("img-pizarra");
				img.src = "../imagen/menu_nino/elige-una-actividad.png";
			}
		</script>

		<!--<link rel="stylesheet" type="text/css" href="../css/media_queries_menuninos.css" media="all" />-->
	</head>

	<body>
		<div id="cuerpo1">		
			<div class="pizarra-actividad-lengua">
				<img src="../imagen/menu_nino/elige-una-actividad.png" id="img-pizarra"/>
			</div>

			<div id="contenedor-menu" class="contenedor-menu">
				<div class="navegacion">
					<span id="anterior" class="anterior">Previous</span>
					<span id="siguiente" class="siguiente">Next</span>
				</div>

				<div class="contenedor-listado">
					<ul class="tj_gallery">
						<?php
							if( $_SESSION["PLACE THE FIRST LETTER"] == "YES" ){
								echo '<li><a href="actividades/colocar_primera_letra.php?Actividad=PLACE THE FIRST LETTER"><img src="../imagen/menu_nino/actividades/colocar_la_primera_letra_ico.png" title="Place the first letter" alt="image01" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/colocar_la_primera_letra.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["PLACE THE VOWELS"] == "YES" ){
								echo '<li><a href="actividades/colocar_vocales.php?Actividad=PLACE THE VOWELS"><img src="../imagen/menu_nino/actividades/colocar_las_vocales_ico.png" title="Place the vowels" alt="image02" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/colocar_las_vocales.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							/*if( $_SESSION["ENCUENTRA LAS LETRAS"] == "YES" ){*/
								echo '<li><a href="actividades/encontrar_letras.php?Actividad=FIND THE LETTERS"><img src="../imagen/menu_nino/actividades/buscar_las_letras_ico.png" title="Find the letters" alt="image03" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/buscar_las_letras.png\')" onMouseOut="ocultar()" /></a></li>';
							/*}*/
							
							if( $_SESSION["WRITE THE FIRST LETTER OF THE OBJECT"] == "YES" ){
								echo '<li><a href="actividades/escribir_primera_letra.php?Actividad=WRITE THE FIRST LETTER OF THE OBJECT"><img src="../imagen/menu_nino/actividades/escribir_la_primera_letra_ico.png" title="Write the first letter of the object" alt="image04" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/escribir_la_primera_letra.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["ARRANGE THE WORD"] == "YES" ){
								echo '<li><a href="actividades/ordenar_palabra.php?Actividad=ARRANGE THE WORD"><img src="../imagen/menu_nino/actividades/ordenar_la_palabra_ico.png" title="Arrange the word" alt="image05" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/ordenar_la_palabra.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["SELECT THE IMAGE THAT´S ASSOCIATED TO THE WORD"] == "YES" ){
								echo '<li><a href="actividades/seleccionar_img_palabra.php?Actividad=SELECT THE IMAGE THAT´S ASSOCIATED TO THE WORD"><img src="../imagen/menu_nino/actividades/seleccionar_img_palabra_ico.png" title="Select the image associated to the word" alt="image06" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/seleccionar_img_palabra.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["SELECT THE OBJECTS WHOSE FIRST LETTER IS EQUAL TO THE INDICATED"] == "YES" ){
								echo '<li><a href="actividades/seleccionar_imgs_letra.php?Actividad=SELECT THE OBJECTS WHOSE FIRST LETTER IS EQUAL TO THE INDICATED"><img src="../imagen/menu_nino/actividades/seleccionar_imgs_letra_ico.png" title="Select the images which first letter is equal to the indicated
								" alt="image07" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/seleccionar_imgs_letra.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["ASSOCIATE THE WORDS WITH THE IMAGES"] == "YES" ){
								echo '<li><a href="actividades/asociar_imagen_palabra.php?Actividad=ASSOCIATE THE WORDS WITH THE IMAGES"><img src="../imagen/menu_nino/actividades/asocia_palabras_imgs_ico.png" title="Associate the word to the corresponded image" alt="image07" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/asocia_palabras_imgs.png\')" onMouseOut="ocultar()" /></a></li>';
							}
						?>
					</ul>
				</div>
			</div>

			<a href="menu_ninos.php"><div id="puerta-atras"></div></a>
		</div>
	</body>
</html>
<?php

	if(isset($_SESSION["mensaje"])){
			//Incluimos e instanciamos la clase mensajes para poder mostrar los mensajes que enviemos
			//del controlador mediante la variable de $_SESSION["mensaje"];
			include("../cabecera/librerias/mensaje.php");
			$mensaje = new CabeceraMensaje;
			
			if( $_SESSION["mensaje"] == "Excellent" ){
				$mensaje -> mensaje = "$.blockUI({ message: '<img src=\"../imagen/icon/exito_.png\" class=\"img-mensaje\" />' });";
			}
			else{
				$mensaje -> mensaje = "$.blockUI({ message: '<img src=\"../imagen/icon/alto.gif\" class=\"img-mensaje\" />' });";
			}
			$mensaje -> mostrarMensaje1();
			unset($_SESSION["mensaje"]);
	}
?>
