<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../cabecera/menu.php");
	include("../cabecera/titulo.php");
	include("../cabecera/librerias/cierre_por_inactividad.php");
?>

<!DOCTYPE html>
<html >
 
<head>
    <meta charset="UTF-8"/>

    <?php titulo(); ?>

    <link rel="stylesheet" type="text/css" href="../css/estilo_gestion.css" media="all" />
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
    <link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

    <script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery-1.4.4.min.js"></script>
	
    <script>
	$(document).ready(function(){
		//$('#contenido_principal').css({ 'height':$(window).height() - $(window).height() / 5.9 });
		$('#contenido_principal').css({ 'height': 100% });
		$('#logo_pagina_principal').css({ 'height':$(window).height() - $(window).height() / 3.8 });
		$('.logo_pagina').css({ 'height':$(window).height() - $(window).height() / 3 });
		$('#pie').css({ 'margin-top': 0});

		
	});
    </script>

</head>

<body>

<div id="cabecera">
		<div class="nombre_sistema">
			<?php include("../cabecera/cabecera.php"); ?>
		</div>
		<div id="nav">
			<?php menu(); ?>
		</div>
</div>

<div id="contenido_principal">

	<div id="logo_pagina_principal">
		<img class="logo_pagina" src='../imagen/logo.png' />
	</div>

</div>

<div id="pie">
		<?php include("../cabecera/pie.php"); ?>
</div>
</body>
</html>

<?php
	cierrePorInactividad("../controlador/salir.php");

	if(isset($_SESSION["mensaje"])){
		//Incluimos e instanciamos la clase mensajes para poder mostrar los mensajes que enviemos
		//del controlador mediante la variable de $_SESSION["mensaje"];
		include("../cabecera/librerias/mensaje.php");
		$mensaje = new CabeceraMensaje;
		$mensaje -> mensaje = $_SESSION["mensaje"];
		$mensaje -> mostrarMensaje();
		unset($_SESSION["mensaje"]);
	}
?>
