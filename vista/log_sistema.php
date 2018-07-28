<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		//echo "<meta http-equiv='refresh' content='0 url=../index.php'/>";	
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

    <link href="../css/estilo_gestion.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="../css/librerias/estilo_calendario.css" media="all" />
	<link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />
	
	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>	
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
		<script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
		<script language="javascript" type="text/javascript" src="../js/log_sistema.js"></script>
		<script language="javascript" type="text/javascript" src="../js/librerias/calendario.js"></script>

		<script type="text/javascript">
				$(document).ready(function(){
					$(".calendario").calendarioDW();

					$( '.botoncal' ).css({
   									opacity: 1,
    								pointerEvents: 'auto'
					})

					//Cada vez que el usuario envie la respuesta
					$("#limpiar_campo_fecha").click(function(){

							$("#buscar_fecha_log").val("");
							busquedaAvanzadaLogSistema('', 'cuerpo-tabla-maestro', '../controlador/bitacora.php', 'consultarEntradaSalida')

					});
				});
    </script>

	
</head>

<body onLoad="busquedaAvanzadaLogSistema('', 'cuerpo-tabla-maestro', '../controlador/bitacora.php', 'consultarEntradaSalida')" >

<div id="cabecera">
		<div class="nombre_sistema">
			<?php include("../cabecera/cabecera.php"); ?>
		</div>
		<div id="nav">
			<?php menu(); ?>
		</div>
</div>

<div id="contenido_principal">
	<section class="nombre_maestro">
		<h5>System Log</h5>
	</section>

	
	<form action="../controlador/bitacora.php" method="POST">

	<fieldset id="catalogo-maestro">
							<legend>Record of log-in and log-out of the system</legend>
										<section class="buscar-maestro-label">
											<label for="buscar">Date:</label>
												<input type="text" id="buscar_fecha_log" name="buscar_fecha_log" class="calendario" value="" size="10px" title="Enter the date to search for when the operation was realized" maxlength="25" onKeyup="busquedaAvanzadaLogSistema( '', 'cuerpo-tabla-maestro', '../controlador/bitacora.php', 'consultarEntradaSalida'); validarLongitud(this.value, '11')" /> <a id="limpiar_campo_fecha" class='limpiar_ico' href='#' title="Pulse para limpiar campo de fecha"><span></span></a>
										</section>

										<table class="tabla-maestro" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="200px">User's name</th>
														<th width="200px">Date</th>
														<th width="200px">Time of Log-in</th>
														<th width="210px">Time of Log-out</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
									  </table>
		</fieldset>

		</form>
		
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
