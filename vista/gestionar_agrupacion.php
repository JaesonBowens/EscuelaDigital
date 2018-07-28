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
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

	<script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
	<script language="javascript" type="text/javascript" src="../js/agrupacion.js"></script>

</head>

<body onLoad="busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_agrupacion.php', 'consultaAvanzada')">

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
		<h5>Groupings</h5>
	</section>

	<fieldset id="catalogo-maestro">
							<legend>List of groupings</legend>
									<section class="form-izq">
										<section class="buscar-maestro-pequeno-label">
											<label for="buscar">Search:</label>
												<input list="lista" type="text" id="buscar" name="buscar" value="" size="13px" title="Enter name of grouping" maxlength="25" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzada(this.value, 'cuerpo-tabla-maestro', '../controlador/gestionar_agrupacion.php', 'consultaAvanzada'); validarLongitud(this.value, '25')" />
										</section>

										<table class="tabla-maestro-pequeno-dos" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="250px">Grouping</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
									  </table>
									</section>

									<section class="form-der">
									<fieldset id="form-maestro-pequeno">
										<legend>Manage Grouping</legend>

											<form action="../controlador/gestionar_agrupacion.php" method="POST">

											<section class="form-pequeno-cent">
												
												<section class="contenedor-label">
													<label for="nombre">Grouping:</label>
													<input type="hidden" id="id_agrupacion" name="id_agrupacion" />
													<input type="text" id="nombre_agrupacion" name="nombre_agrupacion" class="texto" value="" size="15px" placeholder="NAME OF GROUPING" pattern="[A-Za-z\s]*" maxlength="25" title="Enter name of grouping" onKeypress="return validarLetra(event)" />
												</section>

											</section>
											<div id="msj-consulta"><p id="msj-p"></p></div>
											<br class="clearFloat"/>	

									<section class="boton-maestro">
											<button type="button" id="incluir" name="incluir" title="Press to save" class="boton"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="button" id="cancelar" name="cancelar" title="Press to cancel" class="boton" onClick="limpiarCamposAgrupacion(id = ['id_tema', 'nombre_tema'])"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>
									</section>

									</form>

		 						</fieldset>

								</section>
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

