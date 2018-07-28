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

    <link href="../css/estilo_gestion.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/librerias/alertify.core.css" type="text/css" />
	<link rel="stylesheet" href="../css/librerias/alertify.default.css" type="text/css" />

    <script language="javascript" type="text/javascript" src="../js/librerias/alertify.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
	<script language="javascript" type="text/javascript" src="../js/discapacidad.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>

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
		<h5>Discapacity</h5>
	</section>

	<fieldset id="catalogo-maestro">
							<legend>List of discapacities</legend>
									<section class="form-izq">
										<section class="buscar-maestro-pequeno-label">
											<label for="buscar">Search:</label>
												<input list="lista" type="text" id="buscar" name="buscar" value="" size="15px" title="Enter name of discapacity to search for" maxlength="50" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzada(this.value, 'cuerpo-tabla-maestro', '../controlador/gestionar_discapacidad.php', 'consultaAvanzada'); validarLongitud(this.value, '50')" />
										</section>

										<table class="tabla-maestro-discap" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="350px">Name of Discapacity</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
									  </table>
									</section>

									<section class="form-der">
									<fieldset id="form-maestro-pequeno">
										<legend>Manage Discapacity</legend>
											<form action="../controlador/gestionar_discapacidad.php" method="POST">
											<section class="form-cent">
												<section class="discap-label">
													<label for="nombre_maestro">Discapacity:</label>
												<input type="hidden" id="id_discapacidad" name="id_discapacidad" />
												<input type="text" id="nombre_discapacidad" name="nombre_discapacidad" class="texto" value="" size="19px" placeholder="NAME OF DISCAPACITY" pattern="[A-Za-z\s]*" maxlength="30" title="Enter name of discapacity" onKeypress="return validarLetra(event)" />
												</section>
											</section>
											
											<div id="msj-consulta"><p id="msj-p"></p></div>
											<br class="clearFloat"/>	

									<section class="boton-maestro">
											<button type="button" id="incluir" name="incluir" title="Press to save" class="boton"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="button" id="cancelar" name="cancelar" title="Press to cancel" class="boton" onClick="limpiarCamposDiscapacidad(id = ['id_discapacidad', 'nombre_discapacidad'])"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>	
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




