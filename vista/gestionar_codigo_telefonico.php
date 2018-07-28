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
    <script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
    <script language="javascript" type="text/javascript" src="../js/codigo_telefonico.js"></script>

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
		<h5>Telephone code</h5>
	</section>

	<fieldset id="catalogo-maestro">
							<legend>List of Telephone Codes</legend>
									<section class="form-izq">
										<section class="buscar-maestro-pequeno-label">
											<label for="buscar">Search:</label>
												<input list="lista" type="number" id="buscar" name="buscar" value="" max="9999" min="1" title="Enter number of telephone code to search for" maxlength="4" onKeypress="return validarNumero(event)" onChange="busquedaAvanzada(this.value, 'cuerpo-tabla-maestro', '../controlador/gestionar_codigo_telefonico.php', 'consultaAvanzada'); validarLongitud(this.value, '4')" onKeyup="busquedaAvanzada(this.value, 'cuerpo-tabla-maestro', '../controlador/gestionar_codigo_telefonico.php', 'consultaAvanzada'); validarLongitud(this.value, '4')" />
										</section>

										<table class="tabla-maestro-pequeno" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="200px">Telephone Codes</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
									  </table>
									</section>

									<section class="form-der">
									<fieldset id="form-maestro-pequeno">
										<legend>Manage Telephone Codes</legend>

											<form action="../controlador/gestionar_codigo_telefonico.php" method="POST">

											<section class="form-pequeno-cent">
												<section class="contenedor-label">
													<label for="opcion_codigo">Code:</label>
													<input type="hidden" id="id_codigo_tele" name="id_codigo_tele" />
													<input type="text" id="opcion_codigo" name="opcion_codigo" value="" max="9999" min="1" size="10px" placeholder="CODE" pattern="[0-9]*" maxlength="4" title="Enter telephone code" onKeypress="return validarNumero(event)" onKeyup="validarLongitud(this.value, '4')" />
												</section>

											</section>
											
											<div id="msj-consulta"><p id="msj-p"></p></div>
											<br class="clearFloat"/>	

									<section class="boton-maestro">
											<button type="button" id="incluir" name="incluir" title="Press to savePulse para Guardar" class="boton"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="button" id="cancelar" name="cancelar" title="Press to cancel" class="boton" onClick="limpiarCamposCodigoTelefonico(id = ['id_codigo_tele', 'opcion_codigo'])"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>		
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


