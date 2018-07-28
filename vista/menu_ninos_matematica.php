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
		<link rel="stylesheet" type="text/css" href="../css/estilo_actividad.css" />
		
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
	</head>

	<body>
		<div id="cuerpo1">	
			<div class="pizarra-actividad-matematica">
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
							if( $_SESSION["IDENTIFY THE NUMBER"] == "YES" ){
								echo '<li><a href="actividades/identificar_numero.php?Actividad=IDENTIFICA EL NÚMERO"><img src="../imagen/menu_nino/actividades/identificar_el_numero_ico.png" alt="image01" title="Identify the number" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/identificar_el_numero.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["SPELL THE NUMBER"] == "YES" ){
								echo '<li><a href="actividades/escribir_numero.php?Actividad=ESCRIBIR EL NÚMERO EN PALABRA"><img src="../imagen/menu_nino/actividades/escribir_numero_en_palabra_ico.png" title="Spell the number" alt="image02" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/escribir_numero_en_palabra.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["COUNT THE OBJECTS"] == "YES" ){
								echo '<li><a href="actividades/contar_objetos.php?Actividad=COUNT THE OBJECTS"><img src="../imagen/menu_nino/actividades/contar_los_objetos_ico.png" title="Count the objects" alt="image03" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/contar_los_objetos.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["WHAT TIME IS IT?"] == "YES" ){
								echo '<li><a href="actividades/escribir_hora.php?Actividad=ESCRIBE LA HORA"><img src="../imagen/menu_nino/actividades/escribir_la_hora_ico.png" title="Write the time seen in the images" alt="image04" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/escribir_la_hora.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["SUM THE OBJECTS"] == "YES" ){
								echo '<li><a href="actividades/sumar_objetos.php?Actividad=SUM THE OBJECTS"><img src="../imagen/menu_nino/actividades/sumar_los_objetos_ico.png" title="Sum the objects" alt="image05" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/sumar_los_objetos.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							if( $_SESSION["SUBTRACT THE OBJECTS"] == "YES" ){
								echo '<li><a href="actividades/restar_objetos.php?Actividad=SUBTRACT THE OBJECTS"><img src="../imagen/menu_nino/actividades/restar_los_objetos_ico.png" title="Subtract the objects" alt="image06" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/restar_los_objetos.png\')" onMouseOut="ocultar()" /></a></li>';
							}
							/*if( $_SESSION["COMPLETA LA SECUENCIA DE NÚMERO"] == "SI" ){*/
								echo '<li><a href="actividades/completar_secuencia.php?Actividad=COMPLETE THE NUMBER SEQUENCES"><img src="../imagen/menu_nino/actividades/completar_secuencia_de_numero_ico.png" title="Complete the sequence of numbers" alt="image07" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/completar_secuencia_de_numero.png\')" onMouseOut="ocultar()" /></a></li>';
							/*}*/
							if( $_SESSION["FIND THE IMAGES WITH THE MOST OBJECTS"] == "YES" ){
								echo '<li><a href="actividades/encontrar_mas_objetos.php?Actividad=FIND THE IMAGES WITH THE MOST OBJECTS"><img src="../imagen/menu_nino/actividades/encontrar_imagen_mas_objetos_ico.png" title="Find the image with the most objects" alt="image08" onMouseOver="mostrar(\'../imagen/menu_nino/actividades/encontrar_imagen_mas_objetos.png\')" onMouseOut="ocultar()" /></a></li>';
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
			$mensaje -> mensaje = "$.blockUI({ message: '<h1><img src=\"../imagen/icon/exito_.png\" class=\"img-mensaje\" /></h1>' });";
		}
		else{
			$mensaje -> mensaje = "$.blockUI({ message: '<h1><img src=\"../imagen/icon/alto.gif\" class=\"img-mensaje\" /></h1>' });";
		}
		
		$mensaje -> mostrarMensaje1();
		unset($_SESSION["mensaje"]);
	}	
?>

