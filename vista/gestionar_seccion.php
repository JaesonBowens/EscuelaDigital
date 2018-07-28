<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../modelo/conexion_bd.php");
	$conexion_bd = new conexionBD;
	$conexion_bd -> conexion();

	include("../cabecera/campos_de_seleccion/grado.php");	
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
	<script language="javascript" type="text/javascript" src="../js/seccion.js"></script>

</head>

<body onLoad="busquedaAvanzadaSeccion('', 'cuerpo-tabla-maestro', '../controlador/gestionar_seccion.php', 'consultaAvanzada')">

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
		<h5>Section</h5>
	</section>
	
	<fieldset id="catalogo-maestro">
							<legend>List of Section</legend>
									<section class="form-izq">
										<section class="buscar-maestro-pequeno-label">
											<label for="buscar_grado" >Grade:</label>
													<select id="buscar_grado" name="buscar_grado" title="Select the grade" onChange="busquedaAvanzadaSeccion('', 'cuerpo-tabla-maestro', '../controlador/gestionar_seccion.php', 'consultaAvanzada')">
														<option value="">SELECT</option>
														<?php
																cargarGrado();	
														?>
													</select>
										</section>
										
										<section class="buscar-maestro-pequeno-label">
												<label for="buscar_seccion" >Section:</label>
													<input list="lista" type="text" id="buscar_grupo" name="buscar_grupo" value="" size="11px" title="Enter the section to search for" maxlength="1" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzadaSeccion('', 'cuerpo-tabla-maestro', '../controlador/gestionar_seccion.php', 'consultaAvanzada'); validarLongitud(this.value, '1')" />
											</section>

										<table class="tabla-maestro-pequeno-dos" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="150px">Grade</th>
														<th width="100px">Section</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
									  </table>
									</section>

									<section class="form-der">
									<fieldset id="form-maestro-pequeno">
										<legend>Manage Section</legend>
											<form id="formulario" action="../controlador/gestionar_seccion.php" method="POST">
											<div id="datos-cargados">
											<section class="form-pequeno-cent">
												<section class="contenedor-label">
												<label for="id_grado">Grade:</label>
													<select id="id_grado" name="id_grado" title="Select the grade ">
														<option value="">SELECT</option>
														<?php
															cargarGrado();
														?>
													</select>
											</section>

											<section class="contenedor-label">
												<label for="nombre_seccion">Section:</label>
													<input type="hidden" id="id_seccion" name="id_seccion" />
													<input type="text" id="grupo" name="grupo" class="texto" value="" size="14px" placeholder="Letra de la Sección" pattern="[A-Za-z\s]*" maxlength="1" title="Ingrese la Letra de la Sección" onKeypress="return validarLetra(event)" />
											</section>

											</section>

											</div>
											<div id="msj-consulta"><p id="msj-p"></p></div>
											<br class="clearFloat"/>	

									<section class="boton-maestro">
											<button type="button" id="incluir" name="incluir" title="Press to save" class="boton"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="button" id="cancelar" name="cancelar" title="Press to cancel" class="boton" onClick="limpiarCamposSeccion(id = ['id_grado', 'id_seccion', 'grupo'])"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>
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

