<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		//echo "<meta http-equiv='refresh' content='0 url=../index.php'/>";	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../cabecera/campos_de_seleccion/tabla_bd.php");
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
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
  <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
  <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery-1.4.4.min.js" media = "all"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/ajax-jqueryUI-v1.9.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jQueryBlockUI-gestion.js"></script>
	<script language="javascript" type="text/javascript" src="../js/bd.js"></script>

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
	<section class="nombre_maestro">
		<h5>Restore and Back-up data base</h5>
	</section>

		<fieldset id="segundo-form-maestro">
							<legend>Back-up all tables of the data base</legend>
									<form name="respaldarBaseDato" action="../controlador/generar_respaldo.php" method="POST">
									<section class="form-cent">
											<section class="bd-label">
											<label for="nombre_maestro">Name of the back-up:</label>
												<input type="text" id="nombre_respaldo" name="nombre_respaldo" value="" size="15px" placeholder="Name of back-up" pattern="[A-Za-z\s]*" maxlength="" title="Enter name of back-up" onKeypress="return validarLetra(event)" /> 
											</section>
									</section>

									<br class="clearFloat"/>

									<section class="boton-maestro">
											<button type="button" id="respaldarBD" name="respaldarBD" title="Press to back-up data base" class="boton"><img class='ico' src='../imagen/icono_boton/ib-15.png' alt='Icon'> Back-up</button>
											<button type="button" id="cancelarRespaldarBD" name="cancelarRespaldarBD" title="Press to cancel" class="boton" ><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'> Cancel</button>
									 </section>
									 </form>
		</fieldset>

		<fieldset id="segundo-form-maestro">
							<legend>Back-up a table of the data base</legend>
									<form name="respaldarTablaBaseDato" action="../controlador/generar_respaldo_tabla_bd.php" method="POST">
									<section class="form-cent">
											<section class="bd-label">
											<label for="nombreTabla">Table of Data Base:</label>	
											<select id="nombre_tabla" name="nombre_tabla" title="Select table">
												<option value="">SELECT</option>
												<?php	
													cargarTablaBD();
												?>
											</select>
											</section>
									</section>

									<br class="clearFloat"/>

									<section class="boton-maestro">
											<button type="button" id="respaldar_tabla" name="respaldar" title="Press to back-up a table of the data base" class="boton" ><img class='ico' src='../imagen/icono_boton/ib-15.png' alt='Icon'> Back-up</button>
											<button type="button" id="cancelarRespaldarTablaBD" name="cancelarRespaldarTablaBD" title="Press to cancel" class="boton" ><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'> Cancel</button>
									</section>

									</form>
		</fieldset>

		<fieldset id="segundo-form-maestro">
							<legend>Restore Data Base</legend>
									<form name="restaurarBD" action="../controlador/restaurar_bd.php" method="POST" enctype='multipart/form-data'>

										<div class="alerta">
													<h5>¡Please wait, it's loading</h5>
													<img src="#" class="img-mensaje" />
										</div>
										<section class="form-cent">
												<section class="bd-label">
										    <label for="ficheroDeCopia">Data Base:</label>											
										    <input type="file" id="ficheroDeCopia" name="ficheroDeCopia" required size="15px" title="Select the data base to restore" onchange="return ValidarBaseDatoSubir()"/> 
												</section>
									  </section>

									<br class="clearFloat"/>

									<section class="boton-maestro">
											<button type="button" id="restaurar" name="restaurar" title="Press to restore data base" class="boton" ><img class='ico' src='../imagen/icono_boton/ib-16.png' alt='Icon'> Restore</button>
											<button type="button" id="cancelarRestaurarBD" name="cancelarRestaurarBD" title="Press to cancel" class="boton"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'> Cancel</button>
									</section>

									</form>
		</fieldset>
		
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


