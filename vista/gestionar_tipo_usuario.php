<?php
	session_start();

	if ( !isset($_SESSION['autenticado']) && isset($_SESSION['autenticado']) != 'YES' ){
		//echo "<meta http-equiv='refresh' content='0 url=../index.php'/>";	
		$_SESSION["mensaje"] = "Please start session!";
		header("Location: ../index.php");
		die();
	}

	include("../cabecera/funcion_usuario.php");
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
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery -v1.11.2.js"></script>
	<script language="javascript" type="text/javascript" src="../js/librerias/jquery.touch.js"></script>
    <script language="javascript" type="text/javascript" src="../js/formulario.js"></script>
    <script language="javascript" type="text/javascript" src="../js/validacion.js"></script>
    <script language="javascript" type="text/javascript" src="../js/asignacion_funcion_usuario.js"></script>
   

</head>

<body onLoad="busquedaAvanzada('', 'cuerpo-tabla-maestro', '../controlador/gestionar_tipo_usuario.php', 'consultar'); redireccionar('#uno')">

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
		<h5>Tipo de Usuario</h5>
	</section>
	
	<form action="../controlador/gestionar_tipo_usuario.php" method="POST">

	<fieldset id="catalogo-maestro">
							<legend>List of Types of Users</legend>
									<section class="form-cent">
										<section class="buscar-maestro-label">
											<label for="buscar">Search:</label>
												<input list="lista" type="text" id="buscar" name="buscar" value="" size="15px" title="Enter the type of user to search for" maxlength="25" onKeypress="return validarLetra(event)" onKeyup="busquedaAvanzada(this.value, 'cuerpo-tabla-maestro', '../controlador/gestionar_tipo_usuario.php', 'consultar'); validarLongitud(this.value, '25')" />
										</section>

										<table class="tercera-tabla-maestro-pequeno" align="center" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-tabla-maestro">
													<tr>
														<th width="400px">Type of User</th>
													</tr>
												</thead>

												<tbody class="cuerpo-tabla-maestro" id="cuerpo-tabla-maestro">
													
												</tbody>
									  </table>
								</section>
		</fieldset>

		<fieldset id="form-maestro">
										<legend>Manage Type of User</legend>

											<section class="form-izq">
											
										<!--<section class="funcion-usuario" >-->
											<table class="tabla-funcion-usuario" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-funcion-usuario">
													<tr>
														<th width="395px">User's Functions</th>
													</tr>
												</thead>

												<tbody class="cuerpo-funcion-usuario" id="cuerpo-funcion-usuario">
													<?php
														cargarFuncionUsuario();
													?>
												</tbody>
											</table>
											<!--</section>-->
											</section>

											<section class="asig-funcion-der">

											<section class="tipo-usuario-label">
											<label for="descripcion_tipo_usuario">Type of User:</label>
												<input type="hidden" id="id_tipo_usuario" name="id_tipo_usuario" />
												<input type="text" id="descripcion_tipo_usuario" name="descripcion_tipo_usuario" value="" size="20px" placeholder="TYPE OF USER" required pattern="[A-Za-z\s]*" maxlength="25" title="Enter the type of user" onKeypress="return validarLetra(event)" />
											</section>

												<table class="tabla-asignacion-funcion" frame="box" rules="*" cellpadding="7">
												<thead class="cabecera-asignacion-funcion">
													<tr>
														<th width="400px">Assigned Functions</th>
													</tr>
												</thead>

												<tbody class="cuerpo-asignacion-funcion" id="cuerpo-asignacion-funcion">
														
												</tbody>
											</table>
											<input type="hidden" id="cont" name="cont" value="0" />
											</section>

											<br class="clearFloat"/>	

									<section class="boton-maestro">
											<button type="button" id="incluir" name="incluir" title="Press to save" class="boton"><img class='ico' src='../imagen/icono_boton/ib-7.png' alt='Icon'>  Save</button>
											<button type="button" id="modificar" name="modificar" title="Press to modify" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-9.png' alt='Icon'>  Modify</button>
											<button type="button" id="eliminar" name="eliminar" title="Press to delete" class="boton" hidden="hidden"><img class='ico' src='../imagen/icono_boton/ib-8.png' alt='Icon'>  Delete</button>
											<button type="reset" id="cancelar" name="cancelar" title="Press to cancel" class="boton" onClick="activarIncluir(); limpiarTabla()"><img class='ico' src='../imagen/icono_boton/ib-2.png' alt='Icon'>  Cancel</button>
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
